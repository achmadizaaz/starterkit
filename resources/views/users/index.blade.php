@extends('layouts.main')

@section('title', 'Users')

@section('content')
    <!-- start page title -->
    <div class="card p-3">
        <div class="d-sm-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <div class="fs-4 fw-semibold">Users</div>
                <span class="fs-5">({{ $users->total()}})</span class="fs-5">
            </div>
            <div class="page-title-right">
                <a href="{{ route('users.create') }}" class="btn text-bg-primary">
                    <i class="bi bi-plus me-2"></i> Create a user
                </a>
            </div>
        </div>
    </div>
    <!-- end page title -->
    
    <!-- Alert Component-->
    <x-alert/>
    <!-- end Alert Component -->

    <!-- start page main -->
    <div class="card p-3">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2" style="width: 200px">
                <div class="fw-bold">
                    Show
                </div>
                <form action="{{ route('users.show.page')}}" method="GET">
                    <select name="show" onchange="this.form.submit()" class="form-select form-select-sm" style="max-width:80px">
                        <option value="10" @if (session('showPages') == 10)
                            selected
                        @endif>10</option>
                        <option value="25" @if (session('showPages') == 25)
                        selected
                        @endif>25</option>
                        <option value="50" @if (session('showPages') == 50)
                        selected
                        @endif>50</option>
                        <option value="100" @if (session('showPages') == 100)
                        selected
                        @endif>100</option>
                    </select>
                </form>
                <div class="fw-bold">
                    Entries
                </div>
            </div>
            <div class="d-flex gap-1">
                    {{-- Form Pencarian --}}
                    <form action="{{ route('users')}}" method="GET" class="d-flex gap-1">
                        <input type="text" name="search" class="form-control"  placeholder="Searching" value="{{request('search') }}">
                        <button type="submit" class="btn text-bg-primary">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>

                    {{-- Button Reset --}}
                    <a href="{{ route('users') }}" class="btn text-bg-info" title="Reset">
                        <i class="bi bi-circle"></i>
                    </a>
                    {{-- Button Recycle Bin --}}
                    <a href="{{ route('users.trashed') }}" class="btn text-bg-secondary" title="Recycle Bin">
                        <i class="bi bi-trash2"></i>
                    </a>
            </div>
        </div>
    </div>

    {{-- Card Table --}}
    <div class="card p-3">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <th>No</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Last login</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @empty ($users->count())
                        <tr>
                            <td class="text-center" colspan="8">
                                <div class="alert alert-warning" role="alert">
                                    No data available.
                                </div>
                            </td>
                        </tr>
                    @endempty
                    @foreach ($users as $user)
                        <tr>
                            <td class="align-middle">
                                {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                            </td>
                            <td class="align-middle">{{ $user->username }}</td>
                            <td class="align-middle">
                                @if (isset($user->image))
                                    <img src="{{ asset('storage/'.$user->image) }}" class="object-fit-cover border rounded-5 me-2" alt="{{ $user->username }}" height="40px" width="40px">
                                    @else
                                    <img src="{{ asset('assets/images/no-image.webp') }}" class="object-fit-cover border rounded-5 me-2"alt="{{ $user->username }}" height="40px" width="40px">
                                @endif
                                {{ $user->name }}
                            </td>
                            <td class="align-middle">{{ $user->email }}</td>
                            <td class="align-middle">
                                @if ($user->is_active)
                                <span class="badge bg-success-subtle text-success">Active</span>
                                @else
                                <span class="badge bg-danger-subtle text-danger">Non active</span>
                                @endif
                            </td>
                            <td class="align-middle">{!! $user->last_login_at ? $user->last_login_at->diffForHumans() : '<span class="fst-italic">Belum pernah login</span>'  !!}</td>
                            <td class="align-middle">
                                <div class="d-flex gap-1">
                                    {{-- Detail Button --}}
                                    <a href="{{ route('users.show', $user->slug) }}" class="btn btn-sm btn-info" title="Show detail user">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    {{-- Edit Button --}}
                                    <a href="{{ route('users.edit', $user->slug) }}" class="btn btn-sm text-bg-warning" title="Edit user">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    {{-- Change password button --}}
                                    <button type="button" class="btn btn-sm btn-success changePasswordUser" data-bs-toggle="modal" data-bs-target="#changePasswordUserModal" data-username="{{ $user->username }}" data-id="{{ $user->id }}" title="Change password user">
                                        <i class="bi bi-shield-lock"></i>
                                    </button>

                                    {{-- Delete button --}}
                                    <button type="button" class="btn btn-sm btn-danger confirm_delete" data-bs-toggle="modal" data-bs-target="#deleteModal" data-username="{{ $user->username }}" data-id="{{ $user->id }}" title="Delete user">
                                        <i class="bi bi-trash3"></i>
                                    </button>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-secondary">
                    <th>No</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Last login</th>
                    <th>Action</th>
                </tfoot class="bg-secondary">
            </table>
        </div>
    </div>
    <div class="d-flex flex-row-reverse">
        {{ $users->onEachSide(0)->appends(request()->input())->links('vendor.paginate') }}
    </div>
    <!-- end page main -->
</div>

<!-- Modal Change password user -->
<div class="modal fade" id="changePasswordUserModal" tabindex="-1" aria-labelledby="changePasswordUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="changePasswordUserModalLabel">Change Password: 
                <span class="text-success changePasswordUserName"></span>
            </h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" id="formChangePassword" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div class="mb-2">
                        Silakan masukan katasandi baru pengguna
                    </div>
                    <input type="text" class="form-control" name="change_password" placeholder="Enter a new password" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Change Password.</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete user -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="deleteModalLabel">Delete User</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" id="formDelete" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('DELETE')
                    <label for="confirm_delete" class="form-label">
                        Untuk melanjutkan penghapusan pengguna, silakan ketik: <span class="text-danger" id="modalUsername"></span>
                    </label>
                    <input type="text" class="form-control" name="confirm" id="confirm_delete" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-danger">Delete it.</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Change password
        $('.changePasswordUser').click(function(e) {
            let username = $(this).data('username');
            let id = $(this).data('id');
        
            $('.changePasswordUserName').html(username);
            
            // Route change password user
            let url = "{{ route('users.change.password', ':id') }}";
            route = url.replace(':id', id);
            // Action route for delete user
            $('#formChangePassword').attr('action', route);
        });

        // Delete user
        $('.confirm_delete').click(function(e) {
            let username = $(this).data('username');
            let id = $(this).data('id');
        
            $('#modalUsername').html(username);
            $('#confirm_delete').attr('placeholder', 'Ketikan: "'+username+'"')
            
            // Route delete user
            let url = "{{ route('users.delete', ':id') }}";
            route = url.replace(':id', id);
            // Action route for delete user
            $('#formDelete').attr('action', route);
        });
    </script>
@endpush