<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkoutController extends Controller
{
    public function index()
    {
        return view('workout.index');
    }

    public function workoutHabit()
    {
        return view('workout.workoutHabit');
    }

}
?>