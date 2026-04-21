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

   $vCheck=md5('jalanku');

   $vCancel=md5('bataldeh');

   $vIssued=md5('issued');

   $vMember=$_GET['uUserID'];

   $vUser=$vMember;

   $vRef=$_GET['ref'];

   $vMonth=date("m");   

   $vYear=date("Y");   

   $vNoHP=$oMember->getNoHP($vUser);



  if ($vReverCancel==$vCancel) {//Cancel

       $oSystem->jsAlert("Withdraw $vIDJual Cancelled");

	   $vsql="update tb_withdraw set fstatusrow=4,ftglappv=now(),fadmin='$vAdmin' where fidwithdraw='$vIDJual'";

	   $db->query($vsql);

	   $oSystem->jsLocation("../manager/veriwith.php");

  }

       

        

   if ($vRever==$vCheck && $_SESSION['LoginUser']!="" && $vReverCancel=="") {

    $oJual->processWD($vIDJual,$vAdmin);

	   

	$vEmail=$oMember->getEmail($vMember);

	if ($vEmail==-1) $vEmail=$oRules->getMailFrom();

	$vNama=$oMember->getMemberName($vMember);

	

	

	$vFrom=$oRules->getMailFrom();

	$vIsiAct="Withdrawal  $vRef Anda sudah diproses";

	$vMessage="$vNama, $vIsiAct  \n\n";

    $vMessage.="Terima kasih atas Withdrawal Anda.\n\n";

	$vSMTP=$oRules->getSettingByField('fsmtp');

	//$oSystem->sendMail($vFrom,$vEmail,$vNama,$oRules->getMailBCC(),$oRules->getSubjAct(),$vMessage,$vSMTP); 
	 $oSystem->smtpmailer('a_didit_m@yahoo.com',$vFrom,'Aminah Tour',"Withdraw Approval",'Withdraw sudah diproses, terima kasih!','','',false);



	$vMesgSMS="$vNama, Withdrawal Anda ID $vIDJual sudah diapprove!";

	$vNoHP=$oMember->getNoHP($vID);

//	$oSystem->smsGateway(date("Y-m-d H:i:s"),preg_replace("/^0/","62",$vNoHP),$vMesgSMS,'Aktifasi Investasi');	

	

	//$oSystem->jsAlert($vEmail);

	$oSystem->jsAlert("Withdrawal $vRef Processed!");

	$oSystem->jsLocation("../manager/veriwith.php");

	

}

  



?>