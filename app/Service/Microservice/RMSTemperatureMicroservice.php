<?php

namespace App\Service\Microservice;

class RMSTemperatureMicroservice extends BaseService
{
  const SERVICE_NAME = 'rms-temperature';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function recent($query)
  {
    return $this->get('/api/recent', $query);
  }

  public function history($query)
  {
    return $this->get('/api/history', $query);
  }
}
