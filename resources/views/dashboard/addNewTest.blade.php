@extends('layouts.dashboard')
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <ol class="breadcrumb fs-sm mb-1">
            <li class="breadcrumb-item"><a>Test</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add New Test</li>
        </ol>
        <h4 class="main-title mb-0">Create New Test</h4>
    </div>
    <!-- <nav class="nav nav-icon nav-icon-lg">
        <a href="#" class="nav-link" data-bs-toggle="tooltip" title="Share"><i class="ri-share-line"></i></a>
        <a href="#" class="nav-link" data-bs-toggle="tooltip" title="Print"><i class="ri-printer-line"></i></a>
        <a href="#" class="nav-link" data-bs-toggle="tooltip" title="Report"><i class="ri-bar-chart-2-line"></i></a>
    </nav> -->
</div>

<div class="card card-one mt-3 shadow">
    <div class="card-body p-3">
        <form action="{{route('add-new-test')}}" method="POST">
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
            <hr>
            <!-- <div class="row align-items-center"> -->
            <!-- <div class="col-11"> -->
            <div>
                <label for="groupName" class="form-label">Group Name</label>
                <input type="text" name="group_name[]" class="form-control" id="groupName" placeholder="Enter Group Name">
            </div>
            <div class="mt-2">
                <label for="groupName" class="form-label">Group Content</label>
                <textarea class="form-control" name="group_content[]" rows="6" id="groupContent" placeholder="Enter Group Content"></textarea>
            </div>
            <!-- </div> -->
            <!-- <div class="col-1">
                    <button class="btn btn-primary rounded-pill add-btn">
                        <i class="ri-add-line"></i>
                    </button>
                </div> -->
            <!-- </div> -->
            <div class="mt-2" id="newinput"></div>
            <div class="row">
                <div class="col"><button type="submit" class="btn btn-success w-25 mt-3 add-btn">Add Group</button></div>
                <div class="col"><button type="submit" class="btn btn-primary w-25 mt-3">Submit</button></div>
            </div>
            <!-- <div class="d-grid">
                <button type="submit" class="btn btn-primary w-25 mt-3">Add</button>
            </div> -->
        </form>
    </div><!-- card-body -->
</div><!-- card -->
<script src="{{asset('dashboard/lib/jquery/jquery.min.js')}}"></script>
<script>
    $(document).ready(() => {
        $('.add-btn').click((e) => {
            e.preventDefault();
            let newRowAdd =
                `<hr class="hr">
                <div class="row align-items-center">
                <div class="col-11">
                    <div>
                        <label for="groupName" class="form-label">Group Name</label>
                        <input type="text" name="group_name[]" class="form-control" id="groupName" placeholder="Enter Group Name">
                    </div>
                    <div class="mt-2">
                        <label for="groupName" class="form-label">Group Content</label>
                        <textarea class="form-control" name="group_content[]" rows="6" id="groupContent" placeholder="Enter Group Content"></textarea>
                    </div>
                </div>
                <div class="col-1">
                    <button class="btn btn-danger rounded-pill remove-btn">
                        <i class="ri-delete-bin-6-line"></i>
                    </button>
                </div>
            </div>`;
            $('#newinput').append(newRowAdd);
        });
        $('#newinput').on('click', '.remove-btn', function(e) {
            e.preventDefault();
            // console.log($(this).parents('.row'));
            // $(this).parents('.row').remove();
            // $('.hr').remove();
            $(this).closest('.row').prev('hr').remove();
            $(this).closest('.row').remove();
        })
    })
</script>
@endsection