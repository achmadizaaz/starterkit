@extends('errors.layout')

@section('code', '419')
@section('symbol', '↻')
@section('kicker', 'Sesi Berakhir')
@section('title', 'Sesi Anda sudah kedaluwarsa')
@section('message', 'Untuk menjaga keamanan akun, sesi yang tidak aktif akan ditutup secara otomatis.')
@section('hint', 'Muat ulang halaman lalu ulangi tindakan Anda. Data yang belum disimpan mungkin perlu dimasukkan kembali.')

@section('actions')
    <button type="button" class="error-btn error-btn-secondary" onclick="history.back()">Kembali</button>
    <button type="button" class="error-btn error-btn-primary" onclick="location.reload()">Muat Ulang</button>
@endsection
