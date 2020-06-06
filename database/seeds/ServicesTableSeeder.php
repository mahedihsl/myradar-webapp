<?php

use Illuminate\Database\Seeder;
use App\Entities\Service;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i < 15; $i++) {
            Service::create([
                'name' => 'Service-'.$i,
                'type' => $i < 10 ? Service::$TYPE_DIGITAL : Service::$TYPE_ANALOG,
                'interval' => rand(1, 20) * 5,
            ]);
        }
    }
}
