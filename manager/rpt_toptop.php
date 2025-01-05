<? include_once("../framework/masterheader.php")?>
<?php
define("MENU_ID", "mdm_member_aktif_detail");   
$vFall=$_GET['fallback'];
 if (!$oSystem->checkPriv($vUser,MENU_ID)) { ;
    //  $oSystem->jsAlert("Not Authorized!");
    //  $oSystem->jsLocation("../main/logout.php");
 }
$vOP=$_POST['hOP'];
$vSpy=md5('spy');
$vID=$_POST['tfID'];
$vNama=$_POST['tfNama'];
$vNoHP=$_POST['tfNoHP'];
$vKota=$_POST['tfKota'];
$vAktif=$_POST['lmAktif'];
$vSort=$_POST['lmSort'];
if ($vSort=="") $vSort=$_GET['lmSort'];
if ($vSort=="") $vSort=1;

if ($vAktif=="") $vAktif=$_GET['lmAktif'];
$vPrem=$_POST['lmMship'];
if ($vPrem=="") $vPrem=$_GET['lmMship'];
$vStockist=$_POST['lmStockist'];

if ($vSort=="1")
   $vOrder=" fspon ";
if ($vSort=="2")
   $vOrder=" fidmember ";
if ($vSort=="3")
   $vOrder=" fnama ";
    

if ($vNama!="")
   $vCrit.=" and fnama like '%$vNama%' ";


if ($vAktif==2)
   $vCrit.=" and faktif = 0";
else if ($vAktif==1)   
   $vCrit.=" and faktif = 1";

if ($vPrem!="-" && $vPrem!="")
   $vCrit.=" and fpaket = '$vPrem' ";

 

$vPage=$_GET['uPage'];
$vBatasBaris=25;
if ($vPage=="")
 	$vPage=0;
$vStartLimit=$vPage * $vBatasBaris;	

$vsql="select b.fidmember,b.fnama, a.fspon from (select fsponsor,count(fdownline) as fspon from tb_updown where fsponsor <> -1 group by fsponsor) as a left join m_anggota b on a.fsponsor=b.fidmember where 1 ";
$vsql.=$vCrit;
$vsql.=" order by $vOrder ";
//echo "<br><br><br>".$vsql;
$db->query($vsql);
$db->next_record();
$vRecordCount=$db->num_rows();
$vPageCount=ceil($vRecordCount/$vBatasBaris);



$from="Uneeds <info@uneeds-style>";
?>


<script language="JavaScript" type="text/JavaScript">
$(document).ready(function(){
    $('#caption').html('Report Top Of The Top');

});
<!--
function MM_goToURL() { //v3.0

  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  if (getValue()=="") {
      alert('Pilih salah satu member melalui Radio Button di kolom paling kanan, kemudian klik tombol ini kembali!');
	  return false;
  }	  
  for (i=0; i<(args.length-1); i+=2) 
      eval(args[i]+".location='"+args[i+1]+"'");
  
}

function doActivate(pURL,pOP) {
   var vMess='';
   if (pOP=='act') vMess='Apakah Anda yakin mengaktifkan member ini?';
   else if (pOP=='trial') vMess='Apakah Anda yakin mengaktifkan member ini untuk trial?';
   else if(pOP=='stop') vMess='Apakah Anda yakin stop member ini untuk trial?';
   else vMess='Apakah Anda yakin menghapus member ini?';
   vSure=confirm(vMess);
   if (vSure==true) {
	     window.location=pURL+"&uStockist=0";
   } 
}

function doDeActivate(pURL) {
   vSure=confirm('Apakah Anda yakin me-non-aktifkan member ini?');
   if (vSure==true) {
	     window.location=pURL+"&uOP=0";
   } 
}


function getValue(){
   vLength=document.memberForm.rbSelected.length;   
   for (i=0;i<vLength;i++) {
      if (document.memberForm.rbSelected[i].checked) {
	     return document.memberForm.rbSelected[i].value; 
	  } 
   } 
      if (document.memberForm.rbSelected.value)
	     return document.memberForm.rbSelected.value;
	  else return '(Anda belum memilih member)';	 
}

function checkStatus(pStatus,pStockist) {
/*
   if (pStatus!='1') {
      document.getElementById('btKomisi').disabled=true;
	  if (document.getElementById('btX'))
	  document.getElementById('btX').disabled=true;
      if (document.getElementById('btJar'))
	  document.getElementById('btJar').disabled=true;
	  if (document.getElementById('btTTK'))
	  document.getElementById('btTTK').disabled=true;
      if (document.getElementById('btGen'))
	  document.getElementById('btGen').disabled=true;
	  if (document.getElementById('btGG'))
	  document.getElementById('btGG').disabled=true;
	  document.getElementById('btBH').disabled=true;
	  document.getElementById('btGS').disabled=true;
	  document.getElementById('btTitik').disabled=true;
	  document.getElementById('btBH2').disabled=true;
	  document.getElementById('btGS2').disabled=true;
	  document.getElementById('btTitik2').disabled=true;
	  document.getElementById('btMutasi').disabled=true;
	  document.getElementById('btButuan').disabled=true;
   } else {
      document.getElementById('btKomisi').disabled=false;
	  if (document.getElementById('btX'))	  
	  document.getElementById('btX').disabled=false;
      document.getElementById('btJar').disabled=false;
	  document.getElementById('btTTK').disabled=false;
      document.getElementById('btGen').disabled=false;
	  document.getElementById('btGG').disabled=false;
	  document.getElementById('btBH').disabled=false;
	  document.getElementById('btGS').disabled=false;
	  document.getElementById('btTitik').disabled=false;
	  document.getElementById('btBH2').disabled=false;
	  document.getElementById('btGS2').disabled=false;
	  document.getElementById('btTitik2').disabled=false;
	  document.getElementById('btButuan').disabled=false;
	  document.getElementById('btMutasi').disabled=false;

   }
   */
   
}

//-->
</script>
	<link rel="stylesheet" href="../css/screen.css">

	
	
 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />

<style type="text/css">
<!--
.style1 {color:#666666}
.style2 {
	color: #000000;
	font-weight: bold;
}
-->


@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

	/* Force table to not be like tables anymore */
	table, thead, tbody, th, td, tr { 
		display: block; 
	}
	
	/* Hide table headers (but not display: none;, for accessibility) */
	thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
	
	tr { border: 1px solid #ccc; }
	
	td { 
		/* Behave  like a "row" */
		border: none;
		border-bottom: 1px solid #eee; 
		position: relative;
		padding-left: 50%; 
	}
	
	td:before { 
		/* Now like a table header */
		position: absolute;
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;
	}

</style>
<section>
    <!-- left side start-->
   <? include "../framework/leftadmin.php"; ?>
    <!-- main content start-->
    <div class="main-content" >

   <? include "../framework/headeradmin.php"; ?>
           <!--body wrapper start-->
 <section class="wrapper">

<div align="center" class="table-responsive"> 
      
       		<form method="post" >
       		<div style="border:1px solid grey;padding: 4px 4px 4px 4px" style="width:85%">
		  <table border="0" cellpadding="4" cellspacing="0"  style="width:450px;border:0px solid silver;padding:6px 6px 6px 6px"  >
            <tr>
              <td colspan="2" ><div align="center"><font size="3"><strong>Filter</strong></font></div></td>
            </tr>
            <tr>
              <td width="35%" height="25" ><div align="left">Member ID </div></td>
              <td height="25" style="width: 62%"><div align="left">
                  <input name="tfID" type="text" class="form-control" id="tfID" value="<?=$vID?>" />
                  <input name="hOP" type="hidden" id="hOP" value="post" />
              </div></td>
            </tr>
            <tr>
              <td height="25"><div align="left">Nama</div></td>
              <td height="25" style="width: 62%"><div align="left">
                  <input name="tfNama" type="text" class="form-control" id="tfNama" value="<?=$vNama?>" />
              </div></td>
            </tr>

            <tr  >
              <td height="25"><div align="left">Sponsor Paket</div></td>
              <td height="25" style="width: 62%"><div align="left">
                <select name="lmMship" class="form-control" id="lmMship">
                  <option value="-" selected="selected">Semua</option>
                  <option value="E" <? if ($vPrem=="E") echo "selected"?>>Economy</option>
                  <option value="B" <? if ($vPrem=="B") echo "selected"?>>Business</option>
				  <option value="F" <? if ($vPrem=="F") echo "selected"?>>First</option>
                </select>
              </div></td>
            </tr>
            <tr >
              <td style="height: 25px"><div align="left">Sorting</div></td>
              <td style="height: 25px; width: 62%;"><div align="left">
                <select name="lmSort" class="form-control" id="lmSort">
                  <option value="1" <? if ($vSort=="1") echo "selected";?>>Tgl Daftar</option>
                  <option value="2" <? if ($vSort=="2") echo "selected";?>>User ID / Kd Anggota</option>
                  <option value="3" <? if ($vSort=="3") echo "selected";?>>Nama</option>
                </select>
              </div></td>
            </tr>
            <tr>
              <td colspan="2"><div align="center"><br>
                  <input name="Submit" type="submit" class="btn btn-primary" value="Cari" />
                &nbsp; &nbsp;
                <input name="Submit2" type="reset" class="btn btn-default" value="Reset" />
              </div></td>
            </tr>
          </table>
          </div>

  
</form>
<form name="memberForm">
    &nbsp; 
    <div align="left">
           <br><br>
      
          <input alt="Detail & Edit Member" name="btDetail" type="button" class="btn btn-success btn-sm" id="btDetail2" onClick="MM_goToURL('parent','../memstock/profile.php?op=<?=$vSpy?>'+CryptoJS.MD5(getValue())+'&uMemberId='+getValue());return document.MM_returnValue" value="Detail &raquo;" onMouseover="showhint('Lihat detail /  Edit Member '+getValue(), this, event, '220px')">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <br>  
          <br>
      
      </div>
      <div class="table-responsive" >
    <table width="70%" border="0" align="center" cellpadding="1" cellspacing="0" class="table" >
      <tr style="color:#85d7ca;font-weight:bold"> 
        <td  height="26" style="width: 30px"> No.</td>
        <td  height="26" style="width: 30px"> <div align="center" >Distributor ID </div></td>
        <td width="142"><div align="center" >Distributor Name 
        </div></td>
        <td width="138"><div align="center" >Sponsorship Count 
          </div></td>
        <td width="27"><div align="center" >&radic;</div></td>

        
      </tr>
      <?
		  if ($vOP=="post") $vStartLimit=0;
		  $vsql="select b.fidmember,b.fnama, a.fspon from (select fsponsor,count(fdownline) as fspon from tb_updown where fsponsor <> -1 group by fsponsor) as a left join m_anggota b on a.fsponsor=b.fidmember where 1";
		  $vsql.=$vCrit;
		  $vsql.=" order by $vOrder ";
		$vsql.="limit $vStartLimit ,$vBatasBaris ";
			
		  $db->query($vsql);
		  $vNumRows=$db->num_rows();
		  $vHari=$oRules->getSettingByField("fbyyprint");
		  $vNo=0;
		  while ($db->next_record()) {
		     $vNo++;
		     $vAktifList=$db->f('faktif'); 
			 $vTrial=$db->f('fisfree');
			 $vIDSys=$db->f('fidsys');
			 

			  $vTglAktif=$oPhpdate->DMY2YMD($oPhpdate->YMD2DMY($db->f('ftglaktif')));
			     $vSaldo=$db->f('fsaldovcr');
		?>
      <tr style="<? if ($oMember->isStockist($db->f('fidmember'))==1) echo "background-color:#880000;color:#fff"; ?>"  > 
        <td style="color:<? if ($oMember->isStockist($db->f('fidmember'))==1) echo 'lime'; else echo 'grey';?>; width: 30px;" onmouseover="showhint('<?=$vMess?>', this, event, '150px')">
        <?=$vNo?></td>
        <td style="color:<? if ($oMember->isStockist($db->f('fidmember'))==1) echo 'lime'; else echo 'grey';?>; width: 30px;" onmouseover="showhint('<?=$vMess?>', this, event, '150px')">
        <a name="<?=$db->f('fidmember')?>"></a>
        <div align="left"><span  >
          <?=$db->f('fidmember')?>
          <? if ($vTrial=='1' && $vAktifList=='1') { ?>
          <br>
          Trial s/d <?=$oPhpdate->YMD2DMY($oMydate->dateAdd($vTglAktif,$vHari,"day")) ?>
          <? } ?>
           <? if ($oMember->isStockist($db->f('fidmember'))==1) echo "<br> St. ID: ".$db->f('fidstockist');?>
          </span></div></td>
        <td style="height: 39px"><div align="left"><span >
          <?=$db->f('fnama')?>
          <br>
          </span></div></td>
        <td width="138" style="height: 39px" align="right">          <div align="left"><span >
          <?=number_format($db->f('fspon'),0,",",".")?>
          <br>
          </span></div></td>
          <td  style="height: 39px" <? if($vFall==$db->f('fidmember')) echo "bgcolor=#0f0";?>><span >
          <input class="form-control" id="rbSelected" style="width:20px;height:20px" name="rbSelected" type="radio" value="<?=$db->f('fidmember')?>" onClick="checkStatus('<?=$db->f('faktif')?>','<?=$db->f('fstockist')?>')" >
          </span></td>

      </tr>
        <? 
          }
          if ($vNumRows <= 0) {
         // while $db->next_record?>
        <tr><td>&nbsp;</td><td colspan="3">Tidak ada distibutor ulang tahun tanggal <?=$vTglLahir?>-<?=$vBlnLahir?></td></tr>
        <? } ?>
      </table>
</div>
    </form>
      <div align="center">
            <p align="left" style="display:none"><span >
			  <input alt="Detail & Edit Member" name="btDetail2" type="button" class="btn btn-primary" id="btDetail2" onClick="MM_goToURL('parent','admin.php?menu=changeprofil&uMemberId='+getValue());return document.MM_returnValue" value="Detail" onMouseover="showhint('Lihat detail /  Edit Member '+getValue(), this, event, '220px')">
			  <input name="btKomisi2" type="button" class="btn btn-default" id="btKomisi2" onClick="MM_goToURL('parent','admin.php?menu=stkomisi&uMemberId='+getValue());return document.MM_returnValue" value="Komisi" onMouseover="showhint('Lihat Komisi Member '+getValue(), this, event, '190px')">
              <input name="btJar2" type="button" class="vsmallbutton" id="btJar2" onClick="MM_goToURL('parent','admin.php?menu=stjaringan&uMemberId='+getValue());return document.MM_returnValue" value="Net/Sponsor" onMouseover="showhint('Lihat Status Network & Sponsor Member '+getValue(), this, event, '190px')">
              <input name="btGen2" type="button" class="vsmallbutton" id="btGen2" onClick="MM_goToURL('parent','admin.php?menu=genealogi&uMemberId='+getValue());return document.MM_returnValue" value="Geneologi" onMouseover="showhint('Lihat Genealogi Member '+getValue(), this, event, '210px')">
            </span></p>
        <p align="left">      
          <input alt="Detail & Edit Member" name="btDetail2" type="button" class="btn btn-success btn-sm" id="btDetail2" onClick="MM_goToURL('parent','../memstock/profile.php?op=<?=$vSpy?>'+CryptoJS.MD5(getValue())+'&uMemberId='+getValue());return document.MM_returnValue" value="Detail &raquo;" onMouseover="showhint('Lihat detail /  Edit Member '+getValue(), this, event, '220px')">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            </p>
            <p><br>
              <?
   for ($i=0;$i<$vPageCount;$i++) {
     $vOffset=$i*$vBatasBaris;
	   $idisp=$i;
	 if ($vOP=="post") $idisp=0;
     if ($idisp!=$vPage) {
?>
              <a  href="aktiftemp.php?lmAktif=<?=$vAktif?>&amp;lmMship=<?=$vPrem?>&amp;uPage=<?=$idisp?>&amp;lmSort=<?=$vSort?>" >
              <?=$i+1?>
              </a> 
              <?
  } else {
?>
              <?=$i+1?>
              <? } ?>
              <?  } //while?>
              <span >                </span><br>
              <br>
        </p>
      </div></td>
</tr>

       <!-- page end-->
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

