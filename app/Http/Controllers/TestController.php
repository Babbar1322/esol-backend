<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\TestGroup;
use App\Models\TestQuestion;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class TestController extends Controller
{
    public function addNewTest(Request $request)
    {
        try {
            $request->validate([
                'test_name' => 'required|string',
                'test_type' => 'required|string',
                'test_time' => 'required',
                'group_name' => 'required',
                'group_content' => 'required',
            ]);

            $test = Test::create([
                "test_name" => $request->test_name,
                "test_type" => $request->test_type,
                "time" => $request->test_time
            ]);

            collect($request->group_name)->map(function ($group, $index) use ($test, $request) {
                TestGroup::create([
                    "test_id" => $test->id,
                    "group_name" => $group,
                    "group_content" => $request->group_content[$index]
                ]);
            });
            return redirect("admin/add-test-questions/$test->id");
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors(['error' => $e->errors()[array_keys($e->errors())[0]]]);
        }
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
                'answer' => 'required|string'
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
                "answer" => $request->answer
            ]);

            return response()->json('success', 200);
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

    public function getAllTest()
    {
        // if ($request->user()) {
        $data = Test::with('test_groups')->get();
        return response()->json($data, 200);
        // }
    }

    public function getTestDetails(Request $request)
    {
        $test = Test::with('test_groups.test_questions')->find($request->id);
        return response()->json($test, 200);
    }
}
