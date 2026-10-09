<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ComputerController;
use App\Http\Controllers\TrainigCenterController;

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
