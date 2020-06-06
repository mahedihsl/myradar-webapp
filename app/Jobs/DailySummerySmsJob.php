<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Entities\Car;
use App\Service\SmsService;
use App\Service\Sms\DailySummerySms;
use Carbon\Carbon;

class DailySummerySmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $car;
    private $date;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($car_id)
    {
        $this->car = Car::find($car_id);
        $this->date = Carbon::yesterday();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $service = new SmsService();
        $sms = new DailySummerySms($this->car, $this->date);

        $service->send($this->car->user->phone, $sms->content(), 'pack1');
    }
}
