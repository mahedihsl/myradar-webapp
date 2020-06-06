<?php

namespace App\Listeners;

use App\Events\AcStateChanged;
use App\Jobs\PushNotificationJob;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendAcPush
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
     * @param  AcStateChanged  $event
     * @return void
     */
    public function handle(AcStateChanged $event)
    {
        $data = collect([
            'title' => $event->title(),
            'body' => $event->body(),
        ]);

        dispatch(new PushNotificationJob($event->device->user_id, $data));
    }
}
