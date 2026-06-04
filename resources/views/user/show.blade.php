@extends('layouts.app')

@section('title','Detail User')

@php
    $profile = $user->profile;
    $avatar = $user->avatar ? asset('storage/' . $user->avatar) : 'https://i.pravatar.cc/300?u=' . urlencode($user->email);
    $primaryRole = $user->roles->first()?->name ?? 'User';
    $phone = $profile?->phone ?? '-';
    $address = $profile?->address ?? 'Alamat belum ditambahkan.';
    $location = $profile?->country;
    $socialMedia = collect($profile?->social_media ?? [])->filter();
    $nextStatus = $user->status ? 0 : 1;
@endphp

@section('content')
    <div class="container-fluid profile-page">
        <div class="profile-hero">
            <div class="profile-hero-content">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-modern mb-3">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('user.index') }}">User Management</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail User</li>
                    </ol>
                </nav>

                <div class="profile-title-row">
                    <div>
                        <span class="profile-kicker">User Detail</span>
                        <h1>{{ $user->name }}</h1>
                        <p>Kelola detail profil, kata sandi, dan status akses user.</p>
                    </div>
                    <div class="profile-actions">
                        <button type="button" class="btn btn-profile-password" data-bs-toggle="modal" data-bs-target="#detailPasswordModal">
                            <i class="bi bi-key"></i>
                            Ubah Kata Sandi
                        </button>
                        <button type="button" class="btn {{ $user->status ? 'btn-profile-status-danger' : 'btn-profile-status-success' }}" data-bs-toggle="modal" data-bs-target="#detailStatusModal">
                            <i class="bi {{ $user->status ? 'bi-toggle-off' : 'bi-toggle-on' }}"></i>
                            {{ $user->status ? 'Nonaktifkan User' : 'Aktifkan User' }}
                        </button>
                        <button type="button" class="btn btn-profile-edit" data-bs-toggle="modal" data-bs-target="#detailEditUserModal">
                            <i class="bi bi-pencil-square"></i>
                            Edit Profile
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 profile-grid">
            <div class="col-xl-4">
                <div class="profile-summary-card h-100">
                    <div class="profile-cover"></div>
                    <div class="profile-summary-body">
                        <div class="profile-avatar-wrap">
                            <img src="{{ $avatar }}" alt="{{ $user->name }}" class="profile-avatar-modern">
                            <span class="profile-status-dot {{ $user->status ? '' : 'inactive' }}" title="{{ $user->status ? 'Active' : 'Inactive' }}"></span>
                        </div>

                        <h2>{{ $user->name }}</h2>
                        <p class="profile-role">{{ $primaryRole }}</p>

                        <div class="profile-badges">
                            <span class="profile-badge {{ $user->status ? 'active' : 'inactive' }}">
                                <i class="bi {{ $user->status ? 'bi-check2-circle' : 'bi-x-circle' }}"></i>
                                {{ $user->status ? 'Active' : 'Inactive' }}
                            </span>
                            <span class="profile-badge {{ $user->email_verified_at ? 'verified' : 'unverified' }}">
                                <i class="bi {{ $user->email_verified_at ? 'bi-patch-check-fill' : 'bi-envelope-exclamation' }}"></i>
                                {{ $user->email_verified_at ? 'Verified' : 'Unverified' }}
                            </span>
                            <button type="button" class="profile-badge profile-badge-button" data-bs-toggle="modal" data-bs-target="#detailRolesModal">
                                <i class="bi bi-shield-check"></i>
                                {{ $user->roles->count() }} Role
                            </button>
                        </div>

                        <div class="profile-contact-list">
                            <div class="profile-contact-item">
                                <span><i class="bi bi-envelope"></i></span>
                                <div>
                                    <small>Email</small>
                                    <p>{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="profile-contact-item">
                                <span><i class="bi bi-telephone"></i></span>
                                <div>
                                    <small>Phone</small>
                                    <p>{{ $phone }}</p>
                                </div>
                            </div>
                            <div class="profile-contact-item">
                                <span><i class="bi bi-geo-alt"></i></span>
                                <div>
                                    <small>Location</small>
                                    <p>{{ $location ?: 'Lokasi belum ditambahkan.' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="profile-detail-card h-100">
                    <div class="profile-card-header">
                        <div>
                            <h5>Profile Information</h5>
                            <p>Informasi utama yang digunakan user ini.</p>
                        </div>
                        <span class="profile-updated">
                            <i class="bi bi-clock-history"></i>
                            {{ optional($user->updated_at)->diffForHumans() }}
                        </span>
                    </div>

                    <div class="profile-info-grid">
                        <div class="profile-info-item">
                            <span class="info-icon"><i class="bi bi-person"></i></span>
                            <div>
                                <small>Full Name</small>
                                <p>{{ $user->name }}</p>
                            </div>
                        </div>
                        <div class="profile-info-item">
                            <span class="info-icon"><i class="bi bi-at"></i></span>
                            <div>
                                <small>Username</small>
                                <p>{{ $user->username }}</p>
                            </div>
                        </div>
                        <div class="profile-info-item">
                            <span class="info-icon"><i class="bi bi-envelope"></i></span>
                            <div>
                                <small>Email</small>
                                <p>{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="profile-info-item">
                            <span class="info-icon"><i class="bi bi-toggle-on"></i></span>
                            <div>
                                <small>Status</small>
                                <p>{{ $user->status ? 'Active' : 'Inactive' }}</p>
                            </div>
                        </div>
                       
                        <div class="profile-info-item">
                            <span class="info-icon"><i class="bi bi-calendar3"></i></span>
                            <div>
                                <small>Birth Date</small>
                                <p>{{ $profile?->birth_date ? \Illuminate\Support\Carbon::parse($profile->birth_date)->format('d M Y') : '-' }}</p>
                            </div>
                        </div>
                        <div class="profile-info-item">
                            <span class="info-icon"><i class="bi bi-gender-ambiguous"></i></span>
                            <div>
                                <small>Gender</small>
                                <p>{{ $profile?->gender ? ucfirst($profile->gender) : '-' }}</p>
                            </div>
                        </div>
                        
                        <div class="profile-info-item">
                            <span class="info-icon"><i class="bi bi-globe"></i></span>
                            <div>
                                <small>Website</small>
                                <p>
                                    @if($profile?->website)
                                        <a href="{{ $profile->website }}" target="_blank" rel="noopener" class="profile-link">{{ $profile->website }}</a>
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="profile-info-item">
                            <span class="info-icon"><i class="bi bi-person-badge"></i></span>
                            <div>
                                <small>Created</small>
                                <p>{{ optional($user->created_at)->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="profile-address-box">
                        <div class="profile-card-header compact">
                            <div>
                                <h5>Address</h5>
                                <p>{{ $address }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="profile-social-box">
                        <div class="profile-card-header compact">
                            <div>
                                <h5>Media Social</h5>
                                <p>Daftar media sosial user yang tersimpan dalam format JSON.</p>
                            </div>
                        </div>

                        <div class="profile-social-list">
                            @forelse($socialMedia as $platform => $value)
                                <a href="{{ str_starts_with($value, 'http') ? $value : '#' }}" target="_blank" rel="noopener" class="profile-social-link">
                                    <i class="bi bi-{{ $platform === 'twitter' ? 'twitter-x' : $platform }}"></i>
                                    <span>{{ ucfirst($platform) }}</span>
                                </a>
                            @empty
                                <span class="profile-social-empty">Media sosial belum ditambahkan.</span>
                            @endforelse
                        </div>
                    </div>

                    
                </div>
            </div>
        </div>

        <div class="profile-detail-card mt-4">
            <div class="profile-card-header">
                <div>
                    <h5>Login History</h5>
                    <p>10 aktivitas login terakhir user.</p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table profile-history-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>IP Address</th>
                            <th>Device</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($user->loginHistories()->latest()->limit(10)->get() as $login)
                            <tr>
                                <td><span class="history-ip">{{ $login->ip_address }}</span></td>
                                <td>{{ $login->device }}</td>
                                <td>{{ $login->login_at }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="bi bi-clock-history"></i>
                                        <p>Belum ada riwayat login.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade profile-modal" id="detailEditUserModal" tabindex="-1" aria-labelledby="detailEditUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content profile-modal-content">
                <form method="POST" action="{{ route('user.update', $user->id) }}" id="detailEditUserForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="redirect_to" value="detail">

                    <div class="modal-header profile-modal-header">
                        <div class="modal-heading">
                            <span class="modal-icon modal-icon-primary"><i class="bi bi-person-gear"></i></span>
                            <div>
                                <h5 class="modal-title" id="detailEditUserModalLabel">Edit Profile User</h5>
                                <p>Perbarui data utama, role, dan avatar user.</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body profile-modal-body">
                        <div class="avatar-upload-card mb-4">
                            <div class="avatar-preview-box">
                                <img src="{{ $avatar }}" alt="Preview Avatar" id="detail-avatar-preview">
                            </div>
                            <div class="avatar-upload-content">
                                <label for="detailAvatar" class="form-label">Avatar</label>
                                <input type="file" class="form-control" name="avatar" accept=".jpg,.png,.jpeg,.webp" id="detailAvatar">
                                <div class="form-text">Biarkan kosong jika tidak ingin mengganti avatar.</div>
                            </div>
                        </div>

                        <div class="form-section-title">
                            <i class="bi bi-person-vcard"></i>
                            <span>Informasi User</span>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="detailName">Full Name</label>
                                <div class="input-group input-group-modern">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input name="name" id="detailName" type="text" value="{{ old('name', $user->name) }}" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="detailUsername">Username</label>
                                <div class="input-group input-group-modern">
                                    <span class="input-group-text"><i class="bi bi-at"></i></span>
                                    <input name="username" id="detailUsername" type="text" value="{{ old('username', $user->username) }}" class="form-control" pattern="[A-Za-z0-9._-]+" title="Tanpa spasi. Gunakan huruf, angka, titik, garis bawah, atau tanda minus.">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="detailEmail">Email</label>
                                <div class="input-group input-group-modern">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input name="email" id="detailEmail" type="email" value="{{ old('email', $user->email) }}" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="detailEmailVerified">Validasi Email</label>
                                <div class="form-check form-switch border rounded-2 px-3 py-2">
                                    <input type="hidden" name="email_verified" value="0">
                                    <input class="form-check-input ms-0 me-2" type="checkbox" role="switch" name="email_verified" id="detailEmailVerified" value="1" {{ $user->email_verified_at ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="detailEmailVerified">Tandai email sudah terverifikasi</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="detailStatus">Status</label>
                                <div class="input-group input-group-modern">
                                    <span class="input-group-text"><i class="bi bi-toggle-on"></i></span>
                                    <select name="status" id="detailStatus" class="form-select">
                                        <option value="1" {{ $user->status ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ ! $user->status ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="detailRole">Role</label>
                                <div class="input-group input-group-modern">
                                    <span class="input-group-text"><i class="bi bi-shield-check"></i></span>
                                    <select name="role" id="detailRole" class="form-select js-select2" data-placeholder="Pilih Role" data-dropdown-parent="#detailEditUserModal">
                                        <option value="">Pilih Role</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ $user->roles->first()?->id === $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-section-title mt-4">
                            <i class="bi bi-person-lines-fill"></i>
                            <span>Informasi Profil</span>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="detailPhone">Phone</label>
                                <div class="input-group input-group-modern">
                                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                    <input name="phone" id="detailPhone" type="text" value="{{ old('phone', $profile?->phone) }}" class="form-control" placeholder="Masukkan nomor telepon">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="detailBirthDate">Birth Date</label>
                                <div class="input-group input-group-modern">
                                    <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                                    <input name="birth_date" id="detailBirthDate" type="date" value="{{ old('birth_date', optional($profile?->birth_date)->format('Y-m-d') ?? $profile?->birth_date) }}" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="detailGender">Gender</label>
                                <div class="input-group input-group-modern">
                                    <span class="input-group-text"><i class="bi bi-gender-ambiguous"></i></span>
                                    <select name="gender" id="detailGender" class="form-select">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="male" {{ old('gender', $profile?->gender) === 'male' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="female" {{ old('gender', $profile?->gender) === 'female' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="detailCountry">Country</label>
                                <div class="input-group input-group-modern">
                                    <span class="input-group-text"><i class="bi bi-geo"></i></span>
                                    <input name="country" id="detailCountry" type="text" value="{{ old('country', $profile?->country) }}" class="form-control" placeholder="Indonesia">
                                    <datalist id="detailCountry">
                                        <option value="Indonesia">
                                    </datalist>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="detailWebsite">Website</label>
                                <div class="input-group input-group-modern">
                                    <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                    <input name="website" id="detailWebsite" type="url" value="{{ old('website', $profile?->website) }}" class="form-control" placeholder="https://example.com">
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="detailAddress">Address</label>
                                <textarea name="address" id="detailAddress" class="form-control profile-textarea" rows="4" placeholder="Masukkan alamat user">{{ old('address', $profile?->address) }}</textarea>
                            </div>
                        </div>

                        <div class="form-section-title mt-4">
                            <i class="bi bi-share"></i>
                            <span>Media Sosial</span>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="detailSocialInstagram">Instagram</label>
                                <div class="input-group input-group-modern">
                                    <span class="input-group-text"><i class="bi bi-instagram"></i></span>
                                    <input name="social_media[instagram]" id="detailSocialInstagram" type="text" value="{{ old('social_media.instagram', $profile?->social_media['instagram'] ?? '') }}" class="form-control" placeholder="https://instagram.com/username">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="detailSocialFacebook">Facebook</label>
                                <div class="input-group input-group-modern">
                                    <span class="input-group-text"><i class="bi bi-facebook"></i></span>
                                    <input name="social_media[facebook]" id="detailSocialFacebook" type="text" value="{{ old('social_media.facebook', $profile?->social_media['facebook'] ?? '') }}" class="form-control" placeholder="https://facebook.com/username">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="detailSocialLinkedin">LinkedIn</label>
                                <div class="input-group input-group-modern">
                                    <span class="input-group-text"><i class="bi bi-linkedin"></i></span>
                                    <input name="social_media[linkedin]" id="detailSocialLinkedin" type="text" value="{{ old('social_media.linkedin', $profile?->social_media['linkedin'] ?? '') }}" class="form-control" placeholder="https://linkedin.com/in/username">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="detailSocialTwitter">X / Twitter</label>
                                <div class="input-group input-group-modern">
                                    <span class="input-group-text"><i class="bi bi-twitter-x"></i></span>
                                    <input name="social_media[twitter]" id="detailSocialTwitter" type="text" value="{{ old('social_media.twitter', $profile?->social_media['twitter'] ?? '') }}" class="form-control" placeholder="https://x.com/username">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer profile-modal-footer">
                        <button class="btn btn-light-modern" type="button" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary-modern" type="submit" form="detailEditUserForm">
                            <i class="bi bi-check2"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade profile-modal" id="detailPasswordModal" tabindex="-1" aria-labelledby="detailPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content profile-modal-content">
                <form method="POST" action="{{ route('user.password.update', $user->id) }}" id="detailPasswordForm">
                    @csrf
                    @method('PUT')

                    <div class="modal-header profile-modal-header">
                        <div class="modal-heading">
                            <span class="modal-icon modal-icon-primary"><i class="bi bi-key"></i></span>
                            <div>
                                <h5 class="modal-title" id="detailPasswordModalLabel">Ubah Kata Sandi</h5>
                                <p>Tetapkan kata sandi baru untuk user ini.</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body profile-modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label" for="detailPassword">Kata sandi baru</label>
                                <div class="input-group input-group-modern">
                                    <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                                    <input type="password" class="form-control" name="password" id="detailPassword" autocomplete="new-password">
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="detailPasswordConfirmation">Konfirmasi kata sandi baru</label>
                                <div class="input-group input-group-modern">
                                    <span class="input-group-text"><i class="bi bi-shield-check"></i></span>
                                    <input type="password" class="form-control" name="password_confirmation" id="detailPasswordConfirmation" autocomplete="new-password">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer profile-modal-footer">
                        <button class="btn btn-light-modern" type="button" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary-modern" type="submit" form="detailPasswordForm">
                            <i class="bi bi-check2"></i>
                            Simpan Kata Sandi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade logout-modal" id="detailStatusModal" tabindex="-1" aria-labelledby="detailStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content logout-modal-content">
                <div class="modal-header logout-modal-header border-0 pb-0">
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body logout-modal-body text-center">
                    <div class="logout-modal-icon">
                        <i class="bi {{ $user->status ? 'bi-toggle-off' : 'bi-toggle-on' }}"></i>
                    </div>
                    <h5 class="modal-title" id="detailStatusModalLabel">{{ $user->status ? 'Nonaktifkan user?' : 'Aktifkan user?' }}</h5>
                    <p>Status {{ $user->name }} akan diubah menjadi {{ $user->status ? 'Inactive' : 'Active' }}.</p>
                </div>
                <div class="modal-footer logout-modal-footer">
                    <button type="button" class="btn btn-light-modern" data-bs-dismiss="modal">Batal</button>
                    <form method="POST" action="{{ route('user.status.update', $user->id) }}" class="m-0">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="{{ $nextStatus }}">
                        <button type="submit" class="btn {{ $user->status ? 'btn-danger-modern' : 'btn-emerald-modern' }}">
                            <i class="bi {{ $user->status ? 'bi-toggle-off' : 'bi-toggle-on' }}"></i>
                            {{ $user->status ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade profile-modal" id="detailRolesModal" tabindex="-1" aria-labelledby="detailRolesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content profile-modal-content">
                <div class="modal-header profile-modal-header">
                    <div class="modal-heading">
                        <span class="modal-icon modal-icon-emerald"><i class="bi bi-shield-lock"></i></span>
                        <div>
                            <h5 class="modal-title" id="detailRolesModalLabel">Role User</h5>
                            <p>Daftar role yang dimiliki oleh {{ $user->name }}.</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body profile-modal-body">
                    <div class="table-responsive">
                        <table class="table profile-history-table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Role</th>
                                    <th>Code</th>
                                    <th>Guard</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($user->roles as $role)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><span class="role-name-cell"><i class="bi bi-shield-check"></i>{{ $role->name }}</span></td>
                                        <td>{{ $role->code ?? '-' }}</td>
                                        <td><span class="history-ip">{{ $role->guard_name }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <div class="empty-state">
                                                <i class="bi bi-shield-x"></i>
                                                <p>User belum memiliki role.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer profile-modal-footer">
                    <button class="btn btn-light-modern" type="button" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('detailAvatar')?.addEventListener('change', function (event) {
            if (!event.target.files[0]) {
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('detail-avatar-preview').src = e.target.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        });
    </script>
@endpush
