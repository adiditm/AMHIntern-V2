
<? 
date_default_timezone_set('Asia/Jakarta');
$mtime = microtime(); 
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$starttime = $mtime; 

$vMsgAll.="<html><head><title>Compile Bonus Titik </title></head><body>";

include_once("../classes/networkclass.php");
include_once("../server/config.php");
include_once("../classes/ruleconfigclass.php");

?>


          <? 

		   $vStart=$_GET['uStart'];
		   $vStartSplit=split("_",$vStart);
		   $vStartA=$vStartSplit[0];
		   $vLimit=$vStartSplit[1];
   
			$vIdPromo = 'P-001';
			$vSQL="select * from m_promo where fidpromo='$vIdPromo'";
			$db->query($vSQL);
			$db->next_record();
			$vStart=$db->f('fstart');
			$vEnd=$db->f('fend');	
			$vPoinPromo = $db->f('fsyarat');
			$vDesc = $db->f('fdesc');
			
			$vStartLimit = 300000;
			$vBatasBaris = 0;
			
             $vNo=0;

			 $vsql="select * from m_anggota where 1    "; 

			 $vsql.=$vCrit;

			 


			  $vsql.=" order by fnama  limit $vStartA,$vLimit ";

			// $vsql.="limit $vStartLimit ,$vBatasBaris ";

		     $db->query($vsql);
			


			 $vTot=0;$vCount=0;
			    
			 while ($db->next_record()) {

			     
				 $vIdMember=$db->f('fidmember');
				 $vTanggal=$db->f('ftanggal');
				 $vName=$db->f('fnama');

 echo $vMsg="<br><font color='#000'>========================================Start Member:".$vIdMember." ($vName) ===================================</font><br>";
		 $vMsgAll .= $vMsg;
				   $vSQL="select *, date(ftglentry) as ftgl from tb_logchange where fkdanggota='$vIdMember' and ftipe='promo-demo' and fnew >= '1'";
				//  echo "<br>";
				  $dbin->query($vSQL);
				  $dbin->next_record();
				  $vTglUpgrade=$dbin->f('ftgl');
				  $vNewStat = $dbin->f('fnew');

				 
//Calculate Poin
 	
	    $vTotPoin=0;
        $vExe = $oNetwork->getSponsorshipCountPack($vIdMember,'S',$vStart,$vEnd);
		$vPointExe=1;
		$vTotPoin+=$vExe * $vPointExe;
	
		$vExc = $oNetwork->getSponsorshipCountPack($vIdMember,'G',$vStart,$vEnd);
		$vPointExc=3;
		$vTotPoin+=$vExc * $vPointExc;
		
		$vEli = $oNetwork->getSponsorshipCountPack($vIdMember,'P',$vStart,$vEnd);
		$vPointEli=7;
		$vTotPoin+=$vEli * $vPointEli;
		
		
			   $vSQL="select fstockist from m_anggota where fidmember='$vIdMember'";
			  //echo "<br>";
			  $dbin->query($vSQL);
			  $dbin->next_record();
			  $vTypeStockist=$dbin->f('fstockist');

		$vPointMobSto=0; 
		$vPointSto=0; 
		$vPointMast=0; 

		$vPointSpMobSto=0; 
		$vPointSpSto=0; 
		$vPointSpMast=0; 
		
		$vSpMobSto = $oNetwork->getSponsorshipCountStock($vIdMember,'1',$vStart,$vEnd);
		$vSpSto = $oNetwork->getSponsorshipCountStock($vIdMember,'2',$vStart,$vEnd);
		$vSpMastSto = $oNetwork->getSponsorshipCountStock($vIdMember,'3',$vStart,$vEnd);
		
		$vPointSpMobSto = $vSpMobSto * 4;
		$vPointSpSto = $vSpSto * 20;
		$vPointSpMast = $vSpMastSto * 100;
		
		
		if ($vTypeStockist=='1')
		   $vPointMobSto=20;
		if ($vTypeStockist=='2')
		   $vPointSto=80;
		if ($vTypeStockist=='3')
		   $vPointMast=200;
		   
		
		$vTotPoin+= $vPointMobSto + $vPointSto + $vPointMast + $vPointSpMobSto + $vPointSpSto + $vPointSpMast ;
	
				

				 if ($vTotPoin > 0) {
					 $vCount++;
					 $vSQL="select * from tb_promo where fidmember='$vIdMember' and fidpromo='$vIdPromo'";
					 $dbin->query($vSQL);
					 $dbin->next_record();
					 if ($dbin->num_rows() <=0) {
						 $vNo++;
						  $vSQL="INSERT INTO tb_promo(fidmember, fidpromo, fsyarat, fomzet, frewarddesc, fpaid, fbukti, ftglpaid, ftanggal, fpoinexec, fpoinexcl, fpoinelit, fpoinmobi, fpoinstoc, fpoinmast,fpoinspmobi, fpoinspstoc, fpoinspmast) ";
						  $vSQL .="values('$vIdMember','$vIdPromo',$vPoinPromo,$vTotPoin,'$vDesc','0','',null,now(),$vExe * $vPointExe,$vExc * $vPointExc,$vEli * $vPointEli,$vPointMobSto,$vPointSto,$vPointMast,$vPointSpMobSto,$vPointSpSto,$vPointSpMast)";
						  $dbin->query($vSQL);
						  //echo "<br>";
						  echo $vMsg="<br><font color='#00f'>No .Urut $vCount: New achievement member $vIdMember. Poin: $vTotPoin </font><br>";
						  $vMsgAll.=$vMsg;	
					 } else {
						 $vNo++;
						  $vSQL="update tb_promo set  fomzet=$vTotPoin,fpoinexec=$vExe * $vPointExe,fpoinexcl=$vExc * $vPointExc,fpoinelit=$vEli * $vPointEli,fpoinmobi=$vPointMobSto,fpoinstoc=$vPointSto,fpoinmast=$vPointMast,fpoinspmobi=$vPointSpMobSto,fpoinspstoc=$vPointSpSto,fpoinspmast=$vPointSpMast where  fidmember='$vIdMember' and fidpromo='$vIdPromo'";
						  $dbin->query($vSQL);
						  
						  echo $vMsg="<br><font color='#00f'>No .Urut $vCount: Update poin member $vIdMember. Poin: $vTotPoin </font><br>";
						  $vMsgAll.=$vMsg;	
						 
						 
					 }
					 
					// echo "<br>".$vSQL;
					// echo "<br>";
				
				 } else {
						 echo $vMsg="<br><font color='#f00'>No action taken!</font><br>";
						 $vMsgAll.=$vMsg;	
					 
				 }
				 
echo $vMsg="<br><font color='#000'>========================================End Member:".$vIdMember." ($vName) ===================================</font><br>";
		$vMsgAll.=$vMsg;				 
				 
			 }
			 
	echo "<br>$vNo members calculated!"		 ;
	
   $mtime = microtime(); 
   $mtime = explode(" ",$mtime); 
   $mtime = $mtime[1] + $mtime[0]; 
   $endtime = $mtime; 
   $totaltime = ($endtime - $starttime); 
   echo $vMsg="Total time  ".$totaltime." seconds"; 
   $vMsgAll.=$vMsg;
    $vMsgAll.="</body></html>";
   
  // mail("a_didit_m@yahoo.com","Bonus Pairing Compilation $vNow",$vMsg);
   $vFileName='../files/TourCalculation'.date('Y-m-d_H.i.s').'.htm';
   $fp=fopen($vFileName,'w',true);
   fputs($fp,$vMsgAll,10000000);
   fclose($fp);	