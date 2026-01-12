<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $module->title }} - {{ $course->title }} | EduIde</title>
    
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
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .active-module {
            background: rgba(79, 70, 229, 0.1) !important;
            border-left: 3px solid rgb(79, 70, 229) !important;
        }

        .prose {
            color: #e5e7eb;
            line-height: 1.8;
        }

        .prose h2 {
            font-size: 1.875rem;
            font-weight: 700;
            margin-top: 1.5rem;
            margin-bottom: 1rem;
            color: #ffffff;
        }

        .prose h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-top: 1.25rem;
            margin-bottom: 0.75rem;
            color: #f3f4f6;
        }

        .prose p {
            margin-bottom: 1rem;
        }

        .prose ul, .prose ol {
            margin-left: 1.5rem;
            margin-bottom: 1rem;
        }

        .prose li {
            margin-bottom: 0.5rem;
        }

        .prose code {
            background: rgba(79, 70, 229, 0.1);
            color: #a5b4fc;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-family: 'Courier New', monospace;
        }

        .prose pre {
            background: rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem;
            border-radius: 0.5rem;
            overflow-x: auto;
            margin-bottom: 1rem;
        }

        .prose blockquote {
            border-left: 4px solid rgb(79, 70, 229);
            padding-left: 1rem;
            color: #9ca3af;
            italic: true;
            margin: 1rem 0;
        }

        .module-button {
            transition: all 0.3s ease;
        }

        .module-button:hover {
            background: rgba(79, 70, 229, 0.2);
            border-color: rgb(79, 70, 229);
        }
    </style>
</head>
<body class="min-h-screen">
    {{-- Navigation Top --}}
    <nav class="glass-nav sticky top-0 z-50">
        <div class="container mx-auto px-4 md:px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('user.dashboard') }}" class="flex items-center gap-2 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="text-sm font-bold text-gray-400 group-hover:text-white transition-colors">Kembali ke Katalog</span>
                </a>

                <div class="flex items-center gap-4">
                    <div class="text-center hidden sm:block">
                        <p class="text-[10px] font-black uppercase tracking-widest text-indigo-400">{{ $course->title }}</p>
                        <p class="text-xs font-bold text-gray-300">{{ $module->title }}</p>
                    </div>

                    @auth
                        <a href="{{ route('profile') }}" class="p-2 rounded-lg bg-white/5 hover:bg-white/10 border border-white/10 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 md:px-6 py-8 md:py-12">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 md:gap-8">
            {{-- Sidebar - Module List --}}
            <div class="lg:col-span-1">
                <div class="glass-card rounded-[24px] p-6 border border-white/10 sticky top-[80px]">
                    <h3 class="text-sm font-black uppercase tracking-widest text-gray-400 mb-4">📚 Modul Pembelajaran</h3>
                    
                    <div class="space-y-2 max-h-[60vh] overflow-y-auto">
                        @forelse($modules as $mod)
                            <a href="{{ route('user.learn', [$course->slug, $mod->id]) }}" 
                               class="module-button block p-3 rounded-[12px] border border-white/10 text-[12px] font-bold uppercase tracking-wider transition-all {{ $module->id === $mod->id ? 'active-module bg-indigo-500/20 text-indigo-300' : 'text-gray-400 hover:text-white' }}">
                                <div class="flex items-start gap-2">
                                    <span class="text-lg">{{ $mod->order }}.</span>
                                    <span class="line-clamp-2 text-left">{{ $mod->title }}</span>
                                </div>
                            </a>
                        @empty
                            <p class="text-xs text-gray-500 text-center py-4">Belum ada modul</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="lg:col-span-3">
                {{-- Module Header --}}
                <div class="mb-8">
                    <div class="mb-4 flex items-center gap-3">
                        <span class="px-3 py-1 bg-indigo-600/20 border border-indigo-500/30 rounded-full text-indigo-300 text-[10px] font-black uppercase tracking-wider">
                            Modul {{ $module->order }} dari {{ $modules->count() }}
                        </span>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-black tracking-tight mb-4">
                        {{ $module->title }}
                    </h1>
                    <div class="flex items-center gap-4 text-gray-400 text-sm">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Waktu Belajar: ~15 menit</span>
                        </div>
                    </div>
                </div>

                {{-- Module Content --}}
                <div class="glass-card rounded-[32px] p-8 md:p-12 border border-white/10 mb-8 prose">
                    {!! nl2br(e($module->content)) !!}
                </div>

                {{-- Navigation Buttons --}}
                <div class="grid grid-cols-2 gap-4 md:grid-cols-2">
                    @if($previousModule)
                        <a href="{{ route('user.learn', [$course->slug, $previousModule->id]) }}" 
                           class="flex items-center gap-2 justify-center p-4 bg-white/5 hover:bg-white/10 border border-white/10 rounded-[16px] text-sm font-bold uppercase tracking-wider transition-all text-gray-300 hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            <span>Modul Sebelumnya</span>
                        </a>
                    @else
                        <div class="p-4 bg-white/5 border border-white/10 rounded-[16px] opacity-50 cursor-not-allowed">
                            <span class="text-xs text-gray-500">Tidak ada modul sebelumnya</span>
                        </div>
                    @endif

                    @if($nextModule)
                        <a href="{{ route('user.learn', [$course->slug, $nextModule->id]) }}" 
                           class="flex items-center gap-2 justify-center p-4 bg-indigo-600 hover:bg-indigo-500 border border-indigo-500/50 rounded-[16px] text-sm font-bold uppercase tracking-wider transition-all text-white active:scale-95 shadow-lg shadow-indigo-600/20">
                            <span>Modul Berikutnya</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('user.enrolled') }}" 
                           class="flex items-center gap-2 justify-center p-4 bg-emerald-600 hover:bg-emerald-500 border border-emerald-500/50 rounded-[16px] text-sm font-bold uppercase tracking-wider transition-all text-white active:scale-95 shadow-lg shadow-emerald-600/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Selesai</span>
                        </a>
                    @endif
                </div>

                {{-- Course Info Card --}}
                <div class="mt-12 glass-card rounded-[24px] p-6 border border-white/10">
                    <div class="flex items-center gap-4">
                        <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}" 
                             class="w-16 h-16 rounded-[12px] object-cover border border-white/10 shadow-lg">
                        <div class="flex-grow">
                            <h4 class="font-bold text-white">{{ $course->title }}</h4>
                            <p class="text-sm text-gray-400">{{ $course->category->name ?? 'Uncategorized' }}</p>
                        </div>
                        <a href="{{ route('user.modules', $course->slug) }}" class="px-4 py-2 bg-indigo-600/20 hover:bg-indigo-600/30 border border-indigo-500/30 rounded-lg text-indigo-300 text-xs font-bold uppercase tracking-wider transition-all">
                            Lihat Semua
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
