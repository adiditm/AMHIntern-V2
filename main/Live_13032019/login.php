<?php
  session_start();
  include_once "../server/config.php";
  include_once CLASS_DIR."memberclass.php";
  include_once CLASS_DIR."systemclass.php";
  

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
	 $oSystem->jsLocation("/login.php");
  }

 if ($vIDMember==1){
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
		 $oSystem->jsAlert("User atau Password salah!");
			 
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
                 
                 
                 
 	     $oSystem->jsLocation("../memstock/indexmem.php");
	  } else {
		 $vSuccessLogin=0;
		 $vSuccessSec=0;
		 $oSystem->jsLocation("/login.php");
	  }
}  else if ($vIDMember==0){ // if posted user Admin
    
	  if ($vPostedPass=="") {
		 $oSystem->jsAlert("Password Kosong!");
		 $oSystem->jsLocation("/login.php");
	  }
	
	//  if ($vPostedSec=="") {
	  if (false) {
		 $oSystem->jsAlert("Security code Kosong!");
		 $oSystem->jsLocation("/login.php");
	  }
	
	  if ($oSystem->authAdmin($vPostedUser,$vPostedPass)==1)  
		 $vSuccessLogin=1;
	  else
		 $oSystem->jsAlert("User atau Password salah!");
			 
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
		 $oSystem->jsLocation("../manager/indexadmin.php");
	  } else {
		 $vSuccessLogin=0;
		 $vSuccessSec=0;
		 $oSystem->jsLocation("/login.php");
	  }
   
 
}
?>