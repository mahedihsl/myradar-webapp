<?php

namespace App\Listeners;

use App\Events\PanicStateTriggered;
use App\Jobs\PushNotificationJob;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPanicPush
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
     * @param  PanicStateTriggered  $event
     * @return void
     */
    public function handle(PanicStateTriggered $event)
    {
        if ( ! $event->deliverable()) return;
        
        $data = collect([
            'title' => $event->title(),
            'body' => $event->body(),
        ]);

        dispatch(new PushNotificationJob($event->device->user_id, $data));
    }
}
