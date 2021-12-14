<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckRewardExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reward:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire all the rewards if their expiry date has crossed.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = Carbon::today();

        $users = User::all();
        foreach($users as $user)
        {
            //calculate reward points that are not expired.
            $unexpired_points = $user->rewards()
                ->whereDate('expiry_date', '>', $date)
                ->where('is_expired', 0)
                ->sum('reward_points');
            
            //update user reward points
            //condition check to balance out used reward points
            if($user->reward_points > $unexpired_points){
                //update user reward points
                $user->reward_points = $unexpired_points;
                $user->save();
            }

            //for all expired rewards, set 'is_expired' value to true
            $user->rewards()->whereDate('expiry_date', '<=', $date)
                            ->where('is_expired', 0)
                            ->update(['is_expired' => 1]);

        }
        return Command::SUCCESS;
    }
}
