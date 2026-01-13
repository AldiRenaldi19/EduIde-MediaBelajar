<!-- Scroll Progress Bar -->
<div class="fixed top-0 left-0 h-[3px] bg-gradient-to-r from-indigo-600 via-indigo-400 to-cyan-400 z-[100] transition-all duration-150 ease-out"
     :style="'width: ' + scrollPercent + '%'"
     x-data="{ scrollPercent: 0 }"
     @scroll.window="scrollPercent = (window.pageYOffset / (document.documentElement.scrollHeight - window.innerHeight)) * 100">
</div>

<x-toast />

<nav class="fixed top-0 w-full z-50 transition-all duration-300" 
     :class="{ 'glass-nav py-3': scrolled, 'bg-transparent py-4 md:py-5': !scrolled }"
     x-data="{ mobileMenuOpen: false, scrolled: false }" 
     @scroll.window="scrolled = (window.pageYOffset > 20)"
     x-cloak>
    <div class="container mx-auto px-6 flex justify-between items-center">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex items-center gap-3 group">
            <img src="{{ asset('favicon.ico') }}" alt="EduIde Logo" class="w-10 h-10 rounded-xl shadow-lg shadow-indigo-500/20 group-hover:rotate-12 transition-transform duration-300">
            <span class="text-xl font-bold tracking-tight text-white group-hover:text-indigo-200 transition-colors">Edu<span class="text-indigo-400">Ide</span></span>
        </a>

        <!-- Desktop Navigation -->
        <div class="hidden md:flex items-center gap-8">
            <a href="{{ url('/') }}" class="text-[11px] font-bold uppercase tracking-widest text-gray-300 hover:text-white transition-colors relative group">
                Beranda
                <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-indigo-500 transition-all group-hover:w-full"></span>
            </a>
            @auth
                <a href="{{ route('user.dashboard') }}" class="text-[11px] font-bold uppercase tracking-widest text-gray-300 hover:text-white transition-colors relative group">
                    Katalog
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-indigo-500 transition-all group-hover:w-full"></span>
                </a>
                <a href="{{ route('user.enrolled') }}" class="text-[11px] font-bold uppercase tracking-widest text-gray-300 hover:text-white transition-colors relative group">
                    Kelas Saya
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-indigo-500 transition-all group-hover:w-full"></span>
                </a>
                
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="text-[11px] font-bold uppercase tracking-widest text-indigo-400 hover:text-indigo-300 transition-colors">
                        Admin Panel
                    </a>
                @endif
                
                <div class="pl-6 border-l border-white/10 ml-2 flex items-center gap-4">
                     <a href="{{ route('profile') }}" class="flex items-center gap-3 group">
                        <div class="w-9 h-9 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-bold border border-white/10 group-hover:border-indigo-400 transition-colors">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="text-right hidden lg:block">
                            <p class="text-[10px] font-bold text-white group-hover:text-indigo-300 transition-colors">{{ \Illuminate\Support\Str::limit(Auth::user()->name, 15) }}</p>
                            <p class="text-[9px] text-gray-500 uppercase tracking-widest">Student</p>
                        </div>
                    </a>
                </div>
            @else
                <a href="{{ route('login') }}" class="text-[11px] font-bold uppercase tracking-widest text-gray-300 hover:text-white transition-colors">Masuk</a>
                <a href="{{ route('register') }}" class="px-6 py-2.5 rounded-full text-[10px] font-black uppercase tracking-[0.1em] btn-primary text-white hover:scale-105 transition-transform shadow-lg shadow-indigo-500/20">
                    Daftar Gratis
                </a>
            @endauth
        </div>

        <!-- Mobile Menu Button -->
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-white p-2 hover:bg-white/10 rounded-lg transition-colors flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
    </div>

    <!-- Mobile Drawer -->
    <div x-show="mobileMenuOpen" 
         style="display: none;"
         class="fixed inset-0 z-[60]"
         role="dialog" aria-modal="true">
        
        <!-- Backdrop -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/80 backdrop-blur-sm" 
             @click="mobileMenuOpen = false"></div>

        <!-- Drawer Panel -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full"
             class="fixed inset-y-0 right-0 z-[70] w-full max-w-xs bg-[#0b0b11] border-l border-white/10 p-8 shadow-2xl flex flex-col">
            
            <div class="flex justify-between items-center mb-10 pb-6 border-b border-white/5">
                <span class="text-xl font-bold tracking-tight text-white">Menu</span>
                <button @click="mobileMenuOpen = false" class="p-2 text-gray-400 hover:text-white bg-white/5 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="flex flex-col gap-4 flex-1">
                <a href="{{ url('/') }}" class="flex items-center gap-4 p-4 rounded-xl bg-white/5 text-sm font-bold text-gray-300 hover:text-white hover:bg-indigo-600 transition-all">
                    <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Beranda
                </a>
                @auth
                    <a href="{{ route('user.dashboard') }}" class="flex items-center gap-4 p-4 rounded-xl bg-white/5 text-sm font-bold text-gray-300 hover:text-white hover:bg-indigo-600 transition-all">
                        <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        Katalog Kursus
                    </a>
                    <a href="{{ route('user.enrolled') }}" class="flex items-center gap-4 p-4 rounded-xl bg-white/5 text-sm font-bold text-gray-300 hover:text-white hover:bg-indigo-600 transition-all">
                        <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        Kelas Saya
                    </a>
                    <a href="{{ route('profile') }}" class="flex items-center gap-4 p-4 rounded-xl bg-white/5 text-sm font-bold text-gray-300 hover:text-white hover:bg-indigo-600 transition-all">
                        <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Profil Saya
                    </a>
                @else
                    <a href="{{ route('login') }}" class="flex items-center gap-4 p-4 rounded-xl bg-white/5 text-sm font-bold text-gray-300 hover:text-white hover:bg-indigo-600 transition-all">
                        <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                        Masuk
                    </a>
                @endauth
            </div>

            <div class="pt-6 border-t border-white/5">
                @auth
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="w-full py-4 rounded-xl bg-rose-500/10 text-rose-500 font-bold uppercase tracking-widest text-xs hover:bg-rose-500 hover:text-white transition-colors">
                            Keluar Akun
                        </button>
                    </form>
                @else
                    <a href="{{ route('register') }}" class="block w-full text-center py-4 rounded-xl bg-indigo-600 text-white font-bold uppercase tracking-widest text-xs hover:bg-indigo-500 transition-colors">
                        Daftar Gratis
                    </a>
                @endauth
                <p class="text-center text-[9px] text-gray-600 uppercase tracking-widest mt-6">© {{ date('Y') }} EduIde Platform</p>
            </div>
        </div>
    </div>
</nav>
