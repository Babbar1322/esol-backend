<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if ($request->user()->is_admin != 1) {
                $token = $request->user()->createToken('authToken')->plainTextToken;
                return response()->json(['token' => $token, 'user' => $request->user()], 200);
            } else {
                Auth::logout(); // logout if the user is an admin
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            // $token = $request->user()->createToken('authToken')->plainTextToken;
            // return response()->json(['token' => $token, 'user' => $request->user()], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function logout(Request $request)
    {
        // $user = $request->user();
        // $user->tokens()->delete();
        return response()->json('User logged out successfully', 200);
    }

    public function addNewStudent(Request $request)
    {
        $request->validate([
            'student_name' => "required|string",
            'student_email' => "required|string",
            'student_phone' => "required",
            'student_password' => 'required'
        ]);
        if (!$request->student_email || !$request->student_name || !$request->student_phone || !$request->student_password) {
            return redirect()->back()->withErrors(["error" => "All fields are required"]);
        }
        User::create([
            "name" => $request->student_name,
            "email" => $request->student_email,
            "phone" => $request->student_phone,
            "password" => Hash::make($request->student_password),
            "show_pass" => $request->student_password,
        ]);
        return redirect()->back()->with('message', "Student $request->student_name Added Successfully");
    }
}
