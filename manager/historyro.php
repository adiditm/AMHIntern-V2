<? include_once("../framework/admin_headside.blade.php")?>

<?php

$vAwal=$_POST['dc'];
$vAkhir=$_POST['dc1'];
$vOutletPost=$_POST['lmOutlet'];
$vResPost=$_POST['lmReseller'];

$vAnd="";

if ($vOutletPost !='') 
   $vAnd .= " and b.fidoutlet = '$vOutletPost' ";	

if ($vResPost !='') 
   $vAnd .= " and a.fidseller = '$vResPost' ";	

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
	
	
 
 $vSQL="select fidmember from m_anggota  where faktif='1' ";
 $vSQL.="union all ";
 $vSQL.="select fidmember from m_admin where fidmember = '$vUserActive'";
 $db->query($vSQL);
 $vArrID=array();
 while ($db->next_record()) {
	 $vArrID[]=$db->f('fidmember');
 }

  $vIDJson=json_encode($vArrID);
  $vIDJson=str_replace('"',"'",$vIDJson);
  $vIDJson=str_replace('[',"",$vIDJson);
  $vIDJson=str_replace(']',"",$vIDJson);	
$vStartLimit=$vPage * $vBatasBaris;	

$vCrit.=" and date(a.ftanggal) >= '$vAwal' and date(a.ftanggal) <= '$vAkhir'" ;



 $vsql="select * from (select distinct a.ftanggal, a.fidpenjualan,fidseller,fidmember, a.fketerangan, a.fprocessed, a.fshipcost, a.fdiscount, a.fdiscglobal  from tb_trxstok_member a left join m_outlet b on a.fnostockist = b.fidoutlet where a.fidproduk not like 'KIT%' $vAnd $vCrit"; 
 $vsql.=" union all ";
 $vsql.= "select distinct a.ftanggal, a.fidpenjualan,fidseller,fidmember, a.fketerangan, a.fprocessed, a.fshipcost, a.fdiscount, a.fdiscglobal  from tb_trxstok_member_temp a left join m_outlet b on a.fnostockist = b.fidoutlet where a.fidproduk not like 'KIT%' $vAnd $vCrit) as x"; 
 
 //$vsql.=" where x.fidseller in ($vIDJson) ";
 $vsql.=" order by x.ftanggal ";


 $db->query($vsql);
 $db->next_record();
 $vRecordCount=$db->num_rows();
 $vPageCount=ceil($vRecordCount/$vBatasBaris);

 

?>



<script language="JavaScript" type="text/JavaScript">


$(document).ready(function(){
    $('#caption').html('History Penjualan');


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


<div class="content-wrapper">

       <section class="content">

<form action="" method="post" name="demoform">

<div class="row">
       <div class="col-lg-5"> 
          <strong>Date : </strong>
          <input style="width:100px;display:inline" class="form-control" name="dc" id="dc" size="11" value="<?=$vAwal?>">&nbsp; <strong>
			  to</strong>
          <input style="width:100px;display:inline" class="form-control" name="dc1" id="dc1" size="11" value="<?=$vAkhir?>"> &nbsp;&nbsp;
         
   </div>       
</div>

<div class="row">
<br>
       <div class="col-lg-5"> 
       <label><b>Outlet</b></label>
 <select onChange="selectProd(this)" name="lmOutlet" id="lmOutlet" class="form-control" >
								
								<option value="" selected="selected">---Pilih---</option>
								<?
								    $vSQL="select * from m_outlet where faktif=1";
								    $db->query($vSQL);
								   
								    while($db->next_record()) {
								       $vCode=$db->f('fidoutlet');
								       $vNama=$db->f('fnama');

								      								       
								?>
								<option value="<?=$vCode?>" <? if ($vCode==$vOutletPost) echo 'selected';?>><?=$vCode."; ".$vNama?></option>

								<? } ?>
			</select>
   </div>       
</div>
<div class="row">
<br>
       <div class="col-lg-5"> 
       <label><b>Reseller</b></label>
 <select onChange="selectProd(this)" name="lmReseller" id="lmReseller" class="form-control" >
								
								<option value="" selected="selected">---Pilih---</option>
								<?
								    $vSQL="select * from m_anggota where faktif=1";
								    $db->query($vSQL);
								   
								    while($db->next_record()) {
								       $vCode=$db->f('fidmember');
								       $vNama=$db->f('fnama');

								      								       
								?>
								<option value="<?=$vCode?>" <? if ($vCode==$vResPost) echo 'selected';?>><?=$vCode."; ".$vNama?></option>

								<? } ?>
                                <option value="<?=$vUserActive?>"  <? if ($vUserActive==$vResPost) echo 'selected';?>><?=$vUserActive?>; <?=$oMember->getMemFieldAdm('fnama',$vUserActive)?></option>
			</select>
   </div>       
</div>
<div class="row">
<br>
       <div class="col-lg-5"> 
 <input style="display:inline" name="Submit22" type="submit" class="btn btn-success" value="Refresh">
 </div>
 </div>
          <br /><br />
<br />


    <div class="table-responsive">
        <table width="90%" border="0" class="table table-striped">
          <tr >
            <td style="height: 24px; width: 5%;"><strong>No.</strong></td>
            <td width="15%" style="height: 24px"><div align="center"><strong>Date</strong></div></td>
            <td class="" width="15%" style="height: 24px"><strong>Reseller Username</strong></td>
            <td width="10%" align="center" style="height: 24px"><strong>Customer Name </strong></td>
            <td width="12%" align="center" style="height: 24px"><strong>Outlet</strong></td>
            <td width="12%" align="center" style="height: 24px"><strong>&nbsp;Detail Product </strong></td>
            <td width="12%" align="center" style="height: 24px"><strong>Status</strong></td>
            <td width="12%" align="center" style="height: 24px"><strong>Note</strong></td>
            <td width="12%" align="center" style="height: 24px"><strong>Total</strong></td>
            <td width="12%" align="center" style="height: 24px"><strong>Discount</strong></td>
            <td width="13%" align="center" style="height: 24px"><strong>Shipcost</strong></td>
            <td width="10%" align="center" style="height: 24px"><strong>Nett </strong></td>
          </tr>
          <? 
             $vNo=0;
			 $vsql="select * from (select distinct a.ftanggal, a.fidpenjualan,fidseller,fidmember, a.fketerangan, a.fprocessed, a.fshipcost, a.fdiscount, a.fdiscglobal  from tb_trxstok_member a left join m_outlet b on a.fnostockist = b.fidoutlet where a.fidproduk not like 'KIT%' $vAnd $vCrit"; 
			 $vsql.=" union all ";
			 $vsql.= "select distinct a.ftanggal, a.fidpenjualan,fidseller,fidmember, a.fketerangan, a.fprocessed, a.fshipcost, a.fdiscount, a.fdiscglobal  from tb_trxstok_member_temp a left join m_outlet b on a.fnostockist = b.fidoutlet where a.fidproduk not like 'KIT%' $vAnd $vCrit) as x"; 
			// $vsql.=" where x.fidseller in ($vIDJson) ";
			 $vsql.=" order by x.ftanggal ";
			  $vsql.="limit $vStartLimit ,$vBatasBaris ";
		     $db->query($vsql);
			 $vTotJual=0;
			 while ($db->next_record()) {
			 $vNo++;
				 $vTanggal=$db->f('ftanggal');
				 $vIdMember=$db->f('fidmember');
				 $vIdSeller=$db->f('fidseller');
				 $vIdProd=$db->f('fidproduk');
				 $vOutlet=$oMember->getMemField('foutlet',$vIdSeller);
				 if ($vOutlet=='')
				     $vOutlet=$oMember->getMemFieldAdm('fidoutlet',$vIdSeller);
				 $vNama=$oMember->getMemberName($vIdMember);
				 $vKet=$db->f('fketerangan');
				 
				 $vStat=$db->f('fprocessed');
				 $vIdSys=$db->f('fidsys');
				 $vIdTrx=$db->f('fidpenjualan');
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
            <td ><?=$oPhpdate->YMD2DMY($vTanggal,"-")?></td>
            <td class=""><?=$db->f('fidseller')?></td>
            <td ><?=$vIdMember?></td>
            <td nowrap><?=$vOutlet?>/<?=$oMember->getOutletName($vOutlet)?></td>
            <td ><div align="left"><?=$oJual->dispDetBuyed($db->f('fidpenjualan'))?></div></td>
            <td align="left"><span class="<?=$vStatClass?>"><?=$vStatus?></span></td>
            <td ><?=$vKet?></td>
            <td ><div align="right">
              <?
             $vSubTot=$oJual->getBuyedTot($db->f('fidpenjualan'));
             echo  number_format($vSubTot,0,",",".");
            
            
            ?>
            </div></td>
            <td ><div align="right"><?=number_format($vDiscG=$db->f('fdiscglobal'),0,",",".");?></div></td>
            <td ><div align="right">
              <?=number_format($vShCost=$db->f('fshipcost'),0,",",".");?>
            </div></td>
            <td ><div align="right">
            <?
            
             echo  number_format($vTot=$vSubTot-$vDiscG+$vShCost,0,",",".");
             $vTotalJual+=$vTot;
            
            ?>
			</div></td>
          </tr>
           <? } ?>
          <tr>
            <td style="width: 5%" >&nbsp;</td>
            <td ><div align="right"><strong>Grand Total </strong></div></td>
            <td class="">&nbsp;</td>
            <td colspan="9" ><div align="right"><strong>
              <?=number_format($vTotalJual,0,",",".")?>
            </strong></div></td>
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


       </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->





<?
 include('../framework/admin_footside.blade.php');
?>

