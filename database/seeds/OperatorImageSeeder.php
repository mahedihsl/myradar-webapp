<?php

use Illuminate\Database\Seeder;

class OperatorImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $logo = collect([
            'image/grameenphone.jpg',
            'image/robi.jpg',
            'image/airtel.jpg',
            'image/teletalk.jpg',
            'image/banglalink.jpg',
        ]);

        $ops = App\Entities\Operator::all();

        foreach ($logo as $key => $lg) {
            $ops->get($key)->image()->create([
                'url' => $lg,
            ]);
        }
    }
}
