<div class="modal fade profile-modal" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content profile-modal-content">
                <form method="POST" action="{{ route('profile.change.password') }}" id="changeProfilePasswordForm">
                    @csrf
                    @method('PUT')

                    <div class="modal-header profile-modal-header">
                        <div class="modal-heading">
                            <span class="modal-icon modal-icon-primary"><i class="bi bi-key"></i></span>
                            <div>
                                <h5 class="modal-title" id="changePasswordModalLabel">Ubah Kata Sandi</h5>
                                <p>Gunakan kata sandi baru yang kuat dan mudah Anda ingat.</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body profile-modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label" for="profileCurrentPassword">Kata sandi saat ini</label>
                                <div class="input-group input-group-modern">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" class="form-control" name="current_password" id="profileCurrentPassword" autocomplete="current-password">
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="profileNewPassword">Kata sandi baru</label>
                                <div class="input-group input-group-modern">
                                    <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                                    <input type="password" class="form-control" name="password" id="profileNewPassword" autocomplete="new-password">
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="profilePasswordConfirmation">Konfirmasi kata sandi baru</label>
                                <div class="input-group input-group-modern">
                                    <span class="input-group-text"><i class="bi bi-shield-check"></i></span>
                                    <input type="password" class="form-control" name="password_confirmation" id="profilePasswordConfirmation" autocomplete="new-password">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer profile-modal-footer">
                        <button class="btn btn-light-modern" type="button" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary-modern" type="submit" form="changeProfilePasswordForm">
                            <i class="bi bi-check2"></i>
                            Simpan Kata Sandi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>