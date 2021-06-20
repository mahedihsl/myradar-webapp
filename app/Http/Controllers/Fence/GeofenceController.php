<?php

namespace App\Http\Controllers\Fence;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Microservice\GeofenceMicroservice;

class GeofenceController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new GeofenceMicroservice();
    }

    public function save(Request $request)
    {
        try {
            return response()->json($this->service->saveGeofence($request->all()));
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
