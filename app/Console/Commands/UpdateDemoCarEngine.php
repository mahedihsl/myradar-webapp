<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\DemoUserDataJob;
use App\Consumer\EngineStatusConsumer;

class UpdateDemoCarEngine extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:engine';

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

        $status = ($device->engine_status + 1) % 2;
        $consumer = new EngineStatusConsumer($status);
        $consumer->consume($device);

        if ($status) {
            dispatch(new DemoUserDataJob());
        }
    }
}
