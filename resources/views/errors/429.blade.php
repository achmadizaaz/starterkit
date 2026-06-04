@extends('errors.layout')

@section('code', '429')
@section('symbol', '…')
@section('kicker', 'Terlalu Banyak Permintaan')
@section('title', 'Mohon tunggu sebentar')
@section('message', 'Sistem menerima terlalu banyak permintaan dari perangkat Anda dalam waktu singkat.')
@section('hint', 'Tunggu beberapa saat sebelum mencoba kembali agar layanan tetap stabil untuk semua pengguna.')

@section('actions')
    <a href="{{ url('/') }}" class="error-btn error-btn-secondary">Ke Halaman Utama</a>
    <button type="button" class="error-btn error-btn-primary" onclick="location.reload()">Coba Lagi</button>
@endsection
