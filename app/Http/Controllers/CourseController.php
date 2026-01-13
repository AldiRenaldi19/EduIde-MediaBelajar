<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Services\CloudinaryClient;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;

/**
 * Controller kursus untuk sisi siswa dan admin.
 *
 * Menangani:
 * - katalog dan detail kursus untuk siswa,
 * - proses enroll dan daftar kursus yang diambil,
 * - operasi CRUD kursus dari sisi admin (store/update/destroy).
 */
class CourseController extends Controller
{
    /**
     * Klien Cloudinary untuk upload thumbnail kursus.
     */
    protected $cloudinary;

    /**
     * Konstruktor.
     *
     * @param  CloudinaryClient  $cloudinary  Abstraksi klien Cloudinary.
     */
    public function __construct(CloudinaryClient $cloudinary)
    {
        $this->cloudinary = $cloudinary;
    }

    /**
     * Katalog utama: daftar kursus yang tersedia untuk siswa.
     *
     * Fitur:
     * - pencarian berdasarkan judul,
     * - filter berdasarkan kategori (slug),
     * - pagination untuk pengalaman belajar yang nyaman.
     */
    public function dashboard(Request $request): \Illuminate\View\View
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
     * Detail kursus tunggal berdasarkan slug SEO‑friendly.
     */
    public function show(string $slug): \Illuminate\View\View
    {
        $course = Course::with(['category'])->where('slug', $slug)->firstOrFail();
        return view('user.show', compact('course'));
    }

    /**
     * Mendaftarkan user ke kursus (enroll) agar bisa mulai belajar.
     */
    public function enroll(Course $course): \Illuminate\Http\RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Menggunakan syncWithoutDetaching agar data tidak terduplikat jika diklik berkali-kali
        Auth::user()->courses()->syncWithoutDetaching([$course->id]);

        return redirect()->route('user.enrolled')->with('success', 'Pendaftaran berhasil! Selamat menempuh ide baru.');
    }

    /**
     * Menampilkan daftar kursus yang sudah diikuti siswa beserta progres modul.
     */
    public function myCourses(): \Illuminate\View\View
    {
        $user = Auth::user();
        $courses = $user->courses()
            ->with('category')
            ->withCount('modules') // Eager-loads 'modules_count'
            ->latest()
            ->get();

        // Ambil jumlah modul yang selesai untuk semua kursus user dalam satu query
        $completedModuleCounts = \App\Models\ModuleCompletion::where('user_id', $user->id)
            ->select('course_id', \DB::raw('count(*) as completions'))
            ->groupBy('course_id')
            ->pluck('completions', 'course_id');

        // Hitung progress di sini (di controller), bukan di model dalam perulangan
        $courses->each(function ($course) use ($completedModuleCounts) {
            $completedCount = $completedModuleCounts->get($course->id, 0);
            $totalModules = $course->modules_count; // Menggunakan hasil withCount
            $course->progress = ($totalModules > 0) ? round(($completedCount / $totalModules) * 100) : 0;
            $course->completed_modules = $completedCount;
            $course->total_modules = $totalModules;
        });

        return view('user.enrolled', compact('courses', 'user'));
    }

    /**
     * Admin: simpan kursus baru.
     */
    public function store(StoreCourseRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $thumbnailUrl = null;

            if ($request->hasFile('thumbnail')) {
                $upload = $this->cloudinary->upload(
                    $request->file('thumbnail')->getRealPath(),
                    ['folder' => 'eduide/thumbnails']
                );

                $thumbnailUrl = $upload['secure_url'] ?? $upload['url'] ?? null;
            }

            Course::create([
                'author_id'    => Auth::id(),
                'category_id'  => $request->category_id,
                'title'        => $request->title,
                'slug'         => Str::slug($request->title) . '-' . strtolower(Str::random(5)),
                'description'  => $request->description,
                'price'        => $request->price,
                'level'        => $request->level,
                'level'        => $request->level,
                'thumbnail'    => $thumbnailUrl,
                'is_published' => $request->boolean('is_published'),
            ]);

            return redirect()->route('admin.dashboard')->with('success', 'Kursus baru berhasil diterbitkan!');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['thumbnail' => 'Gagal: ' . $e->getMessage()]);
        }
    }

    /**
     * Admin: perbarui kursus.
     */
    public function update(UpdateCourseRequest $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $course = Course::findOrFail($id);

        $data = [
            'category_id'  => $request->category_id,
            'title'        => $request->title,
            'description'  => $request->description,
            'price'        => $request->price,
            'level'        => $request->level,
            'is_published' => $request->boolean('is_published'),
        ];

        // Regenerasi slug jika judul berubah agar URL tetap konsisten
        if ($course->title !== $request->title) {
            $data['slug'] = Str::slug($request->title) . '-' . strtolower(Str::random(5));
        }

        try {
            if ($request->hasFile('thumbnail')) {
                $upload = $this->cloudinary->upload(
                    $request->file('thumbnail')->getRealPath(),
                    ['folder' => 'eduide/thumbnails']
                );

                $data['thumbnail'] = $upload['secure_url'] ?? $upload['url'] ?? null;
            }

            $course->update($data);

            return redirect()->route('admin.dashboard')->with('success', 'Data kursus berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['thumbnail' => 'Gagal Update: ' . $e->getMessage()]);
        }
    }

    /**
     * Admin: hapus kursus beserta modul terkait.
     */
    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return back()->with('success', 'Kursus telah dihapus.');
    }
}
