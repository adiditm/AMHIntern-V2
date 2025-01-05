<? 
	       if ($_GET['op'] == '') 
           include_once("../framework/admin_headside.blade.php");
        else
           include_once("../framework/member_headside.blade.php") ; 
		   
  define("MENU_ID", "mdm_jual_verifikasi");   
  $vRefUser=$_GET['uMemberId'];
  if (isset($vRefUser))
  	 $vUser=$vRefUser;
  else	 
  	 $vUser=$_SESSION['LoginUser'];
 // $vDeep=$oRules->getRealMaxLevel(1);
 // $vCoup=$oRules->getSettingByField("ffeecouple",1);
 // $vSponsor=$oRules->getSponFee(1);
  if ($vTanggal=="")
     $vTanggal=$oPhpdate->getNowYMD("-");  
  $vAwal=$_POST['dc'];
  $vAkhir=$_POST['dc1'];
  if ($vAwal=="") 
     $vAwal=$oMydate->dateSub(date("Y-m-d"),30,"day");
  if ($vAkhir=="") 
  	 $vAkhir=date("Y-m-d"); 
	 //FIlter

   $ref=$_REQUEST['ref'];


	$vIDJual=$_POST['tfIDJual']; 
	$vID=$_POST['tfID'];
	$vAnd="";
	if ($vID!="") $vAnd.=" and fidmember = '$vID' ";
	if ($vIDJual!="")  $vAnd.=" and fidtrans like '%$vIDJual%' "; 
	$vAnd.=" and date(ftglupdate) between date('$vAwal') and date('$vAkhir')";
	//$vAnd.=" and fstatusrow !=4 ";
	
    $vsql="SELECT *  FROM tb_baltrans WHERE 1  $vAnd ";
    $vsql.="ORDER BY fidtrans DESC";
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
<link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />
<link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />
<link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />
<link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
<link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />
<script language="JavaScript" type="text/JavaScript">

$(document).ready(function(){

    $('#caption').html('Verifikasi & Approval Withdraw');





      $('#dc').datepicker({

                    format: "yyyy-mm-dd",

                    autoclose : true

    }); 

  

  

       $('#dc1').datepicker({

                    format: "yyyy-mm-dd",

                    autoclose : true

    }); 



});

<!--
<!--

//-->

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
   vSure=confirm('Apakah Anda yakin memproses transfer saldo ini?');
   if (vSure==true) {
	     window.location=pURL+'&ref=transfer';
   } 
}

function doCancel(pURL) {
   vSure=confirm('Apakah Anda yakin membatalkan transfer saldo ini?');
   if (vSure==true) {
	     window.location=pURL;
   } 
}




function doDetail(pID){
	doShow(400,600,'wDet','dettrans.php?uID='+pID);
}
</script>
<style type="text/css">
<!--
.style3 {
	font-size: 12px;
	font-weight: bold;
}
.style4 {
	font-size: 10px
}
.style5 {
	color: #FF0000;
	font-weight: bold;
	font-family: Tahoma;
}
-->
</style>

<div class="right_col" role="main">
  <label> </label>
  <h3>Approval Transfer Saldo</h3>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableRow">
    <!--DWLayoutTable-->
    
    <tr>
      <td height="5" align="center" valign="middle"><hr></td>
    </tr>
    <tr>
      <td height="5" align="center" valign="top"><form id="demoform" name="demoform" method="post" action="" >
        <input name="hPageNum" type="hidden" id="hPageNum">
        <input name="hPage" type="hidden" id="hPage" value="<?=$curpage?>">
        <input name="hBtn" type="hidden" id="hBtn">
        <input name="ref" type="hidden" id="ref" >
        <!--DWLayoutTable-->
        <tr>
            <td height="5" align="left" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="3"><br />
              </font></strong></font>
        <form id="demoform" name="demoform" method="post" action="" >
          <input name="hPageNum" type="hidden" id="hPageNum">
          <input name="hPage" type="hidden" id="hPage" value="<?=$curpage?>">
          <input name="hBtn" type="hidden" id="hBtn">
          <input name="ref" type="hidden" id="ref" >
          <div align="left" >
            <table border="0" cellpadding="2" cellspacing="0"  >
              <tr>
                <td colspan="3" ><label>Filter</label></td>
              </tr>
              <tr>
                <td width="33%" height="25" > Member ID
                  <div align="left"></div></td>
                <td width="2%" height="25">:</td>
                <td width="65%" height="25" ><input name="tfID" type="text" class="form-control" id="tfID" value="<?=$vID?>" /></td>
              </tr>
              <tr>
                <td height="25" >ID Transfer </td>
                <td height="25" >:</td>
                <td height="25" ><input name="tfIDJual" type="text" class="form-control" id="tfIDJual" value="<?=$vIDJual?>" /></td>
              </tr>
            </table>
            <hr />
          </div>
          <font face="Verdana, Arial, Helvetica, sans-serif"><strong><br />
          Mulai Tanggal : </strong>
          <input name="dc" id="dc" value="<?=$vAwal?>" size="20" />
          &nbsp; <strong>s/d</strong>
          <input  name="dc1" id="dc1" size="20" value="<?=$vAkhir?>" />
          &nbsp;&nbsp;
          <input name="Submit22" type="button" class="btn btn-success btn-sm" onclick="MM_callJS('doSubmit(\'cari\')')" value="   Lihat   "  />
          </font> <br />
          <strong><br />
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
                  </strong> <span class="style5">Warna gelap : Transfer dibatalkan</span> </div></td>
              <td><div align="right"><strong>Page
                  <select name="select" id="select2" onchange="changePage(this)">
                    <? for ($i=0;$i<$pagenum;$i++) {?>
                    <option value="<?=$i+1 ?>" <? if ($curpage==($i)) echo 'selected';?>>&nbsp;
                    <?=$i+1?>
                    &nbsp;</option>
                    <? } ?>
                  </select>
                  </strong></div></td>
            </tr>
          </table>
          </strong>
          </p>
          <div class="table-responsive">
         <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
            <tr>
              <td width="50" nowrap="nowrap" valign="bottom"><p align="center" style="text-align:center;"><strong><span style="font-family:Arial; font-size:10.0pt; ">No</span></strong></p></td>
              <td width="67" nowrap="nowrap" valign="bottom"><p align="center" style="text-align:center;"><strong><span style="font-family:Arial; font-size:10.0pt; ">Tgl</span></strong></p></td>
              <td width="144" nowrap="nowrap" valign="bottom"><strong><span style="font-family:Arial; font-size:10.0pt; ">ID Transfer </span></strong></td>
              <td width="85" nowrap="nowrap" valign="bottom"><span style="font-family:Arial; font-size:10.0pt; "><strong>ID Member Pengirim</strong></span></td>
              <td width="136" nowrap="nowrap" valign="bottom"><strong>ID Member Penerima</strong></td>
              <td width="94" nowrap="nowrap" valign="bottom"><p align="center" style="text-align:center;"><strong><span style="font-family:Arial; font-size:10.0pt; ">Total Transfer</span> </strong></p></td>
              <td width="94" nowrap="nowrap" valign="bottom"><strong><span style="font-family:Arial; font-size:10.0pt;">Keterangan</span></strong></td>
              <td width="94" nowrap="nowrap" valign="bottom"><strong><span style="font-family:Arial; font-size:10.0pt;">Status</span></strong></td>
              <td width="79" nowrap="nowrap" valign="bottom"><p align="center" style="text-align:center;"><strong><span style="font-family:Arial; font-size:10.0pt; "> Action</span></strong></p></td>
            </tr>
            <?
			   $vsql="SELECT * FROM tb_baltrans WHERE 1 $vAnd ";
			   $vsql.="ORDER BY ftglupdate desc,fidtrans DESC ";
			   $vsql.="limit  $offset, $rowpage ";
			   $db->query($vsql);
			   $vNo=0;$vTotHarga=0;$vTotHargaV=0;
			   while ($db->next_record()) {
			     $vNo+=1;
				 $vIDJual=$db->f("fidtrans");
				 $vTgl=$db->f("ftglupdate");
				 $vUserIDFrom=$db->f("fidmember");
				 $vUserIDTo=$db->f("fidto");
				 $vSubtotal=$db->f("fnominal");
				 $vProcessed=$db->f("fstatusrow");
				 $vKet=$db->f("fket");

				 $vTotHarga+=$vSubtotal;
				 if ($vProcessed==2) {
				    $vTotHargaV+=$vSubtotal;
					$vStatusText ="Approved";
				 } else if($vProcessed==0) {
					$vStatusText ="Pending"; 
				 } else if($vProcessed==4) {
					$vStatusText ="Cancelled"; 
				 }
			?>
            <tr " <? if ($vProcessed==4) echo "bgcolor='#666666'"; else if(($vNo % 2)==1) echo "bgcolor='#FFFFF3'"; else echo "bgcolor='#CCCCFF'"; ?>>
              <td width="50" height="19" valign="middle" nowrap="nowrap">&nbsp;</td>
              <td width="67" valign="middle" nowrap="nowrap"><div align="left"><span style="font-family:Verdana; font-size:10px">
                  <?=$oPhpdate->YMD2DMY($vTgl,"-")?>
                  </span></div></td>
              <td width="144" valign="middle" nowrap="nowrap"><div align="left"><span style="font-family:Verdana; font-size:10px">
                  <?=$vIDJual?>
                  </span></div></td>
              <td width="85" nowrap="nowrap" valign="middle"><div align="left"><span style="font-family:Verdana; font-size:10px;">
                  <?=$vUserIDFrom?>
                  (
                  <?=$oMember->getMemberName($vUserIDFrom)?>
                  ) </span></div></td>
              <td width="136"  valign="middle"><p align="left" class="MsoNormal style4"><span style="font-family:Verdana;font-size:10px">
                  <?=$vUserIDTo?>
                  (
                  <?=$oMember->getMemberName($vUserIDTo)?>
                  ) </span></p></td>
              <td width="94" nowrap="nowrap" valign="middle">&nbsp;</td>
              <td width="94" valign="middle"><span style="font-family:Verdana; font-size:10px;">
                <?=$vKet?>
                </span></td>
              <td width="94" valign="middle"><span style="font-family:Verdana; font-size:10px;">
                <?=$vStatusText?>
                </span></td>
              <td width="79" nowrap="nowrap" valign="middle"><p class="MsoNormal style4">
                  <input type="button" name="Button" onClick="doProcess('processtrans.php?payfor=trans&uIDJual=<?=$vIDJual?>&from=<?=$vUserIDFrom?>&to=<?=$vUserIDTo?>&nom=<?=$vSubtotal?>&ket=<?=$vKet?>&uSess=<?=md5('jalanku')?>&uUserID=<?=$vUserID?>');" value="Process" <? if ($vProcessed==2 || $vProcessed==4) echo "disabled";?> />
                  <input type="button" name="Button2" onclick="doCancel('processtrans.php?payfor=trans&uIDJual=<?=$vIDJual?>&uSess=<?=md5('jalanku')?>&uCanc=<?=md5('bataldeh')?>&uUserID=<?=$vUserID?>');" value="Cancel" <? if ($vProcessed==2 || $vProcessed==4) echo "disabled";?> />
                  <input style="display:none" name="btnDetail" type="button" id="btnDetail" onclick="doDetail('<?=$vIDJual?>');" value="Detail"  />
                </p></td>
            </tr>
            <? } ?>
            <tr>
              <td nowrap="nowrap" colspan="5" valign="bottom"><div align="left"><strong><span style="font-family:Arial; font-size:10.0pt; ">Total Transfer (halaman ini - Verified) </span></strong></div></td>
              <td nowrap="nowrap" valign="bottom"><div align="right"><strong><span style="font-family:Verdana;font-size:10px">
                  <?=number_format($vTotHargaV,0,",",".")?>
                  </span></strong></div></td>
              <td rowspan="4" valign="bottom" nowrap="nowrap">&nbsp;</td>
              <td rowspan="4" valign="bottom" nowrap="nowrap">&nbsp;</td>
              <td nowrap="nowrap" valign="bottom">&nbsp;</td>
            </tr>
            <tr>
              <td nowrap="nowrap" colspan="5" valign="bottom"><div align="left"><strong><span style="font-family:Arial; font-size:10.0pt; ">Total Transfer (halaman ini - All) </span></strong></div></td>
              <td nowrap="nowrap" valign="bottom"><div align="right"><strong><span style="font-family:Verdana;font-size:10px">
                  <?=number_format($vTotHarga,0,",",".")?>
                  </span></strong></div></td>
              <td nowrap="nowrap" valign="bottom">&nbsp;</td>
            </tr>
            <tr>
              <td nowrap="nowrap" colspan="5" valign="bottom"><div align="left"><span style="text-align:left;"><strong><span style="font-family:Arial; font-size:10.0pt; ">Total Transfer (Verified) </span></strong></span></div></td>
              <td nowrap="nowrap" valign="bottom"><div align="right"><strong><span style="font-family:Verdana;font-size:10px">
                  <?=number_format($oJual->getTransByStatus(2,$vAwal,$vAkhir),0,",",".")?>
                  </span></strong></div></td>
              <td nowrap="nowrap" valign="bottom">&nbsp;</td>
            </tr>
            <tr>
              <td nowrap="nowrap" colspan="5" valign="bottom"><p align="justify" style="text-align:left;"><strong><span style="font-family:Arial; font-size:10.0pt; ">Total Transfer (All) </span></strong></p></td>
              <td width="94" nowrap="nowrap" valign="bottom"><p align="right"><strong><span style="font-family:Verdana;font-size:10px">
                  <?=number_format($oJual->getTransByStatus(0,$vAwal,$vAkhir),0,",",".")?>
                  </span></strong></p></td>
              <td width="79" nowrap="nowrap" valign="bottom">&nbsp;</td>
            </tr>
          </table>
          </div>

          <input name="ref" type="hidden" id="ref" />
 
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
                  </strong><span class="style5">Warna gelap : Transfer dibatalkan</span></div></td>
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
        </form></td>
    </tr>
  </table>
  <!-- page end-->
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
