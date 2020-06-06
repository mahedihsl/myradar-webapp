<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;
use App\Entities\Device;
use App\Contract\Repositories\DeviceRepository;
use App\Events\EngineStatusChanged;

class TurnOffEngine extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'engine:off {diff}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Turn off engine status after {diff} seconds';

    /**
     * @var DeviceRepository
     */
    private $devices;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(DeviceRepository $devices)
    {
        parent::__construct();

        $this->devices = $devices;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $offset = intval($this->argument('diff'));
        $last_time = Carbon::now()->subSeconds($offset);

        $deviceList = $this->getDeviceList($last_time);
        foreach ($deviceList as $dev) {
            event(new EngineStatusChanged($dev, 0, TRUE));
        }

        // $n = Device::where('engine_status', 1)
        //         ->where('last_pulse', '<', $last_time)
        //         ->whereNotNull('car_id')
        //         ->whereNotNull('user_id')
        //         ->update([
        //             'engine_status' => 0,
        //             'off_by' => 'server',
        //         ]);

        $res = Device::raw(function($collection) use ($offset) {
            $time = Carbon::now()->subSeconds($offset);
            $time = new \MongoDB\BSON\UTCDateTime($time->timestamp * 1000);

            return $collection->updateMany([
                '$and' => [
                    ['engine_status' => ['$eq' => 1]],
                    ['last_pulse' => ['$lt' => $time]],
                    ['car_id' => ['$ne' => null]],
                    ['user_id' => ['$ne' => null]],
                ]
            ], [
                '$set' => [
                    'engine_status' => 0,
                    'off_by' => 'server',
                ]
            ]);
        });
    }

    public function getDeviceList($last_time)
    {
        return Device::raw(function($collection) use ($last_time) {
            $time = new \MongoDB\BSON\UTCDateTime($last_time->timestamp * 1000);
            return $collection->find([
                '$and' => [
                    ['engine_status' => ['$eq' => 1]],
                    ['last_pulse' => ['$lt' => $time]],
                    ['car_id' => ['$ne' => null]],
                    ['user_id' => ['$ne' => null]],
                ]
            ], []);
        });
        // return Device::where('engine_status', 1)
        //         ->where('last_pulse', '<', $last_time)
        //         ->whereNotNull('car_id')
        //         ->whereNotNull('user_id')
        //         ->get();
    }

}
