<?php

namespace App\Service\Microservice;

/**
 * Created for tessting purpose, safe to delete
 */
class SocketMicroservice extends BaseService
{
  const SERVICE_NAME = 'socket2';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function send($user_id, $payload)
  {
    return $this->post('/io/send/notification', compact('user_id', 'payload'));
  }
}
