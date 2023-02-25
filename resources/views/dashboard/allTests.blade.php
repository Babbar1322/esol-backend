@extends('layouts.dashboard')
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <ol class="breadcrumb fs-sm mb-1">
            <li class="breadcrumb-item"><a>Test</a></li>
            <li class="breadcrumb-item active" aria-current="page">All Tests</li>
        </ol>
        <h4 class="main-title mb-0">List of All Tests</h4>
    </div>
</div>

<div class="card card-one mt-3 shadow">
    <div class="card-body p-3">
        @if(session()->has('message'))
        <div class="alert-alert-success-alert-dismissible">
            {{session('message')}}
        </div>
        @endif
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Type</th>
                    <th scope="col">Groups</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $test)
                <tr>
                    <td>{{$test->id}}</td>
                    <td>{{$test->test_name}}</td>
                    <td style="text-transform: capitalize;">{{$test->test_type}}</td>
                    <td>{{count($test->test_groups)}}</td>
                    <td><a href="{{route('admin.add-test-questions', ['id' => $test->id])}}" class="btn btn-success">Add Questions</a></td>
                    <td><a href="{{route('delete-test', ['id' => $test->id])}}" class="btn btn-danger"><i class="ri-delete-bin-6-fill"></i></a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script src="{{asset('dashboard/lib/jquery/jquery.min.js')}}"></script>
<script>
</script>
@endsection