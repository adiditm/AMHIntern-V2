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
echo $vMsgAll.="<html><head><title>Compile Bonus Profit Share </title></head><body>";
$vMsg="";
  

   include_once("../server/config.php");

   include_once("../classes/memberclass.php");
   include_once(CLASS_DIR."dateclass.php");
   include_once("../classes/networkclass.php");
   include_once(CLASS_DIR."ifaceclass.php");
   include_once(CLASS_DIR."ruleconfigclass.php");
   include_once("../classes/komisiclass.php");
   include_once("../classes/jualclass.php");
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
   $vDate=$_GET['uDate'];
   if ($vDate=='')
       $vDate=date("Y-m-d");

   $vDate=$oMydate->dateSub($vDate,1,'day');
   $vDateMo=$oMydate->dateSub($vDate,1,'month');
   $vDateLastTime=$vDate." 23:59:59";
   $vNow=$vDateCompile." ".date("H:i:s");
   $vNowBns=$vDate." 23:59:59";
    
   $vThBul=substr($vDateMo,0,4).substr($vDateMo,5,2);

	$vYear=substr($vDateMo,0,4);
	$vMonth=substr($vDateMo,5,2);

   
   $vByy=	 $oRules->getSettingByField('fbyyadmin');
   
   $vMaxMaRO = $oRules->getSettingByField('fmaxrowal');
   $vProsenPSPM=$oRules->getSettingByField('pfsharepm');
   $vProsenPSDir=$oRules->getSettingByField('pfsharedir');
   $vProsenPSRD=$oRules->getSettingByField('pfsharerd');
   $vGlobalRO=$oJual->getROGlobal($vThBul);
   $vGlobalRO=1000000000;
   
   //$vDeepUni=$oRules->getSettingByField('fdeepuni');   
   //$vFeeUni=$oRules->getSettingByField('ffeeuni');      
   echo $vMsg="<br>======================PROSES KUALIFIKASI================================" ; 
		 $vMsgAll.=$vMsg;

   echo $vMsg="<br>Global RO Month $vMonth-$vYear : ".number_format($vGlobalRO,0,",",".") ; 
		 $vMsgAll.=$vMsg;
   
 //  $vPairFeeSet = $vPairFeeSet / 100; 
   if (true) {   
   
	   $vsql="select * from m_anggota where ftglaktif not like '0000-00-00%' and fidmember like '%$vMember%'  order by fidsys  limit $vStartA,$vLimit";
	   $dbin->query($vsql);
	   $vCount=0;
		$vQualiRD=0;
		$vQualiDir=0;
		$vQualiPM=0;
		
		$vArrQualiRD="";
		$vArrQualiDir="";
		$vArrQualiPM="";
		
	    $db->query('START TRANSACTION;');
	   while ($dbin->next_record()) {
	     $vCount+=1;
		 $vUser=$dbin->f('fidmember');
		 $vLevel = $oMember->getMemField('flevel',$vUser);
		 //$vLevel ='RD';
		
		echo $vMsg="<br>============================ Start Member <b style='color:#00f'>$vUser</b> ($vLevel) ================================= <br>";
		$vMsgAll.=$vMsg;
		
   echo $vMsg="<br>Global RO Month $vMonth-$vYear : ".number_format($vGlobalRO,0,",",".") ; 
		 $vMsgAll.=$vMsg;
		

		 $vKakiL=$oNetwork->getDownLR($vUser,'L');
		 $vKakiR=$oNetwork->getDownLR($vUser,'R');
		 
		 if ($vKakiL==-1)
		     $vKakiLText='[none]';
		 else 	$vKakiLText=$vKakiL; 
		 if ($vKakiR==-1)
		     $vKakiRText='[none]';
		  else $vKakiRText=$vKakiR;	 
		 
		 echo $vMsg="<br>Kaki Kiri Pertama : ".$vKakiLText; 
		 $vMsgAll.=$vMsg;
		 echo $vMsg="<br>Kaki Kanan Pertama: ".$vKakiRText; 
		 $vMsgAll.=$vMsg;
		
		if ($vKakiL !=-1 && $vKakiL !='')
		    $vOmzetDownL=$oKomisi->getOmzetROWholeMemberByMonth($vKakiL,$vMonth,$vYear);
		else	
		    $vOmzetDownL=0;
			
		if ($vKakiR !=-1 && $vKakiR !='')
		    $vOmzetDownR=$oKomisi->getOmzetROWholeMemberByMonth($vKakiR,$vMonth,$vYear);
		else	
		    $vOmzetDownR=0;
			
	$vOmzetDownR=500000000;
			$vOmzetDownL=500000000;		
			
		 echo $vMsg="<br>Omzet L : ".number_format($vOmzetDownL,0,",","."); 
		 $vMsgAll.=$vMsg;
		 echo $vMsg="<br>Omzet L : ".number_format($vOmzetDownR,0,",",".");
		 $vMsgAll.=$vMsg;

		    $vSyaratRD=0;
			$vSyaratDir=0;
			$vSyaratPM=0;
		 //Syarat Perinmgkat
		 if ($vLevel == 'RD') {
		    $vSyaratRD=1;
			$vSyaratDir=1;
			$vSyaratPM=1;
			
			

			echo $vMsg="<br><font color='#00f'>Syarat RD : Terpenuhi</font>";
			$vMsgAll.=$vMsg;
			echo $vMsg="<br><font color='#00f'>Syarat D : Terpenuhi</font>";
			$vMsgAll.=$vMsg;
			echo $vMsg="<br><font color='#00f'>Syarat PM : Terpenuhi</font>";
			$vMsgAll.=$vMsg;
			
			//Syarat Omzet
			if ($vOmzetDownL >= 1500000000 && $vOmzetDownR >= 1500000000) {
				echo $vMsg="<br><font color='#00f'>Syarat Profit Share RD : Terpenuhi</font>";
				$vMsgAll.=$vMsg;
				echo $vMsg="<br><font color='#00f'>Syarat Profit Share D : Terpenuhi</font>";
				$vMsgAll.=$vMsg;
				echo $vMsg="<br><font color='#00f'>Syarat Profit Share PM : Terpenuhi</font>";
				$vMsgAll.=$vMsg;
				$vQualiRD+=1;$vQualiDir+=1;$vQualiPM+=1;
				$vArrQualiRD[]=$vUser; $vArrQualiDir[]=$vUser; $vArrQualiPM[]=$vUser;

			} else	if ($vOmzetDownL >= 500000000 && $vOmzetDownR >= 500000000) {
				echo $vMsg="<br><font color='#00f'>Syarat Profit Share D : Terpenuhi</font>";
				$vMsgAll.=$vMsg;
				echo $vMsg="<br><font color='#00f'>Syarat Profit Share PM : Terpenuhi</font>";
				$vMsgAll.=$vMsg;
				$vQualiDir+=1;$vQualiPM+=1;
				$vArrQualiDir[]=$vUser; $vArrQualiPM[]=$vUser;
			} else	if ($vOmzetDownL >= 200000000 && $vOmzetDownR >= 200000000) {
				echo $vMsg="<br><font color='#00f'>Syarat Profit Share PM : Terpenuhi</font>";
				$vMsgAll.=$vMsg;
				$vQualiPM+=1;
				$vArrQualiPM[]=$vUser;
			}
			
			
		 } else if ($vLevel == 'D') {
		    $vSyaratRD=0;
			$vSyaratDir=1;
			$vSyaratPM=1;
			
			echo $vMsg="<br><font color='#00f'>Syarat RD : Tidak</font>";
			$vMsgAll.=$vMsg;
			echo $vMsg="<br><font color='#00f'>Syarat D : Terpenuhi</font>";
			$vMsgAll.=$vMsg;
			echo $vMsg="<br><font color='#00f'>Syarat PM : Terpenuhi</font>";
			$vMsgAll.=$vMsg;
			
			//Syarat Omzet
			if ($vOmzetDownL >= 500000000 && $vOmzetDownR >= 500000000) {
				echo $vMsg="<br><font color='#00f'>Syarat Profit Share D : Terpenuhi</font>";
				$vMsgAll.=$vMsg;
				echo $vMsg="<br><font color='#00f'>Syarat Profit Share PM : Terpenuhi</font>";
				$vMsgAll.=$vMsg;
				$vQualiDir+=1;$vQualiPM+=1;
				$vArrQualiDir[]=$vUser; $vArrQualiPM[]=$vUser;

			} else	if ($vOmzetDownL >= 200000000 && $vOmzetDownR >= 200000000) {
				echo $vMsg="<br><font color='#00f'>Syarat Profit Share PM : Terpenuhi</font>";
				$vMsgAll.=$vMsg;
				$vQualiPM+=1;
				$vArrQualiPM[]=$vUser;
				
			}

			
			
		 } else if ($vLevel == 'PM') {
		    $vSyaratRD=0;
			$vSyaratDir=0;
			$vSyaratPM=1;

			echo $vMsg="<br><font color='#00f'>Syarat RD : Tidak</font>";
			$vMsgAll.=$vMsg;
			echo $vMsg="<br><font color='#00f'>Syarat D : Tidak</font>";
			$vMsgAll.=$vMsg;
			echo $vMsg="<br><font color='#00f'>Syarat PM : Terpenuhi</font>";
			$vMsgAll.=$vMsg;

			//Syarat Omzet
			if ($vOmzetDownL >= 200000000 && $vOmzetDownR >= 200000000) {
				echo $vMsg="<br><font color='#00f'>Syarat Profit Share PM : Terpenuhi</font>";
				$vMsgAll.=$vMsg;
				$vQualiPM+=1;
				$vArrQualiPM[]=$vUser;
				
			}
			
		 }
		 
			
		

		
	   
   


		
		
		echo $vMsg="<br>============================ End Member <b>$vUser</b> ($vPaketText) ================================= <br>";
		$vMsgAll.=$vMsg;
	  
	  
		
	
				
		
				
		}  //while
		
		echo $vMsg="<br>$vCount member calculated on ".$vNow."<BR>\n";
		$vMsgAll.=$vMsg;

		echo $vMsg="<br><font color='#f00'>Jumlah Qualified RD : $vQualiRD</font></font>\n";
		$vMsgAll.=$vMsg;
		echo $vMsg="<br><font color='#f00'>Jumlah Qualified Dir : $vQualiDir</font>\n";
		$vMsgAll.=$vMsg;
		echo $vMsg="<br><font color='#f00'>Jumlah Qualified PM : $vQualiPM </font>\n<br>";
		$vMsgAll.=$vMsg;

   		echo $vMsg="<br><font color='#00f'>======================PROSES BONUS PROFIT SHARE================================</font><br>" ; 
		 $vMsgAll.=$vMsg;
		
		//Calculate RD
		if (is_array($vArrQualiRD)) {
			$vNo=0;
		    while(list($key,$val)=each($vArrQualiRD)) {
				$vNo++;
				$vProfitShareRD = ($vProsenPSRD / 100) * $vGlobalRO / $vQualiRD;
				$vProfitShareDir = ($vProsenPSDir / 100) * $vGlobalRO / $vQualiDir;
				$vProfitSharePM = ($vProsenPSPM / 100) * $vGlobalRO / $vQualiPM;

				echo $vMsg="<br>$vNo. [RD] <font color='#f00'>Bonus Profit Share RD :  ($vProsenPSRD /100 ) * $vGlobalRO / $vQualiRD </font>\n<br>";
				$vMsgAll.=$vMsg;
				echo $vMsg="<font color='#f00'>Insert bonus Profit Sharing RD/RD [$val] : ".number_format($vProfitShareRD,0,",",".")." </font>\n<br>";
				$vMsgAll.=$vMsg;





			   $vLastBal=$oMember->getMemField('fsaldovcr',$val);
			   $vFeeID = $val."-PFT-".date("YmdHis");	
			   $vNewBal=$vLastBal + $vProfitShareRD;
			   $vsql="insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fref,fincometax) "; 
			   $vsql.="values ('$val', '$val', '$vNowBns','Komisi Profit Sharing RD/RD - $vYear-$vMonth' , $vProfitShareRD,0 ,$vNewBal ,'profit' , '1','system' , '$vNow','$vFeeID',0) "; 
			   $db->query($vsql); 
			   $oMember->updateBalConn($val,$vNewBal,$db);


			   $vsql="insert into tb_kom_profit(ftanggal,fidfunder,fidmember,ffee,ffeestatus,fdesc) ";
			   $vsql.="values('$vNowBns','system','$val', $vProfitShareRD,'1','$vFeeID-RD/RD-($vProsenPSRD /100 ) * $vGlobalRO / $vQualiRD')";   
			   $db->query($vsql); 
				
				/*
				//RD Dir
				echo $vMsg="<br>$vNo. [RD] <font color='#f00'>Bonus Profit Share Dir :  ($vProsenPSDir /100 ) * $vGlobalRO / $vQualiDir </font>\n<br>";
				$vMsgAll.=$vMsg;
				echo $vMsg="<font color='#f00'>Insert bonus Profit Sharing RD/Dir [$val] : ".number_format($vProfitShareDir,0,",",".")." </font>\n<br>";
				$vMsgAll.=$vMsg;

			   $vLastBal=$oMember->getMemField('fsaldovcr',$val);
			   $vFeeID = $val."-PFT-".date("YmdHis");	
			   $vNewBal=$vLastBal + $vProfitShareDir;
			   $vsql="insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fref,fincometax) "; 
			   $vsql.="values ('$val', '$val', '$vNowBns','Komisi Profit Sharing RD/Dir - $vYear-$vMonth' , $vProfitShareDir,0 ,$vNewBal ,'profit' , '1','system' , '$vNow','$vFeeID',0) "; 
			   $db->query($vsql); 
			   $oMember->updateBalConn($val,$vNewBal,$db);



				//RD PM
				echo $vMsg="<br>$vNo. [RD] <font color='#f00'>Bonus Profit Share PM :  ($vProsenPSPM /100 ) * $vGlobalRO / $vQualiPM </font>\n<br>";
				$vMsgAll.=$vMsg;
				echo $vMsg="<font color='#f00'>Insert bonus Profit Sharing RD/PM [$val] : ".number_format($vProfitSharePM,0,",",".")." </font>\n<br>";
				$vMsgAll.=$vMsg;

			   $vLastBal=$oMember->getMemField('fsaldovcr',$val);
			   $vFeeID = $val."-PFT-".date("YmdHis");	
			   $vNewBal=$vLastBal + $vProfitSharePM;
			   $vsql="insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fref,fincometax) "; 
			   $vsql.="values ('$val', '$val', '$vNowBns','Komisi Profit Sharing RD/PM - $vYear-$vMonth' , $vProfitSharePM,0 ,$vNewBal ,'profit' , '1','system' , '$vNow','$vFeeID',0) "; 
			   $db->query($vsql); 
			   $oMember->updateBalConn($val,$vNewBal,$db);
*/
			   	
			}
			
		} 
		
		if (is_array($vArrQualiDir)) {
			$vNo=0;
		    while(list($key,$val)=each($vArrQualiDir)) {
				$vNo++;
				$vProfitShareDir = ($vProsenPSDir/100) * $vGlobalRO / $vQualiDir;
				$vProfitSharePM = ($vProsenPSPM / 100) * $vGlobalRO / $vQualiPM;
				//DIR /  DIR
				echo $vMsg="<br>$vNo. [Dir] <font color='#f00'>Bonus Profit Share Dir :  ($vProsenPSDir / 100) * $vGlobalRO / $vQualiDir </font>\n<br>";
				$vMsgAll.=$vMsg;
				
				echo $vMsg="<font color='#f00'>Insert bonus Profit Sharing Dir/Dir [$val] : ".number_format($vProfitShareDir,0,",",".")." </font>\n<br>";
				$vMsgAll.=$vMsg;
				
			   $vLastBal=$oMember->getMemField('fsaldovcr',$val);
			   $vFeeID = $val."-PFT-".date("YmdHis");	
			   $vNewBal=$vLastBal + $vProfitShareDir;
			   $vsql="insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fref,fincometax) "; 
			   $vsql.="values ('$val', '$val', '$vNowBns','Komisi Profit Sharing Dir/Dir - $vYear-$vMonth' , $vProfitShareDir,0 ,$vNewBal ,'profit' , '1','system' , '$vNow','$vFeeID',0) "; 
			   $db->query($vsql); 
			   $oMember->updateBalConn($val,$vNewBal,$db);


			   $vsql="insert into tb_kom_profit(ftanggal,fidfunder,fidmember,ffee,ffeestatus,fdesc) ";
			   $vsql.="values('$vNowBns','system','$val', $vProfitShareDir,'1','$vFeeID-Dir/Dir-($vProsenPSDir / 100) * $vGlobalRO / $vQualiDir')";   
			   $db->query($vsql); 
			   
				/*
				//DIR/PM
				echo $vMsg="<br>$vNo. [Dir] <font color='#f00'>Bonus Profit Share Dir / PM :  ($vProsenPSPM / 100) * $vGlobalRO / $vQualiPM </font>\n<br>";
				$vMsgAll.=$vMsg;
				
				echo $vMsg="<font color='#f00'>Insert bonus Profit Sharing Dir/PM [$val] : ".number_format($vProfitSharePM,0,",",".")." </font>\n<br>";
				$vMsgAll.=$vMsg;


			   $vLastBal=$oMember->getMemField('fsaldovcr',$val);
			   $vFeeID = $val."-PFT-".date("YmdHis");	
			   $vNewBal=$vLastBal + $vProfitSharePM;
			   $vsql="insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fref,fincometax) "; 
			   $vsql.="values ('$val', '$val', '$vNowBns','Komisi Profit Sharing Dir/PM - $vYear-$vMonth' , $vProfitSharePM,0 ,$vNewBal ,'profit' , '1','system' , '$vNow','$vFeeID',0) "; 
			   $db->query($vsql); 
			   $oMember->updateBalConn($val,$vNewBal,$db);
			   	*/
			}
			
		}


		if (is_array($vArrQualiPM)) {
			$vNo=0;
		    while(list($key,$val)=each($vArrQualiPM)) {
				$vNo++;
				$vProfitSharePM = ($vProsenPSPM/100) * $vGlobalRO / $vQualiDir;

				echo $vMsg="<br>$vNo. [PM] <font color='#f00'>Bonus Profit Share PM/PM :  ($vProsenPSPM / 100) * $vGlobalRO / $vQualiPM </font>\n<br>";
				$vMsgAll.=$vMsg;
				
				echo $vMsg="<br><font color='#f00'>Insert bonus Profit Sharing PM/PM [$val] : ".number_format($vProfitSharePM,0,",",".")." </font>\n<br>";
				$vMsgAll.=$vMsg;

			   $vLastBal=$oMember->getMemField('fsaldovcr',$val);
			   $vFeeID = $val."-PFT-".date("YmdHis");	
			   $vNewBal=$vLastBal + $vProfitSharePM;
			   $vsql="insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fref,fincometax) "; 
			   $vsql.="values ('$val', '$val', '$vNowBns','Komisi Profit Sharing PM/PM - $vYear-$vMonth' , $vProfitSharePM,0 ,$vNewBal ,'profit' , '1','system' , '$vNow','$vFeeID',0) "; 
			   $db->query($vsql); 
			   $oMember->updateBalConn($val,$vNewBal,$db);
				
			   $vsql="insert into tb_kom_profit(ftanggal,fidfunder,fidmember,ffee,ffeestatus,fdesc) ";
			   $vsql.="values('$vNowBns','system','$val', $vProfitSharePM,'1','$vFeeID-PM/PM-($vProsenPSPM / 100) * $vGlobalRO / $vQualiPM')";  
			   $db->query($vsql); 
			   	
			}
			
		}
		
		$db->query('COMMIT;');	
   		echo $vMsg="<br><font color='#00f'>======================END BONUS PROFIT SHARE================================</font><br>" ; 
		 $vMsgAll.=$vMsg;
		

	} else { echo $vMsg="Bulan dan Tahun tidak boleh kosong!";   $vMsgAll.=$vMsg;}

   $mtime = microtime(); 
   $mtime = explode(" ",$mtime); 
   $mtime = $mtime[1] + $mtime[0]; 
   $endtime = $mtime; 
   $totaltime = ($endtime - $starttime); 
   echo $vMsg="<br>Total time  ".$totaltime." seconds"; 
   $vMsgAll.=$vMsg;
   
  // mail("a_didit_m@yahoo.com","Bonus Pairing Compilation $vNow",$vMsg);
   $vFileName='../files/ProfitCompile'.date('Y-m-d_H.i.s').'.htm';
   $fp=fopen($vFileName,'w',true);
   fputs($fp,$vMsgAll,10000000);
   fclose($fp);

  
?>