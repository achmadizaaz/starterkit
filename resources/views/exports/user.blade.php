<table>
    <thead>
    <tr>
        <th style="background-color:#FFFF00;font-weight:bold">No</th>
        <th style="background-color:#FFFF00;font-weight:bold">Username</th>
        <th style="background-color:#FFFF00;font-weight:bold">Name</th>
        <th style="background-color:#FFFF00;font-weight:bold">Email</th>
        <th style="background-color:#FFFF00;font-weight:bold">Status</th>
        <th style="background-color:#FFFF00;font-weight:bold">Role</th>
        <th style="background-color:#FFFF00;font-weight:bold">Last login at</th>
        <th style="background-color:#FFFF00;font-weight:bold">Last login ip</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $user->username }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->is_active ? 'Active' : 'Non active'; }}</td>
            <td>
                @if ($role == 'semua')
                        {{ count($user->roles->pluck('name')) > 0 ? str_replace('"', ' ',trim($user->roles->pluck('name'), '[]')) : '-'  }}
                    @else
                        {{ $role }}
                @endif
            </td>
            <td>{{ $user->last_login_at ?? '-' }}</td>
            <td>{{ $user->last_login_ip ?? '-' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>