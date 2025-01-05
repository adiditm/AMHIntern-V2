<?           include "../framework/admin_headside.blade.php"; 
     
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
   $vAkhir=date("Y-m");

$vPaket=$_POST['lmPaket'];
$vSort=$_POST['lmSort'];
$vBankFilter=$_POST['tfBank'];

$vDatePrev=$oMydate->dateSub($vAkhir."-01",1,'day');
			


$vPage=$_GET['uPage'];
$vBatasBaris=25;
if ($vPage=="")
 	$vPage=0;
$vStartLimit=$vPage * $vBatasBaris;	
$vFilterText="";
$vCrit.=" and date_format(a.ftanggal,'%Y-%m') = '$vAkhir' " ;
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

if ($vBankFilter !='')
   $vCrit.=" and  c.fkodebank='$vBankFilter'  ";

if ($vSort =='M')
   $vOrder.=" order by b.fnama ";
else  if ($vSort =='B') 
   $vOrder.=" order by a.fdebit  ";
else    $vOrder.=" order by a.ftanggal asc ";



			 $vsql="select a.*, b.*,c.fnamabank as cfnamabank,  date(a.ftanggal) as ftglcompile from tb_cftrans_smo a left join m_anggota b on a.fidmember=b.fidmember left join m_bank c on b.fnamabank=c.fkodebank where a.ftype='cfsmonth'"; 

			 $vsql.=$vCrit;			 
			 
			  $vsql.=$vOrder;


				$vRekMandiri = $oRules->getSettingByField('frekbank1');
				$vKotaMandiri = $oRules->getSettingByField('frekkota1');
				$vFeeTransOther = $oRules->getSettingByField('ffeetrans');
				$vFeeTransMdr = $oRules->getSettingByField('ffeetransmdr');
				$vMinTrans = $oRules->getSettingByField('fmintrans');

			  $db->query($vsql);
			  //$vCount=$db->num_rows();
				 $vTot=0;$vBonusTot=0; $vCount =0;
		        while ($db->next_record()) {
				   $vUserName=$db->f('fidmember');
				   $vBonus=$db->f('fcftrans');
				   if ($vUserName !='UNIGTOP') {
				      $vBonusTot+=$vBonus;
					  $vCount++;
				    }
				    
                   $vBank=$db->f('fnamabank');
                   $vBankName=$oMember->getBankName($vBank);
				 
                 $vRek=$db->f('fnorekening');
				 if($vBank == 'BK-ID-0002') {
				   $vKindTrans ='IBU';
				   $vFeeTrans = $vFeeTransMdr;
				 } else {  
				   $vKindTrans ='LBU'; 
				   $vFeeTrans = $vFeeTransOther ;
				 }					
				
					
			 	}  


			 
			//Export Excel
				$db->query($vsql);
				//$vCount=$db->num_rows();
								
				$vArrData=array();
				$vArrHead=array('P',str_replace("-","",$vAkhir."-01"),$vRekMandiri,$vCount,$vBonusTot,'','','','','','','','','','','','','');
				
				//$vArrBlank=array('','','','','','','');
				//$vArrDateFilter=array('Filter :  '.$vFilterText,'','','','','','');
				
				$i=0;
				//$vArrData[]=$vArrDateFilter;
				//$vArrData[]=$vArrBlank;
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

			   $vEmail=$db->f('femail');
				if (trim($vEmail) !='')
				   $vHasEmail ='Y'; 
				else $vHasEmail ='N';   
				
				 $vProp=$oMember->getMemField('fpropinsi',$vIdMember);
				 $vBonus=$db->f('fcftrans');
				 

				 $vKotaName = $oMember->getWilName('ID',$vProp,$vKota,'00','0000');

                 $vBank=$db->f('fnamabank');
                 $vBankName=$oMember->getBankName($vBank);
				 
                 $vRek=$db->f('fnorekening');
				 if($vBank == 'BK-ID-0002') {
				   $vKindTrans ='IBU';
				   $vFeeTrans = $vFeeTransMdr;
				 } else {  
				   $vKindTrans ='LBU'; 
				   $vFeeTrans = $vFeeTransOther ;
				 }
				 
				  $vSQL="select * from m_bank where fkodebank='$vBank'";
				 $dbin->query($vSQL);
				 $dbin->next_record();
				 $vCodeClear = $dbin->f('fclearno');
				 $vCityBank = $dbin->f('fcity');
				    //$vArrHead=array('No.','RO Date','Username','Name','ID Penjualan','Purc. Amount','Address','Phone','Autoship Item');
				// if ($vSisa >= $vMinTrans)
				    if ($vIdMember !='UNIGTOP')
					$vArrData[]=array($vRek,$vNama,$vKotaName,'','','IDR',$vBonus,"Periode $vAkhir",'',$vKindTrans,$vCodeClear,$vBankName,$vCityBank,'','','',$vHasEmail,$vEmail);
					//$vArrMem['fpassword'][$i]=$oSystem->doED('decrypt',$db->f('fpassword'));
				
				}
				
				$_SESSION['statemonthbm']=$vArrData;
			 
			 
			 
 $db->query($vsql);
 $db->next_record();
 $vRecordCount=$db->num_rows();
 $vPageCount=ceil($vRecordCount/$vBatasBaris);

?>



<script language="JavaScript" type="text/JavaScript">


$(document).ready(function(){
	$('#tfBank').select2();
	$('#lmSort').select2();
    $('#caption').html('Daily Statement Report');


      $('#dc').datepicker({
                    format: "yyyy-mm-dd",
                    autoclose : true
    }).on('changeDate', function (ev) {
    $(this).datepicker('hide');
    });  

  
  
       $('#dc1').datepicker({
                    format: "yyyy-mm",
                    autoclose : true,
					startView: 1,
  minViewMode: 1
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
		<div><label><h3>Monthly Transfer (Bank Mandiri)</h3></label></div>

<form action="" method="post" name="demoform">

          <div style="display:inline" align="left">
                   &nbsp; &nbsp;&nbsp;&nbsp;
          
          </div>
          <br />
                    <div class="row">
          <div class="col-lg-8">

		  <table style="width: 100%">
			  <tr>
				  <td width="152" style="height: 22px; width: 90px;"> <strong>Month  </strong>&nbsp;</td>
				  <td width="828" style="height: 22px"> <span class="hide"><input style="width:100px;display:inline" class="form-control" name="dc" id="dc" size="11" value="<?=$vAwal?>"><b>to</b></span>
          <input style="width:100px;display:inline" class="form-control" name="dc1" id="dc1" size="11" value="<?=$vAkhir?>"> </td>
			  </tr>
			  <tr class="hide">
				  <td style="width: 100px; height: 26px;" nowrap><strong>Reg. Package</strong>
</td>
				  <td style="height: 80px"><select name="lmPaket" id="lmPaket" class="form-control ">
				  <option value="" selected>--All--</option>
				  <option value="S" <? if ($vPaket=='E' ||  $vPaket=="S") echo 'selected'; ?>>Silver</option>
				  <option value="G" <? if ($vPaket=='B' ||  $vPaket=="G") echo 'selected'; ?>>Gold</option>
				  <option value="P" <? if ($vPaket=='F' ||  $vPaket=="P") echo 'selected'; ?>>Platinum</option>




				  </select></td>
				  
			  </tr>
<tr>
				  <td style="width: 100px; height: 22px" nowrap><strong>Bank Filter</strong>
</td>
				  <td style="height: 22px">
				  <select  class="form-control m-bot15" id="tfBank" name="tfBank"  onchange="">
                                <option  value="" selected="selected" >--Pilih / Choose--</option>
								<? 
								    $vSQL="select * from m_bank where faktif='1' order by fnamabank";
								    $dbin->query($vSQL);
								    while ($dbin->next_record()) {
								?>                               
								 <option  <? if ($vBankFilter==$dbin->f('fkodebank')) echo 'selected'; ?>  value="<?=$dbin->f('fkodebank')?>"  ><?=$dbin->f('fnamabank')?></option>
								 <? } ?>
                            </select></td>
			  </tr>                     
			  <tr>
				  <td style="width: 100px; height: 22px"><strong>Sort By</strong>
</td>
				  <td style="height: 22px">
				  <select name="lmSort" id="lmSort"  class="form-control">
				  <option value="">None</option>
				  <option value="M" <? if ($vSort=='M') echo 'selected'; ?>>Member Name</option>
				  <option value="B" <? if ($vSort=='B') echo 'selected'; ?>>Bonus Amount</option>
                  <option value="A" <? if ($vSort=='A') echo 'selected'; ?>>Bank Name</option>
				 



				  </select></td>
			  </tr>
<? if ($_SESSION['Priv'] == 'administrator') {?>		  
 <tr>
				  <td style="width: 100px; height: 22px"><strong>ID Member</strong>
					</td>
				  <td style="height: 22px">
				  <input type="text" name="tfMem" id="tfMem" value="<?=$_POST['tfMem']?>" class="form-control">
				</td>
			  </tr>
			  
			  <? } ?>
			  
			  <tr>
				  <td style="width: 100px">&nbsp;</td>
				  <td>&nbsp;</td>
			  </tr>
		  </table>
		  </div>
		  </div>
          <input style="display:inline" name="Submit22" type="submit" class="btn btn-success" value="Refresh"><br />
		  <br>
		  <br>


    <div class="table-responsive">
    <?
    $vsql="select a.*, b.*,c.fnamabank as cfnamabank, date(a.ftanggal) as ftglcompile from tb_cftrans_smo a left join m_anggota b on a.fidmember=b.fidmember left join m_bank c on b.fnamabank=c.fkodebank where a.ftype='cfsmonth'"; 
			 $vsql.=$vCrit;
			 
			  $vsql.= $vOrder ;
			// $vsql.="limit $vStartLimit ,$vBatasBaris ";
			$db->query($vsql);
			// $vCount=$db->num_rows();
				 $vTot=0;$vBonusTot=0;$vCount=0;
		        while ($db->next_record()) {
				    $vBonus=$db->f('fcftrans');
                $vBank=$db->f('fnamabank');
                 $vBankName=$oMember->getBankName($vBank);
				 
                 $vRek=$db->f('fnorekening');
				 if($vBank == 'BK-ID-0002') {
				   $vKindTrans ='IBU';
				   $vFeeTrans = $vFeeTransMdr;
				 } else {  
				   $vKindTrans ='LBU'; 
				   $vFeeTrans = $vFeeTransOther ;
				 }					
				    			
					   $vBonusTot+=$vBonus;
					   $vCount++;
					
			 	}  
	?>
        <table border="0" class="table table-striped" style="width:98%">
          <tr style="font-weight:bold">
            <td style="height: 24px; width: 4%;"><strong>No.</strong></td>
            <td style="height: 24px; width: 11%;"><div align="center"><strong>Username</strong></div></td>
            <td style="height: 24px; width: 14%;" align="center">No. Rekening<br><br><span style="color:blue;float:right">P</span></td>
            <td style="height: 24px; width: 14%;" align="center"><strong>Nama Penerima<br><span style="color:blue;float:right"><?=str_replace("-","",$vAkhir."-01")?></span></strong></td>
            <td  style="height: 24px; width: 7%;" align="center">Alamat Pemilik Rek<span style="float:right;color:blue"><?=$vRekMandiri?></span></td>
            <td class="hide" style="height: 24px; width: 7%;" align="center"><strong>Kota</strong></td>
            <td align="center" style="height: 24px; width: 88px;"><strong>Jml Member <br> <span style="float:right;color:blue"><?=number_format($vCount,0,",",".")?></span></strong></td>
            <td align="center" style="height: 24px; width: 88px;"><strong>
			Tot Transfer <br>
            <span style="float:right;color:blue"><?=number_format($vBonusTot,0,",",".")?></span>
            </strong>
            </td>
            <td class="hide" align="center" style="height: 24px; "><strong>Mata Uang </strong></td>
            <td align="center" style="height: 24px; ">Bonus</td>
            <td align="center" style="height: 24px; ">Biaya Transfer</td>
            <td align="center" style="height: 24px; "><strong>Nominal Trx (Nett)</strong></td>
            <td align="center" style="height: 24px; " nowrap="nowrap"><strong>Remark</strong></td>
            <td align="center" style="height: 24px; " nowrap="nowrap">Kosong</td>
            <td align="center" style="height: 24px; " nowrap="nowrap">IBU/LBU</td>
            <td align="center" style="height: 24px; " nowrap="nowrap">Kode LBU</td>
            <td align="center" style="height: 24px; " nowrap="nowrap">Nama Bank</td>
            <td align="center" style="height: 24px; " nowrap="nowrap">Kota Bank</td>
            <td align="center" style="height: 24px; " nowrap="nowrap">Alamat 1</td>
            <td align="center" style="height: 24px; " nowrap="nowrap">Alamat 2 </td>
            <td align="center" style="height: 24px; " nowrap="nowrap">Alamat 3</td>
            <td align="center" style="height: 24px; " >Punya Email (Y/N)</td>
            <td align="center" style="height: 24px; " nowrap="nowrap">Email</td>
          </tr>
          <? 
            

		

             $vNo=0;
			
				
			 
		     $db->query($vsql);
		     //$vCount=$db->num_rows();
			 //$vTotJualL=0;$vTotalJualR=0;
			 $vTot=0;$vCount=0;
			 
			 while ($db->next_record()) {
			 
				 $vIdMember=$db->f('fidmember');
				 $vTanggal=$db->f('ftglcompile');
				// $vNama=$db->f('fnama');
				$vAlamat=$oMember->getMemField('falamat',$vIdMember);			
				$vNegara=$oMember->getMemField('fcountry',$vIdMember);
				$vHP=$oMember->getMemField('fnohp',$vIdMember);
				$vNama=$oMember->getMemberName($vIdMember);
				$vKota=$oMember->getMemField('fkota',$vIdMember);
				$vEmail=$db->f('femail');
				if (trim($vEmail) !='')
				   $vHasEmail ='Y';
				else $vHasEmail ='N';   

				$vProp=$oMember->getMemField('fpropinsi',$vIdMember);
				$vBonus=$db->f('fcftrans');

				 $vKotaName = $oMember->getWilName('ID',$vProp,$vKota,'00','0000');
                 $vBank=$db->f('fnamabank');
                 //$vBankName=$oMember->getBankName($vBank);
				 $vBankName=$db->f('cfnamabank');
                 $vRek=$db->f('fnorekening');
				 if($vBank == 'BK-ID-0002') {
				   $vKindTrans ='IBU';
				   $vFeeTrans = $vFeeTransMdr;
				 } else {  
				   $vKindTrans ='LBU'; 
				   $vFeeTrans = $vFeeTransOther ;
				 }
				 $vBonusPlus=$vBonus + $vFeeTrans;
				  $vSQL="select * from m_bank where fkodebank='$vBank'";
				 $dbin->query($vSQL);
				 $dbin->next_record();
				 $vCodeClear = $dbin->f('fclearno');
				 $vCityBank = $dbin->f('fcity');
				 
			
					$vNo++;
					   $vCount++;
				 

		  ?>
          <tr>
            <td style="width: 4%; height: 24px;" ><?=$vNo+$vStartLimit?></td>
            <td style="height: 24px; width: 11%;" align="center"><span style="height: 24px; width: 14%;">
              <?=$vIdMember?>
            </span></td>
            <td style="height: 24px; width: 14%;" align="left"><?=$vRek?></td>
            <td style="height: 24px; width: 14%;" align="left"><span style="height: 24px; width: 88px;">
              <?=$vNama?>
            </span></td>
            <td class="" style="height: 24px; width: 7%;" align="left"><?=$vKotaMandiri?></td>
            <td class="hide" style="height: 24px; width: 7%;" align="center"><?=$db->f('fidpenjualan')?></td>
            <td style="height: 24px; width: 88px;" align="right">&nbsp;</td>
            <td style="height: 24px; width: 88px;" align="right">&nbsp;</td>
            <td class="hide" style="height: 24px; " align="center">IDR</td>
            <td style="height: 24px; " align="right"><?=number_format($vBonusPlus,0,",",".")?></td>
            <td style="height: 24px; " align="right"><?=number_format($vFeeTrans,0,",",".")?></td>
            <td style="height: 24px; " align="right"><?=number_format($vBonus,0,",",".")?></td>
            <td style="height: 24px; " align="left" nowrap="nowrap"><? echo "Periode $vAkhir";  ?></td>
            <td style="height: 24px; " align="left" nowrap="nowrap">&nbsp;</td>
            <td style="height: 24px; " align="center" nowrap="nowrap"><?=$vKindTrans?></td>
            <td style="height: 24px; " align="center" nowrap="nowrap"><?=$vCodeClear?></td>
            <td style="height: 24px; " align="left" nowrap="nowrap"><?=$vBankName?></td>
            <td style="height: 24px; " align="left" nowrap="nowrap"><?=$vCityBank?></td>
            <td style="height: 24px; " align="left" nowrap="nowrap">&nbsp;</td>
            <td style="height: 24px; " align="left" nowrap="nowrap">&nbsp;</td>
            <td style="height: 24px; " align="left" nowrap="nowrap">&nbsp;</td>
            <td style="height: 24px; " align="center" nowrap="nowrap"><?=$vHasEmail?></td>
            <td style="height: 24px; " align="left" nowrap="nowrap"><?=$vEmail?></td>
          </tr>
           <? 
					
		   } 
		   
		   ?>
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
          <a href="statemonthbm.php?uPage=<?=$i?>&amp;uAwal=<?=$oPhpdate->DMY2YMD($oPhpdate->YMD2DMY($vAwal,"-"),"-")?>&amp;uAkhir=<?=$oPhpdate->DMY2YMD($oPhpdate->YMD2DMY($vAkhir,"-"),"-")?>" >
          <?=$i+1?>
          </a>
          <?
  } else {
?>
          <?=$i+1?>
          <? } ?>
          <?  } //while
		  
		  // print_r($_SESSION['statedaybm']); 
		  ?>

        </p>
        
        </td>
    </tr>
        <tr> 
      <td  align="left" valign="top" style="font-weight:bold">
       <h5>        Total : <?=number_format($vCount,0,",",".");?> record(s)</h5>
       <h5>        Minimum Transfer : <?=number_format($vMinTrans,0,",",".");?></h5><br>
       <br>
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
<button class="btn btn-info btn-sm" onClick="document.location.href='../manager/getexcel.php?arr=statemonthbm&file=monthly_statement_report_<?=$vUser?>'"><i class="fa fa-file-text-o"></i> Export Excel</button> &nbsp;
<button class="btn btn-info btn-sm" onClick="document.location.href='../manager/getcsv.php?arr=statemonthbm&file=daily_statement_report_<?=$vUser?>'"><i class="fa fa-file-text-o"></i> Export CSV</button> 



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