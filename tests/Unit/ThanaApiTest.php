<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\District;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThanaApiTest extends TestCase
{
    /**
     * Thana list get api test
     *
     * @return void
     */
    public function testThanaListApi()
    {
        $district = District::first();

        $this->actingAs(User::first(), 'api')
            ->json('GET', '/api/thana/list/'.$district->id)
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => ['items', 'size'],
            ]);
    }
}
