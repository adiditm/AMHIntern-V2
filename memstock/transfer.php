<? include_once("../framework/admin_headside.blade.php");

  $vUser=$_SESSION['LoginUser'];
   if ($_GET['op']=='spy')
      $vUser=$_GET['uMemberId'];


 $refer = $_SERVER['HTTP_REFERER'];
 $vAction=$_POST['hAction'];
 $vNama=$_POST['nama'];
 $vID=$_POST['ID'];
 $vtoID=$_POST['toID'];
 $vNom=$_POST['tfNom'];
 $vTgl=$_POST['dc'];
 $vKet=$_POST['taKet'];
  $vPass=$_POST['tfPass'];

 if ($vPriv=='sponsor')
     $vJenis = 'sponsor';
 else if ($vPriv=='korwil')
     $vJenis = 'korwil';
 else $vJenis='';	
// $vInvest=$oMember->checkInvest($vUser);

 $vSaldoX=0;$vSaldo=0;$vPendingTrans=0;$vPendingWD=0;
 $vPendingWD=$oJual->getPendingWD($vUser,$vJenis);
 $vPendingTrans=$oJual->getPendingTrans($vUser,$vJenis) ;
 $vSaldoX=$oMember->getSaldoAdm($vUser,$vJenis);
  
 $vMinTrans=$oRules->getSettingByField("fmintransfer");
 $vFrom=$oRules->getMailFrom();
  

 $vFrom=$oRules->getMailFrom();

 $vMessage="Transfer Saldo :\n";
 $vMessage.="Nama\t\t\t: $vNama\n";
 $vMessage.="ID\t\t\t: $vID\n";
 $vMessageReply="$vNama, permintaan transfer saldo dari $vID ke $vtoID sukses, silakan tunggu approval dari Admin!";

$vSaldoX=0;$vSaldo=0;$vPendingTrans=0;$vPendingWD=0;
 $vPendingWD=$oJual->getPendingWD($vUser,$vJenis);
 $vPendingTrans=$oJual->getPendingTrans($vUser,$vJenis) ;
 $vSaldoX=$oMember->getSaldoAdm($vUser,$vJenis);
 
 
 if ($vAction=="fPost") {

 if($vJenis=='sponsor') {
	  if ($oMember->authSponActiveID($vtoID) == 0) {
		$oSystem->jsAlert("Pebisnis ID Tujuan Transfer tidak ada atau tidak aktif!"); 
		$oSystem->jsLocation("../memstock/transfer.php?op=&current=mdm_pebisnis&menu=spon_trans_tsaldo");
		exit;
	 }
	 
	 if ($oMember->authSponPass($vID,$vPass) == 0) {
	$oSystem->jsAlert("Password salah!"); 
	$oSystem->jsLocation("../memstock/transfer.php?op=&current=mdm_pebisnis&menu=spon_trans_tsaldo");
	exit;
 }	 
 } else if($vJenis=='korwil') {
		 
	  if ($oMember->authKorwilActiveID($vtoID) == 0) {
		$oSystem->jsAlert("Korwil ID Tujuan Transfer tidak ada atau tidak aktif!"); 
		$oSystem->jsLocation("../memstock/transfer.php?op=&current=mdm_pebisnis&menu=spon_trans_tsaldo");
		exit;
	 }
 
 if ($oMember->authKorwilPass($vID,$vPass) == 0) {
	$oSystem->jsAlert("Password salah!"); 
	$oSystem->jsLocation("../memstock/transfer.php?op=&current=mdm_pebisnis&menu=spon_trans_tsaldo");
	exit;
 }	 
 }

 
 if (($oMember->getSaldoAdm($vUser,$vJenis) - $vEndap) < $vNom) {
	$oSystem->jsAlert("Saldo aktif tidak cukup untuk transfer!"); 
	$oSystem->jsLocation("../memstock/transfer.php?op=&current=mdm_pebisnis&menu=spon_trans_tsaldo");
	exit;
 }	 
   if ($vNom>0 ) {
      $vNextID=$oMember->getNextTransID($vTgl);
      $vRegTrans=$oMember->regTransfer($vNextID,$vID,$vNom,$vTgl,$vKet,$vtoID);
	  
	 // $vProcess=$oJual->processTrans($vNextID,'manager',$vID,$vNom, $vKet, $vtoID);
	  if ($vRegTrans=='1') {
	    
		$vSMTP="localhost";
		//$oSystem->sendMail($vFrom,$oRules->getMailFrom(1),$vNama,$oRules->getMailBCC(1),"Transfer Saldo",$vMessage,$vSMTP);
		
		$oSystem->smtpmailer($vFrom,$oRules->getMailFrom(1),$vNama,'Transfer Saldo',$vMessage,"amhtechs@gmail.com","",true);
		 
		echo $vMessageReply;
	//	$oSystem->sendMail($oRules->getMailFrom(1),$vFrom,$oRules->getAtasNama(1),$oRules->getMailBCC(1),"Balasan Contact",$vMessageReply,$vSMTP); 
		$oSystem->smtpmailer($oRules->getMailFrom(1),$vFrom,$vNama,'Balasan Transfer Saldo',$vMessageReply,"amhtechs@gmail.com","",true);
		$vMesgSMS="$vNama, permintaan transfer saldo ke $vtoID sebesar ".number_format($vNom,0,",",".")." berhasil, silakan tunggu approval dari Admin!.";
		$vNoHP=$oMember->getNoHP($vID);
		//$oSystem->smsGateway(date("Y-m-d H:i:s"),preg_replace("/^0/","62",$vNoHP),$vMesgSMS,'Investasi');	
		$oSystem->jsAlert("Permintaan transfer saldo sukses, silakan tunggu aprroval dari Admin!");
		//$oSystem->jsAlert($vMessageReply.", jika perlu catatlah pesan ini. Anda juga akan mendapatkan pesan ini di email Anda. Terima kasih!");
		$oSystem->jsLocation("../memstock/transfer.php?op=&current=mdm_pebisnis&menu=spon_trans_tsaldo");
	  } else { 
	    $oSystem->jsAlert('Transfer gagal, kemungkinan saldo tidak cukup!');
	    $vsql="delete from tb_baltrans   where fidtrans='$vNextID' and fstatusrow=0;";
	   $db->query($vsql);
		
		$oSystem->jsLocation("../memstock/transfer.php?op=&current=mdm_pebisnis&menu=spon_trans_tsaldo");
		
	  }
	 } else { // Serial Harus diisi
		 $oSystem->jsAlert("Isikan jumlah transfer dengan benar!");
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
    $vCrit.=" and fidwithdraw like '%$vsNoJual%' ";
	if ($vsIDMember!="")
    $vCrit.=" and fidwithdraw = '$vsIDMember' ";

 ?>
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
</style>
<link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />
  
  <script type="text/javascript" src="../js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<script type="text/javascript" src="../js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script language="javascript">

$(document).ready(function(){
	   $('#dc1').datepicker({

                    format: "yyyy-mm-dd",

                    autoclose : true

    }).on('changeDate', function (ev) {
    	$(this).datepicker('hide');
    });  
  

    

       $('#dc2').datepicker({

                    format: "yyyy-mm-dd",

                    autoclose : true

    }).on('changeDate', function (ev) {
   		 $(this).datepicker('hide');
    });  
 


});	
	

function saveWithdraw() {
	var vNom=document.getElementById('tfNom').value;
	var vSaldoX=document.getElementById('hSaldo').value;
	var vWD=document.getElementById('tfNom').value;

	if (parseFloat(vWD) < parseFloat(<?=$vMinTrans?>)) {
		alert('Jumlah yang Anda masukkan kurang dari jumlah transfer minimum <?=number_format($vMinTrans,0,",",".")?>');
		return false;
	}

	if  (document.getElementById('hPending')) {
    		vPending = parseFloat(document.getElementById('hPending').value) + parseFloat(document.getElementById('hPendingTrans').value);
	}
	if (parseFloat(vWD) < parseFloat(<?=$vMinTransh?>)) {
		alert('Jumlah yang Anda masukkan kurang dari jumlah transfer minimum <?=number_format($vMinTransh,0,",",".")?>');
		return false;
	}
    var vAll = parseFloat(vWD) + parseFloat(vPending);
 //  alert(vPending);
    var vSaldoY = parseFloat(vSaldoX) - parseFloat('<?=$vEndap?>');
	if ((parseFloat(vWD) + parseFloat(vPending)) > parseFloat(vSaldoY)) {
		alert('Jumlah transfer ('+vWD+') tidak boleh melebihi saldo aktif '+parseFloat(vSaldoY)+' (termasuk Transfer & Withdraw yang pending ('+vPending+')');
		return false;
	} 
	
	if (parseFloat(vWD) <=0 ) {
		alert('Jumlah transfer tidak boleh nol atau negatif');
		return false;
	}

	   
	if (confirm('Yakin transfer sebesar '+vNom+'?')==true) {
		document.frmInvest.submit();
	} else return false;
}
</script>
	<div class="right_col" role="main">

		<div><label>
		<h3>Transfer Saldo</h3></label></div>  
        

            <form name="frmInvest" method="post" action="" onsubmit="return saveWithdraw()">
              <div class="row">
                 
        <input type="hidden" id="hPending" name="hPending" value="<?=$vPendingWD?>" />
              <input type="hidden" id="hPendingTrans" name="hPendingTrans" value="<?=$vPendingTrans?>" />             
                  <div class="col-lg-6">
                   <label>Tanggal</label>
                    <div align="left">
                      <input  name="dc" id="dc" value="<?=date("Y-m-d")?>" size="12" readonly="readonly"  class="form-control" />
                    </div>
                    </div>
               
                 

                  <div class="col-lg-6">
                   <label>Nama</label>
                    <input class="form-control" name="nama" type="text" value="<?=$oMember->getMemberNameAdm($vUser,$vJenis)?>" readonly="true" >
                    <input name="hAction" type="hidden" id="hAction" value="fPost"> 
                  </div>
     
      <div class="col-lg-6">
                   <label>Saldo</label>
                   
                    <input name="saldo" id="hSaldo" type="text" value="<?=$oMember->getSaldoAdm($vUser,$vJenis)?>" readonly="true" class="form-control">
                    <input name="hAction" type="hidden" id="hAction" value="fPost"> 
                
                  </div>                 
               
                  <div class="col-lg-6">
                  <label>ID Pengirim</label>
                    <input class="form-control" name="ID" type="text" id="ID" value="<?=$vUser?>" readonly="true" />
                  </div>
               
                  
                  
                  <div class="col-lg-6"><label>Password Anda</label>
                    <input class="form-control" name="tfPass" type="password" id="tfPass"  />
                  </div>
                
                  
                  
                  <div class="col-lg-6">
                  <label>ID Tujuan Transfer</label>
                    <input name="toID" type="text" id="toID"  class="form-control" placeholder=" Contoh : 1511-0000-XXXX, MLG01"  />
                 
                  </div>
               
                 
                 
                  <div class="col-lg-6">
                   <label>Jumlah Transfer  </label>
                    <input name="tfNom" type="text" id="tfNom" dir="rtl" value="0" size="15" class="form-control"> 
                  </div>
               
                 
                 
                  <div class="col-lg-6"> 
                  <label>Keterangan</label>
                    <textarea name="taKet" id="taKet" cols="45" rows="7" class="form-control"></textarea>
                  </div>
</div>
                
                <div class="row"> 
                  <div class="col">&nbsp;</div>
                  <div class="col">&nbsp;</div>
                  <div class="col"> <div align="left">
                    <input type="submit" name="kirim" value="Kirim" class="btn btn-success" > 
                    <input 

type="reset" name="reset" value="Bersihkan" class="btn btn-default"> 
                  </div></div>
                </div>
            </form>
         

<div class="row">
<div class="col-lg-12">    
   <form style="font-family:Tahoma" action="" method="post" name="frListJual" id="frListJual">
        <br />
        <h4>History Transfer
          [<?=$vUser." / ".$oMember->getMemberNameAdm($vUser,$vJenis);?>]</h4>
<br />
              

     
      <div class="col-lg-2"><label for="dc1">Mulai :</label> <input  name="dc1"  id="dc1" value="<?=$vsTglAwal?>" size="9" class="form-control" /></div>
      
                <div class="col-lg-2">
                <label for="dc2">s/d</label>
                <input  name="dc2" id="dc2" value="<?=$vsTglAkhir?>" size="9" class="form-control"  />		
                	</div> <div class="col-lg-2"><input style="margin-top:2.2em" type="submit" name="button" id="button" value="Refresh" class="btn btn-info btn-sm" /></div>
&nbsp;
                


      <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
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
                <td width="14%" height="26"><div align="center" class="style9">Tanggal</div></td>
                <td width="18%"><div align="center" class="style9">No Transfer </div></td>
                <td width="18%"><div align="center" class="style10"><strong>Nilai Transfer </strong></div>
                    <div align="center" class="style10"></div>
                <div align="center" class="style10"> </div></td>
                <td width="19%"><div align="center" class="style10"><strong>Transfer ke ID Member</strong></div></td>
                <td width="19%"><div align="center" class="style10"><strong>Status</strong></div></td>
                <td width="31%"><div align="center">
                  <div align="center" class="style10"><strong>Keterangan</strong></div>
                </div></td>
          </tr>
              <?
		  $vsql="select fadmin,ftglupdate,ftglappv,fidtrans,fidmember,fidto,fnominal as asubtotal,fstatusrow, fket from tb_baltrans where 1 and fidmember='$vUser' and date(ftglupdate) between  date('$vsTglAwal') and date('$vsTglAkhir')";
		  $vsql.=$vCrit;
		  $vsql.="   order by fidtrans ";

		  $db->query($vsql);
		  
		  $vTotJual=0; $vTotPoint=0;
		  while ($db->next_record()) {
			 $vKet="";    
			 $vProcessed=$db->f('fstatusrow');
			 $vAppv=$db->f('ftglappv');
			 $vAdmin=$db->f('fadmin');
		?>
              <tr  <? if ($vProcessed==2) echo "style='background-color:#009999'"; else if ($vProcessed==4) echo "style='background-color:#666'"?>    >
                <td><div align="center" class="style10">
                    <?=$oPhpdate->YMD2DMY($db->f('ftglupdate'),"-")?>
                    <br />
                </div></td>
                <td><span class="style10">
                <?=$db->f('fidtrans')?>
                  <br />                
                  </span></td>
                <td><div align="right" class="style10">
                    <?=number_format($db->f('asubtotal'),0,",",".");?>
                    <? $vTotJual+=$db->f('asubtotal'); ?>
                </div></td>
                <td><span class="style10">
                  <?=$db->f('fidto')?>
                </span></td>
                <td><div align="center" class="style10">
				<?
				   if ($vProcessed==0 || $vProcessed==1)
				      echo "Pending";
				   else if ($vProcessed==2) 
				      echo "Approved <strong>".$oPhpdate->YMD2DMY($vAppv,"-")."</strong> by ".$vAdmin;
				   else if ($vProcessed==4)
				      echo "Dibatalkan";  	  
					  	   
				?>
				</div></td>
                <td><span class="style10">
                  <?=$db->f('fket')?>
                </span></td>
              </tr>
              <? 
     
	 } // while $db->next_record //if $vCrit
  ?>
              <tr>
                <td colspan="2"><span class="style10"><strong>Total</strong></span></td>
                <td><div align="right" class="style10"><strong>
                    <?=number_format($vTotJual,0,",",".");?>
                </strong></div></td>
                <td>&nbsp;</td>
                <td><span class="style10"></span></td>
                <td>&nbsp;</td>
              </tr>
        </table>
    </form>

<script language="javascript">
   <? if($vPriv=='administrator') { ?>
   		alert('Transfer Saldo hanya boleh dilakukan oleh Korwil/Subkorwil atau Pebisnis!');
		document.location.href='../manager/indexadmin.php';
   
   <? } ?>
</script>

 </div>
<? include_once("../framework/admin_footside.blade.php") ; ?>    