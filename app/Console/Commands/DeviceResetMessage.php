<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Entities\Device;
use App\Service\SmsService;
use App\Contract\Repositories\DeviceRepository;

class DeviceResetMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'device:reset';
    private $service;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send sms to device for reset if last pulse came more than an hour ago ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->service = new SmsService();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      try {
        $deviceList = $this->getDeviceList();
        $content = 'DEVICE_RESET';
        foreach ($deviceList as $key => $device) {
            $this->service->send($device->phone, $content, 'dev_reset');
        }
      } catch (\Exception $e) {
        
      }
    }

    public function getDeviceList()
    {
      $last_time = Carbon::now()->subMinutes(720);
      $last_month = Carbon::now()->subDays(30);
      return Device::where('last_pulse', '>', $last_month)
	  		->where('last_pulse', '<=', $last_time)
              ->where('version', '>=', '3.7.5')
              ->whereNotNull('car_id')
              ->whereNotNull('user_id')
              ->get();
    }
}
