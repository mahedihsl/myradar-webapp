<?php

use Illuminate\Database\Seeder;

use App\Entities\District;
use App\Entities\Thana;
use App\Entities\Fence;

class FencesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Excel::load(storage_path('app/imports/geofence.csv'), function($reader) {
        //
        //     collect($reader->toArray())->each(function($row) {
        //         $row = collect($row);
        //
        //         $d_name = $row->get('district');
        //         $t_name = $row->get('thana');
        //
        //         $district = District::where('name', $d_name)->first();
        //         $thana = Thana::where('name', $t_name)->first();
        //
        //         if (is_null($district)) {
        //             $district = District::create([
        //                 'name' => $d_name,
        //             ]);
        //         }
        //
        //         if (is_null($thana)) {
        //             $thana = Thana::create([
        //                 'name' => $t_name,
        //                 'district_id' => $district->id,
        //             ]);
        //         }
        //
        //         Fence::create([
        //             'name' => $row->get('location_n'),
        //             'lat' => $row->get('lattitude'),
        //             'lng' => $row->get('longitude'),
        //             'radius' => 200,
        //             'thana_id' => $thana->id,
        //         ]);
        //     });
        //
        // });

        Fence::all()->each(function($fence) {
            if (is_string($fence->thana_id)) {
                $fence->update([
                    'loc' => [$fence->lng, $fence->lat]
                ]);
            }
        });
    }
}
