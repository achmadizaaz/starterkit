<div class="modal fade modern-modal" id="createRoleModal" tabindex="-1" aria-labelledby="createRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modern-modal-content">
            <form action="{{ route('role.store') }}" method="POST">
                @csrf
                <div class="modal-header modern-modal-header">
                    <div class="modal-heading">
                        <span class="modal-icon modal-icon-primary">
                            <i class="bi bi-plus-lg"></i>
                        </span>
                        <div>
                            <h5 class="modal-title" id="createRoleModalLabel">Tambah Role Baru</h5>
                            <p>Lengkapi informasi dasar role.</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="code" class="form-label">Kode Role</label>
                        <input type="text" name="code" id="code" value="{{ old('code') }}" class="form-control @error('code') is-invalid @enderror" placeholder="Masukkan kode role">
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Role</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan nama role">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer modern-modal-footer">
                    <button type="button" class="btn btn-light-modern" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary-modern">
                        <i class="bi bi-check2"></i>
                        Simpan Role
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>