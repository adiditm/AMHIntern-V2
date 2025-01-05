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





echo $vMsgAll.="<html><head><title>Delete Temporary Member </title></head><body>";
echo $vMsg = "<h4>Cleaning Member</h4><br>";
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

   
   

   if ($vOP=='delete') {   
   
	    $vsql="select * from m_anggota where hour(timediff(now(),ftgldaftar)) >= '48' and faktif='0'";
	   $dbin->query($vsql);
	   $vCount=0;$vArrData=array();
	    $db->query('START TRANSACTION;');
		
	   while ($dbin->next_record()) {
		   		$vArrData[]=$dbin->Record;
		    	$vCount++;
		        $vIdSys = $dbin->f('fidsys'); 
				$vIDMember=$dbin->f('fidmember'); 
				echo "$vIDMember :: $vNama <br>";
				$vNama=$dbin->f('fnama'); 
		   		$vSQLDel="delete from m_anggota where fidsys=$vIdSys";
				$db->query($vSQLDel);
		}  //while
		
		$db->query('COMMIT;');	
		//$oSystem->smtpmailer($oRules->getSettingByField('fmailbcc'),$vMailFrom,'AMHIntern','Auto Delete Member Tidak Aktif',$vData,"adiditm@gmail.com","",true);
	
	//Blokir lebih dari 1 tahun
	
		    $vsql="select * from m_pebisnis  where  DATEDIFF(now(),ftglaktif) >365 ;";
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
		   		 $vSQLBlock="update   m_admin set faktif='4'  where fidsys=$vIdSys";
		   	//echo "<br>";
			//	$db->query($vSQLBlock);
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
		
		$oSystem->smtpmailer($oRules->getSettingByField('fmailbcc'),$vMailFrom,'AMHIntern','Auto Delete Member Tidak Aktif',$vData,"amhtechs@gmail.com","",true);
	}
	
	
	$oSystem->smtpmailer($oRules->getSettingByField('fmailbcc'),$vMailFrom,'AMHIntern','Auto Delete Member Tidak Aktif',$vData,"adiditm@gmail.com","",true);
	
	   
  echo  $vMsg ="==================================================================================================<br>";
	$vMsgAll .= $vMsg;	
	
		echo $vMsg="<br>$vCount member deleted on ".$vNow."<BR>\n";
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
   $vFileName='../files/DelTemp'.date('Y-m-d_H.i.s').'.htm';
   if ($vCount >0){
	   $fp=fopen($vFileName,'w',true);
	   fputs($fp,$vMsgAll,10000000);
	   fclose($fp);
   }

  
?>
