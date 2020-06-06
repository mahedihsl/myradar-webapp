<?php

use Illuminate\Database\Seeder;
use App\Entities\Zone;
use App\Entities\User;

class ZonesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $enterprise = User::where('type', User::$TYPE_CUSTOMER)
                            ->where('customer_type', User::$CUSTOMER_ENTERPRISE)
                            ->first();
        
        $data = collect([
            [
                'name' => 'Mirpur',
                'lat' => 23.807066,
                'lng' => 90.368606,
                'radius' => 5000,
            ],
            [
                'name' => 'Shyamoli',
                'lat' => 23.773215,
                'lng' => 90.367091,
                'radius' => 5000,
            ],
            [
                'name' => 'Dhanmondi',
                'lat' => 23.748354,
                'lng' => 90.376165,
                'radius' => 5000,
            ],
            [
                'name' => 'Banani',
                'lat' => 23.793835,
                'lng' => 90.405421,
                'radius' => 5000,
            ],
            [
                'name' => 'Uttara',
                'lat' => 23.869093,
                'lng' => 90.400284,
                'radius' => 5000,
            ],
        ]);

        $data->each(function($item) use ($enterprise) {
            $enterprise->zones()->create($item);
        });
    }
}
