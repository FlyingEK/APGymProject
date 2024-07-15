<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkoutAnalyticController extends Controller
{
    public function index()
    {
        return view('workout-analytic.index');
    }

    public function setGoal()
    {
        return view('workout-analytic.set-goal');
    }

    // public function recordDetails()
    // {
    //     return view('workout-analytic.record-details');
    // }
}
?>