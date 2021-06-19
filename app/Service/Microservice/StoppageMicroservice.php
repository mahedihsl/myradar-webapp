<?php

namespace App\Service\Microservice;

class StoppageMicroservice extends BaseService
{
  const SERVICE_NAME = 'stoppage';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function list($query)
  {
    return $this->get('/api/list', $query);
  }

  public function save($data)
  {
    return $this->post('/api/save', $data);
  }
  
  public function update($data)
  {
    return $this->post('/api/update', $data);
  }
  
  public function remove($id)
  {
    return $this->post('/api/remove', compact('id'));
  }
}
