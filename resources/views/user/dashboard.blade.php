<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Kursus - EduIde</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="pb-20" style="background-color: var(--bg-page); color: var(--text-main);">
    {{-- Decorative Background --}}
    <div class="glow-blob top-[-10%] left-[-10%] bg-indigo-600/30"></div>
    <div class="glow-blob bottom-[-10%] right-[-10%] bg-blue-500/20"></div>

    {{-- Navigation --}}
    {{-- Navigation --}}
    <x-navbar />

    <main class="container mx-auto px-6 mt-32">
        {{-- Hero Header --}}
        <div class="max-w-2xl mb-16">
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tighter mb-4 leading-tight text-[var(--text-main)]">
                Eksplorasi Ide <br/><span class="text-indigo-400">Tanpa Batas.</span>
            </h1>
            <p class="text-[var(--text-muted)] text-sm max-w-md leading-relaxed mb-8">
                Pilih program pembelajaran yang dirancang untuk masa depan industri kreatif dan teknologi.
            </p>

            {{-- Search Bar (Hero Placement) --}}
            <form action="{{ route('user.dashboard') }}" method="GET" class="relative max-w-md">
                <input type="text" name="search" placeholder="Cari materi yang ingin kamu pelajari..." value="{{ request('search') }}"
                       class="w-full bg-white/5 border border-white/10 rounded-2xl pl-6 pr-14 py-4 text-sm focus:outline-none focus:border-indigo-500 focus:bg-white/10 transition-all text-white placeholder-gray-500 shadow-xl">
                <button type="submit" class="absolute right-2 top-2 p-2 bg-indigo-600 rounded-xl text-white hover:bg-indigo-500 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>
        </div>

        {{-- Categories Scroll --}}
        <div class="flex items-center gap-4 mb-8">
            <div class="flex overflow-x-auto gap-3 no-scrollbar py-2">
                <a href="{{ route('user.dashboard') }}" 
                   class="px-6 py-3 rounded-2xl text-[10px] font-bold uppercase tracking-widest transition-all {{ !request('category') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'bg-white/5 border border-white/10 text-gray-500 hover:border-white/20' }}">
                    Semua
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('user.dashboard', ['category' => $cat->slug]) }}" 
                       class="px-6 py-3 rounded-2xl text-[10px] font-bold uppercase tracking-widest transition-all {{ request('category') == $cat->slug ? 'bg-indigo-600 text-white' : 'bg-white/5 border border-white/10 text-gray-500 hover:border-white/20' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Course Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($courses as $index => $course)
            <div class="glass-card rounded-[32px] p-6 flex flex-col group reveal" style="animation-delay: {{ $index * 100 }}ms">
                {{-- Thumbnail --}}
                <div class="relative aspect-video mb-6 overflow-hidden rounded-[24px] bg-white/5 border border-white/10 shimmer">
                    <img src="{{ $course->thumbnail_url }}" 
                         alt="{{ $course->title }}" 
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 bg-black/50 backdrop-blur-md border border-white/10 rounded-full text-[9px] font-bold uppercase tracking-widest text-white">
                            {{ $course->level }}
                        </span>
                    </div>
                </div>

                {{-- Content --}}
                <div class="flex-grow">
                    <p class="text-indigo-400 text-[9px] font-bold uppercase tracking-[0.2em] mb-2">{{ $course->category->name }}</p>
                    <h3 class="text-xl font-bold text-[var(--text-main)] mb-3 tracking-tight group-hover:text-indigo-300 transition-colors line-clamp-2">
                        {{ $course->title }}
                    </h3>
                    <p class="text-[var(--text-muted)] text-xs leading-relaxed line-clamp-2 mb-6 opacity-80">
                        {{ $course->description }}
                    </p>
                </div>

                {{-- Footer --}}
                <div class="pt-6 border-t border-white/5 flex items-center justify-between mt-auto">
                    <div>
                        <p class="text-[9px] text-gray-600 uppercase font-bold tracking-widest mb-1">Investasi Ilmu</p>
                        <p class="text-white font-extrabold text-lg tracking-tight">
                            {{ $course->price > 0 ? 'Rp ' . number_format($course->price, 0, ',', '.') : 'Akses Gratis' }}
                        </p>
                    </div>
                    <a href="{{ route('user.show', $course->slug) }}" 
                       class="w-12 h-12 bg-white text-black rounded-2xl flex items-center justify-center hover:bg-indigo-500 hover:text-white transition-all duration-300 shadow-xl group-hover:scale-110 btn-shine-effect">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full py-32 text-center bg-white/5 rounded-[40px] border border-dashed border-white/10">
                <p class="text-gray-500 font-bold uppercase tracking-widest text-xs">Belum ada kursus di kategori ini</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-10 flex items-center justify-center">
            {{ $courses->links() }}
        </div>
    </main>

</body>
</html>