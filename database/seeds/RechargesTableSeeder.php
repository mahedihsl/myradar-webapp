<?php

use Illuminate\Database\Seeder;

class RechargesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Entities\Device::all()->each(function($device) {
            $count = rand(1, 4);
            $date = Carbon\Carbon::today()->subMonths($count);
            while ($count > -1) {
                $volume = rand(100, 500);
                $consumption = rand(100, $volume);  

                $device->recharges()->create([
                    'recharged_at' => $date,
                    'validity' => $date->copy()->addMonth(),
                    'amount' => rand(100, 500),
                    'volume' => $volume,
                    'consumed' => $consumption,
                    'remained' => $volume - $consumption
                ]);

                $count--;
                $date = $date->copy()->addMonth();
            }
        });
    }
}
