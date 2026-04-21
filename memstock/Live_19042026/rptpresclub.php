<?php

		if ($_GET['op'] != '') 
           include_once("../framework/admin_headside.blade.php");
        else
           include_once("../framework/member_headside.blade.php") ;  
		
		include_once("../classes/networkclass.php");  
		include_once("../classes/komisiclass.php");  

		
?>	

<?php



$vAwal=$_POST['dc'];

$vAkhir=$_POST['dc1'];
$vLevelPost=$_POST['lmLevel'];
$vFltUser=$_POST['tfUser'];
$vCrit='';


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



//$vCrit.=" and date(ftanggal) >= '$vAwal' and date(ftanggal) <= '$vAkhir'" ;

if ($vFltUser !='')
   $vCrit.=" and fkdanggota='$vFltUser' ";

if ($vLevelPost !='')
   $vCrit.=" and fperingkat='$vLevelPost' ";







			 $vsql="select  * from m_rewards   where 1  "; 

			 $vsql.=$vCrit;

			 

			 

			 $vsql.=" order by ftanggal ";

 $db->query($vsql);

 $db->next_record();

 $vRecordCount=$db->num_rows();

 $vPageCount=ceil($vRecordCount/$vBatasBaris);



?>







<script language="JavaScript" type="text/JavaScript">





$(document).ready(function(){

    $('#caption').html('Reward Report ');





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





	

	

 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />

  	<div id="content" class="content">
			<ol class="breadcrumb pull-right">
				<h4><li><a href="javascript:;">Status Bonus President Club <? if ($vRefUser !='') echo " ($vRefUser)";?></a></li></h4>
				
			</ol>
<h1 class="page-header">&nbsp;</small></h1>


<form action="" method="post" name="demoform">



                  <div class="row">
          <div class="col-lg-12">
          <input name="Submit22" type="submit" class="btn btn-success" value="Refresh">
          </div>
          </div>
          <br>


          	
		




    <div class="table-responsive">

        <table width="100%" border="0" class="table table-striped" style="width:100%">

          <tr style="font-weight:bold;text-align:center">

            <td width="19%" ><div align="center"><strong>Syarat Perolehan</strong></div></td>
            <td width="12%" align="center"><strong>Status</strong></td>
            <td width="19%" align="center">Omzet Group Anda</td>
            <td width="17%" >Jml Member Yang Memenuhi Syarat (termasuk Anda)</td>
            <td width="16%"><div align="center"><strong>Reward</strong></div></td>
            <td width="17%" align="center" >Bonus</td>

            <td width="17%" align="center" ><strong>Ket</strong></td>

          </tr>

        

          <tr>

            <td  align="left" nowrap><div align="left">
              Memperoleh Semua Reward
            </div></td>
            <td  align="center"><?
                $vSemua=$oKomisi->isGotReward($vUser,6);
				if ($vSemua) 
				   echo "Terpenuhi";
				else echo "Belum Terpenuhi";   
			?></td>
            <td  align="center"><?
			   $vOmzetCompany = $oKomisi->getOmzetCompany();
			    
			   $vPresClub = $oRules->getSettingByField('fpresclub');
			   $v2Persen = $vOmzetCompany * $vPresClub / 100;
			   $vSelfOmzet=$oKomisi->getOmzetAllMember($vUser);
			   $vDownlineOmzet=$oKomisi->getOmzetWholeMember($vUser);
			   $vMyOmzet = $vSelfOmzet + $vDownlineOmzet;
			   
			   echo number_format($vMyOmzet,0,",",".") ?></td>
            <td  align="center"><?
				

                
				$vSQL="select count(fidsys) as fjml from tb_rewards where flevel=6 ";
				$db->query($vSQL);
				$db->next_record();
				$vJml=$db->f('fjml');
				echo number_format($vJml,0,",",".");
				if ($vJml<=0) $vJml =1;
				
			?></td>
            <td  align="center"><div align="left">
              <? if ($vSemua) { ?>
              <?="2% x ".number_format($vOmzetCompany,0,",",".")?> / <?=$vJml?>
              <? } else echo "-"; ?>
              </div></td>
            <td align="center"><?
               $vBonus = ($vMyOmzet / $vOmzetCompany) * $v2Persen;
			   if ($vSemua)
			      echo number_format($vBonus,0,",",".");
			   else echo 0;	  
			   $vKetClaimText="-";
			   
			?></td>

            <td align="right"><div align="left"><?=$vKetClaimText?></div></td>

          </tr>



          </table>    

</div>  

            

     <table width="90%">

     <tr class="hide">

      <td align="center">

        

        <p>

          <?

   for ($i=0;$i<$vPageCount;$i++) {

     $vOffset=$i*$vBatasBaris;

     if ($i!=$vPage) {

?>

          <a href="rptsumomzet.php?uPage=<?=$i?>&amp;uAwal=<?=$oPhpdate->DMY2YMD($oPhpdate->YMD2DMY($vAwal,"-"),"-")?>&amp;uAkhir=<?=$oPhpdate->DMY2YMD($oPhpdate->YMD2DMY($vAkhir,"-"),"-")?>" >

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

        <tr class="hide"> 

      <td  align="left" valign="top" style="font-weight:bold">

       <h3>        Total : <?=number_format($vNo,0,",",".");?></h3><br><br>

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