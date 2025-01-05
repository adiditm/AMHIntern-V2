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
   
	  // $vsql="select * tb_updown where fidsys >=60 order by fsponsor, fidsys  ";
	   $vsql="select * from tb_updown order by fidsys  ";
	   $dbin->query($vsql);
	   $vCount=0;
	   

	//    $db->query('START TRANSACTION;');
	   while ($dbin->next_record()) {
	     $vCount+=1;
		 $vUser=$dbin->f('fdownline');
         $vSpon=$dbin->f('fsponsor');   

			echo $vSQL2="update m_anggota set fsernospon='$vSpon' where fidmember='$vUser' "; 
			$dbin1->query($vSQL2);
			echo "<br>";
             

       
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
   $vFileName='../files/PairingCompile'.date('Y-m-d_H.i.s').'.htm';
   $fp=fopen($vFileName,'w',true);
   fputs($fp,$vMsg,100000);
   fclose($fp);

  
?>