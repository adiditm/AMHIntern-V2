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





echo $vMsgAll.="<html><head><title>Compile &amp;Birthday </title></head><body>";
$vMsg="";
  

   include_once("../server/config.php");

   include_once("../classes/memberclass.php");
   include_once("../classes/dateclass.php");
   include_once("../classes/networkclass.php");
   include_once(CLASS_DIR."ifaceclass.php");
   include_once("../classes/ruleconfigclass.php");
   include_once(CLASS_DIR."komisiclass.php");
   include_once(CLASS_DIR."jualclass.php");
   include_once("../classes/systemclass.php");
   include_once("../classes/productclass.php");
   //echo "==================================================================================================";
  // $vMsg.="==================================================================================================";

/*  $vMonth=$_GET['uMonth'];
   if ($vMonth=="")
      $vMonth=date("m");
   $vYear=$_GET['uYear'];
   if ($vYear=="")
      $vYear=date("Y");*/
   $vTop=$oMember->getFirstID();
   $vMember=$_GET['uId'];
   $vStart=$_GET['uStart'];
   $vStartSplit=split("_",$vStart);
   $vStartA=$vStartSplit[0];
   $vLimit=$vStartSplit[1];

   $vDateCompile=$_GET['uDate'];

   if ($vDateCompile=='')
       $vDateCompile=date("Y-m-d");
	   
	$vSubMail="Selamat Ulang Tahun";
	$vMailFrom = $oRules->getSettingByField('fmailadmin');
	$vUserPassGO=$oRules->getSettingByField('fuserpassgosms');
	$vUserPassGO = explode("/",$vUserPassGO);
	$vUserGO = $vUserPassGO[0];
	$vPassGO = $vUserPassGO[1];
	   
	   
   
   $vDate=$oMydate->dateSub($vDateCompile,1,'day');
   $vNow=$vDateCompile." ".date("H:i:s"); 
   $vNowBns=$vDate." 23:59:59";

	
	//echo "$vLastWeekStart : $vLastWeekEnd";
	//exit ;


   
   
 //  $vPairFeeSet = $vPairFeeSet / 100; 
   if (true) {   
   
	   $vsql="select *, DATE_FORMAT(ftgllahir, '%m-%d') as fbday  from m_anggota where ftglaktif not like '0000-00-00%' and fidmember like '%$vMember%'   order by fidsys  limit $vStartA,$vLimit";
	   $dbin->query($vsql);
	   $vCount=0;
	    $db->query('START TRANSACTION;');
	   while ($dbin->next_record()) {
	     $vCount+=1;
		 $vUser=$dbin->f('fidmember');
		$vNama=$dbin->f('fnama');
		 $vHP=$dbin->f('fnohp');
		 $vMailMem=$dbin->f('femail');
		  $vBDay=$dbin->f('fbday');
		   $vTL=$dbin->f('ftgllahir');
		   $vUmur=$oPhpdate->dateDiff('yyyy',$vTL,date('Y-m-d'));
		 
		$vIsiSMS=$oRules->getSettingByField('fsmsbday');
		$vIsiMail=$oRules->getSettingByField('fmailbday');
		 
		 
		 

		
		echo $vMsg="============================ Start Member <b style='color:#00f'>$vUser</b> ($vPaketText) ================================= <br>";
		$vMsgAll .= $vMsg;

		

	    	echo $vMsg="<font color='#0f0'>Check Ulang Tahun $vDateCompile : " ;
			$vMsgAll .= $vMsg;
	
		 
		    echo $vMsg="</font><br>";
			$vMsgAll .= $vMsg;



		    //Masukkan bonus
		    if ($vBDay == date('m-d')) {
				echo $vMsg="<font color='#00f'>Send birthday greeting to $vHP ..... </font><br>";
				$vMsgAll .= $vMsg;

//$vMailMem="a_didit_m@yahoo.com";
					 $vIsiMail=str_replace("{MEMNAME}",$vNama,$vIsiMail);
					 $vIsiMail=str_replace("{TAHUN}",$vUmur,$vIsiMail);
					 $vIsiMail=str_replace("{TANGGAL}",$vDateCompile,$vIsiMail);
					 
					  $vIsiSMS=str_replace("{MEMNAME}",$vNama,$vIsiSMS);
					  $vIsiSMS=str_replace("{TAHUN}",$vUmur,$vIsiSMS);
					   $vIsiSMS=str_replace("{TANGGAL}",$vDateCompile,$vIsiSMS);
				      $vRet=$oSystem->sendSMS($vHP, $vIsiSMS, $vUserGO, $vPassGO);
					  echo "Response SMS: $vRet <br>";
					 $oSystem->smtpmailer($vMailMem,$vMailFrom,'Onotoko',$vSubMail,$vIsiMail,'','',false);
				

			} else {
				echo $vMsg="<font color='#f00'><b>No action taken! </b></font><br>";
				$vMsgAll .= $vMsg;					
				
			}



		
		
		echo "============================ End Member <b>$vUser</b> ($vPaketText) ================================= <br>";
	  
		
	
				
		
				
		}  //while
		$db->query('COMMIT;');	
	
		echo $vMsg="<br>$vCount member calculated on ".$vNow."<BR>\n";
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
   $vFileName='../files/RemindBirthDay'.date('Y-m-d_H.i.s').'.htm';
   $fp=fopen($vFileName,'w',true);
   fputs($fp,$vMsgAll,10000000);
   fclose($fp);

  
?>