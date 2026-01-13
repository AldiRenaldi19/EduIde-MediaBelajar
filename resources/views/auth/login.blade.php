<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - EduIde</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center p-6 relative" style="background-color: var(--bg-page); color: var(--text-main);">
    
    <div class="glow-blob top-[-10%] left-[-5%] bg-indigo-600/40"></div>
    <div class="glow-blob bottom-[-10%] right-[-5%] bg-blue-500/30"></div>

    {{-- Back Button --}}
    <div class="fixed top-8 left-8 z-50">
        <a href="{{ url('/') }}" class="group flex items-center gap-3 bg-white/5 hover:bg-white/10 border border-white/10 px-6 py-3 rounded-2xl transition-all backdrop-blur-md">
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
            <p class="text-gray-500 text-[10px] font-bold uppercase tracking-[0.4em] mt-2 opacity-60">Pintu Menuju Ide Baru</p>
        </div>

        <div class="glass-card rounded-[40px] p-10 md:p-12 relative overflow-hidden">
            <h2 class="text-2xl font-bold mb-2 tracking-tight">Selamat Datang</h2>
            <p class="text-gray-500 text-xs mb-8">Silakan masuk untuk melanjutkan belajar.</p>
            
            {{-- Error Handling --}}
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-2xl">
                    <p class="text-[11px] text-red-400 leading-relaxed">{{ $errors->first() }}</p>
                </div>
            @endif
            
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-[10px] font-bold text-[var(--text-muted)] uppercase tracking-widest mb-2 ml-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" 
                        class="input-glass w-full px-6 py-4 rounded-2xl text-sm text-[var(--text-main)] placeholder-[var(--text-muted)]" 
                        placeholder="email@anda.com" required autofocus>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2 ml-1">
                        <label class="text-[10px] font-bold text-[var(--text-muted)] uppercase tracking-widest">Password</label>
                        <a href="{{ route('password.request') }}" class="text-[10px] text-indigo-400 font-bold hover:text-indigo-300 transition-colors">Lupa?</a>
                    </div>
                    <input type="password" name="password" 
                        class="input-glass w-full px-6 py-4 rounded-2xl text-sm text-[var(--text-main)] placeholder-[var(--text-muted)]" 
                        placeholder="••••••••" required>
                </div>

                <div class="flex items-center gap-3 ml-1">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember" class="text-[10px] font-bold text-[var(--text-muted)] uppercase tracking-widest cursor-pointer hover:text-[var(--text-main)]">Ingat saya</label>
                </div>

                <button type="submit" class="w-full bg-white text-black hover:bg-indigo-500 hover:text-white py-5 rounded-2xl font-black text-[10px] transition-all active:scale-[0.98] uppercase tracking-widest mt-4 shadow-lg shadow-white/5">
                    Masuk ke Platform
                </button>
            </form>

            <div class="relative my-10">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-white/5"></div></div>
                <div class="relative flex justify-center text-[9px] uppercase font-bold tracking-[0.3em]"><span class="bg-[#0b0b11] px-4 text-gray-600">Atau</span></div>
            </div>

            <a href="{{ route('google.login') }}" class="w-full flex items-center justify-center gap-3 bg-white/5 hover:bg-white/10 border border-white/10 py-4 rounded-2xl transition-all group">
                <svg class="w-4 h-4" viewBox="0 0 24 24">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 12 5.38z" fill="#EA4335"/>
                </svg>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest group-hover:text-white">Lanjut dengan Google</span>
            </a>
        </div>
        
        <p class="mt-8 text-center text-[10px] text-gray-500 font-bold tracking-widest uppercase">
            Belum punya akun? <a href="{{ route('register') }}" class="text-indigo-400 hover:text-indigo-300 ml-1">Daftar Sekarang</a>
        </p>
    </div>
</body>
</html>