<? include_once("../framework/admin_headside.blade.php")?>
<? include_once("../classes/networkclass.php");
include_once("../server/config.php");
?>


<?php

$vSQL="select * from m_anggota    order by fidsys ";
$db->query($vSQL);
while($db->next_record()) {
   $vIdMem=$db->f('fidmember');	
   $vOmzetX=$oNetwork->getCountCoupleP($vIdMem);
   
				 $vsql="select * from m_rewards  where 1  and fkind='r' "; 		
				 //echo $vsql."<br>";	 
		    
			 $dbin->query($vsql);
			 $vTot=0;
			 while ($dbin->next_record()) {
			 $vNo++;
				 $vSyaratNom=$dbin->f('fjmlangg');
				 $vSyaratText=$dbin->f('fsyarat');
				 $vReward=$dbin->f('freward');
				 $vLevel = $dbin->f('flevel');
				 $vNom = $dbin->f('fnominal');
				 $vName=$oMember->getMemberName($vIdMem);
				 $vOmzet=$oNetwork->getCountCoupleP($vIdMem);

				 $vKakiL=$oNetwork->getDownLR($vIdMem,'L');
				 $vKakiR=$oNetwork->getDownLR($vIdMem,'R');

				 
				 $vOmzetL = $oKomisi->getOmzetROWholeMember($vKakiL);
				 $vOmzetR = $oKomisi->getOmzetROWholeMember($vKakiR);
				  $vOmzetKakiL=$oKomisi->getOmzetROAllMember($vKakiL);
				   $vOmzetKakiR=$oKomisi->getOmzetROAllMember($vKakiR);
				   $vOmzetLAll=$vOmzetL + $vOmzetKakiL;
				   $vOmzetRAll=$vOmzetR + $vOmzetKakiR;
				   
				  $vPRNom = $oRules->getSettingByField('fnompr');
				 
				 if ($vOmzetLAll >0 && $vOmzetRAll >0) {
					  if ($vOmzetLAll < $vOmzetRAll)
					     $vOmzet = $vOmzetLAll;
					  else if ($vOmzetLAll > $vOmzetRAll)	  
					     $vOmzet = $vOmzetRAll;
					  else	 
					     $vOmzet = $vOmzetRAll;
				 } else $vOmzet = 0;
				 
				 $vOmzetPR = $vOmzet / $vPRNom;
				 
				 
				 $vKetClaim=$oKomisi->getKetClaim($vUser,$dbin->f('flevel'));
				  $vKetClaimText='-';
				 if ($vKetClaim != '-') 
				     $vKetClaimText='<b>Claimed:</b> '.$vKetClaim;
				 	 
				 $vPaket=$oMember->getPaket($vIdMem);
				 
				 if ($vOmzetPR >= $vSyaratNom ) {
				 //  $vStatus="Sudah";
				// else $vStatus="Belum";  
				 
				 
				//  echo  "AAAAAA:$vIdMem:$vOmzetX<br>";
		//		 if ($vOmzetX >= $vSyaratNom) {
					 
					
					
					$vSQL="select * from tb_rewards where fkdanggota='$vIdMem' and flevel=$vLevel";
					$db1->query($vSQL);
					$db1->next_record();
					$vRecs=$db1->num_rows();
					
					if ($vRecs <1) {
						 $vSQL="insert into tb_rewards(fkdanggota, flevel, fperingkat, fjmlanggota, fomzet, fnominal, frewarddesc, fpaid, fbukti, ftglpaid, ftanggal) " ;
						$vSQL .=  "value ('$vIdMem', $vLevel, '', $vSyaratNom, $vOmzetPR, $vNom, '$vReward', '0', '', '1981-01-01 00:00:00', now())";
						$db1->query($vSQL);
					}
				 }
				 
			 }
   
	
}

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







			 $vsql="select  * from tb_rewards   where 1   "; 

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


function claimReward1(pUser,pLevel) {
   $('#hUser').val(pUser);
   $('#hLevel').val(pLevel);
   $('#spReward').html(pUser+' / '+pLevel);   
   $('#btnModal').trigger('click');	
}

function claimReward(pUser,pLevel,pBukti) {
    var vURL="../main/mpurpose_ajax.php?op=claimrwd";
   if (confirm('Yakin melakukan claim terhadap reward untuk member '+pUser+'?')) { 
		   $('#spClaim').show();
		   $('#btClaim').hide();
		   $('#spClaim').html('<img src="../images/ajax-loader.gif" />');
		   $.post(vURL, {level : pLevel, user : pUser, bkt: pBukti},function(data) {
				  // alert(data);
				$('#spClaim').hide();
				$('#btClaim').show();
				$('#divClaimed').html('&radic;&nbsp; Sudah');
				document.getElementById('btClaim').disabled=true;
				if (data.trim()=='success')	{
				   alert('Reward sudah diclaim!');
				   document.location.href='../manager/rptrewardadm.php';
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

				
				
<div class="right_col" role="main">
		<div><label><h3>Reward Report</h3></label></div>

<button type="button" class="btn btn-info btn-lg hide" id="btnModal" data-toggle="modal" data-target="#dialogModal">Open Modal</button>

<div class="modal fade" id="dialogModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="modalhead">Claim Reward [<span id="spReward"></span>]</span></h4>
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

          <button type="button" id="btSubmit" name="btSubmit" class="btn btn-success" data-dismiss="modal" onClick="claimReward($('#hUser').val(),$('#hLevel').val(),$('#tfResi').val())">Submit</button>
          <button type="button" id="btClose" name="btClose" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

<form action="" method="post" name="demoform">



                  <div class="row">
          <div class="col-lg-12">
          <input name="Submit22" type="submit" class="btn btn-success" value="Refresh">
          </div>
          </div>
          <br>


    <div class="table-responsive">

        <table width="76%" border="0" class="table table-striped" style="width:100%">

          <tr >

            <td width="3%" ><strong>No.</strong></td>
            <td width="6%" ><div align="center"><strong>Date</strong></div></td>

            <td width="9%"><div align="center"><strong>Username</strong></div></td>

            <td width="12%" align="center"><strong>Name</strong></td>

            <td width="11%" align="center" ><strong>Perolehan Pasangan </strong></td>
            <td width="19%" align="center" ><strong>Perolehan Reward</strong></td>
            <td width="10%" align="center" ><strong>Claimed</strong></td>
            <td width="25%" align="center" ><strong>Bukti</strong></td>
            <td width="12%" align="center" ><strong>&radic;</strong></td>

          </tr>

          <? 


             $vNo=0;

			 $vsql="select * from tb_rewards where 1   "; 

			 $vsql.=$vCrit;

			 


			 $vsql.=" order by ftanggal ";

			$vsql.="limit $vStartLimit ,$vBatasBaris ";

		     $db->query($vsql);
			 

			 //$vTotJualL=0;$vTotalJualR=0;

			 $vTot=0;
if ($vRecordCount > 0) {	
			 while ($db->next_record()) {

			 $vNo++;

				 $vIdMember=$db->f('fkdanggota');

				 $vTanggal=$db->f('ftanggal');

				 $vName=$oMember->getMemberName($vIdMember);

				 $vLevel=$db->f('fperingkat');
				 

				 $vReward=$db->f('frewarddesc');
				 $vNominalR=$db->f('fnominal');
				 $vOmzet=$db->f('fomzet');


				 $vJumlah=$db->f('fout'); 
				 $vLevelRwd=$db->f('flevel');    
				 $vClaimed=$db->f('fpaid'); 
				 $vBukti=$db->f('fbukti');    
				 if ($vBukti=='') $vBukti='-';
				 if ($vClaimed=='0') {
				    $vClaimedText='&#10060; Belum';
					$vBtnState='';
				 } else	{ $vClaimedText='&#x2705; Sudah'; 
				 		  $vBtnState='disabled';	
				 }
				
		  ?>   

          <tr>

            <td  ><?=$vNo+$vStartLimit?></td>
            <td  align="center" nowrap><?=$oPhpdate->YMD2DMY($vTanggal)?></td>

            <td  align="center"><?=$vIdMember?></td>

            <td  align="left"><?=$vName?></td>

            <td  align="right"><div align="right">
              <?=$vOmzet?>
            </div></td>
            <td align="right"><div align="left">
              <?=number_format($vNominalR,0,",",".")." / ".$vReward?>
            </div></td>
            <td align="right"><div align="center" id="divClaimed"><?=$vClaimedText?></div></td>
            <td align="center"><div align="left"><?=$vBukti?></div></td>
            <td align="center"><input <?=$vBtnState?>  type="button" name="btClaim" id="btClaim" value="Set Claim" class="btn btn-success btn-sm" onClick="claimReward1('<?=$vIdMember?>','<?=$vLevelRwd?>')">
            <span id="spClaim"></span>
            </td>

          </tr>

           <? } 
			} else { 
		   ?>
  <tr>

            <td colspan="9"  ><b>Belum ada data!</b></td>
            </tr>         
           <? } ?>

          </table>    

 </div>  

            

     <table width="90%">

     <tr>

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
	


<? include_once("../framework/admin_footside.blade.php") ; ?>