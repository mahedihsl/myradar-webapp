<?php

namespace App\Service\Microservice;

class SmsMicroservice extends BaseService
{
  const SERVICE_NAME = 'sms';

  public function __construct()
  {
    parent::__construct(self::SERVICE_NAME);
  }

  public function send($phone, $content, $type = 'unknown')
  {
    return $this->post('/send', compact('phone', 'content', 'type'));
  }

  public function sendRaw($phone, $type = 'unknown', $payload)
  {
    return $this->post('/send-raw', compact('phone', 'type', 'payload'));
  }
 
  public function buildContent($type, $payload)
  {
    $response = $this->post('/build-content', compact('type', 'payload'));
    return $response['content'];
  }
}
