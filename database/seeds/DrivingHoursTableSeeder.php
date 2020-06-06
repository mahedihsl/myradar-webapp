<?php

use Illuminate\Database\Seeder;

use App\Entities\Device;
use Carbon\Carbon;

class DrivingHoursTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Device::all()->each(function($device) {
            for ($i=40; $i > -1; $i--) {
                $device->driving_hour()->create([
                    'value' => rand(4, 60) * 10000,
                    'car_id' => $device->car_id,
                    'when' => Carbon::today()->subDays($i),
                ]);
            }
        });
    }
}
