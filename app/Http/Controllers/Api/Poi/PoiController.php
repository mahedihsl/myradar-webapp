<?php

namespace App\Http\Controllers\Api\Poi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\PoiRepository;
use App\Criteria\LastUpdatedCriteria;

class PoiController extends Controller
{
    /**
     * @var PoiRepository
     */
    private $repository;

    public function __construct(PoiRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $items = $this->repository->paginate(1000);
        if (count($items['data']) == 0) {
            return response()->ok([
                'data' => [],
                'time' => $this->lastUpdatedTime(),
            ]);
        }

        return response()->ok($items);
    }

    public function check(Request $request)
    {
        try {
            $lastTime = intval($request->get('time'));
            return response()->ok($lastTime < $this->lastUpdatedTime());
        } catch (\Exception $e) {
            return response()->ok(false);
        }
    }

    private function lastUpdatedTime()
    {
        return $this->repository
                ->skipPresenter()
                    ->pushCriteria(new LastUpdatedCriteria())
                        ->first(['updated_at'])
                            ->updated_at
                                ->timestamp;
    }
}
