<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Entities\Device;
use App\Entities\Health;

use App\Contract\Repositories\HealthRepository;

class HealthApiTest extends TestCase
{
    private $repository;

    public function setUp()
    {
        parent::setUp();

        $this->repository = $this->app->make(HealthRepository::class);
    }

    public function testHealthSaveApi()
    {
        $device = Device::first();
        $count = $this->repository->count();
        $message = 'Health Count not updated after health store api has been called';

        $this->repository->save($device, collect([
            'com_id' => $device->com_id,
            'count_loop' => 10,
            'time_setup' => 23,
            'time_avg_loop' => 21,
            'time_min_loop' => 56,
            'time_max_loop' => 66,
            'free_ram_min' => 39,
            'free_ram_max' => 93,
        ]));

        $this->assertEquals($count + 1, $this->repository->count(), $message);
    }
}
