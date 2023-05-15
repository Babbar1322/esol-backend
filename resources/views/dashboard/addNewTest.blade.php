@extends('layouts.dashboard')
@section('content')
<link rel="stylesheet" href="{{asset('dashboard/css/richtext.min.css')}}">
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <ol class="breadcrumb fs-sm mb-1">
            <li class="breadcrumb-item"><a>Test</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add New Test</li>
        </ol>
        <h4 class="main-title mb-0">Create New Test</h4>
    </div>
</div>

<div class="card card-one mt-3 shadow">
    <div class="card-body p-3">
        @if ($errors->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $errors->first('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <form action="{{ route('add-new-test') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="testName" class="form-label">Test Name</label>
                <input type="text" name="test_name" class="form-control" id="testName" placeholder="Test Name">
            </div>
            <div class="mb-3">
                <label for="testType" class="form-label">Test Type</label>
                <select name="test_type" class="form-select" id="testType">
                    <option value="">Choose Test Type</option>
                    <option value="reading">Reading</option>
                    <option value="writing">Writing</option>
                    <option value="listening">Listening</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="testTime" class="form-label">Test Time (Minutes)</label>
                <input type="text" name="test_time" class="form-control" id="testTime" placeholder="Test Time">
            </div>
            <!-- <hr> -->
            <!-- <div class="row align-items-center"> -->
            <!-- <div class="col-11"> -->
            <!-- <div>
                <label for="groupName" class="form-label">Group Name</label>
                <input type="text" name="group_name[]" class="form-control" id="groupName"
                    placeholder="Enter Group Name">
            </div>
            <div class="mt-2">
                <label for="groupName" class="form-label">Group Content</label>
                <textarea class="form-control editor" name="group_content[]" rows="6" id="groupContent"
                    placeholder="Enter Group Content"></textarea>
            </div> -->
            <!-- </div> -->
            <!-- <div class="col-1">
                            <button class="btn btn-primary rounded-pill add-btn">
                                <i class="ri-add-line"></i>
                            </button>
                        </div> -->
            <!-- </div> -->
            <div class="mt-2" id="newinput"></div>
            <div class="row">
                <!-- <div class="col"><button type="button" class="btn btn-success w-25 mt-3 add-btn">Add Group</button>
                </div> -->
                <div class="col"><button type="submit" class="btn btn-primary w-25 mt-3">Submit</button></div>
            </div>
            <!-- <div class="d-grid">
                        <button type="submit" class="btn btn-primary w-25 mt-3">Add</button>
                    </div> -->
        </form>
    </div><!-- card-body -->
</div><!-- card -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
{{-- <script src="{{asset('dashboard/js/jquery.richtext.min.js')}}"></script> --}}
<script>
    $(document).ready(() => {
            $('#testType').change(function(){
                let testType = $(this).val();
                if(testType === 'listening'){
                    $('#newinput').append(`<div class="mb-3"><label>Choose Audio File (Max Size is 70MB)</label><input type="file" name="test_audio" accept="audio/*" class="form-control"></div>`).hide().slideDown(500);
                } else {
                    $('#newinput').slideUp(500, function(){
                        $(this).empty();
                    });
                }
            });
            // disable button after submit form
            $('form').submit(function(){
                // check if file size is greater than 30MB
                let testType = $('#testType').val();
                if(testType === 'listening'){
                    let fileSize = $('input[name="test_audio"]')[0].files[0].size;
                    if(fileSize > 30000000){
                        alert('File size is greater than 30MB');
                        return false;
                    }
                }
                $('button[type="submit"]').attr('disabled', true);
            });
        });
</script>
@endsection