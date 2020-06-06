<?php

namespace App\Listeners;

use App\Events\AccountStatusChanged;
use App\Jobs\PushNotificationJob;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendAccountStatusNoti
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
     * @param  AccountStatusChanged  $event
     * @return void
     */
    public function handle(AccountStatusChanged $event)
    {
        if ( ! $event->user->isEnabled()) {
            $data = collect([
                'title' => $event->title(),
                'body' => $event->body(),
            ]);

            dispatch(new PushNotificationJob($event->user->id, $data));
        }
    }
}
