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
