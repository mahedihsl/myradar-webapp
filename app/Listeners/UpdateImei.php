<?php

namespace App\Listeners;

use App\Events\DeviceHealthReceived;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateImei
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
     * @param  DeviceHealthReceived  $event
     * @return void
     */
    public function handle(DeviceHealthReceived $event)
    {
        if ($event->hasImei() && $event->device->imei != $event->getImei()) {
            $event->device->update([ 'imei' => $event->getImei() ]);
        }
    }
}
