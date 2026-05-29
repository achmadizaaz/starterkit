<div class="modal fade modern-modal" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content modern-modal-content">
            <form id="editUserForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header modern-modal-header">
                    <div class="modal-heading">
                        <span class="modal-icon modal-icon-emerald">
                            <i class="bi bi-pencil-square"></i>
                        </span>
                        <div>
                            <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                            <p>Perbarui profil, status, role, atau password pengguna.</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="avatar-upload-card mb-4">
                        <div class="avatar-preview-box">
                            <img id="editAvatarPreview" src="#" alt="Preview Avatar" class="d-none">
                            <div id="editAvatarPreviewPlaceholder" class="avatar-preview-placeholder">
                                <i class="bi bi-image"></i>
                                <span>Preview</span>
                            </div>
                        </div>
                        <div class="avatar-upload-content">
                            <label for="editAvatar" class="form-label">Avatar</label>
                            <input type="file" name="avatar" id="editAvatar" accept="image/*" class="form-control">
                            <div class="form-text">Biarkan kosong jika tidak ingin mengganti avatar.</div>
                        </div>
                    </div>

                    <div class="form-section-title">
                        <i class="bi bi-person-vcard"></i>
                        <span>Informasi Pengguna</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="editName" class="form-label">Name</label>
                            <div class="input-group input-group-modern">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" name="name" id="editName" class="form-control" placeholder="Nama lengkap">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="editUsername" class="form-label">Username</label>
                            <div class="input-group input-group-modern">
                                <span class="input-group-text"><i class="bi bi-at"></i></span>
                                <input type="text" name="username" id="editUsername" class="form-control" placeholder="username">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="editEmail" class="form-label">Email</label>
                            <div class="input-group input-group-modern">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" id="editEmail" class="form-control" placeholder="email@domain.com">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="editStatus" class="form-label">Status</label>
                            <div class="input-group input-group-modern">
                                <span class="input-group-text"><i class="bi bi-toggle-on"></i></span>
                                <select name="status" id="editStatus" class="form-select">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="editRole" class="form-label">Role</label>
                            <div class="input-group input-group-modern">
                                <span class="input-group-text"><i class="bi bi-shield-check"></i></span>
                                <select name="role" id="editRole" class="form-select">
                                    <option value="">Pilih Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="editPassword" class="form-label">Password Baru</label>
                            <div class="input-group input-group-modern">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" id="editPassword" class="form-control" placeholder="Opsional">
                                <button class="btn btn-password-toggle" type="button" id="toggleEditPassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <div class="form-text">Kosongkan jika tidak ingin mengubah password.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="editPasswordConfirm" class="form-label">Konfirmasi Password</label>
                            <div class="input-group input-group-modern">
                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" name="password_confirmation" id="editPasswordConfirm" class="form-control" placeholder="Ulangi password baru">
                                <button class="btn btn-password-toggle" type="button" id="toggleEditPasswordConfirm">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer modern-modal-footer">
                    <button type="button" class="btn btn-light-modern" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-emerald-modern">
                        <i class="bi bi-arrow-repeat"></i>
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
