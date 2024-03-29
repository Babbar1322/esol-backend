@extends('layouts.dashboard')
@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <ol class="breadcrumb fs-sm mb-1">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <!-- <li class="breadcrumb-item active" aria-current="page">Website Analytics</li> -->
            </ol>
            <h4 class="main-title mb-0">Welcome to ESOL Dashboard</h4>
        </div>
    </div>

    @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session()->get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
     @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
     @endif

    <div class="fs-2">Tests</div>
    <hr>
    <div class="row g-3 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
        <div class="col">
            <div class="card card-one shadow">
                <div class="card-body">
                    <a href="{{route('admin.all-tests')}}" class="stretched-link"></a>
                    <h3 class="card-value mb-1">{{ $tests }}</h3>
                    <label class="card-title fw-medium text-dark mb-1">Total Tests</label>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card card-one shadow">
                <div class="card-body">
                    <a href="{{route('admin.all-tests', ['type' => 'reading'])}}" class="stretched-link"></a>
                    <h3 class="card-value mb-1">{{ $reading_tests }}</h3>
                    <label class="card-title fw-medium text-dark mb-1">Total Reading Tests</label>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card card-one shadow">
                <div class="card-body">
                    <a href="{{route('admin.all-tests', ['type' => 'listening'])}}" class="stretched-link"></a>
                    <h3 class="card-value mb-1">{{ $listening_tests }}</h3>
                    <label class="card-title fw-medium text-dark mb-1">Total Listening Tests</label>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card card-one shadow">
                <div class="card-body">
                    <a href="{{route('admin.all-tests', ['type' => 'writing_tests'])}}" class="stretched-link"></a>
                    <h3 class="card-value mb-1">{{ $writing_tests }}</h3>
                    <label class="card-title fw-medium text-dark mb-1">Total Writing Tests</label>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card card-one shadow">
                <div class="card-body">
                    <h3 class="card-value mb-1">{{ $user_tests }}</h3>
                    <label class="card-title fw-medium text-dark mb-1">Total Test Taken</label>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card card-one shadow">
                <div class="card-body">
                    <h3 class="card-value mb-1">{{ $combined_tests }}</h3>
                    <label class="card-title fw-medium text-dark mb-1">Combined Tests</label>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card card-one shadow">
                <div class="card-body">
                    <h3 class="card-value mb-1">{{ $allocated_tests }}</h3>
                    <label class="card-title fw-medium text-dark mb-1">Allocated to Students</label>
                </div>
            </div>
        </div>
    </div>

    <div class="fs-2 mt-5">Users</div>
    <hr>
    <div class="row g-3 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
        <div class="col">
            <div class="card card-one shadow">
                <div class="card-body">
                    <a href="{{route('admin.all-students')}}" class="stretched-link"></a>
                    <h3 class="card-value mb-1">{{ $users }}</h3>
                    <label class="card-title fw-medium text-dark mb-1">Students</label>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card card-one shadow">
                <div class="card-body">
                    <a href="{{route('admin.all-students', ['status' => 'active'])}}" class="stretched-link"></a>
                    <h3 class="card-value mb-1">{{ $active_users }}</h3>
                    <label class="card-title fw-medium text-dark mb-1">Active Students</label>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card card-one shadow">
                <div class="card-body">
                    <a href="{{route('admin.all-students', ['status' => 'inactive'])}}" class="stretched-link"></a>
                    <h3 class="card-value mb-1">{{ $inactive_users }}</h3>
                    <label class="card-title fw-medium text-dark mb-1">Inactive Students</label>
                </div>
            </div>
        </div>
    </div>
@endsection
