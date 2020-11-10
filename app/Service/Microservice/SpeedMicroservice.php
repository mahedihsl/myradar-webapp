<?php

namespace App\Service\Microservice;

class SpeedMicroservice extends BaseService
{
  const SERVICE_NAME = 'speed';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function observe($car_id, $speed)
  {
    return $this->post('/observe', compact('car_id', 'speed'));
  }

}
