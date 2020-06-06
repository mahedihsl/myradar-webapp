<?php

use Illuminate\Database\Seeder;

use App\Entities\User;
use App\Entities\Setting;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::all()->each(function($user) {
            factory(Setting::class)->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
