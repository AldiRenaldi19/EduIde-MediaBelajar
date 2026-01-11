<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReviewController;
use App\Models\Review;

// 1. Landing Page
Route::get('/', function () {
    $reviews = Review::latest()->take(6)->get();
    return view('welcome', compact('reviews'));
})->name('home');

// 2. Katalog & Detail Kursus (Public)
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
// Menggunakan slug agar URL lebih SEO friendly
Route::get('/course/{slug}', [CourseController::class, 'show'])->name('courses.show');

// 3. Auth Routes (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Lupa Password (Kirim Link)
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'handleForgotPassword'])->name('password.email');

    // Reset Password (Update Data)
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'handleResetPassword'])->name('password.update');

    // Google Login
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
});

// 4. Logout (Harus Auth)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// 5. User Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile');
    Route::get('/my-courses', [CourseController::class, 'myCourses'])->name('courses.my');
    Route::post('/course/{course}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

// 6. Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Dashboard Utama
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Moderasi Ulasan
    Route::delete('/reviews/{id}', [AdminController::class, 'deleteReview'])->name('admin.reviews.delete');

    // Manajemen Kursus (CRUD)
    Route::get('/courses/create', [AdminController::class, 'createCourse'])->name('admin.courses.create');
    Route::post('/courses/store', [AdminController::class, 'storeCourse'])->name('admin.courses.store');
    Route::get('/courses/{id}/edit', [AdminController::class, 'editCourse'])->name('admin.courses.edit');
    Route::put('/courses/{id}', [AdminController::class, 'updateCourse'])->name('admin.courses.update');
    Route::delete('/courses/{id}', [AdminController::class, 'deleteCourse'])->name('admin.courses.delete');
});
