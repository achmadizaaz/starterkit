@extends('layouts.main')

@section('title', 'Roles')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="card p-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Roles</h4>
                <div class="page-title-right">
                    <div class="page-title-right">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRoleModal">
                            <i class="bi bi-plus me-2"></i> Create a role
                        </button>

                        <!-- Modal Create Role -->
                        <div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="createRoleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('roles.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="createRoleModalLabel">Create a role</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="name" class="form-lavel">Name <span class="fst-italic">*</span></label>
                                                <input type="text" class="form-control" name="name" placeholder="Enter name role" value="{{ old('name') }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="isAdmin" class="form-label me-1">Is admin</label>
                                                <select name="admin" id="isAdmin" class="form-select">
                                                    <option value="non_admin">Non Admin</option>
                                                    <option value="admin">Admin</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="level" class="form-lavel">Level <span class="fst-italic">*</span></label>
                                                <input type="number" class="form-control" name="level" min="1" max="10" placeholder="Enter level role" value="{{ old('level', 1) }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-plus me-2"></i> Create
                                            </button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Tutup
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- Alert  -->
        {{-- Alert Success --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        {{-- Alert Failed --}}
        @if (session('failed'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i> {{ session('failed') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <h5 class="alert-heading">
                    <i class="bi bi-exclamation-circle me-2"></i>  Errors:
                </h5>
                {{-- Button close --}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <hr>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- end Alert -->

        <!-- start page main -->
        <div class="card p-3">
            <div class="d-flex justify-content-between mb-2">
                <div class="d-flex align-items-center" style="width: 250px">
                    <div class="me-2 fw-bold">
                        Show :
                    </div>
                    <form action="{{ route('roles.show.page')}}" method="GET">
                        <select name="show" onchange="this.form.submit()" class="form-select form-select-sm" style="width: 100px">
                            <option value="10" @if (session('showPageRoles') == 10)
                                selected
                            @endif>10</option>
                            <option value="25" @if (session('showPageRoles') == 25)
                            selected
                            @endif>25</option>
                            <option value="50" @if (session('showPageRoles') == 50)
                            selected
                            @endif>50</option>
                            <option value="100" @if (session('showPageRoles') == 100)
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
                    <form action="{{ route('roles')}}" method="GET" class="d-flex gap-1">
                        <input type="text" name="search" class="form-control"  placeholder="Searching" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>

                    {{-- Button Reset --}}
                    <a href="{{ route('roles') }}" class="btn btn-info text-white" title="Reset">
                        <i class="bi bi-circle"></i>
                    </a>
               </div>
            </div>
            <table class="table">
                <thead>
                    <th>No</th>
                    <th>Name</th>
                    <th>Is Admin</th>
                    <th>Level</th>
                    <th>Created at</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    {{-- Jika tidak ada data role --}}
                    @empty ($roles->count())
                        <tr>
                            <td class="text-center" colspan="8">
                                <div class="alert alert-warning" role="alert">
                                    No data available.
                                  </div>
                            </td>
                        </tr>
                    @endempty

                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ ($roles->currentPage() - 1) * $roles->perPage() + $loop->iteration }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{!! $role->is_admin ? '<span class="badge text-bg-primary">Admin</span>' : ' <span class="badge text-bg-secondary">Non admin</span>' !!}</td>
                            <td>{{ $role->level }}</td>
                            <td>{{ $role->created_at }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    {{-- Edit Button --}}
                                    <button type="button" class="btn btn-sm btn-warning confirm_edit" data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{ $role->id }}" data-name="{{ $role->name }}" data-level="{{ $role->level }}" data-admin="{{ $role->is_admin }}" title="Edit role">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    {{-- Delete button --}}
                                    <button type="button" class="btn btn-sm btn-danger confirm_delete" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $role->id }}" data-name="{{ $role->name }}"  title="Delete role">
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
                    Total : ({{ $roles->total()}} / Roles)
                </div>
                <div class="d-flex align-items-center flex-row-reverse">
                    {{ $roles->onEachSide(0)->appends(request()->input())->links('vendor.paginate') }}
                </div>
            </div>
        </div>
        <!-- end page main -->
    </div>

    <!-- Modal Edit Role -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="POST" id="formUpdate">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editModalLabel">Edit Role</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-lavel">Name <span class="fst-italic">*</span></label>
                            <input type="text" class="form-control" name="name" required id="editName">
                        </div>
                        <div class="mb-3">
                            <label for="editAdmin" class="form-lavel">Admin <span class="fst-italic">*</span></label>
                            <select name="admin" id="editAdmin" class="form-select">
                                <option value="non_admin">Non admin</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="level" class="form-lavel">Level <span class="fst-italic">*</span></label>
                            <input type="number" class="form-control" name="level" min="1" max="10" required id="editLevel">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-save me-1"></i> Update
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END Modal Edit Role -->

    <!-- Modal Delete Role -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteModalLabel">Delete Role</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" id="formDelete" method="POST">
                    <div class="modal-body">
                        @csrf
                        @method('DELETE')
                        <label for="confirm_delete" class="form-label">
                            Untuk melanjutkan penghapusan role, silakan ketik: <span id="modalName"></span>
                        </label>
                        <input type="text" class="form-control" name="confirm" id="confirm_delete" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Delete it.</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Edit Modal
        $('.confirm_edit').click(function(e) {
            let name = $(this).data('name');
            let level = $(this).data('level');
            let id = $(this).data('id');
            let isAdmin = $(this).data('admin');
            // Insert Value Role
            $('#editName').val(name);
            $('#editLevel').val(level);
            $('#editAdmin').val(isAdmin ? 'admin' : 'non_admin');
            $('#editAdmin').trigger('change');

            // Route update
            let url = "{{ route('roles.update', ':id') }}";
            route = url.replace(':id', id);
            // Action route for update
            $('#formUpdate').attr('action', route);
        });

        // Delete Modal
        $('.confirm_delete').click(function(e) {
            let name = $(this).data('name');
            let id = $(this).data('id');
            $('#modalName').html(name);
            $('#confirm_delete').attr('placeholder', 'Ketikan: "'+name+'"')
            // Route delete
            let url = "{{ route('roles.delete', ':id') }}";
            route = url.replace(':id', id);
            // Action route for delete user
            $('#formDelete').attr('action', route);
        });
    </script>
@endpush