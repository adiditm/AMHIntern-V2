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
   include_once("../classes/ruleconfigclass.php");
   include_once(CLASS_DIR."komisiclass.php");
   include_once("../classes/jualclass.php");
   include_once("../classes/systemclass.php");
   include_once(CLASS_DIR."productclass.php");
   include_once(CLASS_DIR."texttoimageclass.php");
   include_once(CLASS_DIR."actionpayclass.php");

 

 

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

	       $vSQL="select * from m_wilayah where fkodeneg='$vWilID' and fkabkota='00' and fkec='00' and fdeskel='0000' order by fnamawil ";

	      $db->query($vSQL);

	      echo '<option value="">--Pilih / Choose-</option> <option  value="PX"  >Other Province</option>';

	      while ($db->next_record()) {

	          $vKodeProp=$db->f('fprop');

	          $vWil=$db->f('fnamawil');

	          echo '<option value="'.$vKodeProp.'">'.$vWil.'</option>';

	      }

	   }   

	  
			if ($vGetWil=='propongkir') {
			
			
					$id_propinsi = "a3";
					
					$curl = curl_init();
					curl_setopt_array($curl, array(
					  CURLOPT_URL            => "https://pro.rajaongkir.com/api/province",
					  CURLOPT_SSL_VERIFYHOST => 0,
					  CURLOPT_SSL_VERIFYPEER => 0,
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_ENCODING       => "",
					  CURLOPT_MAXREDIRS      => 10,
					  CURLOPT_TIMEOUT        => 30,
					  CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
					  CURLOPT_CUSTOMREQUEST  => "GET",
					  CURLOPT_HTTPHEADER     => array(
						"key: ".$oRules->getSettingByField('fkeyongkir','')
					  ),
					));
					
					$response_propinsi = curl_exec($curl);
					$err               = curl_error($curl);
					
					curl_close($curl);
					 $array_propinsi = json_decode($response_propinsi, true);
 					 $data_propinsi = $array_propinsi['rajaongkir']['results'];
			

			
					  echo "<option selected value=''>-- Pilih Propinsi --</option>";
					  foreach ($data_propinsi as $propinsi) {
						$selected = ($propinsi['province_id'] == $id_propinsi ? 'selected' : '');
						echo "<option value='" . $propinsi['province_id'] . "'" . $selected . ">" . $propinsi['province_id'] . " | " . $propinsi['province'] . "</option>";
								
					  }   
			}
	  

	   if ($vGetWil=='kota') {
	     $vDefault=$_GET['def'];
	      $vSQL="select * from m_wilayah where fkodeneg='$vCountry' and fprop='$vWilID' and fkabkota <> '00' and fkec='00' and fdeskel='0000' order by fnamawil ";
	      $db->query($vSQL);
	      echo '<option value="">--Pilih / Choose-</option> <option  value="KX"  >Other City</option>';
	      while ($db->next_record()) {
	          $vKodeKota=$db->f('fkabkota');
	          $vWil=$db->f('fnamawil');
	          $vSelect='';
	           if(trim($vDefault) ==$vKodeKota) $vSelect =  "selected";
	          echo '<option value="'.$vKodeKota.'"  '.$vSelect.'>'.$vWil.'</option>';
	      }
	   }    
	   

	   if ($vGetWil=='kotaongkir') {
		  
			$provinsi_id = $_GET['prov_id'];
			if ($provinsi_id !='') {
					$id_kota = "aaaaaaa106";
					
					$curl = curl_init();
					curl_setopt_array($curl, array(
					  CURLOPT_URL            => "https://pro.rajaongkir.com/api/city?province=" . $provinsi_id,
					  CURLOPT_SSL_VERIFYHOST => 0,
					  CURLOPT_SSL_VERIFYPEER => 0,
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_ENCODING       => "",
					  CURLOPT_MAXREDIRS      => 10,
					  CURLOPT_TIMEOUT        => 30,
					  CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
					  CURLOPT_CUSTOMREQUEST  => "GET",
					  CURLOPT_HTTPHEADER     => array(
						"key: ".$oRules->getSettingByField('fkeyongkir','')
					  ),
					));
					
					$response_kota = curl_exec($curl);
					$err           = curl_error($curl);
					curl_close($curl);
					
					 $array_kota = json_decode($response_kota, true);
					  // var_dump($array_kota);
					  $data_kota = $array_kota['rajaongkir']['results'];
					
						echo "<option selected value=''>-- Pilih Kab/Kota --</option>";
					  foreach ($data_kota as $kota) {
						$selected = ($provinsi_id == $id_kota ? 'selected' : '');
						$type = $kota['type'] == "Kabupaten" ? "Kab." : "";
						echo "<option value='" . $kota['city_id'] . "' idkota_tujuan='" . $kota['city_id'] . "'" . $selected . ">"  . $kota['city_id'] . " | " . $type . " " . $kota['city_name'] . "</option>";
					  };
					  
			} else echo "<option selected value=''>-- Pilih  Kab/Kota --</option>";
	   } 
	   
	   
	   
 		if ($vGetWil=='kecaongkir') {
		  
			$kota_id = $_GET['kota_id'];
			if ($kota_id !='') {
					$kota_id = $_GET['kota_id'];
					$id_kecamatan     = "aaaaaaa106";
					//echo "key: ".$oRules->getSettingByField('fkeyongkir','');
					$curl = curl_init();
					curl_setopt_array($curl, array(
					  CURLOPT_URL            => "https://pro.rajaongkir.com/api/subdistrict?city=" . $kota_id,
					  CURLOPT_SSL_VERIFYHOST => 0,
					  CURLOPT_SSL_VERIFYPEER => 0,
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_ENCODING       => "",
					  CURLOPT_MAXREDIRS      => 10,
					  CURLOPT_TIMEOUT        => 30,
					  CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
					  CURLOPT_CUSTOMREQUEST  => "GET",
					  CURLOPT_HTTPHEADER     => array(
						"key: ".$oRules->getSettingByField('fkeyongkir','')
					  ),
					));
					
					$response_kecamatan = curl_exec($curl);
					$err           = curl_error($curl);
					curl_close($curl);
					
				  $array_kecamatan = json_decode($response_kecamatan, true);
				  $data_kecamatan  = $array_kecamatan['rajaongkir']['results'];
				
				  echo "<option selected value=''>-- Pilih Kecamatan--</option>";
				  foreach ($data_kecamatan as $kecamatan) {
					$selected = ($kecamatan['subdistrict_id'] == $id_kecamatan ? 'selected' : '');
					echo "<option value='" . $kecamatan['subdistrict_id'] . "' id_kecamatan='" . $kecamatan['city_id'] . "'" . $selected . ">" . $kecamatan['subdistrict_id'] . " | " . $kecamatan['subdistrict_name'] . "</option>";
				  };
					  
			} else echo "<option selected value=''>-- Pilih Kecamatan--</option>";
	  	 } 	      
	   
	   
	   if ($vGetWil=='keca') {
	     $vDefault=$_GET['def'];
		   $vProp = $_GET['kodeprop'];
	       $vSQL="select * from m_wilayah where fkodeneg='$vCountry' and fprop='$vProp' and fkabkota = '$vWilID' and fkec<>'00' and fdeskel='0000' order by fnamawil ";
	      $db->query($vSQL);
	      echo '<option value="">--Pilih / Choose-</option> <option  value="KX"  >Other City</option>';
	      while ($db->next_record()) {
	          $vKodeKeca=$db->f('fkec');
	          $vWil=$db->f('fnamawil');
            $vSelect='';
	           if(trim($vDefault) ==$vKodeKeca) $vSelect =  "selected";	          
	          echo '<option value="'.$vKodeKeca.'"  '.$vSelect.'>'.$vWil.'</option>';
	      }
	   } 
	    
  } 
  
  else if ($vOp=='kit' && $_GET['st'] =='') {

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
    if ($oMember->authSponActiveID($vKitSpon)==1) {
   echo   $vSQL="select * from m_pebisnis where fidmember = '$vKitSpon'  ";
		$db->query($vSQL);
       $db->next_record();
/*	   $vSponPhone = $oMember->getNoHP($vKitSpon);
	   $vSponMail = $oMember->getEmail($vKitSpon);
	   $vSponAlamat = $oMember->getAlamat($vKitSpon);*/
	   
	   $vSponPhone = $db->f('fnohp');
	   $vSponMail = $db->f('femail');
	   $vSponAlamat = $db->f('falamat');
	   
	   
            echo 'yesx|'.$db->f('fnama')."|$vSponPhone|$vSponMail|$vSponAlamat|$vStockist|$vCountry|$vCurr";
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
 
 if ($vOp=='loadevent') {
       $vIdSys=$_GET['idsys'];

       $vNama='failed';
       $vSQL="select * from tb_korwil_area where fidsys=$vIdSys  ";	
       $db->query($vSQL);
       $db->next_record();
	   $vOut=$db->Record;
	   echo json_encode($vOut,true);	
	
 }

 if ($vOp=='getref') {
       $vIdRef=$_POST['ref'];

       $vNama='failed';
       $vSQL="select * from tmmember where kode='$vIdRef'  ";	
       $oDBAMHT->query($vSQL);
       $oDBAMHT->next_record();
	   $vOut=$oDBAMHT->Record;
	   
	   if ($oDBAMHT->num_rows()>0) {
	   		$vArrOut = array('status'=>'xsuccessref','message'=>'Kode Pebisnis Valid!','data'=>$vOut);
			$vRet = json_encode($vArrOut,true);
	   } else {
		   	$vArrOut = array('status'=>'xfailref','message'=>'Kode Pebisnis Tidak Valid!','data'=>'');
			$vRet = json_encode($vArrOut,true);	   
	   }
	
	echo $vRet;
 } else if ($vOp=='deltemplate') {

	   $vIdSys=$_GET['idsys'];

       $vSQL="delete from tb_korwil_area where fidsys=$vIdSys";	
	//   exit;
       $db->query($vSQL);
	   if ($db->affected_rows() >0 )
	      echo 'success';
	   else echo 'nodel';	  
  } else if ($vOp=='addevent') {
	   $vPrefix=$_GET['prefix'];
	   $vIdTemp=$_GET['idtemp'];
	   $vLenPref=strlen($vPrefix);
        $vSQL="select max(fidevent) as maxid from m_event  where fidtemplate='$vIdTemp'";	
	   
       $db->query($vSQL);
	   $db->next_record();
	    $vMaxid=$db->f('maxid');
	   if (trim($vMaxid) =='') {
		  echo "$vPrefix"."0001";   
		   
	   } else {
		// $vPrefix=substr($vMaxid,0,$vLenPref);    
		 $vSuffix = substr($vMaxid,$vLenPref,4);     
		 $vSuffix = (int) $vSuffix;
		 $vSuffix++;
		 $vSuffix=str_pad($vSuffix,4,'0',STR_PAD_LEFT);
		 
		 echo "$vPrefix$vSuffix";
		 
		 
	   }
  } else if ($vOp=='savearea') {
	   $vSubOP = $_GET['subop'];
	   $vIdSys = $_POST['idsys'];
	   $vIDKorwil=$_POST['idkor'];
	   $vCountry=$_POST['country'];
	   $vProp=$_POST['prop'];
	   $vKabKota=$_POST['kota'];
	   $vKec=$_POST['kec'];
	   
	   if ($vSubOP=='saveadd') {

		  				 $vOut=array();
						 $vSQL="select * from tb_korwil_area where fidkorwil='$vIDKorwil' and fprop='$vProp' and fkabkota='$vKabKota' and fkec='$vKec' ";
						 $db->query($vSQL);
						 $db->next_record();
						
						 if ($db->num_rows() <=0 ) {
							    $vSQL="insert into tb_korwil_area(fidkorwil, fprop,  fkabkota, fkec, flastupdate) values('$vIDKorwil','$vProp','$vKabKota','$vKec', now())  ";	
							  // exit;
							    $db->query($vSQL);
								$vOut['status'] = 'success';
								$vOut['data'] = '';
								$vOut['message'] = 'Penambahan area sukses!';
							
							    
						 } else {
							$vOut['status'] = 'failed';
							$vOut['data'] = '';
							$vOut['message'] = "Penambahan area gagal, duplicate area in $vIDKorwil, silakan pilih Propinsi, Kab/Kota, Kecamatan lainnya!";
							 
						 }
						 
						 echo json_encode($vOut,true);
						 
	   } else if ($vSubOP=='saveedit') {
		  				 $vOut=array();
						 $vSQL="select * from tb_korwil_area where fidkorwil='$vIDKorwil' and fprop='$vProp' and fkabkota='$vKabKota' and fkec='$vKec' ";
						 $db->query($vSQL);
						 $db->next_record();
						 
						 if ($db->num_rows() <=0 ) {
						 	$vSQL="update  tb_korwil_area set  fprop='$vProp', fkabkota='$vKabKota', fkec='$vKec',flastupdate=now() where fidkorwil='$vIDKorwil' and fidsys=$vIdSys";	

					     	$db->query($vSQL) ;
							$vOut['status'] = 'success';
							$vOut['data'] = '';
							$vOut['message'] = 'Update success!';
							
						 } else {
							$vOut['status'] = 'failed';
							$vOut['data'] = '';
							$vOut['message'] = "Update gagal, duplicate area in $vIDKorwil!";
							 
						 }
						 
						 echo json_encode($vOut,true);
					    
		
	   }
		 
		 
	   
  } else if ($vOp=='thepprog') {
	   $vPaket = $_GET['ppaket'];
	   $vProg = $_GET['pprog'];
	    $vDepart = $_GET['depart'];
	     $vProd = $_GET['prod'];
	
		  				 $vOut=array();
					 	 $vSQL="select b.fidtour, b.fdesc, b.fjmlhari as daypromo, b.fhargapub as pricepromo, b.fassure as asupromo, b.fhandle as handpromo,b.fcurr, b.fkurs, b.fhargapub * b.fkurs as ffprice from  m_tour b  where b.fpaket='$vPaket' and b.fprogram='$vProg' and b.ftgldepart='$vDepart' and  fidtour = '$vProd' ";
						 $db->query($vSQL);
						 $db->next_record();
						 
						 if ($db->num_rows() > 0 ) {
						 	$vPrice= $db->f('pricepromo');	
						 	$vFPrice= $db->f('ffprice');	
							$vDayCount= $db->f('daypromo');
							$vAssure= $db->f('asupromo');
							$vHandle= $db->f('handpromo');
							$vIdPromo= $db->f('fidtour');
							$vDesc= $db->f('fdesc');
							
							$vData['price']=$vPrice;
							$vData['hari']=$vDayCount;
							$vData['assure']=$vAssure;
							$vData['handle']=$vHandle;
							$vData['idpromo']=$vIdPromo;
							$vData['desc']=$vDesc;
							$vData['haripromo']=$db->f('daypromo');
							$vData['pricepromo']=$db->f('pricepromo');
							$vData['handlepromo']=$db->f('handpromo');
							$vData['assurepromo']=$db->f('asupromo');
							$vData['foreprice']=$vFPrice;
							$vData['fcurr']=$db->f('fcurr');
							
					     	$db->query($vSQL) ;
							$vOut['status'] = 'success';
							$vOut['data'] = $vData;
							$vOut['message'] = 'Data retrieved!';
							
						 } else {
							$vOut['status'] = 'failed';
							$vOut['data'] = '';
							$vOut['message'] = "Data not found, please contact Administrator & check setting for Paket Program!";
							 
						 }
						 
						 echo json_encode($vOut,true);
					    
   
  } else if ($vOp=='getseat') {
	
	    $vDepart = $_GET['depart'];
	      $vProd = $_GET['prod'];
	
		  				 $vOut=array();
						 $vSQL="select a.* from m_tour a where  a.ftgldepart='$vDepart'  and fidtour='$vProd' ";
						 $db->query($vSQL);
						 $db->next_record();
						 
						 if ($db->num_rows() > 0 ) {
						 	$vDepart= $db->f('ftgldepart');	
							$vSisaSeat= $db->f('fsisaseat');
							$vPlane= $db->f('fplane');
							$vHotel= $db->f('fhotel');
							$vDesc= $db->f('fdesc');
						
							$vData['depart']=$vDepart;
							$vData['sisaseat']=$vSisaSeat;
							$vData['plane']=$vPlane;
							$vData['fdesc']=$vDesc;
							$vData['hotel']=", Hotel: ".$vHotel;

							
					     	$db->query($vSQL) ;
							$vOut['status'] = 'success';
							$vOut['data'] = $vData;
							$vOut['message'] = 'Data retrieved!';
							
						 } else {
							$vOut['status'] = 'failed';
							$vOut['data'] = '';
							$vOut['message'] = "Data not found, please check setting for Info Keberangkatan!";
							 
						 }
						 
						 echo json_encode($vOut,true);
					    
   
  }  else if ($vOp=='getseatcode') {
	
 $vCode = $_GET['code'];
		$vPaket = $_GET['paket'];
	
		  				 $vOut=array();
						if ($vPaket=='1')
							 $vSQL="select a.* from m_tour a where  a.fidtour='$vCode'  and a.fexpired >= date(now()) ";
					   else
					   		 $vSQL="select a.* from m_tour a where  a.fidtour='$vCode' and a.fpaket='$vPaket' and a.fexpired >= date(now()) ";
						 $db->query($vSQL);
						 $db->next_record();
						 
						 if ($db->num_rows() > 0 ) {
						 	$vDepart= $db->f('ftgldepart');	
							$vSisaSeat= $db->f('fsisaseat');
							$vPlane= $db->f('fplane');
							$vHotel= $db->f('fhotel');
						
							if ($db->f('fjenispax')=='1')
							   $vJenPax = 'Single';
							else if ($db->f('fjenispax')=='2')
							   $vJenPax = 'Double';   
							else if ($db->f('fjenispax')=='3')
							   $vJenPax = 'Triple';  
							else if ($db->f('fjenispax')=='4')
							   $vJenPax = 'Quad';      
							   
							$vData['depart']=$vDepart;
							$vData['sisaseat']=$vSisaSeat;
							$vData['plane']=$vPlane;
							$vData['hotel']=", Hotel: ".$vHotel;
							$vData['jenpax']=", Jenis Pax: ".$vJenPax;

							
					     	$db->query($vSQL) ;
							$vOut['status'] = 'success';
							$vOut['data'] = $vData;
							$vOut['message'] = 'Data retrieved!';
							
						 } else {
							$vOut['status'] = 'failed';
							$vOut['data'] = '';
							$vOut['message'] = "Data not found, please check setting for Info Keberangkatan!";
							 
						 }
						 
						 echo json_encode($vOut,true);
  } 
  else if ($vOp=='mempay') {
    if ($oMember->authActiveID($vKitSpon)==1) {
    $vSQL="select * from m_anggota where fidmember = '$vKitSpon'  ";
		$db->query($vSQL);
       $db->next_record();
/*	   $vSponPhone = $oMember->getNoHP($vKitSpon);
	   $vSponMail = $oMember->getEmail($vKitSpon);
	   $vSponAlamat = $oMember->getAlamat($vKitSpon);*/
	   
	   $vSponPhone = $db->f('fnohp');
	   $vSponMail = $db->f('femail');
	   $vSponAlamat = $db->f('falamat');
	   
	   
            echo 'yesx|'.$db->f('fnama')."|$vSponPhone|$vSponMail|$vSponAlamat|$vStockist|$vCountry|$vCurr";
    } else {
       echo 'nox|nomem';   
    }
   
  } else if ($vOp=='thepprogcode') {
	   $vPaket = $_GET['ppaket'];
	   $vProg = $_GET['pprog'];
	    $vCode = $_GET['code'];
		$vPax = $_GET['pax'];
	
		  				 $vOut=array();
						 $vSQL="select a.* from m_tour a where a.fpaket='$vPaket' and a.fidtour='$vCode' and a.fexpired >= date(now()) ";
						 $db->query($vSQL);
						 $db->next_record();
						 if ($vPax =='1')
						    $vPax='';
						 if ($db->num_rows() > 0 ) {
						 	$vPrice= $db->f('fhargapub'.$vPax);	
							$vDayCount= $db->f('fjmlhari');
							$vAssure= $db->f('fassure');
							$vHandle= $db->f('fhandle');
							$vCurr= $db->f('fcurr');
							$vKurs = $db->f('fkurs'); 
						//	if($vCurr !='IDR') {
							   $vSQL = "select fsetval from tb_rules_config where fsetname='finfokursusd'";
							  $db1->query($vSQL);
							  $db1->next_record();
							  $vPrice = round($vPrice / $vKurs * $db1->f('fsetval')); 
						//	}
							
							$vDesc= $db->f('fdesc');
							
							$vData['price']=$vPrice;
							$vData['hari']=$vDayCount;
							$vData['assure']=$vAssure;
							$vData['handle']=$vHandle;
							
							$vData['desc']=$vDesc;
							
							
					     	$db->query($vSQL) ;
							$vOut['status'] = 'success';
							$vOut['data'] = $vData;
							$vOut['message'] = 'Data retrieved!';
							
						 } else {
							$vOut['status'] = 'failed';
							$vOut['data'] = '';
							$vOut['message'] = "Data not found, please check setting for Paket Program!";
							 
						 }
						 
						 echo json_encode($vOut,true);
					    
   
  } else  if ($vOp=='wilongkir') { //Wilayah  Ongkir Kota

	   if ($vGetWil=='prop') {

	       $vSQL="select * from m_wilayah where fkodeneg='$vWilID' and fkabkota='00' and fkec='00' and fdeskel='0000' order by fnamawil ";

	      $db->query($vSQL);

	      echo '<option value="">--Pilih / Choose-</option> <option  value="PX"  >Other Province</option>';

	      while ($db->next_record()) {

	          $vKodeProp=$db->f('fprop');

	          $vWil=$db->f('fnamawil');

	          echo '<option value="'.$vKodeProp.'">'.$vWil.'</option>';

	      }

	   }   

	  

	  

	   if ($vGetWil=='kota') {
		   $vURL = "";
	     $vDefault=$_GET['def'];
		 
			$provinsi_id = $_POST['prov_id'];
			$id_kota = "aaaaaaa106";
			
			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL            => "https://pro.rajaongkir.com/api/city?province=" . $provinsi_id,
			  CURLOPT_SSL_VERIFYHOST => 0,
			  CURLOPT_SSL_VERIFYPEER => 0,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING       => "",
			  CURLOPT_MAXREDIRS      => 10,
			  CURLOPT_TIMEOUT        => 30,
			  CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST  => "GET",
			  CURLOPT_HTTPHEADER     => array(
				"key: ".$oRules->getSettingByField('fkeyongkir','')
			  ),
			));
			
			$response_kota = curl_exec($curl);
			$err           = curl_error($curl);
			
			curl_close($curl);
		 
	      $vSQL="select * from m_wilayah where fkodeneg='$vCountry' and fprop='$vWilID' and fkabkota <> '00' and fkec='00' and fdeskel='0000' order by fnamawil ";
	      $db->query($vSQL);
	      echo '<option value="">--Pilih / Choose-</option> <option  value="KX"  >Other City</option>';
	      while ($db->next_record()) {
	          $vKodeKota=$db->f('fkabkota');
	          $vWil=$db->f('fnamawil');
	          $vSelect='';
	           if(trim($vDefault) ==$vKodeKota) $vSelect =  "selected";
	          echo '<option value="'.$vKodeKota.'"  '.$vSelect.'>'.$vWil.'</option>';
	      }
	   }  else  if ($vGetWil=='keca') {
	     $vDefault=$_GET['def'];
		   $vProp = $_GET['kodeprop'];
	       $vSQL="select * from m_wilayah where fkodeneg='$vCountry' and fprop='$vProp' and fkabkota = '$vWilID' and fkec<>'00' and fdeskel='0000' order by fnamawil ";
	      $db->query($vSQL);
	      echo '<option value="">--Pilih / Choose-</option> <option  value="KX"  >Other City</option>';
	      while ($db->next_record()) {
	          $vKodeKeca=$db->f('fkec');
	          $vWil=$db->f('fnamawil');
            $vSelect='';
	           if(trim($vDefault) ==$vKodeKeca) $vSelect =  "selected";	          
	          echo '<option value="'.$vKodeKeca.'"  '.$vSelect.'>'.$vWil.'</option>';
	      }
	   } 
	    
  } else if ($vOp=='addrongkir') {
	  $vSQL = "select * from m_seller where fprop <> '' and fkota <> '' and fkec <> '' and fidseller='$vKitSpon'";
	  $db->query($vSQL);
	  if ($db->num_rows() >0){	  
        echo 'yesaddr|'.$oMember->getMemberName($vKitSpon);
	  } else  echo 'noaddr|'.$oMember->getMemberName($vKitSpon);
  } else if ($vOp=='packongkir') {
	  		$vBerat = $_POST['berat'];
			
			if ($vBerat < 1000) $vBerat = 1000;
			$id_kotaasal  = $_POST['id_kotaasal'];
			$berat        = $vBerat;
			$id_kecamatan = $_POST['id_kecamatan'];
			$kota = $_POST['id_kecamatan'];
			$kurir        = $_POST['kurir'];

		$curl = curl_init();
		curl_setopt_array(
		  $curl,
		  array(
			CURLOPT_URL            => "https://pro.rajaongkir.com/api/cost",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => "",
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 30,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_CUSTOMREQUEST  => "POST",
			// CURLOPT_POSTFIELDS     => "origin=" . $id_kotaasal . "&destination=" . $id_kotatujuan . "&weight=" . $berat . "&courier=" . $kurir . "",
			CURLOPT_POSTFIELDS => "origin=" . $id_kotaasal . "&originType=city&destination=" . $id_kecamatan . "&destinationType=subdistrict&weight=" . $berat . "&courier=" . $kurir . "",
			CURLOPT_HTTPHEADER     => array(
			  "content-type: application/x-www-form-urlencoded",
			  "key: ".$oRules->getSettingByField('fkeyongkir','')
			),
		  )
		);

		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  // echo $response; //untuk ngetes hasil
		
		
		  $array_paket = json_decode($response, true);
		  $data_paket  = $array_paket['rajaongkir']['results'][0]['costs'];
		
		  echo "<option value='0' ongkir=\"0\" selected=''>-- Pilih Paket " . strtoupper($kurir) . "--</option>";
			  foreach ($data_paket as $paket) {
				echo "<option 
				value        = '" . $paket['service'] . "'
				ongkir       = '" . $paket['cost'][0]['value'] . "'
				lamakirim    = '" . $paket['cost'][0]['etd'] . "'
				jenispaket   = '" . $paket['service'] . "'
				kecamatan    = '" . $array_paket['rajaongkir']['destination_details']['subdistrict_name'] . "'
				id_kecamatan = '" . $array_paket['rajaongkir']['destination_details']['subdistrict_id'] . "'
				kota         = '" . $array_paket['rajaongkir']['destination_details']['city'] . "'
				type         = '" . $array_paket['rajaongkir']['destination_details']['type'] . "'
				id_kota      = '" . $array_paket['rajaongkir']['destination_details']['city_id'] . "'
				propinsi     = '" . $array_paket['rajaongkir']['destination_details']['province'] . "'
				id_propinsi  = '" . $array_paket['rajaongkir']['destination_details']['province_id'] . "'
				>" . $paket['service'] . " | " . $paket['cost'][0]['etd'] . " Hari | Rp. " . number_format($paket['cost'][0]['value'], 0, ',', '.') . "</option>";
			  };
		  }



  } else if ($vOp=='generateva') {
		$vJumlah = $_POST['amount'];
		$vRef = $_POST['ref'];
		$vBuyer = $_POST['buyer'];
		$vBankVA = $_POST['bankva'];

		$clientId = $oRules->getSettingByField('factpayclientid');
		$clientSecret = $oRules->getSettingByField('factpayclientsec');
		$apiSecret = $oRules->getSettingByField('factpayapisec');
		$vNamaAlias = $oRules->getSettingByField('factpaycompname');
		$vNorek = $oRules->getSettingByField('frekbank1');
		$vBankCode = $oRules->getSettingByField('factpaybankva');

		$vRemark = "Pembayaran VA $vRef";

		$vBankCodeVA = $oRules->getSettingByField('factpaybankva');
		$data_inquiry = "{
			\"address\":\"$vNorek\",
			\"amount\":$vJumlah,
			\"alias\":\"$vNamaAlias\",
			\"bankCode\":\"$vBankCodeVA\",
			\"remarks\":\"$vRemark\",
			\"refId\":\"$vRef\"
		}"; 

		$data_inquiry = '';


		//$accessToken = getAuthToken($clientId, $clientSecret);

		// Get signature
		$signatureAll = $oActionPay->getSignature($clientId, $clientSecret, $apiSecret, $data_inquiry);
		$signature = $signatureAll['data']['signature'];

		//  echo "Sig: $signature <br>";
		// Example usage
		$accessToken = $oActionPay->getAuthToken($clientId, $clientSecret);

		//echo "Data Inquiry: ".$data_inquiry."<br>";

		$response = $oActionPay->depositRoute($accessToken, $signature);

		//echo "Withdraw Inquiry Response: ";
		//print_r($response);

		
		$vChannelID = $response['data'][$vBankVA]['chId'];
		$vBankCodeVA = $response['data'][$vBankVA]['mId'];
		//$accessToken = getAuthToken($clientId, $clientSecret);

		//$vRef = 'MyRef' . rand(100, 999);


		$data_inquiry = "{
		\"address\":\"\",
		\"amount\":$vJumlah,
		\"bankCode\":\"$vBankCodeVA\",
		\"alias\":\"$vNamaAlias\",
		\"remarks\":\"$vRemark\",
		\"type\":\"va\",
		\"addressName\":\"$vBuyer\",
		\"channelId\":\"$vChannelID\",
		\"refId\":\"$vRef\"
		}";

		$signatureAll = $oActionPay->getSignature($clientId, $clientSecret, $apiSecret, $data_inquiry);
		$signature = $signatureAll['data']['signature'];

		//echo "Signature: $signature <br>";
		//echo "Data Inquiry: ".$data_inquiry."<br>";
		//echo "Access Token: $accessToken <br>";

		$response = $oActionPay->doDeposit($accessToken, $signature, $data_inquiry);
		//echo "Withdraw Confirm Response: ";

		$response = json_encode($response, JSON_PRETTY_PRINT);
		//$response = json_encode($response, JSON_PRETTY_PRINT);
		echo $response;

	
	
} else if ($vOp=='saveva') {
	$vVA = $_POST['va_no'];
	$vAmount = $_POST['va_amount'];
	$vFee = $_POST['va_fee'];
	$vBank = $_POST['va_bank'];
	$vBankCode = $_POST['va_bankcode'];
	$vTrxDate = $_POST['va_trxdate'];
	$vTrxDate = substr($vTrxDate, 0, 19);
	$vTrxDate = str_replace(' ', 'T', $vTrxDate);

	$vCredit = $_POST['va_credit'];
	$vDebit = $_POST['va_debit'];
	$vChannelId = $_POST['va_channelid'];
	$vChannelName = $_POST['va_channelname'];
	$vAddress = $_POST['va_address'];
	$vAddressName = $_POST['va_addressname'];
	$vAddressNameSplit = explode('-', $vAddressName);
	if (count($vAddressNameSplit) > 1 )
		$vRecName = end($vAddressNameSplit);
	$vRefId = $_POST['va_refid'];
	$vBankFee=$oRules->getSettingByField('fbyybank');

	// Check if va_refid already exists
	$vSQLCheck = "SELECT COUNT(*) AS count FROM tb_trx_va WHERE va_refid = '$vRefId'";
	$db->query($vSQLCheck);
	$db->next_record();
	$vCount = $db->f('count');

	$vSQLGetTrx = "select * from tb_trxstok_member_temp where fidpenjualan='$vRefId' ";
	$db->query($vSQLGetTrx);
	$db->next_record();
	$vIdSeller = $db->f('fidseller');

	if ($vCount == 0) {
		// Insert into tb_trx_va
		 $vSQLInsert = "INSERT INTO tb_trx_va (va_no, va_amount, va_fee, va_bank, va_bankcode, va_trxdate, va_credit, va_debit, va_channelid, va_channelname, va_address, va_addressname, va_refid, am_fee) 
					   VALUES ('$vVA', $vAmount, $vFee, '$vBank', '$vBankCode', '$vTrxDate', $vCredit, $vDebit, '$vChannelId', '$vChannelName', '$vAddress', '$vAddressName', '$vRefId','$vBankFee')";
		$vResult = $db->query($vSQLInsert);

		
		
		$vMember = $oJual->getJualField($vRefId,'fidmember');
		$vMailTo = $oMember->getMemFieldBis('femail',$vMember);
		$vMailToName = $oMember->getMemFieldBis('fnama',$vMember);
		$vMailFrom=$oRules->getSettingByField('fmailadmin');
		$vToNumberBuyer = $_POST['va_recnohp'];
		$vToNumberSeller = $oMember->getMemFieldSell('fnohp',$vIdSeller);
		$vNamaSeller = $oMember->getMemFieldSell('fnama',$vIdSeller);

		$vBody = 'Yth. pebisnis' . $vMailToName . ", terima kasih sudah berbelanja di AMH Techno\n\n";
		$vBody .= 'Nomor Order / Pembelian : ' . $vRefId . "\n";
		$vBody .= 'Nama Pembeli Anda : ' . $vRecName . "\n";
		$vBody .= 'No HP Pembeli Anda : ' . $vToNumberBuyer . "\n";
		$vBody .= 'Nomor Virtual Account : ' . $vVA . "\n";
		$vBody .= 'Jumlah Pembayaran : ' . number_format($vAmount,0,',','.') . "\n";
		$vBody .= 'Bank : ' . strtoupper($vBank) . "\n";
		
		$vBody .= 'Bank Code : ' . $vBankCode . "\n\n";
		$vBody .= 'Infokan kepada pembeli Anda, untuk segera selesaikan pembayaran'."\n";
		
		$vBody .= 'Catatan: Total nominal transaksi sudah termasuk admin bank sebesar ' . number_format($vFee,0,',','.') . "\n";

		
		$vBodyBuyer = 'Yth. ' . $vRecName . ", terima kasih sudah berbelanja di AMH Techno melalui pebisnis $vMailToName \n\n";
		$vBodyBuyer .= 'Nomor Order / Pembelian : ' . $vRefId . "\n";
		$vBodyBuyer .= 'Nomor Virtual Account : ' . $vVA . "\n";
		$vBodyBuyer .= 'Jumlah Pembayaran : ' . number_format($vAmount,0,',','.') . "\n";
		$vBodyBuyer .= 'Bank : ' . strtoupper($vBank) . "\n";
		
		$vBodyBuyer .= 'Bank Code : ' . $vBankCode . "\n\n";
		$vBodyBuyer .= 'Segera selesaikan pembayaran Anda'."\n";
		
		$vBodyBuyer .= 'Catatan: Total nominal transaksi sudah termasuk admin bank sebesar ' . number_format($vFee,0,',','.') . "\n";



		$vBodySeller = 'Yth. seller ' . $vNamaSeller . ", ada transaksi pembelian dari pebisnis $vMailToName \n\n";
		$vBodySeller .= 'Anda akan mendapatkan notifikasi berikutnya jika pembeli sudah melakukan pembayaran.';
		
		
		$vBodySeller .= 'Silakan login sebagai seller di web https://intern.amhtechno.com untuk melihat detail transaksi' . "\n";

		if ($vMailTo == '' || $vMailTo == '-')  $vMailTo = 'amhtechs@gmail.com';
		$oSystem->smtpmailerHosting($vMailTo,$vMailToName,$vMailFrom,'AMH Techno',"Pembayaran Virtual Account",$vBody,$oRules->getSettingByField('fmailbcc'),'',false);
		
		$vToNumber = $oMember->getMemFieldBis('fnohp',$vMember);
		if ($vToNumber == '' || $vToNumber == '-')
			$vToNumber = $oRules->getSettingByField('fhpconf');

		//Send WhatsApp message 
		if($vToNumber != '' && $vToNumber != '') {
			//To Pebisnis
			$oSystem->sendWAMessage($vToNumber,$vBody);
			
		}

		//Send WhatsApp to buyer
		if ($vToNumberBuyer != '' && $vToNumberBuyer != '-') {	
			//To Buyer
			$oSystem->sendWAMessage($vToNumberBuyer,$vBodyBuyer);
		}


		//Send WhatsApp to Seller
		if ($vToNumberSeller != '' && $vToNumberSeller != '-') {	
			//To Seller
			$oSystem->sendWAMessage($vToNumberSeller,$vBodySeller);
		}

		if ($vResult) {
			$vArrOut['status'] = 'success';
			$vArrOut['message'] = 'Data berhasil disimpan';
			$vArrOut['data'] = array('mail_to'=>$vMailTo,'mail_body'=>$vBody,'member_id'=>$vMember, 'mail_from'=>$vMailFrom);
		} else {
			$vArrOut['status'] = 'failed';
			$vArrOut['message'] = 'Data gagal disimpan';
		}

		echo json_encode($vArrOut, true);
	}

  } else if ($vOp=='banklist') {
	$clientId = $oRules->getSettingByField('factpayclientid');
	$clientSecret = $oRules->getSettingByField('factpayclientsec');
	$apiSecret = $oRules->getSettingByField('factpayapisec');
	$vNamaAlias = $oRules->getSettingByField('factpaycompname');
	$vBankCode = $oRules->getSettingByField('factpaybankva');
	

	
	$vBankCodeVA = $oRules->getSettingByField('factpaybankva');
	 $data_inquiry = "{
		\"address\":\"-\",
		\"amount\":0,
		\"alias\":\"$vNamaAlias\",
		\"bankCode\":\"$vBankCode\",
		\"remarks\":\"-\",
		\"refId\":\"-\"
	}"; 
	
	$data_inquiry = '';
	
	
	 //$accessToken = getAuthToken($clientId, $clientSecret);
	
	// Get signature
	 $signatureAll = $oActionPay->getSignature($clientId, $clientSecret, $apiSecret, $data_inquiry);
	  $signature = $signatureAll['data']['signature'];
	
	//  echo "Sig: $signature <br>";
	// Example usage
	 $accessToken = $oActionPay->getAuthToken($clientId, $clientSecret);
	
	//echo "Data Inquiry: ".$data_inquiry."<br>";
	
	$response = $oActionPay->depositRoute($accessToken, $signature);

	$bankList = [
		'mandiri'    => 'Virtual Account Bank Mandiri',
		'bri'        => 'Virtual Account Bank BRI',
		'bni'        => 'Virtual Account Bank BNI',
		'cimb_niaga' => 'Virtual Account Bank CIMB Niaga',
		'permata'    => 'Virtual Account Bank Permata',
		'demo'    => 'Virtual Account Bank Demo',
	];

	echo '<option value="">--Pilih--</option>';
	foreach($response['data'] as $key => $value) {
		$vOption='';
		echo $vOption .= '<option value="' . $key . '">' . $bankList[$value['mId']] . '</option>';
		
	}
  }
 

 ?> 

