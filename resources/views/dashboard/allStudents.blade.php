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

<div class="modal fade" id="allocateTest">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Allocate Test</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="test" class="form-label">Select Test</label>
                        <select class="form-select" id="test">
                            @if(count($tests) > 0)
                                <option selected disabled>Select Test</option>
                                @foreach($tests as $test)
                                    <option value="{{$test->id}}">{{$test->test_name}}</option>
                                @endforeach
                            @else
                                <option disabled selected>No Tests Found</option>
                            @endif
                        </select>
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary">Allocate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="confirmation" tabindex="-1" aria-labelledby="confirmationModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                Are You Sure?<br /><b>You Want to Delete This Student?</b>
            </div>
            <div class="modal-footer py-1">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="" id="deleteBtn" class="btn btn-danger">Delete</a>
            </div>
        </div>
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
            @if(count($data) > 0)
                @foreach($data as $student)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$student->name}}</td>
                    <td>{{$student->email}}</td>
                    <td>{{$student->phone}}</td>
                    <td>
                        <button class="btn btn-success allocate rounded-pill" data-test-id="{{$student->id}}" data-bs-toggle="modal" data-bs-target="#allocateTest">Allocate Test</button>
                        <button class="btn btn-danger rounded-pill delete-btn" data-user-id="{{$student->id}}" data-bs-toggle="modal" data-bs-target="#confirmation"><i class="ri-delete-bin-6-fill"></i></button>
                        @if($student->is_active == 1)
                            <a href="{{route('change-student-status', ['user_id' => $student->id,'status' => 0])}}" class="btn btn-secondary rounded-pill"><i class="ri-close-circle-line"></i></a>
                        @else
                            <a href="{{route('change-student-status', ['user_id' => $student->id,'status' => 1])}}" class="btn btn-success rounded-pill"><i class="ri-check-line"></i></a>
                        @endif
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center"><h3>No Students Found</h3></td>
                </tr>
                <tr>
                    <td colspan="5" class="text-center"><a href="{{route('admin.add-new-student')}}" class="btn btn-primary rounded-pill px-4">Add New Student</a></td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
<script src="{{asset('dashboard/lib/jquery/jquery.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('.allocate').click(function(){
                var id = $(this).data('test-id');
                $.ajax({
                    url: "",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id
                    },
                    success: function(response){
                        console.log(response);
                    }
                });
            });
            $('.delete-btn').click(function(){
                var id = $(this).data('user-id');
                    $('#deleteBtn').attr('href', "{{route('delete-student')}}" + "?user_id=" + id);
            });
        });
    </script>
@endsection
