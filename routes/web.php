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
        Route::post('change-password', [DashboardController::class, 'changePassword'])->name('admin.change-password');

        // Test Routes
        Route::get('all-tests', [DashboardController::class, 'allTests'])->name('admin.all-tests');
        Route::get('add-new-test', [DashboardController::class, 'addNewTest'])->name('admin.add-new-test');


        Route::get('add-test-groups/{id}', [DashboardController::class, 'addTestGroups'])->name('admin.add-test-groups');
        Route::get('delete-group/{id}', [TestController::class, 'deleteTestGroup'])->name('admin.delete-test-group');
        Route::get('add-test-questions/{id}', [DashboardController::class, 'addTestQuestions'])->name('admin.add-test-questions');
        Route::get('add-dnd-questions/{id}', [DashboardController::class, 'addDNDQuestions'])->name('admin.add-dnd-questions');
        Route::get('add-image-questions/{id}', [DashboardController::class, 'addImageQuestions'])->name('admin.add-image-questions');
        Route::get('delete-question/{id}', [TestController::class, 'deleteQuestion'])->name('admin.delete-test');
        Route::get('submitted-writing-tests', [DashboardController::class, 'submittedWritingTests'])->name('admin.submitted-writing-tests');
        Route::get('preview-test/{id}', [TestController::class, 'previewTest'])->name('admin.preview-test');
        Route::get('review-writing-test/{id}', [DashboardController::class, 'reviewWritingTest'])->name('admin.review-writing-test');

        Route::get('combine-tests', [DashboardController::class, 'combineTests'])->name('admin.combine-tests');
        Route::get('combined-tests', [DashboardController::class, 'combinedTests'])->name('admin.combined-tests');

        Route::get('allocated-tests', [DashboardController::class, 'allocatedTests'])->name('admin.allocated-tests');

        Route::get('submitted-tests', [DashboardController::class, 'submittedTests'])->name('admin.submitted-tests');

        // Student Routes
        Route::get('add-new-student', [DashboardController::class, 'addNewStudent'])->name('admin.add-new-student');
        Route::get('all-students', [DashboardController::class, 'allStudents'])->name('admin.all-students');
    });

    // Route::post('login', [LoginController::class, 'login'])->name('login');

    Route::post('add-new-test', [TestController::class, 'addNewTest'])->name('add-new-test');
    Route::post('add-test-group', [TestController::class, 'addTestGroup'])->name('add-test-group');
    Route::get('change-test-status', [TestController::class, 'changeTestStatus'])->name('change-test-status');
    Route::get('change-combined-test-status', [TestController::class, 'changeCombinedTestStatus'])->name('change-combined-test-status');
    Route::get('delete-test', [TestController::class, 'deleteTest'])->name('delete-test');
    Route::get('delete-combined-test', [TestController::class, 'deleteCombinedTest'])->name('delete-combined-test');
    Route::post('combine-tests', [TestController::class, 'combineTests'])->name('combine-tests');
    Route::post('validate-writing-test', [TestController::class, 'validateWritingTest'])->name('validate-writing-test');
    Route::post('invalidate-writing-test', [TestController::class, 'invalidateWritingTest'])->name('invalidate-writing-test');

    Route::post('allocate-test', [TestController::class, 'allocateTest'])->name('allocate-test');
    Route::get('reallocate-test', [TestController::class, 'reAllocateTest'])->name('reallocate-test');

    // Student Routes
    Route::post('add-new-student', [UserController::class, 'addNewStudent'])->name('add-new-student');
    Route::get('change-student-status', [UserController::class, 'changeStudentStatus'])->name('change-student-status');
    Route::get('delete-student', [UserController::class, 'deleteStudent'])->name('delete-student');
});
