@extends('layouts.app')

@section('title','Laporan Aktivitas Login / Logout')

@section('content')
    <div class="container-fluid">
        <div class="mb-4 small">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-modern">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">Laporan</li>
                    <li class="breadcrumb-item active">Aktivitas Login / Logout</li>
                </ol>
            </nav>
        </div>

        <div class="page-heading">
            <div>
                <span class="dashboard-kicker">Reports</span>
                <h4 class="mb-1">Aktivitas Login / Logout</h4>
                <p class="text-muted mb-0">Pantau riwayat login, logout, IP, dan perangkat user.</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                @can('export-login-activity-report')
                    <a href="{{ route('reports.login-activities', array_merge(request()->query(), ['format' => 'pdf'])) }}" target="_blank" class="btn btn-light-modern">
                        <i class="bi bi-filetype-pdf"></i>
                        PDF
                    </a>
                    <a href="{{ route('reports.login-activities', array_merge(request()->query(), ['format' => 'excel'])) }}" class="btn btn-emerald-modern">
                        <i class="bi bi-file-earmark-spreadsheet"></i>
                        Excel
                    </a>
                @endcan
            </div>
        </div>

        <div class="card card-modern mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('reports.login-activities') }}" class="row g-3 align-items-end">
                    <input type="hidden" name="format" value="html">
                    <div class="col-lg-4 col-md-6">
                        <label for="activitySearch" class="form-label">Cari Aktivitas</label>
                        <div class="input-group input-group-modern">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" id="activitySearch" class="form-control" value="{{ request('search') }}" placeholder="Nama, username, email, IP, device">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label for="activityFilter" class="form-label">Aktivitas</label>
                        <select name="activity" id="activityFilter" class="form-select">
                            <option value="">Semua</option>
                            <option value="login" @selected(request('activity') === 'login')>Login</option>
                            <option value="logout" @selected(request('activity') === 'logout')>Sudah Logout</option>
                            <option value="online" @selected(request('activity') === 'online')>Belum Logout</option>
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <label class="form-label">Tanggal Login</label>
                        <div class="input-group input-group-modern">
                            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                            <span class="input-group-text px-2">s/d</span>
                            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-12 d-flex gap-2">
                        <a href="{{ route('reports.login-activities') }}" class="btn btn-light-modern flex-fill">
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
                <div class="table-responsive">
                    <table class="table modern-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>IP Address</th>
                                <th>Device</th>
                                <th>Login</th>
                                <th>Logout</th>
                                <th>Durasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activities as $activity)
                                <tr>
                                    <td class="text-muted fw-500">{{ $loop->iteration + ($activities->currentPage() - 1) * $activities->perPage() }}</td>
                                    <td>
                                        <strong>{{ $activity->user?->name ?? 'User terhapus' }}</strong>
                                        <div class="text-muted small">{{ $activity->user?->email ?? '-' }}</div>
                                    </td>
                                    <td><span class="history-ip">{{ $activity->ip_address ?? '-' }}</span></td>
                                    <td class="text-break">{{ $activity->device ?? '-' }}</td>
                                    <td>{{ optional($activity->login_at)->format('d M Y H:i:s') }}</td>
                                    <td>
                                        @if($activity->logout_at)
                                            {{ $activity->logout_at->format('d M Y H:i:s') }}
                                        @else
                                            <span class="email-verification-badge unverified">Belum logout</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($activity->login_at && $activity->logout_at)
                                            {{ $activity->login_at->diffForHumans($activity->logout_at, true) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="bi bi-clock-history"></i>
                                            <p>Tidak ada aktivitas sesuai filter.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination-wrapper mt-4">
                    {{ $activities->links('vendor.pagination.modern-bootstrap') }}
                </div>
            </div>
        </div>
    </div>
@endsection
