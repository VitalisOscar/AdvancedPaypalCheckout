<?php
$config = [
    'BASE_URL' => 'https://api-m.sandbox.paypal.com/',
    'CLIENT_ID' => 'Aez1yzQiVRwL0M5cy9cD4fC3qCvg3JSUd1PvOlcgJnbscZHxl-Ex9TXFFAb6PDeuF5e4hPd0zkz0M9YH',
    'CLIENT_SECRET' => 'EL82vFMqyUqctnPF86-kCEtDn2rbRvXrAjhZOdSGNsXItqq-USHsKx-qHyi19q4gnqKLAk3Lxtcm-z1i',
];

$amount = $_POST['amount'];
$access_token = paypal_access_token();
$url = $config['BASE_URL'] . 'v2/checkout/orders';

$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'intent' => "CAPTURE",
    "purchase_units" => [
        [
            "amount" => [
                "currency_code" => "USD",
                "value" => $amount
            ],
        ],
    ],
    "payment_source" => [
        "paypal" => [
            "shipping_preference" => "Not Applicable",
            "experience_context" => [
                "payment_method_preference" => "IMMEDIATE_PAYMENT_REQUIRED",
                "brand_name" => "ABC",
                "locale" => "en-US",
                "landing_page" => "LOGIN",
                "user_action" => "PAY_NOW",
                "return_url" => "",
                "cancel_url" => "",
            ],
        ]
    ]
]));

curl_setopt($ch,CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $access_token,
]);
$result = curl_exec($ch);

$result = json_decode($result, true);

echo json_encode([
    'data' => $result['id'],
    'message' => 'Payment order initiated successfully'
]);

function paypal_access_token(){
    global $config;
    $url = $config['BASE_URL'] . 'v1/oauth2/token';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
    curl_setopt($ch, CURLOPT_USERPWD, $config['CLIENT_ID'] . ':' . $config['CLIENT_SECRET']);

    $result = curl_exec($ch);
    $result = json_decode($result, true);

    return $result['access_token'];
}
