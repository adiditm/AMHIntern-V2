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

$vCrit.=" and date(ftgldist) >= '$vAwal' and date(ftgldist) <= '$vAkhir' and (fstatus = '2' or fstatus='3')" ;



 $vsql="select distinct ftgldist,fserno,fstatus,fpendistribusi  from tb_skit where 1 "; 
 $vsql.=$vCrit;
 $vsql.=" order by fidsys, ftgldist ";
 $db->query($vsql);
 $db->next_record();
 $vRecordCount=$db->num_rows();
 $vPageCount=ceil($vRecordCount/$vBatasBaris);

?>



<script language="JavaScript" type="text/JavaScript">


$(document).ready(function(){
    $('#caption').html('Report Summary KIT Keluar');


      $('#dc').datepicker({
                    format: "yyyy-mm-dd",
                    autoclose : true
    }); 
  
  
       $('#dc1').datepicker({
                    format: "yyyy-mm-dd",
                    autoclose : true
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
	
<head>
	<link rel="stylesheet" href="../css/screen.css">

	
	
 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />


<style type="text/css">
.auto-style1 {
	font-weight: bold;
}
</style>
</head>


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
          <strong>Mulai Tanggal : </strong>
          <input style="width:100px;display:inline" class="form-control" name="dc" id="dc" size="11" value="<?=$vAwal?>">&nbsp; <strong>s/d</strong>
          <input style="width:100px;display:inline" class="form-control" name="dc1" id="dc1" size="11" value="<?=$vAkhir?>"> &nbsp;&nbsp;
          <input style="display:inline" name="Submit22" type="submit" class="btn btn-primary" value="Refresh">
          
          </div>
          <br /><br />
<br />


    <div class="table-responsive">
        <table width="90%" border="0" class="table table-striped" style="width:70%">
          <tr >
            <td style="height: 24px; width: 14%;" class="auto-style1"></td>
            <td width="12%" style="height: 24px" align="center"><b>Out to Agent</b></td>
            <td width="12%" style="height: 24px" align="center"><b>Terpakai</b></td>
          </tr>
          <tr >
            <td style="height: 24px; width: 14%;" class="auto-style1"><strong>
			Economy.</strong></td>
            <td width="12%" style="height: 24px" align="center">
            <?
                $vSQL="select count(fserno) as fcount from tb_skit where fstatus='2' or fstatus='3' and fserno like 'UEC%'";
                $db->query($vSQL);
                $db->next_record();
                echo number_format($db->f('fcount'),0,",",".");
            
            ?>
            </td>
            <td width="12%" style="height: 24px" align="center">
            <?
                $vSQL="select count(fidmember) as fcount from m_anggota where fidmember like 'UEC%'";
                $db->query($vSQL);
                $db->next_record();
                echo number_format($db->f('fcount'),0,",",".");
            
            ?>

            </td>
          </tr>
                   <tr >
            <td style="height: 24px; width: 14%;"><b>Business</b></td>
            <td width="12%" style="height: 24px" align="center">
            <?
                $vSQL="select count(fserno) as fcount from tb_skit where fstatus='2' or fstatus='3' and fserno like 'UBC%'";
                $db->query($vSQL);
                $db->next_record();
                echo number_format($db->f('fcount'),0,",",".");
            
            ?>

            </td>
            <td width="12%" style="height: 24px" align="center">
                        <?
                $vSQL="select count(fidmember) as fcount from m_anggota where fidmember like 'UBC%'";
                $db->query($vSQL);
                $db->next_record();
                echo number_format($db->f('fcount'),0,",",".");
            
            ?>

            </td>
          </tr>
          <tr >
            <td style="height: 24px; width: 14%;"><b>First Class</b></td>
            <td width="12%" style="height: 24px" align="center">
            <?
                $vSQL="select count(fserno) as fcount from tb_skit where fstatus='2' or fstatus='3' and fserno like 'UFC%'";
                $db->query($vSQL);
                $db->next_record();
                echo number_format($db->f('fcount'),0,",",".");
            
            ?>

            </td>
            <td width="12%" style="height: 24px" align="center">
            <?
                $vSQL="select count(fidmember) as fcount from m_anggota where fidmember like 'UFC%'";
                $db->query($vSQL);
                $db->next_record();
                echo number_format($db->f('fcount'),0,",",".");
            
            ?>
            
            </td>
          </tr>
          </table>    
     </div>  
            
</form>
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
