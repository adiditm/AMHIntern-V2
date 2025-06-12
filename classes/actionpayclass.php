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
   /*
CREATE TABLE tb_actpcall_log (
	fid bigint(19) NOT NULL auto_increment,
	fendpoint varchar(255) NOT NULL,
	fcalling_for varchar(100),
	fmethod varchar(10) NOT NULL,
	frequest_payload text(65535),
	fresponse_payload text(65535),
	fstatus_code int(10) NOT NULL,
	fresponse_time_ms int(10),
	fclient_ip varchar(45),
	fcreated_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
	fupdated_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
	PRIMARY KEY (fid)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

   */
   
   class actionpay {

			// Function to get list bank
			
			
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
				echo $requestOptions = json_encode($options); // Convert options to JSON string for logging
				
			//	print_r($requestAll); // Debugging output


				$startTime = microtime(true); // Start timer

				$result = file_get_contents($url, false, $context); //Use @ to suppress warnings
				$endTime = microtime(true); // End timer
				$responseTime = round($endTime - $startTime, 3); // Response time in milliseconds
				$http_response_header_str = isset($http_response_header) ? implode("\r\n", $http_response_header) : '';

				if ($result === FALSE) {
						$error = error_get_last(); // Get last error
						$errorMessage = $error['message'];

						// Log the API call failure
						$vSQL = "INSERT INTO tb_actpcall_log (fendpoint, fcalling_for, fmethod, frequest_payload, fresponse_payload, fstatus_code, fresponse_time_ms, fclient_ip) VALUES (
							'$url',
							'getListBank',
							'GET',
							'".$requestOptions."',
							'".mysql_real_escape_string($errorMessage)."',
							NULL,
							'$responseTime',
							'".$_SERVER['REMOTE_ADDR']."'
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
					$vSQL = "INSERT INTO tb_actpcall_log (fendpoint, fcalling_for, fmethod, frequest_payload, fresponse_payload, fstatus_code, fresponse_time_ms, fclient_ip) VALUES (
						'$url',
						'getListBank',
						'GET',
						'".mysql_real_escape_string($requestHeader)."',
						'".mysql_real_escape_string($responseBody)."',
						'$responseCode',
						'$responseTime',
						'".$_SERVER['REMOTE_ADDR']."'
					)";
					$oDB->query($vSQL);

					return $response;
				}
			}
			
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
				$url = $oRules->getSettingByField("factpaywdconfirm");
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
   }

   $oActionPay=new actionpay;

?>
