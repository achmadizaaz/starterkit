@extends('layouts.main')

@section('title', 'Sync Permission')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="card p-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Sync Permission</h4>
                <div class="page-title-right">
                    <div class="page-title-right">
                        <button type="button" class="btn btn-primary" disabled>
                            <i class="bi bi-arrow-repeat me-1"></i> Synchronize
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- Alert Component-->
        <x-alert/>
        <!-- end Alert Component -->

        <!-- start page main -->
        
        {{-- Change Role --}}
        @include('sync.select-role')
        {{-- END Change Role --}}

        <div class="alert alert-warning text-center fst-italic" role="alert">
            Tidak ada role yang terpilih, silakan pilih role dan klik button <b>Change Role</b>.
        </div>
        <!-- end page main -->
    </div>
@endsection

