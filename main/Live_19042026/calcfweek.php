<?php
date_default_timezone_set('Asia/Jakarta');
$mtime = microtime(); 
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$starttime = $mtime; 

$vMsgAll.="<html><head><title>Compile CFTrans </title></head><body>";

  
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
$vAkhir=$_REQUEST['uDate'];


if ($vAkhir=="")
	$vAkhir=$_GET['uAkhir'];


   
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
			

$vMailFrom=$oRules->getSettingByField('fmailadmin');
$vPage=$_GET['uPage'];
$vBatasBaris=25;
if ($vPage=="")
 	$vPage=0;
$vStartLimit=$vPage * $vBatasBaris;	
$vFilterText="";
$vCrit.=" and date(a.ftanggal) = '$vAkhir' " ;
$vFilterText.="[Date : $vAkhir]";


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


if ($vSort =='M')
   $vOrder.=" order by b.fnama ";
else  if ($vSort =='B') 
   $vOrder.=" order by a.fdebit  ";
else    $vOrder.=" order by a.ftanggal asc ";



			 $vsql="select a.*, b.*,c.fnamabank as cfnamabank,  date(a.ftanggal) as ftglcompile, c.fkdbankreal as fkdreal from tb_mutasi a left join m_anggota b on a.fidmember=b.fidmember left join m_bank c on b.fnamabank=c.fkodebank where a.fkind='resetweek'"; 

			 $vsql.=$vCrit;			 
			 
			  $vsql.=$vOrder;


				$vRekMandiri = $oRules->getSettingByField('frekbank1');
				$vKotaMandiri = $oRules->getSettingByField('frekkota1');
				$vFeeTransOther = $oRules->getSettingByField('ffeetrans');
				$vFeeTransMdr = $oRules->getSettingByField('ffeetransmdr');
				$vMinTrans = $oRules->getSettingByField('fmintrans');
				
				

			  $db->query($vsql);
		//	  echo $vCount=$db->num_rows();
				 $vTot=0;$vBonusTot=0; $vCount =0;
		        while ($db->next_record()) {
				   $vUserName=$db->f('fidmember');
				   $vBonus=$db->f('fdebit');
				   $vBonusOri=$vBonus;
				
				   $vNama=$oMember->getMemberName($vUserName); 
                   $vBank=$db->f('fnamabank');
                   $vBankName=$oMember->getBankName($vBank);
				   $vKodeBankReal = $db->f('fkdreal');
                 $vRek=$db->f('fnorekening');
				 if($vBank == 'BK-ID-0002') {
				   $vKindTrans ='IBU';
				   $vFeeTrans = $vFeeTransMdr;
				 } else {  
				   $vKindTrans ='LBU'; 
				   $vFeeTrans = $vFeeTransOther ;
				 }					

 //Ambil CF kemarin
				   $vSQL="select fidsys,fcftrans,ftanggal from tb_cftransweek where fidmember='$vUserName' and date(ftanggal) < date('$vAkhir') and ftype='cfweek' and ffeestatus='1'";
				   $dbin->query($vSQL);
				   $dbin->next_record();
				   $vCF=$dbin->f('fcftrans');
				    $vCFDate="'".$dbin->f('ftanggal')."'";
					if (strlen($vCFDate)<10)
					    $vCFDate = 'null';
				   $vIdSys=$dbin->f('fidsys');
				   if ($vCF=='') $vCF=0;
				   
				   if ($vCF >0)  {
					   $vBonus=$vBonus + $vCF;
					   echo "$vUserName::$vBonusX :: $vBonus :: $vCF<br>"; 	
				   }
				  
					$vSisa = $vBonus - $vFeeTrans;
					if ($vSisa >= $vMinTrans) {

//cek keberadaan total bonus
					   $vSQL="select * from tb_cftrans_sweek where fidmember='$vUserName' and date(ftanggal) =  date('$vAkhir') and ftype='cfsweek';";
					   $dbin->query($vSQL);
					   $dbin->next_record();
					   if ($dbin->num_rows() <=0) {					   
						     $vSQL="insert into tb_cftrans_sweek(fidmember, ftglbefore,fcfbefore,fbonusnow,ftanggal, fcftrans, ftype) ";
						     $vSQL.="values('$vUserName', $vCFDate,$vCF,$vBonusOri,'$vAkhir', $vSisa, 'cfsweek') ";
						   
						   echo $vMsg=$vSQL."<br>";
						   $vMsgAll .=$vMsg;
						   $db1->query($vSQL);	
						   
						   $vSQL="insert into tb_cftransweek(fidmember, ftglbefore,fcfbefore,fbonusnow,ftanggal, fcftrans, ftype, flastop, ffeestatus) ";
						    $vSQL .="values ('$vUserName',$vCFDate,$vCF,$vBonusOri,'$vAkhir',0,'cfweek','trans','0');";	
							$db1->query($vSQL);						   

						   echo $vMsg=$vSQL."<br>";
						   $vMsgAll .=$vMsg;

						   echo $vMsg="Sending payment to Espay<br>";
						   $vMsgAll .=$vMsg;
						   
						   $vSourceBankCode=$oRules->getSettingByField('fspbankfrom');
						   $vSourceBankAcc=$oRules->getSettingByField('fsprekfrom');
						   
						   $vResult=$oEspay->transferFund($vSourceBankCode,$vSourceBankAcc,$vKodeBankReal,$vRek,$vNama,$vSisa,'Transfer Bonus Mingguan Onotoko',$vUserName.'-'.date("Y-m-d"));
						 //  echo $vResult."<br>";
						   if (trim($vResult) !='') {
							    $vResArr=json_decode($vResult,true);
								if ($vResArr['error_message']=='Success') {
								    $vSQL="update tb_cftrans_sweek set ffeestatus='2', fpaylog='$vResult' where fidmember='$vUserName' and date(ftanggal) = '$vAkhir'";
									$db1->query($vSQL);
								}
								      
						   }
						   
						   if ($vCF >0)  {
								   echo $vSQL="update tb_cftransweek set ffeestatus='0', flastop='transupd' where fidsys=$vIdSys";
								   $db1->query($vSQL);	
								   echo "<br>";		
						   }
							echo "<br>";
					   }	else {
						    echo $vMsg="<font color='#f00'>$vUserName: already trasferred for $vAkhir, no action taken!</font> <br>";
						   $vMsgAll .=$vMsg;    
					   }
						
					   $vBonusTot+=$vSisa;
					   $vCount++;
					} else {
					   $vSQL="select * from tb_cftransweek where fidmember='$vUserName' and date(ftanggal) =  date('$vAkhir') and ftype='cfweek';";
					  // echo "<br>:";
					   $dbin->query($vSQL);
					   $dbin->next_record();
					  // echo $dbin->num_rows();
					   if ($dbin->num_rows() <=0) {
						   $vSQL="insert into tb_cftransweek(fidmember, ftglbefore,fcfbefore,fbonusnow,ftanggal, fcftrans, ftype) ";
						    $vSQL .="values ('$vUserName',$vCFDate,$vCF,$vBonusOri,'$vAkhir',$vBonusOri+$vCF,'cfweek');";	
							$db1->query($vSQL);
						   echo $vMsg=$vSQL."<br>";
						   $vMsgAll .=$vMsg;
							
						if ($vCF >0)  {
								   $vSQL="update tb_cftransweek set ffeestatus='0',flastop='cfupd' where fidsys=$vIdSys";
								   $db1->query($vSQL);	
								   
								   
						   echo $vMsg=$vSQL."<br>";
						   $vMsgAll .=$vMsg;
								   	
						   }							
							
						   echo $vMsg="<br>";
						   $vMsgAll .=$vMsg;

					   }
					}
			 	}  

     			 $oSystem->smtpmailer($oRules->getSettingByField('fmailbcc'),$vMailFrom,'Onotoko','Compile Transfer Bonus Mingguan','Transfer Bonus Mingguan Compiled!',$oRules->getSettingByField('fmailbcc'),"");
			 
 $mtime = microtime(); 
   $mtime = explode(" ",$mtime); 
   $mtime = $mtime[1] + $mtime[0]; 
   $endtime = $mtime; 
   $totaltime = ($endtime - $starttime); 
  // echo "Total time  ".$totaltime." seconds"; 
   echo $vMsg="Total time  ".$totaltime." seconds"; 
   $vMsgAll .= $vMsg;	
   echo $vMsg="</body></html>";
   $vMsgAll .= $vMsg;	
   
  // mail("a_didit_m@yahoo.com","Bonus Pairing Compilation $vNow",$vMsg);
   $vFileName='../files/CompileTransMingguan'.date('Y-m-d_H.i.s').'.htm';
   $fp=fopen($vFileName,'w',true);
   fputs($fp,$vMsgAll,10000000);
   fclose($fp);		

?>