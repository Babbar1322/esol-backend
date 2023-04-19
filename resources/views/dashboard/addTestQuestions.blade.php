@extends('layouts.dashboard')
@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <ol class="breadcrumb fs-sm mb-1">
                <li class="breadcrumb-item"><a>Test</a></li>
                <li class="breadcrumb-item"><a>Add New Test</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add New Questions</li>
            </ol>
            <h4 class="main-title mb-0">Add Questions To {{ $data->test_name }}</h4>
        </div>
    </div>

    <div id="alert-box"></div>

    @if (count($data->test_groups) == 0)
        <div class="card card-one mt-3 shadow">
            <div class="card-body py-3 text-center">
                <img src="https://cdn-icons-png.flaticon.com/512/1380/1380641.png
                " draggable="false"
                    style="max-width: 15%">
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
                    <input type="text" name="question_number" class="form-control" id="question_number"
                        placeholder="Question Number">
                </div>
                <div class="mb-3">
                    <label for="question" class="form-label">Question</label>
                    <input type="text" name="question" class="form-control" id="question" placeholder="Question">
                </div>
                <div class="mb-3">
                    <label for="questionType" class="form-label">Question Type</label>
                    <select name="question_type" onchange="" class="form-select" id="questionType">
                        <option value="">Choose Question Type</option>
                        <option value="input">Input</option>
                        <option value="multi_choice">Mutli Choice</option>
                        <option value="single_choice">Single Choice</option>
                    </select>
                </div>
                <div class="mt-2" id="newinput">
                </div>
                <div id="answer">
                    <div class="mb-3" id="answerElement">
                        <label for="answer" class="form-label">Answer</label>
                        <input type="text" name="answers[]" class="form-control" id="answer"
                            placeholder="Enter Answer">
                    </div>
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
            let question_type = $('#questionType').val();

            let inputs = $('[name="question_hint[]"]');
            let questionHint = inputs.map((index, elem) => {
                return $(elem).val();
            }).get();

            let answerInputs = $('[name="answers[]"]');
            let answer = answerInputs.map(function() {
                return this.value;
            }).get();

            let color = 'success';
            let message = "Question Added Successfully";

            // Submitting Data using axios library - https://axios-http.com/docs/intro
            axios.post("{{ url('api/add-test-questions') }}", {
                question,
                question_number,
                question_type,
                questionHint,
                answer,
                groupId,
                test_id: '{{ $data->id }}'
            }).then(res => {
                // Showing Success Message at The Top of Form
                let alert =
                    `<div class="alert alert-${color} alert-dismissible fade show" role="alert">${message}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`
                $('#alert-box').append(alert);

                // Clearing The Inputs
                $('#group_id').val("");
                $('#question_number').val("");
                $('#question').val("");
                $('#questionType').val("");
                $('[name="answers[]"]').val("");
                $('[name="question_hint[]"]').val("");
                $('.newInputs').remove();
                $('#newinput').empty();
                $('#addAnswer').remove();
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
            // When Question Type Changes It will remove Inputs that are created Dynamically
            $('#questionType').change(function(e) {
                $('.newInputs').remove();
                if (e.target.value === 'input') {
                    $('#newinput').empty();
                } else {
                    $('#newinput').append(
                        `<div class="mb-3"><label for="questionHint" class="form-label">Question Hints</label><input type="text" class="form-control" name="question_hint[]" id="questionHint" placeholder="Enter Question Hint"></div><button class="btn btn-success" id="addBtn">Add More Hints</button>`
                    );
                }
                if (e.target.value === 'multi_choice') {
                    $('#answer').append(
                        `<button class="btn btn-success" id="addAnswer">Add More Answers</button>`)
                } else {
                    $('#addAnswer').remove();
                }
            });
            $('#newinput').on('click', '#addBtn', function() {
                let newInput =
                    `<div class="row align-items-center mb-3 newInputs"><div class="col-11"><input type="text" class="form-control" name="question_hint[]" id="questionHint" placeholder="Enter Question Hint"></div><div class="col-1"><button class="btn btn-danger rounded-pill remove-btn"><i class="ri-delete-bin-6-line"></i></button></div></div>`;
                $(newInput).hide().insertBefore(this).slideDown(200);
            });

            $('#answer').on('click', '#addAnswer', function() {
                let newInput =
                    `<div class="row align-items-center mb-3 newInputs"><div class="col-11"><input type="text" class="form-control" name="answers[]" id="answers" placeholder="Enter Answer"></div><div class="col-1"><button class="btn btn-danger rounded-pill remove-btn"><i class="ri-delete-bin-6-line"></i></button></div></div>`
                $(newInput).hide().insertBefore(this).slideDown(200)
            })
            // This is Delete Button
            $('#newinput').on('click', '.remove-btn', function() {
                $(this).parents('.row').slideUp(200, function() {
                    $(this).remove();
                });
            });
            $('#answer').on('click', '.remove-btn', function() {
                $(this).parents('.row').slideUp(200, function() {
                    $(this).remove();
                });
            });
        })
    </script>
@endsection
