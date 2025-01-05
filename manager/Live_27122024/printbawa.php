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
			        <td width="87%" align="center"><h2>Tanda Terima Barang Bawaan</h2></td>
		          </tr>
		        </table></td>
		      </tr>
			  <tr bgcolor="">
			    <td colspan="3" align="left" style="border:1px solid;border-top:none" >
                <br>
			      <strong>Nama jamaah :
<?=$_POST['fnama']?> / <?=$_POST['fidmember']?>
		        , titipan barang-barang bawaan sebagai berikut:</strong><br>		        
		        <br></td>
		      </tr>
              <? $vNo=1;?>
			  <tr bgcolor="#CCCCFF" style="font-weight:bold">
					<td width="27" align="center" style="width:5%;border:1px solid"   >
					No</td>
					<td width="542" align="center" style="border:1px solid" >
					Nama Barang</td>
					<td width="81" align="center" style="border:1px solid" >Jumlah</td>
			  </tr>
				<? if ($_POST['fbawakoper']=='1') {?>
            	<tr >
					<td  align="center" style="border:1px solid" >
                <?=$vNo++?>
              	  </td>
					<td align="left" style="border:1px solid">Koper</td>
					<td align="right" style="border:1px solid"><?=$_POST['tfbawakoper']?></td>
				</tr>
                <? } ?>

				<? if ($_POST['fbawatpaspor']=='1') {?>
            	<tr >
					<td  align="center" style="border:1px solid" >
                <?=$vNo++?>
              	  </td>
					<td align="left" style="border:1px solid">Tas Paspor</td>
					<td align="right" style="border:1px solid"><?=$_POST['tfbawatpaspor']?></td>
				</tr>
                <? } ?>

				<? if ($_POST['fbawabukudoa']=='1') {?>
            	<tr >
					<td  align="center" style="border:1px solid" >
               <?=$vNo++?>
              	  </td>
					<td align="left" style="border:1px solid">Buku Do'a</td>
					<td align="right" style="border:1px solid"><?=$_POST['tfbawabukudoa']?></td>
				</tr>
                <? } ?>
				<? if ($_POST['fbawabergok']=='1') {?>
            	<tr >
					<td  align="center" style="border:1px solid" >
                <?=$vNo++?>
              	  </td>
					<td align="left" style="border:1px solid">Bergo Kecil</td>
					<td align="right" style="border:1px solid"><?=$_POST['tfbawabergok']?></td>
				</tr>
                <? } ?>
                
                
				<? if ($_POST['fbawaikrom']=='1') {?>
            	<tr >
					<td  align="center" style="border:1px solid" >
                <?=$vNo++?>
              	  </td>
					<td align="left" style="border:1px solid">Kain Ikrom</td>
					<td align="right" style="border:1px solid"><?=$_POST['tfbawaikrom']?></td>
				</tr>
                <? } ?>
                
                                
				<? if ($_POST['fbawatkabin']=='1') {?>
            	<tr >
					<td  align="center" style="border:1px solid" >
                <?=$vNo++?>
              	  </td>
					<td align="left" style="border:1px solid">Tas Kabin</td>
					<td align="right" style="border:1px solid"><?=$_POST['tfbawatkabin']?></td>
				</tr>
                <? } ?>
				<? if ($_POST['fbawakainser']=='1') {?>
            	<tr >
					<td  align="center" style="border:1px solid" >
                <?=$vNo++?>
              	  </td>
					<td align="left" style="border:1px solid">Kain Seragam</td>
					<td align="right" style="border:1px solid"><?=$_POST['tfbawakainser']?></td>
				</tr>
                <? } ?>
				<? if ($_POST['fbawabergob']=='1') {?>
            	<tr >
					<td  align="center" style="border:1px solid" >
                <?=$vNo++?>
              	  </td>
					<td align="left" style="border:1px solid">Bergo Besar</td>
					<td align="right" style="border:1px solid"><?=$_POST['tfbawabergob']?></td>
				</tr>
                <? } ?>
                
			<? if ($_POST['fbawasabuk']=='1') {?>
            	<tr >
					<td  align="center" style="border:1px solid" >
                <?=$vNo++?>
              	  </td>
					<td align="left" style="border:1px solid">Sabuk</td>
					<td align="right" style="border:1px solid"><?=$_POST['fbawasabuk']?></td>
				</tr>
                <? } ?>
                                
				<? if ($_POST['fbawalain']=='1') {?>
            	<tr >
					<td  align="center" style="border:1px solid" >
                <?=$vNo++?>
              	  </td>
					<td align="left" style="border:1px solid">Lain-lain</td>
					<td align="right" style="border:1px solid"><?=$_POST['tfbawalain']?></td>
				</tr>
                 <? } ?>
            	<tr >
            	  <td colspan="3"  align="center" style="border:1px solid;padding:3px 3px 3px 3px" >
           	        <table width="100%" border="0" cellspacing="0" cellpadding="0">
           	          <tr>
           	            <td align="left" width="50%"><p>&nbsp;</p>
           	              <p>Surabaya, 
           	            <?=date('m-d-Y')?>
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
