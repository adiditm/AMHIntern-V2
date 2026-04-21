<?
   session_start();

  include_once "../server/config.php"; 
  include_once "../classes/memberclass.php";
  include_once "../classes/systemclass.php";
   include_once "../classes/komisiclass.php";
      include_once("../classes/ruleconfigclass.php");
   $vData = print_r($_REQUEST,true);
   		$vMailFrom=$oRules->getSettingByField('fmailadmin');
	$oSystem->smtpmailer($oRules->getSettingByField('fmailbcc'),$vMailFrom,'AMHIntern','Debug Transfer Saldo In',$vData,"amhtechs@gmail.com","",true);

   $fidmember=$_POST['code'];
   $famount=$_POST['amount'];
   $fsecurity=$_POST['security'];
   $fdesc = $_POST['desc'];
   
   $vSQLCheck = "select * from m_pebisnis where fidmember ='$fidmember'";
   $db->query($vSQLCheck);
   $db->next_record();
   $vCheckCount = $db->num_rows();
   
   $vSecCheck = md5($fidmember.$famount);
   if($vCheckCount >0) {
	   if ($fsecurity == $vSecCheck) {
		  
		    $vOldBal = $oMember->getMemFieldBis('fsaldovcr',$fidmember);
		   
		    $vNewBal = $vOldBal + $famount;
		   $oKomisi->insertMutasi($fidmember,'mlmsystem',date('Y-m-d H:i:s'),$fdesc,$famount,0,$vNewBal,'trans','');
		   $oMember->updateBalBis($fidmember,$vNewBal);
		   $vData = array(
		   		'code' => $fidmember,
				'oldbal' => $vOldBal,
				'credit' => $famount,
				'newbal' => $vNewBal,
				'desc'	 => $fdesc	
		   
		   );
		   
		   $vRet = array('status'=>'succeed','data'=>$vData,'message'=>'Transfer saldo sukses!') ; 
		   echo json_encode($vRet) ;   
		   
	   } else {
		 $vRet = array('status'=>'secinvalid','message'=>'Security check invalid!') ; 
		 echo json_encode($vRet) ;   
	   }
   } else {
		 $vRet = array('status'=>'refnotfound','message'=>'Pebisnis tidak ditemukan!') ; 
		 echo json_encode($vRet) ;   	   
   }


?>
