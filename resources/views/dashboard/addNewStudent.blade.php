@extends('layouts.dashboard')
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <ol class="breadcrumb fs-sm mb-1">
            <li class="breadcrumb-item"><a>Students</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add New Student</li>
        </ol>
        <h4 class="main-title mb-0">Add New Student</h4>
    </div>
</div>

<div class="card card-one mt-3 shadow">
    <div class="card-body p-3">
        @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{session('message')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if($errors->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $errors->first('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <form action="{{route('add-new-student')}}" method="POST">
            @csrf
            <div>
                <label for="studentName" class="form-label">Student Name</label>
                <input type="text" name="student_name" class="form-control" id="studentName" placeholder="Student Name">
            </div>
            <div class="mt-2">
                <label for="email" class="form-label">Student Email</label>
                <input type="email" name="student_email" class="form-control" id="email" placeholder="Enter Student Email">
            </div>
            <div class="mt-2">
                <label for="studentPhone" class="form-label">Student Phone</label>
                <input type="tel" class="form-control" name="student_phone" id="studentPhone" placeholder="Enter Student Phone"></textarea>
            </div>
            <div class="mt-2">
                <label for="studentPassword" class="form-label">Student Password</label>
                <input type="password" class="form-control" name="student_password" id="studentPassword" placeholder="Enter Student Password"></textarea>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-success w-25 mt-3 add-btn">Add Student</button>
            </div>
        </form>
    </div>
</div>
@endsection