<? include_once("../framework/admin_headside.blade.php")?>

<?php

$vAwal=$_POST['dc'];
$vAkhir=$_POST['dc1'];
$vSortPost=$_POST['lmSort'];
$vSpy = md5('spy').md5($_GET['uMemberId']);

 if ($_GET['uMemberId'] != '')
    $vUserActive=$_GET['uMemberId'];
 else  $vUserActive=$vUser;

if ($vAwal=="")
	$vAwal=$_GET['uAwal'];
if ($vAkhir=="")
	$vAkhir=$_GET['uAkhir'];


if ($vAwal=="")
   $vAwal=date('Y-m-d', strtotime('-30 days'));
   
if ($vAkhir=="")
   $vAkhir=$oPhpdate->getNowYMD("-");

  

?>



<script language="JavaScript" type="text/JavaScript">


$(document).ready(function(){
    $('#caption').html('Ranking Produk (Nominal)');


      $('#dc').datepicker({
                    format: "yyyy-mm-dd",
                    autoclose : true
    }).on('changeDate', function (ev) {
    $(this).datepicker('hide');
    });  
; 
  
  
       $('#dc1').datepicker({
                    format: "yyyy-mm-dd",
                    autoclose : true
    }).on('changeDate', function (ev) {
    $(this).datepicker('hide');
    });  
; 

});


function doBayar(pKode,pKomisi,pSisa,pBatas) {
   pSisa=parseInt(pSisa);
   pBatas=parseInt(pBatas);

    if (pSisa<pBatas) {
	   alert('Komisi tidak bisa dibayarkan karena sisa komisi kurang dari batas minimum transfer!');
	   return false;
	}
	window.location='admin.php?menu=buktitfr&uKd='+pKode+'&uKom='+pKomisi;
}


function doBayarBuy(pKode,pKomisi,pSisa,pBatas) {
   pSisa=parseInt(pSisa);
   pBatas=parseInt(pBatas);

    if (pSisa<pBatas) {
	   alert('Komisi tidak bisa dibayarkan karena sisa komisi kurang dari batas minimum transfer!');
	   return false;
	}
	window.location='admin.php?menu=buktitfrsell&uKd='+pKode+'&uKom='+pKomisi;
}//-->
</script>
<!--	<link rel="stylesheet" href="../css/screen.css">-->

	
	
 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />


<div class="content-wrapper">

       <section class="content">

<form action="" method="post" name="demoform">
<br>
    <div class="row">
    <div class="col-lg-5">

          <strong>Date : </strong>
          <input style="width:165px;display:inline" class="form-control" name="dc" id="dc" size="11" value="<?=$vAwal?>">&nbsp; <strong>
			  to</strong>
          <input style="width:165px;display:inline" class="form-control" name="dc1" id="dc1" size="11" value="<?=$vAkhir?>"> &nbsp;&nbsp;
          
          
          </div>
</div>




 <br>
 <div class="row">
 <div class="col-lg-5">
 <input style="display:inline" name="Submit22" type="submit" class="btn btn-success" value="Refresh">
 </div>
 </div>


     

          <br /><br />
<br />


    <div class="table-responsive">
     
        <table width="75%" border="0" class="table table-striped">
          <tr >
            <td width="8%" style="height: 24px; width: 5%;"><strong>No.</strong></td>
            <td width="20%" style="height: 24px"><div align="left"><strong>ID Produk</strong></div></td>
            <td width="29%" style="height: 24px"><div align="left"><strong>Nama Produk</strong></div></td>
            <td width="19%" align="center" style="height: 24px"><div align="right"><strong> Penjualan (Rp)</strong></div></td>
            </tr>
          <? 
             $vNo=0;

			 
			 $vsql="select a.fidproduk, sum(a.fsubtotal) as fsub from tb_penjualan a where date(a.ftanggal) between '$vAwal' and '$vAkhir' group by a.fidproduk order by sum(a.fsubtotal) desc  "; 
		     $db->query($vsql);
			 $vTotJual=0;
			 while ($db->next_record()) {
			     $vNo++;
				 $vIdProd=$db->f('fidproduk'); 
				 $vSubtot=$db->f('fsub');


		  ?>
          <tr>
            <td style="width: 5%" ><?=$vNo?></td>
            <td nowrap><?=$vIdProd?></td>
            <td nowrap><?=$oProduct->getProductName($vIdProd)?>
              <div align="right"></div></td>
            <td ><div align="right"> <?=number_format($vSubtot,0,",",".")?></div></td>
            </tr>
           <? } ?>
          </table>  
          <br>

<b>Produk yang belum pernah ada transaksi : </b>
        
<br> 
<ul>          
<?
   $vSQL="select * from m_product where fidproduk not in (select fidproduk from tb_penjualan where date(ftanggal) between '$vAwal' and '$vAkhir')";
   $db->query($vSQL);
   while ($db->next_record()) {

?>          
          
<li><? echo $db->f('fidproduk')?> / <?=$oProduct->getProductName($db->f('fidproduk'))?></li>          
          
<? } ?>
</ul>
            
        </div>  
            
     <table width="90%">
     <tr>
      <td align="center">
        
        <p>
          <?
   for ($i=0;$i<$vPageCount;$i++) {
     $vOffset=$i*$vBatasBaris;
     if ($i!=$vPage) {
?>
          <a href="../memstock/historyro.php?uPage=<?=$i?>&uAwal=<?=$oPhpdate->DMY2YMD($oPhpdate->YMD2DMY($vAwal,"-"),"-")?>&uAkhir=<?=$oPhpdate->DMY2YMD($oPhpdate->YMD2DMY($vAkhir,"-"),"-")?>" >
          <?=$i+1?>
          </a>
          <?
  } else {
?>
          <?=$i+1?>
          <? } ?>
          <?  } //while?>
<br>
        </p></td>
    </tr>
    <tr> 
      <td height="5" align="center" valign="middle"> <div align="right"></div>
        <hr> </td>
    </tr>
    <tr> 
      <td height="49" align="center" valign="middle"> <p><br>
        </p>
      <p>&nbsp;        </p></td>
    </tr>
    <?php
   
  if ($baris==$Akhiran)
  {
  ?>
    <?php
  }
  ?>
  </table>
  
</form>


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


       </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->





<?
 include('../framework/admin_footside.blade.php');
?>

