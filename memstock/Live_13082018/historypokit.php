<? 
		if ($_GET['op'] != '') 
           include_once("../framework/admin_headside.blade.php");
        else
           include_once("../framework/member_headside.blade.php") ;  
?>

<?php


$vAwal=$_POST['dc'];
$vAkhir=$_POST['dc1'];
$vSpy = md5('spy').md5($_GET['uMemberId']);

 if ($_GET['uMemberId'] != '')
    $vUserActive=$_GET['uMemberId'];
 else  $vUserActive=$vUser;

if ($vAwal=="")
	$vAwal=$_GET['uAwal'];
if ($vAkhir=="")
	$vAkhir=$_GET['uAkhir'];


if ($vAwal=="")
   $vAwal=date('Y-m-d', strtotime('-30 days'));
   
if ($vAkhir=="")
   $vAkhir=$oPhpdate->getNowYMD("-");

   
$vPrevWeek=$oMydate->getPrevWeek($vTanggal);
$vWeek=$oMydate->getWeek($vTanggal);
$vYear=$oMydate->getYear($vTanggal);   
if ($vWeek==52)
    $vPrevYear=$vYear-1;
else
     $vPrevYear= $vYear;	
$oMydate->setCritPrevDate("ftglkomisi",$vTanggal);	 

$vPage=$_GET['uPage'];
$vBatasBaris=25;
if ($vPage=="")
 	$vPage=0;
$vStartLimit=$vPage * $vBatasBaris;	
$vFilterText='';
$vCrit.=" and date(ftanggal) >= '$vAwal' and date(ftanggal) <= '$vAkhir'" ;
$vFilterText.="[Date: $vAwal - $vAkhir]";



 $vsql="select distinct ftanggal, fidpenjualan,fidmember, fketerangan  from tb_trxstok_member where fidproduk not like 'KIT%' and fidmember='$vUserActive' and fjenis='PS'";
 $vsql.=$vCrit;
 $vsql.=" order by ftanggal ";
 
 
 
 				$db->query($vsql);
				$vArrData="";
				$vArrHead=array('No.','Date','MS USername','Username','Name','Detail Product','Note','Total','Status');
				$vArrBlank=array('','','','','','','','','');
				$vArrDateFilter=array('Filter :  '.$vFilterText,'','','','','','','','');
				
				
				$i=0;$vTot=0;
				$vArrData[]=$vArrDateFilter;
				$vArrData[]=$vArrBlank;
				$vArrData[]=$vArrHead;
				
				while ($db->next_record()) { //Convert Excel
				     $i++;

				 $vTanggal=$db->f('ftanggal');
				 $vIdMember=$db->f('fidmember');
				 $vIdProd=$db->f('fidproduk');
				 $vNama=$oMember->getMemberName($vIdMember);
				 $vKet=$db->f('fketerangan');
				 $vStat=$db->f('fstatus');
				 if ($vStat=='0')
				    $vStatus='Pending';
				 else if ($vStat=='1')   
				    $vStatus='Approved';
				 else if ($vStat=='4')  
				    $vStatus='Rejected';   				     

				 //$vArrHead=array('No.','Date','MS USername','Username','Name','Detail Product','Note','Total','Status');


				 $vArrData[]=array($i,$vTanggal,$db->f('fidseller'),$vIdMember,$vNama,$oJual->dispDetPO($db->f('fidpenjualan')),$vKet,$vStatus);
					//$vArrMem['fpassword'][$i]=$oSystem->doED('decrypt',$db->f('fpassword'));
				
				}
				
				//$vArrTot=array('','','','','','',$vTot);
				//$vArrData[]=$vArrTot;
				$_SESSION['pohist']=$vArrData;

 
 
 
 $db->query($vsql);
 $db->next_record();
 $vRecordCount=$db->num_rows();
 $vPageCount=ceil($vRecordCount/$vBatasBaris);

?>



<script language="JavaScript" type="text/JavaScript">


$(document).ready(function(){
    $('#caption').html('Purchase Order History <?=$vUserActive?> (<?=$oMember->getMemberName($vUserActive);?>)');


      $('#dc').datepicker({
                    format: "yyyy-mm-dd",
                    autoclose : true
    }).on('changeDate', function (ev) {
    $(this).datepicker('hide');
    });  
; 
  
  
       $('#dc1').datepicker({
                    format: "yyyy-mm-dd",
                    autoclose : true
    }).on('changeDate', function (ev) {
    $(this).datepicker('hide');
    });  
; 

});


function doBayar(pKode,pKomisi,pSisa,pBatas) {
   pSisa=parseInt(pSisa);
   pBatas=parseInt(pBatas);

    if (pSisa<pBatas) {
	   alert('Komisi tidak bisa dibayarkan karena sisa komisi kurang dari batas minimum transfer!');
	   return false;
	}
	window.location='admin.php?menu=buktitfr&uKd='+pKode+'&uKom='+pKomisi;
}


function doBayarBuy(pKode,pKomisi,pSisa,pBatas) {
   pSisa=parseInt(pSisa);
   pBatas=parseInt(pBatas);

    if (pSisa<pBatas) {
	   alert('Komisi tidak bisa dibayarkan karena sisa komisi kurang dari batas minimum transfer!');
	   return false;
	}
	window.location='admin.php?menu=buktitfrsell&uKd='+pKode+'&uKom='+pKomisi;
}//-->
</script>
<!--	<link rel="stylesheet" href="../css/screen.css">-->

	
	
 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />

<div id="content" class="content">
			<ol class="breadcrumb pull-right">
				<h4>
				  <li><a href="javascript:;">History PO Serial</a></li></h4>
				
			</ol>
<h1 class="page-header">&nbsp;</small></h1>
        <!-- page start-->

<form action="" method="post" name="demoform">

          <div style="display:inline" align="left">
          <strong>Date : </strong>
          <input style="width:100px;display:inline" class="form-control" name="dc" id="dc" size="11" value="<?=$vAwal?>">&nbsp; <strong>
			  to</strong>
          <input style="width:100px;display:inline" class="form-control" name="dc1" id="dc1" size="11" value="<?=$vAkhir?>"> &nbsp;&nbsp;
          <input style="display:inline" name="Submit22" type="submit" class="btn btn-success" value="Refresh">
          
          </div>
          <br /><br />
<br />


    <div class="table-responsive">
        <table width="90%" border="0" class="table table-striped">
          <tr >
            <td style="height: 24px; width: 5%;"><strong>No.</strong></td>
            <td width="15%" style="height: 24px"><div align="center"><strong>Date</strong></div></td>
            <td class="hide" width="15%" style="height: 24px"><strong>MS Username</strong></td>
            <td width="10%" align="center" style="height: 24px"><strong>Username </strong></td>
            <td align="center" style="width: 23%; height: 24px;"><strong>Name</strong></td>
            <td width="12%" align="center" style="height: 24px"><strong>&nbsp;Detail Serial </strong></td>
            <td width="12%" align="center" style="height: 24px"><strong>Note</strong></td>
            <td width="14%" align="center" style="height: 24px"><strong>Total </strong></td>
            <td width="14%" align="center" style="height: 24px"><strong>Status</strong></td>
          </tr>
          <? 
             $vNo=0;
			 $vsql="select distinct ftanggal, fidpenjualan,fidseller,fidmember, fketerangan,fserno,fsubtotal,fprocessed, '1' as fstatus  from tb_trxkit where  fidmember='$vUserActive' "; 
			 $vsql.=$vCrit;

			 
			 $vsql.=" order by ftanggal desc ";

			 
			 $vsql.="limit $vStartLimit ,$vBatasBaris ";




		     $db->query($vsql);
			 $vTotJual=0;
			 while ($db->next_record()) {
			 $vNo++;
				 $vTanggal=$db->f('ftanggal');
				 $vIdMember=$db->f('fidmember');
				
				 $vNama=$oMember->getMemberName($vIdMember);
				 $vKet=$db->f('fketerangan');
				 $vSerno=$db->f('fserno');
				 $vSubTot=$db->f('fsubtotal');
				 $vSerno="[".str_replace(",","] [",$vSerno)."]";
				 $vStat=$db->f('fprocessed');
				 if ($vStat=='0')
				    $vStatus='Pending';
				 else if ($vStat=='2')   
				    $vStatus='Approved';
				 else if ($vStat=='4')  
				    $vStatus='Rejected';    
				 //$vtgltrans=$db->f('ftanggal');
		  ?>
          <tr>
            <td style="width: 5%" ><?=$vNo?></td>
            <td ><?=$oPhpdate->YMD2DMY($vTanggal,"-")?></td>
            <td class="hide"><?=$db->f('fidseller')?></td>
            <td ><?=$vIdMember?></td>
            <td style="width: 23%" ><?=$vNama?></td>
            <td ><div align="left"><?=$vSerno?></div></td>
            <td ><?=$vKet?></td>
            <td ><div align="right">
            <?
           //  $vSubTot=$oJual->getPOTot($db->f('fidpenjualan'));
             echo  number_format($vSubTot,0,",",".");
             $vTotalJual+=$vSubTot;
            
            ?>
			</div></td>
            <td> <?=$vStatus?></td>
          </tr>
           <? } ?>
          <tr>
            <td style="width: 5%" >&nbsp;</td>
            <td ><div align="right"><strong>Grand Total </strong></div></td>
            <td class="hide">&nbsp;</td>
            <td colspan="5" ><div align="right"><strong>
              <?=number_format($vTotalJual,0,",",".")?>
            </strong></div></td>
            <td >&nbsp;</td>
          </tr>
        </table>    
        </div>  
            
     <table width="90%">
     <tr>
      <td align="center">
        
        <p>
          <?
   for ($i=0;$i<$vPageCount;$i++) {
     $vOffset=$i*$vBatasBaris;
     if ($i!=$vPage) {
?>
          <a href="historypo.php?uPage=<?=$i?>&amp;uAwal=<?=$oPhpdate->DMY2YMD($oPhpdate->YMD2DMY($vAwal,"-"),"-")?>&amp;uAkhir=<?=$oPhpdate->DMY2YMD($oPhpdate->YMD2DMY($vAkhir,"-"),"-")?>" >
          <?=$i+1?>
          </a>
          <?
  } else {
?>
          <?=$i+1?>
          <? } ?>
          <?  } //while?>
<br>
        </p></td>
    </tr>
    <tr> 
      <td height="5" align="center" valign="middle"> <div align="right"></div>
        <hr> </td>
    </tr>
    <tr> 
      <td height="49" align="center" valign="middle"> <p><br>
        </p>
      <p>&nbsp;        </p></td>
    </tr>
    <?php
   
  if ($baris==$Akhiran)
  {
  ?>
    <?php
  }
  ?>
  </table>
  
</form>
      <!-- page end-->

<button style="margin-left:2em" class="btn btn-info btn-sm" onClick="document.location.href='../manager/getexcel.php?arr=pohist&file=po_hist_report_<?=$vUserChoosed?>'"><i class="fa fa-file-text-o"></i> Export Excel</button>         
        <!--body wrapper end-->


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

	
<? include_once("../framework/member_bottomjs.blade.php")?>	
	<script>
		$(document).ready(function() {
			App.init();
			Dashboard.init();
		});
	</script>

<? include_once("../framework/member_footside.blade.php") ; ?>
