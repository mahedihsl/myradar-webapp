<?php

namespace App\Service\Microservice;

class GeofenceMicroservice extends BaseService
{
  const SERVICE_NAME = 'geofence';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function observe($car_id, $lat, $lng)
  {
    return $this->post('/observe', compact('car_id', 'lat', 'lng'));
  }

  public function getGeofenceList($query)
  {
    return $this->get('/geofence/list', $query);
  }
  
  public function saveGeofence($data)
  {
    return $this->post('/geofence/save', $data);
  }

  public function removeGeofence($id)
  {
    return $this->post('/geofence/remove', compact('id'));
  }

  public function updateGeofence($id, $name, $coordinates)
  {
    return $this->post('/geofence/update', compact('id', 'name', 'coordinates'));
  }

  public function syncSubscriptions($geofence_id, $car_ids)
  {
    return $this->post('/geofence/subscriptions/sync', compact('geofence_id', 'car_ids'));
  }

  public function fetchSubscriptions($geofence_id)
  {
    return $this->get('/geofence/subscriptions/fetch', compact('geofence_id'));
  }

  public function getViolationHistory($query)
  {
    return $this->get('/violation/history', $query);
  }

  public function test($car)
  {
    return $this->get('/geofence/test', compact('car'));
  }

  public function testCacheRead($car_id)
  {
    return $this->post('/test/read-cache', compact('car_id'));
  }

  public function testCacheWrite($car_id)
  {
    return $this->post('/test/write-cache', compact('car_id'));
  }
}
