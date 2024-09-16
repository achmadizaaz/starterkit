@extends('layouts.main')

@section('title', 'Edit User: '.$user->name)

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="card p-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Edit {{ $user->name }}</h4>
                <div class="page-title-right d-flex gap-1">
                    {{-- Button update user --}}
                    <button type="submit" class="btn text-bg-warning" form="updateForm">
                        <i class="bi bi-pencil-square me-2"></i> Update
                    </button>
                    {{-- Button kembali --}}
                    <a href="{{ route('users.show', $user->slug) }}" class="btn text-bg-secondary">
                        <i class="bi bi-arrow-bar-left me-2"></i> Back
                    </a>
                </div>
            </div>
        </div>
        <!-- end page title -->
        
        <!-- Alert Component-->
        <x-alert/>
        <!-- end Alert Component -->

        <!-- start page main -->
        <div class="card p-3">
            <form method="post" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data"  id="updateForm">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <div class="col-md-3 text-center">
                        <div class="mb-3">
                           @if (isset($user->image))
                            <img src="{{ asset('storage/'.$user->image) }}" alt="Upload a image" class="rounded-3 img-cover" width="100%" max-width="265%" height="100%" max-height="300px" id="preview-image">
                           @else
                            <img src="{{ asset('assets/images/no-image.webp') }}" alt="Upload a image" class="rounded-3 img-cover" width="100%" max-width="265%" height="100%" max-height="300px" id="preview-image">
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
                                   <label for="username" class="form-label">Username <span class="text-danger fst-italic">*</span></label>
                                   <input type="text" name="username" class="form-control" id="username" value="{{ old('username', $user->username) }}">
                                </div>
                                <div class="mb-4">
                                    <label for="name" class="form-label">Name <span class="text-danger fst-italic">*</span></label>
                                   <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $user->name) }}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="email">Email</label>
                                   <input type="email" class="form-control" value="{{$user->email }}" id="email" disabled>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-4">
                                    <label for="is_active" class="form-label">Active?<span class="fst-italic text-danger">*</span></label>
                                    <select name="is_active" class="form-select" id="is_active" required>
                                        <option>Silakan pilih satu</option>
                                        <option value="0" @selected(old('is_active', $user->is_active) == 0)>Non Active</option>
                                        <option value="1" @selected(old('is_active', $user->is_active) == 1)>Active</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="role" class="form-label col">
                                        Roles
                                    </label>
                                    <select name="role" id="role" class="form-select col">
                                        <option value="">Choose one of the roles</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" @selected( old('role', $user->roles->pluck('id')[0] ?? '') == $role->id)>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
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
                                    <div class="col-4">
                                        <label for="gender" class="form-label">
                                            <i class="bi bi-gender-ambiguous me-2"></i> Gender<span class="text-danger fst-italic">*</span>
                                        </label>
                                    </div>
                                    <div class="col-8">
                                        <select name="gender" id="gender" class="form-select">
                                            <option value="">Choose a one</option>
                                            <option value="1" @selected(old('gender', $user->profile->gender) == '1')>Man</option>
                                            <option value="0" @selected(old('gender', $user->profile->gender) == '0')>Woman</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="row mb-3 align-items-center">
                                    <div class="col-4">
                                        <label for="date_of_birth" class="form-label">
                                            <i class="bi bi-calendar3 me-2"></i> Date of Birth<span class="text-danger fst-italic">*</span>
                                        </label>
                                    </div>
                                    <div class="col-8">
                                        <input type="date" class="form-control" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $user->profile->date_of_birth ?? '') }}">
                                    </div>
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
</script>
@endpush