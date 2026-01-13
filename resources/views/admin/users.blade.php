<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Users</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen relative pb-20" style="background-color: var(--bg-page); color: var(--text-main);">
    <x-navbar />

    <div class="fixed top-0 right-0 w-[500px] h-[500px] bg-indigo-600/10 blur-[120px] rounded-full -z-10"></div>

    <div class="container max-w-6xl mx-auto px-6 mt-32">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight mb-2">User Management</h1>
                <p class="text-[var(--text-muted)] text-sm">Kelola akses dan role pengguna.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-[10px] font-bold uppercase tracking-widest transition-all">
                ← Kembali
            </a>
        </div>

        <div class="glass-card rounded-[30px] overflow-hidden border border-white/5 shadow-2xl">
            {{-- Search Bar could go here --}}
            <div class="p-6 border-b border-white/5 bg-white/[0.02]">
                <form action="{{ route('admin.users.index') }}" method="GET" class="relative max-w-md">
                    <input type="text" name="search" placeholder="Cari nama atau email..." value="{{ request('search') }}" 
                           class="w-full bg-[#0a0a0f] border border-white/10 rounded-xl pl-5 pr-12 py-3 text-xs focus:outline-none focus:border-indigo-500 transition-colors text-white placeholder-gray-600">
                    <button type="submit" class="absolute right-2 top-2 p-1.5 bg-indigo-500/10 text-indigo-400 rounded-lg hover:bg-indigo-500 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </button>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] uppercase tracking-widest text-gray-500 bg-white/[0.01] border-b border-white/5">
                            <th class="p-6 font-bold">User</th>
                            <th class="p-6 font-bold">Role Access</th>
                            <th class="p-6 font-bold text-right">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($users as $user)
                        <tr class="group hover:bg-white/[0.02] transition-colors">
                            <td class="p-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500/20 to-purple-600/20 flex items-center justify-center text-xs font-black text-indigo-400 border border-indigo-500/20 shadow-lg">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-sm text-[var(--text-main)]">{{ $user->name }}</p>
                                        <p class="text-xs text-[var(--text-muted)]">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-6">
                                @if($user->is_admin)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-indigo-500/10 border border-indigo-500/20 rounded-lg text-[9px] font-black text-indigo-400 uppercase tracking-widest shadow-[0_0_10px_rgba(99,102,241,0.2)]">
                                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-pulse"></span> Administrator
                                    </span>
                                @else
                                    <span class="inline-block px-3 py-1 bg-white/5 border border-white/10 rounded-lg text-[9px] font-bold text-gray-400 uppercase tracking-widest">
                                        Learner
                                    </span>
                                @endif
                            </td>
                            <td class="p-6 text-right">
                                @if(auth()->id() !== $user->id)
                                <form action="{{ route('admin.users.toggleAdmin', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button class="px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 text-gray-300 rounded-xl text-[9px] font-bold uppercase tracking-widest transition-all {{ $user->is_admin ? 'hover:text-amber-400 hover:border-amber-400/30' : 'hover:text-indigo-400 hover:border-indigo-400/30' }}">
                                        {{ $user->is_admin ? 'Demote Access' : 'Promote Admin' }}
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-6 border-t border-white/5">{{ $users->links() }}</div>
        </div>
    </div>
</body>
</html>
