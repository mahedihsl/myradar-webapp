<?php

use Illuminate\Database\Seeder;

use App\Entities\Poi;

class PoiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\Entities\Poi::class, 5000)->create();

        // Excel::load(storage_path('app/imports/poi_list.csv'), function($reader) {
        //
        //     collect($reader->toArray())->each(function($row) {
        //         $row = collect($row);
        //         Poi::create([
        //             'name' => $row->get('location_n'),
        //             'lat' => $row->get('lattitude'),
        //             'lng' => $row->get('longitude'),
        //         ]);
        //     });
        //
        // });

        Poi::all()->each(function($item){
          $item->update([ 'loc' => [$item->lng, $item->lat] ]);
        });

    }
}
