<?php

namespace App\Listeners;

use App\Events\AcStatusChanged;
use App\Jobs\PushNotificationJob;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAcStatus
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
     * @param  AcStatusChanged  $event
     * @return void
     */
    public function handle(AcStatusChanged $event)
    {
        $data = collect([
            'title' => $event->title(),
            'body' => $event->body(),
        ]);
        
        dispatch(new PushNotificationJob($event->device->user_id, $data));
    }
}
