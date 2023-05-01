@extends('layouts.dashboard')
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <ol class="breadcrumb fs-sm mb-1">
            <li class="breadcrumb-item"><a>Test</a></li>
            <li class="breadcrumb-item"><a>Add New Test</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add New Drag and Drop Questions</li>
        </ol>
        <h4 class="main-title mb-0">Add Questions To {{ $data->test_name }}</h4>
    </div>
</div>

<div id="alert-box"></div>

@if (count($data->test_groups) == 0)
<div class="card card-one mt-3 shadow">
    <div class="card-body py-3 text-center">
        <img src="https://cdn-icons-png.flaticon.com/512/1380/1380641.png" draggable="false" style="max-width: 15%">
        <h3 class="card-title">No Groups Found in This Test</h3>
    </div>
</div>
@else
<!-- <form action="{{ route('add-new-test') }}" method="POST"> -->
<select name="group_id" id="group_id" class="form-select">
    <option value="">Select Group to Add Question</option>
    @foreach ($data['test_groups'] as $group)
    <option value="{{ $group->id }}">{{ $group->group_name }}</option>
    @endforeach
</select>
<div class="card card-one mt-3 shadow">
    <div class="card-body p-3">
        <div class="mb-3">
            <label for="question_number" class="form-label">Question Number</label>
            <input type="number" name="question_number" class="form-control" id="question_number" placeholder="Question Number">
        </div>
        <div class="mb-3">
            <label for="number_of_questions" class="form-label">How many questions? <span title="This will create a group of questions and bring all the answers together."><i class="ri-question-fill h5"></i></span></label>
            <input type="number" name="number_of_questions" class="form-control" id="number_of_questions" placeholder="Number of Questions">
        </div>
        <div class="mb-3">
            <label for="question" class="form-label">Question</label>
            <input type="text" name="question" class="form-control" id="question" placeholder="Question">
        </div>
        <div class="mt-2" id="newinput">
        </div>
        <div class="d-grid">
            <button class="btn btn-success w-25 mt-3 add-btn" onclick="submitData()">Add Question</button>
        </div>
    </div>
</div>
<!-- </form> -->
@endif
{{-- Importing jQuery and axios Libraries --}}
<script src="{{ asset('dashboard/lib/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('dashboard/js/axios.js') }}"></script>
<script>
    function submitData() {
        // Getting The Values of input fields
        let groupId = $('#group_id').val();
        let question_number = $('#question_number').val();
        let question = $('#question').val();

        let inputs = $('[name="sub_questions[]"]');
        let sub_questions = inputs.map((index, elem) => {
            return $(elem).val();
        }).get();

        let answerInputs = $('[name="answers[]"]');
        let answer = answerInputs.map(function() {
            return this.value;
        }).get();

        let color = 'success';
        let message = "Question Added Successfully";

        // Submitting Data using axios library - https://axios-http.com/docs/intro
        axios.post("{{ url('api/add-dnd-questions') }}", {
            question,
            question_number,
            question_type: 'drag_and_drop',
            sub_questions,
            answer,
            groupId,
            test_id: '{{ $data->id }}'
        }).then(res => {
            // Showing Success Message at The Top of Form
            let alert =
                `<div class="alert alert-${color} alert-dismissible fade show" role="alert">${res.data}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`
            $('#alert-box').append(alert);

            // Clearing The Inputs
            $('#group_id').val("");
            $('#question_number').val("");
            $('#question').val();
            $('[name="sub_questions[]"]').val("");
            $('[name="answers[]"]').val("");
            $('.newInputs').remove();
            $('#newinput').empty();
        }).catch(err => {
            // Showing Error Message at The Top of Form
            color = 'danger';
            message = err.response.data.error;
            let alert =
                `<div class="alert alert-${color} alert-dismissible fade show" role="alert">${message}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`
            $('#alert-box').empty();
            $('#alert-box').append(alert);
        }).finally(() => {
            // Scrolling to The Top When server returns response
            window.scrollTo(0, 0);
        });
    }

    // Adding and Removing Input Fields Dynamically
    $(document).ready(() => {
        // When User Provide Number of Question it will create questions according number
        $('#number_of_questions').focus(function() {
            $('#newinput').empty();
        });
        $('#number_of_questions').blur(function() {
            const value = $(this).val();
            const input = function(number) {
                return (
                    `<div class="mb-3"><div class="row align-items-start"><div class="col-1 pe-0"><span class="bg-secondary px-2 rounded-2 fs-5 text-white">${number}</span></div><div class="col"><div class="mb-1"><label for="question" class="form-label">Question</label><input type="text" name="sub_questions[]" class="form-control" id="question" placeholder="Question"></div><div id="answer"><div class="mb-3" id="answerElement"><label for="answer" class="form-label">Answers <span title="Multiple answers can be seprated by Comma(,)"><i class="ri-question-fill h5"></i></span></label><input type="text" name="answers[]" class="form-control" id="answer" placeholder="Enter Answer"></div></div></div></div></div>`
                )
            }

            let question = $('#question_number').val();
            for (let i = 0; i < value; i++) {
                $('#newinput').append(input(parseInt(i) + parseInt(question)));
            }
        });
    })
</script>
@endsection
