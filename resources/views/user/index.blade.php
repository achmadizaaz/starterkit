@extends('layouts.app')

@section('title','User Management')

@section('content')

    <div class="container-fluid">

        <div class="mb-4 small">
             <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-modern">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">User Management</li>
                    <li class="breadcrumb-item active" aria-current="page">Users</li>
                </ol>
            </nav>
        </div>

        <div class="page-heading">
            <div>
                {{-- <span class="dashboard-kicker">Access Control</span> --}}
                <h4 class="mb-1">User Management</h4>
                <p class="text-muted mb-0">Kelola dan kontrol semua pengguna sistem.</p>
            </div>
             <button type="button" class="btn btn-add-modern" data-bs-toggle="modal" data-bs-target="#createUserModal">
                    <i class="bi bi-plus-lg"></i> Tambah User
            </button>
            
        </div>
        

        <div class="card card-modern">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table modern-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Pengguna</th>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $item)
                                <tr class="user-row">
                                    <td class="text-muted fw-500">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                    <td>
                                        <div class="user-cell">
                                            @if ($item->avatar)
                                                <img src="{{ asset('storage/' . $item->avatar) }}" alt="{{ $item->name }}" class="avatar-img">
                                            @else
                                                <div class="avatar-placeholder">
                                                    {{ strtoupper(substr($item->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div class="user-info">
                                                <p class="user-name">{{ $item->name }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="username-text">{{ $item->username }}</span>
                                    </td>
                                    <td>
                                        <span class="email-text">{{ $item->email }}</span>
                                    </td>
                                    <td>
                                        @forelse ($item->roles as $role)
                                            <span class="badge badge-modern badge-role">{{ $role->name }}</span>
                                        @empty
                                            <span class="text-muted">-</span>
                                        @endforelse
                                    </td>
                                    <td>
                                        <span class="status-badge {{ $item->status ? 'status-active' : 'status-inactive' }}">
                                            <span class="status-dot"></span>
                                            {{ $item->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="action-buttons">
                                            <a href="{{ route('user.show', $item->id) }}" class="btn-action btn-detail" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <button class="btn-action btn-edit" data-bs-toggle="modal" data-bs-target="#editUserModal" data-user-id="{{ $item->id }}" data-user-name="{{ $item->name }}" data-user-username="{{ $item->username }}" data-user-email="{{ $item->email }}" data-user-email-verified="{{ $item->email_verified_at ? '1' : '0' }}" data-user-status="{{ $item->status }}" data-user-role="{{ $item->roles->first()?->id }}" data-user-avatar="{{ $item->avatar ? asset('storage/' . $item->avatar) : '' }}" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button class="btn-action btn-delete" data-bs-toggle="modal" data-bs-target="#deleteUserModal" data-user-id="{{ $item->id }}" data-user-name="{{ $item->name }}" title="Hapus">
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
                                            <p>Belum ada data user</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination-wrapper mt-4">
                    {{ $users->links('vendor.pagination.modern-bootstrap') }}
                </div>
            </div>
        </div>

        <!-- Create User Modal -->
        @include('user.create-modal')

        <!-- Edit User Modal -->
        @include('user.edit-modal')

        <!-- Delete User Modal -->
        @include('user.delete-modal')

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var avatarInput = document.getElementById('avatar');
                    var avatarPreview = document.getElementById('avatarPreview');
                    var avatarPlaceholder = document.getElementById('avatarPreviewPlaceholder');

                    function updateAvatarPreview(file) {
                        if (!file) {
                            avatarPreview.classList.add('d-none');
                            avatarPlaceholder.classList.remove('d-none');
                            avatarPreview.src = '#';
                            return;
                        }

                        var reader = new FileReader();
                        reader.onload = function (e) {
                            avatarPreview.src = e.target.result;
                            avatarPreview.classList.remove('d-none');
                            avatarPlaceholder.classList.add('d-none');
                        };
                        reader.readAsDataURL(file);
                    }

                    avatarInput?.addEventListener('change', function (event) {
                        updateAvatarPreview(event.target.files[0]);
                    });

                    // Toggle Password Visibility
                    const togglePasswordBtn = document.getElementById('togglePassword');
                    const passwordInput = document.getElementById('password');

                    togglePasswordBtn?.addEventListener('click', function (e) {
                        e.preventDefault();
                        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                        passwordInput.setAttribute('type', type);
                        this.querySelector('i').classList.toggle('bi-eye');
                        this.querySelector('i').classList.toggle('bi-eye-slash');
                    });

                    // Toggle Password Confirmation Visibility
                    const togglePasswordConfirmBtn = document.getElementById('togglePasswordConfirm');
                    const passwordConfirmInput = document.getElementById('password_confirmation');

                    togglePasswordConfirmBtn?.addEventListener('click', function (e) {
                        e.preventDefault();
                        const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
                        passwordConfirmInput.setAttribute('type', type);
                        this.querySelector('i').classList.toggle('bi-eye');
                        this.querySelector('i').classList.toggle('bi-eye-slash');
                    });

                    // Edit User Modal Handler
                    document.getElementById('editUserModal')?.addEventListener('show.bs.modal', function (e) {
                        const button = e.relatedTarget;
                        const userId = button.getAttribute('data-user-id');
                        const userName = button.getAttribute('data-user-name');
                        const userUsername = button.getAttribute('data-user-username');
                        const userEmail = button.getAttribute('data-user-email');
                        const userEmailVerified = button.getAttribute('data-user-email-verified');
                        const userStatus = button.getAttribute('data-user-status');
                        const userRole = button.getAttribute('data-user-role');
                        const userAvatar = button.getAttribute('data-user-avatar');

                        document.getElementById('editName').value = userName;
                        document.getElementById('editUsername').value = userUsername;
                        document.getElementById('editEmail').value = userEmail;
                        document.getElementById('editEmailVerified').checked = userEmailVerified === '1';
                        document.getElementById('editStatus').value = userStatus;
                        document.getElementById('editRole').value = userRole;
                        if (window.jQuery) {
                            jQuery('#editRole').trigger('change');
                        }
                        document.getElementById('editUserForm').action = '/dashboard/user/' + userId;

                        // Set avatar preview
                        const editAvatarPreview = document.getElementById('editAvatarPreview');
                        const editAvatarPlaceholder = document.getElementById('editAvatarPreviewPlaceholder');
                        if (userAvatar && userAvatar.trim() !== '') {
                            editAvatarPreview.src = userAvatar;
                            editAvatarPreview.classList.remove('d-none');
                            editAvatarPlaceholder.classList.add('d-none');
                        } else {
                            editAvatarPreview.classList.add('d-none');
                            editAvatarPlaceholder.classList.remove('d-none');
                        }

                        // Clear password fields
                        document.getElementById('editPassword').value = '';
                        document.getElementById('editPasswordConfirm').value = '';
                    });

                    // Edit Avatar Preview Handler
                    document.getElementById('editAvatar')?.addEventListener('change', function (event) {
                        if (!event.target.files[0]) return;
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            document.getElementById('editAvatarPreview').src = e.target.result;
                            document.getElementById('editAvatarPreview').classList.remove('d-none');
                            document.getElementById('editAvatarPreviewPlaceholder').classList.add('d-none');
                        };
                        reader.readAsDataURL(event.target.files[0]);
                    });

                    // Toggle Edit Password Visibility
                    document.getElementById('toggleEditPassword')?.addEventListener('click', function (e) {
                        e.preventDefault();
                        const input = document.getElementById('editPassword');
                        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                        input.setAttribute('type', type);
                        this.querySelector('i').classList.toggle('bi-eye');
                        this.querySelector('i').classList.toggle('bi-eye-slash');
                    });

                    // Toggle Edit Password Confirm Visibility
                    document.getElementById('toggleEditPasswordConfirm')?.addEventListener('click', function (e) {
                        e.preventDefault();
                        const input = document.getElementById('editPasswordConfirm');
                        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                        input.setAttribute('type', type);
                        this.querySelector('i').classList.toggle('bi-eye');
                        this.querySelector('i').classList.toggle('bi-eye-slash');
                    });

                    // Delete User Modal Handler
                    document.getElementById('deleteUserModal')?.addEventListener('show.bs.modal', function (e) {
                        const button = e.relatedTarget;
                        const userId = button.getAttribute('data-user-id');
                        const userName = button.getAttribute('data-user-name');

                        document.getElementById('deleteUserName').textContent = userName;
                        document.getElementById('deleteUserForm').action = '/dashboard/user/' + userId;
                    });

                    @if ($errors->any())
                        var modal = new bootstrap.Modal(document.getElementById('createUserModal'));
                        modal.show();
                    @endif
                });
            </script>
        @endpush

        {{-- END Container Fluid --}}
    </div>

@endsection
