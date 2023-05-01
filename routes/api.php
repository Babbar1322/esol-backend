<?php

use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\PersonalAccessToken;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::group(["middleware" => "auth:sanctum"], function () {
Route::get('user', function (Request $request) {
    return $request->user();
})->middleware("auth:sanctum");
Route::post('logout', [UserController::class, 'logout']);

// Routes for Test
Route::get('get-all-test', [TestController::class, 'getAllTest']);
Route::get('get-combined-test/{id}', [TestController::class, 'getCombinedTest']);
Route::get('get-test-details', [TestController::class, 'getTestDetails']);

// Submit Test
Route::post('take-test', [TestController::class, 'takeTest']);
Route::post('submit-test', [TestController::class, 'submitTest']);
Route::post('submit-writing-test', [TestController::class, 'submitWritingTest']);
Route::post('review-test', [TestController::class, 'reviewTest']);
// });
Route::post('login', [UserController::class, 'login']);
Route::post('add-test-questions', [TestController::class, 'addTestQuestions']);
Route::post('add-dnd-questions', [TestController::class, 'addDNDQuestions']);
Route::post('add-image-questions', [TestController::class, 'addImageQuestions']);
Route::get('test', function (Request $req) {
    $token = $req->query('token');
    $find = PersonalAccessToken::findToken($token);

    if (!$find) {
        return response()->json('Not Authorised', 401);
    }

    $user = Auth::onceUsingId(
        PersonalAccessToken::findToken($token)->tokenable()
    );

    if (!$user) {
        return response()->json('Unauthorized', 401);
    }
    return response()->json('success', 200);
});
