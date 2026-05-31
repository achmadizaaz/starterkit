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

    <div class="dropdown">

        <a class="text-decoration-none dropdown-toggle user-box" data-bs-toggle="dropdown">
            <img src="https://i.pravatar.cc/100">
            <span>{{ Auth::user()->name }}</span>
        </a>

        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i class="bi bi-person"></i> Profile</a></li>
            <li>
                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                    <i class="bi bi-gear"></i> Ubah katasandi
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
        </ul>

    </div>

</div>

<!-- Change Password Modal -->
    @include('profile.change-password-modal')
