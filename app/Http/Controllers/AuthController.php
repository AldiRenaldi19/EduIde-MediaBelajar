<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash, Password};
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Tampilan Register - Menampilkan form pendaftaran akun baru.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Proses Register - Validasi data dan pembuatan akun user baru.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        // Landing page setelah daftar: Dashboard Kursus
        return redirect()->route('user.dashboard');
    }

    /**
     * Tampilan Login - Menampilkan form masuk sistem.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Proses Login - Verifikasi kredensial dan inisialisasi sesi.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Login dengan fitur 'Remember Me' untuk kenyamanan user
        if (Auth::attempt($credentials, $request->remember)) {
            // Keamanan: Regenerasi ID sesi untuk mencegah Session Fixation
            $request->session()->regenerate();

            // Redirect ke halaman yang ingin dituju sebelumnya atau ke dashboard
            return redirect()->intended(route('user.dashboard'));
        }

        // Jika gagal, kembali dengan error pada field email
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan tidak sesuai.',
        ])->withInput($request->only('email'));
    }

    /**
     * Google OAuth - Redirect user ke halaman login Google.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Google Callback - Mengelola data user yang kembali dari Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cari user berdasarkan email, jika tidak ada buat baru (updateOrCreate)
            $user = User::updateOrCreate([
                'email' => $googleUser->email,
            ], [
                'name'              => $googleUser->name,
                'google_id'         => $googleUser->id,
                'avatar'            => $googleUser->avatar,
                'password'          => Hash::make(Str::random(24)), // Password random aman
                'email_verified_at' => now(),
            ]);

            Auth::login($user);
            return redirect()->route('user.dashboard');
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Terjadi kesalahan saat masuk dengan Google. Silakan coba lagi.'
            ]);
        }
    }

    /**
     * Lupa Password - Menampilkan form permintaan reset password.
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Kirim Reset Link - Mengirim email pemulihan ke pengguna.
     */
    public function handleForgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'Alamat email tidak ditemukan.'
        ]);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Link reset password telah dikirim ke email Anda.')
            : back()->withErrors(['email' => 'Gagal mengirim email pemulihan.']);
    }

    /**
     * Tampilan Reset Password - Form untuk memasukkan password baru.
     */
    public function showResetPassword($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    /**
     * Update Password - Menyimpan kata sandi baru ke database.
     */
    public function handleResetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Password berhasil diperbarui!')
            : back()->withErrors(['email' => 'Token reset sudah kadaluarsa atau tidak valid.']);
    }

    /**
     * Profil User - Menampilkan detail akun dan statistik belajar.
     */
    public function showProfile()
    {
        // Eager load count kursus untuk performa database
        $user = Auth::user()->loadCount('courses');
        return view('auth.profile', compact('user'));
    }

    /**
     * Proses Logout - Membersihkan sesi dan keluar dari sistem.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Membersihkan seluruh data sesi agar aman
        $request->session()->invalidate();

        // Menghapus token CSRF untuk sesi berikutnya
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
