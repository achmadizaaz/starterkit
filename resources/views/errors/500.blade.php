@extends('errors.layout')

@section('code', '500')
@section('symbol', '!')
@section('kicker', 'Kesalahan Server')
@section('title', 'Ada kendala di sisi kami')
@section('message', 'Permintaan Anda belum dapat diproses karena terjadi kesalahan internal.')
@section('hint', 'Tim pengelola dapat memeriksa log aplikasi. Silakan coba kembali beberapa saat lagi.')

@section('actions')
    <a href="{{ url('/') }}" class="error-btn error-btn-secondary">Ke Halaman Utama</a>
    <button type="button" class="error-btn error-btn-primary" onclick="location.reload()">Coba Lagi</button>
@endsection
