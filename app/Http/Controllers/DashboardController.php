<?php

namespace App\Http\Controllers;

use App\Models\AllocatedTest;
use App\Models\CombineTest;
use App\Models\SubmittedTest;
use App\Models\Test;
use App\Models\TestGroup;
use App\Models\User;
use App\Models\UserTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::where('is_admin', '!=', 1)->get()->count();
        $active_users = User::where('is_admin', '!=', 1)->where('is_active', 1)->get()->count();
        $inactive_users = User::where('is_admin', '!=', 1)->where('is_active', 0)->get()->count();
        $tests = Test::get()->count();
        $user_tests = UserTest::get()->count();
        $reading_tests = Test::where('test_type', 'reading')->get()->count();
        $listening_tests = Test::where('test_type', 'listening')->get()->count();
        $writing_tests = Test::where('test_type', 'writing')->get()->count();
        $combined_tests = CombineTest::get()->count();
        $allocated_tests = AllocatedTest::get()->count();
        return view('dashboard.index', compact("users", "tests", "user_tests", "reading_tests", "listening_tests", "writing_tests", "active_users", "inactive_users", "combined_tests", "allocated_tests"));
    }

    public function changePassword(Request $request){
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required'
        ]);
        if($request->old_password == $request->new_password){
            return redirect()->back()->withErrors(['error' => 'Old Password and New Password Cannot be Same']);
        }
        if($request->new_password != $request->confirm_password){
            return redirect()->back()->withErrors(['error' => 'New Password and Confirm Password do not Match']);
        }
        $user = User::find($request->user()->id);
        if($user){
            if(Hash::check($request->old_password, $user->password)){
                $user->password = Hash::make($request->new_password);
                $user->show_pass = $request->new_password;
                $user->save();
                return redirect()->back()->with('message', 'Password Changed Successfully');
            } else {
                return redirect()->back()->withErrors(['error' => 'Old Password is Incorrect']);
            }
        } else {
            return redirect()->back()->withErrors(['error' => 'User Not Found']);
        }
    }

    public function allTests(Request $request)
    {
        $data = Test::with('test_groups')->when($request->type, function($d) use ($request) {
            $d->where('test_type', $request->type);
        })->when($request->published, function($d){
            $d->where('status', 1);
        })->orderBy('id')->get();
        foreach ($data as $test) {
            $total_questions = 0;
            foreach ($test->test_groups as $group) {
                $group->makeHidden('group_content');
                $total_questions += $group->total_questions;
            }
            $test->total_questions = $total_questions;
        }
        return view('dashboard.allTests', compact("data"));
    }

    public function addNewTest()
    {
        return view('dashboard.addNewTest');
    }

    public function addTestGroups($id)
    {
        $data = TestGroup::where('test_id', $id)->get();
        return view('dashboard.addTestGroups', compact("id", "data"));
    }

    public function addTestQuestions($id)
    {
        $data = Test::with('test_groups')->find($id);
        return view('dashboard.addTestQuestions', compact("data"));
    }

    public function addDNDQuestions($id)
    {
        $data = Test::with('test_groups')->find($id);
        return view('dashboard.addDNDQuestions', compact('data'));
    }

    public function addImageQuestions($id)
    {
        $data = Test::with('test_groups')->find($id);
        return view('dashboard.addImageQuestions', compact('data'));
    }

    public function combineTests()
    {
        $readingTest = Test::where('test_type', 'reading')->where('is_combined', '!=', 1)->get();
        $listeningTest = Test::where('test_type', 'listening')->where('is_combined', '!=', 1)->get();
        $writingTest = Test::where('test_type', 'writing')->where('is_combined', '!=', 1)->get();
        return view('dashboard.combineTest', compact('readingTest', 'listeningTest', 'writingTest'));
    }

    public function combinedTests(Request $request)
    {
        $data = CombineTest::with('reading_test', 'listening_test', 'writing_test')->when($request->status, function($d) use ($request) {
            if($request->status == 'published') {
                $d->where('status', 1);
            } else {
                $d->where('status', 0);
            }
        })->get();
        return view('dashboard.combinedTestList', compact('data'));
    }

    public function submittedWritingTests(Request $request)
    {
        $data = UserTest::join('tests', 'tests.id', 'user_tests.test_id')->join('users', 'users.id', 'user_tests.user_id')->where('tests.test_type', 'writing')->where('user_tests.status', $request->status || 0)->get();
//        echo "<pre>";
//        print_r($data);
         return view('dashboard.submittedWritingTests', compact('data'));
    }

    public function reviewWritingTest(Request $request, $id)
    {
        // dd($id);
        $user_test = UserTest::where('test_id',$id)->where('user_id', $request->user_id)->first();
        $user = User::find($user_test->user_id);
        $test = Test::with('test_groups')->find($user_test->test_id);
        $submitted_test = SubmittedTest::where('test_id', $user_test->test_id)->where('user_id', $user_test->user_id)->get();
        foreach($test->test_groups as $group) {
            foreach ($submitted_test as $submitted) {
                if ($group->id == $submitted->question_number) {
                    $group->submitted_answer = $submitted->question_value;
                    $group->is_checked = $submitted->is_checked;
                    $group->submitted_id = $submitted->id;
                }
            }
        }
        // $data = UserTest::join('tests', 'tests.id', 'user_tests.test_id')->join('users', 'users.id', 'user_tests.user_id')->join('submitted_tests', 'submitted_tests.test_id', 'user_tests.test_id')->where('user_tests.id', $id)->first();
        return view('dashboard.reviewWritingTest', compact('user_test', 'user', 'test'));
    }

    public function submittedTests(Request $request){
        $data = UserTest::join('tests', 'tests.id', 'user_tests.test_id')->join('users', 'users.id', 'user_tests.user_id')->when($request->type, function($d) use ($request){
            $d->where('tests.test_type', $request->type);
        })->where('user_tests.status', $request->status || 0)->get();
        return view('dashboard.submittedTests', compact('data'));
    }

    public function addNewStudent(Request $request)
    {
        return view('dashboard.addNewStudent');
    }

    public function allStudents(Request $request)
    {
        $tests = CombineTest::where('status', 1)->get();
        $data = User::where('is_admin', '!=', 1)->when($request->status, function($d) use($request) {
            if($request->status == 'active') {
                $d->where('is_active', 1);
            } else {
                $d->where('is_active', 0);
            }
            // $d->where('is_active', $request->status);
        })->get();
        return view('dashboard.allStudents', compact("data", "tests"));
    }
}
