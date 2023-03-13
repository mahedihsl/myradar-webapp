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
        Redis::command('SET', ['due_bill', $service_res['total']]);
        $cars_list = $this->bkashPaymentService->getCarsListForUserID($user->id, $this->paymentRepository);

        return view('bkash.chcekout-url.amount')->with([
            'due_bill' => $service_res['total'],
            'cars_list' => $cars_list
        ]);
    }
    
    public function payment(Request $request)
    {
        $amount = $request->get('amount');
        $car_no = $request->get('car_no');
        $selectedCars = $request->input('cars');

        if(!$selectedCars){
            return redirect()->back()->withErrors(['error' => 'Please Selecet a car']);
        }

        $user = Auth::user();
        $cars_list = $this->bkashPaymentService->getCarsListForUserID($user->id, $this->paymentRepository);

        return view('bkash.chcekout-url.pay')->with([
            'amount' => $amount,
            'car_no' => $car_no,
        ]);
    }

    public function createPayment(Request $request){

        $amount = $request->get('amount');
        $car_no = $request->get('car_no');
        Redis::command('SET', ['car_no', $car_no]);
      
        return $this->bkashCheckoutURLService->createPayment($amount, $this->credential);
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

                $data = collect([
                    'amount' => $response['amount'],
                    'months' => json_encode([1, 2]),
                    'year' => 2023,
                    'car_id'  => Redis::command('GET', ['car_no']),
                    'user_id' => $this->user->id,
                    'date' => $response['paymentExecuteTime'],
                    'extra' => '', // advance
                    'waive' => '', // discount
                    'note'=> ' ',
                    'type' => '11'
                    
                ]);

                $service_res = $this->bkashPaymentService->save($data, $this->paymentRepository);

                if($service_res['Error_msg'] == 'Success' && $service_res['Error_code'] == '200'){
                    return view('bkash.chcekout-url.success');
                }else{
                    return view('bkash.chcekout-url.fail')->with([
                        'message' => $service_res['Error_msg'],
                    ]);
                }
                
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
    
}