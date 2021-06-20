<?php

namespace App\Http\Controllers\Api\Poi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Microservice\StoppageMicroservice;

class StoppageController extends Controller {
  private $service;

  public function __construct() {
    $this->service = new StoppageMicroservice();
  }

  public function list(Request $request)
  {
    try {
      return response()->json($this->service->list($request->all()));
    } catch (\Exception $e) {
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }
  
  public function save(Request $request)
  {
    try {
      return response()->json($this->service->save($request->all()));
    } catch (\Exception $e) {
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }
  
  public function update(Request $request)
  {
    try {
      return response()->json($this->service->update($request->all()));
    } catch (\Exception $e) {
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }
  
  public function remove(Request $request)
  {
    try {
      $stoppageId = $request->get('id');
      $result = $this->service->remove($stoppageId);
      return response()->json($result);
    } catch (\Exception $e) {
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }
}