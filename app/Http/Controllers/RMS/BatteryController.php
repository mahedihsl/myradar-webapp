<?php

namespace App\Http\Controllers\RMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Microservice\RMSBatteryMicroservice;
use Exception;

class BatteryController extends Controller
{
    private $rmsBatteryService;

    public function __construct() {
      $this->rmsBatteryService = new RMSBatteryMicroservice();
    }

    public function recent(Request $request)
    {
      try {
        $response = $this->rmsBatteryService->recent($request->all());
        return response()->json($response);
      } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
      }
    }
}
