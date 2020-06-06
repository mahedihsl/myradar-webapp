<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Entities\Car;
use App\Criteria\CarRegNoCriteria;
use App\Contract\Repositories\CarRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CarSearchTest extends TestCase
{
    private $repository;

    public function setUp()
    {
        parent::setUp();

        $this->repository = $this->app->make(CarRepository::class);
    }

    /**
     * test device search by registration number works
     *
     * @return void
     */
    public function testSearchByOnlyRegNo()
    {
        $dev = $this->repository->first();
        $criteria = new CarRegNoCriteria($dev->reg_no);

        $this->repository->skipPresenter();
        $this->repository->pushCriteria($criteria);

        $result = $this->repository->all();

        $this->assertTrue(get_class($result) == Collection::class, 'Search result dont return a collection');
        $this->assertTrue($result->count() == 1);
        $this->assertTrue(get_class($result->first()) == Car::class);
        $this->assertTrue($result->first()->reg_no == $dev->reg_no);
    }
}
