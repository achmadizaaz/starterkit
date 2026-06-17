<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Email Terverifikasi</th>
            <th>Terdaftar</th>
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
                <td>{{ $user->status ? 'Active' : 'Inactive' }}</td>
                <td>{{ $user->email_verified_at ? 'Verified' : 'Unverified' }}</td>
                <td>{{ optional($user->created_at)->format('Y-m-d H:i:s') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
