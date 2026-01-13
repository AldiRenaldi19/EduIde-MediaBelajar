<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Module;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CourseService
{
    /**
     * Helper untuk memproses URL konten (Deteksi YouTube/Video File & HTTPS)
     */
    public function processModuleContent(?string $url): array
    {
        if (empty($url)) {
            return ['type' => 'document', 'url' => '#', 'youtube_id' => null];
        }

        $isYoutube = str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be');
        $isVideoFile = false;
        $youtubeId = null;

        // Cek ekstensi file jika bukan YouTube
        if (!$isYoutube) {
            $path = parse_url($url, PHP_URL_PATH);
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $isVideoFile = in_array(strtolower($ext), ['mp4', 'webm', 'ogg', 'mov', 'm4v']);
        }

        // Force HTTPS
        if (str_starts_with($url, 'http://')) {
            $url = str_replace('http://', 'https://', $url);
        }

        // Ekstrak YouTube ID
        if ($isYoutube) {
            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches);
            if (isset($matches[1])) {
                $youtubeId = $matches[1];
            }

            // Standardize Embed URL
            if (!str_contains($url, '/embed/') && $youtubeId) {
                $url = 'https://www.youtube.com/embed/' . $youtubeId;
            }
        }

        return [
            'type' => ($isYoutube || $isVideoFile) ? 'video' : 'document',
            'url' => $url,
            'youtube_id' => $youtubeId
        ];
    }

    /**
     * Check if a user is enrolled in a course.
     */
    public function isEnrolled(?User $user, int $courseId): bool
    {
        if (!$user) {
            return false;
        }
        return $user->courses()->where('course_id', $courseId)->exists();
    }

    /**
     * Get adjacent modules for navigation.
     */
    public function getModuleNavigation(Course $course, Module $currentModule): array
    {
        $previous = $course->modules()
            ->where('order', '<', $currentModule->order)
            ->orderBy('order', 'desc')
            ->first();

        $next = $course->modules()
            ->where('order', '>', $currentModule->order)
            ->orderBy('order', 'asc')
            ->first();

        return compact('previous', 'next');
    }
}
