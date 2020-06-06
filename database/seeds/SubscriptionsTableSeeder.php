<?php

use Illuminate\Database\Seeder;

class SubscriptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = App\Entities\Service::all();
        App\Entities\Car::all()->each(function($car, $key) use ($services) {
            $services->random(rand(1, 5))->each(function($serv, $i) use ($car) {
                App\Entities\Subscription::create([
                    'car_id' => $car->id,
                    'service_id' => $serv->id,
                ]);
            });
        });
    }
}
