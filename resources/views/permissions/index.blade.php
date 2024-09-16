@extends('layouts.main')

@section('title', 'Permission')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="card p-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Permission</h4>
                <div class="page-title-right">
                    <div class="page-title-right">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRoleModal">
                            <i class="bi bi-plus me-2"></i>Create a permission
                        </button>

                        <!-- Modal Create Permission -->
                        <div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="createRoleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('permissions.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="createRoleModalLabel">Create a permission</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="name" class="form-lavel">Name <span class="fst-italic">*</span></label>
                                                <input type="text" class="form-control" name="name" placeholder="Enter name permission" value="{{ old('name') }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-plus me-2"></i>Create
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

        <div class="alert alert-warning" role="alert">
            <h4 class="alert-heading">Alert</h4>
            <hr>
            <p class="mb-0">Fitur permission hanya digunakan untuk pengembangan aplikasi. Menghapus permission dapat menyebabkan fitur pada sistem tidak berfungsi.</p>
        </div>

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
                    <form action="{{ route('permissions.show.page')}}" method="GET">
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
                    <form action="{{ route('permissions')}}" method="GET" class="d-flex gap-1">
                        <input type="text" name="search" class="form-control"  placeholder="Searching" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>

                    {{-- Button Reset --}}
                    <a href="{{ route('permissions') }}" class="btn btn-info text-white" title="Reset">
                        <i class="bi bi-circle"></i>
                    </a>
               </div>
            </div>
            <table class="table">
                <thead>
                    <th>No</th>
                    <th>Name</th>
                    <th>Created at</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach ($permissions as $permission)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->created_at }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    {{-- Edit Button --}}
                                    <button type="button" class="btn btn-sm text-bg-warning confirm_edit" data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{ $permission->id }}" data-name="{{ $permission->name }}" title="Edit permission">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    {{-- Delete button --}}
                                    <button type="button" class="btn btn-sm btn-danger confirm_delete" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $permission->id }}" data-name="{{ $permission->name }}"  title="Delete permission">
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
                    Total : ({{ $permissions->total()}} / Permissions)
                </div>
                <div class="d-flex align-items-center flex-row-reverse">
                    {{ $permissions->onEachSide(0)->appends(request()->input())->links('vendor.paginate') }}
                </div>
            </div>
        </div>
        <!-- end page main -->
    </div>

    <!-- Modal Edit Permission -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="POST" id="formUpdate">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editModalLabel">Edit Permission</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-lavel">Name <span class="fst-italic">*</span></label>
                            <input type="text" class="form-control" name="name" required id="editName">
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
    <!-- END Modal Edit Permission -->

    <!-- Modal Delete Permission -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteModalLabel">Delete Permission</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" id="formDelete" method="POST">
                    <div class="modal-body">
                        @csrf
                        @method('DELETE')
                        <label for="confirm_delete" class="form-label">
                            Untuk melanjutkan penghapusan permissions, silakan ketik: <span id="modalName"></span>
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
            let id = $(this).data('id');
            // Insert Value Permission
            $('#editName').val(name);
            // Route update
            let url = "{{ route('permissions.update', ':id') }}";
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
            let url = "{{ route('permissions.delete', ':id') }}";
            route = url.replace(':id', id);
            // Action route for delete user
            $('#formDelete').attr('action', route);
        });
    </script>
@endpush