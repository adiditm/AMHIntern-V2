<? include_once("../framework/masterheader.php")?>
<?
  
  if ($_GET['uMemberId'] !='')
     $vAgent=$_GET['uMemberId'];
  else  $vAgent=$vUser; 

 $vSpy = md5('spy').md5($_GET['uMemberId']);
?>

<script language="Javascript">
$(document).ready(function(){
      $('#caption').html('Stock Balance (RO Items)');
});	
	
	
</script>

<body class="sticky-header">
 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />


 <section>
    <!-- left side start-->
      <?  
      
     
      if ($_GET['uMemberId'] != '' && $_GET['op']==$vSpy) 
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
 	   <section class="wrapper" style="width:90%" >
 		  <div align="left" style="width:98%;margin-left:1%" class="table-responsive">               
 		    			<table border="0" align="left" cellpadding="1" cellspacing="0" class="table" style="margin-left:0.4em">
				<tr bgcolor="#CCCCFF" style="font-weight:bold">
					<td align="center" style="width: 21%">Product Code</td>
					<td align="center" style="width: 35%">Product Name</td>
					<td class="hide" align="center" style="width: 22%">Size</td>
					<td class="hide" align="center" style="width: 27%">Color</td>
					<td width="48%" align="center">Stock&nbsp;Balance</td>
									</tr>
            <?php
		 $vsql="select * from tb_stok_positionro where fidmember='$vAgent' order by fidproduk ";
		$dbin->query($vsql);
		while ($dbin->next_record()) {
		$vID=$dbin->f('fidproduk');
		$vBal=$dbin->f('fbalance');
		$vSize=$dbin->f('fsize');
		$vColor=$dbin->f('fcolor');
		$vColorName=$oProduct->getColor($dbin->f('fcolor'));
		?>
            	<tr >
					<td align="center" style="width: 21%">
					<?=$vID?></td>
					<td align="left" style="width: 35%">
					<?=$oProduct->getProductName($vID)?></td>
					<td class="hide" align="center" style="width: 22%"><?=$vSize?></td>
					<td class="hide" align="center" style="width: 27%"><?=$vColorName?></td>
					<td align="right">
					<?=number_format($vBal,0,",",".")?></td>
									</tr>
            <? } ?>
            	<tr >
					<td height="21" align="center" class="style6" style="width: 21%">&nbsp;
					</td>
					<td height="21" align="center" class="style6" style="width: 35%">&nbsp;
					</td>
					<td class="hide" height="21" align="center" class="style6" style="width: 22%">
					&nbsp;</td>
					<td class="hide" height="21" align="center" class="style6" style="width: 27%">
					&nbsp;</td>
					<td height="21" align="center" class="style6">&nbsp;
					</td>
									</tr>
			</table>
		        </div>
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
