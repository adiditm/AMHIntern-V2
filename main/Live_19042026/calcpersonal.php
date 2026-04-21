<?
date_default_timezone_set('Asia/Jakarta');
$mtime = microtime(); 
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$starttime = $mtime; 
echo $vMsgAll.="<html><head><title>Compile Bonus Personal Sales </title></head><body>";
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
	 $vMsgAll.=$vMsg;

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
   
   $vMonth=substr($vDate,5,2);
  
   $vYear=substr($vDate,0,4);
   
   
   	  
  
   
   $vPTKPMonth=$oRules->getSettingByField('fptkp');
   $vPTKPYear=$oRules->getSettingByField('fptkpy');
   $vProsenNormaPPH=$oRules->getSettingByField('fnormapph');
   //$vRealPPH=$oRules->getSettingByField('fpph');
   $vBatasBwh=$oRules->getSettingByField('fbataspsalesb');
   $vBatasAtas=$oRules->getSettingByField('fbataspsalesa');

   $vProsenBwh=$oRules->getSettingByField('fprosenpsalesb');
   $vProsenAtas=$oRules->getSettingByField('fprosenpsalesa');

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
		
				$vOmzetMonth = $oKomisi->getOmzetROMonthMember($vUser,$vMonth,$vYear);
			   echo $vMsg="<br>Omzet Bulan ini : ".number_format($vOmzetMonth,0,",",".")."<br>";
			   $vMsgAll.=$vMsg;
	   
  
		// $vHasSpon=$oNetwork->hasSponsorship($vUser);
	
	
	
		  	
	
		 echo $vMsg="<br>";
		  $vMsgAll.=$vMsg;

		 
		 if ($vOmzetMonth >$vBatasAtas)
		    $vProsen = $vProsenAtas;
		 else if ($vOmzetMonth >=$vBatasBwh && $vOmzetMonth <= $vBatasAtas)	
		    $vProsen = $vProsenBwh;
		 else $vProsen = 0;	
		
	

		
	
		
		
		if ($vOmzetMonth >= $vBatasBwh) {
		     echo "Status: Terpenuhi";
		     $vMsg.="Status: Terpenuhi";

			 $vOmzetGroup='1';
		} else {
		      echo "Status: Tidak Terpenuhi";	 
		      $vMsg.="Status: Tidak Terpenuhi";
			 $vOmzetGroup='0';
		    
		}
		
		echo "<br>";
		$vMsg.="<br>";
		
        if  ($vOmzetGroup=='1') { //Semua
		  

		   
		   $vFeeNom= $vOmzetMonth *($vProsen / 100);		   
		   $vFeeID = "PERSONAL-SALES-".$vUser."-".$vDate;
		   $vText="";

		    echo $vMsg="<br><font color='#060'>Insert Bonus Personal Sales x $vProsen% (".number_format($vFeeNom,0,",",".").") [$vText]</font><br>";	
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
			
			$vPersonFee=$vFeeNom ;
			
			
			
    		$vPersonFeeAdm=($vPersonFee * $vProsenAdm / 100);
   			
			if ($vIncomeMonth >= $vPTKPMonth || $vIncomeYear >= $vPTKPYear) {
		  	    $vTaxPPH = $vPersonFee * ($vProsenTax   / 100)  *  ($vProsenNormaPPH  / 100);
				$vPersonFeeNett = $vPersonFee - $vTaxPPH - $vPersonFeeAdm;
				
				$vFeeID .= " nett with PPH $vProsenNormaPPH%";
			} else {
			    $vTaxPPH = 0;
				$vPersonFeeNett = $vPersonFee - $vTaxPPH - $vPersonFeeAdm;
				
				$vFeeID .= " nett ";
			}
			
			
			$vLastBal=$oMember->getMemField('fsaldovcrmo',$vUser);  


			
		   
		   
		   echo $vMsg="<font color='#f00'>Insert Bonus Personal Sales ke mutasi Cash gross (".number_format($vPersonFee,0,",",".")."), $vFeeID (".number_format($vPersonFeeNett,0,",",".").")  ke Wallet Cash </font><br>";	
		   $vMsgAll.=$vMsg;
		  
		   $vNewBal=$vLastBal + $vPersonFeeNett;
		   $vsql="insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fref,fincometax) "; 
		   $vsql.="values ('$vUser', '$vUser', '$vNowBns','Bonus Personal Sales - $vFeeID' , $vPersonFeeNett,0 ,$vNewBal ,'person' , '1','system' , '$vNow','$vFeeID',$vTaxPPH) "; 
		   $db->query($vsql); 
		   $oMember->updateBalConnMo($vUser,$vNewBal,$db);
		   



		   
			
		}  else  { echo $vMsg="<br><font color='#f00'>Bonus: No Action Taken!</font><br>"; 
		   $vMsgAll.=$vMsg;
		}
		
		echo $vMsg="============================ End Member <b>$vUser</b> ($vPaket) ================================= <br>";
		$vMsgAll.=$vMsg;
		$vMsgAllSlash=addslashes($vMsgAll);
		$vSQL = "update tb_mutasi set flog='$vMsgAllSlash' where fidmember='$vUser' and fkind='person' and ftanggal='$vNow'";
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
   $vFileName='../files/PersonalSalesCompile'.date('Y-m-d_H.i.s').'.htm';
   $fp=fopen($vFileName,'w',true);
   fputs($fp,$vMsgAll,10000000);
   fclose($fp);

  
?>