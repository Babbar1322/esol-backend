<?php

namespace App\Http\Controllers;

use App\Models\CombineTest;
use App\Models\DragAndDrop;
use App\Models\ImageQuestion;
use App\Models\Media;
use App\Models\SubmittedTest;
use App\Models\Test;
use App\Models\TestGroup;
use App\Models\TestQuestion;
use App\Models\UserTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class TestController extends Controller
{
    public function addNewTest(Request $request)
    {
        try {
            // Validate the data that user send
            $request->validate([
                'test_name' => 'required|string',
                'test_type' => 'required|string',
                'test_time' => 'required|integer',
                //                'group_name' => 'required',
                //                'group_content' => 'required',
            ]);

            // dd($request->file('test_audio'));

            if($request->hasFile('test_audio')){
                // dd($request->file('test_audio'));
                $audio = $request->file('test_audio');
                $audio_name = time() . $audio->getClientOriginalName();
                $audio->move(public_path('uploads/audio'), $audio_name);
                $audio_path = 'uploads/audio/' . $audio_name;
                $media = Media::create([
                    'type' => 'audio',
                    'path' => $audio_path,
                ]);
            }

            // Inserting data to tests table
            $test = Test::create([
                "test_name" => $request->test_name,
                "test_type" => $request->test_type,
                "time" => $request->test_time,
                "media_id" => $media->id ?? null,
            ]);

            // Inserting data to test_groups for each group from array
            //            collect($request->group_name)->map(function ($group, $index) use ($test, $request) {
            //                TestGroup::create([
            //                    "test_id" => $test->id,
            //                    "group_name" => $group,
            //                    "group_content" => $request->group_content[$index]
            //                ]);
            //            });
            //            return redirect("admin/add-test-questions/$test->id");
            return redirect("admin/add-test-groups/$test->id");
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors(['error' => $e->errors()[array_keys($e->errors())[0]]]);
        }
    }

    public function addTestGroup(Request $request)
    {
        try {
            // Validate the data that user send
            $request->validate([
                'test_id' => 'required|integer',
                'group_name' => 'required|string',
                // 'group_content' => 'required|string',
            ]);

            // Insterting data to test_groups for each group from array
            //            collect($request->group_name)->map(function ($group, $index) use ($request) {
            //                TestGroup::create([
            //                    "test_id" => $request->test_id,
            //                    "group_name" => $group,
            //                    "group_content" => $request->group_content[$index]
            //                ]);
            //            });
            TestGroup::create([
                "test_id" => $request->test_id,
                "group_name" => $request->group_name,
                "group_content" => $request->group_content
            ]);
            return redirect()->back()->with('message', 'Group Added Successfully');
            //            "admin/add-test-questions/$request->test_id"
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors(['error' => $e->errors()[array_keys($e->errors())[0]]]);
        }
    }

    public function changeTestStatus(Request $request)
    {
        $test = Test::find($request->id);
        if (empty($test)) {
            return redirect()->back()->withErrors(['error' => "Test Doesn't Exist"]);
        }
        $test->update(['status' => $request->status]);
        return redirect()->back()->with('message', 'Test ' . ($request->status == 0 ? 'hidden' : 'published') . ' Successfully');
    }

    public function deleteTest(Request $request)
    {
        $test = Test::find($request->id);
        if (empty($test)) {
            return redirect()->back()->withErrors(['error' => 'Test Doesn\'t Exist']);
        }
        $test->delete();
        return redirect()->back()->with('message', 'Test Deleted Successfully');
    }

    public function addTestQuestions(Request $request)
    {
        try {
            // Checking The Validations for Incoming Data
            $request->validate([
                'test_id' => 'required|integer',
                'groupId' => 'required',
                'question_number' => 'required|integer',
                'question_type' => 'required|string',
                'question' => 'required|string',
                // 'questionHint' => 'required',
                'answer' => 'required'
            ]);

            // Check If Question Number Already Exist
            $checkQuestion = TestQuestion::where('question_number', $request->question_number)->where('test_id', $request->test_id)->first();
            if (!empty($checkQuestion)) {
                // If Question Exist, Return an Error to User
                return response()->json(['error' => 'Question Number Already Exist'], 401);
            }

            // If There's not any errors, Test will be inserted Successfully
           TestQuestion::create([
                "test_id" => $request->test_id,
                "test_group_id" => $request->groupId,
                "question_number" => $request->question_number,
                "question_type" => $request->question_type,
                "question" => $request->question,
                "question_hint" => json_encode($request->questionHint),
                "answer" => $request->question_type === 'multi_choice' ? json_encode($request->answer) : $request->answer[0]
            ]);

            $group = TestGroup::where('id', $request->groupId)->first();
            $group->update(['total_questions' => $group->total_questions + 1]);

            return response()->json("Question Number $request->question_number added successfully", 200);
        } catch (ValidationException $e) {
            if (!empty($e->errors()['groupId'])) {
                return response()->json(['error' => "Select a Group"], 400);
            }
            if (!empty($e->errors()['question_type'])) {
                return response()->json(['error' => "Select a Question Type"], 400);
            }
            return response()->json(['error' => $e->errors()[array_keys($e->errors())[0]]], 400);
        }
    }

    public function addDNDQuestions(Request $request)
    {
        try {
            // Checking The Validations for Incoming Data
            $request->validate([
                'test_id' => 'required|integer',
                'groupId' => 'required',
                'question_number' => 'required|integer',
                'question_type' => 'required|string',
                'question' => 'required|string',
                // 'questionHint' => 'required',
                'answer' => 'required'
            ]);

            // return response()->json('Hellop');

            // Check If Question Number Already Exist
            $checkQuestion = TestQuestion::where('question_number', $request->question_number)->where('test_id', $request->test_id)->first();
            if (!empty($checkQuestion)) {
                // If Question Exist, Return an Error to User
                return response()->json(['error' => 'Question Number Already Exist'], 400);
            }

            // Insert Main Drag and Drop Question
            $dnd = DragAndDrop::create([
                "test_id" => $request->test_id,
                "test_group_id" => $request->groupId,
                "question" => $request->question,
            ]);

            $answers = $request->answer;
            shuffle($answers);

            // Insert TestQuestions with loop
//            Log::info($request->all());
            collect($request->sub_questions)->map(function ($value, $index) use ($request, $dnd, $answers) {
                TestQuestion::create([
                    "test_id" => $request->test_id,
                    "test_group_id" => $request->groupId,
                    "question_number" => $request->question_number + $index,
                    "question_type" => $request->question_type,
                    "question" => $value,
                    "question_hint" => json_encode($answers),
                    "answer" => $request->answer[$index],
                    "q_count" => count($request->sub_questions),
                    "dnd_id" => $dnd->id
                ]);
            });

            $group = TestGroup::where('id', $request->groupId)->first();
            $group->update(['total_questions' => $group->total_questions + count(collect($request->sub_questions))]);

            $q_number = $request->question_number;
            $total_q = $q_number + count($request->sub_questions) - 1;

            return response()->json("Questions from $q_number to $total_q added successfully", 200);
        } catch (ValidationException $e) {
            if (!empty($e->errors()['groupId'])) {
                return response()->json(['error' => "Select a Group"], 400);
            }
            if (!empty($e->errors()['question_type'])) {
                return response()->json(['error' => "Select a Question Type"], 400);
            }
            return response()->json(['error' => $e->errors()[array_keys($e->errors())[0]]], 400);
        }
    }

    public function addImageQuestions(Request $request)
    {
        try {
            // Checking The Validations for Incoming Data
            $request->validate([
                'test_id' => 'required|integer',
                'groupId' => 'required',
                'question_number' => 'required|integer',
                'question' => 'required|string',
            ]);

//            Log::info($request->all());

            // Check If Question Number Already Exist
//            $checkQuestion = TestQuestion::where('question_number', $request->question_number)->where('test_id', $request->test_id)->first();
//            if (!empty($checkQuestion)) {
//                // If Question Exist, Return an Error to User
//                return response()->json(['error' => 'Question Number Already Exist'], 400);
//            }

            if ($request->hasFile('question_image')) {
                $file = $request->file('question_image');
                $name = uniqid() . '_' . $file->getClientOriginalName();
                $file->move(public_path('/images'), $name);
                $question_image = 'images/' . $name;
            }

            $media = Media::create([
                'path' => $question_image,
                'type' => 'image'
            ]);

            foreach (json_decode($request->image_coords) as $key => $coords) {
                $question = TestQuestion::where('test_id', $request->test_id)->where('question_number', $request->question_number + $key)->first();
                $question->update(['question_type' => 'image', 'q_count' => $key === 0 ? count(json_decode($request->image_coords)) : null]);
                ImageQuestion::create([
                    'test_id' => $request->test_id,
                    'media_id' => $media->id,
                    'image_coordinates' => json_encode($coords),
                    'question_id' => $question->id,
                    'question_number' => $question->question_number,
                    'question' => $request->question,
                ]);
            }

            $q_number = $request->question_number;
            $total_q = $q_number + count(json_decode($request->image_coords)) - 1;

            return response()->json("Questions from $q_number to $total_q added successfully", 200);
        } catch (ValidationException $e) {
            if (!empty($e->errors()['groupId'])) {
                return response()->json(['error' => "Select a Group"], 400);
            }
            if (!empty($e->errors()['question_type'])) {
                return response()->json(['error' => "Select a Question Type"], 400);
            }
            return response()->json(['error' => $e->errors()[array_keys($e->errors())[0]]], 400);
        }
    }

    public function combineTests(Request $request)
    {
        $combineTest = new CombineTest;
        $combineTest->create([
            'name' => $request->name,
            'reading_test_id' => $request->reading_test_id,
            'listening_test_id' => $request->listening_test_id,
            'writing_test_id' => $request->writing_test_id,
        ]);
        // update test Is Combined
        $readingTest = Test::where('id', $request->reading_test_id)->first();
        $readingTest->update(['is_combined' => 1]);
        $listeningTest = Test::where('id', $request->listening_test_id)->first();
        $listeningTest->update(['is_combined' => 1]);
        $writingTest = Test::where('id', $request->writing_test_id)->first();
        $writingTest->update(['is_combined' => 1]);
        return redirect()->back()->with('success', 'Test Combined Successfully');
    }

    public function getAllTest(Request $request)
    {
        $data = CombineTest::with('reading_test', 'writing_test', 'listening_test')->get();
//        $data = Test::with('test_groups')->where('status', 1)->get();
//        foreach ($data as $test) {
//            $total_questions = 0;
//            $userTest = UserTest::where('test_id', $test->id)->where('user_id', $request->user_id)->first();
//            $test->is_taken = !empty($userTest);
//            foreach ($test->test_groups as $group) {
//                $group->makeHidden('group_content');
//                $total_questions += $group->total_questions;
//            }
//            $test->total_questions = $total_questions;
//        }
        return response()->json($data, 200);
    }

    public function getCombinedTest(Request $request, $id)
    {
        $data = CombineTest::with('reading_test', 'writing_test', 'listening_test')->where('id', $id)->first();
        $data->reading_test->is_taken = UserTest::where('test_id', $data->reading_test->id)->where('user_id', $request->user_id)->first();
        $data->listening_test->is_taken = UserTest::where('test_id', $data->listening_test->id)->where('user_id', $request->user_id)->first();
        $data->writing_test->is_taken = UserTest::where('test_id', $data->writing_test->id)->where('user_id', $request->user_id)->first();
        $data->reading_test->total_questions = TestQuestion::where('test_id', $data->reading_test->id)->count();
        $data->listening_test->total_questions = TestQuestion::where('test_id', $data->listening_test->id)->count();
        $data->writing_test->total_questions = TestQuestion::where('test_id', $data->writing_test->id)->count();
        return response()->json($data, 200);
    }

    public function takeTest(Request $request)
    {
        // Find Test
        $test = Test::with('test_groups.test_questions')->find($request->test_id);
        // If Test Not Found, Return Error
        if (empty($test)) {
            return response()->json('Test Not Found!', 400);
        }

        // Check If User has already taken Test
        $userTest = UserTest::where('user_id', $request->user_id)->where('test_id', $request->test_id)->first();
        // If User has already taken Test, Return Error
        if (!empty($userTest)) {
            return response()->json('This Test is Already Taken by User!', 403);
        }

        $total_questions = collect($test->test_groups)->map(function ($data) {
            $total_count = 0;
            $total_count += count($data->test_questions);
            return $total_count;
        });

        // Insert Entry Into user_tests Table
        UserTest::create([
            'user_id' => $request->user_id,
            'test_id' => $request->test_id,
            'start_time' => round(microtime(true) * 1000),
            'total_questions' => array_sum(json_decode($total_questions)),
            'total_score' => NULL,
            'status' => 1,
            'submit_time' => NULL,
            'time_taken' => NULL
        ]);
        return response()->json($request->test_id, 200);
    }

    public function getTestDetails(Request $request)
    {
        // Find Test
        $test = Test::with('test_groups.test_questions')->find($request->id);
        if($request->type === 'listening'){
            $test->audio = Media::find($test->media_id);
        }
        // loop through the test groups
        foreach ($test->test_groups as $group) {
            // loop through the test questions
            foreach ($group->test_questions as $question) {
                // check if the question type is drag and drop, if yes then get the answer as hint array
                if ($question->question_type == 'drag_and_drop') {
                    // spread the answer to dragHints array

                    // array_push($dragHints, ...json_decode($question->answer));
                    $question->hints = json_decode($question->answer);
                }
                if($question->question_type == 'image'){
                    $imageQuestion = ImageQuestion::where('question_id', $question->id)->first();
                    $media = Media::where('id',$imageQuestion->media_id)->first();
                    $question->image_coordinates = $imageQuestion->image_coordinates;
                    $question->question = $imageQuestion->question;
                    // $question->question_image = $imageQuestion->media->path;
                    $question->image_url = request()->getSchemeAndHttpHost() . "/esol-new/" . $media->path;
//                    Log::info($question->image_url);
                }
            }
        }
        return response()->json($test, 200);
    }

    // public function getTestDetails(Request $request)
    // {
    //     $test = Test::with('test_groups.test_questions')->find($request->test_id);
    //     // return response()->json($test);
    //     foreach ($test->test_groups as $group) {
    //         $dragHints = [];
    //         foreach ($group->test_questions as $question) {
    //             // if question_type is drag_and_drop combine them into an array
    //             if ($question->question_type == 'drag_and_drop') {
    //                 $dnd = DragAndDrop::find($question->dnd_id);
    //                 $question->question = $dnd->question;
    //                 $question->sub_questions = $dnd->sub_questions;
    //                 array_push($dragHints, json_decode($question->answer));
    //                 // dd($dragHints);
    //                 // $dragHints->push(json_decode($question->answer));
    //                 $question->hint = $dragHints;
    //             }
    //             $question->makeHidden('answer');
    //         }
    //     }
    //     return response()->json($dragHints, 200);
    // }

    public function submitTest(Request $request)
    {
        // Check if user already submitted the test
        $userTest = UserTest::where('user_id', $request->user_id)->where('test_id', $request->test_id)->first();
        if (!empty($userTest->submit_time)) {
            return response()->json('This Test is already Submitted before', 401);
        }

        // log the request
//        Log::info($request->all());

        // Stored the Time when User Submit the Test
        $submit_time = round(microtime(true) * 1000);

        // Instering Data into submitted_tests for each question
        foreach ($request->questionValues as $q_number => $question) {
            // Find Question to match the answer
            $testQuestion = TestQuestion::find($question['question_id']);

            // If Question Type is multi_choice then this will match the answer values from array
            $correct_count = 0;
            if ($question['question_type'] === 'multi_choice') {
                // By Default it will correct
                $is_correct = 1;

                // Convert json to array that retrieved from database
                $answer = json_decode($testQuestion->answer);

                // This value of the answer by user
                $user_input = $question['value'];

                // Filtering The user input to get the key where the corresponding value is true from array
                $filter_answers = array_keys(array_filter($user_input, function ($value) {
                    return $value === true;
                }));

                // Matching the answer with the original answer
                $matchAnswers = array_intersect($answer, $filter_answers);

                // Checking if original answer's length is equal to matched answer values
                if (count($answer) !== count($matchAnswers)) {
                    $is_correct = 0;
                }

                if ($is_correct === 1) {
                    $correct_count++;
                }

                // Inserting Data into Table for question and the result
                SubmittedTest::create([
                    'test_id' => $request->test_id,
                    'user_id' => $request->user_id,
                    'question_id' => $question['question_id'],
                    'question_number' => $q_number,
                    'question_type' => $question['question_type'],
                    'question_value' => json_encode($filter_answers),
                    'is_correct' => $is_correct
                ]);
            } else {
                // If Question Type is not multi_choice then this will match the answer value with original answer
                $is_correct = $testQuestion->answer == $question['value'];
                if ($is_correct) {
                    $correct_count++;
                }
                SubmittedTest::create([
                    'test_id' => $request->test_id,
                    'user_id' => $request->user_id,
                    'question_id' => $question['question_id'],
                    'question_number' => $q_number,
                    'question_type' => $question['question_type'],
                    'question_value' => $question['value'],
                    'is_correct' => $is_correct
                ]);
            }
        }

        // Retrieving user_test to update the values
        $userTest = UserTest::where('user_id', $request->user_id)->where('test_id', $request->test_id)->first();
        $userTest->update([
            'total_score' => $correct_count, 'status' => 2, 'submit_time' => $submit_time, 'time_taken' => $submit_time - $userTest->start_time
        ]);
        return response()->json('success', 200);
    }

    public function submitWritingTest(Request $request)
    {
        // Check if user already submitted the test
        $userTest = UserTest::where('user_id', $request->user_id)->where('test_id', $request->test_id)->first();
        if (!empty($userTest->submit_time)) {
            return response()->json('This Test is already Submitted before', 401);
        }

        // Stored the Time when User Submit the Test
        $submit_time = round(microtime(true) * 1000);

        // Instering Data into submitted_tests for each question
        foreach ($request->questionValues as $q_number => $question) {
            SubmittedTest::create([
                'test_id' => $request->test_id,
                'user_id' => $request->user_id,
                'question_id' => $question['question_id'],
                'question_number' => $q_number,
                'question_type' => 'input',
                'question_value' => $question['value'],
                'is_correct' => 0
            ]);
        }

        // Retrieving user_test to update the values
        $userTest = UserTest::where('user_id', $request->user_id)->where('test_id', $request->test_id)->first();
        $userTest->update([
            'total_score' => 0, 'status' => 0, 'submit_time' => $submit_time, 'time_taken' => $submit_time - $userTest->start_time
        ]);
        return response()->json('success', 200);
    }

    public function validateWritingTest(Request $request)
    {
        $submittedTest = SubmittedTest::where('id', $request->id)->first();
        $submittedTest->update([
            'is_correct' => 1,
            'is_checked' => 1,
        ]);
        // check if all questions are checked
        $allChecked = SubmittedTest::where('test_id', $submittedTest->test_id)->where('user_id', $submittedTest->user_id)->where('is_checked', 0)->count();
        $totalScore = SubmittedTest::where('test_id', $submittedTest->test_id)->where('user_id', $submittedTest->user_id)->where('is_correct', 1)->count();
        if ($allChecked === 0) {
            $userTest = UserTest::where('test_id', $submittedTest->test_id)->where('user_id', $submittedTest->user_id)->first();
            $userTest->update([
                'status' => 2,
                'total_score' => $totalScore,
            ]);
        }
        return response()->json('success', 200);
    }
    public function invalidateWritingTest(Request $request)
    {
        $submittedTest = SubmittedTest::where('id', $request->id)->first();
        $submittedTest->update([
            'is_correct' => 0,
            'is_checked' => 1,
        ]);
        $allChecked = SubmittedTest::where('test_id', $submittedTest->test_id)->where('user_id', $submittedTest->user_id)->where('is_checked', 0)->count();
        $totalScore = SubmittedTest::where('test_id', $submittedTest->test_id)->where('user_id', $submittedTest->user_id)->where('is_correct', 1)->count();
        if ($allChecked === 0) {
            $userTest = UserTest::where('test_id', $submittedTest->test_id)->where('user_id', $submittedTest->user_id)->first();
            $userTest->update([
                'status' => 2,
                'total_score' => $totalScore
            ]);
        }
        return response()->json('success', 200);
    }

    public function reviewTest(Request $request)
    {
        $test = UserTest::where('test_id', $request->test_id)->where('user_id', $request->user_id)->first();
        Log::info($request->user_id);
        if ($test->submit_time == null) {
            return response()->json('Test not Submitted by user', 418);
        }
//        $test = UserTest::where('test_id', $request->test_id)->where('user_id', $request->user_id)->get();
//        $test = SubmittedTest::join('user_tests', 'user_tests.test_id', 'submitted_tests.test_id')
//            ->where('submitted_tests.test_id', $request->test_id)
//            ->where('submitted_tests.user_id', $request->user_id)
//            ->get();
//        $test = UserTest::join(DB::raw('submitted_tests AS st'), 'user_tests.test_id', '=', 'st.test_id')
//            ->where('user_tests.test_id', $request->test_id)
//            ->where('user_tests.user_id', $request->user_id)
//            ->select('user_tests.*', 'st.*')
//            ->get();

//        $submitted_test = SubmittedTest::join('user_tests',function($join){
//            $join->on('user_tests.test_id','=','submitted_tests.test_id')
//                ->where('user_tests.user_id','=','submitted_tests.user_id');
//        })->where('user_tests.test_id', $request->test_id)
//            ->where('user_tests.user_id', $request->user_id)
//            ->get();
        $test = DB::select("SELECT * FROM `submitted_tests` INNER JOIN user_tests on user_tests.user_id = submitted_tests.user_id AND user_tests.test_id = submitted_tests.test_id WHERE user_tests.user_id = $request->user_id AND user_tests.test_id = $request->test_id;");

            // Log::info(json_encode($submitted_test));

        // $test = Test::join('submitted_tests', 'submitted_tests.test_id', 'tests.id')->join('user_tests', 'user_tests.test_id', 'tests.id')->join('')->first();
        return response()->json(compact('test'), 200);
        // $test = Test::with('test_groups.test_questions')->find($request->id);
        // return response()->json($test, 200);
    }
}
