<?php

use Illuminate\Database\Seeder;
use App\Entities\Car;
use Carbon\Carbon;

class DriversTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Car::where('user_id','5aaa33d189232c00071cdef2')->each(function($car) {
              $car->driver()->create([
                  'name'=>'Iqbal',
                  'phone'=>'01715986327',
                  'car_id' => $car->id
              ]);

      });
    }
}
