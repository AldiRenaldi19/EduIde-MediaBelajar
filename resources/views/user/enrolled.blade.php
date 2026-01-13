<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kursus Saya - EduIde</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="pb-10 md:pb-20" style="background-color: var(--bg-page); color: var(--text-main);">
    {{-- Decorative Background --}}
    <div class="glow-blob top-[-5%] right-[-5%] bg-indigo-600/30"></div>
    <div class="glow-blob bottom-[-5%] left-[-5%] bg-cyan-500/20"></div>

    <x-navbar />

    <main class="container mx-auto px-4 md:px-8 mt-24 md:mt-32">
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
                @foreach($courses as $index => $course)
                <div class="glass-card rounded-[40px] overflow-hidden p-8 flex flex-col group h-full reveal" style="animation-delay: {{ $index * 100 }}ms">
                    <div class="relative aspect-video mb-8 overflow-hidden rounded-[24px] bg-white/5 border border-white/10 shimmer group-hover:scale-[1.02] transition-transform duration-500">
                        <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                        <div class="absolute top-4 right-4">
                            <span class="text-[9px] font-black px-4 py-2 bg-emerald-500/80 backdrop-blur-md text-white rounded-full border border-white/20 uppercase tracking-widest">
                                Aktif
                            </span>
                        </div>
                    </div>

                    <h3 class="text-2xl font-bold mb-4 tracking-tight group-hover:text-indigo-400 transition-colors leading-tight text-[var(--text-main)]">
                        {{ $course->title }}
                    </h3>
                    
                    <p class="text-[var(--text-muted)] text-sm mb-8 line-clamp-2 leading-relaxed">
                        {{ $course->description }}
                    </p>

                    {{-- Progress Bar Dinamis --}}
                    @php
                        $progress = $course->progress ?? 0;
                        $completedModules = $course->completed_modules ?? 0;
                        $totalModules = $course->total_modules ?? $course->modules_count ?? 0;
                        $progressLabel = $totalModules > 0 ? "{$completedModules}/{$totalModules} modul" : 'Belum ada modul';
                    @endphp
                    <div class="mb-8">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Progress</span>
                            <span class="text-[10px] font-bold text-indigo-400 uppercase">{{ $progress }}%</span>
                        </div>
                        <div class="w-full h-2 bg-white/5 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-indigo-500 to-cyan-400 transition-all duration-500 shadow-[0_0_10px_rgba(99,102,241,0.5)]"
                                 style="width: {{ $progress }}%; min-width: {{ $progress > 0 ? '8%' : '0%' }};">
                            </div>
                        </div>
                        <p class="text-[10px] text-gray-500 font-semibold mt-2 uppercase tracking-widest">{{ $progressLabel }}</p>
                    </div>

                    <div class="mt-auto flex flex-col gap-3">
                        <a href="{{ route('user.modules', $course->slug) }}" class="block w-full text-center py-5 btn-primary text-white rounded-[20px] text-[10px] font-black uppercase tracking-[0.2em] shadow-[0_0_30px_rgba(79,70,229,0.3)] hover:scale-[1.02] transition-all active:scale-95 btn-shine-effect">
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