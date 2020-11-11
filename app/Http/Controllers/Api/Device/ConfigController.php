<?php

namespace App\Http\Controllers\Api\Device;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Service\Microservice\DeviceMicroservice;

class ConfigController extends Controller
{
  /**
   * @var DeviceMicroservice
   */
  private $service;

  public function __construct() {
    $this->service = new DeviceMicroservice();
  }

  public function fetch(Request $request)
  {
    try {
      $device_id = $request->get('device_id');
      return response()->json($this->service->deviceConfig($device_id));
    } catch (\Exception $th) {
      return response()->json(['message' => $th->getMessage()]);
    }
  }
}