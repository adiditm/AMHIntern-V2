<?php

		if ($_GET['uMemberId'] != '') 
           include_once("../framework/admin_headside.blade.php");
        else
           include_once("../framework/member_headside.blade.php") ;  
		
		include_once("../classes/networkclass.php");  
		include_once("../classes/komisiclass.php");  
		include_once("../classes/ruleconfigclass.php");  

		
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
				<h4><li><a href="javascript:;">Status Rwd Tour Malaysia - Singapore - Batam<? if ($vUser !='') echo " ($vUser)";?></a></li></h4>
				
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

          <tr >

            <td width="5%" ><strong>No.</strong></td>
            <td width="12%" ><div align="center"><strong>Syarat Perolehan</strong></div></td>
            <td width="21%"><div align="center"><strong>Reward</strong></div></td>

            <td width="21%" align="center" ><div align="center"><strong>Perolehan Poin </strong></div></td>
            <td width="11%" align="center" ><strong>Mencapai/Belum</strong></td>
            <td width="10%" align="center" ><strong>Kekurangan</strong></td>
            <td width="20%" align="center" ><strong>Ket</strong></td>

          </tr>

          <? 


           $vNo=0;

			 $vsql="select * from m_rewards  where 1  and fkind='t' "; 			 
		     $db->query($vsql);
			 $vTot=0;
			 while ($db->next_record()) {
			 $vNo++;
				 $vSyaratNom=$db->f('fjmlangg');
				 $vSyaratText=$db->f('fsyarat');
				 $vReward=$db->f('freward');
				 $vName=$oMember->getMemberName($vUser);
				 
				 
				 
				 $vKetClaim=$oKomisi->getKetClaim($vUser,$db->f('flevel'));
				  $vKetClaimText='-';
				 if ($vKetClaim != '-') 
				     $vKetClaimText='<b>Claimed:</b> '.$vKetClaim;
				 	 
				
				 

		  ?>

          <tr>

            <td  ><?=$vNo?></td>
            <td  align="left" nowrap><div align="left">
              <?=$vSyaratText?>
            </div></td>
            <td  align="center"><div align="left">
              <?=$vReward?>
            </div></td>

            <td  align="left"><div align="left">
             <table width="99%" border="0">
  <tr>
    <td width="84%" align="left"><strong>Sponsor</strong></td>
    <td width="16%" align="left"><strong>Poin</strong></td>
  </tr>
  <tr>
    <td>Sponsor Executive
    <?
	    $vTotPoin=0;
        $vExe = $oNetwork->getSponsorshipCountPack($vUser,'S');
		$vPointExe=1;
		$vTotPoin+=$vExe * $vPointExe;
		
		$vExc = $oNetwork->getSponsorshipCountPack($vUser,'G');
		$vPointExc=3;
		$vTotPoin+=$vExc * $vPointExc;
		
		$vEli = $oNetwork->getSponsorshipCountPack($vUser,'P');
		$vPointEli=7;
		$vTotPoin+=$vEli * $vPointEli;


		$vMobSto = $oNetwork->getSponsorshipCountStock($vUser,'1');
		$vPointMobSto=4;
		$vTotPoin+=$vMobSto * $vPointMobSto;
		
		
			   $vSQL="select fstockist from m_anggota where fidmember='$vUser'";
			  //echo "<br>";
			  $dbin->query($vSQL);
			  $dbin->next_record();
			  $vPaket=$dbin->f('fstockist');

		
		//$vAsMobSto = $oNetwork->getSponsorshipCountSto($vUser,'1');
		if ($vPaket=='1')
		   $vAsMobSto=20;
		else   $vAsMobSto=0; 
		$vTotPoin+= $vAsMobSto;
		
		echo " ($vExe)";
	?>
    </td>
    <td align="right">: <?=number_format($vExe * $vPointExe,0,",",".");?></td>
  </tr>
  <tr>
    <td>Sponsor Exclusive (<?=$vExc?>)</td>
    <td align="right">: <?=number_format($vExc * $vPointExc,0,",",".");?></td>
  </tr>
  <tr>
    <td>Sponsor Elite (<?=$vEli?>)</td>
    <td align="right">: <?=number_format($vEli * $vPointEli,0,",",".");?></td>
  </tr>
 <tr>
    <td>Sponsor Mob. Stokis (<?=$vEli?>)</td>
    <td align="right">: <?=number_format($vMobSto * $vPointMobSto,0,",",".");?></td>
  </tr>  
  <tr>
    <td>Sbg. Mobile Stokis</td>
    <td align="right">: <?=number_format( $vAsMobSto,0,",",".");?></td>
  </tr>
  <tr>
    <td>Total Poin</td>
    <td align="right">: <?=number_format($vTotPoin,0,",",".");?></td>
  </tr>


</table>

            </div></td>
            <td align="right"><div align="center">
              <?
				  $vKetClaimText='-';
				 if ($vKetClaim != '-') 
				     $vKetClaimText='<b>Claimed:</b> '.$vKetClaim;
				
				
				 if ($vTotPoin >= $vSyaratNom )
				   $vStatus="Sudah";
				 else $vStatus="Belum";  
              
			  
			  echo $vStatus;?>
            </div></td>
            <td align="right"><div align="center">
              <? 
			  $vKurang=$vSyaratNom-$vTotPoin;
			  if ($vKurang <=0) $vKurang=0;
			 echo number_format($vKurang,0,",",".");?>
            </div></td>
            <td align="right"><div align="left"><?=$vKetClaimText?></div></td>

          </tr>

           <? } ?>

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