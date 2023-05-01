<div class="header-main px-3 px-lg-4">
    <a id="menuSidebar" class="menu-link me-3 me-lg-4"><i class="ri-menu-2-fill"></i></a>

    <div class="dropdown dropdown-skin ms-auto">
        <a class="dropdown-link" data-bs-toggle="dropdown" data-bs-auto-close="outside"><i class="ri-settings-3-line"></i></a>
        <div class="dropdown-menu dropdown-menu-end shadow mt-10-f">
            <label>Skin Mode</label>
            <nav id="skinMode" class="nav nav-skin">
                <a href="#" class="nav-link active">Light</a>
                <a href="#" class="nav-link">Dark</a>
            </nav>
            <!-- <hr>
            <label>Sidebar Skin</label>
            <nav id="sidebarSkin" class="nav nav-skin">
                <a href="#" class="nav-link active">Default</a>
                <a href="#" class="nav-link">Prime</a>
                <a href="#" class="nav-link">Dark</a>
            </nav> -->
        </div><!-- dropdown-menu -->
    </div><!-- dropdown -->

    <div class="dropdown dropdown-profile ms-3 ms-xl-4">
        <a href="#" class="dropdown-link" data-bs-toggle="dropdown" data-bs-auto-close="outside">
            <div class="avatar online"><img src="https://images.unsplash.com/photo-1565464027194-7957a2295fb7?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=100&ixid=MnwxfDB8MXxyYW5kb218MHx8bWFufHx8fHx8MTY4MjE0NzUzNQ&ixlib=rb-4.0.3&q=80&utm_campaign=api-credit&utm_medium=referral&utm_source=unsplash_source&w=100" alt=""></div>
        </a>
        <div class="dropdown-menu dropdown-menu-end mt-10-f">
            <div class="dropdown-menu-body text-center">
                <div class="avatar avatar-xl online mb-3 mx-auto"><img src="https://images.unsplash.com/photo-1565464027194-7957a2295fb7?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=100&ixid=MnwxfDB8MXxyYW5kb218MHx8bWFufHx8fHx8MTY4MjE0NzUzNQ&ixlib=rb-4.0.3&q=80&utm_campaign=api-credit&utm_medium=referral&utm_source=unsplash_source&w=100" alt=""></div>
                <h5 class="mb-1 text-dark fw-semibold">{{Auth::user()->name}}</h5>
                <p class="fs-sm text-secondary">{{Auth::user()->email}}</p>

{{--                <nav class="nav">--}}
{{--                    <a href="#"><i class="ri-edit-2-line"></i> Edit Profile</a>--}}
{{--                    <a href="#"><i class="ri-profile-line"></i> View Profile</a>--}}
{{--                </nav>--}}
{{--                <hr>--}}
                <nav class="nav">
                    <!-- <a href="#"><i class="ri-question-line"></i> Help Center</a>
                    <a href="#"><i class="ri-lock-line"></i> Privacy Settings</a> -->
                    <a href="#" data-bs-target="#password-modal" data-bs-toggle="modal"><i class="ri-key-2-line"></i> Update Password</a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <i class="ri-logout-box-r-line"></i> {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </nav>
            </div><!-- dropdown-menu-body -->
        </div><!-- dropdown-menu -->
    </div><!-- dropdown -->
</div><!-- header-main -->
<div class="modal fade" id="password-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1>Update Your Password</h1>
            </div>
            <div class="modal-body text-center">
                <form action="{{route('admin.change-password')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <input type="password" class="form-control" name="old_password" placeholder="Old Password">
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" name="new_password" placeholder="New Password">
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password">
                    </div>
                    <input type="submit" class="btn btn-primary" value="Update Password">
                </form>
            </div>
        </div>
    </div>
</div>
