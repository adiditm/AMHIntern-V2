<?
session_start();
ini_set('display_errors', true);
error_reporting(E_ERROR);
include_once("../server/config.php");
$vUser=$_SESSION['LoginUser'];
//print_r($_POST);

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
 
 
	function getStartAndEndDate($week, $year) {
	  $dto = new DateTime();
	  $dto->setISODate($year, $week);
	  $ret['week_start'] = $dto->format('Y-m-d');
	  $dto->modify('+6 days');
	  $ret['week_end'] = $dto->format('Y-m-d');
	  return $ret;
	}	
   
   $vGetWil=$_GET['wil'];
   $vWilID=$_GET['kodewil'];
   $vCountry=$_GET['neg'];
   $vOp=$_GET['op'];
   $vKitMem=$_POST['serno'];
   $vKitSpon=$_POST['sernospon'];
   $vKitPres=$_POST['sernopres'];
   $vKitUp=$_POST['sernoup'];
   $vBuyer=$_GET['buyer'];
   $vPosition=$_POST['position'];
   $vMaker=$_GET['maker'];
   
 

   if ($vOp=='wil') { //Wilayah
	   if ($vGetWil=='prop') {
	      $vSQL="select * from m_wilayah where fkodeneg='$vWilID' and fkabkota='00' and fkec='00' and fdeskel='00' order by fnamawil ";
	      $db->query($vSQL);
	      echo '<option value="">--Pilih / Choose-</option> <option  value="PX"  >Other Province</option>';
	      while ($db->next_record()) {
	          $vKodeProp=$db->f('fprop');
	          $vWil=$db->f('fnamawil');
	          echo '<option value="'.$vKodeProp.'">'.$vWil.'</option>';
	      }
	   }   
	  
	  
	   if ($vGetWil=='kota') {
	      $vSQL="select * from m_wilayah where fkodeneg='$vCountry' and fprop='$vWilID' and fkabkota <> '00' and fkec='00' and fdeskel='00' order by fnamawil ";
	      $db->query($vSQL);
	      echo '<option value="">--Pilih / Choose-</option> <option  value="KX"  >Other City</option>';
	      while ($db->next_record()) {
	          $vKodeKota=$db->f('fkabkota');
	          $vWil=$db->f('fnamawil');
	          echo '<option value="'.$vKodeKota.'">'.$vWil.'</option>';
	      }
	   } 
  } else if ($vOp=='kit' && $_GET['st'] =='') {
	//echo $vKitMem;
	if ($_SESSION['Priv']!='administrator') {

		 $vSQL="select fserno from tb_skit where fserno='$vKitMem'  ";
		$db->query($vSQL);
		$db->next_record();
		$vCheckSer1 = $db->f('fserno');

		 $vSQL="select fserno from tb_skit where fserno='$vKitMem' and fstatus='4'  ";
		$db->query($vSQL);
		$db->next_record();
		$vCheckSer3 = $db->f('fserno');

		 $vSQL="select fserno from tb_skit where fserno='$vKitMem' and fstatus='3'  ";
		$db->query($vSQL);
		$db->next_record();
		$vCheckSer2 = $db->f('fserno');
		
		$vSQL="select fidmember,fnama,fsponphone,femailspon from m_anggota where fserno='$vKitMem' ";
		$db->query($vSQL);
		$db->next_record();
		$vCheckMem = $db->f('fidmember');

		$vSQL="select fidmember from tb_kit_active where fidmember='$vKitMem' ";
		$db->query($vSQL);
		$db->next_record();
		$vCheckActive = $db->f('fidmember');
        $vPack=$oJual->getKitPack($vKitMem);   
		$vPackName=$oProduct->getPackName($vPack['id']);
	 //   if (trim($vCheckMem) !='')
	//       echo 'used';
	//    else echo 'notfound';   
		
		if ($vCheckSer1 == '')
		   echo 'xnotfound';
		else if ($vCheckSer3 != '')
		   echo 'xused1';   

		else if ($vCheckSer2 == '')
		   echo 'xnotactive1';   
		else if (trim($vCheckMem) !='')
		   echo 'xused2';
		/*else if (trim($vCheckActive) =='')
		   echo 'xnotactive2';    */
		else echo 'xyes;'.$vPack['name'].";".$vPack['id'];
		
	} else {//Admin
		 $vSQL="select fserno from tb_skit where fserno='$vKitMem'  ";
		$db->query($vSQL);
		$db->next_record();
		$vCheckSer1 = $db->f('fserno');

		 $vSQL="select fserno from tb_skit where fserno='$vKitMem' and fstatus='4'  ";
		$db->query($vSQL);
		$db->next_record();
		$vCheckSer3 = $db->f('fserno');

		 $vSQL="select fserno from tb_skit where fserno='$vKitMem' and fstatus='3'  ";
		$db->query($vSQL);
		$db->next_record();
		$vCheckSer2 = $db->f('fserno');
		
		$vSQL="select fidmember,fnama,fsponphone,femailspon from m_anggota where fserno='$vKitMem' ";
		$db->query($vSQL);
		$db->next_record();
		$vCheckMem = $db->f('fidmember');

		$vSQL="select fidmember from tb_kit_active where fidmember='$vKitMem' ";
		$db->query($vSQL);
		$db->next_record();
		$vCheckActive = $db->f('fidmember');
        $vPack=$oJual->getKitPack($vKitMem);   
		//$vPackName=$oProduct->getPackName($vPack['id']);
		
	 //   if (trim($vCheckMem) !='')
	//       echo 'used';
	//    else echo 'notfound';   
		
		if ($vCheckSer1 == '')
		   echo 'xnotfound';
		else if ($vCheckSer3 != '')
		   echo 'xused1';   

		else if ($vCheckSer2 == '')
		   echo 'xnotactive1';   
		else if (trim($vCheckMem) !='')
		   echo 'xused2';
		else if (trim($vCheckActive) =='')
		   echo 'xnotactive2';    
		else echo 'xyes;'.$vPack['name'].";".$vPack['id'];
	
	}
//
  }  
 else if ($vOp=='kit' && $_GET['st'] !='') {
	//echo $vKitMem;
		$vStockist=$_GET['st'];
		 $vSQL="select fserno from tb_skit where fserno='$vKitMem'  ";
		$db->query($vSQL);
		$db->next_record();
		$vCheckSer1 = $db->f('fserno');

		 $vSQL="select fserno from tb_skit where fserno='$vKitMem' and fstatus='4'  ";
		$db->query($vSQL);
		$db->next_record();
		$vCheckSer3 = $db->f('fserno');

		$vSQL="select fserno from tb_skit where fserno='$vKitMem' and fstatus='3' and fpendistribusi='$vStockist' ";
		$db->query($vSQL);
		$db->next_record();
		$vCheckSer2 = $db->f('fserno');
		
		$vSQL="select fidmember,fnama,fsponphone,femailspon from m_anggota where fserno='$vKitMem' ";
		$db->query($vSQL);
		$db->next_record();
		$vCheckMem = $db->f('fidmember');

		$vSQL="select fidmember from tb_kit_active where fidmember='$vKitMem' ";
		$db->query($vSQL);
		$db->next_record();
		$vCheckActive = $db->f('fidmember');
        $vPack=$oJual->getKitPack($vKitMem);   
	//	$vPackName=$oProduct->getPackName($vPack['id']);
	 //   if (trim($vCheckMem) !='')
	//       echo 'used';
	//    else echo 'notfound';   
		
		if ($vCheckSer1 == '')
		   echo 'xnotfound';
		else if ($vCheckSer3 != '')
		   echo 'xused1';   

		else if ($vCheckSer2 == '')
		   echo 'xnotactive1';   
		else if (trim($vCheckMem) !='')
		   echo 'xused2';
		else if (trim($vCheckActive) =='')
		   echo 'xnotactive2';    
		else echo 'xyes;'.$vPack['name'].";".$vPack['id'];
		
	
  }  else if ($vOp=='kitstockist') {
	//echo $vKitMem;
	$vSerno=$_POST['serno'];
   if ($oMember->authActiveID($vSerno)==1) {
    	$vSponPhone=$oMember->getMemField('fnohp',$vSerno);
	    $vSponMail=$oMember->getMemField('femail',$vSerno);	
	    $vStockist=$oMember->getMemField('fstockist',$vSerno);	
	    $vSponAlamat=$oMember->getMemField('falamat',$vSerno);	
	    $vSponAlamat.= " ".$oMember->getWilName('ID',$oMember->getMemField('fpropinsi',$vSerno),$oMember->getMemField('fkota',$vSerno),'00','00');	
	    $vSponAlamat.= " ".$oMember->getWilName('ID',$oMember->getMemField('fpropinsi',$vSerno),'00','00','00');	
	    $vSponAlamat.= " ".$oMember->getCountryName($oMember->getMemField('fcountry',$vSerno));	
	    
        echo 'yesx|'.$oMember->getMemberName($vSerno)."|$vSponPhone|$vSponMail|$vSponAlamat|$vStockist";
    } else {
       echo 'nox|';   
    
    }
		
	
  } else if ($vOp=='kitspon') {
    
    if ($oMember->authActiveID($vKitSpon)==1) {
    	$vSponPhone=$oMember->getMemField('fnohp',$vKitSpon);
	    $vSponMail=$oMember->getMemField('femail',$vKitSpon);	
	    $vStockist=$oMember->getMemField('fstockist',$vKitSpon);	
	    $vSponAlamat=$oMember->getMemField('falamat',$vKitSpon);	
	    $vSponAlamat.= " ".$oMember->getWilName('ID',$oMember->getMemField('fpropinsi',$vKitSpon),$oMember->getMemField('fkota',$vKitSpon),'00','00');	
	    $vSponAlamat.= " ".$oMember->getWilName('ID',$oMember->getMemField('fpropinsi',$vKitSpon),'00','00','00');	
	    $vSponAlamat.= " ".$oMember->getCountryName($oMember->getMemField('fcountry',$vKitSpon));	
	    
        echo 'yesx|'.$oMember->getMemberName($vKitSpon)."|$vSponPhone|$vSponMail|$vSponAlamat|$vStockist";
    } else {
       echo 'nox|';   
    
    }
  }  else if ($vOp=='kitpres') {
    
    if ($oMember->authActiveID($vKitPres)==1) {
    	$vSponPhone=$oMember->getMemField('fnohp',$vKitPres);
	    $vSponMail=$oMember->getMemField('femail',$vKitPres);	
	    $vStockist=$oMember->getMemField('fstockist',$vKitPres);	
	    $vSponAlamat=$oMember->getMemField('falamat',$vKitPres);	
	    $vSponAlamat.= " ".$oMember->getWilName('ID',$oMember->getMemField('fpropinsi',$vKitPres),$oMember->getMemField('fkota',$vKitPres),'00','00');	
	    $vSponAlamat.= " ".$oMember->getWilName('ID',$oMember->getMemField('fpropinsi',$vKitPres),'00','00','00');	
	    $vSponAlamat.= " ".$oMember->getCountryName($oMember->getMemField('fcountry',$vKitPres));	
	    
        echo 'yesx|'.$oMember->getMemberName($vKitPres)."|$vSponPhone|$vSponMail|$vSponAlamat|$vStockist";
    } else {
       echo 'nox|';   
    
    }
  } else if ($vOp=='kitsponms') {
    
    if ($oMember->authActiveID($vKitSpon)==1) {
    	$vSponPhone=$oMember->getMemField('fnohp',$vKitSpon);
	    $vSponMail=$oMember->getMemField('femail',$vKitSpon);	
	    $vStockist=$oMember->getMemField('fstockist',$vKitSpon);	
	    $vSponAlamat=$oMember->getMemField('falamat',$vKitSpon);	
	    $vSponAlamat.= " ".$oMember->getWilName('ID',$oMember->getMemField('fpropinsi',$vKitSpon),$oMember->getMemField('fkota',$vKitSpon),'00','00');	
	    $vSponAlamat.= " ".$oMember->getWilName('ID',$oMember->getMemField('fpropinsi',$vKitSpon),'00','00','00');	
	    $vSponAlamat.= " ".$oMember->getCountryName($oMember->getMemField('fcountry',$vKitSpon));	
	    $vPaket=$oMember->getPaket($vKitSpon);
	    $vRO=$oJual->getSetRO($vKitSpon);
        echo 'yesx|'.$oMember->getMemberName($vKitSpon)."|$vSponPhone|$vSponMail|$vSponAlamat|$vStockist|$vPaket|$vRO";
    } else {
       echo 'nox|';   
    
    }
  }  
  
  else if ($vOp=='kitsponro') {
    
    if ($oMember->authActiveID($vKitSpon)==1) {
    	$vSponPhone=$oMember->getMemField('fnohp',$vKitSpon);
	    $vSponMail=$oMember->getMemField('femail',$vKitSpon);	
	    $vStockist=$oMember->getMemField('fstockist',$vKitSpon);	
	    $vCountry=$oMember->getMemField('fcountrybank',$vKitSpon);	
	    $vCurr=$oJual->getCntCurr($vCountry);	
	    $_SESSION['cntro']=$vCountry;
	    $vSponAlamat=$oMember->getMemField('falamat',$vKitSpon);	
	    $vSponAlamat.= " ".$oMember->getWilName('ID',$oMember->getMemField('fpropinsi',$vKitSpon),$oMember->getMemField('fkota',$vKitSpon),'00','00');	
	    $vSponAlamat.= " ".$oMember->getWilName('ID',$oMember->getMemField('fpropinsi',$vKitSpon),'00','00','00');	
	    $vSponAlamat.= " ".$oMember->getCountryName($oMember->getMemField('fcountry',$vKitSpon));	
	   // if ($oNetwork->isInNetwork($vKitSpon,$vUser)==1)
            echo 'yesx|'.$oMember->getMemberName($vKitSpon)."|$vSponPhone|$vSponMail|$vSponAlamat|$vStockist|$vCountry|$vCurr";
       // else echo 'nox|nonet';    
    } else {
       echo 'nox|nomem';   
    
    }
  } else if ($vOp=='getcntro') {
       
       $vCntRO=$oMember->getMemField('fcountrybank',$vBuyer);	
       $vCurrRO=$oJual->getCntCurr($vCntRO);
       echo "$vCntRO|$vCurrRO";
 
  } else if ($vOp=='convertprice') {
       $vFrom=$_GET['from'];
       $vTo=$_GET['to'];
       $vNom=$_GET['nom'];
       
       if ($vFrom !='IDR')
           $vNom=$oJual->convertRateID('IDR',$vFrom,$vNom,'J');
 
       
	   if ($vFrom=='IDR' || $vTo=='IDR')
	      $vHargaForeign=$oJual->convertRateID($vFrom,$vTo,$vNom,'J');
	   else   
	      $vHargaForeign=$oJual->convertRateNonID($vFrom,$vTo,$vNom,'J');
       echo number_format($vHargaForeign,2);
 
  } else if ($vOp=='cvalidkit') {
       $vSerno=$_GET['kit'];
       $vJenis=$_GET['jen'];
      $vSQL="select fserno from tb_skit where fserno like '$vJenis%' and md5(fserno) = '$vSerno' and fstatus='1' and fpendistribusi = '' and fserno not in (select fidmember from m_anggota) ";
       
       $db->query($vSQL);
       $db->next_record();
       
       if(trim($db->f('fserno')) !='')
         echo 'yes'; 
       else echo 'no';  
   
  }  else if ($vOp=='bankcnt') {
       $vCnt=$_GET['cnt'];
       
      $vSQL="select * from m_bank where faktif='1' and  fcountry_code='$vCnt'";
       
	      $db->query($vSQL);
	      echo '<option value="">--Pilih / Choose--</option>';
	      while ($db->next_record()) {
	          $vKodeBank=$db->f('fkodebank');
	          $vBank=$db->f('fnamabank');
	          $vMaxDigit=$db->f('fmaxdigit');
	          echo '<option value="'.$vKodeBank.';'.$vMaxDigit.'">'.$vBank.'</option>';
	      }
 } else if ($vOp=='currconvert') {
          $vCurrFrom=$_GET['from'];
          $vCurrTo=$_GET['to'];
          $vNom=$_GET['nom'];
          $vJB=$_GET['jb'];
          $vHasil=$oJual->convertRate($vCurrFrom,$vCurrTo,$vNom,$vJB);
          $vHasil= round($vHasil,2);
          echo number_format($vHasil,2,",",".");
 
 } else if ($vOp=='kitstock') {
    
    if ($oMember->authActiveID($vKitSpon)==1) {
    	$vSponPhone=$oMember->getMemField('fnohp',$vKitSpon);
	    $vSponMail=$oMember->getMemField('femail',$vKitSpon);	
	    $vStockist=$oMember->getMemField('fstockist',$vKitSpon);	
	    $vSponAlamat=$oMember->getMemField('falamat',$vKitSpon);	
	    $vSponAlamat.= " ".$oMember->getWilName('ID',$oMember->getMemField('fpropinsi',$vKitSpon),$oMember->getMemField('fkota',$vKitSpon),'00','00');	
	    $vSponAlamat.= " ".$oMember->getWilName('ID',$oMember->getMemField('fpropinsi',$vKitSpon),'00','00','00');	
	    $vSponAlamat.= " ".$oMember->getCountryName($oMember->getMemField('fcountry',$vKitSpon));	

           echo 'yesx|'.$oMember->getMemberName($vKitSpon)."|$vSponPhone|$vSponMail|$vSponAlamat|$vStockist";

    } else {
       echo 'nox|nomem';   
    
    }
  } else if ($vOp=='checkstock') {
          $vMem=$_GET['mem'];
          $vProd=$_GET['prod'];
          $vSize=$_GET['size'];
          $vColor=$_GET['color'];
         // echo $oMember->getStockPos($vMem,$vProd,$vSize,$vColor);
		  echo $oMember->getStockPosNex($vMem,$vProd);
 
  } else if ($vOp=='checkstockro') {
          $vMem=$_GET['mem'];
          $vProd=$_GET['prod'];
          $vSize=$_GET['size'];
          $vColor=$_GET['color'];
         // echo $oMember->getStockPos($vMem,$vProd,$vSize,$vColor);
		  echo $oMember->getStockPosNexRO($vMem,$vProd);
 
  } else if ($vOp=='checkstockho') {
          $vProd=$_GET['prod'];
          $vSize=$_GET['size'];
          $vColor=$_GET['color'];
		  $vWH=$_GET['wh'];
          echo $oProduct->getStockPosWH($vWH,$vProd,$vSize,$vColor);
 
  } else if ($vOp=='getcurr') {
       $vCnt=$_GET['cnt'];
       
       $vCurr=$oJual->getCntCurr($vCnt);
       echo "$vCurr|$vCnt";
 
  } else if ($vOp=='checkmultiro') {
       $vUsername=$_GET['user'];
       $vYMonth=$_GET['ymonth'];
       
       echo $vMultiroRO=$oJual->checkMultiRO($vUsername,$vYMonth);	
 
  }  else if ($vOp=='checkmultiident') {
       $vIdent=$_GET['ident'];
       
       $vSQL="select count(fidmember) as fjml from m_anggota where fnoktp='$vIdent' ";	
       $db->query($vSQL);
       $db->next_record();
       echo $vJml=$db->f('fjml');
       
       
 
  } else if ($vOp=='forgotpass') {
       $vIdent=$_GET['ident'];
	   $vUserX=$_GET['user'];	
       $vNama='failed';
	   if (substr($vIdent,0,2) == '08')
	      $vIdentInter = "628".substr($vIdent,2,strlen($vIdent));
	   else $vIdentInter = $vIdent;
	   
	    	  
     $vSQL="select fidmember,fnama from m_anggota where (fnohp='$vIdentInter' or fnohp='$vIdent') and fidmember='$vUserX' ";	
       $db->query($vSQL);
       $db->next_record();
       if ($db->num_rows() > 0)
          $vNama=$db->f('fnama');
       
       echo $vNama;
       
       
 
  } else if ($vOp=='kitavai') {
       $vIdent=$_GET['ident'];
	   $vUserX=$_GET['user'];
	   $vSerno=$_POST['serno'];	
       $vStatus='failed';
     $vSQL="select fserno from tb_skit where fstatus='1' and fserno ='$vSerno' ";	
       $db->query($vSQL);
       $db->next_record();
       if ($db->num_rows() > 0)
          $vStatus=$db->f('fserno');
       
       if (trim($vStatus)==trim($vSerno))
	      echo "sernovalid";
	   else echo "sernoinvalid";	  
       
       
 
  } else if ($vOp=='checkuser') {
	//echo $vKitMem;
		$vUserPost=$_POST['user'];
		$vSQL="select fidmember,fnama,fsponphone,femailspon from m_anggota where fidmember='$vUserPost' ";
		$db->query($vSQL);
		$db->next_record();
		$vCheckMem = $db->f('fidmember');
		
		$vSQL="select fidmember from tb_idused where fidmember='$vUserPost' ";
		$db->query($vSQL);
		$db->next_record();
		$vCheckMem2 = $db->f('fidmember');
		
	    if (trim($vCheckMem) !='' || trim($vCheckMem2) !='')
	       echo 'xused';
	    else echo 'xnotfound';   
		
	
  }  else if ($vOp=='kitup') {
   // $vInNet = $oNetwork->isInNetwork($vKitUp,$vKitSpon);
	//echo "$vKitUp,$vKitSpon";
    if ($oMember->authActiveID($vKitUp)==1) {

		$vHasX='';
		$vIsIn='';
		$vHas=$oNetwork->hasDownlineLR($vKitUp,$vPosition);
		if ($vHas==1)
		   $vHasX='hasleg';
		//echo "$vKitUp,$vKitSpon";
		$vIn=$oNetwork->isInNetwork($vKitUp,$vKitSpon);   
		if ($vIn==0) {
		   $vIsIn='notinnet';
		}
		
    	$vSponPhone=$oMember->getMemField('fnohp',$vKitUp);
	    $vSponMail=$oMember->getMemField('femail',$vKitUp);	
	    $vStockist=$oMember->getMemField('fstockist',$vKitUp);	
	    $vSponAlamat=$oMember->getMemField('falamat',$vKitUp);	
	    $vSponAlamat.= " ".$oMember->getWilName('ID',$oMember->getMemField('fpropinsi',$vKitUp),$oMember->getMemField('fkota',$vKitUp),'00','00');	
	    $vSponAlamat.= " ".$oMember->getWilName('ID',$oMember->getMemField('fpropinsi',$vKitUp),'00','00','00');	
	    $vSponAlamat.= " ".$oMember->getCountryName($oMember->getMemField('fcountry',$vKitUp));	
		
		if ($vIn ==1 && $vHasX=='')
	         echo 'yesx|'.$oMember->getMemberName($vKitUp)."|$vSponPhone|$vSponMail|$vSponAlamat|$vStockist";
		else	echo "nox|$vHasX|$vIsIn";     
    } else {
       echo 'noxall|';   
    
    }
  } else if ($vOp=='kitavaimulti' && $vMaker != 'stockist') {
	  
       $vIdent=$_GET['ident'];
	   $vUserX=$_GET['user'];
	   $vSerno=$_POST['serno'];	
	   
	   $vArrSerno=explode("\n",$vSerno);
	   //print_r($vArrSerno);
	   $vArrNotValid="";
	   $vArrPaket=array();
	   while(list($key,$val)=each($vArrSerno)) {
		   if (trim($val) !='') {

			 $vSQL="select fserno,fpaket from tb_skit where fstatus='1' and fserno ='$val';";	
				   $db->query($vSQL);
				   $db->next_record();
				   if ($db->num_rows() <= 0)
					  $vArrNotValid .= $val.",";
				   else {
					   $vPaket=$db->f('fpaket');   
					   $vArrPaket[] = $vPaket;
				   }
			   
		   }
	   }
	  
	   $vArrPaket= array_unique($vArrPaket);
	   
//echo	  $vArrNotValid; 

	   if ($vArrNotValid !='')
	       $vArrNotValid = substr($vArrNotValid,0,strlen($vArrNotValid)-1);

	   
	   
	   
    
       
       if (trim($vArrNotValid)=='' && count($vArrPaket) <=1) {
	      
		  $vArrVal=array_values($vArrPaket);
		  $_SESSION['paket']=$vArrVal[0];
		  
		  $vKitPrice=$oRules->getSettingByField('fkitprice');
		  $vSPrice = $oRules->getSettingByField('fregsilver');
		  $vGPrice = $oRules->getSettingByField('freggold');
		  $vPPrice = $oRules->getSettingByField('fregplat');
		  $vPackName = $oProduct->getPackName($vArrVal[0]);
		  if ($vArrVal[0] == 'S') {
		     $vPrice = $vSPrice;
			 $vMax = $vGPrice;
		  } else	if ($vArrVal[0] == 'G') {
		     $vPrice = $vGPrice;
			 $vMax = $vPPrice;
		  } else	if ($vArrVal[0] == 'P') {
		     $vPrice = $vPPrice;
			 $vMax = 9999999999;
	   	  }
		  $_SESSION['price']=$vArrVal[0];
		  echo "sernovalid;".$vArrVal[0].";$vPrice;$vMax;$vPackName";
	   } else if (trim($vArrNotValid)!='' || count($vArrPaket) >1 ) {
		   
		   $vNotValid = "sernoinvalid;".$vArrNotValid;
		   if (count($vArrPaket) >1)
		      $vNotValid .= "mix";
			  
			  echo $vNotValid;
	   }
       
       
 
  } else if ($vOp=='cancelact') {
    $vMem=$_GET['mem'];
	if ($vMem=='') $vMem='headoffice';
	$vSer = $_GET['ser'];
	$vSell = $_GET['idsell'];
	
	 $vSQL="select * from tb_kit_active where fidpenjualan='$vSell' and fidmember='$vSer'";
	$db->query($vSQL);
	while ($db->next_record()) {
		$vIDProd=$db->f('fidproduk');
		$vQty=$db->f('fjumlah');
		$vSerno=$db->f('fidmember');

		$vLastBal = $oMember->getStockPosUnig($vMem,$vIDProd);
		$vNewBal=$vLastBal + $vQty;
//Mutasi dan stok position
	 	$vSQLIn = "INSERT INTO  tb_mutasi_stok(fidmember, fidproduk,  fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate, fref) VALUES ('$vMem', '$vIDProd', '$vSerno', now(), 'Kit Deactivation [$vSerno]', $vQty, 0, $vNewBal, 'KDA', '1', 'admin_manager', now(), '$vSell');";
		$vResin=$dbin->query($vSQLIn);
		if ($vResin) {
   	  	  	$vSQLin2="update tb_stok_position set fbalance=fbalance+$vQty where fidmember='$vMem' and fidproduk='$vIDProd';";
			$dbin->query($vSQLin2);
			
   	  	  	$vSQLin2="update tb_skit set fstatus=1, fpendistribusi='',ftgldist=null, ftglused=null where fserno='$vSerno';";
			$dbin->query($vSQLin2);
			
	
		}
		
	}
	
	 $vSQL = "delete from tb_kit_active where fidmember='$vSer' and fidpenjualan='$vSell'";
	
	if ($db->query($vSQL))
		echo "success";
  } else if ($vOp=='kitavaimulti' && $vMaker == 'stockist') {
	   $vDistributor=$_GET['dist'];
       $vIdent=$_GET['ident'];
	   $vUserX=$_GET['user'];
	   $vSerno=$_POST['serno'];	
	   
	   $vArrSerno=explode("\n",$vSerno);
	   //print_r($vArrSerno);
	   $vArrNotValid="";
	   $vArrPaket=array();
	   while(list($key,$val)=each($vArrSerno)) {
		   if (trim($val) !='') {

			  $vSQL="select fserno,fpaket from tb_skit where fstatus='2' and fserno ='$val' and fpendistribusi='$vDistributor';";	
				   $db->query($vSQL);
				   $db->next_record();
				   if ($db->num_rows() <= 0)
					  $vArrNotValid .= $val.",";
				   else {
					   $vPaket=$db->f('fpaket');   
					   $vArrPaket[] = $vPaket;
				   }
			   
		   }
	   }
	  
	   $vArrPaket= array_unique($vArrPaket);
	   
//echo	  $vArrNotValid; 

	   if ($vArrNotValid !='')
	       $vArrNotValid = substr($vArrNotValid,0,strlen($vArrNotValid)-1);

	   
	   
	   
    
       
       if (trim($vArrNotValid)=='' && count($vArrPaket) <=1) {
	      
		  $vArrVal=array_values($vArrPaket);
		  $_SESSION['paket']=$vArrVal[0];
		  
		  $vKitPrice=$oRules->getSettingByField('fkitprice');
		  $vSPrice = $oRules->getSettingByField('fregsilver');
		  $vGPrice = $oRules->getSettingByField('freggold');
		  $vPPrice = $oRules->getSettingByField('fregplat');
		  $vPackName = $oProduct->getPackName($vArrVal[0]);
		  if ($vArrVal[0] == 'S') {
		     $vPrice = $vSPrice;
			 $vMax = $vGPrice;
		  } else	if ($vArrVal[0] == 'G') {
		     $vPrice = $vGPrice;
			 $vMax = $vPPrice;
		  } else	if ($vArrVal[0] == 'P') {
		     $vPrice = $vPPrice;
			 $vMax = 9999999999;
	   	  }
		  $_SESSION['price']=$vArrVal[0];
		  echo "sernovalid;".$vArrVal[0].";$vPrice;$vMax;$vPackName";
	   } else if (trim($vArrNotValid)!='' || count($vArrPaket) >1 ) {
		   
		   $vNotValid = "sernoinvalid;".$vArrNotValid;
		   if (count($vArrPaket) >1)
		      $vNotValid .= "mix";
			  
			  echo $vNotValid;
	   }
       
       
 
  }  else if ($vOp=='cancelactst') {
    $vMem=$_GET['mem'];
	if ($vMem=='') $vMem='headoffice';
	$vSer = $_GET['ser'];
	$vSell = $_GET['idsell'];
	
	 $vSQL="select * from tb_kit_active where fidpenjualan='$vSell' and fidmember='$vSer'";
	$db->query($vSQL);
	while ($db->next_record()) {
		$vIDProd=$db->f('fidproduk');
		$vQty=$db->f('fjumlah');
		$vSerno=$db->f('fidmember');

		$vLastBal = $oMember->getStockPosUnig($vMem,$vIDProd);
		$vNewBal=$vLastBal + $vQty;
//Mutasi dan stok position
	 	$vSQLIn = "INSERT INTO  tb_mutasi_stok(fidmember, fidproduk,  fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate, fref) VALUES ('$vMem', '$vIDProd', '$vSerno', now(), 'Kit Deactivation [$vSerno]', $vQty, 0, $vNewBal, 'KDA', '1', 'admin_manager', now(), '$vSell');";
		$vResin=$dbin->query($vSQLIn);
		if ($vResin) {
   	  	  	$vSQLin2="update tb_stok_position set fbalance=fbalance+$vQty where fidmember='$vMem' and fidproduk='$vIDProd';";
			$dbin->query($vSQLin2);
			
   	  	  	$vSQLin2="update tb_skit set fstatus=2, ftglused=null where fserno='$vSerno';";
			$dbin->query($vSQLin2);
			
	
		}
		
	}
	
	 $vSQL = "delete from tb_kit_active where fidmember='$vSer' and fidpenjualan='$vSell'";
	
	if ($db->query($vSQL))
		echo "success";
  } else if ($vOp=='claimtour') {//Claimtour
    $vMem=$_POST['user'];
	$vIdSys = $_POST['level'];
	$vBukti = $_POST['bkt'];
	
	
	$vSQL="update tb_promo set fpaid='1', ftglpaid=now(),fbukti='$vBukti' where fidsys=$vIdSys";

	
	if ($db->query($vSQL))
		echo "success";
  }

	if ($vOp=='getrweek') {
		$vWeek=$_GET['week'];
		$vYear=$_GET['year'];
		
		$vRange=getStartAndEndDate($vWeek,$vYear);
		if (is_array($vRange)) {
		     echo json_encode($vRange);	
		}  else {
		     echo json_encode(array("week_start"=>"","week_end"=>""));		
		}
	}


 
 ?> 
