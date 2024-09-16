@extends('layouts.main')

@section('title', 'Option')


@section('content')
    <div class="container-fluid">
        <!-- Alert Component-->
        <x-alert/>
        <!-- end Alert Component -->

        <form action="{{ route('options.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <h5 class="text-secondary">General Settings</h5>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-3">
                            <label for="site" class="form-label">Site Title</label>
                        </div>
                        <div class="col-6">
                            <input type="text" class="form-control" name="siteTitle" id="site" value="{{ $option['site-title']->value ?? env('APP_NAME') }}" placeholder="{{ $option['site-title']->value ?? env('APP_NAME') }}">
                        </div>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-3">
                            <label for="site" class="form-label">Favicon</label>
                        </div>
                        <div class="col-6">
                            <img src="{{ asset($option['favicon']->value ? 'storage/'.$option['favicon']->value : 'assets/images/laravel.png') }}" alt="favicon" height="42px" width="42px" class="me-2" id="favicon-preview">
                            <!-- Button trigger modal -->
                            <label for="faviconUpload" class="btn btn-sm btn-outline-primary">
                                Change icon
                            </label>
                            <input type="file" class="d-none" name="favicon" id="faviconUpload" accept=".ico,.jpg,.jpeg,.png">
                            <div class="small">
                                The favicon <span class="fst-italic">(icon site)</span> is what you see in browser tabs, bookmark bars, and within the mobile apps. It should be square and at least <b class="text-primary">512 × 512</b> pixels.
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <h5 class="text-secondary">Sidebar</h5>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-3">
                            <label for="site" class="form-label">Icon</label>
                        </div>
                        <div class="col-6">
                            <img src="{{ asset($option['sidebar-icon']->value ? 'storage/'.$option['sidebar-icon']->value : 'assets/images/laravel.png') }}" alt="sidebar icon" height="42px" width="42px" class="me-2" id="sidebar-icon-preview">
                            <!-- Button trigger modal -->
                            <label for="siderbarIconUpload" class="btn btn-sm btn-outline-primary">
                                Change icon
                            </label>
                            <input type="file" class="d-none" name="sidebarIcon" id="siderbarIconUpload" accept=".ico,.jpg,.jpeg,.png">
                            <div class="small">
                                The icon is what you see in sidebar menu. It should be square and at least <b class="text-primary">512 × 512</b> pixels.
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-3">
                            <label for="sidebarTextIcon" class="form-label">Text Icon Sidebar</label>
                        </div>
                        <div class="col-6">
                        <input type="text" name="sidebarTextIcon" class="form-control" id="sidebarTextIcon" value="{{ $option['sidebar-text-icon']->value ?? env('APP_NAME') }}" placeholder="{{ $option['sidebar-text-icon']->value ?? env('APP_NAME') }}">
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <h5 class="text-secondary">Register</h5>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-3">
                            <label for="site" class="form-label">Can register?</label>
                        </div>
                        <div class="col-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" name="canRegister" @checked($option['can-register']->value == 'yes')>
                                <span class="small">Anyone can register</span>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-3">
                            <label for="site" class="form-label">Status Active</label>
                        </div>
                        <div class="col-6">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="isActive" id="active" value="1" @checked($option['default-is-active']->value)>
                                <label class="form-check-label" for="active">Active</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="isActive" id="non-active" value="0" @checked($option['default-is-active']->value == 0)>
                                <label class="form-check-label" for="non-active">Non-active</label>
                              </div>
                        </div>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-3">
                            <label for="site" class="form-label">New user default role</label>
                        </div>
                        <div class="col-6">
                            <select name="defaultRole" id="select" class="form-select">
                                <option value="" class="fw-bold">Without roles</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" @selected($role->id == $option['default-role']->value)>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <h5 class="text-secondary">Forget Password</h5>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-3">
                            <label for="forget-password" class="form-label">Can forget password</label>
                        </div>
                        <div class="col-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" name="canForgetPassword" id="forget-password" @checked($option['can-forget-password']->value == 'yes')>
                                <span class="small">User can forget password</span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div>
                        <button class="btn btn-outline-primary">Save Changes</button>
                    </div>
                </div> <!-- END Card Body -->
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        // FAVICON PREVIEW IMAGE 
        $('#faviconUpload').change(function(){
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#favicon-preview').attr('src', e.target.result); 
            }
            reader.readAsDataURL(this.files[0]); 
        });

        // SIDEBAR ICON PREVIEW IMAGE 
        $('#siderbarIconUpload').change(function(){
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#sidebar-icon-preview').attr('src', e.target.result); 
            }
            reader.readAsDataURL(this.files[0]); 
        });
    </script>
@endpush