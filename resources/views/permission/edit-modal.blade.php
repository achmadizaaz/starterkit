<div class="modal fade" id="editPermissionModal" tabindex="-1" aria-labelledby="editPermissionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="editPermissionForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <div class="modal-heading">
                                <span class="modal-icon modal-icon-emerald">
                                    <i class="bi bi-pencil-square"></i>
                                </span>
                                <div>
                                    <h5 class="modal-title" id="editPermissionModalLabel">Edit Permission</h5>
                                    <p>Perbarui data permission</p>
                                </div>
                            </div>

                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editName" class="form-label">Nama Permission</label>
                                <div class="input-group">
                                    <input type="text" name="name" id="editName" class="form-control" placeholder="Masukkan nama permission">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="editPermissionGroupId" class="form-label">Permission Group</label>
                                <div class="input-group">
                                    <select name="permission_group_id" id="editPermissionGroupId" class="form-select">
                                        <option value="">-- Pilih Permission Group --</option>
                                        @foreach ($permissionGroups as $group)
                                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-modern" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-emerald-modern">
                                <i class="bi bi-arrow-repeat"></i>
                                Update Permission
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>