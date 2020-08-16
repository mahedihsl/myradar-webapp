<?php

namespace App\Service\Microservice;

class ServiceException extends \Exception {
  public function __construct($message) {
    parent::__construct($message);
  }

  public static function fromClientException($e) {
    $response = $e->getResponse()->getBody()->getContents();
    $response = json_decode($response, true);
    return new ServiceException($response['message']);
  }

  public static function fromServerException($e) {
    return new ServiceException('Unknown microservice error');
  }
}