@extends('layouts.app')

@section('title','Dashboard')

@section('head')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')

<div class="container-fluid dashboard-page">
    <div class="dashboard-heading">
        <div>
            <span class="dashboard-kicker">Access Control</span>
            <h4 class="mb-1">Dashboard Overview</h4>
            <p class="text-muted mb-0">Ringkasan users, roles, permissions, dan tren pendaftaran user.</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>
    </div>

    <div class="row g-3 g-xl-4">
        <div class="col-md-4">
            <div class="card stat-summary-card shadow-sm h-100">
                <div class="card-body">
                    <div class="stat-card">
                        <div>
                            <div class="text-muted small">Total Users</div>
                            <h3 class="mb-0">{{ number_format($userCount ?? 0) }}</h3>
                        </div>
                        <div class="stat-icon stat-icon-blue">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                    <div class="stat-footer text-success">
                        <i class="bi bi-arrow-up-right"></i>
                        <span>+12.8% bulan ini</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stat-summary-card shadow-sm h-100">
                <div class="card-body">
                    <div class="stat-card">
                        <div>
                            <div class="text-muted small">Total Roles</div>
                            <h3 class="mb-0">{{ number_format($roleCount ?? 0) }}</h3>
                        </div>
                        <div class="stat-icon stat-icon-emerald">
                            <i class="bi bi-shield-check"></i>
                        </div>
                    </div>
                    <div class="stat-footer text-primary">
                        <i class="bi bi-layers"></i>
                        <span>Role aktif terkelola</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stat-summary-card shadow-sm h-100">
                <div class="card-body">
                    <div class="stat-card">
                        <div>
                            <div class="text-muted small">Total Permissions</div>
                            <h3 class="mb-0">{{ number_format($permissionCount ?? 0) }}</h3>
                        </div>
                        <div class="stat-icon stat-icon-cyan">
                            <i class="bi bi-key"></i>
                        </div>
                    </div>
                    <div class="stat-footer text-info">
                        <i class="bi bi-check2-circle"></i>
                        <span>Akses tersinkronisasi</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 g-xl-4 mt-1">
        <div class="col-xl-8">
            <div class="card dashboard-panel shadow-sm h-100">
                <div class="card-body">
                    <div class="panel-header">
                        <div>
                            <h5 class="mb-1">Tren Pendaftaran User</h5>
                            <p class="text-muted mb-0">Data dummy 7 bulan terakhir.</p>
                        </div>
                        <span class="badge rounded-pill bg-primary-subtle text-primary">Line Chart</span>
                    </div>
                    <div class="chart-box">
                        <canvas id="userRegistrationChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card dashboard-panel shadow-sm h-100">
                <div class="card-body">
                    <div class="panel-header">
                        <div>
                            <h5 class="mb-1">Rangkuman Data</h5>
                            <p class="text-muted mb-0">Status modul akses utama.</p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle dashboard-table mb-0">
                            <thead>
                                <tr>
                                    <th>Modul</th>
                                    <th class="text-end">Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><i class="bi bi-people text-primary me-2"></i>Users</td>
                                    <td class="text-end fw-semibold">{{ number_format($userCount ?? 0) }}</td>
                                    <td><span class="badge bg-success-subtle text-success">Active</span></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-shield-check text-success me-2"></i>Roles</td>
                                    <td class="text-end fw-semibold">{{ number_format($roleCount ?? 0) }}</td>
                                    <td><span class="badge bg-primary-subtle text-primary">Managed</span></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-key text-info me-2"></i>Permissions</td>
                                    <td class="text-end fw-semibold">{{ number_format($permissionCount ?? 0) }}</td>
                                    <td><span class="badge bg-info-subtle text-info">Synced</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const chartCanvas = document.getElementById('userRegistrationChart');

            if (!chartCanvas || typeof Chart === 'undefined') {
                return;
            }

            new Chart(chartCanvas, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul'],
                    datasets: [{
                        label: 'User Baru',
                        data: [12, 18, 15, 28, 34, 42, 55],
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, .12)',
                        pointBackgroundColor: '#10b981',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 3,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        fill: true,
                        tension: .42
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            padding: 12,
                            titleFont: {
                                weight: '600'
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            },
                            grid: {
                                color: 'rgba(148, 163, 184, .18)'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
