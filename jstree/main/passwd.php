<?php
$vPinOK=0;
$vPostPin=$_POST['hPin'];

$vNewPass=$_POST['tfNewPass'];
$vOldPostPass=$_POST['tfOldPass'];
$vConfirm=$_POST['tfConfirm'];
$vPin=$_POST['tfPin'];

  if ($vPin!="") {
	if ($oMember->authPin($vUser,$vPin)==1)
	   $vPinOK=1;
	else {   
	   $vPinOK=0;
	   $oSystem->jsAlert('Pin salah, mohon ulangi lagi!');
	}
  } 
  if ($vPostPin=="exist")
      $vPinOK=1;
  
if (strlen($vNewPass)>0 && strlen($vOldPostPass) > 0) {
	$vOldPass=$oMember->getPass($vUser);
	if ($vOldPass==$vOldPostPass) {
	   $vSucc=$oMember->setPassConfirm($vUser,$vNewPass,$vConfirm);
	   if ($vSucc=='1') {
		  $oSystem->jsAlert("Logout otomatis!"); 
	      $oSystem->jsLocation("logout.php");
	   }
	}
	   
	else
	   $oSystem->jsAlert("Password lama salah!");   
	
	   // if ($vOldHP != $vNoHP)
        //   $db->query("insert into tb_logchange(fkdanggota,fold,fnew,ftipe,fket,ftglentry) values('$vUser','$vOldHP','$vNoHP','1','Penggantian nomor HP',now())");
       // if ($vOldRek != $vNoRek)
        //    $db->query("insert into tb_logchange(fkdanggota,fold,fnew,ftipe,fket,ftglentry) values('$vuser','$vOldBank $vOldRek','$vBank $vNorek','2','Penggantian nomor Rekening',now())");
		
} else {
  if ($_POST['hAction']=="posting")
  $oSystem->jsAlert("Anda tidak melakukan perubahan password!");
}	  

?>     


<?
$db->query("select * from m_anggota where fidmember='".$vUser."'");
if ($db->next_record())
{

?>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function validate() { 
   if (frmPass.tfConfirm.value!=frmPass.tfNewPass.value) {
	   alert('Konfirmasi tidak sama!');
	   return false;
   }

   if (frmPass.tfOldPass.value==frmPass.tfNewPass.value) {
	   alert('Password tidak berubah!');
	   return false;
   }


frmPass.submit();
}
//-->
</script>
<form name="frmPass"  method="post">
      <table  width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" class="contentfont">
        <tr> 
          <td height="20" align="center" valign="middle"> <p><strong><font size="4"> 
          Ubah Password</font><br>
              </strong></p></td>
        </tr>
        <tr> 
          
      <td height="19"><strong>
        <input type="hidden" name="hPin" value="exist">
        </strong></td>
        </tr>    
		<tr valign="top"> 
          <td height="92" valign="top"> <table width="100%" border="0" cellspacing="0" cellpadding="0" class="contentfont">
          <tr> 
            <td width="213" height="23"><div align="left">Kode anggota</div></td>
            <td width="7"><strong>:</strong></td>
            <td width="387">
              <div align="left">
                <?=$vUser?>
            </div></td>
          </tr>
          <tr> 
            <td width="213" height="23"><div align="left">Password Lama</div></td>
            <td width="7"><strong>:</strong></td>
            <td width="387"><div align="left">
              <input name="tfOldPass" type="password"> 
            </div></td>
          </tr>
          <tr> 
            <td height="24"><div align="left">Password Baru</div></td>
            <td><strong>:</strong></td>
            <td><div align="left">
              <input name="tfNewPass" type="password" > 
            </div></td>
          </tr>
          <tr> 
            <td height="21"><div align="left">Ulangi Password Baru</div></td>
            <td><strong>:</strong></td>
            <td><div align="left">
              <input name="tfConfirm" type="password" >
              <input name="hAction" type="hidden" value="posting">
            </div></td>
          </tr>
        </table></td>
        </tr>
        <tr valign="top"> 
          
      <td height="21" valign="top"><br>
        <table width="184" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr> 
                <td width="57"><input name="kirim" type="button" onclick="validate()"  value="Simpan"></td>
                <td width="121"><input type="reset" name="reset" value="Reset"></td>
              </tr>
        </table></td>
        </tr>
      </table>
</form>
<?php
}
?>