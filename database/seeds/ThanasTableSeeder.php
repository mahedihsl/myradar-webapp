<?php

use Illuminate\Database\Seeder;

class ThanasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Entities\District::all()->each(function($district) {
            factory(App\Entities\Thana::class, rand(20, 30))->create([
                'district_id' => $district->id,
            ]);
        });
    }
}
