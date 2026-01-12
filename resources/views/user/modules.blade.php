<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modul - {{ $course->title }} | EduIde</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap');
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #050508; 
            color: #ffffff;
        }

        .glass-nav {
            background: rgba(10, 10, 15, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .module-card {
            transition: all 0.3s ease;
        }

        .module-card:hover {
            transform: translateY(-4px);
            background: rgba(79, 70, 229, 0.15);
            border-color: rgb(79, 70, 229);
        }
    </style>
</head>
<body class="min-h-screen">
    {{-- Navigation Top --}}
    <nav class="glass-nav sticky top-0 z-50">
        <div class="container mx-auto px-4 md:px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('user.enrolled') }}" class="flex items-center gap-2 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="text-sm font-bold text-gray-400 group-hover:text-white transition-colors">Kembali ke Kursus Saya</span>
                </a>

                @auth
                    <a href="{{ route('profile') }}" class="p-2 rounded-lg bg-white/5 hover:bg-white/10 border border-white/10 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 md:px-6 py-12 md:py-16">
        {{-- Course Header --}}
        <div class="mb-12">
            <div class="mb-6 flex items-start gap-6">
                <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}" 
                     class="w-24 h-24 md:w-32 md:h-32 rounded-[20px] object-cover border border-white/10 shadow-xl">
                
                <div class="flex-grow">
                    <p class="text-indigo-400 text-sm font-black uppercase tracking-widest mb-2">📚 Modul Pembelajaran</p>
                    <h1 class="text-3xl md:text-5xl font-black tracking-tight mb-3">{{ $course->title }}</h1>
                    <p class="text-gray-400 text-sm md:text-base max-w-xl leading-relaxed mb-4">{{ $course->description }}</p>
                    
                    <div class="flex flex-wrap items-center gap-4 text-sm">
                        <span class="flex items-center gap-2 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M7 3a1 1 0 000 2h1a1 1 0 100-2H7zM4 7a1 1 0 012 0v1a1 1 0 11-2 0V7zM14 3a1 1 0 000 2h1a1 1 0 100-2h-1zM17 7a1 1 0 012 0v1a1 1 0 11-2 0V7zM7 14a1 1 0 100 2h1a1 1 0 100-2H7zM4 14a1 1 0 012 0v1a1 1 0 11-2 0v-1z" />
                            </svg>
                            {{ $modules->count() }} Modul
                        </span>
                        <span class="flex items-center gap-2 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12s4.477 10 10 10 10-4.484 10-10S17.523 2 12 2zm3.707 8.207a1 1 0 00-1.414-1.414L11 9.586 9.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l3-3z" clip-rule="evenodd" />
                            </svg>
                            Tersedia
                        </span>
                        @if($course->level)
                            <span class="flex items-center gap-2 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                {{ ucfirst($course->level) }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Modules Grid --}}
        <div class="mb-8">
            <h2 class="text-2xl font-black uppercase tracking-wider mb-6 text-white">
                <span class="w-1 h-8 bg-indigo-500 inline-block mr-4"></span> Daftar Modul
            </h2>

            @if($modules->isEmpty())
                <div class="glass-card rounded-[32px] p-12 text-center border border-dashed border-white/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-700 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.232.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <h3 class="text-xl font-bold mb-2">Belum ada Modul</h3>
                    <p class="text-gray-400">Instruktur sedang mempersiapkan konten pembelajaran.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($modules as $mod)
                        <a href="{{ route('user.learn', [$course->slug, $mod->id]) }}" 
                           class="module-card glass-card rounded-[24px] p-6 md:p-8 border border-white/10 group">
                            
                            {{-- Module Number Badge --}}
                            <div class="flex items-center justify-between mb-4">
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-[12px] bg-indigo-600/20 border border-indigo-500/30 text-indigo-300 font-black text-sm">
                                    {{ $mod->order }}
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 group-hover:text-indigo-400 group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>

                            {{-- Module Title --}}
                            <h3 class="text-lg md:text-xl font-bold mb-3 group-hover:text-indigo-400 transition-colors line-clamp-2">
                                {{ $mod->title }}
                            </h3>

                            {{-- Module Preview --}}
                            <p class="text-gray-400 text-sm mb-6 line-clamp-2">
                                {{ Str::limit(strip_tags($mod->content), 100) }}
                            </p>

                            {{-- Meta Info --}}
                            <div class="flex items-center gap-4 text-xs text-gray-500 pt-4 border-t border-white/5">
                                <span class="flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd" />
                                    </svg>
                                    15 menit
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                    Akses Penuh
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Back Button --}}
        <div class="text-center pt-8 border-t border-white/10">
            <a href="{{ route('user.enrolled') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-white/5 hover:bg-white/10 border border-white/10 rounded-[20px] font-bold uppercase tracking-wider text-sm transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Kursus Saya
            </a>
        </div>
    </div>
</body>
</html>
