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
        
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #050508; }
        ::-webkit-scrollbar-thumb { background: #1e1e2e; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #312e81; }
    </style>
</head>
<body class="pb-10 md:pb-20">
    <div class="glow-blob top-[-5%] right-[-5%] bg-indigo-600/30"></div>
    <div class="glow-blob bottom-[-5%] left-[-5%] bg-cyan-500/20"></div>

    <nav class="p-4 md:p-8">
        <div class="container mx-auto flex justify-between items-center px-2">
            {{-- Perbaikan: Route disesuaikan dengan web.php --}}
            <a href="{{ route('user.dashboard') }}" class="group flex items-center gap-2 md:gap-3 text-gray-400 hover:text-white transition-all">
                <div class="p-2 bg-white/5 rounded-xl group-hover:bg-indigo-500/20 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </div>
                <span class="text-[10px] md:text-xs font-black uppercase tracking-[0.2em] md:tracking-[0.3em]">Katalog Kursus</span>
            </a>

            <div class="flex items-center gap-4">
                <div class="hidden md:block text-right">
                    <p class="text-[10px] font-black uppercase tracking-widest text-indigo-400">Panel Belajar</p>
                    <p class="text-sm font-bold text-white/90">{{ Auth::user()->name }}</p>
                </div>
                {{-- Form Logout Simple --}}
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="p-2 bg-red-500/10 hover:bg-red-500/20 border border-red-500/20 rounded-xl transition-all group" title="Logout">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-400 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 md:px-8 mt-6 md:mt-10">
        <div class="mb-10 md:mb-16">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></div>
                <span class="text-indigo-400 font-black tracking-widest text-xs uppercase">EduIde Personal Learning</span>
            </div>
            <h2 class="text-4xl md:text-7xl font-extrabold tracking-tighter mb-4 bg-clip-text text-transparent bg-gradient-to-r from-white via-white to-white/30">
                Kursus Saya
            </h2>
            <p class="text-gray-500 text-[10px] md:text-xs tracking-[0.3em] uppercase font-black">
                {{ $courses->count() }} Modul dalam Progres
            </p>
        </div>

        @if($courses->isEmpty())
            <div class="glass-card rounded-[40px] p-12 md:p-24 text-center border-dashed border-white/10 flex flex-col items-center">
                <div class="w-20 h-20 bg-indigo-500/10 rounded-full flex items-center justify-center mb-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.232.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h3 class="text-xl md:text-3xl font-bold mb-4">Belum ada Kursus</h3>
                <p class="text-gray-500 text-sm mb-10 max-w-sm mx-auto">Ambil langkah pertama untuk menguasai teknologi masa depan sekarang juga.</p>
                <a href="{{ route('user.dashboard') }}" class="px-10 py-5 bg-white text-black rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-indigo-500 hover:text-white transition-all shadow-xl active:scale-95">
                    Cari Ide Sekarang
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($courses as $course)
                <div class="glass-card rounded-[40px] overflow-hidden p-8 flex flex-col group h-full">
                    <div class="flex justify-between items-start mb-10">
                        <div class="w-12 h-12 bg-white/5 rounded-2xl flex items-center justify-center border border-white/10 group-hover:border-indigo-500/50 transition-colors">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span class="text-[9px] font-black px-4 py-2 bg-emerald-500/10 text-emerald-400 rounded-full border border-emerald-500/20 uppercase tracking-widest">
                            Aktif
                        </span>
                    </div>

                    <h3 class="text-2xl font-bold mb-4 tracking-tight group-hover:text-indigo-400 transition-colors leading-tight">
                        {{ $course->title }}
                    </h3>
                    
                    <p class="text-gray-500 text-sm mb-8 line-clamp-2 leading-relaxed">
                        {{ $course->description }}
                    </p>

                    {{-- Progress Bar Statis (Hanya Visual) --}}
                    <div class="mb-8">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Progress</span>
                            <span class="text-[10px] font-bold text-indigo-400 uppercase">0%</span>
                        </div>
                        <div class="w-full h-1.5 bg-white/5 rounded-full overflow-hidden">
                            <div class="w-0 h-full bg-indigo-500 group-hover:w-full transition-all duration-1000"></div>
                        </div>
                    </div>

                    <div class="mt-auto flex flex-col gap-3">
                        <a href="{{ route('user.modules', $course->slug) }}" class="block w-full text-center py-5 bg-indigo-600 text-white rounded-[20px] text-[10px] font-black uppercase tracking-[0.2em] hover:bg-indigo-500 hover:shadow-[0_0_30px_rgba(79,70,229,0.3)] transition-all active:scale-95">
                            Buka Modul Pembelajaran
                        </a>
                        <a href="{{ route('user.show', $course->slug) }}" class="block w-full text-center py-3 bg-white/5 border border-white/10 text-white rounded-[16px] text-[10px] font-black uppercase tracking-[0.2em] hover:bg-white/10 transition-all active:scale-95">
                            Detail Kursus
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </main>
</body>
</html>