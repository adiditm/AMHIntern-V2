<?php

error_reporting(1);
include_once("../server/config.php");
 include_once("../classes/actionpayclass.php");
 include_once("../classes/ruleconfigclass.php");

// $bank = $oActionPay->getListBank();
//print_r($bank['status']);
 //exit;
// Replace with your actual client ID and secret
$clientId = $oRules->getSettingByField('factpayclientid');
$clientSecret = $oRules->getSettingByField('factpayclientsec');
$apiSecret = $oRules->getSettingByField('factpayapisec');
$vNorek = "1010588100";
$vJumlah = 10000;
$vNamaAlias = 'Bambang Susetyo';
$vBankCode = 'banten';
$vRemark = 'Okkkk';
$vRef = 'adawdawda';

 $data_inquiry = "{
    \"address\":\"$vNorek\",
    \"amount\":$vJumlah,
    \"alias\":\"$vNamaAlias\",
    \"bankCode\":\"$vBankCode\",
    \"remarks\":\"$vRemark\",
    \"refId\":\"$vRef\"
}"; 



// Get the access token
 //$accessToken = getAuthToken($clientId, $clientSecret);

// Get signature
 $signatureAll = $oActionPay->getSignature($clientId, $clientSecret, $apiSecret, $data_inquiry);
  $signature = $signatureAll['data']['signature'];

//  echo "Sig: $signature <br>";
// Example usage
 $accessToken = $oActionPay->getAuthToken($clientId, $clientSecret);

//echo "Data Inquiry: ".$data_inquiry."<br>";

$response = $oActionPay->withdrawInquiry($accessToken, $signature, $data_inquiry);
echo "Withdraw Inquiry Response: ";
print_r($response['data']['fees'][0]['feeamount']); echo "<br>";

 //$accessToken = getAuthToken($clientId, $clientSecret);

$vRef = 'MyRef' . rand(100, 999);
$data_inquiry = "{
    \"address\":\"$vNorek\",
    \"amount\":$vJumlah,
    \"alias\":\"$vNamaAlias\",
    \"bankCode\":\"$vBankCode\",
    \"remarks\":\"$vRemark\",
    \"refId\":\"$vRef\"
}"; 

$signatureAll = $oActionPay->getSignature($clientId, $clientSecret, $apiSecret, $data_inquiry);
$signature = $signatureAll['data']['signature'];

$response = $oActionPay->withdrawConfirm($accessToken, $signature, $data_inquiry);
echo "Withdraw Confirm Response: ";
print_r($response);



?>