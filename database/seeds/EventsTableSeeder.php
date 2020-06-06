<?php

use Illuminate\Database\Seeder;
use App\Entities\Car;
use App\Entities\Event;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

      public function run()
      {
            $car=car::find('59803f60dac177031948e2d3');
            for($i=1;$i<50;$i++)
            {
                Event::create([
                'title' => "alert for car:"+$car->reg_no,
                'body' => "Your car was on at 12:50 PM",
                'car_id' => $car->id,
                'user_id'=>$car->user_id,
                'type'=>1,
              ]);
            }
            for($i=1;$i<50;$i++)
            {
                Event::create([
                'title' => "alert for car:"+$car->reg_no,
                'body' => "Your car was off at 1:10 PM",
                'car_id' => $car->id,
                'user_id'=>$car->user_id,
                'type'=>2,
              ]);
            }
            for($i=1;$i<50;$i++)
            {
                Event::create([
                'title' => "alert for car:"+$car->reg_no,
                'body' => "Your car has taken gas at 10:32 PM.
                            To know your gas amount please call +880 1907888839",
                'car_id' => $car->id,
                'user_id'=>$car->user_id,
                'type'=>3,
              ]);
            }

          }
}
