<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ComputerController;
use App\Http\Controllers\TrainigCenterController;
use App\Http\Controllers\ApprenticeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\CourseTeacherController;
use App\Http\Controllers\FormacionController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/areas', [AreaController::class, 'index'])->name('area.index');
Route::get('/areas/create', [AreaController::class, 'create'])->name('area.create');
Route::post('/areas', [AreaController::class, 'store'])->name('area.store');
Route::get('/areas/{id}', [AreaController::class, 'show'])->name('area.show');
Route::get('/areas/{id}/edit', [AreaController::class, 'edit'])->name('area.edit');
Route::put('/areas/{id}', [AreaController::class, 'update'])->name('area.update');
Route::delete('/areas/{id}', [AreaController::class, 'destroy'])->name('area.destroy');


Route::get('/computers', [ComputerController::class, 'index'])->name('computer.index');
Route::get('/computers/create', [ComputerController::class, 'create'])->name('computer.create');
Route::post('/computers', [ComputerController::class, 'store'])->name('computer.store');
Route::get('/computers/{id}', [ComputerController::class, 'show'])->name('computer.show');
Route::get('/computers/{id}/edit', [ComputerController::class, 'edit'])->name('computer.edit');
Route::put('/computers/{id}', [ComputerController::class, 'update'])->name('computer.update');
Route::delete('/computers/{id}', [ComputerController::class, 'destroy'])->name('computer.destroy');


Route::get('/training-centers', [TrainigCenterController::class, 'index'])->name('trainig-center.index');
Route::get('/training-centers/create', [TrainigCenterController::class, 'create'])->name('trainig-center.create');
Route::post('/training-centers', [TrainigCenterController::class, 'store'])->name('trainig-center.store');
Route::get('/training-centers/{id}', [TrainigCenterController::class, 'show'])->name('trainig-center.show');
Route::get('/training-centers/{id}/edit', [TrainigCenterController::class, 'edit'])->name('trainig-center.edit');
Route::put('/training-centers/{id}', [TrainigCenterController::class, 'update'])->name('trainig-center.update');
Route::delete('/training-centers/{id}', [TrainigCenterController::class, 'destroy'])->name('trainig-center.destroy');

Route::get('/apprentices', [ApprenticeController::class, 'index'])->name('apprentice.index');
Route::get('/apprentices/create', [ApprenticeController::class, 'create'])->name('apprentice.create');
Route::post('/apprentices', [ApprenticeController::class, 'store'])->name('apprentice.store');
Route::get('/apprentices/{id}', [ApprenticeController::class, 'show'])->name('apprentice.show');
Route::get('/apprentices/{id}/edit', [ApprenticeController::class, 'edit'])->name('apprentice.edit');
Route::put('/apprentices/{id}', [ApprenticeController::class, 'update'])->name('apprentice.update');
Route::delete('/apprentices/{id}', [ApprenticeController::class, 'destroy'])->name('apprentice.destroy');

Route::get('/courses', [CourseController::class, 'index'])->name('course.index');
Route::get('/courses/create', [CourseController::class, 'create'])->name('course.create');
Route::post('/courses', [CourseController::class, 'store'])->name('course.store');
Route::get('/courses/{id}', [CourseController::class, 'show'])->name('course.show');
Route::get('/courses/{id}/edit', [CourseController::class, 'edit'])->name('course.edit');
Route::put('/courses/{id}', [CourseController::class, 'update'])->name('course.update');
Route::delete('/courses/{id}', [CourseController::class, 'destroy'])->name('course.destroy');

Route::get('/teachers', [TeacherController::class, 'index'])->name('teacher.index');
Route::get('/teachers/create', [TeacherController::class, 'create'])->name('teacher.create');
Route::post('/teachers', [TeacherController::class, 'store'])->name('teacher.store');
Route::get('/teachers/{id}', [TeacherController::class, 'show'])->name('teacher.show');
Route::get('/teachers/{id}/edit', [TeacherController::class, 'edit'])->name('teacher.edit');
Route::put('/teachers/{id}', [TeacherController::class, 'update'])->name('teacher.update');
Route::delete('/teachers/{id}', [TeacherController::class, 'destroy'])->name('teacher.destroy');

Route::get('/course-teachers', [CourseTeacherController::class, 'index'])->name('course_teacher.index');
Route::get('/course-teachers/create', [CourseTeacherController::class, 'create'])->name('course_teacher.create');
Route::post('/course-teachers', [CourseTeacherController::class, 'store'])->name('course_teacher.store');
Route::get('/course-teachers/{id}', [CourseTeacherController::class, 'show'])->name('course_teacher.show');
Route::get('/course-teachers/{id}/edit', [CourseTeacherController::class, 'edit'])->name('course_teacher.edit');
Route::put('/course-teachers/{id}', [CourseTeacherController::class, 'update'])->name('course_teacher.update');
Route::delete('/course-teachers/{id}', [CourseTeacherController::class, 'destroy'])->name('course_teacher.destroy');

Route::resource('/formaciones', FormacionController::class)->only(['index', 'create', 'store']);

// 2. Rutas personalizadas (que no forman parte del resource estándar)
Route::get('/formaciones/{id}/evaluar', [FormacionController::class, 'evaluarAspirantes'])->name('formaciones.evaluar');

Route::put('/formaciones/aspirantes/{id}/aprobar', [FormacionController::class, 'aprobarAspirante'])->name('formaciones.aprobar');
Route::put('/formaciones/aspirantes/{id}/rechazar', [FormacionController::class, 'rechazarAspirante'])->name('formaciones.rechazar');
