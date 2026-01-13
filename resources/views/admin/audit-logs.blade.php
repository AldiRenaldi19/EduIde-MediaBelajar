<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Audit Logs — Admin</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen relative pb-20" style="background-color: var(--bg-page); color: var(--text-main);">
    <x-navbar />

    <div class="fixed bottom-0 left-0 w-[500px] h-[500px] bg-purple-600/10 blur-[120px] rounded-full -z-10"></div>

    <div class="container max-w-6xl mx-auto px-6 mt-32">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight mb-2">Audit Logs</h1>
                <p class="text-[var(--text-muted)] text-sm">Rekam jejak aktivitas sistem.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-[10px] font-bold uppercase tracking-widest transition-all">
                ← Kembali
            </a>
        </div>

        {{-- Filters --}}
        <div class="glass-card p-6 rounded-[24px] mb-8 border border-white/5">
            <form method="GET" class="flex flex-col md:flex-row items-end gap-4">
                <div class="flex-1 w-full">
                    <label class="block text-[9px] font-bold uppercase tracking-widest text-gray-500 mb-2">Pencarian</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari aktivitas..." 
                           class="w-full bg-[#0a0a0f] border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 transition-colors text-white placeholder-gray-600">
                </div>
                
                <div class="w-full md:w-48">
                    <label class="block text-[9px] font-bold uppercase tracking-widest text-gray-500 mb-2">Tipe Aksi</label>
                    <div class="relative">
                        <select name="action" class="w-full appearance-none bg-[#0a0a0f] border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 transition-colors text-white cursor-pointer">
                            <option value="">Semua Aksi</option>
                            @foreach(($actions ?? []) as $act)
                                <option value="{{ $act }}" @if(request('action')==$act) selected @endif>{{ $act }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                            <svg class="fill-current h-3 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-auto flex gap-2">
                    <div>
                        <label class="block text-[9px] font-bold uppercase tracking-widest text-gray-500 mb-2">Dari</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="bg-[#0a0a0f] border border-white/10 rounded-xl px-4 py-2.5 text-xs focus:outline-none focus:border-indigo-500 text-white">
                    </div>
                    <div>
                        <label class="block text-[9px] font-bold uppercase tracking-widest text-gray-500 mb-2">Sampai</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}" class="bg-[#0a0a0f] border border-white/10 rounded-xl px-4 py-2.5 text-xs focus:outline-none focus:border-indigo-500 text-white">
                    </div>
                </div>

                <div class="flex gap-2">
                    <button class="px-6 py-3 bg-indigo-600 hover:bg-indigo-500 rounded-xl text-[10px] font-black uppercase tracking-widest text-white shadow-lg transition-all active:scale-95">Filter</button>
                    <a href="{{ route('admin.audit.logs') }}" class="px-6 py-3 bg-white/5 hover:bg-white/10 rounded-xl text-[10px] font-black uppercase tracking-widest text-gray-400 transition-all">Reset</a>
                </div>
            </form>
        </div>

        <div class="glass-card rounded-[30px] overflow-hidden border border-white/5 shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] uppercase tracking-widest text-gray-500 bg-white/[0.01] border-b border-white/5">
                            <th class="p-6 font-bold">Waktu</th>
                            <th class="p-6 font-bold">Admin</th>
                            <th class="p-6 font-bold">Aktivitas</th>
                            <th class="p-6 font-bold">Target</th>
                            <th class="p-6 font-bold">Detail JSON</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($logs as $log)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="p-6 text-xs font-mono text-gray-400">{{ $log->created_at->format('Y-m-d H:i') }}</td>
                            <td class="p-6">
                                <p class="text-xs font-bold text-white">{{ $log->admin->name ?? 'System' }}</p>
                                <p class="text-[9px] text-gray-500">{{ $log->admin->email ?? '' }}</p>
                            </td>
                            <td class="p-6">
                                <span class="px-2 py-1 bg-white/5 rounded-lg text-[10px] font-bold text-indigo-300 border border-white/10">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="p-6 text-xs text-gray-300">{{ $log->target_type }} <span class="text-gray-500">#{{ $log->target_id }}</span></td>
                            <td class="p-6">
                                <div class="relative group">
                                    <pre class="w-48 truncate text-[10px] text-gray-500 font-mono cursor-help group-hover:text-white transition-colors">{{ json_encode($log->details) }}</pre>
                                    {{-- Tooltip helper --}}
                                    <div class="absolute bottom-full left-0 mb-2 w-64 bg-black border border-white/20 p-3 rounded-xl hidden group-hover:block z-50 shadow-2xl">
                                        <pre class="whitespace-pre-wrap text-[9px] text-gray-300">{{ json_encode($log->details, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="p-12 text-center text-gray-500 text-xs uppercase tracking-widest">Tidak ada data log aktivitas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-6 border-t border-white/5">{{ $logs->links() }}</div>
        </div>
    </div>
</body>
</html>
