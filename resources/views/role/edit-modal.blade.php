<div class="modal fade modern-modal" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editRoleForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header modern-modal-header">
                    <div class="modal-heading">
                        <span class="modal-icon modal-icon-emerald">
                            <i class="bi bi-pencil-square"></i>
                        </span>
                        <div>
                            <h5 class="modal-title" id="createRoleModalLabel">Edit Role</h5>
                            <p>Perbarui data role</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editCode" class="form-label">Kode Role</label>
                        <input type="text" name="code" id="editCode" class="form-control" placeholder="Masukkan kode role">
                    </div>
                    <div class="mb-3">
                        <label for="editName" class="form-label">Nama Role</label>
                        <input type="text" name="name" id="editName" class="form-control" placeholder="Masukkan nama role">
                    </div>
                </div>
                <div class="modal-footer modern-modal-footer">
                    <button type="button" class="btn btn-light-modern" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-emerald-modern">
                        <i class="bi bi-arrow-repeat"></i>
                        Update Role
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>