<?php

namespace Tests\Unit;

use App\Entities\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CustomerApiTest extends TestCase
{
    public function testCustomerListGet()
    {
        $this->actingAs(User::first())
            ->json('GET', '/customers/api')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [ 'id', 'name' ,'count', ],
                ]
            ]);
    }

    public function testCustomerTypesGet()
    {
        $this->actingAs(User::first())
            ->json('GET', '/customer/types/api')
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [ 'id', 'name' ]
            ]);
    }
}
