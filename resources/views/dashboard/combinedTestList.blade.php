@extends('layouts.dashboard')
@section('content')
    <div class="modal fade" id="confirmation" tabindex="-1" aria-labelledby="confirmationModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    Are You Sure?<br /><b>You Want to Delete This Test?</b>
                </div>
                <div class="modal-footer py-1">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="#" id="deleteBtn" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <ol class="breadcrumb fs-sm mb-1">
                <li class="breadcrumb-item"><a>Test</a></li>
                <li class="breadcrumb-item active" aria-current="page">Combined Test List</li>
            </ol>
            <h4 class="main-title mb-0">List of All Combined Tests</h4>
        </div>
        <div>
            <a href="{{route('admin.add-new-test')}}" class="btn btn-primary rounded-pill shadow px-4">Add New Test</a>
            <a href="{{route('admin.combine-tests')}}" class="btn btn-success rounded-pill shadow px-4 ms-3">Combine Tests</a>
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
                    <th scope="col">Reading Test</th>
                    <th scope="col">Listening Test</th>
                    <th scope="col">Writing Test</th>
                    <th scope="col">Combined On</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                @if(count($data) > 0)
                    @foreach ($data as $test)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $test->name }}</td>
                            <td style="text-transform: capitalize;">{{ $test->test_type }}</td>
                            <td>{{ count($test->test_groups) }}</td>
                            <td>{{ $test->total_questions }}</td>
                            <td>{{ $test->created_at }}</td>
                            <td>
                                @if ($test->status === 0)
                                    <a href="{{ route('publish-test', ['id' => $test->id]) }}"
                                       class="btn btn-primary rounded-pill">Publish</a>
                                @else
                                    <button class="btn btn-secondary rounded-pill">Hide</button>
                                @endif
                                <button type="button" class="btn btn-danger deleteTest rounded-pill" test-id="{{ $test->id }}"
                                        data-bs-toggle="modal" data-bs-target="#confirmation">
                                    <i class="ri-delete-bin-6-fill"></i>
                                </button>
                            </td>
                            {{-- <td><a href="{{route('delete-test', ['id' => $test->id])}}" class="btn btn-danger"><i class="ri-delete-bin-6-fill"></i></a></td> --}}
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="text-center"><h3>No Combined Tests Found</h3></td>
                    </tr>
                    <tr>
                        <td colspan="7" class="text-center"><a href="{{route('admin.add-new-test')}}" class="btn btn-primary px-3 rounded-pill shadow">Combine New Test</a></td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
    <script src="{{ asset('dashboard/lib/jquery/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.deleteTest').click(function() {
                $('#deleteBtn').attr('href', '{{ route('delete-test') }}' + "?id=" + $(this).attr(
                    'test-id'));
            })
        })
    </script>
@endsection
