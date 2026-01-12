<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CourseController extends Controller
{
    /**
     * Katalog Utama - Menampilkan daftar kursus yang tersedia untuk siswa.
     * Dilengkapi fitur pencarian dan filter kategori.
     */
    public function dashboard(Request $request)
    {
        // Menyiapkan query dengan eager loading kategori untuk optimasi database
        $query = Course::with(['category'])->where('is_published', true);

        // Fitur Pencarian berdasarkan judul
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Fitur Filter berdasarkan kategori (menggunakan slug kategori)
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Gunakan pagination untuk performa dan UX yang lebih baik
        $courses = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::all();

        return view('user.dashboard', compact('courses', 'categories'));
    }

    /**
     * Simpan Kursus Baru - Logika khusus Admin untuk menerbitkan materi baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'thumbnail'   => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $course = new Course($validated);
        $course->slug = Str::slug($request->title) . '-' . Str::lower(Str::random(5));
        $course->author_id = Auth::id();
        $course->is_published = true;

        // Proses upload thumbnail ke Cloudinary (Cloud Storage)
        if ($request->hasFile('thumbnail')) {
            $cloudinary = new \Cloudinary\Cloudinary(env('CLOUDINARY_URL'));
            $upload = $cloudinary->uploadApi()->upload($request->file('thumbnail')->getRealPath(), [
                'folder' => 'eduide/courses'
            ]);
            $course->thumbnail = $upload['secure_url'] ?? $upload['url'] ?? null;
        }

        $course->save();

        return redirect()->route('admin.dashboard')->with('success', 'Kursus baru berhasil diterbitkan!');
    }

    /**
     * Update Kursus - Memperbarui data kursus yang sudah ada di sistem.
     */
    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'thumbnail'   => 'nullable|image|max:2048',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $course->fill($validated);

        // Upload thumbnail baru jika ada, jika tidak tetap gunakan yang lama
        if ($request->hasFile('thumbnail')) {
            $cloudinary = new \Cloudinary\Cloudinary(env('CLOUDINARY_URL'));
            $upload = $cloudinary->uploadApi()->upload($request->file('thumbnail')->getRealPath(), [
                'folder' => 'eduide/courses'
            ]);
            $course->thumbnail = $upload['secure_url'] ?? $upload['url'] ?? null;
        }

        $course->save();

        return redirect()->route('admin.dashboard')->with('success', 'Data kursus berhasil diperbarui!');
    }

    /**
     * Detail Kursus - Menampilkan informasi lengkap satu kursus tertentu.
     */
    public function show($slug)
    {
        $course = Course::with(['category'])->where('slug', $slug)->firstOrFail();
        return view('user.show', compact('course'));
    }

    /**
     * Enrollment - Mendaftarkan user ke kursus agar bisa mulai belajar.
     */
    public function enroll(Course $course)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Menggunakan syncWithoutDetaching agar data tidak terduplikat jika diklik berkali-kali
        Auth::user()->courses()->syncWithoutDetaching([$course->id]);

        return redirect()->route('user.enrolled')->with('success', 'Pendaftaran berhasil! Selamat menempuh ide baru.');
    }

    /**
     * Kursus Saya - Menampilkan koleksi kursus yang telah dibeli/diikuti oleh siswa.
     */
    public function myCourses()
    {
        $courses = Auth::user()->courses()->with('category')->latest()->get();
        return view('user.enrolled', compact('courses'));
    }
}
