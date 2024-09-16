@props(['type' => 'text'])

<!-- Success alert -->
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <h4 class="alert-heading">Successfully</h4>
    <hr>
    @if ($type == 'html')
        <p class="mb-0">{!! session('success') !!}</p>
        @else
        <p class="mb-0">{{ session('success') }}</p>
    @endif
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<!-- end success alert -->

<!-- Failed alert -->
@if (session('failed'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <h4 class="alert-heading">Failed</h4>
    <hr>
    @if ($type == 'html')
        <p class="mb-0">{!! session('failed') !!}</p>
        @else
        <p class="mb-0">{{ session('failed') }}</p>
    @endif
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<!-- end failed alert -->

{{-- Alert errors --}}
@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <h4 class="alert-heading">Errors:</h4>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
{{-- End Alert errors --}}