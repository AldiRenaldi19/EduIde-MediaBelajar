<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use App\Models\Course;
use App\Models\Category;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
// Import SDK Native Cloudinary
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class AdminController extends Controller
{
    public function __construct()
    {
        // Cloudinary configuration is loaded from config/cloudinary.php and env.
    }

    public function dashboard(Request $request)
    {
        $stats = [
            ['label' => 'Total Siswa', 'value' => User::where('is_admin', false)->count(), 'color' => 'indigo'],
            ['label' => 'Ulasan Masuk', 'value' => Review::count(), 'color' => 'cyan'],
            ['label' => 'Kursus Aktif', 'value' => Course::count(), 'color' => 'purple'],
        ];

        $reviews = Review::latest()->paginate(10)->withQueryString();
        $courses = Course::with('category')->withCount('students')->latest()->paginate(12)->withQueryString();

        return view('admin.dashboard', compact('stats', 'reviews', 'courses'));
    }

    public function deleteReview($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        AuditLog::create([
            'admin_id' => auth()->id(),
            'action' => 'delete_review',
            'target_type' => 'review',
            'target_id' => $id,
            'details' => json_encode(['name' => $review->name]),
        ]);

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
                $upload = Cloudinary::upload($request->file('thumbnail')->getRealPath(), [
                    'folder' => 'eduide/thumbnails'
                ]);
                $thumbnailUrl = $upload->getSecurePath();
            }

            $course = Course::create([
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

            AuditLog::create([
                'admin_id' => auth()->id(),
                'action' => 'create_course',
                'target_type' => 'course',
                'target_id' => $course->id,
                'details' => json_encode(['title' => $course->title]),
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
                $upload = Cloudinary::upload($request->file('thumbnail')->getRealPath(), [
                    'folder' => 'eduide/thumbnails'
                ]);
                $data['thumbnail'] = $upload->getSecurePath();
            }

            $course->update($data);

            AuditLog::create([
                'admin_id' => auth()->id(),
                'action' => 'update_course',
                'target_type' => 'course',
                'target_id' => $course->id,
                'details' => json_encode(['title' => $course->title]),
            ]);

            return redirect()->route('admin.dashboard')->with('success', 'Data kursus berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['thumbnail' => 'Gagal Update: ' . $e->getMessage()]);
        }
    }

    public function deleteCourse($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        AuditLog::create([
            'admin_id' => auth()->id(),
            'action' => 'delete_course',
            'target_type' => 'course',
            'target_id' => $course->id,
            'details' => json_encode(['title' => $course->title]),
        ]);

        return back()->with('success', 'Kursus telah dihapus.');
    }

    // Toggle publish/unpublish
    public function togglePublish($id)
    {
        $course = Course::findOrFail($id);
        $course->is_published = !$course->is_published;
        $course->save();

        AuditLog::create([
            'admin_id' => auth()->id(),
            'action' => $course->is_published ? 'publish_course' : 'unpublish_course',
            'target_type' => 'course',
            'target_id' => $course->id,
            'details' => json_encode(['title' => $course->title, 'is_published' => $course->is_published]),
        ]);

        return back()->with('success', 'Status publikasi kursus telah diperbarui.');
    }

    // Users list
    public function users(Request $request)
    {
        $query = User::query();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $users = $query->latest()->paginate(15)->withQueryString();
        return view('admin.users', compact('users'));
    }

    // Toggle admin role
    public function toggleUserAdmin($id)
    {
        $user = User::findOrFail($id);
        $user->is_admin = !$user->is_admin;
        $user->save();

        AuditLog::create([
            'admin_id' => auth()->id(),
            'action' => $user->is_admin ? 'promote_user' : 'demote_user',
            'target_type' => 'user',
            'target_id' => $user->id,
            'details' => json_encode(['email' => $user->email, 'is_admin' => $user->is_admin]),
        ]);

        return back()->with('success', 'Status admin user telah diperbarui.');
    }

    // Reviews listing for moderation (separate view is optional)
    public function reviews(Request $request)
    {
        $query = Review::query();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')->orWhere('message', 'like', '%' . $request->search . '%');
        }

        $reviews = $query->latest()->paginate(10)->withQueryString();
        return view('admin.dashboard', compact('reviews'));
    }

    // Export courses CSV
    public function exportCourses()
    {
        $filename = 'courses-export-' . date('YmdHis') . '.csv';
        $columns = ['id', 'title', 'slug', 'category', 'author', 'price', 'is_published', 'created_at'];

        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            Course::with('category', 'author')->chunk(200, function ($courses) use ($file) {
                foreach ($courses as $c) {
                    fputcsv($file, [
                        $c->id,
                        $c->title,
                        $c->slug,
                        $c->category->name ?? '',
                        $c->author->name ?? '',
                        $c->price,
                        $c->is_published ? '1' : '0',
                        $c->created_at->toDateTimeString(),
                    ]);
                }
            });

            fclose($file);
        };

        AuditLog::create([
            'admin_id' => auth()->id(),
            'action' => 'export_courses_csv',
            'target_type' => 'course_export',
            'target_id' => null,
            'details' => json_encode(['filename' => $filename]),
        ]);

        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }
}
