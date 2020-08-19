<?php

namespace App\Service\Microservice;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

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
    try {
      $res = $this->client->post($path, [ 'json' => $data ]);
      return json_decode($res->getBody()->getContents(), true);
    } catch (ClientException $e) {
      throw ServiceException::fromClientException($e);
    } catch (ServerException $e) {
      throw ServiceException::fromServerException($e);
    }
  }

  public function get($path, $params = [])
  {
    try {
      $res = $this->client->get($path, [ 'query' => $params ]);
      return json_decode($res->getBody()->getContents(), true);
    } catch (ClientException $e) {
      throw ServiceException::fromClientException($e);
    } catch (ServerException $e) {
      throw ServiceException::fromServerException($e);
    }
  }
}