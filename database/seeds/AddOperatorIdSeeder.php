<?php

use Illuminate\Database\Seeder;

use App\Entities\Device;
use App\Entities\Operator;

class AddOperatorIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ops = Operator::all();
        Device::all()->each(function($device) use ($ops) {
            $device->update([
                'operator_id' => $ops->random()->id,
            ]);
        });
    }
}
