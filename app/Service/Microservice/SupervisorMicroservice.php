<?php

namespace App\Service\Microservice;

class SupervisorMicroservice extends BaseService
{
  const SERVICE_NAME = 'supervisor';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function trimData()
  {
    return $this->post('/api/trim-data');
  }
}
