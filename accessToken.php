<?php
$consumerKey = 'PiLpaMir2mlSnXFa2iXA27cvOMJ0HGvLeAEQxt9bILXBCROM';
$consumerSecret = 'YiBUvn0qbPDaQl0Z9gt1stIXiKnDrFAE5NtcOMXDdX3hVTuJHhQoFUsu4qYHUMYs';
$credentials = base64_encode($consumerKey . ':' . $consumerSecret);

$url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $credentials));
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($curl);

if($response === false){
    echo "Curl error: " . curl_error($curl);
} else {
    $data = json_decode($response);
    echo "Access Token: " . $data->access_token;
}

curl_close($curl);
?>
