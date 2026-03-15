<?php
include_once "../server/config.php";
include_once CLASS_DIR . "networkclass.php";

// Tidak harus include, untuk membantu saat coding saja
include_once "../classes/memberclass.php";
include_once "../classes/komisiclass.php";
include_once "../classes/networkclass.php";
include_once "../classes/ruleconfigclass.php";
include_once "../classes/jualclass.php";

// echo "Resetting tables...!";
$vOP = $_GET['op'];
$vKind = $_GET['kind'];
$vIdTrx = $_GET['idtrx'];
$vIdSys = $_GET['idsys'];

if ($vOP == "rejectst") {
	$vSQL = "delete from tb_stockist_temp where fidsys='$vIdSys' ";
	if($db->query($vSQL))
		echo 'successdel';
} else if ($vOP == "reject") {
	$vSQL = "delete from tb_trxstok_temp where fidpenjualan='$vIdTrx' ";
	if($db->query($vSQL))
		echo 'successdel';
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
	
	$vSQL = "select sum(fsubtotal) as ftotal from tb_trxstok_member_temp where fidpenjualan='$vIdTrx' ";
	$dbin->query($vSQL);
	$dbin->next_record();
	$vTotal = $dbin->f('ftotal');

	$vSQL = "select fongkir from tb_trxstok_member_temp where fidpenjualan='$vIdTrx' ";
	$dbin->query($vSQL);
	$dbin->next_record();
	$vOngkir = $dbin->f('fongkir');

	$vSQL = "select fidmember, fnostockist, fmethod from tb_trxstok_member_temp where fidpenjualan='$vIdTrx' limit 1";
	$dbin->query($vSQL);
	$dbin->next_record();
	$vBuyerTrx = $dbin->f('fidmember');
	$vPayerTrx = $dbin->f('fnostockist');
	$vMethodTrx = $dbin->f('fmethod');
	if (trim($vPayerTrx) == '')
		$vPayerTrx = $vBuyerTrx;

	if ($vMethodTrx == 'wpr') {
		$vLastBalBiz = $oMember->getMemFieldBis('fsaldovcr', $vPayerTrx);
		if ($vLastBalBiz < $vTotal) {
			$db->query("ROLLBACK;");
			echo 'not_e_bonusbalance';
			exit;
		}
	}
	
	$vSQL = "insert into tb_trxstok_member( `fidpenjualan` , `fidseller` , `fidmember` , `falamatkrm` , `fnostockist` , `fidproduk` , `fjumlah` , `ftanggal` , `fhargasat` , `fsubtotal` , `fsize` , `fcolor` , `ftgltrans` , `fjenis` , `fjmltrans` , `fserial` , `fpin` , `fmethod` , `fketerangan` , `ftglentry` , `fprocessed` , `ftglprocessed`,`fongkir`,`fberat`, `fcountry`, `fprop`, `fkota`, `fkec`, `fexpe`, `fpack`, `frecname`, `frecnohp`) ";
	$vSQL .= "select `fidpenjualan` , `fidseller` , `fidmember` , `falamatkrm` , `fnostockist` , `fidproduk` , `fjumlah` , `ftanggal` , `fhargasat` , `fsubtotal` , `fsize` , `fcolor` , `ftgltrans` , `fjenis` , `fjmltrans` , `fserial` , `fpin` , `fmethod` , `fketerangan` , `ftglentry` , `fprocessed` , now(), `fongkir`,`fberat`, `fcountry`, `fprop`, `fkota`, `fkec`, `fexpe`, `fpack`, `frecname`, `frecnohp` from tb_trxstok_member_temp where fidpenjualan='$vIdTrx' ";
	
	if($db->query($vSQL)) {
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
			
			$vSQL = "INSERT INTO `tb_mutasi_stok` (`fidmember` ,`fidproduk` ,`fsize` ,`fcolor` ,`fidfunder` ,`ftanggal` ,`fdesc` ,`fcredit` ,`fdebit` ,`fbalance` ,`fkind` ,`fstatus` ,`flastuser` ,`flastupdate` ,`fref`) ";
			$vSQL .= "VALUES ('$vSeller', '$vIDProduk' , NULL , NULL , '', now(), 'RO Sales [$vIdMem]',$vAmount, 0, $vNewBal, 'JRO', '1', '$vSeller', now(), '$vIdTrx');";
			$db->query($vSQL);
			
			$oMember->setSaldoStockWH($vSeller, $vIDProduk, $vNewBal, $db);
		}
		
		$vSQL = "update tb_trxstok_member set fketerangan=concat(fketerangan,', Ket: $vResi') where fidpenjualan='$vIdTrx'";
		$db->query($vSQL);
		
		$vSQL = "delete from tb_trxstok_member_temp where fidpenjualan='$vIdTrx' ";
		$db->query($vSQL);
		
		// Mutasi Si member
		$vUserTrx = $vPayerTrx;
		$vBuyer = $vIdMem;
		$vNextJual = $vIdTrx;

		if ($vMethodTrx == 'wpr') {
			$vLastBal = $oMember->getMemFieldBis('fsaldovcr', $vUserTrx);
			$vNewBal = $vLastBal - $vTotal;
			$vsql = "insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fincometax,fref) ";
			$vsql .= "values ('$vUserTrx', '$vBuyer', now(),'Repeat Order Sales $vNextJual [Potong Saldo Pebisnis - Approval]' , 0,$vTotal ,$vNewBal ,'reorder' , '1','$vUserTrx' , now(),0,'$vNextJual') ";
			$db->query($vsql);
			$oMember->updateBalConnWProdBiz($vUserTrx, $vNewBal, $db);
		}
		
		$vIDMember = $oJual->getMemberByJual($vIdTrx);
		$vJumlah = $oJual->getBuyedTot($vIdTrx);
		// $oNetwork->sendFeeTitikCompress('EDUARDO',20,1000000,'J7777777');
		// $oNetwork->sendFeeTitikCompress($vIDMember,20,$vJumlah,$vIdTrx);
		//Pencairan ke Seller
		$vSellSession = md5('jalanku');
		if ($vMethod == 'tva') {
			include("payseller.php");
		}
		echo 'successappv';
	}
	$db->query("COMMIT;");
	
} else if ($vOP == "approvesell" && $vKind == 'kit') {

	$vResi = $_GET['noresi'];
	$vKind = "Penjualan";
	$db->query("START TRANSACTION;");
	
	$vSQL = "select sum(fsubtotal) as ftotal from tb_trxstok_member_temp where fidpenjualan='$vIdTrx' ";
	$dbin->query($vSQL);
	$dbin->next_record();
	$vTotal = $dbin->f('ftotal');
	
	$vSQL = "insert into tb_trxstok_member( `fidpenjualan` , `fidseller` , `fidmember` , `falamatkrm` , `fnostockist` , `fidproduk` , `fjumlah` , `ftanggal` , `fhargasat` , `fsubtotal` , `fsize` , `fcolor` , `ftgltrans` , `fjenis` , `fjmltrans` , `fserial` , `fpin` , `fmethod` , `fketerangan` , `ftglentry` , `fprocessed` , `ftglprocessed`) ";
	$vSQL .= "select `fidpenjualan` , `fidseller` , `fidmember` , `falamatkrm` , `fnostockist` , `fidproduk` , `fjumlah` , `ftanggal` , `fhargasat` , `fsubtotal` , `fsize` , `fcolor` , `ftgltrans` , `fjenis` , `fjmltrans` , `fserial` , `fpin` , `fmethod` , `fketerangan` , `ftglentry` , `fprocessed` , now() from tb_trxstok_member_temp where fidpenjualan='$vIdTrx' ";
	
	if($db->query($vSQL)) {
		$vSQLSelect = "select * from tb_trxstok_member_temp where fidpenjualan='$vIdTrx' ";
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
		
		$vSQL = "update tb_trxstok_member set fketerangan=concat(fketerangan,', Ket: $vResi') where fidpenjualan='$vIdTrx'";
		$db->query($vSQL);
		
		$vSQL = "delete from tb_trxstok_member_temp where fidpenjualan='$vIdTrx' ";
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
	
} else if ($vOP == "approvesell" && $vKind == 'acc') {

	$vResi = $_GET['noresi'];
	$vKind = "Penjualan";
	$db->query("START TRANSACTION;");
	
	$vSQL = "select sum(fsubtotal) as ftotal from tb_trxstok_member_temp where fidpenjualan='$vIdTrx' ";
	$dbin->query($vSQL);
	$dbin->next_record();
	$vTotal = $dbin->f('ftotal');
	
	$vSQL = "insert into tb_trxstok_member( `fidpenjualan` , `fidseller` , `fidmember` , `falamatkrm` , `fnostockist` , `fidproduk` , `fjumlah` , `ftanggal` , `fhargasat` , `fsubtotal` , `fsize` , `fcolor` , `ftgltrans` , `fjenis` , `fjmltrans` , `fserial` , `fpin` , `fmethod` , `fketerangan` , `ftglentry` , `fprocessed` , `ftglprocessed`) ";
	$vSQL .= "select `fidpenjualan` , `fidseller` , `fidmember` , `falamatkrm` , `fnostockist` , `fidproduk` , `fjumlah` , `ftanggal` , `fhargasat` , `fsubtotal` , `fsize` , `fcolor` , `ftgltrans` , `fjenis` , `fjmltrans` , `fserial` , `fpin` , `fmethod` , `fketerangan` , `ftglentry` , `fprocessed` , now() from tb_trxstok_member_temp where fidpenjualan='$vIdTrx' ";
	
	if($db->query($vSQL)) {
		$vSQLSelect = "select * from tb_trxstok_member_temp where fidpenjualan='$vIdTrx' ";
		$dbin->query($vSQLSelect);
		
		while ($dbin->next_record()) {
			$vIdMem = $dbin->f('fidmember');
			$vIDProduk = $dbin->f('fidproduk');
			$vAmount = $dbin->f('fjumlah');
			$vSeller = $dbin->f('fidseller');
			$vMethod = $dbin->f('fmethod');
		}
		
		$vSQL = "update tb_trxstok_member set fketerangan=concat(fketerangan,', Ket: $vResi') where fidpenjualan='$vIdTrx'";
		$db->query($vSQL);
		
		$vSQL = "delete from tb_trxstok_member_temp where fidpenjualan='$vIdTrx' ";
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
