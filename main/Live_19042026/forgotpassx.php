<?php
       session_start();
        include_once("../server/config.php");
        require_once '../simage/securimage.php';
        require_once '../classes/systemclass.php';
 $vIdent = $_POST['tfIdent'];
 $vUserPost=$_POST['tfUser'];
 $vSess = $_POST['hSess'];
  $vSQL = "select * from m_anggota where fidmember='$vUserPost' and fsession='$vSess'";
 $db->query($vSQL);
 $db->next_record();
 $vRows=$db->num_rows();
 
 if ($_POST['hPost']=='1') {
  // print_r($_POST);   
//   print_r($_SESSION);
   if ($vRows <=0) {
      $oSystem->jsAlert('Reset Session expired!');
      $oSystem->jsLocation('../main/forgotpasswd.php');
      exit;
	   
   } else if ($_POST['tfPassConf'] != $_POST['tfNewPass']) {
      $oSystem->jsAlert('Password does not match!');
      $oSystem->jsLocation($_SERVER['HTTP_REFERER']);
      exit;
   } else {
	  
	  $vPassPost=$_POST['tfNewPass'];
	  $vPasswd=$oSystem->doED('encrypt',$vPassPost);
	  $vSQL="update m_anggota set fpassword='$vPasswd' where fidmember='$vUserPost';";
	  if ($db->query($vSQL))
	     $oSystem->jsAlert('Success, password was changed!');
		 $vSQL = "update  m_anggota set fsession='' where fidmember='$vUserPost' ";
		 $db->query($vSQL);
	     $oSystem->jsLocation('../main/loginform.php');

   }
   
 
 }
 
 ?>
