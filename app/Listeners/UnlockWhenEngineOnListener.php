<?php

namespace App\Listeners;

use App\Events\UnlockWhenEngineOnEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Entities\Device;
use App\Service\ConcoxDevice;

class UnlockWhenEngineOnListener
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
     * @param  UnlockWhenEngineOnEvent  $event
     * @return void
     */
    public function handle(UnlockWhenEngineOnEvent $event)
    {
        $event->device->update([ 'lock_status' => Device::$STATUS_UNLOCKED ]);

        $concox = new ConcoxDevice();
        $concox->lock($event->device->com_id, false);
    }
}
