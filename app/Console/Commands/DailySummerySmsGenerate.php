<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Entities\Car;
use App\Entities\Setting;
use App\Entities\DrivingHour;
use App\Jobs\DailySummerySmsJob;
use Carbon\Carbon;

class DailySummerySmsGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:summery';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        $this->getEligibleCarIds()->each(function($item) {
            dispatch(new DailySummerySmsJob($item));
        });
    }

    public function getEligibleCarIds()
    {
        $user_ids = Setting::where('sms_pack1', true)
                            ->get(['user_id'])
                            ->map(function ($val) {
                                return $val->user_id;
                            });
        $car_ids = Car::whereIn('user_id', $user_ids->toArray())
                    ->get(['_id'])
                    ->map(function ($val) {
                        return $val->id;
                    });
        $car_ids = DrivingHour::where('when', Carbon::yesterday())
                                    ->where('duration', '>', 0)
                                    ->whereIn('car_id', $car_ids->toArray())
                                    ->get(['car_id'])
                                    ->map(function ($val) {
                                        return $val->car_id;
                                    });
        return $car_ids;
    }
}
