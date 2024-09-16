@extends('layouts.main')

@section('title', 'Recycle Bin Users')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="card p-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Recycle Bin: Users</h4>
                <div class="page-title-right">
                    <!-- Button restore all modal -->
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#restoreAllModal">
                        <i class="bi bi-arrow-counterclockwise me-2"></i>Restore
                    </button>
                    <!-- Modal -->
                    
                    <div class="modal fade" id="restoreAllModal" tabindex="-1" aria-labelledby="restoreAllModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('users.restore.all') }}" method="POST">
                                @method('PUT')
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5 text-success" id="restoreAllModalLabel">Restore All Users</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            Apakah anda yakin ingin memulihkan semua pengguna?
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success">Restore All</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Button delete permanent all modal -->
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAllModal">
                        <i class="bi bi-trash2 me-2"></i>Permanent
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="deleteAllModal" tabindex="-1" aria-labelledby="deleteAllModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('users.force.delete.all') }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5 text-danger" id="deleteAllModalLabel">Delete Permanent</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-2">
                                            Apakah anda yakin ingin menghapus semua pengguna secara permanen?
                                        </div>
                                        <small class="fst-italic text-danger"><span class="fw-bold">Warning</span>: Semua data yang telah dihapus secara permanen tidak dapat dipulihkan kembali.</small>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger">Delete All</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Kembali Button --}}
                    <a href="{{ route('users') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-bar-left me-2"></i>Back
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
            <div class="d-flex justify-content-between mb-2">
                <div class="d-flex align-items-center" style="width: 250px">
                    <div class="me-2 fw-bold">
                        Show :
                    </div>
                    <form action="{{ route('users.show.page')}}" method="GET">
                        <select name="show" onchange="this.form.submit()" class="form-select form-select-sm" style="width: 100px">
                            <option value="10" @if (session('showPageUsers') == 10)
                                selected
                            @endif>10</option>
                            <option value="25" @if (session('showPageUsers') == 25)
                            selected
                            @endif>25</option>
                            <option value="50" @if (session('showPageUsers') == 50)
                            selected
                            @endif>50</option>
                            <option value="100" @if (session('showPageUsers') == 100)
                            selected
                            @endif>100</option>
                        </select>
                    </form>
                    <div class="ms-2 fw-bold">
                        Data
                    </div>
                </div>
               <div class="d-flex gap-1">
                    {{-- Input Pencarian --}}
                    <form action="{{ route('users.trashed')}}" method="GET" class="d-flex gap-1">
                        <input type="text" name="search" class="form-control"  placeholder="Searching" value="{{request('search') }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>

                    {{-- Button Reset --}}
                    <a href="{{ route('users.trashed') }}" class="btn btn-info text-white" title="Reset">
                        <i class="bi bi-circle"></i>
                    </a>
  
               </div>
            </div>
            
            <table class="table">
                <thead>
                    <th>No</th>
                    <th>Image</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Is active?</th>
                    <th>Last login</th>
                    <th>Deleted at</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach ($trashed as $user)
                        <tr>
                            <td class="align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">
                                @if (isset($user->image))
                                    <img src="{{ asset('storage/'.$user->image) }}" class="object-fit-cover border rounded-5" alt="{{ $user->username }}" height="40px" width="40px">
                                    @else
                                    <img src="{{ asset('assets/images/no-image.webp') }}" class="object-fit-cover border rounded-5"alt="{{ $user->username }}" height="40px" width="40px">
                                @endif
                            </td>
                            <td class="align-middle">{{ $user->username }}</td>
                            <td class="align-middle">{{ $user->name }}</td>
                            <td class="align-middle">{{ $user->email }}</td>
                            <td class="align-middle">{{ $user->is_active ? 'Active' : 'Non active' }}</td>
                            <td class="align-middle">{!! $user->last_login_at ? $user->last_login_at->diffForHumans() : '<span class="fst-italic">Belum pernah login</span>'  !!}</td>
                            <td class="align-middle">{{ $user->deleted_at->diffForHumans() }}</td>
                            <td class="align-middle">
                                <div class="d-flex gap-1">
                                    {{-- Change restore button --}}
                                    <button type="button" class="btn btn-sm btn-success restoreUser" data-bs-toggle="modal" data-bs-target="#restoreUserModal" data-username="{{ $user->username }}" data-id="{{ $user->id }}" title="Restore user">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </button>

                                    {{-- Delete permanent button --}}
                                    <button type="button" class="btn btn-sm btn-danger confirm_delete" data-bs-toggle="modal" data-bs-target="#deleteModal" data-username="{{ $user->username }}" data-id="{{ $user->id }}" title="Delete user">
                                        <i class="bi bi-trash3"></i>
                                    </button>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-between">
                <div class="py-2">
                    Total : ({{ $trashed->total()}} / Users)
                </div>
                <div class="d-flex align-items-center flex-row-reverse">
                    {{ $trashed->onEachSide(0)->links('vendor.paginate') }}
                </div>
            </div>
        </div>
        <!-- end page main -->
    </div>

    <!-- Modal Change password user -->
    <div class="modal fade" id="restoreUserModal" tabindex="-1" aria-labelledby="restoreUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="restoreUserModalLabel">Restore user: 
                    <span class="text-success restoreUserName"></span>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" id="formRestoreUser" method="POST">
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <div class="mb-2">
                           Apakah anda ingin memulihkan pengguna <span class="restoreUserName"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Restore</button>
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
                        <div class="mb-2">Apakah anda yakin ingin menghapus pengguna <span class="text-danger" id="modalUsername"></span> secara permanen?</div>
                        <small class="fst-italic text-danger"><span class="fw-bold">Warning</span>: Data yang telah dihapus secara permanen tidak dapat dipulihkan!</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete Permanent</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>

 // Change password
        $('.restoreUser').click(function(e) {
            let username = $(this).data('username');
            let id = $(this).data('id');
        
            $('.restoreUserName').html(username);
            
            // Route delete user
            let url = "{{ route('users.restore', ':id') }}";
            route = url.replace(':id', id);
            // Action route for delete user
            $('#formRestoreUser').attr('action', route);
        });
            
        // Delete user
        $('.confirm_delete').click(function(e) {
            let username = $(this).data('username');
            let id = $(this).data('id');
        
            $('#modalUsername').html(username);
            $('#confirm_delete').attr('placeholder', 'Ketikan: "'+username+'"')
            
            // Route delete user
            let url = "{{ route('users.force.delete', ':id') }}";
            route = url.replace(':id', id);
            // Action route for delete user
            $('#formDelete').attr('action', route);
        });
    </script>
@endpush