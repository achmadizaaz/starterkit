@extends('layouts.main')

@section('title', 'User report')

@section('content')
<div class="card p-3">
    <div class="d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0 font-size-18">Report Users</h4>
        <div class="page-title-right d-flex gap-1">
            <small class="fst-italic">Dashboard / Report / User</small>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('report.users.show') }}" method="POST" id="form">
            @csrf
            <div class="row mb-3">
                <div class="col">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" class="form-select" id="role">
                        <option value="semua">Semua role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="isActive" class="form-label">Status</label>
                    <select name="status" class="form-select" id="isActive">
                        <option value="semua">Semua status</option>
                        <option value="1">Active</option>
                        <option value="0">Non active</option>
                    </select>
                </div>
                <div class="col">
                    <label for="orderBy" class="form-label">Order by</label>
                    <select name="orderBy" class="form-select" id="orderBy">
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-4">
                    <label for="type" class="form-label">Type</label>
                    <select name="type" id="type" class="form-select">
                        <option value="html">HTML</option>
                        <option value="excel">Excel</option>
                    </select>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary" >Submit</button>
                <button type="button" class="btn btn-secondary" id="submitNewTab">Submit and open new tab</button>
            </div>
        </form>
    </div>
</div>
<!-- end page title -->
@endsection

@push('scripts')
<script>
    document.getElementById('submitNewTab').addEventListener('click', function() {
        let form = document.getElementById('form');
        form.target = '_blank'; // Set target ke _blank untuk membuka di tab baru
        form.submit();
    });

</script>

@endpush