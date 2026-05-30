<div class="modal fade" id="deletePermissionGroupModal" tabindex="-1" aria-labelledby="deletePermissionGroupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content delete-modal-content">
            <form id="deletePermissionGroupForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body delete-modal-body text-center">
                    <div class="delete-icon">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <h5 class="modal-title" id="deletePermissionGroupModalLabel">Hapus Permission Group?</h5>
                    <p class="delete-copy">
                        Permission group <strong id="deleteGroupName"></strong> akan dihapus dari sistem. Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>

               <div class="modal-footer delete-modal-footer">
                    <button type="button" class="btn btn-light-modern" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger-modern">
                        <i class="bi bi-trash3"></i>
                        Hapus Permission Group
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>