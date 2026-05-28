<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">

<div class="sidebar-header">
    <span>{{ env('APP_NAME') }}</span>
    <button class="btn btn-sm sidebar-close" onclick="closeSidebar()">
    <i class="bi bi-x-lg"></i>
    </button>
</div>

<ul class="sidebar-menu list-unstyled m-0">

<li>
<a href="#" class="active">
<span class="menu-left">
<i class="bi bi-grid"></i> Dashboard
</span>
</a>
</li>


<li>
<a data-bs-toggle="collapse" href="#menuUser">
<span class="menu-left">
<i class="bi bi-people"></i> User Management
</span>
<i class="bi bi-chevron-right menu-arrow"></i>
</a>

<ul class="collapse submenu list-unstyled" id="menuUser">
    <li>
        <a href="{{ route('user.index') }}">Users</a>
    </li>
    <li><a href="{{ route('role.index') }}">Roles</a></li>
    <li><a href="{{ route('permission.index') }}">Permissions</a></li>
    <li><a href="{{ route('permission-group.index') }}">Permission Groups</a></li>
    <li><a href="{{ route('role-permission.index') }}">Assign Permission</a></li>
</ul>
</li>



<li>
<a href="#">
<span class="menu-left">
<i class="bi bi-gear"></i> Pengaturan
</span>
</a>
</li>

</ul>

</div>
