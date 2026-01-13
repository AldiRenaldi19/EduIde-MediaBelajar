<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Kursus</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        h2 { text-align: center; margin-bottom: 20px; color: #1a1a2e; }
        .meta { text-align: center; margin-bottom: 30px; font-size: 10px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f3f4f6; font-weight: bold; color: #111; }
        tr:nth-child(even) { background-color: #f9fafb; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 9px; font-weight: bold; text-transform: uppercase; }
        .badge-published { background-color: #d1fae5; color: #065f46; }
        .badge-draft { background-color: #fef3c7; color: #92400e; }
    </style>
</head>
<body>
    <h2>Laporan Data Kursus - EduIde</h2>
    <div class="meta">
        Dicetak oleh: {{ auth()->user()->name }} | Tanggal: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WIB
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul Kursus</th>
                <th>Kategori</th>
                <th>Instruktur</th>
                <th>Harga</th>
                <th>Status</th>
                <th>Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
            <tr>
                <td>{{ $course->id }}</td>
                <td>{{ $course->title }}</td>
                <td>{{ $course->category->name ?? '-' }}</td>
                <td>{{ $course->author->name ?? '-' }}</td>
                <td>{{ $course->price > 0 ? 'Rp ' . number_format($course->price, 0, ',', '.') : 'GRATIS' }}</td>
                <td>
                    @if($course->is_published)
                        <span class="badge badge-published">Published</span>
                    @else
                        <span class="badge badge-draft">Draft</span>
                    @endif
                </td>
                <td>{{ $course->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="margin-top: 30px; text-align: right; font-size: 10px; font-style: italic;">
        Dokumen ini digenerate secara otomatis oleh sistem EduIde.
    </div>
</body>
</html>
