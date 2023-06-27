@extends('layouts.dashboard')
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <ol class="breadcrumb fs-sm mb-1">
            <li class="breadcrumb-item"><a>Test</a></li>
            <li class="breadcrumb-item active" aria-current="page">Preview Test</li>
        </ol>
        <h4 class="main-title mb-0">Preview {{$test->test_name}}</h4>
    </div>
</div>
@if($errors->any())
<div class="alert alert-danger">
    {{$errors->all()}}
</div>
@endif

@if(session()->has('message'))
<div class="alert alert-success">
    {{session('message')}}
</div>
@endif
@foreach ($test->test_groups as $group)
<div class="card card-one mt-3 shadow overflow-hidden">
    <div class="card-body p-0">
        <div class="accordion accordion-flush" id="test-groups-{{$loop->iteration}}">
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading-{{$loop->iteration}}">
                    <button class="accordion-button bg-transparent" type="button" data-bs-toggle="collapse"
                        data-bs-target="#group-{{$loop->iteration}}" aria-expanded="false"
                        aria-controls="group-{{$loop->iteration}}">
                        {{$group->group_name}}
                    </button>
                </h2>
                @if ($test->test_type != 'writing')
                <div id="group-{{$loop->iteration}}" class="accordion-collapse collapse"
                    aria-labelledby="heading-{{$loop->iteration}}" data-bs-parent="#test-groups-{{$loop->iteration}}">
                    <div class="accordion-body">
                        @foreach($group->test_questions as $question)
                        @if($question->question_type == 'multi_choice')
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="form-check mb-2">
                                    <label for="" class="form-label">Question - {{$question->question_number}}</label>
                                    <div class="fs-6 mb-2 text-decoration-underline">{{$question->question}}</div>
                                    @foreach(json_decode($question->question_hint) as $hint)
                                    <div class="mb-1 ms-5">
                                        <input class="form-check-input" type="checkbox" value="{{$hint}}"
                                            id="hint-{{$question->question_number}}-{{$loop->iteration}}">
                                        <label class="form-check-label"
                                            for="hint-{{$question->question_number}}-{{$loop->iteration}}">
                                            {{$hint}}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-1">
                                <a href="{{route('admin.delete-test', ['id' => $question->id])}}" class="btn btn-danger">
                                    <i class="ri-delete-bin-6-line"></i>
                                </a>
                            </div>
                        </div>
                        @endif
                        @if($question->question_type == 'input')
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="" class="form-label">Question - {{$question->question_number}}</label>
                                    <div class="fs-6 mb-2 text-decoration-underline">{{$question->question}}</div>
                                    <p class="border">{{$question->answer}}</p>
                                </div>
                            </div>
                            <div class="col-1">
                                <a href="{{route('admin.delete-test', ['id' => $question->id])}}" class="btn btn-danger">
                                    <i class="ri-delete-bin-6-line"></i>
                                </a>
                            </div>
                        </div>
                        @endif
                        @if($question->question_type == 'single_choice')
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="" class="form-label">Question - {{$question->question_number}}</label>
                                    <div class="fs-6 mb-2 text-decoration-underline">{{$question->question}}</div>
                                    @foreach (json_decode($question->question_hint) as $hint)
                                        <div class="mb-1 ms-5">
                                            <input class="form-check-input" type="radio" name="hint-{{$question->question_number}}" id="hint-{{$question->question_number}}-{{$loop->iteration}}">
                                            <label class="form-check-label" for="hint-{{$question->question_number}}-{{$loop->iteration}}">
                                            {{$hint }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-1">
                                <a href="{{route('admin.delete-test', ['id' => $question->id])}}" class="btn btn-danger">
                                    <i class="ri-delete-bin-6-line"></i>
                                </a>
                            </div>
                        </div>
                        @endif
                        @if($question->question_type == 'multi_question')
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="mb-2">
                                    <label for="" class="form-label">Question - {{$question->question_number}} - {{$question->question_number + $question->q_count}}</label>
                                    <div class="fs-6 mb-2 text-decoration-underline">{{$question->question}}</div>
                                    @foreach(json_decode($question->question_hint) as $hint)
                                    <div class="mb-1 ms-5">
                                        <input class="form-check-input" type="checkbox" value="{{$hint}}"
                                            id="hint-{{$question->question_number}}-{{$loop->iteration}}">
                                        <label class="form-check-label"
                                            for="hint-{{$question->question_number}}-{{$loop->iteration}}">
                                            {{$hint}}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-1">
                                <a href="{{route('admin.delete-test', ['id' => $question->id])}}" class="btn btn-danger">
                                    <i class="ri-delete-bin-6-line"></i>
                                </a>
                            </div>
                        </div>
                        @endif
                        @if($question->question_type == 'drag_and_drop')
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="mb-2">
                                    <label for="" class="form-label">Question - {{$question->question_number}}</label>
                                    <div class="fs-6 mb-2 text-decoration-underline">{{$question->question}}</div>
                                    <div class="mb-1 ms-2">
                                        <div class="border rounded-1 p-2">
                                            <p class="m-0">{{$question->answer}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-1">
                                <a href="{{route('admin.delete-test', ['id' => $question->id])}}" class="btn btn-danger">
                                    <i class="ri-delete-bin-6-line"></i>
                                </a>
                            </div>
                        </div>
                        @endif
                        @if($question->question_type == 'image')
                        <div class="row align-items-center">
                            <div class="col position-relative">
                                @if($question->q_count != null)
                                <label for="" class="form-label">Question - {{$question->question_number}}</label>
                                <div class="fs-6 mb-2 text-decoration-underline">{{$question->question}}</div>
                                <img src="{{asset($question->image_url)}}" alt="" style="width: 500px">
                                @foreach ($question->imageQuestions as $imgQ)
                                <div class="position-absolute bg-white border rounded-1 p-1" style="top: {{$imgQ->image_coordinates->y}}px; left: {{$imgQ->image_coordinates->x}}px">
                                    <p class="m-0">{{implode(json_decode($imgQ->answer))}}</p>
                                </div>
                                @endforeach
                                @endif
                            </div>
                            <div class="col-1">
                                @if($question->q_count != null)
                                <a href="{{route('admin.delete-test', ['id' => $question->id])}}" class="btn btn-danger">
                                    <i class="ri-delete-bin-6-line"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                @else
                <div class="row align-items-center p-3">
                    <div class="col">{!! $group->group_content !!}</div>
                    <div class="col-1">
                        <a href="{{route('admin.delete-test-group', ['id' => $group->id])}}" class="btn btn-danger">
                            <i class="ri-delete-bin-6-line"></i>
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach
<script src="{{ asset('dashboard/lib/jquery/jquery.min.js') }}"></script>
<script>
    let inputChangeStatus = {};

    function changedQuestion(element){
        const inputId = element.id;

        if (!inputChangeStatus[inputId]) {
            $(element).parents('.row').append(`<div class="col-3 col-md-2"><button class="btn btn-success w-100 shadow">Save</button></div>`);
            inputChangeStatus[inputId] = true;
        }
    }
    $(document).ready(function() {

    });
</script>
@endsection
