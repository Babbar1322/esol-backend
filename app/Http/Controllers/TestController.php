<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\TestGroup;
use App\Models\TestQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function addNewTest(Request $request)
    {
        if (Auth::user()) {
            $test = Test::create([
                "test_name" => $request->test_name,
                "test_type" => $request->test_type
            ]);

            collect($request->group_name)->map(function ($group, $index) use ($test, $request) {
                TestGroup::create([
                    "test_id" => $test->id,
                    "group_name" => $group,
                    "group_content" => $request->group_content[$index]
                ]);
            });
            return redirect("admin/add-test-questions/$test->id");
        }
    }

    public function deleteTest(Request $request)
    {
        Test::find($request->id)->delete();
        return redirect()->back()->with('message', 'Test Deleted');
    }

    public function addTestQuestions(Request $request)
    {
        $instert = TestQuestion::create([
            "test_id" => $request->test_id,
            "group_id" => $request->groupId,
            "question_type" => $request->question_type,
            "question" => $request->question,
            "question_hint" => json_encode($request->questionHint),
            "answer" => $request->answer
        ]);
        if (empty($instert)) {
            return response()->json('Failed', 400);
        }

        return response()->json('success', 200);
    }

    public function getAllTest(Request $request)
    {
        if ($request->user()) {
            $data = Test::with('test_groups')->get();
            return response()->json($data, 200);
        }
    }
}
