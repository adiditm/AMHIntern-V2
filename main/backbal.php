<?
date_default_timezone_set('Asia/Jakarta');
$mtime = microtime(); 
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$starttime = $mtime; 
echo $vMsgAll.="<html><head><title>Kembalikan Saldo </title></head><body>";
$vMsg="";
  

   include_once("../server/config.php");

   include_once("../classes/memberclass.php");
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
   
   $vDate=$oMydate->dateSub($vDate,1,'day');
   $vNow=$vDateCompile." ".date("H:i:s"); 
   $vNowBns=$vDate." 23:59:59";
   //$vLimit=$_GET['uLimit'];
   

   
   if (true) {   
   
	   $vsql="select * from m_anggota where ftglaktif not like '0000-00-00%' and fidmember in('UNIG04','AMAZING_YOUNIG','AMAZING_YOUNIG','YOUNIG18','YOUNIG8','YOUNIG3','UNIG04','YOUNIG18','YOUNIG8','YOUNIG3','YOUNIG8','YOUNIG18','UNIG04','AMAZING_YOUNIG')  order by fidsys  limit $vStartA,$vLimit";
	   $dbin->query($vsql);
	   $vCount=0;
	    $db->query('START TRANSACTION;');
	   while ($dbin->next_record()) {
	     $vCount+=1;
		  $vUser=$dbin->f('fidmember');
		 $vSaldoVCR=$oMember->getLastBalMut($vUser);
		 $vSaldoProd=$oMember->getLastBalMutProd($vUser);
		 $vSaldoKIT=$oMember->getLastBalMutKIT($vUser);
		 $vSaldoSupp=$oMember->getLastBalMutAcc($vUser);
		 
		 //echo "$vUser:$vSaldoVCR:$vSaldoProd:$vSaldoKIT:$vSaldoSupp<br>";
		 
		 echo $vSQL="update m_anggota set fsaldovcr=$vSaldoVCR,fsaldowprod=$vSaldoProd where fidmember='$vUser' ";
		 $db->query($vSQL);
		 echo "<br>";
		 

				
		
				
		}  //while
		$db->query('COMMIT;');	
		echo $vMsg="<br>$vCount member back balanced on ".$vNow."<BR>\n";
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
   $vFileName='../files/BackBalance'.date('Y-m-d_H.i.s').'.htm';
   $fp=fopen($vFileName,'w',true);
   fputs($fp,$vMsgAll,10000000);
   fclose($fp);

  
?>