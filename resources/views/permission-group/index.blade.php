@extends('layouts.app')

@section('title','Permission Group Management')

@section('content')

    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="mb-4">Permission Group Management</h4>
            </div>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createPermissionGroupModal">
                Tambah Permission Group
            </button>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Sort Order</th>
                                <th scope="col">Jumlah Permission</th>
                                <th scope="col">Action</th>
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
                                                        <i class="bi bi-arrow-up"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            @if (! $loop->last)
                                                <form action="{{ route('permission-group.move-down', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-outline-secondary btn-sm" title="Turun">
                                                        <i class="bi bi-arrow-down"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#permissionListModal" data-group-id="{{ $item->id }}">
                                            {{ $item->permissions_count }}
                                        </button>
                                    </td>
                                    <td>
                                        <!-- Edit Button -->
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editPermissionGroupModal" data-group-id="{{ $item->id }}" data-group-name="{{ $item->name }}" data-group-sort-at="{{ $item->sort_at }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <!-- Delete Button -->
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deletePermissionGroupModal" data-group-id="{{ $item->id }}" data-group-name="{{ $item->name }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">Belum ada data permission group.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $permissionGroups->links() }}
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
                            <table class="table table-hover align-middle mb-0">
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

        <!-- Create Permission Group Modal -->
        <div class="modal fade" id="createPermissionGroupModal" tabindex="-1" aria-labelledby="createPermissionGroupModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('permission-group.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="createPermissionGroupModalLabel">Tambah Permission Group Baru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Permission Group</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan nama permission group">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="sort_at" class="form-label">Sort Order</label>
                                <input type="number" name="sort_at" id="sort_at" value="{{ old('sort_at') }}" class="form-control @error('sort_at') is-invalid @enderror" placeholder="Masukkan sort order">
                                @error('sort_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary btn-sm">Simpan Permission Group</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Permission Group Modal -->
        <div class="modal fade" id="editPermissionGroupModal" tabindex="-1" aria-labelledby="editPermissionGroupModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="editPermissionGroupForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editPermissionGroupModalLabel">Edit Permission Group</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editName" class="form-label">Nama Permission Group</label>
                                <input type="text" name="name" id="editName" class="form-control" placeholder="Masukkan nama permission group">
                            </div>
                            <div class="mb-3">
                                <label for="editSortAt" class="form-label">Sort Order</label>
                                <input type="number" name="sort_at" id="editSortAt" class="form-control" placeholder="Masukkan sort order">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-warning btn-sm">Update Permission Group</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Permission Group Modal -->
        <div class="modal fade" id="deletePermissionGroupModal" tabindex="-1" aria-labelledby="deletePermissionGroupModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="deletePermissionGroupForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title" id="deletePermissionGroupModalLabel">Konfirmasi Hapus Permission Group</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menghapus permission group <strong id="deleteGroupName"></strong>?</p>
                            <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger btn-sm">Hapus Permission Group</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

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
