<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Kata Sandi - EduIde</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center p-6 relative" style="background-color: var(--bg-page); color: var(--text-main);">
    <div class="glow-blob top-[-10%] left-[-10%] bg-indigo-600/40"></div>
    <div class="glow-blob bottom-[-10%] right-[-10%] bg-blue-500/30"></div>

    <div class="w-full max-w-md relative fade-in">
        {{-- Brand --}}
        <div class="text-center mb-10 flex flex-col items-center">
            <img src="{{ asset('favicon.ico') }}" alt="Logo" class="w-12 h-12 mb-4 rounded-xl shadow-lg shadow-indigo-500/20">
            <h1 class="text-3xl font-extrabold tracking-tighter">Edu<span class="text-indigo-400">Ide</span></h1>
        </div>

        <div class="glass-card rounded-[48px] p-10 md:p-12 shadow-2xl relative overflow-hidden">
            <h2 class="text-2xl font-bold mb-2 tracking-tight">Kata Sandi Baru</h2>
            <p class="text-gray-500 text-[11px] mb-8 leading-relaxed font-bold uppercase tracking-wider opacity-60">Silakan masukkan kata sandi baru untuk akun Anda.</p>

            <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
                @csrf
                
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-2 ml-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ request()->email }}" class="input-glass w-full px-6 py-4 rounded-2xl text-sm text-white/50 cursor-not-allowed" placeholder="nama@email.com" required readonly>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-2 ml-1">Kata Sandi Baru</label>
                    <input type="password" name="password" class="input-glass w-full px-6 py-4 rounded-2xl text-sm text-white placeholder-white/20" placeholder="••••••••" required autofocus>
                    @error('password') 
                        <p class="text-rose-500 text-[10px] mt-2 ml-1 font-bold italic uppercase">{{ $message }}</p> 
                    @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-2 ml-1">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" class="input-glass w-full px-6 py-4 rounded-2xl text-sm text-white placeholder-white/20" placeholder="••••••••" required>
                </div>

                <button type="submit" class="w-full bg-white text-black hover:bg-indigo-500 hover:text-white py-5 rounded-2xl font-black text-[10px] transition-all active:scale-[0.98] shadow-lg shadow-white/5 uppercase tracking-[0.2em]">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</body>
</html>