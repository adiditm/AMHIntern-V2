<?php
date_default_timezone_set('Asia/Jakarta');
include_once "../server/config.php";
include_once "../classes/ruleconfigclass.php";
include_once "../classes/memberclass.php";
include_once "../classes/systemclass.php";
include_once "../classes/jualclass.php";
include_once "../classes/komisiclass.php";
include_once "../classes/ifaceclass.php";
include_once "../classes/dateclass.php";
include_once "../classes/networkclass.php";


//echo str_pad(33333, 5, '0', STR_PAD_LEFT);
//echo $oJual->getNextIDJual();

//echo $_SERVER['HTTPS'];
//getDownlineByPaket($pID,&$vout,$pStart,$pEnd,$pPaket)
//echo "ssssssssss";
//$oNetwork->getDownlineByPaket('UFC203110441',$Hasil,'2015-10-15','2015-10-15','B');
//print_r($Hasil);

//$a=$oKomisi->getPoint('UEC518118195','2016-02-01','2016-03-29');
//print_r($a);
 //$oNetwork->sendFeeCouple('dodolan',135000,$db);
// echo $vRoMaMonth = 	$oKomisi->getROMaMonth('nex001',2016, 8);
//echo $OmzetDownL=$oNetwork->getDownlineCountActivePeriod('nex002','2016-08-25','2016-08-25');
//echo $oRules->getSettingByField('fbonusro');
//echo date('H:i:s');
//$oSystem->smtpmailer("a_didit_m@yahoo.com","jerry@gmail.com","Jerry","Test Cron ".date('Y-m-d H:i:s'),"Body aja");
//echo date('Y-m-d H:i:s');
 //$vIsiSMS = $oRules->getSettingByField('fsmsreg');
 /*$vIsiSMS = $oRules->getSettingByField('fsmsbonusb');

	 	 $vIsiSMS=str_replace("{MEMID}","SMS9892893TY",$vIsiSMS);
		$vIsiSMS=str_replace("{PASSWD}",'111111',$vIsiSMS);
		$vIsiSMS=str_replace("{BONUSB}",'300.000',$vIsiSMS);
	echo	 $vIsiSMS=str_replace("{MEMNAME}","SUMEDANG LARANG",$vIsiSMS);


$a=$oSystem->sendSMS('08563482937', $vIsiSMS);
print_r($a);

*/

//echo $vLastBal = $oMember->getStockPosUnig('headoffice','P003');
 // echo $oJual->getKITNom('UNSCM5HCICUM');
// echo $oKomisi->getBonusAByDate('COBA1','2017-10-26 08:19:34','2017-10-26 08:19:34');
// echo $oInterface->getMenuContent('slider2text1');
 
/* $sms = "Selamat. Permohonan kredit manuk anda telah kami setujui.Terima kasih.(PT.BEP)";
$sms_final = str_replace(" ","%20",$sms); // setiap ada spasi akan diganti %20
$mobilephone="628124110039";
$ch = curl_init();
// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, "https://secure.gosmsgateway.com/masking/api/Send.php?username=YouNig&mobile=$mobilephone&message=$sms_final&password=hHjNGsjA");
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, 'Verifikasi');

// grab URL and pass it to the browser
$curlsend =curl_exec($ch);
print_r($curlsend);*/
//echo  $oSystem->sendSMS("62816562359",$sms_final,'YouNig','hHjNGsjA');;
// $vDateCompile='2018-03-01';
//echo $vLastDateMonth = $oMydate->dateSub($vDateCompile,1,'month'); 

 $oNetwork->sendFeeTitikCompress('YOUNIG15',20,1,'J2018092700001');
?>