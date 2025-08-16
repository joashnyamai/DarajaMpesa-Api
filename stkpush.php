<?php
$accessTokenUrl = 'accessToken.php'; // Include or require your access token script
$consumerKey = 'PiLpaMir2mlSnXFa2iXA27cvOMJ0HGvLeAEQxt9bILXBCROM';
$consumerSecret = 'YiBUvn0qbPDaQl0Z9gt1stIXiKnDrFAE5NtcOMXDdX3hVTuJHhQoFUsu4qYHUMYs';
$shortcode = 'YOUR_SHORTCODE'; // Till or Paybill number
$lipanampesaOnlinePasskey = 'YOUR_PASSKEY';
$amount = 1; // Amount to charge
$phoneNumber = '2547XXXXXXXX'; // Customer phone number
$callbackUrl = 'https://yourdomain.com/callback.php';

// Get access token
$credentials = base64_encode($consumerKey . ':' . $consumerSecret);
$token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $token_url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $credentials));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($curl);
$data = json_decode($response);
$access_token = $data->access_token;
curl_close($curl);

// Prepare STK Push data
$timestamp = date('YmdHis');
$password = base64_encode($shortcode . $lipanampesaOnlinePasskey . $timestamp);

$stkPushData = [
    'BusinessShortCode' => $shortcode,
    'Password' => $password,
    'Timestamp' => $timestamp,
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => $amount,
    'PartyA' => $phoneNumber,
    'PartyB' => $shortcode,
    'PhoneNumber' => $phoneNumber,
    'CallBackURL' => $callbackUrl,
    'AccountReference' => 'TestPayment',
    'TransactionDesc' => 'Payment of X'
];

$stkPushUrl = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $stkPushUrl);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $access_token
));
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($stkPushData));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
if($response === false){
    echo "Curl error: " . curl_error($curl);
} else {
    echo "<pre>";
    print_r(json_decode($response));
    echo "</pre>";
}
curl_close($curl);
?>
