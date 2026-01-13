<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modul - {{ $course->title }} | EduIde</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen relative" style="background-color: var(--bg-page); color: var(--text-main);">
    <x-navbar />
    
    <div class="glow-blob top-20 right-0 bg-indigo-600/10"></div>

    <div class="container mx-auto px-6 pt-20 pb-16 md:pt-28 md:pb-24">
        {{-- Course Header --}}
        <div class="mb-12 reveal">
            <div class="mb-6 flex items-start gap-6">
                <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}" 
                     class="w-24 h-24 md:w-32 md:h-32 rounded-[20px] object-cover border border-white/10 shadow-xl shimmer">
                
                <div class="flex-grow">
                    <p class="text-indigo-400 text-sm font-black uppercase tracking-widest mb-2">📚 Modul Pembelajaran</p>
                    <h1 class="text-3xl md:text-5xl font-black tracking-tight mb-3">{{ $course->title }}</h1>
                    <p class="text-gray-400 text-sm md:text-base max-w-xl leading-relaxed mb-4">{{ $course->description }}</p>
                    
                    <div class="flex flex-wrap items-center gap-4 text-sm font-bold opacity-60">
                        <span class="flex items-center gap-2 text-gray-400 uppercase tracking-widest text-[10px]">
                            {{ $modules->count() }} Modul
                        </span>
                        <span class="flex items-center gap-2 text-emerald-400 uppercase tracking-widest text-[10px]">
                            Tersedia
                        </span>
                        @if($course->level)
                            <span class="flex items-center gap-2 text-amber-500 uppercase tracking-widest text-[10px]">
                                {{ ucfirst($course->level) }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Modules Grid --}}
        <div class="mb-8">
            <h2 class="text-xs font-black uppercase tracking-[0.3em] mb-6 text-indigo-400 flex items-center gap-3 reveal" style="animation-delay: 100ms">
                <span class="w-8 h-[1px] bg-indigo-500/30"></span> Daftar Modul
            </h2>

            @if($modules->isEmpty())
                <div class="glass-card rounded-[32px] p-12 text-center border border-dashed border-white/10 reveal">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-700 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.232.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <h3 class="text-xl font-bold mb-2">Belum ada Modul</h3>
                    <p class="text-gray-400">Instruktur sedang mempersiapkan konten pembelajaran.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($modules as $index => $mod)
                        <a href="{{ route('user.learn', [$course->slug, $mod->id]) }}" 
                           class="module-card glass-card rounded-[24px] p-6 md:p-8 border border-white/10 group reveal btn-shine-effect" 
                           style="animation-delay: {{ 200 + ($index * 100) }}ms">
                            
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
                            <p class="text-gray-400 text-sm mb-6 line-clamp-2 opacity-80">
                                {{ Str::limit(strip_tags($mod->content), 100) }}
                            </p>

                            {{-- Meta Info --}}
                            <div class="flex items-center gap-4 text-[9px] font-black uppercase tracking-widest text-gray-600 pt-4 border-t border-white/5">
                                <span class="flex items-center gap-1">
                                    Materi Video
                                </span>
                                <span class="flex items-center gap-1 text-indigo-400">
                                    Gratis Akses
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
