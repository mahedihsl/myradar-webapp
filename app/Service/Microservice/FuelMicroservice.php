<?php

namespace App\Service\Microservice;

class FuelMicroservice extends BaseService
{
  const SERVICE_NAME = 'fuel';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function latest($device_id = null, $car_id = null)
  {
    return $this->get('/fuel/latest', compact('device_id', 'car_id'));
  } 
}
