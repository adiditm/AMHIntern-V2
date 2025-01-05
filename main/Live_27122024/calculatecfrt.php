<?
date_default_timezone_set('Asia/Jakarta');
$mtime = microtime(); 
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$starttime = $mtime; 
echo $vMsgAll.="<html><head><title>Compile Bonus Pairing </title></head><body>";
$vMsg="";
  

   include_once("../server/config.php");

   include_once(CLASS_DIR."memberclass.php");
   include_once(CLASS_DIR."dateclass.php");
   include_once("../classes/networkclass.php");
   include_once(CLASS_DIR."ifaceclass.php");
   include_once(CLASS_DIR."ruleconfigclass.php");
   include_once(CLASS_DIR."komisiclass.php");
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
   $vStartSplit=split("_",$vStart);
   $vStartA=$vStartSplit[0];
   $vLimit=$vStartSplit[1];
   $vDateCompile=$_GET['uDate'];
   if ($vDateCompile=='')
       $vDateCompile=date("Y-m-d");
   $vDate=$_GET['uDate'];
   if ($vDate=='')
       $vDate=date("Y-m-d");
   
  // $vDate=$oMydate->dateSub($vDate,1,'day');
   $vNow=$vDateCompile." ".date("H:i:s"); 
   //$vLimit=$_GET['uLimit'];
   
   $vPairBig=$oRules->getSettingByField('fpairbesar');	  
   $vPairSmall=$oRules->getSettingByField('fpairkecil');	  
   $vPairFeeSet = $oRules->getSettingByField('fbasicpair');
   $vByy=	 $oRules->getSettingByField('fbyyadmin');
   
   $vMaxPairE=$oRules->getSettingByField('fmaxpairs');
   $vMaxPairB=$oRules->getSettingByField('fmaxpairg');
   $vMaxPairF=$oRules->getSettingByField('fmaxpairp');

		   $vMaxPairE = (float) $vMaxPairE;
		   $vMaxPairB = (float) $vMaxPairB;
		   $vMaxPairF = (float) $vMaxPairF;
      
   
   
 //  $vPairFeeSet = $vPairFeeSet / 100; 
   if (true) {   
   
	   $vsql="select * from m_anggota where ftglaktif not like '0000-00-00%' and fidmember like '%$vMember%'  order by fidsys  limit $vStartA,$vLimit";
	   $dbin->query($vsql);
	   $vCount=0;
	    $db->query('START TRANSACTION;');
	   while ($dbin->next_record()) {
	     $vCount+=1;
		 $vUser=$dbin->f('fidmember');
		 
	
		 $vPaket=$dbin->f('fpaket');
		 
		 if ($vPaket=='E' || $vPaket=='S') {
			 $vMaxPair = $vMaxPairE;
			 $vPaketText = 'S';
		 } else if ($vPaket=='B' || $vPaket=='G') {	 
		    $vMaxPair = $vMaxPairB;
			 $vPaketText = 'G';
		 } else if ($vPaket=='F' || $vPaket=='P') {	 
		    $vMaxPair = $vMaxPairF;
			 $vPaketText = 'P';
		 }

		echo $vMsg="============================ Start Member <b style='color:#00f'>$vUser</b> ($vPaketText) ================================= <br>";
		 $vMsgAll.=$vMsg;
		
	   
  
		 $vHasSpon=$oNetwork->hasSponsorship($vUser);
	
	
	
		 //$vDownL=$oNetwork->getDownLR($vUser,"L");
		 //$vDownR=$oNetwork->getDownLR($vUser,"R");
		// $vSponL=$oNetwork->get1stSponsorshipLR('UEC294903666','L');
		// $vSponL=$oNetwork->get1stSponsorshipLR($vUser,'L');
		// $vSponR=$oNetwork->get1stSponsorshipLR($vUser,'R');

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
		    //$OmzetDownL=$oKomisi->getOmzetROWholeMemberByDate($vKakiL,$vDate,$vDate);
		$OmzetDownL=$oNetwork->getDownlineCountActivePeriod($vKakiL,$vDate,$vDate);
		else	
		    $OmzetDownL=0;
			
		if ($vKakiR !=-1 && $vKakiR !='')
		    $OmzetDownR=$oNetwork->getDownlineCountActivePeriod($vKakiR,$vDate,$vDate);
		else	
		    $OmzetDownR=0;
			
		
		$vCF=0;
		//$vCF=$oKomisi->getPairCF($vUser,$vDate);
		$vFeeID = "CFO-".$vUser."-".$vDate;
		if (($vKakiL !=-1 && $vKakiL !='') && ($vKakiR ==-1 || $vKakiR =='')) {// Kaki Kiri Saja 
		//CF Kiri   
		   $vCFBefore=$oKomisi->getCFPos($vUser,'L',$vDateCompile);
		   $vCFSisa=$OmzetDownL + $vCFBefore;    
		   if ($vCFSisa > 0) {
			   echo $vMsg="<br>$vUser Carry Forward Kiri : $vCFSisa<br>";
			   $vMsgAll.=$vMsg;
			   echo $vMsg="<font color='#0f0'>Insert CF kiri : $vCFSisa</font><br>";
			   $vMsgAll.=$vMsg;
			   
			   $vSQL="insert into tb_kom_coupcf(fidreceiver, ffee, fcf,flr,ftanggal,fidfee)";
			   $vSQL.=" values('$vUser',0,$vCFSisa,'L','$vNow','$vFeeID')";
			  // $db->query($vSQL); 	
		   }
		}  else  if (($vKakiR !=-1 && $vKakiR !='') && ($vKakiL ==-1 || $vKakiL =='')) {//Kaki Kanan Saja
		
		//CF Kanan
		   $vCFBefore=$oKomisi->getCFPos($vUser,'R',$vDateCompile);
		   $vCFSisa=$OmzetDownR + $vCFBefore;    
		   
		   if ($vCFSisa > 0) {
			   echo $vMsg="$vUser Carry Forward Kanan : $vCFSisa <br>";
			   $vMsgAll.=$vMsg;
			   echo $vMsg="<font color='#0f0'>Insert CF kanan : $vCFSisa</font>";
			   $vMsgAll.=$vMsg;
			   
			   $vSQL="insert into tb_kom_coupcf(fidreceiver, ffee, fcf,flr,ftanggal,fidfee)";
			   $vSQL.=" values('$vUser',0,$vCFSisa,'R','$vNow','$vFeeID')";
			   $db->query($vSQL); 	
		   
		   }
		   
		} else  if (($vKakiR !=-1 && $vKakiR !='') && ($vKakiL !=-1 || $vKakiL !='')) {//Kaki Kanan Kiri
		
				//CF Kanan
				   $vCFBefore=$oKomisi->getCFPos($vUser,'R',$vDateCompile);
				   $vCFSisaR=$OmzetDownR + $vCFBefore;    
		
				   $vCFBefore=$oKomisi->getCFPos($vUser,'L',$vDateCompile);
				   $vCFSisaL=$OmzetDownL + $vCFBefore;    
				   
				   if ($vCFSisaR > 0 && $vCFSisaL <=0 ) {
					   echo $vMsg="$vUser Carry Forward Kanan : $vCFSisaR <br>";
					   $vMsgAll.=$vMsg;
					   echo $vMsg="<font color='#0f0'>Insert CF kanan : $vCFSisaR</font>";
					   $vMsgAll.=$vMsg;
					   
					   $vSQL="insert into tb_kom_coupcf(fidreceiver, ffee, fcf,flr,ftanggal,fidfee)";
					   $vSQL.=" values('$vUser',0,$vCFSisaR,'R','$vNow','$vFeeID')";
					   $db->query($vSQL); 	
				   
				   } else 		   if ($vCFSisaL > 0 && $vCFSisaR <=0 ) {
					   echo $vMsg="$vUser Carry Forward Kiri : $vCFSisaR <br>";
					   $vMsgAll.=$vMsg;
					   echo $vMsg="<font color='#0f0'>Insert CF kiri : $vCFSisaL</font>";
					   $vMsgAll.=$vMsg;
					   
					   $vSQL="insert into tb_kom_coupcf(fidreceiver, ffee, fcf,flr,ftanggal,fidfee)";
					   $vSQL.=" values('$vUser',0,$vCFSisaL,'L','$vNow','$vFeeID')";
					   $db->query($vSQL); 	
				   
				   }


		
		
		}	
		
		$vCFBeforeL=$oKomisi->getCFPos($vUser,'L',$vDateCompile);
		$vCFBeforeR=$oKomisi->getCFPos($vUser,'R',$vDateCompile);
		$vCFL=0;$vCFR=0;
		if ($vCFBeforeL > 0 && $vCFBeforeR <=0) {
		   	$OmzetDownL+=$vCFBeforeL;
			$vCFL = $vCFBeforeL;
			$vCFR = 0;
		} else if ($vCFBeforeR > 0 && $vCFBeforeL <=0) {
			$OmzetDownR+=$vCFBeforeR ;
			$vCFR = $vCFBeforeR;
			$vCFL = 0;
		} else if ($vCFBeforeR > 0 && $vCFBeforeL > 0) {
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
		echo $vMsg="<br>CFL: ".$vCFL.", CFR: ".$vCFR;
		$vMsgAll.=$vMsg;
		//echo "<br>Syarat 2 : Min. Omzet Kecil=$vPairSmall, Min. Omzet Kecil Besar=$vPairBig:<br>";
		echo $vMsg="<br>Omzet Group Kiri L (+CF) = $OmzetDownL,";
		$vMsgAll.=$vMsg;
		echo $vMsg="Omzet Group Kanan R (+CF)= $OmzetDownR";
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

		   if ($vSmallLegNom > $vMaxPair)
		       $vSmallLegNom = $vMaxPair;

		
        if  ($vOmzetGroup=='1') { //Semua
		  
		  // print_r($vCF);

		   $vCFLR='';
		   if ($vSmallLeg=='L') {
			  $vCFSisa= $OmzetDownR -$vSmallLegNom;
			  $vCFLR='R';

			  if ($vSmallLegNom >= $vMaxPair) {
			     $vCFSisa=0;
				 $vCFLR='R (Flushout)';
			  }
			  
		   } else if ($vSmallLeg=='R') {
			 $vCFSisa= $OmzetDownL -$vSmallLegNom;
			  $vCFLR='L';	

			  if ($vSmallLegNom >= $vMaxPair) {
			     $vCFSisa=0;
				 $vCFLR='L (Flushout)';
			  }
			  		   
		   }
		   
		   $vPairFee=$vSmallLegNom;
		   
		   // * $vPairFeeSet;
		   

				$vProsenNex=$oRules->getSettingByField('fprosencash');
			$vProsenRO=$oRules->getSettingByField('fprosenauto');
			$vMaxMaRO = $oRules->getSettingByField('fmaxrowal');
;
	   
		   // $vRinci="NexWallet ".$vProsenNex * $vPairFee * $vPairFeeSet.", RO Wallet ".$vProsenRO * $vPairFee * $vPairFeeSet";
		  
		   $vFeeID = "PAIR-".$vUser."-".$vDate;
		    echo $vMsg="<br><font color='#060'>Insert komisi pairing $vPairFee (".number_format($vPairFee * $vPairFeeSet,0,",",".")."), CF : $vCFSisa ($vCFLR) $vRinci </font><br>";	
			$vMsgAll.=$vMsg;
		    
		   $vSQL="insert into tb_kom_couple(fidreceiver, fidregistrar, ffee, fcf,flr,ftanggal,fidfee)";
		   $vSQL.=" values('$vUser','system',$vPairFee,$vCFSisa,'$vCFLR','$vNow','$vFeeID')";
		   $db->query($vSQL);
		    
		   
		   
		   
 			 echo $vMsg="<font color='#0f0'>---->Insert CF : $vCFSisa ($vCFLR)</font><br>";	
			 $vMsgAll.=$vMsg;
 			 
			   $vSQL="insert into tb_kom_coupcf(fidreceiver, ffee, fcf,flr,ftanggal,fidfee)";
			  $vSQL.=" values('$vUser',0,$vCFSisa,'$vCFLR','$vNow','$vFeeID')";
			  $db->query($vSQL);
	


		  
			$vPairFee= $vSmallLegNom * $vPairFeeSet;
			$vPairFeeOri=$vPairFee;

			$vPairFeeRO=$vPairFee * $vProsenRO / 100;
			$vPairFee=$vPairFee * $vProsenNex / 100;
	
    		$vPairFeeAdm=($vPairFee * $vByy / 100);
   			 $vPairFeeNett = $vPairFee - $vPairFeeAdm;
			
			
			$vLastBal=$oMember->getMemField('fsaldovcr',$vUser);  


			//$vYear=date("Y");
			$vYear=substr($vDate,0,4);
			//$vMonth=date("m");
			$vMonth=substr($vDate,5,2);
			$vMonth = (int) $vMonth;
			
			$vRoMaMonth = 	$oKomisi->getROMaMonth($vUser,$vYear, $vMonth);


			if ($vRoMaMonth >= $vMaxMaRO)	{

		        $vPairFee= $vPairFeeOri;
		        $vPairFeeNett=$vPairFee- ($vPairFee * $vByy / 100);		
				$vOri='asli 100%';		
			}	else $vOri='';		
		   echo $vMsg="<font color='#00f'>RO Month :  ".number_format($vRoMaMonth,0,",",".")." </font><br>";	  
		   $vMsgAll.=$vMsg;
		   echo $vMsg="<font color='#f00'>Insert Bonus Pairing gross (".number_format($vPairFeeOri,0,",",".")."), nett (".number_format($vPairFeeNett,0,",",".").") $vOri ke Nexwallet </font><br>";	
		   $vMsgAll.=$vMsg;
		    
		   $vNewBal=$vLastBal + $vPairFee;
		   $vsql="insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fref,fincometax) "; 
		   $vsql.="values ('$vUser', '$vUser', '$vNow','Bonus Pairing - $vFeeID' , $vPairFeeNett,0 ,$vNewBal ,'pairing' , '1','system' , '$vNow','$vFeeID',$vPairFeeAdm) "; 
		   $oDB->query($vsql); 
		   $oMember->updateBalConn($vUser,$vNewBal,$db);
		   
		   if ($vRoMaMonth < $vMaxMaRO ) {

						if(($vMaxMaRO-$vRoMaMonth) < $vPairFeeRO) {
						  $vPairFeeROOri=$vPairFeeRO;
						  $vPairFeeRO= ($vMaxMaRO-$vRoMaMonth);
						  $vSelisih = $vPairFeeROOri - $vPairFeeRO;
						  $vTax = $vSelisih * $vByy / 100;
						  $vSelisih = $vSelisih - $vTax;
							//Sisa RO	
						 echo $vMsg="<font color='#070'>Selisih :  ".number_format($vMaxMaRO-$vRoMaMonth,0,",",".")." ($vMaxMaRO - $vRoMaMonth), bonus RO-Wallet $vPairFeeROOri  </font><br>";						
						 $vMsgAll.=$vMsg;
						 echo $vMsg="<font color='#f00'>Insert Overflow :  $vSelisih nett ke Nexwallet </font><br>";									  
						 $vMsgAll.=$vMsg;
							$vLastBal=$oMember->getMemField('fsaldovcr',$vUser);
							$vNewBal=$vLastBal + $vSelisih ;
						    $vsql="insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fref,fincometax) "; 
						    $vsql.="values ('$vUser', '$vUser', '$vNow','Bonus Pairing - $vFeeID (overflow RO)' , $vSelisih ,0 ,$vNewBal ,'pairing' , '1','system' , '$vNow','$vFeeID',$vTax) "; 
						    $oDB->query($vsql); 
						    $oMember->updateBalConn($vUser,$vNewBal,$db);
						  
						  
						  
						}



				echo $vMsg="<font color='#f00'>Insert Bonus Pairing  ke RO-wallet ".number_format($vPairFeeRO,0,",",".")." </font><br>";	
				$vMsgAll.=$vMsg;
			   $vLastBal=$oMember->getMemField('fsaldoro',$vUser);
				
			   $vNewBal=$vLastBal + $vPairFeeRO;
			   $vsql="insert into tb_mutasi_ro (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fref,fincometax) "; 
			   $vsql.="values ('$vUser', '$vUser', '$vNow','Komisi Pairing - $vFeeID' , $vPairFeeRO,0 ,$vNewBal ,'pairing' , '1','system' , '$vNow','$vFeeID',0) "; 
			   $oDB->query($vsql); 
			   $oMember->updateBalConnRO($vUser,$vNewBal,$db);
		   }	   
		   
			
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
			   echo $vMsg="<font color='#f00'>No Action Taken!</font><br>";
			   $vMsgAll.=$vMsg;
		    }

		    
			
		} else  { echo $vMsg="<br><font color='#f00'>No Action Taken!</font><br>"; 
		   $vMsgAll.=$vMsg;
		}
		
		echo $vMsg="============================ End Member <b>$vUser</b> ($vPaketText) ================================= <br>";
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
   fputs($fp,$vMsgAll,100000);
   fclose($fp);

  
?>