<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Notifications\GoalFailed;
use Illuminate\Support\Facades\Notification;


class OverallGoal extends Model
{
    use HasFactory;
    protected $table = 'overall_goal';
    protected $primaryKey = 'goal_id';
    protected $fillable = ['goal_id','workout_hour', 'target_date','per'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function goal()
    {
        return $this->belongsTo(Goal::class, 'goal_id', 'goal_id');
    }

    public static function checkDailyGoals()
    {
        $goals = self::where('status', 'active')->get();

        foreach ($goals as $goal) {
            $gymUserId = $goal->goal->gym_user_id;
            $targetDate = Carbon::parse($goal->target_date);

            // Calculate total workout hours before the target date
            $totalHours = Workout::where('gym_user_id', $gymUserId)
                ->where('status', 'completed')
                ->whereDate('date', '<=', $targetDate)
                ->sum('duration') / 60;

            if ($totalHours < $goal->workout_hour && $targetDate->isPast()) {
                // Mark the goal as failed
                // $goal->status = 'failed';
                // $goal->save();

                Notification::send(User::find($gymUserId), new GoalFailed($goal));

                //Update the goal to new target date
                if($goal->per == "week"){
                    $goal->target_date = $targetDate->addWeek();
                }else if($goal->per == "month"){
                    $goal->target_date = $targetDate->addMonth();
                }
                $goal->status = 'active';
                $goal->save();

            }
        }
    }
}
