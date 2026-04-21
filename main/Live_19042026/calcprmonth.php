<?
date_default_timezone_set('Asia/Jakarta');
$mtime = microtime(); 
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$starttime = $mtime; 
echo $vMsgAll.="<html><head><title>Compile Poin Reward RO </title></head><body>";
$vMsg="";
  

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
   if ($vMonth=="") {
      $vMonth=date("m");
   
		$vMonth = date('m', strtotime('first day of last month'));

   }
   $vYear=$_GET['uYear'];
   if ($vYear=="") {
      $vYear=date("Y");
	  $vYear = date('Y', strtotime('first day of last month'));
   }
   $vYearMonthData = $vYear."-".$vMonth;
   echo $vMsg="Year-Month Data: $vYearMonthData <br><br>";
   $vMember=trim($_GET['uId']);
   $vStart=$_GET['uStart'];
   $vStartSplit=split("_",$vStart);
   $vStartA=$vStartSplit[0];
   $vLimit=$vStartSplit[1];
   $vDateCompile=$_GET['uDate'];
   if ($vDateCompile=='')
       $vDateCompile=date("Y-m-d");
   
   
   $vDate=$oMydate->dateSub($vDateCompile,1,'day');
    $vNow=$vDateCompile." ".date("H:i:s"); 
   $vNowBns=$vDate." 23:59:59";
   //$vLimit=$_GET['uLimit'];
   
   $vProsenNetDev = $oRules->getSettingByField('fnetdev');
   	  $vMailFrom=$oRules->getSettingByField('fmailadmin');
   //$vPairFeeSet=$oRules->getSettingByField('ffeepair');	  
   ///$vPairFeeSet = 1; //Langsung nominal
   /*
   $vMaxKembangS=$oRules->getSettingByField('fmaxkems');
   $vMaxKembangG=$oRules->getSettingByField('fmaxkemg');	
   $vMaxKembangP=$oRules->getSettingByField('fmaxkemp');	


   $vProsenCash=$oRules->getSettingByField('fprosencash');
   $vProsenWProd=$oRules->getSettingByField('fprosenwprod');
   
   //$vProsenWKit=$oRules->getSettingByField('fprosenwkit');
   //$vProsenWAcc=$oRules->getSettingByField('fprosenwacc');
   */
   
   $vPTKPMonth=$oRules->getSettingByField('fptkp');
   $vPTKPYear=$oRules->getSettingByField('fptkpy');
   $vProsenNormaPPH=$oRules->getSettingByField('fnormapph');
   //$vRealPPH=$oRules->getSettingByField('fpph');
   //$vReqNetDev=$oRules->getSettingByField('freqnetdev');
   $vProsenNetDev=$oRules->getSettingByField('fnetdev');
	$vProsenAdm=$oRules->getSettingByField('ffeeadmin');
	$vProsenTaxNPWP=$oRules->getSettingByField('ftaxnpwp');
	$vProsenTaxNonNPWP=$oRules->getSettingByField('ftaxnonpwp');

	$vProsenTaxNPWP=0;
	$vProsenTaxNonNPWP=0;
   
     
   if (true) {   
   
	  $vsql="select * from m_anggota where ftglaktif not like '0000-00-00%' and fidmember like '%$vMember%'  order by fidsys  limit $vStartA,$vLimit";
	 //  $vsql="select fdownline as fidmember from tb_updown where ftanggal not like '0000-00-00%' and fdownline like '%$vMember%'  order by fidsys  limit $vStartA,$vLimit"; 
	   $dbin->query($vsql);
	   $vCount=0;
	    $db->query('START TRANSACTION;');
	   while ($dbin->next_record()) {
	     $vCount+=1;
		 $vUser=$dbin->f('fidmember');
		 $vPaket=$oMember->getPaketID($vUser);
		 $vMemberName=$oMember->getMemberName($vUser);
		  $vBaseRwd = $oRules->getSettingByField('fbasereward');
		 
	


		echo $vMsg="============================ Start Member <b style='color:#00f'>$vUser</b> ($vMemberName - $vPaket) ================================= <br>";
		 $vMsgAll.=$vMsg;
		

	
	
	
	

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
		if ($vKakiL !=-1 && $vKakiL !='')
		    //$OmzetDownL=$oKomisi->getOmzetROWholeMemberByDate($vKakiL,$vDate,$vDate); //nex
			//$OmzetDownL=$oNetwork->getDownlineCountActivePeriod($vKakiL,$vDate,$vDate); //spectra
			$OmzetDownL=$oKomisi->getOmzetROWholeMemberByMonth($vKakiL,$vMonth,$vYear); //unig
		else	
		    $OmzetDownL=0;
			
		if ($vKakiR !=-1 && $vKakiR !='')
		    //$OmzetDownR=$oNetwork->getDownlineCountActivePeriod($vKakiR,$vDate,$vDate); //nex
			$OmzetDownR=$oKomisi->getOmzetROWholeMemberByMonth($vKakiR,$vMonth,$vYear); //unig
		else	
		    $OmzetDownR=0;
//			$OmzetDownR = 100000000;
	//		$OmzetDownL = 200000000;
		
		//echo "getOmzetROWholeMemberByMonth($vKakiR,$vMonth,$vYear)";
	
		//echo date("Y-m-d",strtotime("2018-11-11"));
		

		echo $vMsg="<br>Omzet Group Kiri L  = $OmzetDownL,";
		$vMsgAll.=$vMsg;
		echo $vMsg="Omzet Group Kanan R = $OmzetDownR";
		$vMsgAll.=$vMsg;

		$vReqNetDev =0;
		
	
		
		echo "<br>";
		$vMsg.="<br>";
		
        if  ($OmzetDownL > 0) { //Kiri
		   $vPV = round($OmzetDownL / $vBaseRwd,2);
		   $vFeeID = "PRRO-".$vUser."-$vYear-$vMonth";
		   $vText="";

		    echo $vMsg="<br><font color='#060'>Insert komisi PR RO ($OmzetDownL  /  $vBaseRwd = $vPV) </font><br>";	
			$vMsgAll.=$vMsg;
	
	
		 	$vSQL="insert into tb_kom_pr(fidreceiver, fidregistrar, ffee,ffeenom, fcf,flr,ftanggal,fidfee,flog,ffeestatus)";
		    $vSQL.=" values('$vUser','system',$OmzetDownL,$vPV,0,'L','$vNowBns','$vFeeID','','2' )";
		   
		    $db->query($vSQL);

		
		
			
		}  else  { echo $vMsg="<br><font color='#f00'>Bonus L: No Action Taken!</font><br>"; 
		   $vMsgAll.=$vMsg;
		}
		
		
        if  ($OmzetDownR > 0) { //Kiri
		   $vPV = round($OmzetDownR / $vBaseRwd,2);
		 $vFeeID = "PRRO-".$vUser."-$vYear-$vMonth";
		   $vText="";

		    echo $vMsg="<br><font color='#060'>Insert komisi PR RO ($OmzetDownR  /  $vBaseRwd = $vPV) </font><br>";	
			$vMsgAll.=$vMsg;
	
	
		 	$vSQL="insert into tb_kom_pr(fidreceiver, fidregistrar, ffee,ffeenom, fcf,flr,ftanggal,fidfee,flog,ffeestatus)";
		    $vSQL.=" values('$vUser','system',$OmzetDownR,$vPV,0,'R','$vNowBns','$vFeeID','','2' )";
		   
		    $db->query($vSQL);

				 $vIsiSMS = $oRules->getSettingByField('fsmsbonusprm');
				 $vIsiSMS=str_replace("{BONUSPRM}",number_format($vBonus,0,",","."),$vIsiSMS);
				 if ($vHP !='')
				     $oSystem->sendSMS($vHP, $vIsiSMS,$vUserGO,$vPassGO);
					 
				$vSubject="Pemberitahuan  Bonus PR Bulanan";
				 if ($vEmail !='')
				     $oSystem->smtpmailer($vEmail,$vMailFrom,'Onotoko',$vSubject,$vIsiSMS,$oRules->getSettingByField('fmailbcc'),"");
			
		}  else  { echo $vMsg="<br><font color='#f00'>Bonus R: No Action Taken!</font><br>"; 
		   $vMsgAll.=$vMsg;
		}
				
		
		echo $vMsg="============================ End Member <b>$vUser</b> ($vPaket) ================================= <br>";
	
		
				
		}  //while
		$db->query('COMMIT;');	
		echo $vMsg="<br>$vCount member calculated on ".$vNow."<BR>\n";
		$vMsgAll.=$vMsg;

	} else { echo $vMsg="Bulan dan Tahun tidak boleh kosong!";  $vMsgAll.=$vMsg; }


 //  $oSystem->smtpmailer($oRules->getSettingByField('fmailbcc'),$vMailFrom,'Onotoko','Compile PR Bulanan','Well Run!',$oRules->getSettingByField('fmailbcc'),"");

   $mtime = microtime(); 
   $mtime = explode(" ",$mtime); 
   $mtime = $mtime[1] + $mtime[0]; 
   $endtime = $mtime; 
   $totaltime = ($endtime - $starttime); 
   echo "Total time  ".$totaltime." seconds"; 
   $vMsg.="Total time  ".$totaltime." seconds"; 
    $vMsg.="</body></html>";
   
  // mail("a_didit_m@yahoo.com","Bonus Pairing Compilation $vNow",$vMsg);
   $vFileName='../files/NetDevCompile'.date('Y-m-d_H.i.s').'.htm';
   $fp=fopen($vFileName,'w',true);
   fputs($fp,$vMsgAll,10000000);
   fclose($fp);

  
?>