@extends('layouts.app')

@section('title','Role Management')

@section('content')

    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="mb-4">Role Management</h4>
            </div>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createRoleModal">
                Tambah Role
            </button>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Kode Role</th>
                                <th scope="col">Nama Role</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($roles as $item)
                                <tr>
                                    <td>{{ $loop->iteration + ($roles->currentPage() - 1) * $roles->perPage() }}</td>
                                    <td><code>{{ $item->code }}</code></td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <!-- Edit Button -->
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editRoleModal" data-role-id="{{ $item->id }}" data-role-code="{{ $item->code }}" data-role-name="{{ $item->name }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <!-- Delete Button -->
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteRoleModal" data-role-id="{{ $item->id }}" data-role-name="{{ $item->name }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">Belum ada data role.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $roles->links() }}
                </div>
            </div>
        </div>

        <!-- Create Role Modal -->
        <div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="createRoleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('role.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="createRoleModalLabel">Tambah Role Baru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="code" class="form-label">Kode Role</label>
                                <input type="text" name="code" id="code" value="{{ old('code') }}" class="form-control @error('code') is-invalid @enderror" placeholder="Masukkan kode role">
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Role</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan nama role">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary btn-sm">Simpan Role</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Role Modal -->
        <div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="editRoleForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editCode" class="form-label">Kode Role</label>
                                <input type="text" name="code" id="editCode" class="form-control" placeholder="Masukkan kode role">
                            </div>
                            <div class="mb-3">
                                <label for="editName" class="form-label">Nama Role</label>
                                <input type="text" name="name" id="editName" class="form-control" placeholder="Masukkan nama role">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-warning btn-sm">Update Role</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Role Modal -->
        <div class="modal fade" id="deleteRoleModal" tabindex="-1" aria-labelledby="deleteRoleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="deleteRoleForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteRoleModalLabel">Konfirmasi Hapus Role</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menghapus role <strong id="deleteRoleName"></strong>?</p>
                            <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger btn-sm">Hapus Role</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    // Edit Role Modal Handler
                    document.getElementById('editRoleModal')?.addEventListener('show.bs.modal', function (e) {
                        const button = e.relatedTarget;
                        const roleId = button.getAttribute('data-role-id');
                        const roleCode = button.getAttribute('data-role-code');
                        const roleName = button.getAttribute('data-role-name');

                        document.getElementById('editCode').value = roleCode;
                        document.getElementById('editName').value = roleName;
                        document.getElementById('editRoleForm').action = '/dashboard/role/' + roleId;
                    });

                    // Delete Role Modal Handler
                    document.getElementById('deleteRoleModal')?.addEventListener('show.bs.modal', function (e) {
                        const button = e.relatedTarget;
                        const roleId = button.getAttribute('data-role-id');
                        const roleName = button.getAttribute('data-role-name');

                        document.getElementById('deleteRoleName').textContent = roleName;
                        document.getElementById('deleteRoleForm').action = '/dashboard/role/' + roleId;
                    });

                    @if ($errors->any())
                        var modal = new bootstrap.Modal(document.getElementById('createRoleModal'));
                        modal.show();
                    @endif
                });
            </script>
        @endpush

    </div>

@endsection
