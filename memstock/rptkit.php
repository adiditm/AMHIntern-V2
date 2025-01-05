<? include_once("../framework/masterheader.php")?>
<?
  error_reporting(1);
  if ($_GET['uMemberId'] !='')
     $vAgent=$_GET['uMemberId'];
  else  $vAgent=$vUser; 

 $vSpy = md5('spy').md5($_GET['uMemberId']);
 $vSort=$_POST['lmSort'];
 $vPaket=$_POST['lmPaket'];
?>

<script language="Javascript">
$(document).ready(function(){
      $('#caption').html('KIT Stock');
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
 	   <section class="wrapper" style="width:90%">
 		  <div align="left" style="width:98%;margin-left:1%" class="table-responsive">               
 		      Agent ID : <?=$vAgent?><br>
 		      Name :  <?=$oMember->getMemberName($vAgent)?><br><br>
<form id="frmFilter" name="frmFilter" method="post">
<div style="border:1px solid grey;padding: 4px 4px 4px 4px" style="width:65%">
		  <table border="0" cellpadding="4" cellspacing="0"  style="width:450px;border:0px solid silver;padding:6px 6px 6px 6px"  >
            <tr>
              <td colspan="2" ><div align="center"><font size="3"><strong>Filter</strong></font></div></td>
            </tr>

            <tr  >
              <td height="25"><div align="left">Package List</div></td>
              <td height="25"><div align="left">
                <select name="lmPaket" class="form-control" id="lmPaket">
                  <option value="-" selected="selected">All</option>
                  <option value="UEC" <? if ($vPaket=="UEC") echo "selected"?>>Economy Class Only</option>
                  <option value="UBC" <? if ($vPaket=="UBC") echo "selected"?>>Business Class Only</option>
				  <option value="UFC" <? if ($vPaket=="UFC") echo "selected"?>>First Class Only</option>
                </select>
              </div></td>
            </tr>
            <tr >
              <td style="height: 25px"><div align="left">Sorting List</div></td>
              <td style="height: 25px"><div align="left">
                <select name="lmSort" class="form-control" id="lmSort">
                  <option value="" <? if ($vSort=="") echo "selected";?>>Display All</option>
                  <option value="1" <? if ($vSort=="1") echo "selected";?>>KIT Being Used Only</option>
                  <option value="2" <? if ($vSort=="2") echo "selected";?>>KIT Not Being Used Only</option>
                  
                </select>
              </div></td>
            </tr>
            <tr>
              <td colspan="2"><div align="center"><br>
                  <input name="Submit" type="submit" class="btn btn-primary" value="Refresh" />
                &nbsp; &nbsp;
                <input name="Submit2" type="button" class="btn btn-default" value="Reset" onclick="document.location.href='../manager/rpt_topspon.php'" />
              </div></td>
            </tr>
          </table>
          </div>
</form>
<br>
			<table border="0" align="left" cellpadding="1" cellspacing="0" class="table" style="width:95%" >
				<tr bgcolor="#CCCCFF" style="font-weight:bold">
					<td align="center" style="width: 21%">KIT No</td>
					<td align="center" style="width: 35%">Class</td>
					<td align="center" style="width: 22%">Purchased Date</td>
					<td align="center" style="width: 22%">Used</td>
									</tr>
            <?php
         
         $vOrder =   "";
         if ($vSort=='1')
            $vOrder=" order by b.fnama asc ";
         else  if ($vSort=='2')   
            $vOrder=" order by b.fnama desc ";
         else  if ($vSort=='3')   
            $vOrder=" order by a.fserno asc ";         
         else  if ($vSort=='4')   
            $vOrder=" order by a.fserno desc ";         
        
         $vAnd="";
         
         if ($vPaket=='UEC')
            $vAnd = " and a.fserno like 'UEC%' ";
		 else if ($vPaket=='UBC')
            $vAnd = " and a.fserno like 'UBC%' ";
		 else if ($vPaket=='UFC')
            $vAnd = " and a.fserno like 'UFC%' ";

   
		$vsql="select a.*,b.fidmember,b.fnama from tb_skit a left join m_anggota b on a.fserno=b.fidmember where a.fpendistribusi='$vAgent' $vAnd $vOrder ";
		$dbin->query($vsql);
		$vCount=0;
		while ($dbin->next_record()) {
		   $vCount++;
			$vNo=$dbin->f('fserno');
			$vPurcDate=$dbin->f('ftgldist');
			if (substr($vNo,0,3)=='UEC')
			   $vClass='Economy';
			else if (substr($vNo,0,3)=='UBC')   
			   $vClass='Business';
			else  if (substr($vNo,0,3)=='UFC')    
			   $vClass='First Class';
		   if ($dbin->f('fstatus') == 3) {
		      $vUsed = 'Yes';
		      if ($dbin->f('fnama') != '') 
		          $vUsed.= " (by ".$dbin->f('fnama').")";
		   } else $vUsed='No';   

		?>
            	<tr >
					<td align="center" style="width: 21%">
					<?=$vNo?></td>
					<td align="left" style="width: 35%">
					<?=$vClass?></td>
					<td align="center" style="width: 22%"><?=$vPurcDate?></td>
					<td align="left" style="width: 22%"><?=$vUsed?></td>
														</tr>
            <? } ?>
            	<tr style="font-weight:bold">
					<td height="21" align="center" class="style6" style="width: 21%">
					Total Stock&nbsp;</td>
					<td height="21" align="center" class="style6" style="width: 35%">
					&nbsp;</td>
					<td height="21" align="right" class="style6" style="width: 22%">
					<? echo number_format($vCount,0,",",".");?>&nbsp;</td>
					<td height="21" align="right" class="style6" style="width: 22%">
					&nbsp;</td>
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
