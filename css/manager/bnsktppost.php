<? include_once("../framework/admin_headside.blade.php")?>
	

<?php


$vAwal=$_POST['dc'];
$vAkhir=$_POST['dc1'];
$vSpy = md5('spy').md5($_GET['uMemberId']);

 if ($_GET['uMemberId'] != '')
    $vUserActive=$_GET['uMemberId'];
 else  $vUserActive=$vUser;
 
// echo $vUserActive;

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
$vUserHO=$oRules->getSettingByField('fuserho');
$vPage=$_GET['uPage'];
$vBatasBaris=50;
if ($vPage=="")
 	$vPage=0;
$vStartLimit=$vPage * $vBatasBaris;	

$vPeriod = $_POST['tfFPeriod'];
$vPeriodOri = $_POST['tfFPeriod'];
$vPeriod = explode("_",$vPeriod);
$vFrom = $vPeriod[0];
$vTo = $vPeriod[1];

if ($_POST['tfFPeriod'] !='')
$vCrit.=" and a.fdfrom = '$vFrom' and a.fdto = '$vTo'" ;

if($_POST['lmKorwil'] !='') 
	$vCrit .= " and a.fidkorwil='{$_POST['lmKorwil']}'  ";

 
 $vsql="select a.*, b.fnama from tb_komisi a left join m_korwil b on a.fidkorwil=b.fidkorwil where a.fkind='KTP'  ";


  $vsql.=$vCrit;
 $vsql.=" order by ftanggal ";
 $db->query($vsql);
 $db->next_record();
 $vRecordCount=$db->num_rows();
 $vPageCount=ceil($vRecordCount/$vBatasBaris);

?>

<link rel="stylesheet" type="text/css" href="../vendor/select2/select2.min.css">
<script src="../vendor/select2/select2.min.js"></script>

<script language="JavaScript" type="text/JavaScript">
function setPay(pIdSys,pRemark) {
   var vURL='../manager/processing_ajax.php?op=markpay&idsys='+pIdSys;
   if (confirm('Yakin untuk menandai terbayar '+pRemark+'?')) {
	   $.get(vURL,function(data) {
	      if(data.trim()=='successmark') {
	        alert('Bonus sudah ditandai terbayar!');
	        $('#tdstatpay'+pIdSys).html('<font color="#00f">Sudah</font>');
  			document.getElementById('btnPay'+pIdSys).disabled=true;
  			//document.getElementById('btnReject'+pIdTrx).disabled=true;
	      }
	   });
   }
}

<?
  $vNow = date('H:i:s');
  if ($vNow >= "00:00:00" && $vNow <="03:00:00") {
?>
  alert('Sistem sedang memproses bonus pukul 00:00:00 - 03:00:00, silakan melakukan approval di luar jam tersebut!');
  document.location.href='../index.php';
  
<? } ?>

$(document).ready(function(){
    $('#caption').html('PO Approval');


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
 $('#lmKorwil').select2();
 
					$('#tblMain').DataTable({
							"pageLength" : 100,
							responsive: true,
						 	"language": {
    								"search": "Pencarian Umum:"
  							},
							
							"columnDefs": [
    							{
									
									//"sType": "numeric", "aTargets": [-1] 
									"targets": [0],
									// "orderable": false,
									 "type": "num"
									
								}
  							],
							
							 dom: 'Bfrtip',
        buttons: [{
             					extend: 'excelHtml5',
								filename: 'BonusKTP<?="$vPeriodOri"?>',
								title: 'Bonus KTP Periode <?="$vPeriodOri"?>'
						}	, 
			 				{ 
								extend: 'print',
								title: 'Bonus KTP Periode <?="$vPeriodOri"?>',
								exportOptions: {
        							stripHtml: false
    							}
								
							}
		]
  });  
 
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

function doApprove(pIdSys,pIdTrx) {
   var vURL='../manager/processing_ajax.php?op=approvepoin&idsys='+pIdSys+'&idtrx='+pIdTrx;
   if (confirm('Are you sure to approve order Point PO '+pIdTrx+'?')) {
	   $.get(vURL,function(data) {
	      if(data.trim()=='successappv') {
	        alert('Approval succeed, payment updated!');
	        $('#tdstat'+pIdSys).html('Approved');
  			document.getElementById('btnAppv'+pIdTrx).disabled=true;
  			document.getElementById('btnReject'+pIdTrx).disabled=true;
	      }
	   });
   }
}


function doReject(pIdSys,pIdTrx) {
   var vURL='../manager/processing_ajax.php?op=rejectkit&idsys='+pIdSys+'&idtrx='+pIdTrx;
   if (confirm('Are you sure to reject & delete permanently PO '+pIdTrx+'?')) {
	   $.get(vURL,function(data) {
	      alert(data);
	      if (data.trim()=='successdel') {
	         alert('PO already rejected!');
	         $('#tr'+pIdTrx).hide('slow');
	      }
	   });
   }
}

</script>
<!--	<link rel="stylesheet" href="../css/screen.css">-->

	
	
 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />


				
<div class="right_col" role="main">
		<div><label>
		<h3> Report Bonus KTP</h3></label></div>

<form action="" method="post" name="demoform">
		<div class="row hide">
        <div class="col-lg-5">
          <div style="display:inline" align="left">
          <strong>Tgl Posting : </strong>
          <input style="width:100px;display:inline" class="form-control" name="dc" id="dc" size="11" value="<?=$vAwal?>">&nbsp; <strong>
			  to</strong>
          <input style="width:100px;display:inline" class="form-control" name="dc1" id="dc1" size="11" value="<?=$vAkhir?>"> 
          
          </div>
          </div>
          </div>
          
  <div>&nbsp;</div>
        <div class="row"> 
               <div class="col-lg-2">
           <b>  Periode </b>  </div>
              <div class="col-lg-4">
              
               
               <select name="tfFPeriod" id="tfFPeriod" class="form-control">
               <option value="">--Pilih--</option>
               <?
               		 $vSQL="select distinct concat(a.fdfrom,'_',a.fdto) as fperiod, fdfrom, fdto from tb_komisi a  where a.fkind='KTP'  ";
					$dbin->query($vSQL);
					while($dbin->next_record()) {
			   ?>
               <option <? if($_POST['tfFPeriod']==$dbin->f('fperiod')) echo 'selected'; ?> value="<?=$dbin->f('fperiod')?>"><?=$oPhpdate->YMD2DMY($dbin->f('fdfrom'))." s/d ".$oPhpdate->YMD2DMY($dbin->f('fdto'))?></option> 
               <? } ?>
               </select>
          </div>
       
        </div>   
		
<div class="row"> 
               <div class="col-lg-2">
           <b>  Area Korwil / Subkorwil </b>  </div>
              <div class="col-lg-4">
              
               
               <select name="lmKorwil" class="form-control" id="lmKorwil">
                    <option value="" selected="selected">--All--</option>
                    <?
                    	$vSQL = "select * from m_korwil order by fnama";
						$db->query($vSQL);
						while($db->next_record()) {
							$vIDKor=$db->f('fidkorwil');
							$vNamaKor=$db->f('fnama');
					
					?>
                    	<option value="<?=$vIDKor?>" <? if ($_REQUEST['lmKorwil'] == $vIDKor) echo "selected"?>><?=$vIDKor?> / <?=$vNamaKor?></option>
                    <? } ?>
                  </select>
          </div>
       
        </div>
				  
        <br>
          <input style="display:inline" name="Submit22" type="submit" class="btn btn-success" value="Refresh">    
          <br /><br />
<br />


    <div class="table-responsive">
        <table  width="100%" border="0" class="table table-striped table-bordered" id="tblMain">
          <thead>
          <tr style="font-weight:bold">
            <td width="4%" style="height: 24px; width: 5%;"><strong>No.</strong></td>
            <td width="8%" style="height: 24px"><div align="center"><strong>Tgl. Posting</strong></div></td>
            <td class="" width="8%" style="height: 24px" align="center"><strong>ID Korwil / Subkorwil</strong></td>
            <td class="hide" width="8%" style="height: 24px"><strong>ID Pebisnis</strong></td>
            <td width="21%" align="center" style="width: 12%; height: 24px;"><strong>Nama</strong></td>
            <td width="22%" align="center" style="height: 24px"><strong>Keterangan</strong></td>
            <td width="14%" align="center" style="height: 24px"><strong>Jml. Bonus (netto)</strong></td>
            <td width="15%" align="center" style="height: 24px" class="display:none"><strong> Status Sync</strong></td>
            <td width="15%" align="center" style="height: 24px;" class="">Status Bayar</td>
            <td width="15%" align="center" style="height: 24px" class="">&radic;</td>
            </tr>
            </thead>
            <tbody>
          <? 
             $vNo=0;


			 
			 $vsql="select a.*, b.fnama from tb_komisi a left join m_korwil b on a.fidkorwil=b.fidkorwil where a.fkind='KTP'  ";
			  
			  $vsql.=$vCrit;
			 
			// $vsql.=" order by ftglentry  desc ";

			 
			  $vsql.="limit $vStartLimit ,$vBatasBaris ";




		     $db->query($vsql);
			 $vTotJual=0;
			 while ($db->next_record()) {
			 $vNo++;
				 $vTanggal=$db->f('ftanggal');
				 $vIdMember=$db->f('fidmember');
				 $vIdProd=$db->f('fidproduk');
				 $vNama=$db->f('fnama');
				 $vKet=$db->f('fdesc');
				 $vStat=$db->f('ffeestatus');
				
				 $vIdSys=$db->f('fidsys');
				 $vIdTrx=$db->f('fidpenjualan');
				 $vSubTotal = $db->f('fnetto');
				
				 $vPoin = $db->f('fjumlah');
				 $vRemark = "$vKet untuk $vNama";
				 $vStatPay=$db->f('fmark');
				 if($vStatPay=='0')
				    $vSPayText='<font color="#FF0000">Belum</font>';
				 else 	if($vStatPay=='1')
				    $vSPayText ='<font color="#0000FF">Sudah</font>';
				 if ($vStat=='0' || $vStat=='1')
				    $vStatus='Pending';
				 else if ($vStat=='2')   
				    $vStatus='Approved';
				 else if ($vStat=='4')  
				    $vStatus='Rejected';    
				 //$vtgltrans=$db->f('ftanggal');
		  ?>
          <tr id="tr<?=$vIdSys?>">
            <td style="width: 5%" ><?=$vNo+$vStartLimit?></td>
            <td nowrap ><?=$oPhpdate->YMD2DMY($vTanggal,"-")?></td>
            <td class=""><?=$db->f('fidkorwil')?></td>
            <td class="hide"><?=$db->f('fidbisnis')?></td>
            <td style="width: 23%" ><?=$vNama?></td>
            <td align="left"><?=$vKet?></td>
            <td ><div align="right">
            <?
            
            
			 echo  number_format($vSubTotal,0,",",".");
            
			 $vTotalJual+=$vSubTotal;
            
            ?>
			</div></td>
            <td id="tdstat<?=$vIdSys?>" class="" style="display:none"> <?=$vStatus?></td>
            <td id="tdstatpay<?=$vIdSys?>" class=""><?=$vSPayText?></td>
            <td id="tdstatbutt<?=$vIdSys?>"><input  id="btnPay<?=$vIdSys?>" name="btnPay<?=$vIdSys?>" type="button" class="btn btn-info btn-xs" value="Tandai Terbayar" onClick="setPay('<?=$vIdSys?>','<?=$vRemark?>')" <? if ($vStatPay=='1') echo 'disabled'; ?>></td>
            </tr>
           <? } ?>
          <tr class="hide">
            <td style="width: 5%" >&nbsp;</td>
            <td ><div align="right"><strong>Grand Total </strong></div></td>
            <td class="hide">&nbsp;</td>
            <td class="hide">&nbsp;</td>
            <td colspan="" ><div align="right"></div></td>
            <td class="">&nbsp;</td>
            <td class="" align="right"><strong>
              <?=number_format($vTotalJual,0,",",".")?>
            </strong></td>
            <td class="">&nbsp;</td>
            <td class="">&nbsp;</td>
            <td class="">&nbsp;</td>
            </tr>
        </table>    
        </div>  
            
     <table width="90%">
     <tr>
      <td align="center">
        
       
        <ul class="pagination">
          <?
   for ($i=0;$i<$vPageCount;$i++) {
     $vOffset=$i*$vBatasBaris;
     if ($i!=$vPage) {
?>
          <li class="active" ><a href="../manager/bnsktppost.php?uPage=<?=$i?>&uAwal=<?=$oPhpdate->DMY2YMD($oPhpdate->YMD2DMY($vAwal,"-"),"-")?>&uAkhir=<?=$oPhpdate->DMY2YMD($oPhpdate->YMD2DMY($vAkhir,"-"),"-")?>" >
          <?=$i+1?>
          </a></li>
          <?
  } else {
?>
         <li style="cursor:pointer"> <a href="#" > <?=$i+1?></a></li>
          <? } ?>
          <?  } //while?>
<br>
       </ul></td>
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
     <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.css"/>

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
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>

</div>
	<!-- end page container -->


<? include_once("../framework/admin_footside.blade.php") ; ?>
