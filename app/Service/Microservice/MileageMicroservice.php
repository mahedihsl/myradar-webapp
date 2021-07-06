<?php

namespace App\Service\Microservice;

class MileageMicroservice extends BaseService
{
  const SERVICE_NAME = 'mileage';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function history($query)
  {
    return $this->get('/api/list', $query);
  }
}
