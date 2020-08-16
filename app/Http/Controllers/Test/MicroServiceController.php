<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Microservice\SmsMicroservice;

class MicroServiceController extends Controller
{
    public function testGeofence(Request $request)
    {
        $client = new \GuzzleHttp\Client(['base_uri' => 'http://myradar-geofence:6000/']);
        $res = $client->post('observe', [
            'form_params' => [
                'car_id' => '5f2ae945683eeb76b6132b36',
                'lat' => 23.874988,
                'lng' => 90.365400,
            ]
        ]);
        return $res->getBody();
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
}
