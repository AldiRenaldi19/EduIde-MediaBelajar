<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - EduIde</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap');
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #050508; 
            color: #ffffff; 
            overflow: hidden; 
        }

        .glass-auth { 
            background: rgba(255, 255, 255, 0.02); 
            backdrop-filter: blur(30px); 
            -webkit-backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.08); 
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
        }

        .input-glass { 
            background: rgba(255, 255, 255, 0.03); 
            border: 1px solid rgba(255, 255, 255, 0.08); 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
        }

        .input-glass:focus { 
            border-color: rgba(99, 102, 241, 0.5); 
            background: rgba(99, 102, 241, 0.03); 
            outline: none; 
            box-shadow: 0 0 25px rgba(99, 102, 241, 0.1); 
        }

        .glow-blob { 
            position: fixed; 
            width: 500px; 
            height: 500px; 
            filter: blur(120px); 
            border-radius: 50%; 
            z-index: -1; 
            opacity: 0.15; 
        }

        /* Custom Checkbox */
        input[type="checkbox"] {
            appearance: none;
            background-color: rgba(255, 255, 255, 0.05);
            width: 1.2rem;
            height: 1.2rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 6px;
            display: grid;
            place-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        input[type="checkbox"]:checked {
            border-color: #6366f1;
            background-color: rgba(99, 102, 241, 0.1);
        }

        input[type="checkbox"]::before {
            content: "";
            width: 0.65rem;
            height: 0.65rem;
            transform: scale(0);
            transition: 120ms transform ease-in-out;
            box-shadow: inset 1em 1em #6366f1;
            clip-path: polygon(14% 44%, 0 65%, 50% 100%, 100% 16%, 80% 0%, 43% 62%);
        }

        input[type="checkbox"]:checked::before { transform: scale(1); }

        /* Animation */
        .fade-in { animation: fadeIn 0.8s ease-out forwards; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 relative">
    
    <div class="glow-blob top-[-10%] left-[-5%] bg-indigo-600/40"></div>
    <div class="glow-blob bottom-[-10%] right-[-5%] bg-blue-500/30"></div>

    <div class="fixed top-8 left-8 z-50">
        <a href="/" class="group flex items-center gap-3 bg-white/5 hover:bg-white/10 border border-white/10 px-6 py-3 rounded-2xl transition-all backdrop-blur-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-400 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span class="text-[11px] font-black uppercase tracking-[0.2em] text-gray-300">Kembali</span>
        </a>
    </div>

    <div class="w-full max-w-md relative fade-in">
        <div class="text-center mb-10">
            <div class="inline-flex items-center gap-3 mb-4 p-3 bg-white/5 rounded-[20px] border border-white/5 shadow-inner">
                <img src="{{ asset('favicon.ico') }}" alt="EduIde Logo" class="w-8 h-8">
            </div>
            <h1 class="text-3xl font-extrabold tracking-tighter">Edu<span class="text-indigo-500">Ide</span></h1>
            <p class="text-gray-500 text-[10px] font-black uppercase tracking-[0.4em] mt-2 opacity-60">Pintu Menuju Ide Baru</p>
        </div>

        <div class="glass-auth rounded-[48px] p-10 md:p-12 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-indigo-500/20 to-transparent"></div>

            <h2 class="text-2xl font-bold mb-2 tracking-tight">Selamat Datang</h2>
            <p class="text-gray-500 text-xs mb-8">Silakan masuk untuk melanjutkan akses materi.</p>
            
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-2xl">
                    <div class="flex items-center gap-2 mb-1">
                        <div class="w-1.5 h-1.5 rounded-full bg-red-500"></div>
                        <p class="text-[10px] text-red-400 font-black uppercase tracking-widest">Gagal Masuk</p>
                    </div>
                    <p class="text-[11px] text-red-200/60 leading-relaxed">{{ $errors->first() }}</p>
                </div>
            @endif
            
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-2 ml-1">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" 
                        class="input-glass w-full px-6 py-4 rounded-2xl text-sm text-white placeholder-white/20" 
                        placeholder="nama@email.com" required autofocus>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2 ml-1">
                        <label class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">Password</label>
                        <a href="{{ route('password.request') }}" class="text-[10px] text-indigo-400 font-bold hover:text-indigo-300 transition-colors">Lupa Password?</a>
                    </div>
                    <input type="password" name="password" 
                        class="input-glass w-full px-6 py-4 rounded-2xl text-sm text-white placeholder-white/20" 
                        placeholder="••••••••" required>
                </div>

                <div class="flex items-center gap-3 ml-1">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember" class="text-[10px] font-black text-gray-500 uppercase tracking-[0.1em] cursor-pointer hover:text-gray-400 transition-colors">Ingat akun saya</label>
                </div>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 py-5 rounded-2xl font-black text-[10px] transition-all active:scale-[0.98] shadow-xl shadow-indigo-600/20 text-white uppercase tracking-[0.2em] mt-4">
                    Masuk ke Platform
                </button>
            </form>

            <div class="relative my-10">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-white/5"></div></div>
                <div class="relative flex justify-center text-[9px] uppercase font-black tracking-[0.3em]"><span class="bg-[#050508] px-4 text-gray-600">Opsi Lain</span></div>
            </div>

            <a href="{{ route('google.login') }}" class="w-full flex items-center justify-center gap-3 bg-white/5 hover:bg-white/10 border border-white/10 py-4 rounded-2xl transition-all group active:scale-[0.98]">
                <svg class="w-4 h-4" viewBox="0 0 24 24">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 12 5.38z" fill="#EA4335"/>
                </svg>
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest group-hover:text-white transition-colors">Lanjut dengan Google</span>
            </a>
        </div>
        
        <p class="mt-8 text-center text-[10px] text-gray-500 font-bold tracking-[0.1em] uppercase">
            Belum memiliki akses? 
            <a href="{{ route('register') }}" class="text-indigo-400 hover:text-indigo-300 transition-colors ml-1">Daftar Akun Baru</a>
        </p>
    </div>
</body>
</html>