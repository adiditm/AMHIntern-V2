<? include_once("../framework/masterheader.php")?>
<?
 $vSpy = md5('spy').md5($_GET['uMemberId']);

 if ($_GET['uMemberId'] != '')
    $vUserActive=$_GET['uMemberId'];
 else  $vUserActive=$vUser;
 
 $vStart=$_GET['start'];
 $vEnd=$_GET['end'];

?>
<script language="Javascript">
$(document).ready(function(){
      $('#caption').html('Sponsorship Status <?=$vUserActive?> (<?=$oMember->getMemberName($vUserActive);?>)');
});	
	
	
</script>

<body class="" bgcolor="#fff" style="background-color:white">
 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />


 <section>
             <!--body wrapper start-->
 	   <section class="wrapper" style="width:100%;background-color:white">
 		  <div align="left" style="width:98%;margin-left:1%" class="">               
 		    <b>Agent / Distributor ID :  <?=$vUserActive?> / <?=($oMember->getMemberName($vUserActive))?></b><br> <br>
 		    <b>Sponsorship List:</b><br>
			<table border="0" align="center" cellpadding="1" cellspacing="0" class="table" >
				<tr bgcolor="#CCCCFF">
					<td align="center" style="width: 11%"><span class="style5">
					No</span></td>
					<td align="center" style="width: 32%"><span class="style5">
					Distributor ID</span></td>
					<td align="center" style="width: 38%"><span class="style5">Name</span></td>
					<td width="48%" align="center">Active Date</td>
					<td width="48%" align="center">Omzet </td>
				</tr>
            <?php
		$vsql="select fdownline,ftanggal from tb_updown where fsponsor='$vUserActive' and ftanggal between '$vStart' and '$vEnd' ";
		$dbin->query($vsql);
		$vNo=0;$vOmzetTot=0;
		while ($dbin->next_record()) {
		$vNo++;
		$vRegistrar=$dbin->f('fdownline');
		$vTglActive=$oPhpdate->YMD2DMY($dbin->f('ftanggal'));
		$vPos=$oNetwork->getPosOne($vRegistrar);
		if ($vPos==L)
		   $vPos='LEFT';
		else   
		   $vPos='RIGHT';
		?>
            	<tr >
					<td height="21" align="center" style="width: 11%"><span class="style9">
                <?=$vNo?>
              	  </span></td>
					<td align="center" style="width: 32%">
					<div align="left" class="style9">
                  <?=$vRegistrar?>
              	  </div>
					</td>
					<td align="center" style="width: 38%">
					<div align="left" class="style9">
                  <?=$oMember->getMemberName($vRegistrar)?>
              	  </div>
					</td>
					<td align="center">
					<?=$vTglActive?></td>
					<td align="center">
					        <?
            $vOmzet=$oKomisi->getOmzetROAllMemberKIT($vRegistrar);
			echo number_format($vOmzet,2,",",".");
			$vOmzetTot+=$vOmzet;
        ?>

					
					</td>
				</tr>
            <? } ?>
            	<tr >
					<td height="21" colspan="2" align="center" class="style6">
					<span class="style8"><strong>Total Omzet Sponsorship</strong>
					</span></td>
					<td height="21" align="center" class="style6" style="width: 38%">
					<div align="right" class="style9">
						</div>
					</td>
					<td height="21" align="center" class="style6">
					&nbsp;</td>
					<td height="21" align="center" class="style6"><strong>
					<?=number_format($vOmzetTot,2,",",".")?></strong></td>
				</tr>
			</table>
		        </div>
</section>
        <!--body wrapper end-->

        <!--footer section start-->

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
