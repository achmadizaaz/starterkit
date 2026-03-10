
{{-- Contoh Penggunaan

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalUser">
  Launch demo modal
</button>

<x-ui.modal id="modalUser" title="Tambah User">

    <!-- Body Modal -->
    <form>
        ...
    </form>

    <!-- Footer Modal -->
    <x-slot:footer>
        <button class="btn btn-secondary" data-bs-dismiss="modal">
        Batal
        </button>

        <button class="btn btn-primary" type="submit">
            Simpan
        </button>

    </x-slot:footer>

</x-ui.modal>

- tambahkan attribut size untuk mengubah ukuran modal
https://getbootstrap.com/docs/5.3/components/modal/#optional-sizes

End comment --}}

<div class="modal fade" id="{{ $id }}" tabindex="-1"  aria-hidden="true">
    <div class="modal-dialog {{ $size ?? '' }}">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                {{ $slot }}
            </div>

            <!-- FOOTER -->
            @isset($footer)
                <div class="modal-footer">
                    {{ $footer }}
                </div>
            @endisset

        </div>
    </div>
</div>

