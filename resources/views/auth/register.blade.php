<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - EduIde</title>
    
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap');
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #050508; 
            color: #ffffff; 
            overflow-x: hidden;
        }

        .glass-auth { 
            background: rgba(255, 255, 255, 0.02); 
            backdrop-filter: blur(30px); 
            -webkit-backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.08); 
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .input-glass { 
            background: rgba(255, 255, 255, 0.03); 
            border: 1px solid rgba(255, 255, 255, 0.08); 
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
        }

        .input-glass:focus { 
            border-color: rgba(99, 102, 241, 0.5); 
            background: rgba(99, 102, 241, 0.03); 
            outline: none; 
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.1); 
        }

        .glow-bg { 
            position: fixed; 
            width: 600px; 
            height: 600px; 
            filter: blur(150px); 
            border-radius: 50%; 
            z-index: -1; 
            opacity: 0.15; 
        }

        .fade-in { animation: fadeIn 0.6s ease-out forwards; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 relative">
    <div class="glow-bg top-[-20%] right-[-10%] bg-indigo-600"></div>
    <div class="glow-bg bottom-[-20%] left-[-10%] bg-violet-600"></div>

    <div class="fixed top-8 left-8 z-50">
        <a href="/" class="group flex items-center gap-3 bg-white/5 hover:bg-white/10 border border-white/10 px-6 py-3 rounded-2xl transition-all backdrop-blur-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-400 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span class="text-[11px] font-black uppercase tracking-[0.2em] text-gray-300">Batal</span>
        </a>
    </div>

    <div class="w-full max-w-lg mt-12 md:mt-0 fade-in">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold tracking-tighter">Edu<span class="text-indigo-500">Ide</span></h1>
            <p class="text-[10px] font-black uppercase tracking-[0.4em] text-gray-500 mt-2 opacity-60">Pendaftaran Akun Baru</p>
        </div>

        <div class="glass-auth rounded-[48px] p-10 md:p-12 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-indigo-500/20 to-transparent"></div>
            
            <h2 class="text-2xl font-bold mb-8 tracking-tight text-center">Bergabung Sekarang</h2>
            
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-2xl">
                    <p class="text-[10px] text-red-400 font-black uppercase tracking-widest mb-1">Terjadi Kesalahan</p>
                    <ul class="list-none">
                        @foreach ($errors->all() as $error)
                            <li class="text-[11px] text-red-200/60 leading-relaxed">• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="input-glass w-full px-6 py-4 rounded-2xl text-sm text-white placeholder-white/20" placeholder="Masukkan nama lengkap" required>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="input-glass w-full px-6 py-4 rounded-2xl text-sm text-white placeholder-white/20" placeholder="email@contoh.com" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">Password</label>
                        <input type="password" name="password" class="input-glass w-full px-6 py-4 rounded-2xl text-sm text-white placeholder-white/20" placeholder="••••••••" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">Ulangi</label>
                        <input type="password" name="password_confirmation" class="input-glass w-full px-6 py-4 rounded-2xl text-sm text-white placeholder-white/20" placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 py-5 rounded-2xl font-black text-[10px] transition-all active:scale-[0.98] shadow-xl shadow-indigo-600/20 text-white uppercase tracking-[0.2em] mt-4">
                    Buat Akun Sekarang
                </button>
            </form>

            <div class="relative my-10">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-white/5"></div></div>
                <div class="relative flex justify-center text-[9px] uppercase font-black tracking-[0.3em]"><span class="bg-[#050508] px-4 text-gray-600">Atau Daftar Dengan</span></div>
            </div>

            <a href="{{ route('google.login') }}" class="w-full flex items-center justify-center gap-3 bg-white/5 hover:bg-white/10 border border-white/10 py-4 rounded-2xl transition-all group active:scale-[0.98]">
                <svg class="w-4 h-4" viewBox="0 0 24 24">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 12 5.38z" fill="#EA4335"/>
                </svg>
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest group-hover:text-white transition-colors">Google Account</span>
            </a>
        </div>

        <p class="mt-8 text-center text-[10px] text-gray-500 font-bold tracking-[0.1em] uppercase">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300 transition-colors ml-1">Masuk Sekarang</a>
        </p>
    </div>
</body>
</html>