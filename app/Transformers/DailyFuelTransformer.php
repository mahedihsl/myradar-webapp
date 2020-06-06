<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\DailyFuel;

/**
 * Class DailyFuelTransformer
 * @package namespace App\Transformers;
 */
class DailyFuelTransformer extends TransformerAbstract
{

    /**
     * Transform the DailyFuel entity
     * @param App\Entities\DailyFuel $model
     *
     * @return array
     */
    public function transform(DailyFuel $model)
    {
        return [
            'id' => $model->id,
            'value' => $model->value,
            'when' => $model->when->format('j M'),
        ];
    }
}
