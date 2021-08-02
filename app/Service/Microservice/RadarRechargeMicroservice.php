<?php

namespace App\Service\Microservice;

class RadarRechargeMicroservice extends BaseService
{
  const SERVICE_NAME = 'radar-recharge';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }
  
  public function signup($data)
  {
    return $this->post('/auth/signup', $data);
  }
}
