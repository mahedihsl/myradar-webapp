<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\Thana;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FenceApiTest extends TestCase
{
    public function testFenceListApi()
    {
        $thana = Thana::first();

        $this->actingAs(User::first(), 'api')
            ->json('GET', '/api/fence/list/'.$thana->id)
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => ['items', 'size']
            ]);
    }

    public function testFenceSaveApi()
    {
        $this->actingAs(User::first(), 'api')
            ->json('POST', '/api/fence/save', [
                'name' => 'New Fence #10',
                'lat' => 40.44,
                'lng' => 90.99,
                'radius' => 100,
            ])
            ->assertStatus(200)
            ->assertJson([
                'status' => 1,
            ])
            ->assertJsonStructure([
                'status',
                'data' => [
                    'attached', 'message'
                ]
            ]);
    }
}
