<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Consumer\GasConsumer;
use App\Events\GasRefueled;
use App\Jobs\DemoUserDataJob;

class UpdateDemoCarGas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:gas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $device = (new DemoUserDataJob())->getDemoDevice();

        $model = $device->daily_gas()->where('when', Carbon::today())->first();
        if (is_null($model)) {
            $consumer = new GasConsumer(rand(10, 200));
            $consumer->consume($device);
            event(new GasRefueled($device, rand(2, 10) * 50));
        }
    }
}
