<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\TestGroup;
use App\Models\TestQuestion;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::where('is_admin', '!=', 1)->get()->count();
        $tests = Test::get()->count();
        return view('dashboard.index', compact("users", "tests"));
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

    public function combineTests()
    {
        $readingTest = Test::where('test_type', 'reading')->get();
        $listeningTest = Test::where('test_type', 'listening')->get();
        $writingTest = Test::where('test_type', 'writing')->get();
        return view('dashboard.combineTest', compact('readingTest', 'listeningTest', 'writingTest'));
    }

    public function allTests()
    {
        $data = Test::with('test_groups')->orderBy('id')->get();
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

    public function reviewWritingTest($id)
    {
        $data = TestQuestion::where('test_id', $id)->get();
        return view('dashboard.reviewWritingTest', compact('data'));
    }

    public function addNewStudent(Request $request)
    {
        return view('dashboard.addNewStudent');
    }

    public function allStudents()
    {
        $data = User::where('is_admin', '!=', 1)->get();
        return view('dashboard.allStudents', compact("data"));
    }
}
