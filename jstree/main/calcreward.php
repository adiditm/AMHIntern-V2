<?
date_default_timezone_set('Asia/Jakarta');
$mtime = microtime(); 
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$starttime = $mtime; 


echo $vMsgAll.="<html><head><title>Compile Reward  </title></head><body>";
$vMsg="";

echo $vMsgAll.="<h3>Compile Reward  </h3>";
$vMsg="";
  
   include_once("../server/config.php");
   
   include_once ("../classes/memberclass.php");
   include_once(CLASS_DIR."dateclass.php");
   include_once("../classes/networkclass.php");
   include_once(CLASS_DIR."ifaceclass.php");
   include_once("../classes/ruleconfigclass.php");
   include_once("../classes/komisiclass.php");
   include_once(CLASS_DIR."jualclass.php");
   include_once(CLASS_DIR."productclass.php");
 //  echo "==================================================================================================";
 //  $vMsg.="==================================================================================================";
   $vMonth=$_GET['uMonth'];
   if ($vMonth=="")
      $vMonth=date("m");
   $vYear=$_GET['uYear'];
   if ($vYear=="")
      $vYear=date("Y");
   $vMember=$_GET['uId'];
   $vStart=$_GET['uStart'];
   $vStartSplit=split("_",$vStart);
   $vStartA=$vStartSplit[0];
   $vLimit=$vStartSplit[1];
   $vDateCompile=$_GET['uDate'];
   if ($vDateCompile=='')
       $vDateCompile=date("Y-m-d");
   $vDate=$_GET['uDate'];
   if ($vDate=='')
       $vDate=date("Y-m-d");
   
   $vDate=$oMydate->dateSub($vDate,1,'day');
   $vNow=$vDateCompile." ".date("H:i:s"); 
   //$vLimit=$_GET['uLimit'];
   $vByy=	 $oRules->getSettingByField('fbyyadmin');
   
   //Batas-batas
   $vExecutive=$oRules->getSettingByField('fthexecutive');
   $vExecutiveRwd=$oRules->getSettingByField('fthexecutive',1);
   	  
   $vPlatExec=$oRules->getSettingByField('fthplatexec');
   $vPlatExecRwd=$oRules->getSettingByField('fthplatexec',1);
   	  
   $vManager = $oRules->getSettingByField('fthmanager');
   $vManagerRwd = $oRules->getSettingByField('fthmanager',1);
   
   $vPlatMan=$oRules->getSettingByField('fthplatman');
   $vPlatManRwd=$oRules->getSettingByField('fthplatman',1);
   
   $vDirector=$oRules->getSettingByField('fthdirector');
   $vDirectorRwd=$oRules->getSettingByField('fthdirector',1);
   
   $vRyDir=$oRules->getSettingByField('fthrydirector');
   $vRyDirRwd=$oRules->getSettingByField('fthrydirector',1);
   //Rewards
   
   
   

   if (true) {   
   
	   $vsql="select * from m_anggota where ftglaktif not like '0000-00-00%' and fidmember like '%$vMember%'  order by fidsys  limit $vStartA,$vLimit";
	   $dbin->query($vsql);
	   $vCount=0;
	    $db->query('START TRANSACTION;');
	   while ($dbin->next_record()) {
	     $vCount+=1;
		 $vUser=$dbin->f('fidmember');
	
		 $vPaket=$dbin->f('fpaket');
		 $vLevelX=$dbin->f('flevel');
		 
		
	   
  

	     echo $vMsg="<br><font color='#00f'>========================================Start Member:".$vUser." ($vPaket) ($vLevelX)===================================</font><br>";
		 $vMsgAll .= $vMsg;
		 //KIRI
	     $vSQL="select coalesce(sum(ffeenom),0) as flfee from tb_kom_pr where fidreceiver = '$vUser' and flr='L' ";
		 $db->query($vSQL);
		 $db->next_record();
	 	 $vOmzetKiri = $db->f('flfee');
		
	     $vSQL="select coalesce(sum(ffeenom),0) as frfee from tb_kom_pr where fidreceiver = '$vUser' and flr='R' ";
		 $db->query($vSQL);
		 $db->next_record();
	 	 $vOmzetKanan = $db->f('frfee');
		 
		
		 
 		echo $vMsg="<br><font color='#f00'>Member: ".$vUser." Omzet Kiri: $vOmzetKiri, Omzet Kanan: $vOmzetKanan</font><br>";
		 $vMsgAll .= $vMsg;

		 $vSQL = "select * from m_rewards order by flevel ";
		 $db1->query($vSQL);
		 while ($db1->next_record()) {
			  $vSyarat = $db1->f('fjmlangg');
			  $vLevel = $db1->f('flevel');
			  $vNom = $db1->f('fnominal');
			  $vReward = $db1->f('freward');
			  
			  if ($vOmzetKiri >= $vSyarat && $vOmzetKanan >= $vSyarat) {
				  if ($vOmzetKiri <= $vOmzetKanan) {
					   $vLemah = 'Kiri';  
					   $vOmzet = $vOmzetKiri;
				  } else {
					   $vLemah = 'Kanan';   
					   $vOmzet = $vOmzetKanan;
				  }
			      $vFulFill = "Ya";
			  } else 	  
			      $vFulFill = "Tidak";
			//	$vFulFill ="Ya";  
			if ($vFulFill =='Tidak') $vFulFill .="<font color='#f00'>, no action taken!</font>";	  
			
			echo $vMsg="<font color='#0f0'>Memenuhi syarat  reward $vLevel (".number_format($vSyarat,0,",",".").") ?: $vFulFill</font><br>";
			 $vMsgAll .= $vMsg;
			if ($vFulFill == "Ya") {
					$vSQL = "select * from tb_rewards where fkdanggota = '$vUser' and flevel='$vLevel'";
					$db->query($vSQL);
					$db->next_record();
					if ($db->num_rows() <=0) {

					   $vRewardDesc=$vReward ." / ".number_format($vNom,0,",",".");
					   echo $vMsg="<font color='#00f'>Insert reward kaki lemah $vLemah $vLevel ($vRewardDesc) </font><br>";
						$vMsgAll .= $vMsg;

						
						$vSQL ="INSERT INTO tb_rewards(fkdanggota, flevel, fperingkat, fjmlanggota, fomzet, fnominal, frewarddesc, fpaid, fbukti, ftanggal, ftglpaid) "; 
						$vSQL .="VALUES ('$vUser', '$vLevel', '', '$vSyarat', '$vOmzet', '$vNom', '$vRewardDesc', '0', '',now(),null );";
						$db->query($vSQL);
					} else {
						$vRewardDesc=$vReward ." / ".number_format($vNom,0,",",".");
					   echo $vMsg="<font color='#f00'>Reward $vLevel ($vRewardDesc) already exist, no action taken!</font><br>";
						$vMsgAll .= $vMsg;
						
					}
			}
			   
		 }


		
		echo $vMsg="<br><font color='#00f'>========================================End Member:".$vUser." ($vPaket) ($vLevelX)===================================</font><br>";
		$vMsgAll.=$vMsg;
	  
		
	
				
		
				
		}  //while
		$db->query('COMMIT;');	
		echo $vMsg="<br>$vCount member calculated on ".$vNow."<BR>\n";
		$vMsgAll.=$vMsg;
		

	} else { echo  $vMsg= "Bulan dan Tahun tidak boleh kosong!";   $vMsgAll.=$vMsg;}

   $mtime = microtime(); 
   $mtime = explode(" ",$mtime); 
   $mtime = $mtime[1] + $mtime[0]; 
   $endtime = $mtime; 
   $totaltime = ($endtime - $starttime); 
   echo $vMsg="Total time  ".$totaltime." seconds"; 
   $vMsgAll.=$vMsg;
    $vMsgAll.="</body></html>";
   
  // mail("a_didit_m@yahoo.com","Bonus Pairing Compilation $vNow",$vMsg);
   $vFileName='../files/RewardCompile'.date('Y-m-d_H.i.s').'.htm';
   $fp=fopen($vFileName,'w',true);
   fputs($fp,$vMsgAll,10000000);
   fclose($fp);

  
?>