@extends('errors.layout')

@section('code', $exception->getStatusCode())
@section('symbol', '×')
@section('kicker', 'Permintaan Tidak Dapat Diproses')
@section('title', 'Ada masalah dengan permintaan Anda')
@section('message', 'Permintaan ini tidak dapat diproses oleh aplikasi.')
@section('hint', 'Periksa kembali halaman atau tindakan yang Anda lakukan, lalu coba sekali lagi.')

@section('actions')
    <button type="button" class="error-btn error-btn-secondary" onclick="history.back()">Kembali</button>
    <a href="{{ url('/') }}" class="error-btn error-btn-primary">Ke Halaman Utama</a>
@endsection
