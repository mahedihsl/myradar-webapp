<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\SmsService;
use Carbon\Carbon;
use App\Contract\Repositories\PaymentRepository;
use App\Criteria\WithinDatesCriteria;
use App\Criteria\UserIdCriteria;
use App\Criteria\GroupByCriteria;
use App\Entities\Car;
use App\Entities\User;

class PaymentController extends Controller
{
    /**
     * @var PaymentRepository
     */
    private $repository;

    public function __construct(PaymentRepository $repository)
    {
        $this->repository = $repository;
        Carbon::useMonthsOverflow(false);
    }

    public function save(Request $request)
    {
        $payment = $this->repository->save(collect($request->all()));

        if ( ! is_null($payment)) {
            return response()->ok();
        }

        return response()->error();
    }

    public function index(Request $request, $userId)
    {
      $this->repository->pushCriteria(new UserIdCriteria($userId));
      $criteria = new WithinDatesCriteria(Carbon::today()->subYears(2), Carbon::tomorrow(), 'paid_on');
      $paymentlist = $this->repository->pushCriteria($criteria)
                                        ->with(['user','car'])
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
      $service = new SmsService();
      $service->send(User::find($userId)->phone, $content, 'payment_1');
      return response()->ok();
    }

    public function getMsgContent($userId)
    {
      $months = $this->getDue($userId);

      if(sizeof($months) == 0) return response()->ok('All paid');
      $content = $this->getContent($months);
      return response()->ok($content);
    }

    public function getContent($data)
    {
      $content = "Dear Customer,\nyour due bill:\n";
      foreach ($data as $key => $val) {

        $content.="For car: ".$val['reg_no']."\nAmount: ".$val['bill']." tk for month ";
        $monStr = $this->getMonthStr($val['mon']);
        $content.=$monStr;
        $content.="\n\n";
      }

      $content.="Call:01907888899";
      return $content;
    }

    public function getMonthStr($mon)
    {
      $ret=Carbon::createFromDate($mon[0][1],$mon[0][0],1)->format("M'y");

      if (sizeof($mon)==2) {
        $ret.=" and ";
        $ret.=Carbon::createFromDate($mon[1][1],$mon[1][0],1)->format("M'y");
      }
      else if(sizeof($mon)>2){
        $len = sizeof($mon);
        $ret.=" to ";
        $ret.=Carbon::createFromDate($mon[$len-1][1],$mon[$len-1][0],1)->format("M'y");
      }

      return $ret;
    }

    public function totalDue(Request $request, $userId)
    {
        return response()->ok([
            'total' => $this->getDue($userId)->sum('bill'),
        ]);
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


        foreach($car->payments as $key=>$payment){
          foreach ($payment->months as $key => $month) {
            $mon = $mon->reject(function($value,$key) use ($month){
              return ($month[0]+1 == $value[0] && $month[1] == $value[1]);
            });
          }
        }

        $mon = $mon->values();
        if($car->bill == '' || sizeof($mon)==0) continue;
        $bill = $car->bill*sizeof($mon) - $this->getExtraPayment($car);

        $months->push([
            'car_id' => $car->id,
            'reg_no' => $car->reg_no,
            'bill' => $bill,
            'mon' => $mon,
        ]);
      }
      return $months;
    }

    public function getExtraPayment($car) //check if the user has given some extra money on his last payment
    {
      $lastPayment = $car->getLatestPayment();
      if(!is_null($lastPayment) && !is_null($lastPayment->extra)){
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
      for($i = $billDate->copy(); $i->lte($presentDate); $i->addMonth())
      {
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
      $user    = User::find($userId);
      $phone   = $user->phone;
      $refNo     = $user->ref_no;
      if($refNo == "") return response()->ok("add ref no!");
      $content = $this->methodContent($refNo);
      return response()->ok($content);
    }

    public function methodContent($refNo)
    {

      $ret = "Dear Customer,\nPlease pay your bill:\nMerchant bKash: ".config('myradar.bkash.marchent')."\nReference: ".$refNo."\nCounter No: 1";
      return $ret;
    }

    public function getPayments(Request $request,$userId)
    {
      $cars = User::find($userId)->cars;
      $data = collect();
      foreach($cars as $key =>$car){
        $mon = collect();
        foreach($car->payments as $key=>$payment){
          foreach ($payment->months as $key => $month) {
            $mon->push($month);
          }
        }
        $data->push(['reg_no' => $car->reg_no,
                     'bill'   => $car->bill,
                     'date'   => $car->created_at->toFormattedDateString(),
                     'mon'    => $mon,
                     'last_payment'  => $car->getLatestPayment()
                   ]);
      }

      return response()->ok($data);
    }

}
