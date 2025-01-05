<? include_once("../framework/masterheader.php")?>

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

if ($vSort=="") $vSort=$_GET['lmSort'];

if ($vSort=="") $vSort=1;



if ($vAktif=="") $vAktif=$_GET['lmAktif'];

$vPrem=$_POST['lmMship'];

if ($vPrem=="") $vPrem=$_GET['lmMship'];

$vStockist=$_POST['lmStockist'];



if ($vSort=="1")

   $vOrder=" ftgldaftar ";

if ($vSort=="2")

   $vOrder=" fidmember ";

if ($vSort=="3")

   $vOrder=" fnama ";

    



if ($vStockist!="")

   $vCrit.=" and fstockist = '$vStockist' ";

if ($vID!="")

   $vCrit.=" and fidmember like '%$vID%' ";



if ($vNama!="")

   $vCrit.=" and fnama like '%$vNama%' ";

if ($vNoHP!="")

   $vCrit.=" and fnohp like '%$vNoHP%' ";

if ($vKota!="")

   $vCrit.=" and fkota like '%$vKota%' ";



if ($vAktif==2)

   $vCrit.=" and faktif = 0";

else if ($vAktif==1)   

   $vCrit.=" and faktif = 1";



if ($vPrem!="-" && $vPrem!="")

   $vCrit.=" and fpaket = '$vPrem' ";



 



$vPage=$_GET['uPage'];

$vBatasBaris=25;

if ($vPage=="")

 	$vPage=0;

$vStartLimit=$vPage * $vBatasBaris;	



$vsql="select sum(fsaldovcr) as fsaldo from m_anggota where faktif= '0'  ";

$vsql.=$vCrit;

$db->query($vsql);

$db->next_record();

$vSaldoAll=$db->f('fsaldo');







$vsql="select * from m_anggota where faktif= '0' ";

$vsql.=$vCrit;

$vsql.=" order by $vOrder ";

$db->query($vsql);
$vArrMem="";
$vArrHead=array('Username','Name','Alamat','Kota','No. HP');
$vArrBlank=array('','','','','');

$i=0;
$vArrMem[]=$vArrHead;
//$vArrMem[]=$vArrBlank;
while ($db->next_record()) { //Convert Excel
    
	$vKotaList=$db->f('fkota');
	$vProp=$db->f('fpropinsi');
	$vWil=$oMember->getWilName('ID',$vProp,$vKotaList,'','');
     
	$vArrMem[]=array($db->f('fidmember'),$db->f('fnama'),$db->f('falamat'),$vWil," ".$db->f('fnohp'));
	//$vArrMem['fpassword'][$i]=$oSystem->doED('decrypt',$db->f('fpassword'));
	$i++;
}


$_SESSION['approve']=$vArrMem;

$db->query($vsql);

$db->next_record();

$vRecordCount=$db->num_rows();

$vPageCount=ceil($vRecordCount/$vBatasBaris);







$from="Uneeds <info@uneeds-style>";

?>





<script language="JavaScript" type="text/JavaScript">

$(document).ready(function(){

    $('#caption').html('Members Profiles');



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



function doActivate(pURL,pOP) {

   var vMess='';

   if (pOP=='act') vMess='Apakah Anda yakin mengaktifkan member ini?';

   else if (pOP=='trial') vMess='Apakah Anda yakin mengaktifkan member ini untuk trial?';

   else if(pOP=='stop') vMess='Apakah Anda yakin stop member ini untuk trial?';

   else vMess='Apakah Anda yakin menghapus member ini?';

   vSure=confirm(vMess);

   if (vSure==true) {

	     window.location=pURL+"&uStockist=0";

   } 

}



function doDeActivate(pURL) {

   vSure=confirm('Apakah Anda yakin me-non-aktifkan member ini?');

   if (vSure==true) {

	     window.location=pURL+"&uOP=0";

   } 

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



function checkStatus(pStatus,pStockist) {

/*

   if (pStatus!='1') {

      document.getElementById('btKomisi').disabled=true;

	  if (document.getElementById('btX'))

	  document.getElementById('btX').disabled=true;

      if (document.getElementById('btJar'))

	  document.getElementById('btJar').disabled=true;

	  if (document.getElementById('btTTK'))

	  document.getElementById('btTTK').disabled=true;

      if (document.getElementById('btGen'))

	  document.getElementById('btGen').disabled=true;

	  if (document.getElementById('btGG'))

	  document.getElementById('btGG').disabled=true;

	  document.getElementById('btBH').disabled=true;

	  document.getElementById('btGS').disabled=true;

	  document.getElementById('btTitik').disabled=true;

	  document.getElementById('btBH2').disabled=true;

	  document.getElementById('btGS2').disabled=true;

	  document.getElementById('btTitik2').disabled=true;

	  document.getElementById('btMutasi').disabled=true;

	  document.getElementById('btButuan').disabled=true;

   } else {

      document.getElementById('btKomisi').disabled=false;

	  if (document.getElementById('btX'))	  

	  document.getElementById('btX').disabled=false;

      document.getElementById('btJar').disabled=false;

	  document.getElementById('btTTK').disabled=false;

      document.getElementById('btGen').disabled=false;

	  document.getElementById('btGG').disabled=false;

	  document.getElementById('btBH').disabled=false;

	  document.getElementById('btGS').disabled=false;

	  document.getElementById('btTitik').disabled=false;

	  document.getElementById('btBH2').disabled=false;

	  document.getElementById('btGS2').disabled=false;

	  document.getElementById('btTitik2').disabled=false;

	  document.getElementById('btButuan').disabled=false;

	  document.getElementById('btMutasi').disabled=false;



   }

   */

   

}



//-->

</script>

<!--	<link rel="stylesheet" href="../css/screen.css"> -->



	

	

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



  .margin-button {

	

	margin-top:5px;

	}

}

</style>

<section>

    <!-- left side start-->

   <? include "../framework/leftadmin.php"; ?>

    <!-- main content start-->

    <div class="main-content" >



   <? include "../framework/headeradmin.php"; ?>

           <!--body wrapper start-->

 <section class="wrapper">



<div align="left" class="table-responsive col-lg-6"> 

      

       		<form method="post" >

       		

		  <table border="0" cellpadding="4" cellspacing="0"  align="left" style="width:100%">

            <tr>

              <td colspan="2" ><div align="left"><font size="3"><strong>Filter</strong></font></div></td>

            </tr>

            <tr>

              <td height="25" style="width: 14%" ><div align="left">Username </div></td>

              <td width="62%" height="25"><div align="left">

                  <input name="tfID" type="text" class="form-control" id="tfID" value="<?=$vID?>" />

                  <input name="hOP" type="hidden" id="hOP" value="post" />

              </div></td>

            </tr>

            <tr>

              <td height="25" style="width: 14%"><div align="left">Name</div></td>

              <td height="25"><div align="left">

                  <input name="tfNama" type="text" class="form-control" id="tfNama" value="<?=$vNama?>" />

              </div></td>

            </tr>

            <tr>

              <td style="height: 25px; width: 14%;"><div align="left">Phone No</div></td>

              <td style="height: 25px"><div align="left">

                  <input name="tfNoHP" type="text" class="form-control" id="tfNoHP" value="<?=$vNoHP?>" />

              </div></td>

            </tr>

            <tr>

              <td height="25" style="width: 14%"><div align="left">City</div></td>

              <td height="25"><div align="left">

                  <input name="tfKota" type="text" class="form-control" id="tfKota" value="<?=$vKota?>" />

              </div></td>

            </tr>

            <tr >

              <td style="width: 14%; height: 25px;"><div align="left">MS</div></td>

              <td style="height: 25px"><div align="left">

                  <select name="lmStockist" class="form-control" id="lmStockist">

                    <option value="" selected="selected">--All--</option>

                    <option value="0" <? if ($vStockist==0 && $vStockist!="") echo "selected"?>>Bukan Stockist</option>

                    <option value="1" <? if ($vStockist==1) echo "selected"?>>Stockist</option>

                  </select>

              </div></td>

            </tr>

            <tr>

              <td style="height: 25px; width: 14%;"><div align="left">Status</div></td>

              <td style="height: 25px"><div align="left">

                  <select name="lmAktif" class="form-control" id="lmAktif">

                    <option value="3" selected="selected">--All--</option>

                    <option value="2" <? if ($vAktif==2) echo "selected"?>>Inactive</option>

                    <option value="1" <? if ($vAktif==1) echo "selected"?>>Active</option>

                  </select>

              </div></td>

            </tr>

            <tr class="trhide">

              <td height="25" style="width: 14%"><div align="left">Reg. Package</div></td>

              <td height="25"><div align="left">

                <select name="lmMship" class="form-control" id="lmMship">

                  <option value="-" selected="selected">--All--</option>

                  <option value="E" <? if ($vPrem=="E" || $vPrem=="S") echo "selected"?>>Silver</option>

                  <option value="B" <? if ($vPrem=="B" || $vPrem=="G") echo "selected"?>>Gold</option>

				  <option value="F" <? if ($vPrem=="F" || $vPrem=="P") echo "selected"?>>Platinum</option>

                </select>

              </div></td>

            </tr>

            <tr style="display:none">

              <td style="height: 25px; width: 14%;"><div align="left">Sort By</div></td>

              <td style="height: 25px"><div align="left">

                <select name="lmSort" class="form-control" id="lmSort">

                  <option value="1" <? if ($vSort=="1") echo "selected";?>>Reg. Date</option>

                  <option value="2" <? if ($vSort=="2") echo "selected";?>>Username</option>

                  <option value="3" <? if ($vSort=="3") echo "selected";?>>Name</option>

                </select>

              </div></td>

            </tr>

            <tr>

              <td colspan="2"><div align="left"><br>

                  <input name="Submit" type="submit" class="btn btn-success" value="Cari" />

                &nbsp; &nbsp;

                <input name="Submit2" type="reset" class="btn btn-default" value="Reset" />

              </div></td>

            </tr>

          </table>

         



  

</form>
 </div>
<div style="float:left">
<form name="memberForm">

    &nbsp; 

    <div align="left">

          


      

          <? if ($oSystem->checkPriv($vUser,"mdm_listprof_detail")) { ?> <input alt="Detail & Edit Member" name="btDetail" type="button" class="btn btn-success btn-sm" id="btDetail2" onClick="MM_goToURL('parent','../memstock/profile.php?op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Detail/Edit&raquo;" onMouseover="showhint('Lihat detail /  Edit Member '+getValue(), this, event, '220px')" style="margin-top:5px;display:none">  <? } ?>        
          <? if ($oSystem->checkPriv($vUser,"mdm_listprof_detail")) { ?> 
		   <input alt="Member Activation" name="btActiv" type="button" class="btn btn-success btn-sm" id="btActiv" onClick="MM_goToURL('parent','../memstock/activationadm.php?op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Review»" onMouseover="showhint('Aktiifasi Member '+getValue(), this, event, '220px')"  style="margin-top:5px">  <? } ?>        

          <? if ($oSystem->checkPriv($vUser,"mdm_listprof_repstock")) { ?><input name="btStock" type="button" class="btn btn-success btn-sm" id="btStock" onclick="MM_goToURL('parent','../memstock/rptstock.php?&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Agent Stock &raquo;" onmouseover="showhint('Stock Agent '+getValue(), this, event, '210px')" style="margin-top:5px;display:none" /> <? } ?>

          <? if ($oSystem->checkPriv($vUser,"mdm_listprof_repkit")) { ?><input name="btKit" type="button" class="btn btn-success btn-sm" id="bKit" onclick="MM_goToURL('parent','../memstock/rptkit.php?&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Agent KIT Report &raquo;" onmouseover="showhint('KIT Agent '+getValue(), this, event, '210px')" style="margin-top:5px;display:none" /> <? } ?>

          <? if ($oSystem->checkPriv($vUser,"mdm_listprof_uwallet")) { ?><input name="btWallet" type="button" class="btn btn-success btn-sm" id="btWallet" onclick="MM_goToURL('parent','../memstock/ewalletbal.php?&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Nex-Wallet &raquo;" onmouseover="showhint('Nex-Wallet '+getValue(), this, event, '210px')" style="margin-top:5px;display:none" /> <? } ?>
          <? if ($oSystem->checkPriv($vUser,"mdm_listprof_uwallet")) { ?><input name="btWallet" type="button" class="btn btn-success btn-sm" id="btWallet" onclick="MM_goToURL('parent','../memstock/ewalletrobal.php?&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="RO-Wallet  &raquo;" onmouseover="showhint('RO Wallet  '+getValue(), this, event, '210px')" style="margin-top:5px;display:none" /> <? } ?>

          <? if ($oSystem->checkPriv($vUser,"mdm_listprof_walladj")) { ?><input name="btKoreksi" type="button" class="btn btn-success btn-sm" id="bKoreksi" onclick="MM_goToURL('parent','../manager/koreksi.php?&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Nex-Wallet Correction &raquo;" onmouseover="showhint('Nex-Wallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px;display:none" /> <? } ?>

          <? if ($oSystem->checkPriv($vUser,"mdm_listprof_repstinout")) { ?><input name="btStWallet" type="button" class="btn btn-success btn-sm" id="btStWallet" onclick="MM_goToURL('parent','../memstock/stockbal.php?&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Stock In/Out Report &raquo;" onmouseover="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px;display:none" /> <? } ?>

          <? if ($oSystem->checkPriv($vUser,"mdm_listprof_stockadj")) { ?><input name="btKoreksiSt" type="button" class="btn btn-success btn-sm" id="bKoreksiSt" onclick="MM_goToURL('parent','../manager/koreksistock.php?&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Stock Adjustment &raquo;" onmouseover="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px;display:none" /> <? } ?>

          <? if ($oSystem->checkPriv($vUser,"mdm_listprof_reporderhist")) { ?><input name="btHist" type="button" class="btn btn-success btn-sm" id="btHist" onclick="MM_goToURL('parent','../memstock/historyro.php?&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Order History Report &raquo;" onmouseover="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px;display:none" /> <? } ?>

          <? if ($oSystem->checkPriv($vUser,"mdm_listprof_repspon")) { ?><input name="btSpon" type="button" class="btn btn-success btn-sm" id="btSpon" onclick="MM_goToURL('parent','../memstock/stjaringan.php?&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Sponsorship Report &raquo;" onmouseover="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px;display:none" /> <? } ?>

          <? if ($oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btGenea" type="button" class="btn btn-success btn-sm" id="btGenea" onclick="MM_goToURL('parent','../memstock/genealogi2.php?&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Genealogi &raquo;" onmouseover="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px;display:none" />&nbsp;<? } ?>

          <? if ($oSystem->checkPriv($vUser,"mdm_listprof_reppair")) { ?><input name="btPair" type="button" class="btn btn-success btn-sm" id="btPair" onclick="MM_goToURL('parent','../memstock/pairing.php?&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Komisi Pair Report &raquo;" onmouseover="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px;display:none" />&nbsp;<? } ?>

          <? if ($oSystem->checkPriv($vUser,"mdm_listprof_repcf")) { ?><input name="btCF" type="button" class="btn btn-success btn-sm" id="btCF" onclick="MM_goToURL('parent','../memstock/pairingcf.php?&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="CF Omzet &raquo;" onmouseover="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px;display:none" />&nbsp; <? } ?>

          <? if ($oSystem->checkPriv($vUser,"mdm_listprof_repwd")) { ?><input name="btWD" type="button" class="btn btn-success btn-sm" id="btWD" onclick="MM_goToURL('parent','../memstock/withdraw.php?&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Withdraw History &raquo;" onmouseover="showhint('Withdraw History '+getValue(), this, event, '210px')" style="margin-top:5px;display:none" />&nbsp;<? } ?>

          

          <br>  

          <br>

      

      </div>

      <div class="table-responsive" >

    <table width="100%" border="0" align="center" cellpadding="1" cellspacing="0" class="table" >

      <tr style="color:;font-weight:bold"> 

        <td  height="26" style="width: 30px"> <div align="center" >Username </div></td>

        <td width="142"><div align="center" >Name 

        </div></td>

        <td width="138"><div align="center" >Address 

          </div></td>

        <td width="68"><div align="center" >Phone No. 

          </div></td>

        <td width="58"><div align="center" >Acc. No.</div></td>

        <td width="70"><div align="center" > Activation Date </div></td>

        <td width="99"><div align="center">Reg. Purc. </div></td>

        <td width="99"><div align="center">Nex-Wallet</div></td>



        <td width="187"><div align="center" >Referral</div></td>

        <td width="27"><div align="center" >&radic;</div></td>

      </tr>

      <?

		  if ($vOP=="post") $vStartLimit=0;

		  $vsql="select * from m_anggota where faktif='0' ";

		  $vsql.=$vCrit;

		  $vsql.=" order by $vOrder ";

		  $vsql.="limit $vStartLimit ,$vBatasBaris ";

			//echo "<br><br><br>".$vsql;

		  $db->query($vsql);

		  $vHari=$oRules->getSettingByField("fbyyprint");

		  while ($db->next_record()) {

		     $vAktifList=$db->f('faktif'); 

			 $vTrial=$db->f('fisfree');

			 $vIDSys=$db->f('fidsys');
			 if ($vAktifList=='1')
			     $vActive='yellow';
			 else
			 $vActive='white';
			     



			  $vTglAktif=$oPhpdate->DMY2YMD($oPhpdate->YMD2DMY($db->f('ftglaktif')));

			     $vSaldo=$db->f('fsaldovcr');

			 $vStockistCSS='';

			     

		 $vStockistCond=$oMember->getMemField('fstockist',$db->f('fidmember'));     

			 if ($vStockistCond == '1')

			    $vStockistCSS='background-color:#880000;color:#fff';

			 else if ($vStockistCond == '2') 

   				$vStockistCSS='background-color:purple;color:#fff';

			 else if ($vStockistCond == '3') 

   				$vStockistCSS='background-color:navy;color:#fff';

			 

			   

			    

		?>

      <tr  bgcolor="<?=$vActive?>" style="<?=$vStockistCSS?>"   > 

        <td title="<?=$db->f('fidmember')?>" style="color:<? if ($oMember->isStockist($db->f('fidmember'))==1) echo 'lime'; else echo 'grey';?>; width: 30px;" onmouseover="showhint('<?=$vMess?>', this, event, '150px')">

        <a name="<?=$db->f('fidmember')?>"></a>

        <div align="left"><span  >

          <? 
		     if (strlen($db->f('fidmember')) >= 12) 
			 echo substr($db->f('fidmember'),0,12)." ...";
			 else echo $db->f('fidmember');
		  
		  ?>

          <? if ($vTrial=='1' && $vAktifList=='1') { ?>

          <br>

          Trial s/d <?=$oPhpdate->YMD2DMY($oMydate->dateAdd($vTglAktif,$vHari,"day")) ?>

          <? } ?>

           <? if ($oMember->isStockist($db->f('fidmember'))==1) echo "<br> St. ID: ".$db->f('fidstockist');?>

          </span></div></td>

        <td title="<?=$db->f('fnama')?>" style="height: 39px"><div align="left"><span >

          <? 
		  
		  		     if (strlen($db->f('fnama')) >= 12) 
			 echo substr($db->f('fnama'),0,12)." ...";
			 else echo $db->f('fnama');

		  
		  ?>

          <br>

          </span></div></td>

        <td width="138" style="height: 39px">          <div align="left"><span >

          <?=$db->f('falamat').", ".$oMember->getWilName('ID',$db->f('fpropinsi'),$db->f('fkota'),'00','00')?>

          <br>

          </span></div></td>

        <td  style="height: 39px"> 

          <div align="left"><span >

            <?=$db->f('fnohp')?>

          &nbsp;          </span></div></td>

        <td style="height: 39px"><div align="left"><span > 

          <?=$oMember->getBankName($db->f('fnamabank'))?>

          , 

          <?=$db->f('fnorekening')?>

          &nbsp; </span></div></td>

        <td  style="height: 39px"> 

          <span >

            <?=$oPhpdate->YMD2DMY($db->f('ftglaktif'))?>

          </span>        </td>

        <td  style="height: 39px;<? if ($db->f('fpriv')=='1') echo 'background-color:#ccc';?>"><div align="right"><?=number_format($db->f('ftotbelanja'),0,",",".")?></div></td>

        <td  style="height: 39px;<? if ($db->f('fpriv')=='1') echo 'background-color:#ccc';?>"><div align="right"><?=number_format($vSaldo,0,",",".")?></div></td>

              <td   style="height: 39px"><div align="center" > <?=$vSpon=$oMember->getMemField('fidressponsor',$db->f('fidmember'))?> / <?=$oMember->getMemberName($vSpon)?> </div></td>

        <td  style="height: 39px" <? if($vFall==$db->f('fidmember')) echo "bgcolor=#0f0";?>><span >

          <input class="form-control" id="rbSelected" style="width:20px;height:20px" name="rbSelected" type="radio" value="<?=$db->f('fidmember')?>" onClick="checkStatus('<?=$db->f('faktif')?>','<?=$db->f('fstockist')?>')" >

          </span></td>

      </tr>

        <? } // while $db->next_record?>

        

      </table>

      </div>

    </form>

      <div align="center">

            <p align="left" style="display:none"><span >

			  <input alt="Detail & Edit Member" name="btDetail2" type="button" class="btn btn-primary" id="btDetail2" onClick="MM_goToURL('parent','admin.php?menu=changeprofil&uMemberId='+getValue());return document.MM_returnValue" value="Detail" onMouseover="showhint('Lihat detail /  Edit Member '+getValue(), this, event, '220px')" style="margin-top:5px">

			  <input name="btKomisi2" type="button" class="btn btn-default" id="btKomisi2" onClick="MM_goToURL('parent','admin.php?menu=stkomisi&uMemberId='+getValue());return document.MM_returnValue" value="Komisi" onMouseover="showhint('Lihat Komisi Member '+getValue(), this, event, '190px')">

              <input name="btJar2" type="button" class="vsmallbutton" id="btJar2" onClick="MM_goToURL('parent','admin.php?menu=stjaringan&uMemberId='+getValue());return document.MM_returnValue" value="Net/Sponsor" onMouseover="showhint('Lihat Status Network & Sponsor Member '+getValue(), this, event, '190px')">

              <input name="btGen2" type="button" class="vsmallbutton" id="btGen2" onClick="MM_goToURL('parent','admin.php?menu=genealogi&uMemberId='+getValue());return document.MM_returnValue" value="Geneologi" onMouseover="showhint('Lihat Genealogi Member '+getValue(), this, event, '210px')" style="margin-top:5px">

            </span></p>

        <p align="left">      

					<? if ($oSystem->checkPriv($vUser,"mdm_listprof_detail")) { ?><input alt="Detail & Edit Member" name="btDetail2" type="button" class="btn btn-success btn-sm" id="btDetail2" onClick="MM_goToURL('parent','../memstock/profile.php?op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Detail/Edit&raquo;" onMouseover="showhint('Lihat detail /  Edit Member '+getValue(), this, event, '220px')" style="margin-top:5px;display:none"><? } ?>
					<? if ($oSystem->checkPriv($vUser,"mdm_listprof_detail")) { ?> 
					<input alt="Member Activation" name="btActiv2" type="button" class="btn btn-success btn-sm" id="btActiv2" onClick="MM_goToURL('parent','../memstock/activationadm.php?op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Review»" onMouseover="showhint('Aktiifasi Member '+getValue(), this, event, '220px')"  style="margin-top:5px">  <? } ?>        
					<? if ($oSystem->checkPriv($vUser,"mdm_listprof_repstock")) { ?><input name="btStock2" type="button" class="btn btn-success btn-sm" id="btBH" onclick="MM_goToURL('parent','../memstock/rptstock.php?&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Agent Stock &raquo;" onmouseover="showhint('Stock Agent '+getValue(), this, event, '210px')" style="margin-top:5px;display:none" /><? } ?>

                    <? if ($oSystem->checkPriv($vUser,"mdm_listprof_repkit")) { ?><input name="btKit2" type="button" class="btn btn-success btn-sm" id="bKit2" onclick="MM_goToURL('parent','../memstock/rptkit.php?&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Agent KIT Report &raquo;" onmouseover="showhint('Stock Agent '+getValue(), this, event, '210px')" style="margin-top:5px;display:none" /><? } ?>

                    <? if ($oSystem->checkPriv($vUser,"mdm_listprof_uwallet")) { ?><input name="btWallet2" type="button" class="btn btn-success btn-sm" id="btWallet2" onclick="MM_goToURL('parent','../memstock/ewalletbal.php?&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Nex-Wallet &raquo;" onmouseover="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px;display:none" /><? } ?>
                    <? if ($oSystem->checkPriv($vUser,"mdm_listprof_uwallet")) { ?><input name="btWallet2" type="button" class="btn btn-success btn-sm" id="btWallet2" onclick="MM_goToURL('parent','../memstock/ewalletrobal.php?&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="RO-Wallet &raquo;" onmouseover="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px;display:none" /><? } ?>

                    <? if ($oSystem->checkPriv($vUser,"mdm_listprof_walladj")) { ?> <input name="btKoreksi2" type="button" class="btn btn-success btn-sm" id="bKoreksi2" onclick="MM_goToURL('parent','../manager/koreksi.php?&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="UWallet Correction &raquo;" onmouseover="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px;display:none" /><? } ?>

                    <? if ($oSystem->checkPriv($vUser,"mdm_listprof_repstinout")) { ?><input name="btStWallet2" type="button" class="btn btn-success btn-sm" id="btStWallet2" onclick="MM_goToURL('parent','../memstock/stockbal.php?&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Stock In/Out Report &raquo;" onmouseover="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px;display:none" /><? } ?>

                    <? if ($oSystem->checkPriv($vUser,"mdm_listprof_stockadj")) { ?><input name="btKoreksiSt2" type="button" class="btn btn-success btn-sm" id="bKoreksiSt2" onclick="MM_goToURL('parent','../manager/koreksistock.php?&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Stock Adjustment &raquo;" onmouseover="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px;display:none" /><? } ?>

                    <? if ($oSystem->checkPriv($vUser,"mdm_listprof_reporderhist")) { ?><input name="btHist2" type="button" class="btn btn-success btn-sm" id="btHist2" onclick="MM_goToURL('parent','../memstock/historyro.php?&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Order History Report &raquo;" onmouseover="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px;display:none" /><? } ?>

                    <? if ($oSystem->checkPriv($vUser,"mdm_listprof_repspon")) { ?><input name="btSpon2" type="button" class="btn btn-success btn-sm" id="btSpon2" onclick="MM_goToURL('parent','../memstock/stjaringan.php?&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Sponsorship &raquo;" onmouseover="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px;display:none" /><? } ?>

					<? if ($oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btGenea2" type="button" class="btn btn-success btn-sm" id="btGenea2" onclick="MM_goToURL('parent','../memstock/genealogi2.php?&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Genealogi &raquo;" onmouseover="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px;display:none" />&nbsp;<? } ?>	                    

					 <? if ($oSystem->checkPriv($vUser,"mdm_listprof_reppair")) { ?><input name="btPair2" type="button" class="btn btn-success btn-sm" id="btPair2" onclick="MM_goToURL('parent','../memstock/pairing.php?&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Komisi Pair Report &raquo;" onmouseover="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px;display:none" /><? } ?>

                    <? if ($oSystem->checkPriv($vUser,"mdm_listprof_repcf")) { ?><input name="btCF2" type="button" class="btn btn-success btn-sm" id="btCF2" onclick="MM_goToURL('parent','../memstock/pairingcf.php?&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="CF Omzet &raquo;" onmouseover="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px;display:none" />&nbsp;<? } ?>

					<? if ($oSystem->checkPriv($vUser,"mdm_listprof_repwd")) { ?><input name="btWD" type="button" class="btn btn-success btn-sm" id="btWD" onclick="MM_goToURL('parent','../memstock/withdraw.php?&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Withdraw History &raquo;" onmouseover="showhint('Withdraw History '+getValue(), this, event, '210px')" style="margin-top:5px;display:none" />&nbsp;<? } ?>

            </p>

            <p><br>

              <?

   for ($i=0;$i<$vPageCount;$i++) {

     $vOffset=$i*$vBatasBaris;

	   $idisp=$i;

	 if ($vOP=="post") $idisp=0;

     if ($idisp!=$vPage) {

?>

              <a  href="approval.php?lmAktif=<?=$vAktif?>&amp;lmMship=<?=$vPrem?>&amp;uPage=<?=$idisp?>&amp;lmSort=<?=$vSort?>" >

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

      </div>
<button class="btn btn-info btn-sm" onClick="document.location.href='../manager/getexcel.php?arr=approve&file=data_aktifasi'"><i class="fa fa-file-text-o"></i> Export Excel</button>      
      </td>

</tr>



       <!-- page end-->

        </section>
</div>        

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



