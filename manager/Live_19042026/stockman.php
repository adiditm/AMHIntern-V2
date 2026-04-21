<? include_once("../framework/admin_headside.blade.php")?>

				
<div class="right_col" role="main">
		<div><label><h3>Stock Asjustment for Head Office</h3></label></div>


 <?php
     $vUserHO = $oRules->getSettingByField('fuserho');
   $vRefer=$_SERVER['HTTP_REFERER'];
  
   if (preg_match('/aktif.php/i',$vRefer,$vMatches))

      $_SESSION['referer'] = $vRefer."?";

   else $_SESSION['referer'] = "http://".$_SERVER['HTTP_HOST'].$vRootWeb."manager/stockman.php?";

      

   $vUser=$_SESSION['LoginUser'];

   $vSpy = md5('spy').md5($_GET['uMemberId']);

   if ($_GET['op']==$vSpy)

      $vUserChoosed=$_GET['uMemberId'];
    $vUserChoosed=$vUserHO;


 

  



 $vAction=$_POST['hAction'];

 $vNama=$_POST['nama'];

 $vID=$_POST['ID'];

 $vNom=$_POST['tfNom'];

 $vKorek=$_POST['tfKorek'];

 

 $vProduct=$_POST['lmProduct'];

 $vSize=$_POST['lmSize']; 

 $vColor=$_POST['lmColor']; 



 $vTgl=$_POST['dc'];

 $vKet=$_POST['taKet'];

 $vRekFrom=$_POST['tfRekFrom'];

 $vRekTo=$_POST['lmRekTo'];

 $vSync=$_POST['cbSync'];

 if ($vSync!='0')  $vSync='1';

// $vInvest=$oMember->checkInvest($vUser);

  

 

// $vFrom=$oRules->getMailFrom();



  $vSaldo=$_POST['tfNom'];





 

 if ($vAction=="fPost") {

   if ($vKorek>=0 && $vKorek != $vSaldo) {

		$vNom=$vSaldo - $vKorek;

		$vDesc="Stock Adjusment - $vKet";

		

		if ($vNom < 0) {//kredit



		   

		                              //$pID,$pProduct,$pSize,$pColor,$pTanggal,$pDesc,$pCred,$pDeb,$pBal,$pKind,$pRef=''

		   $oProduct->insertMutasiStock($vUserChoosed,$vProduct,$vSize,$vColor,date("Y-m-d H:i:s"),$vDesc,abs($vNom),0,$vKorek,'adjust') ;

		} else if ($vNom > 0)   {

          



		   $oProduct->insertMutasiStock($vUserChoosed,$vProduct,$vSize,$vColor,date("Y-m-d H:i:s"),$vDesc,0,abs($vNom),$vKorek,'adjust') ;

		}

		//$pId,$pProd,$pSize,$pColor,$pNom

		$oMember->setSaldoStockWH($vUserChoosed,$vProduct,$vKorek,$db);

		

		$oSystem->jsAlert("Koreksi dari ".number_format($vSaldo,0,",",".")." menjadi ".number_format($vKorek,0,",",".")." sukses!");

		$oSystem->jsLocation($_SESSION['referer'].'&fallback='.$vUserChoosed.'#'.$vUserChoosed);

		$_SESSION['referer']='';

	 } else { // Serial Harus diisi

		 $oSystem->jsAlert("Isikan koreksi stock dengan benar!");

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


    <!-- main content start-->

    <div class="main-content" >




        <!-- page start-->

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

      $('#caption').html('Stock Management');



   $('#dc').datepicker({

                    format: "yyyy-mm-dd",

                    autoclose : true

    });  

    

  

});	



function checkStock() {

  // var vMember = $('#hID').val();

   var vProd =  $('#lmProduct').val();

   var vSize =  $('#lmSize').val();

   var vColor =  $('#lmColor').val();

   var vURL ='../main/mpurpose_ajax.php?op=checkstockho&prod='+vProd+'&wh=headoffice';;

   

  $.get(vURL, function(data) {

     if (data.trim() != 'Not Found') { 

        $('#tfNom').val(data.trim());

        $('#btKoreksi').prop('disabled', false);

     } else {

        $('#tfNom').val(data.trim());

        $('#btKoreksi').prop('disabled', true);



     }



   });   

 



}

</script>

 



  <tr valign="top"> 

    <td align="center" valign="top">

   

        <h4 style="color:blue">Choose Product then Check Stock</h4>

            <form name="frmInvest" method="post" action="" onsubmit="return saveKorek()">

            <input type="hidden" name="hID" id="hID" value="<?=$vUserChoosed?>">

            <input type="hidden" name="hAction" id="hAction" value="fPost">



              <table width="75%" border="0"  cellpadding="4" cellspacing="0" align="center" style="margin-left:40px">

              

                <tr style="display:none">

                  <td align="left" style="height: 34px">Tanggal Adjustment</td>

                  <td style="height: 34px">

                    <div align="left">

                      <input style="max-width:100px" class="form-control"  name="dc" id="dc" value="<?=date("Y-m-d")?>" size="12"  />

                  </div></td>

                </tr>

                <tr>

                  <td align="left" style="height: 34px">Product</td>

                  <td style="height: 34px">

                    <div align="left">

<select name="lmProduct" id="lmProduct" class="form-control">

                <option selected="selected" value="">--Choose--</option>

                <? 

                   $vSQL="select distinct fidproduk from m_product  order by fidproduk";

                   $dbin->query($vSQL);

                   while ($dbin->next_record()) {

                       $vIdProd=$dbin->f('fidproduk');

                       $vNamaProd=$oProduct->getProductName($vIdProd);

                                       ?>

                <option value="<?=$vIdProd?>" <? if ($vProd==$vIdProd) echo "selected";?>><?=$vIdProd.';'.$vNamaProd;?></option>

                <? } ?>

              </select>





                  </div></td>

                </tr>



                <tr class="hide">

                  <td align="left" style="height: 34px">Size</td>

                  <td style="height: 34px">

                    <div align="left">

<select name="lmSize" id="lmSize" class="form-control">

                <option selected="selected" value="">--Choose--</option>

                <? 

                   $vSQL="select distinct fsize from m_size  order by fsize ";

                   $dbin->query($vSQL);

                   while ($dbin->next_record()) {

                       $vSizeX=$dbin->f('fsize');

                      // $vNamaProd=$oProduct->getProductName($vIdProd);

                                      ?>

                <option value="<?=$vSizeX?>" ><?=$vSizeX?></option>

                <? } ?>

              </select>





                  </div></td>

                </tr>



                <tr class="hide">

                  <td align="left" style="height: 34px">Color</td>

                  <td style="height: 34px">

                    <div align="left">

<select name="lmColor" id="lmColor" class="form-control">

                <option selected="selected" value="">--Choose--</option>

                <? 

                   $vSQL="select distinct fidcolor from m_color  order by fidcolor";

                   $dbin->query($vSQL);

                   while ($dbin->next_record()) {

                       $vIdColor=$dbin->f('fidcolor');

                       $vNamaColor=$oProduct->getColor($vIdColor);

                                      ?>

                <option value="<?=$vIdColor?>"><?=$vIdColor.';'.$vNamaColor;?></option>

                <? } ?>

              </select>





                  </div></td>

                </tr>



                               <tr> 

                  <td align="left">Stock Balance  </td>

                  <td> <div align="left">                    <input class="form-control" name="tfNom" type="text" id="tfNom" dir="rtl" value="<? //number_format($vSaldo,0,"","")?>" size="15" readonly > 

                  </div></td>

                </tr>

                             

                               <tr> 

                  <td align="left">&nbsp; </td>

                  <td> <br><input type="button" class="btn btn-primary" name="btcheck" value="Check Stock" onclick="checkStock()" ><br><br></td>

                </tr>

                             

                <tr>

                  <td style="height: 12px" align="left">Correction </td>

                  <td style="height: 12px"><div align="left">

                    <input class="form-control" name="tfKorek" type="text" id="tfKorek" dir="rtl" value="0" size="15"> 

                  <span style="color:blue">masukkan jumlah stock akhir yg benar 

					  dari produk yg bersangkutan sebagai koreksi</span></div></td>

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

                    <input type="submit" class="btn btn-primary" name="kirim" id="btKoreksi" value="Koreksi" disabled="disabled"> 

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

	


<? include_once("../framework/admin_footside.blade.php") ; ?>