 <div class="modal fade profile-modal" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content profile-modal-content">
            <form method="POST" action="{{ route('profile.update') }}" id="editForm" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <div class="modal-header profile-modal-header">
                    <div class="modal-heading">
                        <span class="modal-icon modal-icon-primary"><i class="bi bi-person-gear"></i></span>
                        <div>
                            <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                            <p>Perbarui foto dan informasi akun Anda.</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body profile-modal-body">
                    <div class="avatar-upload-card mb-4">
                        <div class="avatar-preview-box">
                            <img src="{{ $avatar }}" alt="Preview Avatar" id="preview-image">
                        </div>
                        <div class="avatar-upload-content">
                            <label for="uploadImage" class="form-label">Avatar</label>
                            <input type="file" class="form-control" name="avatar" accept=".jpg,.png,.jpeg" id="uploadImage">
                            <div class="form-text">
                                <ul class="mb-0">
                                    <li>Ukuran file maks 2MB Format file: .jpg, .jpeg, .png. </li>
                                    <li>Gunakan gambar persegi agar tampilan avatar tetap rapi.</li>
                                </ul>    
                            </div>
                        </div>
                    </div>

                    <div class="form-section-title">
                        <i class="bi bi-person-vcard"></i>
                        <span>Informasi Profil</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="name">Full Name</label>
                            <div class="input-group input-group-modern">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input name="name" id="name" type="text" value="{{ old('name', $user->name) }}" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="username">Username</label>
                            <div class="input-group input-group-modern">
                                <span class="input-group-text"><i class="bi bi-at"></i></span>
                                <input id="username" type="text" value="{{ $user->username }}" class="form-control" disabled>
                            </div>
                            <div class="form-text">Username tidak dapat diubah dari halaman profil.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="email">Email</label>
                            <div class="input-group input-group-modern">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input name="email" id="email" type="email" value="{{ old('email', $user->email) }}" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="phone">Phone</label>
                            <div class="input-group input-group-modern">
                                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                <input name="phone" id="phone" type="text" value="{{ old('phone', $profile?->phone) }}" class="form-control" placeholder="Masukkan nomor telepon">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="birth_date">Birth Date</label>
                            <div class="input-group input-group-modern">
                                <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                                <input name="birth_date" id="birth_date" type="date" value="{{ old('birth_date', $profile?->birth_date) }}" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="gender">Gender</label>
                            <div class="input-group input-group-modern">
                                <span class="input-group-text">
                                    <i class="bi bi-gender-ambiguous"></i>
                                </span>
                                <select name="gender" id="gender" class="form-control">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="male" {{ old('gender', $profile?->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="female" {{ old('gender', $profile?->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>

                        

                        <div class="col-md-6">
                            <label class="form-label" for="website">Website</label>
                            <div class="input-group input-group-modern">
                                <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                <input name="website" id="website" type="url" value="{{ old('website', $profile?->website) }}" class="form-control" placeholder="https://example.com">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="country">Country</label>
                            <div class="input-group input-group-modern">
                                <span class="input-group-text"><i class="bi bi-geo"></i></span>
                                <input name="country" id="country" type="text" value="{{ old('country', $profile?->country) }}" class="form-control" placeholder="Indonesia">
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label" for="address">Address</label>
                            <textarea name="address" id="address" class="form-control profile-textarea" rows="4" placeholder="Masukkan alamat Anda">{{ old('address', $profile?->address) }}</textarea>
                        </div>
                    </div>

                    <div class="form-section-title mt-4">
                        <i class="bi bi-share"></i>
                        <span>Media Sosial</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="socialInstagram">Instagram</label>
                            <div class="input-group input-group-modern">
                                <span class="input-group-text"><i class="bi bi-instagram"></i></span>
                                <input name="social_media[instagram]" id="socialInstagram" type="text" value="{{ old('social_media.instagram', $profile?->social_media['instagram'] ?? '') }}" class="form-control" placeholder="https://instagram.com/username">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="socialFacebook">Facebook</label>
                            <div class="input-group input-group-modern">
                                <span class="input-group-text"><i class="bi bi-facebook"></i></span>
                                <input name="social_media[facebook]" id="socialFacebook" type="text" value="{{ old('social_media.facebook', $profile?->social_media['facebook'] ?? '') }}" class="form-control" placeholder="https://facebook.com/username">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="socialLinkedin">LinkedIn</label>
                            <div class="input-group input-group-modern">
                                <span class="input-group-text"><i class="bi bi-linkedin"></i></span>
                                <input name="social_media[linkedin]" id="socialLinkedin" type="text" value="{{ old('social_media.linkedin', $profile?->social_media['linkedin'] ?? '') }}" class="form-control" placeholder="https://linkedin.com/in/username">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="socialTwitter">X / Twitter</label>
                            <div class="input-group input-group-modern">
                                <span class="input-group-text"><i class="bi bi-twitter-x"></i></span>
                                <input name="social_media[twitter]" id="socialTwitter" type="text" value="{{ old('social_media.twitter', $profile?->social_media['twitter'] ?? '') }}" class="form-control" placeholder="https://x.com/username">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer profile-modal-footer">
                    <button class="btn btn-light-modern" type="button" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary-modern" type="submit" form="editForm">
                        <i class="bi bi-check2"></i>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
