<? include_once("../framework/admin_headside.blade.php")?>

<?php

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

function amhApproveDispDetSellOut($pIDJual) {
	global $oDB, $oProduct;
	$vsql = "select a.fidproduk,a.fhargasat, a.fjumlah, b.fnamaproduk,a.fsize, a.fcolor from tb_penjualan_temp_out a";
	$vsql .= " left join m_product b on a.fidproduk=b.fidproduk where a.fidpenjualan='$pIDJual'";
	echo "<table width='110' border='0' style='margin-top:-0.9em'>";
	$oDB->query($vsql);
	while ($oDB->next_record()) {
		$vIDProd = $oDB->f('fidproduk');
		$vProd = str_replace(' ', '&nbsp;', $vIDProd . '/' . $oDB->f('fnamaproduk') . ' (' . number_format($oDB->f('fhargasat'), 0, ',', '.') . ')');
		$vJum = $oDB->f('fjumlah');
		echo '<tr><td width="90" valign="top"><div align="left">' . $vProd . '</div></td>';
		echo '<td><div align="left" valign="top">:</div></td>';
		echo '<td valign="top"><div align="right">' . $vJum . '</div></td></tr>';
	}
	echo '</table>';
}

function amhApproveGetSellTotOut($pIDJual) {
	global $oDB;
	$oDB->query("select sum(fsubtotal) as stot from tb_penjualan_temp_out where fidpenjualan='$pIDJual'");
	$oDB->next_record();
	return (float)$oDB->f('stot');
}

function amhApproveGetOngkirOut($pIDJual) {
	global $oDB;
	$oDB->query("select fongkir from tb_penjualan_temp_out where fidpenjualan='$pIDJual' limit 1");
	if ($oDB->next_record())
		return (float)$oDB->f('fongkir');
	return 0;
}

$vOutlet=$_SESSION['LoginOutlet'];
$vAwal=$_POST['dc'];
$vAkhir=$_POST['dc1'];
$vSpy = md5('spy').md5($_GET['uMemberId']);
$vReceiveField = amhGetTrxReceiveField($dbin);
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
   $vAwal=date('Y-m-d', strtotime('-30 days'));
   $vSQLMin = "select min(date(COALESCE(NULLIF(ftanggal,'0000-00-00 00:00:00'), NULLIF(ftglentry,'0000-00-00 00:00:00'), ftanggal))) as mindate from tb_penjualan_temp_out where (ifnull(fprocessed,'0')='0' or ifnull(fprocessed,0)=0)";
   $db->query($vSQLMin);
   if ($db->next_record()) {
      $vMinDate = $db->f('mindate');
      if ($vMinDate != '' && $vMinDate < $vAwal) {
         $vAwal = $vMinDate;
      }
   }
}
   
if ($vAkhir=="")
   $vAkhir=$oPhpdate->getNowYMD("-");

$vUploadMsg = '';
$vUploadMsgType = '';
if (isset($_POST['hUploadWpr']) && $_POST['hUploadWpr'] == '1') {
	$vUploadTrx = trim($_POST['hUploadTrx']);
	$vUploadAwal = trim($_POST['hUploadAwal']);
	$vUploadAkhir = trim($_POST['hUploadAkhir']);
	if ($vUploadAwal != '')
		$vAwal = $vUploadAwal;
	if ($vUploadAkhir != '')
		$vAkhir = $vUploadAkhir;

	$vSQL = "select fidpenjualan, fidseller, fmethod, fprocessed, fpaid from tb_penjualan_temp where fidpenjualan='$vUploadTrx' limit 1";
	$dbin->query($vSQL);
	$dbin->next_record();
	$vUploadSeller = $dbin->f('fidseller');
	$vUploadMethod = $dbin->f('fmethod');
	$vUploadPaid = $dbin->f('fpaid');

	if ($vUploadTrx == '' || $dbin->num_rows() <= 0) {
		$vUploadMsg = 'Transaksi tidak ditemukan atau sudah diproses.';
		$vUploadMsgType = 'danger';
	} else if ($_SESSION['Priv'] != 'seller' || strtoupper($_SESSION['LoginUser']) != strtoupper($vUploadSeller)) {
		$vUploadMsg = 'Anda tidak berhak mengupload bukti untuk transaksi ini.';
		$vUploadMsgType = 'danger';
	} else if ($vUploadMethod != 'wpr' && $vUploadMethod != 'ctr' && $vUploadMethod != 'tva') {
		$vUploadMsg = 'Upload bukti kirim hanya tersedia untuk transaksi metode saldo bonus, cash/transfer, atau transfer virtual account.';
		$vUploadMsgType = 'danger';
	} else if ($vUploadMethod == 'ctr' && $vUploadPaid != '1') {
		$vUploadMsg = 'Upload bukti kirim untuk transaksi cash/transfer baru tersedia setelah payment diapprove admin.';
		$vUploadMsgType = 'danger';
	} else if (!isset($_FILES['uploadFile']) || $_FILES['uploadFile']['error'] != 0) {
		$vUploadMsg = 'File bukti kirim belum dipilih atau gagal diupload.';
		$vUploadMsgType = 'danger';
	} else {
		$vFileName = $_FILES['uploadFile']['name'];
		$vExt = strtolower(pathinfo($vFileName, PATHINFO_EXTENSION));
		$vAllowedExt = array('jpg', 'jpeg', 'png');
		if (!in_array($vExt, $vAllowedExt)) {
			$vUploadMsg = 'File bukti kirim harus berformat jpg, jpeg, atau png.';
			$vUploadMsgType = 'danger';
		} else {
			$vUploadDir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'bukti';
			if (!is_dir($vUploadDir))
				@mkdir($vUploadDir, 0777, true);

			if (!is_dir($vUploadDir)) {
				$vUploadMsg = 'Folder upload bukti tidak dapat dibuat.';
				$vUploadMsgType = 'danger';
			} else {
				foreach ($vAllowedExt as $vCleanupExt) {
					$vOldFile = $vUploadDir . DIRECTORY_SEPARATOR . $vUploadTrx . '.' . $vCleanupExt;
					if (file_exists($vOldFile))
						@unlink($vOldFile);
				}

				$vDestFile = $vUploadDir . DIRECTORY_SEPARATOR . $vUploadTrx . '.' . $vExt;
				if (move_uploaded_file($_FILES['uploadFile']['tmp_name'], $vDestFile)) {
					if ($vUploadMethod == 'wpr') {
						$db->query("update tb_penjualan_temp set fsend='1', fpaid='1' where fidpenjualan='$vUploadTrx' and fmethod='wpr'");
						$db->query("update tb_penjualan set fsend='1', fpaid='1' where fidpenjualan='$vUploadTrx' and fmethod='wpr'");
					} else if ($vUploadMethod == 'ctr') {
						$db->query("update tb_penjualan_temp set fsend='1' where fidpenjualan='$vUploadTrx' and fmethod='ctr'");
						$db->query("update tb_penjualan set fsend='1' where fidpenjualan='$vUploadTrx' and fmethod='ctr'");
					} else if ($vUploadMethod == 'tva') {
						$db->query("update tb_penjualan_temp set fsend='1' where fidpenjualan='$vUploadTrx' and fmethod='tva'");
						$db->query("update tb_penjualan set fsend='1' where fidpenjualan='$vUploadTrx' and fmethod='tva'");
					}
					$vUploadMsg = 'Bukti kirim berhasil diupload.';
					$vUploadMsgType = 'success';
				} else {
					$vUploadMsg = 'File bukti kirim gagal disimpan.';
					$vUploadMsgType = 'danger';
				}
			}
		}
	}
}

   
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

$vSellerFilter = "";
if ($_SESSION['Priv'] == 'seller') {
	$vSellerEsc = addslashes($vUser);
	$vSellerFilter = " and fidseller = '$vSellerEsc' ";
}

$vCrit.=" and date(ftanggal) >= '$vAwal' and date(ftanggal) <= '$vAkhir'" . $vSellerFilter;


$vsqlCount = "select count(distinct fidpenjualan) as cnt from (";
$vsqlCount .= " select fidpenjualan from tb_penjualan where 1 " . $vCrit;
$vsqlCount .= " union all select fidpenjualan from tb_penjualan_temp where 1 " . $vCrit;
$vsqlCount .= " union all select fidpenjualan from tb_penjualan_temp_out where (ifnull(fprocessed,'0')='0' or ifnull(fprocessed,0)=0) ";
$vsqlCount .= $vSellerFilter;
$vsqlCount .= " and (date(COALESCE(NULLIF(ftanggal,'0000-00-00 00:00:00'), NULLIF(ftglentry,'0000-00-00 00:00:00'), ftanggal)) >= '$vAwal' and date(COALESCE(NULLIF(ftanggal,'0000-00-00 00:00:00'), NULLIF(ftglentry,'0000-00-00 00:00:00'), ftanggal)) <= '$vAkhir' or COALESCE(NULLIF(ftanggal,'0000-00-00 00:00:00'), NULLIF(ftglentry,'0000-00-00 00:00:00'), ftanggal) = '0000-00-00 00:00:00' or COALESCE(NULLIF(ftanggal,'0000-00-00 00:00:00'), NULLIF(ftglentry,'0000-00-00 00:00:00'), ftanggal) is null) ";
$vsqlCount .= ") as temp";

$db->query($vsqlCount);
$db->next_record();
$vRecordCount = (int)$db->f('cnt');
$vPageCount = ceil($vRecordCount / $vBatasBaris);

?>
<style type="text/css">
.modal-content  {
    -webkit-border-radius: 3px !important;
    -moz-border-radius: 3px !important;
    border-radius: 3px !important; 
}
</style>


<script language="JavaScript" type="text/JavaScript">
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

function doApprove1(pSys,pTrx,pKind,pMethod,pPaid,pSend,pReceived,pStat) {
   if (pStat != '0') {
      return false;
   }
   if (pMethod == 'ctr' && pPaid != '1') {
      doApprovePayment(pSys,pTrx);
      return false;
   }
   if (pMethod == 'ctr' && pSend != '1') {
      alert('Tidak bisa disetujui, seller belum mengirim barang');
      return false;
   }
   if (pMethod == 'tva') {
      if (pPaid != '1') {
         alert('Belum bisa disetujui, pembeli belum menyelesaikan pembayaran.');
         return false;
      }
      if (pSend != '1') {
         alert('Belum bisa disetujui, seller belum menyelesaikan pengiriman');
         return false;
      }
      if (pReceived != '1') {
         alert('Belum bisa disetujui, pembeli belum menyatakan menerima barang. Hubungi pebisnis secara berkala untuk setatus penerimaan.');
         return false;
      }
   }
   if (pMethod == 'wpr' && pSend != '1') {
      alert('Belum bisa disetujui, seller belum menyelesaikan pengiriman');
      return false;
   }
   if (pMethod == 'wpr' && pReceived != '1') {
      alert('Belum bisa disetujui, pembeli belum menyatakan menerima barang. Hubungi pebisnis secara berkala untuk setatus penerimaan.');
      return false;
   }
   $('#spJual').text(pTrx);
   $('#hIdSys').val(pSys);
   $('#hIdTrx').val(pTrx);   
   $('#hKind').val(pKind);   
   // show bootstrap modal directly
   $('#dialogModal').modal('show');
}

function doApprovePayment(pSys,pTrx) {
   var vURL='../manager/processing_ajax.php?op=approvepayment&idsys='+pSys+'&idtrx='+pTrx;
   if (confirm('Apakah Anda yakin menyetujui pembayaran untuk transaksi '+pTrx+'? Pastikan Anda sebagai admin sudah check dana masuk di rekening!')) {
      $.get(vURL,function(data) {
         var r = $.trim(data);
         if (r == 'successpaid') {
            alert('Payment berhasil diapprove.');
            $('#tdstat'+pTrx).html('Diproses (Sudah Dibayar)');
            $('#btnAppv'+pTrx).val('Approve');
            $('#btnAppv'+pTrx).attr('onclick',"doApprove1('"+pSys+"','"+pTrx+"','"+$('#hKind').val()+"','ctr','1','0','0','0')");
            window.location.reload();
         } else {
            var msg = 'Approve payment gagal.';
            if (r == 'notfound') msg = 'Transaksi tidak ditemukan di data sementara (tb_penjualan_temp).';
            else if (r == 'invalidmethod') msg = 'Metode bayar bukan Cash/Transfer.';
            else if (r == 'alreadyprocessed') msg = 'Transaksi ini sudah tidak dalam status tunggu approve payment.';
            else if (r == 'updatefailed') msg = 'Update fpaid gagal (tidak ada baris yang cocok). Cek fidpenjualan dan fmethod di database.';
            else if (r !== '') msg = 'Respon server: ' + r;
            alert(msg);
         }
      });
   }
}

function doApprove2(pIdSys,pIdTrx,pKind) {
   var vResi= $('#tfResi').val();
   var vURL='../manager/processing_ajax.php?op=approvesell&idsys='+pIdSys+'&idtrx='+pIdTrx+'&noresi='+vResi+'&kind='+pKind;
   var vNotEnough = /notenough/g;
   var vNotEnoughBal=/not_e_deposit/g
   var vNotEnoughBonus=/not_e_bonusbalance/g
   var vNotReadyWpr=/notreadywpr/g
   var vNotReadyWprReceived=/notreadywprreceived/g
   var vNotReadyCtrPaid=/notreadyctrpaid/g
   var vNotReadyCtrSend=/notreadyctrsend/g
   var vNotReadyTVAPaid=/notreadytvapaid/g
   var vNotReadyTVASend=/notreadytvasend/g
   var vNotReadyTVAReceived=/notreadytvareceived/g
   if (confirm('Are you sure to approve Penjualan '+pIdTrx+'?')) {
       $.get(vURL,function(data) {
          if(data.trim()=='successappv') {
            alert('Approval succeed, stock updated!');
            $('#tdstat'+pIdTrx).html('Selesai');
            document.getElementById('btnAppv'+pIdTrx).disabled=true;
            document.getElementById('btnReject'+pIdTrx).disabled=true;
            // hide modal after success
            $('#dialogModal').modal('hide');
          } else if (vNotEnough.test(data.trim())) {
              var vData=data.split('_');
              var vKode=vData[1];
             alert('Approval failed, stock '+vKode+' tidak cukup!');   
          }  else if (vNotEnoughBal.test(data.trim())) {
             
             alert('Approval failed, saldo reseller tidak cukup!');   
          }  else if (vNotEnoughBonus.test(data.trim())) {
             alert('Approval failed, saldo bonus / saldo pebisnis member tidak cukup!');
          }  else if (vNotReadyWpr.test(data.trim())) {
             alert('Belum bisa menyetujui transaksi ini karena seller belum mengirimkan pesanan');
          }  else if (vNotReadyWprReceived.test(data.trim())) {
             alert('Belum bisa disetujui, pembeli belum menyatakan menerima barang. Hubungi pebisnis secara berkala untuk setatus penerimaan.');
          }  else if (vNotReadyCtrPaid.test(data.trim())) {
             alert('Belum bisa disetujui, pembayaran belum diapprove admin.');
          }  else if (vNotReadyCtrSend.test(data.trim())) {
             alert('Tidak bisa disetujui, seller belum mengirim barang');
          }  else if (vNotReadyTVAPaid.test(data.trim())) {
             alert('Belum bisa disetujui, pembeli belum menyelesaikan pembayaran.');
          }  else if (vNotReadyTVASend.test(data.trim())) {
             alert('Belum bisa disetujui, seller belum menyelesaikan pengiriman');
          }  else if (vNotReadyTVAReceived.test(data.trim())) {
             alert('Belum bisa disetujui, pembeli belum menyatakan menerima barang. Hubungi pebisnis secara berkala untuk setatus penerimaan.');
          }
       });
   }
}

function openUploadWpr(pTrx) {
   $('#spUploadJual').text(pTrx);
   $('#hUploadTrx').val(pTrx);
   $('#uploadFile').val('');
   $('#dialogUploadWpr').modal('show');
}

function openProofModal(pTrx, pFile) {
   $('#spProofJual').text(pTrx);
   $('#imgProofPreview').attr('src', pFile);
   $('#dialogProofWpr').modal('show');
}

function submitUploadWpr() {
   if ($('#uploadFile').val().trim()=='') {
      alert('Pilih file bukti kirim terlebih dahulu.');
      return false;
   }
   $('#hUploadAwal').val($('#dc').val());
   $('#hUploadAkhir').val($('#dc1').val());
   $('#frmUploadWpr').submit();
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

</script>
<!--	<link rel="stylesheet" href="../css/screen.css">-->

	
	
 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />

<div class="right_col" role="main">
		<div><label>
		<h3> <? if($_SESSION['Priv']!='seller') {?>Approval <? } else { ?> List <? } ?>Penjualan</h3></label></div>
<? if ($vUploadMsg != '') { ?>
<div class="alert alert-<?=$vUploadMsgType?>"><?=$vUploadMsg?></div>
<? } ?>
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
          <button type="button" id="btSubmit" name="btSubmit" class="btn btn-success" onClick="doApprove2($('#hIdSys').val(),$('#hIdTrx').val(),$('#hKind').val())">Submit</button>
          <button type="button" id="btClose" name="btClose" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

<form action="" method="post" enctype="multipart/form-data" id="frmUploadWpr">
<div class="modal fade" id="dialogUploadWpr" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Upload Bukti Kirim [<span id="spUploadJual"></span>]</h4>
        </div>
        <div class="modal-body " style="padding: 2em 4em 3em 4em">
          <div class="row">
             <div class="col-lg-12">
                 <label>Pilih file bukti kirim (jpg, jpeg, png)</label>
                 <input type="file" name="uploadFile" id="uploadFile" class="form-control" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
             </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" id="hUploadWpr" name="hUploadWpr" value="1" />
          <input type="hidden" id="hUploadTrx" name="hUploadTrx" value="" />
          <input type="hidden" id="hUploadAwal" name="hUploadAwal" value="<?=$vAwal?>" />
          <input type="hidden" id="hUploadAkhir" name="hUploadAkhir" value="<?=$vAkhir?>" />
          <button type="button" class="btn btn-success" onClick="submitUploadWpr()">Upload</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</form>

<div class="modal fade" id="dialogProofWpr" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Preview Bukti Kirim [<span id="spProofJual"></span>]</h4>
        </div>
        <div class="modal-body text-center" style="padding: 2em;">
          <img id="imgProofPreview" src="" alt="Bukti Kirim" style="max-width:100%;max-height:70vh;">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
      <label style="color: red;">Keterangan : Pembelian yang bisa diapprove adalah yang sudah dibayar dan sudah dikirim atau yang menggunakan cara pembayaran cash/transfer. <br>Untuk cara bayar Cash/Transfer, pastikan pembayaran sudah diterima di rekening bank!</label>

        <table width="90%" border="0" class="table table-striped">
          <tr >
            <td style="height: 24px; width: 5%;"><strong>No.</strong></td>
            <td width="10%" style="height: 24px" nowrap><div align="center"><strong>Date</strong></div></td>
            <td  width="15%" style="height: 24px" ><div align="left"><strong>No. Pembelian</strong></div></td>
            <td  width="15%" style="height: 24px" class="hide"><strong>Seller Username</strong></td>
            <td width="10%" align="center" style="height: 24px"><strong>ID Member </strong></td>
            <td align="center" style="width: 23%; height: 24px;"><strong>Name</strong></td>
            <td width="12%" align="center" style="height: 24px"><strong>Seller</strong></td>
            <td width="12%" align="center" style="height: 24px" class="hide"><strong>&nbsp;Detail Product </strong></td>
            <td width="35%" align="center" style="height: 24px"><strong>Cara Bayar</strong></td>
            <td width="14%" align="center" style="height: 24px"><strong>Ongkos Krm & Admin</strong></td>
            <td width="14%" align="center" style="height: 24px"><strong>Total Produk </strong></td>
            <td width="14%" align="center" style="height: 24px"><strong>Status</strong></td>
           <td width="14%" align="center" style="height: 24px"><strong>Action</strong></td>
          </tr>
          <? 
             $vNo=0;
			 $vsql="select distinct fidsys, ftanggal, fidpenjualan,fidseller,fidmember, fketerangan,fongkir, '1' as fstatus, fpaid, fsend, $vReceiveSelect, fmethod, cast(ifnull(fprocessed,0) as char) as fprocessed  from tb_penjualan where   1 "; 
			 $vsql.=$vCrit;

			 
			 $vsql.=" union all select distinct fidsys, ftanggal, fidpenjualan,fidseller,fidmember, fketerangan,fongkir, '0' as fstatus, fpaid, fsend, $vReceiveSelect, fmethod, cast(ifnull(fprocessed,0) as char) as fprocessed  from tb_penjualan_temp where  1 "; 
			 $vsql.=$vCrit;

			 $vsql.=" union all select distinct 0 as fidsys, COALESCE(NULLIF(ftanggal,'0000-00-00 00:00:00'), NULLIF(ftglentry,'0000-00-00 00:00:00'), ftanggal) as ftanggal, fidpenjualan, fidseller, fidmember, fketerangan, fongkir, 'out' as fstatus, fpaid, '0' as fsend, '0' as freceived, fmethod, cast(ifnull(fprocessed,0) as char) as fprocessed from tb_penjualan_temp_out where (ifnull(fprocessed,'0')='0' or ifnull(fprocessed,0)=0) ";
			 $vsql.=" and (date(COALESCE(NULLIF(ftanggal,'0000-00-00 00:00:00'), NULLIF(ftglentry,'0000-00-00 00:00:00'), ftanggal)) >= '$vAwal' and date(COALESCE(NULLIF(ftanggal,'0000-00-00 00:00:00'), NULLIF(ftglentry,'0000-00-00 00:00:00'), ftanggal)) <= '$vAkhir' or COALESCE(NULLIF(ftanggal,'0000-00-00 00:00:00'), NULLIF(ftglentry,'0000-00-00 00:00:00'), ftanggal) = '0000-00-00 00:00:00' or COALESCE(NULLIF(ftanggal,'0000-00-00 00:00:00'), NULLIF(ftglentry,'0000-00-00 00:00:00'), ftanggal) is null) " . $vSellerFilter;
			 
			 $vsql.=" order by ftanggal ";

			 
			 $vsql.="limit $vStartLimit ,$vBatasBaris ";




		     $db->query($vsql);
			 $vTotJual=0;
			 while ($db->next_record()) {
			 $vNo++;
				 $vTanggal=$db->f('ftanggal');
				 $vIdMember=$db->f('fidmember');
				 $vIdSeller=$db->f('fidseller');
         $vPaid=$db->f('fpaid');
         $vSend=$db->f('fsend');
         $vReceived=$db->f('freceived');
         $vMethod=$db->f('fmethod');
         $vFprocessed=trim((string)$db->f('fprocessed'));
				
				 $vNama=$oMember->getMemberNameAdm($vIdMember,'sponsor');
				 
				 $vKet=$db->f('fketerangan');
				// $vOngkir=$db->f('fongkir');
				 $vStat=$db->f('fstatus');
				 $vIdSys=$db->f('fidsys');
				 $vIdTrx=$db->f('fidpenjualan');
				  $vIdProd=$oJual->getKindProd($vIdTrx);
				 if (preg_match("/KIT/i",$vIdProd)) 
				    $vKind='kit';
				 else	if (preg_match("/SUPP/i",$vIdProd)) 
				    $vKind='acc';
			     else		
				    $vKind='prd';
				 
				 //$vtgltrans=$db->f('ftanggal');
				 
				 $vIDJual = $db->f('fidpenjualan');
			 	 if ($vStat == 'out') {
			 	 	 $dbin->query("select fidproduk from tb_penjualan_temp_out where fidpenjualan='$vIDJual' limit 1");
			 	 	 $dbin->next_record();
			 	 	 $vProduk = $dbin->f('fidproduk');
			 	 	 $vAMHFee = 0;
			 	 	 $vPaid = '0';
			 	 	 $vSend = '0';
			 	 	 $vReceived = '0';
			 	 } else {
				 	 // Prioritize temporary transaction status when it exists
				 	 $vSendTemp = '';
				 	 $vSQLTemp = "select fsend from tb_penjualan_temp where fidpenjualan='$vIDJual' limit 1";
				 	 $dbin->query($vSQLTemp);
				 	 if ($dbin->next_record()) {
				 	 	 $vSendTemp = $dbin->f('fsend');
				 	 }
				 	 $vSQL = "select * from  (select fidpenjualan, fidproduk,fpaid, fsend, $vReceiveSelect from tb_penjualan union  select fidpenjualan, fidproduk,fpaid, fsend, $vReceiveSelect from tb_penjualan_temp) as a left join tb_trx_va b on a.fidpenjualan=b.va_refid where a.fidpenjualan='$vIDJual' ";
					$dbin->query($vSQL);
					$dbin->next_record();
			        $vProduk = $dbin->f('fidproduk');
			        $vAMHFee = $dbin->f('am_fee');
			
			        $vPaid = $dbin->f('fpaid');
			        $vSend = ($vSendTemp !== '') ? $vSendTemp : $dbin->f('fsend');
			 	 }
       if ($vStat=='out' && $vFprocessed=='0')
          $vStatus='Menunggu Proses [pebisnis]';
       else if ($vStat=='0' && $vMethod=='tva' && $vPaid!='1')
          $vStatus='Pending [buyer]';
        else if ($vStat=='0' && $vMethod=='tva' && $vPaid=='1' && $vSend !='1')
          $vStatus='Pending [seller]';
        else if ($vStat=='0' && $vMethod=='tva' && $vPaid=='1' && $vSend =='1' && $vReceived !='1')
          $vStatus='Pending [pebisnis]';
        else if ($vStat=='0' && $vMethod=='wpr' && $vSend !='1')
          $vStatus='Pending [seller]';
        else if ($vStat=='0' && $vMethod=='wpr' && $vSend =='1' && $vReceived !='1')
          $vStatus='Pending [pebisnis]';
        else if ($vStat=='0' && $vMethod=='ctr' && $vPaid!='1')
          $vStatus='Pending [payment]';
        else if ($vStat=='0' && $vPaid=='0' && $vMethod != 'wpr')
          $vStatus='Pending';
        else if ($vStat=='0' && $vMethod=='tva' && $vPaid=='1' && $vSend =='1' && $vReceived =='1')
          $vStatus='Diproses (Sudah Diterima)';
        else if ($vStat=='0' && $vMethod=='wpr' && $vSend =='1' && $vReceived =='1')
          $vStatus='Diproses (Sudah Diterima)';
        else if ($vStat=='0' && $vMethod=='ctr' && $vPaid=='1' && $vSend =='1' && $vReceived =='1')
          $vStatus='Diproses (Sudah Diterima)';
        else if ($vStat=='0' && $vPaid=='1' && $vSend =='1' && $vReceived =='1')
          $vStatus='Diproses (Sudah Diterima)';
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
				
				
				
				$vSQL = "select * from  m_product where fidproduk='$vProduk'";
				$dbin->query($vSQL);
				$dbin->next_record();
				$vSeller = $dbin->f('fseller');
				
				$vSQL = "select * from  m_seller where fidseller='$vSeller'";
				$dbin->query($vSQL);
				$dbin->next_record();
				$vProofFile = '';
				foreach (array('jpg','jpeg','png') as $vProofExt) {
					$vProofAbs = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'bukti' . DIRECTORY_SEPARATOR . $vIdTrx . '.' . $vProofExt;
					if (file_exists($vProofAbs)) {
						$vProofFile = 'bukti/'.$vIdTrx.'.'.$vProofExt;
						break;
					}
					$vProofAbs2 = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'memstock' . DIRECTORY_SEPARATOR . 'resi_files' . DIRECTORY_SEPARATOR . $vIdTrx . '.' . $vProofExt;
					if (file_exists($vProofAbs2)) {
						$vProofFile = '../memstock/resi_files/'.$vIdTrx.'.'.$vProofExt;
						break;
					}
				}
				if ($vProofFile == '' && $vSend == '1') {
					// Fallback: if fsend=1 but file not found yet, try alternate common upload folders
					foreach (array('jpg','jpeg','png') as $vProofExt) {
						$vAlt = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'memstock' . DIRECTORY_SEPARATOR . $vIdTrx . '.' . $vProofExt;
						if (file_exists($vAlt)) {
							$vProofFile = '../memstock/'.$vIdTrx.'.'.$vProofExt;
							break;
						}
					}
				}
				 
				 
				 if ($_SESSION['Priv'] != 'seller' || ($_SESSION['Priv'] == 'seller' && strtoupper($_SESSION['LoginUser'])==strtoupper($vSeller))) {
		  ?>
          <tr id="tr<?=$vIdSys?>" <? if (isset($_GET['hl']) && $_GET['hl']==$vIdTrx) echo 'style="background-color: #ffffcc !important;"'; ?> >
            <td style="width: 5%" valign="top"><?=$vNo?></td>
            <td nowrap valign="top"><?=$oPhpdate->YMD2DMY($vTanggal,"-")?></td>
            <td  valign="top"><?=$vIdTrx=$db->f('fidpenjualan')?></td>
            <td class="hide" valign="top"><?=$db->f('fidseller')?></td>
            <td valign="top"><?=$vIdMember?></td>
            <td style="width: 23%" valign="top"><?=$vNama?></td>
            <td valign="top" nowrap>
            <?
            	
				echo $vNamaSeller = $dbin->f('fnama');
			?>
            </td>
             <td valign="top" nowrap class="hide"><div align="left"><?
             	if ($vStat == 'out') {
             		amhApproveDispDetSellOut($vIdTrx);
             	} else {
             		$oJual->dispDetSell($db->f('fidpenjualan'));
             	}
             ?></div></td>
             <td valign="top" style="vertical-align:top">
             <?php
             // Display payment method instead of note
             $vMethodDisplay = '';
             if ($vMethod == 'ctr') {
                 $vMethodDisplay = 'Cash/Transfer';
             } else if ($vMethod == 'tva') {
                 $vMethodDisplay = 'Transfer Virtual Account';
             } else if ($vMethod == 'wpr') {
                 $vMethodDisplay = 'eWallet';
             } else {
                 $vMethodDisplay = $vMethod;
             }
             echo $vMethodDisplay;
             ?>
             </td>
             <td valign="top" align="right"><?
              if ($vStat == 'out') {
                  $vOngkir = amhApproveGetOngkirOut($vIdTrx);
              } else {
                  $vOngkir=$oJual->getOngkir($db->f('fidpenjualan'));
                  if ($vOngkir == 0) $vOngkir=$oJual->getOngkirTemp($db->f('fidpenjualan'));
              }
            
              if ($vAMHFee=='') $vAMHFee=0;
			 
			echo number_format($vOngkir,0,",",".");?></td>
             <td valign="top"><div align="right">
             <?
              if ($vStat == 'out') {
                  $vSubTot = amhApproveGetSellTotOut($vIdTrx);
              } else {
                  $vSubTot=$oJual->getSellTot($db->f('fidpenjualan'));
                  if ($vSubTot == 0) $vSubTot=$oJual->getSellTotTemp($db->f('fidpenjualan'));
              }
			 
			
			 
              echo  number_format($vSubTot+$vOngkir+$vAMHFee,0,",",".");
              $vTotalJual+=($vSubTot + $vOngkir + $vAMHFee);
             
             ?>
 			</div></td>
            <td id="tdstat<?=$vIdTrx?>" valign="top"> <?=$vStatus?></td>
            <td nowrap="nowrap"> <? if ($_SESSION['Priv'] !='seller') {?>
            <input <? if ($vStat!='0') echo 'disabled';?> onclick="doApprove1('<?=$vIdSys?>','<?=$vIdTrx?>','<?=$vKind?>','<?=$vMethod?>','<?=$vPaid?>','<?=$vSend?>','<?=$vReceived?>','<?=$vStat?>')" class="btn btn-success btn-xs" name="btnAppv" id="btnAppv<?=$vIdTrx?>" type="button" value="<? if ($vMethod=='ctr' && $vStat=='0' && $vPaid!='1' && $vSend!='1' && $vReceived!='1') echo 'Approve Payment'; else echo 'Approve';?>">&nbsp;
            <input <? if ($vStat!='0') echo 'disabled';?> onclick="doReject('<?=$vIdSys?>','<?=$vIdTrx?>')"  class="btn btn-danger btn-xs" name="btnReject" id="btnReject<?=$vIdTrx?>"  type="button" value="Reject">
            <? if ($vProofFile!='' && $vSend=='1') { ?>
            <input type="button" class="btn btn-xs btn-info" value="Lihat Bukti" onClick="openProofModal('<?=$vIdTrx?>','<?=$vProofFile?>')">
            <? } ?>
            <? } else { ?>
            <? if ($vStat=='0' && (($vMethod=='wpr') || ($vMethod=='ctr' && $vPaid=='1') || ($vMethod=='tva' && $vPaid=='1'))) { ?>
            <input type="button" class="btn btn-xs btn-primary" value="<? if ($vProofFile!='') echo 'Re-upload Bukti'; else echo 'Upload Bukti';?>" onClick="openUploadWpr('<?=$vIdTrx?>')">
            <? if ($vProofFile!='') { ?>
            <input type="button" class="btn btn-xs btn-info" value="Lihat Bukti" onClick="openProofModal('<?=$vIdTrx?>','<?=$vProofFile?>')">
            <? } ?>
            <? } ?>
            <? } ?>  
        <input type="button" class="btn btn-xs btn-success" name="button" id="button" value="Detail Receipt" onClick="printTrx('<?=$vIdTrx?>','<?=$vTanggal?>','<?=$vIdMember?>')">
            </td>  
          </tr>
           <? } //if seller
			 }?>
          <tr class="hide">
            <td style="width: 5%" >&nbsp;</td>
            <td ><div align="right"><strong>Grand Total </strong></div></td>
            <td class="hide">&nbsp;</td>
            <td class="hide">&nbsp;</td>
            <td >&nbsp;</td>
            <td colspan="6" ><div align="right"><strong>
              <?=number_format($vTotalJual,0,",",".")?>
            </strong></div></td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
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
          <a href="approvesell.php?uPage=<?=$i?>&amp;uAwal=<?=$oPhpdate->DMY2YMD($oPhpdate->YMD2DMY($vAwal,"-"),"-")?>&amp;uAkhir=<?=$oPhpdate->DMY2YMD($oPhpdate->YMD2DMY($vAkhir,"-"),"-")?>" >
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
<? include_once("../framework/admin_footside.blade.php");?>

