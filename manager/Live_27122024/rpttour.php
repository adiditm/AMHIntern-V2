<? include_once("../framework/admin_headside.blade.php")?>
<? include_once("../classes/networkclass.php");
include_once("../server/config.php");
include_once("../classes/ruleconfigclass.php");
$vInitVal=20;
$vFilterPoin = $_POST['tfPoin'];
if ($vFilterPoin=='')
   $vFilterPoin = $vInitVal;
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


function claimReward1(pUser,pLevel) {
   $('#hUser').val(pUser);
   $('#hIdSys').val(pLevel);
   $('#spReward').html(pUser+' / '+pLevel);   
   $('#btnModal').trigger('click');	
}

function claimReward(pUser,pIdsys,pBukti) {
    var vURL="../main/mpurpose_ajax.php?op=claimtour";
   if (confirm('Yakin melakukan claim terhadap reward promo tour untuk member '+pUser+'?')) {
		   $('#spClaim').show();
		   $('#btClaim').hide();
		   $('#spClaim').html('<img src="../images/ajax-loader.gif" />');
		   $.post(vURL, {level : pIdsys, user : pUser, bkt: pBukti},function(data) {
				  // alert(data);
				$('#spClaim').hide();
				$('#btClaim').show();
				$('#divClaimed').html('&radic;&nbsp; Sudah');
				document.getElementById('btClaim').disabled=true;
				if (data.trim()=='success')	{
				   alert('Tour sudah diclaim!');
				   document.location.href='../manager/rpttour.php';
				} else   { alert('Proses claim gagal!');
				   document.getElementById('btClaim').disabled=false;
				}
				
			  
		  });
  
   }
		
}

</script>

	



	

	

 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />


<div id="content" class="content ">
			<ol class="breadcrumb pull-right">
				<h4><li><a href="javascript:;">Tour Promo Report </a></li></h4>
				
			</ol>
<h1 class="page-header">&nbsp;</small></h1>
<button type="button" class="btn btn-info btn-lg hide" id="btnModal" data-toggle="modal" data-target="#dialogModal">Open Modal</button>

<div class="modal fade" id="dialogModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="modalhead">Claim Tour [<span id="spReward"></span>]</span></h4>
        </div>
        <div class="modal-body " style="padding: 2em 4em 3em 4em">
        <div class="row">
             <div class="col-lg-12" id="divContent">
                 Masukkan catatan atau bukti pengambilan/pengiriman jika diperlukan :
                 <textarea cols="30" rows="5" name="tfResi" id="tfResi" class="form-control" value="-"></textarea>
             </div>
           
          </div>
          



        </div>
        <div class="modal-footer">
          <input type="hidden" id="hUser" name="hUser" value="" />
          <input type="hidden" id="hLevel" name="hLevel" value="" />
          <input type="hidden" id="hIdSys" name="hIdSys" value="" />

          <button type="button" id="btSubmit" name="btSubmit" class="btn btn-success" data-dismiss="modal" onClick="claimReward($('#hUser').val(),$('#hIdSys').val(),$('#tfResi').val())">Submit</button>
          <button type="button" id="btClose" name="btClose" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

<form action="" method="post" name="demoform">



                  <div class="row">
          <div class="col-lg-6" >
         <div class="form-inline">
         Poin minimum: <input name="tfPoin" type="text" class="form-control" id="tfPoin" value="<?=$vFilterPoin?>" style="width:5em">&nbsp;<input name="Submit22" type="submit" class="btn btn-success" value="Refresh">
         </div>
          </div>
          </div>
          <br>


    <div class="table-responsive">

        <table width="76%" border="0" class="table table-striped" style="width:100%">

          <tr >

            <td width="3%" ><strong>No.</strong></td>
            <td width="9%"><div align="center"><strong>Username</strong></div></td>

            <td width="20%" align="center"><strong>Name</strong></td>

            <td width="11%" align="center" ><strong>Perolehan Poin</strong></td>
            <td width="9%" align="center" ><strong>Claimed</strong></td>
            <td width="29%" align="center" ><strong>Detail</strong></td>
            <td width="13%" align="center" ><strong>&radic;</strong></td>

          </tr>

          <? 


			$vIdPromo = 'P-001';
			$vSQL="select * from m_promo where fidpromo='$vIdPromo'";
			$db->query($vSQL);
			$db->next_record();
			$vStart=$db->f('fstart');
			$vEnd=$db->f('fend');	


			$vStartLimit = 300000;
			$vBatasBaris = 0;
			
             $vNo=0;

			 $vsql="select a.*, b.fnama, b.fstockist from tb_promo a left join m_anggota b on a.fidmember=b.fidmember where a.fidpromo='P-001'  "; 

			 $vsql.=$vCrit;

			 


			  $vsql.=" order by a.fomzet desc, b.fnama ";

			// $vsql.="limit $vStartLimit ,$vBatasBaris ";

		     $db->query($vsql);
			


			 $vTot=0;
				$vPoinPromo = $oRules->getSettingByField('fpoinpromo1');
			 while ($db->next_record()) {

			     $vClaimedText='';
				 $vIdMember=$db->f('fidmember');
				 $vTanggal=$db->f('ftanggal');
				 $vName=$db->f('fnama');
				 $vTotPoin=$db->f('fomzet');
				 $vIdSys=$db->f('fidsys');
				 $vPaid=$db->f('fpaid');
				 $vStockistType=$db->f('fstockist');
				 $vTglPaid=$oPhpdate->YMD2DMY($db->f('ftglpaid'));
				 if ($vPaid=='1')
				    $vClaimedText="Claimed at <br> $vTglPaid";
				 //$vTglAktif=$db->f('ftglaktif');
				 
				 
//Calculate Poin
 /*	
	    $vTotPoin=0;
        $vExe = $oNetwork->getSponsorshipCountPack($vIdMember,'S');
		$vPointExe=1;
		$vTotPoin+=$vExe * $vPointExe;
		
		$vExc = $oNetwork->getSponsorshipCountPack($vIdMember,'G');
		$vPointExc=3;
		$vTotPoin+=$vExc * $vPointExc;
		
		$vEli = $oNetwork->getSponsorshipCountPack($vIdMember,'P');
		$vPointEli=7;
		$vTotPoin+=$vEli * $vPointEli;

		$vStock = $oNetwork->getSponsorshipCountStock($vIdMember,'1');
		$vPointStock=4;
		$vTotPoin+=$vStock * $vPointStock;*/
		
	/*		   $vSQL="select fstockist from m_anggota where fidmember='$vIdMember'";
			  //echo "<br>";
			  $dbin->query($vSQL);
			  $dbin->next_record();
			  $vIsStock=$dbin->f('fstockist');


			   $vSQL="select *, date(ftglentry) as ftgl from tb_logchange where fkdanggota='$vIdMember' and fnew='1'";
			  //echo "<br>";
			  $dbin->query($vSQL);
			  $dbin->next_record();
			  $vTglUpgrade=$dbin->f('ftgl');

		
		
		if ($vIsStock=='1')
		   $vPointMobSto=20;
		else   $vPointMobSto=0;
		
		if ($vTglUpgrade >= '2017-09-01' && $vTglUpgrade <= '2018-02-29')
		   $vTotPoin+= $vPointMobSto;
		
		
	
		
				*/

				 if ($vTotPoin >= $vFilterPoin) {
					//echo $vTotPoin."<br>";
				  $vNo++;
		  ?>   

          <tr>

            <td  ><?=$vNo?></td>
            <td  align="left"><?=$vIdMember?></td>

            <td  align="left"><?=$vName?></td>

            <td align="right"><div align="right">
              <?=$vTotPoin?>
            </div></td>
            <td align="right" nowrap><div align="center" id="divClaimed"><?=$vClaimedText?></div></td>
            <td align="center"><div align="left"><table width="99%" border="0">
  <tr>
    <td width="84%" align="left"><strong>Sponsor</strong></td>
    <td width="16%" align="left"><strong>Poin</strong></td>
  </tr>
  <tr>
         

    <td>Sponsor Executive (<?=$oNetwork->getSponsorshipCountPack($vIdMember,'S',$vStart,$vEnd);?>)
    
    </td>
    <td align="right">: <?=number_format($db->f('fpoinexec'),0,",",".");?></td>
  </tr>
  <tr>
    <td>Sponsor Exclusive (<?=$oNetwork->getSponsorshipCountPack($vIdMember,'G',$vStart,$vEnd);?>)</td>
    <td align="right">: <?=number_format($db->f('fpoinexcl'),0,",",".");?></td>
  </tr>
  <tr>
    <td>Sponsor Elite (<?=$oNetwork->getSponsorshipCountPack($vIdMember,'P',$vStart,$vEnd);?>)</td>
    <td align="right">: <?=number_format($db->f('fpoinelit'),0,",",".");?></td>
  </tr>
  <tr>
    <td>Sponsor Mob. Stockist (<?=$oNetwork->getSponsorshipCountStock($vIdMember,'1',$vStart,$vEnd);?>)</td>
    <td align="right">: <?=number_format($db->f('fpoinspmobi'),0,",",".");?></td>
  </tr>
<? if ($vStockistType == '1') { ?>
  <tr>
    <td>Sbg. Mobile Stokis</td>
    <td align="right">: <?=number_format( $db->f('fpoinmobi'),0,",",".");?></td>
  </tr>
  <? } else  if ($vStockistType == '2') {  ?>
  <tr>
    <td>Sbg. Stokis</td>
    <td align="right">: <?=number_format( $db->f('fpoinstoc'),0,",",".");?></td>
  </tr>
  <? } else if ($vStockistType == '3') { ?> 

  <tr>
    <td>Sbg. Master Stokis</td>
    <td align="right">: <?=number_format( $db->f('fpoinmast'),0,",",".");?></td>
  </tr>
 <? } ?>  
  <tr>
    <td>Total Poin</td>
    <td align="right">: <?=number_format($vTotPoin,0,",",".");?></td>
  </tr>


</table></div></td>
            <td align="center"><input <?=$vBtnState?>  type="button" name="btClaim" id="btClaim" value="Set Claim" class="btn btn-success btn-sm" onClick="claimReward1('<?=$vIdMember?>','<?=$vIdSys?>')" <? if ($vPaid=='1') echo 'disabled';?>>
            <span id="spClaim"></span>
            </td>

          </tr>

           <? 
				 }
			 }
		    ?>

          </table>    

 </div>  

            

     <table width="90%">

     <tr>

      <td align="center">

        

        <p style="display:none">

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

        <tr> 

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
	
<? include_once("../framework/admin_bottomjs.blade.php")?>	
	<script>
		$(document).ready(function() {
			App.init();
			Dashboard.init();
		});
	</script>

<? include_once("../framework/admin_footside.blade.php") ; ?>