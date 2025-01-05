<? include_once("../framework/admin_headside.blade.php")?>
<?
  define("MENU_ID", "mdm_jual_verifikasi");   
  date_default_timezone_set('Asia/Jakarta');
  $vRefUser=$_GET['uMemberId'];
  if (isset($vRefUser))
  	 $vUser=$vRefUser;
  else	 
  	 $vUser=$_SESSION['LoginUser'];
  if ($vTanggal=="")
     $vTanggal=$oPhpdate->getNowYMD("-");  
  $vAwal=$_POST['dc'];
  $vAkhir=$_POST['dc1'];
  if ($vAwal=="") 
     $vAwal=date("Y-m-d");
  if ($vAkhir=="") 
  	 $vAkhir=date("Y-m-d"); 
	 //FIlter

   $ref=$_REQUEST['ref'];


	$vIDJual=$_POST['tfIDJual']; 
	$vID=$_POST['tfID'];
	$vAnd="";
	if ($vID!="") $vAnd.=" and fidmember = '$vID' ";
	if ($vIDJual!="")  $vAnd.=" and fidtopup like '%$vIDJual%' "; 
	$vAnd.=" and date(ftglupdate) between date('$vAwal') and date('$vAkhir')";
	//$vAnd.=" and fstatusrow !=4 ";
	
    $vsql="SELECT *  FROM tb_topup WHERE  fstatusrow in ('0','1')  $vAnd ";
    $vsql.="ORDER BY fidtopup DESC, fstatusrow asc";
    $db->query($vsql);
	$vNumRows=$db->num_rows();

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
<script type="text/javascript" src="../js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<script type="text/javascript" src="../js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>




<script language="JavaScript" type="text/JavaScript">



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


function doProcess(pURL) {
   vSure=confirm('Apakah Anda yakin memproses topup ini?');
   if (vSure==true) {
	     window.location=pURL+'&ref=topup';
   } 
}

function doCancel(pURL) {
   vSure=confirm('Apakah Anda yakin membatalkan topup ini?');
   if (vSure==true) {
	     window.location=pURL;
   } 
}


function doShow(windowHeight, windowWidth, windowName, windowUri)
{
    var centerWidth = (window.screen.width - windowWidth) / 2;
    var centerHeight = (window.screen.height - windowHeight) / 2;

    newWindow = window.open(windowUri, windowName, 'scrollbars=1, resizable=0,width=' + windowWidth + 
        ',height=' + windowHeight + 
        ',left=' + centerWidth + 
        ',top=' + centerHeight);

    newWindow.focus();
    return newWindow.name;
}


function doDetail(pID){
	doShow(400,500,'wDet','detopup.php?uID='+pID);
}

$(document).ready(function(){
   $('#dc').datepicker({

                    format: "yyyy-mm-dd",

                    autoclose : true

    }).on('changeDate', function (ev) {
    $(this).datepicker('hide');
    });  
  

    

       $('#dc1').datepicker({

                    format: "yyyy-mm-dd",

                    autoclose : true

    }).on('changeDate', function (ev) {
    $(this).datepicker('hide');
    });  
	
	    $('#caption').html('Topup Deposit Approval');	
});
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
.style5 {
	color: #FF0000;
	font-weight: bold;
	font-family: Tahoma;
}
-->
</style>
<div class="content-wrapper" style="width:100%;">
<section class="content" >

<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableRow" class="contentfont">
  <!--DWLayoutTable-->
  <tr> 
    <td width="618" height="5" align="center" valign="top"> 
      <form id="demoform" name="demoform" method="post" action="" >
        <input name="hPageNum" type="hidden" id="hPageNum">   
        <input name="hPage" type="hidden" id="hPage" value="<?=$curpage?>">
        <input name="hBtn" type="hidden" id="hBtn">
        <input name="ref" type="hidden" id="ref" >
  <div align="left">
  <div class="row">
  <div class="col-lg-6">
    <table width="50%" border="0" cellpadding="2" cellspacing="0" bgcolor="#99CCFF" >
      <tr>
        <td colspan="3"  ><div align="center" class="style3">
          <div align="left"><h4>Filter</h4></div>
          </div></td>
        </tr>
      <tr>
        <td width="33%" height="25" >Member ID
          <div align="left"></div></td>
        <td width="2%" height="25">:</td>
        <td width="65%" height="25" ><input class="form-control" name="tfID" type="text" id="tfID" value="<?=$vID?>" /></td>
        </tr>
      <tr>
        <td height="25" >ID Topup </td>
        <td height="25" >:</td>
        <td height="25" ><input class="form-control"  name="tfIDJual" type="text" id="tfIDJual" value="<?=$vIDJual?>" /></td>
        </tr>
      </table>
  </div>
  </div>          
    </div>
        <div class="row">
  <div class="col-lg-8 col-sm-4 col-xs-4 form-inline">       
    <p align="left"><font face="Verdana, Arial, Helvetica, sans-serif"><strong><br />
      Mulai Tanggal : </strong>
      <input name="dc" id="dc" class="form-control" value="<?=$vAwal?>" size="20" />
      
      <input  name="dc1"  id="dc1" class="form-control"  size="20" value="<?=$vAkhir?>" />
      
      <button name="Submit22"  class="btn btn-success btn-sm" onclick="MM_callJS('doSubmit(\'cari\')')"  >
        <i class="fa fa-refresh"></i>
        Refresh
        </button>
      <br />
      </font><strong><br />
        </strong></p>
    </div>
          </div>
        <strong><table width="100%" border="0">
          <tr>
            <td><div align="left"><strong>Page
              <select name="select3" id="select3" onchange="changePage(this)" class="form-control" style="max-width:75px">
                <? for ($i=0;$i<$pagenum;$i++) {?>
                <option value="<?=$i+1 ?>" <? if ($curpage==($i)) echo "selected";?>>&nbsp;
                  <?=$i+1?>
                  &nbsp;</option>
                <? } ?>
                </select>
              </strong></div></td>
            <td><div align="right"><strong>Page
              <select name="select" id="select2" onchange="changePage(this)" class="form-control" style="max-width:75px">
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
        <? if ($vNumRows > 0) {?>
        <br><br><br><br><br><br><br>
        <table width="76%" border="0" align="center" cellpadding="0" cellspacing="0" class="table table-striped" >
          <tr class="upper text-bold">
            <td width="32" nowrap="nowrap" valign="middle" ><div align="center">No</div></td>
            <td width="108" nowrap="nowrap" valign="middle" style="min-width:80px; word-wrap:no"><div align="center">Tgl</div></td>
            <td width="87" nowrap="nowrap" valign="middle" ><div align="center">ID Reseller</div></td>
            <td width="202" nowrap="nowrap" valign="middle" ><div align="center">Name</div></td>
            <td width="83" nowrap="nowrap" valign="middle" ><div align="center">Status</div></td>
            <td width="115" nowrap="nowrap" valign="middle" ><div align="center">Rek Tujuan</div></td>
            <td width="127" nowrap="nowrap" valign="middle" ><div align="center">Rek Asal</div></td>
            <td  valign="middle"  width="308"> <div align="center">Action</div></td>
            <td width="133" nowrap="nowrap" valign="middle" ><div align="center">Amount </div></td>
            
            
            
            
            
            </tr>
          
          <?
			   $vsql="SELECT * FROM tb_topup WHERE fstatusrow in ('0','1') $vAnd ";
			   $vsql.="ORDER BY ftglupdate desc,fidtopup DESC, fstatusrow asc ";
			    $vsql.="limit  $offset, $rowpage ";
			   $db->query($vsql);
			   $vNo=0;$vTotHarga=0;$vTotHargaV=0;
			   while ($db->next_record()) {
			     $vNo+=1;
				 $vIDJual=$db->f("fidtopup");
				 $vTgl=$db->f("ftglupdate");
				 $vUserID=$db->f("fidmember");
				 $vSubtotal=$db->f("fnominal");
				 $vProcessed=$db->f("fstatusrow");
				 $vRekFrom=$db->f("frekfrom");
				 $vRekTo=$db->f("frekto");
				 $vTotHarga+=$vSubtotal;
				 if ($vProcessed==2)
				    $vTotHargaV+=$vSubtotal;
				if ($vProcessed=='2')
				    $vStatusText='Approved';	
				else if	($vProcessed=='4')
				    $vStatusText='Rejected';	
				else $vStatusText='Pending';		
			?>
          
          <tr style="height:12.75pt;"  >
            <td width="32" height="19" valign="middle" nowrap="nowrap"><div align="center">
              <?=str_pad($vNo+$offset,2,'0',STR_PAD_LEFT)?>
              </div></td>
            <td width="108" valign="middle" nowrap="nowrap" ><?=$oPhpdate->YMD2DMY($vTgl,"-")?>                </td>
            <td width="87" nowrap="nowrap" valign="middle" ><?=$vUserID?></td>
            <td width="202" nowrap="nowrap" valign="middle" ><?=$oMember->getMemberName($vUserID)?></td>
            <td width="83" nowrap="nowrap" valign="middle" ><?=$vStatusText?></td>
            <td width="115" nowrap="nowrap" valign="middle" ><?=$vRekTo?></td>
            <td width="127" nowrap="nowrap" valign="middle" ><?=$vRekFrom?></td>
            
            
            
            
            <td nowrap="nowrap" valign="middle" align="center"><? if ($vProcessed!=2 && $vProcessed!=4) { ?> 
              <input type="button" name="Button" onClick="doProcess('processbeli.php?uIDJual=<?=$vIDJual?>&uSess=<?=md5('jalanku')?>&uUserID=<?=$vUserID?>');" value="Process" <? if ($vProcessed==2 || $vProcessed==4) echo "disabled";?> />
              <input type="button" name="Button2" onclick="doCancel('processbeli.php?uIDJual=<?=$vIDJual?>&uSess=<?=md5('jalanku')?>&uCanc=<?=md5('bataldeh')?>&uUserID=<?=$vUserID?>');" value="Cancel" <? if ($vProcessed==2 || $vProcessed==4) echo "disabled";?> />
              <? } ?>                <input name="btnDetail" type="button" id="btnDetail" onclick="doDetail('<?=$vIDJual?>');" value="Detail"  /></td>
            
            <td width="133" nowrap="nowrap" valign="middle" ><div align="right">
              <?=number_format($vSubtotal,0,",",".")?>
              </div></td>
            
            </tr>
          
          
          <? } ?>
          <tr style="height:12.75pt;"  <? if ($vProcessed==4) echo "bgcolor='#666666'"; else if($vProcessed==2) echo "bgcolor='#99FFCC'"; else if(($vNo % 2)==1) echo "bgcolor='#FFFFF3'"; else echo "bgcolor='#CCCCFF'"; ?>>
            <td height="19" colspan="8" valign="middle" nowrap="nowrap">Total Top Up Pending (halaman ini) </td>
            <td nowrap="nowrap" valign="middle" ><div align="right"><?=number_format($vTotHarga,0,",",".")?></div></td>
            </tr>
          <tr style="height:12.75pt;"  <? if ($vProcessed==4) echo "bgcolor='#666666'"; else if($vProcessed==2) echo "bgcolor='#99FFCC'"; else if(($vNo % 2)==1) echo "bgcolor='#FFFFF3'"; else echo "bgcolor='#CCCCFF'"; ?>>
            <td height="19" colspan="8" valign="middle" nowrap="nowrap">Total Top Up Pending </td>
            <td nowrap="nowrap" valign="middle" ><div align="right"><?=number_format($oJual->getTopupByStatus(0,$vAwal,$vAkhir),0,",",".")?></div></td>
            </tr>           
          
          </table>
        <? } else { ?>
        <h4>Tidak ada data deposit pending! </h4>
        
        <? } ?>
        
        <p><strong>
          <input name="ref" type="hidden" id="ref" />
          <br />
          </strong>
          <table width="100%" border="0">
            <tr>
              <td><div align="left"><strong>Page
                <select name="select4" id="select4" onchange="changePage(this)" class="form-control" style="max-width:75px">
                  <? for ($i=0;$i<$pagenum;$i++) {?>
                  <option value="<?=$i+1 ?>" <? if ($curpage==($i)) echo "selected";?>>&nbsp;
                    <?=$i+1?>
                    &nbsp;</option>
                  <? } ?>
                  </select>
                </strong></div></td>
              <td><div align="right"><strong>Page 
                <select name="select2" id="select" onchange="changePage(this)" class="form-control" style="max-width:75px">
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
        <input  class="hide" name="btnBukti" type="button"  id="btnBukti" onClick="MM_goToURL('parent','loggedin.php?menu=showbukti&uUser=<?=base64_encode($vUser)?>');return document.MM_returnValue" value="Lihat Bukti Pembayaran">      
        <br>
        </p>
      <blockquote>
        <div align="left"></div>
        </blockquote></td>
  </tr>
</table>



</section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



<script type="text/javascript" src="../js/bootstrap-daterangepicker/moment.min.js"></script>

<script type="text/javascript" src="../js/bootstrap-daterangepicker/daterangepicker.js"></script>

<script type="text/javascript" src="../js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>

<script type="text/javascript" src="../js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>

<!--common scripts for all pages-->

<script src="../js/pickers-init.js"></script>


<?
 include('../framework/admin_footside.blade.php');
?>

