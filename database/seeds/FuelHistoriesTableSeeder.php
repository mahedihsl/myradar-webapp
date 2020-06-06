<?php

use Illuminate\Database\Seeder;
use App\Entities\FuelHistory;
use Carbon\Carbon;
use App\Entities\Device;
class FuelHistoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    $devices = Device::all()->take(15);
            foreach ($devices as $device) {
              FuelHistory::create([
                  'when' => Carbon::now()->addDays(5),
                  'value' => rand(1, 9) * 5,
                  'device_id'=>$device->id
              ]);

            }

    }
}
