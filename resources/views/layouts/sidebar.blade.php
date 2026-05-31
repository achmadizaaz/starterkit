@php
    $userMenuOpen = request()->routeIs('user.*', 'role.*', 'permission.*', 'permission-group.*', 'role-permission.*');
    $permissionMenuOpen = request()->routeIs('permission.*', 'permission-group.*', 'role-permission.*');
    $sidebarUser = Auth::user();
    $sidebarRole = $sidebarUser?->roles->first()?->name ?? 'User';
    $sidebarAvatar = $sidebarUser?->avatar ? asset('storage/' . $sidebarUser->avatar) : 'https://i.pravatar.cc/120?u=' . urlencode($sidebarUser?->email ?? 'user');
@endphp

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            <span class="brand-mark"><i class="bi bi-command"></i></span>
            <span class="brand-text">{{ config('app.name', 'Starterkit') }}</span>
        </a>
        <button class="btn btn-sm sidebar-close" onclick="closeSidebar()" aria-label="Close sidebar">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <div class="sidebar-content">
    <ul class="sidebar-menu list-unstyled m-0">
        <li>
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="menu-left">
                    <i class="bi bi-grid-1x2"></i>
                    <span class="menu-text">Dashboard</span>
                </span>
            </a>
        </li>
        <hr class="sidebar-divider">
        <li>
            <a data-bs-toggle="collapse" href="#menuUser" role="button" aria-expanded="{{ $userMenuOpen ? 'true' : 'false' }}" aria-controls="menuUser" class="{{ $userMenuOpen ? '' : 'collapsed' }}">
                <span class="menu-left">
                    <i class="bi bi-people"></i>
                    <span class="menu-text">User Management</span>
                </span>
                <i class="bi bi-chevron-right menu-arrow"></i>
            </a>

            <ul class="collapse submenu list-unstyled {{ $userMenuOpen ? 'show' : '' }}" id="menuUser">
                <li><a href="{{ route('user.index') }}" class="{{ request()->routeIs('user.*') ? 'active' : '' }}">Users</a></li>
                <li><a href="{{ route('role.index') }}" class="{{ request()->routeIs('role.*') ? 'active' : '' }}">Roles</a></li>
                <li>
                    <a data-bs-toggle="collapse" href="#menuPermission" role="button" aria-expanded="{{ $permissionMenuOpen ? 'true' : 'false' }}" aria-controls="menuPermission" class="submenu-toggle {{ $permissionMenuOpen ? '' : 'collapsed' }}">
                        <span>Permissions</span>
                        <i class="bi bi-chevron-right menu-arrow"></i>
                    </a>
                    <ul class="collapse submenu submenu-nested list-unstyled {{ $permissionMenuOpen ? 'show' : '' }}" id="menuPermission">
                        <li><a href="{{ route('permission.index') }}" class="{{ request()->routeIs('permission.*') ? 'active' : '' }}">Permission List</a></li>
                        <li><a href="{{ route('permission-group.index') }}" class="{{ request()->routeIs('permission-group.*') ? 'active' : '' }}">Permission Groups</a></li>
                        <li><a href="{{ route('role-permission.index') }}" class="{{ request()->routeIs('role-permission.*') ? 'active' : '' }}">Assign Permission</a></li>
                    </ul>
                </li>
            </ul>
        </li>

        <li>
            <a href="#">
                <span class="menu-left">
                    <i class="bi bi-gear"></i>
                    <span class="menu-text">Pengaturan</span>
                </span>
            </a>
        </li>
    </ul>

    <div class="sidebar-footer">
        <div class="sidebar-user-mini">
            <img src="{{ $sidebarAvatar }}" alt="{{ $sidebarUser?->name }}">
            <div>
                <strong>{{ $sidebarUser?->name }}</strong>
                <span>{{ $sidebarRole }}</span>
            </div>
        </div>
        <button type="button" class="sidebar-logout-btn" data-bs-toggle="modal" data-bs-target="#logoutConfirmModal">
            <i class="bi bi-box-arrow-right"></i>
            <span class="menu-text">Logout</span>
        </button>
    </div>
    </div>
</div>
