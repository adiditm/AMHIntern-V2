<?php

	       if ($_GET['uMemberId'] != '') 
           include_once("../framework/admin_headside.blade.php");
        else
           include_once("../framework/member_headside.blade.php") ;  
?>
<?
  
  if ($_GET['uMemberId'] !='')
     $vAgent=$_GET['uMemberId'];
  else  $vAgent=$vUser; 

 $vSpy = md5('spy').md5($_GET['uMemberId']);
?>

<script language="Javascript">
$(document).ready(function(){
      $('#caption').html('Stock Balance');
});	
	
	
</script>


 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />
	<div id="content" class="content">
			<ol class="breadcrumb pull-right">
				<h4>
				  <li><a href="javascript:;">Stock Position Report </a></li></h4>
				
			</ol>
<h1 class="page-header">&nbsp;</small></h1>
           <!--body wrapper start-->
 	 
 		  <div align="left" style="width:100%;margin-left:1%" class="table-responsive">               
 		    			<table border="0" align="left" cellpadding="1" cellspacing="0" class="table" style="margin-left:0.4em">
				<tr bgcolor="#CCCCFF" style="font-weight:bold">
					<td align="center" style="width: 21%">Product Code</td>
					<td align="center" style="width: 35%">Product Name</td>
					<td class="hide" align="center" style="width: 22%">Size</td>
					<td class="hide" align="center" style="width: 27%">Color</td>
					<td width="48%" align="center">Stock&nbsp;Balance</td>
									</tr>
            <?php
		 $vsql="select * from tb_stok_position where fidmember='$vAgent' order by fidproduk ";
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
					<td class="hide" height="21" align="center" style="width: 22%">&nbsp;
					</td>
					<td class="hide" height="21" align="center" style="width: 27%">&nbsp;
					</td>
					<td height="21" align="center" class="style6">&nbsp;
					</td>
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
	<!-- end page container -->
	
<? include_once("../framework/member_bottomjs.blade.php")?>	
	<script>
		$(document).ready(function() {
			App.init();
			Dashboard.init();
		});
	</script>

<? include_once("../framework/member_footside.blade.php") ; ?>
