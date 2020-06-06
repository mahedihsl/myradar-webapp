<?php

namespace App\Http\Controllers\Api\Car;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Criteria\ModeCriteria;
use App\Criteria\CarIdCriteria;
use App\Criteria\NRecordsCriteria;
use App\Criteria\EventTypeCriteria;
use App\Criteria\LastCreatedCriteria;
use App\Transformers\EventTransformer;
use App\Entities\Event;
use App\Entities\GasRefuelInput;

class EventController extends Controller
{
    public function events(Request $request, $car)
    {
        $options = [
            'sort' => ['created_at' => -1],
            'limit' => 100,
            'projection' => [
                'title' => true,
                'body' => true,
                'type' => true,
                'meta' => true,
                'created_at' => true,
            ],
        ];
        $onOff = Event::raw(function($collection) use ($car, $options) {
            return $collection->find([
                '$and' => [
                    ['car_id' => ['$eq' => $car]],
                    ['mode' => ['$eq' => Event::MODE_PUBLIC]],
                    ['type' => ['$in' => [Event::TYPE_ON, Event::TYPE_OFF]]],
                ]
            ], $options);
        });
        $gas = Event::raw(function($collection) use ($car, $options) {
            return $collection->find([
                '$and' => [
                    ['car_id' => ['$eq' => $car]],
                    ['mode' => ['$eq' => Event::MODE_PUBLIC]],
                    ['type' => ['$eq' => Event::TYPE_REFUEL]],
                ]
            ], $options);
        });
        $fuel = Event::raw(function($collection) use ($car, $options) {
            return $collection->find([
                '$and' => [
                    ['car_id' => ['$eq' => $car]],
                    ['mode' => ['$eq' => Event::MODE_PUBLIC]],
                    ['type' => ['$eq' => Event::TYPE_FUEL_REFUEL]],
                ]
            ], $options);
        });
        $event_ids = array_merge(
            $onOff->map(function($val) {return $val->id;})->toArray(),
            $gas->map(function($val) {return $val->id;})->toArray(),
            $fuel->map(function($val) {return $val->id;})->toArray()
        );
        $inputs = GasRefuelInput::raw(function($collection) use ($event_ids) {
            return $collection->find([
                'event_id' => ['$in' => $event_ids]
            ], [
                'projection' => [
                    'event_id' => true,
                ],
            ]);
        });
        $events = $onOff->merge($gas)->merge($fuel);
        $events = $events->map(function($model) use ($inputs) {
            $tr = new EventTransformer();
            $ret = $tr->transform($model);
            $ret['input'] = $inputs->contains(function($item) use ($ret) {
                return $item->event_id == $ret['id'];
            });
            return $ret;
        });
        return response()->ok([
            'items' => $events,
        ]);
    }
}
