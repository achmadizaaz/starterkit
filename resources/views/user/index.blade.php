@extends('layouts.app')

@section('title','User Management')

@section('content')

    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="mb-4">User Management</h4>

            </div>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createUserModal">
                Tambah User
            </button>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Avatar</th>
                                <th scope="col">Name</th>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $item)
                                <tr>
                                    <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                    <td>
                                        @if ($item->avatar)
                                            <img src="{{ asset('storage/' . $item->avatar) }}" alt="{{ $item->name }}" class="rounded-circle" style="width:42px; height:42px; object-fit:cover;">
                                        @else
                                            <div class="rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center" style="width:42px; height:42px;">
                                                {{ strtoupper(substr($item->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->username }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>
                                        <span class="badge {{ $item->status ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $item->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal" data-user-id="{{ $item->id }}" data-user-name="{{ $item->name }}" data-user-username="{{ $item->username }}" data-user-email="{{ $item->email }}" data-user-status="{{ $item->status }}" data-user-avatar="{{ $item->avatar ? asset('storage/' . $item->avatar) : '' }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteUserModal" data-user-id="{{ $item->id }}" data-user-name="{{ $item->name }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">Belum ada data user.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $users->links() }}
                </div>
            </div>
        </div>

        <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="createUserModalLabel">Tambah User Baru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">

                                <div class="row align-items-center">
                                    <div class="col-md-4 mt-2">
                                        <div class="border text-center" style="min-height: 80px;">
                                            <img id="avatarPreview" src="#" alt="Preview Avatar" class="d-none" style="width: 100%; height: 100%; ">
                                            <div id="avatarPreviewPlaceholder" class="text-muted small">
                                                Pilih file image untuk melihat pratinjau.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-8 text-align-center">
                                        <label for="avatar" class="form-label">Upload Avatar</label>
                                        <input type="file" name="avatar" id="avatar" accept="image/*" class="form-control @error('avatar') is-invalid @enderror">
                                        @error('avatar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <hr/>

                                <div class="col-md-6">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" name="username" id="username" value="{{ old('username') }}" class="form-control @error('username') is-invalid @enderror">
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>



                                <div class="col-md-6">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                    <div class="input-group">
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary btn-sm">Simpan User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit User Modal -->
        <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="editUserForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="row align-items-center">
                                    <div class="col-md-4 mt-2">
                                        <div class="border text-center" style="min-height: 80px;">
                                            <img id="editAvatarPreview" src="#" alt="Preview Avatar" class="d-none" style="width: 100%; height: 100%;">
                                            <div id="editAvatarPreviewPlaceholder" class="text-muted small">
                                                Pilih file image untuk melihat pratinjau.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-8 text-align-center">
                                        <label for="editAvatar" class="form-label">Upload Avatar</label>
                                        <input type="file" name="avatar" id="editAvatar" accept="image/*" class="form-control">
                                    </div>
                                </div>

                                <hr/>

                                <div class="col-md-6">
                                    <label for="editName" class="form-label">Name</label>
                                    <input type="text" name="name" id="editName" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label for="editUsername" class="form-label">Username</label>
                                    <input type="text" name="username" id="editUsername" class="form-control" readonly>
                                </div>

                                <div class="col-md-6">
                                    <label for="editEmail" class="form-label">Email</label>
                                    <input type="email" name="email" id="editEmail" class="form-control" readonly>
                                </div>

                                <div class="col-md-6">
                                    <label for="editStatus" class="form-label">Status</label>
                                    <select name="status" id="editStatus" class="form-select">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="editPassword" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="editPassword" class="form-control">
                                        <button class="btn btn-outline-secondary" type="button" id="toggleEditPassword">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    <small class="text-muted fst-italic">Kosongkan jika tidak ingin mengubah password</small>
                                </div>

                                <div class="col-md-6">
                                    <label for="editPasswordConfirm" class="form-label">Konfirmasi Password</label>
                                    <div class="input-group">
                                        <input type="password" name="password_confirmation" id="editPasswordConfirm" class="form-control">
                                        <button class="btn btn-outline-secondary" type="button" id="toggleEditPasswordConfirm">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-warning btn-sm">Update User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete User Modal -->
        <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="deleteUserForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteUserModalLabel">Konfirmasi Hapus User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menghapus user <strong id="deleteUserName"></strong>?</p>
                            <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger btn-sm">Hapus User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

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
                        const userStatus = button.getAttribute('data-user-status');
                        const userAvatar = button.getAttribute('data-user-avatar');

                        document.getElementById('editName').value = userName;
                        document.getElementById('editUsername').value = userUsername;
                        document.getElementById('editEmail').value = userEmail;
                        document.getElementById('editStatus').value = userStatus;
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
