<?php

namespace App\Http\Controllers\Test;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entities\Car;
use App\Entities\Device;
use App\Service\DirectionService;
use Carbon\Carbon;
use Excel;

class BillInsertController extends Controller
{


  public function populate(Request $requst)
  {
    $cars = Car::All();
    foreach ($cars as $key => $car) {
      $car->bill = 500;
      $car->save();
    }
  }




}
