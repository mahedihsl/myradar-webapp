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
  
  public function carsOfUser($user_id, $type)
  {
    return $this->get('/car/of-user', compact('user_id', 'type'));
  }
}
