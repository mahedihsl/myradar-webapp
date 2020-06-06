<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Entities\User;
use App\Search\UserModelSearch;
use App\Criteria\UserEmailCriteria;
use App\Criteria\UserPhoneCriteria;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BaseSearchTest extends TestCase
{
    private $repo;

    public function __construct()
    {
        $this->repo = new UserModelSearch();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSearchResult()
    {
        $user = User::first();

        $this->repo->pushCriteria(new UserEmailCriteria($user->email));
        $this->repo->pushCriteria(new UserPhoneCriteria($user->phone));

        $res = $this->repo->search();

        $this->assertTrue($res->getCollection()->count() > 0, 'search result empty');
    }
}
