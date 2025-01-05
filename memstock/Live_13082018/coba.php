<?
   session_start();
ini_set('display_errors', true);
error_reporting(E_ERROR);
include_once("../server/config.php");


   include_once("../classes/memberclass.php");
   include_once(CLASS_DIR."dateclass.php");
   include_once("../classes/networkclass.php");
   include_once(CLASS_DIR."ifaceclass.php");
   include_once(CLASS_DIR."ruleconfigclass.php");
   include_once(CLASS_DIR."komisiclass.php");
   include_once(CLASS_DIR."jualclass.php");
   include_once(CLASS_DIR."systemclass.php");
   include_once(CLASS_DIR."productclass.php");
   include_once(CLASS_DIR."texttoimageclass.php");
    error_reporting (E_ALL ^ E_NOTICE);
   
//   echo $oNetwork->findSpilloverLR('UNEEDS4','L');

      echo $oNetwork->hasSponsorshipLR('UBC589689851');
   ?>
