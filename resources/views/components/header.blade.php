<div class="header-main px-3 px-lg-4">
    <a id="menuSidebar" class="menu-link me-3 me-lg-4"><i class="ri-menu-2-fill"></i></a>

    <div class="form-search me-auto">
        <input type="text" class="form-control" placeholder="Search">
        <i class="ri-search-line"></i>
    </div><!-- form-search -->

    <div class="dropdown dropdown-skin">
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
            <div class="avatar online"><img src="https://source.unsplash.com/100x100/?man" alt=""></div>
        </a>
        <div class="dropdown-menu dropdown-menu-end mt-10-f">
            <div class="dropdown-menu-body">
                <div class="avatar avatar-xl online mb-3"><img src="https://source.unsplash.com/100x100/?man" alt=""></div>
                <h5 class="mb-1 text-dark fw-semibold">{{Auth::user()->name}}</h5>
                <p class="fs-sm text-secondary">Admin</p>

                <nav class="nav">
                    <a href="#"><i class="ri-edit-2-line"></i> Edit Profile</a>
                    <a href="#"><i class="ri-profile-line"></i> View Profile</a>
                </nav>
                <hr>
                <nav class="nav">
                    <!-- <a href="#"><i class="ri-question-line"></i> Help Center</a>
                    <a href="#"><i class="ri-lock-line"></i> Privacy Settings</a> -->
                    <a href="#"><i class="ri-user-settings-line"></i> Account Settings</a>
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