<?php

//include_once("../server/config.php");

//print_r($_POST);

   include_once(CLASS_DIR."memberclass.php");
   include_once(CLASS_DIR."dateclass.php");
   include_once(CLASS_DIR."networkclass.php");
   include_once(CLASS_DIR."ifaceclass.php");
   include_once(CLASS_DIR."ruleconfigclass.php");
   include_once(CLASS_DIR."komisiclass.php");
   include_once(CLASS_DIR."jualclass.php");
   include_once(CLASS_DIR."systemclass.php");
   include_once(CLASS_DIR."productclass.php");
   include_once(CLASS_DIR."texttoimageclass.php");
   
   
   
   class anta {
	   
 		function sendRequest($pURL,$pData,  $pHeader) {
			//echo $pData;
			$curl = curl_init(); 
			curl_setopt($curl, CURLOPT_URL,$pURL);
		    curl_setopt($curl, CURLOPT_HTTPHEADER, $pHeader);
			curl_setopt($curl, CURLOPT_TIMEOUT, 30);
			curl_setopt($curl, CURLOPT_POST, 0); 
			curl_setopt($curl, CURLOPT_POSTFIELDS,$pData); 
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
			return curl_exec($curl);	   	
   			curl_close($curl);
   		}   


 		function sendPost($pURL,$pData,  $pHeader=null) {
		//	echo $pURL ; print_r($pData);
			$curl = curl_init(); 
			curl_setopt($curl, CURLOPT_URL,$pURL);
		    //curl_setopt($curl, CURLOPT_HTTPHEADER, $pHeader);
			curl_setopt($curl, CURLOPT_TIMEOUT, 30);
			curl_setopt($curl, CURLOPT_POST, 1); 
			curl_setopt($curl, CURLOPT_POSTFIELDS,$pData); 
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
			//curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
		//	curl_setopt($curl, CURLOPT_CUSTOMREQUEST,'POST');
			//curl_setopt($curl, CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
			 $vRet = curl_exec($curl);	   	
   			curl_close($curl);
	


			if ($vRet !='' && preg_match('<br />',$vRet)) {
				$vRet = explode('<br />',$vRet);
			
				return str_replace("\\n","",trim($vRet[2])) ;
			} else return $vRet;
			
   		}   
		
		
	function genPost($pURL,$pParam,$pCookie) {
				//echo $pParam;
				$curl = curl_init();
				//curl_setopt($curl, CURLOPT_SSLVERSION,3);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($curl, CURLOPT_HEADER, false);
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $pParam);
				curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
			//	curl_setopt($curl, CURLOPT_COOKIEFILE, $pCookie);
				//curl_setopt($curl, CURLOPT_COOKIESESSION,1);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				//curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
				curl_setopt($curl, CURLOPT_URL, $pURL);


				 $response = curl_exec($curl);
				curl_close ($curl);
				return $response;


	}
	
			
 		function sendGet($pURL) {
			$curl = curl_init(); 
			curl_setopt($curl, CURLOPT_URL,$pURL);
		  //  curl_setopt($curl, CURLOPT_HTTPHEADER, $pHeader);
			curl_setopt($curl, CURLOPT_TIMEOUT, 30);
			curl_setopt($curl, CURLOPT_POST, 0); 
			//curl_setopt($curl, CURLOPT_POSTFIELDS,$pData); 
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
			return curl_exec($curl);	   	
   			curl_close($curl);
   		}   
	   
        //ambil saldo bank
		function getBankBalance($pBankCode,$pBankAcc) {
			          global $oRules;

					  $vEspaySet = '';
					  $vHost = $_SERVER['HTTP_HOST']; 
					  if(preg_match("/trial/",$vHost) || preg_match("/training/",$vHost))
					    $vEspaySet='test'; 

					  $vClientID= trim($oRules->getSettingByField("fspclientidpay".$vEspaySet));
					  
					  $vRqUUID = $vClientID.rand();
					  $vRqDatetime = date("Y-m-d H:i:s");
					  $vBeneCode= $pBankCode;
					  $vBeneAcc=$pBankAcc;
					  $vSecret =trim($oRules->getSettingByField("fspscretkeypay".$vEspaySet));
					  
					 // $vStep1 = $vRqUUID.$vRqDatetime.$vClientID.$vBeneCode.$vBeneAcc;
					  $vStep1 = $vRqUUID.$vRqDatetime.$vClientID.$vBeneCode;
					  $vStep2 = strtoupper($vStep1).$vSecret;
					  $vHash = hash('sha256',$vStep2);
					  
					  $vUserHTTP =  trim($oRules->getSettingByField("fsphttpuserpay".$vEspaySet));
					  $vPassHTTP =trim($oRules->getSettingByField("fsphttppasspay".$vEspaySet));
					  $vSign = base64_encode("$vUserHTTP:$vPassHTTP");
					  $vArrHead=array();
					  $vArrHead[]="Content-Type: application/x-www-form-urlencoded";
					  $vArrHead[]="Authorization: Basic $vSign";
					
					 $vData=array();
					 $vData['rq_uuid']=$vRqUUID;
					 $vData['rq_datetime']=$vRqDatetime;
					 $vData['sender_id'] = $vClientID;
					 $vData['signature'] = $vHash;
					 $vData['bank_code']=$vBeneCode;
					 $vData['account_number']=$vBeneAcc;
					
					 // $vData['beneficiary_bank_code']=$vBeneCode;
					// $vData['beneficiary_account_number']=$vBeneAcc;
					  
					   $vDataEnc =  http_build_query($vData);	
	
					 $vURL = trim($oRules->getSettingByField("fspbal".$vEspaySet));
					$vRes=$this->sendRequest($vURL,$vDataEnc,$vArrHead);
					return $vRes;


		}
		
		
       //ambil nama acc bank
		function getBankAccName($pBankCode,$pBankAcc) {
			          global $oRules;

					  $vEspaySet = '';
					  $vHost = $_SERVER['HTTP_HOST']; 
					  if(preg_match("/trial/",$vHost) || preg_match("/training/",$vHost))
					    $vEspaySet='test'; 
						
					  $vClientID= trim($oRules->getSettingByField("fspclientid".$vEspaySet));
					  
					  $vRqUUID = $vClientID.rand();
					  $vRqDatetime = date("Y-m-d H:i:s");
					  $vBeneCode= $pBankCode;
					  $vBeneAcc=$pBankAcc;
					  $vSecret =trim($oRules->getSettingByField("fspscretkey".$vEspaySet));
					  
					  $vStep1 = $vRqUUID.$vRqDatetime.$vClientID.$vBeneCode.$vBeneAcc;
					//  $vStep1 = $vRqUUID.$vRqDatetime.$vClientID.$vBeneCode;
					  $vStep2 = strtoupper($vStep1).$vSecret;
					  $vHash = hash('sha256',$vStep2);
					  
					  $vUserHTTP =  trim($oRules->getSettingByField("fsphttpuser".$vEspaySet));
					  $vPassHTTP =trim($oRules->getSettingByField("fsphttppass".$vEspaySet));
					  $vSign = base64_encode("$vUserHTTP:$vPassHTTP");
					  $vArrHead=array();
					  $vArrHead[]="Content-Type: application/x-www-form-urlencoded";
					  $vArrHead[]="Authorization: Basic $vSign";
					
					 $vData=array();
					 $vData['rq_uuid']=$vRqUUID;
					 $vData['rq_datetime']=$vRqDatetime;
					 $vData['sender_id'] = $vClientID;
					 $vData['signature'] = $vHash;
					
					 $vData['beneficiary_bank_code']=$vBeneCode;
					 $vData['beneficiary_account_number']=$vBeneAcc;
					  
					   $vDataEnc =  http_build_query($vData);	
	
					  $vURL = trim($oRules->getSettingByField("fspname".$vEspaySet));
					$vRes=$this->sendRequest($vURL,$vDataEnc,$vArrHead);
					return $vRes;


		}


    //Transfer
		function transferFund($pSourceBank,$pSourceAcc,$pBeneCode,$pBeneAccNo,$pBeneAccName,$pAmount,$pDesc,$pTrxID) {
			          global $oRules;
					  $vEspaySet = '';
					  $vHost = $_SERVER['HTTP_HOST']; 
					  if(preg_match("/trial/",$vHost) || preg_match("/training/",$vHost))
					    $vEspaySet='test'; 
					  
					  $vInqu =  $this->inquAccName($pBeneCode,$pBeneAccNo);
					  $vInquArr = json_decode($vInqu,true);
					//  print_r($vInquArr);
					  $pBeneAccName = $vInquArr['beneficiary_account_name'];
					  $pBeneBankName =  $vInquArr['beneficiary_bank_name'];
					  $vError = trim($vInquArr['error_message']);
					  if ($vError =='Success') {
								//  exit;
								  $pAmount = number_format($pAmount,2,".","");
								  $vClientID= trim($oRules->getSettingByField("fspclientidpay".$vEspaySet));
								  
								  $vRqUUID = $vClientID.rand();
								  $vRqDatetime = date("Y-m-d H:i:s");
						
								  $vSecret =trim($oRules->getSettingByField("fspscretkeypay".$vEspaySet));
								  
								  $vStep1 = $vRqUUID.$vRqDatetime.$vClientID.$pBeneCode.$pBeneAccNo.$pAmount;
							//	  $vStep1 = $vRqUUID.$vRqDatetime.$vClientID.$pBeneCode.$pAmount;
								  $vStep2 = strtoupper($vStep1).$vSecret;
								  $vHash = hash('sha256',$vStep2);
								  
								  $vUserHTTP =  trim($oRules->getSettingByField("fsphttpuserpay".$vEspaySet));
								  $vPassHTTP =trim($oRules->getSettingByField("fsphttppasspay".$vEspaySet));
								  $vSign = base64_encode("$vUserHTTP:$vPassHTTP");
								  $vArrHead=array();
								  $vArrHead[]="Content-Type: application/x-www-form-urlencoded";
								  $vArrHead[]="Authorization: Basic $vSign";
								
								 $vData=array();
								 $vData['rq_uuid']=$vRqUUID;
								 $vData['rq_datetime']=$vRqDatetime;
								 $vData['sender_id'] = $vClientID;
								 $vData['signature'] = $vHash;
								 $vData['transfer_type']="0";
								 $vData['source_bank_code']=$pSourceBank;
								 $vData['source_account_number']=$pSourceAcc;
								 $vData['beneficiary_bank_code']=$pBeneCode;
								 $vData['beneficiary_bank_name']=$pBeneBankName;
								 $vData['swift_code']="";
								 $vData['beneficiary_account_number']=$pBeneAccNo;
								 $vData['beneficiary_account_name']=$pBeneAccName;
								 $vData['beneficiary_email']="";
								 $vData['beneficiary_address1']="";
								 $vData['beneficiary_address2']="";
								 $vData['beneficiary_category']="";
								 $vData['beneficiary_citizenship']="";
								 $vData['amount']=$pAmount; 
								 $vData['transaction_id']=$pTrxID; 
								 $vData['transfer_reff']="";
								 $vData['description']=$pDesc; 
								 
								 $vData['description_detail']="";
								
								 // print_r($vData);
								   $vDataEnc =  http_build_query($vData);	
				
								 $vURL = trim($oRules->getSettingByField("fspfundtrans".$vEspaySet));
								$vRes=$this->sendRequest($vURL,$vDataEnc,$vArrHead);
								return $vRes;
					  } else {
						    return $vInqu;
					  }


		}
		

   //Inquiry Acc Name
		function inquAccName($pBeneCode,$pBeneAccNo) {
			          global $oRules;
					  $vEspaySet = '';
					  $vHost = $_SERVER['HTTP_HOST']; 
					  if(preg_match("/trial/",$vHost) || preg_match("/training/",$vHost))
					    $vEspaySet='test'; 
					  

					  $vClientID= trim($oRules->getSettingByField("fspclientidpay".$vEspaySet));
					  
					  $vRqUUID = $vClientID.rand();
					  $vRqDatetime = date("Y-m-d H:i:s");
			
					  $vSecret =trim($oRules->getSettingByField("fspscretkeypay".$vEspaySet));
					  
					  $vStep1 = $vRqUUID.$vRqDatetime.$vClientID.$pBeneCode.$pBeneAccNo;
				//	  $vStep1 = $vRqUUID.$vRqDatetime.$vClientID.$pBeneCode.$pAmount;
					  $vStep2 = strtoupper($vStep1).$vSecret;
					  $vHash = hash('sha256',$vStep2);
					  
					  $vUserHTTP =  trim($oRules->getSettingByField("fsphttpuserpay".$vEspaySet));
					  $vPassHTTP =trim($oRules->getSettingByField("fsphttppasspay".$vEspaySet));
					  $vSign = base64_encode("$vUserHTTP:$vPassHTTP");
					  $vArrHead=array();
					  $vArrHead[]="Content-Type: application/x-www-form-urlencoded";
					  $vArrHead[]="Authorization: Basic $vSign";
					
					 $vData=array();
					 $vData['rq_uuid']=$vRqUUID;
					 $vData['rq_datetime']=$vRqDatetime;
					 $vData['sender_id'] = $vClientID;
					 $vData['signature'] = $vHash;
					 $vData['beneficiary_bank_code']=$pBeneCode;
					 $vData['beneficiary_account_number']=$pBeneAccNo;


					
					//  print_r($vData);
					   $vDataEnc =  http_build_query($vData);	
	
					 $vURL = trim($oRules->getSettingByField("fspinquaccname".$vEspaySet));
					$vRes=$this->sendRequest($vURL,$vDataEnc,$vArrHead);
					return $vRes;


		}
		
		
   //ambil status Trx
		function getStatusTrx($pTrxID) {
			          global $oRules;

					  $vEspaySet = '';
					  $vHost = $_SERVER['HTTP_HOST']; 
					  if(preg_match("/trial/",$vHost) || preg_match("/training/",$vHost))
					    $vEspaySet='test'; 

					  $vClientID= trim($oRules->getSettingByField("fspclientid".$vEspaySet));
					  
					  $vRqUUID = $vClientID.rand();
					  $vRqDatetime =date("Y-m-d H:i:s");
					  $vSecret =trim($oRules->getSettingByField("fspscretkey".$vEspaySet));
					  
					  $vStep1 = $vRqUUID.$vRqDatetime.$vClientID.$pTrxID;
					//  $vStep1 = $vRqUUID.$vRqDatetime.$vClientID.$vBeneCode;
					  $vStep2 = strtoupper($vStep1).$vSecret;
					  $vHash = hash('sha256',$vStep2);
					  
					  $vUserHTTP =  trim($oRules->getSettingByField("fsphttpuser".$vEspaySet));
					  $vPassHTTP =trim($oRules->getSettingByField("fsphttppass".$vEspaySet));
					  $vSign = base64_encode("$vUserHTTP:$vPassHTTP");
					  $vArrHead=array();
					  $vArrHead[]="Content-Type: application/x-www-form-urlencoded";
					  $vArrHead[]="Authorization: Basic $vSign";
					
					 $vData=array();
					 $vData['rq_uuid']=$vRqUUID;
					 $vData['rq_datetime']=$vRqDatetime;
					 $vData['sender_id'] = $vClientID;
					 $vData['signature'] = $vHash;
					
					 $vData['transaction_id']=$pTrxID;
					 
				//	 print_r($vData);
					 
					  
					   $vDataEnc =  http_build_query($vData);	
	
					  $vURL = trim($oRules->getSettingByField("fspstattrx".$vEspaySet));
					$vRes=$this->sendRequest($vURL,$vDataEnc,$vArrHead);
					return $vRes;


		}		
		
		
		
		
   }



   $oAnta=new anta;

?>