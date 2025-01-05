<?php
    error_reporting (E_ALL ^ E_NOTICE);
    session_start();
    include_once("server/config.php");

	if ($_SESSION['LoggedIn']=="Yes") {
      if ($_SESSION['Priv']=='administrator')
	  	header("Location: manager/indexadmin.php");
	  else
	  	header("Location: memstock/indexmem.php");

	} else header("Location: main/loginform.php");
    

   
   $vScriptName= explode("/",$_SERVER['SCRIPT_FILENAME']);
   $vCount = count($vScriptName) -1;
    $vScriptName= $vScriptName[$vCount];

  
   $vURL=$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING'];
   //if ($_SERVER['SERVER_PORT']==80)
   //header("Location: https://$vURL");
   
   $vUser =  $_SESSION['LoginUser'];
  
	 
   $vBaseUrl=$_SERVER['SERVER_NAME'];	  



   include_once($CLASS_DIR."memberclass.php");
   include_once($CLASS_DIR."dateclass.php");
   include_once($CLASS_DIR."networkclass.php");
   include_once($CLASS_DIR."ifaceclass.php");
   include_once($CLASS_DIR."ruleconfigclass.php");
   include_once($CLASS_DIR."komisiclass.php");
   include_once($CLASS_DIR."jualclass.php");
   include_once($CLASS_DIR."systemclass.php");
   include_once($CLASS_DIR."productclass.php");
   include_once($CLASS_DIR."texttoimageclass.php");

   
  
?>