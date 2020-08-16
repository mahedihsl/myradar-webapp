<?php

namespace App\Service\Microservice;

class BaseService {
  private $name;
  private $client;

  public function __construct($name) {
    $this->name = $name;
    $this->client = new \GuzzleHttp\Client(['base_uri' => $this->getBaseUri()]);
  }

  public function getBaseUri()
  {
    $config = config('microservice.' . $this->name);
    if (!$config) throw new \Exception('Unknown Microservice Name: ' . $this->name);

    return $config['url'] . ':' . $config['port'];
  }

  public function getClient()
  {
    return $this->client;
  }

  public function post($path, $data)
  {
    $res = $this->client->post($path, [
      'json' => $data
    ]);
    return $res->getBody();
  }
}