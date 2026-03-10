<form action="{{ $action }}" method="POST" 
onsubmit="return confirm('Yakin hapus data?')">

    @csrf
    @method('DELETE')

    <button class="btn btn-danger btn-sm">
        <i class="bi bi-trash"></i>
        Hapus
    </button>

</form>