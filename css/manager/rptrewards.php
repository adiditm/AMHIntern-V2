<? include_once("../framework/masterheader.php")?>



<?php



$vAwal=$_POST['dc'];

$vAkhir=$_POST['dc1'];
$vLevelPost=$_POST['lmLevel'];
$vFltUser=$_POST['tfUser'];
$vCrit='';
$vFilterText="";

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

if ($vFltUser !='') {
   $vCrit.=" and fkdanggota='$vFltUser' ";
   $vFilterText.="[Username: $vFltUser]";
}   

if ($vLevelPost !='') {
   $vCrit.=" and fperingkat='$vLevelPost' ";
   $vFilterText.="[Level: $vArrPeringkat[$vLevelPost]]";
}






			 $vsql="select  * from tb_rewards   where 1 and fperingkat = 'E' "; 

			 $vsql.=$vCrit;

			 

			 

			 $vsql.=" order by ftanggal ";


			//Export Excel
				$db->query($vsql);
				$vArrData="";
				$vArrHead=array('No.','Date','Username','Name','Level','Turnover');
				$vArrBlank=array('','','','','','','','');
				$vArrDateFilter=array('Filter :  '.$vFilterText,'','','','','','','');
				
				
				$i=0;$vTot=0;
				$vArrData[]=$vArrDateFilter;
				$vArrData[]=$vArrBlank;
				$vArrData[]=$vArrHead;
				
				while ($db->next_record()) { //Convert Excel
				     $i++;

				 $vIdMember=$db->f('fkdanggota');

				 $vTanggal=$db->f('ftanggal');

				 $vName=$oMember->getMemberName($vIdMember);

				 $vLevel=$db->f('fperingkat');
				 $vLevelText=$vArrPeringkat[$vLevel];

				 $vReward=$db->f('frewarddesc');



				 $vJumlah=$db->f('fout'); 
				 $vOmzet=$db->f('fomzet');    
				     

				 //$vArrHead=array('No.','Date','Username','Name','Level','Turnover');

				 $vArrData[]=array($i,$vTanggal,$vIdMember,$vName,$vLevelText,$vOmzet);
					//$vArrMem['fpassword'][$i]=$oSystem->doED('decrypt',$db->f('fpassword'));
				
				}
				
				$vArrTot=array('','','','','','Total:',$vTot);
				//$vArrData[]=$vArrTot;
				$_SESSION['rewarde']=$vArrData;




 $db->query($vsql);

 $db->next_record();

 $vRecordCount=$db->num_rows();

 $vPageCount=ceil($vRecordCount/$vBatasBaris);



?>







<script language="JavaScript" type="text/JavaScript">





$(document).ready(function(){

    $('#caption').html('Rewards Report ');





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

   <? include "../framework/leftadmin.php"; ?>

    <!-- main content start-->

    <div class="main-content" >



   <? include "../framework/headeradmin.php"; ?>

           <!--body wrapper start-->

 <section class="wrapper">

        <!-- page start-->



<form action="" method="post" name="demoform">



          <div style="display:inline;" align="left">

          	
		  <div class="row" style="display:none"> 	
          Date<strong>: </strong>
          <input style="width:100px;display:inline" class="form-control" name="dc" id="dc" size="11" value="<?=$vAwal?>">&nbsp; <strong>s/d</strong>

          <input style="width:100px;display:inline" class="form-control" name="dc1" id="dc1" size="11" value="<?=$vAkhir?>"> &nbsp;&nbsp;

          
          </div>
          <br>
          <div class="row">
              <div class="col-lg-12">
              <strong>Username :</strong>
              <input style="width:150px;display:inline"" type="text" class="form-control" id="tfUser" name="tfUser" value="<?=$vFltUser?>">
              </div>
          </div>
          <div class="row">
              <div class="col-lg-12">
              <strong>Peringkat :</strong>
              <select style="width:150px;display:inline""  class="form-control" id="lmLevel" name="lmLevel" >
              <option <? if ($vLevelPost=='') echo 'selected'; ?> value="">---All---</option>
              <option <? if ($vLevelPost=='E') echo 'selected'; ?> value="E">Executive</option>
              <option <? if ($vLevelPost=='PE') echo 'selected'; ?> value="PE">Platinum Executive</option>
              <option <? if ($vLevelPost=='M') echo 'selected'; ?> value="M">Manager</option>
              <option <? if ($vLevelPost=='PM') echo 'selected'; ?> value="PM">Platinum Manager</option>
              <option <? if ($vLevelPost=='D') echo 'selected'; ?> value="D">Director</option>
              <option <? if ($vLevelPost=='RD') echo 'selected'; ?> value="RD">Platinum Director</option>
              
              </select>
                </div>
          </div>
          <br>
          <div class="row">
          <div class="col-lg-12">
          <input name="Submit22" type="submit" class="btn btn-success" value="Refresh">
          </div>
          </div>
          

          

    </div>

          <br /><br />

<br />





    <div class="table-responsive">

        <table width="76%" border="0" class="table table-striped" style="width:75%">

          <tr >

            <td width="3%" ><strong>No.</strong></td>
            <td width="12%" ><div align="center"><strong>Date</strong></div></td>

            <td width="14%"><div align="center"><strong>Username</strong></div></td>

            <td width="22%" align="center"><strong>Name</strong></td>

            <td width="21%" align="center" ><strong>Level </strong></td>
            <td width="28%" align="center" ><strong>Turnover</strong></td>

          </tr>

          <? 


             $vNo=0;

			 $vsql="select * from tb_rewards  where 1 and fperingkat = 'E' "; 

			 $vsql.=$vCrit;

			 


			 $vsql.=" order by ftanggal ";

			$vsql.="limit $vStartLimit ,$vBatasBaris ";

		     $db->query($vsql);

			 //$vTotJualL=0;$vTotalJualR=0;

			 $vTot=0;

			 while ($db->next_record()) {

			 $vNo++;

				 $vIdMember=$db->f('fkdanggota');

				 $vTanggal=$db->f('ftanggal');

				 $vName=$oMember->getMemberName($vIdMember);

				 $vLevel=$db->f('fperingkat');
				 $vLevelText=$vArrPeringkat[$vLevel];

				 $vReward=$db->f('frewarddesc');



				 $vJumlah=$db->f('fout'); 
				 $vOmzet=$db->f('fomzet');    

		  ?>

          <tr>

            <td  ><?=$vNo+$vStartLimit?></td>
            <td  align="center"><?=$oPhpdate->YMD2DMY($vTanggal)?></td>

            <td  align="center"><?=$vIdMember?></td>

            <td  align="center"><?=$vName?></td>

            <td  align="right"><div align="left">
              <?=$vLevelText?>
            </div></td>
            <td align="right" > <div align="left">
              <?=$vOmzet?>
            </div></td>

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
<button class="btn btn-info btn-sm" onClick="document.location.href='../manager/getexcel.php?arr=rewarde&file=reward_executive_report'"><i class="fa fa-file-text-o"></i> Export Excel</button> 
      <!-- page end-->

        </section>

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

