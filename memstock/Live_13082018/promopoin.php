<? include_once("../framework/masterheader.php")?>

<?php

$vAwal=$_POST['dc'];
$vAkhir=$_POST['dc1'];

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

   

$vPointE=$oRules->getSettingByField('fpointeco');
$vPointB=$oRules->getSettingByField('fpointbuss');
$vPointF=$oRules->getSettingByField('fpointfirst');

$vDownL=$oNetwork->getDownLR($vUserActive,'L');
$vDownR=$oNetwork->getDownLR($vUserActive,'R');
$vPaketDownL=$oMember->getPaketID($vDownL);
$vPaketDownR=$oMember->getPaketID($vDownR);

$oNetwork->getDownlineByPaket($vDownL,$vOutLB,$vAwal,$vAkhir,'B');
$oNetwork->getDownlineByPaket($vDownL,$vOutLF,$vAwal,$vAkhir,'F');

if (is_array($vOutLB))
   $vCountLB=count($vOutLB);
else   
   $vCountLB=0;
   
if (is_array($vOutLF))
   $vCountLF=count($vOutLF);
else   
   $vCountLF=0;

//echo $vCountLF;
//echo ":";
//echo $vCountLB;

 
$oNetwork->getDownlineByPaket($vDownR,$vOutRB,$vAwal,$vAkhir,'B');
$oNetwork->getDownlineByPaket($vDownR,$vOutRF,$vAwal,$vAkhir,'F');

if (is_array($vOutRB))
   $vCountRB=count($vOutRB);
else   
   $vCountRB=0;
   
if (is_array($vOutRF))
   $vCountRF=count($vOutRF);
else   
   $vCountRF=0;

//echo $vCountRF;
//echo ":";
//echo $vCountRB;

/*echo "vCountLF $vCountLF<br>";
echo "vCountLB $vCountLB";


echo "vCountRF $vCountRF<br>";
echo "vCountRB $vCountRB";*/

$vPointL = ($vPointF * $vCountLF) + ($vPointB * $vCountLB);
if ($vPaketDownL=='B')
    $vPointL+=$vPointB;
    
if ($vPaketDownL=='F')
    $vPointL+=$vPointF;
    

$vPointR = ($vPointF * $vCountRF) + ($vPointB * $vCountRB);
if ($vPaketDownR=='B')
    $vPointR+=$vPointB;
    
if ($vPaketDownR=='F')
    $vPointR+=$vPointF;

/*
echo "Point L:".$vPointL ;
echo "<br>";
echo "Point R:".$vPointR ;
//print_r($vOutLB);
//print_r($vOutLF);
*/





 
?>



<script language="JavaScript" type="text/JavaScript">


$(document).ready(function(){
    $('#caption').html('Poin for Promo <?=$vUserActive?> (<?=$oMember->getMemberName($vUserActive);?>)');


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
	<link rel="stylesheet" href="../css/screen.css">

	
	
 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />


<section>
    <!-- left side start-->
   <?  if ($_GET['uMemberId'] != '' && $_GET['op']==$vSpy) 
           include "../framework/leftadmin.php"; 
        else
           include "../framework/leftmem.php"; 
     
     ?>
    <!-- main content start-->
    <div class="main-content" >

   <?   if ($_GET['uMemberId'] != '') 
           include "../framework/headeradmin.php"; 
        else
           include "../framework/headermem.php";    
     
     ?>
           <!--body wrapper start-->
 <section class="wrapper">
        <!-- page start-->

<form action="" method="post" name="demoform">

          <div style="display:inline" align="left">
          <strong>Start Date : </strong>
          <input style="width:100px;display:inline" class="form-control" name="dc" id="dc" size="11" value="<?=$vAwal?>">&nbsp; <strong>till</strong>
          <input style="width:100px;display:inline" class="form-control" name="dc1" id="dc1" size="11" value="<?=$vAkhir?>"> &nbsp;&nbsp;
          <input style="display:inline" name="Submit22" type="submit" class="btn btn-primary" value="Refresh">
          
          </div>
          <br /><br />
<br />


    <div class="table-responsive">
        <table width="90%" border="0" class="table ">
          <tr >
            <td width="8%" align="left" style="height: 24px" rowspan="2"><strong>ID Member </strong></td>
            <td width="21%" align="left" style="width: 23%; height: 24px;" rowspan="2"><strong>Name</strong></td>
            <td width="11%" align="center" style="height: 24px" colspan="2"><strong>&nbsp;Point</strong></td>
          </tr>
          <tr >
            <td align="center" style="height: 24px; width: 41px;"><strong>Left</strong></td>
            <td width="11%" align="center" style="height: 24px; width: 5%;">
			<strong>Right</strong></td>
          </tr>
                   <tr style="background-color:white">
            <td style="height: 24px" ><?=$vUserActive?></td>
            <td style="width: 23%; height: 24px;" ><?=$oMember->getMemberName($vUserActive);?></td>
            <td style="width: 41px; height: 24px;" ><div align="center"><? $vPoint=$oKomisi->getPoint($vUserActive,$vAwal,$vAkhir);echo  number_format($vPoint['L'],0,",",".")?></div></td>
            <td style="height: 24px" align="center"><? echo  number_format($vPoint['R'],0,",",".")?></td>
          </tr>

          </table>
      </div>  
            
     <table width="90%" style="display:none">
     <tr>
      <td align="center">
        
        <p>
          <?
   for ($i=0;$i<$vPageCount;$i++) {
     $vOffset=$i*$vBatasBaris;
     if ($i!=$vPage) {
     $vOP=$_GET['op'];

?>
          <a href="promopoin.php?uMemberId=<?=$vUserActive?>&amp;op=<?=$vOP?>uPage=<?=$i?>&amp;uAwal=<?=$oPhpdate->DMY2YMD($oPhpdate->YMD2DMY($vAwal,"-"),"-")?>&amp;uAkhir=<?=$oPhpdate->DMY2YMD($oPhpdate->YMD2DMY($vAkhir,"-"),"-")?>" >
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
