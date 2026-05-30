@extends('layouts.app')

@section('title','Permission Management')

@section('content')

    <div class="container-fluid">

         <!-- Breadcrumb -->
        <div class="mb-4 small">
             <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-modern">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item" aria-current="page">User Management</li>
                    <li class="breadcrumb-item" aria-current="page">Permissions</li>
                    <li class="breadcrumb-item active" aria-current="page">Permission List</li>
                </ol>
            </nav>
        </div>

        <!-- Dashboard Heading -->
        <div class="page-heading">
            <div>
                <h4 class="mb-1">Permission Management</h4>
                <p class="text-muted mb-0">Kelola dan kontrol semua permission sistem.</p>
            </div>
             <button type="button" class="btn btn-add-modern" data-bs-toggle="modal" data-bs-target="#createPermissionModal">
                    <i class="bi bi-plus-lg"></i> Tambah Permission
            </button>
        </div>


        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table modern-table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Permission</th>
                                <th scope="col">Permission Group</th>
                                <th scope="col" class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($permissions as $item)
                                <tr>
                                    <td>{{ $loop->iteration + ($permissions->currentPage() - 1) * $permissions->perPage() }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td><span class="badge bg-info">{{ $item->permissionGroup?->name ?? 'No Group' }}</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <!-- Edit Button -->
                                            <button class="btn-action btn-edit" data-bs-toggle="modal" data-bs-target="#editPermissionModal" data-permission-id="{{ $item->id }}" data-permission-name="{{ $item->name }}" data-permission-group-id="{{ $item->permission_group_id }}">
                                                 <i class="bi bi-pencil-square"></i>
                                            </button>

                                            <!-- Delete Button -->
                                            <button class="btn-action btn-delete" data-bs-toggle="modal" data-bs-target="#deletePermissionModal" data-permission-id="{{ $item->id }}" data-permission-name="{{ $item->name }}">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </div>

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
                <!-- Pagination -->
                <div class="pagination-wrapper mt-4">
                    {{ $permissions->links('vendor.pagination.modern-bootstrap') }}
                </div>
            </div>
        </div>


        <!-- Create Permission Modal -->
        @include('permission.create-modal')

        <!-- Edit Permission Modal -->
        @include('permission.edit-modal')

        <!-- Delete Permission Modal -->
        @include('permission.delete-modal')


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
