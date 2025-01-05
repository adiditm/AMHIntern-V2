<? 
	       if ($_GET['op'] == '') 
           include_once("../framework/admin_headside.blade.php");
        else
           include_once("../framework/member_headside.blade.php") ;  

 if ($vPriv=='sponsor')
     $vJenis = 'sponsor';
 else if ($vPriv=='korwil')
     $vJenis = 'korwil';
 else $vJenis='';	 

 


 $refer = $_SERVER['HTTP_REFERER'];
 $vAction=$_POST['hAction'];
 $vNama=$_POST['nama'];
 $vID=$_POST['ID'];
 if ($vJenis=='korwil') {
	$vSQL = "select fidbisnis from m_korwil where fidkorwil='{$_SESSION['LoginUser']}'";
	$db->query($vSQL);
	$db->next_record();
	$vIdBis= $db->f('fidbisnis');
 }
 $vNom=$_POST['tfNom'];
 $vTgl=$_POST['dc'];
 $vKet=$_POST['taKet'];
 $vRekFrom=$_POST['tfRekFrom'];
 $vRekTo=$_POST['lmRekTo'];
// $vInvest=$oMember->checkInvest($vUser);

 $vSaldoX=0;$vSaldo=0;$vPendingTrans=0;$vPendingWD=0;
 $vPendingWD=$oJual->getPendingWD($vUser,$vJenis);
 $vPendingTrans=$oJual->getPendingTrans($vUser,$vJenis) ;
 $vSaldoX=$oMember->getSaldoAdm($vUser,$vJenis);
 $vMinSal = $oRules->getSettingByField("fmindap");
  
 $vMinWith=$oRules->getSettingByField("fmanfee");
 $vFrom=$oRules->getMailFrom();

 $vMessage="Withdrawal Deposit :\n";
 $vMessage.="Nama\t\t\t: $vNama\n";
 $vMessage.="ID\t\t\t: $vID\n";
 $vMessageReply="$vNama, silakan tunggu approval dari Admin, withdrawal akan dikirim ke $vRekTo";
 $vBankreal = $oMember->getBankNameReal($oMember->getBankAdm($vUser,$vJenis));

 
 if ($vAction=="fPost") {
   if ($vNom>0 ) {
      $vNextID=$oMember->getNextWDID($vTgl);
	 // if ($vJenis=='sponsor')
      	$vProcess=$oMember->regWithdraw($vNextID,$vID,$vNom,$vTgl,$vKet,$vRekFrom,$vRekTo,$vJenis);
	 // else if ($vJenis=='korwil')	$vProcess=$oMember->regWithdraw($vNextID,$vIdBis,$vNom,$vTgl,$vKet,$vRekFrom,$vRekTo,$vJenis);
	  if ($vProcess=='1') {
			$vSMTP='localhost';
			//$oSystem->sendMail($vFrom,$oRules->getMailFrom(1),$vNama,$oRules->getMailBCC(1),"Upgrade",$vMessage,$vSMTP); 
			//echo $vMessageReply;
			//$oSystem->sendMail($oRules->getMailFrom(1),$vFrom,$oRules->getAtasNama(1),$oRules->getMailBCC(1),"Balasan Contact",$vMessageReply,$vSMTP); 
			$vMesgSMS="$vNama, proses withdrawal $vNextID sebesar ".number_format($vNom,0,",",".")." berhasil, silakan tunggu approval dari Admin.";
			$vNoHP=$oMember->getNoHP($vID);
			//$oSystem->smsGateway(date("Y-m-d H:i:s"),preg_replace("/^0/","62",$vNoHP),$vMesgSMS,'Investasi');	
			$oSystem->jsAlert("Withdrawal sukses, harap tunggu proses approval dari Admin!");
			$oSystem->jsAlert($vMessageReply.", jika perlu catatlah pesan ini. Anda juga akan mendapatkan pesan ini di email Anda. Terima kasih!");
			$oSystem->jsLocation("?tack=withdraw");
		 } else { 
	    $oSystem->jsAlert('Withdraw gagal,  saldo tidak cukup!');
	    $vsql="delete from tb_withdraw   where fidwithdraw='$vNextID';";
	   $db->query($vsql);
		
		$oSystem->jsLocation("?tack=withdraw");
		
	  }
	 } else { // Serial Harus diisi
		 $oSystem->jsAlert("Isikan withdraw dengan benar!");
	 }
 
}	//Post


	$vsNoJual=$_POST['tfsnojual'];
	$vsIgnore=$_POST['cbIgnore'];
	$vsIDMember=$_POST['tfsidmember']; 
	$vsTglAwal=$_POST['dc1'];
	if ($vsTglAwal=='') $vsTglAwal=date("Y-m-d",strtotime("-1 week"));
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
<link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />
  
  <script type="text/javascript" src="../js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<script type="text/javascript" src="../js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>

<script type="text/javascript" src="../js/bootstrap-daterangepicker/moment.min.js"></script>
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
  if ('<?=$vBankreal?>' == '-1') {
    alert('Withdraw tidak bisa dilanjutkan, data bank Anda tidak valid. Hubungi admin untuk mengoreksi!');
    return false;
  }
	var vNom=document.getElementById('tfNom').value;
	var vSaldoX=document.getElementById('hSaldo').value;
	var vWD=document.getElementById('tfNom').value;
	var vMinSal=document.getElementById('hMinSal').value;
	var vPending =0;
	if  (document.getElementById('hPending')) {
    		vPending = parseFloat(document.getElementById('hPending').value) + parseFloat(document.getElementById('hPendingTrans').value);
	}
	if (parseFloat(vWD) < parseFloat(<?=$vMinWith?>)) {
		alert('Jumlah yang Anda masukkan kurang dari jumlah withdrawal minimum <?=number_format($vMinWith,0,",",".")?>');
		return false;
	}
    var vAll = parseFloat(vWD) + parseFloat(vPending);
 //  alert(vPending);
	if ((parseFloat(vWD) + parseFloat(vPending) + parseFloat(vMinSal)) > parseFloat(vSaldoX)) {
		alert('Jumlah withdraw '+vWD+' tidak boleh melebihi saldo '+vSaldoX+' (termasuk Transfer, Saldo Mengendap & Withdraw yang pending ('+vPending+')');
		return false;
	} 
	if (document.getElementById('lmRekTo').value=='') {
		alert('Rekening tujuan pembayaran harus dipilih');
		return false;
	}

	if (parseFloat(vWD) < parseFloat(<?=$vMinWith?>)) {
		alert('Jumlah yang Anda masukkan kurang dari jumlah withdrawal minimum <?=$vMinWith?>');
		return false;
	}

	   
	if (confirm('Yakin withdrawal sebesar '+vNom+'?')==true) {
		document.frmInvest.submit();
	} else return false;
}
</script>
  <div class="right_col" role="main">
		<div><label>
		<h3>Pencairan Diskon</h3></label></div>  		

        
          
            <form name="frmInvest" method="post" action="" onsubmit="return saveWithdraw()">
              <div class="row">
              <input type="hidden" id="hPending" name="hPending" value="<?=$vPendingWD?>" />
              <input type="hidden" id="hPendingTrans" name="hPendingTrans" value="<?=$vPendingTrans?>" />
              
                 
                 
                  <div class="col-lg-6">
                   <label>Tanggal</label>
                    <div align="left">
                      <input  name="dc" id="dc" value="<?=date("Y-m-d")?>" size="12" readonly="readonly" class="form-control" />
                    </div>
                    </div>
                 
                 
                 
                  <div class="col-lg-6">
                   <label>Nama</label>
                   
                    <input name="nama" type="text" value="<?=$oMember->getMemberNameAdm($vUser,$vJenis)?>" readonly="true" class="form-control">
                    <input name="hAction" type="hidden" id="hAction" value="fPost"> 
                
                  </div>
                  
 
                  <div class="col-lg-6">
                   <label>Saldo</label>
                   
                    <input name="hSaldo" id="hSaldo" type="text" value="<?=$vSaldoX?>" readonly="true" class="form-control">
                    <input name="hMinSal" id="hMinSal" type="text" value="<?=$vMinSal?>" readonly="true" class="form-control hide">
                   
                   
                
                  </div>                  
               
                 
                 
                  <div class="col-lg-6">
                  <label>ID</label>
                    <input name="ID" type="text" id="ID" value="<?=$vUser?>" readonly="true" class="form-control" />
                  </div>
                  
               
                  
             
                  <div class="col-lg-6"> 
                  <label>Jumlah Pencairan  </label>
                 
                    <input name="tfNom" type="text" id="tfNom" dir="rtl" value="0" size="15" class="form-control"> 
                  </div>
                
                 

                  <div class="col-lg-6">
                   <label>Ditransfer ke Rekening</label>
                  
                    <select name="lmRekTo" id="lmRekTo" onchange="getData(this.value)" class="form-control">
                      <option value="<?=$oMember->getBankNameReal($oMember->getBankAdm($vUser,$vJenis));?> <?=$oMember->getAtasNamaAdm($vUser,$vJenis)?> <?=$oMember->getRekeningAdm($vUser,$vJenis)?>"><?=$oMember->getBankNameReal($oMember->getBankAdm($vUser,$vJenis))?> <?=$oMember->getAtasNamaAdm($vUser,$vJenis)?> <?=$oMember->getRekeningAdm($vUser,$vJenis)?></option>
                
                    </select>
                  </div>
                
                
                

                  <div class="col-lg-6">
                    <label>Pemilik Rekening</label>

                    <input name="tfRekFrom" type="text" id="tfRekFrom" class="form-control" value="<?=$oMember->getAtasNamaAdm($vUser,$vJenis)?>"  />
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
         	 
	

    
    <form style="font-family:Tahoma" action="" method="post" name="frListJual" id="frListJual">
        <br /><h4>History Pencairan
          [<?=$vUser." / ".$oMember->getMemberNameAdm($vUser,$vJenis);?>]</h4>
<br />
              
     <div class="row">
     <div class="col-lg-12">
     
      <div class="col-lg-2"><label for="dc1">Mulai :</label> <input  name="dc1"  id="dc1" value="<?=$vsTglAwal?>" size="9" class="form-control" /></div>
      
                <div class="col-lg-2">
                <label for="dc2">s/d</label>
                <input  name="dc2" id="dc2" value="<?=$vsTglAkhir?>" size="9" class="form-control"  />		
                	</div> <div class="col-lg-2"><input style="margin-top:2.2em" type="submit" name="button" id="button" value="Refresh" class="btn btn-info btn-sm" /></div>
&nbsp;
                

</div>

</div>
                <br /><br />
     <div class="table-responsive">
      <table width="100%%" border="1" align="center" cellpadding="0" cellspacing="0" class="table table-striped table-bordered" style="color:#000">
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
                <td width="18%"><div align="center" class="style9">No Pencairan </div></td>
                <td width="18%"><div align="center" class="style10"><strong>Nilai Pencairan </strong></div>
                    <div align="center" class="style10"></div>
                <div align="center" class="style10"> </div></td>
                <td width="19%"><div align="center" class="style10"><strong>WDraw ke Rek</strong></div></td>
                <td width="19%"><div align="center" class="style10"><strong>Status</strong></div></td>
                <td width="31%"><div align="center">
                  <div align="center" class="style10"><strong>Keterangan</strong></div>
                </div></td>
                <td width="31%"><div align="center">
                  <div align="center" class="style10"><strong>Catatan Admin</strong></div>
                </div></td>
          </tr>
              <?
		  $vsql="select fadmin,ftglupdate,ftglappv,fidwithdraw,fidmember,frekto,fnominal as asubtotal,fstatusrow, fket, fnoteadm from tb_withdraw where 1 and (fidmember='$vUser' or fidmember='$vIdBis') and date(ftglupdate) between  date('$vsTglAwal') and date('$vsTglAkhir')";
		  $vsql.=$vCrit;
		  $vsql.="   order by fidwithdraw ";

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
                <?=$db->f('fidwithdraw')?>
                  <br />                
                  </span></td>
                <td><div align="right" class="style10">
                    <?=number_format($db->f('asubtotal'),0,",",".");?>
                    <? $vTotJual+=$db->f('asubtotal'); ?>
                </div></td>
                <td><span class="style10">
                  <?=$db->f('frekto')?>
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
                <td><span class="style10">
                  <?=$db->f('fnoteadm')?>
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
                <td>&nbsp;</td>
              </tr>
        </table>
      </div>
    </form>
<script language="javascript">
   <? if($vPriv=='administrator') { ?>
   		alert('Pencairanhanya boleh dilakukan oleh Korwil/Subkorwil atau Pebisnis!');
		document.location.href='../manager/indexadmin.php';
   
   <? } ?>
</script>
</div>
	<!-- end page container -->
	

	

<? include_once("../framework/member_footside.blade.php") ; ?>
