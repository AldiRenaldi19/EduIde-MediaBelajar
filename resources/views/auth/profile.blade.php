<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - EduIde</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen relative pb-20" style="background-color: var(--bg-page); color: var(--text-main);">
    <x-navbar />

    <div class="fixed top-0 left-0 w-[500px] h-[500px] bg-indigo-600/10 blur-[120px] rounded-full -z-10"></div>
    <div class="fixed bottom-0 right-0 w-[500px] h-[500px] bg-cyan-500/10 blur-[120px] rounded-full -z-10"></div>
    
    <div class="container mx-auto px-6 mt-32 max-w-4xl">
        <div class="inline-flex items-center gap-3 bg-white/5 px-5 py-2 rounded-full border border-white/10 mb-8 backdrop-blur-md">
            <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
            <span class="text-[10px] font-bold tracking-[0.3em] uppercase text-indigo-400">EduIde Learner Profile</span>
        </div>

        <div class="glass-card rounded-[40px] p-8 md:p-12 relative overflow-hidden shadow-2xl">
            {{-- Header Profile --}}
            <div class="flex flex-col md:flex-row items-center gap-10 mb-12 relative z-10">
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-[40px] blur opacity-40 group-hover:opacity-75 transition duration-1000"></div>
                    @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatar }}" class="relative w-36 h-36 rounded-[36px] object-cover border-2 border-white/10 shadow-2xl">
                    @else
                        <div class="relative w-36 h-36 rounded-[36px] bg-gradient-to-br from-indigo-600 to-purple-700 flex items-center justify-center text-5xl font-extrabold text-white shadow-2xl border border-white/10">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    @endif
                    <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-emerald-500 border-4 border-[#0a0a0f] rounded-full shadow-lg flex items-center justify-center" title="Online">
                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                    </div>
                </div>

                <div class="text-center md:text-left flex-1">
                    <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-2 text-white">{{ auth()->user()->name }}</h1>
                    <p class="text-[var(--text-muted)] text-sm font-medium mb-6 italic">"Terus belajar, terus tumbuh bersama EduIde."</p>
                    
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-3">
                        <span class="px-4 py-1.5 bg-white/5 border border-white/10 rounded-xl text-[10px] font-black text-indigo-300 uppercase tracking-widest">
                            UID-{{ str_pad(auth()->user()->id, 4, '0', STR_PAD_LEFT) }}
                        </span>
                        @if(auth()->user()->is_admin)
                            <span class="px-4 py-1.5 bg-indigo-500/20 border border-indigo-500/30 rounded-xl text-[10px] font-black text-indigo-400 uppercase tracking-widest shadow-[0_0_15px_rgba(99,102,241,0.3)]">Administrator</span>
                        @else
                            <span class="px-4 py-1.5 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-[10px] font-black text-emerald-400 uppercase tracking-widest">Learner</span>
                        @endif
                        <span class="px-4 py-1.5 bg-white/5 border border-white/10 rounded-xl text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                            Joined {{ auth()->user()->created_at->format('M Y') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Stats Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-12">
                <div class="p-6 rounded-[24px] bg-white/5 border border-white/5 hover:border-white/10 transition-colors group">
                    <div class="flex items-start justify-between mb-4">
                        <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Email Account</span>
                        <div class="p-2 bg-indigo-500/10 rounded-lg text-indigo-400 group-hover:text-white group-hover:bg-indigo-500 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        </div>
                    </div>
                    <span class="text-base text-gray-200 font-bold break-all tracking-tight">{{ auth()->user()->email }}</span>
                </div>
                
                <div class="p-6 rounded-[24px] bg-white/5 border border-white/5 hover:border-white/10 transition-colors group">
                     <div class="flex items-start justify-between mb-4">
                        <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Learning Progress</span>
                        <div class="p-2 bg-purple-500/10 rounded-lg text-purple-400 group-hover:text-white group-hover:bg-purple-500 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        </div>
                    </div>
                    <span class="text-base text-gray-200 font-bold tracking-tight">{{ auth()->user()->courses()->count() }} Course Enrolled</span>
                </div>
            </div>

            {{-- Actions --}}
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('profile.edit') }}" class="py-5 bg-indigo-600 hover:bg-indigo-500 text-white text-center rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all shadow-xl shadow-indigo-600/20 active:scale-95 flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        Edit Profil
                    </a>
                    <a href="{{ route('password.change') }}" class="py-5 bg-white/5 hover:bg-white/10 border border-white/10 text-white text-center rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all active:scale-95 flex items-center justify-center gap-2">
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        Ubah Password
                    </a>
                </div>

                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="block w-full py-5 bg-gradient-to-r from-gray-800 to-gray-900 border border-white/10 hover:border-indigo-500/50 text-indigo-400 text-center rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all shadow-lg active:scale-95">
                        Access Admin Dashboard
                    </a>
                @endif

                <form action="{{ route('logout') }}" method="POST" class="pt-6 border-t border-white/5 mt-6">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 text-rose-500 hover:text-rose-400 text-[10px] font-black uppercase tracking-[0.2em] transition-colors group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        Log Out Session
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>