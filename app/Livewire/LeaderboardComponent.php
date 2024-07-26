<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Workout;
use App\Models\GymUser;
use App\Models\Equipment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LeaderboardComponent extends Component
{
    public $topOverall = [];
    public $topDaily = [];
    public $restOverall = [];
    public $restDaily = [];
    public $currentUserOverall;
    public $currentUserDaily;
    public $filter; // default filter
    public $period; // default period
    public $currentUserOverallPosition;
    public $currentUserDailyPosition;
    public $equipmentId;
    public $allEquipments;
    public $currentUser;

    public function mount()
    {
        // Retrieve the values from the session or set default values
        $this->filter = session('filter', 'hour'); // default filter
        $this->period = session('period', 'daily'); // default period
        $this->equipmentId = session('equipmentId', null);

        $this->currentUser = Auth::user();
        $this->getAllEquipments();
        $this->updateLeaderboard();

    }

    public function getAllEquipments()
    {
        $this->allEquipments = Equipment::where('is_deleted', false)
            ->where('has_weight', 1)
            ->get();
    }

    public function setEquipment($equipmentId)
    {
        $this->equipmentId = $equipmentId;
        session(['equipmentId' => $equipmentId]);
        $this->setFilter('weight');
    }

    public function setFilter($filter)
    {
        $this->filter = $filter;
        session(['filter' => $filter]);
        $this->updateLeaderboard();
    }

    public function setPeriod($period)
    {
        $this->period = $period;
        session(['period' => $period]);
        $this->updateLeaderboard();
    }

    private function updateLeaderboard()
    {
        if ($this->filter == 'hour') {
            if ($this->period == 'overall') {
                $this->getOverallBoard();
            } else {
                $this->getDailyBoard();
            }
        } elseif ($this->filter == 'weight') {
            if ($this->period == 'overall') {
                $this->getWeightBoard();
            } else {
                $this->getDailyWeightBoard();
            }
        }
    }

    public function getOverallBoard()
    {
        // Fetch overall leaderboard by total workout duration
        $overallLeaderboard = Workout::with('gymUser.user')->select('gym_user_id', DB::raw('SUM(duration) as total_duration'))
            ->where('status', 'completed')
            ->groupBy('gym_user_id')
            ->orderBy('total_duration', 'desc')
            ->get();

        $this->topOverall = $overallLeaderboard->take(3)->toArray(); // Convert to array
        $this->restOverall = $overallLeaderboard->slice(3);
        $this->updateCurrentUserPosition($overallLeaderboard);
    }

    public function getDailyBoard()
    {
        // Fetch daily leaderboard by total workout duration
        $today = Carbon::today()->toDateString();
        $dailyLeaderboard = Workout::with('gymUser.user')->select('gym_user_id', DB::raw('SUM(duration) as total_duration'))
            ->where('status', 'completed')
            ->whereDate('date', $today)
            ->groupBy('gym_user_id')
            ->orderBy('total_duration', 'desc')
            ->get();

        $this->topDaily = $dailyLeaderboard->take(3)->toArray();
        $this->restDaily = $dailyLeaderboard->slice(3);
        $this->updateCurrentUserPosition($dailyLeaderboard, true);
    }

    public function getDailyWeightBoard()
    {
        // Fetch daily leaderboard by maximum weight lifted
        $today = Carbon::today()->toDateString();
        $dailyLeaderboard = Workout::with('gymUser.user')->select('gym_user_id', DB::raw('MAX(weight) as max_weight'))
            ->where('status', 'completed')
            ->whereDate('date', $today)
            ->when($this->equipmentId, function ($query) {
                return $query->where('equipment_id', $this->equipmentId);
            })
            ->groupBy('gym_user_id')
            ->orderBy('max_weight', 'desc')
            ->get();

        $this->topDaily = $dailyLeaderboard->take(3)->toArray();
        $this->restDaily = $dailyLeaderboard->slice(3);
        $this->updateCurrentUserPosition($dailyLeaderboard, true);
    }

    private function updateCurrentUserPosition($leaderboard, $isDaily = false)
    {
        $gymUser = GymUser::where('user_id', Auth::id())->first();
        $gymUserId = $gymUser->gym_user_id;

        if ($isDaily) {
            $this->currentUserDaily = $leaderboard->where('gym_user_id', $gymUserId)->first();
            $position = $leaderboard->search(function ($item) use ($gymUserId) {
                return $item->gym_user_id == $gymUserId;
            });
            $this->currentUserDailyPosition = $position !== false ? $position + 1 : "N/A";
        } else {
            $this->currentUserOverall = $leaderboard->where('gym_user_id', $gymUserId)->first();
            $position = $leaderboard->search(function ($item) use ($gymUserId) {
                return $item->gym_user_id == $gymUserId;
            });
            $this->currentUserOverallPosition = $position !== false ? $position + 1 : "N/A";
        }
    }

    public function getWeightBoard()
    {
        // Fetch overall leaderboard by maximum weight lifted
        $overallLeaderboard = Workout::with('gymUser.user')->select('gym_user_id', DB::raw('MAX(weight) as max_weight'))
            ->where('status', 'completed')
            ->when($this->equipmentId, function ($query) {
                return $query->where('equipment_id', $this->equipmentId);
            })
            ->groupBy('gym_user_id')
            ->orderBy('max_weight', 'desc')
            ->get();

        $this->topOverall = $overallLeaderboard->take(3)->toArray();
        $this->restOverall = $overallLeaderboard->slice(3);
        $this->updateCurrentUserPosition($overallLeaderboard);
    }

    public function render()
    {
        return view('livewire.leaderboard-component');
    }
}
