<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="EduIde — Platform belajar interaktif dengan kurikulum berstandar industri. Kuasai skill masa depan dengan mentor expert.">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="EduIde — Future Learning Platform">
    <meta property="og:description" content="Platform belajar interaktif dengan kurikulum berstandar industri. Kuasai skill masa depan dengan mentor expert.">
    <meta property="og:image" content="{{ asset('favicon.ico') }}">

    <title>EduIde — Future Learning Platform</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .text-glow { text-shadow: 0 0 30px rgba(255, 255, 255, 0.15); }
    </style>
</head>
<body class="antialiased overflow-x-hidden selection:bg-indigo-500 selection:text-white">

    <!-- Decorative Globs -->
    <div class="glow-blob top-[-10%] left-[-10%] bg-indigo-600"></div>
    <div class="glow-blob top-[30%] right-[-10%] bg-blue-600"></div>
    <div class="glow-blob bottom-[-10%] left-[20%] bg-purple-600"></div>

    <!-- Navigation -->
    <x-navbar />

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center pt-20">
        <div class="container mx-auto px-6 relative z-10 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 border border-white/10 mb-8 backdrop-blur-md animate-fade-in-up">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-emerald-400">Revolusi Pembelajaran Digital</span>
            </div>
            
            <h1 class="text-5xl md:text-8xl font-extrabold tracking-tighter mb-8 leading-tight text-glow animate-fade-in-up delay-100">
                Kuasai Skill <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-white to-purple-400">Masa Depan.</span>
            </h1>
            
            <p class="text-[var(--text-muted)] text-base md:text-xl max-w-2xl mx-auto mb-12 leading-relaxed animate-fade-in-up delay-200">
                Platform belajar interaktif dengan kurikulum berstandar industri. Tingkatkan karirmu dengan materi yang relevan dan mentor berpengalaman.
            </p>
            
            <div class="flex flex-col md:flex-row items-center justify-center gap-5 animate-fade-in-up delay-300">
                <a href="{{ route('register') }}" class="px-10 py-5 rounded-2xl btn-primary text-xs font-black uppercase tracking-[0.2em] w-full md:w-auto">
                    Mulai Belajar Sekarang
                </a>
                <a href="#featured" class="px-10 py-5 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 text-white text-xs font-black uppercase tracking-[0.2em] transition-all w-full md:w-auto flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                    </svg>
                    Lihat Katalog
                </a>
            </div>
        </div>
    </section>

    <!-- Stats Section (Glass Banner) -->
    <section class="py-10 border-y border-white/5 bg-black/20 backdrop-blur-sm">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="space-y-2">
                    <h3 class="text-3xl md:text-4xl font-bold text-white">15K+</h3>
                    <p class="text-[10px] uppercase tracking-widest text-[var(--text-muted)]">Siswa Aktif</p>
                </div>
                <div class="space-y-2">
                    <h3 class="text-3xl md:text-4xl font-bold text-white">120+</h3>
                    <p class="text-[10px] uppercase tracking-widest text-[var(--text-muted)]">Modul Materi</p>
                </div>
                <div class="space-y-2">
                    <h3 class="text-3xl md:text-4xl font-bold text-white">50+</h3>
                    <p class="text-[10px] uppercase tracking-widest text-[var(--text-muted)]">Mentor Expert</p>
                </div>
                <div class="space-y-2">
                    <h3 class="text-3xl md:text-4xl font-bold text-white">4.9</h3>
                    <p class="text-[10px] uppercase tracking-widest text-[var(--text-muted)]">Rating Rata-rata</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-32 relative">
        <div class="container mx-auto px-6">
            <div class="text-center mb-20">
                <h2 class="text-3xl md:text-5xl font-bold mb-6">Kenapa EduIde?</h2>
                <div class="w-24 h-1 bg-indigo-500 mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="glass-card p-10 rounded-[32px]">
                    <div class="w-16 h-16 rounded-2xl bg-indigo-500/20 flex items-center justify-center mb-8 text-indigo-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Akses Seumur Hidup</h3>
                    <p class="text-[var(--text-muted)] text-sm leading-relaxed">
                        Sekali bayar, akses materi selamanya. Termasuk update materi di masa depan tanpa biaya tambahan.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="glass-card p-10 rounded-[32px] relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/20 to-purple-600/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10">
                        <div class="w-16 h-16 rounded-2xl bg-purple-500/20 flex items-center justify-center mb-8 text-purple-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-4">Proyek Portofolio</h3>
                        <p class="text-[var(--text-muted)] text-sm leading-relaxed">
                            Belajar dengan praktik langsung. Bangun portofolio nyata yang bisa kamu pamerkan ke rekruter.
                        </p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="glass-card p-10 rounded-[32px]">
                    <div class="w-16 h-16 rounded-2xl bg-pink-500/20 flex items-center justify-center mb-8 text-pink-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Komunitas Diskusi</h3>
                    <p class="text-[var(--text-muted)] text-sm leading-relaxed">
                        Bergabung dengan ribuan developer lain. Diskusi, tanya jawab, dan networking dalam satu platform.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Courses Section -->
    <section id="featured" class="py-32 relative overflow-hidden">
        <div class="glow-blob top-[20%] right-[-10%] bg-indigo-600/10"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-16 reveal">
                <div>
                    <h2 class="text-3xl md:text-5xl font-bold mb-4 text-white">Katalog Unggulan</h2>
                    <div class="w-24 h-1 bg-indigo-500 mb-6 rounded-full"></div>
                    <p class="text-[var(--text-muted)] text-sm md:text-base max-w-xl leading-relaxed">Pilih kurikulum terbaik yang telah disusun oleh para ahli industri untuk mengakselerasi karirmu secara profesional.</p>
                </div>
                <a href="{{ route('user.dashboard') }}" class="group flex items-center gap-3 text-indigo-400 font-bold uppercase tracking-widest text-[10px] hover:text-indigo-300 transition-all">
                    Lihat Semua Kursus
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($featuredCourses as $index => $course)
                    <div class="glass-card rounded-[40px] overflow-hidden group reveal" style="animation-delay: {{ $index * 100 }}ms">
                        <div class="relative aspect-video overflow-hidden">
                            <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110 shimmer">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>
                            <div class="absolute top-6 left-6">
                                <span class="px-4 py-1.5 rounded-full bg-indigo-600/90 backdrop-blur-md text-[9px] font-black text-white uppercase tracking-[0.2em] border border-white/20">
                                    {{ $course->category->name ?? 'Course' }}
                                </span>
                            </div>
                        </div>
                        <div class="p-8 md:p-10">
                            <h3 class="text-xl md:text-2xl font-bold mb-3 group-hover:text-indigo-400 transition-colors line-clamp-1 text-white">{{ $course->title }}</h3>
                            <p class="text-[10px] text-gray-500 uppercase tracking-widest font-black mb-10 opacity-60">By {{ $course->author->name }}</p>
                            
                            <div class="flex items-center justify-between pt-8 border-t border-white/10">
                                <div class="flex flex-col">
                                    <span class="text-[9px] text-gray-500 uppercase tracking-widest mb-1 opacity-50 font-bold">Value</span>
                                    <span class="text-xl font-bold text-white tracking-tight">Rp{{ number_format($course->price, 0, ',', '.') }}</span>
                                </div>
                                <a href="{{ route('user.show', $course->slug) }}" class="px-7 py-4 rounded-2xl bg-white/5 border border-white/10 hover:bg-indigo-600 hover:border-indigo-500 text-white text-[10px] font-black uppercase tracking-[0.15em] transition-all btn-shine-effect shadow-lg shadow-indigo-600/10">
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-3 text-center py-24 glass-card rounded-[40px] border-dashed border-white/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto text-gray-700 mb-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                        <p class="text-gray-500 italic uppercase tracking-[0.3em] text-[10px] font-black">Coming Soon: Premium Content</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Testimonials Slider (Powered by Reviews) -->
    <section class="py-20 relative overflow-hidden">
        <div class="container mx-auto px-6 relative z-10">
            {{-- Inline Review Form (Expandable) --}}
            <div x-data="{ open: false }" x-cloak class="mb-12">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold mb-2">Kata Mereka</h2>
                        <p class="text-[var(--text-muted)] text-sm">Pengalaman belajar dari alumni EduIde.</p>
                    </div>
                    
                    <button @click="open = !open" 
                            class="w-full md:w-auto px-8 py-4 rounded-xl border transition-all btn-shine-effect flex items-center justify-center gap-3"
                            :class="open ? 'bg-white/10 border-white/20 text-white' : 'bg-white/5 border-white/10 text-white hover:bg-white/10'">
                        <span x-text="open ? 'Batal Menulis' : 'Tulis Ulasan'"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transition-transform duration-300" :class="{ 'rotate-45': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                </div>

                <div x-show="open" 
                     x-collapse
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 -translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0 shadow-2xl"
                     class="max-w-2xl mx-auto">
                    
                    <div class="glass-card p-8 md:p-10 rounded-[35px] border-white/20 shadow-[0_0_50px_rgba(99,102,241,0.1)] !transform-none !hover:translate-y-0">
                        <div class="mb-8 pb-4 border-b border-white/10">
                            <h3 class="text-xl font-bold text-white">Bagikan Pengalamanmu</h3>
                            <p class="text-[9px] text-gray-500 uppercase tracking-widest mt-1">Edukasi Yang Memberdayakan • Berikan Feedback Terbaikmu</p>
                        </div>

                        <form action="{{ route('reviews.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em] mb-3">Nama Lengkap</label>
                                    <input type="text" name="name" required class="input-glass w-full px-5 py-4 rounded-2xl text-sm" placeholder="Nama Anda">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em] mb-3">Pekerjaan / Mahasiswa</label>
                                    <input type="text" name="job" required class="input-glass w-full px-5 py-4 rounded-2xl text-sm" placeholder="Contoh: UI/UX Designer">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em] mb-3">Ulasan Detail</label>
                                <textarea name="message" rows="4" required class="input-glass w-full px-5 py-4 rounded-2xl text-sm resize-none" placeholder="Ceritakan progres belajar Anda..."></textarea>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="w-full md:w-auto px-10 py-5 btn-primary rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] text-white shadow-xl shadow-indigo-600/30 hover:scale-[1.05] active:scale-95 transition-all btn-shine-effect">
                                    Submit Testimoni Sekarang
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Existing Reviews Display -->
            @if(session('success'))
                <div class="mb-8 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-2xl text-[10px] font-bold uppercase tracking-[0.2em] text-center backdrop-blur-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($reviews as $review)
                <div class="glass-card p-6 rounded-2xl border border-white/5">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-xs font-bold text-white">
                            {{ substr($review->name, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-white">{{ $review->name }}</h4>
                            <p class="text-[10px] text-indigo-400 uppercase tracking-wider font-bold">{{ $review->job }}</p>
                        </div>
                    </div>
                    <p class="text-[var(--text-muted)] text-sm leading-relaxed italic">"{{ $review->message }}"</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 border-t border-white/5 bg-black/40 backdrop-blur-lg mt-20">
        <div class="container mx-auto px-6 text-center">
            <div class="flex items-center justify-center gap-2 mb-6">
                <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <span class="text-lg font-bold text-white">Edu<span class="text-indigo-400">Ide</span></span>
            </div>
            <p class="text-[var(--text-muted)] text-xs">© {{ date('Y') }} EduIde Platform. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>