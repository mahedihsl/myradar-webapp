<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Microservice\ET200Microservice;

class ConcoxController extends Controller
{
    private $microservice;

    public function __construct()
    {
        $this->microservice = new ET200Microservice();
    }

    public function lock(Request $request)
    {
        $res = $this->microservice->lock(22235);
        return response()->json($res);
    }

    public function unlock(Request $request)
    {
        $res = $this->microservice->unlock(22235);
        return response()->json($res);
    }

    public function status(Request $request)
    {
        $res = $this->microservice->status(22235);
        return response()->json($res);
    }
}
