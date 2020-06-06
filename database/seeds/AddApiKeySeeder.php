<?php

use Illuminate\Database\Seeder;
use App\Entities\User;

class AddApiKeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::all()->each(function($user) {
            $user->update([
                'api_token' => str_random(60),
            ]);
        });
    }
}
