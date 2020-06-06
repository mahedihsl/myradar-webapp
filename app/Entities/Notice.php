<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Notice.
 *
 * @package namespace App\Entities;
 */
class Notice extends Eloquent implements Transformable
{
    use TransformableTrait;

    protected $guarded = [];

}
