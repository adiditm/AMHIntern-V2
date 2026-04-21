<?php
date_default_timezone_set('Asia/Jakarta');
$mtime = microtime(); 
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$starttime = $mtime; 

$vMsgAll.="<html><head><title>Send Mail </title></head><body>";

  
   include_once("../server/config.php");
   
   include_once ("../classes/memberclass.php");
   include_once(CLASS_DIR."dateclass.php");
   include_once("../classes/networkclass.php");
   include_once(CLASS_DIR."ifaceclass.php");
   include_once("../classes/ruleconfigclass.php");
   include_once("../classes/komisiclass.php");
   include_once(CLASS_DIR."jualclass.php");
   include_once(CLASS_DIR."productclass.php");
   include_once("../classes/espayclass.php");
   
   $vMember = "1401-0000-0001";
    $vBankCode ="00000";
    $vBank = "demo";
    $vVA = "1234567890";
       // $vMember = $oJual->getJualField($vRefId,'fidmember');
		$vMailTo = $oMember->getMemFieldBis('femail',$vMember);
		$vMailToName = $oMember->getMemFieldBis('fnama',$vMember);
		$vMailFrom=$oRules->getSettingByField('fmailadmin');
        echo "Member : $vMember , MailTo : $vMailTo , MailFrom : $vMailFrom  <br>";
//exit;
		$vBody = 'Yth. ' . $vMailToName . ", \n\n";
		$vBody .= 'Nomor Virtual Account : ' . $vVA . "\n";
		$vBody .= 'Jumlah Pembayaran : ' . number_format(20000,0,',','.') . "\n";
		$vBody .= 'Bank : ' . strtoupper($vBank) . "\n";
		
		$vBody .= 'Bank Code : ' . $vBankCode . "\n\n";
		$vBody .= 'Segera selesaikan pembayaran Anda'."\n";
		
		$vBody .= 'Catatan: Total nominal transaksi sudah termasuk admin bank sebesar ' . number_format($vFee,0,',','.') . "\n";
		
		if ($vMailTo == '' || $vMailTo == '-')  $vMailTo = 'amhtechs@gmail.com';
		$oSystem->smtpmailerHosting($vMailTo,$vMailToName,$vMailFrom,'AMH Techno',"Pembayaran Virtual Account",$vBody,$oRules->getSettingByField('fmailbcc'),'',false);

    $oSystem->smtpmailerHosting($vMailTo,$vMailToName,$vMailFrom,'AMH Techno',"Pembayaran Virtual Account",$vBody,$oRules->getSettingByField('fmailbcc'),'',false);


?>