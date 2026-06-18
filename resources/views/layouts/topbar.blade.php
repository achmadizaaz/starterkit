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

        <div class="topbar-search" id="globalSearchContainer">
            <i class="bi bi-search"></i>
            <input
                id="menuSearch"
                class="form-control global-search"
                type="search"
                placeholder="Cari menu atau user..."
                autocomplete="off"
                aria-label="Pencarian global"
                aria-controls="globalSearchResults"
                aria-expanded="false"
            >
            <kbd class="global-search-shortcut">Ctrl K</kbd>
            <div class="global-search-results" id="globalSearchResults" role="listbox" hidden>
                <div class="global-search-state">
                    <i class="bi bi-search"></i>
                    <span>Ketik minimal 2 karakter untuk mencari.</span>
                </div>
            </div>
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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('globalSearchContainer');
            const input = document.getElementById('menuSearch');
            const panel = document.getElementById('globalSearchResults');

            if (!container || !input || !panel) {
                return;
            }

            const endpoint = @json(route('global-search'));
            let debounceTimer;
            let activeIndex = -1;
            let requestController;

            function setPanel(open) {
                panel.hidden = !open;
                input.setAttribute('aria-expanded', open ? 'true' : 'false');
            }

            function renderState(icon, message, loading = false) {
                panel.replaceChildren();
                const state = document.createElement('div');
                state.className = 'global-search-state';

                const iconElement = document.createElement('i');
                iconElement.className = loading ? 'spinner-border spinner-border-sm' : `bi ${icon}`;
                iconElement.setAttribute('aria-hidden', 'true');

                const text = document.createElement('span');
                text.textContent = message;
                state.append(iconElement, text);
                panel.append(state);
                activeIndex = -1;
                setPanel(true);
            }

            function setActiveResult(index) {
                const items = Array.from(panel.querySelectorAll('.global-search-result'));
                if (!items.length) {
                    return;
                }

                activeIndex = Math.max(0, Math.min(index, items.length - 1));
                items.forEach((item, itemIndex) => {
                    const active = itemIndex === activeIndex;
                    item.classList.toggle('active', active);
                    item.setAttribute('aria-selected', active ? 'true' : 'false');
                });
                items[activeIndex].scrollIntoView({ block: 'nearest' });
            }

            function renderResults(results) {
                panel.replaceChildren();
                activeIndex = -1;

                if (!results.length) {
                    renderState('bi-search', 'Tidak ada hasil yang ditemukan.');
                    return;
                }

                results.forEach(function (result, index) {
                    const link = document.createElement('a');
                    link.href = result.url;
                    link.className = 'global-search-result';
                    link.setAttribute('role', 'option');
                    link.setAttribute('aria-selected', 'false');

                    const icon = document.createElement('span');
                    icon.className = 'global-search-result-icon';
                    const iconElement = document.createElement('i');
                    iconElement.className = `bi ${result.icon}`;
                    icon.append(iconElement);

                    const content = document.createElement('span');
                    content.className = 'global-search-result-content';
                    const title = document.createElement('strong');
                    title.textContent = result.title;
                    const description = document.createElement('small');
                    description.textContent = result.description;
                    content.append(title, description);

                    const badge = document.createElement('span');
                    badge.className = `global-search-result-badge ${result.badge === 'Inactive' ? 'inactive' : ''}`;
                    badge.textContent = result.badge;

                    link.append(icon, content, badge);
                    link.addEventListener('mouseenter', () => setActiveResult(index));
                    panel.append(link);
                });

                setPanel(true);
            }

            async function search(query) {
                requestController?.abort();
                requestController = new AbortController();
                renderState('', 'Mencari...', true);

                try {
                    const response = await fetch(`${endpoint}?q=${encodeURIComponent(query)}`, {
                        headers: { Accept: 'application/json' },
                        signal: requestController.signal,
                    });

                    if (!response.ok) {
                        throw new Error('Search request failed');
                    }

                    const payload = await response.json();
                    renderResults(payload.results || []);
                } catch (error) {
                    if (error.name !== 'AbortError') {
                        renderState('bi-exclamation-circle', 'Pencarian gagal. Silakan coba lagi.');
                    }
                }
            }

            input.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                const query = input.value.trim();

                if (query.length < 2) {
                    requestController?.abort();
                    if (query.length) {
                        renderState('bi-search', 'Ketik minimal 2 karakter untuk mencari.');
                    } else {
                        setPanel(false);
                    }
                    return;
                }

                debounceTimer = setTimeout(() => search(query), 250);
            });

            input.addEventListener('focus', function () {
                if (input.value.trim().length >= 2 || panel.querySelector('.global-search-result')) {
                    setPanel(true);
                }
            });

            input.addEventListener('keydown', function (event) {
                const items = panel.querySelectorAll('.global-search-result');

                if (event.key === 'ArrowDown' && items.length) {
                    event.preventDefault();
                    setActiveResult(activeIndex + 1);
                } else if (event.key === 'ArrowUp' && items.length) {
                    event.preventDefault();
                    setActiveResult(activeIndex <= 0 ? items.length - 1 : activeIndex - 1);
                } else if (event.key === 'Enter' && activeIndex >= 0 && items[activeIndex]) {
                    event.preventDefault();
                    window.location.href = items[activeIndex].href;
                } else if (event.key === 'Escape') {
                    setPanel(false);
                    input.blur();
                }
            });

            document.addEventListener('keydown', function (event) {
                if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 'k') {
                    event.preventDefault();
                    input.focus();
                    input.select();
                }
            });

            document.addEventListener('click', function (event) {
                if (!container.contains(event.target)) {
                    setPanel(false);
                }
            });
        });
    </script>
@endpush

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
