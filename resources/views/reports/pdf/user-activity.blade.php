<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #1a1a1a; }
        h1 { font-size: 16px; margin-bottom: 2px; }
        p.subtitle { color: #666; margin-top: 0; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f3f4f6; text-align: left; padding: 6px 8px; font-size: 10px; text-transform: uppercase; }
        td { padding: 6px 8px; border-bottom: 1px solid #eee; }
    </style>
</head>
<body>
    <h1>Laporan Aktivitas Pengguna</h1>
    <p class="subtitle">Dicetak pada {{ now()->format('d M Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Waktu</th><th>Pengguna</th><th>Jenis</th><th>Produk</th><th>Jumlah</th><th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($activities as $activity)
                <tr>
                    <td>{{ $activity->created_at->format('d M Y H:i') }}</td>
                    <td>{{ $activity->user->name ?? '-' }}</td>
                    <td>{{ $activity->type }}</td>
                    <td>{{ $activity->product->name ?? '-' }}</td>
                    <td>{{ $activity->quantity }}</td>
                    <td>{{ $activity->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>