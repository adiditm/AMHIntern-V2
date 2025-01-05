 <?php
  $vUser=$_SESSION['LoginUser'];
   if ($_GET['op']=='spy')
      $vUser=$_GET['uMemberId'];

 include_once("classes/pulsaclass.php");
 
    $vFeePulsa=$oRules->getSettingByField("fcountflush");
	$vFeePublic=$oRules->getSettingByField("fhrgpaket");


	
	$vsTglAwal=$_POST['dc1'];
	if ($vsTglAwal=='') $vsTglAwal=date("Y-m-d");
	$vsTglAkhir=$_POST['dc2'];
	if ($vsTglAkhir=='') $vsTglAkhir=date("Y-m-d");
	

    if ($_POST['hPost']=='1') {
	 //   $oSystem->jsLocation('loggedin.php?tack=pulsa');
		//print_r($_POST);
		$vStatus='1';
		while(list($key,$val)=each($_POST)) {
			
		   if (preg_match("/cbProd/",$key,$vMatches)) {
			   if ($val !='') {

				  $vValuePost=explode('|',$val);
				  $vKdProd=$vValuePost[0];
				  $vNomPost=$vValuePost[1];
				  $vHargaPost=$vValuePost[2];
				  $vHargaAsliPost=$vValuePost[3];
				  $vOperator=$vValuePost[4];
				  $vNextID=$oMember->getNextTrxID($vTgl);
				  $vMsisdn=$_POST['tfMsis'];

				  $vLastBal=$oKomisi->getLastBalance($vUser);
				  if ($vLastBal < $vHargaPost) {
					  $oSystem->jsAlert('Error! Saldo Anda sebesar '.number_format($vLastBal,0,",",".").' tidak cukup untuk transaksi pulsa seharga '.number_format($vHargaPost,0,",",".").'. Anda akan diarahkan ke halaman topup saldo, silakan melakukan topup!');
					  $oSystem->jsLocation('loggedin.php?tack=topup');
					  exit;
					  
				  }
				  $vSig=md5($vMsisdn.$vNextID);
				  $vURLServer="http://darsatiket.com/reqvoucher.php?kprod=$vKdProd&msis=$vMsisdn&trxid=$vNextID&sig=$vSig";
				  $vResult=$oPulsa->getGoto($vURLServer,"");
				  $vResX=explode("|",$vResult);
				  $vServerResponse=$vResX[1];
				  $vXMLSent=$vResX[0];
				
				   
				  
				  
				  if (preg_match("/ID Client telah diblokir/i",$vServerResponse)) {
					  $oSystem->jsAlert('Error! Ada masalah server pulsa!');
					  $oSystem->jsLocation('loggedin.php?tack=pulsa');
					  exit;
				  } else if (preg_match("/Salah Password/i",$vServerResponse)) {
					  $oSystem->jsAlert('Error! Ada masalah authentikasi server pulsa!');
					  $oSystem->jsLocation('loggedin.php?tack=pulsa');
					  exit;
				  } else if (preg_match("/Possible Attack/i",$vServerResponse)) {
					  $oSystem->jsAlert('Error! Possible Attack!');
					  $oSystem->jsLocation('loggedin.php?tack=pulsa');
					  exit;
				  } else if (preg_match("/Sudah Pernah Diorderkan/i",$vServerResponse)) {
					  $oSystem->jsAlert("Error! Kode produk $vKdProd sudah pernah diorderkan ke nomor $vMsisdn, tidak bisa diorder lagi dalam 24 jam!");
					  $oSystem->jsLocation('loggedin.php?tack=pulsa');
					  exit;
				  }  else if (preg_match("/DIPROSES:/i",$vServerResponse)) {
					  $vStatus='1';
					  $oSystem->jsAlert("Sukses! Transaksi pulsa $vKdProd ke nomor $vMsisdn berhasil dikirim ke server pulsa, silakan tunggu pulsa masuk ke nomor tujuan!. Untuk mengetahui status transaksi terkini, klik tombol [Refresh List]!");
					  $oSystem->jsLocation('loggedin.php?tack=pulsa');
				  }  else if (preg_match("/BERHASIL/i",$vServerResponse)) {
					  $vStatus='0';
					  $oSystem->jsAlert("Sukses! Transaksi pulsa $vKdProd ke nomor $vMsisdn berhasil, silakan tunggu pulsa masuk ke nomor tujuan!. Untuk mengetahui status transaksi terkini, klik tombol [Refresh List]!");
					  $oSystem->jsLocation('loggedin.php?tack=pulsa');
				  } else  if (preg_match("/GAGAL/i",$vServerResponse)) {
					  $oSystem->jsAlert("Transaksi Gagal, kemungkinan salah produk atau ada gangguan!");
					  $oSystem->jsLocation('loggedin.php?tack=pulsa');
					  exit;
				  } 
				  
				  $vSQL="INSERT INTO tb_trxpulsa (fidtrx,fidmember,fkdproduk,fnominal,fhrgsumber,fhrgamh,fmsisdn,fserverresponse,fxmlsent,fket,flastuser,fstatustrx,fstatusrow,fsaldoamh,ftglupdate,ftglentry) ";
				  $vSQL.="VALUE('$vNextID','$vUser','$vKdProd',$vNomPost,$vHargaAsliPost,$vHargaPost,'$vMsisdn','$vServerResponse','$vXMLSent','Transaksi Pulsa $vOperator ke $vMsisdn','$vUser','1','1',0,now(),now());";   
				   $db->query($vSQL);	
				  $vDesc="Transaksi pulsa $vOperator $vKdProd ke nomor ($vMsisdn)";
				  $vLastBal=$oKomisi->getLastBalance($vUser);
				  $vBal=$vLastBal-$vHargaPost;
				  $oKomisi->insertMutasi($vUser,$vUser,date("Y-m-d H:i:s"),$vDesc,0,$vHargaPost,$vBal,'trxpulsa') ;
				  $oMember->updateSaldo($vUser,$vNomPost,'D');



					
					$vProsenFeeSpon=$oRules->getSettingByField("fminroyal");
					$vSponFee=($vFeePublic - $vFeePulsa) * ($vProsenFeeSpon/100);

					$vSponsor=$oNetwork->getSponsor($vIDMaster);
					$vLastBal=$oKomisi->getLastBalance($vSponsor);
					$vBal=$vLastBal+$vSponFee;
					
					
					$vDesc="Bonus Transaksi Sponsor dari $vUser, pembelian pulsa $vKdProd ";
					$oKomisi->insertMutasi($vSponsor,$vSponsor,date("Y-m-d H:i:s"),$vDesc,$vSponFee,0,$vBal,'pulsa') ;
					$oMember->updateSaldo($vSponsor,$vSponFee,'K');


					$vLastBal=$oKomisi->getLastBalance($vUser);
					$vBal=$vLastBal-$vSponFee;
					
					
					$vDesc="Bayar Bonus Transaksi Sponsor untuk $vSponsor, pembelian pulsa $vKdProd ke nomor ($vMsisdn)";
					$oKomisi->insertMutasi($vUser,$vUser,date("Y-m-d H:i:s"),$vDesc,0,$vSponFee,$vBal,'pulsa') ;
					$oMember->updateSaldo($vUser,$vSponFee,'D');

				//  $oSystem->jsAlert("Sukses! Transaksi pulsa $vKdProd ke nomor $vMsisdn berhasil dikirim ke server pulsa, silakan tunggu pulsa masuk ke nomor tujuan!");
				  $oSystem->jsLocation('loggedin.php?tack=pulsa');

				  
			   }
		   }
			
		}
	}
 ?>
<style type="text/css">
<!--
.style8 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 15px;
}
.style9 {
	font-size: 12px;
	font-weight: bold;
}
.style10 {font-size: 12px}
input,select,textarea,button {
	border:1px solid #999;
}

.tbltrx {
   	border-collapse:collapse;
}

.tbltrx td {
   border:1px solid #CCC;	
}
-->
</style><table  width="100%"  border="0" cellpadding="0" cellspacing="0">
<script language="javascript">


function changeTRX(pThis) {

	var vLength=$('.cbProd').length;
	for (i=0;i<vLength;i++) {
	    var objFocused=document.activeElement.id;
		if 	(('cbProd'+(i+1)) !=objFocused) 
		   $('#cbProd'+(i+1)).val('');
	}
}

function confirmOrder() {
 	var vLength=$('.cbProd').length;
	
	var vValue='';
	var vText='';
	var vMsis=$('#tfMsis').val();
	if (document.getElementById('tfMsis').value=='') {
	   alert('Anda belum memasukkan nomor tujuan!');	
	   document.getElementById('tfMsis').focus();
	   return false;
	}
	for (i=0;i<vLength;i++) {
		   vValue=$('#cbProd'+(i+1)).val();
		   vText=$('#cbProd'+(i+1)).find("option:selected").text();
		   if (vValue!='') {
			   if(confirm('Yakin melakukan pembelian pulsa '+vText+' ke nomor tujuan '+vMsis+'?')==true) {
				  document.frmInvest.submit(); 
				 return true;
			   } else return false;
		   }

	}
	
	if (vValue=='') {
	   alert('Anda belum memilih produk!');	
	   return false;
		
	}
  	
}

$(document).ready(function() {
if ('<?=$_POST[hList]?>' == '1') {

   window.location.hash='history';
}

 $("#tfMsis").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

});
</script>
  
  <tr valign="top"> 
    <td align="center" valign="top">
    <?  if ($_GET['op']!='spy') {?>
      <table width="100%"  border="0" align="left" cellpadding="0"  cellspacing="0">
        <tr> 
          <td width="498"  height="25" align="left" valign="top">
          <?=$oInterface->getKetTRX($vuMenu)?>

          <h3>Transaksi Pulsa <blink><span style="color:#F00">(Trial Version)</span></blink></h3>
            <form name="frmInvest" method="post" action="" onsubmit="return saveTopup()">
              <table width="100%" border="0" align="left" cellpadding="2" cellspacing="0" style="border:1px solid #CCC" class="tbltrx">
                <tr>
                  <td width="140">ID</td>
                  <td colspan="3"><div align="left">
                    <input name="ID" type="text" id="ID" value="<?=$vUser?>" size="15" readonly="true" style="background-color:#CCC" />
                    <input type="hidden" name="hPost" id="fPost" value="1" />
                  </div></td>
                </tr>
                <tr>
                  <td>Nomor Tujuan (MSISDN)</td>
                  <td colspan="3"><input style="font-size:14px;font-weight:bold" name="tfMsis" type="text" id="tfMsis"  size="30"  class="Number"  /></td>
                </tr>
                <tr>
                  <td rowspan="8" valign="top">Produk</td>
                  <td width="173">Simpati </td>
                  <td width="501"><label for="select"></label>
                    <select class="cbProd" onchange="changeTRX(this)" name="cbProd1" id="cbProd1">
                      <option selected="selected" value="">--Pilih--</option>
                      <?
                         $vSQL="select distinct Brand, Nom from m_voucherhp where Brand in ('Simpati') and status='OK' order by Nom";
						 $db->query($vSQL);
						 while ($db->next_record()) {
							 $vValue=$db->f('Kode');
							 $vBrand=$db->f('Brand');
							 $vNom=$db->f('Nom');
							 $vNominal=$db->f('Nom') * 1000;

							 $vLabel = $vBrand." ".$vNom;
						?>	 
                      <option value="<?=$vNom?>"> <?=$vLabel?></option>
                      <? } ?>
                  </select></td>
                  <td width="151" rowspan="2"><img src="images/tsel.jpg" height="40" alt="tsel" /></td>
                </tr>
                <tr>
                  <td>Kartu As</td>
                  <td><select class="cbProd" onchange="changeTRX(this)" name="cbProd2" id="cbProd2">
                    <option selected="selected" value="">--Pilih--</option>
                    <?
                         $vSQL="select * from m_voucherhp where Brand in ('AS') and status='OK' order by Nom";
						 $db->query($vSQL);
						 while ($db->next_record()) {
							 $vValue=$db->f('Kode');
							 $vBrand=$db->f('Brand');
							 $vNominal=$db->f('Nom') * 1000;
							 $vRegional=$db->f('Regional');
							 $vHargaAsli=$db->f('Harga');
							 $vHarga=$db->f('Harga') + $vFeePulsa;
$vHargaP=$db->f('Harga') + $vFeePublic;
							 $vStatus=$db->f('Status');
							 $vLabel=$db->f('Kode')." $vBrand $vRegional $vNominal, NTA: ".number_format($vHarga,0,',','.').", Hrg. Jual: ".number_format($vHargaP,0,',','.');
					  ?>
                    <option value="<?="$vValue|$vNominal|$vHarga|$vHargaAsli|$vBrand"?>">
                      <?=$vLabel?>
                      </option>
                    <? } ?>
                  </select></td>
                </tr>
                <tr>
                  <td>Mentari</td>
                  <td><select class="cbProd" onchange="changeTRX(this)" name="cbProd3" id="cbProd3">
                    <option selected="selected" value="">--Pilih--</option>
                    <?
                         $vSQL="select * from m_voucherhp where Brand in ('Mentari') and status='OK' order by Nom";
						 $db->query($vSQL);
						 while ($db->next_record()) {
							 $vValue=$db->f('Kode');
							 $vBrand=$db->f('Brand');
							 $vNominal=$db->f('Nom') * 1000;
							 $vRegional=$db->f('Regional');
							 $vHargaAsli=$db->f('Harga');
							 $vHarga=$db->f('Harga') + $vFeePulsa;
$vHargaP=$db->f('Harga') + $vFeePublic;
							 $vStatus=$db->f('Status');
							 $vLabel=$db->f('Kode')." $vBrand $vRegional $vNominal, NTA: ".number_format($vHarga,0,',','.').", Hrg. Jual: ".number_format($vHargaP,0,',','.');
					  ?>
                    <option value="<?="$vValue|$vNominal|$vHarga|$vHargaAsli|$vBrand"?>">
                      <?=$vLabel?>
                      </option>
                    <? } ?>
                  </select></td>
                  <td rowspan="3"><img src="images/indosat.jpg" alt="indosat"  height="40" /></td>
                </tr>
                <tr>
                  <td>IM3</td>
                  <td><select class="cbProd" onchange="changeTRX(this)" name="cbProd4" id="cbProd4">
                    <option selected="selected" value="">--Pilih--</option>
                    <?
                         $vSQL="select * from m_voucherhp where Brand in ('IM3') and status='OK' order by Nom";
						 $db->query($vSQL);
						 while ($db->next_record()) {
							 $vValue=$db->f('Kode');
							 $vBrand=$db->f('Brand');
							 $vNominal=$db->f('Nom') * 1000;
							 $vRegional=$db->f('Regional');
							 $vHargaAsli=$db->f('Harga');
							 $vHarga=$db->f('Harga') + $vFeePulsa;
$vHargaP=$db->f('Harga') + $vFeePublic;
							 $vStatus=$db->f('Status');
							 $vLabel=$db->f('Kode')." $vBrand $vRegional $vNominal, NTA: ".number_format($vHarga,0,',','.').", Hrg. Jual: ".number_format($vHargaP,0,',','.');
					  ?>
                    <option value="<?="$vValue|$vNominal|$vHarga|$vHargaAsli|$vBrand"?>">
                      <?=$vLabel?>
                      </option>
                    <? } ?>
                  </select></td>
                </tr>
                <tr>
                  <td>Starone</td>
                  <td><select class="cbProd" onchange="changeTRX(this)" name="cbProd10" id="cbProd10">
                    <option selected="selected" value="">--Pilih--</option>
                    <?
                         $vSQL="select * from m_voucherhp where Brand in ('Starone') and status='OK' order by Nom";
						 $db->query($vSQL);
						 while ($db->next_record()) {
							 $vValue=$db->f('Kode');
							 $vBrand=$db->f('Brand');
							 $vNominal=$db->f('Nom') * 1000;
							 $vRegional=$db->f('Regional');
							 $vHargaAsli=$db->f('Harga');
							 $vHarga=$db->f('Harga') + $vFeePulsa;
$vHargaP=$db->f('Harga') + $vFeePublic;
							 $vStatus=$db->f('Status');
							 $vLabel=$db->f('Kode')." $vBrand $vRegional $vNominal, NTA: ".number_format($vHarga,0,',','.').", Hrg. Jual: ".number_format($vHargaP,0,',','.');
					  ?>
                    <option value="<?="$vValue|$vNominal|$vHarga|$vHargaAsli|$vBrand"?>">
                      <?=$vLabel?>
                      </option>
                    <? } ?>
                  </select></td>
                </tr>
                <tr>
                  <td>XL </td>
                  <td><select class="cbProd" onchange="changeTRX(this)" name="cbProd5" id="cbProd5">
                    <option selected="selected" value="">--Pilih--</option>
                    <?
                         $vSQL="select * from m_voucherhp where Brand in ('XL') and status='OK' order by Nom";
						 $db->query($vSQL);
						 while ($db->next_record()) {
							 $vValue=$db->f('Kode');
							 $vBrand=$db->f('Brand');
							 $vNominal=$db->f('Nom') * 1000;
							 $vRegional=$db->f('Regional');
							 $vHargaAsli=$db->f('Harga');
							 $vHarga=$db->f('Harga') + $vFeePulsa;
$vHargaP=$db->f('Harga') + $vFeePublic;
							 $vStatus=$db->f('Status');
							 $vLabel=$db->f('Kode')." $vBrand $vRegional $vNominal, NTA: ".number_format($vHarga,0,',','.').", Hrg. Jual: ".number_format($vHargaP,0,',','.');
					  ?>
                    <option value="<?="$vValue|$vNominal|$vHarga|$vHargaAsli|$vBrand"?>">
                      <?=$vLabel?>
                      </option>
                    <? } ?>
                  </select></td>
                  <td><img src="images/xl.jpg" alt="indosat"  height="40" /></td>
                </tr>
                <tr>
                  <td>Axis </td>
                  <td><select class="cbProd" onchange="changeTRX(this)" name="cbProd6" id="cbProd6">
                    <option selected="selected" value="">--Pilih--</option>
                    <?
                         $vSQL="select * from m_voucherhp where Brand in ('Axis') and status='OK' order by Nom";
						 $db->query($vSQL);
						 while ($db->next_record()) {
							 $vValue=$db->f('Kode');
							 $vBrand=$db->f('Brand');
							 $vNominal=$db->f('Nom') * 1000;
							 $vRegional=$db->f('Regional');
							 $vHargaAsli=$db->f('Harga');
							 $vHarga=$db->f('Harga') + $vFeePulsa;
$vHargaP=$db->f('Harga') + $vFeePublic;
							 $vStatus=$db->f('Status');
							 $vLabel=$db->f('Kode')." $vBrand $vRegional $vNominal, NTA: ".number_format($vHarga,0,',','.').", Hrg. Jual: ".number_format($vHargaP,0,',','.');
					  ?>
                    <option value="<?="$vValue|$vNominal|$vHarga|$vHargaAsli|$vBrand"?>">
                      <?=$vLabel?>
                      </option>
                    <? } ?>
                  </select></td>
                  <td><img src="images/axis.jpg" alt="indosat"  height="40" /></td>
                </tr>
                <tr>
                  <td>Three</td>
                  <td><select class="cbProd" onchange="changeTRX(this)" name="cbProd7" id="cbProd7">
                    <option selected="selected" value="">--Pilih--</option>
                    <?
                         $vSQL="select * from m_voucherhp where Brand in ('Three') and status='OK' order by Nom";
						 $db->query($vSQL);
						 while ($db->next_record()) {
							 $vValue=$db->f('Kode');
							 $vBrand=$db->f('Brand');
							 $vNominal=$db->f('Nom') * 1000;
							 $vRegional=$db->f('Regional');
							 $vHargaAsli=$db->f('Harga');
							 $vHarga=$db->f('Harga') + $vFeePulsa;
$vHargaP=$db->f('Harga') + $vFeePublic;
							 $vStatus=$db->f('Status');
							 $vLabel=$db->f('Kode')." $vBrand $vRegional $vNominal, NTA: ".number_format($vHarga,0,',','.').", Hrg. Jual: ".number_format($vHargaP,0,',','.');
					  ?>
                    <option value="<?="$vValue|$vNominal|$vHarga|$vHargaAsli|$vBrand"?>">
                      <?=$vLabel?>
                      </option>
                    <? } ?>
                  </select></td>
                  <td><img src="images/tri.jpg" alt="indosat"  height="40" /></td>
                </tr>
                <tr>
                  <td valign="top">&nbsp;</td>
                  <td>Smartfren</td>
                  <td><select class="cbProd" onchange="changeTRX(this)" name="cbProd8" id="cbProd8">
                    <option selected="selected" value="">--Pilih--</option>
                    <?
                         $vSQL="select * from m_voucherhp where Brand in ('Smart','Fren') and status='OK' order by Nom";
						 $db->query($vSQL);
						 while ($db->next_record()) {
							 $vValue=$db->f('Kode');
							 $vBrand=$db->f('Brand');
							 $vNominal=$db->f('Nom') * 1000;
							 $vRegional=$db->f('Regional');
							 $vHargaAsli=$db->f('Harga');
							 $vHarga=$db->f('Harga') + $vFeePulsa;
$vHargaP=$db->f('Harga') + $vFeePublic;
							 $vStatus=$db->f('Status');
							 $vLabel=$db->f('Kode')." $vBrand $vRegional $vNominal, NTA: ".number_format($vHarga,0,',','.').", Hrg. Jual: ".number_format($vHargaP,0,',','.');
					  ?>
                    <option value="<?="$vValue|$vNominal|$vHarga|$vHargaAsli|$vBrand"?>">
                      <?=$vLabel?>
                      </option>
                    <? } ?>
                  </select></td>
                  <td><img src="images/smartfren.jpg" alt="indosat"  height="40" /></td>
                </tr>
                <tr>
                  <td valign="top">&nbsp;</td>
                  <td>Flexi</td>
                  <td><select class="cbProd" onchange="changeTRX(this)" name="cbProd11" id="cbProd11">
                    <option selected="selected" value="">--Pilih--</option>
                    <?
                         $vSQL="select * from m_voucherhp where Brand in ('Flexi') and status='OK' order by Nom";
						 $db->query($vSQL);
						 while ($db->next_record()) {
							 $vValue=$db->f('Kode');
							 $vBrand=$db->f('Brand');
							 $vNominal=$db->f('Nom') * 1000;
							 $vRegional=$db->f('Regional');
							 $vHargaAsli=$db->f('Harga');
							 							 $vHarga=$db->f('Harga') + $vFeePulsa;
$vHargaP=$db->f('Harga') + $vFeePublic;
							 $vStatus=$db->f('Status');
							 $vLabel=$db->f('Kode')." $vBrand $vRegional $vNominal, NTA: ".number_format($vHarga,0,',','.').", Hrg. Jual: ".number_format($vHargaP,0,',','.');
					  ?>
                    <option value="<?="$vValue|$vNominal|$vHarga|$vHargaAsli|$vBrand"?>">
                      <?=$vLabel?>
                      </option>
                    <? } ?>
                  </select></td>
                  <td><img src="images/flexi.jpg" alt="indosat"  height="40" /></td>
                </tr>
                <tr>
                  <td valign="top">&nbsp;</td>
                  <td>Esia</td>
                  <td><select class="cbProd" onchange="changeTRX(this)" name="cbProd12" id="cbProd12">
                    <option selected="selected" value="">--Pilih--</option>
                    <?
                         $vSQL="select * from m_voucherhp where Brand in ('Esia') and status='OK' order by Nom";
						 $db->query($vSQL);
						 while ($db->next_record()) {
							 $vValue=$db->f('Kode');
							 $vBrand=$db->f('Brand');
							 $vNominal=$db->f('Nom') * 1000;
							 $vRegional=$db->f('Regional');
							 $vHargaAsli=$db->f('Harga');
							 							 $vHarga=$db->f('Harga') + $vFeePulsa;
$vHargaP=$db->f('Harga') + $vFeePublic;
							 $vStatus=$db->f('Status');
							 $vLabel=$db->f('Kode')." $vBrand $vRegional $vNominal, NTA: ".number_format($vHarga,0,',','.').", Hrg. Jual: ".number_format($vHargaP,0,',','.');
					  ?>
                    <option value="<?="$vValue|$vNominal|$vHarga|$vHargaAsli|$vBrand"?>">
                      <?=$vLabel?>
                      </option>
                    <? } ?>
                  </select></td>
                  <td><img src="images/esia.jpg" alt="indosat"  height="40" /></td>
                </tr>
                <tr>
                  <td valign="top">&nbsp;</td>
                  <td>Ceria</td>
                  <td><select class="cbProd" onchange="changeTRX(this)" name="cbProd13" id="cbProd13">
                    <option selected="selected" value="">--Pilih--</option>
                    <?
                         $vSQL="select * from m_voucherhp where Brand in ('Ceria') and status='OK' order by Nom";
						 $db->query($vSQL);
						 while ($db->next_record()) {
							 $vValue=$db->f('Kode');
							 $vBrand=$db->f('Brand');
							 $vNominal=$db->f('Nom') * 1000;
							 $vRegional=$db->f('Regional');
							 $vHargaAsli=$db->f('Harga');
							 $vHarga=$db->f('Harga') + $vFeePulsa;
$vHargaP=$db->f('Harga') + $vFeePublic;
							 $vStatus=$db->f('Status');
							 $vLabel=$db->f('Kode')." $vBrand $vRegional $vNominal, NTA: ".number_format($vHarga,0,',','.').", Hrg. Jual: ".number_format($vHargaP,0,',','.');
					  ?>
                    <option value="<?="$vValue|$vNominal|$vHarga|$vHargaAsli|$vBrand"?>">
                      <?=$vLabel?>
                      </option>
                    <? } ?>
                  </select></td>
                  <td><img src="images/ceria.jpg" alt="indosat"  height="40" /></td>
                </tr>
                <tr>
                  <td valign="top">&nbsp;</td>
                  <td>Hepi</td>
                  <td><select class="cbProd" onchange="changeTRX(this)" name="cbProd14" id="cbProd14">
                    <option selected="selected" value="">--Pilih--</option>
                    <?
                         $vSQL="select * from m_voucherhp where Brand in ('Hepi') and status='OK' order by Nom";
						 $db->query($vSQL);
						 while ($db->next_record()) {
							 $vValue=$db->f('Kode');
							 $vBrand=$db->f('Brand');
							 $vNominal=$db->f('Nom') * 1000;
							 $vRegional=$db->f('Regional');
							 $vHargaAsli=$db->f('Harga');
							 $vHarga=$db->f('Harga') + $vFeePulsa;
$vHargaP=$db->f('Harga') + $vFeePublic;
							 $vStatus=$db->f('Status');
							 $vLabel=$db->f('Kode')." $vBrand $vRegional $vNominal, NTA: ".number_format($vHarga,0,',','.').", Hrg. Jual: ".number_format($vHargaP,0,',','.');
					  ?>
                    <option value="<?="$vValue|$vNominal|$vHarga|$vHargaAsli|$vBrand"?>">
                      <?=$vLabel?>
                      </option>
                    <? } ?>
                  </select></td>
                  <td><img src="images/hepi.jpg" alt="indosat"  height="40" /></td>
                </tr>
                <tr style="display:none">
                  <td valign="top">&nbsp;</td>
                  <td>PLN Prabayar</td>
                  <td><select class="cbProd" onchange="changeTRX(this)" name="cbProd9" id="cbProd9">
                    <option selected="selected" value="">--Pilih--</option>
                    <?
                         $vSQL="select * from m_voucherhp where Brand in ('PLN') and status='OK' order by Nom";
						 $db->query($vSQL);
						 while ($db->next_record()) {
							 $vValue=$db->f('Kode');
							 $vBrand=$db->f('Brand');
							 $vNominal=$db->f('Nom') * 1000;
							 $vRegional=$db->f('Regional');
							 $vHargaAsli=$db->f('Harga');
							 $vHarga=$db->f('Harga') + $vFeePulsa;
$vHargaP=$db->f('Harga') + $vFeePublic;
							 $vStatus=$db->f('Status');
							 $vLabel=$db->f('Kode')." $vBrand $vRegional $vNominal, NTA: ".number_format($vHarga,0,',','.').", Hrg. Jual: ".number_format($vHargaP,0,',','.');
					  ?>
                    <option value="<?="$vValue|$vNominal|$vHarga|$vHargaAsli|$vBrand"?>">
                      <?=$vLabel?>
                      </option>
                    <? } ?>
                  </select></td>
                  <td><img src="images/pln.jpg" alt="indosat"  height="40" /></td>
                </tr>
                <? if (trim($oInterface->getMenuContent("topup",true)) != '') { ?>
                <? } ?>
                
                <tr> 
                  <td height="37" colspan="4"> <div align="left">
                    <input type="button" name="kirim" value="Kirim Transaksi" onclick="confirmOrder()"> 
                    <input 

type="reset" name="reset" value="Bersihkan"> 
                  </div></td>
                </tr>
              </table>
            </form>
          <p>&nbsp;</p></td>
        </tr>
        <tr>
          <td  height="25" align="left" valign="top"></td>
        </tr>
    </table>	 
	<? } ?>   </td>
  </tr>
  <tr valign="top">
    <td align="center" valign="top"><form style="font-family:Tahoma" action="" method="post" name="frListJual" id="frListJual">
      <p><span class="style1"><span class="style22 style8">History Transaksi<span class="style8">
          [<?=$vUser." / ".$oMember->getMemberName($vUser);?>]
                </span></span></span><span class="style8"><a name="history" id="history"></a></span><br />
                <br />
     <span class="style10"><strong>Mulai :</strong></span>
                    <input  name="dc1"  id="dc1" value="<?=$vsTglAwal?>" size="9" />
                    <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.frListJual.dc1);return false;" ><img src="calbtn.gif" alt="" name="popcal" width="34" height="22" border="0" align="absmiddle" id="popcal" /></a> <span class="style9">s/d</span>
                <input  name="dc2" class="" id="dc2" value="<?=$vsTglAkhir?>" size="9" />
                  <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.frListJual.dc2);return false;" ><img src="calbtn.gif" alt="" name="popcal" width="34" height="22" border="0" align="absmiddle" id="popcal" /></a>
                  &nbsp;<input type="submit" name="button" id="button" value="Refresh List" />
                  <input type="hidden" id="hList" name="hList" value="1" />
                  <br />
<div align="left" style="color:#f00;font-weight:bold">Untuk mengetahui status transaksi terkini, klik tombol [Refresh List]!</div>
      <table width="100%%" border="1" align="center" cellpadding="0" cellspacing="0" class="tabelrekap">
            <!-- <tr style="display:none">
                <td height="26"></td>
                <td><div align="center">
                    <input name="tfsnojual" type="text" class="inputborder" id="tfsnojual" value="<?=$vsNoJual?>" size="10" />
                </div></td>
                <td colspan="2" ><div align="left">
                    <input type="submit" name="Submit2" value="Cari" />
                    <input name="cbIgnore" type="checkbox" id="cbIgnore" value="yes" <? if ($vsIgnore=="yes") echo "checked";?>>
                    <span class="style2 style11">Abaikan Tanggal </span> </div></td>
              </tr> -->
      <tr <? if ($vProcessed==2) echo "bgcolor='#CCCCCC'" ?> >
        <td width="2%"><div align="center" class="style9">No.</div></td>
                <td width="20%" height="26"><div align="center" class="style9">Tanggal</div></td>
                <td width="9%"><div align="center" class="style9">No Transaksi </div></td>
                <td width="8%"><div align="center" class="style10"><strong>Kode Produk</strong></div>
                    <div align="center" class="style10"></div>
                <div align="center" class="style10"> </div></td>
                <td width="7%"><div align="center" class="style10"><strong>Nominal</strong></div></td>
                <td width="11%"><div align="center" class="style10"><strong>Harga</strong></div></td>
                <td width="24%"><div align="center" class="style10"><strong>Status</strong></div></td>
                <td width="19%"><div align="center">
                  <div align="center" class="style10"><strong>Keterangan</strong></div>
                </div></td>
          </tr>
              <?
		  $vsql="select * from tb_trxpulsa where 1 and fkdproduk not like 'PLN%' and fidmember='$vUser' and (date(ftglentry) between  date('$vsTglAwal') and date('$vsTglAkhir'))";
		  $vsql.=$vCrit;
		  $vsql.="   order by fidtrx ";

		  $db->query($vsql);
		  
		  $vNo=0; 
		  while ($db->next_record()) {
			  $vNo+=1;
			 $vTanggal=$oPhpdate->YMDT2DMYT($db->f('ftglentry'));
			 $vIDTrx=$db->f('fidtrx');
			 $vKdProd=$db->f('fkdproduk');
			 $vNomList=number_format($db->f('fnominal'),0,",",".");
			 $vHargList=number_format($db->f('fhrgamh'),0,",",".");
			 $vKet=$db->f('fket');
			 $vStatDB=$db->f('fstatustrx');
			 $vSNDB=$db->f('fsn');
			 $vVNDB=$db->f('fvn');
			 if ($vStatDB=='0') {
			     $vStatText='Berhasil';
				 if ($vSNDB !='' || $vVNDB !='')
				    $vStatText.=", SN: $vSNDB, VN: $vVNDB";
			 } else if ($vStatDB=='1')
			     $vStatText='Diproses';
			 else if ($vStatDB=='11')
			     $vStatText='Gagal';

		?>
              <tr  <? if ($vStatDB=='0') echo "style='background-color:#66CC66'"; else if ($vStatDB=='11') echo "style='background-color:#f00'"?>    >
                <td><div align="right"><span class="style10">
                  <?=$vNo?>
                </span></div></td>
                <td><div align="center" class="style10">
                    <?=$vTanggal?>
                    <br />
                </div></td>
                <td ><span class="style10" >
                <?=$vIDTrx?>
                  <br />                
                  </span></td>
                <td><div align="center" class="style10">
                  <?=$vKdProd?>
                </div></td>
                <td><div align="right"><span class="style10">
                  <?=$vNomList?>
                </span></div></td>
                <td><div align="right"><span class="style10">
                  <?=$vHargList?>
                </span></div></td>
                <td><?=$vStatText?></td>
                <td><span class="style10">
                  <?=$vKet?>
                </span></td>
              </tr>
              <? 
     
	 } // while $db->next_record //if $vCrit
  ?>
              <tr style="display:none">
                <td colspan="3"><span class="style10"><strong>Total</strong></span></td>
                <td><div align="right" class="style10"><strong>
                    <?=number_format($vTotJual,0,",",".");?>
                </strong></div></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
        </table>
    </form></td>
  </tr>
</table>
<iframe name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="js/cal/ipopeng.htm" style="visibility: visible; z-index: 999; position: absolute; left: -500px; top: 0px;" width="174" frameborder="0" height="189" scrolling="No"></iframe>

</iframe>
