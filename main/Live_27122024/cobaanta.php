<?
session_start();
ini_set('display_errors', true);
error_reporting(E_ERROR);
include_once("../server/config.php");

//print_r($_POST);

   include_once(CLASS_DIR."memberclass.php");
   include_once(CLASS_DIR."dateclass.php");
   include_once("../classes/networkclass.php");
   include_once(CLASS_DIR."ifaceclass.php");
   include_once(CLASS_DIR."ruleconfigclass.php");
   include_once(CLASS_DIR."komisiclass.php");
   include_once(CLASS_DIR."jualclass.php");
   include_once(CLASS_DIR."systemclass.php");
   include_once(CLASS_DIR."productclass.php");
   include_once("../classes/pulsaclass.php");
   
   

 

//echo $oEspay->getBankBalance('009','0318017012');
//echo $oEspay->getBankAccName('009','0318017012');
 /*$vName= $oEspay->getBankAccName('009','0116896629');

$vArrResult = json_decode($vName,true);
$vBeneName=$vArrResult['beneficiary_account_name'];
//print_r($vArrResult);
echo $oEspay->transferFund('009','0318017012','009','0116896629',$vBeneName,20000,'Coba Transfer','TRX-00003');
//echo $oEspay->getStatusTrx('TRX-00002');*/
        
//$vURL="https://www.onotoko.co.id/xsystem/main/calcreal.php?op=compile&uAkhir=2018-11-17&uId=NNNNN_3";
				$vURLServer ="https://antautama.co.id/api_pulsa/pulsa_prabayar/proses_pulsa.php";
	

				 // $vResult=$oPulsa->getGoto($vURLServer,"");
				 $vData = array("customer_id"=>"08123110039",'username'=>'aminah','password'=>'dennis1','code'=>'p-tsel-5k');
				//    $vResult=$oPulsa->genPost($vURLServer,$vData,'');


				$pattern = '/\{(?:[^{}]|(?R))*\}/x';
				
				preg_match_all($pattern, $vResult, $matches);
				 $vJSon=$matches[0][0];
			//	print_r($vJSon);
				$vObjRes =json_decode($vJSon,true);
				//print_r($vObjRes);  
				$vResData = $vObjRes['results']['data'];
				//echo $vRequestId = $vResData['request_id'];
				 $vURLCheck = " https://antautama.co.id/api_pulsa/pulsa_prabayar/cek_pulsa.php";  
				 $vData = array("request_id"=>"AUYTe4c5o7",'username'=>'aminah','password'=>'dennis1');		
	
	
$request_id = 'AUYTe4c5o7';
$username = 'aminah';
$password = 'dennis1';

$data = array(
    'username' => $username,
    'password' => $password,
    'request_id' => $request_id
);

			
$url = 'https://antautama.co.id/api_pulsa/pulsa_prabayar/cek_pulsa.php';		
				$curls = curl_init();
				curl_setopt($curls, CURLOPT_URL, $url);
				curl_setopt($curls, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($curls, CURLOPT_SSL_VERIFYHOST, 0);
				//curl_setopt($curl, CURLOPT_HEADER, false);
				curl_setopt($curls, CURLOPT_POST, 1);
				curl_setopt($curls, CURLOPT_POSTFIELDS, $data);
			//	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
				curl_setopt($curls, CURLOPT_RETURNTRANSFER, true);
				//curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");

				
				curl_setopt($curls, CURLOPT_TIMEOUT, 60); //timeout in seconds


				echo $response = curl_exec($curls);				
				print_r($response);
				
				curl_close ($curls);
				
	
	
$url = 'https://antautama.co.id/api_pulsa/pulsa_prabayar/cek_pulsa.php';

$request_id = 'AUYTe4c5o7';
$username = 'aminah';
$password = 'dennis1';

$data = array(
    'username' => $username,
    'password' => $password,
    'request_id' => $request_id
);

$data_string = json_encode($data);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_TIMEOUT, 60); //timeout in seconds
$response = curl_exec ($ch);
//$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//$curl_error = curl_error($ch);
curl_close ($ch);

print_r($response);				
			//	echo  $vResultCheck=$oPulsa->genPost($vURLCheck,$vData,'');		
 ?> 
