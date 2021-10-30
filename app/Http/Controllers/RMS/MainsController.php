<?php

namespace App\Http\Controllers\RMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Microservice\RMSMainsMicroservice;
use Exception;

class MainsController extends Controller
{
    private $rmsMainsService;

    public function __construct() {
      $this->rmsMainsService = new RMSMainsMicroservice();
    }

    public function offhours(Request $request)
    {
      try {
        $response = $this->rmsMainsService->offhours($request->all());
        return response()->json($response);
      } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
      }
    }
}
