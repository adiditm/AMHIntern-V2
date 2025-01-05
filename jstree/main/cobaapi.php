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
   include_once("../classes/espayclass.php");
   
   

 

//echo $oEspay->getBankBalance('009','0318017012');
//echo $oEspay->getBankAccName('009','0318017012');
 /*$vName= $oEspay->getBankAccName('009','0116896629');

$vArrResult = json_decode($vName,true);
$vBeneName=$vArrResult['beneficiary_account_name'];
//print_r($vArrResult);
echo $oEspay->transferFund('009','0318017012','009','0116896629',$vBeneName,20000,'Coba Transfer','TRX-00003');
//echo $oEspay->getStatusTrx('TRX-00002');*/
        
//$vURL="https://www.onotoko.co.id/xsystem/main/calcreal.php?op=compile&uAkhir=2018-11-17&uId=NNNNN_3";
$vURL="https://www.onotoko.co.id/xsystem/main/calcreal.php?uStart=0_89999999&uDate=2018-11-17&uId=NNNNN_3";
echo $oEspay->sendGet($vURL);
 ?> 
