<?php

namespace App\Http\Controllers\RMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Microservice\RMSDoorMicroservice;
use Exception;

class DoorController extends Controller
{
    private $rmsDoorService;

    public function __construct() {
      $this->rmsDoorService = new RMSDoorMicroservice();
    }

    public function openhours(Request $request)
    {
      try {
        $response = $this->rmsDoorService->openhours($request->all());
        return response()->json($response);
      } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
      }
    }
}
