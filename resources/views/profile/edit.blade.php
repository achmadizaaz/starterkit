@extends('layouts.app')

@section('title','Profile')

@section('content')
       <!-- MAIN -->
    <div class="main">
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

            <div class="row">
                <!-- PROFILE CARD -->
                <div class="col-lg-4">

                    <div class="card shadow-sm border-0 profile-card">
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


                <!-- PROFILE DETAIL -->
                <div class="col-lg-8">

                    <div class="card shadow-sm border-0">

                        <div class="card-header bg-white">
                            <strong>Profile Information</strong>
                        </div>

                        <div class="card-body">

                            <form>

                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Full Name</label>
                                        <input type="text"
                                            class="form-control"
                                            value="Achmad Izaaz">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="text"
                                            class="form-control"
                                            value="{{ Auth::user()->username }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email"
                                            class="form-control"
                                            value="achmad@email.com">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Phone</label>
                                        <input type="text"
                                            class="form-control"
                                            value="08123456789">
                                    </div>

                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control" rows="3"></textarea>
                                </div>

                                <button class="btn btn-primary">
                                    <i class="bi bi-save"></i>
                                    Update Profile
                                </button>

                            </form>

                        </div>

                    </div>


                    <!-- CHANGE PASSWORD -->
                    <div class="card shadow-sm border-0 mt-4">

                        <div class="card-header bg-white">
                            <strong>Change Password</strong>
                        </div>

                        <div class="card-body">

                            <form>

                                <div class="mb-3">
                                    <label class="form-label">Current Password</label>
                                    <input type="password" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <input type="password" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control">
                                </div>

                                <button class="btn btn-danger">
                                    Update Password
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>
        </div>

    </div>
@endsection