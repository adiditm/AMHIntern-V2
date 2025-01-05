<?php
$vUser=strtolower($_SESSION['LoginUser']);
$vKey=$this->rec;

   
   $vID=$newvals['fidmember'];
   $vAktif=$newvals['faktif'];
   

   $vSQL="update m_pebisnis set faktif='$vAktif' where fidmember='$vID'";
   
   $this->myquery($vSQL);

?>
