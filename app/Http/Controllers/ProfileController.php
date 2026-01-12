<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Cloudinary\Api\Upload\UploadApi;

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

    /**
     * Menampilkan halaman edit profil.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('auth.edit-profile', compact('user'));
    }

    /**
     * Update data profil (nama, email, avatar).
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|max:255|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Jika ada upload avatar baru
        if ($request->hasFile('avatar')) {
            try {
                $uploadApi = new UploadApi();
                $upload = $uploadApi->upload(
                    $request->file('avatar')->getRealPath(),
                    ['folder' => 'eduide/avatars']
                );
                $validated['avatar'] = $upload['secure_url'];
            } catch (\Exception $e) {
                return back()->withErrors(['avatar' => 'Gagal upload avatar: ' . $e->getMessage()]);
            }
        }

        $user->update($validated);

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Menampilkan form ubah password.
     */
    public function showChangePassword()
    {
        return view('auth.change-password');
    }

    /**
     * Update password user.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password'         => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ], [
            'current_password.required' => 'Password saat ini harus diisi.',
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
            'password.required' => 'Password baru harus diisi.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.letters' => 'Password harus mengandung huruf.',
            'password.numbers' => 'Password harus mengandung angka.',
        ]);

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile')->with('success', 'Password berhasil diubah!');
    }
}
