<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Entities\User::class, 30)->create()->each(function($user) {
            $user->image()->create([
                'url' => 'image/face' . rand(1, 10) . '.jpg',
            ]);
        });

        factory(App\Entities\User::class, 50)
            ->states('customer')
                ->create()
                    ->each(function($user) {
                        $user->image()->create([
                            'url' => 'image/face' . rand(1, 10) . '.jpg',
                        ]);
                        factory(App\Entities\Car::class, rand(1, 3))->create([
                            'user_id' => $user->id,
                        ])->each(function($car) use ($user) {
                            factory(App\Entities\Device::class)->create([
                                'car_id' => $car->id,
                                'user_id' => $user->id,
                            ]);
                        });
                    });
    }

}
