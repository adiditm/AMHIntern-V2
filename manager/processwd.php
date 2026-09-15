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

function amhGetWithdrawAccountJenis($oMember, $pId)
{
    if ($oMember->authSell($pId) == 1)
        return 'seller';
    if ($oMember->authKor($pId) == 1)
        return 'korwil';
    return 'sponsor';
}

$vIDJual = $_GET['uIDJual'];
$vAdmin = $_SESSION['LoginUser'];
$vRever = $_GET['uSess'];
$vReverCancel = $_GET['uCanc'];
$vCheck = md5('jalanku');
$vCancel = md5('bataldeh');
$vIssued = md5('issued');
$vMember = $_GET['uUserID'];
$vUser = $vMember;
$vRef = $_GET['ref'];
$vMonth = date("m");
$vYear = date("Y");
$vNoHP = $oMember->getNoHP($vUser);

if ($vReverCancel == $vCancel) { // Cancel
    $oSystem->jsAlert("Withdraw $vIDJual Cancelled");
    $vsql = "update tb_withdraw set fstatusrow=4, ftglappv=now(), fadmin='$vAdmin' where fidwithdraw='$vIDJual'";
    $db->query($vsql);
    $oSystem->jsLocation("../manager/veriwith.php");
}

if ($vRever == $vCheck && $_SESSION['LoginUser'] != "" && $vReverCancel == "") {

    $vJenisWD = amhGetWithdrawAccountJenis($oMember, $vMember);

    if ($vJenisWD == 'seller')
        $vEmail = $oMember->getMemFieldSell('femail', $vMember);
    else
        $vEmail = $oMember->getMemFieldBis('femail', $vMember);
    if ($vEmail == -1 || empty($vEmail)) $vEmail = $oRules->getMailFrom();
    $vNama = $oMember->getMemberNameAdm($vMember, $vJenisWD);

    $vFrom = $oRules->getMailFrom();
    $vIsiAct = "Withdrawal $vRef Anda sudah diproses";
    $vMessage = "$vNama, $vIsiAct  \n\n";
    $vMessage .= "Terima kasih atas Withdrawal Anda.\n\n";
    $vSMTP = $oRules->getSettingByField('fsmtp');

    // Approval manual - langsung proses mutasi & status database tanpa payment gateway
    $db->query("start transaction;");
    $vResWD = $oJual->processWD($vIDJual, $vAdmin, $db);

    if ($vResWD) {
        $db->query("commit");

        $vMailFrom = $oRules->getSettingByField('fmailadmin');
        if ($vMailFrom == -1 || empty($vMailFrom)) $vMailFrom = 'amhtechs@gmail.com';
        $vNomWD = number_format($oJual->getNomByWD($vIDJual), 0, ",", ".");
        $oSystem->smtpmailer($vEmail, $vMailFrom, 'AMHIntern', 'Withdraw Approval', "Withdraw ID $vIDJual sebesar $vNomWD sudah diproses secara manual, terima kasih!", "amhtechs@gmail.com", "", true);

        $oSystem->jsAlert("Withdrawal $vRef Processed!");
    } else {
        $db->query("rollback");
        $oSystem->jsAlert("Withdrawal $vRef gagal diproses atau sudah pernah diapprove sebelumnya!");
    }

    $oSystem->jsLocation("../manager/veriwith.php");
}

$oSystem->jsLocation("../manager/veriwith.php");
?>
