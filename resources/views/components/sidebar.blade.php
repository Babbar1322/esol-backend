<div class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-logo">ESOL</a>
    </div><!-- sidebar-header -->
    <div id="sidebarMenu" class="sidebar-body">
        <div class="nav-group show">
            <a href="#" class="nav-label">Dashboard</a>
            <ul class="nav nav-sidebar">
                <li class="nav-item">
                    <a href="{{route('admin')}}" class="nav-link {{ request()->is('admin') ? 'active' : '' }}"><i class="ri-pie-chart-2-line"></i> <span>Dashboard</span></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link has-sub {{ request()->is('admin/all-tests') ? 'active' : request()->is('admin/add-new-test') ? 'active' : request()->is('admin/combine-tests') ? 'active' : "" }}"><i class="ri-book-2-line"></i> <span>Test</span></a>
                    <nav class="nav nav-sub">
                        <a href="{{route('admin.all-tests')}}" class="nav-sub-link {{ request()->is('admin/all-tests') ? 'active' : '' }}">All Test</a>
                        <a href="{{route('admin.add-new-test')}}" class="nav-sub-link {{ request()->is('admin/add-new-test') ? 'active' : '' }}">Add New Test</a>
                        <a href="{{route('admin.combine-tests')}}" class="nav-sub-link {{ request()->is('admin/combine-tests') ? 'active' : '' }}">Combine Tests</a>
                    </nav>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link has-sub {{ request()->is('admin/all-students') ? 'active' : request()->is('admin/add-new-student') ? 'active' : '' }}"><i class="ri-user-4-line"></i> <span>Students</span></a>
                    <nav class="nav nav-sub">
                        <a href="{{route('admin.all-students')}}" class="nav-sub-link {{ request()->is('admin/all-students') ? 'active' : '' }}">All Students</a>
                        <a href="{{route('admin.add-new-student')}}" class="nav-sub-link {{ request()->is('admin/add-new-student') ? 'active' : '' }}">Add New Student</a>
                    </nav>
                </li>
            </ul>
        </div>
    </div>
</div>
