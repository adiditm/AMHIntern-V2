

<?
   
   error_reporting (E_ALL ^ E_NOTICE);
   session_start();
   include "checksession.php";   
   include_once("config.php");
   include_once("phplib.php");
   include_once("classes/memberclass.php");
   include_once("classes/dateclass.php");
   include_once("classes/networkclass.php");
   include_once("classes/ifaceclass.php");
   include_once("classes/systemclass.php");
   include_once(CLASS_DIR."texttoimageclass.php");
   
   $vBaseUrl=$_SERVER['SERVER_NAME'];	  
   $vuMenu=$_GET['menu'];
   $vRefUser=$_GET['uMemberId'];
   if (isset($vRefUser))
  	 $vUser=$vRefUser;
   else	 
  	 $vUser=$_SESSION['LoginUser'];

ini_set("display_errors",1);

if ($vUser=="")
   header("Location: index.php");
$_im = new TextToImage();
$vText="\n\n                                       Sertifikat Mitra Usaha\n                                          Invest2MF.com";
$vContent="";
$vContent.="\nNama                  : ".$oMember->getMemberName($vUser);
$vContent.="\nUser Name          : ".$vUser;
$vContent.="\nTanggal Aktivasi  : ".$oPhpdate->YMD2DMY($oMember->getActivationDate($vUser),"-");
$vContent.="\n\nAtas partisipasinya sebagai Mitra Usaha invest2mf.com";
$vContent.="\n\nSertifikat dan halaman member area ini adalah bukti kuat bagi Anda sebagai partisipan";
$vContent.="\ndalam program invest2mf.com yang berlaku hingga 15 bulan kedepan sejak tanggal tersebut";
$vContent.="\ndiatas.";
$vContent.="\n\nRoyal Mandiri menjamin pembayaran bagi hasil Anda hingga masa berlaku sertifikat ini berakhir. ";
$vContent.="\n\nTerima kasih atas kepercayaan Anda untuk tumbuh bersama kami. ";
$vContent.="\n\n".$oSystem->printChar(" ",100)."Jakarta, ".$oPhpdate->YMD2DMY($oMember->getActivationDate($vUser),'-');
$vContent.="\n".$oSystem->printChar(" ",110)."Management";
$vContent.="\n\n\n\n".$oSystem->printChar(" ",112)."Invest2MF";
$_im->makeImageF($vContent,$vText,"trebucbd.ttf",500,50,0,80);
//$_im->makeImageF($vText,"trebucbd.ttf",200,50,0,50);

//$_im->showAsJpg();
//header('Content-Type: image/png');
//$_im->showAsPng(); 

$_im->saveAsPng("certfinal","images/user/");
header('Location: loggedin.php?cont=cert');
//header('Location: certfinal.php');
//unlink("images/user/certfinal.png");


//$_im->showAsGif();



?>
