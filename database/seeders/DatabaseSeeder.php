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
        /**
         * 1. Buat user contoh (idempotent).
         *
         * Menggunakan updateOrCreate agar perintah db:seed bisa dijalankan
         * berulang kali tanpa memicu error duplicate email.
         */
        $user = User::updateOrCreate(
            ['email' => 'dosen@test.com'],
            [
                'name' => 'Dosen Penguji',
                'password' => bcrypt('password'),
            ]
        );

        /**
         * 2. Buat kategori (idempotent).
         */
        $webCat = Category::updateOrCreate(
            ['slug' => 'web-development'],
            ['name' => 'Web Development']
        );

        $designCat = Category::updateOrCreate(
            ['slug' => 'ui-ux-design'],
            ['name' => 'UI/UX Design']
        );

        /**
         * 3. Buat kursus contoh (idempotent).
         */
        Course::updateOrCreate(
            ['slug' => 'belajar-laravel-dasar-untuk-uas'],
            [
                'category_id' => $webCat->id,
                'author_id' => $user->id,
                'title' => 'Belajar Laravel Dasar untuk UAS',
                'description' => 'Kursus ini membahas manajemen database di Laravel.',
                'price' => 50000,
                'level' => 'beginner',
                'is_published' => true,
            ]
        );

        Course::updateOrCreate(
            ['slug' => 'mastering-figma-2026'],
            [
                'category_id' => $designCat->id,
                'author_id' => $user->id,
                'title' => 'Mastering Figma 2026',
                'description' => 'Belajar desain interface yang modern.',
                'price' => 75000,
                'level' => 'intermediate',
                'is_published' => true,
            ]
        );
    }
}
