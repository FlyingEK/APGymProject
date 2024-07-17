<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkoutAnalyticController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConstraintController;
use App\Http\Controllers\IssueReportController;
use App\Http\Controllers\GymController;



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

Route::get('/gym', [GymController::class, 'gymUser'])->name('gym-user');
Route::get('/gym', [GymController::class, 'gymIndex'])->name('gym-index');

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile', [ProfileController::class, 'view'])->name('profile.view');
    Route::patch('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/edit', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::group(['prefix' => 'workout'],function(){
    Route::get('/index', [WorkoutController::class, 'index'])->name('workout-index');
    // Route::get('/view-record', [WorkoutAnalyticController::class, 'recordDetails'])->name('analytic-report');
});
Route::group(['prefix' => 'analytic'],function(){
    Route::get('/', [WorkoutAnalyticController::class, 'index'])->name('analytic-report');
    Route::get('/setGoal', [WorkoutAnalyticController::class, 'setGoal'])->name('set-goal');
    // Route::get('/view-record', [WorkoutAnalyticController::class, 'recordDetails'])->name('analytic-report');
});

Route::group(['prefix' => 'issue'],function(){
    Route::get('/', [IssueReportController::class, 'indexUser'])->name('issue-user-index');
    Route::get('/create', [IssueReportController::class, 'create'])->name('issue-create');
    Route::get('/edit', [IssueReportController::class, 'edit'])->name('issue-edit');
    Route::get('/view', [IssueReportController::class, 'viewUser'])->name('issue-user-view');
    Route::get('/index', [IssueReportController::class, 'indexTrainer'])->name('issue-trainer-index');

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

Route::group(['prefix' => 'equipment'], function(){
    Route::get('/', [EquipmentController::class, 'index'])->name('equipment-index');
    Route::get('/equipments', [EquipmentController::class, 'allEquipment'])->name('equipments');
    Route::get('/view', [EquipmentController::class, 'viewEquipment'])->name('equipment-view');
    Route::get('/add', [EquipmentController::class, 'addEquipment'])->name('equipment-add');
    Route::post('/store', [EquipmentController::class, 'store'])->name('equipment.store');
    Route::get('/all', [EquipmentController::class, 'viewAllEquipment'])->name('equipment-all');
    Route::get('/edit/{id}', [EquipmentController::class, 'editEquipment'])->name('equipment-edit');
    Route::get('/adminView/{id}', [EquipmentController::class, 'adminViewEquipment'])->name('equipment-admin-view');
    Route::get('/exceeded', [EquipmentController::class, 'timeExceededEquipment'])->name('equipment-time-exceeded');
});


// Route::group(['prefix' => 'equipment'],function(){
//     Route::get('/report', [WorkoutAnalyticController::class, 'report'])->name('analytic-report');
//     Route::get('/view-record', [WorkoutAnalyticController::class, 'recordDetails'])->name('analytic-report');
// });

require __DIR__.'/auth.php';
