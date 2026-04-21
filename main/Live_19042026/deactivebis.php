<?
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





echo $vMsgAll.="<html><head><title>Deactive Old Pebisnis </title></head><body>";
echo $vMsg = "<h4>Cleaning Pabisnis</h4><br>";
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
 
   echo $vMsg ="==================================================================================================<br>";
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

   
   

   if ($vOP=='deactive') {   
   
	    $vsql="select *,datediff(now(),ftglaktif) as thediff from m_pebisnis where datediff(now(),ftglaktif) > 365 and faktif='1' and fidmember <> '1401-0000-0001'
order by ftglaktif ";
	   $dbin->query($vsql);
	   $vCount=0;$vArrData=array();
	    $db->query('START TRANSACTION;');
		
	   while ($dbin->next_record()) {
		   		$vArrData[]=$dbin->Record;
		    	$vCount++;
		        $vIdSys = $dbin->f('fidsys'); 
				$vIDMember=$dbin->f('fidmember'); 
				$vNama=$dbin->f('fnama'); 
				
				
		   		
		}  //while
		
		$db->query('COMMIT;');	
		//$oSystem->smtpmailer($oRules->getSettingByField('fmailbcc'),$vMailFrom,'AMHIntern','Auto Delete Member Tidak Aktif',$vData,"adiditm@gmail.com","",true);
	
	//Blokir lebih dari 1 tahun
	
		    
	   $dbin->query($vsql);
	   $vCountX=0;$vArrDataX=array();
	    $db->query('START TRANSACTION;');
		
	   while ($dbin->next_record()) {
		   		$vArrDataX[]=$dbin->Record;
		    	$vCountX++;
		        $vIdSys = $dbin->f('fidsys'); 
				$vIDMember=$dbin->f('fidmember'); 
			//	echo "$vIDMember :: $vNama <br>";
				$vNama=$dbin->f('fnama'); 
		   		$vSQLBlock="update m_pebisnis set faktif='0' where fidsys=$vIdSys";
				$db->query($vSQLBlock);
				
				$vSQLBlock="update m_admin set faktif='0' where fidmember='$vIDMember'";
				$db->query($vSQLBlock);

				echo "$vIDMember :: $vNama :: Tglaktif:: ".$dbin->f('ftglaktif')." Diff: ".$dbin->f('thediff')." $vSQLBlock  <br>";
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
		
		$oSystem->smtpmailer($oRules->getSettingByField('fmailbcc'),$vMailFrom,'AMHIntern','Auto deactive pebisnis lama',$vData,"amhtechs@gmail.com","",true);
	}
	
	
	$oSystem->smtpmailer($oRules->getSettingByField('fmailbcc'),$vMailFrom,'AMHIntern','Auto deactive pebisnis lama',$vData,"adiditm@gmail.com","",true);
	
	   
  echo  $vMsg ="==================================================================================================<br>";
	$vMsgAll .= $vMsg;	
	$vMsgAll .= $vData;	
		echo $vMsg="<br>$vCount pebisnis deactivated on ".$vNow."<BR>\n";
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
   $vFileName='../files/DeactiveBis'.date('Y-m-d_H.i.s').'.htm';
   if ($vCount >0){
	   $fp=fopen($vFileName,'w',true);
	   fputs($fp,$vMsgAll,10000000);
	   fclose($fp);
   }

  
?>
