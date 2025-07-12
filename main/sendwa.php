<?php
date_default_timezone_set('Asia/Jakarta');
$mtime = microtime(); 
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$starttime = $mtime; 

$vMsgAll.="<html><head><title>Send Mail </title></head><body>";

  
   include_once("../server/config.php");
   
   include_once ("../classes/memberclass.php");
   include_once(CLASS_DIR."dateclass.php");
   include_once("../classes/networkclass.php");
   include_once(CLASS_DIR."ifaceclass.php");
   include_once("../classes/ruleconfigclass.php");
   include_once("../classes/komisiclass.php");
   include_once(CLASS_DIR."jualclass.php");
   include_once(CLASS_DIR."systemclass.php");
   include_once("../classes/espayclass.php");
   
   $oSystem->sendWAMessage("08973114383","Testing WA Message");


?>