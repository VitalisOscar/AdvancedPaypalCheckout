<?php
$config = [
    'BASE_URL' => 'https://api-m.sandbox.paypal.com/',
    'CLIENT_ID' => 'Aez1yzQiVRwL0M5cy9cD4fC3qCvg3JSUd1PvOlcgJnbscZHxl-Ex9TXFFAb6PDeuF5e4hPd0zkz0M9YH',
    'CLIENT_SECRET' => 'EL82vFMqyUqctnPF86-kCEtDn2rbRvXrAjhZOdSGNsXItqq-USHsKx-qHyi19q4gnqKLAk3Lxtcm-z1i',
];

$order_id = $_GET['order_id'];
$access_token = paypal_access_token();
$url = $config['BASE_URL'] . 'v2/checkout/orders/'.$order_id.'/capture';

$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);

curl_setopt($ch,CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $access_token,
]);
$result = curl_exec($ch);

$result = json_decode($result, true);

if($result['status'] ?? '' == 'COMPLETED'){
    echo json_encode([
        'message' => 'Thank you for your payment'
    ]);
}else if(isset($result['details'][0]['issue']) && $result['details'][0]['issue'] == 'ORDER_ALREADY_CAPTURED'){
    echo json_encode([
        'message' => 'Payment has already been captured'
    ]);
}else {
    echo json_encode([
        'message' => 'An error occurred'
    ]);
}

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