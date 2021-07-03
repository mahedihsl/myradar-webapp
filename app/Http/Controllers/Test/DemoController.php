<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Microservice\DemoMicroservice;

class DemoController extends Controller
{
    private $microservice;

    public function __construct()
    {
        $this->microservice = new DemoMicroservice();
    }

    public function vessel(Request $request)
    {
        try {
            $index = $request->get('index');
            $res = $this->microservice->moveVessel($index);
            return response()->json($res);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
