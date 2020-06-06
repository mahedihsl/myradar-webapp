<?php

namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Log\ServiceLog;

class ServiceLogController extends Controller
{
    public function history(Request $request, $car, $service)
    {
        $service = new ServiceLog($car, $service);
        return response()->ok($service->get());
    }
}
