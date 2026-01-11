<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel categories (Foreign Key)
            $table->foreignId('category_id')->constrained()->onDelete('cascade');

            // Relasi ke tabel users sebagai pengajar/instruktur
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');

            $table->string('title');
            $table->string('slug')->unique(); // Bagus untuk SEO & URL rapi
            $table->text('description');
            $table->string('thumbnail')->nullable(); // Simpan path gambar kursus
            $table->integer('price')->default(0); // 0 jika gratis
            $table->enum('level', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
