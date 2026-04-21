<?php
date_default_timezone_set('Asia/Jakarta');
$mtime = microtime(); 
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$starttime = $mtime; 

function generateRandomString($length = 6) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}





echo $vMsgAll.="<html><head><title>Recheck status pulsa! </title></head><body>";
echo $vMsg = "<h4>Recheck status pulsa!</h4><br>";
      $vMsgAll .= $vMsg;

   include_once("../server/config.php");

   include_once("../classes/memberclass.php");
   include_once(CLASS_DIR."dateclass.php");
   include_once("../classes/networkclass.php");
   include_once(CLASS_DIR."ifaceclass.php");
   include_once("../classes/ruleconfigclass.php");
   include_once(CLASS_DIR."komisiclass.php");
   include_once(CLASS_DIR."jualclass.php");
   include_once("../classes/systemclass.php");
   include_once("../classes/productclass.php");
   include_once("../classes/antaclass.php");
   include_once("../classes/pulsaclass.php");
 
   echo $vMsg ="==================================================================================================<br>";
   
   $vUserAnta =$oRules->getSettingByField('fantauser');
  $vPassAnta = $oRules->getSettingByField('fantapass');
  
  
   $vMsgAll .= $vMsg; 
   $vMember=$_GET['uId'];
   $vStart=$_GET['uStart'];
   $vStartSplit=explode("_",$vStart);
   $vStartA=$vStartSplit[0];
   $vLimit=$vStartSplit[1];
   $vOP=$_GET['op'];	
   $vDateCompile=$_GET['uDate'];

   if ($vDateCompile=='')
       $vDateCompile=date("Y-m-d");
	   
	   
   
   $vDate=$oMydate->dateSub($vDateCompile,1,'day');
   $vNow=$vDateCompile." ".date("H:i:s"); 
   $vNowBns=$vDate." 23:59:59";

	
	
		$vMailFrom=$oRules->getSettingByField('fmailadmin');

   
   

   if ($vOP=='recheck') {   
   
	 $vsql="select * from  tb_trxpulsa where fstatustrx='1' and fidtrx like 'TP-%' limit 5";
	   $dbin->query($vsql);
	   $vCount=0;$vArrData=array();
	 
		
	   while ($dbin->next_record()) {
		    $vCount++;
		   		$vArrData[]=$dbin->Record;
		    	
		        $vIdSys = $dbin->f('fidsys'); 
				$vIDMember=$dbin->f('fidmember'); 
				$vIDTrx=$dbin->f('fidtrx'); 
				$vKet=$dbin->f('fket'); 
				
				//Getting status

		}  //while
		
	
		//$oSystem->smtpmailer($oRules->getSettingByField('fmailbcc'),$vMailFrom,'AMHIntern','Auto Delete Member Tidak Aktif',$vData,"adiditm@gmail.com","",true);
	
	//Blokir lebih dari 1 tahun
	
		  
			
	   $dbin->query($vsql);
	   $vCountX=0;$vArrDataX=array();
	    $db->query('START TRANSACTION;');
		
	   while ($dbin->next_record()) {
		   $vArrDataX[]=$dbin->Record;
		    	$vArrDataX[]=$dbin->Record;
		    	$vCountX++;
		   		$vIdSys = $dbin->f('fidsys'); 
				$vIDMember=$dbin->f('fidmember'); 
				$vIDTrx=$dbin->f('fidtrx'); 
				$vKet=$dbin->f('fket'); 
				$vRequestID = $dbin->f('fxmlsent'); 
				$vHarga = $dbin->f('fhrgamh'); 
				
				//Getting status
				 $vData = array("customer_id"=>$vMsisdn,'username'=>$vUserAnta,'password'=>$vPassAnta,'code'=>'','type'=>'','request_id'=>'AUH2HfiCPbOrl');
				 if ($vRequestID !='') { 
					  $vResult=$oPulsa->genPost("https://antautama.co.id/api_pulsa/prabayar/cek_prabayar.php",$vData,'');
					 $vArrResult = json_decode($vResult);  
					
					 $vStatus = $vArrResult->results->data->status_code;
					 if($vStatus=='2') 
					 		$vStatus='4';
					 else if($vStatus=='1') 
					 		$vStatus='0';
					 
					 
				 } else $vStatus = '4';
				$vSQLUpdate="update tb_trxpulsa set fstatustrx='$vStatus' where fidsys=$vIdSys";
				$db->query($vSQLUpdate);
				$vBal = 0;
				if ($vStatus=='4') {
					 $vDesc = "Koreksi penambahan (otomatis): $vKet";
					$vLastBal=$oMember->getMemFieldBis(fsaldovcr,$vIDMember);
				 	$vBal=$vLastBal+$vHarga;
				  	$oKomisi->insertMutasi($vIDMember,$vIDMember,date("Y-m-d H:i:s"),$vDesc,$vHarga,0,$vBal,'koreksi',$vIDTrx) ;
				  	$oMember->updateBalBis($vIDMember,$vBal);	
				}
			
			echo "$vIDMember :: $vIDTrx :: Tgl:: ".$dbin->f('ftglentry')." Ket: ".$dbin->f('fket').":: RequestID $vRequestID ::  $vSQLUpdate  <br>";
		}  //while
		
		$db->query('COMMIT;');	
	
	
	
	if ($vCount >0) {
		
		$vData="";
		foreach($vArrData as $key=>$val) {
		   $vData .= "<br>\nData $key: <br>\n";
		   foreach($val as $keyx=>$valx){
			   if (!is_numeric($keyx))
			   $vData .= "$keyx: $valx <br>\n";   
		   }
		}
		
		//$oSystem->smtpmailer($oRules->getSettingByField('fmailbcc'),$vMailFrom,'AMHIntern','Auto update status TRX pulsa',$vData,"amhtechs@gmail.com","",true);
	}
	
	
	//$oSystem->smtpmailer($oRules->getSettingByField('fmailbcc'),$vMailFrom,'AMHIntern','Auto update status TRX pulsa',$vData,"adiditm@gmail.com","",true);
	
	   
  echo  $vMsg ="==================================================================================================<br>";
	$vMsgAll .= $vMsg;	
	$vMsgAll .= $vData;	
		
		echo $vMsg="<br>$vCount transaction updated on ".$vNow."<BR>\n";
		$vMsgAll .= $vMsg;	

	} else { 
	   
	   echo $vMsg="Bulan dan Tahun tidak boleh kosong!";   
	   $vMsgAll .= $vMsg;
	}

   $mtime = microtime(); 
   $mtime = explode(" ",$mtime); 
   $mtime = $mtime[1] + $mtime[0]; 
   $endtime = $mtime; 
   $totaltime = ($endtime - $starttime); 
   
   echo $vMsg="Total time  ".$totaltime." seconds"; 
   $vMsgAll .= $vMsg;
   echo $vMsg="</body></html>";
   $vMsgAll .= $vMsg;
   
  // mail("a_didit_m@yahoo.com","Bonus Pairing Compilation $vNow",$vMsg);
   $vFileName='../files/RecheckPulsa'.date('Y-m-d_H.i.s').'.htm';
   if ($vCount >0){
	   $fp=fopen($vFileName,'w',true);
	   fputs($fp,$vMsgAll,10000000);
	   fclose($fp);
   }

  
?>
