<?
date_default_timezone_set('Asia/Jakarta');
$mtime = microtime(); 
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$starttime = $mtime; 





echo $vMsgAll.="<html><head><title>Fix Pebisnis Aktif Status </title></head><body>";
echo $vMsg = "<h4>Fixing Pebisnis</h4><br>";
      $vMsgAll .= $vMsg;

   include_once("../server/config.php");

   include_once("../classes/memberclass.php");
   include_once(CLASS_DIR."dateclass.php");
   include_once("../classes/networkclass.php");
   include_once(CLASS_DIR."ifaceclass.php");
   include_once("../classes/ruleconfigclass.php");
   include_once(CLASS_DIR."komisiclass.php");
   include_once(CLASS_DIR."jualclass.php");
   include_once("../classes/systemclass.php");
   include_once("../classes/productclass.php");
 
   echo $vMsg ="==================================================================================================<br>";
   $vMsgAll .= $vMsg; 
   $vMember=$_GET['uId'];
   $vStart=$_GET['uStart'];
   $vStartSplit=explode("_",$vStart);
   $vStartA=$vStartSplit[0];
   $vLimit=$vStartSplit[1];
   $vOP=$_GET['op'];	
   $vDateCompile=$_GET['uDate'];

   if ($vDateCompile=='')
       $vDateCompile=date("Y-m-d");
	   
	   
   
   $vDate=$oMydate->dateSub($vDateCompile,1,'day');
   $vNow=$vDateCompile." ".date("H:i:s"); 
   $vNowBns=$vDate." 23:59:59";

	
	
		$vMailFrom=$oRules->getSettingByField('fmailadmin');

   
   

   if ($vOP=='fix') {
   
       $vsql="update m_pebisnis set faktif='1' where faktif='';";
	   $dbin->query($vsql);


   $mtime = microtime(); 
   $mtime = explode(" ",$mtime); 
   $mtime = $mtime[1] + $mtime[0]; 
   $endtime = $mtime; 
   $totaltime = ($endtime - $starttime); 
   
   echo $vMsg="Total time  ".$totaltime." seconds"; 
   $vMsgAll .= $vMsg;
   echo $vMsg="</body></html>";
   $vMsgAll .= $vMsg;
   
  // mail("a_didit_m@yahoo.com","Bonus Pairing Compilation $vNow",$vMsg);
   $vFileName='../files/DelTemp'.date('Y-m-d_H.i.s').'.htm';
   if ($vCount >0){
	   $fp=fopen($vFileName,'w',true);
	   fputs($fp,$vMsgAll,10000000);
	   fclose($fp);
   }
}
  
?>
