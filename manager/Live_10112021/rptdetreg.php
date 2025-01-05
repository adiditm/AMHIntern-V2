<? include_once("../framework/admin_headside.blade.php")?>



<?php

$vClass=$_GET['class'];
if ($vClass=='E' || $vClass=='S')
   $vCText='Executive';
else if ($vClass=='B' || $vClass=='G')
   $vCText='Exclusive';
if ($vClass=='F' || $vClass=='P')
   $vCText='Elite';
   
   

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



$vCrit.=" and date(ftgldaftar) >= '$vAwal' and date(ftgldaftar) <= '$vAkhir'" ;







			 $vsql="select  fidmember,ftgldaftar,fnama,falamat,fkota,fpropinsi from m_anggota where  fpaket = '".$_GET['class']."'"; 



			 $vsql.=$vCrit;

			 

			 

			 $vsql.=" order by ftgldaftar";



			//Export Excel
			$db->query($vsql);
			$vArrData="";
			$vArrDateFilter=array('Date Filter : ',$vAwal." - ".$vAkhir." ($vCText)",'','');
			$vArrBlank=array('','','','','');
			$vArrHead=array('No.','Date','Username','Name','Address');
			
			$i=0;
			$vArrData[]=$vArrDateFilter;
			$vArrData[]=$vArrBlank;
			$vArrData[]=$vArrHead;
			
			while ($db->next_record()) { //Convert Excel
			     $i++;


				 $vIdMember=$db->f('fidmember');
				 $vTanggal=$db->f('ftgldaftar');
				 $vNama=$db->f('fnama');
				 $vAlamat=$db->f('falamat');
				 $vKota=$db->f('fkota');
				 $vProp=$db->f('fpropinsi');
				 $vKotaName = $oMember->getWilName('ID',$vProp,$vKota,'00','0000');

				 $vArrData[]=array($i,$vTanggal,$vIdMember,$vNama,$vAlamat.' '.$vKotaName);
				//$vArrMem['fpassword'][$i]=$oSystem->doED('decrypt',$db->f('fpassword'));
			
			}
			//$vArrTot=array('','','Total',$vTot);
			//$vArrData[]=$vArrTot;
			
			$_SESSION['detreg']=$vArrData;
			

			 

 $db->query($vsql);

 $db->next_record();

 $vRecordCount=$db->num_rows();

 $vPageCount=ceil($vRecordCount/$vBatasBaris);



?>







<script language="JavaScript" type="text/JavaScript">





$(document).ready(function(){

    $('#caption').html('Reg. Report Detail Class <?=$vCText?>');





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



				
<div class="right_col" role="main">
		<div><label><h3>Reg. Report Detail  <?=$vCText?></h3></label></div>


<form action="" method="post" name="demoform">



          <div style="display:inline" align="left">

          	<strong>Date : </strong>

          <input style="width:100px;display:inline" class="form-control" name="dc" id="dc" size="11" value="<?=$vAwal?>">&nbsp; 
			  <strong>to</strong>

          <input style="width:100px;display:inline" class="form-control" name="dc1" id="dc1" size="11" value="<?=$vAkhir?>"> &nbsp;&nbsp;

          <input style="display:inline" name="Submit22" type="submit" class="btn btn-success" value="Refresh">

          

          </div>

          <br /><br />

		  <input name="button" class="btn btn-success" type="button" value="&laquo; Back to Summary" onclick="document.location.href='../manager/rptsumreg.php?current=<?=$_GET['current']?>'"><br>

		  <br>





    <div class="table-responsive">

        <table width="80%" border="0" class="table table-striped" style="width:80%">

          <tr >

            <td style="height: 24px; width: 4%;"><strong>No.</strong></td>

            <td style="height: 24px; width: 26%;"><div align="center"><strong>
				Date</strong></div></td>

            <td style="height: 24px; width: 36%;" align="center"><strong>
			Username</strong></td>

            <td align="center" style="height: 24px; "><strong>Name </strong></td>

            <td align="center" style="height: 24px; "><strong>Address </strong></td>

          </tr>

          <? 

            



		



             $vNo=0;

			 $vsql="select  fidmember,ftgldaftar,fnama,falamat,fkota,fpropinsi from m_anggota where  fpaket = '".$_GET['class']."'"; 

			 $vsql.=$vCrit;

			 

			  $vsql.=" order by ftgldaftar ";

			// $vsql.="limit $vStartLimit ,$vBatasBaris ";

		     $db->query($vsql);

		     $vCount=$db->num_rows();

			 //$vTotJualL=0;$vTotalJualR=0;

			 $vTot=0;

			 while ($db->next_record()) {

			 $vNo++;

				 $vIdMember=$db->f('fidmember');

				 $vTanggal=$db->f('ftgldaftar');

				 $vNama=$db->f('fnama');

				 $vAlamat=$db->f('falamat');

				$vKota=$db->f('fkota');

				$vProp=$db->f('fpropinsi');



				 $vKotaName = $oMember->getWilName('ID',$vProp,$vKota,'00','0000');

				 



		  ?>

          <tr>

            <td style="width: 4%; height: 24px;" ><?=$vNo+$vStartLimit?></td>

            <td style="height: 24px; width: 26%;" align="center"><?=$vTanggal?></td>

            <td style="height: 24px; width: 36%;" align="center"><?=$vIdMember?></td>

            <td style="height: 24px; " align="left"><?=$vNama?></td>

            <td style="height: 24px; " align="left"><?=$vAlamat.' '.$vKotaName?></td>

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

          <a href="rptdetreg.php?uPage=<?=$i?>&amp;uAwal=<?=$oPhpdate->DMY2YMD($oPhpdate->YMD2DMY($vAwal,"-"),"-")?>&amp;uAkhir=<?=$oPhpdate->DMY2YMD($oPhpdate->YMD2DMY($vAkhir,"-"),"-")?>" >

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
<button class="btn btn-info btn-sm" onClick="document.location.href='../manager/getexcel.php?arr=detreg&file=detail_registration'"><i class="fa fa-file-text-o"></i> Export Excel</button>
      




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


<? include_once("../framework/admin_footside.blade.php") ; ?>