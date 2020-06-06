<?php

namespace App\Consumer;

use App\Entities\Device;
use App\Entities\Position;
use App\Events\LatLngReceived;
use App\Contract\Repositories\PositionRepository;
use App\Consumer\DistanceConsumer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

/**
 * @class LatLngConsumer
 */
class LatLngConsumer extends ServiceConsumer
{
    /**
     * @var PositionRepository
     */
    private $repository;

    private $device;

    private $lastPos = null;
    private $lastMilPos = null;

    function __construct($data)
    {
        parent::__construct($data);

        $this->repository = resolve(PositionRepository::class);
    }

    protected function transform($data)
    {
        return collect(explode('|', $data))->map(function($item) {
            return collect(explode(',', $item))->map(function($d) {
                return floatval($d);
            });
        });
    }

    public function consume(Device $device)
    {
        $this->setDevice($device);

        $when = $this->getLastTime();
        $interval = $this->findInterval();

        $ret = collect();
        foreach ($this->getData() as $i => $value) {
            $time = Carbon::createFromTimestamp($when + $interval);
            $temp = $this->handleLatLng($value, $time);
            $when += $interval;
            if ( ! is_null($temp)) {
                $ret->push($temp);
            }
        }

        return $ret;
    }

    public function handleLatLng(Collection $latlng, $when)
    {
        $lat = $latlng->get(0);
        $lng = $latlng->get(1);

        if ($lat == 0 || $lng == 0) {
            return null;
	}


        //$lastPos = $this->getLastPos();
        $lastMilPos = $this->getLastMilPos();

        $position = $this->repository->save($this->getDevice(), $lat, $lng, $when);
        if ( ! is_null($position)) {
            event(new LatLngReceived($this->getDevice(), $position));

            if ( ! is_null($lastMilPos)) {
                $speed = $lastMilPos->speed($position);
                $threshold = config('car.mileage.position.diff');
                if ($speed < 200) {
                    $dist = $lastMilPos->distance($position);
                    if($dist > $threshold){
                      $consumer = new DistanceConsumer($dist);
                      $consumer->consume($this->getDevice());
                    }
                }
            }

            $this->setLastPos($position);
            $this->setLastMilPos($position);
        }
 
        return $position;
    }

    public function findInterval()
    {
        return floor((time() - $this->getLastTime()) / $this->getData()->count());
    }

    public function getLastTime()
    {
        $lastPos = $this->getLastPos();

        if (is_null($lastPos)) {
            return time();
        }

        $ret = $lastPos->when->timestamp;

        $lastStart = $this->getDevice()->last_start;
        if ( ! is_null($lastStart)) {
            $ret = max($ret, $lastStart->timestamp);
        }

        return $ret;
    }

    public function getDevice()
    {
        return $this->device;
    }

    public function setDevice($device)
    {
        return $this->device = $device;
    }

    public function getLastPos()
    {
        if ( ! is_null($this->lastPos)) {
            return $this->lastPos;
        }

        // $this->lastPos = $this->getDevice()
        //                 ->positions()
        //                     ->orderBy('_id', 'desc')
        //                         ->take(1)
        //                             ->first();

        $arr = $this->getDevice()->meta->get('pos');

        if($arr == null){
          $this->lastPos = null;
          return $this->lastPos;
        }

        $this->lastPos = Position::make([
            '_id' => $arr['id'],
            'lat' => $arr['lat'],
            'lng' => $arr['lng'],
            'when' => Carbon::createFromTimestamp($arr['time']),
            'device_id' => $this->getDevice()->id,
        ]);

        return $this->lastPos;
    }

    public function getLastMilPos()
    {
        if ( ! is_null($this->lastMilPos)) {
            return $this->lastMilPos;
        }

        // $this->lastPos = $this->getDevice()
        //                 ->positions()
        //                     ->orderBy('_id', 'desc')
        //                         ->take(1)
        //                             ->first();

        $arr = $this->getDevice()->meta->get('mil_pos');

        if($arr == null){
          $this->lastMilPos = $this->getLastPos();
          return $this->lastMilPos;
        }

        $this->lastMilPos = Position::make([
            '_id' => $arr['id'],
            'lat' => $arr['lat'],
            'lng' => $arr['lng'],
            'when' => Carbon::createFromTimestamp($arr['time']),
            'device_id' => $this->getDevice()->id,
        ]);

        return $this->lastMilPos;
    }

    public function setLastPos($pos)
    {
        $this->lastPos = $pos;
    }

    public function setLastMilPos($pos)
    {
      $lastMilPos = $this->getLastMilPos();
      if(!is_null($lastMilPos)){
        $speed = $lastMilPos->speed($pos);
        $thresold = config('car.mileage.position.diff');
        if ($speed < 200) {
            $dist = $lastMilPos->distance($pos);
            if($dist > $thresold){
              $this->lastMilPos = $pos;
            }
        }
      }

    }
    public function count()
    {
        return $this->getData()->count();
    }
}
