<? include_once("../framework/masterheader.php")?>



<?

  date_default_timezone_set('Asia/Jakarta');

  define("MENU_ID", "royal_jual_verifikasi");   

  $vRefUser=$_GET['uMemberId'];

  if (isset($vRefUser))

  	 $vUser=$vRefUser;

  else	 

  	 $vUser=$_SESSION['LoginUser'];

  

  $vCoup=$oRules->getSettingByField("ffeecouple",1);

  $vSponsor=$oRules->getSponFee(1);

  if ($vTanggal=="")

     $vTanggal=$oPhpdate->getNowYMD("-");  

  $vAwal=$_POST['dc'];

  $vAkhir=$_POST['dc1'];

  if ($vAwal=="") 

     $vAwal=$oPhpdate->getWeekDate(date("Y"),date("W"),true)." 00:00:00";

  if ($vAkhir=="") 

  	 $vAkhir=$oPhpdate->getWeekDate(date("Y"),date("W"),false)." 23:59:59"; 

	 //FIlter



   $ref=$_REQUEST['ref'];





	$vIDJual=$_POST['tfIDJual']; 

	$vID=$_POST['tfID'];

	$vAnd="";

	if ($vID!="") $vAnd.=" and fidmember like '%$vID%' ";

	if ($vIDJual!="")  $vAnd.=" and fidpenjualan like '%$vIDJual%' "; 

	$vAnd.=" and ftanggal between '$vAwal' and '$vAkhir'";

	$vAnd.=" and fprocessed !=4 ";

	

    $vsql="SELECT fidpenjualan,fidmember,ftanggal,fjenis,fprocessed,SUM(fsubtotal) AS subtotal  FROM tb_trxstok_member WHERE fidproduk not like 'KIT%'  $vAnd ";

    $vsql.="	GROUP BY fidpenjualan,ftanggal,fidmember,fjenis,fprocessed ORDER BY fidpenjualan DESC";

    $db->query($vsql);



    $curpage=$_POST['hPageNum'];

    if ($curpage=="" || $_POST['hBtn']=="cari") {

       $curpage="1";

    }

	

	$rows=$db->num_rows();

	$jml=$rows;

	$rowpage=25;

	$curpage=$curpage-1;

	$offset=$curpage*$rowpage;

	

	$pagenum=ceil($rows/$rowpage);



 



	

	

?>



<!--  <link rel="stylesheet" href="../css/screen.css"> -->

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />









<script language="JavaScript" type="text/JavaScript">





$(document).ready(function(){

    $('#caption').html('Verifikasi Repeat Order');





      $('#dc').datepicker({

                    format: "yyyy-mm-dd",

                    autoclose : true

    }); 

  

  

       $('#dc1').datepicker({

                    format: "yyyy-mm-dd",

                    autoclose : true

    }); 



});





function MM_goToURL() { //v3.0

  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;

  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");

}





   function changePage(pMenu) {



     document.demoform.hPageNum.value=pMenu.value;

	 doSubmit("refresh");

   }



   function doSubmit(btn) {



      document.demoform.hBtn.value=btn;

	  if (btn=="refresh")

	     document.getElementById("ref").value="posting";

	  else if (btn=="cari")

	     document.getElementById("ref").value="posting";

	  document.demoform.submit();

   }



function MM_callJS(jsStr) { //v2.0

  return eval(jsStr)

}

//-->



function doProcess(pURL) {

   vSure=confirm('Apakah Anda yakin memproses pembelian ini?');

   if (vSure==true) {

	     window.location=pURL+'&ref=auto';

   } 

}



function doCancel(pURL) {

   vSure=confirm('Apakah Anda yakin membatalkan pembelian ini?');

   if (vSure==true) {

	     window.location=pURL;

   } 

}



</script>

<style type="text/css">

<!--

table.MsoNormalTable {

font-size:10.0pt;

font-family:"Times New Roman";

}

p.MsoNormal {

margin:0cm;

margin-bottom:.0001pt;

font-size:12.0pt;

font-family:"Times New Roman";

}

.style3 {

	font-size: 12px;

	font-weight: bold;

}

.style4 {font-size: 10px}

-->

</style>



<section>

    <!-- left side start-->

   <? include "../framework/leftadmin.php"; ?>

    <!-- main content start-->

    <div class="main-content" >



   <? include "../framework/headeradmin.php"; ?>

           <!--body wrapper start-->

 <section class="wrapper">





        <form id="demoform" name="demoform" method="post" action="" >

		<input name="hPageNum" type="hidden" id="hPageNum">   

        <input name="hPage" type="hidden" id="hPage" value="<?=$curpage?>">

        <input name="hBtn" type="hidden" id="hBtn">

         <input name="ref" type="hidden" id="ref" >

<div align="left" class="col-lg-12" >
<div align="left" class="col-lg-8" style="margin-left:-1em">
         


<div class="row">
            <div align="left" class="col-sm-4"><strong>Username</strong></div>

           <div align="left" class="col-sm-6 col-md-6 col-xs-6">
              <input name="tfID" type="text" class="form-control" id="tfID" value="<?=$vID?>" />
            </div></div>
<br>
<div class="row">
            <div align="left" class="col-sm-4"><strong>Purchase ID</strong></div>

           <div align="left" class="col-sm-6 col-md-6 col-xs-6">
              <input name="tfIDJual" type="text" class="form-control" id="tfIDJual" value="<?=$vIDJual?>" />
            </div></div>
<br>           

  

          

         <div class="row">

         
           <div align="left" class="col-sm-4"><strong>Date</strong></div>

           <div  class="col-lg-2  col-sm-2 col-md-2 col-xs-4" style="min-width:10em">
            <input name="dc" class="form-control" id="dc" value="<?=$vAwal?>" size="10" />
            </div>

            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"><strong>To</strong></div>
		<div  class="col-lg-2  col-sm-2 col-md-2 col-xs-4" style="min-width:10em">
        <input class="form-control" name="dc1" id="dc1" size="10" value="<?=$vAkhir?>" />
        </div>
</div>
   <div class="row">

		<div  class="col-lg-2  col-sm-2 col-md-2 col-xs-4">

            <input name="Submit22" type="button" class="btn btn-success" onclick="MM_callJS('doSubmit(\'cari\')')" value="   Refresh   "  /> </div>
            </div>
<br>
       
          
</div> 
</div>
          
          

         

          

          

          <table width="100%" border="0">

  <tr>

    <td><div align="left"><strong>Page

      <select name="select3" id="select3" onchange="changePage(this)">

              <? for ($i=0;$i<$pagenum;$i++) {?>

              <option value="<?=$i+1 ?>" <? if ($curpage==($i)) echo "selected";?>>&nbsp;

              <?=$i+1?>

                &nbsp;</option>

              <? } ?>

            </select>

    </strong></div></td>

    <td><div align="right"><strong>Page

          <select name="select" id="select2" onchange="changePage(this)">

            <? for ($i=0;$i<$pagenum;$i++) {?>

            <option value="<?=$i+1 ?>" <? if ($curpage==($i)) echo "selected";?>>&nbsp;

            <?=$i+1?>

  &nbsp;</option>

            <? } ?>

          </select>

    </strong></div></td>

  </tr>

</table>



          </strong></p>

          <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" class="table" style="margin-left:5.15pt;border-collapse:collapse;">

            <tr style="height:12.75pt;">

              <td width="36" nowrap="nowrap" valign="bottom" style="border:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt;"><strong><span style="font-family:Arial; font-size:10.0pt; ">ID Pembelian </span></strong></td>

              <td width="72" nowrap="nowrap" valign="bottom" style="border:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt;"><strong><span style="font-family:Arial; font-size:10.0pt; ">ID Penjual</span></strong></td>

              <td width="78" nowrap="nowrap" valign="bottom" style="border:none;border-top:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt;"><p align="center" class="MsoNormal" style="text-align:center;"><strong><span style="font-family:Arial; font-size:10.0pt; ">Nama Penjual</span></strong></p></td>

              <td width="72" nowrap="nowrap" valign="bottom" style="border:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt;"><span style="font-family:Arial; font-size:10.0pt; "><strong>

                ID Pembeli</strong></span></td>

              <td width="72" nowrap="nowrap" valign="bottom" style="border:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt;"><strong>

                Jns Order</strong></td>

              

              <td width="196" nowrap="nowrap" valign="bottom" style="border:none;border-top:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt;"><p align="center" class="MsoNormal" style="text-align:center;"><strong><span style="font-family:Arial; font-size:10.0pt; ">Product &amp; Qty</span></strong></p></td>

              <td width="70" nowrap="nowrap" valign="bottom" style="border:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt;"><p align="center" class="MsoNormal" style="text-align:center;"><strong><span style="font-family:Arial; font-size:10.0pt; ">Total Harga</span> </strong></p></td>

              </tr>

			

			<?

			   $vsql="SELECT fidpenjualan,fidmember,ftanggal,fjenis,fprocessed,SUM(fsubtotal) AS subtotal  FROM tb_trxstok_member WHERE fidproduk not like 'KIT%' $vAnd";

			   $vsql.="	GROUP BY fidpenjualan,ftanggal,fidmember,fjenis,fprocessed ORDER BY fidpenjualan DESC";

			   $vsql.=" limit  $offset, $rowpage ";

			   $db->query($vsql);

			   $vNo=0;$vTotHarga=0;$vTotHargaV=0;

			   while ($db->next_record()) {

			     $vNo+=1;

				 $vIDJual=$db->f("fidpenjualan");

				 $vTgl=$db->f("ftanggal");

				 $vUserID=$db->f("fidmember");

				 $vHP=$oMember->getNoHP($vUserID);

				 

				 $vSubtotal=$db->f("subtotal");

				 $vProcessed=$db->f("fprocessed");

				 $vTotHarga+=$vSubtotal;

				 if ($vProcessed==2)

				    $vTotHargaV+=$vSubtotal;

				$vNoStockist = 	$db->f("fnostockist");

			?>

			

            <tr style="height:12.75pt;" <? if(($vNo % 2)==1) echo "bgcolor='#FFFFF3'"; else echo "bgcolor='#CCCCFF'"; ?>>

              <td width="36" valign="middle" nowrap="nowrap" style="width:32.0pt;border:solid windowtext 1.0pt;border-top:none;padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt;"><div align="left"><span style="font-family:Verdana; font-size:10px">

                <?=$vIDJual?>

              </span></div></td>

              <td width="72" nowrap="nowrap" valign="middle" style="width:32.0pt;border:solid windowtext 1.0pt;border-top:none;padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt;"><span style="font-family:Verdana; font-size:10px">

                <?

				  $vIDSeller=$oJual->getSeller($vIDJual);

				  if ($vIDSeller=="0") $vIDSeller="Admin";

				  echo $vIDSeller;

				 // if ($vNoStockist != "")

				 // echo " Stockist $vNoStockist";

				  

				?>

              </span></td>

              <td width="78" nowrap="nowrap" valign="middle" style="width:42.0pt;border:none;border-bottom:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt;"><p align="left" class="MsoNormal style4"><span style="font-family:Verdana;font-size:10px">

                <?=$oMember->getMemberName($vUserID)?>

              </span></p></td>

              <td width="72" nowrap="nowrap" valign="middle" style="width:32.0pt;border:solid windowtext 1.0pt;border-top:none;padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt;"><span style="font-family:Verdana; font-size:10px;">

                <?=$vUserID?>

              </span></td>

              <td width="72" nowrap="nowrap" valign="middle" style="width:32.0pt;border:solid windowtext 1.0pt;border-top:none;padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt;"><?=$db->f("fjenis");?></td>

             

			 <td width="186" nowrap="nowrap" valign="middle" style="width:58.8pt;border:none;border-bottom:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt;"><p align="left" class="MsoNormal style4"><span style="font-family:Verdana; font-size:10px;"><span style="font-family:Arial;">

			   <?=$oJual->dispDetBuyed($vIDJual)?>

			   </span></p></td>

              <td width="86" nowrap="nowrap" valign="middle" style="width:32.0pt;border:solid windowtext 1.0pt;border-top:none;padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt;"><p align="right" class="MsoNormal style4"><span style="font-family:Verdana;font-size:10px"><?=number_format($vSubtotal,0,",",".")?></span></p></td>

              </tr>

			

			<? } ?>

            <tr style="height:12.75pt;">

              <td nowrap="nowrap" colspan="6" valign="bottom" style="width:362.0pt;border-top:none;border-left:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;border-right:none;padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt;"><div align="left"><strong><span style="font-family:Arial; font-size:10.0pt; ">Total RO (halaman ini - Verified) </span></strong></div></td>

              <td nowrap="nowrap" valign="bottom" style="width:32.0pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;border-left:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt;"><div align="right"><strong><span style="font-family:Verdana;font-size:10px">

                <?=number_format($vTotHargaV,0,",",".")?>

              </span></strong></div></td>

              </tr>

            <tr style="height:12.75pt;display:none">

              <td nowrap="nowrap" colspan="6" valign="bottom" style="width:362.0pt;border-top:none;border-left:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;border-right:none;padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt;"><div align="left"><strong><span style="font-family:Arial; font-size:10.0pt; ">Total RO (halaman ini - All) </span></strong></div></td>

              <td nowrap="nowrap" valign="bottom" style="width:32.0pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;border-left:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt;"><div align="right"><strong><span style="font-family:Verdana;font-size:10px">

                <?=number_format($vTotHarga,0,",",".")?>

              </span></strong></div></td>

              </tr>

            <tr style="height:12.75pt;">

              <td nowrap="nowrap" colspan="6" valign="bottom" style="width:362.0pt;border-top:none;border-left:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;border-right:none;padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt;"><div align="left"><span class="MsoNormal" style="text-align:left;"><strong><span style="font-family:Arial; font-size:10.0pt; ">Total RO (Verified) </span></strong></span></div></td>

              <td nowrap="nowrap" valign="bottom" style="width:32.0pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;border-left:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt;"><div align="right"><strong><span style="font-family:Verdana;font-size:10px">

                <?=number_format($oJual->getBuyedByStatus(2,$vAwal,$vAkhir),0,",",".")?>

              </span></strong></div></td>

              </tr>

            <tr style="height:12.75pt;">

              <td nowrap="nowrap" colspan="6" valign="bottom" style="width:362.0pt;border-top:none;border-left:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;border-right:none;padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt;"><p align="justify" class="MsoNormal" style="text-align:left;"><strong><span style="font-family:Arial; font-size:10.0pt; ">Total RO (All) </span></strong></p></td>

              <td width="86" nowrap="nowrap" valign="bottom" style="width:32.0pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;border-left:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt;"><p align="right" class="MsoNormal"><strong><span style="font-family:Verdana;font-size:10px">

                <?=number_format($oJual->getBuyedByStatus(0,$vAwal,$vAkhir),0,",",".")?>

              </span></strong></p></td>

              </tr>

          </table>

	      <p><strong>

          <input name="ref" type="hidden" id="ref" />

          <br />

	      </strong>

	      <table width="100%" border="0">

            <tr>

              <td><div align="left"><strong>Page

                <select name="select4" id="select4" onchange="changePage(this)">

                        <? for ($i=0;$i<$pagenum;$i++) {?>

                        <option value="<?=$i+1 ?>" <? if ($curpage==($i)) echo "selected";?>>&nbsp;

                        <?=$i+1?>

                          &nbsp;</option>

                        <? } ?>

                </select>

              </strong></div></td>

              <td><div align="right"><strong>Page 

                <select name="select2" id="select" onchange="changePage(this)">

                      <? for ($i=0;$i<$pagenum;$i++) {?>

                      <option value="<?=$i+1 ?>" <? if ($curpage==($i)) echo "selected";?>>&nbsp;

                      <?=$i+1?>

  &nbsp;</option>

                      <? } ?>

                </select>

              </strong></div></td>

            </tr>

          </table>

	      <p align="right">&nbsp;</p>

        </form>

      <p align="center">&nbsp;</p>

      <p><br>      

      </p>

      <p>&nbsp;</p>

      <p>

        <input style="display:none" name="btnBukti" type="button"  id="btnBukti" onClick="MM_goToURL('parent','loggedin.php?menu=showbukti&uUser=<?=base64_encode($vUser)?>');return document.MM_returnValue" value="Lihat Bukti Pembayaran">      

        <br>

      </p>

      <blockquote>

        <div align="left"></div>

    </blockquote>     <!-- page end-->

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

