<?php

namespace App\Service\Microservice;

class FuelMicroservice extends BaseService
{
  const SERVICE_NAME = 'fuel';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function latest($device_id = null, $car_id = null)
  {
    return $this->get('/fuel/latest', compact('device_id', 'car_id'));
  }

  public function history($car_id, $type)
  {
    return $this->get('/fuel/history', compact('car_id', 'type'));
  }

  public function fetchAvarage($device_id, $from, $to, $page, $per_page)
  {
    return $this->get('/fuel/fetch-avarage', compact('device_id', 'from', 'to', 'page', 'per_page'));
  }

  public function storeAvarage($value, $device_id)
  {
    return $this->post('/fuel/store-avarage', compact('value', 'device_id'));
  }

  public function getRefuelEvents($car_id, $days)
  {
    return $this->get('/refuel/events', compact('car_id', 'days'));
  }
}
