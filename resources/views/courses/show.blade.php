<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->title }} - EduIde</title>
    
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
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .module-row:hover {
            background: rgba(255, 255, 255, 0.05);
            transform: translateX(8px);
        }

        .glow-sphere {
            position: fixed;
            width: 600px;
            height: 600px;
            filter: blur(120px);
            border-radius: 50%;
            z-index: -1;
            opacity: 0.3;
        }

        @media (min-width: 1024px) {
            .sticky-sidebar {
                position: sticky;
                top: 120px;
            }
        }
        
        /* Animasi halu untuk status terdaftar */
        .enrolled-badge {
            background: linear-gradient(90deg, rgba(99, 102, 241, 0.2), rgba(34, 211, 238, 0.2));
            border: 1px solid rgba(99, 102, 241, 0.3);
        }
    </style>
</head>
<body class="min-h-screen pb-20">
    
    <div class="glow-sphere top-[-20%] right-[-10%] bg-indigo-600/40"></div>
    <div class="glow-sphere bottom-[-20%] left-[-10%] bg-cyan-500/20"></div>

    <nav class="glass-nav sticky top-0 z-50 p-4 mb-8">
        <div class="container mx-auto flex justify-between items-center px-6">
            <a href="{{ route('courses.index') }}" class="group flex items-center gap-3">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <img src="{{ asset('favicon.ico') }}" alt="Logo" class="w-6 h-6 opacity-80">
                </div>
                <span class="text-xl font-extrabold tracking-tighter italic">Edu<span class="text-indigo-400">Ide</span></span>
            </a>
            <div class="hidden md:block">
                <span class="text-[10px] font-bold tracking-[0.3em] text-gray-500 uppercase">Akses Kursus Terverifikasi</span>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-8">
        @if(session('status'))
            <div class="mb-8 p-4 glass-card rounded-2xl border-l-4 border-emerald-500 flex items-center gap-3 animate-pulse">
                <div class="bg-emerald-500/20 p-2 rounded-full text-emerald-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </div>
                <p class="text-sm font-semibold text-emerald-500">{{ session('status') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <div class="lg:col-span-2">
                <div class="mb-6 flex items-center gap-3">
                    <span class="px-4 py-1 bg-white/5 border border-white/10 text-indigo-300 text-[10px] font-bold rounded-full uppercase tracking-widest">
                        {{ $course->category->name }}
                    </span>
                    <span class="text-gray-500 text-[10px] font-medium tracking-widest">KODE: EI-{{ str_pad($course->id, 3, '0', STR_PAD_LEFT) }}</span>
                </div>

                <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-8 tracking-tighter leading-tight">
                    {{ $course->title }}
                </h1>

                <div class="glass-card p-8 rounded-[32px] mb-12">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-[0.2em] mb-4">Eksplorasi Materi</h3>
                    <p class="text-gray-300 text-lg md:text-xl leading-relaxed font-light italic">
                        "{{ $course->description }}"
                    </p>
                </div>

                <div class="mt-16">
                    <h2 class="text-2xl font-extrabold mb-8 flex items-center gap-4 text-white/90">
                        Kurikulum Pembelajaran
                        <div class="h-[1px] flex-grow bg-white/10"></div>
                    </h2>
                    
                    <div class="space-y-3">
                        @forelse($course->modules as $index => $module)
                            <div class="module-row flex items-center p-6 glass-card rounded-2xl transition-all duration-300 border border-white/5 group">
                                <div class="w-12 h-12 bg-white/5 border border-white/10 rounded-xl flex items-center justify-center font-bold mr-6 text-indigo-400 group-hover:bg-indigo-500 group-hover:text-white transition-all">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-lg text-white tracking-tight">{{ $module->title }}</h4>
                                    <p class="text-xs text-gray-500 mt-1 uppercase tracking-widest font-medium">
                                        Modul EduIde — Interaktif
                                    </p>
                                </div>
                                <div class="hidden sm:block">
                                    @php
                                        $isEnrolled = Auth::check() && Auth::user()->courses->contains($course->id);
                                    @endphp
                                    @if($isEnrolled)
                                        <span class="text-[10px] font-bold bg-indigo-500/10 text-indigo-400 px-4 py-1.5 rounded-full border border-indigo-500/20 uppercase tracking-widest">Terbuka</span>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="p-12 border-2 border-dashed border-white/5 rounded-[32px] text-center">
                                <p class="text-gray-500 font-medium italic">Belum ada kurikulum yang diunggah.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="glass-card p-10 rounded-[40px] sticky-sidebar border-t border-white/20 shadow-2xl">
                    <div class="mb-10 text-center">
                        <p class="text-[10px] text-indigo-400 font-bold mb-2 tracking-[0.4em] uppercase">Status Akses</p>
                        <div class="text-5xl font-extrabold text-white tracking-tighter">
                            Gratis
                        </div>
                    </div>

                    @php
                        $isEnrolled = Auth::check() && Auth::user()->courses->contains($course->id);
                    @endphp

                    @auth
                        @if($isEnrolled)
                            <div class="space-y-4 mb-8">
                                <div class="enrolled-badge text-center py-5 rounded-2xl">
                                    <p class="text-xs font-black uppercase tracking-[0.2em] text-indigo-400 mb-1">Anda Terdaftar</p>
                                    <p class="text-[10px] text-gray-400">Selamat belajar, raih mimpimu!</p>
                                </div>
                                @if($course->modules->count() > 0)
                                <a href="#" class="block w-full py-5 bg-indigo-600 text-white text-center rounded-2xl font-extrabold uppercase tracking-widest hover:bg-indigo-500 transition-all shadow-xl shadow-indigo-600/20">
                                    Lanjut Belajar
                                </a>
                                @endif
                            </div>
                        @else
                            <form action="{{ route('courses.enroll', $course->id) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                    class="w-full py-5 rounded-2xl font-extrabold uppercase tracking-widest transition-all duration-300 mb-8 bg-white text-black hover:bg-indigo-500 hover:text-white shadow-xl shadow-indigo-500/10 active:scale-95">
                                    Mulai Belajar
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="block w-full py-5 bg-indigo-600 text-white text-center rounded-2xl font-extrabold uppercase tracking-widest hover:bg-indigo-500 transition-all mb-8 shadow-xl shadow-indigo-600/20">
                            Masuk untuk Akses
                        </a>
                    @endauth

                    <div class="space-y-5 pt-8 border-t border-white/10">
                        <div class="flex justify-between items-center">
                            <span class="text-[11px] text-gray-500 font-bold uppercase tracking-widest">Tingkat</span>
                            <span class="text-white font-bold text-sm uppercase">{{ $course->level ?? 'Menengah' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[11px] text-gray-500 font-bold uppercase tracking-widest">Total Modul</span>
                            <span class="text-white font-bold text-sm">{{ $course->modules->count() }} Materi</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[11px] text-gray-500 font-bold uppercase tracking-widest">Lisensi</span>
                            <span class="text-white font-bold text-sm uppercase">Lifetime</span>
                        </div>
                    </div>

                    <div class="mt-10 flex flex-col items-center gap-4">
                        <div class="flex gap-2">
                            <div class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></div>
                            <div class="w-2 h-2 rounded-full bg-cyan-500 animate-pulse delay-75"></div>
                            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse delay-150"></div>
                        </div>
                        <p class="text-[9px] text-gray-600 font-bold uppercase tracking-widest text-center">
                            Digital E-Certificate included<br>by EduIde Professional
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>