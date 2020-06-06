<?php

namespace App\Listeners;

use App\Events\PaymentReceived;
use App\Service\SmsService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPaymentAcknowledgeSms
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
     * @param  PaymentReceived  $event
     * @return void
     */
    public function handle(PaymentReceived $event)
    {
        $service = new SmsService();
        $service->send($event->payment->user->phone, $event->body(), 'payment_ack');
    }
}
