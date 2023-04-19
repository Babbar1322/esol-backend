@extends('layouts.dashboard')
@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <ol class="breadcrumb fs-sm mb-1">
                <li class="breadcrumb-item"><a>Test</a></li>
                <li class="breadcrumb-item">Add New Test</li>
                <li class="breadcrumb-item active" aria-current="page">Add Test Groups</li>
            </ol>
            <h4 class="main-title mb-0">Add Test Groups</h4>
        </div>
    </div>
    <div class="card card-one mt-3 shadow">
        <div class="card-body p-3">
            @if($data->count() > 0)
                <h5>Already Added Groups</h5>
                <div class="alert alert-outline alert-secondary">
                    <ul class="mb-0">
                        @foreach($data as $group)
                            <li>{{$group->group_name}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if ($errors->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $errors->first('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form action="{{ route('add-test-group') }}" method="POST">
                @csrf
                <div>
                    <label for="groupName" class="form-label">Group Name</label>
                    <input type="text" name="group_name" class="form-control" id="groupName"
                           placeholder="Enter Group Name">
                </div>
                <div class="mt-2">
                    <label for="groupName" class="form-label">Group Content</label>
                    <textarea class="form-control editor" name="group_content" rows="10" id="groupContent"
                              placeholder="Enter Group Content"></textarea>
                </div>
                <input type="hidden" name="test_id" value="{{ $id }}">
                <div class="mt-2" id="newinput"></div>
                <div class="row justify-content-between">
                    <div class="col"><button type="submit" class="btn btn-primary w-25 mt-3">Submit</button></div>
                    <div class="col"><a href="{{route('admin.add-test-questions', ['id' => $id])}}" class="btn btn-success w-25 mt-3 add-btn">Add Questions</a>
                    </div>
                </div>
                <!-- <div class="d-grid">
                            <button type="submit" class="btn btn-primary w-25 mt-3">Add</button>
                        </div> -->
            </form>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <script>
        $(document).ready(function() {
            // configure ckeditor
            CKEDITOR.replace('groupContent', {
                filebrowserUploadUrl: "{{--route('ckeditor.upload', ['_token' => csrf_token() ])--}}",
                filebrowserUploadMethod: 'form'
            });
            // submit ckeditor data with form
            $('form').submit(function() {
                for (instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }
            });
        })
    </script>
@endsection
