@php
    $userMenuOpen = request()->routeIs('user.*', 'role.*', 'permission.*', 'permission-group.*', 'role-permission.*');
    $monitoringMenuOpen = request()->routeIs('audit-log.*', 'backup.*', 'system-health.*', 'notifications.*');
    $reportMenuOpen = request()->routeIs('reports.*');
    $permissionMenuOpen = request()->routeIs('permission.*', 'permission-group.*', 'role-permission.*');
    $sidebarUser = Auth::user();
    $sidebarRole = $sidebarUser?->roles->first()?->name ?? 'User';
    $sidebarAvatar = $sidebarUser?->avatar ? asset('storage/' . $sidebarUser->avatar) : 'https://i.pravatar.cc/120?u=' . urlencode($sidebarUser?->email ?? 'user');
    $sidebarAppName = \App\Models\AppSetting::getValue('app_name', config('app.name', 'Starterkit'));
    $sidebarLogo = \App\Models\AppSetting::getValue('app_logo');
    $sidebarCanSeeUserManagement = $sidebarUser?->canAny([
        'read-user',
        'read-role',
        'read-permission',
        'read-permission-group',
        'read-role-permission',
    ]) ?? false;
    $sidebarCanSeeOperational = $sidebarUser?->canAny([
        'read-activity-log',
        'read-backup-database',
        'read-system-health',
        'read-notification',
    ]) ?? false;
    $sidebarCanSeeReports = $sidebarUser?->canAny([
        'read-user-report',
        'read-login-activity-report',
    ]) ?? false;
@endphp

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            <span class="brand-mark">
                @if($sidebarLogo)
                    <img src="{{ asset('storage/' . $sidebarLogo) }}" alt="{{ $sidebarAppName }}">
                @else
                    <i class="bi bi-command"></i>
                @endif
            </span>
            <span class="brand-text">{{ $sidebarAppName }}</span>
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
        @if($sidebarCanSeeUserManagement || $sidebarCanSeeOperational || $sidebarCanSeeReports || ($sidebarUser?->can('read-settings') ?? false))
        <hr class="sidebar-divider">
        @endif
        @if($sidebarCanSeeUserManagement)
        <li>
            <a data-bs-toggle="collapse" href="#menuUser" role="button" aria-expanded="{{ $userMenuOpen ? 'true' : 'false' }}" aria-controls="menuUser" class="{{ $userMenuOpen ? '' : 'collapsed' }}">
                <span class="menu-left">
                    <i class="bi bi-people"></i>
                    <span class="menu-text">User Management</span>
                </span>
                <i class="bi bi-chevron-right menu-arrow"></i>
            </a>

            <ul class="collapse submenu list-unstyled {{ $userMenuOpen ? 'show' : '' }}" id="menuUser">
                @can('read-user')
                    <li><a href="{{ route('user.index') }}" class="{{ request()->routeIs('user.*') ? 'active' : '' }}">Users</a></li>
                @endcan
                @can('read-role')
                    <li><a href="{{ route('role.index') }}" class="{{ request()->routeIs('role.*') ? 'active' : '' }}">Roles</a></li>
                @endcan
                @if($sidebarUser?->canAny(['read-permission', 'read-permission-group', 'read-role-permission']))
                    <li>
                    <a data-bs-toggle="collapse" href="#menuPermission" role="button" aria-expanded="{{ $permissionMenuOpen ? 'true' : 'false' }}" aria-controls="menuPermission" class="submenu-toggle {{ $permissionMenuOpen ? '' : 'collapsed' }}">
                        <span>Permissions</span>
                        <i class="bi bi-chevron-right menu-arrow"></i>
                    </a>
                    <ul class="collapse submenu submenu-nested list-unstyled {{ $permissionMenuOpen ? 'show' : '' }}" id="menuPermission">
                        @can('read-permission')
                            <li><a href="{{ route('permission.index') }}" class="{{ request()->routeIs('permission.*') ? 'active' : '' }}">Permission List</a></li>
                        @endcan
                        @can('read-permission-group')
                            <li><a href="{{ route('permission-group.index') }}" class="{{ request()->routeIs('permission-group.*') ? 'active' : '' }}">Permission Groups</a></li>
                        @endcan
                        @can('read-role-permission')
                            <li><a href="{{ route('role-permission.index') }}" class="{{ request()->routeIs('role-permission.*') ? 'active' : '' }}">Assign Permission</a></li>
                        @endcan
                    </ul>
                </li>
                @endif
            </ul>
        </li>
        @endif

        @if($sidebarCanSeeOperational)
        <li>
            <a data-bs-toggle="collapse" href="#menuMonitoring" role="button" aria-expanded="{{ $monitoringMenuOpen ? 'true' : 'false' }}" aria-controls="menuMonitoring" class="{{ $monitoringMenuOpen ? '' : 'collapsed' }}">
                <span class="menu-left">
                    <i class="bi bi-activity"></i>
                    <span class="menu-text">Operasional</span>
                </span>
                <i class="bi bi-chevron-right menu-arrow"></i>
            </a>
            <ul class="collapse submenu list-unstyled {{ $monitoringMenuOpen ? 'show' : '' }}" id="menuMonitoring">
                @can('read-activity-log')
                    <li><a href="{{ route('audit-log.index') }}" class="{{ request()->routeIs('audit-log.*') ? 'active' : '' }}">Audit Log</a></li>
                @endcan
                @can('read-backup-database')
                    <li><a href="{{ route('backup.index') }}" class="{{ request()->routeIs('backup.*') ? 'active' : '' }}">Backup Database</a></li>
                @endcan
                @can('read-system-health')
                    <li><a href="{{ route('system-health.index') }}" class="{{ request()->routeIs('system-health.*') ? 'active' : '' }}">System Health</a></li>
                @endcan
                @can('read-notification')
                    <li><a href="{{ route('notifications.index') }}" class="{{ request()->routeIs('notifications.*') ? 'active' : '' }}">Notifikasi Admin</a></li>
                @endcan
            </ul>
        </li>
        @endif

        @if($sidebarCanSeeReports)
        <li>
            <a data-bs-toggle="collapse" href="#menuReports" role="button" aria-expanded="{{ $reportMenuOpen ? 'true' : 'false' }}" aria-controls="menuReports" class="{{ $reportMenuOpen ? '' : 'collapsed' }}">
                <span class="menu-left">
                    <i class="bi bi-file-earmark-bar-graph"></i>
                    <span class="menu-text">Laporan</span>
                </span>
                <i class="bi bi-chevron-right menu-arrow"></i>
            </a>
            <ul class="collapse submenu list-unstyled {{ $reportMenuOpen ? 'show' : '' }}" id="menuReports">
                @can('read-user-report')
                    <li><a href="{{ route('reports.users') }}" class="{{ request()->routeIs('reports.users') ? 'active' : '' }}">Laporan User</a></li>
                @endcan
                @can('read-login-activity-report')
                    <li><a href="{{ route('reports.login-activities') }}" class="{{ request()->routeIs('reports.login-activities') ? 'active' : '' }}">Aktivitas Login / Logout</a></li>
                @endcan
            </ul>
        </li>
        @endif

        @can('read-settings')
        <li>
            <a href="{{ route('settings.index') }}" class="{{ request()->routeIs('settings.*') ? 'active' : '' }}">
                <span class="menu-left">
                    <i class="bi bi-gear"></i>
                    <span class="menu-text">Pengaturan</span>
                </span>
            </a>
        </li>
        @endcan
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
