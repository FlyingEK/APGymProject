<?php
namespace App\Http\Controllers;
use App\Models\Equipment;
use Illuminate\Http\Request;

class WorkoutAnalyticController extends Controller
{
    public function index()
    {
        return view('workout-analytic.index');
    }

    public function setGoal()
    {
        $allEquipment = Equipment::where('is_deleted', false)->get();
        return view('workout-analytic.set-goal', compact('allEquipment'));
    }

    // public function recordDetails()
    // {
    //     return view('workout-analytic.record-details');
    // }
}
?>