@extends('layouts.app')

@section('title','Backup Database')

@section('content')
    <div class="container-fluid">
        <div class="mb-4 small">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-modern">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Backup Database</li>
                </ol>
            </nav>
        </div>

        <div class="page-heading">
            <div>
                <span class="dashboard-kicker">Recovery</span>
                <h4 class="mb-1">Backup Database</h4>
                <p class="text-muted mb-0">Buat backup SQL terenkripsi, kelola retensi, dan unduh backup saat diperlukan.</p>
            </div>
            <button type="button" class="btn btn-add-modern" data-bs-toggle="modal" data-bs-target="#backupConfirmModal" data-confirm-title="Buat backup database?" data-confirm-message="Sistem akan membuat backup SQL terenkripsi dari database saat ini." data-confirm-action="{{ route('backup.store') }}" data-confirm-method="POST" data-confirm-button="Buat Backup" data-confirm-icon="bi-database-add" data-confirm-class="btn-primary-modern">
                    <i class="bi bi-database-add"></i>
                    Buat Backup
            </button>
        </div>

        @if(session('restore_inspection'))
            @php($inspection = session('restore_inspection'))
            <div class="alert alert-info d-flex align-items-start gap-3">
                <i class="bi bi-clipboard-check fs-4"></i>
                <div>
                    <div class="fw-semibold">Dry-run restore berhasil untuk {{ $inspection['filename'] }}</div>
                    <div class="small">
                        {{ $inspection['statements'] }} statement,
                        {{ $inspection['drop_tables'] }} drop table,
                        {{ $inspection['create_tables'] }} create table,
                        {{ $inspection['insert_rows'] }} insert row.
                    </div>
                </div>
            </div>
        @endif

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card card-modern h-100">
                    <div class="card-body">
                        <div class="form-section-title">
                            <i class="bi bi-shield-lock"></i>
                            Kebijakan Backup
                        </div>
                        <form method="POST" action="{{ route('backup.policy.update') }}" class="d-grid gap-3">
                            @csrf
                            @method('PUT')
                            <div>
                                <label for="backup_retention_days" class="form-label">Retensi backup</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar-week"></i></span>
                                    <input type="number" min="1" max="365" name="backup_retention_days" id="backup_retention_days" value="{{ old('backup_retention_days', $retentionDays) }}" class="form-control">
                                    <span class="input-group-text">hari</span>
                                </div>
                                @error('backup_retention_days')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="alert alert-info small mb-0">
                                Backup disimpan di private storage dan isi file dienkripsi menggunakan APP_KEY.
                            </div>
                            <button type="submit" class="btn btn-primary-modern">
                                <i class="bi bi-save"></i>
                                Simpan Kebijakan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card card-modern">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table modern-table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>File</th>
                                        <th>Dibuat Oleh</th>
                                        <th>Ukuran</th>
                                        <th>Status</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($backups as $backup)
                                        <tr>
                                            <td>
                                                <strong>{{ $backup->filename }}</strong>
                                                <div class="text-muted small">{{ optional($backup->created_at)->format('d M Y H:i') }} • {{ $backup->connection }}</div>
                                            </td>
                                            <td>{{ $backup->user?->name ?? '-' }}</td>
                                            <td>{{ number_format($backup->size / 1024, 2) }} KB</td>
                                            <td>
                                                <div class="d-flex flex-column align-items-start gap-1">
                                                    <span class="status-badge status-active"><span class="status-dot"></span>{{ ucfirst($backup->status) }}</span>
                                                    @if($backup->restored_at)
                                                        <span class="email-verification-badge verified">
                                                            <i class="bi bi-arrow-counterclockwise"></i>
                                                            Pernah direstore
                                                        </span>
                                                        <small class="text-muted">
                                                            {{ $backup->restored_at->format('d M Y H:i') }}
                                                            @if($backup->restoredBy)
                                                                oleh {{ $backup->restoredBy->name }}
                                                            @endif
                                                        </small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <div class="action-buttons">
                                                    <a href="{{ route('backup.download', $backup) }}" class="btn-action btn-detail" title="Download"><i class="bi bi-download"></i></a>
                                                    @if(auth()->user()?->hasRole('Super Administrator'))
                                                        <button type="button" class="btn-action btn-edit" title="Dry-run Restore" data-bs-toggle="modal" data-bs-target="#backupConfirmModal" data-confirm-title="Jalankan dry-run restore?" data-confirm-message="Sistem akan memvalidasi dan menganalisis isi backup {{ $backup->filename }} tanpa mengubah database." data-confirm-action="{{ route('backup.restore.dry-run', $backup) }}" data-confirm-method="POST" data-confirm-button="Jalankan Dry-run" data-confirm-icon="bi-clipboard-check" data-confirm-class="btn-primary-modern">
                                                            <i class="bi bi-clipboard-check"></i>
                                                        </button>
                                                        <button type="button" class="btn-action btn-delete" title="Restore" data-bs-toggle="modal" data-bs-target="#restoreBackupModal" data-restore-url="{{ route('backup.restore', $backup) }}" data-backup-name="{{ $backup->filename }}" data-confirm-text="RESTORE {{ $backup->filename }}">
                                                            <i class="bi bi-arrow-counterclockwise"></i>
                                                        </button>
                                                    @endif
                                                    <button type="button" class="btn-action btn-delete" title="Hapus" data-bs-toggle="modal" data-bs-target="#backupConfirmModal" data-confirm-title="Hapus backup database?" data-confirm-message="File backup {{ $backup->filename }} akan dihapus dari private storage dan tidak dapat digunakan lagi." data-confirm-action="{{ route('backup.destroy', $backup) }}" data-confirm-method="DELETE" data-confirm-button="Hapus Backup" data-confirm-icon="bi-trash3" data-confirm-class="btn-danger-modern">
                                                        <i class="bi bi-trash3"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <div class="empty-state">
                                                    <i class="bi bi-database"></i>
                                                    <p>Belum ada backup database.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination-wrapper mt-4">
                            {{ $backups->links('vendor.pagination.modern-bootstrap') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade logout-modal" id="backupConfirmModal" tabindex="-1" aria-labelledby="backupConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content logout-modal-content">
                <form method="POST" id="backupConfirmForm">
                    @csrf
                    <input type="hidden" name="_method" id="backupConfirmMethod" value="POST">
                    <div class="modal-header logout-modal-header border-0 pb-0">
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body logout-modal-body text-center">
                        <div class="logout-modal-icon" id="backupConfirmIconWrap">
                            <i class="bi bi-question-circle" id="backupConfirmIcon"></i>
                        </div>
                        <h5 class="modal-title" id="backupConfirmModalLabel">Konfirmasi</h5>
                        <p id="backupConfirmMessage">Apakah Anda yakin?</p>
                    </div>
                    <div class="modal-footer logout-modal-footer">
                        <button type="button" class="btn btn-light-modern" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary-modern" id="backupConfirmButton">
                            <i class="bi bi-check2"></i>
                            Lanjutkan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade logout-modal" id="restoreBackupModal" tabindex="-1" aria-labelledby="restoreBackupModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content logout-modal-content">
                <form method="POST" id="restoreBackupForm">
                    @csrf
                    <div class="modal-header logout-modal-header border-0 pb-0">
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body logout-modal-body text-center">
                        <div class="logout-modal-icon">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                        <h5 class="modal-title" id="restoreBackupModalLabel">Restore database?</h5>
                        <p>Proses ini akan menimpa data database saat ini menggunakan backup <strong id="restoreBackupName"></strong>. Jalankan dry-run terlebih dahulu sebelum restore.</p>
                        <div class="text-start mt-3">
                            <label for="restoreConfirmation" class="form-label">Ketik konfirmasi</label>
                            <input type="text" name="confirmation" id="restoreConfirmation" class="form-control" autocomplete="off">
                            <div class="form-text">Ketik persis: <code id="restoreConfirmText"></code></div>
                        </div>
                    </div>
                    <div class="modal-footer logout-modal-footer">
                        <button type="button" class="btn btn-light-modern" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger-modern">
                            <i class="bi bi-arrow-counterclockwise"></i>
                            Restore Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('restoreBackupModal')?.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const restoreUrl = button.getAttribute('data-restore-url');
            const backupName = button.getAttribute('data-backup-name');
            const confirmText = button.getAttribute('data-confirm-text');

            document.getElementById('restoreBackupForm').action = restoreUrl;
            document.getElementById('restoreBackupName').textContent = backupName;
            document.getElementById('restoreConfirmText').textContent = confirmText;
            document.getElementById('restoreConfirmation').value = '';
            document.getElementById('restoreConfirmation').placeholder = confirmText;
        });

        document.getElementById('backupConfirmModal')?.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const form = document.getElementById('backupConfirmForm');
            const methodInput = document.getElementById('backupConfirmMethod');
            const submitButton = document.getElementById('backupConfirmButton');
            const icon = document.getElementById('backupConfirmIcon');

            form.action = button.getAttribute('data-confirm-action');
            methodInput.value = button.getAttribute('data-confirm-method') || 'POST';
            document.getElementById('backupConfirmModalLabel').textContent = button.getAttribute('data-confirm-title') || 'Konfirmasi';
            document.getElementById('backupConfirmMessage').textContent = button.getAttribute('data-confirm-message') || 'Apakah Anda yakin?';
            icon.className = 'bi ' + (button.getAttribute('data-confirm-icon') || 'bi-question-circle');
            submitButton.className = 'btn ' + (button.getAttribute('data-confirm-class') || 'btn-primary-modern');
            submitButton.innerHTML = `<i class="bi ${button.getAttribute('data-confirm-icon') || 'bi-check2'}"></i> ${button.getAttribute('data-confirm-button') || 'Lanjutkan'}`;
        });
    </script>
@endpush
