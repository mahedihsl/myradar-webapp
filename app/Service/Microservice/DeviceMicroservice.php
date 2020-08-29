<?php

namespace App\Service\Microservice;

class DeviceMicroservice extends BaseService
{
  const SERVICE_NAME = 'device';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function bindDevice($car_id, $com_id)
  {
    return $this->post('/car/bind', compact('car_id', 'com_id'));
  }

  public function unbindDevice($car_id)
  {
    return $this->post('/car/unbind', compact('car_id'));
  }

  public function bindHistory($car_id, $device_id, $page)
  {
    return $this->get('/car/bind/history', compact('car_id', 'device_id', 'page'));
  }
}
