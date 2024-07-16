<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\GoogleFormsModule\App\Http\Controllers\AdminController;
use Modules\GoogleFormsModule\App\Http\Controllers\Auth\AuthController;
use Modules\GoogleFormsModule\App\Http\Controllers\GoogleFormsModuleController;
use Modules\GoogleFormsModule\App\Http\Controllers\TeacherController;

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

// Route::get('admin/teachers', [AdminController::class, 'teachers']);
// Route::post('admin/teacher/create', [AdminController::class, 'createTeacher']);
// Route::put('admin/teacher/{id}/edit', [AdminController::class, 'editTeacher']);
// Route::delete('admin/teacher/{id}/delete', [AdminController::class, 'deleteTeacher']);


// Route::get('/admin/students', [AdminController::class, 'students']);
// Route::post('admin/student/create', [AdminController::class, 'createStudent']);
// Route::put('admin/student/{id}/edit', [AdminController::class, 'editStudent']);
// Route::delete('admin/student/{id}/delete', [AdminController::class, 'deleteStudent']);

// Route::get('/admin/forms', [AdminController::class, 'forms']);



Route::post('/teacher/register', [TeacherController::class, 'register']);
Route::post('/teacher/login', [TeacherController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('teacher/form', [TeacherController::class, 'teacherForm']);
    Route::get('teacher/form/{id}', [TeacherController::class, 'teacherFormID']);
    Route::post('form/{id}/edit', [TeacherController::class, 'editForm']);
    Route::delete('teacher/form/delete/{id}', [TeacherController::class, 'deleteForm']);

    Route::get('/form/{id}/student', [TeacherController::class, 'student']);
    Route::get('/form/{id}/allStudent', [TeacherController::class, 'allStudent']);
    Route::post('student/export', [TeacherController::class, 'export']);

    Route::get('student/{id}', [TeacherController::class, 'oneStudent']);
    Route::get('student/{id}/view', [TeacherController::class, 'viewStudent']);
    Route::patch('studentForm/{id}/edit', [TeacherController::class, 'editStudentForm']);

    Route::patch('student/{id}/edit', [TeacherController::class, 'editStudent']);
    Route::delete('student/{id}/delete', [TeacherController::class, 'deleteStudent']);
    Route::post('/teacher/logout', [TeacherController::class, 'logout']);
    Route::post('googleformsmodules', [GoogleFormsModuleController::class, 'store']);
});

// Route::middleware('auth:teacher')->group(function () {
// });


// Route::prefix('googleformsmodules')->group(function () {

//     Route::post('register', [AuthController::class, 'register'])->name('register');
//     Route::post('login', [AuthController::class, 'login'])->name('login');

//     Route::middleware('auth:sanctum')->group(function () {

//         Route::post('logout', [AuthController::class, 'logout'])->name('logout');
//         Route::get('showAdmin', [AuthController::class, 'showAdmin'])->name('showAdmin');
//         Route::patch('updateAdmin', [AuthController::class, 'update'])->name('updateAdmin');
//     });
// });



Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {

    Route::get(
        'googleformsmodules',
        fn (Request $request) => $request->user()
    )->name('googleformsmodule');
});


Route::get('googleformsmodules/show/{generated_id}', [GoogleFormsModuleController::class, 'showForm']);

Route::post('googleformsmodules/showStdForm/{generated_id}', [GoogleFormsModuleController::class, 'showStdForm']);


Route::get('googleformsmodules/showReq/{generated_id}', [GoogleFormsModuleController::class, 'showFormReq']);

Route::get('googleformsmodules/{generated_id}', [GoogleFormsModuleController::class, 'shareLink']);

Route::post('googleformsmodules/submitUserInfo/', [GoogleFormsModuleController::class, 'submitUserInfo']);

Route::post('googleformsmodules/submitformAnswers/{generated_id}', [GoogleFormsModuleController::class, 'submitformAnswers']);
