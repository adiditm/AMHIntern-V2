<? include_once("../framework/admin_headside.blade.php")?>


<?php

define("MENU_ID", "royal_pass_admin");

$vPinOK=0;

$vPostPin=$_POST['hPin'];



$vNewPass=$_POST['tfNewPass'];

$vOldPostPass=$_POST['tfOldPass'];

$vConfirm=$_POST['tfConfirm'];

$vPin=$_POST['tfPin'];



  if ($vPin!="") {

	if ($oSystem->authAdminPin($vUser,$vPin)==1)

	   $vPinOK=1;

	else {   

	   $vPinOK=0;

	   $oSystem->jsAlert('Pin salah, mohon ulangi lagi!');

	}

  } 

  if ($vPostPin=="exist")

      $vPinOK=1;

  

if (strlen($vNewPass)>0 && strlen($vOldPostPass) > 0) {

	 $vOldPass=$oSystem->getAdminPass($vUser);

	if ($vOldPass==md5($vOldPostPass))

	   $oSystem->setAdminPassConfirm($vUser,$vNewPass,$vConfirm);

	else

	   $oSystem->jsAlert("Password lama salah, penggantian gagal!");   

	

	

} else {

  if ($_POST['hAction']=="posting")

  $oSystem->jsAlert("Anda tidak melakukan perubahan password!");

}	  



?>     

<script language="javascript">

$(document).ready(function(){

      $('#caption').html('Change Admin Password');



  

});	







</script>
				
<div class="right_col" role="main">
		<div><label><h3>Change Password</h3></label></div>
        

<form action="" method="post">

<? if ($vPinOK==0)  {?>

<table width="100%"  border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableRow"  align="left">

  <tr> 

      <td height="49" align="left" valign="middle"> <p><strong><font size="4">

          

          Masukkan P I N Number</font><br>

          </strong></p></td>

  </tr>

  <tr> 

    <td height="5" align="center" valign="middle"> 

      <hr>

      </td>

  </tr>   

  <tr> 

      <td height="49" align="left" valign="middle" > 

        <table width="50%" class="" align="left" style="margin-left:1%">

          <tr align="left"> 

            <td colspan="2"></td>

          </tr>

          <tr> 

            <td width="32%"><div align="left">P I N</div></td>

            <td width="68%"><input name="tfPin" type="password" id="tfPin" class="form-control"></td>

          </tr>         

          <tr > 

            <td align="left" colspan="2">

              <input type="submit" name="Submit" value="Submit" class="btn btn-primary"></td></tr>

        </table>

		

      </td>

  </tr>   

</table>

<? } ?>

</form>

<?

$db->query("select * from m_admin where fidmember='".$vUser."'");

if ($db->next_record() && $vPinOK==1)

{



?>



<form  method="post">

      

  <table  width="100%" border="0" cellpadding="0" cellspacing="0" class="contentfont">

    <tr> 

      <td height="1" align="left" valign="middle"> <p><strong><font size="4"> 

          Ubah Password Admin</font><br>

          </strong></p></td>

    </tr>

    <tr valign="top"> 

      <td height="12" valign="top"> <hr></td>

    </tr>

    <tr valign="top"> 

      <td valign="top"> <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="margin-left:1%">

          <tr> 

            <td height="35" colspan="2"> <strong>

              <input type="hidden" name="hPin" value="exist">

              </strong></td>

          </tr>

          <tr> 

            <td width="121" height="23"><div align="left">ID</div></td>

            <td width="620"> 

              <div align="left">

                <?=$vUser?>            

              </div></td>

          </tr>

          <tr> 

            <td width="121" height="23"><div align="left">Password Lama</div></td>

            <td width="620"><div align="left">

             <div class="col-md-6">

              <input name="tfOldPass" type="password" class="form-control"> 

              </div>

            </div></td>

          </tr>

          <tr> 

            <td height="24"><div align="left">Password Baru</div></td>

            <td><div align="left">

             <div class="col-md-6">

              <input name="tfNewPass" type="password" class="form-control"> 

              </div>

            </div></td>

          </tr>

          <tr> 

            <td height="21"><div align="left">Ulangi Password Baru</div></td>

            <td><div align="left">

             <div class="col-md-6">

              <input name="tfConfirm" type="password" class="form-control"> 

              </div>

              <input name="hAction" type="hidden" value="posting">            

            </div></td>

          </tr>

        </table></td>

    </tr>

    <tr valign="top"> 

      <td height="21" valign="top"><br> 
      <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">

          <tr> 

            <td width="57"><input  class="btn btn-primary" name="kirim" type="submit" onClick="MM_validateForm('kode_sponsor','','R','nama','','R','no_hp','','R','nm_bank','','R','no_rekening','','R');return document.MM_returnValue" value="Simpan">
            &nbsp;<input class="btn btn-default" type="reset" name="reset" value="Reset">
            </td>

            <td width="121"></td>

          </tr>

        </table></td>

    </tr>

  </table>

</form>

<?php

}

?>





<!-- Placed js at the end of the document so the pages load faster -->



<script src="../js/jquery-ui-1.9.2.custom.min.js"></script>

<script src="../js/jquery-migrate-1.2.1.min.js"></script>



<script src="../js/modernizr.min.js"></script>

<script src="../js/jquery.nicescroll.js"></script>



<!--Sparkline Chart-->

<script src="../js/sparkline/jquery.sparkline.js"></script>

<script src="../js/sparkline/sparkline-init.js"></script>



<!--common scripts for all pages-->

<script src="../js/scripts.js"></script>

	</div>
	<!-- end page container -->


<? include_once("../framework/admin_footside.blade.php") ; ?>