<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Entities\Recharge;
use App\Search\RechargeModelSearch;
use App\Criteria\RechargeRemainedCriteria;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RechargeSearchTest extends TestCase
{
    private $repo;

    public function __construct()
    {
        $this->repo = new RechargeModelSearch();
    }

    public function testBasicTest()
    {
        $this->assertTrue(true);
    }
    
    /**
     * test recharge search by only remaining volume
     *
     * @return void
     */
    // public function testRechargeSearchByRemainedVolume()
    // {
    //     $remained = 100;
    //     $actual = Recharge::where('remained', '<=', $remained)->count();
    //
    //     $this->repo->pushCriteria(new RechargeRemainedCriteria($remained));
    //     $result = $this->repo->search(false);
    //
    //     $this->assertTrue($actual > 0, $remained . ' MB remaining volume count is ZERO');
    //     $this->assertTrue($result->count() == $actual, 'Actual remaining count dont match search result count');
    // }
}
