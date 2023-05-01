@extends('layouts.dashboard')
@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <ol class="breadcrumb fs-sm mb-1">
                <li class="breadcrumb-item"><a>Test</a></li>
                <li class="breadcrumb-item active" aria-current="page">Submitted Tests</li>
            </ol>
            <h4 class="main-title mb-0">List of All Tests that are Submitted by Students</h4>
        </div>
    </div>

    <div class="card card-one mt-3 shadow">
        <div class="card-body p-3">
            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th scope="col">Sr.</th>
                    <th scope="col">Name</th>
                    <th scope="col">User Name</th>
                    <th scope="col">Submitted On</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                @if($data->count() > 0)
                    @foreach ($data as $test)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $test->test_name }}</td>
                            <td style="text-transform: capitalize;">{{ $test->name }}</td>
                            <td>{{ \Carbon\Carbon::createFromTimestampMs($test->submit_time)->toDateTimeString() }}</td>
                            <td>
                                <a href="{{route('admin.review-writing-test', ['id' => $test->test_id, 'user_id' => $test->user_id])}}"
                                   class="btn btn-primary rounded-pill">Check</a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="text-center">
                            <h3>No Submitted Tests Found</h3>
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
