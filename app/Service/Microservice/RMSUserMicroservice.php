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

  public function saveSite($data)
  {
    return $this->post('/site/save', $data);
  }

  public function updateSite($data)
  {
    return $this->post('/site/update', $data);
  }

  public function cacheSiteStatus($data)
  {
    return $this->post('/cache/site-status', $data);
  }
  
  public function statusCounts($query)
  {
    return $this->get('/site/status-counts', $query);
  }

  public function getSiteDigitalControl($query)
  {
    return $this->get('/site/digital-control', $query);
  }

  public function setSiteDigitalControl($data)
  {
    return $this->post('/site/digital-control', $data);
  }
}
