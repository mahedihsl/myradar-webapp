<?php

namespace App\Service\Microservice;

class RMSUserMicroservice extends BaseService
{
  const SERVICE_NAME = 'rms-user';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function filterSites($query)
  {
    return $this->get('/site/fetch', $query);
  }
}
