<?
           include "../framework/admin_headside.blade.php"; 
     
     ?>

<?php

$vAwal=$_POST['dc'];
$vAkhir=$_POST['dc1'];

if ($vAwal=="")
	$vAwal=$_GET['uAwal'];
if ($vAkhir=="")
	$vAkhir=$_GET['uAkhir'];


if ($vAwal=="")
   $vAwal=date('Y-m-d', strtotime('-30 days'));
   
if ($vAkhir=="")
   $vAkhir=$oPhpdate->getNowYMD("-");

$vPaket=$_POST['lmPaket'];
$vSort=$_POST['lmSort'];


$vPage=$_GET['uPage'];
$vBatasBaris=25;
if ($vPage=="")
 	$vPage=0;
$vStartLimit=$vPage * $vBatasBaris;	
$vFilterText="";
$vCrit.=" and date(a.ftanggal) >= '$vAwal' and date(a.ftanggal) <= '$vAkhir' " ;
$vFilterText.="[Date : $vAwal - $vAkhir]";


if ($vPaket !='') {
   $vCrit.=" and b.fpaket='$vPaket' ";
    $vFilterText.="[Paket: $vPaket]";

   }

if ($_SESSION['Priv']=='administrator')
   $vMem=$_POST['tfMem'];
else $vMem=$vUser;   
   
if ($vMem!='') {
   $vCrit.=" and a.fidmember='$vMem' ";   
    $vFilterText.="[Username: $vMem]";

   }

if ($vSort =='M')
   $vOrder.=" order by b.fnama ";
else  if ($vSort =='B') 
   $vOrder.=" order by a.fdebit  ";
else    $vOrder.=" order by a.ftanggal asc ";



			 $vsql="select a.*, b.*, date(a.ftanggal) as ftglcompile from tb_mutasi a left join m_anggota b on a.fidmember=b.fidmember where a.fkind='resetmonth'"; 

			 $vsql.=$vCrit;			 
			 
			 $vsql.=$vOrder;
			 
			//Export Excel
				$db->query($vsql);
				$vArrData="";
				$vArrHead=array('No.','Date','Username','Name','Bonus Amount','Alamat','Phone','Bank Acc. No');
				$vArrBlank=array('','','','','','','');
				$vArrDateFilter=array('Filter :  '.$vFilterText,'','','','','','');
				
				$i=0;
				$vArrData[]=$vArrDateFilter;
				$vArrData[]=$vArrBlank;
				$vArrData[]=$vArrHead;
				
				while ($db->next_record()) { //Convert Excel
				    $i++;
				 $vIdMember=$db->f('fidmember');
				 $vTanggal=$db->f('ftglcompile');
				// $vNama=$db->f('fnama');
				 $vAlamat=$oMember->getMemField('falamat',$vIdMember);			
				 $vNegara=$oMember->getMemField('fcountry',$vIdMember);
				 $vHP=$oMember->getMemField('fnohp',$vIdMember);
				 $vNama=$oMember->getMemberName($vIdMember);
				 $vKota=$oMember->getMemField('fkota',$vIdMember);

				 $vProp=$oMember->getMemField('fpropinsi',$vIdMember);
				 $vBelanja=$db->f('fdebit');

				 $vKotaName = $oMember->getWilName('ID',$vProp,$vKota,'00','0000');

                 $vBank=$db->f('fnamabank');
                 $vBankName=$oMember->getBankName($vBank);
                 $vRek=$db->f('fnorekening');                    

				    //$vArrHead=array('No.','RO Date','Username','Name','ID Penjualan','Purc. Amount','Address','Phone','Autoship Item');

				 $vArrData[]=array($i,$vTanggal,$vIdMember,$vNama,$vBelanja,$vAlamat.' '.$vKotaName," ".$vHP,$vBankName." / ".$vRek);
					//$vArrMem['fpassword'][$i]=$oSystem->doED('decrypt',$db->f('fpassword'));
				
				}
				
				$_SESSION['statemonth']=$vArrData;
			 
			 
			 
 $db->query($vsql);
 $db->next_record();
 $vRecordCount=$db->num_rows();
 $vPageCount=ceil($vRecordCount/$vBatasBaris);

?>



<script language="JavaScript" type="text/JavaScript">


$(document).ready(function(){
    $('#caption').html('Monthly Statement Report');


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
	<!-- <link rel="stylesheet" href="../css/screen.css"> -->

	
	
 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />


<div class="right_col" role="main">
		<div><label><h3>Monthly Statement</h3></label></div>
<form action="" method="post" name="demoform">

          <div style="display:inline" align="left">
                   &nbsp; &nbsp;&nbsp;&nbsp;
          
          </div>
          <br />
                    <div class="row">
          <div class="col-lg-8">

		  <table style="width: 75%">
			  <tr>
				  <td style="height: 22px; width: 154px;"> <strong>Date  </strong>&nbsp;</td>
				  <td style="height: 22px"> <input style="width:100px;display:inline" class="form-control" name="dc" id="dc" size="11" value="<?=$vAwal?>"><b>to</b>
          <input style="width:100px;display:inline" class="form-control" name="dc1" id="dc1" size="11" value="<?=$vAkhir?>"> </td>
			  </tr>
			  <tr class="hide">
				  <td style="width: 154px; height: 26px;"><strong>Reg. Package</strong>
</td>
				  <td style="height: 26px"><select name="lmPaket" id="lmPaket" class="form-control ">
				  <option value="" selected>--All--</option>
				  <option value="S" <? if ($vPaket=='E' ||  $vPaket=="S") echo 'selected'; ?>>Silver</option>
				  <option value="G" <? if ($vPaket=='B' ||  $vPaket=="G") echo 'selected'; ?>>Gold</option>
				  <option value="P" <? if ($vPaket=='F' ||  $vPaket=="P") echo 'selected'; ?>>Platinum</option>




				  </select></td>
				  
			  </tr>
			  <tr>
				  <td style="width: 154px; height: 22px"><strong>Sort By</strong>
</td>
				  <td style="height: 22px">
				  <select name="lmSort" id="lmSort"  class="form-control">
				  <option value="">None</option>
				  <option value="M" <? if ($vSort=='M') echo 'selected'; ?>>Member Name</option>
				  <option value="B" <? if ($vSort=='B') echo 'selected'; ?>>Bonus Amount</option>
				 



				  </select></td>
			  </tr>
<? if ($_SESSION['Priv'] == 'administrator') {?>		  
 <tr>
				  <td style="width: 154px; height: 22px"><strong>ID Member</strong>
					</td>
				  <td style="height: 22px">
				  <input type="text" name="tfMem" id="tfMem" value="<?=$_POST['tfMem']?>" class="form-control">
				</td>
			  </tr>
			  
			  <? } ?>
			  
			  <tr>
				  <td style="width: 154px">&nbsp;</td>
				  <td>&nbsp;</td>
			  </tr>
		  </table>
		  </div>
		  </div>
          <input style="display:inline" name="Submit22" type="submit" class="btn btn-success" value="Refresh"><br />
		  <br>
		  <br>


    <div class="table-responsive">
        <table border="0" class="table table-striped" style="width:98%">
          <tr >
            <td style="height: 24px; width: 4%;"><strong>No.</strong></td>
            <td style="height: 24px; width: 11%;"><div align="center"><strong>Date</strong></div></td>
            <td style="height: 24px; width: 14%;" align="center"><strong>Username</strong></td>
            <td class="hide" style="height: 24px; width: 7%;" align="center"><strong>ID Jual</strong></td>
            <td align="center" style="height: 24px; width: 88px;"><strong>Name </strong></td>
            <td align="center" style="height: 24px; width: 88px;"><strong>
			Bonus Amount </strong></td>
            <td class="hide" align="center" style="height: 24px; "><strong>Address </strong></td>
            <td align="center" style="height: 24px; "><strong>HP No. </strong></td>
            <td align="center" style="height: 24px; " nowrap="nowrap"><strong>Bank Acc. No.</strong></td>
          </tr>
          <? 
            

		

             $vNo=0;
			 $vsql="select a.*, b.*, date(a.ftanggal) as ftglcompile from tb_mutasi a left join m_anggota b on a.fidmember=b.fidmember where a.fkind='resetmonth'"; 
			 $vsql.=$vCrit;
			 
			  $vsql.= $vOrder ;
			// $vsql.="limit $vStartLimit ,$vBatasBaris ";
		     $db->query($vsql);
		     $vCount=$db->num_rows();
			 //$vTotJualL=0;$vTotalJualR=0;
			 $vTot=0;
			 while ($db->next_record()) {
			 $vNo++;
				 $vIdMember=$db->f('fidmember');
				 $vTanggal=$db->f('ftglcompile');
				// $vNama=$db->f('fnama');
				$vAlamat=$oMember->getMemField('falamat',$vIdMember);			
				$vNegara=$oMember->getMemField('fcountry',$vIdMember);
				$vHP=$oMember->getMemField('fnohp',$vIdMember);
				$vNama=$oMember->getMemberName($vIdMember);
				$vKota=$oMember->getMemField('fkota',$vIdMember);

				$vProp=$oMember->getMemField('fpropinsi',$vIdMember);
				$vBonus=$db->f('fdebit');

				 $vKotaName = $oMember->getWilName('ID',$vProp,$vKota,'00','0000');
                 $vBank=$db->f('fnamabank');
                 $vBankName=$oMember->getBankName($vBank);
                 $vRek=$db->f('fnorekening');
				 
				 

		  ?>
          <tr>
            <td style="width: 4%; height: 24px;" ><?=$vNo+$vStartLimit?></td>
            <td style="height: 24px; width: 11%;" align="center"><?=$vTanggal?></td>
            <td style="height: 24px; width: 14%;" align="center"><?=$vIdMember?></td>
            <td class="hide" style="height: 24px; width: 7%;" align="center"><?=$db->f('fidpenjualan')?></td>
            <td style="height: 24px; width: 88px;" align="left"><?=$vNama?></td>
            <td style="height: 24px; width: 88px;" align="right"><?=number_format($vBonus,0,",",".")?></td>
            <td class="hide" style="height: 24px; " align="left"><?=$vAlamat.' '.$vKotaName?></td>
            <td style="height: 24px; " align="left"><?=$vHP?></td>
            <td style="height: 24px; " align="left" nowrap="nowrap"><?=$vBankName?> / <?=$vRek?></td>
          </tr>
           <? } ?>
          </table>    
     </div>  
            
     <table width="90%">
     <tr>
      <td align="center" style="display:none">
        
        <p>
          <?
   for ($i=0;$i<$vPageCount;$i++) {
     $vOffset=$i*$vBatasBaris;
     if ($i!=$vPage) {
?>
          <a href="statemonth.php?uPage=<?=$i?>&amp;uAwal=<?=$oPhpdate->DMY2YMD($oPhpdate->YMD2DMY($vAwal,"-"),"-")?>&amp;uAkhir=<?=$oPhpdate->DMY2YMD($oPhpdate->YMD2DMY($vAkhir,"-"),"-")?>" >
          <?=$i+1?>
          </a>
          <?
  } else {
?>
          <?=$i+1?>
          <? } ?>
          <?  } //while?>

        </p>
        
        </td>
    </tr>
        <tr> 
      <td  align="left" valign="top" style="font-weight:bold">
       <h3>        Total : <?=number_format($vCount,0,",",".");?></h3><br><br>
      </td>
      
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
<button class="btn btn-info btn-sm" onClick="document.location.href='../manager/getexcel.php?arr=statemonth&file=monthly_statement_report_<?=$vUser?>'"><i class="fa fa-file-text-o"></i> Export Excel</button> 
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

<? include_once("../framework/admin_footside.blade.php") ; ?>