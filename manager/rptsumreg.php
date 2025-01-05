<? include_once("../framework/admin_headside.blade.php")?>




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







 $vsql="select * from (select distinct ftgldist,fserno,fstatus,fpendistribusi  from tb_skit where 1 "; 

 $vsql.=$vCrit;

 $vsql.=") as xxx order by  ftgldist ";

 $db->query($vsql);

 $db->next_record();

 $vRecordCount=$db->num_rows();

 $vPageCount=ceil($vRecordCount/$vBatasBaris);



$vArrData="";
$vArrHead=array('Class','Registrant');
$vArrBlank=array('','');
$vArrDateFilter=array('Date Filter : ',$vAwal." - ".$vAkhir,'','');

$i=0;
$vArrData[]=$vArrDateFilter;
$vArrData[]=$vArrBlank;
$vArrData[]=$vArrHead;

?>







<script language="JavaScript" type="text/JavaScript">





$(document).ready(function(){

    $('#caption').html('Summary Registration Report');





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



function goDet(pParam) {

   document.location.href='../manager/rptdetreg.php?current=<?=$_GET['current']?>&class='+pParam;



}

</script><head>

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


           <!--body wrapper start-->



                
<div class="right_col" role="main">
		<div><label><h3>Summary Registration Report</h3></label></div>



<form action="" method="post" name="demoform">



          <div style="display:inline" align="left">

          	<strong>Date : </strong>

          <input style="width:100px;display:inline" class="form-control" name="dc" id="dc" size="11" value="<?=$vAwal?>">&nbsp; 
			  <strong>to</strong>

          <input style="width:100px;display:inline" class="form-control" name="dc1" id="dc1" size="11" value="<?=$vAkhir?>"> &nbsp;&nbsp;

          <input style="display:inline" name="Submit22" type="submit" class="btn btn-success" value="Refresh">

          

          </div>

          <br /><br />

<br />





    <div class="table-responsive">

        <table width="90%" border="0" class="table table-striped" style="width:70%">

          <tr >

            <td style="height: 24px; width: 14%;"  align="center"><strong>Class</strong></td>

            <td width="12%" style="height: 24px" align="center"><b>Registrant</b></td>

            <td width="12%" style="height: 24px" align="center">&nbsp;</td>

          </tr>

          <tr >

            <td style="height: 24px; width: 14%;" class="auto-style1"><strong>

			Executive</strong></td>

            <td width="12%" style="height: 24px" align="center">

            <?

                $vSQL="select count(fidmember) as fcount from m_anggota where fpaket ='S' and date(ftgldaftar) between '$vAwal' and '$vAkhir'";

                $db->query($vSQL);

                $db->next_record();

                echo number_format($db->f('fcount'),0,",",".");

                $vArrDataS=array('Silver',$db->f('fcount'));
				$vArrData[]=$vArrDataS;

            ?>

            </td>

            <td width="12%" style="height: 24px" align="center">

            <input class="btn btn-success btn-sm" name="button" type="button" value="Detail &raquo;" onclick="goDet('S')"></td>

          </tr>

                   <tr >

            <td style="height: 24px; width: 14%;"><b>Exclusive</b></td>

            <td width="12%" style="height: 24px" align="center">

            <?

                 $vSQL="select count(fidmember) as fcount from m_anggota where fpaket= 'G' AND date(ftgldaftar) between '$vAwal' and '$vAkhir'";



                $db->query($vSQL);

                $db->next_record();

                echo number_format($db->f('fcount'),0,",",".");

                $vArrDataG=array('Gold',$db->f('fcount'));
				$vArrData[]=$vArrDataG;


            ?>



            </td>

            <td width="12%" style="height: 24px" align="center">

           <input class="btn btn-success  btn-sm" name="button" type="button" value="Detail &raquo;" onclick="goDet('G')"></td>

          </tr>

          <tr >

            <td style="height: 24px; width: 14%;"><b>Elite</b></td>

            <td width="12%" style="height: 24px" align="center">

            <?

                 $vSQL="select count(fidmember) as fcount from m_anggota where fpaket ='P' and date(ftgldaftar) between '$vAwal' and '$vAkhir'";

                $db->query($vSQL);

                $db->next_record();

                echo number_format($db->f('fcount'),0,",",".");

                 $vArrDataP=array('Platinum',$db->f('fcount'));
				$vArrData[]=$vArrDataP;
           		$_SESSION['sumreg']=$vArrData;

            ?>



            </td>

            <td width="12%" style="height: 24px" align="center">

           <input class="btn btn-success  btn-sm" name="button0" type="button" value="Detail &raquo;" onclick="goDet('P')"></td>

          </tr>

          </table>    

     </div>  

            

</form>
<button class="btn btn-info btn-sm" onClick="document.location.href='../manager/getexcel.php?arr=sumreg&file=report_sumreg'"><i class="fa fa-file-text-o"></i> Export Excel</button>
      <!-- page end-->

  



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
	<!-- end page container -->
	

<? include_once("../framework/admin_footside.blade.php") ; ?>