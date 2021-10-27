<?php

namespace App\Service\Microservice;

class RMSMainsMicroservice extends BaseService
{
  const SERVICE_NAME = 'rms-mains';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }
}
