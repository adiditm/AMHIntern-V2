<?
date_default_timezone_set('Asia/Jakarta');
$mtime = microtime(); 
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$starttime = $mtime; 
$vMsg.="<html><head><title>Bonus Compilation</title></head><body>";

  
   include_once("../server/config.php");
   
   include_once(CLASS_DIR."memberclass.php");
   include_once(CLASS_DIR."dateclass.php");
   include_once(CLASS_DIR."networkclass.php");
   include_once(CLASS_DIR."ifaceclass.php");
   include_once(CLASS_DIR."ruleconfigclass.php");
   include_once(CLASS_DIR."komisiclass.php");
   include_once(CLASS_DIR."jualclass.php");
   include_once(CLASS_DIR."productclass.php");
   echo "==================================================================================================";
   $vMsg.="==================================================================================================";
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
   
   $vPairBig=$oRules->getSettingByField('fpairbesar');	  
   $vPairSmall=$oRules->getSettingByField('fpairkecil');	  
   $vPairFeeSet = $oRules->getSettingByField('ffeepair');
   $vByy=	 $oRules->getSettingByField('fbyyadmin');
   $vMaxPairE=$oRules->getSettingByField('ffeepairmaxe');
   $vMaxPairB=$oRules->getSettingByField('ffeepairmaxb');
   $vMaxPairF=$oRules->getSettingByField('ffeepairmaxf');
   
   $vPairFeeSet = $vPairFeeSet / 100; 
   if (true) {   
   
	   $vsql="select * from m_anggota where ftglaktif not like '0000-00-00%' and fidmember like '%$vMember%'  order by fidsys  limit $vStartA,$vLimit";
	   $dbin->query($vsql);
	   $vCount=0;
	    $db->query('START TRANSACTION;');
	   while ($dbin->next_record()) {
	     $vCount+=1;
		 $vUser=$dbin->f('fidmember');
	
		 $vPaket=$dbin->f('fpaket');
		 

		
	   
  
	//Royalty 5% diganti matching
	     echo "<br><font color='#00f'>Member:".$vUser." ($vPaket)</font><br>";
		 $vMsg.="<br><font color='#00f'>Member:".$vUser." ($vPaket)</font><br>";
		 $vHasSpon=$oNetwork->hasSponsorshipLR($vUser);
	
	
	
		 //$vDownL=$oNetwork->getDownLR($vUser,"L");
		 //$vDownR=$oNetwork->getDownLR($vUser,"R");
		// $vSponL=$oNetwork->get1stSponsorshipLR('UEC294903666','L');
		 $vSponL=$oNetwork->get1stSponsorshipLR($vUser,'L');
		 $vSponR=$oNetwork->get1stSponsorshipLR($vUser,'R');

		 $vKakiL=$oNetwork->getDownLR($vUser,'L');
		 $vKakiR=$oNetwork->getDownLR($vUser,'R');
		 
		 echo "<br>Kaki Kiri Pertama : ".$vKakiL; 
		 echo "<br>Kaki Kanan Pertama: ".$vKakiR; 
		 echo "<br>Sponsor Kiri Pertama : ".$vSponL; 
		 echo "<br>Sponsor Kanan Pertama: ".$vSponR; 

		 echo "<br>";

		 $vMsg.="<br>Kaki Kiri Pertama : ".$vKakiL; 
		 $vMsg.="<br>Kaki Kanan Pertama: ".$vKakiR; 
		 $vMsg.="<br>Sponsor Kiri Pertama : ".$vSponL; 
		 $vMsg.="<br>Sponsor Kanan Pertama: ".$vSponR; 

		 $vMsg.="<br>";
		 
		 //Omzet dimulai dari kaki pertama
		$vSmallLeg ='';$vSmallLegNom=0;
		if ($vKakiL !=-1 && $vKakiL !='')
		    $OmzetDownL=$oKomisi->getOmzetROWholeMemberByDate($vKakiL,$vDate,$vDate);
		else	
		    $OmzetDownL=0;
			
		if ($vKakiR !=-1 && $vKakiR !='')
		    $OmzetDownR=$oKomisi->getOmzetROWholeMemberByDate($vKakiR,$vDate,$vDate);
		else	
		    $OmzetDownR=0;
			
		
		$vCF=0;
		//$vCF=$oKomisi->getPairCF($vUser,$vDate);
		$vFeeID = "CFO-".$vUser."-".$vDate;
		if (trim($vSponL) != '' && trim($vSponR)=='') {// Sponsorship Kiri Saja
		   
		   $vCFBefore=$oKomisi->getCFPos($vUser,'L',$vDateCompile);
		   $vCFSisa=$OmzetDownL + $vCFBefore;    
		   if ($vCFSisa > 0) {
			   echo "$vUser Carry Forward Kiri : $vCFSisa<br>";
			   echo "<font color='#0f0'>Insert CF kiri : $vCFSisa</font><br>";
			   $vMsg.="$vUser Carry Forward Kiri : $vCFSisa<br>";
			   $vMsg.="<font color='#0f0'>Insert CF kiri : $vCFSisa</font><br>";
			   
			   $vSQL="insert into tb_kom_coupcf(fidreceiver, ffee, fcf,flr,ftanggal,fidfee)";
			   $vSQL.=" values('$vUser',0,$vCFSisa,'L','$vNow','$vFeeID')";
			   $db->query($vSQL); 	
		   }
		}  else  if (trim($vSponR) != '' && trim($vSponL)=='') {//Sponsorship Kanan Saja
		   $vCFBefore=$oKomisi->getCFPos($vUser,'R',$vDateCompile);
		   $vCFSisa=$OmzetDownR + $vCFBefore;    
		   
		   if ($vCFSisa > 0) {
			   echo "$vUser Carry Forward Kanan : $vCFSisa <br>";
			   echo "<font color='#0f0'>Insert CF kanan : $vCFSisa</font>";
			   $vMsg.="$vUser Carry Forward Kanan : $vCFSisa <br>";
			   $vMsg.="<font color='#0f0'>Insert CF kanan : $vCFSisa</font>";
			   
			   $vSQL="insert into tb_kom_coupcf(fidreceiver, ffee, fcf,flr,ftanggal,fidfee)";
			   $vSQL.=" values('$vUser',0,$vCFSisa,'R','$vNow','$vFeeID')";
			   $db->query($vSQL); 	
		   
		   }
		
		
		}	
		
		$vCFBeforeL=$oKomisi->getCFPos($vUser,'L',$vDateCompile);
		$vCFBeforeR=$oKomisi->getCFPos($vUser,'R',$vDateCompile);
		
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

		
		
		if ($OmzetDownL < $OmzetDownR) {
		   $vSmallLegNom = $OmzetDownL;
		   $vBigLegNom = $OmzetDownR;

		   $vSmallLeg='L';
		   
		} else { 
		   $vSmallLegNom =  $OmzetDownR;  
		   $vBigLegNom = $OmzetDownL;
		   $vSmallLeg='R';
		} 
		
  		 if ($vHasSpon=='1') 
		    $vSS='Terpenuhi';
		 else $vSS='Tidak';	
		  echo "Syarat 1 : punya sponsor kiri & kanan : $vSS";
        echo "<br>Kaki kecil : $vSmallLegNom, Kaki besar: $vBigLegNom"; 
		echo "<br>CFL: ".$vCFL.", CFR: ".$vCFR;
		echo "<br>Syarat 2 : Min. Omzet Kecil=$vPairSmall, Min. Omzet Kecil Besar=$vPairBig:<br>";
		echo "Omzet Group Kiri L (+CF) = $OmzetDownL,";
		echo "Omzet Group Kanan R (+CF)= $OmzetDownR";

		  $vMsg.="Syarat 1 : punya sponsor kiri & kanan : $vSS";
        $vMsg.="<br>Kaki kecil : $vSmallLegNom, Kaki besar: $vBigLegNom"; 
		$vMsg.="<br>CFL: ".$vCFL.", CFR: ".$vCFR;
		$vMsg.="<br>Syarat 2 : Min. Omzet Kecil=$vPairSmall, Min. Omzet Kecil Besar=$vPairBig:<br>";
		$vMsg.="Omzet Group Kiri L (+CF) = $OmzetDownL,";
		$vMsg.="Omzet Group Kanan R (+CF)= $OmzetDownR";
		
		
		if (($OmzetDownL >= $vPairSmall && $OmzetDownR >= $vPairBig) || ($OmzetDownL >= $vPairBig && $OmzetDownR >= $vPairSmall)) {
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


		
        if ($vSponL != '' && $vSponR !='' && $vOmzetGroup=='1') { //Semua
		  
		  // print_r($vCF);

		   $vCFLR='';
		   if ($vSmallLeg=='L') {
			  $vCFSisa= $OmzetDownR -$vSmallLegNom;
			  $vCFLR='R';
		   } else if ($vSmallLeg=='R') {
			 $vCFSisa= $OmzetDownL -$vSmallLegNom;
			  $vCFLR='L';			   
		   }
		   
		   $vPairFee=$vSmallLegNom * $vPairFeeSet;
		   
		   $vMaxPairE = (float) $vMaxPairE;
		   $vMaxPairB = (float) $vMaxPairB;
		   $vMaxPairF = (float) $vMaxPairF;
		   
		   if ($vPaket=='E') {
			  if ($vPairFee > $vMaxPairE)   
			     $vPairFee = $vMaxPairE;
		   } else if ($vPaket=='B') {
			  if ($vPairFee > $vMaxPairB)   
			     $vPairFee = $vMaxPairB;
		   } else if ($vPaket=='F') {
			  if ($vPairFee > $vMaxPairF)   
			     $vPairFee = $vMaxPairF;
		   }

		   
		  
		   $vFeeID = "PAIR-".$vUser."-".$vDate;
		    echo "<font color='#0f0'>---->Insert komisi pairing $vPairFee, CF : $vCFSisa ($vCFLR)</font><br>";	
		     $vMsg.="<font color='#0f0'>---->Insert komisi pairing $vPairFee, CF : $vCFSisa ($vCFLR)</font><br>";	
		   $vSQL="insert into tb_kom_couple(fidreceiver, fidregistrar, ffee, fcf,flr,ftanggal,fidfee)";
		   $vSQL.=" values('$vUser','system',$vPairFee,$vCFSisa,'$vCFLR','$vNow','$vFeeID')";
		   $db->query($vSQL);
		    
		   
		   
		   
 			 echo "<font color='#0f0'>---->Insert CF : $vCFSisa ($vCFLR)</font><br>";	
 			 $vMsg.="<font color='#0f0'>---->Insert CF : $vCFSisa ($vCFLR)</font><br>";
 			 
			   $vSQL="insert into tb_kom_coupcf(fidreceiver, ffee, fcf,flr,ftanggal,fidfee)";
			  $vSQL.=" values('$vUser',0,$vCFSisa,'$vCFLR','$vNow','$vFeeID')";
			  $db->query($vSQL);
			  
			$vLastBal=$oMember->getMemField('fsaldovcr',$vUser);  
		    $vTax=$vPairFee * $vByy / 100;
		    $vPairFee=$vPairFee - $vTax;	
		    
		    $vNewBal=$vLastBal + $vPairFee;
		   $vsql="insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fref,fincometax) "; 
		   $vsql.="values ('$vUser', '$vUser', '$vNow','Komisi Pairing - $vFeeID' , $vPairFee,0 ,$vNewBal ,'pairing' , '1','system' , '$vNow','$vFeeID',$vTax) "; 
		   $oDB->query($vsql); 
		   $oMember->updateBalConn($vUser,$vNewBal,$db);
		   
		   	   
		   
			
		} else   if ($vSponL != '' && $vSponR !='' && $vOmzetGroup=='0') { //Sponsor Terpenuhi, omzet tidak
		  
		  // print_r($vCF);
			$vCFSisaL= $OmzetDownL;
			$vCFSisaR= $OmzetDownR;
		   
		   

		   
		   $vFeeID = "CFZ-".$vUser."-".$vDate;
		   
		   if ($vCFSisaL >0) {
				echo "<br><font color='#0f0'>---->Insert CF Kiri $vCFSisaL</font> <br>";	
				 $vMsg.="<br><font color='#0f0'>---->Insert CF Kiri $vCFSisaL</font> <br>";	
			   $vSQL="insert into tb_kom_coupcf(fidreceiver, ffee, fcf,flr,ftanggal,fidfee)";
			   $vSQL.=" values('$vUser',0,$vCFSisaL,'L','$vNow','$vFeeID')";
			   $db->query($vSQL);
		   }
		   
		    if ($vCFSisaR >0) {
				echo "<br><font color='#0f0'>---->Insert CF Kanan $vCFSisaR </font><br>";	
				$vMsg.="<br><font color='#0f0'>---->Insert CF Kanan $vCFSisaR </font><br>";
			   $vSQL="insert into tb_kom_coupcf(fidreceiver, ffee, fcf,flr,ftanggal,fidfee)";
			   $vSQL.=" values('$vUser',0,$vCFSisaR,'R','$vNow','$vFeeID')";
			   $db->query($vSQL);
			}
			
			if ($vCFSisaR <=0 && $vCFSisaL <=0) {
			   echo "<font color='#f00'>No Action Taken!</font>";
		       $vMsg.="<font color='#f00'>No Action Taken!</font>";
		    }

		    
			
		} else  { echo "<font color='#f00'>No Action Taken!</font>";
		   $vMsg.="<font color='#f00'>No Action Taken!</font>";

		}
		
		echo "<br>======================================================";
	  
		
	
				
		
				
		}  //while
		$db->query('COMMIT;');	
		echo "<br>$vCount member calculated on ".$vNow."<BR>\n";
		$vMsg.="<br>$vCount member calculated on ".$vNow."<BR>\n";

	} else echo "Bulan dan Tahun tidak boleh kosong!";   

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
   fputs($fp,$vMsg,100000);
   fclose($fp);

  
?>