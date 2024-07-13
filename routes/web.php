<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkoutAnalyticController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConstraintController;
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

Route::group(['prefix' => 'constraint'],function(){
    Route::get('/all', [ConstraintController::class, 'allConstraint'])->name('constraint-all');
    Route::get('/create', [ConstraintController::class, 'addConstraint'])->name('constraint-create');
    Route::get('/edit', [ConstraintController::class, 'editConstraint'])->name('constraint-edit');
    Route::get('/view', [ConstraintController::class, 'viewConstraint'])->name('constraint-view');
});

Route::group(['prefix' => 'user'],function(){
    Route::get('/all', [UserController::class, 'allUser'])->name('user-all');
    Route::get('/create', [UserController::class, 'addUser'])->name('user-create');
    Route::get('/edit', [UserController::class, 'editUser'])->name('user-edit');
    Route::get('/view', [UserController::class, 'viewUser'])->name('user-view');
});

Route::group(['prefix' => 'equipment'],function(){
    Route::get('/', [EquipmentController::class, 'index'])->name('equipment-index');
    Route::get('/view', [EquipmentController::class, 'viewEquipment'])->name('equipment-view');
    Route::get('/add', [EquipmentController::class, 'addEquipment'])->name('equipment-add');
    Route::get('/all', [EquipmentController::class, 'viewAllEquipment'])->name('equipment-all');
    Route::get('/edit', [EquipmentController::class, 'editEquipment'])->name('equipment-edit');
    Route::get('/adminView', [EquipmentController::class, 'adminViewEquipment'])->name('equipment-admin-view');


    
});

// Route::group(['prefix' => 'equipment'],function(){
//     Route::get('/report', [WorkoutAnalyticController::class, 'report'])->name('analytic-report');
//     Route::get('/view-record', [WorkoutAnalyticController::class, 'recordDetails'])->name('analytic-report');
// });

require __DIR__.'/auth.php';
