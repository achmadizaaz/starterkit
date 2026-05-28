@extends('layouts.app')

@section('title','Assign Role Permission')

@section('content')

    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-4">Assign Role Permission</h4>
        </div>
        
        <div class="card">
            <div class="card-body">
                <!-- Select Role Section -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="roleSelect" class="form-label">Pilih Role</label>
                        <select id="roleSelect" class="form-select" onchange="changeRole(this.value)">
                            <option value="">-- Pilih Role --</option>
                            @foreach ($roles as $role)
                                <option value="{{ (string) $role->id }}" {{ $selectedRole && $selectedRole->id === $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @if ($selectedRole)
                    <form action="{{ route('role-permission.update', (string) $selectedRole->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Permissions Table -->
                        <div class="table-responsive mb-4">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Nama Resource</th>
                                        <th scope="col" style="width: 100px;" class="text-center">
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input" type="checkbox" id="selectAllCheckbox">
                                            </div>
                                        </th>
                                        <th scope="col" class="text-center" style="width: 100px;">Read</th>
                                        <th scope="col" class="text-center" style="width: 100px;">Create</th>
                                        <th scope="col" class="text-center" style="width: 100px;">Update</th>
                                        <th scope="col" class="text-center" style="width: 100px;">Delete</th>
                                        <th scope="col" class="text-center" style="width: 100px;">Lainnya</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($groupedPermissions as $groupId => $group)
                                        <tr>
                                            <td>
                                                <strong>{{ ucfirst($group['name']) }}</strong>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input group-checkbox" type="checkbox" data-group-id="{{ $groupId }}">
                                                </div>
                                            </td>
                                            @php
                                                $actions = ['read', 'create', 'update', 'delete'];
                                            @endphp
                                            @foreach ($actions as $action)
                                                <td class="text-center">
                                                    @php
                                                        $permission = collect($group['permissions'])->firstWhere('action', $action);
                                                    @endphp
                                                    @if ($permission)
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input class="form-check-input permission-checkbox group-perm-{{ $groupId }}" type="checkbox" name="permissions[]" value="{{ $permission['id'] }}" id="perm_{{ $permission['id'] }}" {{ $permission['hasPermission'] ? 'checked' : '' }}>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            @endforeach
                                            @php
                                                $otherPermissions = collect($group['permissions'])->reject(fn ($permission) => in_array($permission['action'], $actions));
                                            @endphp
                                            <td class="text-center">
                                                @if ($otherPermissions->isNotEmpty())
                                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#otherPermissionModal" data-group-id="{{ $group['id'] }}" data-group-name="{{ $group['name'] }}" data-permissions='@json($group['permissions'])'>
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">Tidak ada permissions yang tersedia.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-none" aria-hidden="true">
                            @foreach ($groupedPermissions as $groupId => $group)
                                @foreach ($group['permissions'] as $permission)
                                    @if (! in_array($permission['action'], ['read', 'create', 'update', 'delete']))
                                        <input class="permission-checkbox group-perm-{{ $groupId }}" type="checkbox" name="permissions[]" value="{{ $permission['id'] }}" id="hidden_perm_{{ $permission['id'] }}" {{ $permission['hasPermission'] ? 'checked' : '' }}>
                                    @endif
                                @endforeach
                            @endforeach
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-sm">Simpan Permission</button>
                            <a href="{{ route('role.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                        </div>
                    </form>
                @else
                    <div class="alert alert-info">
                        Pilih role terlebih dahulu untuk mengatur permissions.
                    </div>
                @endif
            </div>
        </div>

        <!-- Other Permissions Modal -->
        <div class="modal fade" id="otherPermissionModal" tabindex="-1" aria-labelledby="otherPermissionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="otherPermissionModalLabel">Permissions Lainnya - <span id="groupName"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="otherPermissionsList">
                            <!-- Permissions akan dimuat via JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                function changeRole(roleId) {
                    if (roleId) {
                        window.location.href = "{{ url('/dashboard/role-permission') }}/" + encodeURIComponent(roleId);
                    }else{
                        window.location.href = "{{ url('/dashboard/role-permission') }}";
                    }
                }

                document.addEventListener('DOMContentLoaded', function () {
                    // Select All Checkbox
                    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
                    const permissionCheckboxes = document.querySelectorAll('.permission-checkbox');
                    const groupCheckboxes = document.querySelectorAll('.group-checkbox');

                    if (selectAllCheckbox) {
                        selectAllCheckbox.addEventListener('change', function () {
                            permissionCheckboxes.forEach(checkbox => {
                                checkbox.checked = this.checked;
                            });
                            groupCheckboxes.forEach(checkbox => {
                                checkbox.checked = this.checked;
                            });
                        });
                    }

                    // Group Checkbox Handler
                    groupCheckboxes.forEach(checkbox => {
                        checkbox.addEventListener('change', function () {
                            const groupId = this.getAttribute('data-group-id');
                            const groupPermissions = document.querySelectorAll(`.group-perm-${groupId}`);
                            groupPermissions.forEach(perm => {
                                perm.checked = this.checked;
                            });
                            updateSelectAllCheckbox();
                        });
                    });

                    // Permission Checkbox Handler
                    permissionCheckboxes.forEach(checkbox => {
                        checkbox.addEventListener('change', updateSelectAllCheckbox);
                    });

                    function updateSelectAllCheckbox() {
                        const totalCheckboxes = permissionCheckboxes.length;
                        const checkedCheckboxes = document.querySelectorAll('.permission-checkbox:checked').length;
                        if (selectAllCheckbox) {
                            selectAllCheckbox.checked = totalCheckboxes === checkedCheckboxes && totalCheckboxes > 0;
                        }
                    }

                    // Handler untuk modal "Other Permissions"
                    document.getElementById('otherPermissionModal')?.addEventListener('show.bs.modal', function (e) {
                        const button = e.relatedTarget;
                        const groupId = button.getAttribute('data-group-id');
                        const groupName = button.getAttribute('data-group-name');
                        const permissionsData = JSON.parse(button.getAttribute('data-permissions'));

                        document.getElementById('groupName').textContent = groupName;

                        // Filter permissions yang bukan read, create, update, delete
                        const otherPermissions = permissionsData.filter(p =>
                            !['read', 'create', 'update', 'delete'].includes(p.action)
                        );

                        // Filter permissions standar
                        const standardPermissions = permissionsData.filter(p =>
                            ['read', 'create', 'update', 'delete'].includes(p.action)
                        );

                        let html = '';

                        if (otherPermissions.length > 0) {
                            html += '<div class="mb-3"><strong>Other Permissions:</strong></div>';
                            otherPermissions.forEach(perm => {
                                const permissionCheckbox = document.querySelector(`input[name="permissions[]"][value="${perm.id}"]`);
                                const isChecked = (permissionCheckbox ? permissionCheckbox.checked : perm.hasPermission) ? 'checked' : '';
                                html += `
                                    <div class="form-check mb-2">
                                        <input class="form-check-input permission-checkbox" type="checkbox" name="permissions[]" value="${perm.id}" id="modal_perm_${perm.id}" ${isChecked}>
                                        <label class="form-check-label" for="modal_perm_${perm.id}">
                                            ${perm.name}
                                        </label>
                                    </div>
                                `;
                            });
                        } else {
                            html += '<p class="text-muted">Tidak ada permissions lainnya untuk resource ini.</p>';
                        }

                        document.getElementById('otherPermissionsList').innerHTML = html;
                    });

                    // Sync checkbox di form dan modal
                    document.addEventListener('change', function(e) {
                        if (e.target.classList.contains('permission-checkbox')) {
                            const value = e.target.value;
                            const checked = e.target.checked;

                            // Update di form
                            document.querySelectorAll(`input[name="permissions[]"][value="${value}"]`).forEach(checkbox => {
                                checkbox.checked = checked;
                            });
                            updateSelectAllCheckbox();
                        }
                    });
                });
            </script>
        @endpush

    </div>

@endsection
