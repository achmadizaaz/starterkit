@extends('layouts.app')

@section('title','User Terhapus')

@section('content')
    <div class="container-fluid">
        <div class="mb-4 small">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-modern">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">User Management</li>
                    <li class="breadcrumb-item active">User Terhapus</li>
                </ol>
            </nav>
        </div>

        <div class="page-heading">
            <div>
                <span class="dashboard-kicker">Recycle Bin</span>
                <h4 class="mb-1">User Terhapus</h4>
                <p class="text-muted mb-0">Restore user yang terhapus atau hapus data secara permanen.</p>
            </div>
            <a href="{{ route('user.index') }}" class="btn btn-light-modern">
                <i class="bi bi-arrow-left"></i>
                Kembali ke Users
            </a>
        </div>

        <div class="card card-modern mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('user.deleted.index') }}" class="row g-3 align-items-end">
                    <div class="col-lg-4 col-md-6">
                        <label for="deletedUserSearch" class="form-label">Cari User</label>
                        <div class="input-group input-group-modern">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" id="deletedUserSearch" class="form-control" value="{{ request('search') }}" placeholder="Nama, username, email">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label for="deletedUserRole" class="form-label">Role</label>
                        <select name="role" id="deletedUserRole" class="form-select js-select2" data-placeholder="Semua Role">
                            <option value="">Semua Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" @selected(request('role') === $role->id)>{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-8">
                        <label class="form-label">Tanggal Dihapus</label>
                        <div class="input-group input-group-modern">
                            <input type="date" name="deleted_from" class="form-control" value="{{ request('deleted_from') }}">
                            <span class="input-group-text px-2">s/d</span>
                            <input type="date" name="deleted_to" class="form-control" value="{{ request('deleted_to') }}">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 d-flex gap-2">
                        <a href="{{ route('user.deleted.index') }}" class="btn btn-light-modern flex-fill" title="Reset filter">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                        <button type="submit" class="btn btn-primary-modern flex-fill">
                            <i class="bi bi-funnel"></i>
                            Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card card-modern">
            <div class="card-body">
                <div class="alert alert-warning d-flex align-items-start gap-2">
                    <i class="bi bi-exclamation-triangle mt-1"></i>
                    <div>
                        <strong>Hapus permanen tidak dapat dibatalkan.</strong>
                        Data profil, riwayat login, role, dan file avatar user akan ikut dihapus.
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table modern-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Dihapus Pada</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td class="text-muted fw-500">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                    <td>
                                        <div class="user-cell">
                                            @if($user->avatar)
                                                <img src="{{ asset('storage/'.$user->avatar) }}" alt="{{ $user->name }}" class="avatar-img">
                                            @else
                                                <div class="avatar-placeholder">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                            @endif
                                            <div class="user-info">
                                                <p class="user-name">{{ $user->name }}</p>
                                                <span class="username-text">{{ $user->username }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @forelse($user->roles as $role)
                                            <span class="badge badge-modern badge-role">{{ $role->name }}</span>
                                        @empty
                                            <span class="text-muted">-</span>
                                        @endforelse
                                    </td>
                                    <td>
                                        <div class="audit-time">
                                            <strong>{{ optional($user->deleted_at)->format('d M Y') }}</strong>
                                            <span>{{ optional($user->deleted_at)->format('H:i:s') }}</span>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <div class="action-buttons">
                                            @can('restore-user')
                                                <button type="button" class="btn-action btn-detail" title="Restore User" data-bs-toggle="modal" data-bs-target="#restoreDeletedUserModal" data-user-name="{{ $user->name }}" data-action="{{ route('user.deleted.restore', $user->id) }}">
                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                </button>
                                            @endcan
                                            @can('force-delete-user')
                                                <button type="button" class="btn-action btn-delete" title="Hapus Permanen" data-bs-toggle="modal" data-bs-target="#forceDeleteUserModal" data-user-name="{{ $user->name }}" data-user-username="{{ $user->username }}" data-action="{{ route('user.deleted.force-delete', $user->id) }}">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="bi bi-trash3"></i>
                                            <p>Tidak ada data user yang terhapus.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination-wrapper mt-4">
                    {{ $users->links('vendor.pagination.modern-bootstrap') }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade logout-modal" id="restoreDeletedUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content logout-modal-content">
                <form method="POST" id="restoreDeletedUserForm">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header logout-modal-header border-0 pb-0">
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body logout-modal-body text-center">
                        <div class="logout-modal-icon restore-user-icon"><i class="bi bi-arrow-counterclockwise"></i></div>
                        <h5 class="modal-title">Restore User?</h5>
                        <p>User <strong id="restoreDeletedUserName"></strong> akan dikembalikan dan dapat digunakan kembali.</p>
                    </div>
                    <div class="modal-footer logout-modal-footer">
                        <button type="button" class="btn btn-light-modern" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-emerald-modern"><i class="bi bi-arrow-counterclockwise"></i> Restore User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade logout-modal" id="forceDeleteUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content logout-modal-content">
                <form method="POST" id="forceDeleteUserForm">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header logout-modal-header border-0 pb-0">
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body logout-modal-body text-center">
                        <div class="logout-modal-icon"><i class="bi bi-trash3-fill"></i></div>
                        <h5 class="modal-title">Hapus Permanen?</h5>
                        <p>Semua data <strong id="forceDeleteUserName"></strong> akan dihapus permanen. Ketik username untuk melanjutkan.</p>
                        <div class="text-start mt-3">
                            <label for="forceDeleteConfirmation" class="form-label">Konfirmasi username</label>
                            <input type="text" name="confirmation" id="forceDeleteConfirmation" class="form-control" autocomplete="off" required>
                            <div class="form-text">Ketik persis: <code id="forceDeleteUsername"></code></div>
                        </div>
                    </div>
                    <div class="modal-footer logout-modal-footer">
                        <button type="button" class="btn btn-light-modern" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger-modern" id="forceDeleteSubmit" disabled><i class="bi bi-trash3"></i> Hapus Permanen</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('restoreDeletedUserModal')?.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            document.getElementById('restoreDeletedUserForm').action = button.getAttribute('data-action');
            document.getElementById('restoreDeletedUserName').textContent = button.getAttribute('data-user-name');
        });

        const forceDeleteInput = document.getElementById('forceDeleteConfirmation');
        const forceDeleteSubmit = document.getElementById('forceDeleteSubmit');
        let expectedUsername = '';

        document.getElementById('forceDeleteUserModal')?.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            expectedUsername = button.getAttribute('data-user-username');
            document.getElementById('forceDeleteUserForm').action = button.getAttribute('data-action');
            document.getElementById('forceDeleteUserName').textContent = button.getAttribute('data-user-name');
            document.getElementById('forceDeleteUsername').textContent = expectedUsername;
            forceDeleteInput.value = '';
            forceDeleteSubmit.disabled = true;
        });

        forceDeleteInput?.addEventListener('input', function () {
            forceDeleteSubmit.disabled = forceDeleteInput.value !== expectedUsername;
        });
    </script>
@endpush
