<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkoutAnalyticController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConstraintController;
use App\Http\Controllers\IssueReportController;
use App\Http\Controllers\GymController;
use App\Http\Controllers\GymQueueController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AchievementController;
use App\Http\Livewire\WorkoutReport;
// use Livewire\Livewire;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// Livewire::routes();
Route::get('/', function () {
    // Redirect based on user role
    $user = Auth::user();
    if ($user->role == 'user') {
        return redirect()->intended(route('equipment-index'));
    } elseif ($user->role == 'trainer') {
        return redirect()->intended(route('gym-index'));
    } elseif ($user->role == 'admin') {
        return redirect()->intended(route('gym-log-admin'));
    }
})->middleware(['auth', 'verified']);

Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user->role == 'user') {
        return redirect()->intended(route('equipment-index'));
    } elseif ($user->role == 'trainer') {
        return redirect()->intended(route('gym-index'));
    } elseif ($user->role == 'admin') {
        return redirect()->intended(route('gym-log-admin'));
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/home', function () {
    return view('userHome');
});

Route::group(['middleware' => ['auth','verified']],function(){
    //for admin only
    Route::group(['middleware' => 'role:admin'],function(){
        Route::group(['prefix' => 'constraint'],function(){
            Route::get('/all', [ConstraintController::class, 'allConstraint'])->name('constraint-all');
            Route::get('/create', [ConstraintController::class, 'addConstraint'])->name('constraint-create');
            Route::post('/store', [ConstraintController::class, 'storeConstraint'])->name('constraint-store');
            Route::get('/edit/{id}', [ConstraintController::class, 'editConstraint'])->name('constraint-edit');
            Route::put('/update/{id}', [ConstraintController::class, 'updateConstraint'])->name('constraint-update');
            Route::get('/view/{id}', [ConstraintController::class, 'viewConstraint'])->name('constraint-view');
            Route::delete('/delete', [ConstraintController::class, 'deleteConstraint'])->name('constraint-delete');
        });

        Route::group(['prefix' => 'achievement'],function(){
            Route::get('/all', [AchievementController::class, 'allAchievement'])->name('achievement-all');
            Route::get('/create', [AchievementController::class, 'addAchievement'])->name('achievement-create');
            Route::post('/store', [AchievementController::class, 'storeAchievement'])->name('achievement-store');
            Route::get('/edit/{id}', [AchievementController::class, 'editAchievement'])->name('achievement-edit');
            Route::put('/update/{id}', [AchievementController::class, 'updateAchievement'])->name('achievement-update');
            Route::delete('/delete', [AchievementController::class, 'deleteAchievement'])->name('achievement-delete');
        });

        Route::group(['prefix' => 'equipment'], function(){
            Route::get('/add', [EquipmentController::class, 'addEquipment'])->name('equipment-add');
            Route::post('/store', [EquipmentController::class, 'store'])->name('equipment.store');
            Route::get('/all', [EquipmentController::class, 'viewAllEquipment'])->name('equipment-all');
            Route::get('/edit/{id}', [EquipmentController::class, 'editEquipment'])->name('equipment-edit');
            Route::put('/update/{id}', [EquipmentController::class, 'updateEquipment'])->name('equipment-update');
            Route::get('/adminView/{id}', [EquipmentController::class, 'adminViewEquipment'])->name('equipment-admin-view');
            Route::put('/delete', [EquipmentController::class, 'deleteEquipment'])->name('equipment-delete');
        });

        Route::group(['prefix' => 'user'],function(){
            Route::get('/all', [UserController::class, 'allUser'])->name('user-all');
            Route::get('/add', [UserController::class, 'addUser'])->name('user-add');
            Route::post('/store', [UserController::class, 'store'])->name('user-store');
            Route::put('/edit/{id}', [UserController::class, 'editUser'])->name('user-edit');
            Route::get('/view/{id}', [UserController::class, 'viewUser'])->name('user-view');
            Route::get('/edit/{id}', [UserController::class, 'editUser'])->name('user-edit');
            Route::put('/deactivate', [UserController::class, 'deactivateUser'])->name('user-deactivate');
        });
        
        Route::group(['prefix' => 'gym'],function(){
            Route::get('/log/admin', [GymController::class, 'adminViewLog'])->name('gym-log-admin');        
        });
        Route::get('/viewIssue/{id}', [IssueReportController::class, 'viewAdmin'])->name('issue-admin-view');
        Route::get('/reportedIssue', [IssueReportController::class, 'reportedIssue'])->name('issue-reported');
    });

    // for user
    Route::group(['middleware' => 'role:user'],function(){
        Route::group(['prefix' => 'gym'],function(){
            Route::post('/enter-gym', [GymQueueController::class, 'userEntersGym'])->name('enter-gym');
            Route::post('/leave-gym', [GymQueueController::class, 'userLeavesGym'])->name('leave-gym');
            Route::post('/exit-queue', [GymQueueController::class, 'removeQueue'])->name('exit-queue');        
        });

        Route::group(['prefix' => 'workout'],function(){
            Route::get('/index', [WorkoutController::class, 'index'])->name('workout-index');
            Route::get('/habit', [WorkoutController::class, 'workoutHabit'])->name('workout-habit');
            Route::get('/addHabit', [WorkoutController::class, 'addWorkoutHabit'])->name('workout-habit-add');
            Route::post('/storeHabit', [WorkoutController::class, 'store'])->name('workout-habit-store');
            Route::put('/updateHabit/{id}', [WorkoutController::class, 'updateWorkoutHabit'])->name('workout-habit-update');
            Route::delete('/deleteHabit/{id}', [WorkoutController::class, 'deleteWorkoutHabit'])->name('workout-habit-delete');
            Route::get('/getHabit', [WorkoutController::class, 'getWorkoutHabit'])->name('workout-habit-details');
            Route::post('/addWorkout/{save}', [WorkoutController::class, 'setPlanAndGetEquipment'])->name('workout-add');
            Route::post('/startWorkout', [WorkoutController::class, 'startWorkout'])->name('workout-start');
            Route::put('/endWorkout', [WorkoutController::class, 'endWorkout'])->name('workout-end');
            Route::get('/view-record/{id}', [WorkoutAnalyticController::class, 'recordDetails'])->name('workout-detail');
            Route::post('/remove-queue/{id}', [WorkoutController::class, 'removeQueue'])->name('remove-queue');
        });

        Route::group(['prefix' => 'analytic'],function(){
            Route::get('/', [WorkoutAnalyticController::class, 'index'])->name('analytic-report');
            Route::get('/setGoal', [WorkoutAnalyticController::class, 'setGoal'])->name('set-goal');
            Route::post('/storeStrengthGoal', [WorkoutAnalyticController::class, 'storeStrengthGoal'])->name('store-strength-goal');
            Route::post('/storeOverallGoal/{id}', [WorkoutAnalyticController::class, 'storeOverallGoal'])->name('store-overall-goal');
        });

        Route::group(['prefix' => 'issue'],function(){
            Route::get('/', [IssueReportController::class, 'indexUser'])->name('issue-user-index');
            Route::get('/create', [IssueReportController::class, 'create'])->name('issue-create');
            Route::post('/store', [IssueReportController::class, 'store'])->name('issue-store');
            Route::get('/edit/{id}', [IssueReportController::class, 'edit'])->name('issue-edit');
            Route::put('/update/{id}', [IssueReportController::class, 'update'])->name('issue-update');
            Route::get('/view/{id}', [IssueReportController::class, 'viewUser'])->name('issue-user-view');
            Route::put('/cancel/{id}', [IssueReportController::class, 'cancelIssue'])->name('issue-cancel');
        });

        Route::group(['prefix' => 'equipment'], function(){
            Route::get('/', [EquipmentController::class, 'index'])->name('equipment-index');
            Route::get('/category/{id}', [EquipmentController::class, 'categoryEquipment'])->name('equipment-category');
        });

        Route::get('/notifications', [NotificationController::class, 'index'])->name('notification-index');

        Route::get('/get-equipment-machines', [EquipmentController::class, 'getEquipmentMachines'])->name('get-equipment-machines');

    });

    //for trainer
    Route::group(['middleware' => 'role:trainer'],function(){
        Route::group(['prefix' => 'gym'],function(){
            Route::get('/gymUser', [GymController::class, 'gymUser'])->name('gym-user');
            Route::get('/index', [GymController::class, 'gymIndex'])->name('gym-index');
            Route::get('/checkin', [GymQueueController::class, 'showCheckInForm'])->name('gym-checkin');
            Route::post('/checkin-post', [GymQueueController::class, 'checkIn'])->name('gym-checkin-post');
            Route::get('/log/trainer', [GymController::class, 'trainerViewLog'])->name('gym-log-trainer');
        });

        Route::group(['prefix' => 'issue'],function(){
            Route::get('/index', [IssueReportController::class, 'indexTrainer'])->name('issue-trainer-index');
        });

        Route::group(['prefix' => 'equipment'], function(){
            Route::get('/view/{id}', [EquipmentController::class, 'viewEquipment'])->name('equipment-view');
            Route::get('/equipmentsTrainer', [EquipmentController::class, 'trainerEquipments'])->name('equipments-trainer');
            Route::get('/trainerCategory/{id}', [EquipmentController::class, 'trainerCategoryEquipment'])->name('equipment-trainer-category');
            Route::post('/statusUpdate/{id}', [EquipmentController::class, 'statusUpdate'])->name('equipment-status-update');
        });
    });

    Route::group(['middleware' => 'role:trainer|user'],function(){
        Route::group(['prefix' => 'equipment'], function(){
            Route::get('/view/{id}', [EquipmentController::class, 'viewEquipment'])->name('equipment-view');
        });
    });

    Route::group(['middleware' => 'role:trainer|admin'],function(){
        Route::group(['prefix' => 'issue'],function(){
            Route::put('/updateStatus/{id}', [IssueReportController::class, 'updateStatus'])->name('issue-status-update');
            Route::get('/viewTrainer/{id}', [IssueReportController::class, 'viewTrainer'])->name('issue-trainer-view');
        });
    });

    


});

Route::get('/test', [NotificationController::class, 'test'])->name('test');

Route::middleware('auth')->group(function () {
    Route::group(['middleware' => 'role:trainer|user'],function(){
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    });
});

Route::middleware('auth')->group(function () {
    Route::group(['middleware' => 'role:admin'],function(){
        Route::get('/profile/adminedit', [ProfileController::class, 'adminedit'])->name('profile.admin.edit');

    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'view'])->name('profile.view');
    Route::patch('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/edit', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profileDetails', [ProfileController::class, 'profileDetails'])->name('profile-details');
    Route::put('/notifications/read-all', function () {
        Auth::user()->unreadNotifications->markAsRead();
        return response()->json(['notisuccess' => 'success']);
    })->name('notifications.readAll');
});

require __DIR__.'/auth.php';
