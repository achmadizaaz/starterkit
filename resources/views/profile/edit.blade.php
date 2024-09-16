@extends('layouts.main')

@section('title', $user->name)

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="card p-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ $user->name }}</h4>
                <div class="page-title-right d-flex gap-1">
                    <button type="submit" class="btn text-bg-warning" form="updateForm">
                        <i class="bi bi-pencil-square me-1"></i> Update
                    </button>
                    <a href="{{ route('profile') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-bar-left me-1"></i> Back
                    </a>
                </div>
            </div>
            
        </div>
        <!-- end page title -->

        <!-- start alert -->
        {{-- Success --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Successfully</h4>
                <hr>
                <p class="mb-0">{{ session('success') }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Failed --}}
        @if (session('failed'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Failed</h4>
                <hr>
                <p class="mb-0">{{ session('failed') }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <!-- end alert -->

        @if ($errors->any())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <h5 class="alert-heading">
                    <i class="bi bi-exclamation-circle me-2"></i>  Errors:
                </h5>
                {{-- Button close --}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <hr>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- start page main -->
        <div class="row">
            
            <div class="col-8">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="updateForm">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-3 text-center">
                                    <div class="mb-3">
                                       @if (isset($user->image))
                                        <img src="{{ asset('storage/'.$user->image) }}" alt="Upload a image" class="rounded-3 img-cover" width="100%" max-width="265%" height="100%" max-height="300px" id="img-preview">
                                       @else
                                        <img src="{{ asset('assets/images/no-image.webp') }}" alt="Upload a image" class="rounded-3 img-cover" width="100%" max-width="265%" height="100%" max-height="300px" id="img-preview">
                                       @endif
                                    </div>
                                    <label for="uploadImage" class="btn btn-sm btn-info rounded-3 px-4">
                                        <i class="bi bi-cloud-arrow-up me-2"></i> Upload a image
                                    </label>
                                    <input type="file" name="image" class="d-none" id="uploadImage" accept=".jpg,.jpeg,.png,.web">
                                </div>
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-4">
                                                <label for="name" class="form-label">Name <span class="text-danger fst-italic">*</span></label>
                                                <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $user->name) }}">
                                            </div>
                                            <div class="mb-4">
                                                <h6>Username</h6>
                                                {{ $user->username }}
                                            </div>
                                            <div class="mb-4">
                                                <h6>Email</h6>
                                                {{ $user->email }}
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-4">
                                                <h6>Is active?</h6>
                                                {!! $user->is_active ? '<span class="badge text-bg-success">Active</span>' : '<span class="badge text-bg-danger">Non Active</span>' !!}
                                            </div>

                                            <div class="mb-4">
                                                <h6>Roles</h6>
                                                {{ $user->roles->pluck('name')[0] ?? 'Tidak memiliki role' }}
                                            </div>
                                           
                                            <div class="mb-4">
                                                <h6>Last login at</h6>
                                                {!! $user->last_login_at ? $user->last_login_at->diffForHumans() : '<span class="fst-italic">Belum pernah login</span>'  !!}
                                            </div>
                                            <div class="mb-4">
                                                <h6>Last login ip</h6>
                                                {!! $user->last_login_ip ?? '<span class="fst-italic">Belum pernah login</span>' !!}
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
                                                    <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone', $user->profile->phone ?? '') }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3 align-items-center">
                                                <div class="col-4">
                                                    <label for="address" class="form-label">
                                                        <i class="bi bi-person-vcard me-2"></i> Address
                                                    </label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" class="form-control" name="address" id="address" value="{{ old('address', $user->profile->address ?? '') }}">
                                                </div>
                                            </div>
                                        </div>
            
                                        <div class="col-6">
                                            <div class="row mb-3 align-items-center">
                                                <div class="col-5">
                                                    <label for="gender" class="form-label">
                                                        <i class="bi bi-gender-ambiguous me-2"></i> Gender<span class="text-danger fst-italic">*</span>
                                                    </label>
                                                </div>
                                                <div class="col-7">
                                                    <select name="gender" id="gender" class="form-select">
                                                        <option value="">Choose a one</option>
                                                        <option value="man" @selected(old('gender', $user->profile->gender ?? '') == 1)>Laki-laki</option>
                                                        <option value="woman" @selected(old('gender', $user->profile->gender ?? '') == 0)>Perempuan</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3 align-items-center">
                                                <div class="col-5">
                                                    <label for="date_of_birth" class="form-label">
                                                        <i class="bi bi-calendar3 me-2"></i> Date of Birth<span class="text-danger fst-italic">*</span>
                                                    </label>
                                                </div>
                                                <div class="col-7">
                                                    <input type="date" class="form-control" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $user->profile->date_of_birth ?? '') }}">
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            


            <div class="col-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5>Change Password</h5>
                        <hr>
                        <form action="{{ route('profile.change.password') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="password_current_user" class="form-label">Password current<span class="fst-italic text-danger">*</span></label>
                                <input type="password" class="form-control" name="current_password" id="password_current_user">
                            </div>
                            <div class="mb-3">
                                <label for="password_user" class="form-label">New Password<span class="fst-italic text-danger">*</span></label>
                                <input type="password" class="form-control" name="password" id="password_user">
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation_user" class="form-label">Password Confirmation<span class="fst-italic text-danger">*</span></label>
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation_user">
                            </div>
                            <button type="submit" class="btn btn-outline-success">Save changes</button>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5>Delete account</h5>
                        <div class="mb-3 text-secondary">
                            Once you delete your account you cannot access the application
                        </div>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                            Delete account
                        </button>
                        <!-- Modal Delete Account -->
                        <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
                           <form action="{{ route('profile.delete') }}" method="POST">
                            @csrf
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h1 class="modal-title fs-5 text-danger" id="deleteAccountModalLabel">Delete Account</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                Are you sure you want to delete your account?
                                            </div>
                                            <input type="password" class="form-control" placeholder="Enter the current password" name="password">
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger">Delete account</button>
                                        </div>
                                    </div>
                                </div>
                           </form>
                        </div>
                    </div>
                </div>
            </div>
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
                $('#img-preview').attr('src', e.target.result); 
            }
            reader.readAsDataURL(this.files[0]); 
        });
    </script>
@endpush