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
    return $this->post('/account/disable/by-car', compact('reg_no'));
  }

  public function toggleStatus($user_id, $actor_id) {
    return $this->post('/account/toggle/status', compact('user_id', 'actor_id'));
  }

  public function statusHistory($user_id) {
    return $this->get('/account/status/history', compact('user_id'));
  }

  public function registerSession($data) {
    return $this->post('/session/save', $data);
  }

  public function logoutSession($data) {
    return $this->post('/session/remove', $data);
  }

  public function test()
  {
    return $this->get('/test', [ 'user' => 'palatok' ]);
  }
}
