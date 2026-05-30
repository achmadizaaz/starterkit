<div class="modal fade" id="createPermissionGroupModal" tabindex="-1" aria-labelledby="createPermissionGroupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('permission-group.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <div class="modal-heading">
                        <span class="modal-icon modal-icon-primary">
                            <i class="bi bi-plus-lg"></i>
                        </span>
                        <div>
                            <h5 class="modal-title" id="createPermissionGroupModalLabel">Tambah Permission Group Baru</h5>
                            <p>Lengkapi informasi dasar permission group.</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Permission Group</label>
                        <div class="input-group">
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan nama permission group">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror 
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="sort_at" class="form-label">Sort Order</label>
                        <input type="number" name="sort_at" id="sort_at" value="{{ old('sort_at') }}" class="form-control @error('sort_at') is-invalid @enderror" placeholder="Masukkan sort order">
                        @error('sort_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-modern" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary-modern">
                        <i class="bi bi-check2"></i>
                        Simpan Permission Group
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>