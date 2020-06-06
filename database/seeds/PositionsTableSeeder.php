<?php


use App\Util\RandomLatLngGenerator;
use Illuminate\Database\Seeder;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Entities\Device::all()->each(function($item, $key) {
            $generator = new RandomLatLngGenerator();
            $time = Carbon\Carbon::now();
            $time = $time->subDays(22);

            for ($i = 0, $count = rand(30, 50); $i < $count; $i++) {
                $pos = $generator->getNextLatLng();

                $item->positions()->create([
                    'lat' => $pos->getLat(),
                    'lng' => $pos->getLng(),
                    'when' => $time,
                ]);

                $time = $time->addSeconds(5);
            }
        });
    }
}
