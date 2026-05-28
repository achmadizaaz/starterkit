@extends('layouts.app')

@section('title','Permission Management')

@section('content')

    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="mb-4">Permission Management</h4>
            </div>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createPermissionModal">
                Tambah Permission
            </button>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Permission</th>
                                <th scope="col">Permission Group</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($permissions as $item)
                                <tr>
                                    <td>{{ $loop->iteration + ($permissions->currentPage() - 1) * $permissions->perPage() }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td><span class="badge bg-info">{{ $item->permissionGroup?->name ?? 'No Group' }}</span></td>
                                    <td>
                                        <!-- Edit Button -->
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editPermissionModal" data-permission-id="{{ $item->id }}" data-permission-name="{{ $item->name }}" data-permission-group-id="{{ $item->permission_group_id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <!-- Delete Button -->
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deletePermissionModal" data-permission-id="{{ $item->id }}" data-permission-name="{{ $item->name }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">Belum ada data permission.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $permissions->links() }}
        </div>

        <!-- Create Permission Modal -->
        <div class="modal fade" id="createPermissionModal" tabindex="-1" aria-labelledby="createPermissionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('permission.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="createPermissionModalLabel">Tambah Permission Baru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Permission</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan nama permission">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="permission_group_id" class="form-label">Permission Group</label>
                                <select name="permission_group_id" id="permission_group_id" class="form-select @error('permission_group_id') is-invalid @enderror">
                                    <option value="">-- Pilih Permission Group --</option>
                                    @foreach ($permissionGroups as $group)
                                        <option value="{{ $group->id }}" {{ old('permission_group_id') == $group->id ? 'selected' : '' }}>
                                            {{ $group->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('permission_group_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary btn-sm">Simpan Permission</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Permission Modal -->
        <div class="modal fade" id="editPermissionModal" tabindex="-1" aria-labelledby="editPermissionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="editPermissionForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editPermissionModalLabel">Edit Permission</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editName" class="form-label">Nama Permission</label>
                                <input type="text" name="name" id="editName" class="form-control" placeholder="Masukkan nama permission">
                            </div>
                            <div class="mb-3">
                                <label for="editPermissionGroupId" class="form-label">Permission Group</label>
                                <select name="permission_group_id" id="editPermissionGroupId" class="form-select">
                                    <option value="">-- Pilih Permission Group --</option>
                                    @foreach ($permissionGroups as $group)
                                        <option value="{{ $group->id }}">
                                            {{ $group->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-warning btn-sm">Update Permission</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Permission Modal -->
        <div class="modal fade" id="deletePermissionModal" tabindex="-1" aria-labelledby="deletePermissionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="deletePermissionForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title" id="deletePermissionModalLabel">Konfirmasi Hapus Permission</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menghapus permission <strong id="deletePermissionName"></strong>?</p>
                            <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger btn-sm">Hapus Permission</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    // Edit Permission Modal Handler
                    document.getElementById('editPermissionModal')?.addEventListener('show.bs.modal', function (e) {
                        const button = e.relatedTarget;
                        const permissionId = button.getAttribute('data-permission-id');
                        const permissionName = button.getAttribute('data-permission-name');
                        const permissionGroupId = button.getAttribute('data-permission-group-id');

                        document.getElementById('editName').value = permissionName;
                        document.getElementById('editPermissionGroupId').value = permissionGroupId || '';
                        document.getElementById('editPermissionForm').action = '/dashboard/permission/' + permissionId;
                    });

                    // Delete Permission Modal Handler
                    document.getElementById('deletePermissionModal')?.addEventListener('show.bs.modal', function (e) {
                        const button = e.relatedTarget;
                        const permissionId = button.getAttribute('data-permission-id');
                        const permissionName = button.getAttribute('data-permission-name');

                        document.getElementById('deletePermissionName').textContent = permissionName;
                        document.getElementById('deletePermissionForm').action = '/dashboard/permission/' + permissionId;
                    });

                    @if ($errors->any())
                        var modal = new bootstrap.Modal(document.getElementById('createPermissionModal'));
                        modal.show();
                    @endif
                });
            </script>
        @endpush

    </div>

@endsection
