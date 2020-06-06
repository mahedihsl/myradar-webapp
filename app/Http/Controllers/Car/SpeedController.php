<?php

namespace App\Http\Controllers\Car;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\CarRepository;

class SpeedController extends Controller
{
    /**
     * @var CarRepository
     */
    private $repository;

    public function __construct(CarRepository $repository)
    {
        $this->repository = $repository;
    }

    public function show(Request $request, $id)
    {
        $car = $this->repository->skipPresenter()->find($id);

        if ( ! is_null($car)) {
            return response()->ok($car->speed_limit);
        }

        return response()->error('Car Not Found');
    }

    public function update(Request $request)
    {
        $car = $this->repository->skipPresenter()->find($request->get('id'));

        if ( ! is_null($car)) {
            $car->update([
                'speed_limit' => [
                    'soft' => [
                        'value' => intval($request->get('soft_limit')),
                        'flag' => boolval($request->get('soft_flag')),
                    ],
                    'hard' => [
                        'value' => intval($request->get('hard_limit')),
                        'flag' => boolval($request->get('hard_flag')),
                    ]
                ]
            ]);

            return response()->ok();
        }

        return response()->error('Car Not Found');
    }

}
