<?php

namespace App\Http\Controllers;

use App\Models\Test;
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

    public function addTestQuestions($id)
    {
        $data = Test::with('test_groups')->find($id);
        return view('dashboard.addTestQuestions', compact("data"));
    }

    public function allTests()
    {
        $data = Test::with('test_groups')->orderBy('id')->get();
        return view('dashboard.allTests', compact("data"));
    }
}
