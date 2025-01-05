<? include_once("../framework/member_headside.blade.php");?>
 <?php
  $vUser=$_SESSION['LoginUser'];
   if ($_GET['op']=='spy')
      $vUser=$_GET['uMemberId'];

 
 $refer = $_SERVER['HTTP_REFERER'];
 $vAction=$_POST['hAction'];
 $vNama=$_POST['nama'];	
 $vID=$_POST['ID'];
 $vNom=$_POST['hTrans'];
 $vTgl=$_POST['dc'];
 $vTgl=date("Y-m-d H:i:s");
 $vKet=$_POST['taKet'];
 $vKet ="Topup Saldo ";
 $vRekFrom=$_POST['tfRekFrom'];
 $vRekTo=$_POST['hRekTo'];
// $vInvest=$oMember->checkInvest($vUser);
  $vBatas=date('Y-m-d H:i:s', strtotime('+1 hour'));
 
 $vFrom=$oRules->getMailFrom();

 $vMessage="Topup Saldo Auto :\n";
 $vMessage.="Nama\t\t\t: $vNama\n";
 $vMessage.="ID\t\t\t: $vID\n";
 $vMessageReply="$vNama, silakan kirimkan dana sebesar ".number_format($vNom,0,",",".") .' ke bank '.$vRekTo;

$vHal2 ='<div class="row"> <div class="col-lg-12"><br><br><b>Jumlah yang harus Anda transfer adalah :</b> <h2 style="color:blue">Rp '.number_format($vNom,0,",",".").'</h2>

Silahkan transfer ke : <br>'.
$vRekTo. ' dari pemilik rekening atas nama '.$vRekFrom.' <br> <br>';
/*
<b>BATAS WAKTU TRANSFER HANYA 60 MENIT dari sekarang (time limit : '.$vBatas.')</b>

<br><br>Setelah transfer BERHASIL, otomatis saldo agen akan bertambah OTOMATIS
sejumlah Rp '.number_format($vNom,0,",",".").' dalam waktu <b>MAKSIMAL 30 MENIT</b>
<br><br>
Note :
<br>
<ul>
<li>- Jika anda transfer tidak sesuai dengan nominal diatas / Melebihi batas waktu transfer deposit anda</li>
di system darsatour tidak akan bertambah otomatis
<li>- Transaksi BCA tidak dapat digunakan dari jam 21.00 WIB - 05.00 WIB</li>
<li style="font-weight:bold">- Mohon tidak merefresh halaman ini di browser Anda</li>
</ul>

<p align="center" style="text-align:center;font-weight:bold">Terima kasih Anda telah melakukan TOP-UP Otomatis.
*/
$vHal2 .='Kami bangga melayani Anda
<br><br>
<input class="btn btn-success" type="button" onclick="document.location.href=\'../member/topup-auto.php\'" value="&laquo; Kembali ke Halaman Topup " />
</p></div></div>
';

 
 if ($vAction=="fPost") {
   if ($vNom>0 ) {
      $vNextID=$oMember->getNextTopupID($vTgl);
      $oMember->regTopup($vNextID,$vID,$vNom,$vTgl,$vKet,$vRekFrom,$vRekTo,'0',0);
		//$vSMTP=$oRules->getSMTP(1);
		
		//echo $vMessageReply;
				?>


	
		<?
		echo $vHal2;
		include_once("../framework/footer.blade.php");
		//$oSystem->sendMail($oRules->getMailFrom(1),$vFrom,$oRules->getAtasNama(1),$oRules->getMailBCC(1),"Balasan Contact",$vMessageReply,$vSMTP); 
		$vMesgSMS="$vNama, selamat proses topup $vNextID sebesar ".number_format($vNom,0,",",".")." berhasil, silakan transfer dana ke rekening $vRekTo.";
		//$oSystem->sendMail($vFrom,$oMember->getEmail($vID),$vNama,$oRules->getMailBCC(1),"Topup",$vMessage."\n\n".$vMesgSMS,$vSMTP); 
		
		$vNoHP=$oMember->getNoHP($vID);

		$vFrom=$oRules->getMailFrom(1);
		//$vSMTP=$oRules->getSMTP(1);
		 $vMailGW=$oRules->getSettingByField('ftoprank1');
		//$oSystem->smtpMailer3('ismsgateway@yahoo.co.id',$vFrom,$vNama,$vNoHP,"DARSATOUR\n".$vMessage,"",$oRules->getMailBCC(1));
		//$oSystem->sendMailSMS($vFrom,$vMailGW,"SMS Gateway",$oRules->getMailBCC(1),$oRules->getHPConf(1),$vMessage,$vSMTP);
		
		//$oSystem->smsGateway(date("Y-m-d H:i:s"),preg_replace("/^0/","62",$vNoHP),$vMesgSMS,'Investasi');	
		$oSystem->jsAlert("Topup sukses, harap selesaikan administrasinya!");
	//	$oSystem->jsAlert($vMessageReply.", jika perlu catatlah pesan ini. Anda juga akan mendapatkan pesan ini di email Anda. Terima kasih!");
		$oSystem->jsLocation("../memstock/topup.php");
	    exit;
	 } else { // Serial Harus diisi
		 $oSystem->jsAlert("Isikan topup dengan benar!");
	 }
 
}	//Post


	$vsNoJual=$_POST['tfsnojual'];
	$vsIgnore=$_POST['cbIgnore'];
	$vsIDMember=$_POST['tfsidmember']; 
	$vsTglAwal=$_POST['dc1'];
	if ($vsTglAwal=='') $vsTglAwal=date("Y-m-d");
	$vsTglAkhir=$_POST['dc2'];
	if ($vsTglAkhir=='') $vsTglAkhir=date("Y-m-d");
	
 	$vPostID=$_POST['tfID'];
	$vPostIDProd=$_POST['tfIDProd'];
	$vPostJumlah=$_POST['tfJumlah'];
	$vPostTanggal=$_POST['dc'];
	$vTanggal=$oPhpdate->getNowYMD("-");
	$vNoJual="J".$oPhpdate->getNowYMDTFlat();
	
	if ($vsNoJual!="")
    $vCrit.=" and fidtopup like '%$vsNoJual%' ";
	if ($vsIDMember!="")
    $vCrit.=" and fidmember = '$vsIDMember' ";

 ?>
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />
<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #0000FF; }
.style7 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #0000FF;}
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
.style11 {color: #FFFFFF}
input,select,textarea,button {
	border:1px solid #999;
}
-->
.dd-selected {
	height:32px;
}
</style>

<div class="content-wrapper" >
<section class="content" >
  

        
    <div class="wrapper">   

<script src="../js/jquery.price_format.js"></script>
 <script type="text/javascript" src="../js/jquery.ddslick.min.js"></script>
 <script type="text/javascript" src="../js/jquery.dump.js"></script>

<script language="javascript">

$( document ).ready(function() {
	$('#dc1,#dc2').datepicker({
		changeYear: true,
		changeMonth: true,
		showButtonPanel: true,
		dateFormat: 'yy-mm-dd',
		beforeShow: function (textbox, instance) {
				instance.dpDiv.css({
						marginTop: '0px',
						marginLeft: '0px'
				});
		}
	});



  $('#lmRekTo').ddslick({

    onSelected: function (data) {
        
		$('#hRekTo').val(data.selectedData.value);
    }
});

});
function saveTopup() {
	//alert(document.getElementById('hRekTo').value);
	var vNom=document.getElementById('hTrans').value;
	if (document.getElementById('lmRekTo').value=='') {
		alert('Rekening tujuan pembayaran harus dipilih');
		return false;
	}

	if (document.getElementById('hRekTo').value=='') {
		alert('Rekening tujuan pembayaran harus dipilih');
		return false;
	}

	if (document.getElementById('tfRekFrom').value=='') {
		alert('Pemilik rekening asal pembayaran harus diisi');
		return false;
	}
	   
	if (confirm('Yakin topup sebesar '+vNom+'?')==true) {
		document.frmInvest.submit();
	} else return false;
}

function genUnique(pParam) {
    var vRand=(""+Math.random() * 4).substring(2,5)	;
	var vNom=parseFloat(pParam) + parseFloat(vRand);
	$('#sptrans').html(vNom);
	$('#hTrans').val(vNom);
	
     $('#sptrans').priceFormat({     
                    prefix: ' ',
                    centsSeparator: ',',
                    thousandsSeparator: '.',
                    limit: 15,
                    centsLimit: 0
                });	
}


</script>

  


    
    <?  if ($_GET['op']!='spy') {?>
         


            <div class="panel" style="padding:1em 1em 1em 1em">
            <form name="frmInvest" method="post" action="" onSubmit="return saveTopup()">

                <div class="row">                   
                  <div class="col-lg-4">
                  <label width="129" height="30">Nama</label>
                    <input class="form-control" id="nama" name="nama" type="text" value="<?=$oMember->getMemberName($vUser)?>" readonly="true">
                    <input name="hAction" type="hidden" id="hAction" value="fPost"> 
                  </div>
               
               
				<div class="col-lg-4">
	                
				 <label>ID</label>

                  
                    <input class="form-control"  name="ID" type="text" id="ID" value="<?=$vUser?>" readonly="true" />
                  </div>
			 </div>
			 
			 <br>
                <div class="row"> 
                  <div class="col-lg-4">

                  <label>Jumlah Topup  </label>


                    <input placeholder="Masukkan angka tanpa titik/koma" class="form-control" name="tfNom" type="text" id="tfNom" dir="rtl" value="0" size="15" onKeyUp="genUnique(this.value)">
                    <span style="font-size:12px;font-weight:bold;color:blue">Nominal yg harus Anda transfer : Rp</span> <span style="font-size:12px;font-weight:bold;color:blue" id="sptrans">0</span>
                    <input type="hidden" name="hTrans" id="hTrans" value="" />
                  </div>
                  
               
              <? if (trim($oInterface->getMenuContent("topup",true)) != '') { ?>
                <? } ?>
                 <div class="col-lg-4">

 			       
                  
                  <label>Bayar ke Rekening</label>
                    <select  name="lmRekTo" id="lmRekTo" onChange="" class="form-control">
                      <option value="">--Pilih--</option>
                      
                      <option value="BCA Spectra 8908022808" data-imagesrc="../images/bcadropd.png" data-description="a.n. Spectra">BCA Spectra 8908022808</option>
                      <option value="Mandiri Spectra 908084408080" data-imagesrc="../images/mandiridropd.png" data-description="a.n. Spectra">Mandiri Spectra 908084408080</option>
                
                    </select>
                    <input type="hidden" name="hRekTo" id="hRekTo" value="" />
                  </div>
                  </div>
                  
                  <br>
                <div class="row"> 
        
                  <div class="col-lg-4">
                  <label>Pemilik Rekening Pengirim</label>
                    <input class="form-control" name="tfRekFrom" type="text" id="tfRekFrom"  />
                  </div>
                </div>
 <br>
                <div class="row"> 
                  <div class="col-lg-4">
                    <input class="btn btn-success" type="submit" name="kirim" value="Kirim" > 
                    <input type="reset" name="reset" class="btn btn-default" value="Bersihkan"> 
                  </div>
                  </div>
                

            </form>

       	 
	<? } ?>   


<form style="font-family:Tahoma" action="" method="post" name="frListJual" id="frListJual">
      <h3><span class="style1" style="text-align:center">History Topup
          [<?=$vUser." / ".$oMember->getMemberName($vUser);?>]
                </span></h3><br />
                <br />
     
                    <div class="col-lg-2"><input class="form-control"  name="dc1"  id="dc1" value="<?=$vsTglAwal?>" size="9" />
                    
                   </div>
                <div class="col-lg-2">    
                <input class="form-control"  name="dc2"  id="dc2" value="<?=$vsTglAkhir?>" size="9" />
                  
                </div>  
                  &nbsp;<input class="btn btn-success" type="submit" name="button" id="button" value="Refresh" /><br> <br>
      <table width="100%"  align="center" cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
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
      <tr  >
                <td width="14%" style="height: 26px"><div align="center" class="style9">Tanggal</div></td>
                <td width="18%" class="visible-md visible-lg" style="height: 26px"><div align="center" class="style9">No Topup </div></td>
                <td width="18%" style="height: 26px"><div align="center" class="style10"><strong>Nilai Topup </strong></div>
                    <div align="center" class="style10"></div>
                <div align="center" class="style10"> </div></td>
                <td width="19%" class="visible-md visible-lg" style="height: 26px"><div align="center" class="style10"><strong>Byr ke Rek</strong></div></td>
                <td width="19%" class="visible-md visible-lg" style="height: 26px"><div align="center" class="style10"><strong>Pemilik Rek</strong></div></td>
                <td width="19%" style="height: 26px"><div align="center" class="style10"><strong>Status</strong></div></td>
                <td width="31%" class="visible-md visible-lg" style="height: 26px"><div align="center">
                  <div align="center" ><strong>Keterangan</strong></div>
                </div></td>
          </tr>
              <?
		  $vsql="select fadmin,ftglupdate,ftglappv,fidtopup,fidmember,frekfrom,frekto,fnominal as asubtotal,fstatusrow, fket from tb_topup where 1 and fidmember='$vUser' and (date(ftglupdate) between  date('$vsTglAwal') and date('$vsTglAkhir')    or    date(ftglappv) between  date('$vsTglAwal') and date('$vsTglAkhir')) and fstatusrow in('0','2','4','5','6')";
		  $vsql.=$vCrit;
		  $vsql.="   order by fidtopup ";

		  $db->query($vsql);
		  
		  $vTotJual=0; $vTotPoint=0;
		  while ($db->next_record()) {
			 $vKet="";    
			 $vProcessed=$db->f('fstatusrow');
			 $vAppv=$db->f('ftglappv');
			 $vAdmin=$db->f('fadmin');
		?>
              <tr     >
                <td style="height: 35px"><div align="center" class="style10">
                    <?=$oPhpdate->YMD2DMY($db->f('ftglupdate'),"-")?>
                    <br />
                </div></td>
                <td class="visible-md visible-lg" style="height: 35px"><span class="style10">
                <?=$db->f('fidtopup')?>
                  <br />                
                  </span></td>
                <td style="height: 35px"><div align="right" class="style10">
                    <?=number_format($db->f('asubtotal'),0,",",".");?>
                    <? $vTotJual+=$db->f('asubtotal'); ?>
                </div></td>
                <td class="visible-md visible-lg" style="height: 35px"><span class="style10">
                  <?=$db->f('frekto')?>
                </span></td>
                <td class="visible-md visible-lg" style="height: 35px"><span class="style10">
                  <?=$db->f('frekfrom')?>
                </span></td>
                <td style="height: 35px"><div align="left" class="style10">
                				<?
				   if ($vProcessed==5 || $vProcessed==0 )
				      echo '<span class="btn btn-info btn-xs">Pending</span>';
				   else if ($vProcessed==6 || $vProcessed==2) 
				      echo '<span class="btn btn-success btn-xs">Approved</span> <strong>'.$oPhpdate->YMD2DMY($vAppv,"-")."</strong> by ".$vAdmin;
				   else if ($vProcessed==4)
				      echo '<span class="btn btn-danger btn-xs">Dibatalkan</span>';  	  
					  	   
				?>

				</div></td>
                <td class="visible-md visible-lg" style="height: 35px"><span class="style10">
                  <?=$db->f('fket')?>
                </span></td>
              </tr>
              <? 
     
	 } // while $db->next_record //if $vCrit
  ?>
              <tr>
                <td  style="height: 19px"><span class="style10"><strong>Total</strong></span></td>
                <td style="height: 19px" class="visible-md visible-lg"></td>
                <td style="height: 19px"><div align="right" class="style10"><strong>
                    <?=number_format($vTotJual,0,",",".");?>
                </strong></div></td>
                <td style="height: 19px" class="visible-md visible-lg"></td>
                <td style="height: 19px" class="visible-md visible-lg"></td>
                <td style="height: 19px"><span class="style10"></span></td>
                <td style="height: 19px" class="visible-md visible-lg"></td>
              </tr>
        </table>
    </form>
</section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script type="text/javascript" src="../js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script language="javascript">
$(document).ready(function(){

      $('#caption').html('Topup Saldo');
});  
</script>

<?

           include_once("../framework/member_footside.blade.php");

?>

