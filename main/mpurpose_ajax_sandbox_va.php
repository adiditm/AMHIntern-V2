<?php
session_start();

include_once("../server/config.php");
include_once("../classes/ruleconfigclass.php");

$vOp = $_GET['op'];

function sandbox_json_response($payload) {
    echo json_encode($payload, JSON_PRETTY_PRINT);
    exit;
}

if ($vOp == 'generateva') {
    $vAmount = isset($_POST['amount']) ? (float)$_POST['amount'] : 0;
    $vRef = isset($_POST['ref']) ? trim($_POST['ref']) : '';
    $vBuyer = isset($_POST['buyer']) ? trim($_POST['buyer']) : '';
    $vBankVA = isset($_POST['bankva']) ? trim($_POST['bankva']) : 'demo';

    if ($vAmount <= 0 || $vRef == '') {
        sandbox_json_response(array(
            'status' => '9999',
            'message' => 'Invalid sandbox VA request',
            'data' => array()
        ));
    }

    $vGatewayFee = (float)$oRules->getSettingByField('ffeeactpay');
    if ($vGatewayFee < 0) {
        $vGatewayFee = 0;
    }

    $vAddressName = $vBuyer != '' ? $vBuyer : 'Aminah';
    $vVASeed = preg_replace('/\D+/', '', $vRef);
    if ($vVASeed == '') {
        $vVASeed = date('YmdHis');
    }
    $vAddress = '900' . substr(str_pad($vVASeed, 9, '0', STR_PAD_LEFT), -9);
    $vTrxDate = date('Y-m-d H:i:s');
    $vCreditAmount = $vAmount - $vGatewayFee;
    if ($vCreditAmount < 0) {
        $vCreditAmount = 0;
    }

    $vChannelMap = array(
        'mandiri' => array('channelId' => 'sandbox-mandiri', 'channelName' => 'va - mandiri demo', 'bankCode' => 'mandiri'),
        'bri' => array('channelId' => 'sandbox-bri', 'channelName' => 'va - bri demo', 'bankCode' => 'bri'),
        'bni' => array('channelId' => 'sandbox-bni', 'channelName' => 'va - bni demo', 'bankCode' => 'bni'),
        'cimb_niaga' => array('channelId' => 'sandbox-cimb', 'channelName' => 'va - cimb demo', 'bankCode' => 'cimb_niaga'),
        'permata' => array('channelId' => 'sandbox-permata', 'channelName' => 'va - permata demo', 'bankCode' => 'permata'),
        'demo' => array('channelId' => '8f564234-bcd4-41e4-aa52-3b1abe6bd28b', 'channelName' => 'va - demo', 'bankCode' => 'demo')
    );

    $vChannel = isset($vChannelMap[$vBankVA]) ? $vChannelMap[$vBankVA] : $vChannelMap['demo'];

    sandbox_json_response(array(
        'status' => '0001',
        'message' => 'Success Generate VA Sandbox',
        'data' => array(
            'address' => $vAddress,
            'totAmount' => $vAmount,
            'feeAmount' => $vGatewayFee,
            'trxDate' => $vTrxDate,
            'creditAmount' => $vCreditAmount,
            'debitAmount' => $vAmount,
            'bankCode' => $vChannel['bankCode'],
            'channelId' => $vChannel['channelId'],
            'channelName' => $vChannel['channelName'],
            'addressName' => $vAddressName,
            'refId' => $vRef
        )
    ));
}

sandbox_json_response(array(
    'status' => '9999',
    'message' => 'Unsupported sandbox operation',
    'data' => array()
));
