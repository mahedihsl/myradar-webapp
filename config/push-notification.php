<?php

return array(

	// apns certificate generation process:
	// https://stackoverflow.com/questions/21250510/generate-pem-file-used-to-set-up-apple-push-notifications
    'ios' => array(
        'environment' => 'production',
        'certificate' => config_path() . '/cert/apns-prod-cert.pem',// expires on 10 Dec'20
        'passPhrase'  => '123456',
        'service'     => 'apns',
    ),
    'ios-dev' => array(
        'environment' => 'development',
        'certificate' => config_path() . '/cert/ios-prod-cert2.pem',
        'passPhrase'  => 'radar12!@',
        'service'     => 'apns',
    ),
    'android' => array(
        'environment' => 'production',
        'apiKey'      => env('FCM_KEY'),
        'service'     => 'gcm',
    )

);
