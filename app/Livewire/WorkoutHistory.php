<?php

namespace App\Livewire;
use Livewire\Component;
use App\Models\Workout;
use App\Models\GymUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class WorkoutHistory extends Component
{
    protected $listeners = ['setDate'];

    public $startDate;
    public $endDate;
    public $isFilter;
    public $workoutRecords;

    public function mount()
    {
        $this->isFilter = false;
        $this->startDate = Carbon::now()->subDays(7)->toDateString();
        $this->endDate = Carbon::now()->toDateString();
        $this->fetchWorkoutRecords();
    }

    public function fetchWorkoutRecords()
    {
        $gymUser = GymUser::where('gym_user_id', Auth::user()->user_id)->first();

        $this->workoutRecords = Workout::with('equipmentMachine.equipment')
        ->where('gym_user_id', $gymUser->gym_user_id) 
        ->where('status', 'completed')
        ->whereBetween('date', [$this->startDate, $this->endDate])
        ->orderBy('date', 'desc')
        ->get()
        ->groupBy(function($date) {
            return Carbon::parse($date->date)->format('d-m-Y'); // grouping by date
        })->toArray(); ;
    }

    public function setDate($data)
    {
        $this->isFilter = true;
        $this->startDate = $data;
        $this->endDate = $data;
        $this->fetchWorkoutRecords();
        $this->render();

    }

    public function updatedEndDate()
    {
        $this->fetchWorkoutRecords();
    }

    public function render()
    {
        return view('livewire.workout-history', [
            'isFilter' => $this->isFilter,
            'workoutRecords' => $this->workoutRecords,
        ]);
    }
}
