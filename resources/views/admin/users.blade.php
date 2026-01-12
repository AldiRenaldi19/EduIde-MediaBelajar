<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Users</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style> body{background:#050508;color:#fff;font-family:Inter,ui-sans-serif,system-ui,-apple-system,'Segoe UI',Roboto,'Helvetica Neue',Arial;} .glass{background:rgba(255,255,255,0.02);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.04)}</style>
</head>
<body class="p-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">User Management</h1>
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-300">Back to dashboard</a>
        </div>

        <div class="glass rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="text-xs text-gray-400 uppercase">
                        <tr><th class="p-4">Name</th><th class="p-4">Email</th><th class="p-4">Role</th><th class="p-4 text-right">Actions</th></tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($users as $user)
                        <tr>
                            <td class="p-4">{{ $user->name }}</td>
                            <td class="p-4 text-gray-300">{{ $user->email }}</td>
                            <td class="p-4">{{ $user->is_admin ? 'Admin' : 'User' }}</td>
                            <td class="p-4 text-right">
                                @if(auth()->id() !== $user->id)
                                <form action="{{ route('admin.users.toggleAdmin', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button class="px-4 py-2 bg-white/5 hover:bg-white/10 rounded">{{ $user->is_admin ? 'Demote' : 'Promote' }}</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-white/5">{{ $users->links() }}</div>
        </div>
    </div>
</body>
</html>
