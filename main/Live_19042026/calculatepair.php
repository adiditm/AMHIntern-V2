<?
date_default_timezone_set('Asia/Jakarta');
$mtime = microtime(); 
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$starttime = $mtime; 
echo $vMsgAll.="<html><head><title>Compile Bonus Pairing </title></head><body>";
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


   $vProsenCash=$oRules->getSettingByField('fprosencash');
   $vProsenWProd=$oRules->getSettingByField('fprosenwprod');
   $vMaxWProd=$oRules->getSettingByField('fmaxwprod');
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
		

			   echo $vMsg="<br>Max Pasangan  yg dihitung : ".number_format($vMaxPair,0,",",".")."<br>";
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
		if ($vKakiL !=-1 && $vKakiL !='')
		    //$OmzetDownL=$oKomisi->getOmzetROWholeMemberByDate($vKakiL,$vDate,$vDate); //nex
			$OmzetDownL=$oNetwork->getDownlineCountActivePeriod($vKakiL,$vDate,$vDate); //spectra, Ono
			//$OmzetDownL=$oKomisi->getOmzetFOWholeMemberByDate($vKakiL,$vDate,$vDate); //unig
		else	
		    $OmzetDownL=0;
			
		if ($vKakiR !=-1 && $vKakiR !='')
		    $OmzetDownR=$oNetwork->getDownlineCountActivePeriod($vKakiR,$vDate,$vDate); //ono
			//$OmzetDownR=$oKomisi->getOmzetFOWholeMemberByDate($vKakiR,$vDate,$vDate); //unig
		else	
		    $OmzetDownR=0;
//			$OmzetDownR = 100000000;
	//		$OmzetDownL = 200000000;
		
		$vCF=0;
		//$vCF=$oKomisi->getPairCF($vUser,$vDate);
		$vFeeID = "CFO-".$vUser."-".$vDate;
		if (($vKakiL !=-1 && $vKakiL !='') && ($vKakiR ==-1 || $vKakiR =='')) {// Kaki Kiri Saja 
		//CF Kiri   
		   $vCFBefore=$oKomisi->getCFPos($vUser,'L',$vDateCompile);
		   $vCFSisa=$OmzetDownL + $vCFBefore;  
		   
		   if ($vCFSisa > 0) {
			   if ($vCFSisa > $vMaxCFDay) {
				   $vSelisih = $vCFSisa - $vMaxCFDay;
				   $vCFSisa = $vMaxCFDay;   
				   $vFeeID = $vFeeID."-FLUSH-$vSelisih";
			   }
			   echo $vMsg="<br>$vUser Carry Forward Kiri : $vCFSisa<br>";
			   $vMsgAll.=$vMsg;
			   echo $vMsg="<font color='#0f0'>Insert CF kiri : ".number_format($vCFSisa,0,",",".")." - $vFeeID</font><br>";
			   $vMsgAll.=$vMsg;
			   
				//CF 
			   	
			   	$vMsgAll.=$vMsg;
					
					//salah masih
					
				$vSQL="insert into tb_kom_coupcf(fidreceiver, ffee, fcf,flr,ftanggal,fidfee)";
				$vSQL.=" values('$vUser',0,$vCFSisa,'L','$vNow','$vFeeID')";
				$db->query($vSQL); 						
				
			   
			   
		   }
		}  else  if (($vKakiR !=-1 && $vKakiR !='') && ($vKakiL ==-1 || $vKakiL =='')) {//Kaki Kanan Saja
		
		//CF Kanan
		   $vCFBefore=$oKomisi->getCFPos($vUser,'R',$vDateCompile);
		   $vCFSisa=$OmzetDownR + $vCFBefore;    
		   
		   if ($vCFSisa > 0) {
			   if ($vCFSisa > $vMaxCFDay) {
				   $vSelisih = $vCFSisa - $vMaxCFDay;
				   $vCFSisa = $vMaxCFDay;   
				   $vFeeID = $vFeeID."-FLUSH-$vSelisih";
			   }
			   
			   echo $vMsg="$vUser Carry Forward Kanan : $vCFSisa <br>";
			   $vMsgAll.=$vMsg;
			   echo $vMsg="<font color='#0f0'>Insert CF kanan : $vCFSisa - $vFeeID</font>";
			   $vMsgAll.=$vMsg;
			   
	
				$vSQL="insert into tb_kom_coupcf(fidreceiver, ffee, fcf,flr,ftanggal,fidfee)";
				$vSQL.=" values('$vUser',0,$vCFSisa,'R','$vNow','$vFeeID')";
				$db->query($vSQL); 	
			
			  
			   
		   
		   }
		   
		} else  if (($vKakiR !=-1 && $vKakiR !='') && ($vKakiL !=-1 || $vKakiL !='')) {//Kaki Kanan Kiri
		
				//CF Kanan
				   $vCFBefore=$oKomisi->getCFPos($vUser,'R',$vDateCompile);
				   $vCFBeforeR=$vCFBefore;
				   $vCFSisaR=$OmzetDownR + $vCFBefore;    
				//CF Kiri
				   $vCFBefore=$oKomisi->getCFPos($vUser,'L',$vDateCompile);
				   $vCFBeforeL=$vCFBefore;
				   $vCFSisaL=$OmzetDownL + $vCFBefore;    
				//   echo "<br>Omzet kiri:$OmzetDownL<br>";
				   //pincang
				   if ($vCFSisaR > 0 && $vCFSisaL <=0 ) {
	
				   if ($vCFSisaR > $vMaxCFDay) {
					   $vSelisih = $vCFSisaR - $vMaxCFDay;
					   $vCFSisaR = $vMaxCFDay;   
					   $vFeeID = $vFeeID."-FLUSH-$vSelisih";
				   }
					   
					   echo $vMsg="$vUser Carry Forward Kanan : $vCFSisaR <br>";
					   $vMsgAll.=$vMsg;
					   echo $vMsg="<font color='#0f0'>Insert CF kanan : $vCFSisaR - $vFeeID</font>";
					   $vMsgAll.=$vMsg;
					   
					   
					  	
								
							
								$vSQL="insert into tb_kom_coupcf(fidreceiver, ffee, fcf,flr,ftanggal,fidfee)";
					   			$vSQL.=" values('$vUser',0,$vCFSisaR,'R','$vNow','$vFeeID')";
						   		$db->query($vSQL); 
							
						   
					   
					   	
				   
				   } else  if ($vCFSisaL > 0 && $vCFSisaR <=0 ) {

				   if ($vCFSisaL > $vMaxCFDay) {
					   $vSelisih = $vCFSisaL - $vMaxCFDay;
					   $vCFSisaL = $vMaxCFDay;   
					   $vFeeID = $vFeeID."-FLUSH-$vSelisih";
				   }
					   
					   echo $vMsg="$vUser Carry Forward Kiri : $vCFSisaL <br>";
					   $vMsgAll.=$vMsg;
					   echo $vMsg="<font color='#0f0'>Insert CF kiri : ".number_format($vCFSisaL,0,',','.')." - $vFeeID</font>";
					   $vMsgAll.=$vMsg;
					   
					  
					   $vMsgAll.=$vMsg;	
					   
					//   echo "<br> $vAdaPair && ($vCFLast2 == $vCFSisaL";						
									   
							
								$vSQL="insert into tb_kom_coupcf(fidreceiver, ffee, fcf,flr,ftanggal,fidfee)";
					   			$vSQL.=" values('$vUser',0,$vCFSisaL,'L','$vNow','$vFeeID')";
						    	$db->query($vSQL); 	
							
						   
					   
					   
				   
				   }


		
		
		}	
		//Ambil CF sebelumnya
		$vCFBeforeL=$oKomisi->getCFPos($vUser,'L',$vDateCompile);
		$vCFBeforeR=$oKomisi->getCFPos($vUser,'R',$vDateCompile);
		$vCFL=0;$vCFR=0;
		if ($vCFBeforeL > 0 && $vCFBeforeR <=0) { //Kiri saja
		   	$OmzetDownL+=$vCFBeforeL;
			$vCFL = $vCFBeforeL;
			$vCFR = 0;
		} else if ($vCFBeforeR > 0 && $vCFBeforeL <=0) { //Kanan saja
			$OmzetDownR+=$vCFBeforeR ;
			$vCFR = $vCFBeforeR;
			$vCFL = 0;
		} else if ($vCFBeforeR > 0 && $vCFBeforeL > 0) { //Kiri kanan 
			/*if($vCFBeforeR > $vCFBeforeL)
			   $vCFBeforeL = 0; //CF kecil hangus
			if($vCFBeforeR < $vCFBeforeL)
			   $vCFBeforeR = 0; //CF Kecil Hangus*/
			   
			$OmzetDownR+=$vCFBeforeR ;
			$OmzetDownL+=$vCFBeforeL ;
			$vCFR = $vCFBeforeR;
			$vCFL = $vCFBeforeL;
		}

		
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

		
		
		if ($OmzetDownL > 0 && $OmzetDownR > 0) {
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
			$vSisaFlush = abs($vBigLegNom - $vSmallLegNom);

		
        if  ($vOmzetGroup=='1') { //Semua
		  
		  // print_r($vCF);
 
		   $vCFLR='';
		   if ($vSmallLeg=='L') {
			  $vCFSisa= $OmzetDownR -$vSmallLegNom;
			  $vCFLR='R';
			//	echo "aaaaaaaaaaaa $OmzetDownR -$vSmallLegNom";
			  //if ($vSmallLegNom >= $vMaxPair) {
			  if (false) {	  
			     $vCFSisa=$vSisaFlush;
				 $vCFLR='R';
			  }
			  
		   } else if ($vSmallLeg=='R') {
			 $vCFSisa= $OmzetDownL -$vSmallLegNom;
			  $vCFLR='L';	
//echo "bbbbbbbbbbbbbbbbb $OmzetDownL -$vSmallLegNom  $vSisaFlush";
			  //if ($vSmallLegNom >= $vMaxPair) {
			  if (false) {	  	  
			     $vCFSisa=$vSisaFlush;
				 $vCFLR='L';
			  }
			  		   
		   }

		 /*  if ($vSmallLegNom > $vMaxPair) {
			   $vSmallLegNom = $vMaxPair;			   
		   }
		   */
		    $vText="";
		   $vPairFee=$vSmallLegNom;
		   if ($vPairFee > $vMaxPair) {
		      $vPairFee = $vMaxPair;
			  $vText="Limit Break"; 
		   }
		   // * $vPairFeeSet;
		   

	   
		    $vFeeNom=$vPairFee * $vPairSetFee;
		   $vFeeID = "PAIR-".$vUser."-".$vDate;
		  // $vText="";
		   /*if ($vFeeNom > $vMaxPair) {
		      $vFeeNom = $vMaxPair; 
			  $vText="Limit Break";
		   }*/
		    echo $vMsg="<br><font color='#060'>Insert komisi pairing $vPairFee  (".number_format($vFeeNom,0,",",".")."), CF : $vCFSisa ($vCFLR) $vRinci [$vText]</font><br>";	
			$vMsgAll.=$vMsg;
			
		    
		   $vSQL="insert into tb_kom_couple(fidreceiver, fidregistrar, ffee,ffeenom, fcf,flr,ftanggal,fidfee)";
		   $vSQL.=" values('$vUser','system',$vPairFee,$vFeeNom,$vCFSisa,'$vCFLR','$vNowBns','$vFeeID')";
		   $db->query($vSQL);
		    
		   
		   
		
 			    	echo $vMsg="<font color='#0f0'>---->Insert CF : $vCFSisa ($vCFLR)</font><br>";	
			     	$vMsgAll.=$vMsg;
 			 
			   		$vSQL="insert into tb_kom_coupcf(fidreceiver, ffee, fcf,flr,ftanggal,fidfee)";
			  		$vSQL.=" values('$vUser',0,$vCFSisa,'$vCFLR','$vNow','$vFeeID')";
			  		$db->query($vSQL);
			 
	

			$vNPWP = $oMember->getMemField('fnpwp',$vUser);
			if (trim($vNPWP) != '')
			   $vProsenTax = $vProsenTaxNPWP;
			else    
			   $vProsenTax = $vProsenTaxNonNPWP;

		  
		//	$vPairFee= $vSmallLegNom * $vPairFeeSet * $vProsenKembang / 100;
			$vPairFeeOri=$vFeeNom;

			$vPairFeeProd=$vFeeNom * $vProsenWProd / 100;
			//$vPairFeeKIT=$vFeeNom * $vProsenWKit / 100;
		//	$vPairFeeSupp=$vFeeNom * $vProsenWAcc / 100;
			
		    $vYearMonth=substr($vDate,0,7);
			$vYear=substr($vDate,0,4);
		    $vIncomeMonth = $oKomisi->getBonusMonth($vUser,$vYearMonth);
			$vIncomeYear = $oKomisi->getBonusYear($vUser,$vYear);
		   // echo "xxxxx".  $vIncomeMonth = 5400000;
			
			$vPairFee=$vFeeNom * $vProsenCash / 100;
			
			
			
    		$vPairFeeAdm=($vPairFee * $vProsenAdm / 100);
   			
			if ($vIncomeMonth >= $vPTKPMonth || $vIncomeYear >= $vPTKPYear) {
		  	    $vTaxPPH = $vPairFee * ($vProsenTax /100) * ( $vProsenNormaPPH / 100);
				$vPairFeeNett = $vPairFee - $vTaxPPH - $vPairFeeAdm;
				
				$vFeeID .= " nett with PPH $vProsenNormaPPH%";
			} else {
			    $vPairFeeNett = $vPairFee - $vPairFeeAdm;
				$vTaxPPH = 0;
				$vFeeID .= " nett ";
			}
			
			
			$vLastBal=$oMember->getMemField('fsaldovcr',$vUser);  


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
		   
		   if ($vPairFeeOri > $vMaxPair)
		      $vPairFeeOri = $vMaxPair;
		   echo $vMsg="<font color='#f00'>Insert Bonus Pasangan ke mutasi Cash gross (".number_format($vPairFeeOri,0,",",".")."), $vFeeID (".number_format($vPairFeeNett,0,",",".").")  ke Wallet Cash </font><br>";	
		   $vMsgAll.=$vMsg;

			$vLastBalWProd=$oMember->getMemField('fsaldowprod',$vUser);

			if ($vLastBalWProd >= $vMaxWProd) {
				  	 $vTaxPPH =($vPairFee + $vPairFeeProd)  * ($vProsenTax /100) * ($vProsenNormaPPH / 100);
					 $vPairFeeNett =($vPairFee + $vPairFeeProd)  - $vTaxPPH ;				 

				  $vDescX = "Komisi Pairing [$vFeeID] - cutoff";
			} else    $vDescX = "Komisi Pairing [$vFeeID]";

		  
		   $vNewBal=$vLastBal + $vPairFeeNett;
		   $vsql="insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fref,fincometax) "; 
		   $vsql.="values ('$vUser', '$vUser', '$vNowBns','$vDescX' , $vPairFeeNett,0 ,$vNewBal ,'pairing' , '1','system' , '$vNow','$vFeeID',$vPairFeeAdm+$vTaxPPH) "; 
		   $oDB->query($vsql); 
		   $oMember->updateBalConn($vUser,$vNewBal,$db);
		   

			echo $vMsg="<font color='#f00'>Insert Bonus Pasangan  ke Wallet Automain ".number_format($vPairFeeProd,0,",",".")." </font><br>";	
			$vMsgAll.=$vMsg;
		   $vLastBal=$oMember->getMemField('fsaldowprod',$vUser);

			if ($vLastBal >= $vMaxWProd) {
				  $vPairFeeProd = 0;
				  $vDescX = "Komisi Pairing [$vFeeID] - cutoff";
			} else    $vDescX = "Komisi Pairing [$vFeeID]";
			
		   $vNewBal=$vLastBal + $vPairFeeProd;
		   $vsql="insert into tb_mutasi_wprod (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fref,fincometax) "; 
		   $vsql.="values ('$vUser', '$vUser', '$vNowBns','$vDescX ' , $vPairFeeProd,0 ,$vNewBal ,'pairing' , '1','system' , '$vNowBns','$vFeeID',0) "; 
		   $oDB->query($vsql); 
		   $oMember->updateBalConnWProd($vUser,$vNewBal,$db);


		   
			
		} else   if ($vSponL != '' && $vSponR !='' && $vOmzetGroup=='0') { //Sponsor Terpenuhi, omzet tidak
		  
		  
		  // print_r($vCF);
			$vCFSisaL= $OmzetDownL;
			$vCFSisaR= $OmzetDownR;
		   
		   

		   
		   $vFeeID = "CFZ-".$vUser."-".$vDate;
		   
		   if ($vCFSisaL >0) {
				echo $vMsg="<br><font color='#0f0'>---->Insert CF Kiri $vCFSisaL</font> <br>";	
				$vMsgAll.=$vMsg;

			   $vSQL="insert into tb_kom_coupcf(fidreceiver, ffee, fcf,flr,ftanggal,fidfee)";
			   $vSQL.=" values('$vUser',0,$vCFSisaL,'L','$vNow','$vFeeID')";
			   $db->query($vSQL);
		   }
		   
		    if ($vCFSisaR >0) {
				echo $vMsg="<br><font color='#0f0'>---->Insert CF Kanan $vCFSisaR </font><br>";	
				$vMsgAll.=$vMsg;
				
			   $vSQL="insert into tb_kom_coupcf(fidreceiver, ffee, fcf,flr,ftanggal,fidfee)";
			   $vSQL.=" values('$vUser',0,$vCFSisaR,'R','$vNow','$vFeeID')";
			   $db->query($vSQL);
			}
			
			if ($vCFSisaR <=0 && $vCFSisaL <=0) {
			   echo $vMsg="<font color='#f00'>Bonus: No Action Taken!</font><br>";
			   $vMsgAll.=$vMsg;
		    }

		    
			
		} else  { echo $vMsg="<br><font color='#f00'>Bonus: No Action Taken!</font><br>"; 
		   $vMsgAll.=$vMsg;
		}
		
		echo $vMsg="============================ End Member <b>$vUser</b> ($vPaket) ================================= <br>";
		$vMsgAll.=$vMsg;
		$vMsgAllSlash=addslashes($vMsgAll);
		$vSQL = "update tb_mutasi set flog='$vMsgAllSlash' where fidmember='$vUser' and fkind='pairing' and ftanggal='$vNow'";
		//$db->query($vSQL);


		$vSQL = "update tb_mutasi_ro set flog='$vMsgAllSlash' where fidmember='$vUser' and fkind='pairing' and ftanggal='$vNow'";
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
   $vFileName='../files/PairingCompile'.date('Y-m-d_H.i.s').'.htm';
   $fp=fopen($vFileName,'w',true);
   fputs($fp,$vMsgAll,10000000);
   fclose($fp);

  
?>