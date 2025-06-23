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
$urldep = $oRules->getSettingByField("factpaydep");
$vNorek = "1010588100";
$vJumlah = 20000;
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
 $accessToken = $oActionPay->getAuthToken($clientId, $clientSecret);


// Get signature
echo "Client ID: $clientId <br>";
echo "Client Secret: $clientSecret <br>";
echo "API Secret: $apiSecret <br>";
echo "Data Inquiry: $data_inquiry (dikosongi)<br>";
echo "URL Get SIGNature : $url_sign <br>";

 $signatureAll = $oActionPay->getSignature($clientId, $clientSecret, $apiSecret, $data_inquiry);
  $signature = $signatureAll['data']['signature'];
  echo "<br>Signature: $signature"; 

//  echo "Sig: $signature <br>";
// Example usage
 

//echo "Data Inquiry: ".$data_inquiry."<br>";

$response = $oActionPay->depositRoute($accessToken, $signature);
echo "<br>Deposit Route Response: "; print_r($response['data'][0]);
foreach($response['data'] as $key => $value) {
    echo "$key <br>Channel ID: " . $value['chId'] . "<br>";
    echo "Bank Code: " . $value['mId'] . "<br>";
    echo "Bank Name: " . $value['mName'] . "<br>";
    echo "Channel Name: " . $value['chName'] . "<br>";
    echo "Channel Type: " . $value['chType'] . "<br>";
    echo "Channel Status: " . $value['chStatus'] . "<br>";
    echo "<hr>";
}
exit;
 $vChannelID = $response['data'][0]['chId'];
 $vBankCode = $response['data'][0]['mId'];
 //$accessToken = getAuthToken($clientId, $clientSecret);

$vRef = 'MyRef' . rand(100, 999);
$vRand=  rand(100, 999);
 $data_inquiry = "{
\"address\":\"\",
\"amount\":15000000,
\"bankCode\":\"$vBankCode\",
\"alias\":\"Didit\",
\"remarks\":\"Deposit 1\",
\"type\":\"va\",
\"addressName\":\"Aminah\",
\"channelId\":\"$vChannelID\",
\"refId\":\"J000009$vRand\"
}";

$signatureAll = $oActionPay->getSignature($clientId, $clientSecret, $apiSecret, $data_inquiry);
//print_r($signatureAll);
$signature = $signatureAll['data']['signature'];

echo "<br>Signature: $signature <br>";
//exit;
//echo "Access Token: $accessToken <br>";

echo "<br>Deposit URL :".$oRules->getSettingByField("factpaydep");
echo "<br>Deposit Param: ($accessToken, $signature, "; print_r($data_inquiry);
$response = $oActionPay->doDeposit($accessToken, $signature, $data_inquiry);
echo "<br>Deposit  Response: $response <br>";
//
//echo "Deposit Payload: <br>";
//print_r($data_inquiry);

//cho "Deposit Response: <br>";
//print_r($response);

$response = json_encode($response, JSON_PRETTY_PRINT);
//$response = json_encode($response, JSON_PRETTY_PRINT);
echo $response;



?>
