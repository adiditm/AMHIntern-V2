<?
date_default_timezone_set('Asia/Jakarta');
$mtime = microtime(); 
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$starttime = $mtime; 
echo $vMsgAll.="<html><head><title>Compile Bonus Poin Reward Harian </title></head><body>";
$vMsg="";
$vThebul=date("n");
if ($vThebul % 2 == 0)
	$vBilang = 'even';
else $vBilang='odd';


   include_once("../server/config.php");

   include_once("../classes/memberclass.php");
   include_once(CLASS_DIR."dateclass.php");
   include_once("../classes/networkclass.php");
   include_once(CLASS_DIR."ifaceclass.php");
   include_once(CLASS_DIR."ruleconfigclass.php");
   include_once("../classes/komisiclass.php");
   include_once(CLASS_DIR."jualclass.php");
   include_once(CLASS_DIR."productclass.php");
   //echo "==================================================================================================";
  // $vMsg.="==================================================================================================";

  $vMonth=$_GET['uMonth'];
   if ($vMonth=="")
      $vMonth=date("m");
   $vYear=$_GET['uYear'];
   if ($vYear=="")
      $vYear=date("Y");
   $vMember=trim($_GET['uId']);
   $vStart=$_GET['uStart'];
   $vStartSplit=explode("_",$vStart);
   $vStartA=$vStartSplit[0];
   $vLimit=$vStartSplit[1];
   $vDateCompile=$_GET['uDate'];
   if ($vDateCompile=='')
       $vDateCompile=date("Y-m-d");
   
   
   $vDate=$oMydate->dateSub($vDateCompile,1,'day');
    $vNow=$vDateCompile." ".date("H:i:s"); 
   $vNowBns=$vDate." 23:59:59";
   //$vLimit=$_GET['uLimit'];
//   
  // $vProsenKembang = $oRules->getSettingByField('ffeekembang');
   $vPairSetFee = $oRules->getSettingByField('ffeepair');
   	  
   //$vPairFeeSet=$oRules->getSettingByField('ffeepair');	  
   ///$vPairFeeSet = 1; //Langsung nominal
   
   $vMaxKembangS=$oRules->getSettingByField('fmaxkems');
   $vMaxKembangG=$oRules->getSettingByField('fmaxkemg');	
   $vMaxKembangP=$oRules->getSettingByField('fmaxkemp');	
   $vMaxCFDay=$oRules->getSettingByField('fmaxcfday');	
   $vMaxPair=$oRules->getSettingByField('fmaxpairday');	
    $vPoinRwd=$oRules->getSettingByField('fpoinreward');	


   $vProsenCash=$oRules->getSettingByField('fprosencash');
   $vProsenWProd=$oRules->getSettingByField('fprosenwprod');
   //$vProsenWKit=$oRules->getSettingByField('fprosenwkit');
   //$vProsenWAcc=$oRules->getSettingByField('fprosenwacc');
   $vPTKPMonth=$oRules->getSettingByField('fptkp');
   $vPTKPYear=$oRules->getSettingByField('fptkpy');
   $vProsenNormaPPH=$oRules->getSettingByField('fnormapph');

   $vProsenAdm=$oRules->getSettingByField('ffeeadmin');

	$vProsenTaxNPWP=$oRules->getSettingByField('ftaxnpwp');
	$vProsenTaxNonNPWP=$oRules->getSettingByField('ftaxnonpwp');

	//$vProsenTaxNPWP=0;
	//$vProsenTaxNonNPWP=0;
   
     
   if (true) {   
   
	   $vsql="select * from m_anggota where ftglaktif not like '0000-00-00%' and fidmember like '%$vMember%'  order by fidsys  limit $vStartA,$vLimit";
	   $dbin->query($vsql);
	   $vCount=0;
	    $db->query('START TRANSACTION;');
	   while ($dbin->next_record()) {
	     $vCount+=1;
		 $vUser=$dbin->f('fidmember');
		 
/*		 $vPaket=$oMember->getPaketID($vUser);
		 if ($vPaket == 'S')
		   $vMaxPair=$vMaxKembangS;
		 else if ($vPaket == 'G') 
		   $vMaxPair=$vMaxKembangG; 
		 else if ($vPaket == 'P') 
		   $vMaxPair=$vMaxKembangP; 
*/		 
		 
		 
		 $vMemberName=$oMember->getMemberName($vUser);
	


		echo $vMsg="============================ Start Member <b style='color:#00f'>$vUser</b> ($vMemberName - $vPaket) ================================= <br>";
		 $vMsgAll.=$vMsg;
		

			   echo $vMsg="<br>Nilai Satuan Poin : ".number_format($vPoinRwd,0,",",".")."<br>";
			   $vMsgAll.=$vMsg;
	   
  
		 $vHasSpon=$oNetwork->hasSponsorship($vUser);
	
	
	

		 $vKakiL=$oNetwork->getDownLR($vUser,'L');
		 $vKakiR=$oNetwork->getDownLR($vUser,'R');
		 if ($vKakiL==-1)
		    $vKakiLText='[none]';
		 else $vKakiLText=$vKakiL;	
		 
		 if ($vKakiR==-1)
		    $vKakiRText='[none]';
		 else $vKakiRText = $vKakiR;	
		 
		 echo $vMsg="<br>Kaki Kiri Pertama : ".$vKakiLText; 
		  $vMsgAll.=$vMsg;
		 echo $vMsg="<br>Kaki Kanan Pertama: ".$vKakiRText; 
		  $vMsgAll.=$vMsg;
		// echo "<br>Sponsor Kiri Pertama : ".$vSponL; 
		// echo "<br>Sponsor Kanan Pertama: ".$vSponR; 

		 echo $vMsg="<br>";
		  $vMsgAll.=$vMsg;

		 
		 //Omzet dimulai dari kaki pertama
		$vSmallLeg ='';$vSmallLegNom=0;
		if ($vKakiL !=-1 && $vKakiL !='') {
		    //$OmzetDownL=$oKomisi->getOmzetROWholeMemberByDate($vKakiL,$vDate,$vDate); //nex
			$OmzetDownL=$oNetwork->getDownlineCountActivePeriod($vKakiL,$vDate,$vDate); //spectra, Ono
			//$OmzetDownL=$oKomisi->getOmzetFOWholeMemberByDate($vKakiL,$vDate,$vDate); //unig
			
		} else	 {
		    $OmzetDownL=0;
		}

		echo $vMsg="<font color='#0f0'>---->Omzet Kiri : $OmzetDownL </font><br>";	
		$vMsgAll.=$vMsg;
			
		if ($vKakiR !=-1 && $vKakiR !='') {
		    $OmzetDownR=$oNetwork->getDownlineCountActivePeriod($vKakiR,$vDate,$vDate); //ono
			//$OmzetDownR=$oKomisi->getOmzetFOWholeMemberByDate($vKakiR,$vDate,$vDate); //unig
			
		} else	{
		    $OmzetDownR=0;
//			$OmzetDownR = 100000000;
	//		$OmzetDownL = 200000000;
		}
		echo $vMsg="<font color='#0f0'>---->Omzet Kanan : $OmzetDownR </font><br>";	
		$vMsgAll.=$vMsg;
		
		
		$vCF=0;
		
		//$vCF=$oKomisi->getPairCF($vUser,$vDate);
		$vFeeID = "PR-".$vUser."-".$vDate;
	
			$vNPWP = $oMember->getMemField('fnpwp',$vUser);
			if (trim($vNPWP) != '')
			   $vProsenTax = $vProsenTaxNPWP;
			else    
			   $vProsenTax = $vProsenTaxNonNPWP;
			
		    
		  /* $vSQL="insert into tb_kom_pr(fidreceiver, fidregistrar, ffee,ffeenom, fcf,flr,ftanggal,fidfee)";
		   $vSQL.=" values('$vUser','system',$vPairFee,$vFeeNom,$vCFSisa,'$vCFLR','$vNowBns','$vFeeID')";*/
		   if ($OmzetDownL > 0){
			   $vAmount = $OmzetDownL;
			   $vFee = $vAmount * $vPoinRwd;
			

			   echo $vMsg="<font color='#0f0'>---->Insert PR : $vFee (dari omzet $vAmount)</font><br>";	
			   $vMsgAll.=$vMsg;
			   
			   $vNewBal =0;
			   $vDesc = "Poin Reward Rekrutment";
			   $vLastUser= 'sysrecruit';
			   $vSQL="INSERT INTO tb_kom_pr( fidmember, fidfunder, famount,ffee,fdebit,fbalance, ftanggal, fkind, ffeeunit, ffeestatus, fdesc, flastuser, flastupdate,fref)"; 
			   $vSQL .= "VALUES ('$vUser','SYSTEM', $vAmount, $vFee,0,$vNewBal, now(), 'poinday', 'poin', 'L', '$vDesc', '$vLastUser', now(),'$vFeeID');";
		  
			   $db->query($vSQL);
		   }
		    
		   
		   if ($OmzetDownR > 0){

			   
			   $vAmount = $OmzetDownR;
			   $vFee = $vAmount * $vPoinRwd;

			   echo $vMsg="<font color='#0f0'>---->Insert PR : $vFee (dari omzet $vAmount)</font><br>";	
			   $vMsgAll.=$vMsg;
			   
			   $vNewBal =0;
			   $vDesc = "Poin Reward Rekrutment";
			   $vLastUser= 'sysrecruit';
			   $vSQL="INSERT INTO tb_kom_pr( fidmember, fidfunder, famount,ffee,fdebit,fbalance, ftanggal, fkind, ffeeunit, ffeestatus, fdesc, flastuser, flastupdate,fref)"; 
			   $vSQL .= "VALUES ('$vUser','SYSTEM', $vAmount, $vFee,0,$vNewBal, now(), 'poinday', 'poin', 'R', '$vDesc', '$vLastUser', now(),'$vFeeID');";
		  
			   $db->query($vSQL);
		   }
		   
				
		}  //while
		$db->query('COMMIT;');	
		echo $vMsg="<br>$vCount member calculated on ".$vNow."<BR>\n";
		$vMsgAll.=$vMsg;

	} else { echo $vMsg="Bulan dan Tahun tidak boleh kosong!";  $vMsgAll.=$vMsg; }

   $mtime = microtime(); 
   $mtime = explode(" ",$mtime); 
   $mtime = $mtime[1] + $mtime[0]; 
   $endtime = $mtime; 
   $totaltime = ($endtime - $starttime); 
   echo "Total time  ".$totaltime." seconds"; 
   $vMsg.="Total time  ".$totaltime." seconds"; 
    $vMsg.="</body></html>";
   
  // mail("a_didit_m@yahoo.com","Bonus Pairing Compilation $vNow",$vMsg);
   $vFileName='../files/PRDayCompile'.date('Y-m-d_H.i.s').'.htm';
   $fp=fopen($vFileName,'w',true);
   fputs($fp,$vMsgAll,10000000);
   fclose($fp);

  
?>