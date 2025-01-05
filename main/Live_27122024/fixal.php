<?
date_default_timezone_set('Asia/Jakarta');
$mtime = microtime(); 
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$starttime = $mtime; 
  
   include_once("../server/config.php");
   
   include_once(CLASS_DIR."memberclass.php");
   include_once(CLASS_DIR."dateclass.php");
   include_once(CLASS_DIR."networkclass.php");
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
   $vDate=$_GET['uDate'];
   if ($vDate=='')
       $vDate=date("Y-m-d");
   
   $vDate=$oMydate->dateSub($vDate,1,'day');
   $vNow=$vDateCompile." ".date("H:i:s"); 

  echo "==================================================================================================<br>";
   if (true) {   
   
	   $vsql="select fidmember,max(fidsys) as maxid from tb_mutasi where ftanggal < '$vDateCompile' group by fidmember";
	   $dbin->query($vsql);
	   $vCount=0;

	   while ($dbin->next_record()) {
	     $vCount+=1;
		 $vUser=$dbin->f('fidmember');
		 $vMaxid=$dbin->f('maxid');
		 echo $vUser." : Max: $vMaxid : ";
		 $vSQL="select  fbalance from tb_mutasi where fidsys=$vMaxid";
		 $db->query($vSQL);
		 while($db->next_record()) {
		    echo $vBal=$db->f('fbalance');
		 
		 }
		 
		  $vSQL="update  m_anggota set fsaldovcr = $vBal where fidmember='$vUser'";
		 $db->query($vSQL);
		// while($db->next_record()) {
		//    echo " : ".$db->f('fsaldovcr');
		 
	//	 }



		 $vSQL="select  fsaldovcr from m_anggota where fidmember='$vUser'";
		 $db->query($vSQL);
		 while($db->next_record()) {
		    echo "Saldo : ".$db->f('fsaldovcr');
		 
		 }
		 
		 
		 echo "<br>";
		 
	   
	   }



	   $vsql="select fidmember,max(fidsys) as maxid from tb_mutasi_wprod where ftanggal < '$vDateCompile' group by fidmember";
	   $dbin->query($vsql);
	   $vCount=0;

	   while ($dbin->next_record()) {
	     $vCount+=1;
		 $vUser=$dbin->f('fidmember');
		 $vMaxid=$dbin->f('maxid');
		 echo $vUser." : ";
		 $vSQL="select  fbalance from tb_mutasi_wprod where fidsys=$vMaxid";
		 $db->query($vSQL);
		 while($db->next_record()) {
		    echo $vBal=$db->f('fbalance');
		 
		 }
		 
		  $vSQL="update  m_anggota set fsaldowprod = $vBal where fidmember='$vUser'";
		 $db->query($vSQL);
		// while($db->next_record()) {
		//    echo " : ".$db->f('fsaldovcr');
		 
	//	 }



		 $vSQL="select  fsaldowprod from m_anggota where fidmember='$vUser'";
		 $db->query($vSQL);
		 while($db->next_record()) {
			  echo "<br> : Saldoprod ".$db->f('fsaldowprod');
		 
		 }
		 
		 
		 echo "<br>";
		 
	   
	   }	   
		 
	}    

   $mtime = microtime(); 
   $mtime = explode(" ",$mtime); 
   $mtime = $mtime[1] + $mtime[0]; 
   $endtime = $mtime; 
   $totaltime = ($endtime - $starttime); 
   echo "Total time  ".$totaltime." seconds"; 
  
?>