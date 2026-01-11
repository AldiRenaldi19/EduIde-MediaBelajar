<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kursus Saya - EduIde</title>
    
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap');
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #050508; 
            color: #ffffff; 
            min-height: 100vh; 
            overflow-x: hidden; 
        }

        .glass-card { 
            background: rgba(255, 255, 255, 0.02); 
            backdrop-filter: blur(15px); 
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.08); 
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
        }

        .glass-card:hover { 
            background: rgba(255, 255, 255, 0.05); 
            transform: translateY(-8px); 
            border-color: rgba(99, 102, 241, 0.4); 
            box-shadow: 0 20px 40px rgba(0,0,0,0.4), 0 0 20px rgba(99, 102, 241, 0.1);
        }

        .glow-blob { 
            position: fixed; 
            width: 300px; 
            height: 300px; 
            filter: blur(80px); 
            border-radius: 50%; 
            z-index: -1; 
            opacity: 0.15; 
        }

        @media (min-width: 768px) { 
            .glow-blob { width: 600px; height: 600px; filter: blur(120px); } 
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #050508; }
        ::-webkit-scrollbar-thumb { background: #1e1e2e; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #312e81; }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;  
            overflow: hidden;
        }
    </style>
</head>
<body class="pb-10 md:pb-20">
    <div class="glow-blob top-[-5%] right-[-5%] bg-indigo-600/30"></div>
    <div class="glow-blob bottom-[-5%] left-[-5%] bg-cyan-500/20"></div>

    <nav class="p-4 md:p-8">
        <div class="container mx-auto flex justify-between items-center px-2">
            <a href="{{ route('courses.index') }}" class="group flex items-center gap-2 md:gap-3 text-gray-400 hover:text-white transition-all">
                <div class="p-2 bg-white/5 rounded-xl group-hover:bg-indigo-500/20 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </div>
                <span class="text-[10px] md:text-xs font-black uppercase tracking-[0.2em] md:tracking-[0.3em]">Kembali ke Katalog</span>
            </a>

            <div class="flex items-center gap-4">
                <div class="hidden md:block text-right">
                    <p class="text-[10px] font-black uppercase tracking-widest text-indigo-400">Panel Belajar</p>
                    <p class="text-sm font-bold text-white/90">{{ Auth::user()->name }}</p>
                </div>
                <div class="relative group cursor-pointer">
                    @if(Auth::user()->avatar)
                        <img src="{{ Auth::user()->avatar }}" class="w-10 h-10 md:w-12 md:h-12 rounded-2xl object-cover border-2 border-white/5 group-hover:border-indigo-500/50 transition-all shadow-lg">
                    @else
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-600 to-violet-700 rounded-2xl flex items-center justify-center font-black text-white shadow-lg border border-white/10 group-hover:scale-105 transition-transform">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endif
                    <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 border-4 border-[#050508] rounded-full shadow-sm"></div>
                </div>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 md:px-8 mt-6 md:mt-10">
        <div class="mb-10 md:mb-16 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('favicon.ico') }}" alt="Logo" class="w-8 h-8 opacity-90">
                    <span class="text-indigo-500 font-black tracking-widest text-xs uppercase">EduIde Personal Learning</span>
                </div>
                <h2 class="text-4xl md:text-6xl font-extrabold tracking-tighter mb-4 bg-clip-text text-transparent bg-gradient-to-r from-white to-gray-500">
                    Kursus Saya
                </h2>
                <div class="flex items-center gap-3">
                    <p class="text-gray-500 text-[10px] md:text-xs tracking-widest uppercase font-black">
                        {{ $courses->count() }} Modul Aktif
                    </p>
                    <div class="h-1 w-1 rounded-full bg-indigo-500/50"></div>
                    <p class="text-indigo-400 text-[10px] md:text-xs tracking-widest uppercase font-black">Cloud Sync Aktif</p>
                </div>
            </div>
        </div>

        @if($courses->isEmpty())
            <div class="glass-card rounded-[40px] p-12 md:p-24 text-center border-dashed border-white/10 flex flex-col items-center">
                <div class="w-20 h-20 md:w-24 md:h-24 bg-white/5 rounded-[32px] flex items-center justify-center mb-8 border border-white/5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.232.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h3 class="text-xl md:text-3xl font-bold mb-4 tracking-tight">Mulai Perjalanan Ide Anda</h3>
                <p class="text-gray-500 text-sm md:text-base mb-10 max-w-sm mx-auto leading-relaxed">Anda belum memiliki kursus yang terdaftar. Temukan ide baru di katalog kami.</p>
                <a href="{{ route('courses.index') }}" class="px-10 py-5 bg-white text-black rounded-2xl font-black text-[10px] md:text-xs uppercase tracking-[0.2em] hover:bg-indigo-500 hover:text-white transition-all shadow-2xl active:scale-95">
                    Jelajahi EduIde
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-10">
                @foreach($courses as $course)
                <div class="glass-card rounded-[38px] overflow-hidden p-8 flex flex-col group relative">
                    <div class="absolute -top-24 -right-24 w-48 h-48 bg-indigo-600/10 blur-[60px] rounded-full group-hover:bg-indigo-600/20 transition-all"></div>

                    <div class="flex justify-between items-start mb-8 relative z-10">
                        <span class="text-[9px] md:text-[10px] font-black px-4 py-1.5 bg-white/5 text-indigo-300 rounded-full border border-white/10 uppercase tracking-[0.15em]">
                            {{ $course->category->name ?? 'Materi' }}
                        </span>
                        <div class="flex gap-2 items-center bg-emerald-500/10 px-3 py-1.5 rounded-xl border border-emerald-500/20">
                            <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.6)]"></div>
                            <span class="text-[9px] font-black text-emerald-400 uppercase tracking-widest">Tersedia</span>
                        </div>
                    </div>

                    <h3 class="text-2xl md:text-3xl font-bold mb-4 tracking-tighter group-hover:text-indigo-400 transition-colors leading-tight">
                        {{ $course->title }}
                    </h3>
                    
                    <p class="text-gray-400 text-xs md:text-sm mb-10 line-clamp-2 font-medium opacity-70 leading-relaxed">
                        {{ $course->description }}
                    </p>

                    <div class="mt-auto flex items-center gap-4 relative z-10">
                        <a href="{{ route('courses.show', $course->slug ?? $course->id) }}" class="flex-grow text-center py-5 bg-indigo-600 text-white rounded-2xl text-[10px] md:text-xs font-black uppercase tracking-widest hover:bg-indigo-500 transition-all shadow-lg shadow-indigo-600/20 active:scale-95">
                            Lanjutkan Belajar
                        </a>
                        <a href="{{ route('courses.show', $course->slug ?? $course->id) }}" class="p-5 bg-white/5 border border-white/10 rounded-2xl group-hover:bg-indigo-500/10 group-hover:border-indigo-500/30 transition-all cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-hover:text-indigo-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </main>
</body>
</html>