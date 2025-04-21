<?php
$vResi = $_GET['noresi'];

$vKind = "Penjualan";

$db->query("START TRANSACTION;");

$vSQL = "select sum(fsubtotal) as ftotal from tb_trxstok_member_temp where fidpenjualan='$vIdTrx' ";
$dbin->query($vSQL);
$dbin->next_record();
$vTotal = $dbin->f('ftotal');

$vSQL = "select fongkir from tb_trxstok_member_temp where fidpenjualan='$vIdTrx' ";
$dbin->query($vSQL);
$dbin->next_record();
$vOngkir = $dbin->f('fongkir');

$vSQL = "insert into tb_trxstok_member( `fidpenjualan`, `fidseller`, `fidmember`, `falamatkrm`, `fnostockist`, `fidproduk`, `fjumlah`, `ftanggal`, `fhargasat`, `fsubtotal`, `fsize`, `fcolor`, `ftgltrans`, `fjenis`, `fjmltrans`, `fserial`, `fpin`, `fmethod`, `fketerangan`, `ftglentry`, `fprocessed`, `ftglprocessed`, `fongkir`, `fberat`, `fcountry`, `fprop`, `fkota`, `fkec`, `fexpe`, `fpack`, `frecname`, `frecnohp`) ";
$vSQL .= "select `fidpenjualan`, `fidseller`, `fidmember`, `falamatkrm`, `fnostockist`, `fidproduk`, `fjumlah`, `ftanggal`, `fhargasat`, `fsubtotal`, `fsize`, `fcolor`, `ftgltrans`, `fjenis`, `fjmltrans`, `fserial`, `fpin`, `fmethod`, `fketerangan`, `ftglentry`, `fprocessed`, now(), `fongkir`, `fberat`, `fcountry`, `fprop`, `fkota`, `fkec`, `fexpe`, `fpack`, `frecname`, `frecnohp` from tb_trxstok_member_temp where fidpenjualan='$vIdTrx' ";

if ($db->query($vSQL)) {
    $vSQLSelect = "select * from tb_trxstok_member_temp where fidpenjualan='$vIdTrx' ";
    $dbin->query($vSQLSelect);

    while ($dbin->next_record()) {
        $vIdMem = $dbin->f('fidmember');
        $vIDProduk = $dbin->f('fidproduk');
        $vAmount = $dbin->f('fjumlah');
        $vSeller = $dbin->f('fidseller');
        $vIDOutlet = $dbin->f('fnostockist');
        $vMethod = $dbin->f('fmethod');

        $vLastBal = $oMember->getStockPosUnig($vSeller, $vIDProduk);
        $vNewBal = $vLastBal - $vAmount;

        $vSQL = "UPDATE `tb_stok_position` set fdesc='Penjualan $vIdTrx', fkind='RO', fbalance=fbalance-$vAmount where `fidmember`='$vSeller' and fidproduk='$vIDProduk' ";
        $db->query($vSQL);

        $vSQL = "INSERT INTO `tb_mutasi_stok` (`fidmember`, `fidproduk`, `fsize`, `fcolor`, `fidfunder`, `ftanggal`, `fdesc`, `fcredit`, `fdebit`, `fbalance`, `fkind`, `fstatus`, `flastuser`, `flastupdate`, `fref`) ";
        $vSQL .= "VALUES ('$vSeller', '$vIDProduk', NULL, NULL, '', now(), 'RO Sales [$vIdMem]', $vAmount, 0, $vNewBal, 'JRO', '1', '$vSeller', now(), '$vIdTrx');";
        $db->query($vSQL);

        $oMember->setSaldoStockWH($vSeller, $vIDProduk, $vNewBal, $db);
    }

    $vSQL = "update tb_trxstok_member set fketerangan=concat(fketerangan, ', Ket: $vResi') where fidpenjualan='$vIdTrx'";
    $db->query($vSQL);

    $vSQL = "delete from tb_trxstok_member_temp where fidpenjualan='$vIdTrx' ";
    $db->query($vSQL);

    // Mutasi Si member
    $vUserTrx = $vIdMem;
    $vBuyer = $vIdMem;
    $vNextJual = $vIdTrx;

    $vIDMember = $oJual->getMemberByJual($vIdTrx);
    $vJumlah = $oJual->getBuyedTot($vIdTrx);

    echo 'successappv';
}

$db->query("COMMIT;");
?>