<? include_once("../framework/member_headside.blade.php")?>
<?php
$vPinOK=0;
$vPostPin=$_POST['hPin'];
//print_r($_SESSION['securimage_code_value']['default']);echo "xxxx";
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
	if ($_SESSION['securimage_code_value']['default'] == $_POST['ct_captcha']) {
	if ($vOldPass==$vOldPostPass)
	   $oMember->setPassConfirm($vUser,$vNewPass,$vConfirm);
	else
	   $oSystem->jsAlert("Password lama salah!");   
	} else $oSystem->jsAlert("Security Code salah!");   
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


$(document).ready(function(){
      $('#caption').html('Change Password');

  
});	





//-->
</script>

	<div id="content" class="content">
			<ol class="breadcrumb pull-right">
				<h4><li><a href="javascript:;">Change Password </a></li></h4>
				
			</ol>
<h1 class="page-header">&nbsp;</small></h1>




<form  method="post">
      <table  width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" class="table" style="margin-left:15px">
        
		        <tr valign="top"> 
          <td valign="top"> <table width="50%" border="0" cellspacing="0" cellpadding="5" >
          <input type="hidden" name="hPin" value="exist">
                    <tr> 
            <td width="213" style="height: 23px"><b><strong>Username</strong></td>
            <td width="387" style="height: 23px">
              <strong>
              <?=$vUser?>
              </strong></td>
          </tr>
          <tr> 
            <td width="213" style="height: 23px"><strong>Old Password</strong></td>
            <td width="387" style="height: 23px"><strong>
              <input name="tfOldPass" type="password" class="form-control"> 
            </strong></td>
          </tr>
          <tr> 
            <td style="height: 24px"><strong>New Password</strong></td>
            <td style="height: 24px"><strong>
              <input name="tfNewPass" type="password" class="form-control"> 
            </strong></td>
          </tr>
          <tr> 
            <td style="height: 21px"><strong>Confirm Password</strong></td>
            <td style="height: 21px"><strong>
              <input name="tfConfirm" type="password" class="form-control">
			<input name="hAction" type="hidden" value="posting">
            </strong></td>
          </tr>
           <tr> 
            <td height="21"><strong>Captcha</strong></td>
            <td>
              <strong>
              <?php 
							require_once '../simage/securimage.php';
							$options = array();
							$options['input_name'] = 'ct_captcha'; // change name of input element for form post

							if (!empty($_SESSION['ctform']['captcha_error'])) {
								// error html to show in captcha output
								$options['error_html'] = $_SESSION['ctform']['captcha_error'];
							}
							echo Securimage::getCaptchaHtml($options);							
                    ?>  
            
             </strong></td>
          </tr>        </table>
				<br><input class="btn btn-success" name="kirim" type="submit" onClick="MM_validateForm('kode_sponsor','','R','nama','','R','no_hp','','R','nm_bank','','R','no_rekening','','R');return document.MM_returnValue" value="Change">&nbsp;<input class="btn btn-default" type="reset" name="reset" value="Reset"></td>
        </tr>
              </table>
</form>
<?php
}
?>
    <!-- main content end-->




<script src="../js/jquery.nicescroll.js"></script>


<!--common scripts for all pages-->
<script src="../js/scripts.js"></script>
</div>
	<!-- end page container -->
	
<? include_once("../framework/member_bottomjs.blade.php")?>	
	<script>
		$(document).ready(function() {
			App.init();
			Dashboard.init();
		});
	</script>

<? include_once("../framework/member_footside.blade.php") ; ?>