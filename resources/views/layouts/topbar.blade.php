@php
    $topbarUser = Auth::user();
    $topbarRole = $topbarUser?->roles->first()?->name ?? 'User';
    $topbarAvatar = $topbarUser?->avatar ? asset('storage/' . $topbarUser->avatar) : 'https://i.pravatar.cc/120?u=' . urlencode($topbarUser?->email ?? 'user');
    $topbarCanReadNotifications = $topbarUser?->can('read-notification') ?? false;
    $topbarNotifications = $topbarCanReadNotifications ? $topbarUser?->adminNotifications()->latest()->limit(5)->get() : collect();
    $topbarUnreadNotifications = $topbarCanReadNotifications ? $topbarUser?->adminNotifications()->whereNull('read_at')->count() : 0;
    $isImpersonating = session()->has('impersonator_id');
@endphp

<!-- TOPBAR -->
<div class="topbar">

    <div class="d-flex align-items-center gap-2">

        <button class="btn btn-toggle-menu" onclick="toggleSidebar()" aria-label="Toggle sidebar">
            <i class="bi bi-list" style="font-size:20px"></i>
        </button>

        <div class="topbar-search">
            <i class="bi bi-search"></i>
            <input id="menuSearch" class="form-control global-search" placeholder="Search...">
        </div>

    </div>

    <div class="topbar-actions">
        @if($isImpersonating)
            <form method="POST" action="{{ route('impersonate.destroy') }}" class="m-0">
                @csrf
                @method('DELETE')
                <button type="submit" class="impersonation-return-btn">
                    <i class="bi bi-arrow-left-circle"></i>
                    <span>
                        <strong>Kembali</strong>
                        <small>{{ session('impersonator_name', 'Akun utama') }}</small>
                    </span>
                </button>
            </form>
        @endif

        @if($topbarCanReadNotifications)
            <div class="dropdown topbar-notification-dropdown">
                <button class="btn btn-toggle-menu position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Notifikasi admin">
                    <i class="bi bi-bell" style="font-size:18px"></i>
                    @if($topbarUnreadNotifications > 0)
                        <span class="notification-count">{{ $topbarUnreadNotifications > 9 ? '9+' : $topbarUnreadNotifications }}</span>
                    @endif
                </button>
                <ul class="dropdown-menu dropdown-menu-end notification-dropdown-menu">
                    <li class="notification-dropdown-header">
                        <strong>Notifikasi Admin</strong>
                        <a href="{{ route('notifications.index') }}">Lihat semua</a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    @forelse($topbarNotifications as $notification)
                        <li>
                            <form method="POST" action="{{ route('notifications.read', $notification) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="dropdown-item notification-dropdown-item {{ $notification->read_at ? '' : 'unread' }}">
                                    <strong>{{ $notification->title }}</strong>
                                    <span>{{ \Illuminate\Support\Str::limit($notification->message, 70) }}</span>
                                </button>
                            </form>
                        </li>
                    @empty
                        <li><span class="dropdown-item text-muted small">Belum ada notifikasi.</span></li>
                    @endforelse
                </ul>
            </div>
        @endif

        <div class="dropdown topbar-user-dropdown">

        <button class="user-box" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ $topbarAvatar }}" alt="{{ $topbarUser?->name }}">
            <span class="user-box-meta">
                <span class="user-box-name">{{ $topbarUser?->name }}</span>
                <span class="user-role-badge">{{ $topbarRole }}</span>
            </span>
            <i class="bi bi-chevron-down user-box-chevron"></i>
        </button>

        <ul class="dropdown-menu dropdown-menu-end user-dropdown-menu">
            <li class="user-dropdown-header">
                <img src="{{ $topbarAvatar }}" alt="{{ $topbarUser?->name }}">
                <div>
                    <strong>{{ $topbarUser?->name }}</strong>
                    <span>{{ $topbarUser?->email }}</span>
                </div>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item user-dropdown-item" href="{{ route('profile.show') }}"><i class="bi bi-person"></i> Profile</a></li>
            <li>
                <a class="dropdown-item user-dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                    <i class="bi bi-key"></i> Ubah Kata Sandi
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <button type="button" class="dropdown-item user-dropdown-item user-dropdown-logout" data-bs-toggle="modal" data-bs-target="#logoutConfirmModal">
                    <i class="bi bi-box-arrow-right"></i>
                    Logout
                </button>
            </li>
        </ul>

        </div>
    </div>

</div>

<!-- Change Password Modal -->
    @include('profile.change-password-modal')

<!-- Logout Confirmation Modal -->
<div class="modal fade logout-modal" id="logoutConfirmModal" tabindex="-1" aria-labelledby="logoutConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content logout-modal-content">
            <div class="modal-header logout-modal-header border-0 pb-0">
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body logout-modal-body text-center">
                <div class="logout-modal-icon">
                    <i class="bi bi-box-arrow-right"></i>
                </div>
                <h5 class="modal-title" id="logoutConfirmModalLabel">Keluar dari aplikasi?</h5>
                <p>Anda akan mengakhiri sesi saat ini dan kembali ke halaman login.</p>
            </div>
            <div class="modal-footer logout-modal-footer">
                <button type="button" class="btn btn-light-modern" data-bs-dismiss="modal">Batal</button>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-danger-modern">
                        <i class="bi bi-box-arrow-right"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
