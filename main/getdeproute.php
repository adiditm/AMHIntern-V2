<?php

// URL to send the request to
$url = "https://api-sandbox.actionpay.id/v1/api/deposit/route";

// Initialize cURL session
$ch = curl_init($url);

$data = '{
    "grant_type": "client_credentials"
}';


curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, false); // Use POST request


$response = curl_exec($ch);

// Check for errors
if(curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
} else {
    echo $response;
}

// Close cURL session
curl_close($ch);


?>