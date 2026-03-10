
{{--  Contoh Penggunaan

<x-ui.alert type="success">
    Data berhasil disimpan
</x-ui.alert>

<x-ui.alert type="error">
    Data gagal disimpan
</x-ui.alert>

End comment--}}

@if ($type == 'success')
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-1"></i>
        {{ $slot }}
        <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if ($type == 'error')
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-x-circle me-1"></i>
        {{ $slot }}
        <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
