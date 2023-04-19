@extends('layouts.dashboard')
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <ol class="breadcrumb fs-sm mb-1">
            <li class="breadcrumb-item"><a>Test</a></li>
            <li class="breadcrumb-item"><a>All Tests</a></li>
            <li class="breadcrumb-item active" aria-current="page">Combine Tests</li>
        </ol>
        <h4 class="main-title mb-0">Combine Three Tests Together</h4>
    </div>
</div>
<div class="card card-one mt-3 shadow">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card-body p-3">
        <form action="{{route('combine-tests')}}" method="post">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Combination Name</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Enter Combination Name">
            </div>
            <div class="mb-3">
                <label for="read" class="form-label">Reading Test</label>
                @if(count($readingTest) > 0)
                <select name="reading_test_id" class="form-select" id="read">
                    <option value="" disabled selected>Select a Reading Test</option>
                    @foreach($readingTest as $test)
                        <option value="{{$test->id}}">{{$test->test_name}}</option>
                    @endforeach
{{--                    <option value="0"></option>--}}
                </select>
                @else
                    <h4>No Reading Test Found</h4>
                @endif
            </div>
            <div class="mb-3">
                <label for="listen" class="form-label">Listening Test</label>
                @if(count($listeningTest) > 0)
                <select name="listening_test_id" class="form-select" id="listen">
                    <option value="" disabled selected>Select a Listening Test</option>
                    @foreach($listeningTest as $test)
                        <option value="{{$test->id}}">{{$test->test_name}}</option>
                    @endforeach
{{--                    <option value="0"></option>--}}
                </select>
                @else
                    <h4>No Listening Test Found</h4>
                @endif
            </div>
            <div class="mb-3">
                <label for="write" class="form-label">Writing Test</label>
                @if(count($writingTest) > 0)
                <select name="writing_test_id" class="form-select" id="write">
                    <option value="" disabled selected>Select a Writing Test</option>
                    @foreach($writingTest as $test)
                        <option value="{{$test->id}}">{{$test->test_name}}</option>
                    @endforeach
                </select>
                @else
                    <h4>No Writing Test Found</h4>
                @endif
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary" id="combine">Combine</button>
            </div>
        </form>
    </div>
</div>
@endsection
