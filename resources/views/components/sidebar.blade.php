<div class="sidebar">
    <div class="sidebar-header">
        <a href="javascript:void(0);" class="sidebar-logo">ESOL</a>
    </div><!-- sidebar-header -->
    <div id="sidebarMenu" class="sidebar-body">
        <div class="nav-group show">
            <a href="javascript:void(0);" class="nav-label">Dashboard</a>
            <ul class="nav nav-sidebar">
                <li class="nav-item">
                    <a href="{{route('admin')}}" class="nav-link {{ request()->routeIs('admin') ? 'active' : '' }}"><i
                            class="ri-pie-chart-2-line"></i> <span>Dashboard</span></a>
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
                    <a href="{{route('admin.all-tests')}}"
                       class="nav-link {{ request()->routeIs('admin.all-tests') && empty(request()->getQueryString()) ? 'active' : '' }}"><i
                            class="ri-book-2-line"></i> <span>All Tests</span></a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.add-new-test')}}"
                       class="nav-link {{ request()->routeIs('admin.add-new-test') ? 'active' : '' }}"><i
                            class="ri-menu-add-line"></i> <span>Add New Test</span></a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0);"
                       class="nav-link has-sub {{(request('type') === 'reading') ? 'active' : ''}}"><i
                            class="ri-book-read-line"></i> <span>Reading Test</span></a>
                    <nav class="nav nav-sub">
                        <a href="{{route('admin.all-tests', ['type' => 'reading'])}}"
                           class="nav-sub-link {{ request()->routeIs('admin.all-tests') && !request('published') && request('type') === 'reading' ? 'active' : '' }}">All
                            Reading Tests</a>
                        <a href="{{route('admin.all-tests', ['type' => 'reading', 'published' => 'true'])}}"
                           class="nav-sub-link {{ request()->routeIs('admin.all-tests') && request('published') && request('type') === 'reading' ? 'active' : '' }}">Published
                            Reading Tests</a>
                        <a href="{{route('admin.submitted-tests', ['type' => 'reading'])}}"
                           class="nav-sub-link {{ request()->routeIs('admin.submitted-tests', ['type' => 'reading']) && request('type') === 'reading' ? 'active' : '' }}">Student
                            Reading Tests</a>
                    </nav>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0);"
                       class="nav-link has-sub {{(request('type') === 'writing') || request()->routeIs('admin.submitted-writing-tests') ? 'active' : ''}}"><i
                            class="ri-book-open-line"></i> <span>Writing Test
                            @if($pendingWritingTest = \App\Models\UserTest::where('status', 1)->count() > 0)
                                <span class="badge badge-pill bg-warning">{{$pendingWritingTest}}</span>
                            @endif
                        </span></a>
                    <nav class="nav nav-sub">
                        <a href="{{route('admin.all-tests', ['type' => 'writing'])}}"
                           class="nav-sub-link {{request()->routeIs('admin.all-tests') && request('type') === 'writing' && !request('published') ? 'active' : '' }}">All
                            Writing Tests</a>
                        <a href="{{route('admin.all-tests', ['type' => 'writing', 'published' => 'true'])}}"
                           class="nav-sub-link {{request()->routeIs('admin.all-tests') && request('type') === 'writing' && request('published') ? 'active' : '' }}">Published
                            Writing Tests</a>
                        <a href="{{route('admin.submitted-writing-tests')}}"
                           class="nav-sub-link {{request()->routeIs('admin.submitted-writing-tests') && !request('status') ? 'active' : '' }}">Pending
                            Writing Tests</a>
                        <a href="{{route('admin.submitted-writing-tests', ['status' => 1])}}"
                           class="nav-sub-link {{request()->routeIs('admin.submitted-writing-tests') && request('status') ? 'active' : '' }}">Checked
                            Writing Tests</a>
                    </nav>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0);"
                       class="nav-link has-sub {{(request('type') === 'listening') ? 'active' : ''}}"><i
                            class="ri-headphone-line"></i> <span>Listening Test</span></a>
                    <nav class="nav nav-sub">
                        <a href="{{route('admin.all-tests', ['type' => 'listening'])}}"
                           class="nav-sub-link {{request()->routeIs('admin.all-tests') && request('type') === 'listening' && !request('published') ? 'active' : '' }}">All
                            Listening Tests</a>
                        <a href="{{route('admin.all-tests', ['type' => 'listening', 'published' => 'true'])}}"
                           class="nav-sub-link {{request()->routeIs('admin.all-tests') && request('type') === 'listening' && request('published') ? 'active' : '' }}">Published
                            Listening Tests</a>
                        <a href="{{route('admin.submitted-tests', ['type' => 'listening'])}}"
                           class="nav-sub-link {{request()->routeIs('admin.submitted-tests') && request('type') === 'listening' ? 'active' : '' }}">Student
                            Listening Tests</a>
                    </nav>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0);"
                       class="nav-link has-sub {{request()->routeIs('admin.combine-tests') || request()->routeIs('admin.combined-tests') ? 'active' : ''}}"><i
                            class="ri-book-3-line"></i> <span>Combined Tests</span></a>
                    <nav class="nav nav-sub">
                        <a href="{{route('admin.combine-tests')}}"
                           class="nav-sub-link {{request()->routeIs('admin.combine-tests') ? 'active' : ''}}">Combine
                            Tests</a>
                        <a href="{{route('admin.combined-tests')}}"
                           class="nav-sub-link {{request()->routeIs('admin.combined-tests') && !request('status') ? 'active' : ''}}">All
                            Combined Tests</a>
                        <a href="{{route('admin.combined-tests', ['status' => 'published'])}}"
                           class="nav-sub-link {{request()->routeIs('admin.combined-tests') && request('status') === 'published' ? 'active' : ''}}">Published
                            Combined Tests</a>
                        <a href="{{route('admin.combined-tests', ['status' => 'hidden'])}}"
                           class="nav-sub-link {{request()->routeIs('admin.combined-tests') && request('status') === 'hidden' ? 'active' : ''}}">Hidden
                            Combined Tests</a>
                        <a href="{{route('admin.allocated-tests')}}"
                           class="nav-sub-link {{request()->routeIs('admin.allocated-tests')}}">Student Allocated
                            Tests</a>
                    </nav>
                </li>
            </ul>
        </div>
        <div class="nav-group show">
            <a href="javascript:void(0);" class="nav-label">Students</a>
            <ul class="nav nav-sidebar">
                <li class="nav-item">
                    <a href="{{route('admin.all-students')}}"
                       class="nav-link {{request()->routeIs('admin.all-students') && !request('status') ? 'active' : ''}}"><i
                            class="ri-user-line"></i> <span>All Students</span></a>
                    <a href="{{route('admin.add-new-student')}}"
                       class="nav-link {{request()->routeIs('admin.add-new-student') ? 'active' : ''}}"><i
                            class="ri-user-add-line"></i> <span>Add New Students</span></a>
                    <a href="{{route('admin.all-students', ['status' => 'active'])}}"
                       class="nav-link {{request()->routeIs('admin.all-students') && request('status') === 'active' ? 'active' : ''}}"><i
                            class="ri-user-follow-line"></i> <span>Active Students</span></a>
                    <a href="{{route('admin.all-students', ['status' => 'inactive'])}}"
                       class="nav-link {{request()->routeIs('admin.all-students') && request('status') === 'inactive' ? 'active' : ''}}"><i
                            class="ri-user-unfollow-line"></i> <span>Inactive Students</span></a>
                </li>
            </ul>
        </div>
    </div>
</div>
