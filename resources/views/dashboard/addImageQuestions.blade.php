@extends('layouts.dashboard')
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <ol class="breadcrumb fs-sm mb-1">
            <li class="breadcrumb-item"><a>Test</a></li>
            <li class="breadcrumb-item"><a>Add New Test</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add New Image Questions</li>
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
            <input type="number" name="question_number" class="form-control" id="question_number" placeholder="Enter Question Number">
        </div>
        <div class="mb-3">
            <label for="question" class="form-label">Question</label>
            <input name="question" class="form-control" id="question">
        </div>
        <input type="file" name="question_image" id="q-img" accept="image/*" class="form-control">
        <div class="position-relative mt-3" id="img-container">
            <img src="" alt="Choose an Image" ismap id="preview-img" style="width: 500px" draggable="false">
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

    let imageCoords = [];
    function submitData() {
            // Getting The Values of input fields
            let groupId = $('#group_id').val();
            let question_number = $('#question_number').val();
            let question = $('#question').val();

            let color = 'success';
            let message = "Question Added Successfully";
            // append all values to FormData
            let formData = new FormData();
            formData.append('question', question);
            formData.append('question_number', question_number);
            formData.append('groupId', groupId);
            formData.append('test_id', '{{ $data->id }}');
            formData.append('question_image', $('#q-img')[0].files[0]);
            formData.append('image_coords', JSON.stringify(imageCoords));

            // Submitting Data using axios library - https://axios-http.com/docs/intro
            axios.post("{{ url('api/add-image-questions') }}", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(res => {
                // Showing Success Message at The Top of Form
                let alert =
                    `<div class="alert alert-${color} alert-dismissible fade show" role="alert">${res.data}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`
                $('#alert-box').append(alert);

                // Clearing The Inputs
                $('#group_id').val("");
                $('#question_number').val("");
                $('#question').val("");
                $('[name="answers[]"]').val("");
                $('#newinput').empty();
                $('#addAnswer').remove();
            }).catch(err => {
                // Showing Error Message at The Top of Form
                color = 'danger';
                message = err.response.data.error;
                let alert =
                    `<div class="alert alert-${color} alert-dismissible fade show" role="alert">${message}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`
                $('#alert-box').empty().append(alert);
                // $('#alert-box').append(alert);
            }).finally(() => {
                // Scrolling to The Top When server returns response
                window.scrollTo(0, 0);
            });
        }

        // Adding and Removing Input Fields Dynamically
        $(document).ready(function() {
            // Get Image from Input Field and Display it in img tag
            $('#q-img').change(function(e) {
                let file = e.target.files[0];
                let reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function() {
                    $('#preview-img').attr('src', reader.result);
                }
            });
            // Get the coordinates of the image when clicked
            $('img').click(function(e) {
                let x = e.offsetX;
                let y = e.offsetY;
                let length = $('.new-qestions').length;
                imageCoords.push({
                    x: x,
                    y: y
                });
                $('#img-container').append(`<input type="text" name="answers[]" placeholder="${Number($('#question_number').val()) + length}" class="new-qestions" style="position:absolute; top: ${y}px; left: ${x}px">`);
                // alert(`X: ${x} Y: ${y}`);
            });
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
        })
</script>
@endsection
