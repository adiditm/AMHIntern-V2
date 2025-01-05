<?php
    error_reporting (E_ALL ^ E_NOTICE);
    session_start();
    include_once("xsystem/config.php");

	if ($_SESSION['LoggedIn']=="Yes") {
      if ($_SESSION['Priv']=='administrator')
	  header("Location: xsystem/manager/indexadmin.php");
	  else
	  header("Location: xsystem/memstock/indexmem.php");

	}
    

   
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

   //$oSystem->jsAlert('');
   $vRefName=strtolower($_GET['nx']);
   //$oNetwork->generatePeriod();
  

    
      if ($oMember->authID($vRefName)==1 && !in_array($vRefName,array('nex1','nex2','nex3')))
	  $_SESSION['Ref']=$vRefName;  
   
   
   //$vDistRef=$_SESSION['Ref'];	  
  
  
?>
<!DOCTYPE html>
<html lang="en">

<head>
<script language="javascript">
   function gotoReg() {
	   if ('<?=trim($_SESSION['Ref'])?>' != '') {
		 // document.location.href='./xsystem/main/register.php';   
		  //window.open('./xsystem/main/register.php','_blank'); 
	   } else {
		  alert('Please get a referral from URL first!');   
		   
	   }
   }
</script>
<style type="text/css">
   .theblack { color:#000; }
   .btnx:hover {background-color:#2098af !important;}



</style>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Nexsukses | SHARE THE FUTURE</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

    <!-- Plugin CSS -->
    <link href="vendor/magnific-popup/magnific-popup.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="css/creative.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top">

    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top" style="color:#000">Referral NO : <? if ($_SESSION['Ref'] !='') echo $_SESSION['Ref']." (".$oMember->getMemberName($_SESSION['Ref']).")";?></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right" >
                    <li>
                        <a class="page-scroll " target="_blank" href="xsystem/main/loginform.php"  style="color:#000">Login</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="javascript:void()" onClick="gotoReg()" style="color:#000">Mendaftar</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#about" style="color:#000">Tentang Kami</a>
                    </li>
                    <li>
                        <!--<a class="page-scroll" href="#services">Services</a>
                    </li>-->
                    <li>
                        <a class="page-scroll" href="#portfolio" style="color:#000">Product Dan Peluang</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#contact" style="color:#000">Hubungi Kami</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <header>
        <div class="header-content">
            <div class="header-content-inner" style="color:#000">
                <h1 id="homeHeading">&nbsp;</h1>
                <h1><img src="img/NEX-LOGONEW.png" width="250" height="250"  alt=""/></h1>
                <h1>WELCOME TO NEX </h1>
                <h1>SHARE THE FUTURE </h1>
                <hr>
                <p style="color:#000">Raih Masa Depan Anda Bersama NEX Sekarang</p>
                <a  style="color:#FFF;background-color:#6acbde" href="#about" class="btnx btn btn-primary btn-xl page-scroll">Find Out More</a>
            </div>
        </div>
    </header>

    <section class="bg-primary" id="about" style="background-color:#6acbde">
        <div class="container" style="color:#FFF">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                  <h2 class="section-heading">Bersama NEX, Raih Masa Depan Gemilang!</h2>
                    <p class="text-faded"  style="color:#FFF">PT. Nex Sukses Global lahir dengan menciptakan peluang bisnis yang dapat dilakukan oleh siapapun, dimanapun, kapanpun di seluruh Dunia. Dengan konsep E-commerce, Dropship dan Networking memungkinkan siapapun dapat meraih sukses luar biasa.</p>
                    <a href="javascript:void()" onClick="gotoReg()" class="page-scroll btn btn-default btn-xl sr-button">Get Started!</a>
                </div>
            </div>
        </div>
    </section>

    <!--<section id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">NEX hadir untuk Anda</h2>
                    <hr class="primary">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-diamond text-primary sr-icons"></i>
                        <h3>Produk Berkualitas </h3>
                        <p class="text-muted">Our templates are updated regularly so they don't break.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-paper-plane text-primary sr-icons"></i>
                        <h3>Peluang Sukses</h3>
                        <p class="text-muted">You can use this theme as is, or you can make changes!</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-newspaper-o text-primary sr-icons"></i>
                        <h3>Sistem Dropshipping</h3>
                        <p class="text-muted">We update dependencies to keep things fresh.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-heart text-primary sr-icons"></i>
                        <h3>Team Professional</h3>
                        <p class="text-muted">You have to make your websites with love these days!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>-->

    <section class="no-padding" id="portfolio">
        <div class="container-fluid">
            <div class="row no-gutter popup-gallery">
                <div class="col-lg-4 col-sm-6">
                    <a href="img/portfolio/fullsize/1-1.jpg" class="portfolio-box" >
                        <img src="img/portfolio/thumbnails/1-1.jpg" class="img-responsive" alt="">
                        <div class="portfolio-box-caption" style="background: rgba(32, 152, 175, 0.9);">
                            <div class="portfolio-box-caption-content" >
                                <div class="project-category text-faded">
                                    Bersama NEX
                                </div>
                                <div class="project-name">Bahagiakan Keluarga Anda</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a href="img/portfolio/fullsize/3-3.jpg" class="portfolio-box">
                        <img src="img/portfolio/thumbnails/3-3.jpg" class="img-responsive" alt="">
                        <div class="portfolio-box-caption" style="background: rgba(32, 152, 175, 0.9);">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded"> Bersama NEX </div>
                                <div class="project-name">Sukses Di Tangan Anda</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a href="img/portfolio/fullsize/2-2.jpg" class="portfolio-box">
                        <img src="img/portfolio/thumbnails/2-2.jpg" class="img-responsive" alt="">
                        <div class="portfolio-box-caption" style="background: rgba(32, 152, 175, 0.9);">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded"> Bersama NEX </div>
                                <div class="project-name">Miliki Kulit Cantik dan Segar</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a href="img/portfolio/fullsize/4-4.jpg" class="portfolio-box">
                        <img src="img/portfolio/thumbnails/4-4.jpg" class="img-responsive" alt="">
                        <div class="portfolio-box-caption" style="background: rgba(32, 152, 175, 0.9);">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded"> Bersama NEX </div>
                                <div class="project-name">Kesehatan Adalah Segalanya</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a href="img/portfolio/fullsize/5-5.jpg" class="portfolio-box">
                        <img src="img/portfolio/thumbnails/5-5.jpg" class="img-responsive" alt="">
                        <div class="portfolio-box-caption" style="background: rgba(32, 152, 175, 0.9);">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded"> Bersama NEX </div>
                                <div class="project-name">Raih dan Bagikan Masa Depan</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a href="img/portfolio/fullsize/6-6.jpg" class="portfolio-box">
                        <img src="img/portfolio/thumbnails/6-6.jpg" class="img-responsive" alt="">
                        <div class="portfolio-box-caption" style="background: rgba(32, 152, 175, 0.9);">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded"> Bersama NEX </div>
                                <div class="project-name">Kunci Untuk Selalu Sehat Ada Disini</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <aside class="bg-dark">
        <div class="container text-center">
            <div class="call-to-action">
                <h2>Lihatlah Masa Depan Anda Di Sini !</h2>
                <!-- <a href="#" class="btn btn-default btn-xl sr-button">Download Product Catalog</a> -->
                &nbsp;<a  href="xsystem/download/NEX-MarketingPlan.pptx" class="btn btn-default btn-xl sr-button">Download Marketing Plan</a>
            </div>
        </div>
    </aside>

    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-6  text-center" style="margin-left:25%">
                    <h2 class="section-heading">Kami Siap Melayani Anda!</h2>
                    <hr class="primary">
                    <p>Siap sukses dan sehat bersama kami? Hubungi kami melalui nomor telepon atau email yang tertera disini,  kami  segera membantu Anda</p>
                
          <div class="col-lg-6  text-center">
                    <i class="fa fa-phone fa-3x sr-contact"></i>
                    <p>Telp : 021-83707344 </p>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="fa fa-envelope-o fa-3x sr-contact"></i>
                    <p><a href="mailto:CSNex@nexsukses.com" target="_blank">CSNex@nexsukses.com</a><a href="mailto:your-email@your-domain.com"></a></p>
                </div>
                </div>
     
                
                           <div class="col-lg-6  text-center" style="display:none">
                   <iframe  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.81964897715!2d106.82804031433305!3d-6.154903995543777!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMDknMTcuNiJTIDEwNsKwNDknNDguOCJF!5e0!3m2!1sen!2sid!4v1472286234885" width="600" height="450" frameborder="0" style="border:1px solid #CCC" allowfullscreen></iframe>
                   
                </div>
            </div>
        </div>
    </section>

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="vendor/scrollreveal/scrollreveal.min.js"></script>
    <script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

    <!-- Theme JavaScript -->
    <script src="js/creative.min.js"></script>

</body>

</html>
