<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel module_completions untuk mencatat progres modul per user.
     *
     * Struktur:
     * - user_id     : referensi ke users
     * - module_id   : referensi ke modules
     * - course_id   : redundansi ringan untuk query agregasi progres per kursus
     * - timestamps  : untuk audit/analitik waktu penyelesaian
     *
     * Constraint penting:
     * - unique(user_id, module_id) untuk mencegah duplikasi progres.
     */
    public function up(): void
    {
        Schema::create('module_completions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('module_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['user_id', 'module_id']);
            $table->index(['user_id', 'course_id']);
        });
    }

    /**
     * Drop tabel module_completions.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_completions');
    }
};
