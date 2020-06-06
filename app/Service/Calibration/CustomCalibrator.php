<?php

namespace App\Service\Calibration;

use App\Entities\Device;
use App\Entities\GasCalibration;
use App\Entities\FuelCalibration;

use Illuminate\Support\Facades\Log;


class CustomCalibrator extends BaseCalibrator
{

    function __construct(Device $device)
    {
        parent::__construct($device);
    }

    public function fuel($value)
    {
        $data = FuelCalibration::where('device_id', $this->getDevice()->id)
                    ->orderBy('created_at', 'desc')
                        ->first()->data;

        $st = null;
        $en = null;
        foreach ($data as $key => $arr) {
            if ($value < $arr['value']) {
                $st = $arr;
                break;
            } else {
                $en = $arr;
            }
        }

        if (is_null($en)) return 100;
        if (is_null($st)) return 0;

        $delPerc = $en['perc'] - $st['perc'];
        $delVal = $st['value'] - $en['value'];
        $inter = ($delPerc / $delVal) * ($st['value'] - $value);

        return min(100, floor($st['perc'] + $inter));
    }

    public function newFuel($value)
    {
      $data = FuelCalibration::where('device_id', $this->getDevice()->id)
                  ->orderBy('created_at', 'desc')
                      ->first()->data;

      return $this->getPerc($data, $value);
    }

    public function getPerc($data, $value)
    {
      $last = null;
      $len = sizeof($data);

      for ($i=0; $i < $len; $i++) {
          if ($value <= $data[$i]['value']) {
              if (is_null($last)) {
                  return $data[$i]['perc'];
              }

              $frac = ($value - $last['value']) / ($data[$i]['value'] - $last['value']);
              return $last['perc'] + (($data[$i]['perc'] - $last['perc']) * $frac);
          }
          $last = $data[$i];
      }

      return $data[$len - 1]['perc'];
    }

    public function gas($value)
    {
        $data = GasCalibration::where('device_id', $this->getDevice()->id)
                    ->orderBy('created_at', 'desc')
                        ->first()->data;

        if ($this->isCngTypeB()) {
            $data = $data->reverse();
        }

        foreach ($data as $key => $arr) {
            if ($value < $arr['value']) {
                return $arr['level'];
            }
        }

        return $this->isCngTypeB() ? 4 : 0;
    }
}
