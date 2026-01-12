<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
// Import SDK Native Cloudinary
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

class AdminController extends Controller
{
    public function __construct()
    {
        // Initialize Cloudinary configuration from env to avoid hard-coded secrets
        Configuration::instance([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key'    => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
            'url' => ['secure' => true]
        ]);
    }

    public function dashboard()
    {
        $stats = [
            ['label' => 'Total Siswa', 'value' => User::where('is_admin', false)->count(), 'color' => 'indigo'],
            ['label' => 'Ulasan Masuk', 'value' => Review::count(), 'color' => 'cyan'],
            ['label' => 'Kursus Aktif', 'value' => Course::count(), 'color' => 'purple'],
        ];

        $reviews = Review::latest()->get();
        $courses = Course::with('category')->withCount('students')->latest()->get();

        return view('admin.dashboard', compact('stats', 'reviews', 'courses'));
    }

    public function deleteReview($id)
    {
        Review::findOrFail($id)->delete();
        return back()->with('success', 'Ulasan telah berhasil dihapus.');
    }

    public function createCourse()
    {
        $categories = Category::all();
        return view('admin.course-form', compact('categories'));
    }

    public function storeCourse(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'category_id'  => 'required|exists:categories,id',
            'description'  => 'required',
            'price'        => 'required|numeric|min:0',
            'level'        => 'required|in:beginner,intermediate,advanced',
            'thumbnail'    => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        try {
            $thumbnailUrl = null;
            if ($request->hasFile('thumbnail')) {
                $uploadApi = new UploadApi();
                $upload = $uploadApi->upload($request->file('thumbnail')->getRealPath(), [
                    'folder' => 'eduide/thumbnails'
                ]);
                $thumbnailUrl = $upload['secure_url'];
            }

            Course::create([
                'author_id'    => auth()->id(),
                'category_id'  => $request->category_id,
                'title'        => $request->title,
                'slug'         => Str::slug($request->title),
                'description'  => $request->description,
                'price'        => $request->price,
                'level'        => $request->level,
                'thumbnail'    => $thumbnailUrl,
                'is_published' => $request->has('is_published'),
            ]);

            return redirect()->route('admin.dashboard')->with('success', 'Kursus baru berhasil diterbitkan!');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['thumbnail' => 'Gagal: ' . $e->getMessage()]);
        }
    }

    public function editCourse($id)
    {
        $course = Course::findOrFail($id);
        $categories = Category::all();
        return view('admin.course-form', compact('course', 'categories'));
    }

    public function updateCourse(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $request->validate([
            'title'        => 'required|string|max:255',
            'category_id'  => 'required|exists:categories,id',
            'description'  => 'required',
            'price'        => 'required|numeric|min:0',
            'level'        => 'required|in:beginner,intermediate,advanced',
            'thumbnail'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'category_id'  => $request->category_id,
            'title'        => $request->title,
            'slug'         => Str::slug($request->title),
            'description'  => $request->description,
            'price'        => $request->price,
            'level'        => $request->level,
            'is_published' => $request->has('is_published'),
        ];

        try {
            if ($request->hasFile('thumbnail')) {
                $uploadApi = new UploadApi();
                $upload = $uploadApi->upload($request->file('thumbnail')->getRealPath(), [
                    'folder' => 'eduide/thumbnails'
                ]);
                $data['thumbnail'] = $upload['secure_url'];
            }

            $course->update($data);
            return redirect()->route('admin.dashboard')->with('success', 'Data kursus berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['thumbnail' => 'Gagal Update: ' . $e->getMessage()]);
        }
    }

    public function deleteCourse($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return back()->with('success', 'Kursus telah dihapus.');
    }
}
