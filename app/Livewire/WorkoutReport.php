<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Workout;
use App\Models\GymUser;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; 


class WorkoutReport extends Component
{
    public $workoutRecords;
    public $filter = 'weekly';
    public $totalDays;
    public $totalTime;
    public $mostUsedEquipment;
    public $activeTab = 'weekly';
    protected $listeners = ['fetchWorkoutRecords'];

    public function mount()
    {
        $this->fetchWorkoutRecords();
    }

    public function fetchWorkoutRecords($filter = null)
    {
        if ($filter) {
            $this->filter = $filter;
        }
        $gymUser = GymUser::where('user_id', Auth::user()->user_id)->first();
        $query = Workout::with('equipmentMachine.equipment')
            ->where('gym_user_id', $gymUser->gym_user_id)
            ->where('status', 'completed')
            ->orderBy('date', 'desc');

        switch ($this->filter) {
            case 'weekly':
                $startDate = Carbon::now()->subDays(7)->startOfDay();
                break;
            case 'monthly':
                $startDate = Carbon::now()->subMonth()->startOfMonth();
                break;
            case 'annually':
                $startDate = Carbon::now()->subYear()->startOfYear();
                break;
            default:
                $startDate = Carbon::now()->subDays(7)->startOfDay();
        }

        $endDate = Carbon::now()->endOfDay();

        $workouts = $query->whereBetween('date', [$startDate, $endDate])
            ->get();

        $this->workoutRecords = $workouts->groupBy(function($date) {
            return Carbon::parse($date->date)->format('d-m-Y'); // grouping by date
        })->toArray();

        $this->calculateReport($workouts);
    }

    public function calculateReport($workouts)
    {
        $this->totalDays = $workouts->groupBy('date')->count();
        $totalTimeMinutes = $workouts->sum('duration');
        $this->totalTime = round($totalTimeMinutes / 60);
        $this->mostUsedEquipment = $workouts->groupBy(function ($workout) {
            return $workout->equipmentMachine->equipment_id;
        })->map(function ($group) {
            $totalDurationMinutes = $group->sum('duration');
        
            return [
                'duration' => round($totalDurationMinutes / 60), // convert to hours and round up
                'image' => $group->first()->equipmentMachine->equipment->image
            ];
        })->sortDesc()->take(3);
        
        
    }

    public function getWeeklyReport()
    {
        $this->filter = 'weekly';
        $this->activeTab = 'weekly';
        $this->fetchWorkoutRecords();
        $this->render();

    }

    public function getMonthlyReport()
    {
        $this->filter = 'monthly';
        $this->activeTab = 'monthly';
        $this->fetchWorkoutRecords();
        $this->render();

    }

    public function getAnnualReport()
    {
        $this->filter = 'annually';
        $this->activeTab = 'annual';
        $this->fetchWorkoutRecords();
        $this->render();
    }

    public function render()
    {
        return view('livewire.workout-report');
    }
}
