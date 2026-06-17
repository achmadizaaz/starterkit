@extends('layouts.app')

@section('title','Laporan User')

@section('content')
    <div class="container-fluid">
        <div class="mb-4 small">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-modern">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">Laporan</li>
                    <li class="breadcrumb-item active">User</li>
                </ol>
            </nav>
        </div>

        <div class="page-heading">
            <div>
                <span class="dashboard-kicker">Reports</span>
                <h4 class="mb-1">Laporan User</h4>
                <p class="text-muted mb-0">Lihat, cetak PDF, atau unduh Excel data user berdasarkan filter.</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                @can('export-user-report')
                    <a href="{{ route('reports.users', array_merge(request()->query(), ['format' => 'pdf'])) }}" target="_blank" class="btn btn-light-modern">
                        <i class="bi bi-filetype-pdf"></i>
                        PDF
                    </a>
                    <a href="{{ route('reports.users', array_merge(request()->query(), ['format' => 'excel'])) }}" class="btn btn-emerald-modern">
                        <i class="bi bi-file-earmark-spreadsheet"></i>
                        Excel
                    </a>
                @endcan
            </div>
        </div>

        <div class="card card-modern mb-3">
            <div class="card-body">
                @include('reports.partials.user-filters')
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
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Verified</th>
                                <th>Terdaftar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td class="text-muted fw-500">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                    <td>
                                        <strong>{{ $user->name }}</strong>
                                        <div class="text-muted small">{{ $user->username }}</div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @forelse($user->roles as $role)
                                            <span class="badge badge-modern badge-role">{{ $role->name }}</span>
                                        @empty
                                            <span class="text-muted">-</span>
                                        @endforelse
                                    </td>
                                    <td><span class="status-badge {{ $user->status ? 'status-active' : 'status-inactive' }}"><span class="status-dot"></span>{{ $user->status ? 'Active' : 'Inactive' }}</span></td>
                                    <td><span class="email-verification-badge {{ $user->email_verified_at ? 'verified' : 'unverified' }}">{{ $user->email_verified_at ? 'Verified' : 'Unverified' }}</span></td>
                                    <td>{{ optional($user->created_at)->format('d M Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="bi bi-inbox"></i>
                                            <p>Tidak ada data user sesuai filter.</p>
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
@endsection
