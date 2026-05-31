@extends('layouts.app')

@section('title','Profile')

@php
    $profile = $user->profile;
    $avatar = $user->avatar ? asset('storage/' . $user->avatar) : 'https://i.pravatar.cc/300?u=' . urlencode($user->email);
    $primaryRole = $user->roles->first()?->name ?? 'User';
    $phone = $profile?->phone ?? '-';
    $address = $profile?->address ?? 'Alamat belum ditambahkan.';
    $location = collect([$profile?->city, $profile?->province, $profile?->country])->filter()->implode(', ');
@endphp

@section('content')
    <div class="container-fluid profile-page">
        <div class="profile-hero">
            <div class="profile-hero-content">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-modern mb-3">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profile</li>
                    </ol>
                </nav>

                <div class="profile-title-row">
                    <div>
                        <span class="profile-kicker">Account Center</span>
                        <h1>Profile</h1>
                        <p>Kelola identitas, kontak, dan riwayat akses akun Anda.</p>
                    </div>
                    <div class="profile-actions">
                        <button type="button" class="btn btn-profile-password" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                            <i class="bi bi-key"></i>
                            Ubah Kata Sandi
                        </button>
                        <button type="button" class="btn btn-profile-edit" data-bs-toggle="modal" data-bs-target="#editProfileModal">
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
                            <span class="profile-status-dot" title="Active"></span>
                        </div>

                        <h2>{{ $user->name }}</h2>
                        <p class="profile-role">{{ $primaryRole }}</p>

                        <div class="profile-badges">
                            <span class="profile-badge active"><i class="bi bi-check2-circle"></i> Active</span>
                            <button type="button" class="profile-badge profile-badge-button" data-bs-toggle="modal" data-bs-target="#profileRolesModal">
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
                            <p>Informasi utama yang digunakan untuk akun ini.</p>
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
                            <span class="info-icon"><i class="bi bi-telephone"></i></span>
                            <div>
                                <small>Phone</small>
                                <p>{{ $phone }}</p>
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
                            <span class="info-icon"><i class="bi bi-globe"></i></span>
                            <div>
                                <small>Website</small>
                                <p>{{ $profile?->website ?? '-' }}</p>
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
                </div>
            </div>
        </div>

        <div class="profile-detail-card mt-4">
            <div class="profile-card-header">
                <div>
                    <h5>Login History</h5>
                    <p>10 aktivitas login terakhir akun Anda.</p>
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
                                <div class="form-text">Ukuran file maks 2MB, berformat .jpg, .jpeg, .png.</div>
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
                                    <input name="username" id="username" type="text" value="{{ old('username', $user->username) }}" class="form-control" disabled>
                                </div>
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
                                    <input name="phone" id="phone" type="text" value="{{ old('phone', $profile?->phone) }}" class="form-control">
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="address">Address</label>
                                <textarea name="address" id="address" class="form-control profile-textarea" rows="4">{{ old('address', $profile?->address) }}</textarea>
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

    <div class="modal fade profile-modal" id="profileRolesModal" tabindex="-1" aria-labelledby="profileRolesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content profile-modal-content">
                <div class="modal-header profile-modal-header">
                    <div class="modal-heading">
                        <span class="modal-icon modal-icon-emerald"><i class="bi bi-shield-lock"></i></span>
                        <div>
                            <h5 class="modal-title" id="profileRolesModalLabel">Role User</h5>
                            <p>Daftar role yang saat ini dimiliki oleh {{ $user->name }}.</p>
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
                                        <td>
                                            <span class="role-name-cell">
                                                <i class="bi bi-shield-check"></i>
                                                {{ $role->name }}
                                            </span>
                                        </td>
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

    <!-- Change Password Modal -->
    @include('profile.change-password-modal')
@endsection

@push('scripts')
    <script>
        $('#uploadImage').change(function(){
            if (!this.files || !this.files[0]) {
                return;
            }

            let reader = new FileReader();
            reader.onload = (e) => {
                $('#preview-image').attr('src', e.target.result);
            };
            reader.readAsDataURL(this.files[0]);
        });
    </script>
@endpush
