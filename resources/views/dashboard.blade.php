@extends('layouts.app')

@section('title','Dashboard')

@section('content')
    <!-- MAIN -->
<div class="main">

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-4">Dashboard Overview</h4>
    <div>Home / Dashboard</div>
</div>

<div class="row g-4">

<div class="col-md-3">
<div class="card shadow-sm">
<div class="card-body stat-card">
<div>
<div class="text-muted small">Total Produk</div>
<h4 class="mb-0">120</h4>
</div>
<div class="stat-icon">
<i class="bi bi-box"></i>
</div>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card shadow-sm">
<div class="card-body stat-card">
<div>
<div class="text-muted small">Total User</div>
<h4 class="mb-0">25</h4>
</div>
<div class="stat-icon">
<i class="bi bi-people"></i>
</div>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card shadow-sm">
<div class="card-body stat-card">
<div>
<div class="text-muted small">Transaksi Hari Ini</div>
<h4 class="mb-0">75</h4>
</div>
<div class="stat-icon">
<i class="bi bi-cash"></i>
</div>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card shadow-sm">
<div class="card-body stat-card">
<div>
<div class="text-muted small">Pendapatan</div>
<h4 class="mb-0">Rp 5.2jt</h4>
</div>
<div class="stat-icon">
<i class="bi bi-graph-up"></i>
</div>
</div>
</div>
</div>

</div>

</div>

</div>
@endsection