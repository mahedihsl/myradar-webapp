<?php

namespace App\Service\Microservice;

class GeofenceMicroservice extends BaseService
{
  const SERVICE_NAME = 'geofence';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function observe($car_id, $lat, $lng)
  {
    return $this->post('/observe', compact('car_id', 'lat', 'lng'));
  }
}
