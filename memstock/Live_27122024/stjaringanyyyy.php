<? include_once("../framework/masterheader.php")?>
<?
 $vSpy = md5('spy').md5($_GET['uMemberId']);

 if ($_GET['uMemberId'] != '')
    $vUserActive=$_GET['uMemberId'];
 else  $vUserActive=$vUser;

?>
<script language="Javascript">
$(document).ready(function(){
      $('#caption').html('Sponsorship Status <?=$vUserActive?> (<?=$oMember->getMemberName($vUserActive);?>)');
});	
	
	
</script>

          <?   if ($_GET['uMemberId'] != '') 
           include "../framework/headeradmin.php"; 
        else
           include "../framework/headermem.php";    
     
     ?>
    <!-- left side end-->
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
       <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
 			<? include "../framework/leftmem.php"; ?> 
 

        <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">

           <!--body wrapper start-->
 	<br><br>
 		  <div align="left" style="width:98%;margin-left:1%;margin-top:10%" class="table-responsive">               
 		    
			<table border="0" align="center" cellpadding="1" cellspacing="0" class="table" >
				<tr bgcolor="#CCCCFF">
					<td width="26%" align="center"><span class="style5">Activation Date</span></td>
					<td align="center" style="width: 32%"><span class="style5">ID 
					Member</span></td>
					<td width="48%" align="center"><span class="style5">Name</span></td>
					<td width="48%" align="center">Position </td>
					<td width="48%" align="center">Phone Number</td>
					<td width="48%" align="center">City</td>
					<td width="48%" align="center">State</td>
					<td width="48%" align="center">Country</td>
				</tr>
            <?php
		 $vsql="select fdownline from tb_updown where fsponsor='$vUserActive' ";
		$dbin->query($vsql);
		while ($dbin->next_record()) {
		$vRegistrar=$dbin->f('fdownline');
		$vPos=$oNetwork->getPosOne($vRegistrar);
		if ($vPos==L)
		   $vPos='LEFT';
		else   
		   $vPos='RIGHT';
		?>
            	<tr >
					<td height="21" align="center"><span class="style9">
                <?=$oPhpdate->YMD2DMY($oMember->getActivationDate($vRegistrar),"-")?>
              	  </span></td>
					<td align="center" style="width: 32%">
					<div align="left" class="style9">
                  <?=$vRegistrar?>
              	  </div>
					</td>
					<td align="center">
					<div align="left" class="style9">
                  <?=$oMember->getMemberName($vRegistrar)?>
              	  </div>
					</td>
					<td align="center">
					<?=$vPos?></td>
					<td align="center">
					<?=$oMember->getMemField('fnohp',$vRegistrar)?></td>
					<td align="center">
					<?=$oMember->getWilName('ID',$oMember->getMemField('fpropinsi',$vRegistrar),$oMember->getMemField('fkota',$vRegistrar),'00','00')?></td>
					<td align="center">
					<?=$oMember->getWilName('ID',$oMember->getMemField('fpropinsi',$vRegistrar),'00','00','00')?></td>
					<td align="center">
					<?=$oMember->getCountryName($oMember->getMemField('fcountry',$vRegistrar))?></td>
				</tr>
            <? } ?>
            	<tr >
					<td height="21" colspan="2" align="center" class="style6">
					<span class="style8"><strong>Total Sponsorship</strong>
					</span></td>
					<td height="21" align="center" class="style6">
					<div align="right" class="style9">
						</div>
					</td>
					<td height="21" align="center" class="style6">&nbsp;
					</td>
					<td height="21" align="center" class="style6">&nbsp;
					</td>
					<td height="21" align="center" class="style6">&nbsp;
					</td>
					<td height="21" align="center" class="style6">&nbsp;
					</td>
					<td height="21" align="center" class="style6">
						<span style="font-weight:bold">
                <?=number_format($oNetwork->getSponsorShipCount($vUserActive),0,',','.')?>
              		  </span></td>
				</tr>
			</table>
		        </div>
</div>
</div>

</div>
 

<!-- Placed js at the end of the document so the pages load faster -->

<!-- Placed js at the end of the document so the pages load faster -->

        <!-- BEGIN FOOTER -->
			 <? include "../framework/footer.php"; ?>
        <!-- END FOOTER -->
         <? include "../framework/masterfooter.php"; ?>