@extends('layouts.dashboard')
@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <ol class="breadcrumb fs-sm mb-1">
                <li class="breadcrumb-item"><a>Test</a></li>
                <li class="breadcrumb-item active" aria-current="page">Review Test</li>
            </ol>
            <h4 class="main-title mb-0">Review Writing Test</h4>
        </div>
    </div>
    <div class="card card-one mt-3 shadow">
        <div class="card-body p-3">
            <div class="row">
                <div class="col-md-6">
                    <h5>Test Name: {{ $test->test_name }}</h5>
                    <h5>Student Name: {{ $user->name }}</h5>
                    <h5>Submitted
                        On: {{ \Carbon\Carbon::createFromTimestampMs($user_test->submit_time)->toDateTimeString() }}</h5>
                </div>
                <div class="col-md-6">
                    <h5>Groups</h5>
                    <ul>
                        @foreach ($test->test_groups as $group)
                            <li>{{$group->group_name}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <hr>
            <div>
                @foreach ($test->test_groups as $group)
                    <div class="h4 mt-5">{{$group->group_name}}</div>
                    {!! $group->group_content !!}
                    <textarea class="form-control" rows="10" disabled>{{$group->submitted_answer}}</textarea>
                    <input type="number" class="form-control my-3 marks" id="marks{{$group->submitted_id}}"
                           name="marks[]"
                           placeholder="Marks" value="{{$group->submitted_marks}}">
                    <div class="row my-2">
                        <div class="col">
                            <button class="btn btn-success rounded-pill"
                                    {{$group->is_checked ? 'disabled' : null}} onclick="validate({{$group->submitted_id}}); disableButtons(this)">
                                Validate
                            </button>
                        </div>
                        <div class="col">
                            <button class="btn btn-danger rounded-pill"
                                    {{$group->is_checked ? 'disabled' : null}} onclick="invalidate({{$group->submitted_id}}); disableButtons(this)">
                                Invalidate
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script href="{{asset('dashboard/lib/jquery/jquery.min.js')}}"></script>
    <script>
        function disableButtons(button) {
            $(button).closest(".row").find("button").prop("disabled", true);
        }

        function validate(id) {
            const marks = $('#marks' + id).val();
            $.ajax({
                url: "{{route('validate-writing-test')}}",
                type: "POST",
                data: {
                    id: id,
                    marks,
                    _token: "{{csrf_token()}}"
                },
                success: function (data) {
                    console.log(data);
                }
            });
        }

        function invalidate(id) {
            const marks = $('#marks' + id).val();
            // console.log('#marks' + id, marks);
            // return;
            $.ajax({
                url: "{{route('invalidate-writing-test')}}",
                type: "POST",
                data: {
                    id: id,
                    marks,
                    _token: "{{csrf_token()}}"
                },
                success: function (data) {
                    console.log(data);
                }
            });
        }

        // disable button after click
        // $('button').click(function() {
        //     $(this).parents('.row').find('button').attr('disabled', true);
        // });
    </script>
@endsection
