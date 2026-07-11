<? include_once("../framework/admin_headside.blade.php")?>

<?php

function amhStatDispDetSellOut($pIDJual) {
	global $db, $oProduct;
	$vsql = "select a.fidproduk,a.fhargasat, a.fjumlah, b.fnamaproduk,a.fsize, a.fcolor from tb_penjualan_temp_out a";
	$vsql .= " left join m_product b on a.fidproduk=b.fidproduk where a.fidpenjualan='$pIDJual'";
	echo "<table width='110' border='0' style='margin-top:-0.9em'>";
	$db->query($vsql);
	while ($db->next_record()) {
		$vIDProd = $db->f('fidproduk');
		$vProd = str_replace(' ', '&nbsp;', $vIDProd . '/' . $db->f('fnamaproduk') . ' (' . number_format($db->f('fhargasat'), 0, ',', '.') . ')');
		$vJum = $db->f('fjumlah');
		echo '<tr><td width="90" valign="top"><div align="left">' . $vProd . '</div></td>';
		echo '<td><div align="left" valign="top">:</div></td>';
		echo '<td valign="top"><div align="right">' . $vJum . '</div></td></tr>';
	}
	echo '</table>';
}

function amhStatGetSellTotOut($pIDJual) {
	global $db;
	$db->query("select sum(fsubtotal) as stot from tb_penjualan_temp_out where fidpenjualan='$pIDJual'");
	$db->next_record();
	return (float)$db->f('stot');
}

function amhStatGetOngkirOut($pIDJual) {
	global $db;
	$db->query("select fongkir from tb_penjualan_temp_out where fidpenjualan='$pIDJual' limit 1");
	if ($db->next_record())
		return (float)$db->f('fongkir');
	return 0;
}

function amhStatEsc($pVal) {
	global $db;
	if (is_object($db) && method_exists($db, 'escape_string'))
		return $db->escape_string((string)$pVal);
	return addslashes((string)$pVal);
}

function amhStatGetTrxReceiveField($dbConn) {
	$vReceiveFields = array('freceived', 'freceive');
	foreach ($vReceiveFields as $vFieldName) {
		$vHasTemp = false;
		$vHasMain = false;
		$dbConn->query("SHOW COLUMNS FROM tb_penjualan_temp LIKE '$vFieldName'");
		if ($dbConn->next_record())
			$vHasTemp = true;
		$dbConn->query("SHOW COLUMNS FROM tb_penjualan LIKE '$vFieldName'");
		if ($dbConn->next_record())
			$vHasMain = true;
		if ($vHasTemp && $vHasMain)
			return $vFieldName;
	}
	return '';
}

function amhStatDateExprOut() {
	return "COALESCE(NULLIF(ftanggal,'0000-00-00 00:00:00'), NULLIF(ftglentry,'0000-00-00 00:00:00'), ftanggal)";
}

function amhStatDateCrit($pAwal, $pAkhir) {
	$vAwal = amhStatEsc($pAwal);
	$vAkhir = amhStatEsc($pAkhir);
	return " and date(ftanggal) >= '$vAwal' and date(ftanggal) <= '$vAkhir' ";
}

function amhStatDateCritOut($pAwal, $pAkhir) {
	$vExpr = amhStatDateExprOut();
	$vAwal = amhStatEsc($pAwal);
	$vAkhir = amhStatEsc($pAkhir);
	return " and date($vExpr) >= '$vAwal' and date($vExpr) <= '$vAkhir' ";
}

function amhStatWhereAminahkuOut($pLogin) {
	$vLogin = amhStatEsc($pLogin);
	return " (TRIM(fnostockist)='$vLogin' OR TRIM(fidmember)='$vLogin')
		AND (LOWER(TRIM(IFNULL(fuserid,'')))='aminahku' OR IFNULL(fketerangan,'') LIKE '%link luar%')
		AND (IFNULL(fprocessed,'0')='0' OR IFNULL(fprocessed,0)=0) ";
}

function amhStatPullRow($pDb) {
	return array(
		'ftanggal' => $pDb->f('ftanggal'),
		'fidpenjualan' => $pDb->f('fidpenjualan'),
		'fidseller' => $pDb->f('fidseller'),
		'fidmember' => $pDb->f('fidmember'),
		'fketerangan' => $pDb->f('fketerangan'),
		'fongkir' => $pDb->f('fongkir'),
		'fstatus' => $pDb->f('fstatus'),
		'fmethod' => $pDb->f('fmethod'),
		'fuserid' => $pDb->f('fuserid'),
		'fprocessed' => $pDb->f('fprocessed'),
	);
}

function amhStatLoadMergedList($pLogin, $pAwal, $pAkhir) {
	global $db;
	$vLogin = amhStatEsc($pLogin);
	$vCrit = amhStatDateCrit($pAwal, $pAkhir);
	$vCritOut = amhStatDateCritOut($pAwal, $pAkhir);
	$vMap = array();

	$vsql = "select distinct ftanggal, fidpenjualan, fidseller, fidmember, fketerangan, fongkir,
		'1' as fstatus, fmethod, '' as fuserid, cast(ifnull(fprocessed,0) as char) as fprocessed
		from tb_penjualan where fidproduk not like 'KIT%' and fidmember='$vLogin' $vCrit";
	$db->query($vsql);
	while ($db->next_record())
		$vMap[$db->f('fidpenjualan')] = amhStatPullRow($db);

	$vsql = "select distinct ftanggal, fidpenjualan, fidseller, fidmember, fketerangan, fongkir,
		'0' as fstatus, fmethod, ifnull(fuserid,'') as fuserid, cast(ifnull(fprocessed,0) as char) as fprocessed
		from tb_penjualan_temp where fidproduk not like 'KIT%' and fidmember='$vLogin' $vCrit";
	$db->query($vsql);
	while ($db->next_record())
		$vMap[$db->f('fidpenjualan')] = amhStatPullRow($db);

	$vsql = "select distinct " . amhStatDateExprOut() . " as ftanggal, fidpenjualan, fidseller, fidmember, fketerangan, fongkir,
		'out' as fstatus, ifnull(fmethod,'') as fmethod, ifnull(fuserid,'') as fuserid, cast(ifnull(fprocessed,0) as char) as fprocessed
		from tb_penjualan_temp_out
		where fidproduk not like 'KIT%' and " . amhStatWhereAminahkuOut($pLogin) . $vCritOut;
	if ($db->query($vsql)) {
		while ($db->next_record())
			$vMap[$db->f('fidpenjualan')] = amhStatPullRow($db);
	} else {
		$vsql = "select distinct ftanggal, fidpenjualan, fidseller, fidmember, fketerangan, fongkir,
			'out' as fstatus, ifnull(fmethod,'') as fmethod, '' as fuserid, '0' as fprocessed
			from tb_penjualan_temp_out
			where fidproduk not like 'KIT%' and (TRIM(fnostockist)='$vLogin' OR TRIM(fidmember)='$vLogin')
			and (IFNULL(fketerangan,'') LIKE '%link luar%' OR IFNULL(fketerangan,'') LIKE '%menunggu pebisnis%') $vCrit";
		$db->query($vsql);
		while ($db->next_record())
			$vMap[$db->f('fidpenjualan')] = amhStatPullRow($db);
	}
	
	// Add records from tb_penjualan_temp_out where fidmember matches the logged-in seller
	$vsql = "select distinct " . amhStatDateExprOut() . " as ftanggal, fidpenjualan, fidseller, fidmember, fketerangan, fongkir,
		'out' as fstatus, ifnull(fmethod,'') as fmethod, ifnull(fuserid,'') as fuserid, cast(ifnull(fprocessed,0) as char) as fprocessed
		from tb_penjualan_temp_out
		where fidproduk not like 'KIT%' and TRIM(fidmember)='$vLogin' $vCritOut";
	if ($db->query($vsql)) {
		while ($db->next_record())
			$vMap[$db->f('fidpenjualan')] = amhStatPullRow($db);
	}

	$vList = array_values($vMap);
	usort($vList, function ($a, $b) {
		$vCmp = strcmp((string)$a['ftanggal'], (string)$b['ftanggal']);
		if ($vCmp != 0)
			return $vCmp;
		return strcmp((string)$a['fidpenjualan'], (string)$b['fidpenjualan']);
	});
	return $vList;
}

$vOutlet=$_SESSION['LoginOutlet'];
$vAwal=$_POST['dc'];
$vAkhir=$_POST['dc1'];
$vSpy = md5('spy').md5($_GET['uMemberId']);
$vReceiveField = amhStatGetTrxReceiveField($dbin);
$vReceiveSelect = ($vReceiveField != '') ? $vReceiveField . " as freceived" : "'0' as freceived";

 if ($_GET['uMemberId'] != '')
    $vUserActive=$_GET['uMemberId'];
 else  $vUserActive=$vUser;
 
// echo $vUserActive;

if ($vAwal=="")
	$vAwal=$_GET['uAwal'];
if ($vAkhir=="")
	$vAkhir=$_GET['uAkhir'];


if ($vAwal=="") {
   $vAwal=date('Y-m-d', mktime(0, 0, 0, date('m') - 1, 1, date('Y')));
   $vSQLMin = "select min(date(COALESCE(NULLIF(ftanggal,'0000-00-00 00:00:00'), NULLIF(ftglentry,'0000-00-00 00:00:00'), ftanggal))) as mindate from tb_penjualan_temp_out where TRIM(fidmember)='{$_SESSION['LoginUser']}' and (ifnull(fprocessed,'0')='0' or ifnull(fprocessed,0)=0)";
   $dbin->query($vSQLMin);
   if ($dbin->next_record()) {
      $vMinDate = $dbin->f('mindate');
      if ($vMinDate != '' && $vMinDate < $vAwal) {
         $vAwal = $vMinDate;
      }
   }
}
   
if ($vAkhir=="")
   $vAkhir=$oPhpdate->getNowYMD("-");

   
$vPrevWeek=$oMydate->getPrevWeek($vTanggal);
$vWeek=$oMydate->getWeek($vTanggal);
$vYear=$oMydate->getYear($vTanggal);   
if ($vWeek==52)
    $vPrevYear=$vYear-1;
else
     $vPrevYear= $vYear;	
$oMydate->setCritPrevDate("ftglkomisi",$vTanggal);	 

$vPage=$_GET['uPage'];
$vBatasBaris=35;
if ($vPage=="")
 	$vPage=0;
$vStartLimit=$vPage * $vBatasBaris;	

$vCrit = amhStatDateCrit($vAwal, $vAkhir);

 $vLoginEsc = $_SESSION['LoginUser'];
 $vStatAllRows = amhStatLoadMergedList($vLoginEsc, $vAwal, $vAkhir);
 $vRecordCount = count($vStatAllRows);
 $vPageCount=ceil($vRecordCount/$vBatasBaris);
 if ($vPageCount < 1)
    $vPageCount = 1;
 $vStatPageRows = array_slice($vStatAllRows, $vStartLimit, $vBatasBaris);

?>
<style type="text/css">
.modal-content  {
    -webkit-border-radius: 3px !important;
    -moz-border-radius: 3px !important;
    border-radius: 3px !important; 
}
</style>


<script language="JavaScript" type="text/JavaScript">
 <? if ($_SESSION['Priv'] =='seller') {?>
 		alert('Halaman ini hanya untuk pebisnis!');
		document.location.href='../manager/indexnonadmin.php';
 <?  } ?>
 
  <? if ($_SESSION['Priv'] =='administrator') {?>
 		alert('Halaman ini hanya untuk pebisnis!');
		document.location.href='../manager/indexadmin.php';
 <?  } ?>
function printTrx(pParam,pTgl,pIDMem) {
	var vURL='../memstock/detjual.php?uNoJual='+pParam+'&uTanggal='+pTgl+'&uIDMember='+pIDMem;
	window.open(vURL,'wPrint','width=900 height=600');
}

$(document).ready(function(){
    $('#caption').html('PO Approval');


      $('#dc').datepicker({
                    format: "yyyy-mm-dd",
                    autoclose : true
    }).on('changeDate', function (ev) {
    $(this).datepicker('hide');
    });  
; 
  
  
       $('#dc1').datepicker({
                    format: "yyyy-mm-dd",
                    autoclose : true
    }).on('changeDate', function (ev) {
    $(this).datepicker('hide');
    });  
; 

});


function doBayar(pKode,pKomisi,pSisa,pBatas) {
   pSisa=parseInt(pSisa);
   pBatas=parseInt(pBatas);

    if (pSisa<pBatas) {
	   alert('Komisi tidak bisa dibayarkan karena sisa komisi kurang dari batas minimum transfer!');
	   return false;
	}
	window.location='admin.php?menu=buktitfr&uKd='+pKode+'&uKom='+pKomisi;
}


function doBayarBuy(pKode,pKomisi,pSisa,pBatas) {
   pSisa=parseInt(pSisa);
   pBatas=parseInt(pBatas);

    if (pSisa<pBatas) {
	   alert('Komisi tidak bisa dibayarkan karena sisa komisi kurang dari batas minimum transfer!');
	   return false;
	}
	window.location='admin.php?menu=buktitfrsell&uKd='+pKode+'&uKom='+pKomisi;
}//-->

function doApprove1(pSys,pTrx,pKind) {
   $('#spJual').html(pTrx);	
   $('#hIdSys').val(pSys);
   $('#hIdTrx').val(pTrx);   
   $('#hKind').val(pKind);   
   $('#btnModal').trigger('click');	
}

function doApprove2(pIdSys,pIdTrx,pKind) {
   var vResi= $('#tfResi').val();
   var vURL='../manager/processing_ajax.php?op=approvesell&idsys='+pIdSys+'&idtrx='+pIdTrx+'&noresi='+vResi+'&kind='+pKind;
   var vNotEnough = /notenough/g;
   var vNotEnoughBal=/not_e_deposit/g
   if (confirm('Are you sure to approve Penjualan '+pIdTrx+'?')) {
	   $.get(vURL,function(data) {
	      if(data.trim()=='successappv') {
	        alert('Approval succeed, stock updated!');
	        $('#tdstat'+pIdTrx).html('Selesai');
  			document.getElementById('btnAppv'+pIdTrx).disabled=true;
  			document.getElementById('btnReject'+pIdTrx).disabled=true;
			//$('#dialogModal').hide();
	      } else if (vNotEnough.test(data.trim())) {
			  var vData=data.split('_');
			  var vKode=vData[1];
			 alert('Approval failed, stock '+vKode+' tidak cukup!');   
			// $('#dialogModal').hide();
		  }  else if (vNotEnoughBal.test(data.trim())) {
			 
			 alert('Approval failed, saldo reseller tidak cukup!');   
			// $('#dialogModal').hide();
		  }
	   });
   }
}


function doReject(pIdSys,pIdTrx) {
   var vURL='../manager/processing_ajax.php?op=reject&idsys='+pIdSys+'&idtrx='+pIdTrx;
   if (confirm('Are you sure to reject & delete permanently PO '+pIdTrx+'?')) {
	   $.get(vURL,function(data) {
	    //  alert(data);
	      if (data.trim()=='successdel') {
	         alert('Pembelian rejected!');
	         $('#tdstat'+pIdTrx).html('Rejected');
			 $('#tr'+pIdTrx).hide('slow');
	      }
	   });
   }
}

function doMarkReceived(pIdTrx) {
   if (!confirm('Konfirmasi pembeli sudah menerima barang untuk order ' + pIdTrx + '?'))
      return false;
   var vURL = '../manager/processing_ajax.php?op=markreceived&idtrx=' + encodeURIComponent(pIdTrx);
   $.get(vURL, function(data) {
      var vRes = data.trim();
      if (vRes == 'success') {
         $('#tdstat' + pIdTrx).html('Diproses (Sudah Diterima)');
         var vBtn = document.getElementById('btnReceived' + pIdTrx);
         if (vBtn)
            vBtn.style.display = 'none';
         alert('Konfirmasi penerimaan berhasil dicatat.');
      } else if (vRes == 'already') {
         $('#tdstat' + pIdTrx).html('Diproses (Sudah Diterima)');
         var vBtn2 = document.getElementById('btnReceived' + pIdTrx);
         if (vBtn2)
            vBtn2.style.display = 'none';
      } else if (vRes == 'notsent') {
         alert('Barang belum ditandai dikirim oleh seller.');
      } else if (vRes == 'notpaid') {
         alert('Pembayaran belum selesai.');
      } else if (vRes == 'denied') {
         alert('Anda tidak berhak mengonfirmasi transaksi ini.');
      } else {
         alert('Konfirmasi penerimaan gagal. Silakan refresh halaman dan coba lagi.');
      }
   });
}

</script>
<!--	<link rel="stylesheet" href="../css/screen.css">-->

	
	
 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />

<div class="right_col" role="main">
		<div><label>
		<h3> List / Status Pembelian dari <?=$_SESSION['LoginUser']?></h3></label></div>
<button type="button" class="btn btn-info btn-lg hide" id="btnModal" data-toggle="modal" data-target="#dialogModal">Open Modal</button>

<div class="modal fade" id="dialogModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="modalhead">Approve Penjualan [<span id="spJual"></span>]</span></h4>
        </div>
        <div class="modal-body " style="padding: 2em 4em 3em 4em">
        <div class="row">
             <div class="col-lg-6" id="divContent">
                 Masukkan catatan atau bukti pengambilan/pengiriman jika diperlukan :
                 <textarea name="tfResi" id="tfResi" class="form-control" value="-"></textarea>
             </div>
           
          </div>
          



        </div>
        <div class="modal-footer">
          <input type="hidden" id="hIdSys" name="hIdSys" value="" />
          <input type="hidden" id="hIdTrx" name="hIdTrx" value="" />
           <input type="hidden" id="hKind" name="hKind" value="" />
          <button type="button" id="btSubmit" name="btSubmit" class="btn btn-success" data-dismiss="modal" onClick="doApprove2($('#hIdSys').val(),$('#hIdTrx').val(),$('#hKind').val())">Submit</button>
          <button type="button" id="btClose" name="btClose" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

<form action="" method="post" name="demoform">

          <div style="display:inline" align="left">
          <strong>Date : </strong>
          <input style="width:100px;display:inline" class="form-control" name="dc" id="dc" size="11" value="<?=$vAwal?>">&nbsp; <strong>
			  to</strong>
          <input style="width:100px;display:inline" class="form-control" name="dc1" id="dc1" size="11" value="<?=$vAkhir?>"> &nbsp;&nbsp;
          <input style="display:inline" name="Submit22" type="submit" class="btn btn-success" value="Refresh">
          
          </div>
          <br /><br />
<br />


    <div class="table-responsive">
        <table width="90%" border="0" class="table table-striped">
          <tr >
            <td style="height: 24px; width: 5%;"><strong>No.</strong></td>
            <td width="10%" style="height: 24px" nowrap><div align="center"><strong>Date</strong></div></td>
            <td  width="15%" style="height: 24px" ><div align="left"><strong>No. Pembelian</strong></div></td>
            <td  width="15%" style="height: 24px" class="hide"><strong>Seller Username</strong></td>
            <td width="12%" align="center" style="height: 24px"><strong>Seller</strong></td>
            <td width="12%" align="center" style="height: 24px"><strong>&nbsp;Detail Product </strong></td>
            <td width="14%" align="center" style="height: 24px"><strong>Ongkos Krm & Admin</strong></td>
            <td width="14%" align="center" style="height: 24px"><strong>Total Produk </strong></td>
            <td width="14%" align="center" style="height: 24px"><strong>Status</strong></td>
           <? if ($_SESSION['Priv'] !='seller') {?> <td width="14%" align="center" style="height: 24px"><strong>Action</strong> <? } ?></td>
          </tr>
          <? 
             $vNo=0;
			 $vTotJual=0;
			 foreach ($vStatPageRows as $vStatRow) {
			 $vNo++;
				 $vTanggal=$vStatRow['ftanggal'];
				 $vIdMember=$vStatRow['fidmember'];
				 $vIdSeller=$vStatRow['fidseller'];
				
				 $vNama=$oMember->getMemberNameAdm($vIdMember,'sponsor');
				 
				 $vKet=$vStatRow['fketerangan'];
				 $vStat=$vStatRow['fstatus'];
				 $vMethod=$vStatRow['fmethod'];
				 $vFuserid=strtolower(trim((string)$vStatRow['fuserid']));
				 $vFprocessed=trim((string)$vStatRow['fprocessed']);
				 $vIdSys='';
				 $vIdTrx=$vStatRow['fidpenjualan'];
				  $vIdProd=$oJual->getKindProd($vIdTrx);
				 if (preg_match("/KIT/i",$vIdProd)) 
				    $vKind='kit';
				 else	if (preg_match("/SUPP/i",$vIdProd)) 
				    $vKind='acc';
			     else		
				    $vKind='prd';
				 
				 //$vtgltrans=$db->f('ftanggal');
				 
				 $vIDJual = $vStatRow['fidpenjualan'];
        $vAMHFee = 0;
        if ($vStat == 'out') {
				$dbin->query("select fidproduk from tb_penjualan_temp_out where fidpenjualan='$vIDJual' limit 1");
				$dbin->next_record();
				$vProduk = $dbin->f('fidproduk');
				$vPaid = '0';
				$vSend = '0';
        } else {
				$vSendTemp = '';
				$vReceivedTemp = '';
				$vSQLTemp = "select fsend, $vReceiveSelect from tb_penjualan_temp where fidpenjualan='$vIDJual' limit 1";
				$dbin->query($vSQLTemp);
				if ($dbin->next_record()) {
					$vSendTemp = trim((string)$dbin->f('fsend'));
					$vReceivedTemp = trim((string)$dbin->f('freceived'));
				}
				  $vSQL = "select * from  (select fidpenjualan, fidproduk,fpaid, fsend, $vReceiveSelect from tb_penjualan union  select fidpenjualan, fidproduk,fpaid, fsend, $vReceiveSelect from tb_penjualan_temp) as a left join tb_trx_va b on a.fidpenjualan=b.va_refid where a.fidpenjualan='$vIDJual' ";
				$dbin->query($vSQL);
				$dbin->next_record();
				$vProduk = $dbin->f('fidproduk');
        $vAMHFee = $dbin->f('am_fee');
        $vPaid = $dbin->f('fpaid');
        $vSend = ($vSendTemp !== '') ? $vSendTemp : $dbin->f('fsend');
        $vReceived = ($vReceivedTemp !== '') ? $vReceivedTemp : trim((string)$dbin->f('freceived'));
        }

        if ($vStat=='out')
          $vStatus='Menunggu Proses [pebisnis]';
        else if ($vStat=='0' && $vFuserid=='aminahku' && trim((string)$vMethod)==='' && $vFprocessed=='0')
          $vStatus='Menunggu Proses';
        else if ($vStat=='0' && $vPaid=='0' && $vMethod != 'wpr')
          $vStatus='Pending';
        else if ($vStat=='0' && strtolower(trim((string)$vMethod))=='wpr' && $vSend=='1' && $vReceived=='1')
          $vStatus='Diproses (Sudah Diterima)';
        else if ($vStat=='0' && strtolower(trim((string)$vMethod))=='tva' && $vPaid=='1' && $vSend=='1' && $vReceived=='1')
          $vStatus='Diproses (Sudah Diterima)';
        else if ($vStat=='0' && strtolower(trim((string)$vMethod))=='ctr' && $vPaid=='1' && $vSend=='1' && $vReceived=='1')
          $vStatus='Diproses (Sudah Diterima)';
        else if ($vStat=='0' && $vPaid=='1' && $vSend=='1' && $vReceived=='1')
          $vStatus='Diproses (Sudah Diterima)';
        else if ($vStat=='0' && strtolower(trim((string)$vMethod))=='wpr' && $vSend=='1')
          $vStatus='Diproses (Sudah Dikirim)';
        else if ($vStat=='0' && $vPaid=='1' && $vSend =='1')
          $vStatus='Diproses (Sudah Dikirim)'; 
        else if ($vStat=='0' && $vPaid=='1')
          $vStatus='Diproses (Sudah Dibayar)';
        else if ($vStat=='0' && $vMethod == 'wpr')
          $vStatus='Pending';
        else if ($vFprocessed=='2')
          $vStatus='Selesai';
        else if ($vStat=='1')   
            $vStatus='Approved';
        else if ($vStat=='4' || $vFprocessed=='4')  
            $vStatus='Rejected';

       // echo "$vSQL <br>";
				
				
				
				$vSeller = $vIdSeller;
				if ($vProduk != '') {
					$vSQL = "select * from  m_product where fidproduk='$vProduk'";
					$dbin->query($vSQL);
					if ($dbin->next_record() && $dbin->f('fseller') != '')
						$vSeller = $dbin->f('fseller');
				}
				
				$vSQL = "select * from  m_seller where fidseller='$vSeller'";
				$dbin->query($vSQL);
				$dbin->next_record();
				 
				 
				 if ($_SESSION['Priv'] != 'seller' || ($_SESSION['Priv'] == 'seller' && strtoupper($_SESSION['LoginUser'])==strtoupper($vSeller))) {
		  ?>
          <tr id="tr<?=$vIdSys?>" <? if (isset($_GET['hl']) && $_GET['hl']==$vIdTrx) echo 'style="background-color: #ffffcc !important;"'; ?> >
            <td style="width: 5%" valign="top"><?=$vNo?></td>
            <td nowrap valign="top"><?=$oPhpdate->YMD2DMY($vTanggal,"-")?></td>
            <td  valign="top"><?=$vIdTrx?></td>
            <td class="hide" valign="top"><?=$vStatRow['fidseller']?></td>
            <td valign="top" nowrap>
              <?
            	
				echo $vNamaSeller = $dbin->f('fnama');
			?>
            </td>
            <td valign="top" nowrap><div align="left"><?
             if ($vStat=='out')
                amhStatDispDetSellOut($vIdTrx);
             else
                $oJual->dispDetSell($vIdTrx);
            ?></div></td>
            <td valign="top" align="right"><?
             if ($vStat=='out')
                $vOngkir = amhStatGetOngkirOut($vIdTrx);
             else {
                $vOngkir=$oJual->getOngkir($vIdTrx);
                if ($vOngkir == 0) $vOngkir=$oJual->getOngkirTemp($vIdTrx);
             }
             if ($vAMHFee=='') $vAMHFee=0;
			 
			echo number_format($vOngkir,0,",",".");?></td>
            <td valign="top"><div align="right">
            <?
             if ($vStat=='out')
                $vSubTot = amhStatGetSellTotOut($vIdTrx);
             else {
                $vSubTot=$oJual->getSellTot($vIdTrx);
			    if ($vSubTot == 0) $vSubTot=$oJual->getSellTotTemp($vIdTrx);
             }
			 
			
			 
             echo  number_format($vSubTot+$vOngkir+$vAMHFee,0,",",".");
             $vTotalJual+=($vSubTot + $vOngkir + $vAMHFee);
            
            ?>
			</div></td>
            <td id="tdstat<?=$vIdTrx?>" valign="top"> <?=$vStatus?></td>
            <td nowrap="nowrap">&nbsp;
              <input type="button" class="btn btn-xs btn-success" name="button" id="button" value="Detail Receipt" onClick="printTrx('<?=$vIdTrx?>','<?=$vTanggal?>','<?=$vIdMember?>')">
              <? 
                 $vCanProsesAminahku = ($_SESSION['Priv']=='sponsor' && $vFprocessed=='0' && trim((string)$vMethod)===''
                    && ($vFuserid=='aminahku' || stripos($vKet, 'link luar') !== false)
                    && ($vStat=='out' || $vStat=='0'));
                 if ($vCanProsesAminahku) {
                   $vProcOut = rawurlencode($vIdTrx);
                   $vCurMenu = isset($_GET['current']) ? htmlspecialchars($_GET['current'], ENT_QUOTES, 'UTF-8') : 'mdm_pebisnis';
                   $vMenuParam = isset($_GET['menu']) ? htmlspecialchars($_GET['menu'], ENT_QUOTES, 'UTF-8') : '';
              ?>
              <input type="button" class="btn btn-xs btn-info" value="Proses" onClick="document.location.href='reorder.php?processout=<?=$vProcOut?>&amp;current=<?=$vCurMenu?>&amp;menu=<?=$vMenuParam?>';">
              <? }
                 $vCanMarkReceived = ($_SESSION['Priv']=='sponsor' && $vStat=='0' && $vStat!='out' && $vFprocessed!='2'
                    && $vSend=='1' && $vReceived!='1'
                    && (strtolower(trim((string)$vMethod))=='wpr' || $vPaid=='1'));
                 if ($vCanMarkReceived) {
              ?>
              <input type="button" class="btn btn-xs btn-warning" id="btnReceived<?=$vIdTrx?>" value="Pembeli Sudah Terima" onClick="doMarkReceived('<?=$vIdTrx?>')">
              <? } ?>
            </td>  
          </tr>
           <? } //if seller
			 }?>
          <tr class="hide">
            <td style="width: 5%" >&nbsp;</td>
            <td ><div align="right"><strong>Grand Total </strong></div></td>
            <td class="hide">&nbsp;</td>
            <td class="hide">&nbsp;</td>
            <td colspan="4" ><div align="right"><strong>
              <?=number_format($vTotalJual,0,",",".")?>
            </strong></div></td>
            <td >&nbsp;</td>
            <? if ($_SESSION['Priv'] !='seller') {?> <td >&nbsp;</td> <? } ?>
          </tr>
        </table>    
        </div>  
            
     <table width="90%">
     <tr>
      <td align="center">
        
        <p>
          <?
   for ($i=0;$i<$vPageCount;$i++) {
     $vOffset=$i*$vBatasBaris;
     if ($i!=$vPage) {
?>
          <a href="../memstock/historypo.php?uPage=<?=$i?>&amp;uAwal=<?=$oPhpdate->DMY2YMD($oPhpdate->YMD2DMY($vAwal,"-"),"-")?>&amp;uAkhir=<?=$oPhpdate->DMY2YMD($oPhpdate->YMD2DMY($vAkhir,"-"),"-")?>" >
          <?=$i+1?>
          </a>
          <?
  } else {
?>
          <?=$i+1?>
          <? } ?>
          <?  } //while?>
<br>
        </p></td>
    </tr>
    <tr> 
      <td height="5" align="center" valign="middle"> <div align="right"></div>
        <hr> </td>
    </tr>
    <tr> 
      <td height="49" align="center" valign="middle"> <p><br>
        </p>
      <p>&nbsp;        </p></td>
    </tr>
    <?php
   
  if ($baris==$Akhiran)
  {
  ?>
    <?php
  }
  ?>
  </table>
  
</form>



<!-- Placed js at the end of the document so the pages load faster -->

<script src="../js/jquery-ui-1.9.2.custom.min.js"></script>
<script src="../js/jquery-migrate-1.2.1.min.js"></script>

<script src="../js/modernizr.min.js"></script>
<script src="../js/jquery.nicescroll.js"></script>
<script src="../js/jquery.price_format.js"></script>




<script type="text/javascript" src="../js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="../js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="../js/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="../js/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="../js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="../js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<!--common scripts for all pages-->
<script src="../js/pickers-init.js"></script>
<script src="../js/scripts.js"></script>

</div>
	<!-- end page container -->
	
<? include_once("../framework/admin_footside.blade.php") ; ?>