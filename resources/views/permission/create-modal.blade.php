 <div class="modal fade" id="createPermissionModal" tabindex="-1" aria-labelledby="createPermissionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content">
            <form action="{{ route('permission.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <div class="modal-heading">
                        <span class="modal-icon modal-icon-primary">
                            <i class="bi bi-plus-lg"></i>
                        </span>
                        <div>
                            <h5 class="modal-title" id="createPermissionModalLabel">Tambah Permission Baru</h5>
                            <p>Lengkapi informasi dasar permission.</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Permission</label>
                        <div class="input-group">
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan nama permission">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="permission_group_id" class="form-label">Permission Group</label>
                        <div class="input-group">
                            <select name="permission_group_id" id="permission_group_id" class="form-select js-select2 @error('permission_group_id') is-invalid @enderror" data-placeholder="Pilih Permission Group" data-dropdown-parent="#createPermissionModal">
                                <option value="">-- Pilih Permission Group --</option>
                                @foreach ($permissionGroups as $group)
                                    <option value="{{ $group->id }}" {{ old('permission_group_id') == $group->id ? 'selected' : '' }}>
                                        {{ $group->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('permission_group_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                         </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-modern" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary-modern">
                        <i class="bi bi-check2"></i>
                        Simpan Permission
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
