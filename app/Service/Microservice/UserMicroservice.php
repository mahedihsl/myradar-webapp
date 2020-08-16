<?php

namespace App\Service\Microservice;

class UserMicroservice extends BaseService
{
  const SERVICE_NAME = 'user';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function disableByCar($reg_no)
  {
    return $this->post('/disable/by-car', compact('reg_no'));
  }

  public function toggleStatus($user_id, $actor_id) {
    return $this->post('/toggle/status', compact('user_id', 'actor_id'));
  }

  public function test()
  {
    return $this->get('/test', [ 'user' => 'palatok' ]);
  }
}
