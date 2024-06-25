<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkoutAnalyticController;
use App\Http\Controllers\EquipmentController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/home', function () {
    return view('userHome');
});

Route::get('/report', function () {return view('workoutReport');});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['prefix' => 'analytic'],function(){
    Route::get('/report', [WorkoutAnalyticController::class, 'report'])->name('analytic-report');
    // Route::get('/view-record', [WorkoutAnalyticController::class, 'recordDetails'])->name('analytic-report');
});

Route::get('/equipment', [EquipmentController::class, 'index'])->name('equipment-index');
// Route::group(['prefix' => 'equipment'],function(){
//     Route::get('/report', [WorkoutAnalyticController::class, 'report'])->name('analytic-report');
//     Route::get('/view-record', [WorkoutAnalyticController::class, 'recordDetails'])->name('analytic-report');
// });

require __DIR__.'/auth.php';
