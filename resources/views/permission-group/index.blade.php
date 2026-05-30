@extends('layouts.app')

@section('title','Permission Group Management')

@section('content')

    <div class="container-fluid">

        <div class="mb-4 small">
             <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-modern">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item" aria-current="page">User Management</li>
                    <li class="breadcrumb-item active" aria-current="page">Permission Groups</li>
                </ol>
            </nav>
        </div>

        <div class="page-heading">
            <div>
                <h4 class="mb-1">Permission Group Management</h4>
                <p class="text-muted mb-0">Kelola dan kontrol grup permission.</p>
            </div>
             <button type="button" class="btn btn-add-modern" data-bs-toggle="modal" data-bs-target="#createPermissionGroupModal">
                    <i class="bi bi-plus-lg"></i> Tambah Permission Group
            </button>
        </div>

        <div class="card card-modern">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table modern-table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Sort Order <i class="bi bi-question-circle" title="Urutan tampilan pada Assign Permission"></i></th>
                                <th scope="col">Jumlah Permission</th>
                                <th scope="col" class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($permissionGroups as $item)
                                <tr>
                                    <td>{{ $loop->iteration + ($permissionGroups->currentPage() - 1) * $permissionGroups->perPage() }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-1">
                                            <span class="badge bg-secondary">{{ $item->sort_at }}</span>
                                            @if (! $loop->first)
                                                <form action="{{ route('permission-group.move-up', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-outline-secondary btn-sm" title="Naik">
                                                        <i class="bi bi-arrow-up-short"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            @if (! $loop->last)
                                                <form action="{{ route('permission-group.move-down', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-outline-secondary btn-sm" title="Turun">
                                                        <i class="bi bi-arrow-down-short"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-modern badge-role" data-bs-toggle="modal" data-bs-target="#permissionListModal" data-group-id="{{ $item->id }}">
                                            {{ $item->permissions_count }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="action-buttons">
                                            <button class="btn-action btn-edit" data-bs-toggle="modal" data-bs-target="#editPermissionGroupModal" data-group-id="{{ $item->id }}" data-group-name="{{ $item->name }}" data-group-sort-at="{{ $item->sort_at }}" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button class="btn-action btn-delete" data-bs-toggle="modal" data-bs-target="#deletePermissionGroupModal" data-group-id="{{ $item->id }}" data-group-name="{{ $item->name }}" title="Hapus">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="bi bi-inbox"></i>
                                            <p>Belum ada data permission group</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination-wrapper mt-4">
                    {{ $permissionGroups->links('vendor.pagination.modern-bootstrap') }}
                </div>
            </div>
        </div>

        <!-- Permission List Modal -->
        <div class="modal fade" id="permissionListModal" tabindex="-1" aria-labelledby="permissionListModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="permissionListModalLabel">Permission Tertaut - <span id="permissionListGroupName"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table modern-table  table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" style="width: 70px;">#</th>
                                        <th scope="col">Nama Permission</th>
                                        <th scope="col">Guard</th>
                                    </tr>
                                </thead>
                                <tbody id="permissionListTableBody">
                                    <tr>
                                        <td colspan="3" class="text-center py-4">Belum ada permission tertaut.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create/Edit/Delete Modals (partials) -->
        @include('permission-group.create-modal')
        @include('permission-group.edit-modal')
        @include('permission-group.delete-modal')

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const permissionGroups = @json($permissionGroupsPayload);

                    document.getElementById('permissionListModal')?.addEventListener('show.bs.modal', function (e) {
                        const button = e.relatedTarget;
                        const groupId = button.getAttribute('data-group-id');
                        const group = permissionGroups[groupId] || { name: '', permissions: [] };
                        const permissions = group.permissions;
                        const tableBody = document.getElementById('permissionListTableBody');
                        const escapeHtml = (value) => String(value ?? '')
                            .replaceAll('&', '&amp;')
                            .replaceAll('<', '&lt;')
                            .replaceAll('>', '&gt;')
                            .replaceAll('"', '&quot;')
                            .replaceAll("'", '&#039;');

                        document.getElementById('permissionListGroupName').textContent = group.name;

                        if (permissions.length === 0) {
                            tableBody.innerHTML = '<tr><td colspan="3" class="text-center py-4">Belum ada permission tertaut.</td></tr>';
                            return;
                        }

                        tableBody.innerHTML = permissions.map((permission, index) => `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${escapeHtml(permission.name)}</td>
                                <td><span class="badge bg-secondary">${escapeHtml(permission.guard_name)}</span></td>
                            </tr>
                        `).join('');
                    });

                    // Edit Permission Group Modal Handler
                    document.getElementById('editPermissionGroupModal')?.addEventListener('show.bs.modal', function (e) {
                        const button = e.relatedTarget;
                        const groupId = button.getAttribute('data-group-id');
                        const groupName = button.getAttribute('data-group-name');
                        const groupSortAt = button.getAttribute('data-group-sort-at');

                        document.getElementById('editName').value = groupName;
                        document.getElementById('editSortAt').value = groupSortAt;
                        document.getElementById('editPermissionGroupForm').action = '/dashboard/permission-group/' + groupId;
                    });

                    // Delete Permission Group Modal Handler
                    document.getElementById('deletePermissionGroupModal')?.addEventListener('show.bs.modal', function (e) {
                        const button = e.relatedTarget;
                        const groupId = button.getAttribute('data-group-id');
                        const groupName = button.getAttribute('data-group-name');

                        document.getElementById('deleteGroupName').textContent = groupName;
                        document.getElementById('deletePermissionGroupForm').action = '/dashboard/permission-group/' + groupId;
                    });

                    @if ($errors->any())
                        var modal = new bootstrap.Modal(document.getElementById('createPermissionGroupModal'));
                        modal.show();
                    @endif
                });
            </script>
        @endpush

    </div>

@endsection
