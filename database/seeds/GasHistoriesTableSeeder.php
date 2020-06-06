<?php

use Illuminate\Database\Seeder;
use App\Entities\GasHistory;
use Carbon\Carbon;
use App\Entities\Device;
class GasHistoriesTableSeeder extends Seeder
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
              GasHistory::create([
                  'when' => Carbon::now()->addDays(1),
                  'value' => rand(1,4),
                  'device_id'=>$device->id
              ]);

            }

    }
}
