<div class="modal fade" id="editPermissionGroupModal" tabindex="-1" aria-labelledby="editPermissionGroupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editPermissionGroupForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <div class="modal-heading">
                        <span class="modal-icon modal-icon-emerald">
                            <i class="bi bi-pencil-square"></i>
                        </span>
                        <div>
                            <h5 class="modal-title" id="editPermissionGroupModalLabel">Edit Permission Group</h5>
                            <p>Perbarui data permission group</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editName" class="form-label">Nama Permission Group</label>
                        <input type="text" name="name" id="editName" class="form-control" placeholder="Masukkan nama permission group">
                    </div>
                    <div class="mb-3">
                        <label for="editSortAt" class="form-label">Sort Order</label>
                        <input type="number" name="sort_at" id="editSortAt" class="form-control" placeholder="Masukkan sort order">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-modern" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-emerald-modern">
                        <i class="bi bi-arrow-repeat"></i>
                        Update Permission Group
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>