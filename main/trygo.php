<?
	include("../server/config.php");
	
	function sendSMS($vNoHP,$vMessage,$vUser,$vPass, $pDirect='1'){

//		echo "$vUser:$vPass:$vNoHP:$vMessage";

		global $oDB; 

		//$sms = $vMessage;
		$sms = "Percobaan";

		$sms_final = str_replace(" ","%20",$sms); // setiap ada spasi akan diganti %20

		//$mobilephone=$vNoHP;
    $mobilephone='08123110039';


			if ($pDirect =='2') {//Delay

				$vSQL="INSERT INTO tb_smsbuffer(ftanggal, fcontent, fstatus, fresendtime, fnohp) ";

				$vSQL .= "VALUES (now(), '$vMessage', '$pDirect',null , '$vNoHP');";

				//$oDB->query($vSQL);

			}

		

			$ch = curl_init();

			// set URL and other appropriate options

	//		curl_setopt($ch, CURLOPT_URL, "https://secure.gosmsgateway.com/api/Send.php?username=YouNig&mobile=$mobilephone&message=$sms_final&password=hHjNGsjA");

	//echo "https://secure.gosmsgateway.com/api/Send.php?username=$vUser&mobile=$mobilephone&message=$sms_final&password=$vPass";
	$vAuth = md5('oepetiron'.'O28m61G22?'.'08123110039');
           
         // echo  $vURL = "https://api.gosmsgateway.net/api/sendSMS.php?username=oepetiron&mobile=08123110039&message=Percobaan&auth=$vAuth&trxid=sms0000000002&type=0";
           
         //  $vURL = "https://api.gosmsgateway.net/api/Send.php?username=oepetiron&mobile=08123110039&message=Percobaan&password=O28m61G22?";
            
            echo  $vURL = "https://secure.gosmsgateway.com/masking/api/Send.php?username=oepetiron&mobile=$mobilephone&message=$sms_final&password=O28m61G22?";

			curl_setopt($ch, CURLOPT_URL, $vURL);

			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			curl_setopt($ch, CURLOPT_USERAGENT, 'Verifikasi');

			if ($pDirect=='3')

			   $curlsend =curl_exec($ch);	

			

			// grab URL and pass it to the browser

			if ($pDirect=='1') {

				$curlsend =curl_exec($ch);	

				$vSQL="INSERT INTO tb_smsbuffer(ftanggal, fcontent, fstatus, fresendtime, fnohp,fref) ";

				$vSQL .= "VALUES (now(), '$vMessage', '$pDirect',null , '$vNoHP','$curlsend');";

				//$oDB->query($vSQL);				

			}

					

			curl_close($ch);

			return $curlsend;

		

			

		

	}
	
	echo sendSMS('','','','');

?>
