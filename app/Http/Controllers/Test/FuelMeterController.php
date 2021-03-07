<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Entities\Device;
use App\Entities\FuelHistory;
use App\Http\Controllers\Controller;
use App\Service\Refuel\DetectFuelRefuel;
use Carbon\Carbon;

class FuelMeterController extends Controller
{
    public function test(Request $request)
    {
        $service = new DetectFuelRefuel();
        return response()->json([
            'value' => $service->check(collect($request->get('values'))),
        ]);
    }
}
