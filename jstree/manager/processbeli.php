<?

   session_start();

   $vRefer=$_SERVER['HTTP_REFERER'];

   $vQString=$_SERVER['QUERY_STRING'];

   include_once "../config.php";

   include_once "../classes/systemclass.php";

   include_once"../classes/networkclass.php";

   include_once"../classes/jualclass.php";

   include_once"../classes/komisiclass.php";

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
       $oSystem->jsAlert("Topup $vIDJual Cancelled");
	   $vsql="update tb_topup set fstatusrow=4,ftglappv=now(),fadmin='$vAdmin' where fidtopup='$vIDJual'";
	   $db->query($vsql);
	   $oSystem->jsLocation("admin.php?menu=veritop");
  }
       
        
   if ($vRever==$vCheck && $_SESSION['LoginUser']!="" && $vReverCancel=="") {
    $oJual->processTopup($vIDJual,$vAdmin);
	   
	$vEmail=$oMember->getEmail($vMember);
	if ($vEmail==-1) $vEmail=$oRules->getMailFrom();
	$vNama=$oMember->getMemberName($vMember);
	
	
	$vFrom=$oRules->getMailFrom(1);
	$vIsiAct="Topup  $vRef Anda sudah diproses";
	$vMessage="$vNama, $vIsiAct  \n\n";
    $vMessage.="Terima kasih atas topup Anda.\n\n";
	$vSMTP="localhost";
	//$oSystem->sendMail($vFrom,$vEmail,$vNama,$oRules->getMailBCC(1),$oRules->getSubjAct(1),$vMessage,$vSMTP); 

	$vMesgSMS="$vNama, selamat Topup Anda ID $vIDJual sudah diapprove, salam dan sukses!";
	$vNoHP=$oMember->getNoHP($vID);
//	$oSystem->smsGateway(date("Y-m-d H:i:s"),preg_replace("/^0/","62",$vNoHP),$vMesgSMS,'Aktifasi Investasi');	
	
	//$oSystem->jsAlert($vEmail);
	$oSystem->jsAlert("Topup $vRef Processed!");
	$oSystem->jsLocation("../manager/veritop.php");
	
}
  

?>