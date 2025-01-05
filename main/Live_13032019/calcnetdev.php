<?
date_default_timezone_set('Asia/Jakarta');
$mtime = microtime(); 
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$starttime = $mtime; 
echo $vMsgAll.="<html><head><title>Compile Bonus Net Development </title></head><body>";
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
   $vReqNetDev=$oRules->getSettingByField('freqnetdev');
   $vProsenNetDev=$oRules->getSettingByField('fnetdev');
	$vProsenAdm=$oRules->getSettingByField('ffeeadmin');
	$vProsenTaxNPWP=$oRules->getSettingByField('ftaxnpwp');
	$vProsenTaxNonNPWP=$oRules->getSettingByField('ftaxnonpwp');

	$vProsenTaxNPWP=0;
	$vProsenTaxNonNPWP=0;
   
     
   if (true) {   
   
	   $vsql="select * from m_anggota where ftglaktif not like '0000-00-00%' and fidmember like '%$vMember%'  order by fidsys  limit $vStartA,$vLimit";
	   $dbin->query($vsql);
	   $vCount=0;
	    $db->query('START TRANSACTION;');
	   while ($dbin->next_record()) {
	     $vCount+=1;
		 $vUser=$dbin->f('fidmember');
		 $vPaket=$oMember->getPaketID($vUser);
		 if ($vPaket == 'S')
		   $vMaxPair=$vMaxKembangS;
		 else if ($vPaket == 'G') 
		   $vMaxPair=$vMaxKembangG; 
		 else if ($vPaket == 'P') 
		   $vMaxPair=$vMaxKembangP; 
		 
			$vNPWP = $oMember->getMemField('fnpwp',$vUser);
			if (trim($vNPWP) != '')
			   $vProsenTax = $vProsenTaxNPWP;
			else    
			   $vProsenTax = $vProsenTaxNonNPWP;
		 
		 
		 $vMemberName=$oMember->getMemberName($vUser);
	


		echo $vMsg="============================ Start Member <b style='color:#00f'>$vUser</b> ($vMemberName - $vPaket) ================================= <br>";
		 $vMsgAll.=$vMsg;
		

			   echo $vMsg="<br>Syarat Kaki Kecil : ".number_format($vReqNetDev,0,",",".")."<br>";
			   $vMsgAll.=$vMsg;
	   
  
		// $vHasSpon=$oNetwork->hasSponsorship($vUser);
	
	
	

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
		
		
	

		
		//echo "BandingkanLR $OmzetDownL $OmzetDownR";
		if ($OmzetDownL < $OmzetDownR) {
		   $vSmallLegNom = $OmzetDownL;
		   $vBigLegNom = $OmzetDownR;

		   $vSmallLeg='L';
		   $vBigLeg='R';
		   
		} else if ($OmzetDownL > $OmzetDownR) {
		   $vSmallLegNom = $OmzetDownR;
		   $vBigLegNom = $OmzetDownL;

		   $vSmallLeg='R';
		   $vBigLeg='L';
		   
		} else { 
		   $vSmallLegNom =  $OmzetDownR;  
		   $vBigLegNom = $OmzetDownL;
		   $vSmallLeg='R';
		   $vBigLeg='L';		
		 } 
		


  		/* if ($vHasSpon=='1') 
		    $vSS='Terpenuhi';
		 else $vSS='Tidak';	
		  echo "Syarat 1 : punya sponsor : $vSS"; */
        echo $vMsg="<br>Kaki kecil $vSmallLeg : $vSmallLegNom, Kaki besar $vBigLeg: $vBigLegNom"; 
		$vMsgAll.=$vMsg;
		//echo $vMsg="<br>CFL: ".$vCFL.", CFR: ".$vCFR;
		//$vMsgAll.=$vMsg;
		//echo "<br>Syarat 2 : Min. Omzet Kecil=$vPairSmall, Min. Omzet Kecil Besar=$vPairBig:<br>";
		echo $vMsg="<br>Omzet Group Kiri L  = $OmzetDownL,";
		$vMsgAll.=$vMsg;
		echo $vMsg="Omzet Group Kanan R = $OmzetDownR";
		$vMsgAll.=$vMsg;

		
		
		if ($vSmallLegNom >= $vReqNetDev) {
		     echo " : Terpenuhi";
		     $vMsg.=" : Terpenuhi";

			 $vOmzetGroup='1';
		} else {
		      echo " : Tidak";	 
		      $vMsg.=" : Tidak";
			 $vOmzetGroup='0';
		    
		}
		
		echo "<br>";
		$vMsg.="<br>";
		
        if  ($vOmzetGroup=='1') { //Semua
		  

		   $vOmzetLR = $OmzetDownL + $OmzetDownR;
		   $vFeeNom= ($vOmzetLR /2)  * $vProsenNetDev / 100;		   
		   $vFeeID = "NETDEV-".$vUser."-".$vDate;
		   $vText="";

		    echo $vMsg="<br><font color='#060'>Insert komisi Network Development ($vOmzetLR / 2) x $vProsenNetDev% (".number_format($vFeeNom,0,",",".").") [$vText]</font><br>";	
			$vMsgAll.=$vMsg;
	
	

			$vNPWP = $oMember->getMemField('fnpwp',$vUser);
			if (trim($vNPWP) != '')
			   $vProsenTax = $vProsenTaxNPWP;
			else    
			   $vProsenTax = $vProsenTaxNonNPWP;


			
		    $vYearMonth=substr($vDate,0,7);
			$vYear=substr($vDate,0,4);
		    $vIncomeMonth = $oKomisi->getBonusMonth($vUser,$vYearMonth);
			$vIncomeYear = $oKomisi->getBonusYear($vUser,$vYear);
		   // echo "xxxxx".  $vIncomeMonth = 5400000;
			
			$vNetDevFee=$vFeeNom ;
			
			
			
    		$vvNetDevFeeAdm=($vNetDevFee * $vProsenAdm / 100);
   			
			if ($vIncomeMonth >= $vPTKPMonth || $vIncomeYear >= $vPTKPYear) {
		  	    $vTaxPPH = $vNetDevFee * ($vProsenTax   / 100)  *  ($vProsenNormaPPH  / 100);
				$vNetDevFeeNett = $vNetDevFee - $vTaxPPH - $vvNetDevFeeAdm;
				
				$vFeeID .= " nett with PPH $vProsenNormaPPH%";
			} else {
			    $vTaxPPH = 0;
				$vNetDevFeeNett = $vNetDevFee - $vTaxPPH - $vvNetDevFeeAdm;
				
				$vFeeID .= " nett ";
			}
			
			
			$vLastBal=$oMember->getMemField('fsaldovcrmo',$vUser);  


			/*//$vYear=date("Y");
			$vYear=substr($vDate,0,4);
			//$vMonth=date("m");
			$vMonth=substr($vDate,5,2);
			$vMonth = (int) $vMonth;
			
			//$vRoMaMonth = 	$oKomisi->getROMaMonth($vUser,$vYear, $vMonth);


			if ($vRoMaMonth >= $vMaxMaRO)	{

		        $vPairFee= $vPairFeeOri;
		        $vPairFeeNett=$vPairFee- ($vPairFee * $vByy / 100);		
				$vOri='asli 100%';		
			}	else $vOri='';	*/	
			
			
		//   echo $vMsg="<font color='#00f'>RO Month :  ".number_format($vRoMaMonth,0,",",".")." </font><br>";	  
		//   $vMsgAll.=$vMsg;
		   
		   
		   echo $vMsg="<font color='#f00'>Insert Bonus Net Development ke mutasi Cash gross (".number_format($vNetDevFee,0,",",".")."), $vFeeID (".number_format($vNetDevFeeNett,0,",",".").")  ke Wallet Cash </font><br>";	
		   $vMsgAll.=$vMsg;
		  
		   $vNewBal=$vLastBal + $vNetDevFeeNett;
		   $vsql="insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fref,fincometax) "; 
		   $vsql.="values ('$vUser', '$vUser', '$vNowBns','Bonus Net Development - $vFeeID' , $vNetDevFeeNett,0 ,$vNewBal ,'netdev' , '1','system' , '$vNow','$vFeeID',$vTaxPPH) "; 
		   $db->query($vsql); 
		   $oMember->updateBalConnMo($vUser,$vNewBal,$db);
		   



		   
			
		}  else  { echo $vMsg="<br><font color='#f00'>Bonus: No Action Taken!</font><br>"; 
		   $vMsgAll.=$vMsg;
		}
		
		echo $vMsg="============================ End Member <b>$vUser</b> ($vPaket) ================================= <br>";
		$vMsgAll.=$vMsg;
		$vMsgAllSlash=addslashes($vMsgAll);
		$vSQL = "update tb_mutasi set flog='$vMsgAllSlash' where fidmember='$vUser' and fkind='pairing' and ftanggal='$vNow'";
		//$db->query($vSQL);


		//$vSQL = "update tb_mutasi_ro set flog='$vMsgAllSlash' where fidmember='$vUser' and fkind='pairing' and ftanggal='$vNow'";
		//$db->query($vSQL);
	  
		
	
				
		
				
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
   $vFileName='../files/NetDevCompile'.date('Y-m-d_H.i.s').'.htm';
   $fp=fopen($vFileName,'w',true);
   fputs($fp,$vMsgAll,10000000);
   fclose($fp);

  
?>