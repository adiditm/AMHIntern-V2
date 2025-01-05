<?
date_default_timezone_set('Asia/Jakarta');
$mtime = microtime(); 
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$starttime = $mtime; 
echo $vMsgAll.="<html><head><title>Compile Bonus Matching </title></head><body>";
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
   $vDate=$_GET['uDate'];
   if ($vDate=='')
       $vDate=date("Y-m-d");
   
   $vDate=$oMydate->dateSub($vDate,1,'day');
    $vNow=$vDateCompile." ".date("H:i:s"); 
   $vNowBns=$vDate." 23:59:59";
   //$vLimit=$_GET['uLimit'];
   
   $vProsenKembang = $oRules->getSettingByField('ffeekembang');
   	  
   $vPairFeeSet=$oRules->getSettingByField('ffeepair');	  
   $vPairFeeSet = 1; //Langsung nominal
   
  // $vMaxKembangS=$oRules->getSettingByField('fmaxkems');
  // $vMaxKembangG=$oRules->getSettingByField('fmaxkemg');	
  // $vMaxKembangP=$oRules->getSettingByField('fmaxkemp');	


    $vProsenMatchS=$oRules->getSettingByField('fmatchs');
    $vProsenMatchG=$oRules->getSettingByField('fmatchg');
    $vProsenMatchP=$oRules->getSettingByField('fmatchp');
   
   $vProsenCash=$oRules->getSettingByField('fprosencash');
   $vProsenWProd=$oRules->getSettingByField('fprosenwprod');


   $vPTKPMonth=$oRules->getSettingByField('fptkp');
   $vPTKPYear=$oRules->getSettingByField('fptkpy');
   $vProsenNormaPPH=$oRules->getSettingByField('fnormapph');
   $vProsenAdm=$oRules->getSettingByField('ffeeadmin');


	$vProsenTaxNPWP=$oRules->getSettingByField('ftaxnpwp');
	$vProsenTaxNonNPWP=$oRules->getSettingByField('ftaxnonpwp');

//	$vProsenTaxNPWP=0;
//	$vProsenTaxNonNPWP=0;
//	$vProsenTax = 0;
   
     
   if (true) {   
   
	   $vsql="select * from m_anggota where ftglaktif not like '0000-00-00%' and fidmember like '%$vMember%'  order by fidsys  limit $vStartA,$vLimit";
	   $dbin->query($vsql);
	   $vCount=0;
	    $db->query('START TRANSACTION;');
	   while ($dbin->next_record()) {
	     $vCount+=1;
		 $vUser=$dbin->f('fidmember');




		 
		 $vUp1=$oNetwork->getSponLevel($vUser,1);
		 $vUp2=$oNetwork->getSponLevel($vUser,2);
		 
		 $vUp3=$oNetwork->getSponLevel($vUser,3);
		 
		 $vPaketUp1=$oMember->getPaketID($vUp1);
		 $vPaketUp2=$oMember->getPaketID($vUp2);
		 $vPaketUp3=$oMember->getPaketID($vUp3);
		 $vPaket=$oMember->getPaketID($vUser);
		 
		 if ($vUp1 !=-1 && $vUp1 !='' && $vUp1 !='-') {
			 if ($vPaketUp1 == 'S')
			   $vProsenMatchUp1=$vProsenMatchS;
			 else if ($vPaketUp1 == 'G') 
			   $vProsenMatchUp1=$vProsenMatchG;
			 else if ($vPaketUp1 == 'P') 
			   $vProsenMatchUp1=$vProsenMatchP; 
		 } else $vProsenMatchUp1=0;

       
		if ($vUp2 !=-1 && $vUp2 !='' && $vUp2 !='-') {
			
			 if ($vPaketUp2 == 'S')
			   $vProsenMatchUp2=$vProsenMatchS;
			 else if ($vPaketUp2 == 'G') 
			   $vProsenMatchUp2=$vProsenMatchG;
			 else if ($vPaketUp2 == 'P') 
			   $vProsenMatchUp2=$vProsenMatchP; 
		}  else $vProsenMatchUp2=0;


		if ($vUp3 !=-1 && $vUp3 !='' && $vUp3 !='-') {
			 if ($vPaketUp3 == 'S')
			   $vProsenMatchUp3=$vProsenMatchS;
			 else if ($vPaketUp3 == 'G') 
			   $vProsenMatchUp3=$vProsenMatchG;
			 else if ($vPaketUp3 == 'P') 
			   $vProsenMatchUp3=$vProsenMatchP; 
		}  else $vProsenMatchUp3=0;
		 
		 
		 
		 $vMemberName=$oMember->getMemberName($vUser);
	


		echo $vMsg="============================ Start Member <b style='color:#00f'>$vUser</b> ($vMemberName - $vPaket) ================================= <br>";
		 $vMsgAll.=$vMsg;
		
				$vBonusA=$oKomisi->getBonusAByDate($vUser,$vDate,$vDate);

				
			   echo $vMsg="<br>Bonus Sponsor + Pengembangan : ".number_format($vBonusA,0,",",".")."<br>";
			   $vMsgAll.=$vMsg;
			  
			   if ($vUp1 !=-1 && $vUp1 !='' && $vUp1 !='-'  ) {	 //Level 1
				   if ($vProsenMatchUp1 > 0 && $vBonusA >0) {
						$vMatchFee1 = $vProsenMatchUp1 * $vBonusA / 100;
						$vMatchFee1Cash = $vProsenCash * $vMatchFee1 / 100;
						$vMatchFee1WProd = $vProsenWProd * $vMatchFee1 / 100;		
						
						echo $vMsg="Send to sponsor level 1 ($vUp1) ($vProsenMatchUp1%) (x 80%Cash) : ".number_format($vMatchFee1Cash,0,",",".")."<br>";
						$vMsgAll.=$vMsg;

			
			//=============Income UpSpon===================//
						$vNPWP = $oMember->getMemField('fnpwp',$vUp1);
						if (trim($vNPWP) != '')
						   $vProsenTax = $vProsenTaxNPWP;
						else    
						   $vProsenTax = $vProsenTaxNonNPWP;
			
			
						$vYearMonth=substr(date("Y-m-d"),0,7);
						$vYear=substr(date("Y-m-d"),0,4);
						$vIncomeMonth = $oKomisi->getBonusMonth($vUp1,$vYearMonth);
						$vIncomeYear = $oKomisi->getBonusYear($vUp1,$vYear);
						$vMatchFee1CashAdm=$vMatchFee1Cash * ($vProsenAdm / 100);
						$vFeeID='';
						if ($vIncomeMonth >= $vPTKPMonth || $vIncomeYear >= $vPTKPYear) {
							$vTaxPPH = $vMatchFee1Cash  * ($vProsenTax /100) * ($vProsenNormaPPH / 100);
							$vMatchFee1CashNett = $vMatchFee1Cash - $vTaxPPH - $vMatchFee1CashAdm;
							
							$vFeeID .= " nett with PPH $vProsenNormaPPH%";
						} else {
							$vTaxPPH = 0;
							$vMatchFee1CashNett = $vMatchFee1Cash - $vTaxPPH - $vMatchFee1CashAdm;
							$vFeeID .= " nett ";
						}
			//=============Income UpSponsor===================//

				
						//$vMatchFee1CashAdm=$vMatchFee1Cash * $vProsenTax / 100;
					//	$vMatchFee1CashNett = $vMatchFee1Cash - $vMatchFee1CashAdm;
						 
						$vLastBal=$oMember->getMemField('fsaldovcr',$vUp1);  
						
						
					   echo $vMsg="<font color='#f00'>Insert Bonus Matching ke mutasi Cash gross (".number_format($vMatchFee1Cash,0,",",".")."), nett (".number_format($vMatchFee1CashNett,0,",",".").")  ke Wallet Cash </font><br>";	
					   $vMsgAll.=$vMsg;
						
					   $vNewBal=$vLastBal + $vMatchFee1CashNett;
					   $vsql="insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fref,fincometax) "; 
					   $vsql.="values ('$vUp1', '$vUser', '$vNowBns','Bonus Matching - $vUp1 from $vUser Level-1 $vFeeID' , $vMatchFee1CashNett,0 ,$vNewBal ,'matching' , '1','system' , '$vNow','',$vTaxPPH) "; 
					   $db->query($vsql); 
					  $oMember->updateBalConn($vUp1,$vNewBal,$db);					  

	
						echo $vMsg="Send to sponsor level 1 ($vUp1) ($vProsenMatchUp1%) (x 20%Automain) : ".number_format($vMatchFee1WProd,0,",",".")."<br>";
						$vMsgAll.=$vMsg;


						$vLastBal=$oMember->getMemField('fsaldowprod',$vUp1);  
						
					   echo $vMsg="<font color='#f00'>Insert Bonus Matching ke mutasi Wallet Product gross (".number_format($vMatchFee1WProd,0,",",".")."), nett (".number_format($vMatchFee1WProd,0,",",".").")  ke Wallet Product </font><br>";	
					   $vMsgAll.=$vMsg;
						
					   $vNewBal=$vLastBal + $vMatchFee1WProd;
					   $vsql="insert into tb_mutasi_wprod (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fref,fincometax) "; 
					   $vsql.="values ('$vUp1', '$vUser', '$vNowBns','Bonus Matching - $vUp1 from $vUser Level-1' , $vMatchFee1WProd,0 ,$vNewBal ,'matching' , '1','system' , '$vNow','',0) "; 
					   $db->query($vsql); 
					  $oMember->updateBalConnWProd($vUp1,$vNewBal,$db);					  
				   }
			   
			   } //end level 1
			   
	   
			  if ($vUp2 !=-1 && $vUp2 !='' && $vUp2 !='-'  ) { 	 //Level 2
				   if ($vProsenMatchUp2 > 0 && $vBonusA >0) {
						$vMatchFee2 = $vProsenMatchUp2 * $vBonusA / 100;
						$vMatchFee2Cash = $vProsenCash * $vMatchFee2 / 100;
						$vMatchFee2WProd = $vProsenWProd * $vMatchFee2 / 100;		
						
						echo $vMsg="Send to sponsor level 2 ($vUp2) ($vProsenMatchUp2%) (x 80%Cash) : ".number_format($vMatchFee2Cash,0,",",".")."<br>";
						$vMsgAll.=$vMsg;

			//=============Income UpSpon===================//
						$vNPWP = $oMember->getMemField('fnpwp',$vUp2);
						if (trim($vNPWP) != '')
						   $vProsenTax = $vProsenTaxNPWP;
						else    
						   $vProsenTax = $vProsenTaxNonNPWP;
			
			
						$vYearMonth=substr(date("Y-m-d"),0,7);
						$vYear=substr(date("Y-m-d"),0,4);
						$vIncomeMonth = $oKomisi->getBonusMonth($vUp2,$vYearMonth);
						$vIncomeYear = $oKomisi->getBonusYear($vUp2,$vYear);
						$vMatchFee2CashAdm=$vMatchFee2Cash * ($vProsenAdm / 100);
						$vFeeID='';
						if ($vIncomeMonth >= $vPTKPMonth || $vIncomeYear >= $vPTKPYear) {
							$vTaxPPH = $vMatchFee2Cash  * ($vProsenTax /100) * ($vProsenNormaPPH / 100);
							$vMatchFee2CashNett = $vMatchFee2Cash - $vTaxPPH - $vMatchFee2CashAdm;
							
							$vFeeID .= " nett with PPH $vProsenNormaPPH%";
						} else {
							$vTaxPPH = 0;
							$vMatchFee2CashNett = $vMatchFee2Cash - $vTaxPPH - $vMatchFee2CashAdm;
							$vFeeID .= " nett ";
						}
			//=============Income UpSponsor===================//
				
					//	$vMatchFee2CashAdm=$vMatchFee2Cash * $vProsenTax / 100;
					//	$vMatchFee2CashNett = $vMatchFee2Cash - $vMatchFee2CashAdm;
						 
						$vLastBal=$oMember->getMemField('fsaldovcr',$vUp2);  
						
					   echo $vMsg="<font color='#f00'>Insert Bonus Matching ke mutasi Cash gross (".number_format($vMatchFee2Cash,0,",",".")."), nett (".number_format($vMatchFee2CashNett,0,",",".").")  ke Wallet Cash </font><br>";	
					   $vMsgAll.=$vMsg;
						
					   $vNewBal=$vLastBal + $vMatchFee2CashNett;
					   $vsql="insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fref,fincometax) "; 
					   $vsql.="values ('$vUp2', '$vUser', '$vNowBns','Bonus Matching - $vUp2 from $vUser Level-2 $vFeeID' , $vMatchFee2CashNett,0 ,$vNewBal ,'matching' , '1','system' , '$vNow','',$vTaxPPH) "; 
					   $db->query($vsql); 
					  $oMember->updateBalConn($vUp2,$vNewBal,$db);					  

	
						echo $vMsg="Send to sponsor level 2 ($vUp2) ($vProsenMatchUp2%) (x 20%Automain) : ".number_format($vMatchFee2WProd,0,",",".")."<br>";
						$vMsgAll.=$vMsg;


						$vLastBal=$oMember->getMemField('fsaldowprod',$vUp2);  
						
					   echo $vMsg="<font color='#f00'>Insert Bonus Matching ke mutasi Wallet Product gross (".number_format($vMatchFee2WProd,0,",",".")."), nett (".number_format($vMatchFee2WProd,0,",",".").")  ke Wallet Product </font><br>";	
					   $vMsgAll.=$vMsg;
						
					   $vNewBal=$vLastBal + $vMatchFee2WProd;
					   $vsql="insert into tb_mutasi_wprod (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fref,fincometax) "; 
					   $vsql.="values ('$vUp2', '$vUser', '$vNowBns','Bonus Matching - $vUp2 from $vUser Level-2' , $vMatchFee2WProd,0 ,$vNewBal ,'matching' , '1','system' , '$vNow','',0) "; 
					   $db->query($vsql); 
					  $oMember->updateBalConnWProd($vUp2,$vNewBal,$db);					  
				   }
			   
			   } //end level 2 
		 
	

			   if ($vUp3 !=-1 && $vUp3 !='' && $vUp3 !='-'   ) {	 //Level 3
				   if ($vProsenMatchUp3 > 0 && $vBonusA >0) {
						$vMatchFee3 = $vProsenMatchUp3 * $vBonusA / 100;
						$vMatchFee3Cash = $vProsenCash * $vMatchFee3 / 100;
						$vMatchFee3WProd = $vProsenWProd * $vMatchFee3 / 100;		
						
						echo $vMsg="Send to sponsor level 3 ($vUp3) ($vProsenMatchUp3%) (x 80%Cash) : ".number_format($vMatchFee3Cash,0,",",".")."<br>";
						$vMsgAll.=$vMsg;


			//=============Income UpSpon===================//
						$vNPWP = $oMember->getMemField('fnpwp',$vUp3);
						if (trim($vNPWP) != '')
						   $vProsenTax = $vProsenTaxNPWP;
						else    
						   $vProsenTax = $vProsenTaxNonNPWP;
			
			
						$vYearMonth=substr(date("Y-m-d"),0,7);
						$vYear=substr(date("Y-m-d"),0,4);
						$vIncomeMonth = $oKomisi->getBonusMonth($vUp3,$vYearMonth);
						$vIncomeYear = $oKomisi->getBonusYear($vUp3,$vYear);
						$vMatchFee3CashAdm=$vMatchFee3Cash * ($vProsenAdm / 100);
						$vFeeID='';
						if ($vIncomeMonth >= $vPTKPMonth || $vIncomeYear >= $vPTKPYear) {
							$vTaxPPH = $vMatchFee3Cash  * ($vProsenTax /100) * ($vProsenNormaPPH / 100);
							$vMatchFee3CashNett = $vMatchFee3Cash - $vTaxPPH - $vMatchFee3CashAdm;
							
							$vFeeID .= " nett with PPH $vProsenNormaPPH%";
						} else {
							$vTaxPPH = 0;
							$vMatchFee3CashNett = $vMatchFee3Cash - $vTaxPPH - $vMatchFee3CashAdm;
							$vFeeID .= " nett ";
						}
			//=============Income UpSponsor===================//
				
					//	$vMatchFee3CashAdm=$vMatchFee3Cash * $vProsenTax / 100;
					//	$vMatchFee3CashNett = $vMatchFee3Cash - $vMatchFee3CashAdm;



						 
						$vLastBal=$oMember->getMemField('fsaldovcr',$vUp3);  
						
					   echo $vMsg="<font color='#f00'>Insert Bonus Matching ke mutasi Cash gross (".number_format($vMatchFee3Cash,0,",",".")."), nett (".number_format($vMatchFee3CashNett,0,",",".").")  ke Wallet Cash </font><br>";	
					   $vMsgAll.=$vMsg;
						
					   $vNewBal=$vLastBal + $vMatchFee3CashNett;
					   $vsql="insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fref,fincometax) "; 
					   $vsql.="values ('$vUp3', '$vUser', '$vNowBns','Bonus Matching - $vUp3 from $vUser Level-3 $vFeeID' , $vMatchFee3CashNett,0 ,$vNewBal ,'matching' , '1','system' , '$vNow','',$vTaxPPH) "; 
					   $db->query($vsql); 
					  $oMember->updateBalConn($vUp3,$vNewBal,$db);					  

	
						echo $vMsg="Send to sponsor level 3 ($vUp3) ($vProsenMatchUp3%) (x 20%Automain) : ".number_format($vMatchFee3WProd,0,",",".")."<br>";
						$vMsgAll.=$vMsg;


						$vLastBal=$oMember->getMemField('fsaldowprod',$vUp3);  
						
					   echo $vMsg="<font color='#f00'>Insert Bonus Matching ke mutasi Wallet Product gross (".number_format($vMatchFee3WProd,0,",",".")."), nett (".number_format($vMatchFee3WProd,0,",",".").")  ke Wallet Product </font><br>";	
					   $vMsgAll.=$vMsg;
						
					   $vNewBal=$vLastBal + $vMatchFee3WProd;
					   $vsql="insert into tb_mutasi_wprod (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fref,fincometax) "; 
					   $vsql.="values ('$vUp3', '$vUser', '$vNowBns','Bonus Matching - $vUp3 from $vUser Level-3' , $vMatchFee3WProd,0 ,$vNewBal ,'matching' , '1','system' , '$vNow','',0) "; 
					   $db->query($vsql); 
					  $oMember->updateBalConnWProd($vUp3,$vNewBal,$db);					  
				   }
			   
			   } //end level 3
			   
			  
			if ($vBonusA <=0 ||  $vUp1 ==-1  || $vUp1 =='' || $vUp1 =='-' ) {
				   echo $vMsg="<font color='#f00'>Bonus: No Action Taken!</font><br>";
			   $vMsgAll.=$vMsg;
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
   $vFileName='../files/MatchingCompile'.date('Y-m-d_H.i.s').'.htm';
   $fp=fopen($vFileName,'w',true);
   fputs($fp,$vMsgAll,10000000);
   fclose($fp);

  
?>