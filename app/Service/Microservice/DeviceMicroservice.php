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

  public function bindHistory($params)
  {
    $reg_no = $params->get('reg_no', '');
    $com_id = $params->get('com_id', '');
    $page = $params->get('page', '1');
    return $this->get('/car/bind/history', compact('reg_no', 'com_id', 'page'));
  }

  public function deviceConfig($device)
  {
    return $this->get('/device/config', compact('device'));
  }

  public function list($filter)
  {
    return $this->get('/device/list', $filter);
  }
}
