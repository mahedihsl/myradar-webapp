<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Position;
use App\Entities\User;
use App\Entities\Car;
use App\Entities\Device;
use App\Entities\ExecTime;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseTestController extends Controller
{
    public function jobs(Request $request)
    {
        $KEEP_COUNT = 5000;
        $count = DB::table('jobs')->count();

        $records = DB::table('jobs')->orderBy('_id', 'asc')->limit(2)->get();

        return [
            'a' => $count,
            'b' => $records,
        ];
    }

	public function remove(Request $request)
	{
		$n = User::count();

		return $n;
    }
    
    public function throttle(Request $request) {
        $time = Carbon::now()->subMinutes(1);
        $n = ExecTime::where('created_at', '>', $time)->count();
        return response()->json([
            'api_hit' => $n
        ]);
    }

    public function restore(Request $request)
    {
        // User::create([
        //     'name' => 'Admin',
        //     'email' => 'admin@myradar.com.bd',
        //     'password' => bcrypt('Pixel@123456'),
        //     'type' => 1,
        // ]);
        // User::create([
        //     'name' => 'Customer Care',
        //     'email' => 'cc@myradar.com.bd',
        //     'password' => bcrypt('cc@myradar2020'),
        //     'type' => 2,
        // ]);
        // User::create([
        //     'name' => 'Eng. & Ops',
        //     'email' => 'ops@myradar.com.bd',
        //     'password' => bcrypt('ops@myradar2020'),
        //     'type' => 3,
        // ]);
        // $data = $request->get('data');
        // for ($i=0; $i < count($data); $i++) {
        //     $doc = $data[$i];
        //     $phone = $doc['Phone'];
        //     $carno = $doc['Car No.'];
        //     $comid = $doc['Com. ID'];

            // $user = User::where('phone', $phone)->first();

            // $car = Car::where('reg_no', $carno)->first();
            // if (!$car) {
            //     $car = Car::create([
            //         'reg_no' => $carno,
            //         'user_id' => $user->id,
            //     ]);
            // }

            // if (!is_null($car) && $comid != 'N/A') {
            //     $device = Device::create([
            //         'com_id' => intval($comid),
            //         'car_id' => $car->id,
            //         'user_id' => $car->user->id,
            //     ]);
            // }
            // if (!$user) {
            //     $user = User::create([
            //         'name' => $doc['User'],
            //         'phone' => $phone,
            //         'password' => bcrypt($phone),
            //         'api_token' => str_random(60),
            //         'type' => 4,
            //         'customer_type' => 1,
            //         'enabled' => $doc['Enabled'] == 'Yes' ? 1 : 0,
            //         'status' => $doc['Status'] == 'Current' ? 1 : 0,
            //         'joined_at' => Carbon::createFromFormat('D, M j, Y g:i A', $doc['Date']),
            //     ]);
            // }
        // }
        return ['message' => 'Accounts Created'];
    }

    public function restore2(Request $request)
    {
        // $data = $request->get('data');
        // for ($i=0; $i < count($data); $i++) { 
        //     $doc = $data[$i];
        //     $phone = '0' . $doc['Mobile No'];
        //     $carno = $doc['Car No'];
        //     $comid = $doc['Com ID'];

        //     $user = User::where('phone', $phone)->first();
        //     if (!$user) {
        //         $user = User::create([
        //             'name' => $doc['Name'],
        //             'Phone' => $phone,
        //             'joined_at' => Carbon::createFromFormat("jS-F'y", $doc['Installation date line']),
        //             'password' => bcrypt($phone),
        //             'api_token' => str_random(60),
        //             'type' => 4,
        //             'customer_type' => 1,
        //             'enabled' => 1,
        //             'status' => 1,
        //         ]);
        //     }

        //     $car = Car::where('reg_no', $carno)->first();
        //     if (!$car) {
        //         $car = Car::create([
        //             'name' => $doc['Car Name'],
        //             'reg_no' => $carno,
        //             'user_id' => $user->id,
        //         ]);
        //     }

        //     $device = Device::create([
        //         'com_id' => $comid,
        //         'car_id' => $car->id,
        //         'user_id' => $user->id,
        //     ]);
        // }

        return 'ok';
    }
}
