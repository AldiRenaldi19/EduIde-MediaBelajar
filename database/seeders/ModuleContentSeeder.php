<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;

class ModuleContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find some modules and attach example content if available
        $modules = Module::take(10)->get();
        if ($modules->isEmpty()) {
            return;
        }

        // Example: first module -> YouTube
        if (isset($modules[0])) {
            $modules[0]->update([
                'content_type' => 'video',
                'content_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'attachment_mime' => null,
            ]);
        }

        // second module -> public MP4 (example file)
        if (isset($modules[1])) {
            $modules[1]->update([
                'content_type' => 'video',
                'content_url' => 'https://interactive-examples.mdn.mozilla.net/media/cc0-videos/flower.mp4',
                'attachment_mime' => 'video/mp4',
            ]);
        }

        // third module -> PDF
        if (isset($modules[2])) {
            $modules[2]->update([
                'content_type' => 'document',
                'content_url' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
                'attachment_mime' => 'application/pdf',
            ]);
        }
    }
}
