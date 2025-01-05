<?php

$vAwal=$_POST['dc'];
$vAkhir=$_POST['dc1'];
$vSpy = md5('spy').md5($_GET['uMemberId']);


 if ($_GET['op'] != '') {
    
	include_once("../framework/admin_headside.blade.php");
	$vUserActive=$_GET['uMemberId'];
 }else  { 
   
	include_once("../framework/member_headside.blade.php");
	 $vUserActive=$vUser;
 }

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

$vCrit.=" and date(ftanggal) >= '$vAwal' and date(ftanggal) <= '$vAkhir'" ;



 $vsql="select distinct ftanggal, fidpenjualan,fidmember, fketerangan  from tb_trxstok_member where fidproduk not like 'KIT%' and fidmember='$vUserActive' ";
 $vsql.=$vCrit;
 $vsql.=" order by ftanggal ";
 $db->query($vsql);
 $db->next_record();
 $vRecordCount=$db->num_rows();
 $vPageCount=ceil($vRecordCount/$vBatasBaris);

?>
<style type="text/css">
  td {color:black}
</style>


<script language="JavaScript" type="text/JavaScript">


$(document).ready(function(){
  <? if ($oDetect->isMobile()) {?>
  $('#caption').html('<span data-toggle="tooltip" data-placement="top" title="History Penjualan <?=$oMember->getMemberName($vUserActive)?>"><?=substr("Penjualan ".$oMember->getMemberName($vUserActive),0,20);?>...</span>');
  <? } else { ?>
	$('#caption').html('<span   title="History" >History Penjualan <?=$vUserActive?> (<?=$oMember->getMemberName($vUserActive);?>)</span>');
  <? } ?>


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
   $('[data-toggle="tooltip"]').tooltip({tooltipClass:"ttclass"});  
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

function printTrx(pParam,pTgl,pIDMem) {
	var vURL='../memstock/detjual.php?uNoJual='+pParam+'&uTanggal='+pTgl+'&uIDMember='+pIDMem;
	window.open(vURL,'wPrint','width=900 height=600');
}
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
				  <li><a href="javascript:;">Repeat Order  History</a></li></h4>
				
			</ol>
<h1 class="page-header">&nbsp;</small></h1>

<form action="" method="post" name="demoform">

          <div style="display:inline" align="left">
          <strong>Date : </strong>
          <input style="max-width:90px;display:inline" class="form-control" name="dc" id="dc" size="11" value="<?=$vAwal?>">&nbsp; <strong>
			  to</strong>
          <input style="max-width:90px;display:inline" class="form-control" name="dc1" id="dc1" size="11" value="<?=$vAkhir?>"> &nbsp;&nbsp;

          <input style="display:inline" name="Submit22" type="submit" class="btn btn-success <? if ($oDetect->isMobile()) echo 'btn-xs' ;?>" value="Refresh">
          
          </div>
          <br /><br />
<br />


    <div class="table-responsive">
        <table width="90%" border="0" class="table table-striped" >
          <tr >
            <td style="height: 24px; width: 5%;"><strong>No.</strong></td>
            <td width="15%" style="height: 24px"><div align="center"><strong>Date</strong></div></td>
            <td " width="15%" style="height: 24px"><strong> Username</strong></td>
            <td width="10%" align="center" style="height: 24px"><strong>Member Name </strong></td>
            <td width="12%" align="center" style="height: 24px"><strong>&nbsp;Detail Product </strong></td>
            <td width="12%" align="center" style="height: 24px"><strong>Payment Method</strong></td>
            <td width="12%" align="center" style="height: 24px"><strong>Status</strong></td>
            <td width="12%" align="center" style="height: 24px"><strong>Note</strong></td>
            <td width="12%" align="center" style="height: 24px"><strong>Total</strong></td>
            <td width="10%" align="center" style="height: 24px"><strong>Nett </strong></td>
            <td width="7%" align="center" style="height: 24px"><strong>Action</strong></td>
          </tr>
          <? 
             $vNo=0;
			 $vsql="select distinct ftanggal, fidpenjualan,fidseller,fidmember, fketerangan,fprocessed,fmethod from tb_trxstok_member where fjenis <> 'FO' and fidmember='$vUserActive' "; 
			 $vsql.=" union all ";
			 $vsql.= "select distinct ftanggal, fidpenjualan,fidseller,fidmember, fketerangan,'0' as fprocessed,fmethod  from tb_trxstok_member_temp where fjenis <> 'FO' and fidmember='$vUserActive' "; 
			 $vsql.=$vCrit;
			 $vsql.=" order by ftanggal ";
			$vsql.="limit $vStartLimit ,$vBatasBaris ";
		     $db->query($vsql);
			 $vTotJual=0;
			 while ($db->next_record()) {
			 $vNo++;
				 $vTanggal=$db->f('ftanggal');
				 $vIdMember=$db->f('fidmember');
				 $vIdProd=$db->f('fidproduk');
				 $vNama=$oMember->getMemberName($vIdMember);
				 $vKet=$db->f('fketerangan');
				 
				 $vStat=$db->f('fprocessed');
				 $vIdSys=$db->f('fidsys');
				 $vIdTrx=$db->f('fidpenjualan');
				 $vMethod=$db->f('fmethod');
				 if($vMethod == 'ctr' || $vMethod == 'mTrans')
				    $vMethodText='Cash/Transfer';
				 else $vMethodText='eWallet';	
				 if ($vStat=='0') {
				    $vStatus='Pending';
					$vStatClass='btn btn-info btn-xs';
				 }
				 else if ($vStat=='2')   {
				    $vStatus='Approved';
					$vStatClass='btn btn-success btn-xs';
				 }
				 else if ($vStat=='4')   {
				    $vStatus='Rejected';  
					$vStatClass='btn btn-danger btn-xs';
				 }
				 
				 //$vtgltrans=$db->f('ftanggal');
		  ?>
          <tr>
            <td style="width: 5%" ><?=$vNo?></td>
            <td nowrap><?=$oPhpdate->YMD2DMY($vTanggal,"-")?></td>
            <td ><?=$db->f('fidmember')?></td>
            <td ><?=$vNama?></td>
            <td ><div align="left"><?=$oJual->dispDetBuyed($db->f('fidpenjualan'))?></div></td>
            <td align="left"><?=$vMethodText?></td>
            <td align="left"><span class="<?=$vStatClass?>"><?=$vStatus?></span></td>
            <td ><?=$vKet?></td>
            <td ><div align="right">
              <?
             $vSubTot=$oJual->getBuyedTot($db->f('fidpenjualan'));
             echo  number_format($vSubTot,0,",",".");
            
            
            ?>
            </div></td>
            <td ><div align="right">
              <?
            
             echo  number_format($vTot=$vSubTot-$vDiscG+$vShCost,0,",",".");
             $vTotalJual+=$vTot;
            
            ?>
            </div></td>
            <td ><div align="center"><input type="button" class="btn btn-xs btn-success" name="button" id="button" value="Print Receipt" onClick="printTrx('<?=$vIdTrx?>','<?=$vTanggal?>','<?=$vIdMember?>')"></div></td>
          </tr>
           <? } ?>
          <tr>
            <td style="width: 5%" >&nbsp;</td>
            <td ><div align="right"><strong>Grand Total </strong></div></td>
            <td ">&nbsp;</td>
            <td colspan="6" ><div align="right"></div></td>
            <td ><strong>
              <?=number_format($vTotalJual,0,",",".")?>
            </strong></td>
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
          <a href="../memstock/historyro.php?uPage=<?=$i?>&uAwal=<?=$oPhpdate->DMY2YMD($oPhpdate->YMD2DMY($vAwal,"-"),"-")?>&uAkhir=<?=$oPhpdate->DMY2YMD($oPhpdate->YMD2DMY($vAkhir,"-"),"-")?>" >
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
      <td height="5" align="left" valign="middle"> <div align="right"></div>
        <hr> 
        <b>
        <?
				 $vKakiL=$oNetwork->getDownLR($vUser,'L');
				 $vKakiR=$oNetwork->getDownLR($vUser,'R');
				 
				 
				 $vOmzetL = $oKomisi->getOmzetROWholeMember($vKakiL);
				 $vOmzetKakiL=$oKomisi->getOmzetROAllMember($vKakiL);
				 $vOmzetR = $oKomisi->getOmzetROWholeMember($vKakiR);   
				 $vOmzetKakiR=$oKomisi->getOmzetROAllMember($vKakiR);     
		?>
        Omzet Group Kiri : <?=number_format($vOmzetL+$vOmzetKakiL,0,",",".")?><br />
        Omzet Group Kanan : <?=number_format($vOmzetR+$vOmzetKakiR,0,",",".")?>
        </b>
        </td>
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
	
<? include_once("../framework/member_bottomjs.blade.php")?>	
	<script>
		$(document).ready(function() {
			App.init();
			Dashboard.init();
		});
	</script>

<? include_once("../framework/member_footside.blade.php") ; ?>