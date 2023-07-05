<?php

namespace App\Http\Controllers;

use App\Models\AllocatedTest;
use App\Models\CombineTest;
use App\Models\DragAndDrop;
use App\Models\ImageQuestion;
use App\Models\Media;
use App\Models\SubmittedTest;
use App\Models\Test;
use App\Models\TestGroup;
use App\Models\TestQuestion;
use App\Models\UserTest;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class TestController extends Controller
{
    public function addNewTest(Request $request)
    {
            // Validate the data that user send
            $request->validate([
                'test_name' => 'required|string',
                'test_type' => 'required|string',
                'test_time' => 'required|integer',
            ]);

            if ($request->hasFile('test_audio')) {
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
            return redirect("admin/add-test-groups/$test->id");
    }

    public function addTestGroup(Request $request)
    {
            // Validate the data that user send
            $request->validate([
                'test_id' => 'required|integer',
                'group_name' => 'required|string',
            ]);

            // Insterting data to test_groups for each group from array
            TestGroup::create([
                "test_id" => $request->test_id,
                "group_name" => $request->group_name,
                "group_content" => $request->group_content
            ]);
            return redirect()->back()->with('message', 'Group Added Successfully');
    }

    public function deleteTestGroup($id)
    {
        $testGroup = TestGroup::find($id);
        if(!empty($testGroup))
        {
            $testGroup->delete();
            return redirect()->back()->with('message', "Test Group {$testGroup->group_name} deleted successfully");
        }

        return redirect()->back()->withErrors('errors', "Something went wrong");
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

    public function changeCombinedTestStatus(Request $request)
    {
        $test = CombineTest::find($request->id);
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

    public function deleteCombinedTest(Request $request)
    {
        $test = CombineTest::with('listening_test', 'reading_test', 'writing_test')->find($request->id);
        if (empty($test)) {
            return redirect()->back()->withErrors(['error' => 'Test Doesn\'t Exist']);
        }
        $test->listening_test->update(['is_combined' => 0]);
        $test->reading_test->update(['is_combined' => 0]);
        $test->writing_test->update(['is_combined' => 0]);
        $test->delete();
        return redirect()->back()->with('message', 'Test Deleted Successfully');
    }

    public function addTestQuestions(Request $request)
    {
            // Checking The Validations for Incoming Data
            $request->validate([
                'test_id' => 'required|integer',
                'groupId' => 'required',
                'question_number' => 'required|integer',
                'question_type' => 'required|string',
                'answer' => 'required',
                'marks' => 'required',
            ]);

            // Check If Question Number Already Exist
            $checkQuestion = TestQuestion::where('question_number', $request->question_number)->where('test_id', $request->test_id)->first();
            if (!empty($checkQuestion)) {
                // If Question Exist, Return an Error to User
                return response()->json(['error' => 'Question Number Already Exist'], 401);
            }
            $ques = TestQuestion::where('test_id', $request->test_id)->get();
            for ($i = 0; $i < count($ques); $i++) {
                if ($ques[$i]->question_type == 'multi_question') {
                    for ($j = $ques[$i]->question_number; $j < $ques[$i]->question_number + $ques[$i]->q_count; $j++) {
                        if ($j == $request->question_number) {
                            return response()->json(['error' => 'Question Number Already Exist'], 401);
                        }
                    }
                }
            }

            $answer = null;
            if ($request->question_type === 'multi_choice' || $request->question_type === 'multi_question') {
                $answer = json_encode($request->answer);
            } elseif ($request->question_type === 'input') {
                $answer = json_encode(explode(',', $request->answer[0]));
            } else {
                $answer = $request->answer[0];
            }

            // If There's not any errors, Test will be inserted Successfully
            TestQuestion::create([
                "test_id" => $request->test_id,
                "test_group_id" => $request->groupId,
                "question_number" => $request->question_number,
                "question_type" => $request->question_type,
                "question" => $request->question,
                "question_hint" => count($request->questionHint) > 0 ? json_encode($request->questionHint) : null,
                "answer" => $answer,
                "marks" => $request->marks,
                "q_count" => $request->questionCount,
            ]);

            $group = TestGroup::where('id', $request->groupId)->first();
            $group->update(['total_questions' => $group->total_questions + 1]);

            $total = $request->question_number + $request->questionCount - 1;
            if ($request->question_type === 'multi_question') {
                return response()->json("Question Number $request->question_number to $total added successfully", 200);
            }
            return response()->json("Question Number $request->question_number added successfully", 200);
    }

    public function addDNDQuestions(Request $request)
    {
            // Checking The Validations for Incoming Data
            $request->validate([
                'test_id' => 'required|integer',
                'groupId' => 'required',
                'question_number' => 'required|integer',
                'question_type' => 'required|string',
                'question' => 'required|string',
                // 'questionHint' => 'required',
                'answer' => 'required',
                'marks' => 'required',
            ]);

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
                    "dnd_id" => $dnd->id,
                    "marks" => $request->marks[$index],
                ]);
            });

            $group = TestGroup::where('id', $request->groupId)->first();
            $group->update(['total_questions' => $group->total_questions + count(collect($request->sub_questions))]);

            $q_number = $request->question_number;
            $total_q = $q_number + count($request->sub_questions) - 1;

            return response()->json("Questions from $q_number to $total_q added successfully", 200);
    }

    public function addImageQuestions(Request $request)
    {
            // Checking The Validations for Incoming Data
            $request->validate([
                'test_id' => 'required|integer',
                'groupId' => 'required',
                'question_number' => 'required|integer',
                'question' => 'required|string',
            ]);

            if ($request->hasFile('question_image')) {
                $file = $request->file('question_image');
                $name = uniqid() . '_' . $file->getClientOriginalName();
                $file->move(public_path('/images'), $name);
                $question_image = 'images/' . $name;
            } else {
                return response()->json("Check Image and Try Again", 401);
            }

            $media = Media::create([
                'path' => $question_image,
                'type' => 'image'
            ]);

            if(empty($media)) {
                return response()->json('Something went wrong! Please try again.', 401);
            }

            foreach (json_decode($request->image_coords) as $key => $coords) {
                $question_number = $request->question_number + $key;
                $question = TestQuestion::where('test_id', $request->test_id)->where('question_number', $question_number)->first();
                if(empty($question)) {
                    return response()->json("Question number $question_number doesn't exist");
                }
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
    }

    public function deleteQuestion(Request $request, $id)
    {
        $question = TestQuestion::find($id);

        if(!empty($question)){
        if($question->question_type === 'input' || $question->question_type === 'single_choice' || $question->question_type === 'multi_choice')
        {
            $question->delete();
            return redirect()->back()->with('message', "Question {$question->question_number} delete successfully");
        }

        if($question->question_type === 'multi_question')
        {
            $question->delete();
            $question_last_number = $question->question_number + $question->q_count;
            return redirect()->back()->with('message', "Question {$question->question_number} to {$question_last_number} deleted successfully");
        }

        if($question->question_type === 'image')
        {
            $imageQuestion = ImageQuestion::where('question_id', $question->id)->where('question_number', $question->question_number)->first();
            $media = Media::find($imageQuestion->media_id);
            if(\File::exists(public_path($media->path)))
            {
                \File::delete(public_path($media->path));
            }
            $media->delete();
            for($i = 0; $i < $question->q_count; $i++)
            {
                TestQuestion::where('question_number', $question->question_number + $i)->where('test_group_id', $question->test_group_id)->where('test_id', $question->test_id)->delete();
            }
            $imageQuestion->delete();
            $question_last_number = $question->question_number + $question->q_count;

            return redirect()->back()->with('message', "Question {$question->question_number} to {$question_last_number} deleted successfully");
        }

        if($question->question_type === 'drag_and_drop')
        {
            DragAndDrop::find($question->dnd_id)->delete();
            TestQuestion::where('dnd_id', $question->dnd_id)->delete();
            $question_last_number = $question->question_number + $question->q_count;
            return redirect()->back()->with('message', "Question {$question->question_number} to {$question_last_number} deleted successfully");
        }
        $totalQuestions = TestQuestion::where('test_group_id', $question->test_group_id)->count();
        TestGroup::where('test_group_id', $question->test_group_id)->update(['total_questions' => $totalQuestions]);
    }

        return redirect()->back()->withErrors('error', 'Something went wrong');
    }

    public function combineTests(Request $request)
    {
            $request->validate([
                'name' => 'required|string',
                'reading_test_id' => 'required|integer',
                'listening_test_id' => 'required|integer',
                'writing_test_id' => 'required|integer',
            ]);
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
        if ($request->status === 'pending') {
            $data = AllocatedTest::with('test')->where('user_id', Auth::user()->id)->where('status', 0)->get();
        } else {
            $data = AllocatedTest::with('test')->where('user_id', Auth::user()->id)->where(function ($q) {
                $q->where('status', 1)->orWhere('status', 2);
            })->get();
        }
        return response()->json($data, 200);
    }

    public function getCombinedTest(Request $request, $id)
    {
        $user_id = Auth::user()->id;
        $allocatedTest = AllocatedTest::where('user_id', $user_id)->where('id', $id)->where(function ($q) {
            $q->where('status', '!=', 3)->orWhere('status', '!=', 2);
        })->first();
        if (empty($allocatedTest)) {
            return response()->json('Test Not Found!', 400);
        }

        $data = CombineTest::with('reading_test', 'writing_test', 'listening_test')->where('id', $allocatedTest->combined_test_id)->first();
        if (!empty($data->reading_test)) {
            $data->reading_test->is_taken = UserTest::where('test_id', $data->reading_test->id)->where('user_id', $user_id)->where('status', '!=', 3)->where('allocated_test_id', $allocatedTest->id)->first();
            $data->reading_test->total_questions = TestQuestion::where('test_id', $data->reading_test->id)->count();
        }
        if (!empty($data->listening_test)) {
            $data->listening_test->is_taken = UserTest::where('test_id', $data->listening_test->id)->where('user_id', $user_id)->where('status', '!=', 3)->where('allocated_test_id', $allocatedTest->id)->first();

            $data->listening_test->total_questions = TestQuestion::where('test_id', $data->listening_test->id)->count();
        }
        if (!empty($data->writing_test)) {
            $data->writing_test->is_taken = UserTest::where('test_id', $data->writing_test->id)->where('user_id', $user_id)->where('status', '!=', 3)->where('allocated_test_id', $allocatedTest->id)->first();

            $data->writing_test->total_questions = TestQuestion::where('test_id', $data->writing_test->id)->count();
        }
        return response()->json($data, 200);
    }

    public function previewTest($id)
    {
        // $test = Test::with('test_groups.test_questions')->find($id);
        $test = Test::with(['test_groups.test_questions' => function ($query) {
            $query->orderBy('question_number');
        }])->find($id);
        foreach ($test->test_groups as $group) {
            $imageQuestions = [];
            foreach ($group->test_questions as $question) {
                if ($question->question_type == 'image') {

                    $imageQuestions[] = $question;
                }
            }
            // loop through the test questions
            foreach ($group->test_questions as $question) {
                if ($question->question_type == 'drag_and_drop') {
                    $dragQuestion = DragAndDrop::where('id', $question->dnd_id)->first();
                    $question->drag = $dragQuestion;
                    $question->hints = json_decode($question->answer);
                }
                if ($question->question_type == 'image') {
                    $imageQuestion = ImageQuestion::where('question_id', $question->id)->first();
                    $media = Media::where('id', $imageQuestion->media_id)->first();
                    $question->image_coordinates = json_decode($imageQuestion->image_coordinates);
                    $question->question = $imageQuestion->question;
                    // $question->question_image = $imageQuestion->media->path;
                    $question->image_url = $media->path;
                    $question->imageQuestions = $imageQuestions;
                }
            }
        }
        return view('dashboard.previewTest', compact('test'));
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
        $userTest = UserTest::where('user_id', Auth::user()->id)->where('test_id', $request->test_id)->where('allocated_test_id', $request->allocated_test_id)->where(function ($d) {
            $d->where('status', 2)->orWhere('status', 3);
        })->first();
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
            'allocated_test_id' => $request->allocated_test_id,
            'user_id' => Auth::user()->id,
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
        if ($request->type === 'listening') {
            $test->audio = Media::find($test->media_id);
        }
        foreach ($test->test_groups as $group) {
            $imageQuestions = [];
            // loop through the test questions and add question to an array where question type is image
            foreach ($group->test_questions as $question) {
                if ($question->question_type == 'image') {
                    $imageQuestion = ImageQuestion::where('question_id', $question->id)->first();
                    $media = Media::where('id', $imageQuestion->media_id)->first();
                    $question->image_coordinates = $imageQuestion->image_coordinates;
                    $question->question = $imageQuestion->question;
                    // $question->question_image = $imageQuestion->media->path;
                    $question->image_url = "http://localhost:8000/" . $media->path;

                    $imageQuestions[] = $question;
                }
            }
            // loop through the test questions
            foreach ($group->test_questions as $question) {
                // check if the question type is drag and drop, if yes then get the answer as hint array
                if ($question->question_type == 'drag_and_drop') {
                    $dragQuestion = DragAndDrop::where('id', $question->dnd_id)->first();
                    $question->drag = $dragQuestion;
                    $question->hints = json_decode($question->answer);
                }
                if ($question->question_type == 'image') {
                    $imageQuestion = ImageQuestion::where('question_id', $question->id)->first();
                    $media = Media::where('id', $imageQuestion->media_id)->first();
                    $question->image_coordinates = $imageQuestion->image_coordinates;
                    $question->question = $imageQuestion->question;
                    // $question->question_image = $imageQuestion->media->path;
                    $question->image_url = "https://raazbook.com/esol-new/" . $media->path;
                    $question->imageQuestions = json_encode($imageQuestions);
                }
            }
        }
        return response()->json($test, 200);
    }

    public function submitTest(Request $request)
    {
        // Check if user already submitted the test
        $userTest = UserTest::where('user_id', Auth::user()->id)->where('test_id', $request->test_id)->where('status', '!=', 3)->where('allocated_test_id', $request->allocated_test_id)->first();
        if (!empty($userTest->submit_time)) {
            return response()->json('This Test is already Submitted before', 401);
        }

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
                $answer = json_decode(json_decode($testQuestion->answer));

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
                    'test_id' => $testQuestion->test_id,
                    'user_id' => Auth::user()->id,
                    'question_id' => $question['question_id'],
                    'question_number' => $q_number,
                    'question_type' => $question['question_type'],
                    'question_value' => json_encode($filter_answers),
                    'is_correct' => $is_correct,
                    'allocated_test_id' => $request->allocated_test_id,
                    'marks' => $is_correct === 1 ? $testQuestion->marks : 0,
                ]);
            } else if ($question['question_type'] === 'multi_question') {
                // By Default it will correct
                $is_correct = 1;

                // Convert json to array that retrieved from database
                $answer = json_decode(json_decode($testQuestion->answer));

                // This value of the answer by user
                $user_input = $question['value'];

                // Filtering The user input to get the key where the corresponding value is true from array
                $filter_answers = array_keys(array_filter($user_input, function ($value) {
                    return $value === true;
                }));

                // Matching the answer with the original answer
                $matchAnswers = array_intersect($answer, $filter_answers);

                // Checking if original answer's length is equal to matched answer values
                //                if (count($answer) !== count($matchAnswers)) {
                //                    $is_correct = 0;
                //                }

                if (count($matchAnswers) < 1) {
                    $correct_count++;
                } else {
                    $is_correct = 0;
                }

                // Inserting Data into Table for question and the result
                SubmittedTest::create([
                    'test_id' => $testQuestion->test_id,
                    'user_id' => Auth::user()->id,
                    'question_id' => $question['question_id'],
                    'question_number' => $q_number,
                    'question_type' => $question['question_type'],
                    'question_value' => json_encode($filter_answers),
                    'is_correct' => $is_correct,
                    'allocated_test_id' => $request->allocated_test_id,
                    'marks' => count($matchAnswers),
                ]);
            } else if ($question['question_type'] === 'input') {
                $is_correct = 0;
                foreach (json_decode($testQuestion->answer) as $key => $value) {
                    if ($value === $question['value']) {
                        $is_correct = 1;
                    }
                }
                if ($is_correct === 1) {
                    $correct_count++;
                }
                SubmittedTest::create([
                    'test_id' => $testQuestion->test_id,
                    'user_id' => Auth::user()->id,
                    'question_id' => $question['question_id'],
                    'question_number' => $q_number,
                    'question_type' => $question['question_type'],
                    'question_value' => $question['value'],
                    'is_correct' => $is_correct,
                    'allocated_test_id' => $request->allocated_test_id,
                    'marks' => $is_correct ? $testQuestion->marks : 0,
                ]);
            } else {
                // If Question Type is not multi_choice then this will match the answer value with original answer
                $is_correct = $testQuestion->answer == $question['value'];
                if ($is_correct) {
                    $correct_count++;
                }
                SubmittedTest::create([
                    'test_id' => $testQuestion->test_id,
                    'user_id' => Auth::user()->id,
                    'question_id' => $question['question_id'],
                    'question_number' => $q_number,
                    'question_type' => $question['question_type'],
                    'question_value' => $question['value'],
                    'is_correct' => $is_correct,
                    'allocated_test_id' => $request->allocated_test_id,
                    'marks' => $is_correct ? $testQuestion->marks : 0,
                ]);
            }
        }

        $allocatedTest = AllocatedTest::findOrFail($request->allocated_test_id);
        if ($request->type === 'listening') {
            $allocatedTest->update([
                'listening_test_status' => 1
            ]);
        } else {
            $allocatedTest->update([
                'reading_test_status' => 1
            ]);
        }
        if ($allocatedTest->listening_test_status == 1 && $allocatedTest->reading_test_status == 1 && ($allocatedTest->writing_test_status == 1 || $allocatedTest->writing_test_status == 2)) {
            $allocatedTest->update([
                'status' => 1
            ]);
        }
        $userTest->update([
            'total_score' => $correct_count ?? 0, 'status' => 2, 'submit_time' => $submit_time, 'time_taken' => $submit_time - $userTest->start_time
        ]);
        return response()->json('success', 200);
    }

    public function submitWritingTest(Request $request)
    {
        // Check if user already submitted the test
        $userTest = UserTest::where('user_id', Auth::user()->id)->where('test_id', $request->test_id)->where('status', '!=', 3)->where('allocated_test_id', $request->allocated_test_id)->first();
        if (!empty($userTest->submit_time)) {
            return response()->json('This Test is already Submitted before', 401);
        }

        // Stored the Time when User Submit the Test
        $submit_time = round(microtime(true) * 1000);

        // Instering Data into submitted_tests for each question
        foreach ($request->questionValues as $q_number => $question) {
            SubmittedTest::create([
                'test_id' => $request->test_id,
                'user_id' => Auth::user()->id,
                'question_id' => $question['question_id'],
                'question_number' => $q_number,
                'question_type' => 'input',
                'question_value' => $question['value'],
                'is_correct' => 2,
                'allocated_test_id' => $request->allocated_test_id
            ]);
        }

        // Retrieving user_test to update the values
        // $userTest = UserTest::where('user_id', Auth::user()->id)->where('test_id', $request->test_id)->where('status', '!=', 3)->where('allocated_test_id', $request->allocated_test_id)->first();
        $allocatedTest = AllocatedTest::where('id', $request->allocated_test_id)->first();
        $allocatedTest->update([
            'writing_test_status' => 1
        ]);
        if ($allocatedTest->listening_test_status == 1 && $allocatedTest->reading_test_status == 1 && ($allocatedTest->writing_test_status == 1 || $allocatedTest->writing_test_status == 2)) {
            $allocatedTest->update([
                'status' => 1
            ]);
        }
        $userTest->update([
            'total_score' => 0, 'status' => 1, 'submit_time' => $submit_time, 'time_taken' => $submit_time - $userTest->start_time
        ]);
        return response()->json('success', 200);
    }

    public function validateWritingTest(Request $request)
    {
        $submittedTest = SubmittedTest::where('id', $request->id)->first();
        $submittedTest->update([
            'is_correct' => 1,
            'is_checked' => 1,
            'marks' => $request->marks
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
            'marks' => $request->marks
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
        $user_id = Auth::user()->id;
        $test = UserTest::where('test_id', $request->test_id)->where('user_id', $user_id)->where('status', '!=', 3)->where('allocated_test_id', $request->allocated_test_id)->first();
        if ($test->submit_time == null) {
            return response()->json('Test not Submitted by user', 418);
        }
        $test = DB::select("SELECT * FROM `submitted_tests` INNER JOIN user_tests on user_tests.user_id = submitted_tests.user_id AND user_tests.test_id = submitted_tests.test_id AND user_tests.allocated_test_id = submitted_tests.allocated_test_id WHERE user_tests.user_id = $user_id AND user_tests.test_id = $request->test_id AND submitted_tests.allocated_test_id = $request->allocated_test_id;");
        $imageAnswers = [];
        $isCorrect = [];
        foreach ($test as $question) {
            if ($question->question_type == 'image') {
                $imageAnswers[] = $question->question_value;
                $isCorrect[] = $question->is_correct;
            }
        }

        foreach ($test as $question) {
            if ($question->question_type == 'image') {
                $question->question_value = json_encode($imageAnswers);
                $question->is_correct = json_encode($isCorrect);
            }
        }

        return response()->json(compact('test'), 200);
    }

    public function allocateTest(Request $request)
    {
        $allocatedTest = AllocatedTest::where('combined_test_id', $request->test_id)->where('user_id', $request->user_id)->first();
        if ($allocatedTest) {
            return redirect()->back()->withErrors('Test Already Allocated');
        }
        // $test = CombineTest::find($request->test_id);
        $combinedTest = CombineTest::with('reading_test', 'listening_test', 'writing_test')->where('id', $request->test_id)->first();
        AllocatedTest::create([
            'combined_test_id' => $request->test_id,
            'user_id' => $request->user_id,
            'reading_test_id' => $combinedTest->reading_test->id,
            'listening_test_id' => $combinedTest->listening_test->id,
            'writing_test_id' => $combinedTest->writing_test->id,
        ]);
        return redirect()->back()->with('message', 'Test Allocated Successfully');
    }

    public function reAllocateTest(Request $request)
    {
        $allocatedTest = AllocatedTest::with('test.reading_test', 'test.listening_test', 'test.writing_test')->where('id', $request->id)->first();
        if (empty($allocatedTest)) {
            return redirect()->back()->withErrors('Test Not Found');
        }
        $allocatedTest->update([
            'status' => 2,
            'reading_test_status' => 3,
            'listening_test_status' => 3,
            'writing_test_status' => 3,
        ]);
        $userTest = UserTest::where('allocated_test_id', $allocatedTest->combined_test_id)->where('user_id', $allocatedTest->user_id)->get();
        foreach ($userTest as $test) {
            $test->update([
                'status' => 3
            ]);
        }
        // $test = CombineTest::find($request->test_id);
        AllocatedTest::create([
            'combined_test_id' => $allocatedTest->combined_test_id,
            'user_id' => $allocatedTest->user_id,
            'reading_test_id' => $allocatedTest->test->reading_test->id,
            'listening_test_id' => $allocatedTest->test->listening_test->id,
            'writing_test_id' => $allocatedTest->test->writing_test->id,
        ]);
        return redirect()->back()->with('message', 'Test Re-Allocated Successfully');
    }
}
