<?php
  session_start();
  include_once "../server/config.php";
  include_once CLASS_DIR."memberclass.php";
  include_once CLASS_DIR."systemclass.php";


  $vPostJen = $_POST['rbLoginType'];
  if ($vPostJen == 'J') { //Login Jamaah
  	  $vPostedUser=$_POST['tfUser'];
	  $vSuccessLogin=0;

	  if ($vPostedUser=="") {
		 $oSystem->jsAlert("Masukkan user login jamaah!");
		 $oSystem->jsLocation("./loginform.php");
	
	  }
	  
	   $vIDMember=$oMember->authID($vPostedUser);

	 if ($vIDMember=='1'){	
	     $vSuccessLogin=1; 
		  
		 
	   
		  if ($oMember->getMemField('faktif',$vPostedUser)=='4') {	
			 $oSystem->jsAlert("User blocked!");
			 $oSystem->jsLocation("logout.php");
			 exit;
		  }				
	
		  if ($oMember->isActive($vPostedUser)==0) {	
			 $oSystem->jsAlert("User tidak aktif / tidak ada!");	
			 $oSystem->jsLocation("logout.php");	
			 exit;
		  }
		 
		  if ($vSuccessLogin==1 ) {	
				 $_SESSION['LoggedIn']="Yes";
				 $_SESSION['LoginUser']=$vPostedUser;
				 $_SESSION['Priv']='administrator'; 
				 $_SESSION['Kind']='member'; 
		  }
		  
		  header("Location: ../manager/indexnonadmin.php");
		 exit;
		 // $oSystem->jsLocation("../manager/indexnonadmin.php"); 
		  
	}	else {
		$oSystem->jsAlert("Login salah / user tidak ada!");	
	 	$oSystem->jsLocation("logout.php");	
	}   	
  } else { 
   	
	  $vPostedUser=$_POST['tfUser'];
	  $vPostedPass=$_POST['tfPass'];
	  //$vGenSec=$_POST['hSec'];\
	
	  $vCapt=$_SESSION['securimage_code_value']['default'];
	  $vPostedSec=$vCapt;
	
	  $vSuccessLogin=0;
	  $vSuccessSec=0;
	   $vPriv=$oSystem->getPriv($vPostedUser);
	   if (trim($vPriv) == '' || $vPriv==-1) $vPriv='member';
	  $vUserAdmin=$oSystem->getUserAdmin();
	  $vIDMember=$oMember->authID($vPostedUser);
	  $vCount=count($vUserAdmin['fid']);
	  $vUserID='';
	  for ($i=0;$i<$vCount;$i++) {
	   $vUserID.=$vUserAdmin['fid'][$i].","; 
	  }
	
	 
	
	  if ($vPostedUser=="") {
		 $oSystem->jsAlert("Masukkan User!");
		 $oSystem->jsLocation("./loginform.php");
	
	  }
	
	
	
	 if ($vIDMember=='1'){
	
		  if ($oMember->getMemField('faktif',$vPostedUser)=='4') {
	
			 $oSystem->jsAlert("User blocked!");
	
			 $oSystem->jsLocation("logout.php");
	
		  }
	
	
	
	
	
		  if ($oMember->isActive($vPostedUser)==0) {
	
			 $oSystem->jsAlert("User tidak aktif / tidak ada!");
	
			 $oSystem->jsLocation("logout.php");
	
		  }
	
	
	
		
	
		
	
		  if ($vPostedPass=="") {
	
			 $oSystem->jsAlert("Password Kosong!");
	
			 $oSystem->jsLocation("/login.php");
	
		  }
	
		
	
		 // if ($vPostedSec=="") {
	
		  if (false) {
	
			 $oSystem->jsAlert("Security code Kosong!");
	
			 $oSystem->jsLocation("/login.php");
	
		  }
	
		
	
		  
	
		  if ($oMember->authPass($vPostedUser,$vPostedPass)==1)  
	
			 $vSuccessLogin=1;
	
		  else
	
			 $oSystem->jsAlert("User atau Password salah atau pebisnis tidak aktif!");
	
				 
	
		  //if ($vPostedSec==$vGenSec)
	
		  // if($vCapt==$_POST['ct_captcha'])
	
		  if(true)
	
			 $vSuccessSec=1;	    
	
		
	
		  else {
	
			 $oSystem->jsAlert("Security Code salah!");	 
	
			 $vSuccessSec=0;
	
		  }
	
			
	
		  if ($vSuccessLogin==1 && $vSuccessSec==1) {
	
	
			 $_SESSION['LoggedIn']="Yes";
	
			 $_SESSION['LoginUser']=$vPostedUser;
	
			 $_SESSION['Priv']=$vPriv;
	
					 
	  if ($oMember->getMemFieldAdm('faktif',$vPostedUser)=='4') {
	
			 $oSystem->jsAlert("User blocked!");
	
			 $oSystem->jsLocation("logout.php");
		exit;
		  }
	
	
	
	
	
		  if ($oMember->getMemFieldAdm('faktif',$vPostedUser)==0) {
	
			 $oSystem->jsAlert("User tidak aktif / tidak ada!");
	
			 $oSystem->jsLocation("logout.php");
			exit;
		  }
					 
	
			 if ($vPriv=='administrator')        
					$oSystem->jsLocation("../manager/indexadmin.php");
			else     $oSystem->jsLocation("../manager/indexnonadmin.php");    
		 //    $oSystem->jsLocation("../memstock/indexmem.php");
	
		  } else {
	
			 $vSuccessLogin=0;
	
			 $vSuccessSec=0;
	
			 $oSystem->jsLocation("./loginform.php");
	
		  }
	
	}  else if ($vIDMember==0){ // if posted user Admin
	
		
	
		  if ($vPostedPass=="") {
	
			 $oSystem->jsAlert("Password Kosong!");
	
			 $oSystem->jsLocation("./loginform.php");
			 exit;
	
		  }
	
		
	
		//  if ($vPostedSec=="") {
	
		  if (false) {
	
			 $oSystem->jsAlert("Security code Kosong!");
	
			 $oSystem->jsLocation("./loginform.php");
	
		  }
	
		
	
		  if ($oSystem->authAdmin($vPostedUser,$vPostedPass)==1)  
	
			 $vSuccessLogin=1;
	
		  else
	
			 $oSystem->jsAlert("User atau Password salah atau pebisnis tidak aktif!!");
	
				 
	
		   //if($vCapt==$_POST['ct_captcha'])
	
		   if(true)
	
			 $vSuccessSec=1;	    
	
		  else {
	
			 $oSystem->jsAlert("Security Code salah!");	 
	
			 $vSuccessSec=0;
	
		  }
	
			 // $vSuccessSec=1;
	
			  
	
		  if ($vSuccessLogin==1 && $vSuccessSec==1) {

	
			 $_SESSION['LoggedIn']="Yes";
	
			 $_SESSION['Priv']=$vPriv;
	
			 $_SESSION['LoginUser']=$vPostedUser;
	
			
		if ($vPriv=='administrator')	 {
				  if ($oMember->getMemFieldAdm('faktif',$vPostedUser)=='0') {
			
					 $oSystem->jsAlert("User not active!");
			
					 $oSystem->jsLocation("logout.php");
					exit;
				  }
				  
				   if ($oMember->getMemFieldAdm('faktif',$vPostedUser)=='4') {
			
					 $oSystem->jsAlert("User blocked!");
			
					 $oSystem->jsLocation("logout.php");
					exit;
				  }
		}else  if ($vPriv=='sponsor') {
 				  if ($oMember->getMemFieldBis('faktif',$vPostedUser)=='0') {
			
					 $oSystem->jsAlert("User not active!");
			
					 $oSystem->jsLocation("logout.php");
					exit;
				  }
				  
				   if ($oMember->getMemFieldBis('faktif',$vPostedUser)=='4') {
			
					 $oSystem->jsAlert("User blocked!");
			
					 $oSystem->jsLocation("logout.php");
					exit;
				  }			
		}
	
	
	
	
		  if ($oMember->getMemFieldAdm('faktif',$vPostedUser)==0) {
	
			 $oSystem->jsAlert("User tidak aktif / tidak ada!");
	
			 $oSystem->jsLocation("logout.php");
			exit;
		  }
			 
		   if ($vPriv=='administrator')        
					$oSystem->jsLocation("../manager/indexadmin.php");
			else     $oSystem->jsLocation("../manager/indexnonadmin.php");    		 
			 
	
		  } else {
	
			 $vSuccessLogin=0;
	
			 $vSuccessSec=0;
	
			 $oSystem->jsLocation("./loginform.php");
	
		  }
	
	   
	}
}

?>
