@extends('errors.layout')

@section('code', $exception->getStatusCode())
@section('symbol', '!')
@section('kicker', 'Gangguan Layanan')
@section('title', 'Permintaan belum dapat diselesaikan')
@section('message', 'Aplikasi mengalami kendala saat memproses permintaan Anda.')
@section('hint', 'Silakan coba kembali beberapa saat lagi. Jika kendala berlanjut, hubungi pengelola aplikasi.')

@section('actions')
    <a href="{{ url('/') }}" class="error-btn error-btn-secondary">Ke Halaman Utama</a>
    <button type="button" class="error-btn error-btn-primary" onclick="location.reload()">Coba Lagi</button>
@endsection
