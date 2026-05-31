<div class="modal fade modern-modal" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content modern-modal-content">
            <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header modern-modal-header">
                    <div class="modal-heading">
                        <span class="modal-icon modal-icon-primary">
                            <i class="bi bi-person-plus"></i>
                        </span>
                        <div>
                            <h5 class="modal-title" id="createUserModalLabel">Tambah User Baru</h5>
                            <p>Lengkapi informasi dasar dan hak akses pengguna.</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body modern-modal-body">
                    <div class="avatar-upload-card mb-4">
                        <div class="avatar-preview-box">
                            <img id="avatarPreview" src="#" alt="Preview Avatar" class="d-none">
                            <div id="avatarPreviewPlaceholder" class="avatar-preview-placeholder">
                                <i class="bi bi-image"></i>
                                <span>Preview</span>
                            </div>
                        </div>
                        <div class="avatar-upload-content">
                            <label for="avatar" class="form-label">Avatar</label>
                            <input type="file" name="avatar" id="avatar" accept="image/*" class="form-control @error('avatar') is-invalid @enderror">
                            <div class="form-text">
                                <ul class="mb-0">
                                    <li>Ukuran file maks 2MB Format file: .jpg, .jpeg, .png. </li>
                                    <li>Gunakan gambar persegi agar tampilan avatar tetap rapi.</li>
                                </ul>   
                            </div>
                            @error('avatar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-section-title">
                        <i class="bi bi-person-vcard"></i>
                        <span>Informasi Pengguna</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <div class="input-group ">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Nama lengkap">
                            </div>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="username" class="form-label">Username</label>
                            <div class="input-group ">
                                <span class="input-group-text"><i class="bi bi-at"></i></span>
                                <input type="text" name="username" id="username" value="{{ old('username') }}" class="form-control @error('username') is-invalid @enderror" placeholder="username">
                            </div>
                            @error('username')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group ">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="email@domain.com">
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <div class="input-group ">
                                <span class="input-group-text"><i class="bi bi-toggle-on"></i></span>
                                <select name="status" id="status" class="form-select">
                                    <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="role" class="form-label">Role</label>
                            <div class="input-group ">
                                <span class="input-group-text"><i class="bi bi-shield-check"></i></span>
                                <select name="role" id="role" class="form-select @error('role') is-invalid @enderror">
                                    <option value="">Pilih Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" {{ old('role') === $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('role')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group ">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                                <button class="btn btn-password-toggle" type="button" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <div class="input-group ">
                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Ulangi password">
                                <button class="btn btn-password-toggle" type="button" id="togglePasswordConfirm">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-footer modern-modal-footer">
                    <button type="button" class="btn btn-light-modern" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary-modern">
                        <i class="bi bi-check2"></i>
                        Simpan User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
