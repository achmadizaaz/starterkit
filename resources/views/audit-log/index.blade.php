@extends('layouts.app')

@section('title','Audit Log')

@section('content')
    <div class="container-fluid audit-log-page">
        <div class="mb-4 small">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-modern">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active" aria-current="page">Audit Log</li>
                </ol>
            </nav>
        </div>

        <div class="page-heading">
            <div>
                <span class="dashboard-kicker">Monitoring</span>
                <h4 class="mb-1">Audit Log</h4>
                <p class="text-muted mb-0">Pantau aktivitas administratif penting di dalam aplikasi.</p>
            </div>
            <a href="{{ route('audit-log.export', request()->query()) }}" class="btn btn-add-modern">
                <i class="bi bi-download"></i>
                Export CSV
            </a>
        </div>

        <div class="card card-modern mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('audit-log.index') }}" class="row g-3 align-items-end">
                    <div class="col-lg-4">
                        <label for="search" class="form-label">Cari aktivitas</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" id="search" value="{{ $filters['search'] ?? '' }}" class="form-control" placeholder="Aktivitas, IP, nama, email">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <label for="user_id" class="form-label">User</label>
                        <select name="user_id" id="user_id" class="form-select js-select2" data-placeholder="Semua User">
                            <option value="">Semua User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" @selected(($filters['user_id'] ?? '') === $user->id)>
                                    {{ $user->name }} - {{ $user->email }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label for="date_from" class="form-label">Dari tanggal</label>
                        <input type="date" name="date_from" id="date_from" value="{{ $filters['date_from'] ?? '' }}" class="form-control">
                    </div>
                    <div class="col-lg-2">
                        <label for="date_to" class="form-label">Sampai tanggal</label>
                        <input type="date" name="date_to" id="date_to" value="{{ $filters['date_to'] ?? '' }}" class="form-control">
                    </div>
                    <div class="col-lg-1 d-grid">
                        <button type="submit" class="btn btn-primary-modern">
                            <i class="bi bi-funnel"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card card-modern">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table modern-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>User</th>
                                <th>Aktivitas</th>
                                <th>IP Address</th>
                                <th>User Agent</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                                <tr>
                                    <td>
                                        <div class="audit-time">
                                            <strong>{{ optional($log->created_at)->format('d M Y') }}</strong>
                                            <span>{{ optional($log->created_at)->format('H:i:s') }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="user-cell">
                                            <div class="avatar-placeholder">{{ strtoupper(substr($log->user?->name ?? 'S', 0, 1)) }}</div>
                                            <div class="user-info">
                                                <p class="user-name">{{ $log->user?->name ?? 'System' }}</p>
                                                <span class="email-text">{{ $log->user?->email ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="audit-activity">{{ $log->activity }}</span></td>
                                    <td><span class="history-ip">{{ $log->ip_address ?? '-' }}</span></td>
                                    <td><span class="audit-agent" title="{{ $log->user_agent }}">{{ \Illuminate\Support\Str::limit($log->user_agent ?: '-', 90) }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="bi bi-activity"></i>
                                            <p>Belum ada audit log.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination-wrapper mt-4">
                    {{ $logs->links('vendor.pagination.modern-bootstrap') }}
                </div>
            </div>
        </div>
    </div>
@endsection
