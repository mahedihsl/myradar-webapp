<?php

namespace App\Service\Microservice;

class LocationMicroservice extends BaseService
{
  const SERVICE_NAME = 'location';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function history($device_id, $from, $to)
  {
    return $this->get('/api/history', compact('device_id', 'from', 'to'));
  }
}
