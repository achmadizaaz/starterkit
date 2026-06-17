<table>
    <thead>
        <tr>
            <th>No</th>
            <th>User</th>
            <th>Email</th>
            <th>IP Address</th>
            <th>Device</th>
            <th>Browser</th>
            <th>Login</th>
            <th>Logout</th>
            <th>Durasi</th>
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
                <td>{{ $activity->browser ?? '-' }}</td>
                <td>{{ optional($activity->login_at)->format('Y-m-d H:i:s') }}</td>
                <td>{{ optional($activity->logout_at)->format('Y-m-d H:i:s') ?? 'Belum logout' }}</td>
                <td>{{ $activity->login_at && $activity->logout_at ? $activity->login_at->diffForHumans($activity->logout_at, true) : '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
