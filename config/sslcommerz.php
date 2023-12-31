<?php
return [
    'projectPath' => env('PROJECT_PATH'),
    // For Live, use "https://securepay.sslcommerz.com"
    // For demo, use "https://sandbox.sslcommerz.com"
    'apiDomain' => env("API_DOMAIN_URL", "https://sandbox.sslcommerz.com"),
    'apiCredentials' => [
        'store_id' => env("STORE_ID","trust5efdea0a5bf78"),
        'store_password' => env("STORE_PASSWORD","trust5efdea0a5bf78@ssl"),
    ],
    'apiUrl' => [
        'make_payment' => "/gwprocess/v4/api.php",
        'transaction_status' => "/validator/api/merchantTransIDvalidationAPI.php",
        'order_validate' => "/validator/api/validationserverAPI.php",
        'refund_payment' => "/validator/api/merchantTransIDvalidationAPI.php",
        'refund_status' => "/validator/api/merchantTransIDvalidationAPI.php",
    ],
    'connect_from_localhost' => env("IS_LOCALHOST", true), // For Sandbox, use "true", For Live, use "false"
    'success_url' => '/subscriber/sslcommerz/success',
    'failed_url' => '/subscriber/sslcommerz/fail',
    'cancel_url' => '/subscriber/sslcommerz/cancel',
    'ipn_url' => '/subscriber/sslcommerz/ipn',
];
