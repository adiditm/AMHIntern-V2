<?php

		if ($_GET['op'] != '') 
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

<div class="right_col" role="main" style="min-height:1px !important">
		<div><label><h3>Status Reward</h3></label></div> 



<form action="" method="post" name="demoform">



                  <div class="row">
          <div class="col-lg-12">
          <input name="Submit22" type="submit" class="btn btn-success" value="Refresh">
        
          </div>
          </div>




    <div class="table-responsive">

        <table width="100%" border="0" class="table table-striped" style="width:100%">

          <tr style="font-weight:bold">

            <td width="5%" ><strong>No.</strong></td>
            <td width="12%" ><div align="center"><strong>Syarat Reward <br />(Kaki Lemah)	</strong></div></td>
            <td width="31%"><div align="center"><strong>Jenis Reward</strong> 
            </div></td>
            <td width="13%" align="center"  class="hide"><div align="center"><strong>Perolehan Pasang PR <br />(Kiri - Kanan)</strong></div></td>
            <td width="11%" align="center" ><strong>Total PR Anda	Mencapai/Belum</strong></td>
            <td width="14%" align="center" ><strong>Pencairan</strong></td>

          </tr>

          <? 


             $vNo=0;

			 $vsql="select *  from m_rewards a  where 1   order by a.flevel  "; 			 
		     $db->query($vsql);
	if ($db->num_rows() > 0) {
			 $vTot=0;$vLastOmzet=0;
			 while ($db->next_record()) {
				 $vLevel=$db->f('flevel');
				  $vSQLin="select * from tb_rewards where flevel='$vLevel' and fkdanggota='$vUser'";
				 $dbin->query($vSQLin);
				 $dbin->next_record();
				$vOmzet = $dbin->f('fomzet');
				 if ($vOmzet=='') $vOmzet=0;
				 
			 $vNo++;
				 $vSyaratNom=$db->f('fjmlangg');
				 $vSyaratText="Kaki kecil ".number_format($db->f('fjmlangg'),0)." pasang PR";;
				 $vReward=$db->f('freward')." / ".number_format($db->f('fnominal'),0,",",".");
				 $vName=$oMember->getMemberName($vUser);
				// $vOmzet=number_format($db->f('fomzet'),0,",",".");
				 if ($vOmzet >0 ) $vLastOmzet = $vOmzet;
				 

		
				 
				 $vOmzetPR = $vOmzet;
				 
				 
				 $vKetClaim=$oKomisi->getKetClaim($vUser,$db->f('flevel'));
				  $vKetClaimText='-';
				 if ($vKetClaim != '-') 
				     $vKetClaimText='<b>Claimed:</b> '.$vKetClaim;
				 	 
				 $vPaket=$oMember->getPaket($vUser);
				 
				if ($vOmzetPR >= $vSyaratNom)
				   $vStatus="Sudah";
				else $vStatus = "Belum";   
				

		  ?>

          <tr>

            <td  ><?=$vNo?></td>
            <td  align="left" nowrap><div align="left">
              <?=$vSyaratText?>
            </div></td>
            <td  align="center"><div align="left">
              <?=$vReward?>
            </div></td>
            <td  align="right" class="hide"><div align="right">
              <?=number_format(round($vOmzetPR,2),2,",",".")?>
            </div></td>
            <td align="right"><div align="center">
              <?=$vStatus?>
            </div></td>
            <td align="right"><div align="left"><?=$vKetClaimText?></div></td>

          </tr>

           <? } 
	} else {
		   ?>
           
           <tr><td colspan="5" style="font-weight:bold" align="center">No reward data!</td></tr>
<? } ?>
          </table>    
          <br />
          <b>Omzet: <?=number_format($vLastOmzet,0,",",".");?> Pasang PR</b>
          
        
</div>  

            

     <table width="90%">

     <tr class="hide">

      <td align="center">

        

        

        

        </td>

    </tr>

        <tr > 

      <td  align="left" valign="top" style="font-weight:bold">

       <b>
        <?
			
		?>
    <!--    Omzet Group Kiri : <?=number_format($vOmzetL+$vOmzetKakiL,0,",",".")?><br />
        Omzet Group Kanan : <?=number_format($vOmzetR+$vOmzetKakiR,0,",",".")?>-->
        </b>

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
	


<? include_once("../framework/member_footside.blade.php") ; ?>