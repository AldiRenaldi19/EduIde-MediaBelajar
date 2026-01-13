<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use App\Models\Course;
use App\Models\Category;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Services\CloudinaryClient;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;

/**
 * Controller untuk area Admin.
 *
 * Menangani:
 * - Dashboard & statistik platform,
 * - Manajemen kursus (buat, ubah, hapus, publish),
 * - Manajemen user & role admin,
 * - Moderasi ulasan dan audit log,
 * - Ekspor data kursus ke CSV.
 */
class AdminController extends Controller
{
    /**
     * Klien Cloudinary terabstraksi agar mudah di‑mock dan dikonfigurasi.
     */
    protected $cloudinary;

    /**
     * Konstruktor.
     *
     * @param  CloudinaryClient  $cloudinary  Abstraksi klien Cloudinary untuk upload thumbnail.
     */
    public function __construct(CloudinaryClient $cloudinary)
    {
        $this->cloudinary = $cloudinary;

        /**
         * Pengamanan tambahan:
         * Walaupun semua rute admin sudah dibungkus middleware 'auth' dan 'admin'
         * di file routes/web.php, kita tetap menambahkan lapisan pengecekan di sini
         * agar tidak ada method AdminController yang bisa diakses tanpa hak admin.
         */
        $this->middleware(function ($request, $next) {
            if (!auth()->check() || !auth()->user()->is_admin) {
                abort(403, 'Unauthorized action.');
            }

            return $next($request);
        });
    }

    /**
     * Menampilkan dashboard admin beserta:
     * - kartu statistik singkat,
     * - daftar kursus,
     * - daftar ulasan terbaru.
     */
    public function dashboard(Request $request): \Illuminate\View\View
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

    /**
     * Menghapus satu ulasan dari sistem (moderasi konten).
     *
     * @param  int  $id  ID ulasan yang akan dihapus.
     */
    public function deleteReview(int $id): \Illuminate\Http\RedirectResponse
    {
        $review = Review::findOrFail($id);
        $review->delete();

        // AuditLog handled by Observer
        return back()->with('success', 'Ulasan telah berhasil dihapus.');
    }

    /**
     * Form pembuatan kursus baru.
     * Hanya menyiapkan daftar kategori untuk dipilih di form admin.
     */
    public function createCourse(): \Illuminate\View\View
    {
        $categories = Category::all();
        return view('admin.course-form', compact('categories'));
    }

    /**
     * Simpan kursus baru melalui form khusus AdminController (legacy).
     *
     * Catatan: logika baru dianjurkan menggunakan CourseController::store.
     */
    public function storeCourse(StoreCourseRequest $request)
    {
        try {
            $thumbnailUrl = null;
            if ($request->hasFile('thumbnail')) {
                $upload = $this->cloudinary->upload($request->file('thumbnail')->getRealPath(), ['folder' => 'eduide/thumbnails']);
                $thumbnailUrl = $upload['secure_url'] ?? $upload['url'] ?? null;
            }

            $course = Course::create([
                'author_id'    => auth()->id(),
                'category_id'  => $request->category_id,
                'title'        => $request->title,
                'slug'         => Str::slug($request->title) . '-' . strtolower(Str::random(5)),
                'description'  => $request->description,
                'price'        => $request->price,
                'level'        => $request->level,
                'thumbnail'    => $thumbnailUrl,
                'is_published' => $request->boolean('is_published'),
            ]);

            // AuditLog handled by Observer
            return redirect()->route('admin.dashboard')->with('success', 'Kursus baru berhasil diterbitkan!');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['thumbnail' => 'Gagal: ' . $e->getMessage()]);
        }
    }

    /**
     * Form edit kursus.
     *
     * @param  int  $id  ID kursus yang akan diedit.
     */
    public function editCourse(int $id): \Illuminate\View\View
    {
        $course = Course::findOrFail($id);
        $categories = Category::all();
        return view('admin.course-form', compact('course', 'categories'));
    }

    /**
     * Perbarui data kursus melalui form legacy AdminController.
     *
     * @param  UpdateCourseRequest  $request
     * @param  int                  $id       ID kursus.
     */
    public function updateCourse(UpdateCourseRequest $request, $id)
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

        try {
            // Hanya update slug jika judul berubah, untuk menjaga URL tetap stabil
            if ($course->title !== $request->title) {
                $data['slug'] = Str::slug($request->title) . '-' . strtolower(Str::random(5));
            }

            if ($request->hasFile('thumbnail')) {
                $upload = $this->cloudinary->upload($request->file('thumbnail')->getRealPath(), ['folder' => 'eduide/thumbnails']);
                $data['thumbnail'] = $upload['secure_url'] ?? $upload['url'] ?? null;
            }

            $course->update($data);

            // AuditLog handled by Observer
            return redirect()->route('admin.dashboard')->with('success', 'Data kursus berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['thumbnail' => 'Gagal Update: ' . $e->getMessage()]);
        }
    }

    /**
     * Menghapus kursus dan konten terkait melalui AdminController.
     *
     * @param  int  $id  ID kursus.
     */
    public function deleteCourse($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        // AuditLog handled by Observer
        return back()->with('success', 'Kursus telah dihapus.');
    }

    /**
     * Toggle status publikasi kursus (publish <-> draft).
     *
     * @param  int  $id  ID kursus.
     */
    public function togglePublish($id)
    {
        $course = Course::findOrFail($id);
        $course->is_published = !$course->is_published;
        $course->save();

        // AuditLog handled by Observer
        return back()->with('success', 'Status publikasi kursus telah diperbarui.');
    }

    /**
     * Menampilkan daftar seluruh user dengan opsi pencarian.
     */
    public function users(Request $request): \Illuminate\View\View
    {
        $query = User::query();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $users = $query->latest()->paginate(15)->withQueryString();
        return view('admin.users', compact('users'));
    }

    /**
     * Mengubah status admin pada user tertentu (promote/demote).
     *
     * @param  int  $id  ID user.
     */
    public function toggleUserAdmin($id)
    {
        $user = User::findOrFail($id);
        $user->is_admin = !$user->is_admin;
        $user->save();

        // AuditLog handled by Observer
        return back()->with('success', 'Status admin user telah diperbarui.');
    }

    /**
     * Menampilkan daftar ulasan dengan opsi pencarian untuk moderasi.
     * View yang digunakan tetap dashboard utama agar admin tidak berpindah konteks.
     */
    public function reviews(Request $request): \Illuminate\View\View
    {
        $query = Review::query();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')->orWhere('message', 'like', '%' . $request->search . '%');
        }

        $reviews = $query->latest()->paginate(10)->withQueryString();

        // Data tambahan yang dibutuhkan oleh view dashboard
        $stats = [
            ['label' => 'Total Siswa', 'value' => User::where('is_admin', false)->count(), 'color' => 'indigo'],
            ['label' => 'Ulasan Masuk', 'value' => Review::count(), 'color' => 'cyan'],
            ['label' => 'Kursus Aktif', 'value' => Course::count(), 'color' => 'purple'],
        ];

        $courses = Course::with('category')->withCount('students')->latest()->paginate(12)->withQueryString();

        return view('admin.dashboard', compact('reviews', 'stats', 'courses'));
    }

    /**
     * Mengekspor data kursus ke file CSV untuk analisis atau backup ringan.
     *
     * File akan dikirim sebagai stream download sehingga tidak menambah file di server.
     */
    /**
     * Mengekspor data kursus ke file CSV atau PDF.
     */
    public function exportCourses(Request $request)
    {
        $format = $request->query('format', 'csv');

        // Export PDF
        if ($format === 'pdf') {
            $courses = Course::with('category', 'author')->latest()->get();
            $pdf = Pdf::loadView('admin.exports.courses-pdf', compact('courses'));
            return $pdf->download('courses-export-' . date('YmdHis') . '.pdf');
        }

        // Default: Export CSV
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

        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }

    /**
     * Audit logs viewer for admins
     */
    public function auditLogs(Request $request): \Illuminate\View\View
    {
        $query = AuditLog::with('admin');

        // Full text search across action, target_type, details and admin name/email
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($sub) use ($q) {
                $sub->where('action', 'like', "%{$q}%")
                    ->orWhere('target_type', 'like', "%{$q}%")
                    ->orWhere('details', 'like', "%{$q}%");
            })->orWhereHas('admin', function ($a) use ($q) {
                $a->where('name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%");
            });
        }

        // Filter by specific action (exact match)
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Date range filters (YYYY-MM-DD)
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Provide a list of actions for the filter dropdown
        $actions = AuditLog::select('action')->distinct()->orderBy('action')->pluck('action');

        $logs = $query->latest()->paginate(20)->withQueryString();

        return view('admin.audit-logs', compact('logs', 'actions'));
    }
}
