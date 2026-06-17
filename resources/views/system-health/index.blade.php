@extends('layouts.app')

@section('title','System Health')

@section('content')
    <div class="container-fluid">
        <div class="page-heading">
            <div>
                <span class="dashboard-kicker">Maintenance</span>
                <h4 class="mb-1">System Health</h4>
                <p class="text-muted mb-0">Pantau kesiapan komponen utama aplikasi.</p>
            </div>
            <span class="status-badge {{ $overallStatus === 'ok' ? 'status-active' : 'status-inactive' }}">
                <span class="status-dot"></span>
                {{ strtoupper($overallStatus) }}
            </span>
        </div>

        <div class="row g-3 g-xl-4">
            @foreach($checks as $check)
                <div class="col-md-6 col-xl-4">
                    <div class="card card-modern h-100">
                        <div class="card-body">
                            <div class="health-card">
                                <span class="health-icon health-{{ $check['status'] }}">
                                    <i class="bi {{ $check['status'] === 'ok' ? 'bi-check2-circle' : ($check['status'] === 'warning' ? 'bi-exclamation-triangle' : 'bi-x-circle') }}"></i>
                                </span>
                                <div>
                                    <h5>{{ $check['name'] }}</h5>
                                    <p>{{ $check['message'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
