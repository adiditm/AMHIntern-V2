<?php  
error_reporting(E_ALL);
date_default_timezone_set('Asia/Jakarta');

include_once "../server/config.php";

include_once "../classes/ruleconfigclass.php";

include_once "../classes/memberclass.php";

include_once "../classes/systemclass.php";

include_once "../classes/jualclass.php";

include_once "../classes/komisiclass.php";

include_once "../classes/ifaceclass.php";

include_once "../classes/dateclass.php";

include_once "../classes/networkclass.php";
include_once "../classes/antaclass.php";
include_once("../classes/pulsaclass.php");


require_once('../classes/PHPMailerAutoload.php');



//echo str_pad(33333, 5, '0', STR_PAD_LEFT);

//echo $oJual->getNextIDJual();



//echo $_SERVER['HTTPS'];

//getDownlineByPaket($pID,&$vout,$pStart,$pEnd,$pPaket)

//echo "ssssssssss";

//$oNetwork->getDownlineByPaket('UFC203110441',$Hasil,'2015-10-15','2015-10-15','B');

//print_r($Hasil);



//$a=$oKomisi->getPoint('UEC518118195','2016-02-01','2016-03-29');

//print_r($a);

 //$oNetwork->sendFeeCouple('dodolan',135000,$db);

// echo $vRoMaMonth = 	$oKomisi->getROMaMonth('nex001',2016, 8);

//echo $OmzetDownL=$oNetwork->getDownlineCountActivePeriod('nex002','2016-08-25','2016-08-25');

//echo $oRules->getSettingByField('fbonusro');

//echo date('H:i:s');

//$oSystem->smtpmailer("a_didit_m@yahoo.com","jerry@gmail.com","Jerry","Test Cron ".date('Y-m-d H:i:s'),"Body aja");

//echo date('Y-m-d H:i:s');

 //$vIsiSMS = $oRules->getSettingByField('fsmsreg');

 /*$vIsiSMS = $oRules->getSettingByField('fsmsbonusb');



	 	 $vIsiSMS=str_replace("{MEMID}","SMS9892893TY",$vIsiSMS);

		$vIsiSMS=str_replace("{PASSWD}",'111111',$vIsiSMS);

		$vIsiSMS=str_replace("{BONUSB}",'300.000',$vIsiSMS);

	echo	 $vIsiSMS=str_replace("{MEMNAME}","SUMEDANG LARANG",$vIsiSMS);





$a=$oSystem->sendSMS('08563482937', $vIsiSMS);

print_r($a);



*/



//echo $vLastBal = $oMember->getStockPosUnig('headoffice','P003');

 // echo $oJual->getKITNom('UNSCM5HCICUM');

// echo $oKomisi->getBonusAByDate('COBA1','2017-10-26 08:19:34','2017-10-26 08:19:34');

// echo $oInterface->getMenuContent('slider2text1');

 // $oKomisi->insertSpon('1703-0000-0590','4','REQ','JU-2020010090');

/* $sms = "Selamat. Permohonan kredit manuk anda telah kami setujui.Terima kasih.(PT.BEP)";

$sms_final = str_replace(" ","%20",$sms); // setiap ada spasi akan diganti %20

$mobilephone="628124110039";

$ch = curl_init();

// set URL and other appropriate options

curl_setopt($ch, CURLOPT_URL, "https://secure.gosmsgateway.com/masking/api/Send.php?username=YouNig&mobile=$mobilephone&message=$sms_final&password=hHjNGsjA");

curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($ch, CURLOPT_USERAGENT, 'Verifikasi');



// grab URL and pass it to the browser

$curlsend =curl_exec($ch);

print_r($curlsend);*/

//echo  $oSystem->sendSMS("62816562359",$sms_final,'YouNig','hHjNGsjA');;

// $vDateCompile='2018-03-01';

//echo $vLastDateMonth = $oMydate->dateSub($vDateCompile,1,'month'); 



// $oNetwork->sendFeeTitikCompress('YOUNIG15',20,1,'J2018092700001');
//echo $vExisting = $oMember->isExistPay('angs1','JU-2019050002');
//$oSystem->syncKorwil();
//echo $oSystem->doED('encrypt','asdf4321');

 /* echo $vRet= $oSystem->syncKorwil();
  
   $vFileName='../files/SyncPebisnis'.date('Y-m-d_H.i.s').'.htm';

   $fp=fopen($vFileName,'w',true);

   fputs($fp,$vRet,10000000);

   fclose($fp);		*/
 /*
   
   $vUserAnta =$oRules->getSettingByField('fantauser');
  $vPassAnta = $oRules->getSettingByField('fantapass');
   $vData = array("customer_id"=>$vMsisdn,'username'=>$vUserAnta,'password'=>$vPassAnta,'code'=>'','type'=>'','request_id'=>'AUH2HLQIfSXAd');
				 echo $vResult=$oPulsa->genPost("https://antautama.co.id/api_pulsa/prabayar/cek_prabayar.php",$vData,'');
				   
*/
/*
function sendEmail($toEmail, $toName, $subject, $body, $altBody = '') {
  $mail = new PHPMailer(true);

  try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'amhtechno.com'; // Replace with your SMTP server
    $mail->SMTPAuth   = true;
    $mail->Username   = 'no-reply@amhtechno.com'; // Replace with your SMTP username
    $mail->Password   = 'N4siEn4k'; // Replace with your SMTP password
    $mail->SMTPSecure = 'ssl';
       
    $mail->Port       = 465; // Adjust as needed (usually 587 or 465)
    $mail->SMTPDebug = 1;
    $mail->SMTPOptions = array(
      'ssl' => array(
          'verify_peer' => false,
          'verify_peer_name' => false,
          'allow_self_signed' => true
      )
    );
    // Recipients
    $mail->setFrom('no-reply@amhtechno.com', 'AMH Techno');
    $mail->addAddress($toEmail, $toName); // Add a recipient

    // Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $body;
    $mail->AltBody = $altBody; // Optional plain-text alternative body

    // Send the email
    $mail->send();
    echo 'Message has been sent';
    return true;
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    return false;
  }
}
*/

 $oSystem->smtpmailerHosting('a_didit_m@yahoo.com','Didiet','info@aminahtour.co.id','AMH Techno','Percobaan Yahoo',"Pembayaran Virtual Account",'adiditm@gmail.com','',false,1);
 
?>
