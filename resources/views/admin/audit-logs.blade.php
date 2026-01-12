<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Audit Logs — Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>body{background:#050508;color:#fff;font-family:Inter,system-ui;} .glass{background:rgba(255,255,255,0.02);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.04)}</style>
</head>
<body class="p-8">
  <div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold">Audit Logs</h1>
      <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-300">Back</a>
    </div>

    <form method="GET" class="mb-4">
      <input type="text" name="search" value="{{ request('search') }}" placeholder="Search action, admin, target..." class="px-4 py-2 rounded w-96 bg-white/5" />
      <button class="px-4 py-2 ml-2 rounded bg-indigo-600">Search</button>
    </form>

    <div class="glass rounded overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-left">
          <thead class="text-xs text-gray-400 uppercase">
            <tr>
              <th class="p-4">When</th>
              <th class="p-4">Admin</th>
              <th class="p-4">Action</th>
              <th class="p-4">Target</th>
              <th class="p-4">Details</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            @forelse($logs as $log)
            <tr>
              <td class="p-4 text-sm text-gray-300">{{ $log->created_at->format('Y-m-d H:i') }}</td>
              <td class="p-4 text-sm">{{ $log->admin->name ?? 'System' }}<div class="text-xs text-gray-500">{{ $log->admin->email ?? '' }}</div></td>
              <td class="p-4 text-sm font-bold">{{ $log->action }}</td>
              <td class="p-4 text-sm">{{ $log->target_type }} {{ $log->target_id ? '#'.$log->target_id : '' }}</td>
              <td class="p-4 text-sm text-gray-300"><pre class="whitespace-pre-wrap">{{ json_encode($log->details, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre></td>
            </tr>
            @empty
            <tr><td colspan="5" class="p-8 text-center text-gray-400">No audit logs found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="p-4 border-t border-white/5">{{ $logs->links() }}</div>
    </div>
  </div>
</body>
</html>
