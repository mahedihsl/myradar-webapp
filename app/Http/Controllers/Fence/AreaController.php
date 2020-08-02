<?php

namespace App\Http\Controllers\Fence;

use App\Contract\Repositories\GeofenceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AreaController extends Controller
{
  private $repository;

  public function __construct(GeofenceRepository $repository) {
    $this->repository = $repository;    
  }

  public function index(Request $request)
  {
    return view('fence.polygon');
  }

  public function save(Request $request)
  {
    $model = $this->repository->save(collect($request->all()), $this->getWebUser());
    return response()->json([
      'status' => 1,
      'id' => $model->id,
    ]);
  }
}