<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Kursus - EduIde</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #050508; color: #ffffff; min-height: 100vh; }
        .glass-nav { background: rgba(10, 10, 15, 0.75); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255, 255, 255, 0.08); }
        .glass-card { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(15px); border: 1px solid rgba(255, 255, 255, 0.08); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .glass-card:hover { background: rgba(255, 255, 255, 0.07); transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4); border-color: rgba(99, 102, 241, 0.3); }
        .glow-blob { position: fixed; width: 500px; height: 500px; filter: blur(100px); border-radius: 50%; z-index: -1; opacity: 0.3; }
        #mobileDrawer { transform: translateY(100%); transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        #mobileDrawer.active { transform: translateY(0); }
        #drawerOverlay { opacity: 0; pointer-events: none; transition: opacity 0.3s ease; }
        #drawerOverlay.active { opacity: 1; pointer-events: auto; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        
        /* Tambahan sedikit untuk modal search agar sinkron dengan gaya kamu */
        #mobileSearchModal { opacity: 0; pointer-events: none; transition: all 0.3s ease; }
        #mobileSearchModal.active { opacity: 1; pointer-events: auto; }
    </style>
</head>
<body class="pb-32">
    <div class="glow-blob top-[-10%] left-[-10%] bg-indigo-600/20"></div>
    <div class="glow-blob bottom-[-10%] right-[-10%] bg-cyan-500/10"></div>

    <nav class="glass-nav sticky top-0 z-50 p-4 mb-10">
        <div class="container mx-auto flex justify-between items-center px-4">
            <a href="/" class="group">
                <img src="{{ asset('favicon.ico') }}" alt="EduIde Logo" class="w-10 h-10 inline-block mr-2 group-hover:rotate-12 transition-transform">
                    <span class="text-2xl font-extrabold tracking-tighter italic align-middle">
                    Edu<span class="text-indigo-500">Ide</span>
                    </span>
            </a>
            
            <div class="flex items-center gap-6">
                <form action="{{ route('courses.index') }}" method="GET" class="hidden lg:flex relative group">
                    <input type="text" name="search" placeholder="Cari kursus pilihan..." value="{{ request('search') }}"
                           class="bg-white/5 border border-white/10 rounded-xl px-4 py-2 text-sm w-64 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-all text-white placeholder-gray-500">
                </form>

                <div class="hidden md:flex items-center gap-6">
                    @auth
                        <a href="{{ route('courses.my') }}" class="text-xs font-black uppercase tracking-widest text-gray-400 hover:text-white transition-colors">Kursus Saya</a>
                        
                        @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-1.5 border border-indigo-500/50 bg-indigo-500/10 text-indigo-400 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 hover:text-white transition-all">
                            Admin Dashboard
                        </a>
                        @endif

                        <a href="{{ route('profile') }}" class="flex items-center gap-3 border border-white/10 rounded-xl px-3 py-1.5 bg-white/5 hover:border-indigo-500/50 transition-all group">
                            <span class="text-sm font-bold text-gray-200 group-hover:text-white transition-colors">{{ Auth::user()->name }}</span>
                            @if(Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}" class="w-7 h-7 rounded-lg object-cover border border-white/10 shadow-lg shadow-indigo-600/20">
                            @else
                                <div class="w-7 h-7 bg-indigo-600 rounded-lg flex items-center justify-center text-[10px] font-black text-white shadow-lg shadow-indigo-600/20">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold hover:text-indigo-400 transition-colors">Masuk</a>
                        <a href="{{ route('register') }}" class="px-6 py-2.5 bg-indigo-600 rounded-xl text-sm font-black tracking-widest uppercase shadow-lg shadow-indigo-500/20 hover:bg-indigo-500 transition-all text-white">Daftar</a>
                    @endauth
                </div>

                <button onclick="toggleDrawer()" class="md:hidden p-2.5 rounded-xl bg-white/5 border border-white/10 text-indigo-400 active:scale-90 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-6">
        <div class="mb-12">
            <h1 class="text-4xl font-extrabold tracking-tight mb-2">Pilih Program <span class="text-indigo-500">Masa Depanmu</span></h1>
            <p class="text-gray-500 text-sm italic">Eksplorasi ribuan ide dan teknologi bersama EduIde.</p>
        </div>

        <div class="flex items-center gap-4 mb-6">
            <h2 class="text-xs font-black uppercase tracking-[0.3em] text-gray-500">Kategori</h2>
            <div class="h-px flex-grow bg-white/5"></div>
        </div>

        <div class="flex overflow-x-auto pb-6 gap-3 no-scrollbar mb-10">
            <a href="{{ route('courses.index') }}" 
               class="whitespace-nowrap px-6 py-3 rounded-2xl text-xs font-black uppercase tracking-widest transition-all {{ !request('category') ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-600/20' : 'bg-white/5 border border-white/10 text-gray-400 hover:text-white hover:bg-white/10' }}">
                Semua Program
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('courses.index', ['category' => $cat->slug]) }}" 
                   class="whitespace-nowrap px-6 py-3 rounded-2xl text-xs font-black uppercase tracking-widest transition-all {{ request('category') == $cat->slug ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-600/20' : 'bg-white/5 border border-white/10 text-gray-400 hover:text-white hover:bg-white/10' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($courses as $course)
            <div class="glass-card rounded-[40px] overflow-hidden flex flex-col group p-7">
                <div class="flex justify-between items-start mb-8">
                    <span class="text-[9px] font-black px-3 py-1 bg-indigo-500/10 text-indigo-400 rounded-full border border-indigo-500/20 uppercase tracking-[0.2em]">
                        {{ $course->category->name }}
                    </span>
                    <span class="text-[9px] text-gray-500 font-black uppercase tracking-[0.2em] px-2 py-1 bg-white/5 rounded-md">{{ $course->level }}</span>
                </div>
                
                <h3 class="text-2xl font-bold text-white mb-3 group-hover:text-indigo-400 transition-colors tracking-tight leading-tight">{{ $course->title }}</h3>
                <p class="text-gray-400 text-sm mb-8 line-clamp-3 leading-relaxed opacity-70 group-hover:opacity-100 transition-opacity italic">
                    {{ $course->description }}
                </p>
                
                <div class="mt-auto pt-6 border-t border-white/5 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] text-gray-600 uppercase font-black tracking-widest block mb-1">Akses Belajar</span>
                        <span class="text-white font-extrabold text-xl tracking-tighter">GRATIS</span>
                    </div>

                    <a href="{{ route('courses.show', $course->slug) }}" class="bg-indigo-600 text-white p-4 rounded-2xl hover:bg-white hover:text-indigo-600 hover:scale-105 transition-all duration-300 shadow-lg shadow-indigo-600/20 group/btn flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full py-20 text-center">
                <p class="text-gray-500 font-bold uppercase tracking-widest italic opacity-50">Tidak ada kursus yang ditemukan.</p>
            </div>
            @endforelse
        </div>
    </main>

    <div class="md:hidden fixed bottom-6 left-1/2 -translate-x-1/2 z-[70] w-[90%] max-w-sm">
        <div class="bg-[#0A0A0F]/90 backdrop-blur-2xl border border-white/10 rounded-[32px] p-2.5 flex justify-between items-center shadow-2xl">
            <a href="/" class="flex flex-col items-center gap-1 px-6 py-2.5 text-gray-500 hover:text-indigo-400 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
            </a>
            <button onclick="toggleSearch()" class="flex flex-col items-center gap-1 px-6 py-2.5 rounded-[22px] bg-indigo-600 text-white shadow-xl shadow-indigo-600/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </button>
            <a href="{{ auth()->check() ? route('profile') : route('login') }}" class="flex flex-col items-center gap-1 px-6 py-2.5 text-gray-500 hover:text-white transition-all">
                @if(auth()->check() && auth()->user()->avatar)
                    <img src="{{ auth()->user()->avatar }}" class="w-6 h-6 rounded-full grayscale hover:grayscale-0 transition-all">
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                @endif
            </a>
        </div>
    </div>

    <div id="mobileSearchModal" class="fixed inset-0 bg-black/95 backdrop-blur-xl z-[100] md:hidden flex flex-col p-8">
        <div class="flex justify-between items-center mb-10">
            <h2 class="text-2xl font-black italic">Cari <span class="text-indigo-500">Materi</span></h2>
            <button onclick="toggleSearch()" class="text-gray-400 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <form action="{{ route('courses.index') }}" method="GET">
            <input type="text" name="search" autofocus placeholder="Ketik topik belajar..." 
                   class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-lg text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
        </form>
    </div>

    <div id="drawerOverlay" onclick="toggleDrawer()" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-[80] md:hidden"></div>
    
    <div id="mobileDrawer" class="fixed bottom-0 left-0 right-0 bg-[#050508] border-t border-white/10 rounded-t-[40px] z-[90] p-10 md:hidden shadow-2xl">
        <div class="w-16 h-1 bg-white/10 rounded-full mx-auto mb-10"></div>
        <div class="flex flex-col gap-8">
            @auth
                <div class="flex items-center gap-4 mb-4">
                    @if(Auth::user()->avatar)
                        <img src="{{ Auth::user()->avatar }}" class="w-12 h-12 rounded-2xl border border-white/10">
                    @else
                        <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center font-black text-xl text-white">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <h4 class="font-bold text-lg leading-tight text-white">{{ Auth::user()->name }}</h4>
                        <p class="text-[10px] text-gray-500 uppercase tracking-widest font-black">Member EduIde</p>
                    </div>
                </div>
                <a href="{{ route('courses.my') }}" class="text-2xl font-bold flex items-center justify-between text-white">Kursus Saya <span class="opacity-20 text-sm">→</span></a>
                <a href="{{ route('profile') }}" class="text-2xl font-bold flex items-center justify-between text-white">Profil Akun <span class="opacity-20 text-sm">→</span></a>
                <form action="{{ route('logout') }}" method="POST" class="mt-6 border-t border-white/5 pt-8">
                    @csrf
                    <button class="w-full py-4 bg-rose-500/10 text-rose-500 rounded-2xl font-black uppercase tracking-widest text-[10px]">Keluar Akun</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-2xl font-bold text-white">Masuk</a>
                <a href="{{ route('register') }}" class="text-2xl font-bold text-indigo-400">Daftar Sekarang</a>
            @endauth
        </div>
    </div>

    <script>
        function toggleDrawer() {
            const drawer = document.getElementById('mobileDrawer');
            const overlay = document.getElementById('drawerOverlay');
            drawer.classList.toggle('active');
            overlay.classList.toggle('active');
            document.body.style.overflow = drawer.classList.contains('active') ? 'hidden' : '';
        }

        // Fungsi baru untuk toggle pencarian mobile
        function toggleSearch() {
            const modal = document.getElementById('mobileSearchModal');
            modal.classList.toggle('active');
            if(modal.classList.contains('active')) {
                modal.querySelector('input').focus();
            }
        }
    </script>
</body>
</html>