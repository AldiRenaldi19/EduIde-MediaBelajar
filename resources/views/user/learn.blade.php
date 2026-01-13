<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $module->title }} — {{ $course->title }}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Plyr Video Player CSS -->
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
</head>
<body class="h-screen flex flex-col md:flex-row overflow-hidden" style="background-color: var(--bg-page); color: var(--text-main);">

    <!-- Scroll Progress Bar -->
    <div class="fixed top-0 left-0 h-[3px] bg-gradient-to-r from-indigo-600 via-indigo-400 to-cyan-400 z-[100] transition-all duration-150 ease-out"
         :style="'width: ' + scrollPercent + '%'"
         x-data="{ scrollPercent: 0 }"
         @scroll.window="scrollPercent = (window.pageYOffset / (document.documentElement.scrollHeight - window.innerHeight)) * 100">
    </div>

    <x-toast />

    <!-- Sidebar: Daftar Modul -->
    <aside class="w-full md:w-80 border-r border-white/5 flex flex-col h-[30vh] md:h-full z-20 reveal" style="background-color: var(--bg-sidebar);">
        <div class="p-5 border-b border-white/10" style="background-color: var(--bg-sidebar);">
            <a href="{{ route('user.show', $course->slug) }}" class="flex items-center gap-2 text-[10px] font-bold text-gray-400 hover:text-indigo-400 uppercase tracking-widest mb-3 block transition-colors group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 group-hover:-translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Kembali
            </a>
            <h2 class="text-sm font-bold leading-tight text-white">{{ $course->title }}</h2>
            <div class="mt-1 text-[10px] text-gray-500 uppercase tracking-wider font-bold opacity-60">{{ $modules->count() }} Materi</div>
        </div>
        
        <div class="flex-1 overflow-y-auto p-2 space-y-1">
            @foreach($modules as $mod)
                <a href="{{ route('user.learn', [$course->slug, $mod->id]) }}" 
                   class="block p-4 rounded-xl border transition-all group {{ $mod->id == $module->id ? 'bg-indigo-600 border-indigo-500 text-white shadow-lg shadow-indigo-500/20' : 'bg-transparent border-transparent text-gray-400 hover:bg-white/5 hover:text-gray-200' }}">
                    <div class="flex items-start gap-3">
                        <span class="flex-shrink-0 flex items-center justify-center w-5 h-5 rounded {{ $mod->id == $module->id ? 'bg-white/20 text-white' : 'bg-white/5 text-gray-500 group-hover:bg-white/10' }} text-[10px] font-bold">
                            {{ $mod->order }}
                        </span>
                        <span class="text-xs font-bold leading-relaxed">{{ $mod->title }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </aside>

    <!-- Main Content: Area Belajar -->
    <main class="flex-1 flex flex-col h-[70vh] md:h-full relative" style="background-color: var(--bg-page);">
        <!-- Top Navigation Bar -->
        <header class="h-14 border-b border-white/5 flex items-center justify-between px-6 md:px-8 flex-shrink-0" style="background-color: var(--bg-page);">
            <h1 class="text-xs font-bold text-gray-300 truncate max-w-[50%]">
                <span class="text-indigo-500 mr-2">Modul {{ $module->order }}:</span> {{ $module->title }}
            </h1>
            
            <!-- Tombol Navigasi Next/Prev -->
            <div class="flex gap-2 items-center">
                @if(!$isCompleted)
                    <form action="{{ route('user.modules.complete', $module->id) }}" method="POST">
                        @csrf
                        <button class="px-3 py-1.5 rounded-lg bg-indigo-600/20 text-indigo-400 border border-indigo-500/30 hover:bg-indigo-600 hover:text-white text-[10px] font-bold uppercase tracking-wider transition-all">Tandai Selesai</button>
                    </form>
                @endif
                
                @if($previousModule)
                    <a href="{{ route('user.learn', [$course->slug, $previousModule->id]) }}" class="px-3 py-1.5 rounded-lg border border-white/10 hover:bg-white/5 text-[10px] font-bold uppercase tracking-wider text-gray-400 transition-all">Sebelumnya</a>
                @endif
                @if($nextModule)
                    <a href="{{ route('user.learn', [$course->slug, $nextModule->id]) }}" class="px-4 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-[10px] font-bold uppercase tracking-wider shadow-lg shadow-indigo-600/20 transition-all">Lanjut &rarr;</a>
                @else
                    <a href="{{ route('user.show', $course->slug) }}" class="px-4 py-1.5 rounded-lg bg-green-600 hover:bg-green-500 text-white text-[10px] font-bold uppercase tracking-wider shadow-lg shadow-green-600/20 transition-all">Selesai</a>
                @endif
            </div>
        </header>

        <!-- Content Viewer -->
        <div class="flex-1 overflow-y-auto p-4 md:p-8 flex flex-col items-center">
            <div class="w-full max-w-5xl reveal" style="animation-delay: 200ms">
                
                <!-- Player Container -->
                <div class="aspect-video w-full bg-black rounded-2xl overflow-hidden border border-white/10 shadow-2xl mb-8 relative group shimmer">
                    @if($module->content_type === 'video')
                        @if($youtubeId)
                            {{-- Plyr YouTube Integration --}}
                            <div id="player" data-plyr-provider="youtube" data-plyr-embed-id="{{ $youtubeId }}"></div>
                        @else
                            {{-- Plyr HTML5 Video (File Upload) --}}
                            <video id="player" playsinline controls data-poster="{{ $course->thumbnail_url }}">
                                <source src="{{ $module->content_url }}" type="video/mp4" />
                            </video>
                        @endif
                    @elseif($module->content_type === 'document')
                        {{-- PDF Viewer / File Preview (Native) --}}
                        <object data="{{ $module->content_url }}" type="application/pdf" class="w-full h-full bg-white rounded-xl">
                            <iframe src="{{ $module->content_url }}" class="w-full h-full" style="border: none;">
                                <div class="flex flex-col items-center justify-center h-full text-gray-500 gap-4">
                                    <p>Preview tidak tersedia.</p>
                                    <a href="{{ $module->content_url }}" target="_blank" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-bold">Download / Buka File</a>
                                </div>
                            </iframe>
                        </object>
                        <!-- Always show download link for backup -->
                        <div class="absolute bottom-4 right-4 z-10">
                            <a href="{{ $module->content_url }}" target="_blank" class="flex items-center gap-2 px-3 py-1.5 bg-black/50 hover:bg-black/70 text-white text-[10px] uppercase font-bold tracking-widest rounded-lg backdrop-blur-md transition-all border border-white/10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                Download
                            </a>
                        </div>
                    @elseif($module->content_type === 'text')
                        <article class="prose prose-lg max-w-none dark:prose-invert text-[var(--text-main)] prose-headings:text-[var(--text-main)] prose-strong:text-[var(--text-main)]">
                            {!! Str::markdown(e($module->content)) !!}
                        </article>
                    @else
                        {{-- Empty State --}}
                        <div class="absolute inset-0 flex items-center justify-center text-gray-500 flex-col gap-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-sm font-medium opacity-50">Materi belum diunggah oleh instruktur.</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </main>

    <!-- Plyr Video Player JS -->
    <script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (document.getElementById('player')) {
                const player = new Plyr('#player', {
                    title: '{{ $module->title }}',
                    controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'captions', 'settings', 'pip', 'airplay', 'fullscreen'],
                });
            }
        });
    </script>
</body>
</html>