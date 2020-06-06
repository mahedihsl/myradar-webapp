<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Contract\Repositories\PoiRepository;
use App\Entities\User;

use Carbon\Carbon;

class PoiApiTest extends TestCase
{
    private $repository;

    public function setUp()
    {
        parent::setUp();

        $this->repository = $this->app->make(PoiRepository::class);

    }

    public function testPoiListApi()
    {
        $this->actingAs(User::first(), 'api')
            ->json('GET', '/api/poi/list')
            ->assertStatus(200)
            ->assertJson([
                'status' => 1
            ])
            ->assertJsonStructure([
                'status',
                'data' => [
                    'data' => [
                        '*' => ['id', 'name', 'lat', 'lng']
                    ]
                ]
            ]);
    }

    public function testPoiCheckUpdateApi()
    {
        $time = Carbon::tomorrow()->timestamp;
        $this->actingAs(User::first(), 'api')
            ->json('GET', '/api/poi/check/update?time=' . $time)
            ->assertStatus(200)
            ->assertJson([
                'status' => 1,
                'data' => [
                    'message' => false,
                ]
            ]);

        $this->repository->skipPresenter()->first()->touch();

        $time = Carbon::yesterday()->timestamp;
        $this->actingAs(User::first(), 'api')
            ->json('GET', '/api/poi/check/update?time=' . $time)
            ->assertStatus(200)
            ->assertJson([
                'status' => 1,
                'data' => [
                    'message' => true,
                ]
            ]);
    }
}
