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
$url_sign = $oRules->getSettingByField("factpaysign");
$vNorek = "1010588100";
$vJumlah = 15000000;
$vNamaAlias = 'Bambang Susetyo';
$vBankCode = 'demo';
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



$data_inquiry = '';


 //$accessToken = getAuthToken($clientId, $clientSecret);

// Get signature
echo "Client ID: $clientId <br>";
echo "Client Secret: $clientSecret <br>";
echo "API Secret: $apiSecret <br>";
echo "Data Inquiry: $data_inquiry (kosong)<br>";
echo "URL SIGNature : $url_sign <br>";
 $signatureAll = $oActionPay->getSignature($clientId, $clientSecret, $apiSecret, $data_inquiry);
  $signature = $signatureAll['data']['signature'];
 // echo "<br>Signature: "; print_r($signatureAll);
exit;
//  echo "Sig: $signature <br>";
// Example usage
 $accessToken = $oActionPay->getAuthToken($clientId, $clientSecret);

//echo "Data Inquiry: ".$data_inquiry."<br>";

$response = $oActionPay->depositRoute($accessToken, $signature);
//echo "Withdraw Inquiry Response: ";

 $vChannelID = $response['data'][0]['chId'];
 //$accessToken = getAuthToken($clientId, $clientSecret);

$vRef = 'MyRef' . rand(100, 999);
$vRand=  rand(100, 999);
 $data_inquiry = "{
\"address\":\"\",
\"amount\":15000000,
\"bankCode\":\"demo\",
\"alias\":\"Didit\",
\"remarks\":\"Deposit 1\",
\"type\":\"va\",
\"addressName\":\"Aminah\",
\"channelId\":\"$vChannelID\",
\"refId\":\"J000009$vRand\"
}";

$signatureAll = $oActionPay->getSignature($clientId, $clientSecret, $apiSecret, $data_inquiry);
$signature = $signatureAll['data']['signature'];

//echo "Signature: $signature <br>";
//echo "Access Token: $accessToken <br>";

$response = $oActionPay->doDeposit($accessToken, $signature, $data_inquiry);
//echo "Withdraw Confirm Response: ";

echo "Deposit Payload: <br>";
print_r($data_inquiry);

echo "Deposit Response: <br>";
print_r($response);

$response = json_encode($response, JSON_PRETTY_PRINT);
//$response = json_encode($response, JSON_PRETTY_PRINT);
echo $response;



?>
