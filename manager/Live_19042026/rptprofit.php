<? include_once("../framework/masterheader.php")?>



<?php


$vAnd='';
$vMonth=$_POST['lmBul'];
if ($vMonth =='') $vMonth=date("m");
$vYear=$_POST['lmTahun'];
if ($vYear =='') $vYear=date("Y");

$vRank=$_POST['lmRank'];

if ($vRank !='')
   $vAnd.=" and b.flevel='$vRank' ";






if ($vAwal=="")

   $vAwal=date('Y-m-d', strtotime('-30 days'));

   

if ($vAkhir=="")

   $vAkhir=$oPhpdate->getNowYMD("-");



   



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

    $('#caption').html('Profit Sharing Report');





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

   document.location.href='../manager/rptdetreg.php?class='+pParam;



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

          	<strong>Month : </strong>

            <select name="lmBul" id="lmBul" onChange=""  >
              <option value="" <? if ($vMonth=='') echo "selected";?>>--Pilih--</option>
              <option value="1" <? if ($vMonth=='1') echo "selected";?>>Januari</option>
              <option value="2" <? if ($vMonth=='2') echo "selected";?>>Februari</option>
              <option value="3" <? if ($vMonth=='3') echo "selected";?>>Maret</option>
              <option value="4" <? if ($vMonth=='4') echo "selected";?>>April</option>
              <option value="5" <? if ($vMonth=='5') echo "selected";?>>Mei</option>
              <option value="6" <? if ($vMonth=='6') echo "selected";?>>Juni</option>
              <option value="7" <? if ($vMonth=='7') echo "selected";?>>Juli</option>
              <option value="8" <? if ($vMonth=='8') echo "selected";?>>Agustus</option>
              <option value="9" <? if ($vMonth=='9') echo "selected";?>>September</option>
              <option value="10" <? if ($vMonth=='10') echo "selected";?>>Oktober</option>
              <option value="11" <? if ($vMonth=='11') echo "selected";?>>Nopember</option>
              <option value="12" <? if ($vMonth=='12') echo "selected";?>>Desember</option>
              
            </select>
            &nbsp;
            <strong>Year:</strong>
            
            <select name="lmTahun" id="lmTahun"  >
            <option value="" <? if ($vYear=='') echo 'selected';?> >--Pilih--</option>
          <?
			   $vArrYear=$oPhpdate->dispYearAround();
 			   $vCount=count($vArrYear);			
			   for ($i=0;$i<($vCount);$i++) {
			   
			?>
          <option value="<?=$vArrYear[$i]?>" <? if($vArrYear[$i]==$vYear) echo "selected" ?>>
          <?=$vArrYear[$i]?>
          </option>
          <? } ?>
        </select> &nbsp;&nbsp;<br>
       <br> <b>Filter By:</b> 
        <select name="lmRank" id="lmRank" onChange=""  >
          <option value="" <? if ($vRank=='') echo "selected";?>>--ALL--</option>
          <option value="PM" <? if ($vRank=='PM') echo "selected";?>>Platinum Manager</option>
          <option value="D" <? if ($vRank=='D') echo "selected";?>>Director</option>
          <option value="RD" <? if ($vRank=='RD') echo "selected";?>>Royal Director</option>
              
            </select><br><br>

          <input style="display:inline" name="Submit22" type="submit" class="btn btn-success" value="Refresh">

          

          </div>

          <br /><br />

<br />





    <div class="table-responsive">

        <table width="90%" border="0" class="table table-striped" style="width:70%">

          <tr >
            <td width="5"  align="center" style="height: 24px; width: 3%;"><strong>No.</strong></td>

            <td width="23%"  align="center" style="height: 24px; width: 14%;"><strong>Username</strong></td>

            <td width="24%" style="height: 24px" align="center"><b>Rank</b></td>
            <td width="24%" style="height: 24px" align="center"><b>Rank Bonus</b></td>
            <td width="24%" style="height: 24px" align="center"><b>Profit Sharing Bonus</b></td>

            <td width="24%" style="height: 24px" align="center">&nbsp;</td>

          </tr>
<?

                $vSQL="select * from tb_kom_profit a, m_anggota b where a.fidmember=b.fidmember and month(a.ftanggal) = $vMonth and year(a.ftanggal)= $vYear $vAnd ";

                $db->query($vSQL);
				$vTotBonus=0;
                while ($db->next_record()) {

                $vIDMem = $db->f('fidmember');
				$vRank = $oMember->getMemField('flevel',$vIDMem);
				$vBonus = $db->f('ffee');
				$vTotBonus+=$vBonus;
				$vDesc= $db->f('fdesc');
				$vDescOri=$vDesc;
				$vDesc=explode('(',$vDesc);
				$vDesc="Calculation = (".$vDesc[1];
				

              
				$vArrData[]=$vArrDataS;

            ?>
          <tr >
            <td style="height: 24px; width: 14%;" class="auto-style1">&nbsp;</td>

            <td style="height: 24px; width: 14%;" class="auto-style1"><strong>

			<?=$vIDMem?></strong></td>

            <td width="24%" style="height: 24px" align="center"><?=$vRank?>

            

            </td>
            <td width="24%" style="height: 24px" align="right">
            <?
        		if (preg_match("/PM/i",$vDescOri))
				   echo 'PM';    
				else   if (preg_match("/Dir/i",$vDescOri))
				   echo 'D';
				else   if (preg_match("/RD/i",$vDescOri)  ) 
				   echo 'RD';
			?>
            </td>
            <td width="24%" style="height: 24px" align="right"><?=number_format($vBonus,0,",",".")?></td>

            <td width="24%" style="height: 24px" align="center">

            <input class="btn btn-success btn-sm" name="button" type="button" value="Detail &raquo;" onclick="alert('<?=$vDesc?>')"></td>

          </tr>
          
  <? } ?>
  
  <tr >
            <td colspan="3" class="auto-style1" style="height: 24px; width: 14%;" align="right">Total: </td>
            <td style="height: 24px" align="right">&nbsp;</td>
            <td style="height: 24px" align="right"><?=number_format($vTotBonus,0,",",".")?></td>
            <td style="height: 24px" align="center">&nbsp;</td>
          </tr>
          </table>    

     </div>  

            

</form>
<button class="btn btn-info btn-sm hide" onClick="document.location.href='../manager/getexcel.php?arr=sumreg&file=report_sumreg'"><i class="fa fa-file-text-o"></i> Export Excel</button>
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

