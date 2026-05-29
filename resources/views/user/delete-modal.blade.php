<div class="modal fade modern-modal" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modern-modal-content delete-modal-content">
            <form id="deleteUserForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header modern-modal-header border-0 pb-0">
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body delete-modal-body text-center">
                    <div class="delete-icon">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <h5 class="modal-title" id="deleteUserModalLabel">Hapus User?</h5>
                    <p class="delete-copy">
                        User <strong id="deleteUserName"></strong> akan dihapus dari sistem. Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>

                <div class="modal-footer modern-modal-footer delete-modal-footer">
                    <button type="button" class="btn btn-light-modern" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger-modern">
                        <i class="bi bi-trash3"></i>
                        Hapus User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
