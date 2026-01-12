<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - EduIde</title>

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

        .glass-card { 
            background: rgba(255, 255, 255, 0.02); 
            backdrop-filter: blur(20px); 
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08); 
        }

        .profile-gradient {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        }

        .glow {
            position: fixed;
            width: 600px;
            height: 600px;
            filter: blur(120px);
            border-radius: 50%;
            z-index: -1;
            opacity: 0.15;
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.01);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            background: rgba(255, 255, 255, 0.03);
            border-color: rgba(99, 102, 241, 0.3);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 relative">
    
    <div class="glow top-[-10%] left-[-10%] bg-indigo-600"></div>
    <div class="glow bottom-[-10%] right-[-10%] bg-blue-500"></div>

    <div class="w-full max-w-2xl glass-card rounded-[40px] p-8 md:p-14 relative shadow-2xl">
        <div class="flex justify-center mb-10">
            <div class="flex items-center gap-3 bg-white/5 px-5 py-2 rounded-2xl border border-white/10">
                <img src="{{ asset('favicon.ico') }}" class="w-4 h-4 opacity-80" alt="Icon">
                <span class="text-[10px] font-bold tracking-[0.3em] uppercase text-indigo-400">EduIde Learner Profile</span>
            </div>
        </div>

        <div class="flex flex-col md:flex-row items-center gap-8 mb-12">
            <div class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-[36px] blur opacity-25 group-hover:opacity-50 transition duration-1000"></div>
                @if(auth()->user()->avatar)
                    <img src="{{ auth()->user()->avatar }}" class="relative w-32 h-32 rounded-[32px] object-cover border-2 border-white/10 shadow-2xl">
                @else
                    <div class="relative w-32 h-32 rounded-[32px] profile-gradient flex items-center justify-center text-4xl font-extrabold text-white shadow-2xl">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endif
                <div class="absolute -bottom-2 -right-2 w-7 h-7 bg-emerald-500 border-4 border-[#0a0a0f] rounded-full shadow-lg"></div>
            </div>

            <div class="text-center md:text-left">
                <h2 class="text-4xl font-extrabold tracking-tight mb-2 text-white">{{ auth()->user()->name }}</h2>
                <p class="text-gray-500 text-sm font-medium mb-4 italic opacity-80">"Terus belajar, terus tumbuh bersama EduIde."</p>
                <div class="flex items-center justify-center md:justify-start gap-3">
                    <span class="px-3 py-1 bg-white/5 border border-white/10 rounded-lg text-[10px] font-black text-indigo-300 uppercase tracking-tighter">
                        UID-{{ str_pad(auth()->user()->id, 4, '0', STR_PAD_LEFT) }}
                    </span>
                    @if(auth()->user()->is_admin)
                        <span class="px-3 py-1 bg-indigo-500/10 border border-indigo-500/20 rounded-lg text-[10px] font-black text-indigo-400 uppercase tracking-widest">Administrator</span>
                    @else
                        <span class="px-3 py-1 bg-emerald-500/10 border border-emerald-500/20 rounded-lg text-[10px] font-black text-emerald-400 uppercase tracking-widest">Siswa</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-10">
            <div class="stat-card p-6 rounded-[24px]">
                <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest block mb-1">Email Account</span>
                <span class="text-sm text-gray-200 font-semibold break-all">{{ auth()->user()->email }}</span>
            </div>
            <div class="stat-card p-6 rounded-[24px]">
                <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest block mb-1">Materi Terdaftar</span>
                <span class="text-sm text-gray-200 font-semibold">{{ auth()->user()->courses()->count() }} Modul Belajar</span>
            </div>
        </div>

        <div class="space-y-3">
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('profile.edit') }}" class="py-4 bg-indigo-600 hover:bg-indigo-500 text-white text-center rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all shadow-xl shadow-indigo-600/20 active:scale-95">
                    ✏️ Edit Profil
                </a>
                <a href="{{ route('password.change') }}" class="py-4 bg-amber-600/20 hover:bg-amber-600/30 text-amber-300 text-center rounded-2xl text-[10px] font-black uppercase tracking-widest border border-amber-600/30 transition-all active:scale-95">
                    🔒 Ubah Password
                </a>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('user.enrolled') }}" class="py-4 bg-white/5 hover:bg-white/10 text-white text-center rounded-2xl text-[10px] font-black uppercase tracking-widest border border-white/10 transition-all active:scale-95">
                    Materi Saya
                </a>
                <a href="{{ route('user.dashboard') }}" class="py-4 bg-white/5 hover:bg-white/10 text-white text-center rounded-2xl text-[10px] font-black uppercase tracking-widest border border-white/10 transition-all active:scale-95">
                    Katalog
                </a>
            </div>

            @if(auth()->user()->is_admin)
                <a href="{{ route('admin.dashboard') }}" class="block w-full py-4 bg-indigo-500/10 hover:bg-indigo-500/20 text-indigo-400 text-center rounded-2xl text-[10px] font-black uppercase tracking-widest border border-indigo-500/20 transition-all">
                    Dashboard Admin
                </a>
            @endif

            <form action="{{ route('logout') }}" method="POST" class="pt-4">
                @csrf
                <button type="submit" class="w-full py-4 text-red-500/40 hover:text-red-500 text-[10px] font-black uppercase tracking-[0.2em] transition-colors">
                    Log out from session
                </button>
            </form>
        </div>

        <div class="mt-10 text-center">
            <a href="{{ route('user.dashboard') }}" class="text-[10px] text-gray-600 hover:text-indigo-400 transition-colors uppercase font-bold tracking-[0.3em]">
                ← Back to Dashboard
            </a>
        </div>
    </div>
</body>
</html>