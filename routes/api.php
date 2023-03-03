<?php

use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(["middleware" => "auth:sanctum"], function () {
    Route::get('user', function (Request $request) {
        return $request->user();
    });
    Route::post('logout', [UserController::class, 'logout']);

    // Routes for Test
    Route::get('get-all-test', [TestController::class, 'getAllTest']);
    Route::get('get-test-details', [TestController::class, 'getTestDetails']);

    // Submit Test
    Route::post('submit-test', [TestController::class, 'submitTest']);
});
Route::post('login', [UserController::class, 'login']);
Route::post('add-test-questions', [TestController::class, 'addTestQuestions']);
