<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan User</title>
    <style>
        body{font-family:Arial,sans-serif;color:#111827;margin:24px}
        h1{font-size:22px;margin:0 0 4px}
        p{margin:0 0 18px;color:#64748b}
        table{width:100%;border-collapse:collapse;font-size:12px}
        th,td{border:1px solid #e5e7eb;padding:8px;text-align:left;vertical-align:top}
        th{background:#f8fafc;color:#334155}
        .badge{display:inline-block;padding:3px 7px;border-radius:999px;font-weight:700;font-size:11px}
        .active,.verified{background:#ecfdf5;color:#047857}
        .inactive,.unverified{background:#fff7ed;color:#c2410c}
        @media print{button{display:none}body{margin:0}}
    </style>
</head>
<body>
    <button onclick="window.print()">Cetak / Simpan PDF</button>
    <h1>Laporan User</h1>
    <p>Dicetak pada {{ now()->format('d M Y H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th>#</th><th>Nama</th><th>Username</th><th>Email</th><th>Role</th><th>Status</th><th>Email</th><th>Terdaftar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->roles->pluck('name')->implode(', ') ?: '-' }}</td>
                    <td><span class="badge {{ $user->status ? 'active' : 'inactive' }}">{{ $user->status ? 'Active' : 'Inactive' }}</span></td>
                    <td><span class="badge {{ $user->email_verified_at ? 'verified' : 'unverified' }}">{{ $user->email_verified_at ? 'Verified' : 'Unverified' }}</span></td>
                    <td>{{ optional($user->created_at)->format('d M Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>window.addEventListener('load', () => setTimeout(() => window.print(), 350));</script>
</body>
</html>
