<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Log;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Email or Password is Incorrect.'], 401);
            }
            // get user data and pass it with token
            $user = Auth::user();
            return response()->json(compact('token', 'user'), 200);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token.'], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::parseToken());
            return response()->json(['message' => 'Successfully logged out'], 200);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Failed to logout'], 500);
        }
        // return response()->json('User logged out successfully', 200);
    }

    public function addNewStudent(Request $request)
    {
        try {
            $request->validate([
                'student_name' => "required|string",
                'student_email' => "required|string",
                'student_phone' => "required",
                'student_password' => 'required'
            ]);
            $user = User::where('email', $request->student_email)->orWhere('phone', $request->student_phone)->first();
            if ($user) {
                return redirect()->back()->withErrors(["error" => "Student with This Email or Phone Already Exists"]);
            }
            User::create([
                "name" => $request->student_name,
                "email" => $request->student_email,
                "phone" => $request->student_phone,
                "password" => Hash::make($request->student_password),
                "show_pass" => $request->student_password,
            ]);
            return redirect()->back()->with('message', "Student $request->student_name Added Successfully");
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors(["error" => $e->getMessage()]);
        }
    }

    public function changeStudentStatus(Request $request)
    {
        $user = User::find($request->user_id);
        $user->is_active = $request->status;
        $user->save();
        if ($request->status == 1) {
            $message = "Student $user->name Activated Successfully";
        } else {
            $message = "Student $user->name Deactivated Successfully";
        }
        return redirect()->back()->with('message', $message);
    }

    public function deleteStudent(Request $request)
    {
        $user = User::find($request->user_id);
        $user->delete();
        return redirect()->back()->with('message', "Student $user->name Deleted Successfully");
    }

    public function getUserDetails(Request $request)
    {
        return response()->json($request->user(), 200);
    }
}
