<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ModuleController extends Controller
{
    /**
     * Menampilkan halaman pembelajaran modul
     * Path: /user/{course_slug}/learn/{module_id}
     */
    public function learn($courseSlug, $moduleId)
    {
        // Cari course berdasarkan slug
        $course = Course::where('slug', $courseSlug)->firstOrFail();

        // Cari module berdasarkan id dan pastikan milik course ini
        $module = Module::where('id', $moduleId)
            ->where('course_id', $course->id)
            ->firstOrFail();

        // Cek apakah user sudah enroll course ini
        if (Auth::check() && Auth::user()->courses()->where('course_id', $course->id)->exists()) {
            $isEnrolled = true;
        } else {
            // Redirect ke halaman course jika belum enroll
            return redirect()->route('user.show', $course->slug)
                ->with('error', 'Anda harus mendaftar course ini terlebih dahulu.');
        }

        // Ambil semua modules dari course untuk navigation sidebar
        $modules = $course->modules()->get();

        // Ambil module sebelum dan sesudah untuk navigation
        $previousModule = $course->modules()
            ->where('order', '<', $module->order)
            ->orderBy('order', 'desc')
            ->first();

        $nextModule = $course->modules()
            ->where('order', '>', $module->order)
            ->orderBy('order', 'asc')
            ->first();

        return view('user.learn', compact('course', 'module', 'modules', 'previousModule', 'nextModule', 'isEnrolled'));
    }

    /**
     * Update module thumbnail (admin action). Validates file and uploads to Cloudinary with error handling.
     * Path: POST /admin/modules/{id}/thumbnail
     */
    public function updateThumbnail(Request $request, $id)
    {
        $module = Module::findOrFail($id);

        // simple auth check - only allow admins
        if (!Auth::check() || !Auth::user()->is_admin) {
            return abort(403);
        }

        $request->validate([
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        if (!$request->hasFile('thumbnail')) {
            return back()->withErrors(['thumbnail' => 'File gambar tidak ditemukan.']);
        }

        try {
            $file = $request->file('thumbnail');

            $cloudinary = new \Cloudinary\Cloudinary(env('CLOUDINARY_URL'));
            $upload = $cloudinary->uploadApi()->upload($file->getRealPath(), [
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
     * POST /admin/modules/{id}/content
     */
    public function updateContent(Request $request, $id)
    {
        $module = Module::findOrFail($id);

        if (!Auth::check() || !Auth::user()->is_admin) {
            return abort(403);
        }

        $request->validate([
            'content_option' => 'required|in:file,url',
            'file' => 'nullable|file|max:51200', // up to 50MB
            'url' => 'nullable|url',
        ]);

        try {
            if ($request->content_option === 'file' && $request->hasFile('file')) {
                $file = $request->file('file');
                $mime = $file->getMimeType();

                $cloudinary = new \Cloudinary\Cloudinary(env('CLOUDINARY_URL'));
                $upload = $cloudinary->uploadApi()->upload($file->getRealPath(), [
                    'folder' => 'eduide/modules/content',
                    'resource_type' => 'auto',
                ]);

                $url = $upload['secure_url'] ?? $upload['url'] ?? null;
                $type = str_starts_with($mime, 'video/') ? 'video' : 'document';

                $module->content_type = $type;
                $module->content_url = $url;
                $module->attachment_mime = $mime;
                $module->save();

                return back()->with('success', 'Konten modul berhasil diunggah.');
            }

            if ($request->content_option === 'url' && $request->filled('url')) {
                $url = $request->url;
                $type = str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be') ? 'video' : 'document';

                $module->content_type = $type;
                $module->content_url = $url;
                $module->attachment_mime = null;
                $module->save();

                return back()->with('success', 'Konten modul berhasil ditautkan.');
            }

            return back()->withErrors(['file' => 'Tidak ada file atau URL yang diberikan.']);
        } catch (\Exception $e) {
            Log::error('Module content upload failed', ['module_id' => $module->id, 'error' => $e->getMessage()]);
            return back()->withErrors(['file' => 'GAGAL UPLOAD: ' . $e->getMessage()]);
        }
    }

    /**
     * Menampilkan daftar modul suatu course
     * Path: /user/{course_slug}/modules
     */
    public function index($courseSlug)
    {
        $course = Course::where('slug', $courseSlug)->firstOrFail();

        // Cek apakah user sudah enroll
        if (Auth::check() && Auth::user()->courses()->where('course_id', $course->id)->exists()) {
            $isEnrolled = true;
        } else {
            return redirect()->route('user.show', $course->slug)
                ->with('error', 'Anda harus mendaftar course ini terlebih dahulu.');
        }

        $modules = $course->modules()->get();

        return view('user.modules', compact('course', 'modules', 'isEnrolled'));
    }
}
