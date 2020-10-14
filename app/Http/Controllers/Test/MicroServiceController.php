<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Microservice\GeofenceMicroservice;
use App\Service\Microservice\ServiceException;
use App\Service\Microservice\SmsMicroservice;
use App\Service\Microservice\UserMicroservice;
use App\Service\Microservice\SocketMicroservice;

class MicroServiceController extends Controller
{
    public function socket(Request $request)
    {
        try {
            $service = new SocketMicroservice();

        $userId = '5f63f8719dbb7723d01f7396';
        $payload = [
            'title' => 'Socket Notification',
            'body' => 'Sent from new socket server via scarlet',
            'intent' => 'none',
        ];
        return $service->send($userId, $payload);
        } catch (ServiceException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function testGeofence(Request $request)
    {
        $car_id = '5f2ae945683eeb76b6132b36';
        // Outside geofence
        $lat = 23.874988;
        $lng = 90.365400;

        // Inside Geofence
        // $lat = 23.775418;
        // $lng = 90.364157;
        
        $service = new GeofenceMicroservice();
        $service->observe($car_id, $lat, $lng);
        return response()->json(['status' => 1]);
    }

    public function testPush(Request $request)
    {
        $client = new \GuzzleHttp\Client(['base_uri' => 'http://myradar-push:6001/']);
        $res = $client->post('send', [
            'form_params' => [
                'user_id' => '5b557d33fbe09d45b3017252',
                "payload" => [
                    "title" => "Test Push Microservice",
                    "body" => "Ignore this notification. This is for development purpose.",
                    "type" => 0
                ]
            ]
        ]);
        return $res->getBody();
    }

    public function testSms(Request $request)
    {
        $service = new SmsMicroservice();
        $res = $service->send('01627892968', 'Sms Microservice working', 'test');
        // $client = new \GuzzleHttp\Client(['base_uri' => 'http://myradar-sms:6002/']);
        // $res = $client->post('send', [
        //     'form_params' => [
        //         'phone' => '01627892968',
        //         'content' => 'Sms Microservice working',
        //         'type' => 'test'
        //     ]
        // ]);
        return $res;
    }

    public function testUser(Request $request)
    {
        try {
            $user_id = '5dc3d63b91c404000c19a62a';
            $service = new UserMicroservice();
            $response = $service->statusHistory($user_id);
            return $response;
        } catch (ServiceException $e) {
            return $e;
        }
    }
}
