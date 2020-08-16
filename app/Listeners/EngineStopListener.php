<?php

namespace App\Listeners;

use App\Events\EngineStopEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Jobs\PushNotificationJob;
use App\Service\Microservice\PushMicroservice;
use App\Service\NotificationService;
use Carbon\Carbon;

class EngineStopListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  EngineStopEvent  $event
     * @return void
     */
    public function handle(EngineStopEvent $event)
    {
        $settings = $event->device->user->settings;

        if (is_null($settings) || $settings->noti_engine) {

            $data = collect([
                'title' => 'Alert for car: ' . $event->device->car->reg_no,
                'body' => 'Your car was OFF at ' . Carbon::now()->format('g:i A'),
                'status' => $event->device->engine_status,
                'type' => NotificationService::$TYPE_ENGINE,
            ]);

            $service = new PushMicroservice();
            $service->send($event->device->user_id, $data);
        }
    }
}
