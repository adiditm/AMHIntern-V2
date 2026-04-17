<? include_once("../framework/admin_headside.blade.php")?>

<?php

$vOutlet=$_SESSION['LoginOutlet'];
$vAwal=$_POST['dc'];
$vAkhir=$_POST['dc1'];
$vSpy = md5('spy').md5($_GET['uMemberId']);

 if ($_GET['uMemberId'] != '')
    $vUserActive=$_GET['uMemberId'];
 else  $vUserActive=$vUser;
 
// echo $vUserActive;

if ($vAwal=="")
	$vAwal=$_GET['uAwal'];
if ($vAkhir=="")
	$vAkhir=$_GET['uAkhir'];


if ($vAwal=="")
   $vAwal=date('Y-m-d', strtotime('-30 days'));
   
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

	$vSQL = "select fidpenjualan, fidseller, fmethod, fprocessed from tb_trxstok_member_temp where fidpenjualan='$vUploadTrx' limit 1";
	$dbin->query($vSQL);
	$dbin->next_record();
	$vUploadSeller = $dbin->f('fidseller');
	$vUploadMethod = $dbin->f('fmethod');

	if ($vUploadTrx == '' || $dbin->num_rows() <= 0) {
		$vUploadMsg = 'Transaksi tidak ditemukan atau sudah diproses.';
		$vUploadMsgType = 'danger';
	} else if ($_SESSION['Priv'] != 'seller' || strtoupper($_SESSION['LoginUser']) != strtoupper($vUploadSeller)) {
		$vUploadMsg = 'Anda tidak berhak mengupload bukti untuk transaksi ini.';
		$vUploadMsgType = 'danger';
	} else if ($vUploadMethod != 'wpr') {
		$vUploadMsg = 'Upload bukti kirim hanya tersedia untuk transaksi metode saldo bonus.';
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
					$db->query("update tb_trxstok_member_temp set fsend='1', fpaid='1' where fidpenjualan='$vUploadTrx' and fmethod='wpr'");
					$db->query("update tb_trxstok_member set fsend='1', fpaid='1' where fidpenjualan='$vUploadTrx' and fmethod='wpr'");
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

$vCrit.=" and date(ftanggal) >= '$vAwal' and date(ftanggal) <= '$vAkhir'" ;



 $vsql="select distinct ftanggal, fidpenjualan,fidmember, fketerangan  from tb_trxstok_member where fidproduk not like 'KIT%' and fidmember='$vUserActive' ";
 $vsql.=$vCrit;
 $vsql.=" order by ftanggal ";
 $db->query($vsql);
 $db->next_record();
 $vRecordCount=$db->num_rows();
 $vPageCount=ceil($vRecordCount/$vBatasBaris);

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

function doApprove1(pSys,pTrx,pKind) {
   $('#spJual').text(pTrx);
   $('#hIdSys').val(pSys);
   $('#hIdTrx').val(pTrx);   
   $('#hKind').val(pKind);   
   // show bootstrap modal directly
   $('#dialogModal').modal('show');
}

function doApprove2(pIdSys,pIdTrx,pKind) {
   var vResi= $('#tfResi').val();
   var vURL='../manager/processing_ajax.php?op=approvesell&idsys='+pIdSys+'&idtrx='+pIdTrx+'&noresi='+vResi+'&kind='+pKind;
   var vNotEnough = /notenough/g;
   var vNotEnoughBal=/not_e_deposit/g
   var vNotEnoughBonus=/not_e_bonusbalance/g
   var vNotReadyWpr=/notreadywpr/g
   if (confirm('Are you sure to approve Penjualan '+pIdTrx+'?')) {
       $.get(vURL,function(data) {
          if(data.trim()=='successappv') {
            alert('Approval succeed, stock updated!');
            $('#tdstat'+pIdTrx).html('Approved');
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
			 $vsql="select distinct fidsys, ftanggal, fidpenjualan,fidseller,fidmember, fketerangan,fongkir, '1' as fstatus, fpaid, fsend, fmethod  from tb_trxstok_member where   1 "; 
			 $vsql.=$vCrit;

			 
			 $vsql.=" union all select distinct fidsys, ftanggal, fidpenjualan,fidseller,fidmember, fketerangan,fongkir, '0' as fstatus, fpaid, fsend, fmethod  from tb_trxstok_member_temp where  1 "; 
			 $vsql.=$vCrit;
			 
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
         $vMethod=$db->f('fmethod');
				
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
				  $vSQL = "select * from  (select fidpenjualan, fidproduk,fpaid, fsend from tb_trxstok_member union  select fidpenjualan, fidproduk,fpaid, fsend from tb_trxstok_member_temp) as a left join tb_trx_va b on a.fidpenjualan=b.va_refid where a.fidpenjualan='$vIDJual' ";
				$dbin->query($vSQL);
				$dbin->next_record();
				$vProduk = $dbin->f('fidproduk');
        $vAMHFee = $dbin->f('am_fee');

       $vPaid = $dbin->f('fpaid');
       $vSend = $dbin->f('fsend');  

       if ($vStat=='0' && $vPaid=='0' && $vMethod != 'wpr')
          $vStatus='Pending';
        else if ($vStat=='0' && $vPaid=='1' && $vSend =='1')
          $vStatus='Diproses (Sudah Dikirim)'; 
        else if ($vStat=='0' && $vPaid=='1')
          $vStatus='Diproses (Sudah Dibayar)';
        else if ($vStat=='0' && $vMethod == 'wpr')
          $vStatus='Pending';
        else if ($vStat=='1')   
            $vStatus='Approved';
        else if ($vStat=='4')  
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
				}
				 
				 
				 if ($_SESSION['Priv'] != 'seller' || ($_SESSION['Priv'] == 'seller' && strtoupper($_SESSION['LoginUser'])==strtoupper($vSeller))) {
		  ?>
          <tr id="tr<?=$vIdSys?>">
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
            <td valign="top" nowrap class="hide"><div align="left"><?=$oJual->dispDetSell($db->f('fidpenjualan'))?></div></td>
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
             $vOngkir=$oJual->getOngkir($db->f('fidpenjualan'));
           
             if ($vAMHFee=='') $vAMHFee=0;
			 if ($vOngkir == 0) $vOngkir=$oJual->getOngkirTemp($db->f('fidpenjualan'));
			 
			echo number_format($vOngkir,0,",",".");?></td>
            <td valign="top"><div align="right">
            <?
             $vSubTot=$oJual->getSellTot($db->f('fidpenjualan'));
			 if ($vSubTot == 0) $vSubTot=$oJual->getSellTotTemp($db->f('fidpenjualan'));
			 
			
			 
             echo  number_format($vSubTot+$vOngkir+$vAMHFee,0,",",".");
             $vTotalJual+=($vSubTot + $vOngkir + $vAMHFee);
            
            ?>
			</div></td>
            <td id="tdstat<?=$vIdTrx?>" valign="top"> <?=$vStatus?></td>
            <td nowrap="nowrap"> <? if ($_SESSION['Priv'] !='seller') {?>
            <input <? if (!($vStat=='0' && $vPaid=='1' && $vSend =='1') && $vMethod != 'ctr' && !($vStat=='0' && $vMethod == 'wpr')) echo 'disabled';?> onclick="doApprove1('<?=$vIdSys?>','<?=$vIdTrx?>','<?=$vKind?>')" class="btn btn-success btn-xs" name="btnAppv" id="btnAppv<?=$vIdTrx?>" type="button" value="Approve">&nbsp;
            <input <? if ($vStat!='0') echo 'disabled';?> onclick="doReject('<?=$vIdSys?>','<?=$vIdTrx?>')"  class="btn btn-danger btn-xs" name="btnReject" id="btnReject<?=$vIdTrx?>"  type="button" value="Reject"> <? } else { ?>
            <? if ($vStat=='0' && $vMethod=='wpr') { ?>
            <input type="button" class="btn btn-xs btn-primary" value="<? if ($vProofFile!='') echo 'Re-upload Bukti'; else echo 'Upload Bukti';?>" onClick="openUploadWpr('<?=$vIdTrx?>')">
            <? if ($vProofFile!='') { ?>
            <a href="<?=$vProofFile?>" target="_blank" class="btn btn-xs btn-default">Lihat Bukti</a>
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

