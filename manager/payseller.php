<?php

session_start();

$vRefer = $_SERVER['HTTP_REFERER'];
$vQString = $_SERVER['QUERY_STRING'];

include_once "../server/config.php";
include_once CLASS_DIR . "systemclass.php";
include_once CLASS_DIR . "networkclass.php";
include_once "../classes/jualclass.php";
include_once CLASS_DIR . "komisiclass.php";
include_once "../classes/memberclass.php";
include_once CLASS_DIR . "actionpayclass.php";

$vIDJual = $vIdTrx; //Dari processing_ajax.php approvesell(includer file)
$vAdmin = $_SESSION['LoginUser'];
$vRever = $vSellSession;

$vCheck = md5('jalanku');
$vMember = $vIdMem;
$vUser = $vMember;
$vRef = $_GET['ref'];
$vMonth = date("m");
$vYear = date("Y");
$vNoHP = $oMember->getMemFieldBis('fnohp',$vUser);
$vNoHPSeller = 
$vEmailSeller = 
$vRekSeller =



if ($vRever == $vCheck && $_SESSION['LoginUser'] != "" && $vReverCancel == "") {//Approve

   
    //Email dan Pebinis
    $vEmail = $oMember->getMemFieldBis('femail',$vMember);
    if ($vEmail == -1) $vEmail = $oRules->getMailFrom();
    $vNama = $oMember->getMemFieldBis('fnama',$vMember);

    
    $vFrom = $oRules->getMailFrom();
    $vIsiAct = "Transaksi $vIdTrx Anda sudah diproses!";
    $vMessage = "$vNama, $vIsiAct  \n\n";
    $vMessage .= "Terima kasih atas transaksi Anda.\n\n";
    $vSMTP = $oRules->getSettingByField('fsmtp');

    //Payment Gateway
   

    // Replace with your actual client ID and secret
    $clientId = $oRules->getSettingByField('factpayclientid');
    $clientSecret = $oRules->getSettingByField('factpayclientsec');
    $apiSecret = $oRules->getSettingByField('factpayapisec');
    $vNorek = $oMember->getMemFieldBis('fnorekening',$vMember);
    $vJumlah = $oJual->getNomByWD($vIDJual);
    $vNamaAlias = $oMember->getMemFieldBis('fatasnama',$vMember);
    $vBankCode = $oMember->getMemFieldBis('fnamabank',$vMember);
    $vRemark = $oJual->getJualField($vIDJual, "fket");
    $vRefX = $vIDJual;

    $data_inquiry = "{
        \"address\":\"$vNorek\",
        \"amount\":$vJumlah,
        \"alias\":\"$vNamaAlias\",
        \"bankCode\":\"$vBankCode\",
        \"remarks\":\"$vRemark\",
        \"refId\":\"$vRefX\"
    }"; 



    // Get the access token
    //$accessToken = getAuthToken($clientId, $clientSecret);

    // Get signature
    $signatureAll = $oActionPay->getSignature($clientId, $clientSecret, $apiSecret, $data_inquiry);
    $signature = $signatureAll['data']['signature'];

    //  echo "Sig: $signature <br>";
    // Example usage
    $accessToken = $oActionPay->getAuthToken($clientId, $clientSecret);

    //echo "Data Inquiry: ".$data_inquiry."<br>";

    $response = $oActionPay->withdrawInquiry($accessToken, $signature, $data_inquiry);
   // echo "Withdraw Inquiry Response: ";
  //  print_r($data_inquiry); echo "<br>";
    if (is_array($response)) {
        $vFeeBank = $response['data']['fees'][0]['feeamount'];
        //Start Confirm
        $vRefX = $vIDJual.'_Confirm_'.rand(100, 999);
        $data_inquiry = "{
            \"address\":\"$vNorek\",
            \"amount\":$vJumlah,
            \"alias\":\"$vNamaAlias\",
            \"bankCode\":\"$vBankCode\",
            \"remarks\":\"$vRemark\",
            \"refId\":\"$vRefX\"
        }"; 

        $signatureAll = $oActionPay->getSignature($clientId, $clientSecret, $apiSecret, $data_inquiry);
        $signature = $signatureAll['data']['signature'];

        $response_c = $oActionPay->withdrawConfirm($accessToken, $signature, $data_inquiry);
       // print_r($response_c); echo "<br>";
       // exit;
        if (is_array($response_c) && $response_c['status']=='0001') {
                $vStatus = $response_c['status'];
                $vMessage = $response_c['message'];
                $vRefSuccess = $response_c['data']['trxId'];
                $vRefDate = substr($response_c['data']['trxDate'],0,10);
                //echo "Withdraw Confirm Response: ";
                $vResponse=print_r($response_c, true);


                $vEndap = $oRules->getSettingByField('fmindap');
                $vSaldoBis = $oKomisi->getLastBalanceBis($vMember);
                $vNomWDO=$oJual->getNomByWD($vIDJual);
                $vNomWD=number_format($oJual->getNomByWD($vIDJual),0,",",".");
                if ($vSaldoBis >= ($vFeeBank + $vEndap)){
                        $db->query("start transaction;");
                        $oJual->processWD($vIDJual, $vAdmin, $db);
                        //Fee
                        $vKet=$oJual->getDescByWD($vIDJual);
                        $vDesc="Withdraw  Fee ($vKet)";
                        $vLastBal=$vSaldoBis - $vNomWDO;
                        $vBal=$vLastBal-$vFeeBank ;
                        $oKomisi->insertMutasiConn($vMember,$vMember,date("Y-m-d H:i:s"),$vDesc,0,$vFeeBank ,$vBal,'withdraw',$vIDJual,$db) ;
                        $oMember->changeBalBisConn($vMember,$vFeeBank ,'D',$db);
                        
            
                        
                    
                    
                        // $oSystem->sendMail($vFrom, $vEmail, $vNama, $oRules->getMailBCC(), $oRules->getSubjAct(), $vMessage, $vSMTP);
                    //  $oSystem->smtpmailer('a_didit_m@yahoo.com', $vFrom, 'Aminah Tour', "Withdraw Approval", 'Withdraw sudah diproses, terima kasih!', '', '', false);
                        $vMailFrom=$oRules->getSettingByField('fmailadmin');
                        $oSystem->smtpmailer($vEmail,$vMailFrom,'AMHIntern','Withdraw Approval',"Withdraw ID $vIDJual sebesar $vNomWD sudah diproses, terima kasih!","amhtechs@gmail.com","",true);
            
                        $vResponse = str_replace("'","''",$vResponse);
                        $vSQL = "update tb_withdraw set fpaylog='$vResponse', fnoteadm='$vRefSuccess' where fidwithdraw='$vIDJual'";
                        $db->query($vSQL);
                    
            
                        $vMesgSMS = "$vNama, Withdrawal Anda ID $vIDJual sudah diapprove!";
                        $vNoHP = $oMember->getNoHP($vID);
                        $db->query("commit");
            
                        // $oSystem->smsGateway(date("Y-m-d H:i:s"), preg_replace("/^0/", "62", $vNoHP), $vMesgSMS, 'Aktifasi Investasi');
            
                        // $oSystem->jsAlert($vEmail);
                        $oSystem->jsAlert("Withdrawal $vRef Processed!");
                }  else  $oSystem->jsAlert("Withdrawal $vRef approval gagal, saldo tidak cukup untuk withdraw + biaya admin!"); //saldo tidak cukup
        } else {//response_c
            $oSystem->jsAlert("Withdrawal $vRef approval gagal, problem payment gateway (".$response_c['message'].")!"); 
        
        }
    
         
    } //response inquiry
} //operation

    
    $oSystem->jsLocation("../manager/veriwith.php");


?>