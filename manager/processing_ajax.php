<?php
include_once "../server/config.php";
include_once CLASS_DIR . "networkclass.php";

// Tidak harus include, untuk membantu saat coding saja
include_once "../classes/memberclass.php";
include_once "../classes/komisiclass.php";
include_once "../classes/networkclass.php";
include_once "../classes/ruleconfigclass.php";
include_once "../classes/jualclass.php";

function amhGetTrxReceiveField($dbConn)
{
	$vReceiveFields = array('freceived', 'freceive');
	foreach ($vReceiveFields as $vFieldName) {
		$vHasTemp = false;
		$vHasMain = false;
		$vSQLCheckField = "SHOW COLUMNS FROM tb_penjualan_temp LIKE '$vFieldName'";
		$dbConn->query($vSQLCheckField);
		if ($dbConn->next_record())
			$vHasTemp = true;
		$vSQLCheckField = "SHOW COLUMNS FROM tb_penjualan LIKE '$vFieldName'";
		$dbConn->query($vSQLCheckField);
		if ($dbConn->next_record())
			$vHasMain = true;
		if ($vHasTemp && $vHasMain)
			return $vFieldName;
	}
	return '';
}

function amhGetSellerDisplayName($pSellerId) {
	global $oMember, $dbin;
	$vId = trim((string)$pSellerId);
	if ($vId === '')
		return '';
	$vIdEsc = addslashes($vId);
	$dbin->query("select trim(ifnull(fnama,'')) as fnama from m_seller where fidseller='$vIdEsc' limit 1");
	if ($dbin->next_record()) {
		$vName = trim((string)$dbin->f('fnama'));
		if ($vName !== '' && $vName !== '-1')
			return $vName;
	}
	$vName = trim((string)$oMember->getMemFieldSell('fnama', $vId));
	if ($vName !== '' && $vName !== '-1')
		return $vName;
	return $vId;
}

function amhGetSellerPhoneFromDb($dbConn, $pSellerId) {
	$vId = addslashes(trim((string)$pSellerId));
	if ($vId === '')
		return '';
	$dbConn->query("select trim(ifnull(fnohp,'')) as fnohp from m_seller where fidseller='$vId' limit 1");
	if (!$dbConn->next_record())
		return '';
	$vHp = trim((string)$dbConn->f('fnohp'));
	if ($vHp === '' || $vHp === '-' || $vHp === '-1')
		return '';
	return $vHp;
}

function amhLoadJualTrxHeaderForWa($dbConn, $pTrxId) {
	$vId = addslashes(trim((string)$pTrxId));
	if ($vId === '')
		return null;
	$vTables = array('tb_penjualan_temp', 'tb_penjualan');
	foreach ($vTables as $vTbl) {
		$dbConn->query("select fidmember, fidseller, ifnull(frecname,'') as frecname from $vTbl where fidpenjualan='$vId' limit 1");
		if ($dbConn->next_record()) {
			return array(
				'fidmember' => trim((string)$dbConn->f('fidmember')),
				'fidseller' => trim((string)$dbConn->f('fidseller')),
				'frecname' => trim((string)$dbConn->f('frecname')),
				'table' => $vTbl,
			);
		}
	}
	return null;
}

function amhBuildJualItemSummary($pTrxId, $dbConn, $pTable = 'tb_penjualan') {
	$vTrx = addslashes(trim((string)$pTrxId));
	$vTable = ($pTable === 'tb_penjualan_temp') ? 'tb_penjualan_temp' : 'tb_penjualan';
	$vLines = array();
	$vItemInline = array();
	$vTotQty = 0;
	$vSQL = "select a.fidproduk, a.fjumlah, ifnull(b.fnamaproduk, a.fidproduk) as fnama
		from $vTable a left join m_product b on a.fidproduk=b.fidproduk
		where a.fidpenjualan='$vTrx' order by a.fidproduk";
	$dbConn->query($vSQL);
	while ($dbConn->next_record()) {
		$vQty = (float)$dbConn->f('fjumlah');
		$vTotQty += $vQty;
		$vNama = trim($dbConn->f('fnama'));
		$vQtyFmt = number_format($vQty, 0, ',', '.');
		$vLines[] = $vNama . ' (' . $vQtyFmt . ' pcs)';
		$vItemInline[] = $vNama . ', jumlah : ' . $vQtyFmt;
	}
	return array(
		'qty' => $vTotQty,
		'qty_fmt' => number_format($vTotQty, 0, ',', '.'),
		'detail' => implode("\n", $vLines),
		'item_inline' => implode('; ', $vItemInline),
	);
}

function amhSendApproveSellCompletedWA($pTrxId, $pPebisnisId, $pSellerId) {
	global $oSystem, $oMember, $dbin;
	$vTrxId = trim((string)$pTrxId);
	$vPebisnisId = trim((string)$pPebisnisId);
	$vSellerId = trim((string)$pSellerId);
	if ($vTrxId === '')
		return;

	$vItems = amhBuildJualItemSummary($vTrxId, $dbin);
	$vNamaPebisnis = trim((string)$oMember->getMemFieldBis('fnama', $vPebisnisId));
	if ($vNamaPebisnis === '' || $vNamaPebisnis === '-1')
		$vNamaPebisnis = $vPebisnisId;
	$vNamaSeller = amhGetSellerDisplayName($vSellerId);

	$vBodyPebisnis = "AMHTECHNO\n\nYth. " . $vNamaPebisnis . ", transaksi " . $vTrxId . " telah selesai diproses admin.\n\n";
	$vBodyPebisnis .= "Total barang: " . $vItems['qty_fmt'] . " pcs\n";
	if ($vItems['detail'] !== '')
		$vBodyPebisnis .= "Rincian:\n" . $vItems['detail'] . "\n\n";
	$vBodyPebisnis .= "Terima kasih.";

	$vBodySeller = "AMHTECHNO\n\nYth. seller " . $vNamaSeller . ", transaksi " . $vTrxId . " dari pebisnis " . $vNamaPebisnis . " telah selesai diproses admin.\n\n";
	$vBodySeller .= "Total barang: " . $vItems['qty_fmt'] . " pcs\n";
	if ($vItems['detail'] !== '')
		$vBodySeller .= "Rincian:\n" . $vItems['detail'] . "\n\n";
	$vBodySeller .= "Silakan login ke https://intern.amhtechno.com untuk melihat detail transaksi.";

	$vHpPebisnis = trim((string)$oMember->getMemFieldBis('fnohp', $vPebisnisId));
	if ($vHpPebisnis !== '' && $vHpPebisnis !== '-')
		$oSystem->sendWAMessage($vHpPebisnis, $vBodyPebisnis);

	if ($vSellerId !== '') {
		$vHpSeller = trim((string)$oMember->getMemFieldSell('fnohp', $vSellerId));
		if ($vHpSeller !== '' && $vHpSeller !== '-' && $vHpSeller !== '-1')
			$oSystem->sendWAMessage($vHpSeller, $vBodySeller);
	}
}

function amhSendCtrPaymentApprovedSellerWA($pTrxId) {
	global $oSystem, $oMember, $dbin;
	if (!isset($oSystem) || !is_object($oSystem))
		return false;

	$vTrxId = trim((string)$pTrxId);
	if ($vTrxId === '')
		return false;

	$vHdr = amhLoadJualTrxHeaderForWa($dbin, $vTrxId);
	if ($vHdr === null || $vHdr['fidseller'] === '')
		return false;

	$vSellerId = $vHdr['fidseller'];
	$vBuyerId = $vHdr['fidmember'];
	$vItemTable = ($vHdr['table'] === 'tb_penjualan_temp') ? 'tb_penjualan_temp' : 'tb_penjualan';
	$vNamaSeller = amhGetSellerDisplayName($vSellerId);
	$vNamaPembeli = $vHdr['frecname'];
	if ($vNamaPembeli === '') {
		$vNamaPembeli = trim((string)$oMember->getMemberNameAdm($vBuyerId, 'sponsor'));
	}
	if ($vNamaPembeli === '' || $vNamaPembeli === '-1')
		$vNamaPembeli = $vBuyerId;

	$vItems = amhBuildJualItemSummary($vTrxId, $dbin, $vItemTable);
	$vItemText = $vItems['item_inline'];
	if ($vItemText === '')
		$vItemText = '-';

	$vBody = "Yth. seller " . $vNamaSeller . ", transaksi " . $vTrxId . ", \n";
	$vBody .= "pembeli " . $vNamaPembeli . ", item " . $vItemText . ", \n";
	$vBody .= "pembayaran melalui cash/transfer sudah disetujui oleh admin. \n\n";
	$vBody .= "Silakan untuk memproses pengiriman.";

	$vHpSeller = amhGetSellerPhoneFromDb($dbin, $vSellerId);
	if ($vHpSeller === '') {
		$vHpSeller = trim((string)$oMember->getMemFieldSell('fnohp', $vSellerId));
		if ($vHpSeller === '-1')
			$vHpSeller = '';
	}
	if ($vHpSeller === '' || $vHpSeller === '-')
		return false;

	$oSystem->sendWAMessage($vHpSeller, $vBody);
	return true;
}

// echo "Resetting tables...!";
$vOP = $_GET['op'];
$vKind = $_GET['kind'];
$vIdTrx = $_GET['idtrx'];
$vIdSys = $_GET['idsys'];
$vReceiveField = amhGetTrxReceiveField($dbin);
$vReceiveSelect = ($vReceiveField != '') ? $vReceiveField . " as freceived" : "'0' as freceived";

if ($vOP == "rejectst") {
	$vSQL = "delete from tb_stockist_temp where fidsys='$vIdSys' ";
	if($db->query($vSQL))
		echo 'successdel';
} else if ($vOP == "markreceived") {
	if (session_status() != PHP_SESSION_ACTIVE)
		session_start();
	$vIdTrxEsc = addslashes(trim((string)$vIdTrx));
	if ($vReceiveField == '' || $vIdTrxEsc == '') {
		echo 'nofield';
		exit;
	}
	if (!isset($_SESSION['Priv']) || $_SESSION['Priv'] != 'sponsor' || trim((string)$_SESSION['LoginUser']) == '') {
		echo 'denied';
		exit;
	}
	$vLoginUser = strtoupper(trim((string)$_SESSION['LoginUser']));
	$vSQL = "select fidmember, fnostockist, fsend, fpaid, fmethod, $vReceiveSelect from tb_penjualan_temp where fidpenjualan='$vIdTrxEsc' limit 1";
	$dbin->query($vSQL);
	if ($dbin->num_rows() <= 0) {
		echo 'notfound';
		exit;
	}
	$dbin->next_record();
	$vMemberTrx = strtoupper(trim((string)$dbin->f('fidmember')));
	$vStockTrx = strtoupper(trim((string)$dbin->f('fnostockist')));
	$vSendTrx = trim((string)$dbin->f('fsend'));
	$vReceivedTrx = trim((string)$dbin->f('freceived'));
	$vPaidTrx = trim((string)$dbin->f('fpaid'));
	$vMethodTrx = strtolower(trim((string)$dbin->f('fmethod')));
	if ($vMemberTrx !== $vLoginUser && $vStockTrx !== $vLoginUser) {
		echo 'denied';
		exit;
	}
	if ($vSendTrx != '1') {
		echo 'notsent';
		exit;
	}
	if ($vReceivedTrx == '1') {
		echo 'already';
		exit;
	}
	if ($vMethodTrx != 'wpr' && $vPaidTrx != '1') {
		echo 'notpaid';
		exit;
	}
	$db->query("START TRANSACTION;");
	$db->query("update tb_penjualan_temp set $vReceiveField='1' where fidpenjualan='$vIdTrxEsc'");
	$db->query("update tb_penjualan set $vReceiveField='1' where fidpenjualan='$vIdTrxEsc'");
	$db->query("COMMIT;");
	echo 'success';
} else if ($vOP == "reject") {
	$vSQL = "delete from tb_trxstok_temp where fidpenjualan='$vIdTrx' ";
	if($db->query($vSQL))
		echo 'successdel';
} else if ($vOP == "approvepayment") {
	$vIdTrxEsc = addslashes(trim((string)$vIdTrx));
	$vSQL = "select fmethod, fprocessed, fpaid from tb_penjualan_temp where fidpenjualan='$vIdTrxEsc' limit 1";
	$dbin->query($vSQL);
	if ($dbin->num_rows() <= 0) {
		echo 'notfound';
	} else {
		$dbin->next_record();
		$vMethodNorm = strtolower(trim((string)$dbin->f('fmethod')));
		$vProcessedRaw = $dbin->f('fprocessed');
		$vFpaidRaw = $dbin->f('fpaid');
		$vIsProcessPending = ($vProcessedRaw === null || $vProcessedRaw === '' || (string)$vProcessedRaw === '0');
		if ($vMethodNorm !== 'ctr') {
			echo 'invalidmethod';
		} else if (!$vIsProcessPending) {
			echo 'alreadyprocessed';
		} else if ((string)$vFpaidRaw === '1') {
			amhSendCtrPaymentApprovedSellerWA($vIdTrxEsc);
			echo 'successpaid';
		} else {
			$db->query("START TRANSACTION;");
			$db->query("update tb_penjualan_temp set fpaid='1' where fidpenjualan='$vIdTrxEsc' and fmethod='ctr'");
			$vAffTemp = $db->affected_rows();
			$db->query("update tb_penjualan set fpaid='1' where fidpenjualan='$vIdTrxEsc' and fmethod='ctr'");
			if ($vAffTemp <= 0) {
				$db->query("ROLLBACK;");
				$dbin->query("select fpaid from tb_penjualan_temp where fidpenjualan='$vIdTrxEsc' and fmethod='ctr' limit 1");
				if ($dbin->next_record() && (string)$dbin->f('fpaid') === '1') {
					amhSendCtrPaymentApprovedSellerWA($vIdTrxEsc);
					echo 'successpaid';
				} else {
					echo 'updatefailed';
				}
			} else {
				$db->query("COMMIT;");
				amhSendCtrPaymentApprovedSellerWA($vIdTrxEsc);
				echo 'successpaid';
			}
		}
	}
} else if ($vOP == "approve") {
	$vKind = "Approved";
	$db->query("START TRANSACTION;");
	$vSQL = "insert into tb_trxstok( `fidpenjualan` , `fidseller` , `fidmember` , `falamatkrm` , `fnostockist` , `fidproduk` , `fjumlah` , `ftanggal` , `fhargasat` , `fsubtotal` , `fsize` , `fcolor` , `ftgltrans` , `fjenis` , `fjmltrans` , `fserial` , `fpin` , `fmethod` , `fketerangan` , `ftglentry` , `fprocessed` , `ftglprocessed` , `fkindtrx` ) ";
	$vSQL .= "select `fidpenjualan` , `fidseller` , `fidmember` , `falamatkrm` , `fnostockist` , `fidproduk` , `fjumlah` , `ftanggal` , `fhargasat` , `fsubtotal` , `fsize` , `fcolor` , `ftgltrans` , `fjenis` , `fjmltrans` , `fserial` , `fpin` , `fmethod` , `fketerangan` , `ftglentry` , `fprocessed` , `ftglprocessed` , `fkindtrx` from tb_trxstok_temp where fidpenjualan='$vIdTrx' and fkindtrx='purc1'";
	
	if($dbin->query($vSQL)) {
		echo 'successappv';
		$vSQLSelect = "select * from tb_trxstok_temp where fidpenjualan='$vIdTrx' and fkindtrx='purc1'";
		$db->query($vSQLSelect);
		$vTot = 0;
		while ($db->next_record()) {
			$vIdMem = $db->f('fidmember');
			$vIDProduk = $db->f('fidproduk');
			$vAmount = $db->f('fjumlah');
			$vSeller = $db->f('fidseller');
			$vSubTot = $db->f('fsubtotal');
			$vTot += $vSubTot;
			$vSQLCheck = "select * from tb_stok_position where fidmember='$vIdMem' and fidproduk='$vIDProduk' ";
			$db1->query($vSQLCheck);
			$db1->next_record();
			$vLastBal = $oMember->getStockPosNex($vIdMem, $vIDProduk);
			$vNewBal = $vLastBal + $vAmount;
			if ($db1->num_rows() <= 0) {
				$vSQL = "INSERT INTO `tb_stok_position` (`fidmember`, `fidproduk`, `fsize`, `fcolor`, `flocation`, `fdesc`, `fbalance`, `fkind`, `fstatus`, `flastuser`, `flastupdate`, `fref`) ";
				$vSQL .= "VALUES ('$vIdMem', '$vIDProduk', NULL, NULL, '01', 'First PO $vKind', $vAmount, '1stpo', '1', '$vSeller', now(), '$vIdTrx');";
				$dbin->query($vSQL);
			} else {
				$vSQL = "UPDATE `tb_stok_position` set fdesc='Add Stock', fkind='po', fbalance=fbalance+$vAmount where `fidmember`='$vIdMem' and fidproduk='$vIDProduk' ";
				$dbin->query($vSQL);
			}
			
			$vSQL = "INSERT INTO `tb_mutasi_stok` (`fidmember` ,`fidproduk` ,`fsize` ,`fcolor` ,`fidfunder` ,`ftanggal` ,`fdesc` ,`fcredit` ,`fdebit` ,`fbalance` ,`fkind` ,`fstatus` ,`flastuser` ,`flastupdate` ,`fref`) ";
			$vSQL .= "VALUES ('$vIdMem', '$vIDProduk' , NULL , NULL , '', now(), 'Purchase Order $vKind',$vAmount, 0, $vNewBal, 'po', '1', '$vSeller', now(), '$vIdTrx');";
			$dbin->query($vSQL);
			$oMember->setSaldoStockNex($vIdMem, $vIDProduk, $vNewBal, $dbin);
		}
		
		$vSQL = "delete from tb_trxstok_temp where fidpenjualan='$vIdTrx' ";
		$dbin->query($vSQL);
		
		$vStockStat = $oMember->getMemField('fstockist', $vIdMem);
		$vProsenFee = 0;
		
		// ffeetrxstmob
		if ($vStockStat == '1') {
			$vProsenFee = $oRules->getSettingByField('ffeetrxstmob');
		} else if ($vStockStat == '2') {
			$vProsenFee = $oRules->getSettingByField('ffeetrxststd');
		} else if ($vStockStat == '3') {
			$vProsenFee = $oRules->getSettingByField('ffeetrxstmst');
		}
		
		$vStockFee = $vTot * $vProsenFee / 100;
		$vSpon = $oNetwork->getSponsor($vIdMem);
		if ($vStockFee > 0)
			$oKomisi->spreadStBonus($vSpon, $vTot, $vStockFee, 'bnstrxst', 'nom', "Bonus Transaksi Stockist $vIdMem", $vIdMem, $vIdTrx);
	}
	$db->query("COMMIT;");

		 

} else if ($vOP == "approvesell" && $vKind == 'prd') {
	$vResi = $_GET['noresi'];
	$vKind = "Penjualan";
	$db->query("START TRANSACTION;");
	
	$vSQL = "select sum(fsubtotal) as ftotal from tb_penjualan_temp where fidpenjualan='$vIdTrx' ";
	$dbin->query($vSQL);
	$dbin->next_record();
	$vTotal = (float)$dbin->f('ftotal');
	$vFeeAminah = 0;
	$vSellBonusAmt = 0;
	$vProductProgram = '';
	$vSQL = "select b.fprogram from tb_penjualan_temp a inner join m_product b on a.fidproduk=b.fidproduk where a.fidpenjualan='$vIdTrx' limit 1";
	$dbin->query($vSQL);
	if ($dbin->next_record()) {
		$vProductProgram = trim((string)$dbin->f('fprogram'));
	}
	if ($vProductProgram != '') {
		$vProductProgramEsc = addslashes($vProductProgram);
		$vSQL = "select fbnssponhp from tb_rules_bnskorwil where fidprogram='$vProductProgramEsc' limit 1";
		$dbin->query($vSQL);
		if ($dbin->next_record()) {
			$vSellBonusAmt = (float)$dbin->f('fbnssponhp');
			if ($vSellBonusAmt < 0) $vSellBonusAmt = 0;
		}
	}

	// fongkir tidak dinormalkan: cukup ambil 1 baris untuk 1 fidpenjualan
	$vSQL = "select fongkir from tb_penjualan_temp where fidpenjualan='$vIdTrx' limit 1";
	$dbin->query($vSQL);
	$dbin->next_record();
	$vOngkir = (float)$dbin->f('fongkir');

	$vTotalCharge = $vTotal + $vOngkir;
	$vEndap = (float)$oRules->getSettingByField('fmindap');
	$vBankFee = (float)$oRules->getSettingByField('fbyybank');
	if ($vEndap < 0) $vEndap = 0;
	if ($vBankFee < 0) $vBankFee = 0;

	$vSQL = "select fidmember, fnostockist, fmethod, fsend, fpaid,$vReceiveSelect from tb_penjualan_temp where fidpenjualan='$vIdTrx' limit 1";
	$dbin->query($vSQL);
	$dbin->next_record();
	$vBuyerTrx = $dbin->f('fidmember');
	$vPayerTrx = $dbin->f('fnostockist');
	$vMethodTrx = $dbin->f('fmethod');
	$vSendTrx = $dbin->f('fsend');
	$vReceivedTrx = $dbin->f('freceived');
	$vSellerTrx = '';
	if (trim($vPayerTrx) == '')
		$vPayerTrx = $vBuyerTrx;
	$vSellerCredit = $vTotalCharge;
	if ($vMethodTrx == 'tva') {
		$vSellerCredit += $vBankFee;
		if ($dbin->f('fpaid') != '1') {
			$db->query("ROLLBACK;");
			echo 'notreadytvapaid';
			exit;
		}
		if ($vSendTrx != '1') {
			$db->query("ROLLBACK;");
			echo 'notreadytvasend';
			exit;
		}
		if ($vReceivedTrx != '1') {
			$db->query("ROLLBACK;");
			echo 'notreadytvareceived';
			exit;
		}
	}

	if ($vMethodTrx == 'wpr' && $vSendTrx != '1') {
		$db->query("ROLLBACK;");
		echo 'notreadywpr';
		exit;
	}
	if ($vMethodTrx == 'wpr' && $vReceivedTrx != '1') {
		$db->query("ROLLBACK;");
		echo 'notreadywprreceived';
		exit;
	}
	if ($vMethodTrx == 'ctr' && $dbin->f('fpaid') != '1') {
		$db->query("ROLLBACK;");
		//echo 'notreadyctrpaid' . " $vMethodTrx::". $dbin->f('fpaid');
		exit;
	}
	if ($vMethodTrx == 'ctr' && $vSendTrx != '1') {
		$db->query("ROLLBACK;");
		echo 'notreadyctrsend';
		exit;
	}

	if ($vMethodTrx == 'wpr') {
		$vLastBalBiz = (float)$oMember->getMemFieldBis('fsaldovcr', $vPayerTrx);
		$vAvailBiz = $vLastBalBiz - $vEndap;
		if ($vAvailBiz < $vTotalCharge) {
			$db->query("ROLLBACK;");
			echo 'not_e_bonusbalance';
			exit;
		}
	}
	
	$vSQL = "insert into tb_penjualan( `fidpenjualan` , `fidseller` , `fidmember` , `falamatkrm` , `fnostockist` , `fidproduk` , `fjumlah` , `ftanggal` , `fhargasat` , `fsubtotal` , `fsize` , `fcolor` , `ftgltrans` , `fjenis` , `fjmltrans` , `fserial` , `fpin` , `fmethod` , `fketerangan` , `ftglentry` , `fprocessed` , `ftglprocessed`,`fongkir`,`fberat`, `fcountry`, `fprop`, `fkota`, `fkec`, `fexpe`, `fpack`, `frecname`, `frecnohp`, `fnorek`) ";
	$vSQL .= "select `fidpenjualan` , `fidseller` , `fidmember` , `falamatkrm` , `fnostockist` , `fidproduk` , `fjumlah` , `ftanggal` , `fhargasat` , `fsubtotal` , `fsize` , `fcolor` , `ftgltrans` , `fjenis` , `fjmltrans` , `fserial` , `fpin` , `fmethod` , `fketerangan` , `ftglentry` , '2' , now(), `fongkir`,`fberat`, `fcountry`, `fprop`, `fkota`, `fkec`, `fexpe`, `fpack`, `frecname`, `frecnohp`, `fnorek` from tb_penjualan_temp where fidpenjualan='$vIdTrx' ";
	
	if($db->query($vSQL)) {
		$vSQLSelect = "select a.*, IFNULL(b.fpotong,0) as fpotong from tb_penjualan_temp a left join m_product b on a.fidproduk=b.fidproduk where a.fidpenjualan='$vIdTrx' ";
		$dbin->query($vSQLSelect);
		
		while ($dbin->next_record()) {
			$vIdMem = $dbin->f('fidmember');
			$vIDProduk = $dbin->f('fidproduk');
			$vAmount = $dbin->f('fjumlah');
			$vSeller = $dbin->f('fidseller');
			$vIDOutlet = $dbin->f('fnostockist');
			$vMethod = $dbin->f('fmethod');
			$vSubTotItem = (float)$dbin->f('fsubtotal');
			$vPotongItem = (float)$dbin->f('fpotong');
			$vFeeAminah += ($vSubTotItem * $vPotongItem / 100);
			
			$vLastBal = $oMember->getStockPosUnig($vSeller, $vIDProduk);
			$vNewBal = $vLastBal - $vAmount;
			
			$vSQL = "UPDATE `tb_stok_position` set fdesc='Penjualan $vIdTrx', fkind='RO', fbalance=fbalance-$vAmount where `fidmember`='$vSeller' and fidproduk='$vIDProduk' ";
			$db->query($vSQL);
			
			$vSQL = "INSERT INTO `tb_mutasi_stok` (`fidmember` ,`fidproduk` ,`fsize` ,`fcolor` ,`fidfunder` ,`ftanggal` ,`fdesc` ,`fcredit` ,`fdebit` ,`fbalance` ,`fkind` ,`fstatus` ,`flastuser` ,`flastupdate` ,`fref`) ";
			$vSQL .= "VALUES ('$vSeller', '$vIDProduk' , NULL , NULL , '', now(), 'RO Sales [$vIdMem]',$vAmount, 0, $vNewBal, 'JRO', '1', '$vSeller', now(), '$vIdTrx');";
			$db->query($vSQL);
			
			$oMember->setSaldoStockWH($vSeller, $vIDProduk, $vNewBal, $db);
			if ($vSellerTrx == '') {
				$vSellerTrx = $vSeller;
			}
		}
		
		$vSQL = "update tb_penjualan set fketerangan=concat(fketerangan,', Ket: $vResi') where fidpenjualan='$vIdTrx'";
		$db->query($vSQL);
		
		$vSQL = "delete from tb_penjualan_temp where fidpenjualan='$vIdTrx' ";
		$db->query($vSQL);
		
		// Mutasi Si member
		$vUserTrx = $vPayerTrx;
		$vBuyer = $vIdMem;
		$vNextJual = $vIdTrx;
		$vDescSellerIn = "Dana masuk dari Repeat Order Sales $vNextJual";
		$vDescSellerFee = "Fee AMH dari transaksi Repeat Order Sales $vNextJual";
		$vDescSellerBankFee = "Fee Bank TVA dari transaksi Repeat Order Sales $vNextJual";

		if ($vSellerTrx != '') {
			$vLastBalSeller = (float)$oMember->getMemFieldSell('fsaldovcr', $vSellerTrx);
			if ($vLastBalSeller < 0) {
				$vLastBalSeller = 0;
			}
			$vBalSellerIn = $vLastBalSeller + $vSellerCredit;
			$oKomisi->insertMutasi($vSellerTrx, $vBuyer, date("Y-m-d H:i:s"), $vDescSellerIn, $vSellerCredit, 0, $vBalSellerIn, 'reorder', $vNextJual);

			$vBalSellerFinal = $vBalSellerIn;
			if ($vFeeAminah > 0) {
				$vBalSellerFinal = $vBalSellerIn - $vFeeAminah;
				$oKomisi->insertMutasi($vSellerTrx, $vBuyer, date("Y-m-d H:i:s"), $vDescSellerFee, 0, $vFeeAminah, $vBalSellerFinal, 'reorder', $vNextJual);
			}

			$vSellerBankFee = 0;
			if ($vMethodTrx == 'tva' && $vBankFee > 0) {
				$vSellerBankFee = $vBankFee;
				if ($vSellerBankFee > 0) {
					$vBalSellerFinal = $vBalSellerFinal - $vSellerBankFee;
					$oKomisi->insertMutasi($vSellerTrx, $vBuyer, date("Y-m-d H:i:s"), $vDescSellerBankFee, 0, $vSellerBankFee, $vBalSellerFinal, 'reorder', $vNextJual);
				}
			}

			$oMember->updateBalSeller($vSellerTrx, $vBalSellerFinal);
		}

		if ($vMethodTrx == 'wpr') {
			// Atomic deduction: saldo setelah potong tidak boleh kurang dari saldo mengendap
			$vSQL = "update m_pebisnis set fsaldovcr=fsaldovcr-$vTotalCharge where fidmember='$vUserTrx' and fsaldovcr >= ($vTotalCharge + $vEndap)";
			$db->query($vSQL);
			if ($db->affected_rows() <= 0) {
				$db->query("ROLLBACK;");
				echo 'not_e_bonusbalance';
				exit;
			}

			$vSQL = "select fsaldovcr from m_pebisnis where fidmember='$vUserTrx' limit 1";
			$db->query($vSQL);
			$db->next_record();
			$vNewBal = (float)$db->f('fsaldovcr');

			$vsql = "insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fincometax,fref) ";
			$vsql .= "values ('$vUserTrx', '$vBuyer', now(),'Repeat Order Sales $vNextJual (termasuk admin dan ongkir) [Potong Saldo Pebisnis]' , 0,$vTotalCharge ,$vNewBal ,'reorder' , '1','$vUserTrx' , now(),0,'$vNextJual') ";
			$db->query($vsql);
		}

		if ($vSellBonusAmt > 0 && trim($vUserTrx) != '') {
			$vLastBalBonus = (float)$oMember->getMemFieldBis('fsaldovcr', $vUserTrx);
			if ($vLastBalBonus < 0) {
				$vLastBalBonus = 0;
			}
			$vNewBalBonus = $vLastBalBonus + $vSellBonusAmt;
			$oKomisi->insertMutasiConn($vUserTrx, $vBuyer, date("Y-m-d H:i:s"), "Bonus hasil penjualan $vNextJual", $vSellBonusAmt, 0, $vNewBalBonus, 'reorder', $vNextJual, $db);
			$oMember->updateBalConnWProdBiz($vUserTrx, $vNewBalBonus, $db);
		}
		
		$vIDMember = $oJual->getMemberByJual($vIdTrx);
		$vJumlah = $oJual->getBuyedTot($vIdTrx);
		// $oNetwork->sendFeeTitikCompress('EDUARDO',20,1000000,'J7777777');
		// $oNetwork->sendFeeTitikCompress($vIDMember,20,$vJumlah,$vIdTrx);
		// Pencairan langsung ke seller dinonaktifkan.
		// Semua metode pembayaran (ctr, wpr, tva) sekarang masuk ke saldo seller
		// dan seller melakukan pencairan melalui menu withdraw.
		// $vSellSession = md5('jalanku');
		// if ($vMethodTrx == 'tva') {
		// 	include("payseller.php");
		// }
		amhSendApproveSellCompletedWA($vIdTrx, $vPayerTrx, $vSellerTrx);
		echo 'successappv';
	}
	$db->query("COMMIT;");
	
} else if ($vOP == "approvesell" && $vKind == 'kit') { //Not used

	$vResi = $_GET['noresi'];
	$vKind = "Penjualan";
	$db->query("START TRANSACTION;");
	
	$vSQL = "select sum(fsubtotal) as ftotal from tb_penjualan_temp where fidpenjualan='$vIdTrx' ";
	$dbin->query($vSQL);
	$dbin->next_record();
	$vTotal = $dbin->f('ftotal');
	
	$vSQL = "insert into tb_penjualan( `fidpenjualan` , `fidseller` , `fidmember` , `falamatkrm` , `fnostockist` , `fidproduk` , `fjumlah` , `ftanggal` , `fhargasat` , `fsubtotal` , `fsize` , `fcolor` , `ftgltrans` , `fjenis` , `fjmltrans` , `fserial` , `fpin` , `fmethod` , `fketerangan` , `ftglentry` , `fprocessed` , `ftglprocessed`) ";
	$vSQL .= "select `fidpenjualan` , `fidseller` , `fidmember` , `falamatkrm` , `fnostockist` , `fidproduk` , `fjumlah` , `ftanggal` , `fhargasat` , `fsubtotal` , `fsize` , `fcolor` , `ftgltrans` , `fjenis` , `fjmltrans` , `fserial` , `fpin` , `fmethod` , `fketerangan` , `ftglentry` , '2' , now() from tb_penjualan_temp where fidpenjualan='$vIdTrx' ";
	
	if($db->query($vSQL)) {
		$vSQLSelect = "select * from tb_penjualan_temp where fidpenjualan='$vIdTrx' ";
		$dbin->query($vSQLSelect);
		
		while ($dbin->next_record()) {
			$vIdMem = $dbin->f('fidmember');
			$vIDProduk = $dbin->f('fidproduk');
			$vAmount = $dbin->f('fjumlah');
			$vSeller = $dbin->f('fidseller');
			$vMethod = $dbin->f('fmethod');
			
			for ($x = 0; $x < $vAmount; $x++) {
				if ($vIDProduk == 'KITB001')
					$vSQL = "select * from tb_skit where fstatus='1' and fpaket='B' limit 1";
				else if ($vIDProduk == 'KITP001')
					$vSQL = "select * from tb_skit where fstatus='1' and fpaket='P' limit 1";
				$db1->query($vSQL);
				$db1->next_record();
				$vSerial = $db1->f('fserno');
				
				$vSQL = "INSERT INTO tb_trxkit(fidpenjualan, fidseller, fidmember, falamatkrm, fnostockist, fserno,ftglentry) ";
				$vSQL .= "values('$vIdTrx', '$vSeller', '$vIdMem', '', '', '$vSerial',now()) ";
				$db->query($vSQL);
				
				$vSQL = "update tb_skit set fstatus='2', ftgldist=now(), fpendistribusi='$vIdMem',frefpurc='$vIdTrx' where fserno='$vSerial'";
				$db->query($vSQL);
			}
		}
		
		$vSQL = "update tb_penjualan set fketerangan=concat(fketerangan,', Ket: $vResi') where fidpenjualan='$vIdTrx'";
		$db->query($vSQL);
		
		$vSQL = "delete from tb_penjualan_temp where fidpenjualan='$vIdTrx' ";
		$db->query($vSQL);
		
		// Mutasi Si member
		$vUserTrx = $vIdMem;
		$vBuyer = $vIdMem;
		$vNextJual = $vIdTrx;
		
		$vLastBal = $oMember->getMemField('fsaldowkit', $vUserTrx);
		$vNewBal = $vLastBal - $vTotal;
		
		if ($vMethod != 'ctr') {
			$vsql = "insert into tb_mutasi_wkit (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fincometax,fref) ";
			$vsql .= "values ('$vUserTrx', '$vBuyer', now(),'Repeat Order KIT/Serial Sales $vNextJual [Cash/Transfer]' , 0,$vTotal ,$vNewBal ,'reorder' , '1','$vUserTrx' , now(),0,'$vNextJual') ";
			$db->query($vsql);
			$oMember->updateBalConnWKit($vUserTrx, $vNewBal, $db);
		}
		
		echo 'successappv';
	}
	$db->query("COMMIT;");
	
} else if ($vOP == "approvesell" && $vKind == 'acc') {//Not used accessories

	$vResi = $_GET['noresi'];
	$vKind = "Penjualan";
	$db->query("START TRANSACTION;");
	
	$vSQL = "select sum(fsubtotal) as ftotal from tb_penjualan_temp where fidpenjualan='$vIdTrx' ";
	$dbin->query($vSQL);
	$dbin->next_record();
	$vTotal = $dbin->f('ftotal');
	
	$vSQL = "insert into tb_penjualan( `fidpenjualan` , `fidseller` , `fidmember` , `falamatkrm` , `fnostockist` , `fidproduk` , `fjumlah` , `ftanggal` , `fhargasat` , `fsubtotal` , `fsize` , `fcolor` , `ftgltrans` , `fjenis` , `fjmltrans` , `fserial` , `fpin` , `fmethod` , `fketerangan` , `ftglentry` , `fprocessed` , `ftglprocessed`) ";
	$vSQL .= "select `fidpenjualan` , `fidseller` , `fidmember` , `falamatkrm` , `fnostockist` , `fidproduk` , `fjumlah` , `ftanggal` , `fhargasat` , `fsubtotal` , `fsize` , `fcolor` , `ftgltrans` , `fjenis` , `fjmltrans` , `fserial` , `fpin` , `fmethod` , `fketerangan` , `ftglentry` , '2' , now() from tb_penjualan_temp where fidpenjualan='$vIdTrx' ";
	
	if($db->query($vSQL)) {
		$vSQLSelect = "select * from tb_penjualan_temp where fidpenjualan='$vIdTrx' ";
		$dbin->query($vSQLSelect);
		
		while ($dbin->next_record()) {
			$vIdMem = $dbin->f('fidmember');
			$vIDProduk = $dbin->f('fidproduk');
			$vAmount = $dbin->f('fjumlah');
			$vSeller = $dbin->f('fidseller');
			$vMethod = $dbin->f('fmethod');
		}
		
		$vSQL = "update tb_penjualan set fketerangan=concat(fketerangan,', Ket: $vResi') where fidpenjualan='$vIdTrx'";
		$db->query($vSQL);
		
		$vSQL = "delete from tb_penjualan_temp where fidpenjualan='$vIdTrx' ";
		$db->query($vSQL);
		
		// Mutasi Si member
		$vUserTrx = $vIdMem;
		$vBuyer = $vIdMem;
		$vNextJual = $vIdTrx;
		
		$vLastBal = $oMember->getMemField('fsaldowacc', $vUserTrx);
		$vNewBal = $vLastBal - $vTotal;
		
		if ($vMethod != 'ctr') {
			$vsql = "insert into tb_mutasi_wacc (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fincometax,fref) ";
			$vsql .= "values ('$vUserTrx', '$vBuyer', now(),'Repeat Product Support Sales $vNextJual [Cash/Transfer]' , 0,$vTotal ,$vNewBal ,'reorderacc' , '1','$vUserTrx' , now(),0,'$vNextJual') ";
			$db->query($vsql);
			$oMember->updateBalConnWAcc($vUserTrx, $vNewBal, $db);
		}
		
		echo 'successappv';
	}
	$db->query("COMMIT;");

		 

		 

      } else if ($vOP == "approvero") {
	$vKind = "RO";
	$db->query("START TRANSACTION;");
	$vSQL = "insert into tb_trxstok( `fidpenjualan` , `fidseller` , `fidmember` , `falamatkrm` , `fnostockist` , `fidproduk` , `fjumlah` , `ftanggal` , `fhargasat` , `fsubtotal` , `fsize` , `fcolor` , `ftgltrans` , `fjenis` , `fjmltrans` , `fserial` , `fpin` , `fmethod` , `fketerangan` , `ftglentry` , `fprocessed` , `ftglprocessed` , `fkindtrx` ) ";
	$vSQL .= "select `fidpenjualan` , `fidseller` , `fidmember` , `falamatkrm` , `fnostockist` , `fidproduk` , `fjumlah` , `ftanggal` , `fhargasat` , `fsubtotal` , `fsize` , `fcolor` , `ftgltrans` , `fjenis` , `fjmltrans` , `fserial` , `fpin` , `fmethod` , `fketerangan` , `ftglentry` , `fprocessed` , `ftglprocessed` , `fkindtrx` from tb_trxstok_temp where fidpenjualan='$vIdTrx' and fkindtrx='purc2'";
	
	if($dbin->query($vSQL)) {
		echo 'successappv';
		$vSQLSelect = "select * from tb_trxstok_temp where fidpenjualan='$vIdTrx' and fkindtrx='purc2'";
		$db->query($vSQLSelect);
		
		while ($db->next_record()) {
			$vIdMem = $db->f('fidmember');
			$vIDProduk = $db->f('fidproduk');
			$vAmount = $db->f('fjumlah');
			$vSeller = $db->f('fidseller');
			$vSQLCheck = "select * from tb_stok_positionro where fidmember='$vIdMem' and fidproduk='$vIDProduk' ";
			$db1->query($vSQLCheck);
			$db1->next_record();
			$vLastBal = $oMember->getStockPosNexRO($vIdMem, $vIDProduk);
			$vNewBal = $vLastBal + $vAmount;
			if ($db1->num_rows() <= 0) {
				$vSQL = "INSERT INTO `tb_stok_positionro` (`fidmember`, `fidproduk`, `fsize`, `fcolor`, `flocation`, `fdesc`, `fbalance`, `fkind`, `fstatus`, `flastuser`, `flastupdate`, `fref`) ";
				$vSQL .= "VALUES ('$vIdMem', '$vIDProduk', NULL, NULL, '01', 'First PO $vKind', $vAmount, '1stpo', '1', '$vSeller', now(), '$vIdTrx');";
				$dbin->query($vSQL);
			} else {
				$vSQL = "UPDATE `tb_stok_positionro` set fdesc='Add Stock', fkind='poro', fbalance=fbalance+$vAmount where `fidmember`='$vIdMem' and fidproduk='$vIDProduk' ";
				$dbin->query($vSQL);
			}
			
			$vSQL = "INSERT INTO `tb_mutasi_stokro` (`fidmember` ,`fidproduk` ,`fsize` ,`fcolor` ,`fidfunder` ,`ftanggal` ,`fdesc` ,`fcredit` ,`fdebit` ,`fbalance` ,`fkind` ,`fstatus` ,`flastuser` ,`flastupdate` ,`fref`) ";
			$vSQL .= "VALUES ('$vIdMem', '$vIDProduk' , NULL , NULL , '', now(), 'Purchase Order $vKind',$vAmount, 0, $vNewBal, 'poro', '1', '$vSeller', now(), '$vIdTrx');";
			$dbin->query($vSQL);
			$oMember->setSaldoStockNexRO($vIdMem, $vIDProduk, $vNewBal, $dbin);
		}
		
		$vSQL = "delete from tb_trxstok_temp where fidpenjualan='$vIdTrx' ";
		$dbin->query($vSQL);
	}
	$db->query("COMMIT;");
} else if ($vOP == "block") {

	$vIdMem = $_GET['od'];
	$vSQL = "update m_anggota set faktif='4' where fidmember='$vIdMem' ;";
	if($db->query($vSQL)) {
		echo 'success';
	} else echo 'failed';
	
} else if ($vOP == "delkor") {
	$vIdMem = $_GET['od'];
	$vSQL = "delete from m_korwil where fidkorwil='$vIdMem' ;";
	if($db->query($vSQL)) {
		echo 'success';
	} else echo 'failed';
	
} else if ($vOP == "deljam") {
	$vIdMem = $_GET['od'];
	$vSQL = "delete from m_anggota where fidmember='$vIdMem' ;";
	if($db->query($vSQL)) {
		echo 'success';
	} else echo 'failed';
	
} else if ($vOP == "unblock") {

	$vIdMem = $_GET['od'];
	$db->query("START TRANSACTION;");
	$vSQL = "select * from m_anggota where fidmember='$vIdMem'";
	if (!$db->query($vSQL) || !$db->next_record()) {
		$db->query("ROLLBACK;");
		echo 'error:member_not_found';
		exit;
	}
	$vAktifRow = $db->f('faktif');
	if ($vAktifRow == '1') {
		$db->query("ROLLBACK;");
		echo 'error:member_already_active';
		exit;
	}
	$vJenpay = trim($db->f('fjenpay'));
	$vRegistrar = trim($db->f('fidregistrar'));
	$vTotalAktifasi = (float)$db->f('ftotalbayar');
	$ftgldepart = $db->f('ftgldepart');
	$fstorawal = $db->f('fstorawal');
	$fangsur1 = $db->f('fangsur1');
	$fangsur2 = $db->f('fangsur2');
	$fangsur3 = $db->f('fangsur3');
	$fangsur4 = $db->f('fangsur4');
	$flunas = $db->f('flunas');
	$fairporttax = $db->f('fairporttax');
	$fassure = $db->f('fassure');
	$arabfassure = $db->f('arabfassure');

	if ($vJenpay == 'Saldo Bonus') {
		if ($vRegistrar == '') {
			$db->query("ROLLBACK;");
			echo 'error:invalid_registrar';
			exit;
		}
		if ($vTotalAktifasi <= 0) {
			$db->query("ROLLBACK;");
			echo 'error:invalid_total_bayar';
			exit;
		}

		$vSQL = "select fsaldovcr from m_pebisnis where fidmember='$vRegistrar' ";
		if (!$db->query($vSQL) || !$db->next_record()) {
			$db->query("ROLLBACK;");
			echo 'error:registrar_not_found';
			exit;
		}

		$vLastBalBonus = (float)$db->f('fsaldovcr');
		if ($vLastBalBonus < $vTotalAktifasi) {
			$db->query("ROLLBACK;");
			echo 'error:insufficient_bonus_balance';
			exit;
		}

		$vNewBalBonus = $vLastBalBonus - $vTotalAktifasi;
		$vMutRef = "AKT-SB-$vIdMem";
		$vMutDesc = "Pembayaran aktivasi jamaah $vIdMem via Saldo Bonus";
		$vMutDesc = str_replace("'", "''", $vMutDesc);
		$vSQL = "insert tb_mutasi(fidmember,fidfunder,ftanggal,fdesc,fcredit,fdebit,fbalance,fkind,fref) ";
		$vSQL .= "values('$vRegistrar','$vRegistrar',now(),'$vMutDesc',0,$vTotalAktifasi,$vNewBalBonus,'aktifasi_saldobonus','$vMutRef');";
		if (!$db->query($vSQL)) {
			$db->query("ROLLBACK;");
			echo 'error:db_transaction_failed';
			exit;
		}

		$vSQL = "update m_pebisnis set fsaldovcr=fsaldovcr-$vTotalAktifasi where fidmember='$vRegistrar' ";
		if (!$db->query($vSQL)) {
			$db->query("ROLLBACK;");
			echo 'error:db_transaction_failed';
			exit;
		}
	}
	
	$vSQL = "select * from m_tour where ftgldepart='$ftgldepart' ";
	if (!$db->query($vSQL) || !$db->next_record()) {
		$db->query("ROLLBACK;");
		echo 'error:db_transaction_failed';
		exit;
	}
	$vSisa = $db->f('fsisaseat');
	
	$vSQL = "update m_tour set fsisaseat=fsisaseat-1 where ftgldepart='$ftgldepart'";
	if (!$db->query($vSQL)) {
		$db->query("ROLLBACK;");
		echo 'error:db_transaction_failed';
		exit;
	}
	
	$vSQL = "INSERT INTO tb_logchange(fkdanggota, fold, fnew, ftipe, fket, fstatusrow, ftglentry) ";
	$vSQL .= "values('$vIdMem', $vSisa, $vSisa-1, 'deduct-seat', 'Pengurangan Seat (Pendaftaran)', '1', now());";
	if (!$db->query($vSQL)) {
		$db->query("ROLLBACK;");
		echo 'error:db_transaction_failed';
		exit;
	}
	
	$vNom = 0;
	
	if ($fstorawal > 0) {
		$vDesc = "Setoran Awal";
		$oKomisi->insertPayment($vIdMem, $vIdMem, date("Y-m-d H:i:s"), $vDesc, $fstorawal, 0, $fstorawal, 'sawal');
	}
	
	if ($fangsur1 > 0) {
		$vDesc = "Angsuran 1";
		$vNom = $fstorawal + $fangsur1;
		$oKomisi->insertPayment($vIdMem, $vIdMem, date("Y-m-d H:i:s"), $vDesc, $fangsur1, 0, $vNom, 'fangsur1');
	}
	
	if ($fangsur2 > 0) {
		$vDesc = "Angsuran 2";
		$vNom = $fstorawal + $fangsur1 + $fangsur2;
		$oKomisi->insertPayment($vIdMem, $vIdMem, date("Y-m-d H:i:s"), $vDesc, $fangsur2, 0, $vNom, 'fangsur2');
	}
	
	if ($fangsur3 > 0) {
		$vDesc = "Angsuran 3";
		$vNom = $fstorawal + $fangsur1 + $fangsur2 + $fangsur3;
		$oKomisi->insertPayment($vIdMem, $vIdMem, date("Y-m-d H:i:s"), $vDesc, $fangsur3, 0, $vNom, 'fangsur3');
	}
	
	if ($fangsur3 > 0) {
		$vDesc = "Angsuran 4";
		$vNom = $fstorawal + $fangsur1 + $fangsur2 + $fangsur3 + $fangsur4;
		$oKomisi->insertPayment($vIdMem, $vIdMem, date("Y-m-d H:i:s"), $vDesc, $fangsur4, 0, $vNom, 'fangsur4');
	}
	
	if ($flunas > 0) {
		$vDesc = "Pelunasan";
		$vNom = $fstorawal + $fangsur1 + $fangsur2 + $fangsur3 + $fangsur4 + $flunas;
		$oKomisi->insertPayment($vIdMem, $vIdMem, date("Y-m-d H:i:s"), $vDesc, $flunas, 0, $vNom, 'flunas');
	}
	
	if ($fairporttax > 0) {
		$vDesc = "Perlengkapan";
		$vNom = $fstorawal + $fangsur1 + $fangsur2 + $fangsur3 + $fangsur4 + $flunas + $fairporttax;
		$oKomisi->insertPayment($vIdMem, $vIdMem, date("Y-m-d H:i:s"), $vDesc, $fairporttax, 0, $vNom, 'handle');
	}
	
	if ($fassure > 0) {
		$vDesc = "Asuransi";
		$vNom = $fstorawal + $fangsur1 + $fangsur2 + $fangsur3 + $fangsur4 + $flunas + $fairporttax + $fassure;
		$oKomisi->insertPayment($vIdMem, $vIdMem, date("Y-m-d H:i:s"), $vDesc, $fassure, 0, $vNom, 'assure');
	}
	
	if ($farabassure > 0) {
		$vDesc = "Asuransi Saudi Arabia";
		$vNom = $fstorawal + $fangsur1 + $fangsur2 + $fangsur3 + $fangsur4 + $flunas + $fairporttax + $fassure + $farabassure;
		$oKomisi->insertPayment($vIdMem, $vIdMem, date("Y-m-d H:i:s"), $vDesc, $farabassure, 0, $vNom, 'arabassure');
	}
	
	$vSQL = "update m_anggota set faktif='1', ftglaktif=now() where fidmember='$vIdMem' ;";
	if($db->query($vSQL)) {
		$db->query("COMMIT;");
		echo 'success';
	} else {
		$db->query("ROLLBACK;");
		echo 'failed';
	}
	
} else if ($vOP == "unblocktab") {

	$vIdMem = $_GET['od'];
	$vSQL = "select * from m_anggota_tab where fidmember='$vIdMem'";
	$db->query($vSQL);
	$db->next_record();
	$ftgldepart = $db->f('ftgldepart');
	
	$vSQL = "select * from m_infodep_tab where ftgldepart='$ftgldepart' ";
	$db->query($vSQL);
	$db->next_record();
	$vSisa = $db->f('fsisaseat');
	
	$vSQL = "update m_infodep_tab set fsisaseat=fsisaseat-1 where ftgldepart='$ftgldepart'";
	$db->query($vSQL);
	
	$vSQL = "INSERT INTO tb_logchange(fkdanggota, fold, fnew, ftipe, fket, fstatusrow, ftglentry) ";
	$vSQL .= "values('$vIdMem', $vSisa, $vSisa-1, 'deduct-seat', 'Pengurangan Seat Tabungan (Pendaftaran)', '1', now());";
	$db->query($vSQL);
	
	$vSQL = "update m_anggota_tab set faktif='1', ftglaktif=now() where fidmember='$vIdMem' ;";
	if($db->query($vSQL)) {
		echo 'success';
	} else echo 'failed';
	
} else if ($vOP == 'approvekit') {

	// S
	$db->query("START TRANSACTION;");
	$vSQL = "select * from tb_trxkit where fidpenjualan='$vIdTrx' and fjenis='S'";
	$db1->query($vSQL);
	$db1->next_record();
	$vAmount = $db1->f('fjumlah');
	$vIdMem = $db1->f('fidmember');
	
	$vSerJual = "";
	for ($x = 0; $x < $vAmount; $x++) {
		$vSQL = "select * from tb_skit where fstatus='1' and fpaket='S' limit 1";
		$db1->query($vSQL);
		$db1->next_record();
		$vSerial = $db1->f('fserno');
		
		$vSQL = "update tb_skit set fstatus='2', ftgldist=now(), fpendistribusi='$vIdMem',frefpurc='$vIdTrx' where fserno='$vSerial'";
		$db->query($vSQL);
		if ($x < ($vAmount - 1))
			$vSerJual .= $vSerial . ",";
		else
			$vSerJual .= $vSerial;
	}
	
	$vSQL = "update tb_trxkit set fserno = '$vSerJual', fprocessed ='2',ftglprocessed=now() where fidpenjualan='$vIdTrx' and fjenis='S' ";
	$db1->query($vSQL);
	
	// G
	$vSQL = "select * from tb_trxkit where fidpenjualan='$vIdTrx' and fjenis='G'";
	$db1->query($vSQL);
	$db1->next_record();
	$vAmount = $db1->f('fjumlah');
	$vIdMem = $db1->f('fidmember');
	$vSerJual = "";
	for ($x = 0; $x < $vAmount; $x++) {
		$vSQL = "select * from tb_skit where fstatus='1' and fpaket='G' limit 1";
		$db1->query($vSQL);
		$db1->next_record();
		$vSerial = $db1->f('fserno');
		
		$vSQL = "update tb_skit set fstatus='2', ftgldist=now(), fpendistribusi='$vIdMem',frefpurc='$vIdTrx' where fserno='$vSerial'";
		$db->query($vSQL);
		if ($x < ($vAmount - 1))
			$vSerJual .= $vSerial . ",";
		else
			$vSerJual .= $vSerial;
	}
	
	$vSQL = "update tb_trxkit set fserno = '$vSerJual', fprocessed ='2',ftglprocessed=now() where fidpenjualan='$vIdTrx' and fjenis='G' ";
	$db->query($vSQL);
	
	// P
	$vSQL = "select * from tb_trxkit where fidpenjualan='$vIdTrx' and fjenis='P'";
	$db1->query($vSQL);
	$db1->next_record();
	$vAmount = $db1->f('fjumlah');
	$vIdMem = $db1->f('fidmember');
	$vSerJual = "";
	for ($x = 0; $x < $vAmount; $x++) {
		$vSQL = "select * from tb_skit where fstatus='1' and fpaket='P' limit 1";
		$db1->query($vSQL);
		$db1->next_record();
		$vSerial = $db1->f('fserno');
		
		$vSQL = "update tb_skit set fstatus='2', ftgldist=now(), fpendistribusi='$vIdMem',frefpurc='$vIdTrx' where fserno='$vSerial'";
		$db->query($vSQL);
		if ($x < ($vAmount - 1))
			$vSerJual .= $vSerial . ",";
		else
			$vSerJual .= $vSerial;
	}
	
	$vSQL = "update tb_trxkit set fserno = '$vSerJual', fprocessed ='2',ftglprocessed=now() where fidpenjualan='$vIdTrx' and fjenis='P' ";
	$db->query($vSQL);
	
	// =========start spread============//
	$vSQL = "select sum(fsubtotal) as subtotal from tb_trxkit where fidpenjualan='$vIdTrx' ";
	$db1->query($vSQL);
	$db1->next_record();
	$vTot = $db1->f('subtotal');
	
	$vStockStat = $oMember->getMemField('fstockist', $vIdMem);
	$vProsenFee = 0;
	
	// ffeetrxstmob
	if ($vStockStat == '1') {
		$vProsenFee = $oRules->getSettingByField('ffeetrxstmob');
	} else if ($vStockStat == '2') {
		$vProsenFee = $oRules->getSettingByField('ffeetrxststd');
	} else if ($vStockStat == '3') {
		$vProsenFee = $oRules->getSettingByField('ffeetrxstmst');
	}
	
	$vStockFee = $vTot * $vProsenFee / 100;
	$vSpon = $oNetwork->getSponsor($vIdMem);
	if ($vStockFee > 0)
		$oKomisi->spreadStBonus($vSpon, $vTot, $vStockFee, 'bnstrxkitst', 'nom', "Bonus Transaksi Serial Stockist $vIdMem", $vIdMem, $vIdTrx);
	// =========end spread============//
	
	echo "successappv";
	$db->query("COMMIT;");
	
} else if ($vOP == "rejectkit") {

	  

	$vSQL = "delete from tb_payment_temp where fidpenjualan='$vIdTrx' ";
	if($db->query($vSQL))
		echo 'successdel';
} else if ($vOP == "approvest") {
	$vPoin = 20;
	
	$vSQL = "update tb_stockist_temp set faktif='1', ftglaktif=now() where fidsys=$vIdSys ";
	if($db->query($vSQL))
		echo 'successappv';
	
	$vSQL = "select * from tb_stockist_temp where fidsys=$vIdSys ";
	$db->query($vSQL);
	$db->next_record();
	$vIdMember = $db->f('fidmember');
	$vIdSponsor = $db->f('fidsponsor');
	$vLevel = $db->f('ftype');
	
	$vSQL = "update tb_updown set fsponstock='$vIdSponsor' where fdownline='$vIdMember' ";
	$db->query($vSQL);
	
	$vSQL = "select * from m_anggota where fidmember='$vIdMember' ";
	$db->query($vSQL);
	$db->next_record();
	$vLevelOld = $db->f('fstockist');
	
	$vSQL = "update m_anggota set fstockist='$vLevel', ftglupgrade=now() where fidmember='$vIdMember' ";
	$db->query($vSQL);
	
	$vNewStockStat = $vLevel;
	$vOldStockStat = $vLevelOld;
	if ($vOldStockStat != $vNewStockStat) { //logging
		if (($vOldStockStat == '0' && $vNewStockStat == '2') || ($vOldStockStat == '1' && $vNewStockStat == '2')) {
			$vKet = "Promote stockist $vIdMember";
		} else if ($vOldStockStat == '0' && $vNewStockStat == '1') {
			$vKet = "Promote mobile stockist $vIdMember";
		} else if ($vOldStockStat == '2' && $vNewStockStat == '0') {
			$vKet = "Demote stockist $tfSerno";
		} else if ($vOldStockStat == '2' && $vNewStockStat == '1') {
			$vKet = "Demote stockist $vIdMember to mobile stockist";
		} else if ($vOldStockStat == '1' && $vNewStockStat == '0') {
			$vKet = "Demote mobile stockist $vIdMember";
		}
		
		$vSQL = "INSERT INTO tb_logchange(fkdanggota, fold, fnew, ftipe, fket, ftglentry) VALUES ('$vIdMember', '$vOldStockStat', '$vNewStockStat', 'promo-demo', '$vKet', now());";
		$db1->query($vSQL);
	}
	
	if ($vNewStockStat == '1') {
		$vFee = $vPoin;
		$vFeeSpon = 4;
		$vFeeOne = $oRules->getSettingByField('ffeeonestmob');
	} else if ($vNewStockStat == '2') {
		$vFee = $vPoin * 4;
		$vFeeSpon = 20;
		$vFeeOne = $oRules->getSettingByField('ffeeoneststd');
	} else if ($vNewStockStat == '3') {
		$vFee = $vPoin * 10;
		$vFeeSpon = 100;
		$vFeeOne = $oRules->getSettingByField('ffeeonestmst');
	}
	
	$oKomisi->spreadStBonus($vIdMember, 0, $vFee, 'bnstock', 'poin', 'Bonus Aktifasi sebagai Stockist', $vIdMember, $vKet);
	// $vSpon = $oNetwork->getSponsor($vIdMember);
	$vSpon = $vIdSponsor;
	// Sponsor
	$oKomisi->spreadStBonus($vSpon, 0, $vFeeSpon, 'bnstockspon', 'poin', "Bonus Sponsor Aktifasi Stockist $vIdMember", $vIdMember, $vKet);
	// Onetime
	$oKomisi->spreadStBonus($vSpon, 0, $vFeeOne, 'bnsone', 'nom', 'Bonus Onetime aktifasi sebagai Sponsor Stockist $vIdMember', $vIdMember, $vKet);
} else if ($vOP == 'approvepoin') {
	  

	// Pembayaran Poin
	$vSQL = "select * from tb_payment_temp where fidpenjualan='$vIdTrx' and fmethod='ctr' ";
	$db->query($vSQL);
	$db->next_record();
	$vMember = $db->f('fidmember');
	$vTotal = (float) $db->f('fsubtotal');
	$vPoint = (float) $db->f('fjumlah');
	$vPoinPrice = 1;
	
	// print_r($_POST);
	if (trim($vMember)) {
		$db->query("START TRANSACTION;");
		$vSQL = "insert into tb_payment (fidpenjualan, fidseller, fidmember, fnostockist, fidproduk, fjumlah, fhargasat, fsubtotal, fmethod, fketerangan, ftglentry, fprocessed, ftgltrans, fjmltrans, fjenis, ftglprocessed ) ";
		$vSQL .= "SELECT fidpenjualan, fidseller, fidmember, fnostockist, fidproduk, fjumlah, fhargasat, fsubtotal, fmethod, fketerangan, ftglentry, '2', ftgltrans, fjmltrans, fjenis, now() FROM tb_payment_temp where fidpenjualan='$vIdTrx';";
		$db->query($vSQL);
		
		$vSQLHist = "INSERT INTO tb_payhist(fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate, fref, fincometax, flog, fadminfee, fvat) select fidmember, fidmember, ftglentry, fketerangan, fsubtotal,0,fsubtotal,fidproduk,fprocessed, '" . $_SESSION['LoginUser'] . "',now(),fidpenjualan,0,'',0,0 from tb_payment_temp where fidpenjualan='$vIdTrx'; ";
		$db->query($vSQLHist);
		
		$vSQL = "select fidmember, fidmember, ftglentry, fketerangan, fsubtotal,0,fsubtotal,fidproduk,fprocessed, '" . $_SESSION['LoginUser'] . "',now(),fidpenjualan,0,'',0,0 from tb_payment_temp where fidpenjualan='$vIdTrx';";
		$db->query($vSQL);
		$db->next_record();
		$vFor = $db->f('fidproduk');
		
		$vSQLUpdate = "update m_anggota set $vFor = (select fsubtotal from tb_payment_temp where fidpenjualan='$vIdTrx' ) where fidmember = (select fidmember from tb_payment_temp where fidpenjualan='$vIdTrx' ) ";
		$db->query($vSQLUpdate);
		
		$vSQLUpdate = "update m_anggota set ftotalbayar=fstorawal + fangsur1+ fangsur2 + fangsur3 + fangsur4 + flunas where fidmember = (select fidmember from tb_payment_temp where fidpenjualan='$vIdTrx' ) ";
		$db->query($vSQLUpdate);
		
		$db->query($vSQLUpdate);
		
		$vSQL = "delete from tb_payment_temp where fidpenjualan='$vIdTrx'";
		$db->query($vSQL);
		
		if ($db->query("COMMIT;")) {
			echo 'successappv';
		}
	}
	
} else if ($vOP == 'markpay') {
	// Pembayaran Bonus
	$vSQL = "update tb_komisi set fmark='1' where fidsys='$vIdSys' ";
	$db->query($vSQL);
	echo 'successmark';
	
} else if ($vOP == "delsell") {
	$vIdMem = $_GET['od'];
	$vSQL = "delete from m_seller where fidseller='$vIdMem' ;";
	if($db->query($vSQL)) {
		echo 'success';
	} else echo 'failed';
}

?>
