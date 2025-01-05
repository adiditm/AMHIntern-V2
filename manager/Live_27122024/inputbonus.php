 <?php
  $vUser=$_SESSION['LoginUser'];
   if ($_GET['op']=='spy')
      $vUser=$_GET['uMemberId'];

 
 $refer = $_SERVER['HTTP_REFERER'];
 $vAction=$_POST['hAction'];
 $vNama=$_POST['nama'];
 $vID=$_POST['ID'];
 $vNom=$_POST['tfNom'];
 $vKorek=$_POST['tfKorek'];

 $vTgl=$_POST['dc'];
 $vKet=$_POST['taKet'];
 $vRekFrom=$_POST['tfRekFrom'];
 $vRekTo=$_POST['lmRekTo'];
 $vSync=$_POST['cbSync'];
 if ($vSync!='0')  $vSync='1';
// $vInvest=$oMember->checkInvest($vUser);
  
 
 $vFrom=$oRules->getMailFrom();

 $vMessage="Topup Saldo :\n";
 $vMessage.="Nama\t\t\t: $vNama\n";
 $vMessage.="ID\t\t\t: $vID\n";
 $vMessageReply="$vNama, silakan kirimkan dana sebesar ".number_format($vNom,0,",",".") ." ke bank ".$vRekTo;
 $vSaldo=$oKomisi->getLastBalance($vUser);


 
 if ($vAction=="fPost") {
   if ($vKorek>0) {
		$vNom=$vKorek;
		$vDesc="Input Bonus - $vKet";
		
		if ($vNom > 0)   {
           $vNextID=$oMember->getNextWDID($vTgl);
          // $oMember->regWithdraw($vNextID,$vID,abs($vNom),$vTgl,$vDesc,'','',$vSync);


		   $oKomisi->insertMutasi($vUser,'amh_admin',date("Y-m-d H:i:s"),$vDesc,abs($vNom),0,$vKorek+$vSaldo,'bonus') ;
		}
		
		$oMember->setSaldo($vUser, $vKorek+$vSaldo);
		
		$oSystem->jsAlert("Input bonus sebesar ".number_format($vKorek,0,",",".")." sukses!");
		$oSystem->jsLocation("?menu=inputbonus&op=spy&uMemberId=".$vUser);
	 } else { // Serial Harus diisi
		 $oSystem->jsAlert("Isikan jumlah bonus dengan benar!");
	 }
 
}	//Post


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
</style><table  width="100%"  border="0" cellpadding="0" cellspacing="0">
<script language="javascript">
function saveKorek() {
	var vNom=document.getElementById('tfNom').value;
	var vJadi=document.getElementById('tfKorek').value;

	   
	if (confirm('Yakin input diskon <?=$vUser?> sebesar '+vJadi+'?')==true) {
		document.frmInvest.submit();
	} else return false;
}
</script>
  
  <tr valign="top"> 
    <td align="center" valign="top">
   
      <h3>Input Bonus <?=$oMember->getMemberName($vUser)?> (<?=$vUser?>)</h3>
            <form name="frmInvest" method="post" action="" onsubmit="return saveKorek()">
              <table width="75%" border="0"  cellpadding="4" cellspacing="0" align="center" style="margin-left:40px">
                <tr>
                  <td align="left" style="height: 34px">Tanggal</td>
                  <td style="height: 34px">:</td>
                  <td style="height: 34px">
                    <div align="left">
                      <input  name="dc" id="dc" value="<?=date("Y-m-d")?>" size="12" />
                  <a href="javascript:void(0)" onclick="if(document.frmInvest.dc.value=='') document.frmInvest.dc.value='1965-01-01';if(self.gfPop)gfPop.fPopCalendar(document.frmInvest.dc);return false;" ><img src="calbtn.gif" alt="" name="popcal" width="34" height="22" border="0" align="absmiddle" id="popcal" /></a></div></td>
                </tr>
                <tr> 
                  <td width="129" height="30" align="left">Nama</td>
                  <td width="3">:</td>
                  <td width="335"> <div align="left">
                    <input name="nama" type="text" value="<?=$oMember->getMemberName($vUser)?>" readonly="true">
                    <input name="hAction" type="hidden" id="hAction" value="fPost"> 
                  </div></td>
                </tr>
                <tr>
                  <td align="left">ID</td>
                  <td>:</td>
                  <td><div align="left">
                    <input name="ID" type="text" id="ID" value="<?=$vUser?>" readonly="true" />
                  </div></td>
                </tr>
                <tr> 
                  <td align="left">Jumlah Saldo  </td>
                  <td>:</td>
                  <td> <div align="left">                    <input name="tfNom" type="text" id="tfNom" dir="rtl" value="<?=number_format($vSaldo,0,"","")?>" size="15" readonly style="background-color:#999" > 
                  </div></td>
                </tr>
              <? if (trim($oInterface->getMenuContent("topup",true)) != '') { ?>
                <? } ?>
                
                <tr>
                  <td style="height: 12px" align="left">Bonus</td>
                  <td style="height: 12px">:</td>
                  <td style="height: 12px"><div align="left">
                    <input name="tfKorek" type="text" id="tfKorek" dir="rtl" value="0" size="15"> 
                  </div></td>
                </tr>
                <tr>
                  <td align="left">Keterangan</td>
                  <td valign="top">                :</td>
                  <td><div align="left">
                    <textarea name="taKet" id="taKet" cols="35" rows="4"></textarea>
                  </div></td>
                </tr>
                
                <tr style="display:none">
                  <td height="37" align="left">Sinkron ke Easy Travel</td>
                  <td>:</td>
                  <td><input name="cbSync" type="checkbox" id="cbSync" value="0" checked="checked" /></td>
                </tr>
                <tr> 
                  <td height="37">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td> <div align="left">
                    <input type="submit" name="kirim" value="Submit" > 
                    <input 

type="reset" name="reset" value="Reset"> 
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
	   <iframe name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="js/cal/ipopeng.htm" style="visibility: visible; z-index: 999; position: absolute; left: -500px; top: 0px;" width="174" frameborder="0" height="189" scrolling="No"></iframe>

</iframe>
