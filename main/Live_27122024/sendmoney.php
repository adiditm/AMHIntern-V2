<?php

// Function to get the authentication token
function getAuthToken($clientId, $clientSecret) {
    $url = "https://api-sandbox.actionpay.id/v1/access-token";

    // Data for the POST request
    $data = json_encode([
        'grant_type' => 'client_credentials'
    ]);

    // Create context with headers and body
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => [
                'Authorization: Basic ' . base64_encode("$clientId:$clientSecret"),
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            ],
            'content' => $data
        ]
    ];

    // Create a stream context
    $context = stream_context_create($options);

    // Use file_get_contents to make the request
    $result = file_get_contents($url, false, $context);



    if ($result === FALSE) {
        die('Error fetching auth token');
    }

    $response = json_decode($result, true);
    
    return $response['data']['access_token'];
}

function getSignature($clientId, $clientSecret, $apiSecret, $data_inquiry) {
    
    $url ="https://api-sandbox.actionpay.id/v1/signature";
    

    $options = [
        'http' => [
            'header'  => [
                "Content-Type: application/json",
                          'Authorization: Basic ' . base64_encode("$clientId:$clientSecret"),
                    // "Content-Length: " . strlen($data),
                     "api-secret: $apiSecret"
            ],
            'method'  => 'POST',
            'content' => $data_inquiry
            ]
        ];

   
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        die('Error during get signature');
    }

    $response = json_decode($result, true);
    return $response;

   
    

}


function withdrawInquiry($accessToken, $signature, $data_inquiry) {
    $url = "https://api-sandbox.actionpay.id/v1/api/withdraw/inquiry";

    $header = ["platform: api", 
                "accesstoken: Bearer $accessToken", 
                "signature: $signature", 
                "Content-Type: application/json"
            ];
    $options = [
        'http' => [
            'header'  => $header,
            'method'  => 'POST',
            'content' => $data_inquiry,
        ],
    ];


    $context  = stream_context_create($options);
   // print_r($context);
    $result = file_get_contents($url, false, $context);
  //  print_r($result);

    if ($result === FALSE) {
        die('Error during withdraw inquiry');
    }

    $response = json_decode($result, true);
    return $response;
}



function withdrawConfirm($accessToken, $signature, $data_inquiry) {
    $url = "https://api-sandbox.actionpay.id/v1/api/withdraw";

    $header = ["platform: api", 
                "accesstoken: Bearer $accessToken", 
                "signature: $signature", 
                "Content-Type: application/json"
            ];
    $options = [
        'http' => [
            'header'  => $header,
            'method'  => 'POST',
            'content' => $data_inquiry,
        ],
    ];

   // echo $data_inquiry;

    $context  = stream_context_create($options);
   // print_r($context);
    $result = file_get_contents($url, false, $context);
  //  print_r($result);

    if ($result === FALSE) {
        die('Error during withdraw confirmation');
    }

    $response = json_decode($result, true);
    return $response;
}





// Replace with your actual client ID and secret
$clientId = '1f5b5e65-f9f0-4c92-a304-bd91ffdab72e';
$clientSecret = 'Qp2mdlGfmOK-zgf6';
$apiSecret = 'VkI0V3RkY3FVbHgtd25XUQ==';
$vNorek = "1010588100";
$vJumlah = 15000;
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
 $signatureAll = getSignature($clientId, $clientSecret, $apiSecret, $data_inquiry);
  $signature = $signatureAll['data']['signature'];

//  echo "Sig: $signature <br>";
// Example usage
 $accessToken = getAuthToken($clientId, $clientSecret);

//echo "Data Inquiry: ".$data_inquiry."<br>";

$response = withdrawInquiry($accessToken, $signature, $data_inquiry);
echo "Withdraw Inquiry Response: ";
print_r($response); echo "<br>";

 //$accessToken = getAuthToken($clientId, $clientSecret);

$vRef = 'MyRef';
$data_inquiry = "{
    \"address\":\"$vNorek\",
    \"amount\":$vJumlah,
    \"alias\":\"$vNamaAlias\",
    \"bankCode\":\"$vBankCode\",
    \"remarks\":\"$vRemark\",
    \"refId\":\"$vRef\"
}"; 

$signatureAll = getSignature($clientId, $clientSecret, $apiSecret, $data_inquiry);
$signature = $signatureAll['data']['signature'];

$response = withdrawConfirm($accessToken, $signature, $data_inquiry);
echo "Withdraw Confirm Response: ";
print_r($response);



?>