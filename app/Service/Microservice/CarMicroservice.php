<?php

namespace App\Service\Microservice;

class CarMicroservice extends BaseService
{
  const SERVICE_NAME = 'car';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function all()
  {
    return $this->get('/car/all');
  }
}
