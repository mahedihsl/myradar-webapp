<?php

namespace App\Service\Bkash;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Criteria\WithinDatesCriteria;
use App\Criteria\UserIdCriteria;
use App\Criteria\GroupByCriteria;
use App\Entities\Car;
use App\Entities\User;
use Illuminate\Support\Facades\Log;
use App\Service\Microservice\PaymentMicroservice;
use App\Service\Microservice\SmsMicroservice;

class BkashPaymentService
{
  /**
   * @var PaymentRepository
   */
  private $repository;
  private $smsService;
  private $paymentService;

  public function __construct()
  {
    $this->smsService = new SmsMicroservice();
    $this->paymentService = new PaymentMicroservice();

    Carbon::useMonthsOverflow(false);
  }

  public function save($data , $paymentRepository)
  {
    $payment = $paymentRepository->save($data);

    if (!is_null($payment)) {
      try {
        $this->paymentService->observeBill($payment->id);
      } catch (\Exception $e) {
        Log::info('Error during bill observe', ['error' => $e->getMessage()]);
      }
      return [ "Error_code" => "200", "Error_msg" => "Success"];
    }

    return [ "Error_code" => "404", "Error_msg" => "Not Found"];;
  }

  public function index(Request $request, $userId)
  {
    $criteria = new WithinDatesCriteria(Carbon::today()->subYears(2), Carbon::tomorrow(), 'paid_on');
    $paymentlist = $this->repository
      ->pushCriteria(new UserIdCriteria($userId))
      ->pushCriteria($criteria)
      ->with(['user', 'car'])
      ->all();
    return response()->ok($paymentlist);
  }

  public function getRefNo(Request $request, $userId)
  {
    $ref = User::find($userId)->ref_no;
    return response()->ok($ref);
  }

  public function sendAll(Request $request)
  {
    $users = User::all();
    foreach ($users as $key => $user) {
      try {
        $this->send($user->id);
      } catch (\Exception $e) {
      }
    }
    return response()->ok();
  }

  public function send(Request $request)
  {
    $userId = $request->get('id');
    $content = $request->get('content');
    $type = $request->get('type');
    $this->smsService->send(User::find($userId)->phone, $content, $type);
    return response()->ok();
  }

  public function getMsgContent($userId)
  {
    $months = $this->getDue($userId);

    if (sizeof($months) == 0) return response()->ok('All paid');
    $content = $this->smsService->buildContent('payment_2', $months);
    // $content = $this->getContent($months);
    return response()->ok($content);
  }

  public function getContent($data)
  {
    $content = "Dear myRADAR Customer,\nyour due bill:\n";
    foreach ($data as $key => $val) {

      $content .= "For car: " . $val['reg_no'] . "\nAmount: " . $val['bill'] . " tk for month ";
      $monStr = $this->getMonthStr($val['mon']);
      $content .= $monStr;
      $content .= "\n\n";
    }

    $content .= "Call:01907888899";
    return $content;
  }

  public function getMonthStr($mon)
  {
    $ret = Carbon::createFromDate($mon[0][1], $mon[0][0], 1)->format("M'y");

    if (sizeof($mon) == 2) {
      $ret .= " and ";
      $ret .= Carbon::createFromDate($mon[1][1], $mon[1][0], 1)->format("M'y");
    } else if (sizeof($mon) > 2) {
      $len = sizeof($mon);
      $ret .= " to ";
      $ret .= Carbon::createFromDate($mon[$len - 1][1], $mon[$len - 1][0], 1)->format("M'y");
    }

    return $ret;
  }

  public function totalDue($userId)
  {
    return ['total' => $this->getDue($userId)->sum('bill')];
  }

  public function carDueBillCheck($userId)
  {
    return ['cars_bill_details' => $this->getDue($userId)];
  }

  public function getDue($userId)
  {
    $cars = User::find($userId)->cars;
    $months = collect();
    $bill = 0;

    foreach ($cars as $key => $car) {
      $billDate = $this->getBillDate($car);
      $mon = collect();
      $presentDate = $this->getPresentDate($car);
      $mon = $this->getAllMonths($billDate, $presentDate);

      foreach ($car->payments as $key => $payment) {
        foreach ($payment->months as $key => $month) {
          $mon = $mon->reject(function ($value, $key) use ($month) {
            return ($month[0] + 1 == $value[0] && $month[1] == $value[1]);
          });
        }
      }

      $mon = $mon->values();
      if ($car->bill == '' || sizeof($mon) == 0) continue;
      $bill = $car->bill * sizeof($mon) - $this->getExtraPayment($car);

      $months->push([
        'car_id' => $car->id,
        'reg_no' => $car->reg_no,
        'bill' => $bill,
        'mon' => $mon,
      ]);
    }
    return $months;
  }

  public function getCarsListForUserID($userId){
    $cars = User::find($userId)->cars;
    $cars_list = array();
    for($i = 0; $i < count($cars); $i++){
      array_push($cars_list, $cars[$i]['reg_no']);
    }

    return $cars_list;
  }

  public function getExtraPayment($car) //check if the user has given some extra money on his last payment
  {
    $lastPayment = $car->getLatestPayment();
    if (!is_null($lastPayment) && !is_null($lastPayment->extra)) {
      return $lastPayment->extra;
    }

    return 0;
  }

  public function getBillDate($car)
  {
    $billDate = $car->created_at->addMonth();
    $billDate->day = 1;
    return $billDate;
  }

  public function getPresentDate($car)
  {
    $presentDate = Carbon::today();
    $presentDate->day = 2;
    return $presentDate;
  }

  public function getAllMonths($billDate, $presentDate)
  {
    $mon = collect();
    for ($i = $billDate->copy(); $i->lte($presentDate); $i->addMonth()) {
      $mon->push([$i->month, $i->year]);
    }
    return $mon;
  }

  public function sendMethodAll(Request $request)
  {
    $users = User::all();
    foreach ($users as $key => $user) {
      $this->sendMethod($user->id);
    }

    return response()->ok();
  }

  public function sendMethod($userId)
  {
    try {
      $user = User::find($userId);
      $refNo = $user->ref_no;
      if ($refNo == "") return response()->ok("add ref no!");
      $content = $this->smsService->buildContent('payment_1', ['ref_no' => $refNo]);
      // $content = $this->methodContent($refNo);
      return response()->ok($content);
    } catch (\Throwable $th) {
      response()->ok($th->getMessage());
    }
  }

  public function methodContent($refNo)
  {

    $ret = "Dear myRADAR Customer,\nPlease pay your bill:\nMerchant bKash: " . config('myradar.bkash.marchent') . "\nReference: " . $refNo . "\nCounter No: 1";
    return $ret;
  }

  public function getPayments(Request $request, $userId)
  {
    $cars = User::find($userId)->cars;
    $data = collect();
    foreach ($cars as $key => $car) {
      $mon = collect();
      foreach ($car->payments as $key => $payment) {
        foreach ($payment->months as $key => $month) {
          $mon->push($month);
        }
      }
      $data->push([
        'reg_no' => $car->reg_no,
        'bill'   => $car->bill,
        'date'   => $car->created_at->toFormattedDateString(),
        'mon'    => $mon,
        'last_payment'  => $car->getLatestPayment()
      ]);
    }

    return response()->ok($data);
  }
}

