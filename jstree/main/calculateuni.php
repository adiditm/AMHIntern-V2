<?
date_default_timezone_set('Asia/Jakarta');
$mtime = microtime(); 
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$starttime = $mtime; 


echo $vMsgAll.="<html><head><title>Compile Bonus Unilevel  </title></head><body>";
$vMsg="";

echo $vMsgAll.="<h3>Compile  Bonus Unilevel    </h3>";
$vMsg="";
  
   include_once("../server/config.php");
   
   include_once ("../classes/memberclass.php");
   include_once(CLASS_DIR."dateclass.php");
   include_once("../classes/networkclass.php");
   include_once(CLASS_DIR."ifaceclass.php");
   include_once("../classes/ruleconfigclass.php");
   include_once("../classes/komisiclass.php");
   include_once(CLASS_DIR."jualclass.php");
   include_once(CLASS_DIR."productclass.php");
 //  echo "==================================================================================================";
 //  $vMsg.="==================================================================================================";
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
   $vByy=	 $oRules->getSettingByField('fbyyadmin');
   
  


   if (true) {   
   
	   $vsql="select * from m_anggota where ftglaktif not like '0000-00-00%' and fidmember like '%$vMember%'  order by fidsys  limit $vStartA,$vLimit";
	   $dbin->query($vsql);
	   $vCount=0;
	    $db->query('START TRANSACTION;');
	   while ($dbin->next_record()) {
	     $vCount+=1;
		 $vUser=$dbin->f('fidmember');
	
		 $vPaket=$dbin->f('fpaket');
		 $vLevelX=$dbin->f('flevel');
		 
		
	   
  

	     echo $vMsg="<br><font color='#00f'>========================================Start Member:".$vUser." ($vPaket) ($vLevelX)===================================</font>";
		 $vMsgAll .= $vMsg;
		 //KIRI
	     $vSQL="select sum(fsubtotal) as subtot, fidpenjualan,fidmember from tb_trxstok_member where fidmember  = '$vUser' and fprocessed='2'  group by fidpenjualan, fidmember ";
		 $db1->query($vSQL);
		 while($db1->next_record()) {
	 	 		$vIDJual = $db1->f('fidpenjualan');
				$vSubtot=$db1->f('subtot');
				$vSQL="select * from tb_kom_mtx where fdesc='$vIDJual'  and ffeestatus='1' ";
				$db->query($vSQL);
				$db->next_record();
				if ($db->num_rows() <=0) {
					
				echo $vMsg="<br><font color='#00f'>Insert fee titik dari RO $vIDJual !</font>";
						 $vMsgAll .= $vMsg;
					
							$vMsg=$oNetwork->sendFeeTitikCompress($vUser,20,$vSubtot,$vIDJual,$vDateCompile);
							$vMsgAll .= $vMsg;
				} else {
				echo $vMsg="<br><font color='#f0f'>Fee titik sudah pernah diproses, no action taken! </font>";
						 $vMsgAll .= $vMsg;
					
				}
		 }
		
	  
		 
		 



		
		echo $vMsg="<br><font color='#00f'>========================================End Member:".$vUser." ($vPaket) ($vLevelX)===================================</font><br>";
		$vMsgAll.=$vMsg;
	  
		
	
				
		
				
		}  //while
		$db->query('COMMIT;');	
		echo $vMsg="<br>$vCount member calculated on ".$vNow."<BR>\n";
		$vMsgAll.=$vMsg;
		

	} else { echo  $vMsg= "Bulan dan Tahun tidak boleh kosong!";   $vMsgAll.=$vMsg;}

   $mtime = microtime(); 
   $mtime = explode(" ",$mtime); 
   $mtime = $mtime[1] + $mtime[0]; 
   $endtime = $mtime; 
   $totaltime = ($endtime - $starttime); 
   echo $vMsg="Total time  ".$totaltime." seconds"; 
   $vMsgAll.=$vMsg;
    $vMsgAll.="</body></html>";
   
  // mail("a_didit_m@yahoo.com","Bonus Pairing Compilation $vNow",$vMsg);
   $vFileName='../files/TitikCompressCompile'.date('Y-m-d_H.i.s').'.htm';
   $fp=fopen($vFileName,'w',true);
   fputs($fp,$vMsgAll,10000000);
   fclose($fp);

  
?>