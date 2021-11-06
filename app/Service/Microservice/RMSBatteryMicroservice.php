<?php

namespace App\Service\Microservice;

class RMSBatteryMicroservice extends BaseService
{
  const SERVICE_NAME = 'rms-battery';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function recent($query)
  {
    return $this->get('/api/recent', $query);
  }
}
