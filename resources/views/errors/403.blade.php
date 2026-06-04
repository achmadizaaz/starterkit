@extends('errors.layout')

@section('code', '403')
@section('symbol', '×')
@section('kicker', 'Akses Ditolak')
@section('title', 'Anda tidak memiliki akses')
@section('message', 'Halaman ini tersedia untuk pengguna dengan hak akses tertentu.')
@section('hint', 'Silakan kembali ke halaman sebelumnya atau masuk menggunakan akun yang memiliki izin sesuai.')

@section('actions')
    <button type="button" class="error-btn error-btn-secondary" onclick="history.back()">Kembali</button>
    @auth
        <a href="{{ route('dashboard') }}" class="error-btn error-btn-primary">Ke Dashboard</a>
    @else
        <a href="{{ route('login') }}" class="error-btn error-btn-primary">Masuk ke Akun</a>
    @endauth
@endsection
