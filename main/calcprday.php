<?
date_default_timezone_set('Asia/Jakarta');
$mtime = microtime(); 
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$starttime = $mtime; 
echo $vMsgAll.="<html><head><title>Compile Bonus Poin Reward Recruitment </title></head><body>";
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

   echo "==========================================<b>Compile PR Day ".$_GET['uDate']."</b>===================================================== <br><br>";
   $vMsgAll .="==========================================Compile PR Day===================================================== <br>";
	
   $vMsgAll.=$vMsg;

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
   
   $vBaseRwd = $oRules->getSettingByField('fbasereward');
   $vRegNom = $oRules->getSettingByField('fregnom');
  $vMailFrom=$oRules->getSettingByField('fmailadmin');
   $vPairSetFee =1;
  
   $vMaxCFDay=1000000000; //Unlimited 
  	
   $vMaxPair=1000000000; //Unlimited


   
     
   if (true) {   
   
	   $vsql="select * from m_anggota where ftglaktif not like '0000-00-00%' and fidmember like '%$vMember%'  order by fidsys  limit $vStartA,$vLimit";
 //$vsql="select fdownline as fidmember from tb_updown where ftanggal not like '0000-00-00%' and fdownline like '%$vMember%'  order by fidsys  limit $vStartA,$vLimit"; 	   
	   $dbin->query($vsql);
	   $vCount=0;
	    $db->query('START TRANSACTION;');
	   while ($dbin->next_record()) {
	     $vCount+=1;
		 $vUser=$dbin->f('fidmember');
		 
		 $vPaket=$oMember->getPaketID($vUser);
		 
		 
		 $vMemberName=$oMember->getMemberName($vUser);
	


		 echo $vMsg ="============================ Start Member <b style='color:#00f'>$vUser</b> ($vMemberName - $vPaket) ================================= <br>";
		 $vMsgAll.=$vMsg;
		

			   echo $vMsg="<br>Max Pasang  yg dihitung : Unlimited<br>";
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
		

		 echo $vMsg="<br>";
		  $vMsgAll.=$vMsg;

		 
		 //Omzet dimulai dari kaki pertama
		$vSmallLeg ='';$vSmallLegNom=0;
		if ($vKakiL !=-1 && $vKakiL !='') //Kiri ada
		    //$OmzetDownL=$oKomisi->getOmzetROWholeMemberByDate($vKakiL,$vDate,$vDate); //nex
			$OmzetDownL=$oNetwork->getDownlineCountActivePeriod($vKakiL,$vDate,$vDate); //spectra, Ono
			//$OmzetDownL=$oKomisi->getOmzetFOWholeMemberByDate($vKakiL,$vDate,$vDate); //unig
		else	
		    $OmzetDownL=0;
			
		if ($vKakiR !=-1 && $vKakiR !='') //Kanan Ada
		    $OmzetDownR=$oNetwork->getDownlineCountActivePeriod($vKakiR,$vDate,$vDate); //ono
			//$OmzetDownR=$oKomisi->getOmzetFOWholeMemberByDate($vKakiR,$vDate,$vDate); //unig
		else	
		    $OmzetDownR=0;

//echo "<br> $OmzetDownR = $OmzetDownR * $vRegNom / $vBaseRwd;	";

			$OmzetDownL = $OmzetDownL * $vRegNom / $vBaseRwd;
			$OmzetDownR = $OmzetDownR * $vRegNom / $vBaseRwd;	
		
		$vCF=0;
		//$vCF=$oKomisi->getPairCF($vUser,$vDate);
		//Kelola CF
		$vFeeID = "PRREG-".$vUser."-".$vDate;
		if (($vKakiL !=-1 && $vKakiL !='') && ($vKakiR ==-1 || $vKakiR =='')) {// Kaki Kiri Saja 
		//CF Kiri   
		   $vCFBefore=$oKomisi->getPRCFPos($vUser,'L',$vDateCompile);
		   $vCFSisa=$OmzetDownL + $vCFBefore;  
		  
		   if ($vCFSisa > 0) {
			   if ($vCFSisa > $vMaxCFDay) {
				   $vSelisih = $vCFSisa - $vMaxCFDay;
				   $vCFSisa = $vMaxCFDay;   
				   $vFeeID = $vFeeID."-FLUSH-$vSelisih";
			   }
			   echo $vMsg="<br>$vUser PR  Kiri : $vCFSisa<br>";
			   $vMsgAll.=$vMsg;
			   echo $vMsg="<font color='#0f0'>Insert PR kiri : ".number_format($vCFSisa,0,",",".")." - $vFeeID</font><br>";
			   $vMsgAll.=$vMsg;
			   
				//CF 
			   	
					
				
			   $vSQL="insert into tb_kom_pr(fidreceiver, fidregistrar, ffee,ffeenom, fcf,flr,ftanggal,fidfee,flog,ffeestatus)";
		       $vSQL.=" values('$vUser','system',$vCFSisa,$vCFSisa,0,'L','$vNowBns','$vFeeID','','1' )";
		   
		   $db->query($vSQL);
			   
			   
		   }
		}  else  if (($vKakiR !=-1 && $vKakiR !='') && ($vKakiL ==-1 || $vKakiL =='')) {//Kaki Kanan Saja
		
		//CF Kanan
		   $vCFBefore=$oKomisi->getPRCFPos($vUser,'R',$vDateCompile);
		   $vCFSisa=$OmzetDownR + $vCFBefore;    
		   
		   if ($vCFSisa > 0) {
			   if ($vCFSisa > $vMaxCFDay) {
				   $vSelisih = $vCFSisa - $vMaxCFDay;
				   $vCFSisa = $vMaxCFDay;   
				   $vFeeID = $vFeeID."-FLUSH-$vSelisih";
			   }
			   
			   echo $vMsg="$vUser PR  Kanan : $vCFSisa <br>";
			   $vMsgAll.=$vMsg;
			   echo $vMsg="<font color='#0f0'>Insert PR kanan : $vCFSisa - $vFeeID</font>";
			   $vMsgAll.=$vMsg;
			   
	
  $vSQL="insert into tb_kom_pr(fidreceiver, fidregistrar, ffee,ffeenom, fcf,flr,ftanggal,fidfee,flog,ffestatus)";
		       $vSQL.=" values('$vUser','system',$vCFSisa,$vCFSisa,0,'R','$vNowBns','$vFeeID','','1' )";			
			  
			   
		   
		   }
		   
		} else  if (($vKakiR !=-1 && $vKakiR !='') && ($vKakiL !=-1 && $vKakiL !='')) {//Kaki Kanan Kiri
		
				//CF Kanan
				   $vCFBefore=$oKomisi->getPRCFPos($vUser,'R',$vDateCompile);
				   $vCFBeforeR=$vCFBefore;
				   $vCFSisaR=$OmzetDownR + $vCFBefore;    
				//CF Kiri
				   $vCFBefore=$oKomisi->getPRCFPos($vUser,'L',$vDateCompile);
				   $vCFBeforeL=$vCFBefore;
				   $vCFSisaL=$OmzetDownL + $vCFBefore;    
				  // echo "<br>Omzet kiri:$vCFSisaL";
				//   echo "<br>Omzet kanan:$vCFSisaR";
				   //pincang
				//   echo "sssss";
				   if ($vCFSisaR > 0 && $vCFSisaL <=0 ) {//Kanan
	
						if ($vCFSisaR > $vMaxCFDay) {
							$vSelisih = $vCFSisaR - $vMaxCFDay;
							$vCFSisaR = $vMaxCFDay;   
							$vFeeID = $vFeeID."-PRFLUSH-$vSelisih";
						}
							
							echo $vMsg="$vUser PR  Kanan : $vCFSisaR <br>";
							$vMsgAll.=$vMsg;
							echo $vMsg="<font color='#0f0'>Insert PR kanan : $vCFSisaR - $vFeeID</font>";
							$vMsgAll.=$vMsg;
							
						
						 	$vSQL="insert into tb_kom_pr(fidreceiver, fidregistrar, ffee,ffeenom, fcf,flr,ftanggal,fidfee,flog,ffeestatus)";
							$vSQL.=" values('$vUser','system',$vCFSisaR,$vCFSisaR,0,'R','$vNowBns','$vFeeID','','1' )";
			   							
							$db->query($vSQL); 
							
				   } else  if ($vCFSisaL > 0 && $vCFSisaR <=0 ) { //Kiri

						   if ($vCFSisaL > $vMaxCFDay) {
							   $vSelisih = $vCFSisaL - $vMaxCFDay;
							   $vCFSisaL = $vMaxCFDay;   
							   $vFeeID = $vFeeID."-FLUSH-$vSelisih";
						   }
							   
							   echo $vMsg="$vUser PR Kiri : $vCFSisaL <br>";
							   $vMsgAll.=$vMsg;
							   echo $vMsg="<font color='#0f0'>Insert PRCF kiri : ".number_format($vCFSisaL,0,',','.')." - $vFeeID</font>";
							   $vMsgAll.=$vMsg;
							   
										   
							   $vSQL="insert into tb_kom_pr(fidreceiver, fidregistrar, ffee,ffeenom, fcf,flr,ftanggal,fidfee,flog,ffeestatus)";
							$vSQL.=" values('$vUser','system',$vCFSisaL,$vCFSisaL,0,'L','$vNowBns','$vFeeID','','1' )";

							   $db->query($vSQL); 	
							   
				   }  else  if ($vCFSisaL > 0 && $vCFSisaR > 0 ) {//Kiri kanan

						   if ($vCFSisaL > $vMaxCFDay) {
							   $vSelisih = $vCFSisaL - $vMaxCFDay;
							   $vCFSisaL = $vMaxCFDay;   
							   $vFeeID = $vFeeID."-FLUSH-$vSelisih";
						   }
							   
							   echo $vMsg="$vUser PR Kiri : $vCFSisaL <br>";
							   echo $vMsg="$vUser PR Kanan : $vCFSisaR <br>";
							   
							   $vMsgAll.=$vMsg;
							   
							   echo $vMsg="<font color='#0f0'>Insert PR kiri : ".number_format($vCFSisaL,0,',','.')." - $vFeeID</font><br>";
							   $vMsgAll.=$vMsg;
							   
										   
							   $vSQL="insert into tb_kom_pr(fidreceiver, fidregistrar, ffee,ffeenom, fcf,flr,ftanggal,fidfee,flog,ffeestatus)";
						 	$vSQL.=" values('$vUser','system',$vCFSisaL,$vCFSisaL,0,'L','$vNowBns','$vFeeID','','1' )";

							   $db->query($vSQL); 	
									
								   

							   echo $vMsg="<font color='#0f0'>Insert PR kanan : ".number_format($vCFSisaR,0,',','.')." - $vFeeID</font><br>";
							   $vMsgAll.=$vMsg;
							   
										   
							   $vSQL="insert into tb_kom_pr(fidreceiver, fidregistrar, ffee,ffeenom, fcf,flr,ftanggal,fidfee,flog,ffeestatus)";
						 	$vSQL.=" values('$vUser','system',$vCFSisaR,$vCFSisaR,0,'R','$vNowBns','$vFeeID','','1' )";

							   $db->query($vSQL); 	
							   

				 $vIsiSMS = $oRules->getSettingByField('fsmsbonusprd');
				 $vIsiSMS=str_replace("{BONUSPRD}",number_format($vBonus,0,",","."),$vIsiSMS);
				 if ($vHP !='')
				     $oSystem->sendSMS($vHP, $vIsiSMS,$vUserGO,$vPassGO);
					 
				$vSubject="Pemberitahuan  Bonus PR Harian";
				 if ($vEmail !='')
				     $oSystem->smtpmailer($vEmail,$vMailFrom,'Onotoko',$vSubject,$vIsiSMS,$oRules->getSettingByField('fmailbcc'),"");
					   
				   
				   }


		
		
		}	
	
	

		
		echo $vMsg="<br>============================ End Member <b>$vUser</b> ($vPaket) ================================= <br>";
		$vMsgAll.=$vMsg;
			
			
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
   $vMsgX.="Total time  ".$totaltime." seconds"; 
    $vMsgX.="</body></html>";
   
 //  mail("a_didit_m@yahoo.com","Onotoko Bonus PR Compilation $vNow",$vMsgX);
  // $oSystem->smtpmailer($oRules->getSettingByField('fmailbcc'),$vMailFrom,'Onotoko','Compile PR Harian','Well Run!',$oRules->getSettingByField('fmailbcc'),"");
   
   $vFileName='../files/PRDayCompile'.date('Y-m-d_H.i.s').'.htm';
   $fp=fopen($vFileName,'w',true);
   fputs($fp,$vMsgAll,10000000);
   fclose($fp);

  
?>