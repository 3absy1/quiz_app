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
    Route::get('googleformsmodule',[ GoogleFormsModuleController::class, 'index'])->name('googleformsmodule');


    Route::middleware('auth:sanctum')->group(function () {

    Route::get('admin/teachers', [AdminController::class, 'teachers'])->name('teachers');
    Route::get('admin/teachers/export', [AdminController::class, 'teachersExport'])->name('teachers.export');
    Route::get('admin/teachers/selectedExport', [AdminController::class, 'teachersSelectedExport'])->name('teachers.selectedExport');
    Route::get('admin/teacher/forms', [AdminController::class, 'teacherForm'])->name('teacher.forms');

    Route::get('admin/teacher/students', [AdminController::class, 'studentForm'])->name('teacher.students');
    Route::get('admin/teachers/students/export', [AdminController::class, 'studentFormExport'])->name('studentForm.export');
    Route::get('admin/teachers/students/selectedExport', [AdminController::class, 'studentFormSelectedExport'])->name('studentForm.selectedExport');

    Route::post('admin/teacher/create', [AdminController::class, 'createTeacher'])->name('teacher.create');
    Route::put('admin/teacher/{id}', [AdminController::class, 'updateTeacher'])->name('teacher.update');
    Route::get('admin/teacher/{id}/edit', [AdminController::class, 'editTeacher'])->name('teacher.edit');

    Route::delete('admin/teacher/{id}/delete', [AdminController::class, 'deleteTeacher'])->name('teacher.delete');


    Route::get('/admin/students', [AdminController::class, 'students'])->name('students');
    Route::get('admin/students/export', [AdminController::class, 'studentsExport'])->name('students.export');
    Route::get('admin/students/selectedExport', [AdminController::class, 'studentsSelectedExport'])->name('students.selectedExport');

    Route::put('admin/student/{id}/edit', [AdminController::class, 'editStudent'])->name('students.edit');
    Route::delete('admin/student/{id}/delete', [AdminController::class, 'deleteStudent'])->name('student.delete');

    Route::get('/forms',[ AdminController::class, 'forms'])->name('forms');
    Route::get('admin/forms/export', [AdminController::class, 'formsExport'])->name('forms.export');
    Route::get('admin/forms/selectedExport', [AdminController::class, 'formsSelectedExport'])->name('forms.selectedExport');
    Route::get('/admin', function () {
        return view('googleformsmodule::Admin.home',[
            'teachers' => Teacher::count(),
            'students' => UserAnswer::count(),
            'forms' => Form::count()

        ]);
    })->name('admin');
});


    // Route::resource('googleformsmodule', GoogleFormsModuleController::class)->names('googleformsmodule');


Route::get('/quiz/{id?}', [GoogleFormsModuleController::class , 'index']);
Route::get('/result', [GoogleFormsModuleController::class , 'index']);
Route::get('/googleformsmodule/{id?}/quizResults', [GoogleFormsModuleController::class , 'index']);
Route::get('/googleformsmodule/editForm/{id?}', [GoogleFormsModuleController::class , 'index']);

Route::get('/enter/{id?}', [GoogleFormsModuleController::class , 'index']);

Route::get('/googleformsmodule/sharelink/{id?}', [GoogleFormsModuleController::class , 'index']);
Route::get('/googleformsmodule/login', [GoogleFormsModuleController::class , 'index']);
Route::get('/googleformsmodule/generateQuiz', [GoogleFormsModuleController::class , 'index']);
Route::get('/googleformsmodule/{id?}/examTakers', [GoogleFormsModuleController::class , 'index']);

// });







