<?php

use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::group(["middleware" => "jwt.auth"], function () {
    Route::get('user', function (Request $request) {
        return $request->user();
    });
    Route::get('get-user-details', [UserController::class, 'getUserDetails']);
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
});
Route::post('login', [UserController::class, 'login']);
Route::post('add-test-questions', [TestController::class, 'addTestQuestions']);
Route::post('add-dnd-questions', [TestController::class, 'addDNDQuestions']);
Route::post('add-image-questions', [TestController::class, 'addImageQuestions']);
