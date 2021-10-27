<?php

namespace App\Service\Microservice;

class RMSBatteryMicroservice extends BaseService
{
  const SERVICE_NAME = 'rms-battery';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }
}
