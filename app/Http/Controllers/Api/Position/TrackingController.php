<?php

namespace App\Http\Controllers\Api\Position;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Contract\Repositories\PositionRepository;
use App\Criteria\DeviceIdCriteria;
use App\Criteria\AfterWhenCriteria;
use App\Criteria\RecentItemCriteria;
use App\Criteria\BeforeWhenCriteria;
use App\Presenters\PositionPresenter;

class TrackingController extends Controller
{
    /**
     * @var PositionRepository
     */
    private $repository;

    public function __construct(PositionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function last(Request $request, $id)
    {
        $position = $this->repository->lastPosition($id);
        if ( ! is_null($position)) {
            return response()->ok($position);
        }

        return response()->error('No Position Found');
    }

    public function history(Request $request)
    {
        $this->repository->setPresenter(PositionPresenter::class);

        $criteria = new DeviceIdCriteria($request->get('device_id'));
        $this->repository->pushCriteria($criteria);

        $from = null;
        $to = null;

        $this->repository->pushCriteria(new AfterWhenCriteria($from));
        $this->repository->pushCriteria(new BeforeWhenCriteria($to));

    }

}
