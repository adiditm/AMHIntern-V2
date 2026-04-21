<?php
date_default_timezone_set('Asia/Jakarta');

$mtime = microtime(); 
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$starttime = $mtime; 
; 

$vMsgAll.="<html><head><title>Compile CFTrans Month</title></head><body>";

  
   include_once("../server/config.php");
   
   include_once ("../classes/memberclass.php");
   include_once(CLASS_DIR."dateclass.php");
   include_once("../classes/networkclass.php");
   include_once(CLASS_DIR."ifaceclass.php");
   include_once("../classes/ruleconfigclass.php");
   include_once("../classes/komisiclass.php");
   include_once(CLASS_DIR."jualclass.php");
   include_once(CLASS_DIR."productclass.php");
     include_once("../classes/espayclass.php");
   

$vOP=$_GET['op'];

   
$vAwal=$_REQUEST['dc'];
$vAkhir=$_REQUEST['uDate'];


$vMailFrom=$oRules->getSettingByField('fmailadmin');


if ($vAwal=="")
	$vAwal=$_GET['uAwal'];
if ($vAkhir=="")
	$vAkhir=$_GET['uAkhir'];


if ($vAwal=="")
   $vAwal=date('Y-m-d', strtotime('-30 days'));
   
if ($vAkhir=="")
   $vAkhir=$oPhpdate->getNowYMD("-");
   
if ($vOP != 'compile' || $vAkhir=='') {
   echo "Exit";
   exit;	
}   

$vPaket=$_POST['lmPaket'];
$vSort=$_POST['lmSort'];
$vBankFilter=$_POST['tfBank'];

$vDatePrev=$oMydate->dateSub($vAkhir,1,'day');
			


$vPage=$_GET['uPage'];
$vBatasBaris=25;
if ($vPage=="")
 	$vPage=0;
$vStartLimit=$vPage * $vBatasBaris;	
$vFilterText="";
$vCrit.=" and date(a.ftanggal) = '$vAkhir' " ;
$vFilterText.="[Date : $vAwal - $vAkhir]";


if ($vPaket !='') {
   $vCrit.=" and b.fpaket='$vPaket' ";
    $vFilterText.="[Paket: $vPaket]";

   }

if ($_SESSION['Priv']=='administrator')
   $vMem=$_POST['tfMem'];
else $vMem=$vUser;   
   
if ($vMem!='') {
   $vCrit.=" and a.fidmember='$vMem' ";   
    $vFilterText.="[Username: $vMem]";

   }

if ($vBankFilter !='')
   $vCrit.=" and  c.fkodebank='$vBankFilter'  ";

if ($vSort =='M')
   $vOrder.=" order by b.fnama ";
else  if ($vSort =='B') 
   $vOrder.=" order by a.fdebit  ";
else    $vOrder.=" order by a.ftanggal asc ";



			 $vsql="select a.*, b.*,c.fnamabank as cfnamabank,  date(a.ftanggal) as ftglcompile from tb_mutasi a left join m_anggota b on a.fidmember=b.fidmember left join m_bank c on b.fnamabank=c.fkodebank where a.fkind='resetmonth'"; 

			 $vsql.=$vCrit;			 
			 
			  $vsql.=$vOrder;


				$vRekMandiri = $oRules->getSettingByField('frekbank1');
				$vKotaMandiri = $oRules->getSettingByField('frekkota1');
				$vFeeTransOther = $oRules->getSettingByField('ffeetrans');
				$vFeeTransMdr = $oRules->getSettingByField('ffeetransmdr');
				$vMinTrans = $oRules->getSettingByField('fmintrans');

			  $db->query($vsql);
			  //$vCount=$db->num_rows();
				 $vTot=0;$vBonusTot=0; $vCount =0;
		        while ($db->next_record()) {
				   $vUserName=$db->f('fidmember');
				   $vBonus=$db->f('fdebit');
				   $vBonusOri=$vBonus;
				
				    
                   $vBank=$db->f('fnamabank');
                   $vBankName=$oMember->getBankName($vBank);
				 
                 $vRek=$db->f('fnorekening');
				 if($vBank == 'BK-ID-0002') {
				   $vKindTrans ='IBU';
				   $vFeeTrans = $vFeeTransMdr;
				 } else {  
				   $vKindTrans ='LBU'; 
				   $vFeeTrans = $vFeeTransOther ;
				 }					

 //Ambil CF kemarin
				   $vSQL="select fidsys,fcftrans,ftanggal from tb_cftransmo where fidmember='$vUserName' and  DATE_FORMAT(ftanggal, '%Y-%m') < DATE_FORMAT('$vAkhir','%Y-%m') and ftype='cfmonth' and ffeestatus='1'";
				   $dbin->query($vSQL);
				   $dbin->next_record();
				   $vCF=$dbin->f('fcftrans');
				    $vCFDate=$dbin->f('ftanggal');
					if (trim($vCFDate) =='') $vCFDate='1980-01-01';
				   $vIdSys=$dbin->f('fidsys');
				   if ($vCF=='') $vCF=0;
				   
				   if ($vCF >0)  {
					   $vBonus=$vBonus + $vCF;
					   echo "$vUserName::$vBonusX :: $vBonus :: $vCF<br>"; 	
				   }
				  
					$vSisa = $vBonus - $vFeeTrans;
					if ($vSisa >= $vMinTrans) {

//cek keberadaan total bonus
					    $vSQL="select * from tb_cftrans_smo where fidmember='$vUserName' and DATE_FORMAT(ftanggal,'%Y-%m') = DATE_FORMAT('$vAkhir','%Y-%m') and ftype='cfsmonth';";
					   $dbin->query($vSQL);
					   $dbin->next_record();
					   $vRows=$dbin->num_rows();
					   if ($dbin->num_rows() <=0) {					   
						     $vSQL="insert into tb_cftrans_smo(fidmember, ftglbefore,fcfbefore,fbonusnow,ftanggal, fcftrans, ftype) ";
						     $vSQL.="values('$vUserName', '$vCFDate',$vCF,$vBonusOri,'$vAkhir', $vSisa, 'cfsmonth') ";
						   //echo "<br>";
						   $db1->query($vSQL);	
						   
						   $vSQL="insert into tb_cftransmo(fidmember, ftglbefore,fcfbefore,fbonusnow,ftanggal, fcftrans, ftype, flastop, ffeestatus) ";
						    $vSQL .="values ('$vUserName','$vCFDate',$vCF,$vBonusOri,'$vAkhir',0,'cfmonth','trans','0');";	
							$db1->query($vSQL);						   
						   
						   	echo $vMsg="<font color='#00f'>$vRows:Insert transfer Mandiri ($vUserName: $vSisa), Insert CF = 0 </font><br>";
							$vMsgAll .= $vMsg;

						   echo $vMsg="Sending payment to Espay<br>";
						   $vMsgAll .=$vMsg;
						   
						   $vSourceBankCode=$oRules->getSettingByField('fspbankfrom');
						   $vSourceBankAcc=$oRules->getSettingByField('fsprekfrom');
						   
						   $vResult=$oEspay->transferFund($vSourceBankCode,$vSourceBankAcc,$vKodeBankReal,$vRek,$vNama,$vSisa,'Transfer Bonus Bulanan Onotoko',$vUserName.'-'.date("Y-m-d H:i:s"));
						   echo "Result: ".$vResult."<br>";
						   if (trim($vResult) !='') {
							    $vResArr=json_decode($vResult,true);
								if ($vResArr['error_message']=='Success') {
								    $vSQL="update tb_cftrans_smo set ffeestatus='2', fpaylog='$vResult' where fidmember='$vUserName' and date(ftanggal) = '$vAkhir'";
									$db1->query($vSQL);
									$db1->query("update tb_mutasi set fstatus='2' where fidmember='$vUserName' and fkind in('resetmonth') and date(ftanggal) = '$vAkhir' and fstatus='1' ");
								}
								      
						   }

						   
						   if ($vCF >0)  {
								    $vSQL="update tb_cftransmo set ffeestatus='0', flastop='transupd' where fidsys=$vIdSys";
								   $db1->query($vSQL);	
								//   echo "<br>";		
						   }
						//	echo "<br>";
					   } else {
						  	echo $vMsg="<font color='#f00'>$vRows:$vUserName, bonus $vBonusOri, already compiled, no action taken </font><br>";
							$vMsgAll .= $vMsg;

						  
					   }
						
					   $vBonusTot+=$vSisa;
					   $vCount++;
					} else {
					   $vSQL="select * from tb_cftransmo where fidmember='$vUserName' and DATE_FORMAT(ftanggal,'%Y-%m') =  DATE_FORMAT('$vAkhir','%Y-%m') and ftype='cfmonth';";
					  // echo "<br>:";
					   $dbin->query($vSQL);
					   $dbin->next_record();
					  // echo $dbin->num_rows();
					   if ($dbin->num_rows() <=0) {
						   $vSQL="insert into tb_cftransmo(fidmember, ftglbefore,fcfbefore,fbonusnow,ftanggal, fcftrans, ftype) ";
						    $vSQL .="values ('$vUserName','$vCFDate',$vCF,$vBonusOri,'$vAkhir',$vBonusOri+$vCF,'cfmonth');";	
							$db1->query($vSQL);
							
							echo $vMsg="<font color='#00f'>Insert  ke CF Trans Month bulan berikutnya ".($vBonusOri+$vCF).", ffeestatus=1  </font><br>";
							$vMsgAll .= $vMsg;
														
						if ($vCF >0)  {

							echo $vMsg="<font color='#00f'>CF Trans di-non-aktif-kan, dipindahkan ke bulan berikutnya di atas. </font><br>";
							$vMsgAll .= $vMsg;

								   $vSQL="update tb_cftransmo set ffeestatus='0',flastop='cfupd' where fidsys=$vIdSys";
								   $db1->query($vSQL);	
								 //  echo "<br>";		
						   }							
							
						  // echo "<br>";
					   }
					}
			 	}  


  $mtime = microtime(); 
   $mtime = explode(" ",$mtime); 
   $mtime = $mtime[1] + $mtime[0]; 
   $endtime = $mtime; 
   $totaltime = ($endtime - $starttime); 
   
   echo $vMsg="Total time  ".$totaltime." seconds"; 
   $vMsgAll .= $vMsg;
   echo $vMsg="</body></html>";
   $vMsgAll .= $vMsg;
   
   			 $oSystem->smtpmailer($oRules->getSettingByField('fmailbcc'),$vMailFrom,'Onotoko','Compile Transfer Bonus Bulanan','Transfer Bonus Bulanan Compiled!',$oRules->getSettingByField('fmailbcc'),"");
  // mail("a_didit_m@yahoo.com","Bonus Pairing Compilation $vNow",$vMsg);
   $vFileName='../files/CalcCFTransMonth'.date('Y-m-d_H.i.s').'.htm';
   $fp=fopen($vFileName,'w',true);
   fputs($fp,$vMsgAll,10000000);
   fclose($fp);
			 
		

?>