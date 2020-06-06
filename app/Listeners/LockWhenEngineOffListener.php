<?php

namespace App\Listeners;

use App\Events\LockWhenEngineOffEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Entities\Device;
use App\Service\PusherService;
use App\Service\ConcoxDevice;

class LockWhenEngineOffListener
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
     * @param  LockWhenEngineOffEvent  $event
     * @return void
     */
    public function handle(LockWhenEngineOffEvent $event)
    {
        $event->device->update([ 'lock_status' => Device::$STATUS_LOCKED ]);

        $concox = new ConcoxDevice();
        $concox->lock($event->device->com_id, true);

        $notify = new PusherService();
        $notify->onEngineOff($event->device);
    }
}
