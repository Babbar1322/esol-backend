<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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
                return response()->json(['error' => 'You don\'t have permission to access this website.'], 401);
            }
            // $token = $request->user()->createToken('authToken')->plainTextToken;
            // return response()->json(['token' => $token, 'user' => $request->user()], 200);
        }

        return response()->json(['error' => 'Email or Password is Incorrect.'], 401);
    }

    public function logout(Request $request)
    {
        // $user = $request->user();
        // $user->tokens()->delete();
        return response()->json('User logged out successfully', 200);
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

    public function changeStudentStatus(Request $request){
        $user = User::find($request->user_id);
        $user->is_active = $request->status;
        $user->save();
        if($request->status == 1){
            $message = "Student $user->name Activated Successfully";
        } else {
            $message = "Student $user->name Deactivated Successfully";
        }
        return redirect()->back()->with('message', $message);
    }

    public function deleteStudent(Request $request){
        $user = User::find($request->user_id);
        $user->delete();
        return redirect()->back()->with('message', "Student $user->name Deleted Successfully");
    }
}
