<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkoutAnalyticController extends Controller
{
    public function report()
    {
        return view('workout-analytic.report');
    }

    // public function recordDetails()
    // {
    //     return view('workout-analytic.record-details');
    // }
}
?>