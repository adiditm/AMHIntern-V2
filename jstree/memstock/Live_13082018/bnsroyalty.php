<? include_once("../framework/masterheader.php")?>

<?php

$vAwal=$_POST['dc'];
$vAkhir=$_POST['dc1'];

$vBulNow=$_REQUEST['cbMonth'];
if ($vBulNow=='') $vBulNow=date("m");
if ($vAwal=="")
	$vAwal=$_GET['uAwal'];
if ($vAkhir=="")
	$vAkhir=$_GET['uAkhir'];

  $vRefUser=$_GET['uMemberId'];

  $vUser=$_SESSION['LoginUser'];
  
$vSpy = md5('spy').md5($_GET['uMemberId']);

   if ($_GET['op']==$vSpy)

      $vUserChoosed=$_GET['uMemberId'];



  if (isset($vRefUser))

  	 $vUserChoosed=$vRefUser;

  else	 

  	 $vUserChoosed=$_SESSION['LoginUser'];


$vFilterTgl=$_POST['cbYear'].$_POST['cbMonth'];
if ($vFilterTgl == '')
    $vFilterTgl=date("Ym");

$vPaket=$_REQUEST['lmPaket'];
$vSort=$_REQUEST['lmSort'];
$vRegis=$_REQUEST['tfRegis'];


$vPage=$_GET['uPage'];
$vBatasBaris=100;
if ($vPage=="")
 	$vPage=0;
$vStartLimit=$vPage * $vBatasBaris;	

$vFilterText="";
$vCrit.=" and date_format(ftanggal,'%Y%m') = '$vFilterTgl' " ;
$vFilterText.="[Date: $vFilterTgl]";


if ($vPaket !='') {
   $vCrit.=" and fpaket='$vPaket' ";
   $vFilterText.="[Package: $vPaket]";
}   


if ($vRegis !='') {
   $vCrit.=" and fidregistrar like '$vRegis%' ";
   $vFilterText.="[Registrant: $vRegis]";

   }

if ($_SESSION['Priv']=='administrator')
   $vMem=$_POST['tfMem'];
else $vMem=$vUser;   
   

if ($vSort =='T')
   $vOrder.=" order by ftanggal";
else  if ($vSort =='P') 
   $vOrder.=" order by ftotbelanja desc ";
else    $vOrder.=" order by ftanggal desc ";



			 $vsql="select  * from tb_kom_mtx where  1  and fidmember='$vUserChoosed'"; 
			 $vsql.=$vCrit;
			 $vsql.=$vOrder;
			 


				$db->query($vsql);
				$vArrData="";
				$vArrHead=array('No.','Date','Description','Registrant','Amount');
				$vArrBlank=array('','','','','');
				$vArrDateFilter=array('Filter :  '.$vFilterText,'','','','');
				
				
				$i=0;$vTot=0;
				$vArrData[]=$vArrDateFilter;
				$vArrData[]=$vArrBlank;
				$vArrData[]=$vArrHead;
				
				while ($db->next_record()) { //Convert Excel
				     $i++;

					 $vIdMember=$db->f('fidmember');
					 $vTanggal=$oPhpdate->YMD2DMY($db->f('ftanggal'));
					 $vDesc=$db->f('fdesc');
					 if ($vDesc=='') $vDesc = 'Bonus Royalty';
					 $vAmount=$db->f('ffee');
	
					 $vKotaName = $oMember->getWilName('ID',$vProp,$vKota,'00','0000');
   
				     

				 //$vArrHead=array('No.','Date','Description','Registrant','Amount');


				 $vArrData[]=array($i,$vTanggal,$vDesc,$db->f('fidregistrar'),$vAmount);
					//$vArrMem['fpassword'][$i]=$oSystem->doED('decrypt',$db->f('fpassword'));
				
				}
				
				//$vArrTot=array('','','','','','',$vTot);
				//$vArrData[]=$vArrTot;
				$_SESSION['royalty']=$vArrData;

			 
			 
 $db->query($vsql);
 $db->next_record();
 $vRecordCount=$db->num_rows();
 $vPageCount=ceil($vRecordCount/$vBatasBaris);

?>



<script language="JavaScript" type="text/JavaScript">


$(document).ready(function(){
    $('#caption').html('Royalty Preview <?=$vUserChoosed?>');


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
	<link rel="stylesheet" href="../css/screen.css">

	
	
 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />


<section>
    <!-- left side start-->
      <?  
      
     
      if ($_SESSION['Priv']=='administrator') 
           include "../framework/leftadmin.php"; 
        else
           include "../framework/leftmem.php"; 
     
     ?>
    <!-- main content start-->
    <div class="main-content" >

     <?   if ($_SESSION['Priv']=='administrator') 
           include "../framework/headeradmin.php"; 
        else
           include "../framework/headermem.php";    
     
     ?>
           <!--body wrapper start-->
 <section class="wrapper">
        <!-- page start-->

<form action="" method="post" name="demoform">

          <div style="display:inline" align="left">
                   &nbsp; &nbsp;&nbsp;&nbsp;
          
          </div>
          <br />
          <div class="row">
          <div class="col-lg-8">

		  <table style="width: 75%">
			  <tr>
				  <td style="height: 22px; width: 154px;"> <strong>Period</strong>&nbsp;</td>
				  <td style="height: 22px" nowrap="">  
				  <select name="cbMonth" id="cbMonth" class="form-control" style="max-width:10em;display:inline">
<option selected="selected">Bulan</option>
<?php
$bln=array(1=>"Januari","Februari","Maret","April","Mei","Juni","July","Agustus","September","Oktober","November","Desember");
for($bulan=1; $bulan<=12; $bulan++){
if ((int) $bulan == (int) $vBulNow)
   $vSel='selected';
else $vSel='';   
if($bulan<=9) { echo "<option $vSel value='0$bulan'>$bln[$bulan]</option>"; }
else { echo "<option $vSel value='$bulan'>$bln[$bulan]</option>"; }
}
?>
</select>&nbsp;&nbsp;
          <select name="cbYear" id="cbYear" class="form-control" style="max-width:10em;display:inline">
<option selected="selected">Tahun</option>
<?php
for($i=date('Y'); $i>=date('Y')-10; $i-=1){
if ((int) $i == (int) date("Y"))
   $vSel='selected';
else $vSel='';   

echo"<option $vSel value='$i'> $i </option>";
}
?>
</select> </td>
			  </tr>
			  <tr class="hide">
				  <td style="width: 154px; height: 26px;"><strong>Reg. Package</strong>
</td>
				  <td style="height: 26px"><select name="lmPaket" id="lmPaket" class="form-control">
				  <option value="">--All--</option>
				  <option value="S" <? if ($vPaket=='E' ||  $vPaket=="S") echo 'selected'; ?>>Silver</option>
				  <option value="G" <? if ($vPaket=='B' ||  $vPaket=="G") echo 'selected'; ?>>Gold</option>
				  <option value="P" <? if ($vPaket=='F' ||  $vPaket=="P") echo 'selected'; ?>>Platinum</option>




				  </select></td>
				  
			  </tr>
			  <tr class="hide">
				  <td style="width: 154px; height: 22px"><strong>Sort by</strong></td>
				  <td style="height: 22px">
				  <select name="lmSort" id="lmSort"  class="form-control">
				  <option value="">All</option>
				  <option value="T" <? if ($vSort=='T') echo 'selected'; ?>>Tgl Daftar</option>
				  <option value="P" <? if ($vSort=='P') echo 'selected'; ?>>Purchase Amount</option>
				 



				  </select></td>
			  </tr>
		  
 <tr >
				  <td style="width: 154px; height: 22px"><strong>Registrant</strong>
					</td>
				  <td style="height: 22px">
				  <input type="text" name="tfRegis" id="tfRegis" value="<?=$_POST['tfRegis']?>" class="form-control">
				</td>
			  </tr>
			  

			  
			  <tr>
				  <td style="width: 154px; height: 22px;"></td>
				  <td style="height: 22px"></td>
			  </tr>
		  </table>
		  </div>
		  </div>
          <input style="display:inline" name="Submit22" type="submit" class="btn btn-success" value="Refresh"><br />
		  <br>
		  <br>


    <div class="table-responsive">
    <div style="font-weight:bold;width:80%;color:#900">This table is only the preview for your royalty bonus. You will earn the total bonus at the end of this month if you do at least 1 sponsorship of any package or at least generate 1 pairing</div>
        <table border="0" class="table table-striped" style="width:79%">
          <tr >
            <td style="height: 24px; width: 4%;"><strong>No.</strong></td>
            <td style="height: 24px; width: 16%;"><div align="center"><strong>Date</strong></div></td>
            <td style="height: 24px; width: 44%;" align="center"><strong>Description</strong></td>
            <td style="height: 24px; width: 26%;" align="center"><strong>Registrant</strong></td>
            <td align="center" style="height: 24px; width: 10px;"><strong>Amount </strong></td>
          </tr>
          <? 
            

			  $vsql="select  sum(ffee) as fsumfee from tb_kom_mtx where ffeestatus='0' and fidmember='$vUserChoosed' "; 
			 $vsql.=$vCrit;
			$db->query($vsql);
			$db->next_record();
		    $vTotal=$db->f('fsumfee');

             $vNo=0;
			 $vsql="select  * from tb_kom_mtx where ffeestatus='0' and fidmember='$vUserChoosed' "; 
			$vsql.=$vCrit;
			
			 
			  $vsql.= $vOrder ;
			 $vsql.="limit $vStartLimit ,$vBatasBaris ";
		     $db->query($vsql);
		     $vCount=0;
			 //$vTotJualL=0;$vTotalJualR=0;
			 $vTot=0;
			 while ($db->next_record()) {
			 $vNo++;
				 $vIdMember=$db->f('fidmember');
				 $vTanggal=$oPhpdate->YMD2DMY($db->f('ftanggal'));
				 $vDesc=$db->f('fdesc');
				 if ($vDesc=='') $vDesc = 'Bonus Royalty';
				$vAmount=$db->f('ffee');

				 $vKotaName = $oMember->getWilName('ID',$vProp,$vKota,'00','0000');
				 
				 

		  ?>
          <tr>
            <td style="width: 4%; height: 24px;" ><?=$vNo+$vStartLimit?></td>
            <td style="height: 24px; width: 16%;" align="center"><?=$vTanggal?></td>
            <td style="height: 24px; width: 44%;" align="left"><?=$vDesc?></td>
            <td style="height: 24px; width: 26%;" align="left"><?=$db->f('fidregistrar')?></td>
            <td style="height: 24px; width: 10px;" align="right"><?=number_format($vAmount,0,",",".");?></td>
          </tr>
           <? } ?>
          </table>    
     </div>  
            
     <table width="90%">
     <tr>
      <td align="center" style="display:">
        
        <p>
          <?
   for ($i=0;$i<$vPageCount;$i++) {
     $vOffset=$i*$vBatasBaris;
     if ($i!=$vPage) {
?>
          <a href="bnsroyalty.php?uPage=<?=$i?>&tfRegis=<?=$vRegis?>&&uAwal=<?=$oPhpdate->DMY2YMD($oPhpdate->YMD2DMY($vAwal,"-"),"-")?>&uAkhir=<?=$oPhpdate->DMY2YMD($oPhpdate->YMD2DMY($vAkhir,"-"),"-")?>" >
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
       <h3>        Total balance : <?=number_format($vTotal,0,",",".");?>
       </h3><br><br>
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
      <!-- page end-->
        </section>
<button style="margin-left:2em" class="btn btn-info btn-sm" onClick="document.location.href='../manager/getexcel.php?arr=royalty&file=bnstitik_report_<?=$vUserChoosed?>'"><i class="fa fa-file-text-o"></i> Export Excel</button>         
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
