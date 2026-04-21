<?
date_default_timezone_set('Asia/Jakarta');

$mtime = microtime(); 
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$starttime = $mtime; 
echo $vMsg.="<html><head><title>Update  Bonus Titik </title></head><body>";


   include_once("../server/config.php");
     
   include_once("../classes/networkclass.php");
    $vMsg.="==================================================================================================";
      //$vLimit=$_GET['uLimit'];

   
 //  $vPairFeeSet = $vPairFeeSet / 100; 
   if (true) {   
   
	   $vsql="select * from tb_kom_mtx  ";
	   $dbin->query($vsql);
	   $vCount=0;
	   

	    $db->query('START TRANSACTION;');
	   while ($dbin->next_record()) {
	     $vCount+=1;
		 $vIDSys=$dbin->f('fidsys');
		$vUser=$dbin->f('fidmember');
		//echo "::";
		$vRegis=$dbin->f('fidregistrar');
		//echo "<br>";
		 $vDistance=$oNetwork->getDistance($vRegis,$vUser);


				 
		 echo "===================Start Member $vUser============================<br>";
		echo "Updating descriptioon for $vUser : Bonus royalti [$vUser] level $vDistance <br>";
		$vSQLin="update tb_kom_mtx set fdesc='Bonus royalti [$vUser] level $vDistance' where fidsys=$vIDSys";     
		//echo "<br>";		
		 $db->query($vSQLin);
		 echo "===================End Member $vUser============================<br>";
		 
	
		}  //while
		$db->query('COMMIT;');	
		echo "<br>$vCount member deleted  on ".$vNow."<BR>\n";
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