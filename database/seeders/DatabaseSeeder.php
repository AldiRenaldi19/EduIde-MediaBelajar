<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat User Contoh
        $user = User::create([
            'name' => 'Dosen Penguji',
            'email' => 'dosen@test.com',
            'password' => bcrypt('password'),
        ]);

        // 2. Buat Kategori
        $webCat = Category::create([
            'name' => 'Web Development',
            'slug' => 'web-development'
        ]);

        $designCat = Category::create([
            'name' => 'UI/UX Design',
            'slug' => 'ui-ux-design'
        ]);

        // 3. Buat Kursus Contoh
        Course::create([
            'category_id' => $webCat->id,
            'author_id' => $user->id,
            'title' => 'Belajar Laravel Dasar untuk UAS',
            'slug' => 'belajar-laravel-dasar-untuk-uas',
            'description' => 'Kursus ini membahas manajemen database di Laravel.',
            'price' => 50000,
            'level' => 'beginner',
            'is_published' => true,
        ]);

        Course::create([
            'category_id' => $designCat->id,
            'author_id' => $user->id,
            'title' => 'Mastering Figma 2026',
            'slug' => 'mastering-figma-2026',
            'description' => 'Belajar desain interface yang modern.',
            'price' => 75000,
            'level' => 'intermediate',
            'is_published' => true,
        ]);
    }
}
