<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Util\BkashCredential;
use App\Service\Bkash\BkashCheckoutURLService;
use App\Service\Bkash\BkashPaymentService;
use Illuminate\Support\Facades\Redis;
use URL;
use Illuminate\Support\Str;

class BkashCheckoutURLController extends Controller
{
    private $credential;
    private $bkashCheckoutURLService;
    private $bkashPaymentService;

    public function __construct()
    {
        $this->bkashCheckoutURLService = new BkashCheckoutURLService();
        $this->bkashPaymentService = new BkashPaymentService();
        $this->credential = new BkashCredential(config('bkash.tokenized.sandbox2'));
    }

    public function payment(Request $request)
    {
        return view('bkash.chcekout-url.pay');
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

                $save_data = [
                    'username' => 'tipu',
                    'password' => '1234',
                    'ref_no'  => Redis::command('GET', ['car_no']),
                    'bill_amount' => $response['amount'],
                    'bKash_trxid' => $response['trxID'],
                    'paytime' => $response['paymentExecuteTime']
                    
                ];

                $this->bkashPaymentService->save($save_data);
                
                return view('bkash.chcekout-url.success')->with([
                    'response' => $response['trxID'],
                ]);
                
            }else{
                return view('bkash.chcekout-url.fail')->with([
                    'response' => $response['statusMessage'],
                ]);

            
            }  

        }else{
            return view('bkash.chcekout-url.fail')->with([
                'response' => 'Payment Failed !!'
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