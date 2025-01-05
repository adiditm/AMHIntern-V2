<?php

error_reporting(E_ERROR);
include_once("../server/config.php");
$vContent = $_POST;
if (count($vContent)>0) {
    $vIP = $_SERVER['REMOTE_ADDR'];
	$vContent = json_encode($vContent,1);
    $vSQL = "insert into tb_paynotif(ftanggal,fipaddress,fcontent) ";
	$vSQL .= "values(now(),'$vIP','$vContent')" ;
	 	  
	if($db->query($vSQL))
	   echo "Notification sucessfully received! \n Data: ".$vContent;
	else   echo "Notification fail received!";
} else echo "No posted data!";

?>