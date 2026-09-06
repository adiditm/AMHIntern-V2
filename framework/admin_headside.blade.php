<?php if(session_status()!=PHP_SESSION_ACTIVE) session_start();

	error_reporting(E_ALL ^ E_NOTICE);

	date_default_timezone_set('Asia/Jakarta');

	ini_set('display_errors', true);

//	error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);

	include_once("../server/config.php");

	if( isset($_SERVER['HTTPS'] )) 

		$vProto="https://";

	else    

		$vProto="http://";

	$vReferLogin=$vProto.$_SERVER['HTTP_HOST']."/xsystem/main/login.php"; 

	$vRefer=$_SERVER['HTTP_REFERER'];


   $vScriptName= explode("/",$_SERVER['SCRIPT_FILENAME']);

   $vCount = count($vScriptName) -1;

    $vScriptName= $vScriptName[$vCount];	

	//if ($vRefer==$vReferLogin)

	//if ($vRefer!='')

	 //  $_SESSION['LoggedIn']='Yes';

	

//echo "sssssssss".CLASS_DIR."systemclass.php";



 include_once("../classes/memberclass.php");
   include_once(CLASS_DIR."dateclass.php");
   include_once("../classes/networkclass.php");
   include_once(CLASS_DIR."ifaceclass.php");
   include_once("../classes/ruleconfigclass.php");
   include_once(CLASS_DIR."komisiclass.php");
   include_once(CLASS_DIR."jualclass.php");
   include_once("../classes/systemclass.php");
   include_once(CLASS_DIR."productclass.php");
   include_once(CLASS_DIR."texttoimageclass.php");
   include_once("../classes/mobdetectclass.php");

   $oDetect= new Mobile_Detect;

   $vPriv=$_SESSION['Priv'];

   //$oSystem->syncKorwil();



   if ($_SESSION['LoginUser']=='') {  	
      header("Location: ../main/logout.php");
   } else {
	  
	  $vSQL = "select distinct fpriv from m_admin";
	  $db->query($vSQL);
	  $vArrPriv = array();
	  while($db->next_record()) {
		  $vArrPriv[] = $db->f('fpriv'); 
	  }
	  if (!in_array($vPriv,$vArrPriv))
	        header("Location: ../memstock/indexmem.php");
   }



   $vScriptName= explode("/",$_SERVER['SCRIPT_FILENAME']);

   $vCount = count($vScriptName) -1;

   $vScriptName= $vScriptName[$vCount];



   $vURL=$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING'];



//$_SESSION['LoginUser']='SMS964891346';

   $vUser =  $_SESSION['LoginUser'];

//   $vUser =  'SMS964891346';

   $vBaseUrl=$_SERVER['SERVER_NAME'];	  

   $vRefName=$_GET['ref'];



   if ($oMember->authID($vRefName)==1)



   $_SESSION['Ref']=$vRefName;  



  

   if ((!isset($_GET['ref'])) && (!isset($_GET['id'])) && $_SESSION['Ref']=="") 

      $_SESSION['Ref']=$oMember->getRandomMember();  

   

 $vCurrent=$_GET['current'];

  if($vCurrent == '') $vCurrent='mdm_dashboard';

  

  $vMenuChoosed = $_GET['menu'];

  if ($vMenuChoosed=='') $vMenuChoosed=$vCurrent;

  

  $vAddTitle=$oInterface->getMenuTitle($vMenuChoosed);  	  

?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../images/favicon.ico" type="image/ico" />
    <title><?=$oRules->getSettingByField('fsitetitle')?> | <?=$vAddTitle?></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap">

    <!-- Kept: other manager/ pages still use these Bootstrap/Gentelella widgets -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <link href="../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="../css/lobibox.css" rel="stylesheet">
    <link href="../build/css/custom.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../vendor/select2/select2.min.css">

    <!-- New design system — loaded last so it wins on shared class names.
         Cache-busted with the file's own mtime: without this, browsers
         (mobile ones especially) kept serving a stale cached copy across
         plain reloads even after a fresh upload, since the URL never
         changed. Every future upload gets a new mtime automatically, no
         manual versioning needed. -->
    <? $vDsCssPath = "../css/design-system.css"; ?>
    <link href="<?=$vDsCssPath?>?v=<?=@filemtime(dirname(__FILE__)."/".$vDsCssPath)?>" rel="stylesheet">

    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <script src="../js/md5.js"></script>
    <script src="../js/lobibox.js"></script>
    <script src="../vendor/select2/select2.min.js"></script>

    <? if ($oDetect->isMobile()) { ?>
    <style type="text/css">
      .table-responsive{max-width:340px;}
    </style>
    <? } ?>
  </head>

  <body class="amh-theme nav-md">
    <div class="amh-shell">
      <div class="amh-layout">

        <div class="amh-sidebar amh-glass-nav" id="amhSidebar">
          <div class="amh-sidebar-header">
            <? if ($vPriv=='administrator') {?>
              <a href="../manager/indexadmin.php"><img class="amh-sidebar-logo" src="../images/logoaminahnt.png" alt="Logo"></a>
            <?} else {?>
              <a href="../manager/indexnonadmin.php"><img class="amh-sidebar-logo" src="../images/logoaminahnt.png" alt="Logo"></a>
            <? } ?>
            <span class="amh-sidebar-brand">Aminah Internal Office</span>
          </div>

          <div class="amh-sidebar-profile">
            <span>Welcome,</span>
            <strong>
              <?
              $vNama = $oMember->getMemFieldAdm('fnama',$_SESSION['LoginUser']);
              if ($vNama == -1 ) $vNama = $oMember->getMemberName($_SESSION['LoginUser']);
              echo $vNama;
              ?>
              <? if($vMarkDev !='') echo " <font color='#ff0'>$vMarkDev</font>"; ?>
            </strong>
          </div>

          <div class="amh-sidebar-nav">
            <? include_once("../framework/admin_sidebar.blade.php");?>
          </div>
        </div>

        <div class="amh-sidebar-backdrop" id="amhSidebarBackdrop"></div>
        <div class="amh-sidebar-resizer" id="amhSidebarResizer" title="Geser untuk mengubah lebar sidebar"></div>

        <? include_once("../framework/admin_topnav.blade.php");?>
