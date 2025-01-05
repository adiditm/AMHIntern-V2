<? include_once("../framework/admin_headside.blade.php")?>

<?php

define("MENU_ID", "mdm_member_aktif_detail");   

$vFall=$_GET['fallback'];

 if (!$oSystem->checkPriv($vUser,MENU_ID)) { ;

    //  $oSystem->jsAlert("Not Authorized!");

    //  $oSystem->jsLocation("../main/logout.php");

 }

$vOP=$_POST['hOP'];

$vSpy=md5('spy');

$vID=$_POST['tfID'];

$vNama=$_POST['tfNama'];

$vNoHP=$_POST['tfNoHP'];

$vKota=$_POST['tfKota'];

$vAktif=$_POST['lmAktif'];

$vSort=$_POST['lmSort'];



 $vStart=$_POST['dc'];

 $vEnd=$_POST['dc1'];

 

 if ($vStart=='')

    $vStart=date('Y-m-d', strtotime('-6 months'));

 if ($vEnd=='')

    $vEnd=date('Y-m-d');

    



 if ($vStart!="" && $vEnd!="")

	    $vCritDate.=" and date(ftanggal) >= '$vStart' and date(ftanggal) <= '$vEnd' " ;







if ($vSort=="") $vSort=$_GET['lmSort'];

if ($vSort=="") $vSort=1;



if ($vAktif=="") $vAktif=$_GET['lmAktif'];

$vPaket=$_POST['lmPaket'];



if ($vPaket!="-") 

   $vCritPaket=" and fdownline like '$vPaket%' ";





if ($vSort=="1")

   $vOrder=" fspon asc";

if ($vSort=="2")

   $vOrder=" fspon desc";

    



if ($vNama!="")

   $vCrit.=" and fnama like '%$vNama%' ";

if ($vID!="")

   $vCrit.=" and fidmember like '%$vID%' ";





if ($vAktif==2)

   $vCrit.=" and faktif = 0";

else if ($vAktif==1)   

   $vCrit.=" and faktif = 1";







$vPage=$_POST['lmPage'];

$vBatasBaris=25;

if ($vPage=="")

 	$vPage=0;

else $vPage=$vPage-1; 	

$vStartLimit=$vPage * $vBatasBaris;	



$vsql="select b.fidmember,b.fnama, a.fspon from (select fsponsor,count(fdownline) as fspon from tb_updown where fsponsor <> -1 and ftanggal between '$vStart' and '$vEnd' $vCritPaket $vCritDate group by fsponsor) as a left join m_anggota b on a.fsponsor=b.fidmember where 1 ";

$vsql.=$vCrit;

$vsql.=" order by $vOrder ";

//echo "<br><br><br>".$vsql;

$db->query($vsql);

$vArrTop=array();

while ($db->next_record()) {

    $vIDx=$db->f('fidmember');

    $vSponsorShip = $oNetwork->getReferralPeriod($db->f('fidmember'),$vStart,$vEnd);

    $vOmzet=0;

    while (list($key,$val) = each($vSponsorShip)) {

       $vOmzet+=$oNetwork->getBobot($val);

	}        

	

	$vArrTop[$vIDx]=$vOmzet;

    

      

}



    arsort($vArrTop);

    



$vRecordCount=$db->num_rows();

$vPageCount=ceil($vRecordCount/$vBatasBaris);





$from="Uneeds <info@uneeds-style>";

?>





<script language="JavaScript" type="text/JavaScript">

$(document).ready(function(){

    $('#caption').html('Report Top Sponsor');





   $('#dc').datepicker({

                    format: "yyyy-mm-dd",

                    autoclose : true

    });  

    

       $('#dc1').datepicker({

                    format: "yyyy-mm-dd",

                    autoclose : true

    }); 

  



	



});

<!--

function MM_goToURL() { //v3.0



  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;

  if (getValue()=="") {

      alert('Pilih salah satu member melalui Radio Button di kolom paling kanan, kemudian klik tombol ini kembali!');

	  return false;

  }	  

  for (i=0; i<(args.length-1); i+=2) 

      eval(args[i]+".location='"+args[i+1]+"'");

  

}





function getValue(){

   vLength=document.memberForm.rbSelected.length;   

   for (i=0;i<vLength;i++) {

      if (document.memberForm.rbSelected[i].checked) {

	     return document.memberForm.rbSelected[i].value; 

	  } 

   } 

      if (document.memberForm.rbSelected.value)

	     return document.memberForm.rbSelected.value;

	  else return '(Anda belum memilih member)';	 

}





//-->



function showDetail(pParam,pStart,pEnd) {

   var myWindow = window.open("popspon.php?uMemberId="+pParam+"&start="+pStart+"&end="+pEnd, "wDetail", "width=700, height=600, toolbar=no, scrollbars=yes, resizable=yes "); 



}

</script>

	<!--<link rel="stylesheet" href="../css/screen.css"> -->



	

	

 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />



<style type="text/css">

<!--

.style1 {color:#666666}

.style2 {

	color: #000000;

	font-weight: bold;

}

-->





@media 

only screen and (max-width: 760px),

(min-device-width: 768px) and (max-device-width: 1024px)  {



	/* Force table to not be like tables anymore */

	table, thead, tbody, th, td, tr { 

		display: block; 

	}

	

	/* Hide table headers (but not display: none;, for accessibility) */

	thead tr { 

		position: absolute;

		top: -9999px;

		left: -9999px;

	}

	

	tr { border: 1px solid #ccc; }

	

	td { 

		/* Behave  like a "row" */

		border: none;

		border-bottom: 1px solid #eee; 

		position: relative;

		padding-left: 50%; 

	}

	

	td:before { 

		/* Now like a table header */

		position: absolute;

		/* Top/left values mimic padding */

		top: 6px;

		left: 6px;

		width: 45%; 

		padding-right: 10px; 

		white-space: nowrap;

	}



</style>

<div class="right_col" role="main">
		<div><label><h3>Top Sponsor  <?=$vCText?></h3></label></div>



<div align="center" class="table-responsive"> 

      

       		<form method="post" id="frmFilter" name="frmFilter" >

       		<div class="row">
       		<div class="col-lg-8">

		  <table border="0" cellpadding="4" cellspacing="0"  align="left"  >

            <tr>

            <td width="27%" height="25"><div align="left"><strong>Date</strong></div></td>

            <td style="width: 39%"><div align="left" style="display:inline"><input class="dpick form-control"  name="dc"  id="dc" size="12" value="<?=$vStart?>" style="width:150px" />

				<a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.demoform.dc);return false;" >&nbsp;</a></div></td>

            <td width="36%"><div align="left" style="display:inline"><input  class="dpick form-control" name="dc1" id="dc1" value="<?=$vEnd?>" size="12" style="width:150px" />

				<a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.demoform.dc1);return false;" >&nbsp;</a></div></td>

          </tr>

            

            <tr>

              <td width="35%" height="25" ><div align="left"><strong>Member ID 
				  </strong> </div></td>

              <td height="25" style="width: 39%"><div align="left">

                  <input name="tfID" type="text" class="form-control" id="tfID" value="<?=$vID?>" />

                  <input name="hOP" type="hidden" id="hOP" value="post" />

              </div></td>

            </tr>

            <tr>

              <td height="25"><div align="left"><strong>Nama</strong></div></td>

              <td height="25" style="width: 39%"><div align="left">

                  <input name="tfNama" type="text" class="form-control" id="tfNama" value="<?=$vNama?>" />

              </div></td>

            </tr>



            <tr  >

              <td height="25"><div align="left"><strong>Sponsor Reg. Pack</strong></div></td>

              <td height="25" style="width: 39%"><div align="left">

                <select name="lmPaket" class="form-control" id="lmPaket">

                  <option value="-" selected="selected">--All--</option>

                  <option value="SIL" <? if ($vPaket=="UEC" || $vPaket=="SIL") echo "selected"?>>Silver</option>

                  <option value="GOL" <? if ($vPaket=="UBC" || $vPaket=="GOL") echo "selected"?>>Gold</option>

				  <option value="PLA" <? if ($vPaket=="UFC" || $vPaket=="PLA") echo "selected"?>>Platinum</option>

                </select>

              </div></td>

            </tr>

            <tr >

              <td style="height: 25px"><div align="left"><strong>Sort By</strong></div></td>

              <td style="height: 25px; width: 39%;"><div align="left">

                <select name="lmSort" class="form-control" id="lmSort">

                  <option value="1" <? if ($vSort=="1") echo "selected";?>>Sponsor Count Ascending</option>

                  <option value="2" <? if ($vSort=="2") echo "selected";?>>Sponsor Count Descending</option>

                </select>

              </div></td>

            </tr>

            <tr>

              <td colspan="2"><div align="center"><br>

                  <input name="Submit" type="submit" class="btn btn-success" value="Refresh" />

                &nbsp; &nbsp;

                <input name="Submit2" type="button" class="btn btn-default" value="Reset" onclick="document.location.href='../manager/rpt_topspon.php'" />

              </div></td>

            </tr>

          </table>

          </div>
          </div>



  <br>

  <div style="float:left"></div>

  <h4 align="center">Top Ten Turnover Sponsorship </h4><br>

  

  

        		<table style="width: 50%" align="center" class="table-striped table">

					<tr style="font-weight:bold">

						<td>No.</td>

						<td>Username</td>

						<td>Name</td>

						<td align="right">Sponsorship</td>

						<td align="right">Sponsorhip Turnover</td>

					</tr>

					<?

					    $i=0;
						//Export Excel
						$vArrData="";
						$vArrHead=array('No.','Username','Name','Sponsorship');
						$vArrBlank=array('','','','');
						$vArrDateFilter=array('Filter :  '.$vFilterText);
						
						
						$i=0;$vTot=0;
						$vArrData[]=$vArrDateFilter;
						$vArrData[]=$vArrBlank;
						$vArrData[]=$vArrHead;
					    

					    while(list($key,$val)=each($vArrTop)) {

					       if ($i<10) {
					         


					    

					?>

					

					<tr>

						<td><?=$i+1?></td>

						<td><?=$key?></td>

						<td><?=$oMember->getMemberName($key)?></td>

						<td align="right"><? 

						   $vSponShip=$oNetwork->getSponsorshipCountPeriod($key,$vStart,$vEnd);

						   echo number_format($vSponShip,0,",",".");

						  

						   ?></td>



						<td align="right"><?=number_format($val,0,",",".");
						
						 $vArrData[]=array($i+1,$key,$oMember->getMemberName($key),$val);
						
						?></td>



					</tr>

					<? } 

					  $i++;

					}
					$_SESSION['topspon']=$vArrData;

					?>

				</table>
				

				<br>



  

  

        <div align="right" class="form-inline">

      Page : <select name="lmPage" id="lmPage" onChange="document.frmFilter.submit()" class="form-control" style="width:85px">

            <? for ($i=1;$i<=$vPageCount;$i++) {?>

			<option value="<?=$i?>" <? if (($vPage+1)==$i) echo "selected";?>>-<?=$i?>-</option>

			<? } ?>

          </select>



      </div>

      

      <div class="table-responsive" >

    <table width="98%" border="0" align="center" cellpadding="1" cellspacing="0" class="table" >

      <tr style="font-weight:bold"> 

        <td  height="26" style="width: 30px"> No.</td>

        <td  height="26" style="width: 30px"> <div align="left">Username</div></td>

        <td width="142"><div align="left" >Name 

        </div></td>

        <td width="138"><div align="right" >Sponsorship Count 

          </div></td>



        

        <td width="138"><div align="right" >Sponsorship Tunrover 

          </div></td>



        

      </tr>

      <?

		  //if ($vOP=="post") $vStartLimit=0;

		  $vsql="select b.fidmember,b.fnama, a.fspon from (select fsponsor,count(fdownline) as fspon from tb_updown where fsponsor <> -1 and ftanggal between '$vStart' and '$vEnd' $vCritPaket  $vCritDate group by fsponsor) as a left join m_anggota b on a.fsponsor=b.fidmember where 1";

		  $vsql.=$vCrit;

		  $vsql.=" order by $vOrder ";

		$vsql.="limit $vStartLimit ,$vBatasBaris ";

			

		  $db->query($vsql);

		  $vNumRows=$db->num_rows();

		  $vNo=0;

		  $vHari=$oRules->getSettingByField("fbyyprint");

		  while ($db->next_record()) {

		  $vNo++;

		?>

      <tr style="<? if ($oMember->isStockist($db->f('fidmember'))==1) echo "background-color:#880000;color:#fff"; ?>"  > 

        <td style="color:<? if ($oMember->isStockist($db->f('fidmember'))==1) echo 'lime'; else echo 'grey';?>; width: 30px;" onmouseover="showhint('<?=$vMess?>', this, event, '150px')">

        <?=$vNo + $vStartLimit?></td>

        <td style="color:<? if ($oMember->isStockist($db->f('fidmember'))==1) echo 'lime'; else echo 'grey';?>; width: 30px;" onmouseover="showhint('<?=$vMess?>', this, event, '150px')">

        <a name="<?=$db->f('fidmember')?>"></a>

        <div align="left"><span  >

          <?=$db->f('fidmember')?>

          <? if ($oMember->isStockist($db->f('fidmember'))==1) echo "<br> St. ID: ".$db->f('fidstockist');?>

          </span></div></td>

        <td style="height: 39px"><div align="left"><?=$db->f('fnama')?></div></td>

        <td width="138" style="height: 39px;cursor:pointer" align="right" onclick="showDetail('<?=$db->f('fidmember')?>','<?=$vStart?>','<?=$vEnd?>')"><div align="right"><?=number_format($db->f('fspon'),0,",",".")?></div></td>

        <td width="138" style="height: 39px;cursor:pointer" align="right" onclick="showDetail('<?=$db->f('fidmember')?>','<?=$vStart?>','<?=$vEnd?>')">

        <?

            $vSponsorShip = $oNetwork->getReferralPeriod($db->f('fidmember'),$vStart,$vEnd);

            $vOmzet=0;

            while (list($key,$val) = each($vSponsorShip)) {

               $vOmzet+=$oKomisi->getOmzetROAllMemberKIT($val);

			}        

			echo number_format($vOmzet,2,",",".");

        ?>

        </td>



      </tr>

        <? 

          }

          if ($vNumRows <= 0) {

         // while $db->next_record?>

        <tr><td>&nbsp;</td><td colspan="3">No data! <?=$vTglLahir?>-<?=$vBlnLahir?></td>

			<td>&nbsp;</td></tr>

        <? } ?>

      </table>

      

<div align="right" class="form-inline">

      Page&nbsp;:<select name="lmPage1" id="lmPage1" onChange="document.frmFilter.lmPage.value=this.value;document.frmFilter.submit()" class="form-control" style="width:85px">

            <? for ($i=1;$i<=$vPageCount;$i++) {?>

			<option value="<?=$i?>" <? if (($vPage+1)==$i) echo "selected";?>>-<?=$i?>-</option>

			<? } ?>

          </select>



      </div>

      

</div>

    </form>

      <div align="center">

            <p align="left" style="display:none"><span >

			  <input alt="Detail & Edit Member" name="btDetail2" type="button" class="btn btn-primary" id="btDetail2" onClick="MM_goToURL('parent','admin.php?menu=changeprofil&uMemberId='+getValue());return document.MM_returnValue" value="Detail" onMouseover="showhint('Lihat detail /  Edit Member '+getValue(), this, event, '220px')">

			  <input name="btKomisi2" type="button" class="btn btn-default" id="btKomisi2" onClick="MM_goToURL('parent','admin.php?menu=stkomisi&uMemberId='+getValue());return document.MM_returnValue" value="Komisi" onMouseover="showhint('Lihat Komisi Member '+getValue(), this, event, '190px')">

              <input name="btJar2" type="button" class="vsmallbutton" id="btJar2" onClick="MM_goToURL('parent','admin.php?menu=stjaringan&uMemberId='+getValue());return document.MM_returnValue" value="Net/Sponsor" onMouseover="showhint('Lihat Status Network & Sponsor Member '+getValue(), this, event, '190px')">

              <input name="btGen2" type="button" class="vsmallbutton" id="btGen2" onClick="MM_goToURL('parent','admin.php?menu=genealogi&uMemberId='+getValue());return document.MM_returnValue" value="Geneologi" onMouseover="showhint('Lihat Genealogi Member '+getValue(), this, event, '210px')">

            </span></p>

                    <p style="display:none"><br>

              <?

   for ($i=0;$i<$vPageCount;$i++) {

     $vOffset=$i*$vBatasBaris;

	   $idisp=$i;

	 if ($vOP=="post") $idisp=0;

     if ($idisp!=$vPage) {

?>

              <a  href="aktiftemp.php?lmAktif=<?=$vAktif?>&amp;lmMship=<?=$vPrem?>&amp;uPage=<?=$idisp?>&amp;lmSort=<?=$vSort?>" >

              <?=$i+1?>

              </a> 

              <?

  } else {

?>

              <?=$i+1?>

              <? } ?>

              <?  } //while?>

              <span >                </span><br>

              <br>

        </p>

      </div></td>

</tr>



       <!-- page end-->

<button style="margin-left:2em" class="btn btn-info btn-sm" onClick="document.location.href='../manager/getexcel.php?arr=topspon&file=top_sponsor_report'"><i class="fa fa-file-text-o"></i> Export Top Ten Sponsor to Excel</button> 
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



</div>
<? include_once("../framework/admin_footside.blade.php") ; ?>

