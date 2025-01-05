<? include_once("../framework/member_headside.blade.php");?>



<?php

$vUserHO = $vUser;

$vAwal=$_POST['dc'];

$vAkhir=$_POST['dc1'];
$vSerno=$_POST['tfSerno'];



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



$vCrit.=" and date(a.ftanggal) >= '$vAwal' and date(a.ftanggal) <= '$vAkhir' " ;



if ($vPaket !='')
   $vCrit.=" and b.fpaket='$vPaket' ";

if ($vSerno !='')
   $vCrit.=" and a.fidmember='$vSerno' ";



if ($vSort =='T')

   $vOrder.=" order by ftanggal ";

else  if ($vSort =='P') 

   $vOrder.=" order by sum(a.fsubtotal) desc ";

else    $vOrder.=" order by a.ftanggal desc ";







			 			 $vsql="select  distinct date(a.ftanggal) as ftanggal, a.fidmember, a.fidpenjualan from tb_kit_active a left join tb_skit b on a.fidmember=b.fserno  where  b.fpendistribusi='$vUserHO' $vCrit "; 




						 

			 

			 $vsql.=$vOrder;

			 

 $db->query($vsql);

 $db->next_record();

 $vRecordCount=$db->num_rows();

 $vPageCount=ceil($vRecordCount/$vBatasBaris);



?>







<script language="JavaScript" type="text/JavaScript">





$(document).ready(function(){

    $('#caption').html('Report RO Member');





      $('#dc').datepicker({

                    format: "yyyy-mm-dd",

                    autoclose : true

    }); 

  

  

       $('#dc1').datepicker({

                    format: "yyyy-mm-dd",

                    autoclose : true

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

function doCancel(pParam,pSer){
	var vSucc=/success/g
	if (confirm('Yakin membatalkan aktifasi serial '+pSer+'?')) {
		var vURL = '../main/mpurpose_ajax.php?op=cancelactst&idsell='+pParam+'&ser='+pSer+'&mem=<?=$vUser?>';
		$.get(vURL, function(data){
			if (vSucc.test(data)) {
			   alert('Aktifasi serial '+pSer+' sudah dibatalkan!');	
			   $('#tr'+pSer).hide();
			}
		});
	}
	
	return false;
}
</script>

	<link rel="stylesheet" href="../css/screen.css">



	

	

 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />




          		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<h4>
				  <li><a href="javascript:;">KIT Active list in Stockist <?=$vUser?>
			  </a></li></h4>
				
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">&nbsp;</small></h1>


<form action="" method="post" name="demoform">



          <div style="display:inline" align="left">

                   &nbsp; &nbsp;&nbsp;&nbsp;

          

          </div>

          <br />

		  <table style="width: 75%">

			  <tr>

				  <td style="height: 22px; width: 154px;"> <strong>Mulai Tanggal :  </strong>&nbsp;</td>

				  <td style="height: 22px"><strong>  <input style="width:100px;display:inline" class="form-control" name="dc" id="dc" size="11" value="<?=$vAwal?>">s/d</strong>

          <input style="width:100px;display:inline" class="form-control" name="dc1" id="dc1" size="11" value="<?=$vAkhir?>"> </td>

			  </tr>

			  <tr>

				  <td style="width: 154px"><strong>Paket</strong>

</td>

				  <td><select name="lmPaket" id="lmPaket" class="form-control">

				  <option value="">All</option>
				 <?
                     $vSQL="select * from m_paket ";
					 $dbin->query($vSQL);
					 while($dbin->next_record()) {
						 $vCode=$dbin->f('fpackid');
						 $vName=$dbin->f('fpackname');
				 ?>	
				  <option value="<?=$vCode?>" <? if ($vPaket==$vCode) echo 'selected'; ?>><?=$vName?></option>
                  <? } ?>

				









				  </select></td>

				  

			  </tr>

			  <tr class="hide">

				  <td style="width: 154px; height: 22px"><strong>Sort</strong>

</td>

				  <td style="height: 22px">

				  <select name="lmSort" id="lmSort"  class="form-control">

				  <option value="">All</option>

				  <option value="T" <? if ($vSort=='T') echo 'selected'; ?>>Tgl Daftar</option>

				  <option value="P" <? if ($vSort=='P') echo 'selected'; ?>>Purchase Amount</option>

				 







				  </select></td>


<tr>

				  <td style="width: 154px"><strong>Serial</strong>

</td>

				  <td>
				    <input class="form-control" name="tfSerno" id="tfSerno" size="25" value="<?=$vSerno?>">
				  </td>

				  

		    </tr>
			  </tr>

			  <tr>

				  <td style="width: 154px">&nbsp;</td>

				  <td>&nbsp;</td>

			  </tr>

		  </table>

          <input style="display:inline" name="Submit22" type="submit" class="btn btn-primary" value="Refresh"><br />

		  <br>

		  <br>





    <div class="table-responsive">

        <table border="0" class="table table-striped" style="width:98%">

          <tr style="font-weight:bold">

            <td width="3%"><strong>No.</strong></td>

            <td width="7%"><div align="center"><strong>Activation Date</strong></div></td>

            <td width="11%" align="center" " ><strong>KIT Serial</strong></td>

            <td width="10%" align="center" "><strong>ID Activation</strong></td>

            <td width="26%" align="center"><strong>Items </strong></td>
            <td width="10%" align="center">Status</td>
            <td width="10%" align="center">Packet</td>

            <td width="15%" align="center"><strong>Stockist </strong></td>
            <td width="2%" align="center">&radic;</td>

          </tr>

          <? 

            



		



             $vNo=0;

			 $vsql="select  distinct date(a.ftanggal) as ftanggal, a.fidmember, a.fidpenjualan,fnostockist from tb_kit_active a left join tb_skit b on a.fidmember=b.fserno  where  b.fpendistribusi='$vUserHO' $vCrit "; 

			// $vsql.=$vCrit;

			 

			  $vsql.= $vOrder ;

			// $vsql.="limit $vStartLimit ,$vBatasBaris ";

		     $db->query($vsql);

		     $vCount=$db->num_rows();

			 //$vTotJualL=0;$vTotalJualR=0;

			 $vTot=0;

			 while ($db->next_record()) {

			 $vNo++;

				 $vIdMember=$db->f('fidmember');

				 $vTanggal=$db->f('ftanggal');
				 $vKIT=$db->f('fidmember');

				// $vNama=$db->f('fnama');

				// $vAlamat=$db->f('falamat');

				//$vKota=$db->f('fkota');

			//	$vProp=$db->f('fpropinsi');

				$vBelanja=$db->f('ftot');



				 $vKotaName = $oMember->getWilName('ID',$vProp,$vKota,'00','0000');

				 

				 



		  ?>

          <tr id="tr<?=$vKIT?>">

            <td style="width: 4%; height: 24px;" ><?=$vNo+$vStartLimit?></td>

            <td align="center" nowrap><?=$vTanggal?></td>

            <td align="center"><?=$vKIT?></td>

            <td align="center"><?=$db->f('fidpenjualan')?></td>

            <td align="left"><?
                  $oJual->dispDetAct($db->f('fidpenjualan'),$vKIT);
			?></td>
            <td align="center">
            <? $vStatus=$oJual->getKitStatus($vKIT);
			   $vUsedBy="by ".$oMember->getFieldByField('fserno','fidmember',$vKIT);
			   $vUsedByName=$oMember->getFieldByField('fserno','fnama',$vKIT);
			   
			   if ($vStatus==1) 
			      echo "Used $vUsedBy ($vUsedByName)";
				else echo "Not Used";  
			?>
            </td>
            <td align="center"><?
               $vPack=$oJual->getKitPack($vKIT);
			   echo $oProduct->getPackName($vPack['id']);
			
			?></td>

            <td align="center">&nbsp;<?=$db->f('fnostockist')?></td>
            <td align="center">
            <? if ($vStatus !='1') {?>
            <input type="button" name="btnCancel" id="btnCancel" class="btn btn-sm btn-success" value="Cancel" onClick="return doCancel('<?=$db->f('fidpenjualan')?>','<?=$vKIT?>')"> <?  } ?></td>

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

          <a href="rptromember.php?uPage=<?=$i?>&amp;uAwal=<?=$oPhpdate->DMY2YMD($oPhpdate->YMD2DMY($vAwal,"-"),"-")?>&amp;uAkhir=<?=$oPhpdate->DMY2YMD($oPhpdate->YMD2DMY($vAkhir,"-"),"-")?>" >

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

       <h4>        Total &nbsp; : <?=number_format($vCount,0,",",".");?> KIT Active</h4>
       <br><br>

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