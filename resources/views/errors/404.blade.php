@extends('errors.layout')

@section('code', '404')
@section('symbol', '?')
@section('kicker', 'Halaman Tidak Ditemukan')
@section('title', 'Sepertinya halaman ini sudah berpindah')
@section('message', 'Alamat yang Anda buka tidak tersedia atau mungkin sudah dihapus.')
@section('hint', 'Periksa kembali alamat halaman atau lanjutkan dari halaman utama aplikasi.')

@section('actions')
    <button type="button" class="error-btn error-btn-secondary" onclick="history.back()">Kembali</button>
    <a href="{{ auth()->check() ? route('dashboard') : url('/') }}" class="error-btn error-btn-primary">
        {{ auth()->check() ? 'Ke Dashboard' : 'Ke Halaman Utama' }}
    </a>
@endsection
