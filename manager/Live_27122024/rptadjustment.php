<? include_once("../framework/masterheader.php")?>



<?php



$vAwal=$_POST['dc'];

$vAkhir=$_POST['dc1'];



if ($vAwal=="")

	$vAwal=$_GET['uAwal'];

if ($vAkhir=="")

	$vAkhir=$_GET['uAkhir'];





if ($vAwal=="")

   $vAwal=date('Y-m-d', strtotime('-30 days'));

   

if ($vAkhir=="")

   $vAkhir=$oPhpdate->getNowYMD("-");



   

$vPrevWeek=$oMydate->getPrevWeek($vTanggal);

$vWeek=$oMydate->getWeek($vTanggal);

$vYear=$oMydate->getYear($vTanggal);   

if ($vWeek==52)

    $vPrevYear=$vYear-1;

else

     $vPrevYear= $vYear;	

$oMydate->setCritPrevDate("ftglkomisi",$vTanggal);	 



$vPage=$_GET['uPage'];

$vBatasBaris=25;

if ($vPage=="")

 	$vPage=0;

$vStartLimit=$vPage * $vBatasBaris;	



$vCrit.=" and date(ftanggal) >= '$vAwal' and date(ftanggal) <= '$vAkhir'" ;







			 $vsql="select  * from tb_mutasi_stok where fkind='adjust'  "; 

			 $vsql.=$vCrit;

			  $vsql.=" order by ftanggal ";




$db->query($vsql);
$vArrData="";
$vArrHead=array('No.','Date','Username','Product Code','Product Name','Ajust From/To','Adjustment Amount');
$vArrBlank=array('','','','','','','');
$vArrDateFilter=array('Date Filter : ',$vAwal." - ".$vAkhir,'','');

$i=0;
$vArrData[]=$vArrDateFilter;
$vArrData[]=$vArrBlank;
$vArrData[]=$vArrHead;

while ($db->next_record()) { //Convert Excel
     $i++;
	 
				 $vTanggal=substr($db->f('ftanggal'),0,10);
				 $vDistID=$db->f('fidmember');
				 $vNama=$oMember->getMemberName($vDistID);
				 $vIdProduk=$db->f('fidproduk');
				 $vNamaProd=$oProduct->getProductName($vIdProduk);
				 $vIDColor=$db->f('fcolor');
				 $vColor=$oProduct->getColor($vIDColor);
				 $vSize=$db->f('fsize');

				 $vCredit=$db->f('fcredit');    
				 $vDebit=$db->f('fdebit');    
				 $vLastbal=$db->f('fbalance');    	 
				 if ($vCredit == 0) {
				    $vFrom=$vDebit + $vLastbal;
				    $vTo=$vLastbal;
				    $vAmount = -$vDebit;
				 } else {
				    $vFrom= $vLastbal- $vCredit;
				    $vTo=$vLastbal;
				    $vAmount = $vCredit;
				 }
//	$vArrHead=array('No.','Date','Username','Product Code','Product Name','Ajust From/To','Adjustment Amount'); 
	$vArrData[]=array($i,$vTanggal,$vDistID,$vNama,$vIdProduk,$vNamaProd,$vFrom."/".$vTo,$vAmount);
	//$vArrMem['fpassword'][$i]=$oSystem->doED('decrypt',$db->f('fpassword'));

}
//$vArrTot=array('','','','','','Total',$vTot);
//$vArrData[]=$vArrTot;

$_SESSION['adjust']=$vArrData;


			//$vsql.="limit $vStartLimit ,$vBatasBaris ";

 $db->query($vsql);

 $db->next_record();

 $vRecordCount=$db->num_rows();

 $vPageCount=ceil($vRecordCount/$vBatasBaris);



?>







<script language="JavaScript" type="text/JavaScript">





$(document).ready(function(){

    $('#caption').html('Report Stock Adjustment Summary');





      $('#dc').datepicker({

                    format: "yyyy-mm-dd",

                    autoclose : true

    }).on('changeDate', function (ev) {
    $(this).datepicker('hide');
    });  

  

  

       $('#dc1').datepicker({

                    format: "yyyy-mm-dd",

                    autoclose : true

    }).on('changeDate', function (ev) {
    $(this).datepicker('hide');
    });  



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

	<link rel="stylesheet" href="../css/screen.css">



	

	

 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />





<section>

    <!-- left side start-->

   <? include "../framework/leftadmin.php"; ?>

    <!-- main content start-->

    <div class="main-content" >



   <? include "../framework/headeradmin.php"; ?>

           <!--body wrapper start-->

 <section class="wrapper">

        <!-- page start-->



<form action="" method="post" name="demoform">



          <div style="display:inline" align="left">

          <strong>Date From : </strong>

          <input style="width:100px;display:inline" class="form-control" name="dc" id="dc" size="11" value="<?=$vAwal?>">&nbsp; <strong>

			  to</strong>

          <input style="width:100px;display:inline" class="form-control" name="dc1" id="dc1" size="11" value="<?=$vAkhir?>"> &nbsp;&nbsp;

          <input style="display:inline" name="Submit22" type="submit" class="btn btn-success" value="Refresh">

          

          </div>

          <br /><br />

<br />





    <div class="table-responsive">

        <table width="90%" border="0" class="table table-striped">

          <tr >

            <td width="4%" style="height: 24px; width: 5%;"><strong>No.</strong></td>

            <td style="height: 24px; width: 8%;" align="center"><strong>Date</strong></td>

            <td width="12%" style="height: 24px"><strong>Username/Name</strong></td>

            <td width="12%" style="height: 24px"><div align="center"><strong>
				Code/Product Name</strong></div></td>

            <td align="center" style="height: 24px; width: 8%;" class="hide"><strong>Size </strong></td>

            <td align="center" style="width: 9%; height: 24px;" class="hide"><strong>Color</strong></td>

            <td align="center" style="height: 24px; width: 4%;"><strong>&nbsp;Adjust 

			From / To</strong></td>

            <td align="center" style="height: 24px; width: 4%;"><strong>Adjustment Amount</strong></td>

          </tr>

          <? 

             $vNo=0;

			 $vsql="select  * from tb_mutasi_stok where fkind='adjust'  "; 

			 $vsql.=$vCrit;

			  $vsql.=" order by ftanggal ";

			$vsql.="limit $vStartLimit ,$vBatasBaris ";

		     $db->query($vsql);

			 //$vTotJualL=0;$vTotalJualR=0;

			 while ($db->next_record()) {

			 $vNo++;

				 $vTanggal=substr($db->f('ftanggal'),0,10);

				 $vDistID=$db->f('fidmember');

				 $vNama=$oMember->getMemberName($vDistID);

				 $vIdProduk=$db->f('fidproduk');

				 $vNamaProd=$oProduct->getProductName($vIdProduk);

				 $vIDColor=$db->f('fcolor');

				 $vColor=$oProduct->getColor($vIDColor);

				 $vSize=$db->f('fsize');



				 $vCredit=$db->f('fcredit');    

				 $vDebit=$db->f('fdebit');    

				 $vLastbal=$db->f('fbalance');    

				 

				 if ($vCredit == 0) {

				    $vFrom=$vDebit + $vLastbal;

				    $vTo=$vLastbal;

				    $vAmount = -$vDebit;

				 } else {

				    $vFrom= $vLastbal- $vCredit;

				    $vTo=$vLastbal;

				    $vAmount = $vCredit;

				 }

		  ?>

          <tr>

            <td style="width: 5%; height: 24px;" ><?=$vNo+$vStartLimit?></td>

            <td style="height: 24px; width: 8%;" align="center"><?=$vTanggal?></td>

            <td style="height: 24px" ><?=$vDistID."/".$vNama?></td>

            <td style="height: 24px" ><?=$vIdProduk."/".$vNamaProd?></td>

            <td style="height: 24px; width: 8%;" align="center" class="hide"><?=$vSize?></td>

            <td style="width: 9%; height: 24px;" class="hide"><?=$vColor?></td>

            <td style="width: 4%; height: 24px;" ><div align="right">

            <?=number_format($vFrom,0,",",".")."/".number_format($vTo,0,",",".")?></div></td>

            <td style="width: 4%; height: 24px;" align="right"><?=number_format($vAmount,0,",",".")?></td>

          </tr>

           <? } ?>

          </table>    

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

          <a href="rptssumstockout.php?uPage=<?=$i?>&amp;uAwal=<?=$oPhpdate->DMY2YMD($oPhpdate->YMD2DMY($vAwal,"-"),"-")?>&amp;uAkhir=<?=$oPhpdate->DMY2YMD($oPhpdate->YMD2DMY($vAkhir,"-"),"-")?>" >

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
<button class="btn btn-info btn-sm" onClick="document.location.href='../manager/getexcel.php?arr=adjust&file=report_adjustment_stock'"><i class="fa fa-file-text-o"></i> Export Excel</button>
      <!-- page end-->

        </section>

        <!--body wrapper end-->



        <!--footer section start-->

        <? include "../framework/footer.php";?>

        <!--footer section end-->





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







</body>

</html>

