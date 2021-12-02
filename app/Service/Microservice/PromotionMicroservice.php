<?php

namespace App\Service\Microservice;

class PromotionMicroservice extends BaseService
{
  const SERVICE_NAME = 'promotion';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function saveLead($data)
  {
    return $this->post('/lead/lucky-coupon', $data);
  }
  
  public function saveDemoLead($data)
  {
    return $this->post('/lead/demo-user', $data);
  }
}
