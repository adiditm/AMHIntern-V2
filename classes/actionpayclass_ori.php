<?php

//include_once("../server/config.php");

//print_r($_POST);

   include_once($CLASS_DIR."memberclass.php");
   include_once($CLASS_DIR."dateclass.php");
   include_once($CLASS_DIR."networkclass.php");
   include_once($CLASS_DIR."ifaceclass.php");
   include_once($CLASS_DIR."ruleconfigclass.php");
   include_once($CLASS_DIR."komisiclass.php");
   include_once($CLASS_DIR."jualclass.php");
   include_once($CLASS_DIR."systemclass.php");
   include_once($CLASS_DIR."productclass.php");
   include_once($CLASS_DIR."texttoimageclass.php");
   
   
   class actionpay {

				function getListBank() {
				global $oRules, $oDB; // Use $oDB instead of $db
				$url = $oRules->getSettingByField("factpaylistbank");

				$header = ["platform: api",
				"Content-Type: application/json"
				];
				// Create context with headers and body
				$options = [
				'http' => [
					'method' => 'GET',
					'header' => $header
				]
				];
				// Create a stream context
				$context = stream_context_create($options);

				$requestHeader = json_encode($header); // Convert header array to JSON string for logging
				$startTime = microtime(true); // Start timer

				$result = @file_get_contents($url, false, $context); //Use @ to suppress warnings
				$endTime = microtime(true); // End timer
				$responseTime = round($endTime - $startTime, 3); // Response time in milliseconds
				$http_response_header_str = isset($http_response_header) ? implode("\r\n", $http_response_header) : '';

				if ($result === FALSE) {
						$error = error_get_last(); // Get last error
						$errorMessage = $error['message';

						// Log the API call failure
						$vSQL = "INSERT INTO tb_actpcall_log (api_name, request_url, request_header, response_code, response_body, error_message) VALUES (
							'getListBank',
							'$url',
							'".mysql_real_escape_string($requestHeader)."',
							NULL,
							NULL,
							'".mysql_real_escape_string($errorMessage)."'
						)";

						$oDB->query($vSQL);


						die('Error fetching auth token: ' . $errorMessage);
				} else {
					$response = json_decode($result, true);
					//Get Response Code
					$responseCode = 200;
					if (isset($http_response_header)) {
						foreach ($http_response_header as $headerLine) {
						if (strpos($headerLine, 'HTTP/') === 0) {
							preg_match('{HTTP/\S*\s(\d+)}', $headerLine, $match);
							$responseCode = (int)$match[1];
							break;
						}
						}
					}

					$responseBody = json_encode($response); // Convert response to JSON string for logging

					// Log the API call success
					$vSQL = "INSERT INTO tb_actpcall_log (api_name, request_url, request_header, response_code, response_body, error_message) VALUES (
						'getListBank',
						'$url',
						'".mysql_real_escape_string($requestHeader)."',
						'$responseCode',
						'".mysql_real_escape_string($responseBody)."',
						NULL
					)";
					$oDB->query($vSQL);

					return $response;
				}
			}

			// Function to get list bank
			function getListBankOld() {
				global $oRules;
				 $url = $oRules->getSettingByField("factpaylistbank");

				$header = ["platform: api", 
							"Content-Type: application/json"
						];
				// Create context with headers and body
				$options = [
					'http' => [
						'method' => 'GET',
						'header' => $header
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
				return $response;
			}


			// Function to get the authentication token
			function getAuthToken($clientId, $clientSecret) {
				global $oRules;
				$url = $oRules->getSettingByField("factpaytoken");
				// "https://api-sandbox.actionpay.id/v1/access-token";
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
		
		
		//Getting signature
			function getSignature($clientId, $clientSecret, $apiSecret, $data_inquiry) {
				global $oRules;
				 $url = $oRules->getSettingByField("factpaysign");
				//$url ="https://api-sandbox.actionpay.id/v1/signature";		
				/*$options = [
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
					print_r($options);
				$context  = stream_context_create($options);
				$result = file_get_contents($url, false, $context);
			*/
			
				$ch = curl_init();
				curl_setopt_array($ch, [
					CURLOPT_URL => $url,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_POST => true,
					CURLOPT_POSTFIELDS => $data_inquiry,
					CURLOPT_HTTPHEADER => [
						"Content-Type: application/json",
						'Authorization: Basic ' . base64_encode("$clientId:$clientSecret"),
						"api-secret: $apiSecret"
					]
				]);
				
				$result = curl_exec($ch);
				
				if (curl_errno($ch)) {
					die('Error during get signature: ' . curl_error($ch));
				}
				
				

				curl_close($ch);
				$response = json_decode($result, true);
				return $response;
				
			}

			//Withdraw Inquiry
			function withdrawInquiry($accessToken, $signature, $data_inquiry) {
				global $oRules;
				$url = $oRules->getSettingByField("factpaywdinqu");
				//$url = "https://api-sandbox.actionpay.id/v1/api/withdraw/inquiry";		
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
			
			
			//Withdraw Confirm
			function withdrawConfirm($accessToken, $signature, $data_inquiry) {
				global $oRules;
				echo $url = $oRules->getSettingByField("factpaywdconfirm");
				//$url = "https://api-sandbox.actionpay.id/v1/api/withdraw";
			
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
				$result = file_get_contents($url, false, $context);
			
				if ($result === FALSE) {
					die('Error during withdraw confirmation');
				}
			
				$response = json_decode($result, true);
				return $response;
			}
			
			
			//Deposit Route
			function depositRoute($accessToken, $signature, $data_inquiry) {
				global $oRules;

				$url = $oRules->getSettingByField("factpaydeproute");
				//$url = "https://api-sandbox.actionpay.id/v1/api/withdraw";

				$header = ["platform: api", 
							"accesstoken: Bearer $accessToken", 
							"signature: $signature", 
							"type: va",
							"Content-Type: application/json"
						];

						//echo "Token $accessToken signature $signature <br>";

				$options = [
					'http' => [
						'header'  => $header,
						'method'  => 'GET',
						//'content' => $data_inquiry,
					],
				];

			$context  = stream_context_create($options);
				$result = file_get_contents($url, false, $context);
			
				if ($result === FALSE) {
					die('Error during deposit route');
				}
			
				$response = json_decode($result, true);
				return $response;
			}


			//Deposit
			function doDeposit($accessToken, $signature, $data_inquiry) {
				global $oRules;

				$url = $oRules->getSettingByField("factpaydep");
				//$url = "https://api-sandbox.actionpay.id/v1/api/withdraw";

				/*$header = ["platform: api",
				"accesstoken: Bearer $accessToken",
				"signature: $signature",
				"platform: api",
				"Content-Type: application/json"
				];

				//echo "Token $accessToken signature $signature <br>";

				$options = [
					'http' => [
						'header'  => $header,
						'method'  => 'POST',
						'content' => $data_inquiry,
					],
				];

				//print_r($data_inquiry);
				$context  = stream_context_create($options);
				$result = file_get_contents($url, false, $context);
*/

				$ch = curl_init();
				$opt = [
					CURLOPT_URL => $url,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_POST => true,
					CURLOPT_POSTFIELDS => $data_inquiry,
					CURLOPT_HTTPHEADER => [
						"platform: api",
						"accesstoken: Bearer $accessToken",
						"signature: $signature",
						"Content-Type: application/json"
					]
				];
				curl_setopt_array($ch,$opt);

				$result = curl_exec($ch);

				if (curl_errno($ch)) {
					die('Error during request: ' . curl_error($ch));
				}

				curl_close($ch);

				//echo "<BR>DATA INQUIRY ";print_r(curl_setopt_array);
				//echo "<BR>CURL   ";print_r($opt);

				$response = json_decode($result, true);
				return $response;
			}
   }

   $oActionPay=new actionpay;

?>
