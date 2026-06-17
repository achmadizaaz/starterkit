<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Aktivitas Login / Logout</title>
    <style>
        body{font-family:Arial,sans-serif;color:#111827;margin:24px}
        h1{font-size:22px;margin:0 0 4px}
        p{margin:0 0 18px;color:#64748b}
        table{width:100%;border-collapse:collapse;font-size:11px}
        th,td{border:1px solid #e5e7eb;padding:7px;text-align:left;vertical-align:top}
        th{background:#f8fafc;color:#334155}
        .badge{display:inline-block;padding:3px 7px;border-radius:999px;font-weight:700;font-size:10px;background:#fff7ed;color:#c2410c}
        @media print{button{display:none}body{margin:0}}
    </style>
</head>
<body>
    <button onclick="window.print()">Cetak / Simpan PDF</button>
    <h1>Laporan Aktivitas Login / Logout</h1>
    <p>Dicetak pada {{ now()->format('d M Y H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th>#</th><th>User</th><th>Email</th><th>IP</th><th>Device</th><th>Login</th><th>Logout</th><th>Durasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activities as $activity)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $activity->user?->name ?? 'User terhapus' }}</td>
                    <td>{{ $activity->user?->email ?? '-' }}</td>
                    <td>{{ $activity->ip_address ?? '-' }}</td>
                    <td>{{ $activity->device ?? '-' }}</td>
                    <td>{{ optional($activity->login_at)->format('d M Y H:i:s') }}</td>
                    <td>{!! $activity->logout_at ? e($activity->logout_at->format('d M Y H:i:s')) : '<span class="badge">Belum logout</span>' !!}</td>
                    <td>{{ $activity->login_at && $activity->logout_at ? $activity->login_at->diffForHumans($activity->logout_at, true) : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>window.addEventListener('load', () => setTimeout(() => window.print(), 350));</script>
</body>
</html>
