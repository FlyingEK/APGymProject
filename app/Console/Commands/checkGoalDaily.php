<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OverallGoal;


class checkGoalDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    /**
     * The console command description.
     *
     * @var string
     */
    protected $signature = 'goals:check-daily';
    protected $description = 'Check daily if any user has failed to meet their workout hour goals before the target date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        OverallGoal::checkDailyGoals();
        $this->info('Daily goals checked successfully.');
    }
}
