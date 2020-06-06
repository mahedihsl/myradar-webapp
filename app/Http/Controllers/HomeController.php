<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Entities\Car;
use App\Entities\User;
use App\Entities\Device;
use App\Entities\Position;
use App\Contract\Repositories\UserRepository;
use App\Jobs\PushNotificationJob;
use App\Service\Refuel\DetectGasRefuel;
use App\Criteria\CarIdCriteria;
use App\Http\Controllers\Customer\PositionHistoryController;
use App\Util\Test;
use App\Util\Balance;
use App\Consumer\EngineStatusConsumer;
use Davibennun\LaravelPushNotification\Facades\PushNotification;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = $this->getWebUser();
        if($user->type==User::$TYPE_CUSTOMER && $user->customer_type==User::$CUSTOMER_ENTERPRISE)
         {
           return view('home.enterprise');

         }
        switch ($user->type) {
            case User::$TYPE_ADMIN:
                return view('home.admin');
            case User::$TYPE_AGENT:
                return view('home.agent');
            case User::$TYPE_GOVT:
                return view('home.govt');
            case User::$TYPE_OPERATION:
                return view('home.operation');
            case User::$TYPE_CALIBRATION:
                return view('home.calibration');
            case User::$TYPE_CUSTOMER:
                return view('home.customer')->with([
                    'id'=>Auth::user()->id
                ]);
        }
    }

    public function privacy(Request $request)
    {
        return view('misc.privacy');
    }

    public function test(Request $request)
    {
        $start = microtime(true);
        // $id = '5abb3c5089232c0c2747fb00';
        $id = '5aeeb8b93264d350aa2ca8e2';
        $device = Device::find($id);
        $consumer = new EngineStatusConsumer('1');
        $consumer->consume($device);
        $test = new Test();
        $status = $test->test($device);
        $end = microtime(true);
        return ['time' => $end - $start, 'data' => $status];

        // return [
        //     'user' => resolve(UserRepository::class)
        //             ->scopeQuery(function($query) {
        //                 return $query->where('email', 'demo@myradar.com.bd');
        //             })
        //             ->first()
        // ];

        // Md Babul data
        // $data = [471,473,471,471,470,471,456,450,436,436,433,424,427,396,448,427,75,76];
        // $data = [473,471,471,470,471,456,450,436,436,433,424,427,396,448,427,75,76,75];
        // $data = [471,471,470,471,456,450,436,436,433,424,427,396,448,427,75,76,75,76];
        // $data = [471,470,471,456,450,436,436,433,424,427,396,448,427,75,76,75,76,76];
        // $data = [470,471,456,450,436,436,433,424,427,396,448,427,75,76,75,76,76,77];
        // $data = [456,450,436,436,433,424,427,396,448,427,75,76,75,76,76,77,76,77];
        // $data = [450,436,436,433,424,427,396,448,427,75,76,75,76,76,77,76,77,76];
        // END

        // Shahnewaz Arefeen Data
        $data = [144,148,147,148,149,146,150,150,151,146,150,149,150,151,146,150,151,151];
        $service = new DetectGasRefuel();
        $service->setType(Car::CNG_TYPE_A);
        return $service->check(collect($data));
    }

}
