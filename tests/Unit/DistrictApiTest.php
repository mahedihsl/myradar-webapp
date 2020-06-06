<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Entities\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DistrictApiTest extends TestCase
{
    /**
     * District list get api test
     *
     * @return void
     */
    public function testDistrictListApi()
    {
        $user = User::first();

        $this->actingAs($user, 'api')
            ->json('GET', '/api/district/list')
            ->assertStatus(200)
            ->assertJson([
                'status' => 1,
            ])
            ->assertJsonStructure([
                'status',
                'data' => ['items', 'size'],
            ]);
    }
}
