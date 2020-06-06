<?php

namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\DailyFuelRepository;
use App\Criteria\DeviceIdCriteria;
use App\Criteria\NRecordsCriteria;
use App\Criteria\ExactDateCriteria;
use App\Criteria\DateRangeCriteria;
use App\Criteria\AfterWhenCriteria;
use App\Criteria\BeforeWhenCriteria;
use App\Criteria\LastUpdatedCriteria;
use App\Presenters\DailyFuelPresenter;
use Carbon\Carbon;

class FuelController extends Controller
{
    /**
     * @var DailyFuelRepository
     */
    private $dailyRepo;

    public function __construct(DailyFuelRepository $dailyRepo)
    {
        $this->dailyRepo = $dailyRepo;
    }

    public function latest(Request $request, $id)
    {
        $this->dailyRepo->setPresenter(DailyFuelPresenter::class);
        $this->dailyRepo->pushCriteria(new DeviceIdCriteria($id));
        $this->dailyRepo->pushCriteria(new LastUpdatedCriteria());

        $item = $this->dailyRepo->skipPresenter()->first();
        if ( ! is_null($item)) {
            return response()->ok($item->presenter());
        }

        return response()->ok(['value' => 0]);
    }

    /**
     * Api for Web & Mobile client
     * @param  Request $request [description]
     * @param  string  $id      device id
     * @param  integer $day     number of days
     * @return array            [description]
     */
    public function history(Request $request, $id, $day)
    {
        $this->dailyRepo->pushCriteria(new DeviceIdCriteria($id));
        $this->dailyRepo->pushCriteria(new BeforeWhenCriteria(Carbon::today()));

        return response()->ok([
            'items' => $this->filterFuelValues($day, Carbon::yesterday())
        ]);
    }

    /**
     * Api for Mobile client
     * @param  Request $request [description]
     * @param  string  $id      device id
     * @return array            [description]
     */
    public function archive(Request $request, $id)
    {
        $from = Carbon::createFromFormat('Y-n-j', $request->get('from'));
        $to = Carbon::createFromFormat('Y-n-j', $request->get('to'));

        $day = $from->diffInDays($to) + 1;
        $from->setTime(0, 0, 0);
        $to->setTime(0, 0, 0);

        $this->dailyRepo->pushCriteria(new DeviceIdCriteria($id));
        $this->dailyRepo->pushCriteria(new BeforeWhenCriteria($to->copy()->addDay()));
        $this->dailyRepo->pushCriteria(new AfterWhenCriteria($from->copy()->subDay()));

        return response()->ok([
            'items' => $this->filterFuelValues($day, $to)
        ]);
    }

    public function filterFuelValues($day, $from)
    {
        $this->dailyRepo->setPresenter(DailyFuelPresenter::class);

        $this->dailyRepo->pushCriteria(new LastUpdatedCriteria());
        $this->dailyRepo->pushCriteria(new NRecordsCriteria($day));

        $items = $this->dailyRepo->skipPresenter()->all();
        for ($i = 0; $i < $day && $i < $items->count(); $i++) {
            $model = $items->get($i);
            $date = $from->copy()->subDays($i);

            if ( ! $model->when->eq($date)) {
                $temp = $model->presenter()['data'];
                $temp['when'] = $date->format('j M');
                $items->splice($i, 0, [$temp]);
            }
        }

        return $items->take($day)->map(function($item) {
            return is_array($item) ? $item : $item->presenter()['data'];
        });
    }

}
