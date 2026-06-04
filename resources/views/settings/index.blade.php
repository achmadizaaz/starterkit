@extends('layouts.app')

@section('title','Pengaturan')

@section('content')
    @php
        $savedAppName = $settings->get('app_name');
        $savedAppDescription = $settings->get('app_description');
        $effectiveAppName = $savedAppName ?: env('APP_NAME', config('app.name', 'Starterkit'));
        $effectiveAppDescription = $savedAppDescription ?: env('APP_DESCRIPTION');
        $appName = old('app_name', $savedAppName);
        $appDescription = old('app_description', $savedAppDescription);
        $institutionAddress = old('institution_address', $settings->get('institution_address'));
        $phoneNumber = old('phone_number', $settings->get('phone_number'));
        $officialEmail = old('official_email', $settings->get('official_email'));
        $officialWebsite = old('official_website', $settings->get('official_website'));
        $effectiveFooterCopyright = $settings->get('footer_copyright') ?: date('Y') . ' © ' . $effectiveAppName . ' - All rights reserved.';
        $footerCopyright = old('footer_copyright', $settings->get('footer_copyright'));
        $appLogo = $settings->get('app_logo');
        $favicon = $settings->get('favicon');
        $registrationEnabled = old('registration_enabled', $settings->get('registration_enabled', '1')) === '1';
        $registrationStartsAt = old('registration_starts_at', $settings->get('registration_starts_at'));
        $registrationEndsAt = old('registration_ends_at', $settings->get('registration_ends_at'));
        $registrationIsOpen = \App\Models\AppSetting::isPublicRegistrationOpen();
    @endphp

    <div class="container-fluid settings-page">
        <div class="mb-4 small">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-modern">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active" aria-current="page">Pengaturan</li>
                </ol>
            </nav>
        </div>

        <div class="page-heading">
            <div>
                <span class="dashboard-kicker">System Settings</span>
                <h4 class="mb-1">Pengaturan</h4>
                <p class="text-muted mb-0">Kelola identitas aplikasi dan informasi resmi instansi.</p>
            </div>
        </div>

        <div class="settings-shell">
            <div class="settings-tabs">
                <button class="settings-tab active" type="button">
                    <i class="bi bi-sliders"></i>
                    <span>General</span>
                </button>
                <button class="settings-tab" type="button" disabled>
                    <i class="bi bi-database"></i>
                    <span>Backup Database</span>
                </button>
                <button class="settings-tab" type="button" disabled>
                    <i class="bi bi-activity"></i>
                    <span>Audit Log</span>
                </button>
            </div>

            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="settings-panel">
                @csrf
                @method('PUT')

                <div class="settings-panel-header">
                    <div>
                        <h5>Pengaturan Umum</h5>
                        <p>Jika nama aplikasi atau logo tidak diisi, sistem memakai nilai default saat ini.</p>
                    </div>
                    <button type="submit" class="btn btn-primary-modern">
                        <i class="bi bi-save"></i>
                        Simpan Pengaturan
                    </button>
                </div>

                <div class="settings-grid">
                    <div class="settings-main-card">
                        <div class="form-section-title">
                            <i class="bi bi-app-indicator"></i>
                            Identitas Aplikasi
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="app_name" class="form-label">Nama aplikasi</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-type"></i></span>
                                    <input type="text" id="app_name" name="app_name" value="{{ $appName }}" class="form-control @error('app_name') is-invalid @enderror" placeholder="{{ env('APP_NAME', config('app.name', 'Starterkit')) }}">
                                </div>
                                @error('app_name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="official_website" class="form-label">Website resmi</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-globe2"></i></span>
                                    <input type="url" id="official_website" name="official_website" value="{{ $officialWebsite }}" class="form-control @error('official_website') is-invalid @enderror" placeholder="https://domain.go.id">
                                </div>
                                @error('official_website')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12">
                                <label for="app_description" class="form-label">Deskripsi aplikasi</label>
                                <textarea id="app_description" name="app_description" rows="3" class="form-control settings-textarea @error('app_description') is-invalid @enderror" placeholder="Tuliskan deskripsi singkat aplikasi">{{ $appDescription }}</textarea>
                                @error('app_description')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="form-section-title mt-4">
                            <i class="bi bi-person-plus"></i>
                            Registrasi Publik
                        </div>

                        <div class="border rounded-2 p-3">
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
                                <div>
                                    <strong>Izinkan registrasi akun publik</strong>
                                    <div class="form-text">Registrasi hanya tersedia ketika status aktif dan berada dalam periode yang ditentukan.</div>
                                </div>
                                <span class="status-badge {{ $registrationIsOpen ? 'status-active' : 'status-inactive' }}">
                                    <span class="status-dot"></span>
                                    {{ $registrationIsOpen ? 'Registrasi Dibuka' : 'Registrasi Ditutup' }}
                                </span>
                            </div>

                            <div class="form-check form-switch mb-3">
                                <input type="hidden" name="registration_enabled" value="0">
                                <input class="form-check-input" type="checkbox" role="switch" name="registration_enabled" id="registration_enabled" value="1" {{ $registrationEnabled ? 'checked' : '' }}>
                                <label class="form-check-label" for="registration_enabled">Aktifkan registrasi publik</label>
                            </div>

                            <div class="row g-3" id="registrationPeriodFields">
                                <div class="col-md-6">
                                    <label for="registration_starts_at" class="form-label">Tanggal mulai registrasi</label>
                                    <input type="datetime-local" id="registration_starts_at" name="registration_starts_at" value="{{ $registrationStartsAt }}" class="form-control @error('registration_starts_at') is-invalid @enderror">
                                    <div class="form-text">Kosongkan agar dapat dimulai segera.</div>
                                    @error('registration_starts_at')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="registration_ends_at" class="form-label">Tanggal tutup registrasi</label>
                                    <input type="datetime-local" id="registration_ends_at" name="registration_ends_at" value="{{ $registrationEndsAt }}" class="form-control @error('registration_ends_at') is-invalid @enderror">
                                    <div class="form-text">Kosongkan jika tidak memiliki batas waktu.</div>
                                    @error('registration_ends_at')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-section-title mt-4">
                            <i class="bi bi-building"></i>
                            Informasi Instansi
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="phone_number" class="form-label">Nomor telepon</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                    <input type="text" id="phone_number" name="phone_number" value="{{ $phoneNumber }}" class="form-control @error('phone_number') is-invalid @enderror" placeholder="+62">
                                </div>
                                @error('phone_number')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="official_email" class="form-label">Email resmi</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" id="official_email" name="official_email" value="{{ $officialEmail }}" class="form-control @error('official_email') is-invalid @enderror" placeholder="info@domain.go.id">
                                </div>
                                @error('official_email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12">
                                <label for="institution_address" class="form-label">Alamat instansi</label>
                                <textarea id="institution_address" name="institution_address" rows="3" class="form-control settings-textarea @error('institution_address') is-invalid @enderror" placeholder="Alamat lengkap instansi">{{ $institutionAddress }}</textarea>
                                @error('institution_address')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12">
                                <label for="footer_copyright" class="form-label">Footer copyright</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-c-circle"></i></span>
                                    <input type="text" id="footer_copyright" name="footer_copyright" value="{{ $footerCopyright }}" class="form-control @error('footer_copyright') is-invalid @enderror" placeholder="{{ $effectiveFooterCopyright }}">
                                </div>
                                @error('footer_copyright')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="settings-media-card">
                        <div class="form-section-title">
                            <i class="bi bi-image"></i>
                            Media Aplikasi
                        </div>

                        <div class="settings-upload-card">
                            <div class="settings-preview settings-preview-logo">
                                @if($appLogo)
                                    <img src="{{ asset('storage/' . $appLogo) }}" alt="Logo aplikasi">
                                @else
                                    <span><i class="bi bi-command"></i></span>
                                @endif
                            </div>
                            <div>
                                <label for="app_logo" class="form-label">Logo aplikasi</label>
                                <input type="file" id="app_logo" name="app_logo" class="form-control @error('app_logo') is-invalid @enderror" accept=".jpg,.jpeg,.png,.webp">
                                <div class="form-text">Maks 2MB. Format: jpg, jpeg, png, webp.</div>
                                @error('app_logo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="settings-upload-card">
                            <div class="settings-preview settings-preview-favicon">
                                @if($favicon)
                                    <img src="{{ asset('storage/' . $favicon) }}" alt="Favicon">
                                @else
                                    <span><i class="bi bi-stars"></i></span>
                                @endif
                            </div>
                            <div>
                                <label for="favicon" class="form-label">Favicon</label>
                                <input type="file" id="favicon" name="favicon" class="form-control @error('favicon') is-invalid @enderror" accept=".ico,.png,.jpg,.jpeg,.webp">
                                <div class="form-text">Maks 1MB. Gunakan ikon persegi agar terlihat rapi.</div>
                                @error('favicon')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="settings-preview-card">
                            <small>Preview</small>
                            <strong>{{ $effectiveAppName }}</strong>
                            <p>{{ $effectiveAppDescription ?: 'Deskripsi aplikasi belum diatur.' }}</p>
                            <span>{{ $effectiveFooterCopyright }}</span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.getElementById('registration_enabled');
            const fields = document.querySelectorAll('#registrationPeriodFields input');

            function syncRegistrationFields() {
                fields.forEach(field => {
                    field.readOnly = !toggle.checked;
                });
                document.getElementById('registrationPeriodFields').style.opacity = toggle.checked ? '1' : '.55';
            }

            toggle?.addEventListener('change', syncRegistrationFields);
            syncRegistrationFields();
        });
    </script>
@endpush
