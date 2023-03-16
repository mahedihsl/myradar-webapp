<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Util\BkashCredential;
use App\Contract\Repositories\PaymentRepository;
use App\Service\Bkash\BkashCheckoutURLService;
use App\Service\Bkash\BkashPaymentService;
use Illuminate\Support\Facades\Redis;
use URL;
use Illuminate\Support\Str;
use Auth;

class BkashCheckoutURLController extends Controller
{  /**
    * @var PaymentRepository
    */
    private $repository;
    private $credential;
    private $bkashCheckoutURLService;
    private $bkashPaymentService;

    public function __construct(PaymentRepository $repository)
    {
        $this->paymentRepository = $repository;
        $this->bkashCheckoutURLService = new BkashCheckoutURLService();
        $this->bkashPaymentService = new BkashPaymentService();
        $this->credential = new BkashCredential(config('bkash.tokenized.sandbox2'));
    }

    public function amount(Request $request)
    {   
        $user = Auth::user();
        $service_res = $this->bkashPaymentService->totalDue($user->id, $this->paymentRepository);
        $total_due_bill = $this->bkashPaymentService->totalDue($user->id, $this->paymentRepository);
        $cars_bill_details = $this->bkashPaymentService->carDueBillCheck($user->id, $this->paymentRepository)['cars_bill_details'];

        return view('bkash.chcekout-url.amount')->with([
            'cars_bill_details' => $cars_bill_details,
            'total_due_bill' => $total_due_bill['total']
        ]);
    }
    
    public function payment(Request $request)
    {
        $selectedCars = $request->input('cars');

        if(!$selectedCars){
            return redirect()->back()->withErrors(['error' => 'Please Selecet a car']);
        }

        $selected_cars_str = $this->bkashPaymentService->selectedCarList($selectedCars, $this->paymentRepository);

        $total_pay_bill = 0;
        $car_wise_bill = [];
        
        foreach ($selectedCars as $selectedCar) {

            if($request->input($selectedCar) < 1){
                return redirect()->back()->withErrors(['error' => 'Minimum amount 1 tk']);
            } 
            
            array_push($car_wise_bill, ['car_no' => $selectedCar, 'bill' => $request->input($selectedCar)]);

            $total_pay_bill +=  $request->input($selectedCar);

          } 

        return view('bkash.chcekout-url.pay')->with([
            'car_wise_bill' => json_encode($car_wise_bill),
            'selected_cars' => $selected_cars_str,
            'amount' => $total_pay_bill,
        ]);
    }

    public function createPayment(Request $request){

        $amount = $request->get('amount');
        $car_wise_bill = $request->get('car_wise_bill');
      
        return $this->bkashCheckoutURLService->createPayment($amount, $car_wise_bill, $this->credential);
    }

    public function callback(Request $request)
    {
        $allRequest = $request->all();

        if(isset($allRequest['status']) && $allRequest['status'] == 'success'){
            
            $response = $this->bkashCheckoutURLService->executePayment($allRequest['paymentID'], $this->credential);

            if(array_key_exists("message",$response)){
                // If Execute API Failed  
                sleep(1);
                $response = $this->bkashCheckoutURLService->queryPayment($allRequest['paymentID'], $this->credential);
            }

            if(array_key_exists("statusCode",$response) && $response['statusCode'] == '0000'){
                return view('bkash.chcekout-url.success');
            }else{
                return view('bkash.chcekout-url.fail')->with([
                    'message' => $response['statusMessage'],
                ]);
            }  

        }else{
            return view('bkash.chcekout-url.fail')->with([
                'message' => $allRequest['status'],
            ]);       
        }

    }

    public function getRefund(Request $request)
    {
        return view('bkash.chcekout-url.refund');
    }

    public function refundPayment(Request $request)
    {
        $paymentID = $request->get('paymentID');
        $trxID = $request->get('trxID');
        $amount = $request->get('amount');

        $response = $this->bkashCheckoutURLService->refundTransaction($paymentID, $trxID, $amount, $this->credential);

        return view('bkash.chcekout-url.refund')->with([
            'response' => "Refund Successful",
        ]);
    }        
    
    public function allBkashBill(Request $request){
        
        $all_successful_data = $this->bkashCheckoutURLService->allBkashBill();

        return view('bkash.chcekout-url.allBill')->with([
            'all_successful_data' => $all_successful_data,
        ]);   
    }
    
    private function export($data)
    {
        Excel::create('BillingRecords', function ($excel) use ($data) {
            $excel->sheet('data', function ($sheet) use ($data) {
                $data->transform(function ($car) {
                    $transformer = new CarExportTransformer();
                    return $transformer->transform($car);
                });

                $sheet->fromArray($data->toArray(), null, 'A1', false, true);

                $sheet->row(1, function ($row) {
                    $row->BalancesetFontWeight('bold');
                });
            });
        })->download('xlsx');
    }
}