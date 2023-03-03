<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(["middleware" => "auth"], function () {
    Route::group(["prefix" => "admin"], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin');
        Route::get('add-new-test', [DashboardController::class, 'addNewTest'])->name('admin.add-new-test');
        Route::get('all-tests', [DashboardController::class, 'allTests'])->name('admin.all-tests');
        Route::get('add-test-questions/{id}', [DashboardController::class, 'addTestQuestions'])->name('admin.add-test-questions');

        // Student Routes
        Route::get('add-new-student', [DashboardController::class, 'addNewStudent'])->name('admin.add-new-student');
        Route::get('all-students', [DashboardController::class, 'allStudents'])->name('admin.all-students');
    });

    // Route::post('login', [LoginController::class, 'login'])->name('login');

    Route::post('add-new-test', [TestController::class, 'addNewTest'])->name('add-new-test');
    Route::get('delete-test', [TestController::class, 'deleteTest'])->name('delete-test');

    // Student Routes
    Route::post('add-new-student', [UserController::class, 'addNewStudent'])->name('add-new-student');
});
