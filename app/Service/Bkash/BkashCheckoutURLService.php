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

  public function createPayment($amount, BkashCredential $credential)
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
        'car_wise_bill' =>  Redis::command('GET', ['car_wise_bill']),
        'payment_id' => $response['paymentID'],
        'amount' => $response['amount'],
        'invoice_no' => $response['merchantInvoiceNumber'],
        'create_response' => $response,
        'execute_response' => null,
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

        $check_transaction->update([
          'wallet_no' => $response['customerMsisdn'],
          'execute_response' => $response,
          'is_successful' => true

        ]);

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
