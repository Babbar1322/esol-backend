<div class="sidebar">
    <div class="sidebar-header">
        <a href="javascript:void(0);" class="sidebar-logo">ESOL</a>
    </div><!-- sidebar-header -->
    <div id="sidebarMenu" class="sidebar-body">
        <div class="nav-group show">
            <a href="javascript:void(0);" class="nav-label">Dashboard</a>
            <ul class="nav nav-sidebar">
                <li class="nav-item">
                    <a href="{{route('admin')}}" class="nav-link {{ request()->is('admin') ? 'active' : '' }}"><i class="ri-pie-chart-2-line"></i> <span>Dashboard</span></a>
                </li>
{{--                <li class="nav-item">--}}
{{--                    <a href="javascript:void(0);" class="nav-link has-sub {{ request()->is('admin/all-tests') ? 'active' : request()->is('admin/add-new-test') ? 'active' : request()->is('admin/combine-tests') ? 'active' : "" }}"><i class="ri-book-2-line"></i> <span>Test</span></a>--}}
{{--                    <nav class="nav nav-sub">--}}
{{--                        <a href="{{route('admin.all-tests')}}" class="nav-sub-link {{ request()->is('admin/all-tests') ? 'active' : '' }}">All Test</a>--}}
{{--                        <a href="{{route('admin.add-new-test')}}" class="nav-sub-link {{ request()->is('admin/add-new-test') ? 'active' : '' }}">Add New Test</a>--}}
{{--                        <a href="{{route('admin.combine-tests')}}" class="nav-sub-link {{ request()->is('admin/combine-tests') ? 'active' : '' }}">Combine Tests</a>--}}
{{--                        <a href="{{route('admin.submitted-writing-tests')}}" class="nav-sub-link {{ request()->is('admin/submitted-writing-tests') ? 'active' : '' }}">Submitted Writing Tests</a>--}}
{{--                    </nav>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a href="javascript:void(0);" class="nav-link has-sub {{ request()->is('admin/all-students') ? 'active' : request()->is('admin/add-new-student') ? 'active' : '' }}"><i class="ri-user-4-line"></i> <span>Students</span></a>--}}
{{--                    <nav class="nav nav-sub">--}}
{{--                        <a href="{{route('admin.all-students')}}" class="nav-sub-link {{ request()->is('admin/all-students') ? 'active' : '' }}">All Students</a>--}}
{{--                        <a href="{{route('admin.add-new-student')}}" class="nav-sub-link {{ request()->is('admin/add-new-student') ? 'active' : '' }}">Add New Student</a>--}}
{{--                    </nav>--}}
{{--                </li>--}}
            </ul>
        </div>
        <div class="nav-group show">
            <a href="javascript:void(0);" class="nav-label">Tests</a>
            <ul class="nav nav-sidebar">
                <li class="nav-item">
                    <a href="{{route('admin.all-tests')}}" class="nav-link"><i class="ri-book-2-line"></i> <span>All Tests</span></a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.add-new-test')}}" class="nav-link"><i class="ri-menu-add-line"></i> <span>Add New Test</span></a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0);" class="nav-link has-sub"><i class="ri-book-read-line"></i> <span>Reading Test</span></a>
                    <nav class="nav nav-sub">
                        <a href="{{route('admin.all-tests', ['type' => 'reading'])}}" class="nav-sub-link">All Reading Tests</a>
                        <a href="{{route('admin.all-tests', ['type' => 'reading', 'published' => 'true'])}}" class="nav-sub-link">Published Reading Tests</a>
                        <a href="{{route('admin.submitted-tests', ['type' => 'reading'])}}" class="nav-sub-link">Student Reading Tests</a>
                    </nav>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0);" class="nav-link has-sub"><i class="ri-book-open-line"></i> <span>Writing Test
                            @if($pendingWritingTest = \App\Models\UserTest::where('status', 0)->count() > 0)
                                <span class="badge badge-pill bg-warning">{{$pendingWritingTest}}</span>
                            @endif
                        </span></a>
                    <nav class="nav nav-sub">
                        <a href="{{route('admin.all-tests', ['type' => 'writing'])}}" class="nav-sub-link">All Writing Tests</a>
                        <a href="{{route('admin.all-tests', ['type' => 'writing', 'published' => 'true'])}}" class="nav-sub-link">Published Writing Tests</a>
                        <a href="{{route('admin.submitted-writing-tests')}}" class="nav-sub-link">Student Writing Tests</a>
                        <a href="{{route('admin.submitted-writing-tests', ['status' => 1])}}" class="nav-sub-link">Checked Writing Tests</a>
                    </nav>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0);" class="nav-link has-sub"><i class="ri-headphone-line"></i> <span>Listening Test</span></a>
                    <nav class="nav nav-sub">
                        <a href="{{route('admin.all-tests', ['type' => 'listening'])}}" class="nav-sub-link">All Listening Tests</a>
                        <a href="{{route('admin.all-tests', ['type' => 'listening', 'published' => 'true'])}}" class="nav-sub-link">Published Listening Tests</a>
                        <a href="{{route('admin.submitted-tests', ['type' => 'listening'])}}" class="nav-sub-link">Student Listening Tests</a>
                    </nav>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0);" class="nav-link has-sub"><i class="ri-book-3-line"></i> <span>Combined Tests</span></a>
                    <nav class="nav nav-sub">
                        <a href="{{route('admin.combine-tests')}}" class="nav-sub-link">Combine Tests</a>
                        <a href="{{route('admin.combined-tests')}}" class="nav-sub-link">All Combined Tests</a>
                        <a href="{{route('admin.combined-tests', ['status' => 'published'])}}" class="nav-sub-link">Published Combined Tests</a>
                        <a href="{{route('admin.combined-tests', ['status' => 'hidden'])}}" class="nav-sub-link">Hidden Combined Tests</a>
                        <a href="javascript:void(0);" class="nav-sub-link">Student Allocated Tests</a>
                    </nav>
                </li>
            </ul>
        </div>
        <div class="nav-group show">
            <a href="javascript:void(0);" class="nav-label">Students</a>
            <ul class="nav nav-sidebar">
                <li class="nav-item">
                    <a href="{{route('admin.all-students')}}" class="nav-link"><i class="ri-user-line"></i> <span>All Students</span></a>
                    <a href="{{route('admin.add-new-student')}}" class="nav-link"><i class="ri-user-add-line"></i> <span>Add New Students</span></a>
                    <a href="{{route('admin.all-students', ['status' => 'active'])}}" class="nav-link"><i class="ri-user-follow-line"></i> <span>Active Students</span></a>
                    <a href="{{route('admin.all-students', ['status' => 'inactive'])}}" class="nav-link"><i class="ri-user-unfollow-line"></i> <span>Inactive Students</span></a>
                </li>
            </ul>
        </div>
    </div>
</div>
