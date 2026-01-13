<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - EduIde</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center p-6 relative" style="background-color: var(--bg-page); color: var(--text-main);">
    
    <div class="glow-blob top-[-10%] left-[-5%] bg-indigo-600/40"></div>
    <div class="glow-blob bottom-[-10%] right-[-5%] bg-blue-500/30"></div>

    {{-- Back Button --}}
    <div class="fixed top-8 left-8 z-50">
        <a href="{{ route('login') }}" class="group flex items-center gap-3 bg-white/5 hover:bg-white/10 border border-white/10 px-6 py-3 rounded-2xl transition-all backdrop-blur-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-400 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span class="text-[10px] font-bold uppercase tracking-widest text-gray-300">Kembali</span>
        </a>
    </div>

    <div class="w-full max-w-md relative fade-in">
        {{-- Brand --}}
        <div class="text-center mb-10 flex flex-col items-center">
            <img src="{{ asset('favicon.ico') }}" alt="Logo" class="w-12 h-12 mb-4 rounded-xl shadow-lg shadow-indigo-500/20">
            <h1 class="text-3xl font-extrabold tracking-tighter">Edu<span class="text-indigo-400">Ide</span></h1>
            <p class="text-gray-500 text-[10px] font-bold uppercase tracking-[0.4em] mt-2 opacity-60">Reset Akses Akun</p>
        </div>

        <div class="glass-card rounded-[40px] p-10 md:p-12 relative overflow-hidden">
            <h2 class="text-2xl font-bold mb-2 tracking-tight">Lupa Password?</h2>
            <p class="text-gray-500 text-xs mb-8">Masukkan email Anda untuk menerima link reset password.</p>
            
            @if (session('status'))
                <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl">
                    <p class="text-[11px] text-emerald-400 leading-relaxed font-bold uppercase tracking-wider">{{ session('status') }}</p>
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-[10px] font-bold text-[var(--text-muted)] uppercase tracking-widest mb-2 ml-1">Email Terdaftar</label>
                    <input type="email" name="email" value="{{ old('email') }}" 
                        class="input-glass w-full px-6 py-4 rounded-2xl text-sm text-[var(--text-main)] placeholder-[var(--text-muted)] border border-white/5" 
                        placeholder="email@anda.com" required autofocus>
                    @error('email')
                        <p class="text-rose-500 text-[10px] mt-2 ml-1 font-bold italic uppercase">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-white text-black hover:bg-indigo-500 hover:text-white py-5 rounded-2xl font-black text-[10px] transition-all active:scale-[0.98] uppercase tracking-widest mt-4 shadow-lg shadow-white/5">
                    Kirim Link Instruksi
                </button>
            </form>
        </div>
        
        <p class="mt-8 text-center text-[10px] text-gray-500 font-bold tracking-widest uppercase">
            Ingat password? <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300 ml-1">Masuk Kembali</a>
        </p>
    </div>
</body>
</html>