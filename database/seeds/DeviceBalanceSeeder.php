<?php

use Illuminate\Database\Seeder;
use App\Entities\Device;

class DeviceBalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Device::all()->each(function($device) {
            $recharge = $device->last_recharge;
            if ( ! is_null($recharge)) {
                $device->update([
                    'balance' => [
                        'recharged_at' => $recharge->recharged_at->timestamp,
                        'validity' => $recharge->validity->timestamp,
                        'volume' => $recharge->volume,
                        'consumed' => $recharge->consumed,
                        'remained' => $recharge->remained,
                    ]
                ]);
            }
        });
    }
}
