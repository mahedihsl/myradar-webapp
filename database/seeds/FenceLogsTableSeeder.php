<?php

use Illuminate\Database\Seeder;
use App\Entities\User;
use App\Entities\Fence;
use App\Entities\FenceLog;

class FenceLogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fences = Fence::all()->take(15);
        User::where('type', User::$TYPE_CUSTOMER)
            ->take(10)
            ->get()
            ->each(function($user) use ($fences) {
                foreach ($fences as $fence) {
                    FenceLog::create([
                        'user_id' => $user->id,
                        'fence_id' => $fence->id,
                    ]);
                }
            });
    }
}
