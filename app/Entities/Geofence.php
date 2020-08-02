<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Geofence extends Eloquent implements Transformable
{
    use TransformableTrait;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
