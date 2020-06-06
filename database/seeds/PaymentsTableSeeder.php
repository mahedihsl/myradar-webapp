<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;
use App\Entities\Car;
use App\Entities\Payment;

class PaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Car::all()->map(function ($car) {
            if (rand(1, 10) == 5) {
                return;
            }

            $time = Carbon::today();
            $time->subMonths(5);
            $count = rand(1, 5);

            for ($i=0; $i < $count; $i++) {
                $flag = rand(1, 2) % 2;
                $months = array();

                $time2 = $time->copy();
                $time2->day = rand(1, 10);

                if ($flag == TRUE) {
                    array_push($months, $time->month);
                    $time->addMonth();
                    array_push($months, $time->month);
                    $i++;
                } else {
                    array_push($months, $time->month);
                }
                $time->addMonth();
                $car->payments()->create([
                    'amount' => sizeof($months) * 1000,
                    'months' => $months,
                    'user_id' => $car->user_id,
                    'paid_on' => $time2,
                ]);
            }
        });
    }
}
