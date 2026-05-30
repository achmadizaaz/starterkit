@extends('layouts.app')

@section('title','Role Management')

@section('content')

    <div class="container-fluid">

        <!-- Breadcrumb -->
        <div class="mb-4 small">
             <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-modern">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item" aria-current="page">User Management</li>
                    <li class="breadcrumb-item active" aria-current="page">Roles</li>
                </ol>
            </nav>
        </div>

        <!-- Dashboard Heading -->
        <div class="page-heading">
            <div>
                <h4 class="mb-1">Role Management</h4>
                <p class="text-muted mb-0">Kelola dan kontrol semua role sistem.</p>
            </div>
             <button type="button" class="btn btn-add-modern" data-bs-toggle="modal" data-bs-target="#createRoleModal">
                    <i class="bi bi-plus-lg"></i> Tambah Role
            </button>
        </div>

        <!-- Role Table -->
         <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table modern-table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Kode Role</th>
                                <th scope="col">Nama Role</th>
                                <th scope="col">Juml. Permission</th>
                                <th scope="col" class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($roles as $item)
                                <tr >
                                    <td>{{ $loop->iteration + ($roles->currentPage() - 1) * $roles->perPage() }}</td>
                                    <td><code>{{ $item->code }}</code></td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <span class="badge badge-modern badge-role" data-bs-toggle="modal" data-bs-target="#permissionListModal" data-group-id="{{ $item->id }}">
                                            {{ $item->permissions->count() }} Permission
                                        </span>
                                        
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <!-- Edit Button -->
                                            <button class="btn-action btn-edit" data-bs-toggle="modal" data-bs-target="#editRoleModal" data-role-id="{{ $item->id }}" data-role-code="{{ $item->code }}" data-role-name="{{ $item->name }}">
                                                 <i class="bi bi-pencil-square"></i>
                                            </button>

                                            <!-- Delete Button -->
                                            <button class="btn-action btn-delete" data-bs-toggle="modal" data-bs-target="#deleteRoleModal" data-role-id="{{ $item->id }}" data-role-name="{{ $item->name }}">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="bi bi-inbox"></i>
                                            <p>Belum ada data role</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination-wrapper mt-4">
                    {{ $roles->links('vendor.pagination.modern-bootstrap') }}
                </div>
            </div>
        </div>

        <!-- Create Role Modal -->
        @include('role.create-modal')
        <!-- Edit Role Modal -->
        @include('role.edit-modal')
        <!-- Delete Role Modal -->
        @include('role.delete-modal')

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
