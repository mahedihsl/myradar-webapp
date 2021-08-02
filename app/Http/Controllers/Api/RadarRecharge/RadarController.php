<?php

namespace App\Http\Controllers\Api\RadarRecharge;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Microservice\RadarRechargeMicroservice;

class RadarController extends Controller
{
    private $radarService;

    public function __construct()
    {
        $this->radarService = new RadarRechargeMicroservice();
    }

    public function signup(Request $request)
    {
        try {
            return response()->json($this->radarService->signup($request->all()));
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
