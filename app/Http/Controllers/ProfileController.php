<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Menampilkan profil user yang sedang login.
     */
    public function index()
    {
        // Ambil data user yang sedang login beserta jumlah kursus yang diambil
        $user = Auth::user()->loadCount('courses');

        return view('auth.profile', compact('user'));
    }
}
