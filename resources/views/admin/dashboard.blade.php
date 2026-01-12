<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard — EduIde</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #050508; color: #ffffff; min-height: 100vh; }
        .glass-card { background: rgba(255, 255, 255, 0.02); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.05); }
        .table-row-hover:hover { background-color: rgba(255, 255, 255, 0.02); }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #050508; }
        ::-webkit-scrollbar-thumb { background: #1a1a2e; border-radius: 10px; }
    </style>
</head>
<body class="min-h-screen p-4 md:p-12 relative">
    <div class="fixed top-0 right-0 w-[500px] h-[500px] bg-indigo-600/10 blur-[120px] rounded-full -z-10"></div>
    
    <div class="max-w-6xl mx-auto">
        {{-- Notification --}}
        @if(session('success'))
            <div class="mb-8 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-2xl text-[10px] font-bold uppercase tracking-[0.2em] text-center">
                {{ session('success') }}
            </div>
        @endif

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">Admin <span class="text-indigo-500">Console</span></h1>
                <p class="text-gray-500 text-sm mt-2 font-medium italic">"Powering the future of education, one course at a time."</p>
            </div>
            <a href="{{ route('user.dashboard') }}" class="inline-flex items-center px-6 py-3 border border-white/10 rounded-2xl text-[10px] font-bold uppercase tracking-widest hover:bg-white/5 transition-all text-gray-400">
                Situs Utama
            </a>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-16">
            @foreach($stats as $stat)
            <div class="glass-card p-8 rounded-[35px] border-t border-white/10 relative overflow-hidden group">
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-{{ $stat['color'] ?? 'indigo' }}-500/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 mb-3">{{ $stat['label'] }}</p>
                <div class="flex items-baseline gap-2">
                    <p class="text-4xl md:text-5xl font-bold tracking-tighter text-white">{{ $stat['value'] }}</p>
                    <span class="text-{{ $stat['color'] ?? 'indigo' }}-500 text-[10px] font-black uppercase italic tracking-tighter">Unit Data</span>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Course Management --}}
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-xs font-black uppercase tracking-[0.3em] text-indigo-400 flex items-center gap-3">
                <span class="w-8 h-[1px] bg-indigo-500/30"></span> Manajemen Kursus
            </h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-white/5 hover:bg-white/10 rounded-2xl text-[10px] font-bold uppercase tracking-widest transition-all text-gray-300">Users</a>
                <a href="{{ route('admin.audit.logs') }}" class="px-4 py-2 bg-white/5 hover:bg-white/10 rounded-2xl text-[10px] font-bold uppercase tracking-widest transition-all text-gray-300">Audit Logs</a>
                <a href="{{ route('admin.courses.export') }}" class="px-4 py-2 bg-white/5 hover:bg-white/10 rounded-2xl text-[10px] font-bold uppercase tracking-widest transition-all text-gray-300">Export CSV</a>
                <a href="{{ route('admin.courses.create') }}" class="px-5 py-3 bg-indigo-600 hover:bg-indigo-500 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all shadow-xl shadow-indigo-600/20 active:scale-95">
                + Kursus Baru
            </a>
            </div>
        </div>

        <div class="glass-card rounded-[40px] overflow-hidden border border-white/5 shadow-2xl mb-16">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] uppercase tracking-widest text-gray-500 bg-white/[0.01]">
                            <th class="p-6 font-bold">Modul & Kategori</th>
                            <th class="p-6 font-bold">Instruktur</th>
                            <th class="p-6 font-bold">Status & Harga</th>
                            <th class="p-6 text-right font-bold">Kontrol</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($courses as $course)
                        <tr class="table-row-hover transition-all">
                            <td class="p-6">
                                <div class="flex items-center gap-4">
                                    <img src="{{ $course->thumbnail_url }}" 
                                         class="w-14 h-14 rounded-2xl object-cover border border-white/10 shadow-lg" 
                                         alt="{{ $course->title }}"
                                         onerror="this.src='https://placehold.co/600x400/1a1a2e/ffffff?text=Error';">
                                    <div>
                                        <p class="font-bold text-sm text-white">{{ $course->title }}</p>
                                        <p class="text-[9px] text-indigo-400 font-bold uppercase tracking-widest mt-1">
                                            {{ $course->category->name ?? 'Uncategorized' }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-6 text-xs text-gray-400 font-semibold italic">
                                {{ $course->author->name ?? 'Administrator' }}
                            </td>
                            <td class="p-6">
                                <div class="flex flex-col gap-1">
                                    <span class="text-[10px] font-black uppercase {{ $course->is_published ? 'text-emerald-400' : 'text-amber-400' }}">
                                        {{ $course->is_published ? '● Published' : '○ Draft' }}
                                    </span>
                                    <span class="text-[10px] text-gray-500 font-bold">
                                        {{ $course->price > 0 ? 'Rp ' . number_format($course->price, 0, ',', '.') : 'FREE' }}
                                    </span>
                                </div>
                            </td>
                            <td class="p-6 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.courses.edit', $course->id) }}" class="p-2.5 bg-white/5 hover:bg-white/10 text-gray-400 rounded-xl transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </a>
                                    <form action="{{ route('admin.courses.delete', $course->id) }}" method="POST" onsubmit="return confirm('Hapus kursus ini secara permanen?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2.5 bg-rose-500/10 hover:bg-rose-500 text-rose-500 hover:text-white rounded-xl transition-all border border-rose-500/10">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.courses.toggle', $course->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="p-2.5 bg-white/5 hover:bg-white/10 text-gray-400 rounded-xl transition-all">
                                            {{ $course->is_published ? 'Unpublish' : 'Publish' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="p-20 text-center opacity-40 text-[10px] font-bold uppercase tracking-[0.3em]">Data kursus kosong</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-6 border-t border-white/5">
                {{ $courses->links() }}
            </div>
        </div>

        {{-- Reviews Section --}}
        <h2 class="text-xs font-black uppercase tracking-[0.3em] text-indigo-400 mb-8 flex items-center gap-3">
            <span class="w-8 h-[1px] bg-indigo-500/30"></span> Moderasi Feedback
        </h2>
        
        <div class="glass-card rounded-[40px] overflow-hidden border border-white/5 shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] uppercase tracking-widest text-gray-500 bg-white/[0.01]">
                            <th class="p-6 font-bold">Profil Learner</th>
                            <th class="p-6 font-bold">Testimoni</th>
                            <th class="p-6 text-right font-bold">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($reviews as $review)
                        <tr class="table-row-hover transition-all">
                            <td class="p-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500/20 to-purple-600/20 flex items-center justify-center text-[10px] font-black text-indigo-400 border border-indigo-500/20">
                                        {{ strtoupper(substr($review->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-sm text-white">{{ $review->name }}</p>
                                        <p class="text-[9px] text-gray-600 uppercase tracking-tighter font-black italic">{{ $review->job }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-6">
                                <p class="text-gray-400 text-[11px] leading-relaxed max-w-md italic border-l-2 border-white/5 pl-4 py-1">
                                    "{{ Str::limit($review->message, 80) }}"
                                </p>
                            </td>
                            <td class="p-6 text-right">
                                <form action="{{ route('admin.reviews.delete', $review->id) }}" method="POST" onsubmit="return confirm('Hapus ulasan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-5 py-2.5 bg-white/5 hover:bg-rose-500 text-gray-400 hover:text-white rounded-xl text-[9px] font-black tracking-[0.2em] uppercase transition-all duration-300">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="p-20 text-center opacity-40 text-[10px] font-bold uppercase tracking-[0.3em]">Belum ada ulasan masuk</td></tr>
                        @endforelse
                    </tbody>
                </table>
            <div class="p-6 border-t border-white/5">
                {{ $reviews->links() }}
            </div>
            </div>
        </div>
        
        <div class="mt-16 text-center">
            <p class="text-gray-700 text-[9px] font-black uppercase tracking-[0.6em]">System Version 2.0.4 &bull; EduIde Ecosystem</p>
        </div>
    </div>
</body>
</html>