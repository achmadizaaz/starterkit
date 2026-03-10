@extends('layouts.app')

@section('title','Profile')

@section('title-page')
    <div class="container-fluid">
        <div class="title-page d-flex justify-content-between align-items-center mb-3">
            <h4>Profile</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('content')
       <!-- MAIN -->
    
    <div class="container-fluid">

        <div class="row mb-4">
            <!-- PROFILE CARD -->
            <div class="col-lg-4">

                <div class="card shadow-sm border-0 profile-card" style="height: 100%">
                    <div class="card-body text-center">

                        <img src="https://i.pravatar.cc/150"
                            class="profile-avatar mb-3">

                        <h5 class="mb-0">{{ Auth::user()->name }}</h5>
                        <small class="text-muted">Administrator</small>

                        <div class="mt-3">
                            <span class="badge bg-primary">Active</span>
                        </div>

                        <hr>

                        <div class="text-start small">

                            <p class="mb-2">
                                <i class="bi bi-envelope"></i>
                                {{ Auth::user()->email }}
                            </p>

                            <p class="mb-2">
                                <i class="bi bi-telephone"></i>
                                08123456789
                            </p>

                            <p class="mb-0">
                                <i class="bi bi-geo-alt"></i>
                                Jawa Timur
                            </p>

                        </div>

                    </div>
                </div>

            </div>
                <!-- END PROFILE CARD -->


            <!-- PROFILE DETAIL -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0" style="height: 100%">
                    <div class="card-header bg-white">
                        <strong>Profile Information</strong>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-warning btn-sm float-end" data-bs-toggle="modal" data-bs-target="#modalEdit">
                            <i class="bi bi-pencil-square"></i> Edit
                        </button>
                        <x-ui.modal id="modalEdit" title="Edit Profile">
                            <form method="POST" action="{{ route('profile.update', Auth::user()->id) }}" id="editForm" enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                <div class="mb-3 d-flex gap-2 align-items-center">
                                    <img src="https://i.pravatar.cc/150" class="profile-avatar mb-3" id="preview-image">
                                    <div>
                                        <label for="uploadImage" class=" btn btn-primary btn-sm">Upload a photo</label>
                                        <input type="file" class="d-none" name="avatar" accept=".jpg, .png, .jpeg" id="uploadImage">
                                        <div class="mt-1 small fst-italic text-muted">
                                            Ukuran file maks 2MB, berformat .jpg, .jpeg, .png
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <x-form.input-label class="fw-bold">
                                            <i class="bi bi-person"></i> Full Name
                                        </x-form.input-label>
                                        
                                        <x-form.input name="name" type="text" value="{{ Auth::user()->name }}" />

                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <x-form.input-label class="fw-bold">
                                            <i class="bi bi-person"></i> Username
                                        </x-form.input-label>
                                        
                                        <x-form.input name="username" type="text" value="{{ Auth::user()->username }}" :disabled/>

                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="bi bi-envelope"></i>
                                            Email
                                        </label>
                                        <input type="email"
                                            class="form-control"
                                            value="achmad@email.com">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="bi bi-telephone"></i>
                                            Phone
                                        </label>
                                        <input type="text"
                                            class="form-control"
                                            value="08123456789">
                                    </div>

                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="bi bi-geo-alt"></i>
                                        Address
                                    </label>
                                    <textarea class="form-control" rows="3"></textarea>
                                </div>
                            </form>
                            <x-slot:footer>

                                <button class="btn btn-secondary" data-bs-dismiss="modal">
                                Batal
                                </button>

                                <button class="btn btn-primary" type="submit" form="editForm">
                                    Simpan
                                </button>

                            </x-slot:footer>

                        </x-ui.modal>


                    </div> <!-- end card header -->

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <div class="fw-bold small">
                                    Nama:
                                </div>
                                <div>
                                    {{ Auth::user()->name }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="fw-bold small">
                                    Username:
                                </div>
                                <div>
                                    {{ Auth::user()->username }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="fw-bold small">
                                    Email:
                                </div>
                                <div>
                                    {{ Auth::user()->email }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="fw-bold small">
                                    Telepon:
                                </div>
                                <div>
                                    0812-345-6789
                                </div>
                            </div>

                        </div>

                        <div class="mb-3">
                            <div class="fw-bold small">
                                    Alamat:
                                </div>
                                <div>
                                    Perumahan Tiara Candi 1 Blok B No 12 Kota Pasuruan Jawa Timur
                                </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-end small text-muted fst-italic">Data terakhir diperbarui {{ Auth::user()->updated_at }}</div>
                    </div>
                </div>
            </div>
            <!-- END PROFILE DETAIL -->
            
            

        </div>
        

        <div class="card shadow-sm border-0">
            <div class="card-header">
                <strong>Login History</strong>
            </div>

            <div class="card-body">
                <table class="table table-sm">

                    <thead>
                    <tr>
                        <th>IP</th>
                        <th>Device</th>
                        <th>Date</th>
                    </tr>
                    </thead>

                    <tbody>

                        @foreach(auth()->user()->loginHistories()->latest()->limit(10)->get() as $login)

                        <tr>
                            <td>{{ $login->ip_address }}</td>
                            <td>{{ $login->device }}</td>
                            <td>{{ $login->login_at }}</td>
                        </tr>

                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // PREVIEW IMAGE
        $('#uploadImage').change(function(){
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#preview-image').attr('src', e.target.result); 
            }
            reader.readAsDataURL(this.files[0]); 
        });

    </script>
@endpush