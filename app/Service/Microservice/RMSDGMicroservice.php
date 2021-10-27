<?php

namespace App\Service\Microservice;

class RMSDGMicroservice extends BaseService
{
  const SERVICE_NAME = 'rms-dg';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function runhours($query)
  {
    return $this->get('/api/runhours', $query);
  }
}
