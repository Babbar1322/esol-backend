@extends('layouts.dashboard')
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <ol class="breadcrumb fs-sm mb-1">
            <li class="breadcrumb-item"><a>Students</a></li>
            <li class="breadcrumb-item active" aria-current="page">All Students</li>
        </ol>
        <h4 class="main-title mb-0">List of All Students</h4>
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
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">Sr.</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <!-- <th scope="col">Questions</th> -->
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $student)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$student->name}}</td>
                    <td>{{$student->email}}</td>
                    <td>{{$student->phone}}</td>
                    <!-- <td><a class="btn btn-success">Add Questions</a></td> -->
                    <td><a href="{{route('delete-test', ['id' => $student->id])}}" class="btn btn-danger"><i class="ri-delete-bin-6-fill"></i></a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection