@extends('layouts.dashboard')
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <ol class="breadcrumb fs-sm mb-1">
            <li class="breadcrumb-item"><a>Test</a></li>
            <li class="breadcrumb-item"><a>Add New Test</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add New Questions</li>
        </ol>
        <h4 class="main-title mb-0">Add Questions To {{$data->test_name}}</h4>
    </div>
</div>

<div id="alert-box"></div>

@if(count($data->test_groups) == 0)
<div class="card card-one mt-3 shadow">
    <div class="card-body">
        <h3 class="card-title">No Groups Found in This Test</h3>
    </div>
</div>
@else
<!-- <form action="{{route('add-new-test')}}" method="POST"> -->
<select name="group_id" id="group_id" class="form-select">
    <option value="">Select Group to Add Question</option>
    @foreach ($data['test_groups'] as $group)
    <option value="{{$group->id}}">{{$group->group_name}}</option>
    @endforeach
</select>
<div class="card card-one mt-3 shadow">
    <div class="card-body p-3">
        <div class="mb-3">
            <label for="question" class="form-label">Question</label>
            <input type="text" name="question" class="form-control" id="question" placeholder="Question">
        </div>
        <div class="mb-3">
            <label for="questionType" class="form-label">Test Name</label>
            <select name="question_type" class="form-select" id="questionType">
                <option value="">Choose Question Type</option>
                <option value="input">Input</option>
                <option value="multi_choice">Mutli Choice</option>
                <option value="single_choice">Single Choice</option>
            </select>
        </div>
        <div class="mt-2" id="newinput">
            <div class="mb-3">
                <label for="questionHint" class="form-label">Question Hints</label>
                <input type="text" class="form-control" name="question_hint[]" id="questionHint" placeholder="Enter Question Hint">
            </div>
            <button class="btn btn-success" id="addBtn">Add More Hints</button>
        </div>
        <div class="mb-3">
            <label for="answer" class="form-label">Answer</label>
            <input type="text" name="answer" class="form-control" id="answer" placeholder="Answer">
        </div>
        <div class="d-grid">
            <button class="btn btn-success w-25 mt-3 add-btn" onclick="submitData()">Add Question</button>
        </div>
    </div>
</div>
<!-- </form> -->
@endif
<script src="{{asset('dashboard/lib/jquery/jquery.min.js')}}"></script>
<script>
    function submitData() {
        let groupId = $('#group_id').val();
        let question = $('#question').val();
        let question_type = $('#questionType').val();
        let inputs = $('[name="question_hint[]"]');
        let questionHint = inputs.map((index, elem) => {
            return $(elem).val();
        }).get();
        let answer = $('#answer').val();
        let color = 'success';
        let message = "Test Added Successfully";
        $.ajax({
            method: 'POST',
            data: {
                question,
                question_type,
                questionHint,
                answer,
                groupId,
                test_id: '{{$data->id}}'
            },
            url: "{{url('api/add-test-questions')}}",
            success: function(data, status) {
                let alert = `<div class="alert alert-${color} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`
                $('#alert-box').append(alert);
                let groupId = $('#group_id').val("");
                let question = $('#question').val("");
                let question_type = $('#questionType').val("");
                let answer = $('#answer').val("");
                let inputs = $('[name="question_hint[]"]').val("");
                $('.newInputs').remove();
                window.scrollTo(0, 0);
            },
            error: function(data, status) {
                color = 'danger';
                message = "Failed to Add Test";
                let alert = `<div class="alert alert-${color} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`
                $('#alert-box').append(alert);
            }
        });
    }
    $(document).ready(() => {
        $('#questionType').change(function(e) {
            $('.newInputs').remove();
        });
        $('#addBtn').click(function() {
            let newInpt = `<div class="row align-items-center mb-3 newInputs">
                            <div class="col-11">
                                <input type="text" class="form-control" name="question_hint[]" id="questionHint" placeholder="Enter Question Hint">
                            </div>
                            <div class="col-1">
                                <button class="btn btn-danger rounded-pill remove-btn">
                                    <i class="ri-delete-bin-6-line"></i>
                                </button>
                            </div>
                        </div>`;
            $(newInpt).insertBefore(this);
        });
        $('#newinput').on('click', '.remove-btn', function() {
            $(this).parents('.row').remove();
        });
    })
</script>
@endsection