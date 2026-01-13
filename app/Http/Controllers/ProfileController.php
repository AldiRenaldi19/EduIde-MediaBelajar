<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProfileController extends Controller
{
    /**
     * Menampilkan profil user yang sedang login.
     */
    public function index(): \Illuminate\View\View
    {
        // Ambil data user yang sedang login beserta jumlah kursus yang diambil
        $user = Auth::user()->loadCount('courses');

        return view('auth.profile', compact('user'));
    }

    /**
     * Menampilkan halaman edit profil.
     */
    public function edit(): \Illuminate\View\View
    {
        $user = Auth::user();
        return view('auth.edit-profile', compact('user'));
    }

    /**
     * Update data profil (nama, email, avatar).
     */
    public function update(UpdateProfileRequest $request): \Illuminate\Http\RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validated();

        // Jika ada upload avatar baru
        if ($request->hasFile('avatar')) {
            try {
                $cloud = app(\App\Services\CloudinaryClient::class);
                $result = $cloud->upload($request->file('avatar')->getRealPath(), [
                    'folder' => 'eduide/avatars'
                ]);
                $validated['avatar'] = $result['secure_url'] ?? $result['url'] ?? null;
            } catch (\Exception $e) {
                return back()->withErrors(['avatar' => 'Gagal upload avatar: ' . $e->getMessage()]);
            }
        }

        // Jika email berubah, reset status verifikasi
        if ($request->email !== $user->email) {
            $validated['email_verified_at'] = null;
        }

        $user->update($validated);

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Menampilkan form ubah password.
     */
    public function showChangePassword(): \Illuminate\View\View
    {
        return view('auth.change-password');
    }

    /**
     * Update password user.
     */
    public function updatePassword(Request $request): \Illuminate\Http\RedirectResponse
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
