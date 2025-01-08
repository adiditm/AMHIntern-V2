<?php
include_once ("../server/config.php");
include_once ("../classes/ruleconfigclass.php");
include_once("../classes/actionpayclass.php");

$clientId = $oRules->getSettingByField('factpayclientid');
$clientSecret = $oRules->getSettingByField('factpayclientsec');
echo $token = $oActionPay->getAuthToken($clientId, $clientSecret);
exit;
$url = $oRules->getSettingByField('factpaytoken');
// URL to send the request to
//$url = "https://api-omni.actionpay.id/v1/access-token";

// Initialize cURL session
$ch = curl_init($url);

$data = '{
    "grant_type": "client_credentials"
}';

// Set cURL options
$vUserName = $oRules->getSettingByField('factpayclientid');
$vPass = $oRules->getSettingByField('factpayclientsec');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, "$vUserName:$vPass"); // Replace with actual username and password
curl_setopt($ch, CURLOPT_POST, true); // Use POST request
curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // Set the body data
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data))
);
// Execute the request and get the response
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