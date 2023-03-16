<?php

namespace App\Service\Bkash;

use App\Util\BkashCredential;
use Illuminate\Support\Facades\Redis;
use URL;
use Illuminate\Support\Str;
use Exception;
use App\Entities\BkashPGWTransaction;
use Auth;

class BkashCheckoutURLService extends BkashService
{
  private $website_base_url;

  public function __construct()
  {
    parent::__construct('checkout_url');
    $this->website_base_url = URL::to("/");
  }

  private function storeLog($apiName, $url, $headers, $body, $response)
  {
    $log = [
      'url' => $url,
      'headers' => $headers,
      'body' => $body,
      'response' => $response,
    ];
    $key = 'bkash:log:' . $apiName;
    Redis::command('SET', [$key, json_encode($log)]);
  }

  public function grantToken(BkashCredential $credential)
  {
    try {
      $url = $credential->getURL('/tokenized/checkout/token/grant');
      $headers = $credential->getAuthHeaders();
      $body = [
        'app_key' => $credential->appKey,
        'app_secret' => $credential->appSecret,
      ];
      $res = $this->httpClient()->post($url, [
        'json' => $body,
        'headers' => $headers,
        'connect_timeout' => 10,
        'read_timeout' => 30,
      ]);

      $response = json_decode($res->getBody()->getContents(), true);

      $this->storeLog('grant_token', $url, $headers, $body, $response);

      return $response;
    } catch (Exception $e) {
      throw $e;
    }
  }

  public function refreshToken($refreshToken, BkashCredential $credential)
  {
    try {
      $res = $this->httpClient()->post($credential->getURL('/tokenized/checkout/token/refresh'), [
        'json' => [
          'app_key' => $credential->appKey,
          'app_secret' => $credential->appSecret,
          'refresh_token' => $refreshToken,
        ],
        'headers' => $credential->getAuthHeaders(),
        'connect_timeout' => 10,
        'read_timeout' => 30,
      ]);

      return json_decode($res->getBody()->getContents(), true);
    } catch (Exception $e) {
      throw $e;
    }
  }

  public function createPayment($amount, $car_wise_bill, BkashCredential $credential)
  {
    try {
      $url = $credential->getURL('/tokenized/checkout/create');
      $headers = $credential->getAccessHeaders($this->getAccessToken());   
      $body = [
        'mode' => '0011',
        'payerReference' => ' ',
        'callbackURL' => $this->website_base_url.'/bkash/callback',
        'amount' => $amount,
        'currency' => 'BDT',
        'intent' => 'sale',
        'merchantInvoiceNumber' => "Inv".Str::random(8) 
      ];
      $res = $this->httpClient()->post($url, [
        'json' => $body,
        'headers' => $headers,
        'connect_timeout' => 10,
        'read_timeout' => 30,
      ]);

      $response = json_decode($res->getBody()->getContents(), true);

      $this->storeLog('create_payment', $url, $headers, $body, $response);

      //db insert to bkash_transactions table

      $user = Auth::user();
      
      BkashPGWTransaction::create([
        'user_id' => $user->id,
        'user_name' => $user->name,
        'phone_no' => $user->phone,
        'wallet_no' => null,
        'car_wise_bill' =>  $car_wise_bill,
        'payment_id' => $response['paymentID'],
        'amount' => $response['amount'],
        'invoice_no' => $response['merchantInvoiceNumber'],
        'create_response' => $response,
        'execute_response' => null,
        'trx_id' => null,
        'is_successful' => false
    ]);

      return redirect($response['bkashURL']);

    } catch (Exception $e) {
      throw $e;
    }
  }

  public function executePayment($paymentID, BkashCredential $credential)
  {
    try {
      $url = $credential->getURL('/tokenized/checkout/execute');
      $headers = $credential->getAccessHeaders($this->getAccessToken());
      $body = [
        'paymentID' => $paymentID
      ];

      $res = $this->httpClient()->post($url, [
        'json' => $body,
        'headers' => $headers,
        'connect_timeout' => 10,
        'read_timeout' => 30,
      ]);

      $response = null;

      $check_transaction = BkashPGWTransaction::where('payment_id', $paymentID)->first();

      if($check_transaction){

        $response = json_decode($res->getBody()->getContents(), true);

        if(array_key_exists("statusCode",$response) && $response['statusCode'] == '0000'){
          $check_transaction->update([
            'wallet_no' => $response['customerMsisdn'],
            'execute_response' => $response,
            'trx_id' => $response['trxID'],
            'is_successful' => true
  
          ]);
        }else{
          $check_transaction->update([
            'wallet_no' => $response['customerMsisdn'],
            'execute_response' => $response,
            'trx_id' => null,
            'is_successful' => false
  
          ]);
        }

        $this->storeLog('execute_payment', $url, $headers, $body, $response);

      }

      return $response; 
    } catch (Exception $e) {
      throw $e;
    }
  }

  /**
   * trxID: 9G5507A7EH
   * paymentID: 8YQNJVY1657017309523
   * refundTrxID: 9G5307A7KT
   */

  public function queryPayment($paymentID, BkashCredential $credential)
  {
    try {
      $url = $credential->getURL('/tokenized/checkout/payment/status');
      $headers = $credential->getAccessHeaders($this->getAccessToken());
      $body = [
        'paymentID' => $paymentID
      ];
      $res = $this->httpClient()->post($url, [
        'headers' => $headers,
        'connect_timeout' => 10,
        'read_timeout' => 30,
      ]);

      $response = json_decode($res->getBody()->getContents(), true);

      // database insert to bkash_transaction table;

      $this->storeLog('query_payment', $url, $headers, $body, $response);

      return $response;
    } catch (Exception $e) {
      throw $e;
    }
  }

  public function searchTransaction($trxID, BkashCredential $credential)
  {
    try {
      $url = $credential->getURL('tokenized/checkout/general/searchTransaction');
      $headers = $credential->getAccessHeaders($this->getAccessToken());
      $body = [
        'trxID'=> $trxID
      ];
      $res = $this->httpClient()->post($url, [
        'headers' => $headers,
        'connect_timeout' => 10,
        'read_timeout' => 30,
      ]);

      $response = json_decode($res->getBody()->getContents(), true);

      // database insert to bkash_transaction table; 

      $this->storeLog('search_transaction', $url, $headers, $body, $response);

      return $response;
    } catch (Exception $e) {
      throw $e;
    }
  }

  public function allBkashBill()
  {
    try {

      $successful_transactions = BkashPGWTransaction::where('is_successful', true)->get();
      
      $all_successful_data = [];

      if($successful_transactions){

        foreach ($successful_transactions as $transaction) {

          $car_no_and_bill = json_decode($transaction->car_wise_bill,true);

          $no_of_cars = count($car_no_and_bill);

          if($no_of_cars > 1){
            for ($i = 0; $i < $no_of_cars; $i++) {

              $successful_data =  [
                'user_id' => $transaction->id,
                'user_name' => $transaction->user_name,
                'phone_no' => $transaction->phone_no,
                'wallet_no' => $transaction->wallet_no,
                'payment_id' => $transaction->payment_id,
                'trx_id' => $transaction->trx_id,
                'invoice_no' => $transaction->invoice_no,
                'car_no' => $car_no_and_bill[$i]['car_no'],
                'amount' => $car_no_and_bill[$i]['bill'],
                'updated_at' => $transaction->updated_at
              ];
              
              array_push($all_successful_data,$successful_data);
            }

          }else{
            $successful_data =  [
              'user_id' => $transaction->id,
              'user_name' => $transaction->user_name,
              'phone_no' => $transaction->phone_no,
              'wallet_no' => $transaction->wallet_no,
              'payment_id' => $transaction->payment_id,
              'trx_id' => $transaction->trx_id,
              'invoice_no' => $transaction->invoice_no,
              'car_no' => $car_no_and_bill[0]['car_no'],
              'amount' => $car_no_and_bill[0]['bill'],
              'updated_at' => $transaction->updated_at
            ];
            
            array_push($all_successful_data,$successful_data);

          }
      }
       return $all_successful_data;
      }

      return $successful_transactions; 
    } catch (Exception $e) {
      throw $e;
    }
  }

  public function refundTransaction($paymentID, $trxID, $amount, BkashCredential $credential)
  {
    try {
      $res = $this->httpClient()->post($credential->getURL('/tokenized/checkout/payment/refund'), [
        'json' => [
          'paymentID' => $paymentID,
          'trxID' => $trxID,
          'amount' => strval($amount),
          'sku' => 'no SKU',
          'reason' => 'Product quality issue'
        ],
        'headers' => $credential->getAccessHeaders($this->getAccessToken()),
        'connect_timeout' => 10,
        'read_timeout' => 30,
      ]);

      $response = json_decode($res->getBody()->getContents(), true);
       // database insert to bkash_refund table; 

       $this->storeLog('refund_transaction', $url, $headers, $body, $response);

      return $response;
    } catch (Exception $e) {
      throw $e;
    }
  }
}