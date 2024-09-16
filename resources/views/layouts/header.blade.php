<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index.html" class="logo">
                    <span class="logo-sm">
                        <img src="{{ asset($option['sidebar-icon']->value ? 'storage/'. $option['sidebar-icon']->value : 'assets/images/laravel.png') }}" alt="" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset( $option['sidebar-icon']->value ? 'storage/'. $option['sidebar-icon']->value : 'assets/images/laravel.png') }}" alt="" height="24"> <span class="logo-txt">{{ $option['sidebar-text-icon']->value ?? config('app.name', 'Laravel') }}
                            </span>
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <!-- App Search-->
            <form class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Search..." name="search" value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit"><i class="bx bx-search-alt align-middle"></i></button>
                </div>
            </form>
        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item" id="page-header-search-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="search" class="icon-lg"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ..." aria-label="Search Result" name="search" value="{{ request('search') }}">

                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <!-- Mode themes  -->
            <div class="dropdown bd-mode-toggle">
                <button class="btn btn-bd-primary py-2 dropdown-toggle header-item" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
                    <span class="bi my-1 theme-icon-active">
                        <i class="theme-change-icon"></i>
                    </span>
                    <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
                    <li>
                    <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
                        <i class="bi bi-sun-fill me-2"></i>
                        Light
                    </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
                        <i class="bi bi-moon-stars-fill me-2"></i>
                            Dark
                        </button>
                    </li>
                    <li>
                    <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
                    <i class="bi bi-circle-half me-2"></i>
                        Auto
                    </button>
                    </li>
                </ul>
            </div>
            <!-- End theme mode -->


            {{-- <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="grid" class="icon-lg"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <div class="p-2">
                        <div class="row g-0">
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="assets/images/brands/github.png" alt="Github">
                                    <span>GitHub</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="assets/images/brands/bitbucket.png" alt="bitbucket">
                                    <span>Bitbucket</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="assets/images/brands/dribbble.png" alt="dribbble">
                                    <span>Dribbble</span>
                                </a>
                            </div>
                        </div>

                        <div class="row g-0">
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="assets/images/brands/dropbox.png" alt="dropbox">
                                    <span>Dropbox</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="assets/images/brands/mail_chimp.png" alt="mail_chimp">
                                    <span>Mail Chimp</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="assets/images/brands/slack.png" alt="slack">
                                    <span>Slack</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- Notifikasi -->
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon position-relative" id="page-header-notifications-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="bell" class="icon-lg"></i>
                    <span class="badge bg-danger rounded-pill">99+</span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0"> Notifications </h6>
                            </div>
                            <div class="col-auto">
                                <a href="#!" class="small text-reset text-decoration-underline"> Unread (2)</a>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;">
                        
                        <a href="#!" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 avatar-sm me-3">
                                    <span class="avatar-title bg-primary rounded-circle font-size-16">
                                        <i class="bx bx-cart"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Your order is placed</h6>
                                    <div class="font-size-13 text-muted">
                                        <p class="mb-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur ultricies fringilla elit in pulvinar</p>
                                        <p class="small mb-0"><i class="mdi mdi-clock-outline"></i> <span>3 min ago</span></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#!" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 avatar-sm me-3">
                                    <span class="avatar-title bg-success rounded-circle font-size-16">
                                        <i class="bx bx-badge-check"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Your item is shipped</h6>
                                    <div class="font-size-13 text-muted">
                                        <p class="mb-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur ultricies fringilla elit in pulvinar</p>
                                        <p class="small mb-0"><i class="mdi mdi-clock-outline"></i> <span>1 days ago</span></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="p-2 border-top d-grid">
                        <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                            <i class="mdi mdi-arrow-right-circle me-1"></i> <span>View More..</span> 
                        </a>
                    </div>
                </div>
            </div>
            <!-- End Notifikasi -->

            <!-- Menu User -->
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item bg-light-subtle border-start border-end" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="@if(isset(Auth::user()->image)) {{ asset('storage/'.Auth::user()->image) }} @else {{ asset('assets/images/no-image.webp')  }} @endif"
                        alt="{{ Auth::user()->name }}">
                    <span class="d-none d-xl-inline-block ms-1 fw-medium">{{ Auth::user()->name }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('profile') }}">
                        <i class="bi bi-person-circle me-2"></i> Profile
                    </a>
                    <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                        <i class="bi bi-shield-lock-fill me-1"></i> Change Password
                    </button>
                    <div class="dropdown-divider"></div>

                    <form action="{{ route('logout') }}" method="POST" >
                        @csrf
                        <button type="submit" class="dropdown-item btn btn-default text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</header>
 {{-- Modal Change Password --}}
 <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="changePasswordLabel">Change Password</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="mb-3">
                    <label for="current_password" class="form-label">Current Password <span class="text-danger fst-italic">*</span></label>
                    <input type="password" class="form-control" name="current_password" id="current_password" placeholder="Enter current password">
                  </div>
                  <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <label for="new_password" class="form-label">
                            New Password <span class="text-danger fst-italic">*</span>
                        </label>
                        <div onclick="showPassword()" style="cursor:pointer;" class="small"> 
                            <i class="bi bi-eye-slash" id="icon-password"></i> <span id="text-icon-password">Show password</span> 
                        </div>
                    </div>
                    <input type="password" class="form-control" name="new_password" placeholder="Enter new password" id="new_password">
                  </div>
                  <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirmation Password <span class="text-danger fst-italic">*</span></label>
                    <input type="password" class="form-control" name="confirm_password" placeholder="Enter confirmation password" id="confirm_password">
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-success">
                    <i class="bi bi-shield-lock-fill me-1"></i> Change Password
                </button>
                </div>
              </div>
        </form>
    </div>
  </div>
{{-- END Modal Change Password --}}

@push('scripts')
  <script>
    function showPassword() {
        let icon_eye = document.getElementById("icon-password");
        let current_password = document.getElementById("current_password");
        let new_password = document.getElementById("new_password");
        let confirm_password = document.getElementById("confirm_password");

        if (current_password.type  && new_password.type && confirm_password.type === "password") {
            document.getElementById("icon-password").classList.remove('bi-eye-slash');
            document.getElementById("icon-password").classList.add('bi-eye');
            document.getElementById("text-icon-password").innerHTML = "Hide password"
            // Input Field
            current_password.type = "text";
            new_password.type = "text";
            confirm_password.type = "text";
        } else {
            document.getElementById("icon-password").classList.remove('bi-eye');
            document.getElementById("icon-password").classList.add('bi-eye-slash');
            document.getElementById("text-icon-password").innerHTML = "Show password"
            // Input Field
            current_password.type = "password";
            new_password.type = "password";
            confirm_password.type = "password";
        }
    }
  </script>
@endpush
