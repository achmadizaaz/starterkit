@extends('errors.layout')

@section('code', '503')
@section('symbol', '⌁')
@section('kicker', 'Pemeliharaan Sistem')
@section('title', 'Layanan sedang tidak tersedia')
@section('message', 'Aplikasi sedang dalam proses pemeliharaan atau mengalami peningkatan kapasitas.')
@section('hint', 'Silakan kembali beberapa saat lagi. Layanan akan tersedia setelah proses selesai.')

@section('actions')
    <a href="{{ url('/') }}" class="error-btn error-btn-secondary">Ke Halaman Utama</a>
    <button type="button" class="error-btn error-btn-primary" onclick="location.reload()">Periksa Kembali</button>
@endsection
