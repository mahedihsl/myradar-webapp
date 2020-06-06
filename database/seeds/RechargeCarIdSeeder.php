<?php

use Illuminate\Database\Seeder;
use App\Entities\Recharge;

class RechargeCarIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Recharge::all()->each(function($item) {
            $item->update([
                'car_id' => $item->device->car_id,
            ]);
        });
    }
}
