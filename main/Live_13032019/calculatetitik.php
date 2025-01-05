<?
date_default_timezone_set('Asia/Jakarta');
$mtime = microtime(); 
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$starttime = $mtime; 
$vMsgAll.="<html><head><title>Compile Bonus Titik </title></head><body>";
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
   //$vDate=$_GET['uDate'];
   //if ($vDate=='')
     //  $vDate=date("Y-m-d");
   
   $vDate=$oMydate->dateSub($vDateCompile,1,'day');
   $vDateLastTime=$vDate." 23:59:59";
   $vNow=$vDateCompile." ".date("H:i:s"); 
   //$vThBul= substr($vDate,0,4).substr($vDate,5,2);
   //$vLimit=$_GET['uLimit'];
   $vThBul=substr($vDate,0,4).substr($vDate,5,2);
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
      
 
		$vYear=substr($vDate,0,4);
		$vMonth=substr($vDate,5,2);
  
   
 //  $vPairFeeSet = $vPairFeeSet / 100; 
   if (true) {   
   
	   $vsql="select * from m_anggota where ftglaktif not like '0000-00-00%' and fidmember like '%$vMember%'  order by fidsys  limit $vStartA,$vLimit";
	   $dbin->query($vsql);
	   $vCount=0;
	   

	    $db->query('START TRANSACTION;');
	   while ($dbin->next_record()) {
	     $vCount+=1;
		 $vUser=$dbin->f('fidmember');
		$vMonth = (int) $vMonth;

		 $vRoMaMonth = 	$oKomisi->getROMaMonth($vUser,$vYear, $vMonth);		 
		 
		 echo $vMsg="===================Start Member $vUser============================<br>";
		 $vMsgAll .= $vMsg;
		 echo $vMsg="Bulan Compile : $vDateCompile <br>";
		 $vMsgAll .= $vMsg;
		 echo $vMsg="Bulan Data :  $vDate <br>";

		 echo $vMsg="Member $vUser : <br>";
		 $vMsgAll .= $vMsg;
		 
		 $vHaveSpon=$oNetwork->hasSponsorshipMonth($vUser,$vThBul);
		 $vHavePair=$oNetwork->hasPairingMonth($vUser,$vThBul);
		 
		 if ($vHaveSpon == '1' ||  $vHavePair=='1') {
		     $vSQLin="select sum(ffee) as fsum from tb_kom_mtx where fidmember='$vUser' and ffeestatus='0' and date_format(ftanggal,'%Y%m')='$vThBul'";
		    $db1->query($vSQLin);
		    $db1->next_record();
			
		    echo $vMsg="<br><font color='#0f0'>Hitung bonus titik :" ;
			$vMsgAll .= $vMsg;
		    $vFeeTitik=$db1->f('fsum');
		    if ($vFeeTitik=='') $vFeeTitik =0;
		   
		    
		    //$vFunder=$db->f('fidregistrar');
		    echo $vMsg=$vFeeTitik; 
			$vMsgAll .= $vMsg;
		    echo $vMsg="</font><br>";
			$vMsgAll .= $vMsg;

		    $vFeeAdmin=$oRules->getSettingByField('fbyyadmin');
			$vProsenNex=$oRules->getSettingByField('fprosencash');
			$vProsenRO=$oRules->getSettingByField('fprosenauto');
			$vMaxMaRO = $oRules->getSettingByField('fmaxrowal');

		    
			$vFeeTitikOri=$vFeeTitik;
			
			$vFeeTitikRO=$vFeeTitik* $vProsenRO / 100; //20%
			$vFeeTitik=$vFeeTitik* $vProsenNex / 100; //80%
		
		    $vFeeTitikAdm=($vFeeTitik* $vFeeAdmin / 100);
		    $vFeeTitikNett = $vFeeTitik- $vFeeTitikAdm;

		    //Masukkan bonus
		    if ($vFeeTitik > 0) {
		         echo $vMsg="<font color='#00f'>RO Month :  ".number_format($vRoMaMonth,0,",",".")." </font><br>";	 
				 $vMsgAll .= $vMsg;
				echo $vMsg="<font color='#00f'>Insert bonus titik :  $vFeeTitikNett nett Nexwallet </font><br>";
				$vMsgAll .= $vMsg;


			    if ($vRoMaMonth >= $vMaxMaRO ) {
			        $vFeeTitik= $vFeeTitikOri;
			        $vFeeTitikNett=$vFeeTitik - ($vFeeTitik * $vFeeAdmin / 100);
					$vOri=" original ";
			    } else $vOri='';
		       //echo "$vUser PPPPPPPPPPPPPP";
				$vLastBal=$oMember->getMemField('fsaldovcr',$vUser);
				$vNewBal=$vLastBal + $vFeeTitikNett ;
				$vUserL=$_SESSION['LoginUser'];
				//$vDistance=$oNetwork->getDistance($vUser,$vSponsor);
				 $vsql="insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fincometax) "; 
				 $vsql.="values ('$vUser', 'Multiple', '$vDateLastTime','Bonus royalty [$vUser]  $vOri - $vThBul' , $vFeeTitikNett ,0 ,$vNewBal ,'titik' , '1','System' , now(),$vFeeTitikAdm) "; 
				    
				$db->query($vsql); 
				   
				$oMember->updateBalConn($vUser,$vNewBal,$db);

			    if ($vRoMaMonth < $vMaxMaRO ) {
					//Apakah sisa kurang dari RO
					 
					if(($vMaxMaRO-$vRoMaMonth) < $vFeeTitikRO) {
						  $vFeeTitikROOri=$vFeeTitikRO;//Simpan yg asli
						  $vFeeTitikRO= ($vMaxMaRO-$vRoMaMonth); //RO menjadi selisih antara Max dan existing bonus bulanan
						  $vSelisih = $vFeeTitikROOri - $vFeeTitikRO ;//Selisih akan menjadi overflow ke NExWallet
						   $vSelisihNett=$vSelisih - ($vSelisih * $vFeeAdmin / 100);
						  $vTax=$vSelisih * $vFeeAdmin / 100; 
							//Sisa RO		
							echo $vMsg="<font color='#f00'>Masukkan Overflow :  $vSelisihNett nett ke Nexwallet </font><br>";				  
							$vMsgAll .= $vMsg;
							$vLastBal=$oMember->getMemField('fsaldovcr',$vUser);
							$vNewBal=$vLastBal + $vSelisih ;
							$vUserL=$_SESSION['LoginUser'];
							$vsql="insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fincometax) "; 
							$vsql.="values ('$vUser', 'Multiple', '$vDateLastTime','Bonus royalty [$vUser]  (overflow RO) $vThBul' , $vSelisihNett ,0 ,$vNewBal ,'titik' , '1','$vUserL' , now(),$vTax) "; 
							$db->query($vsql); 
							$oMember->updateBalConn($vUser,$vNewBal,$db);
						  
						  
						  
			    	 }

				

			        echo $vMsg="<font color='#090'>Insert Bonus Titik :  $vFeeTitikRO  ke RO wallet </font><br>";				  	
					$vMsgAll .= $vMsg;
					$vLastBal=$oMember->getMemField('fsaldoro',$vUser);
					$vNewBal=$vLastBal + $vFeeTitikRO;
		 			
					$vsql="insert into tb_mutasi_ro (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fincometax) "; 
					$vsql.="values ('$vUser', 'Multiple', '$vDateLastTime','Bonus royalty RO [$vUser] $vThBul' , $vFeeTitikRO,0 ,$vNewBal ,'titik' , '1','System' , now(),0) "; 
					$db->query($vsql); 
					
				    $oMember->updateBalConnRO($vUser,$vNewBal,$db);
					
			 }


			}
		    
		    
		    
		 }

		 echo $vMsg="===================End Member $vUser============================<br>";
		 $vMsgAll .= $vMsg;
	
		}  //while
		
		    $vSQLin="update tb_kom_mtx set ffeestatus ='1' where  date_format(ftanggal,'%Y%m')='$vThBul'";
//		    $db->query($vSQLin);
		
		$db->query('COMMIT;');	
		echo $vMsg="<br>$vCount member calculated on ".$vNow."<BR>\n";
		$vMsgAll .= $vMsg;
		

	} else { echo $vMsg="Bulan dan Tahun tidak boleh kosong!"; $vMsgAll .= $vMsg; } 

   $mtime = microtime(); 
   $mtime = explode(" ",$mtime); 
   $mtime = $mtime[1] + $mtime[0]; 
   $endtime = $mtime; 
   $totaltime = ($endtime - $starttime); 
   echo $vMsg="Total time  ".$totaltime." seconds"; 
   $vMsgAll .= $vMsg;
   
    $vMsgAll.="</body></html>";
   
  // mail("a_didit_m@yahoo.com","Bonus Pairing Compilation $vNow",$vMsg);
   $vFileName='../files/TitikCompile'.date('Y-m-d_H.i.s').'.htm';
   $fp=fopen($vFileName,'w',true);
   fputs($fp,$vMsgAll,10000000);
   fclose($fp);

  
?>