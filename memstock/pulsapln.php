 <?php
  $vUser=$_SESSION['LoginUser'];
   if ($_GET['op']=='spy')
      $vUser=$_GET['uMemberId'];
 $vTgl=date("Y-m-d");
 include_once("../classes/pulsaclass.php");
 
    $vFeePulsa=$oRules->getSettingByField("fcountflush");
	$vFeePublic=$oRules->getSettingByField("fhrgpaket");
	$vMinBal=$oRules->getSettingByField("fmintransferbuy");


	
	$vsTglAwal=$_POST['dc1'];
	if ($vsTglAwal=='') $vsTglAwal=date("Y-m-d");
	$vsTglAkhir=$_POST['dc2'];
	if ($vsTglAkhir=='') $vsTglAkhir=date("Y-m-d");
	

    if ($_POST['hPost']=='1') {
	 //   $oSystem->jsLocation('loggedin.php?tack=pulsapln');
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
 				  if (($vLastBal - $vMinBal) < $vHargaPost) {
					  $oSystem->jsAlert('Error! Saldo aktif Anda sebesar '.number_format(($vLastBal - $vMinBal),0,",",".").' tidak cukup untuk transaksi pulsa seharga '.number_format($vHargaPost,0,",",".").'. Anda akan diarahkan ke halaman topup saldo, silakan melakukan topup!');
					  $oSystem->jsLocation('loggedin.php?tack=topup');
					  exit;
					  
				  }				  
				
				   
//Temporary
				  $vSQL="INSERT INTO tb_trxpulsa_temp  (fidtrx,fidmember,fkdproduk,fnominal,fhrgsumber,fhrgamh,fmsisdn,fserverresponse,fxmlsent,fket,flastuser,fstatustrx,fstatusrow,fsaldoamh,ftglupdate,ftglentry) ";
				  $vSQL.="VALUE('$vNextID','$vUser','$vKdProd',$vNomPost,$vHargaAsliPost,$vHargaPost,'$vMsisdn','$vServerResponse','$vXMLSent','Transaksi Pulsa $vOperator ke $vMsisdn','$vUser','1','1',0,now(),now());";   
				   $db->query($vSQL);					  


				  $vSQL="INSERT INTO tb_trxpulsa (fidtrx,fidmember,fkdproduk,fnominal,fhrgsumber,fhrgamh,fmsisdn,fserverresponse,fxmlsent,fket,flastuser,fstatustrx,fstatusrow,fsaldoamh,ftglupdate,ftglentry) ";
				  $vSQL.="VALUE('$vNextID','$vUser','$vKdProd',$vNomPost,$vHargaAsliPost,$vHargaPost,'$vMsisdn','$vServerResponse','$vXMLSent','Transaksi Pulsa $vOperator ke $vMsisdn','$vUser','1','1',0,now(),now());";   
				   $db->query($vSQL);	
				  $vDesc="Transaksi pulsa $vOperator $vNextID - $vKdProd ke nomor ($vMsisdn)";
				  $vLastBal=$oKomisi->getLastBalance($vUser);
				  $vBal=$vLastBal-$vHargaPost;
				  $oKomisi->insertMutasi($vUser,$vUser,date("Y-m-d H:i:s"),$vDesc,0,$vHargaPost,$vBal,'trxpulsa') ;
				  $oMember->updateSaldo($vUser,$vHargaPost,'D');



					
					$vProsenFeeSpon=$oRules->getSettingByField("fminroyal");
					$vSponFee=($vFeePublic - $vFeePulsa) * ($vProsenFeeSpon/100);

					$vSponsor=$oNetwork->getSponsor($vUser);
					$vLastBal=$oKomisi->getLastBalance($vSponsor);
					$vBal=$vLastBal+$vSponFee;
					
					
					$vDesc="Bonus Transaksi Sponsor dari $vUser, pembelian pulsa $vNextID - $vKdProd ";
					$oKomisi->insertMutasi($vSponsor,$vSponsor,date("Y-m-d H:i:s"),$vDesc,$vSponFee,0,$vBal,'pulsa') ;
					$oMember->updateSaldo($vSponsor,$vSponFee,'K');


					$vLastBal=$oKomisi->getLastBalance($vUser);
					$vBal=$vLastBal-$vSponFee;
					
					
					$vDesc="Bayar Bonus Transaksi Sponsor untuk $vSponsor, pembelian pulsa $vNextID - $vKdProd ke nomor ($vMsisdn)";
					$oKomisi->insertMutasi($vUser,$vUser,date("Y-m-d H:i:s"),$vDesc,0,$vSponFee,$vBal,'pulsa') ;
					$oMember->updateSaldo($vUser,$vSponFee,'D');


				  $vSig=md5($vMsisdn.$vNextID);
				  $vURLServer="http://windows.amhtechno.com/reqvoucher.php?kprod=$vKdProd&msis=$vMsisdn&trxid=$vNextID&sig=$vSig";
				  $vResult=$oPulsa->getGoto($vURLServer,"");
				  $vResX=explode("|",$vResult);
				  $vServerResponse=$vResX[1];
				  $vXMLSent=$vResX[0];

			      $vSQL="update tb_trxpulsa set fserverresponse='$vServerResponse' where fidtrx='$vNextID' and fserverresponse=''; ";
				 
				  $db->query($vSQL);	
				  $vServerResponse=explode("<?xml",$vServerResponse);
				  $vServerResponse=$vServerResponse[0];

				  
				  if (trim($vServerResponse)=='' ||  trim($vXMLSent)=='') {
					  $oSystem->jsAlert('Error! Tidak ada response dari server pulsa!');
					  $oJual->reverseBalance($vUser,'Error! Tidak ada response dari server pulsa!',$vHargaPost,$vNextID,$vKdProd);
					  $oSystem->jsLocation('loggedin.php?tack=pulsapln');				  
					  exit;
				  } else if (preg_match("/Failed to connect to/i",$vServerResponse)) {
					  $oSystem->jsAlert('Error! Ada masalah koneksi server pulsa!');
					  $oJual->reverseBalance($vUser,'Error! Ada masalah koneksi server pulsa!',$vHargaPost,$vNextID,$vKdProd);
					  $oSystem->jsLocation('loggedin.php?tack=pulsapln');
					  exit;
				  } else if (preg_match("/engine_not_running/i",$vServerResponse)) {
					  $oSystem->jsAlert('Error! Salah Status Kode!');
					  $oJual->reverseBalance($vUser,'Error! Salah Status Kode!',$vHargaPost,$vNextID,$vKdProd);					  
					  $oSystem->jsLocation('loggedin.php?tack=pulsapln');
					  exit;
				  }  else if (preg_match("/ID Client telah diblokir/i",$vServerResponse)) {
					  $oSystem->jsAlert('Error! Ada masalah server pulsa!');
					  $oJual->reverseBalance($vUser,'Error! Ada masalah server pulsa!',$vHargaPost,$vNextID,$vKdProd);
					  $oSystem->jsLocation('loggedin.php?tack=pulsapln');
					  exit;
				  } else if (preg_match("/Salah Password/i",$vServerResponse)) {
					  $oSystem->jsAlert('Error! Ada masalah authentikasi server pulsa!');
					  $oJual->reverseBalance($vUser,'Error! Ada masalah authentikasi server pulsa!',$vHargaPost,$vNextID,$vKdProd);
					  $oSystem->jsLocation('loggedin.php?tack=pulsapln');
					  exit;
				  } else if (preg_match("/Possible Attack/i",$vServerResponse)) {
					  $oSystem->jsAlert('Error! Possible Attack!');
					  $oJual->reverseBalance($vUser,'Error! Possible Attack!',$vHargaPost,$vNextID,$vKdProd);
					  $oSystem->jsLocation('loggedin.php?tack=pulsapln');
					  exit;
				  } else if (preg_match("/Sudah Pernah Diorderkan/i",$vServerResponse)) {
					  $oSystem->jsAlert("Error! Kode produk $vKdProd sudah pernah diorderkan ke nomor $vMsisdn, tidak bisa diorder lagi dalam 24 jam!");
					  $oJual->reverseBalance($vUser,"Error! Kode produk $vKdProd sudah pernah diorderkan ke nomor $vMsisdn, tidak bisa diorder lagi dalam 24 jam!",$vHargaPost,$vNextID,$vKdProd);
					  $oSystem->jsLocation('loggedin.php?tack=pulsapln');
					  exit;
				  }  else if (preg_match("/DIPROSES:/i",$vServerResponse)) {
					  $vStatus='1';
					  $oSystem->jsAlert("Sukses! Transaksi pulsa $vKdProd ke nomor $vMsisdn berhasil dikirim ke server pulsa, silakan tunggu pulsa masuk ke nomor tujuan!. Untuk mengetahui status transaksi terkini, klik tombol [Refresh List]!");
					  $oSystem->jsLocation('loggedin.php?tack=pulsapln');
				  }  else if (preg_match("/BERHASIL/i",$vServerResponse)) {
					  $vStatus='0';
					  $oSystem->jsAlert("Sukses! Transaksi pulsa $vKdProd ke nomor $vMsisdn berhasil, silakan tunggu pulsa masuk ke nomor tujuan!. Untuk mengetahui status transaksi terkini, klik tombol [Refresh List]!");
					  $oSystem->jsLocation('loggedin.php?tack=pulsapln');
				  } else  if (preg_match("/GAGAL/i",$vServerResponse)) {
					  $oSystem->jsAlert("Transaksi Gagal, kemungkinan salah produk atau ada gangguan!");
					  $oJual->reverseBalance($vUser,'Transaksi Gagal, kemungkinan salah produk atau ada gangguan!',$vHargaPost,$vNextID,$vKdProd);
					  $oSystem->jsLocation('loggedin.php?tack=pulsapln');
					  exit;
				  } 
				  


				//  $oSystem->jsAlert("Sukses! Transaksi pulsa $vKdProd ke nomor $vMsisdn berhasil dikirim ke server pulsa, silakan tunggu pulsa masuk ke nomor tujuan!");
				  $oSystem->jsLocation('loggedin.php?tack=pulsaplnpln');

				  
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
		   //alert(vValue);
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

          <h3>Transaksi PLN Prabayar <blink></blink></h3>
            <form name="frmInvest" method="post" action="" onsubmit="return saveTopup()">
              <table width="100%" border="0" align="left" cellpadding="2" cellspacing="0" style="border:1px solid #CCC" class="tbltrx">
                <tr>
                  <td width="212">ID</td>
                  <td colspan="3"><div align="left">
                    <input name="ID" type="text" id="ID" value="<?=$vUser?>" size="15" readonly="true" style="background-color:#CCC" />
                    <input type="hidden" name="hPost" id="fPost" value="1" />
                  </div></td>
                </tr>
                <tr>
                  <td>Nomor Tujuan (Nomor Meter)</td>
                  <td colspan="3"><input style="font-size:14px;font-weight:bold" name="tfMsis" type="text" id="tfMsis"  size="30"  class="Number"  /></td>
                </tr>
                <tr style="display:">
                  <td valign="top">Produk</td>
                  <td width="117">PLN Prabayar</td>
                  <td width="509"><select class="cbProd" onchange="changeTRX(this)" name="cbProd1" id="cbProd1">
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
                  <td width="90"><img src="images/pln.jpg" alt="indosat"  height="40" onclick="window.location.hash='history';" /></td>
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
          [<?=$vUser." / ".$oMember->getMemberName($vUser);?>]<a name="history"></a>
                </span></span></span><br />
                <br />
     <span class="style10"><strong>Mulai :</strong></span>
                    <input  name="dc1"  id="dc1" value="<?=$vsTglAwal?>" size="9" />
                    <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.frListJual.dc1);return false;" ><img src="calbtn.gif" alt="" name="popcal" width="34" height="22" border="0" align="absmiddle" id="popcal" /></a> <span class="style9">s/d</span>
                <input  name="dc2" class="" id="dc2" value="<?=$vsTglAkhir?>" size="9" />
                  <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.frListJual.dc2);return false;" ><img src="calbtn.gif" alt="" name="popcal" width="34" height="22" border="0" align="absmiddle" id="popcal" /></a>
                  &nbsp;<input type="submit" name="button" id="button" value="Refresh List" /><input type="hidden" id="hList" name="hList" value="1" /><br />
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
		  $vsql="select * from tb_trxpulsa where 1 and fkdproduk like 'PLN%' and fidmember='$vUser' and (date(ftglentry) between  date('$vsTglAwal') and date('$vsTglAkhir'))";
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
			 $vKetAll=explode(", Yth: AA0225, AMH TECHNO",$vKet);
			 if (preg_match("/BERHASIL/i",$vKetAll[1]))
			    $vKet=$vKetAll[0]." BERHASIL";
			 else 	$vKet=$vKetAll[0];
			 
			 $vStatDB=$db->f('fstatustrx');
			 $vSNDB=$db->f('fsn');
			 $vVNDB=$db->f('fvn');
			 if ($vStatDB=='0') {
			     $vStatText='Berhasil';
				 if ($vSNDB !='' || $vVNDB !='')
				    $vStatText.=", SN/Token: $vSNDB, VN: $vVNDB";
			 } else if ($vStatDB=='1')
			     $vStatText='Diproses';
			 else if ($vStatDB=='11' || $vStatDB=='4')
			     $vStatText='Gagal';

		?>
              <tr  <? if ($vStatDB=='0') echo "style='background-color:#66CC66'"; else if ($vStatDB=='11' || $vStatDB=='4') echo "style='background-color:#f00'"?>    >
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
