<?php

// SSLCommerz configuration

return [
    'projectPath' => 'https://myradar.com.bd',
    // For Sandbox, use "https://sandbox.sslcommerz.com"
    // For Live, use "https://securepay.sslcommerz.com"
    'apiDomain' => env("API_DOMAIN_URL", "https://sandbox.sslcommerz.com"),
    'apiCredentials' => [
        'store_id' => env("STORE_ID", 'busin619b15dc25115'),
        'store_password' => env("STORE_PASSWORD", 'busin619b15dc25115@ssl'),
    ],
    'apiUrl' => [
        'make_payment' => "/gwprocess/v4/api.php",
        'transaction_status' => "/validator/api/merchantTransIDvalidationAPI.php",
        'order_validate' => "/validator/api/validationserverAPI.php",
        'refund_payment' => "/validator/api/merchantTransIDvalidationAPI.php",
        'refund_status' => "/validator/api/merchantTransIDvalidationAPI.php",
    ],
    'connect_from_localhost' => true, // For Sandbox, use "true", For Live, use "false"
    'success_url' => '/online-payment/success',
    'failed_url' => '/online-payment/fail',
    'cancel_url' => '/online-payment/cancel',
    'ipn_url' => '/online-payment/ipn',
];
