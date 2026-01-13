<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->title }} - EduIde</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen pb-20" style="background-color: var(--bg-page); color: var(--text-main);">
    
    <div class="glow-blob top-[-20%] right-[-10%] bg-indigo-600/40"></div>
    <div class="glow-blob bottom-[-20%] left-[-10%] bg-cyan-500/20"></div>

    <x-navbar />

    <div class="container mx-auto px-6 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <div class="lg:col-span-2 reveal">
                {{-- Hero Thumbnail --}}
                <div class="relative w-full h-[300px] md:h-[450px] mb-10 overflow-hidden rounded-[40px] border border-white/10 shadow-2xl bg-white/5 shimmer">
                    <img src="{{ $course->thumbnail_url }}" 
                         alt="{{ $course->title }}" 
                         class="w-full h-full object-cover transition-transform duration-700 hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#050508] via-transparent to-transparent"></div>
                </div>

                <div class="mb-6 flex items-center gap-3">
                    <span class="px-4 py-1 bg-indigo-500/10 border border-indigo-500/20 text-indigo-300 text-[10px] font-bold rounded-full uppercase tracking-widest">
                        {{ $course->category->name }}
                    </span>
                    <span class="text-gray-500 text-[10px] font-medium tracking-widest uppercase">ID: EI-{{ str_pad($course->id, 3, '0', STR_PAD_LEFT) }}</span>
                </div>

                <h1 class="text-4xl md:text-6xl font-extrabold text-[var(--text-main)] mb-8 tracking-tighter leading-tight">
                    {{ $course->title }}
                </h1>

                <div class="glass-card p-8 rounded-[32px] mb-12 reveal" style="animation-delay: 100ms">
                    <h3 class="text-xs font-bold text-indigo-400 uppercase tracking-[0.2em] mb-4">Ringkasan Program</h3>
                    <p class="text-[var(--text-main)] text-lg leading-relaxed font-light">
                        {{ $course->description }}
                    </p>
                </div>

                <div class="mt-16 reveal" style="animation-delay: 200ms">
                    <h2 class="text-2xl font-extrabold mb-8 flex items-center gap-4 text-white/90">
                        Daftar Modul Belajar
                        <div class="h-[1px] flex-grow bg-white/10"></div>
                    </h2>
                    
                    <div class="space-y-4">
                        @forelse($course->modules as $index => $module)
                            <div class="module-row flex items-center p-6 glass-card rounded-2xl transition-all duration-300 border border-white/5 group">
                                <div class="w-10 h-10 bg-white/5 border border-white/10 rounded-xl flex items-center justify-center font-bold mr-6 text-indigo-400 group-hover:bg-indigo-500 group-hover:text-white transition-all">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-white tracking-tight">{{ $module->title }}</h4>
                                    <p class="text-[10px] text-gray-500 uppercase tracking-widest mt-1">Video & Reading Material</p>
                                </div>
                                <div>
                                    @php $isEnrolled = Auth::check() && Auth::user()->courses->contains($course->id); @endphp
                                    @if($isEnrolled)
                                        <span class="text-[9px] font-bold bg-emerald-500/10 text-emerald-400 px-3 py-1 rounded-lg border border-emerald-500/20 uppercase tracking-widest">Tersedia</span>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="p-12 border-2 border-dashed border-white/5 rounded-[32px] text-center">
                                <p class="text-gray-500 font-medium italic">Modul sedang dalam tahap penyusunan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1 reveal" style="animation-delay: 300ms">
                <div class="glass-card p-10 rounded-[40px] sticky-sidebar border-t border-white/20 shadow-2xl">
                    <div class="mb-10 text-center">
                        <p class="text-[10px] text-indigo-400 font-bold mb-2 tracking-[0.4em] uppercase">Investasi Ilmu</p>
                        <div class="text-4xl font-extrabold text-white tracking-tighter">
                            {{ $course->price > 0 ? 'Rp ' . number_format($course->price, 0, ',', '.') : 'FREE ACCESS' }}
                        </div>
                    </div>

                    @php $isEnrolled = Auth::check() && Auth::user()->courses->contains($course->id); @endphp

                    @auth
                        @if($isEnrolled)
                            <div class="space-y-4 mb-8">
                                <div class="enrolled-badge text-center py-5 rounded-2xl">
                                    <p class="text-xs font-black uppercase tracking-[0.2em] text-indigo-400 mb-1">Akses Dimiliki</p>
                                    <p class="text-[10px] text-gray-400">Anda sudah terdaftar di kelas ini.</p>
                                </div>
                                <a href="{{ route('user.modules', $course->slug) }}" 
                                   class="block w-full py-5 btn-primary text-white text-center rounded-2xl font-extrabold uppercase tracking-widest hover:scale-[1.02] transition-all shadow-xl shadow-indigo-600/20 btn-shine-effect">
                                    🚀 Mulai Belajar Sekarang
                                </a>
                            </div>
                        @else
                            <form action="{{ route('user.enroll', $course->id) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                    class="w-full py-5 rounded-2xl font-extrabold uppercase tracking-widest transition-all duration-300 mb-8 bg-white text-black hover:bg-indigo-500 hover:text-white shadow-xl shadow-indigo-500/10 active:scale-95 btn-shine-effect">
                                    Ambil Kursus Ini
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="block w-full py-5 btn-primary text-white text-center rounded-2xl font-extrabold uppercase tracking-widest transition-all mb-8 shadow-xl shadow-indigo-600/20 btn-shine-effect">
                            Masuk untuk Belajar
                        </a>
                    @endauth

                    <div class="space-y-5 pt-8 border-t border-white/10">
                        <div class="flex justify-between items-center">
                            <span class="text-[11px] text-gray-500 font-bold uppercase tracking-widest">Level</span>
                            <span class="text-white font-bold text-xs uppercase bg-white/5 px-3 py-1 rounded-md border border-white/10">{{ $course->level }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[11px] text-gray-500 font-bold uppercase tracking-widest">Kurikulum</span>
                            <span class="text-white font-bold text-xs">{{ $course->modules->count() }} Materi Utama</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[11px] text-gray-500 font-bold uppercase tracking-widest">Update</span>
                            <span class="text-white font-bold text-xs italic">{{ $course->updated_at->format('M Y') }}</span>
                        </div>
                    </div>

                    <div class="mt-10 pt-8 border-t border-white/5 flex flex-col items-center gap-4">
                        <div class="flex gap-2">
                            <div class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-bounce"></div>
                            <div class="w-1.5 h-1.5 rounded-full bg-cyan-500 animate-bounce delay-100"></div>
                            <div class="w-1.5 h-1.5 rounded-full bg-white animate-bounce delay-200"></div>
                        </div>
                        <p class="text-[9px] text-gray-600 font-bold uppercase tracking-[0.2em] text-center leading-relaxed">
                            Official Digital Certificate<br>Powered by EduIde Engine
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>