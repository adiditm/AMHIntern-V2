<?
   session_start();
 
   $vRefer=$_SERVER['HTTP_REFERER'];
   $vQString=$_SERVER['QUERY_STRING'];
   include_once "../server/config.php";
   include_once CLASS_DIR."systemclass.php";
   include_once CLASS_DIR."networkclass.php";
   include_once CLASS_DIR."jualclass.php";
   include_once CLASS_DIR."komisiclass.php";
   include_once CLASS_DIR."memberclass.php";
   $vIDJual=$_GET['uIDJual'];
   $vAdmin=$_SESSION['LoginUser'];
   $vRever=$_GET['uSess'];
   $vReverCancel=$_GET['uCanc'];
   $vPayfor=$_GET['payfor'];
   $vCheck=md5('jalanku');
   $vCancel=md5('bataldeh');
   $vIssued=md5('issued');
   $vMember=$_GET['uUserID'];
   $vFrom=$_GET['from'];
   $vTo=$_GET['to'];
   $vNom=$_GET['nom'];
   $vKet=$_GET['ket'];
   $vUser=$vMember;
   $vRef=$_GET['ref'];
   $vMonth=date("m");   
   $vYear=date("Y");   
   $vNoHP=$oMember->getNoHP($vUser);

  if ($vReverCancel==$vCancel) {//Cancel
       $oSystem->jsAlert("Transfer saldo $vIDJual Cancelled");
	   $vsql="update tb_baltrans set fstatusrow=4,ftglappv=now(),fadmin='$vAdmin' where fidtrans='$vIDJual'";
	   $db->query($vsql);
	   $oSystem->jsLocation("admin.php?menu=appvtrans");
  }
       
        
   if ($vRever==$vCheck && $_SESSION['LoginUser']!="" && $vReverCancel=="") {
 //   $oJual->processPay($vIDJual,$vAdmin);
	$vProcess=$oJual->processTrans($vIDJual,$vAdmin,$vFrom,$vNom, $vKet, $vTo);
	   
	$vEmail=$oMember->getEmail($vMember);
	if ($vEmail==-1) $vEmail=$oRules->getMailFrom();
	$vNama=$oMember->getMemberName($vMember);
	
	
	$vFrom=$oRules->getMailFrom();
	$vIsiAct="Transfer Saldo  $vRef Anda sudah diproses";
	$vMessage="$vNama, $vIsiAct  \n\n";
    $vMessage.="Terima kasih .\n\n";
	$vSMTP=$oRules->getSettingByField('fsmtp');
	$oSystem->sendMail($vFrom,$vEmail,$vNama,$oRules->getMailBCC(1),$oRules->getSubjAct(1),$vMessage,$vSMTP); 

	$vMesgSMS="$vNama, selamat Transfer Saldo Anda ID $vIDJual sudah diapprove, salam dan sukses!";
	//$vNoHP=$oMember->getNoHP($vID);
//	$oSystem->smsGateway(date("Y-m-d H:i:s"),preg_replace("/^0/","62",$vNoHP),$vMesgSMS,'Aktifasi Investasi');	
	
	//$oSystem->jsAlert($vEmail);
	$oSystem->jsAlert("Transfer Saldo $vRef Processed!.");
	$oSystem->jsLocation("admin.php?menu=appvtrans");
	
}
  

?>