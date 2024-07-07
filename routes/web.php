<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkoutAnalyticController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\IssueReportController;

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


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['prefix' => 'analytic'],function(){
    Route::get('/report', [WorkoutAnalyticController::class, 'report'])->name('analytic-report');
    // Route::get('/view-record', [WorkoutAnalyticController::class, 'recordDetails'])->name('analytic-report');
});

Route::group(['prefix' => 'issue'],function(){
    Route::get('/', [IssueReportController::class, 'indexUser'])->name('issue-user-index');
    Route::get('/create', [IssueReportController::class, 'create'])->name('issue-create');
    Route::get('/edit', [IssueReportController::class, 'edit'])->name('issue-edit');
    Route::get('/view', [IssueReportController::class, 'viewUser'])->name('issue-user-view');
});

Route::group(['prefix' => 'equipment'],function(){
    Route::get('/', [EquipmentController::class, 'index'])->name('equipment-index');
    Route::get('/view', [EquipmentController::class, 'viewEquipment'])->name('equipment-view');
    
});

// Route::group(['prefix' => 'equipment'],function(){
//     Route::get('/report', [WorkoutAnalyticController::class, 'report'])->name('analytic-report');
//     Route::get('/view-record', [WorkoutAnalyticController::class, 'recordDetails'])->name('analytic-report');
// });

require __DIR__.'/auth.php';
