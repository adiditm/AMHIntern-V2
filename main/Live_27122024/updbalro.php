<?
date_default_timezone_set('Asia/Jakarta');

$mtime = microtime(); 
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$starttime = $mtime; 
echo $vMsg.="<html><head><title>Update  Sponsorke </title></head><body>";


   include_once("../server/config.php");
     
   include_once("../classes/networkclass.php");
    $vMsg.="==================================================================================================";
      //$vLimit=$_GET['uLimit'];

   
 //  $vPairFeeSet = $vPairFeeSet / 100; 
   if (true) {   
   
	   $vsql="select * from m_anggota where faktif='1' and fidmember like '%$vMember%'  order by fidsys ";
	   $dbin->query($vsql);
	   $vCount=0;
	   $vUser=$dbin->f('fidmember');
	   

	//    $db->query('START TRANSACTION;');
	   while ($dbin->next_record()) {
	     $vCount+=1;
		 $vUser=$dbin->f('fidmember');
         $vRef=$dbin->f('fref');   
         //echo "<br>";
		 $vUser=$dbin->f('fidmember');
		 $vSQLin="select max(fidsys) as fmaxid from tb_mutasi_ro where  fidmember='$vUser'";
		//echo "<br>";
		 $db1->query($vSQLin);
		 $vCountIn=0;
		 while($db1->next_record()) {
			 $vID=$db1->f('fmaxid');
			 if ($vID=='') $vID=1000000009;
			 
			// echo $vID;
             $vActivator=$db1->f('fidmember');
			  
			 $vCountIn++;
			 $vSQL3="select * from tb_mutasi_ro where fidsys=$vID";
			//echo "<br>";
			 $dbtime->query($vSQL3);
			 $dbtime->next_record();
			 $vBal=$dbtime->f('fbalance');
			 if ($vBal !='') {
			echo $vSQL2="update m_anggota set fsaldoro='$vBal' where fidmember='$vUser' "; 
			$dbin1->query($vSQL2);
			echo "<br>";
			 }
             
	
         //  echo "$vUser : $vDesc : $vActivator";
       //  echo "<br>";               
		 } 
	
       
		}  //while
	//	$db->query('COMMIT;');	
		echo "<br>$vCount member updated  on ".$vNow."<BR>\n";
		$vMsg.="<br>$vCount member deleted  on ".$vNow."<BR>\n";

	} else echo "Bulan dan Tahun tidak boleh kosong!";   

   $mtime = microtime(); 
   $mtime = explode(" ",$mtime); 
   $mtime = $mtime[1] + $mtime[0]; 
   $endtime = $mtime; 
   $totaltime = ($endtime - $starttime); 
   echo "Total time  ".$totaltime." seconds"; 
   $vMsg.="Total time  ".$totaltime." seconds"; 
  echo  $vMsg.="</body></html>";
   
  // mail("a_didit_m@yahoo.com","Bonus Pairing Compilation $vNow",$vMsg);
   $vFileName='../files/UpdBal'.date('Y-m-d_H.i.s').'.htm';
  // $fp=fopen($vFileName,'w',true);
  // fputs($fp,$vMsg,100000);
  // fclose($fp);

  
?>