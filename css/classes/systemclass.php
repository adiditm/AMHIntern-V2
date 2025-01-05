<?php

  include_once CLASS_DIR."ruleconfigclass.php";    

  class msystem {

  

  function jsAlert($pAlert) {

    echo "<script language='JavaScript'>"; 

	//$pAlert=addslashes($pAlert);

	echo "alert('$pAlert');";

	echo "</script>"; 

  }



  function jsLocation($pURL) {

    echo "<script language='JavaScript'>"; 

	echo "window.location='$pURL';";

	echo "</script>"; 

  }

  

    function jsOpenerLocation($pURL) {

	//echo $pURL;

    echo "<script language='JavaScript'>"; 

	echo "window.opener.location='$pURL';";

	echo "</script>"; 

  }

  

  function jsCloseWin() {

    echo "<script language='JavaScript'>"; 

	echo "window.close();";

	echo "</script>"; 

  }



    function jsWindowClose() {

    echo "<script language='JavaScript'>"; 

	echo "window.close();";

	echo "</script>"; 

  }






 function checkSession($pVarName,$pContent) {
	if ($_SESSION['$pVarName']==$pContent) 
	   return 1;
	else
	   return 0;   
  }


  function checkLogin() {
	if (trim($_SESSION['LoginUser'])=='') 
	   header("Location: ../main/logout.php");
}
  

  function sendMail($pFrom,$pToAddr,$pName,$pBcc,$pSubject,$pMessage,$pSMTP,$pFromName) {

	$from=$pFrom;

	include("../main/mailheader.php");

	$headers.="Bcc: $pBcc\n";

	mail("$pToAddr","$pSubject $pName",$pMessage,$headers);

  }

  

	  //ambil nama admin

	function getAdminName($pID) {

		global $oDB; 

		$vres="";

		$vsql="SELECT fnama from m_admin where fidmember='$pID' ";	

		$oDB->query($vsql);

		while ($oDB->next_record()) {

			$vres = $oDB->f("fnama");

		}

		if ($vres != "")

		   return $vres;

		else

		   return -1;   

	}





	  //ambil nama Outlet

	function getOutletName($pID) {

		global $oDB; 

		$vres="";

		$vsql="SELECT fnama from m_outlet where fidoutlet='$pID' ";	

		$oDB->query($vsql);

		while ($oDB->next_record()) {

			$vres = $oDB->f("fnama");

		}

		if ($vres != "")

		   return $vres;

		else

		   return -1;   

	}

        //check apakah Password cocok

		function authAdminPin($pID,$pPin) {		

            global $oDB; 

			$pID=addslashes($pID);

			$pPass=addslashes($pPin);

			$vres="";			

		    $vsql="SELECT fidmember from m_admin where fidmember='$pID' and fpin='$pPin' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fidmember");

			}

			if ($vres != "")

	  		   return 1;

			else

			   return 0;   

		}



        //Set Password

		function setAdminPass($pNew, $pID) {

            global $oDB, $oSystem; 

			$vres="";

			$pNew=md5($pNew);

		    $vsql="update m_admin set fpassword = '$pNew' where fidmember='$pID' ";	

			$vres=$oDB->query($vsql);

			if ($oDB->affected_rows() > 0) {

	  		   $oSystem->jsAlert("Password changed successfully!");

			   return 1;			   

			} else {

			   $oSystem->jsAlert("Error!, kemungkinan karena : ID Member tidak ada, dan atau password sama dengan yang lama!\n\r Yakinkan ID Member ada atau coba dengan password baru! ");

			   return "Error!, kemungkinan karena : ID Member tidak ada, dan atau password sama dengan yang lama!\n\r Yakinkan ID Member ada atau coba dengan password baru! ";   

			}   

		}



   //Set Password Admin

     function setAdminPassConfirm($pID,$pNewPass,$pConfirm){

     	global $oDB, $oSystem;

		if ($pNewPass==$pConfirm) {

			$this->setAdminPass($pNewPass,$pID);

		} else

		   $oSystem->jsAlert("Konfirmasi salah!");

 	 }



        //ambil Admin password dari ID yang diketahui

		function getAdminPass($pID) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT fpassword from m_admin where fidmember='$pID' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fpassword");

				

			}

			if ($vres != "")

	  		   return $vres;

			else

			   return -1;   

		}

        //check apakah Password admin cocok

		function authAdmin($pID,$pPass) {		

            global $oDB; 

			$pID=addslashes($pID);

			$pPass=addslashes($pPass);

			$vres="";

			$pPass=md5($pPass);

		    $vsql="SELECT fidmember from m_admin where fidmember='$pID' and fpassword='$pPass' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fidmember");

			}

			if ($vres != "")

	  		   return 1;

			else

			   return 0;   

		}



        //check apakah Password admin cocok

		function authAdminNP($pID) {		

            global $oDB; 

			$pID=addslashes($pID);

			$pPass=addslashes($pPass);

			$vres="";

			$pPass=md5($pPass);

		    $vsql="SELECT fidmember from m_admin where fidmember='$pID'  ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fidmember");

			}

			if ($vres != "")

	  		   return 1;

			else

			   return 0;   

		}





        //ambil Privileges Admin dari ID yang diketahui

		function getPriv($pID) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT fpriv from m_admin where fidmember='$pID' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fpriv");

				

			}

			if ($vres != "")

	  		   return $vres;

			else

			   return -1;   

		}



        //ambil Counter

		function getCounter() {

            global $oDB; 

			$vres="";

		    $vsql="select fcounter from tb_counter";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fcounter");

			}

			if ($vres != "")

	  		   return $vres;

			else

			   return -1;   

		}

//Set Counter

		function nextCounter() {

            global $oDB; 

			$vres="";

		    $vsql="update tb_counter set fcounter=fcounter+1";	

			$oDB->query($vsql);

		}



        //ambil User Admin

		function getUserAdmin() {

            global $oDB; 

			$vres[]="";

		    $vsql="select fidmember, fnama from m_admin";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres['fid'][] = $oDB->f("fidmember");

				$vres['fnama'][] = $oDB->f("fnama");

			}

			if ($vres != "")

	  		   return $vres;

			else

			   return -1;   

		}



        //ambil List Menu

		function getUserMenu($pUser,$pPriv) {

            global $oDB; 

			$vres[]="";

			if ($pPriv==false)

		         $vsql="select menu_id,menu_title,fparent from m_menu where is_active=1 and menu_id not in (select menu_id from tb_menupriv where user_id='$pUser') order by fparent ";	

			else

			    $vsql="select b.menu_id,a.menu_title,fparent from m_menu a,tb_menupriv b where a.is_active=1 and a.menu_id=b.menu_id and b.user_id='$pUser' order by fparent ";

					 	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres['fid'][] = $oDB->f("menu_id");

				$vres['fnama'][] = $oDB->f("menu_title");
				$vres['fparent'][] = $oDB->f("fparent");

			}

			if ($vres != "")

	  		   return $vres;

			else

			   return -1;   

		}



        //add Privileges

		function addPriv($pUser,$pMenu) {

            global $oDB; 

			$vsql="insert into tb_menupriv(user_id,menu_id,priv_add,priv_edit,priv_delete,priv_confirm,priv_browse) values('$pUser','$pMenu',true,true,true,true,true)";	

			$oDB->query($vsql);

		}



        //add Privileges

		function delPriv($pUser,$pMenu) {

            global $oDB; 

			$vsql="delete from tb_menupriv where user_id='$pUser' and menu_id='$pMenu'";	

			$oDB->query($vsql);

		}

  

  

        //Check Privilege

		function checkPriv($pUser, $pMenu) {

            global $oDB; 

			$vres="";

		    $vsql="select a.user_id,a.menu_id  from tb_menupriv a, m_menu b where a.user_id='$pUser' and a.menu_id='$pMenu' and a.menu_id=b.menu_id and b.is_active <>0 and a.priv_mod=1";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres= $oDB->f("user_id");

			}

			if ($vres != "")

	  		   return true;

			else

			   return false;   

		}

  

		function smsGateway($pTanggal,$pMSisDN,$pMesgSMS,$pJenis) {

            global $oDB; 

			$vMSISDN=preg_replace("/-1/","6285261359999",$pMSisDN);

			$vMSISDN=preg_replace("/^0/","62",$vMSISDN);

			$vMSISDN=preg_replace("/\s+/","",$vMSISDN);

			if (strlen($vMSISDN) > 13)

			   $vMSISDN="6285261359999";

			

			$vres="";

		    $vsql="insert into tb_smsgw(ftanggal,fmsisdn,fmessage,fjenis) values ('$pTanggal','$vMSISDN','$pMesgSMS','$pJenis')";	

			$oDB->query($vsql);

		}	  

		

		function doED($action, $string) {

			$output = false;

		

			$encrypt_method = "AES-256-CBC";

			$secret_key = 'FITRI';

			$secret_iv = 'FITRI';

		

			// hash

			$key = hash('sha256', $secret_key);

			

			// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning

			$iv = substr(hash('sha256', $secret_iv), 0, 16);

		

			if( $action == 'encrypt' ) {

				$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);

				$output = base64_encode($output);

			}

			else if( $action == 'decrypt' ){

				$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);

			}

		

			return $output;

		}

		

	function getGoto($pURL) {

			$curl = curl_init();

	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

	        curl_setopt($curl, CURLOPT_HEADER, false);

	        curl_setopt($curl, CURLOPT_POST, false);

	        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);

	        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");				

			curl_setopt($curl, CURLOPT_URL, $pURL);

	

	

			$response = curl_exec($curl);

			return $response;

		}

	



		function smtpmailer($to, $from, $from_name, $subject, $body,$bcc='',$bcc2='',$html=true) {

			if (file_exists('../classes/class.phpmailer.php'))

			    require_once('../classes/class.phpmailer.php');

			else	

			    require_once('classes/class.phpmailer.php');

			global $error;

			$mail = new PHPMailer();  

			$mail->IsSMTP(); 

			$mail->SMTPDebug = 0;  // untuk memunculkan pesan error /debug di layar

			$mail->SMTPAuth = true;  // authentifikasi smtp enable atau disable

			$mail->SMTPSecure = ''; // secure transfer membutuhkan authentifikasi dari mail server

			$mail->Host = 'onotoko.co.id'; // masukkan nama host email "diawal ssl://"

			$mail->Port = '587'; //port secure ssl email

			$mail->Username = 'no-reply@onotoko.co.id'; //username email

			$mail->Password = 'j4l4nm4sihp4nj4ng'; //password email

			$mail->SetFrom($from, $from_name);

			$mail->Subject = $subject;

			$mail->Body = $body;

			$mail->AddAddress($to);

			$mail->addBCC($bcc,'BCC');

			$mail->addBCC($bcc2,'BCC');

			$mail->isHTML($html);

			if(!$mail->Send()) {

				$error = 'Mail error: '.$mail->ErrorInfo;

				return false;

			} else {

				$error = 'Message sent!';

				return true;

			}

		}		



		function generateRandomString($length = 6) {

			$characters = '01234567989';

			$charactersLength = strlen($characters);

			$randomString = '';

			for ($i = 0; $i < $length; $i++) {

				$randomString .= $characters[rand(0, $charactersLength - 1)];

			}

			return $randomString;

		}



/*

	function sendSMS($pNumber,$pMessage) {

		    global $oRules;

			$vDevId=$oRules->getSettingByField('fidsmsgw');

			$vEmailGw=$oRules->getSettingByField('fmailsmsgw');

			$vPassGw=$oRules->getSettingByField('fpwdsmsgw');

			if (file_exists('../classes/smsGateway.php'))

			    require_once('../classes/smsGateway.php');

			else	

			    require_once('xsystem/classes/smsGateway.php');



		 // include_once("../classes/smsGateway.php");

		$smsGateway = new SmsGateway($vEmailGw, $vPassGw);

	

		$options = array(

			'send_at' => strtotime('+0 minutes'), // Send the message in 10 minutes

			'expires_at' => strtotime('+12 hour') // Cancel the message in 1 hour if the message is not yet sent

		);

	

		//Please note options is no required and can be left out

		$result = $smsGateway->sendMessageToNumber($pNumber, $pMessage, $vDevId, $options);

		//print_r($result);		

		return $result;

	}

	*/

	

	function sendSMS($vNoHP,$vMessage,$vUser,$vPass){

//		echo "$vUser:$vPass:$vNoHP:$vMessage";

		$sms = $vMessage;

		$sms_final = str_replace(" ","%20",$sms); // setiap ada spasi akan diganti %20

		$mobilephone=$vNoHP;

		$ch = curl_init();

		// set URL and other appropriate options

//		curl_setopt($ch, CURLOPT_URL, "https://secure.gosmsgateway.com/api/Send.php?username=YouNig&mobile=$mobilephone&message=$sms_final&password=hHjNGsjA");

//echo "https://secure.gosmsgateway.com/api/Send.php?username=$vUser&mobile=$mobilephone&message=$sms_final&password=$vPass";

		curl_setopt($ch, CURLOPT_URL, "https://secure.gosmsgateway.com/masking/api/Send.php?username=$vUser&mobile=$mobilephone&message=$sms_final&password=$vPass");

		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($ch, CURLOPT_USERAGENT, 'Verifikasi');

		

		// grab URL and pass it to the browser

		$curlsend =curl_exec($ch);		

		curl_close($ch);

		return $curlsend;

	}

	

       //Insert Access Log

		function insertLog() {

            global $oDB ;

			$vres="";

		    $vsql="delete from tb_accesslog where ftime < date_sub(now(),interval 2 month) ";	

			$oDB->query($vsql);

			$vIPAddress=$_SERVER['REMOTE_ADDR'];

			$vHost=gethostbyaddr($vIPAddress);

			$vScript=$_SERVER['REQUEST_URI'];

		    $vsql="insert into tb_accesslog(ftime,fipaddress,fhost,fscript) values(now(),'$vIPAddress','$vHost','$vScript') ";	

			$oDB->query($vsql);

		}

		

		

		function strEscape($value){

			$search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");

			$replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");

		

			return str_replace($search, $replace, $value);

		}



    //Sync Korwil
		function syncKorwil() {
            global $oDBAMHT, $oDB; 
			$vres="";
		     $vsql="SELECT * from tmmember   ";	
			$oDBAMHT->query($vsql);
			//print_r($oDBAMHT);
			//exit;
			//echo $oDBAMHT->num_rows();
			$vMsgAll.="<html><head><title>Sync Pebisnis </title></head><body>\n";
			while ($oDBAMHT->next_record()) {
			     $vKode = $oDBAMHT->f("kode");	
				$vNama = $oDBAMHT->f("nama");	
				 $vNama =  str_replace("'","''",$vNama);
				$vAlamat = $oDBAMHT->f("jalamat");
				$vHP = $oDBAMHT->f("jhandphone");
				$vBank = $oDBAMHT->f("bank");
				$vNorek = $oDBAMHT->f("nomorrek");
				$vAtasNama = $oDBAMHT->f("namarek");
				$vAtasNama =  str_replace("'","''",$vAtasNama);
				$vEmail = $oDBAMHT->f("jemail");
				$vTanggal = $oDBAMHT->f("tanggal");
			//	
				//exit;
				$vSQL ="select fidmember from m_pebisnis where fidmember='$vKode' ";
				$oDB->query($vSQL);
				$oDB->next_record();
				if ($oDB->num_rows() <=0) {
				
				$vSQLIn= "INSERT INTO m_pebisnis( fidmember, frefer, fnama, fnohp, fnamabank, fnorekening, fatasnama, falamat, fcountry, fprop, fkota, fkec, femail, faktif, ftglaktif, fnoktp, fket) ";
				$vSQLIn .=" VALUES  ('$vKode', '$vKode', '$vNama', '$vHP', '$vBank', '$vNorek', '$vAtasNama', '$vAlamat', 'ID','','','', '$vEmail', '1', '$vTanggal', '', '');";
					
				 $oDB->query($vSQLIn);
				  $vMsg="Reference $vKode inserted!<br>\n";	
				 $vMsgAll .=$vMsg;
				 
				} else {
					 $vMsg="Reference $vKode already exists, no action taken!<br>\n";	
					$vMsgAll .=$vMsg;
				    
				}
			}
				 $vMsg="</body></html>";
				
				 return  $vMsgAll .= $vMsg;					
								

		}	
} //Class

 $oSystem=new msystem;



?>
