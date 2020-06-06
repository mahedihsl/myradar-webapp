<?php

namespace Tests\Unit;

use Tests\TestCase;
use Carbon\Carbon;
use App\Entities\Service;
use App\Entities\Device;
use App\Entities\Subscription;
use App\Entities\ServiceLog;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ServiceHealthTest extends TestCase
{
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }
    
    // public function testServiceHealthCheckWorks()
    // {
    //     $subs = Subscription::first();
    //     $device = $subs->car->device;
    //     $service = $subs->service;
    //
    //     $log_count = $device->logs()
    //         ->where('service_id', $service->id)
    //             ->where('when', '>', Carbon::now()->subHours(24))
    //                 ->count();
    //
    //     $this->assertTrue($log_count > 0, 'Last 24 hours log count is ZERO');
    //
    //     $real_health = $log_count / (24 * 60 / $service->interval);
    //     $flag_health = Service::$STATUS_POOR;
    //
    //     if ($real_health >= Device::$GOOD_FREQ_RATIO) {
    //         $flag_health = Service::$STATUS_GOOD;
    //     } else if ($real_health >= Device::$MEDIUM_FREQ_RATIO) {
    //         $flag_health = Service::$STATUS_MEDIUM;
    //     }
    //
    //     $flag_health2 = $device->getServiceStatus($service);
    //
    //     $this->assertTrue($flag_health2 == $flag_health, 'Actual service status doesnt match calculated status');
    // }
}
