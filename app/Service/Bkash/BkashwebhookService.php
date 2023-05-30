<?php

namespace App\Service\Bkash;

use App\Util\BkashCredential;
use Illuminate\Support\Facades\Redis;
use URL;
use Illuminate\Support\Str;
use Exception;
use App\Entities\BkashWebhookTransaction;
use Auth;

class BkashwebhookService 
{
  

  public function __construct()
  {
    
  }



 public function BkashInstantPayloadStore($payload){


  BkashWebhookTransaction::create($payload);



 }
 public function AllBkashIpnData(array $params){


  //$query=BkashWebhookTransaction::all();//->orderBy('updated_at', 'DESC')->paginate(30);
  $query = BkashWebhookTransaction::orderBy('updated_at', 'DESC');

  // dd($query->where('trxID','4J420ANOyC'));

  if(array_key_exists('wallet', $params) && strlen($params['wallet'])) {
//dd($params['wallet']);

$query= $query->where('debitMSISDN', $params['wallet']);
  }
  if(array_key_exists('trxID', $params) && strlen($params['trxID'])){
  
    $query= $query->where('trxID', $params['trxID']);
  }
  return $query->paginate(2);;



 }



  


}