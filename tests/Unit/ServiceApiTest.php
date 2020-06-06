<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Entities\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ServiceApiTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testServiceApiListGetWorks()
    {
        $this->actingAs(User::first())
            ->json('GET', '/services/api')
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id', 'name', 'type',
                ],
            ]);
    }
}
