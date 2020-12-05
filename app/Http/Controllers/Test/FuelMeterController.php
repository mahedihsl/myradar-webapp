<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Entities\Device;
use App\Http\Controllers\Controller;
use App\Service\Calibration\CustomCalibrator;

class FuelMeterController extends Controller
{
    public function test(Request $request)
    {
        $comId = 39114;
        $device = Device::where('com_id', $comId)->first();
        $calibrator = new CustomCalibrator($device);
        return response()->json([
            'value' => $calibrator->fuelPercentage(272),
            // 'value' => $calibrator->getTerminalFuelValues(105)
            // 'value' => $calibrator->lastFuelCalibrationData()
        ]);
    }
}
