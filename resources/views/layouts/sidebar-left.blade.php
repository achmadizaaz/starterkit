<div class="vertical-menu">    
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Menu</li>

                <li>
                    <a href="{{ route('dashboard') }}">
                        <i class="bi bi-house-door"></i>
                        <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>
                @can('read-users')
                <li class="menu-title" data-key="t-components">Management User</li>
                <li class="{{ request()->routeIs('users.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('users') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        <span data-key="t-users">Users</span>
                    </a>
                </li>
                @endcan

                @canany(['read-roles', 'read-permissions', 'read-sync-permission-roles'])
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="grid"></i>
                        <span data-key="t-rolepermission">Role Permission</span>
                    </a>
                    @canany(['read-roles', 'read-permissions', 'read-sync-permission-roles'])
                    <ul class="sub-menu" aria-expanded="false">
                        @can('read-roles')
                        <li>
                            <a href="{{ route('roles') }}">
                                <span data-key="t-role">Role</span>
                            </a>
                        </li>
                        @endcan
                        @can('read-permissions')
                        <li>
                            <a href="{{ route('permissions') }}">
                                <span data-key="t-role">Permission</span>
                            </a>
                        </li>
                        @endcan
                        @can('read-sync-permission-roles')
                        <li class="{{ request()->routeIs('sync.permissions.*') ? 'mm-active' : '' }}">
                            <a href="{{ route('sync.permissions') }}" class="{{ request()->routeIs('sync.permissions.*') ? 'active' : '' }}">
                                <span data-key="t-permission">Sync Permission Role</span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                    @endcanany
                </li>
                @endcanany

                <li class="menu-title" data-key="t-reports">Reports</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="bi bi-bar-chart-line"></i>
                        <span data-key="t-rolepermission">Reports</span>
                    </a>
                    @canany(['read-roles', 'read-permissions', 'read-sync-permission-roles'])
                    <ul class="sub-menu" aria-expanded="false">
                        @can('read-roles')
                        <li>
                            <a href="{{ route('report.users') }}">
                                <span data-key="t-role">User Report</span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                    @endcanany
                </li>

                @can('read-options')
                {{-- Option Menu --}}
                <li class="menu-title" data-key="t-components">Options</li>
                <li>
                    <a href="{{ route('options') }}">
                        <i class="bi bi-gear"></i>
                        <span data-key="t-rolepermission">Settings</span>
                    </a>
                </li>
                @endcan
            </ul>
        </div>
    </div>
</div>