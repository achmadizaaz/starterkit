<!-- TOPBAR -->
<div class="topbar">

    <div class="d-flex align-items-center gap-2">

        <button class="btn btn-toggle-menu" onclick="toggleSidebar()">
            <i class="bi bi-list" style="font-size:20px"></i>
        </button>

        <input id="menuSearch" class="form-control global-search" placeholder="Search...">

    </div>

    <div class="dropdown">

        <a class="text-decoration-none dropdown-toggle user-box" data-bs-toggle="dropdown">
            <img src="https://i.pravatar.cc/100">
            <span>Achmad Izaaz</span>
        </a>

        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Profile</a></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
        </ul>

    </div>

</div>