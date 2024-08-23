@extends('layouts.main')

@section('title', 'Users')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="card p-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Create a user</h4>
                <div class="page-title-right d-flex gap-1">
                    {{-- Button create user --}}
                    <button type="submit" class="btn btn-primary" form="createForm">
                        <i class="bi bi-save2 me-2"></i> Submit
                    </button>
                    {{-- Button reset user --}}
                    <button type="reset" class="btn btn-danger" form="createForm">
                        <i class="bi bi-arrow-clockwise me-2"></i> Reset
                    </button>
                    {{-- Button kembali --}}
                    <a href="{{ route('users') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-bar-left me-2"></i> Back
                    </a>
                </div>
            </div>
        </div>
        <!-- end page title -->

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

        <!-- start page main -->
        <div class="card p-3">
            <form method="POST" id="createForm" action="{{ route('users.store') }}" enctype= multipart/form-data>
                @csrf
                <div class="row mb-3">
                    <div class="col-md-3 text-center">
                        <div class="mb-3">
                            <img src="{{ asset('assets/images/no-image.webp') }}" alt="Upload a image" class="rounded-3 img-cover" width="100%" max-width="265%" height="100%" max-height="300px" id="preview-image">
                        </div>
                        <label for="uploadImage" class="btn btn-sm btn-info rounded-3 px-4">
                            <i class="bi bi-cloud-arrow-up me-2"></i> Upload a image
                        </label>
                        <input type="file" name="image" class="d-none" id="uploadImage" accept=".jpg,.jpeg,.png,.web">
                    </div>
                    <div class="col-md-9">
                        <div class="row mb-3">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username<span class="fst-italic text-danger">*</span></label>
                                    <input type="text" class="form-control" name="username" id="username" placeholder="Enter username" value="{{ old('username') }}" autofocus required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password<span class="fst-italic text-danger">*</span></label>
                                    <div class="input-group mb-3">
                                        <input type="password" class="form-control" name="password" placeholder="Enter password" required id="password">
                                        <span class="input-group-text" id="showPassword" onclick="showPasswordUser()">
                                            <i class="bi bi-eye-slash" id="icon-password-users"></i>
                                        </span>
                                      </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name<span class="fst-italic text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter name"  value="{{ old('name') }}" required>
                                </div>
                            </div>
                            
                            <div class="col">
                                <div class="mb-3">
                                    <label for="is_active" class="form-label">Is active?<span class="fst-italic text-danger">*</span></label>
                                    <select name="is_active" class="form-select" id="is_active" required>
                                        <option value="">Choose one of the active</option>
                                        <option value="0" @selected(old('is_active') == 0)>Non Active</option>
                                        <option value="1" @selected(old('is_active') == 1)>Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email<span class="fst-italic text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter email, ex: your@example.com"  value="{{ old('email') }}"  required>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
                <hr>
                <ul class="nav nav-tabs" id="myTabUser" role="tablist">
                    {{-- For tab General --}}
                    <li class="nav-item py-2" role="presentation">
                      <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general-tab-pane" type="button" role="tab" aria-controls="general-tab-pane" aria-selected="true">
                        <i class="bi bi-person-lines-fill me-1"></i> General<span class="text-danger fst-italic">*</span>
                      </button>
                    </li>
                    {{-- For tab media social --}}
                    <li class="nav-item py-2" role="presentation">
                      <button class="nav-link" id="media-tab" data-bs-toggle="tab" data-bs-target="#media-tab-pane" type="button" role="tab" aria-controls="media-tab-pane" aria-selected="false">
                        <i class="bi bi-globe me-1"></i>  Media Social
                    </button>
                    </li>
                    {{-- For tab homebase --}}
                    <li class="nav-item py-2" role="presentation">
                        <button class="nav-link" id="homebase-tab" data-bs-toggle="tab" data-bs-target="#homebase-tab-pane" type="button" role="tab" aria-controls="homebase-tab-pane" aria-selected="false">
                            <i class="bi bi-database-lock me-1"></i> Role<span class="text-danger fst-italic">*</span>
                    </button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContentUser">
                    {{-- Tab Additional --}}
                    <div class="tab-pane fade show active" id="general-tab-pane" role="tabpanel" aria-labelledby="general-tab" tabindex="0">
                        <div class="row py-4">
                            <div class="col-6">
                                <div class="row mb-3 align-items-center">
                                    <div class="col-4">
                                        <label for="phone" class="form-label">
                                            <i class="bi bi-telephone-forward me-2"></i> Phone
                                        </label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone') }}">
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-4">
                                        <label for="mobile" class="form-label">
                                            <i class="bi bi-phone me-2"></i> Mobile
                                        </label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control" name="mobile" id="mobile" value="{{ old('mobile') }}">
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-4">
                                        <label for="address" class="form-label">
                                            <i class="bi bi-person-vcard me-2"></i> Address
                                        </label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control" name="address" id="address" value="{{ old('address') }}">
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-4">
                                        <label for="bio" class="form-label">
                                            <i class="bi bi-bookmark me-2"></i> Bio
                                        </label>
                                    </div>
                                    <div class="col-8">
                                        <textarea name="bio" id="bio" cols="30" rows="5" class="form-control">{{old('bio')}}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="row mb-3 align-items-center">
                                    <div class="col-4">
                                        <label for="gender" class="form-label">
                                            <i class="bi bi-gender-ambiguous me-2"></i> Gender<span class="text-danger fst-italic">*</span>
                                        </label>
                                    </div>
                                    <div class="col-8">
                                        <select name="gender" id="gender" class="form-select">
                                            <option value="">Choose a one</option>
                                            <option value="1" @selected(old('gender') == 1)>Laki-laki</option>
                                            <option value="0" @selected(old('gender') == 0)>Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-4">
                                        <label for="place_of_birth" class="form-label">
                                            <i class="bi bi-globe-asia-australia me-2"></i> Place of Birth
                                        </label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control" name="place_of_birth" id="place_of_birth" value="{{ old('place_of_birth')}}">
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-4">
                                        <label for="date_of_birth" class="form-label">
                                            <i class="bi bi-calendar3 me-2"></i> Date of Birth<span class="text-danger fst-italic">*</span>
                                        </label>
                                    </div>
                                    <div class="col-8">
                                        <input type="date" class="form-control" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth')}}">
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-4">
                                        <label for="religion" class="form-label">
                                            <i class="bi bi-ui-radios me-2"></i> Religion<span class="text-danger fst-italic">*</span>
                                        </label>
                                    </div>
                                    <div class="col-8">
                                        <select name="religion" id="religion" class="form-select">
                                            <option value="">Choose a one</option>
                                            <option value="Islam" @selected(old('religion') == 'Islam')>Islam</option>
                                            <option value="Kristen" @selected(old('religion') == 'Kristen')>Kristen</option>
                                            <option value="Katolik" @selected(old('religion') == 'Katolik')>Katolik</option>
                                            <option value="Hindu" @selected(old('religion') == 'Hindu')>Hindu</option>
                                            <option value="Buddha" @selected(old('religion') == 'Buddha')>Buddha</option>
                                            <option value="Khonghucu" @selected(old('religion') == 'Khonghucu')>Khonghucu</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    {{-- Tab Media --}}
                    <div class="tab-pane fade" id="media-tab-pane" role="tabpanel" aria-labelledby="media-tab" tabindex="0">
                         <div class="row py-4">
                            <div class="col-6">
                                <div class="row mb-3 align-items-center">
                                    <div class="col-4">
                                        <label for="website" class="form-label">
                                            <i class="bi bi-globe me-2"></i> Website
                                        </label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control" name="website" id="website" value="{{ old('website') }}">
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-4">
                                        <label for="instagram" class="form-label">
                                            <i class="bi bi-instagram me-2"></i> Instagram
                                        </label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control" name="instagram" id="instagram" value="{{ old('instagram') }}">
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-4">
                                        <label for="facebook" class="form-label">
                                            <i class="bi bi-facebook me-2"></i> Facebook
                                        </label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control" name="facebook" id="facebook" value="{{ old('facebook') }}">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-6">
                                <div class="row mb-3 align-items-center">
                                    <div class="col-4">
                                        <label for="twitter" class="form-label">
                                            <i class="bi bi-twitter me-2"></i> Twitter
                                        </label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control" name="twitter" id="twitter" value="{{ old('twitter') }}">
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-4">
                                        <label for="youtube" class="form-label">
                                            <i class="bi bi-youtube me-2"></i> Youtube
                                        </label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control" name="youtube" id="youtube" value="{{ old('youtube') }}">
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-4">
                                        <label for="other" class="form-label">
                                            <i class="bi bi-three-dots me-2"></i> Other
                                        </label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control" name="other" id="other" value="{{ old('other') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tab Pane Homebase  --}}
                    <div class="tab-pane fade" id="homebase-tab-pane" role="tabpanel" aria-labelledby="homebase-tab" tabindex="0">
                        <div class="row  py-4 mb-3">
                            <div class="col-6">
                                <div class="row align-items-center">
                                    <label for="role" class="form-label col">
                                        <i class="bi bi-fingerprint me-2"></i> Role User<span class="fst-italic text-danger">*</span>
                                    </label>
                                    <select name="role" id="role" class="form-select col">
                                        <option value="">Choose one of the roles</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" @selected(old('role') == $role->id)>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
        <!-- end page main -->
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

    // Show / hide password
    function showPasswordUser() {
        let iconPasswordUsers = document.getElementById("icon-password-users");
        let password = document.getElementById("password");
        // If click icon password, 
        // check type password and change type password
        if(password.type == 'password'){
            iconPasswordUsers.classList.remove('bi-eye-slash');
            iconPasswordUsers.classList.add('bi-eye');
            password.type = "text";
        }else{
            iconPasswordUsers.classList.remove('bi-eye');
            iconPasswordUsers.classList.add('bi-eye-slash');
            password.type = "password";
        }
    };

</script>
@endpush