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
            <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i class="bi bi-person"></i> Profile</a></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li>
            
            <li>
                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#passwordChangeModal">
                    <i class="bi bi-gear"></i> Ubah katasandi
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
        </ul>

    </div>

</div>


<!-- Modal Change Password -->
<div class="modal fade" id="passwordChangeModal" tabindex="-1" aria-labelledby="passwordChangeModalLabel" aria-hidden="true" style="z-index: 9999">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="passwordChangeModalLabel">Ubah Kata Sandi</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <form method="POST" action="{{ route('profile.change.password') }}" id="changePasswordForm">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Katasandi saat ini</label>
                <input type="password" class="form-control" name="current_password">
            </div>

            <div class="mb-3">
                <label class="form-label">Katasandi baru</label>
                <input type="password" class="form-control" name="password">
            </div>

            <div class="mb-3">
                <label class="form-label">Ulangi katasandi baru</label>
                <input type="password" class="form-control" name="password_confirmation">
            </div>

        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" form="changePasswordForm">Simpan</button>
      </div>
    </div>
  </div>
</div>