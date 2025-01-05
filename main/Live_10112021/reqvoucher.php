<?php
class Param {
	   var $PASSWORD='002001';
	   var $UID1='AA0225';
	   var $FMT_ORDER='I5';
	   var $TUJUAN='08563482937';
	   var $ID='12345';
	   var $HDASAR=7000;
	   var $SUPP_IP='180.247.56.70';
	   var $SUPP_PORT='13165';
	   var $SUPP_PATH='/';
	   
	}
class Resp {
	   var $display='';
	   var $status_kode='';
	   var $supTrxId='';
	   var $id='';
	   
	}

class AmhParam extends Param{}
$oAmhParam = new AmhParam;

$oAmhParam->FMT_ORDER=$_GET['kprod'];
$oAmhParam->TUJUAN=$_GET['msis'];
$oAmhParam->ID=$_GET['trxid'];
$vCodeConfirm=$_GET['sig'];
$oAmhParam->COMMAND=$_GET['cmd'];
$vConfirm=md5($oAmhParam->TUJUAN.$oAmhParam->ID);

if ($vConfirm==$vCodeConfirm) {
	$hasil=process($oAmhParam);
	echo  "|".print_r($hasil,true);
} else echo "|Possible Attack";

process($oAmhParam);

function process(Param $P) {
   $R = new Resp();
   /*
     sign1 = waktu
     sign2 = RIGHT(msisdn,4)
     sign3 = StrReverse(RIGHT(msisdn,4))
     sign4 = password
     signature = Base64Encode(EnCryptXOR(sign1+sign2,sign3+sign4))

    */

   $time = date("His");
   $a = $time.substr($P->TUJUAN, -4);
   $b = strrev(substr($P->TUJUAN, -4)).$P->PASSWORD;
   $c = $a ^ $b;
   $sign = base64_encode($c); // atau $sign = $P->PASSWORD;
   $content = "<?xml version=\"1.0\"?>
				<evoucher>
					  <command>TOPUP</command>
					  <product>$P->FMT_ORDER</product>
					  <userid>$P->UID1</userid>
					  <time>$time</time>
					  <msisdn>$P->TUJUAN</msisdn>
					  <partner_trxid>$P->ID</partner_trxid>
					  <signature>$sign</signature>
				</evoucher>";
   //die($content);


    $url = "http://$P->SUPP_IP:$P->SUPP_PORT$P->SUPP_PATH";
  
   $psn = curlPost($url, $content);
 echo  $R->display = $psn;
   

//   header("Content-Type: text/plain");
//   die("URL:$url\r\nREQUEST:\r\n$content\r\n\r\n\r\nRESPONSE:\r\n$psn");

   $pos1 = strpos($psn, "<evoucher>");
   if ($pos1 > -1) {
	  $xml = simplexml_load_string($psn);
      //$pos2 = strpos($psn, "</evoucher>");
      //$psn = substr($psn, $pos1, $pos2 + 11 - $pos1);
      //$xml = simplexml_load_string($psn);
      $res = (String) $xml->result;
      $msg = (String) $xml->msg;
      $trxid = (String) $xml->trxid;
      $partner_trxid = (String) $xml->partner_trxid;
      $R->status_kode = $res;
      $R->supTrxId = $trxid;
      $R->id = $partner_trxid;
      $R->display = $msg;
   }
   return $R;
}

function log_to_file($str, $myFile) {
  $dirs = explode("/", $myFile);
  $dirTmp = "";
  for ($i = 0; $i < (sizeof($dirs) - 1); $i++) {
	 $dirTmp .= $dirs[$i]."/";
	 if (!file_exists($dirTmp)) {
		mkdir($dirTmp);
	 }
  }
  $fh = fopen($myFile, 'w');
  fwrite($fh, $str);
  fclose($fh);
}
function curlPost($url, $content = false, $contentType = "application/text") {
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_REFERER, $url);
   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_TIMEOUT, 600);
   curl_setopt($ch, CURLOPT_VERBOSE, true);
   if ($content) {
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
      $len = strlen($content);
      if ($contentType) {
         curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: $contentType", "Content-length: $len"));
      }//else //application/x-www-form-urlencoded
   }
   if (substr($url, 0, 8) == "https://") {
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
   }

   $psn = curl_exec($ch);
   if ($psn === false) {
      if (curl_errno($ch)) {
         $psn = curl_error($ch);
      }
   } else if (curl_errno($ch)) {
      $psn = curl_error($ch);
   }
   curl_close($ch);

   return trim($psn);
}
