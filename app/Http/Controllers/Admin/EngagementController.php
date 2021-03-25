<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\UserRepository;
use App\Criteria\WithTypeCriteria;
use App\Criteria\UserNameCriteria;
use App\Criteria\PhoneNumberCriteria;
use App\Presenters\UserActivityPresenter;
use App\Entities\User;
use App\Entities\Activity;
use Carbon\Carbon;
use Excel;

class EngagementController extends Controller
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
        $this->repository->pushCriteria(new WithTypeCriteria(User::$TYPE_CUSTOMER));
    }

    public function index(Request $request)
    {
        $name = $request->get('name', '');
        $phone = $request->get('phone', '');

        $this->repository->pushCriteria(new UserNameCriteria($name));
        $this->repository->pushCriteria(new PhoneNumberCriteria($phone));

        $records = $this->repository->paginate(20);
        return view('report.engagement')->with([
            'items' => $records,
            'params' => collect([
                'name' => $name,
                'phone' => $phone,
            ])
        ]);
    }

    public function login(Request $request, $id)
    {
        $user = User::find($id);

        if ( ! is_null($user)) {
            $data = $user->getLatestActivity();
            return response()->ok([
                $data[0]['l'],
                $data[1]['l'],
                $data[2]['l'],
            ]);
        }

        return response()->error();
    }

    public function request(Request $request, $id)
    {
        $user = User::find($id);

        if ( ! is_null($user)) {
            $data = $user->getLatestActivity();
            return response()->ok([
                $data[0]['r'],
                $data[1]['r'],
                $data[2]['r'],
                $data[3]['r'],
                $data[4]['r'],
                $data[5]['r'],
                $data[6]['r'],
            ]);
        }

        return response()->error();
    }

    public function export(Request $request)
    {
        $data = $this->records($this->repository->all(['name', 'phone']));
        Excel::create('CustomerEngagement', function ($excel) use ($data) {
            $excel->sheet('data', function ($sheet) use ($data) {
                $sheet->fromArray($data->toArray(), null, 'A1', false, true);
            });
        })->download('xls');

        return redirect()->back();
    }

    private function records($users)
    {
		$uids = $users->map(function($u) { return $u->id; })->toArray();
		$activities = Activity::whereIn('user_id', $uids)
			->where('when', '>', Carbon::today()->subDays(30))
			->get()
			->groupBy(function ($val) {
				return $val->user_id;
			});

        return $users->map(function ($user) use ($activities) {
            $data = collect($activities->get($user->id));
            $ret = [
                'Name' => $user->name,
                // 'Phone' => $user->phone,
                'Cars' => 0, // $user->cars()->count()
            ];

			for ($i=0; $i < 30; $i++) {
				$dt = Carbon::today()->subDays($i);
				$itm = $data->first(function($val, $key) use ($dt) {
					return $val->when->equalTo($dt);
				});

				$xx = 0;
				$yy = 0;
				if ( ! is_null($itm)) {
					$xx = $itm->request;
					$yy = $itm->login;
				}

				$str = $dt->format('j M');
				$arr = [
					$str.'(API)' => $xx,
					// $str.'(OPEN)' => $yy,
				];

				$ret = array_merge($ret, $arr);
			}
            return $ret;
        });
    }

	public function test() {

	}
}
