<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Geofence;

/**
 * Class GeofenceTransformer
 * @package namespace App\Transformers;
 */
class GeofenceTransformer extends TransformerAbstract
{

    /**
     * Transform the \Geofence entity
     * @param \Geofence $model
     *
     * @return array
     */
    public function transform(Geofence $model)
    {
        return [
            'id'     => $model->id,
            'name'   => $model->name,
            'coordinates' => $model->vertices['coordinates'],
        ];
    }
}