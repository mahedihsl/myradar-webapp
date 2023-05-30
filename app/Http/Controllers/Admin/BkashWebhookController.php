<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\BkashWebHookHelper;
use App\Events\BkashPaymentReceived;
use App\Service\Bkash\BkashwebhookService;

class BkashWebhookController extends Controller
{
    //
   public $helper;
   public $webhookservice;
    public function __construct()
    {
        $this->helper= new BkashWebHookHelper();
        $this->webhookservice= new BkashwebhookService();

    }


public function PayloadReceiver(Request $request){


$payload=json_decode($request->getContent(),true);



$this->helper->writeLog('Raw-Payload',json_encode($payload));



$messageType = $request->server('HTTP_X_AMZ_SNS_MESSAGE_TYPE');

$this->helper->writeLog('messageType',$messageType);




   //verify signature
   $signingCertURL = $payload['SigningCertURL'];
   $certUrlValidation = $this->helper->validateUrl($signingCertURL);
   if($certUrlValidation == '1'){
       $pubCert = $this->helper->get_content($signingCertURL);


       $signature = $payload['Signature'];
       $signatureDecoded = base64_decode($signature);

       $content = $this->helper->getStringToSign($payload);
       //dd($content);

       if($content!=''){
           $verified =1;//openssl_verify($content, $signatureDecoded, $pubCert, OPENSSL_ALGO_SHA1);
           //dd($verified);

           if($verified=='1'){
               if($messageType=="SubscriptionConfirmation"){

                        $subscribeURL = $payload['SubscribeURL'];
                        $this->helper->writeLog('Subscribe',$subscribeURL);
                    //    //subscribe
                    //    $url = curl_init($subscribeURL);
                    //    $curl_exec=curl_exec($url);

                    $ch = curl_init();

                    // Set the cURL options
                    curl_setopt($ch, CURLOPT_URL, $subscribeURL);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    // Execute the cURL request and store the response
                    $response = curl_exec($ch);



                    $this->helper->writeLog('Subscribtion-Result',$response);
               }
               else if($messageType=="Notification"){

                   $notificationData = $payload['Message'];

                   $this->helper->writeLog('NotificationData-Message',json_encode($notificationData));

                   $this->webhookservice->BkashInstantPayloadStore(json_decode($notificationData,true));

                  event(new BkashPaymentReceived(json_encode($payload)));

                 
                   //event(new ComplainCreated("test"));             

               }
           }
           else{

            $this->helper->writeLog('Openssl_error',json_encode(["message"=>"openssl failed"]));

           }
       }


   }


    }





    public function BkashWebhookView(Request $request){
        $params = $request->all();

  $ipdata=$this->webhookservice->AllBkashIpnData($params);
    return view('bkash.webhook.allBill')->with(compact('ipdata','params'));

    }




}
