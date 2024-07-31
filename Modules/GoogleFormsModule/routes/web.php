<?php

use Illuminate\Support\Facades\Route;
use Modules\GoogleFormsModule\App\Http\Controllers\AdminController;
use Modules\GoogleFormsModule\App\Http\Controllers\GoogleFormsModuleController;
use Modules\GoogleFormsModule\App\Models\Form;
use Modules\GoogleFormsModule\App\Models\Teacher;
use Modules\GoogleFormsModule\App\Models\UserAnswer;

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
// Route::prefix('build')->group(function () {
Route::get('googleformsmodule', [GoogleFormsModuleController::class, 'index'])->name('googleformsmodule');


Route::middleware('auth:sanctum')->group(function () {

    Route::controller(AdminController::class)->group(function () {

        Route::prefix('admin')->group(function () {

                Route::get('/', [AdminController::class,'index'])->name('admin');

            Route::prefix('teacher')->group(function () {

                Route::get('/', 'teachers')->name('teachers');
                Route::get('/export','teachersExport')->name('teachers.export');
                Route::get('/selectedExport', 'teachersSelectedExport')->name('teachers.selectedExport');

                Route::get('/{id}/forms','teacherForm')->name('teacher.forms');
                Route::get('{ids}/forms/export', 'formsExport')->name('forms.export');
                Route::get('/forms/selectedExport', 'formsSelectedExport')->name('forms.selectedExport');

                Route::get('{id}/students', 'studentForm')->name('teacher.students');
                Route::get('/students/export', 'studentFormExport')->name('studentForm.export');
                Route::get('/students/selectedExport', 'studentFormSelectedExport')->name('studentForm.selectedExport');

                Route::post('/create', 'createTeacher')->name('teacher.create');
                Route::put('/{id}', 'updateTeacher')->name('teacher.update');
                Route::get('/{id}/edit', 'editTeacher')->name('teacher.edit');
                Route::delete('/{id}/delete', 'deleteTeacher')->name('teacher.delete');

            });

            Route::prefix('student')->group(function () {

                Route::get('/', 'students')->name('students');
                Route::get('/export', 'studentsExport')->name('students.export');
                Route::get('/selectedExport', 'studentsSelectedExport')->name('students.selectedExport');

                Route::put('/{id}/edit', 'editStudent')->name('students.edit');
                Route::delete('/{id}/delete', 'deleteStudent')->name('student.delete');
            });
        });
    });

});


// Route::resource('googleformsmodule', GoogleFormsModuleController::class)->names('googleformsmodule');


Route::get('/quiz/{id?}', [GoogleFormsModuleController::class, 'index']);
Route::get('/result', [GoogleFormsModuleController::class, 'index']);
Route::get('/googleformsmodule/admin/{id?}', [GoogleFormsModuleController::class, 'index']);
Route::get('/googleformsmodule/{id?}/quizResults', [GoogleFormsModuleController::class, 'index']);
Route::get('/googleformsmodule/editForm/{id?}', [GoogleFormsModuleController::class, 'index']);

Route::get('/enter/{id?}', [GoogleFormsModuleController::class, 'index']);

Route::get('/googleformsmodule/sharelink/{id?}', [GoogleFormsModuleController::class, 'index']);
Route::get('/googleformsmodule/login', [GoogleFormsModuleController::class, 'index']);
Route::get('/googleformsmodule/generateQuiz', [GoogleFormsModuleController::class, 'index']);
Route::get('/googleformsmodule/{id?}/examTakers', [GoogleFormsModuleController::class, 'index']);

// });
