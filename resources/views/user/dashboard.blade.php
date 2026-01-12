<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Kursus - EduIde</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap');
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #050508; 
            color: #ffffff; 
            min-height: 100vh; 
        }

        .glass-nav { 
            background: rgba(5, 5, 8, 0.8); 
            backdrop-filter: blur(20px); 
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05); 
        }

        .glass-card { 
            background: rgba(255, 255, 255, 0.02); 
            border: 1px solid rgba(255, 255, 255, 0.05); 
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
        }

        .glass-card:hover { 
            background: rgba(255, 255, 255, 0.04); 
            transform: translateY(-8px); 
            border-color: rgba(99, 102, 241, 0.3);
            box-shadow: 0 20px 40px -20px rgba(0, 0, 0, 0.5);
        }

        .glow-blob { 
            position: fixed; 
            width: 600px; 
            height: 600px; 
            filter: blur(120px); 
            border-radius: 50%; 
            z-index: -1; 
            opacity: 0.15; 
        }

        #mobileDrawer { 
            transform: translateY(100%); 
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1); 
        }
        #mobileDrawer.active { transform: translateY(0); }
        
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
</head>
<body class="pb-20">
    {{-- Decorative Background --}}
    <div class="glow-blob top-[-10%] left-[-10%] bg-indigo-600/30"></div>
    <div class="glow-blob bottom-[-10%] right-[-10%] bg-blue-500/20"></div>

    {{-- Navigation --}}
    <nav class="glass-nav sticky top-0 z-50 py-4">
        <div class="container mx-auto flex justify-between items-center px-6">
            <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                <span class="text-2xl font-extrabold tracking-tighter">Edu<span class="text-indigo-400">Ide</span></span>
            </a>
            
            <div class="flex items-center gap-8">
                {{-- Search Bar - Desktop --}}
                <form action="{{ route('user.dashboard') }}" method="GET" class="hidden lg:block relative">
                    <input type="text" name="search" placeholder="Cari ide baru..." value="{{ request('search') }}"
                           class="bg-white/5 border border-white/10 rounded-2xl px-5 py-2 text-xs w-64 focus:outline-none focus:border-indigo-500/50 transition-all text-white placeholder-gray-600">
                </form>

                <div class="hidden md:flex items-center gap-8">
                    @auth
                        <a href="{{ route('user.enrolled') }}" class="text-[10px] font-bold uppercase tracking-widest text-gray-400 hover:text-white transition-colors">Kursus Saya</a>
                        
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="text-[10px] font-bold uppercase tracking-widest text-indigo-400 hover:text-indigo-300">Admin</a>
                        @endif

                        <a href="{{ route('profile') }}" class="flex items-center gap-3 pl-4 border-l border-white/10 group">
                            <div class="text-right">
                                <p class="text-xs font-bold text-gray-200 group-hover:text-white transition-colors">{{ Auth::user()->name }}</p>
                                <p class="text-[9px] text-gray-500 uppercase tracking-tighter">Siswa</p>
                            </div>
                            <div class="w-8 h-8 bg-white/5 border border-white/10 rounded-xl overflow-hidden flex items-center justify-center">
                                @if(Auth::user()->avatar)
                                    <img src="{{ Auth::user()->avatar }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-[10px] font-bold text-indigo-400">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                @endif
                            </div>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-xs font-bold uppercase tracking-widest hover:text-indigo-400 transition-colors">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-white text-black px-6 py-2.5 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-indigo-500 hover:text-white transition-all shadow-lg shadow-white/5">Daftar</a>
                    @endauth
                </div>

                {{-- Mobile Toggle --}}
                <button onclick="toggleDrawer()" class="md:hidden p-2 text-gray-400 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-6 mt-12">
        {{-- Hero Header --}}
        <div class="max-w-2xl mb-16">
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tighter mb-4 leading-tight">
                Eksplorasi Ide <br/><span class="text-indigo-400">Tanpa Batas.</span>
            </h1>
            <p class="text-gray-500 text-sm max-w-md leading-relaxed">
                Pilih program pembelajaran yang dirancang untuk masa depan industri kreatif dan teknologi.
            </p>
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
            @forelse($courses as $course)
            <div class="glass-card rounded-[32px] p-6 flex flex-col group">
                {{-- Thumbnail --}}
                <div class="relative aspect-video mb-6 overflow-hidden rounded-[24px]">
                    <img src="{{ $course->thumbnail ?? asset('images/placeholder.jpg') }}" 
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
                    <h3 class="text-xl font-bold text-white mb-3 tracking-tight group-hover:text-indigo-300 transition-colors line-clamp-2">
                        {{ $course->title }}
                    </h3>
                    <p class="text-gray-500 text-xs leading-relaxed line-clamp-2 mb-6 opacity-80">
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
                       class="w-12 h-12 bg-white text-black rounded-2xl flex items-center justify-center hover:bg-indigo-500 hover:text-white transition-all duration-300 shadow-xl group-hover:scale-110">
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

    {{-- Mobile Drawer Overlay --}}
    <div id="drawerOverlay" onclick="toggleDrawer()" class="fixed inset-0 bg-black/90 backdrop-blur-md z-[80] hidden opacity-0 transition-opacity duration-300"></div>
    
    {{-- Mobile Drawer --}}
    <div id="mobileDrawer" class="fixed bottom-0 left-0 right-0 bg-[#0a0a0f] border-t border-white/10 rounded-t-[40px] z-[90] p-10 md:hidden">
        <div class="w-12 h-1.5 bg-white/10 rounded-full mx-auto mb-10"></div>
        <div class="flex flex-col gap-6">
            @auth
                <div class="flex items-center gap-4 mb-6 border-b border-white/5 pb-6">
                    <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center font-bold text-white text-xl">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <h4 class="font-bold text-white text-lg">{{ Auth::user()->name }}</h4>
                        <p class="text-[10px] text-gray-500 uppercase tracking-widest">Siswa Aktif</p>
                    </div>
                </div>
                <a href="{{ route('user.enrolled') }}" class="text-xl font-bold text-white hover:text-indigo-400 transition-colors">Kursus Saya</a>
                <a href="{{ route('profile') }}" class="text-xl font-bold text-white hover:text-indigo-400 transition-colors">Profil Saya</a>
                <form action="{{ route('logout') }}" method="POST" class="mt-4 pt-6 border-t border-white/5">
                    @csrf
                    <button class="text-rose-500 font-bold uppercase tracking-widest text-xs">Keluar Akun</button>
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
            const isActive = drawer.classList.contains('active');
            
            if (isActive) {
                drawer.classList.remove('active');
                overlay.classList.add('opacity-0');
                setTimeout(() => overlay.classList.add('hidden'), 300);
                document.body.style.overflow = '';
            } else {
                overlay.classList.remove('hidden');
                setTimeout(() => overlay.classList.remove('opacity-0'), 10);
                drawer.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        }
    </script>
</body>
</html>