<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    CourseController,
    AuthController,
    AdminController,
    ReviewController,
    ModuleController,
    ProfileController
};
use App\Models\Review;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Landing Page - Mengambil 6 ulasan terbaru untuk ditampilkan di slider testimoni di welcome.blade.php
Route::get('/', function () {
    $reviews = Review::latest()->take(6)->get();
    return view('welcome', compact('reviews'));
})->name('home');

// Katalog Kursus User - Menampilkan dashboard katalog kursus dari folder views/user/dashboard.blade.php
Route::get('/user', [CourseController::class, 'dashboard'])->name('user.dashboard');

// Detail Kursus User - Menampilkan detail kursus dari folder views/user/show.blade.php
Route::get('/user/{slug}', [CourseController::class, 'show'])->name('user.show');

/*
|--------------------------------------------------------------------------
| Authentication Routes (Guest Only)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    // Registrasi - Menampilkan views/auth/register.blade.php
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Masuk - Menampilkan views/auth/login.blade.php
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Lupa Password - Proses reset password menggunakan views/auth/forgot-password & reset-password
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'handleForgotPassword'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'handleResetPassword'])->name('password.update');

    // Google Login - Integrasi OAuth login pihak ketiga
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
});

/*
|--------------------------------------------------------------------------
| Authenticated User Routes (Siswa & Admin)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Logout - Menghapus sesi login user
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Profil - Menampilkan views/auth/profile.blade.php
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/change-password', [ProfileController::class, 'showChangePassword'])->name('password.change');
    Route::put('/profile/change-password', [ProfileController::class, 'updatePassword'])->name('password.store');

    // Kursus Terdaftar - Menampilkan views/user/enrolled.blade.php
    Route::get('/my-courses', [CourseController::class, 'myCourses'])->name('user.enrolled');

    // Enroll - Proses mendaftar ke kursus secara langsung
    Route::post('/user/{course}/enroll', [CourseController::class, 'enroll'])->name('user.enroll');

    // Module Learning - Halaman pembelajaran modul
    Route::get('/user/{courseSlug}/modules', [ModuleController::class, 'index'])->name('user.modules');
    Route::get('/user/{courseSlug}/learn/{moduleId}', [ModuleController::class, 'learn'])->name('user.learn');

    // Ulasan - Mengirim pesan testimoni dari Landing Page
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Restricted Area)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin - Statistik platform di views/admin/dashboard.blade.php
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Moderasi Review - Menghapus testimoni yang tidak diinginkan
    Route::delete('/reviews/{id}', [AdminController::class, 'deleteReview'])->name('reviews.delete');

    // Manajemen Kursus (CRUD) - Mengelola kursus via views/admin/course-form.blade.php
    Route::controller(AdminController::class)->group(function () {
        Route::get('/courses/create', 'createCourse')->name('courses.create');
        Route::post('/courses/store', 'storeCourse')->name('courses.store');
        Route::get('/courses/{id}/edit', 'editCourse')->name('courses.edit');
        Route::put('/courses/{id}', 'updateCourse')->name('courses.update');
        Route::delete('/courses/{id}', 'deleteCourse')->name('courses.delete');
    });
});
