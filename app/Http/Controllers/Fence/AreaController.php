<?php

namespace App\Http\Controllers\Fence;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AreaController extends Controller
{
  public function __construct() {
    
  }

  public function index(Request $request)
  {
    return view('fence.polygon');
  }

  public function save(Request $request)
  {
    return [
      'user' => $this->getWebUser(),
      'data' => $request->all(),
    ];
  }
}