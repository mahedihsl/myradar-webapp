<?php

use Illuminate\Database\Seeder;

use App\Entities\Operator;

class OperatorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Operator::create([
            'name' => 'Grameenphone',
            'ussd' => '1234',
            'start' => 10,
            'sender' => 'GP Internet',
        ]);

        Operator::create([
            'name' => 'Robi',
            'ussd' => '1534',
            'start' => 8,
            'sender' => '5000',
        ]);

        Operator::create([
            'name' => 'Airtel',
            'ussd' => '2234',
            'start' => 12,
            'sender' => '8000',
        ]);

        Operator::create([
            'name' => 'Teletalk',
            'ussd' => '12344',
            'start' => 10,
            'sender' => 'Teletalk',
        ]);

        Operator::create([
            'name' => 'Banglalink',
            'ussd' => '12534',
            'start' => 6,
            'sender' => '4535',
        ]);
    }
}
