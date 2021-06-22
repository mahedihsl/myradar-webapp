<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Microservice\UserMicroservice;

class LoginController extends Controller {
  private $service;

  public function __construct() {
    $this->service = new UserMicroservice();
  }

  public function login(Request $request)
  {
    try {
      $phone = $request->get('phone');
      $password = $request->get('password');
      
      return response()->json($this->service->login($phone, $password));
    } catch (\Throwable $e) {
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }
}