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

<html lang="en">

  <head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <!-- Meta, title, CSS, favicons, etc. -->

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" href="../images/favicon.ico" type="image/ico" />



    <title><?=$oRules->getSettingByField('fsitetitle')?> | <?=$vAddTitle?></title>



    <!-- Bootstrap -->

    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->

    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- NProgress -->

    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">

    <!-- iCheck -->

    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">

	

    <!-- bootstrap-progressbar -->

    <link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">

    <!-- JQVMap -->

    <link href="../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>

    <!-- bootstrap-daterangepicker -->

    <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
      <link href="../css/lobibox.css" rel="stylesheet">



    <!-- Custom Theme Style -->

    <link href="../build/css/custom.min.css" rel="stylesheet">

    

    

     <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">

      <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">

       <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

       <!-- <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/fonts/FontAwesome.otf" rel="stylesheet">

         <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/fonts/fontawesome-webfont.eot" rel="stylesheet">

          

           <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/fonts/fontawesome-webfont.ttf" rel="stylesheet">

            <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/fonts/fontawesome-webfont.woff" rel="stylesheet">

             <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/fonts/fontawesome-webfont.woff2" rel="stylesheet">-->
    

         <script src="../vendors/jquery/dist/jquery.min.js"></script>

    <script src="../js/md5.js"></script>
    <script src="../js/lobibox.js"></script>
<link rel="stylesheet" type="text/css" href="../vendor/select2/select2.min.css">
<script src="../vendor/select2/select2.min.js"></script>

   <!-- <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/fonts/fontawesome-webfont.svg" rel="stylesheet">-->
  
  <? if ($oDetect->isMobile()) { ?>
   <style type="text/css">
      .table-responsive{max-width:340px;}
   </style>
  
  <? } ?>
    
    
  </head>



  <body class="nav-md">

    <div class="container body">

      <div class="main_container">

        <div class="col-md-3 left_col">

          <div class="left_col scroll-view">

            <div class="navbar nav_title" style="border: 0;">
            <? if ($vPriv=='administrator') {?>
              <a href="../manager/indexadmin.php" class="site_title"><span><img src="../images/logoaminahnt.png" width="205" ></span> </a>
            <?} else {?>
              <a href="../manager/indexnonadmin.php" class="site_title"><span><img src="../images/logoaminahnt.png" width="205" ></span> </a>
            <? } ?>

            </div>



            <div class="clearfix"></div>



            <!-- menu profile quick info -->

            <div class="profile clearfix">

              <div class="profile_pic">

                <img src="../images/user_circle.png" alt="..." class="img-circle profile_img">

              

              </div>

              <div class="profile_info">

                <span>Welcome,</span>

                <h2><?=$oMember->getMemFieldAdm('fnama',$_SESSION['LoginUser'])?><? if($vMarkDev !='') echo "<br><b><font color='#ff0'>$vMarkDev</font></b>"?></h2>

              </div>

            </div>

            <!-- /menu profile quick info -->



            <br />

            <? include_once("../framework/admin_sidebar.blade.php");?>

			<? include_once("../framework/admin_footbutton.blade.php");?>

			</div>

        </div>

        

        <? include_once("../framework/admin_topnav.blade.php");?>

        
