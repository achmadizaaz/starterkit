<li>
    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#passwordChangeModal">
        <i class="bi bi-gear"></i> Ubah katasandi
    </a>
</li>

<!-- Modal -->
<div class="modal fade" id="passwordChangeModal" tabindex="-1" aria-labelledby="passwordChangeModalLabel" aria-hidden="true" style="z-index: 9999">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="passwordChangeModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <form>

            <div class="mb-3">
                <label class="form-label">Current Password</label>
                <input type="password" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input type="password" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" class="form-control">
            </div>

            <button class="btn btn-danger">
                Update Password
            </button>

        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>