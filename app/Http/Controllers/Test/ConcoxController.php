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
        $comId = 59113;
        $res = $this->microservice->lock($comId);
        return response()->json($res);
    }

    public function unlock(Request $request)
    {
        $comId = 59113;
        $res = $this->microservice->unlock($comId);
        return response()->json($res);
    }

    public function status(Request $request)
    {
        $res = $this->microservice->status($request->get('device'));
        return response()->json($res);
    }
}
