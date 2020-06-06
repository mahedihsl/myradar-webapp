<?php

use Carbon\Carbon;
use App\Entities\Subscription;
use App\Entities\Service;
use Illuminate\Database\Seeder;

class ServiceLogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subscription::all()->each(function($sub) {
            $adjusted_interval = $this->getRandomInterval($sub->service);
            $device = $sub->car->device;
            $service = $sub->service;
            $count = floor(rand(1, 5) * 24 * 60 / $adjusted_interval);
            $when = Carbon::now();
            for ($i=0; $i < $count; $i++) {
                $when = $when->copy()->subMinutes($adjusted_interval);

                $value = rand(0, 1) == 1;
                if ($service->type == Service::$TYPE_ANALOG) {
                    $value = rand(1, 5) / 10;
                }

                $device->logs()->create([
                    'service_id' => $service->id,
                    'value' => $value,
                    'when' => $when,
                ]);
            }
        });
    }

    public function getRandomInterval($service)
    {
        $status = collect([
            Service::$STATUS_GOOD,
            Service::$STATUS_MEDIUM,
            Service::$STATUS_POOR,
        ]);
        $seed = rand(1, 10);
        $flag = $seed == 10 ? $status->get(2) : ($seed > 6 ? $status->get(1) : $status->get(0));

        switch ($flag) {
            case Service::$STATUS_GOOD:
                return floor($service->interval / (rand(7, 10) / 10));
            case Service::$STATUS_MEDIUM:
                return floor($service->interval / (rand(3, 6) / 10));
            case Service::$STATUS_POOR:
                return floor($service->interval / (rand(1, 2) / 10));

            default:
                return null;
        }
    }
}
