 <input
        type="{{ $type ?? 'text' }}"
        name="{{ $name }}"
        value="{{ old($name, $value ?? '') }}"
        class="form-control @error($name) is-invalid @enderror">

    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror