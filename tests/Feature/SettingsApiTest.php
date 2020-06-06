<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SettingsApiTest extends TestCase
{
    public function testSettingsStatusApi()
    {
        $user = App\Entities\User::first();
        $this->actingUser($user)
            ->json('GET', '/api/settings/status')
            ->assertStatus(200)
            ->assertJson([ 'status' => 1 ]);
    }

    public function testSettingsToggleApi()
    {
        $user = App\Entities\User::first();
        $this->actingAs($user)
            ->json('POST', '/api/settings/toggle', [
                'noti_geofence' => 0,
            ])
            ->assertStatus(200)
            ->assertJson([ 'status' => 1 ]);
    }
}
