@extends('layouts.dashboard')
@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <ol class="breadcrumb fs-sm mb-1">
                <li class="breadcrumb-item"><a>Test</a></li>
                <li class="breadcrumb-item active" aria-current="page">Allocated Test List</li>
            </ol>
            <h4 class="main-title mb-0">List of Allocated Tests</h4>
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
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li><strong>{{ $error }}</strong></li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                </div>
            @endif
            {{-- $data --}}
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th scope="col">Sr.</th>
                    <th scope="col">Student Name</th>
                    <th scope="col">Combination Name</th>
                    <th scope="col">Reading Test</th>
                    <th scope="col">Listening Test</th>
                    <th scope="col">Writing Test</th>
                    <th scope="col">Status</th>
                    <th scope="col">Allocated On</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                @if(count($data) > 0)
                    @foreach ($data as $test)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $test->user->name }}</td>
                            <td>{{ $test->test->name }}</td>
                            <td>
                                {{ $test->test->reading_test->test_name }}<br>
                                @if($test->reading_test_status == 0)
                                    <span class="badge bg-success">Pending</span>
                                @elseif($test->reading_test_status == 1)
                                    <span class="badge bg-primary">Taken</span>
                                @elseif($test->reading_test_status == 2)
                                    <span class="badge bg-info">Submitted</span>
                                @elseif($test->reading_test_status == 3)
                                    <span class="badge bg-secondary">Expired</span>
                                @endif
                            </td>
                            <td>
                                {{ $test->test->listening_test->test_name }}<br>
                                @if($test->listening_test_status == 0)
                                    <span class="badge bg-success">Pending</span>
                                @elseif($test->listening_test_status == 1)
                                    <span class="badge bg-primary">Taken</span>
                                @elseif($test->listening_test_status == 2)
                                    <span class="badge bg-info">Submitted</span>
                                @elseif($test->listening_test_status == 3)
                                    <span class="badge bg-secondary">Expired</span>
                                @endif
                            </td>
                            <td>
                                {{ $test->test->writing_test->test_name }}<br>
                                @if($test->writing_test_status == 0)
                                    <span class="badge bg-success">Pending</span>
                                @elseif($test->writing_test_status == 1)
                                    <span class="badge bg-primary">Taken</span>
                                @elseif($test->writing_test_status == 2)
                                    <span class="badge bg-info">Submitted</span>
                                @elseif($test->writing_test_status == 3)
                                    <span class="badge bg-secondary">Expired</span>
                                @endif</td>
                            <td>
                                @if($test->status == 0)
                                    <span class="badge bg-success">Pending</span>
                                @elseif($test->status == 1)
                                    <span class="badge bg-primary">Taken</span>
                                @elseif($test->status == 2)
                                    <span class="badge bg-info">Submitted</span>
                                @elseif($test->status == 3)
                                    <span class="badge bg-secondary">Expired</span>
                                @endif
                            </td>
                            <td>{{ $test->created_at }}</td>
                            <td>
                                <a href="{{ route('reallocate-test', ['id' => $test->id]) }}"
                                   class="btn btn-primary rounded-pill">Reallocate</a>
                                {{--                                <button type="button" class="btn btn-danger deleteTest rounded-pill" test-id="{{ $test->id }}"--}}
                                {{--                                        data-bs-toggle="modal" data-bs-target="#confirmation">--}}
                                {{--                                    <i class="ri-delete-bin-6-fill"></i>--}}
                                {{--                                </button>--}}
                            </td>
                            {{-- <td><a href="{{route('delete-test', ['id' => $test->id])}}" class="btn btn-danger"><i class="ri-delete-bin-6-fill"></i></a></td> --}}
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="9" class="text-center"><h3>No Tests Found</h3></td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
    <script src="{{ asset('dashboard/lib/jquery/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.deleteTest').click(function () {
                $('#deleteBtn').attr('href', '{{ route('delete-combined-test') }}' + "?id=" + $(this).attr(
                    'test-id'));
            })
        })
    </script>
@endsection
