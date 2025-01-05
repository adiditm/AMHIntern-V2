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





echo $vMsgAll.="<html><head><title>Compile &amp; Reset Bonus Bulanan </title></head><body>";
$vMsg="";
  

   include_once("../server/config.php");

   include_once("../classes/memberclass.php");
   include_once(CLASS_DIR."dateclass.php");
   include_once("../classes/networkclass.php");
   include_once(CLASS_DIR."ifaceclass.php");
   include_once(CLASS_DIR."ruleconfigclass.php");
   include_once(CLASS_DIR."komisiclass.php");
   include_once(CLASS_DIR."jualclass.php");
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
   $vDateCompileTime=$vDateCompile." ".date('H:i:s');


		

	$dateTimeStamp = strtotime($vDateCompile . " GMT");
	
	$vPrev=date('Y-m', strtotime(date('Y-m',$dateTimeStamp)." -1 month"));
	$vPrevMonthStart=$vPrev."-01";
	$vPrevMonthEnd= date("Y-m-t", strtotime($vPrevMonthStart));
	//echo $vPrevMonthEnd;
//exit;
	

	$vLastMonthStart=$vPrevMonthStart;
	$vLastMonthEnd=$vPrevMonthEnd;
	
//	echo "$vLastMonthStart : $vLastMonthEnd";
//	exit ;

		$vMailFrom=$oRules->getSettingByField('fmailadmin');

		$vUserPassGO=$oRules->getSettingByField('fuserpassgosms');
		$vUserPassGO = explode("/",$vUserPassGO);
		$vUserGO = $vUserPassGO[0];
		$vPassGO = $vUserPassGO[1];
   
   
 //  $vPairFeeSet = $vPairFeeSet / 100; 
   if (true) {   
   
	   $vsql="select * from m_anggota where ftglaktif not like '0000-00-00%' and fidmember like '%$vMember%'   order by fidsys  limit $vStartA,$vLimit";
	   $dbin->query($vsql);
	   $vCount=0;
	    $db->query('START TRANSACTION;');
	   while ($dbin->next_record()) {
	     $vCount+=1;
		 $vUser=$dbin->f('fidmember');
		 $vHP=$dbin->f('fnohp');
		 $vEmail=$dbin->f('femail');
		 
		 
		 
		 

		
		echo $vMsg="============================ Start Member <b style='color:#00f'>$vUser</b> ($vPaketText) ================================= <br>";
		$vMsgAll .= $vMsg;

		

		     //$vSQLin="select sum(fcredit) as fsum from tb_mutasi where fkind in('titik','uni','profit','reorder','reorderms') and fidmember='$vUser' and date(ftanggal) between date('$vLastMonthStart') and date('$vLastMonthEnd') or (fidmember='$vUser' and date(ftanggal)=date(now()) and fkind in('titik','uni')) ";
 $vSQLin="select sum(fcredit) as fsum from tb_mutasi where fkind in('unile') and fidmember='$vUser' and date(ftanggal) between date('$vLastMonthStart') and date('$vLastMonthEnd')   ";		    
			
			$db->query($vSQLin);
		    $db->next_record();
	    	echo $vMsg="<font color='#0f0'>Hitung bonus bulanan ('unile') :" ;
			$vMsgAll .= $vMsg;
			
		    $vBonus=$db->f('fsum');
		    if ($vBonus=='') $vBonus =0;
		   
		    
		    //$vFunder=$db->f('fidregistrar');
		    echo $vMsg=number_format($vBonus,0,",","."); 
			$vMsgAll .= $vMsg;
		    echo $vMsg="</font><br>";
			$vMsgAll .= $vMsg;



		    //Masukkan bonus
		    if ($vBonus > 0) {
				


				$vLastBal=$oMember->getMemField('fsaldovcr',$vUser);
				$vNewBal=$vLastBal - $vBonus ;
				
				echo $vMsg="<font color='#00f'>Deduct bonus bulanan :  $vBonus dari Ewallet, new balance: $vNewBal </font><br>";
				$vMsgAll .= $vMsg;
				
				$vUserL=$_SESSION['LoginUser'];
				 $vsql="insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fincometax) "; 
				 $vsql.="values ('$vUser', 'Multiple', '$vDateCompileTime','Withdraw / Reset bonus bulanan (Unilevel $vLastMonthStart - $vLastMonthEnd)' , 0 ,$vBonus ,$vNewBal ,'resetmonth' , '1','System' ,'$vDateCompileTime',0) "; 
				
				$vSQLCheck="select * from tb_mutasi where fkind='resetmonth' and date(ftanggal)='$vDateCompile' and fidmember='$vUser' ";
				$db1->query($vSQLCheck);
				$db1->next_record();
				if ($db1->num_rows() <=0 && $vNewBal >=0) {					
					$db->query($vsql); 
					$oMember->updateBalConnMo($vUser,$vNewBal,$db);
					
				} else {
				echo $vMsg="<font color='#f00'><b>Monthly bonus already deducted in this date or less than zero, no action taken! </b></font><br>";
				$vMsgAll .= $vMsg;					
				}

				//SMS
				 $vIsiSMS = $oRules->getSettingByField('fsmsbonusb');
				 $vIsiSMS=str_replace("{BONUSB}",number_format($vBonus,0,",","."),$vIsiSMS);
				 if ($vHP !='')
				     $oSystem->sendSMS($vHP, $vIsiSMS,$vUserGO,$vPassGO);
					 
				$vSubject="Pemberitahuan Transfer Bonus Plan B";
				 if ($vEmail !='')
				     $oSystem->smtpmailer($vEmail,$vMailFrom,'Onotoko',$vSubject,$vIsiSMS,"japri_s@yahoo.com","");

			} else {
				
				echo $vMsg="<font color='#f00'><b>No action taken! </b></font><br>";
				$vMsgAll .= $vMsg;					
				
			}



		
		
		echo "============================ End Member <b>$vUser</b> ($vPaketText) ================================= <br>";
	  
		
	
				
		
				
		}  //while
		$db->query('COMMIT;');	
		
		echo $vMsg="<br>$vCount member calculated on ".$vNow."<BR>\n";
		$vMsgAll .= $vMsg;	
		

	} else {
		 echo $vMsg="Bulan dan Tahun tidak boleh kosong!";   
		 $vMsgAll .= $vMsg;	
	}

   $mtime = microtime(); 
   $mtime = explode(" ",$mtime); 
   $mtime = $mtime[1] + $mtime[0]; 
   $endtime = $mtime; 
   $totaltime = ($endtime - $starttime); 
   echo "Total time  ".$totaltime." seconds"; 
   echo $vMsg="Total time  ".$totaltime." seconds"; 
   $vMsgAll .= $vMsg;	
   echo $vMsg="</body></html>";
   $vMsgAll .= $vMsg;	
   
  // mail("a_didit_m@yahoo.com","Bonus Pairing Compilation $vNow",$vMsg);
   $vFileName='../files/ResetBonusMonth'.date('Y-m-d_H.i.s').'.htm';
   $fp=fopen($vFileName,'w',true);
   fputs($fp,$vMsgAll,10000000);
   fclose($fp);

  
?>