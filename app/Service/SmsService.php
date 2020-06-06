<?php

namespace App\Service;

use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\ClientException;
use App\Entities\SmsLog;


/**
 * Service for sending Text SMS
 */
class SmsService
{
    private $debug;

    function __construct($debug = false)
    {
        $this->debug = $debug;
    }

    public function send($phone, $content, $type = 'unknown')
    {
		if (env('APP_ENV') == 'test') {
			return FALSE;
		}

        $options = [
            'debug' => false,
            'form_params' => [
                'Username'  => config('sms.username'),
                'Password'  => config('sms.password'),
                'From'      => config('sms.sender'),
                'To'        => $phone,
                'Message'   => $content,
            ]
        ];

        SmsLog::create([
            'to' => $phone,
            'body' => $content,
            'type' => $type,
        ]);

        try {
            $client = new \GuzzleHttp\Client(['base_uri' => config('sms.api')]);
            $result = $client->post('SendTextMessage', $options);
        } catch (ClientException $e) {
            if ($this->debug) {
                return $e->getResponse()->getBody()->getContents();
            }
            return FALSE;
        }

        return $result->getBody();
    }
}
