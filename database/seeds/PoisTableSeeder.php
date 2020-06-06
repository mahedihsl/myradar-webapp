<?php

use Illuminate\Database\Seeder;
use App\Entities\Poi;

class PoisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Poi::all()->each(function($item){
          $item->update([
              'loc' => [$item->lng, $item->lat],
          ]);
        });
    }
}
