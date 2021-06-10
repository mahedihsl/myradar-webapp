<?php

namespace App\Http\Controllers\Api\Position;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Contract\Repositories\PositionRepository;
use App\Service\Microservice\LocationMicroservice;
use App\Service\Microservice\ServiceException;

class TrackingController extends Controller
{
    /**
     * @var PositionRepository
     */
    private $repository;
    private $locationService;

    public function __construct(PositionRepository $repository)
    {
        $this->repository = $repository;
        $this->locationService = new LocationMicroservice();
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
        try {
            $device_id = $request->get('device_id');
            $from = $request->get('from');
            $to = $request->get('to');

            $result = $this->locationService->history($device_id, $from, $to);
            return response()->json($result);
        } catch (ServiceException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

}
