<?php

namespace App\Service\Microservice;

class RMSMainsMicroservice extends BaseService
{
  const SERVICE_NAME = 'rms-mains';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function recent($query)
  {
    return $this->get('/api/recent', $query);
  }

  public function offhours($query)
  {
    return $this->get('/api/offhours', $query);
  }
}