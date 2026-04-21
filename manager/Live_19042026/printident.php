<?
  session_start();
   include_once("../server/config.php");
   include_once("../classes/memberclass.php");
   include_once(CLASS_DIR."dateclass.php");
   include_once("../classes/networkclass.php");
   include_once(CLASS_DIR."ifaceclass.php");
   include_once("../classes/ruleconfigclass.php");
   include_once(CLASS_DIR."komisiclass.php");
   include_once(CLASS_DIR."jualclass.php");
   include_once(CLASS_DIR."systemclass.php");
   include_once(CLASS_DIR."productclass.php");
   include_once(CLASS_DIR."texttoimageclass.php");
   include_once("../classes/mobdetectclass.php");
    if ($_SESSION['LoginUser']=='') { 	
      header("Location: ../main/logout.php");
	}

//	print_r($_POST);
   $vJamaah = $_GET['uMemberId'];
   $vAngs = $_GET['no'];
   
    $vSQL = "select * from m_anggota where fidmember = '$vJamaah' ";
   $db->query($vSQL);
   $db->next_record();
   if (is_numeric($vAngs)) {
	   $vAngsuran = $db->f('fangsur'.$vAngs);   
   } else  {
	   if ($vAngs=='lns')
	        $vAngsuran = $db->f('flunas');
	   else if ($vAngs=='str')
	        $vAngsuran = $db->f('fstorawal');

   }
   $vName = $oMember->getMemberName($vJamaah);
   
  // echo "sssss ".$vAngsuran;

?>

<html xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 12">
</head>
<script language="Javascript">

	
	
</script>

<body class="" bgcolor="#fff" style="background-color:white"  onLoad="window.print()">
 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />


 <section>
             <!--body wrapper start-->


 		    <table border="0" style="border-collapse:collapse" align="center" cellpadding="3" cellspacing="0" class="table" width="75%" >
			  <tr bgcolor="">
			    <td colspan="3" align="left" style="border:1px solid;border-bottom:none" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
			      <tr>
			        <td width="13%"><img src="../images/logoinvoice.jpg" width="109" height="75" alt="IMG"></td>
			        <td width="87%" align="center"><h2>Tanda Terima Kelengkapan Identitas</h2></td>
		          </tr>
		        </table></td>
		      </tr>
			  <tr bgcolor="">
			    <td colspan="3" align="left" style="border:1px solid;border-top:none" >
                <br>
			      <strong>Nama jamaah :
<?=$_POST['fnama']?> / <?=$_POST['fidmember']?>
		        , titipan kelengkapan identitas sebagai berikut:</strong><br>		        
		        <br></td>
		      </tr>
              <? $vNo=1;?>
			  <tr bgcolor="#CCCCFF" style="font-weight:bold">
					<td width="31" align="center" style="width:5%;border:1px solid"   >
					No</td>
					<td width="526" align="center" style="border:1px solid" >
					Nama Barang</td>
					<td width="105" align="center" style="border:1px solid" >Jumlah</td>
			  </tr>
				<? if ($_POST['fidentfoto34']=='1') {?>
            	<tr >
					<td  align="center" style="border:1px solid" >
                <?=$vNo++?>
              	  </td>
					<td align="left" style="border:1px solid">Foto 3 x 4</td>
					<td align="right" style="border:1px solid"><?=$_POST['tfidentfoto34']?></td>
				</tr>
                <? } ?>

				<? if ($_POST['fidentfoto46']=='1') {?>
            	<tr >
					<td  align="center" style="border:1px solid" >
                <?=$vNo++?>
              	  </td>
					<td align="left" style="border:1px solid">Foto 4 x 6</td>
					<td align="right" style="border:1px solid"><?=$_POST['tfidentfoto46']?></td>
				</tr>
                <? } ?>

				<? if ($_POST['fidentformas']=='1') {?>
            	<tr >
					<td  align="center" style="border:1px solid" >
               <?=$vNo++?>
              	  </td>
					<td align="left" style="border:1px solid">Formulir Asli</td>
					<td align="right" style="border:1px solid"><?=$_POST['tfidentformas']?></td>
				</tr>
                <? } ?>
				<? if ($_POST['fidentformfc']=='1') {?>
            	<tr >
					<td  align="center" style="border:1px solid" >
                <?=$vNo++?>
              	  </td>
					<td align="left" style="border:1px solid">Formulir Fotocopy</td>
					<td align="right" style="border:1px solid"><?=$_POST['tfidentformfc']?></td>
				</tr>
                <? } ?>
				<? if ($_POST['fidentakteas']=='1') {?>
            	<tr >
					<td  align="center" style="border:1px solid" >
                <?=$vNo++?>
              	  </td>
					<td align="left" style="border:1px solid">Akte Lahir Asli</td>
					<td align="right" style="border:1px solid"><?=$_POST['tfidentakteas']?></td>
				</tr>
                <? } ?>
				<? if ($_POST['fidentaktefc']=='1') {?>
            	<tr >
					<td  align="center" style="border:1px solid" >
                <?=$vNo++?>
              	  </td>
					<td align="left" style="border:1px solid">Akte Lahir Fotocopy</td>
					<td align="right" style="border:1px solid"><?=$_POST['tfidentaktefc']?></td>
				</tr>
                <? } ?>
				<? if ($_POST['fidentpasporas']=='1') {?>
            	<tr >
					<td  align="center" style="border:1px solid" >
                <?=$vNo++?>
              	  </td>
					<td align="left" style="border:1px solid">Paspor Asli</td>
					<td align="right" style="border:1px solid"><?=$_POST['tfidentpasporas']?></td>
				</tr>
                <? } ?>
				<? if ($_POST['fidentpasporfc']=='1') {?>
            	<tr >
					<td  align="center" style="border:1px solid" >
                <?=$vNo++?>
              	  </td>
					<td align="left" style="border:1px solid">Paspor Fotocopy</td>
					<td align="right" style="border:1px solid"><?=$_POST['tfidentpasporfc']?></td>
				</tr>
                 <? } ?>

				<? if ($_POST['fidentktpas']=='1') {?>
            	<tr >
					<td  align="center" style="border:1px solid" >
                <?=$vNo++?>
              	  </td>
					<td align="left" style="border:1px solid">KTP Asli</td>
					<td align="right" style="border:1px solid"><?=$_POST['tfidentktpas']?></td>
				</tr>
                 <? } ?>
				<? if ($_POST['fidentktpfc']=='1') {?>
            	<tr >
					<td  align="center" style="border:1px solid" >
                <?=$vNo++?>
              	  </td>
					<td align="left" style="border:1px solid">KTP Fotocopy</td>
					<td align="right" style="border:1px solid"><?=$_POST['tfidentktpfc']?></td>
				</tr>
                 <? } ?>
				<? if ($_POST['fidentkkas']=='1') {?>
            	<tr >
					<td  align="center" style="border:1px solid" >
                <?=$vNo++?>
              	  </td>
					<td align="left" style="border:1px solid">KK Asli</td>
					<td align="right" style="border:1px solid"><?=$_POST['tfidentkkas']?></td>
				</tr>
                 <? } ?>
				<? if ($_POST['fidentkkfc']=='1') {?>
            	<tr >
					<td  align="center" style="border:1px solid" >
                <?=$vNo++?>
              	  </td>
					<td align="left" style="border:1px solid">KK Fotocopy</td>
					<td align="right" style="border:1px solid"><?=$_POST['tfidentkkfc']?></td>
				</tr>
                 <? } ?>
				<? if ($_POST['fidentnikahas']=='1') {?>
            	<tr >
					<td  align="center" style="border:1px solid" >
                <?=$vNo++?>
              	  </td>
					<td align="left" style="border:1px solid">Buku Nikah Asli</td>
					<td align="right" style="border:1px solid"><?=$_POST['tfidentnikahas']?></td>
				</tr>
                 <? } ?>
				<? if ($_POST['fidentnikahfc']=='1') {?>
            	<tr >
					<td  align="center" style="border:1px solid" >
                <?=$vNo++?>
              	  </td>
					<td align="left" style="border:1px solid">Buku Nikah Fotocopy</td>
					<td align="right" style="border:1px solid"><?=$_POST['tfidentnikahfc']?></td>
				</tr>
                 <? } ?>
                 
            	<tr >
            	  <td colspan="3"  align="center" style="border:1px solid;padding:3px 3px 3px 3px" >
           	        <table width="100%" border="0" cellspacing="0" cellpadding="0">
           	          <tr>
           	            <td align="left" width="50%"><p>&nbsp;</p>
           	              <p>Surabaya, 
           	            <?=date('d-m-Y')?>
           	              </p>
       	                <p>&nbsp;</p>
       	                <p>&nbsp;</p>
       	                <p>&nbsp;</p>
       	                <p>(<?=$_POST['fnama']?>)</p></td>
           	            <td align="right"><p>&nbsp;</p>
           	              <p>Penerima &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
       	                <p>&nbsp;</p>
       	                <p>&nbsp;</p>
       	                <p>&nbsp;</p>
       	                <p>(<? for($i=0;$i<50;$i++) echo '&nbsp;';?>)</p></td>
       	              </tr>
   	              </table></td>
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
