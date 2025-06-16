<?php
include "../server/config.php";
include "../classes/actionpayclass.php";

// Function to get the authentication token
//echo file_get_contents("https://api-sandbox.actionpay.id/v1/api/withdraw");
//$error = error_get_last();
//print_r($error);
//exit;

// Replace with your actual client ID and secret
$clientId = '1f5b5e65-f9f0-4c92-a304-bd91ffdab72e';
$clientSecret = 'Qp2mdlGfmOK-zgf6';
$apiSecret = 'VkI0V3RkY3FVbHgtd25XUQ==';
$vNorek = "1010588100";
$vJumlah = 15000;
$vNamaAlias = 'Bambang Susetyo';
$vBankCode = 'banten';
$vRemark = 'Okkkk';
$vRef = 'adawdawdas';

 $data_inquiry = "{
    \"address\":\"$vNorek\",
    \"amount\":$vJumlah,
    \"alias\":\"$vNamaAlias\",
    \"bankCode\":\"$vBankCode\",
    \"remarks\":\"$vRemark\",
    \"refId\":\"$vRef\"
}"; 

// Get the access token

 $accessToken = $oActionPay->getAuthToken($clientId, $clientSecret);



 $signatureAll = $oActionPay->getSignature($clientId, $clientSecret, $apiSecret, $data_inquiry);
$signature = $signatureAll['data']['signature'];
//echo "Data Inquiry: ".$data_inquiry."<br>";

$response = $oActionPay->withdrawInquiry($accessToken, $signature, $data_inquiry);
echo "Withdraw Inquiry Response: ";
print_r($response); echo "<br>";

 //$accessToken = getAuthToken($clientId, $clientSecret);

$vRef = 'MyRef-0001';
$data_inquiry = "{
    \"address\":\"$vNorek\",
    \"amount\":$vJumlah,
    \"alias\":\"$vNamaAlias\",
    \"bankCode\":\"$vBankCode\",
    \"remarks\":\"$vRemark\",
    \"refId\":\"$vRef\"
}"; 



$response = $oActionPay->withdrawConfirm($accessToken, $signature, $data_inquiry);
echo "Withdraw Confirm Response: ";
print_r($response);



?>