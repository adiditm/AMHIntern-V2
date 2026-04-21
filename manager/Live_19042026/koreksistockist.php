<? 

		if ($_GET['uMemberId'] != '') 
           include_once("../framework/admin_headside.blade.php");
        else
           include_once("../framework/member_headside.blade.php") ;  


  $vRefer=$_SERVER['HTTP_REFERER'];

   if (preg_match('/aktif.php/i',$vRefer,$vMatches))

      $_SESSION['referer'] = $vRefer.'&';

     

   $vUser=$_SESSION['LoginUser'];



   $vSpy = md5('spy').md5($_GET['uMemberId']);

   if ($_GET['op']==$vSpy)

     $vUserChoosed=$_GET['uMemberId'];

   if ($oMember->getMemField('fstockist',$vUserChoosed) == '0') {
	   $oSystem->jsAlert("Member $vUserChoosed bukan stockist atau mobile stockist!");
	   $oSystem->jsLocation($_SERVER['HTTP_REFERER']);
   }

 

  

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

  

 

// $vFrom=$oRules->getMailFrom();



  $vSaldo=$oMember->getMemField('fsaldoro',$vUserChoosed);





 

 if ($vAction=="fPost") {

   if ($vKorek>=0 && $vKorek != $vSaldo) {

		$vNom=$vSaldo - $vKorek;

		$vDesc="Stockist Balance Set - $vKet";

		

		if ($vNom < 0) {//kredit



		   

		   

		   $oKomisi->insertMutasiSt($vUserChoosed,$vUser,date("Y-m-d H:i:s"),$vDesc,abs($vNom),0,$vKorek,'setbal') ;

		} else if ($vNom > 0)   {

          



		   $oKomisi->insertMutasiSt($vUserChoosed,$vUser,date("Y-m-d H:i:s"),$vDesc,0,abs($vNom),$vKorek,'setbal') ;

		}

		

		$oMember->setSaldoRO($vUserChoosed, $vKorek);

		$vSessRef=$_SESSION['referer'];

		$vSessRef=str_replace(".php",".php?",$vSessRef);

		$oSystem->jsAlert("Set balance dari ".number_format($vSaldo,0,",",".")." menjadi ".number_format($vKorek,0,",",".")." sukses!");

		$oSystem->jsLocation($vSessRef.'&fallback='.$vUserChoosed.'#'.$vUserChoosed);

		$_SESSION['referer']='';

	 } else { // Serial Harus diisi

		 $oSystem->jsAlert("Isikan set balance dengan benar!");

	 }

 

}	//Post





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

</style>

 
		<div id="content" class="content">
			<ol class="breadcrumb pull-right">
				<h4><li><a href="javascript:;">&nbsp;</a></li></h4>
				
			</ol>
<h1 class="page-header">Set Saldo Stockist <?=$vUserChoosed?></small></h1>


<table  width="100%"  border="0" cellpadding="0" cellspacing="0">

<script language="javascript">

function saveKorek() {

	var vNom=document.getElementById('tfNom').value;

	var vJadi=document.getElementById('tfKorek').value;



	   

	if (confirm('Yakin koreksi saldo <?=$vUserChoosed?> dari '+vNom+' menjadi '+vJadi+'?')==true) {

		document.frmInvest.submit();

	} else return false;

}





$(document).ready(function(){

      $('#caption').html('Cash Balance Correction');



   $('#dc').datepicker({

                    format: "yyyy-mm-dd",

                    autoclose : true

    });  

    

  

});	



</script>

 



  <tr valign="top"> 

    <td align="center" valign="top">

   


      <form name="frmInvest" method="post" action="" onsubmit="return saveKorek()">
      <table width="75%" border="0"  cellpadding="4" cellspacing="0" align="center" style="margin-left:40px">

        <tr>

                  <td align="left" style="height: 34px">Tanggal Koreksi</td>

                  <td style="height: 34px">

                    <div align="left">

                      <input style="max-width:100px" class="form-control"  name="dc" id="dc" value="<?=date("Y-m-d")?>" size="12"  />

                  </div></td>

                </tr>

                <tr> 

                  <td width="129" height="30" align="left">Nama</td>

                  <td width="335"> <div align="left">

                    <input class="form-control" name="nama" type="text" value="<?=$oMember->getMemberName($vUserChoosed)?>" readonly="true">

                    <input name="hAction" type="hidden" id="hAction" value="fPost"> 

                  </div></td>

                </tr>

                <tr>

                  <td align="left">ID</td>

                  <td><div align="left">

                    <input class="form-control" name="ID" type="text" id="ID" value="<?=$vUserChoosed?>" readonly="true" />

                  </div></td>

                </tr>

                <tr> 

                  <td align="left">Jumlah Saldo  </td>

                  <td> <div align="left">                    <input class="form-control" name="tfNom" type="text" id="tfNom" dir="rtl" value="<?=number_format($vSaldo,0,"","")?>" size="15" readonly > 

                  </div></td>

                </tr>

                             

                <tr>

                  <td style="height: 12px" align="left">Koreksi </td>

                  <td style="height: 12px"><div align="left">

                    <input class="form-control" name="tfKorek" type="text" id="tfKorek" dir="rtl" value="0" size="15"> 

                  <span style="color:blue">masukkan jumlah saldo akhir yg benar sebagai koreksi</span></div></td>

                </tr>

                <tr>

                  <td align="left" valign="top">Keterangan</td>

                  <td><div align="left">

                    <textarea class="form-control" name="taKet" id="taKet" cols="35" rows="4"></textarea>

                  </div></td>

                </tr>

                

                <tr style="display:none">

                  <td height="37" align="left">Sinkron ke Easy Travel</td>

                  <td><input name="cbSync" type="checkbox" id="cbSync" value="0" checked="checked" /></td>

                </tr>

                <tr> 

                  <td height="37">&nbsp;</td>

                  <td> <div align="left">

                    <input type="submit" class="btn btn-primary" name="kirim" value="Koreksi" > 

                    <input 



type="reset" name="reset" value="Reset" class="btn btn-default"> 

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

	 



<!-- Placed js at the end of the document so the pages load faster -->



<script src="../js/jquery-ui-1.9.2.custom.min.js"></script>

<script src="../js/jquery-migrate-1.2.1.min.js"></script>



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

<script src="../js/pickers-init.js"></script>

<script src="../js/scripts.js"></script>


</div>

	
<? include_once("../framework/member_bottomjs.blade.php")?>	
	<script>
		$(document).ready(function() {
			App.init();
			Dashboard.init();
		});
	</script>

<? include_once("../framework/member_footside.blade.php") ; ?>