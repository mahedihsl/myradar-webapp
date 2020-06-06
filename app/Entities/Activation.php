<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Carbon\Carbon;

/**
 * Class Activation.
 *
 * @package namespace App\Entities;
 */
class Activation extends Eloquent implements Transformable
{
    use TransformableTrait;

    protected $guarded = [];

    public function getKeyAttribute()
    {
        return $this->code . '-' . sprintf("%'.03d", $this->serial);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function totalBill()
    {
        // $today = Carbon::today();
        // $thatday = $this->created_at;
        // $months = 0;
        // while ($today->year != $thatday->year || $today->month != $thatday->month) {
        //     $months++;
        //     $today = $today->copy()->subMonths(1);
        // }
        $months = $this->created_at->diffInMonths(Carbon::today());
        return $months * $this->car->bill;
    }

    public function totalPaid()
    {
        return $this->car->payments()->sum('amount');
    }

    public function totalWaive()
    {
        return $this->car->payments()->sum('waive');
    }

}
