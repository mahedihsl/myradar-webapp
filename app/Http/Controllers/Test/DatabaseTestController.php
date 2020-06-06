<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Position;
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
		$n = Position::where('device_id', '5d00b7776237460eb949530d')
			->where('when', '>', Carbon::createFromDate(2019, 8, 15))
			->count();

		return $n;
    }
    
    public function throttle(Request $request) {
        $time = Carbon::now()->subMinutes(1);
        $n = ExecTime::where('created_at', '>', $time)->count();
        return response()->json([
            'api_hit' => $n
        ]);
    }
}
