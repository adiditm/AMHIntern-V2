<? 

		if ($_GET['op'] != '') 
           include_once("../framework/admin_headside.blade.php");
        else
           include_once("../framework/member_headside.blade.php") ;  

   $vOutLet = $_SESSION['LoginOutlet'];


 $vSpy = md5('spy').md5($_GET['uMemberId']);



 if ($_GET['uMemberId'] != '')

    $vUserActive=$_GET['uMemberId'];

 else  $vUserActive=$vUser;



?>

<script language="Javascript">

$(document).ready(function(){

  <? if ($oDetect->isMobile()) {?>
  $('#caption').html('<span data-toggle="tooltip" data-placement="top" title="Sponsorship Status <?=$oMember->getMemberName($vUserActive)?>"><?=substr("Sponsorship ".$oMember->getMemberName($vUserActive),0,20);?>...</span>');
  <? } else { ?>
	$('#caption').html('Sponsorship Status <?=$vUserActive?> (<?=$oMember->getMemberName($vUserActive);?>)');
  <? } ?>
      
$('[data-toggle="tooltip"]').tooltip({tooltipClass:"ttclass"});  
});	

	

	

</script>





 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />

<div class="right_col" role="main">
		<div><label>
		<h3>Sponsor  Status</h3></label></div> 



 		  <div align="left" style="margin-left:1em" class="table-responsive">               

 		    

			<table border="0" align="center" cellpadding="1" cellspacing="0" class="table" style="width:100%">
				<thead>
				<tr style="font-weight:bold">

					<th width="12%"  align="center" nowrap style="width:10%">Activation Date</th>
					<th width="35%"  align="center" style="width:12%">Username</th>

					<th width="35%"  align="center" style="width:12%">Name</th>

					<th width="11%" align="center" style="width:10%">Position </th>

					<th width="11%" align="center" nowrap style="width:10%">Phone Number</th>

					<th width="11%" align="center" style="width:10%">City</th>

					<th width="11%"  align="center" style="width:10%">State</th>

				</tr>
                </thead>

            <?php

						//Export Excel
						$vArrData="";
						$vArrHead=array('No.','Activation Date','Username','Name','Position','Phone No.','City','State','Country');
						$vArrBlank=array('','','','');
						//$vArrDateFilter=array('Filter :  '.$vFilterText);
						$vArrDateFilter=array('');
						
						
						$i=0;$vTot=0;
						$vArrData[]=$vArrDateFilter;
						$vArrData[]=$vArrBlank;
						$vArrData[]=$vArrHead;



		 $vsql="select fdownline from tb_updown where fsponsor='$vUserActive' ";
		 
		 

		$dbin->query($vsql);
	    $i=0;
		while ($dbin->next_record()) {
		$i++;	
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
					<td align="left"><?=$vRegistrar?>&nbsp;</td>

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

					<td align="left">

					<?=$oMember->getWilName('ID',$oMember->getMemField('fpropinsi',$vRegistrar),'00','00','00')?></td>

				</tr>

            <? } ?>

            	<tr >

					<td height="21" align="center" class="style6">

					<strong>Total Sponsorship</strong>

					</td>
					<td align="left"  valign="bottom"><?=$i?></td>

					<td height="21" align="center" class="style6">

					<div align="right" >

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

				</tr>

			</table>
            
<p>&nbsp;</p>
</label></div> 
<h3>Presenter  Status</h3>
         <table border="0" align="center" cellpadding="1" cellspacing="0" class="table" style="width:100%">
				<thead>
				<tr style="font-weight:bold">

					<th width="12%"  align="center" nowrap style="width:10%">Activation Date</th>
					<th width="35%"  align="center" style="width:12%">Username</th>

					<th width="35%"  align="center" style="width:12%">Name</th>

					<th width="11%" align="center" style="width:10%">Position </th>

					<th width="11%" align="center" nowrap style="width:10%">Phone Number</th>

					<th width="11%" align="center" style="width:10%">City</th>

					<th width="11%"  align="center" style="width:10%">State</th>

				</tr>
                </thead>

            <?php

						//Export Excel
						$vArrData="";
						$vArrHead=array('No.','Activation Date','Username','Name','Position','Phone No.','City','State','Country');
						$vArrBlank=array('','','','');
						//$vArrDateFilter=array('Filter :  '.$vFilterText);
						$vArrDateFilter=array('');
						
						
						$i=0;$vTot=0;
						$vArrData[]=$vArrDateFilter;
						$vArrData[]=$vArrBlank;
						$vArrData[]=$vArrHead;



		 $vsql="select fdownline from tb_updown where fpresenter='$vUserActive' ";
		 
		 

		$dbin->query($vsql);
	    $i=0;
		while ($dbin->next_record()) {
		$i++;	
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
					<td align="left"><?=$vRegistrar?>&nbsp;</td>

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

					<td align="left">

					<?=$oMember->getWilName('ID',$oMember->getMemField('fpropinsi',$vRegistrar),'00','00','00')?></td>

				</tr>

            <? } ?>

            	<tr >

					<td height="21" align="center" class="style6">

					<strong>Total Presentership</strong>

					</td>
					<td align="left" class="style6" valign="middle"><?=$i?></td>

					<td height="21" align="center" class="style6">

					<div align="right" >

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

				</tr>

			</table>   
  </div>
<button style="margin-left:2em" class="btn btn-info btn-sm hide" onClick="document.location.href='../manager/getexcel.php?arr=stjarmem&file=sponsorship_report'"><i class="fa fa-file-text-o"></i> Export Excel</button> 









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
	


<? include_once("../framework/member_footside.blade.php") ; ?>
