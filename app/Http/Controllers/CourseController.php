<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        // Load 'students' (bukan 'users') agar sinkron dengan Model
        $query = Course::with(['category', 'students'])->where('is_published', true);

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $courses = $query->get();
        $categories = Category::all();

        return view('courses.index', compact('courses', 'categories'));
    }

    public function show($slug)
    {
        $course = Course::with(['category', 'modules'])->where('slug', $slug)->firstOrFail();
        return view('courses.show', compact('course'));
    }

    public function enroll(Course $course)
    {
        $user = Auth::user();
        // Pastikan model User juga punya relasi courses() yang mengarah ke tabel 'enrollments'
        $user->courses()->syncWithoutDetaching([$course->id]);

        return back()->with('status', 'Pendaftaran berhasil.');
    }

    public function myCourses()
    {
        $courses = Auth::user()->courses()->with('category')->get();
        return view('courses.my', compact('courses'));
    }
}
