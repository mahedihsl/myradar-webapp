<?php

namespace App\Service\Microservice;

class RMSDoorMicroservice extends BaseService
{
  const SERVICE_NAME = 'rms-door';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function openhours($query)
  {
    return $this->get('/api/openhours', $query);
  }
}
