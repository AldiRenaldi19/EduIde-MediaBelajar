<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            ['label' => 'Total Siswa', 'value' => User::where('is_admin', false)->count(), 'color' => 'indigo'],
            ['label' => 'Ulasan Masuk', 'value' => Review::count(), 'color' => 'cyan'],
            ['label' => 'Kursus Aktif', 'value' => Course::count(), 'color' => 'purple'],
        ];

        $reviews = Review::latest()->get();
        $courses = Course::withCount('students')->latest()->get(); // Mengambil kursus + jumlah siswa

        return view('admin.dashboard', compact('stats', 'reviews', 'courses'));
    }

    // --- MANAJEMEN ULASAN ---
    public function deleteReview($id)
    {
        Review::findOrFail($id)->delete();
        return back()->with('success', 'Ulasan telah berhasil dihapus.');
    }

    // --- MANAJEMEN KURSUS ---
    public function createCourse()
    {
        return view('admin.course-form'); // Form untuk tambah kursus
    }

    public function storeCourse(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'instructor' => 'required|string',
            'category' => 'required',
            'description' => 'required',
            'image_url' => 'required|url',
        ]);

        Course::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title), // Otomatis buat slug
            'instructor' => $request->instructor,
            'category' => $request->category,
            'description' => $request->description,
            'image_url' => $request->image_url,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Kursus baru berhasil diterbitkan!');
    }

    public function editCourse($id)
    {
        $course = Course::findOrFail($id);
        return view('admin.course-form', compact('course'));
    }

    public function updateCourse(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'instructor' => 'required|string',
            'image_url' => 'required|url',
        ]);

        $course->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'instructor' => $request->instructor,
            'category' => $request->category,
            'description' => $request->description,
            'image_url' => $request->image_url,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Data kursus berhasil diperbarui!');
    }

    public function deleteCourse($id)
    {
        Course::findOrFail($id)->delete();
        return back()->with('success', 'Kursus telah dihapus dari sistem.');
    }
}
