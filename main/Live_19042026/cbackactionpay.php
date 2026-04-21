<?php

/*
[type] => deposit
    [trxId] => e4e127e5-c7e5-480b-82be-e53252d2ec05
    [refId] => J2025041200001
    [trxDate] => 2025-04-12T05:52:00Z
    [status] => completed
    [amount] => 12500.000000
    [fee] => 3500.000000
    [notes] => Pembayaran VA J2025041200001
    [requestTime] => 2025-04-12T05:52:44.911913Z
    */
header('Content-Type: application/json');
include_once('../server/config.php');
include_once("../classes/systemclass.php");
include_once(CLASS_DIR."productclass.php");
include_once(CLASS_DIR."texttoimageclass.php");
include_once(CLASS_DIR."actionpayclass.php");


// Get the raw POST body
$json = file_get_contents('php://input');

// Decode JSON into associative array
$data = json_decode($json, true);
file_put_contents('callback.txt', print_r($data,true) . "\n\n", FILE_APPEND);
if ($data['status']=='completed') {

    $vIdTrx = $data['refId'];
   // include("../manager/approvesellprd.php");
    $vSQL = "update tb_trxstok_member_temp set fpaid='1' where fidpenjualan='$vIdTrx'";
    $db->query($vSQL);
    $vResponse['status'] = '1';
    $vResponse['message'] = 'Transactions succcess';
    $vResponse['data'] = 'N/A';
} else {
    $vResponse['status'] = '0';
    $vResponse['message'] = '0013 - Transactions failed';
    $vResponse['data'] = 'N/A';
}
//print_r($data);
echo json_encode($vResponse, JSON_PRETTY_PRINT);


?>
