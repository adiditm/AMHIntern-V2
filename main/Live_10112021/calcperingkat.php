<?
date_default_timezone_set('Asia/Jakarta');
$mtime = microtime(); 
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$starttime = $mtime; 

$vMsgAll.="<html><head><title>Compile Bonus Titik </title></head><body>";

  
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
		 //$vHasSpon=$oNetwork->hasSponsorshipLR($vUser);
		 $vHasSpon=$oNetwork->hasSponsorship($vUser);
	
	
	

		 $vKakiL=$oNetwork->getDownLR($vUser,'L');
		 $vKakiR=$oNetwork->getDownLR($vUser,'R');
		 $vKarirKakiL=$oMember->getMemField('flevel',$vKakiL);
		 $vKarirKakiR=$oMember->getMemField('flevel',$vKakiR);		 

		 $vPaketKakiL=$oMember->getPaketID($vKakiL);
		 $vPaketKakiR=$oMember->getPaketID($vKakiR);
		 
		 echo $vMsg="<br>Kaki Kiri Pertama : ".$vKakiL; 
		 $vMsgAll.=$vMsg;
		 echo $vMsg="<br>Kaki Kanan Pertama: ".$vKakiR; 
		 $vMsgAll.=$vMsg;

		 echo $vMsg="<br>";
		 $vMsgAll.=$vMsg;

		 
		 //Omzet dimulai dari kaki pertama
		$vSmallLeg ='';$vSmallLegNom=0;
		if ($vKakiL !=-1 && $vKakiL !='') {
		   // $vOmzetDownL=$oKomisi->getOmzetROSetWholeMember($vKakiL);
		    $vOmzetDownL=$oNetwork->getDownlineCountActivePeriodPeringkat($vKakiL,'2016-01-01','2200-01-01');
			$vDLLCountE=$oNetwork->getDownlineCountCareer($vKakiL,'E');
			$vDLLCountPE=$oNetwork->getDownlineCountCareer($vKakiL,'PE');
			$vDLLCountM=$oNetwork->getDownlineCountCareer($vKakiL,'M');
			$vDLLCountPM=$oNetwork->getDownlineCountCareer($vKakiL,'PM');
			$vDLLCountD=$oNetwork->getDownlineCountCareer($vKakiL,'D');
			$vDLLCountRD=$oNetwork->getDownlineCountCareer($vKakiL,'RD');
		} else	{
		    $vOmzetDownL=0;
			$vDLLCountE=0;
			$vDLLCountPE=0;
			$vDLLCountM=0;
			$vDLLCountPM=0;
			$vDLLCountD=0;
			$vDLLCountRD=0;
			
		}
			
		if ($vKakiR !=-1 && $vKakiR !='') {
		   // $vOmzetDownR=$oKomisi->getOmzetROSetWholeMember($vKakiR);
		    $vOmzetDownR=$oNetwork->getDownlineCountActivePeriodPeringkat($vKakiR,'2016-01-01','2200-01-01');
			
			$vDLRCountE=$oNetwork->getDownlineCountCareer($vKakiR,'E');
			$vDLRCountPE=$oNetwork->getDownlineCountCareer($vKakiR,'PE');
			$vDLRCountM=$oNetwork->getDownlineCountCareer($vKakiR,'M');
			$vDLRCountPM=$oNetwork->getDownlineCountCareer($vKakiR,'PM');
			$vDLRCountD=$oNetwork->getDownlineCountCareer($vKakiR,'D');
			$vDLRCountRD=$oNetwork->getDownlineCountCareer($vKakiR,'RD');

		} else	{
		    $vOmzetDownR=0;
			$vDLRCountE=0;
			$vDLRCountPE=0;
			$vDLRCountM=0;
			$vDLRCountPM=0;
			$vDLRCountD=0;
			$vDLRCountRD=0;
			
		}
			
		if ($vPaketKakiL == 'S')
		   $vOmzetDownL+=1;
		else if ($vPaketKakiL == 'G')
		   $vOmzetDownL+=3;
		else if ($vPaketKakiL == 'P')
		   $vOmzetDownL+=7;

		if ($vPaketKakiR == 'S')
		   $vOmzetDownR+=1;
		else if ($vPaketKakiR == 'G')
		   $vOmzetDownR+=3;
		else if ($vPaketKakiR == 'P')
		   $vOmzetDownR+=7;

		
		if ($vKarirKakiL=='E')	
		   $vDLLCountE+=1;
		if ($vKarirKakiL=='PE')	
		   $vDLLCountPE+=1;
		if ($vKarirKakiL=='M')	
		   $vDLLCountM+=1;
		if ($vKarirKakiL=='PM')	
		   $vDLLCountPM+=1;
		if ($vKarirKakiL=='D')	
		   $vDLLCountD+=1;
		if ($vKarirKakiL=='RD')	
		   $vDLLCountRD+=1;



		if ($vKarirKakiR=='E')	
		   $vDLRCountE+=1;
		if ($vKarirKakiR=='PE')	
		   $vDLRCountPE+=1;
		if ($vKarirKakiR=='M')	
		   $vDLRCountM+=1;
		if ($vKarirKakiR=='PM')	
		   $vDLRCountPM+=1;
		if ($vKarirKakiR=='D')	
		   $vDLRCountD+=1;

		if ($vKarirKakiL=='RD')	
		   $vDLLCountRD+=1;

		//Checking Dari Atas
		if ($vHasSpon=='1') 
		    $vSS='Terpenuhi';
		else $vSS='Tidak';	

   		echo $vMsg="<br><font color='#f00'>Count of Director L : $vDLLCountD,  R : $vDLRCountD </font> ";	
		$vMsgAll.=$vMsg;
		echo $vMsg="<br><font color='#f00'>Count of Platinum Manager L : $vDLLCountPM,  R : $vDLRCountPM </font> ";
		$vMsgAll.=$vMsg;
		echo $vMsg="<br><font color='#f00'>Count of Manager L : $vDLLCountM,  R : $vDLRCountM </font> ";
		$vMsgAll.=$vMsg;
		echo $vMsg="<br><font color='#f00'>Count of Platinum Executive L : $vDLLCountPE,  R : $vDLRCountPE </font> ";
		$vMsgAll.=$vMsg;
		echo $vMsg="<br><font color='#f00'>Count of Executive L : $vDLLCountE,  R : $vDLRCountE </font> ";
		$vMsgAll.=$vMsg;
		echo $vMsg="<br><font color='#f00'>Omzet L : $vOmzetDownL,  R : $vOmzetDownR </font> ";
		$vMsgAll.=$vMsg;
		
		
		if ($vDLLCountD >= $vRyDir && $vDLRCountD >= $vRyDir) {//RD
		      if ($oKomisi->checkReward($vUser,'RD') == 0) {
				  echo $vMsg="<br><font color='#f00'>Count of Director L : $vDLLCountD,  R : $vDLRCountD </font> ";	
				  $vMsgAll.=$vMsg;
				  echo $vMsg="<br><font color='#00f'>Got Royal Director Level</font>";	
				  $vMsgAll.=$vMsg;
				  echo $vMsg="<br><font color='#f00'>Got Royal Director Reward $vRyDirRwd </font> ";	
				  $vMsgAll.=$vMsg;
				  $oKomisi->setReward($vUser,6,'RD',"L : $vDLLCountD,  R : $vDLRCountD",$vRyDirRwd);
				  $oMember->updateMemField('flevel',$vUser,'RD');
			  } else echo "<br><font color='#f0f'><b>Already got Royal Director, no action taken! </b></font> ";
		} else if ($vDLLCountPM >= $vDirector && $vDLRCountPM >= $vDirector) {//D
		      if ($oKomisi->checkReward($vUser,'D') == 0) {
				  echo $vMsg="<br><font color='#f00'>Count of Platinum Manager L : $vDLLCountPM,  R : $vDLRCountPM </font> ";
				  $vMsgAll.=$vMsg;
				  echo $vMsg="<br><font color='#00f'>Got Director Level</font>";	
				  $vMsgAll.=$vMsg;
				  echo $vMsg="<br><font color='#f00'>Got Director Reward $vDirectorRwd </font> ";			
				  $vMsgAll.=$vMsg;
				  $oKomisi->setReward($vUser,5,'D',"L : $vDLLCountPM,  R : $vDLRCountPM",$vDirectorRwd);	
				  $oMember->updateMemField('flevel',$vUser,'D');
			  } else echo "<br><font color='#f0f'><b>Already got Director, no action taken! </b></font> ";
		} else if ($vDLLCountM >= $vPlatMan && $vDLRCountM >= $vPlatMan) {//PM
			  if ($oKomisi->checkReward($vUser,'PM') == 0) {
				  echo $vMsg="<br><font color='#f00'>Count of Manager L : $vDLLCountM,  R : $vDLRCountM </font> ";
				  $vMsgAll.=$vMsg;
				  echo $vMsg="<br><font color='#00f'>Got Platinum Manager Level</font>";	
				  $vMsgAll.=$vMsg;
				  echo $vMsg="<br><font color='#f00'>Got Platinum Manager $vPlatManRwd </font> ";		
				  $vMsgAll.=$vMsg;
				  $oKomisi->setReward($vUser,4,'PM',"L : $vDLLCountM,  R : $vDLRCountM",$vPlatManRwd);		
				  $oMember->updateMemField('flevel',$vUser,'PM');
			  } else echo "<br><font color='#f0f'><b>Already got Platinum Manager, no action taken! </b></font> ";
		} else if ($vDLLCountPE >= $vManager && $vDLRCountPE >= $vManager) {//M
		      if ($oKomisi->checkReward($vUser,'M') == 0) {
				  echo $vMsg="<br><font color='#f00'>Count of Platinum Executive L : $vDLLCountPE,  R : $vDLRCountPE </font> ";
				  $vMsgAll.=$vMsg;
				  echo $vMsg="<br><font color='#00f'>Got Manager Level</font>";	
				  $vMsgAll.=$vMsg;
				  echo $vMsg="<br><font color='#f00'>Got Manager $vManagerRwd </font>";	
				  $vMsgAll.=$vMsg;
				  $oKomisi->setReward($vUser,3,'M',"L : $vDLLCountPE,  R : $vDLRCountPE",$vManagerRwd);			
				  $oMember->updateMemField('flevel',$vUser,'M');
			  } else echo "<br><font color='#f0f'><b>Already got Manager, no action taken! </b></font> ";
		} else if ($vDLLCountE >= $vPlatExec && $vDLRCountE >= $vPlatExec) {//PE
		     //echo "<br><font color='#f00'>Count of Executive L : $vDLLCountE,  R : $vDLRCountE </font> ";
		      if ($oKomisi->checkReward($vUser,'PE') == 0) {
				  echo $vMsg="<br><font color='#f00'>Count of Executive L : $vDLLCountE,  R : $vDLRCountE </font> ";
				  $vMsgAll.=$vMsg;
				  echo $vMsg="<br><font color='#00f'>Got Platinum Executive Level</font>";	
				  $vMsgAll.=$vMsg;
				  echo $vMsg="<br><font color='#f00'>Got Platinum Executive $vPlatExecRwd </font> ";			
				  $vMsgAll.=$vMsg;
				  $oKomisi->setReward($vUser,2,'PE',"L : $vDLLCountE,  R : $vDLRCountE",$vPlatExecRwd);	
				  $oMember->updateMemField('flevel',$vUser,'PE');
			  } else echo "<br><font color='#f0f'><b>Already got Platinum Executive, no action taken! </b></font> ";
		} else if ($vOmzetDownL >= $vExecutive && $vOmzetDownR >= $vExecutive) { //E
		      if ($oKomisi->checkReward($vUser,'E') == 0) {
				  echo $vMsg="<br><font color='#f00'>Omzet L : $vOmzetDownL,  R : $vOmzetDownR </font> ";
				  $vMsgAll.=$vMsg;
				  echo $vMsg="<br><font color='#00f'>Got  Executive Level</font> ";	
				  $vMsgAll.=$vMsg;
				  echo $vMsg="<br><font color='#f00'>Got  Executive $vExecutiveRwd </font> ";		
				  $vMsgAll.=$vMsg;
				  $oKomisi->setReward($vUser,1,'E',"L : $vOmzetDownL,  R : $vOmzetDownR",$vExecutiveRwd);		
				  $oMember->updateMemField('flevel',$vUser,'E');
			  } else echo "<br><font color='#f0f'><b>Already got Executive, no action taken! </b></font> ";
		} else {// Nothing
			  echo $vMsg="<br><font color='#f00'><b>No action taken! </b></font> ";	
			  $vMsgAll.=$vMsg;
			//  $oMember->updateMemField('flevel',$vUser,'');
			
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
   $vFileName='../files/PeringkatCompile'.date('Y-m-d_H.i.s').'.htm';
   $fp=fopen($vFileName,'w',true);
   fputs($fp,$vMsgAll,10000000);
   fclose($fp);

  
?>