<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use App\Models\ModuleCompletion;
use App\Services\CloudinaryClient;
use App\Services\CourseService;
use App\Http\Requests\Module\StoreModuleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Controller modul pembelajaran.
 *
 * Menangani:
 * - navigasi belajar per modul,
 * - CRUD ringan modul oleh admin (tambah, hapus, update thumbnail & konten),
 * - penandaan progres modul selesai oleh siswa.
 */
class ModuleController extends Controller
{
    protected CloudinaryClient $cloudinary;
    protected CourseService $courseService;

    /**
     * Konstruktor.
     *
     * Hanya admin yang boleh memodifikasi sumber belajar (store/update/destroy).
     */
    public function __construct(CloudinaryClient $cloudinary, CourseService $courseService)
    {
        $this->cloudinary = $cloudinary;
        $this->courseService = $courseService;

        // Security: batasi hanya admin untuk aksi yang memodifikasi modul.
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || !Auth::user()->is_admin) {
                abort(403, 'Unauthorized action.');
            }

            return $next($request);
        })->only(['store', 'updateThumbnail', 'updateContent', 'destroy']);
    }

    /**
     * Menampilkan halaman pembelajaran modul
     * Path: /user/{course_slug}/learn/{module_id}
     */
    public function learn(string $courseSlug, int $moduleId)
    {
        $course = Course::where('slug', $courseSlug)->firstOrFail();
        
        $module = Module::where('id', $moduleId)
            ->where('course_id', $course->id)
            ->firstOrFail();

        // Process module content via Service (skip for text/empty)
        if ($module->content_type !== 'text' && $module->content_url) {
            $processedData = $this->courseService->processModuleContent($module->content_url);
            $module->content_type = $processedData['type'] === 'video' ? 'video' : $module->content_type;
            $module->content_url = $processedData['url'];
            $youtubeId = $processedData['youtube_id'];
        } else {
            $youtubeId = null;
        }

        // Check enrollment via Service
        if (!$this->courseService->isEnrolled(Auth::user(), $course->id)) {
            return redirect()->route('user.show', $course->slug)
                ->with('error', 'Anda harus mendaftar course ini terlebih dahulu.');
        }

        // Get navigation via Service
        $navigation = $this->courseService->getModuleNavigation($course, $module);
        $previousModule = $navigation['previous'];
        $nextModule = $navigation['next'];

        $modules = $course->modules()->get();

        $isCompleted = ModuleCompletion::where('user_id', Auth::id())
            ->where('module_id', $module->id)
            ->exists();
        
        // Pass isEnrolled as true since we checked it above
        $isEnrolled = true; 

        return view('user.learn', compact('course', 'module', 'modules', 'previousModule', 'nextModule', 'isEnrolled', 'youtubeId', 'isCompleted'));
    }

    /**
     * Membuat modul baru untuk kursus tertentu.
     * Path: POST /admin/courses/{courseId}/modules
     */
    public function store(StoreModuleRequest $request, int $courseId)
    {
        $course = Course::findOrFail($courseId);

        $course->modules()->create([
            'title' => $request->title,
            'slug'  => Str::slug($request->title) . '-' . Str::random(5),
            'order' => $request->order,
        ]);

        return back()->with('success', 'Modul baru berhasil ditambahkan.');
    }

    /**
     * Update module thumbnail (admin action).
     */
    public function updateThumbnail(Request $request, int $id)
    {
        $module = Module::findOrFail($id);

        $request->validate([
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        if (!$request->hasFile('thumbnail')) {
            return back()->withErrors(['thumbnail' => 'File gambar tidak ditemukan.']);
        }

        try {
            $file = $request->file('thumbnail');

            $upload = $this->cloudinary->upload($file->getRealPath(), [
                'folder' => 'eduide/modules'
            ]);

            $module->thumbnail = $upload['secure_url'] ?? $upload['url'] ?? null;
            $module->save();

            return back()->with('success', 'Gambar modul berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Module thumbnail upload failed', ['module_id' => $module->id, 'error' => $e->getMessage()]);
            return back()->withErrors(['thumbnail' => 'GAGAL UPDATE: ' . $e->getMessage()]);
        }
    }

    /**
     * Admin: attach or upload module content (video/document or external URL)
     */
    public function updateContent(Request $request, int $id)
    {
        $module = Module::findOrFail($id);

        $request->validate([
            'content_option' => 'required|in:file,url,text',
            'file' => 'nullable|file|max:51200',
            'url' => 'nullable|url',
            'text_content' => 'nullable|string',
        ]);

        try {
            if ($request->content_option === 'file' && $request->hasFile('file')) {
                $file = $request->file('file');
                $mime = $file->getMimeType();

                $upload = $this->cloudinary->upload($file->getRealPath(), [
                    'folder' => 'eduide/modules/content',
                    'resource_type' => 'auto',
                ]);

                $url = $upload['secure_url'] ?? $upload['url'] ?? null;
                // Basic detection, but also consider PDF explicitly
                if (str_starts_with($mime, 'video/')) {
                    $type = 'video';
                } elseif ($mime === 'application/pdf') {
                    $type = 'document';
                } else {
                    // Default to document for other files, or handle specific cases
                    $type = 'document';
                }

                $module->content_type = $type;
                $module->content_url = $url;
                $module->attachment_mime = $mime;
                $module->save();

                return back()->with('success', 'Konten modul berhasil diunggah.');
            }

            if ($request->content_option === 'url' && $request->filled('url')) {
                // Use Service to normalize content logic if needed, 
                // but for saving to DB we just save raw URL or process it slightly.
                // Reusing service logic for consistency if we want to store processed URL
                // but usually we store raw and process on display.
                // Here we keep existing logic of converting youtube watch to embed for storage if that's preferred,
                // OR we can rely on Service::processModuleContent at display time.
                // The original code converted it at storage time. Let's keep it for compatibility.
                
                $processing = $this->courseService->processModuleContent($request->url);
                $module->content_type = $processing['type'];
                $module->content_url = $processing['url']; // This is already embed url if youtube
                $module->attachment_mime = null;
                $module->save();

                return back()->with('success', 'Konten modul berhasil ditautkan.');
            }

            if ($request->content_option === 'text' && $request->filled('text_content')) {
                $module->content_type = 'text';
                $module->content = $request->text_content;
                $module->content_url = null;
                $module->attachment_mime = null;
                $module->save();

                return back()->with('success', 'Materi teks berhasil disimpan.');
            }

            return back()->withErrors(['file' => 'Tidak ada konten yang diberikan.']);
        } catch (\Exception $e) {
            Log::error('Module content upload failed', ['module_id' => $module->id, 'error' => $e->getMessage()]);
            return back()->withErrors(['file' => 'GAGAL UPLOAD: ' . $e->getMessage()]);
        }
    }

    /**
     * Menghapus modul.
     */
    public function destroy(int $id)
    {
        $module = Module::findOrFail($id);
        $module->delete();

        return back()->with('success', 'Modul berhasil dihapus.');
    }

    /**
     * Menampilkan daftar modul suatu course
     * Path: /user/{course_slug}/modules
     */
    public function index(string $courseSlug)
    {
        $course = Course::where('slug', $courseSlug)->firstOrFail();

        if (!$this->courseService->isEnrolled(Auth::user(), $course->id)) {
            return redirect()->route('user.show', $course->slug)
                ->with('error', 'Anda harus mendaftar course ini terlebih dahulu.');
        }

        $modules = $course->modules()->get();
        $isEnrolled = true;

        return view('user.modules', compact('course', 'modules', 'isEnrolled'));
    }

    /**
     * Menandai modul sebagai selesai.
     */
    public function markAsComplete(Request $request, int $id)
    {
        $module = Module::findOrFail($id);

        if (Auth::check()) {
            ModuleCompletion::firstOrCreate([
                'user_id' => Auth::id(),
                'module_id' => $module->id,
                'course_id' => $module->course_id
            ]);
        }

        return back()->with('success', 'Modul selesai!');
    }
}
