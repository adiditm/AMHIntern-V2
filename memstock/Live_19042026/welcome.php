<?php
  session_start();
  include_once("../server/config.php");
  include_once("../classes/memberclass.php");
  include_once("../classes/texttoimagejustify.class.php");
  $vUser=$_SESSION['LoginUser'];
  // include_once("../classes/texttoimageclass.php");
  $vName = ucwords(strtolower($oMember->getMemField('fnama',$vUser)));
  $vCR1="";
  for ($i=0;$i<13;$i++) {
	  $vCR1 .="\n";
  }

  $vCR2="";
  for ($i=0;$i<14;$i++) {
	  $vCR2 .="\n";
  }
  
function txtUL($text) {
	  $e = explode(' ', $text);
	
	for($i=0;$i<count($e);$i++) {
	  $e[$i] = implode('&#x0332;', str_split($e[$i]));
	}
	
	$text = implode(' ', $e); 	
}



$vText="  $vName \n($vUser)";

if ($vUser=="")
   header("Location: ../index.php");
$_im = new TextToImage();

$vPath= getcwd();  
//imagettfJustifytext($text, $font="CENTURY.TTF", $Justify=2, $W=0, $H=0, $X=0, $Y=0, $fsize=12, $color=array(0x0,0x0,0x0), $bgcolor=array(0xFF,0xFF,0xFF))
//$_im->makeImageF($vText,"$vPath/parisienne-regular.ttf",500,540,55,0);
$_im->imagettfJustifytext($vCR1,$vCR2,$vText,$vUser,"$vPath/asotv.ttf",2,1361,978,0,0,28);
//$_im->makeImageF("","sssssss","$vPath/parisienne-regular.ttf",800,50,0,80);
//$_im->showAsPng(); 
$_im->saveAsPng($vUser."_certfinal","../images/user/");


 

  
?>