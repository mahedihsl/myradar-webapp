<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\User;
use App\Entities\FenceLog;

class FenceLogApiTest extends TestCase
{
    public function getTestCustomer()
    {
        return User::where('type', User::$TYPE_CUSTOMER)->get()->random();
    }

    public function testFenceHistoryGetApi()
    {
        $customer = $this->getTestCustomer();
        $this->actingAs($customer, 'api')
            ->json('GET', '/api/fence/history')
            ->assertStatus(200)
            ->assertJson([
                'status' => 1,
            ])
            ->assertJsonStructure([
                'status',
                'data' => [
                    '*' => [
                        'id', 'name', 'selected',
                    ]
                ]
            ]);
    }

    public function getDeletableFenceId($customer)
    {
        $logs = FenceLog::where('user_id', $customer->id)->get();
        foreach ($logs as $log) {
            if ( ! isset($customer->fence_ids) || ! in_array($log->fence_id, $customer->fence_ids)) {
                return $log->fence->id;
            }
        }

        return null;
    }

    public function testFenceHistoryDeleteApi()
    {
        $customer = null;
        $fence_id = null;

        while (true) {
            $customer = $this->getTestCustomer();
            $fence_id = $this->getDeletableFenceId($customer);
            if ( ! is_null($fence_id)) {
                break;
            }
        }

        $this->actingAs($customer, 'api')
            ->json('POST', '/api/fence/delete', [
                'fence_id' => $fence_id,
            ])
            ->assertStatus(200)
            ->assertJson([
                'status' => 1
            ])
            ->assertJsonStructure([
                'status',
                'data' => ['message']
            ]);
    }
}
