<? include_once("../framework/admin_headside.blade.php");

include_once("../classes/memberclass.php");

include_once("../classes/networkclass.php");

include_once("../classes/systemclass.php");

?>

 <?php

  $vUser=$_SESSION['LoginUser'];

  $vSpy = md5('spy').md5($_GET['uMemberId']);



   if ($_GET['op']==$vSpy)

      $vUserActive=$_GET['uMemberId'];

   else   $vUserActive = $vUser; 



 

 $refer = $_SERVER['HTTP_REFERER'];

 $vAction=$_POST['hAction'];

 $vNama=$_POST['nama'];

 $vID=$_POST['ID'];

 $vNom=$_POST['tfNom'];

 $vTgl=$_POST['dc'];

 $vKet=$_POST['taKet'];

 $vRekFrom=$_POST['tfRekFrom'];

 $vRekTo=$_POST['lmRekTo'];

 

 $vCurrTo=$_GET['curr'];

 if ($vCurrTo=='')

  $vCurrTo='IDR';

 

// $vInvest=$oMember->checkInvest($vUser);

  

 

 $vFrom=$oRules->getSettingByField('fmailfrom');



 $vMessage="Withdrawal Deposit :\n";

 $vMessage.="Nama\t\t\t: $vNama\n";

 $vMessage.="ID\t\t\t: $vID\n";

 $vMessageReply="$vNama, silakan tunggu approval dari Admin, withdrawal akan dikirim ke ".$oMember->getBankName($oMember->getBank($vUserActive))." ".$oMember->getRekening($vUserActive);





 

 if ($vAction=="fPost") {

   if ($vNom>0 ) {

      $vNextID=$oMember->getNextWDID($vTgl);

      $vMailMem=$oMember->getEmail($vUserActive);

      $oMember->regWithdraw($vNextID,$vID,$vNom,$vTgl,$vKet,$vRekFrom,$vRekTo,1,$vCurrTo);

		$vSMTP=$oRules->getSettingByField('fsmtp');

		//$oSystem->sendMail($vFrom,$oRules->getSettingByField('fmailfrom'),$vNama,$oRules->getSettingByField('fmailbcc'),"Upgrade",$vMessage,$vSMTP); 

		

		$oSystem->sendMail($oRules->getSettingByField('fmailfrom'),$vMailMem,$oRules->getSettingByField('fatasnama'),$oRules->getSettingByField('fmailbcc'),"Balasan Withdraw ",$vMessageReply,$vSMTP); 

		$vMesgSMS="$vNama, proses withdrawal $vNextID sebesar ".number_format($vNom,0,",",".")." berhasil, silakan tunggu approval dari Admin.";

		$vNoHP=$oMember->getNoHP($vID);

		//$oSystem->smsGateway(date("Y-m-d H:i:s"),preg_replace("/^0/","62",$vNoHP),$vMesgSMS,'Investasi');	

		$oSystem->jsAlert("Withdrawal sukses, harap tunggu proses approval dari Admin!");

		$oSystem->jsAlert($vMessageReply.", jika perlu catatlah pesan ini. Anda juga akan mendapatkan pesan ini di email Anda. Terima kasih!");

		$oSystem->jsLocation("withdraw.php");

	 } else { // Serial Harus diisi

		 $oSystem->jsAlert("Isikan withdraw dengan benar!");

	 }

 

}	//Post





	$vsNoJual=$_POST['tfsnojual'];

	$vsIgnore=$_POST['cbIgnore'];

	$vsIDMember=$_POST['tfsidmember']; 

	$vsTglAwal=$_POST['dc1'];

	if ($vsTglAwal=='') $vsTglAwal=date("Y-m-d");

	$vsTglAkhir=$_POST['dc2'];

	if ($vsTglAkhir=='') $vsTglAkhir=date("Y-m-d");

	

 	$vPostID=$_POST['tfID'];

	$vPostIDProd=$_POST['tfIDProd'];

	$vPostJumlah=$_POST['tfJumlah'];

	$vPostTanggal=$_POST['dc'];

	$vTanggal=$oPhpdate->getNowYMD("-");

	$vNoJual="J".$oPhpdate->getNowYMDTFlat();

	

	if ($vsNoJual!="")

    $vCrit.=" and fidwithdraw like '%$vsNoJual%' ";

	if ($vsIDMember!="")

    $vCrit.=" and fidwithdraw = '$vsIDMember' ";



 ?>

 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />

 

<style type="text/css">

<!--

.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #0000FF; }

.style7 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #0000FF;}

.style8 {

	font-family: Verdana, Arial, Helvetica, sans-serif;

	font-weight: bold;

	font-size: 15px;

}

.style9 {

	font-size: 12px;

	font-weight: bold;

}

.style10 {font-size: 12px}

.style11 {color: #FFFFFF}

input,select,textarea,button {

	border:1px solid #999;

}

-->

</style>



<script language="javascript">

function saveWithdraw() {

	var vNom=document.getElementById('tfNom').value;

	var vSaldoX=document.getElementById('hSaldoConvert').value;

	var vWD=document.getElementById('tfNom').value;

	if (parseFloat(vWD) > parseFloat(vSaldoX)) {

		alert('Withdraw amount '+vWD+' excedes your balance '+vSaldoX+' (included pending withdraw)');

		return false;

	}

	if (document.getElementById('lmRekTo').value=='') {

		alert('Choose your bank account number');

		return false;

	}



	   

	if (confirm('Are you sure to do withdraw <?=$vCurrTo?> '+vNom+'?')==true) {

		document.frmInvest.submit();

	} else return false;

}





$(document).ready(function(){

      $('#caption').html('U-Wallet Withdrawal');



  /* $('#dc').datepicker({

                    format: "yyyy-mm-dd",

                    autoclose : true

    });  

    */

       $('#dc1').datepicker({

                    format: "yyyy-mm-dd",

                    autoclose : true

    }); 

  

  

       $('#dc2').datepicker({

                    format: "yyyy-mm-dd",

                    autoclose : true

    }); 

  

});	



function setCurr(pParam) {

    document.location.href='../memstock/withdraw.php?curr='+pParam;

	

}

</script>

<div class="right_col" role="main">

		<div><label>

		<h3>Penukaran Voucher Onotoko.com</h3>

		</label></div> 



  

   

   <?

       $vSaldoIDR=$vSaldo;

	   $vCurrFrom='IDR';

	   $vSQL="select funit, fratenom from tb_exrate where fratefrom='$vCurrFrom' and frateto='$vCurrTo'";

	   $db->query($vSQL);

	   $db->next_record();

	   $vUnit=$db->f('funit');

	   $vRateNom=$db->f('fratenom');

       if ($vUnit > 0)	 

	      $vConvert=$vSaldoIDR * $vRateNom / $vUnit;

	   else $vConvert=$vSaldoIDR;	  

	   

   ?>

           <!--body wrapper start-->

 	   <section class="wrapper" style="width:100%">

 		  <div align="left" style="width:98%;margin-left:1%" class="table-responsive">    

<input type="hidden" id="hSaldoConvert" name="hSaldoConvert" value="<?=$vConvert?>" >

<table  width="100%"  border="0" cellpadding="0" cellspacing="0">

  

  <tr valign="top"> 

    <td align="center" valign="top">

    <?  if ($_GET['op']!=$vSpy) {?>

      <table width="90%"  border="0" align="left" cellpadding="0"  cellspacing="0">

        <tr> 

          <td width="498"  height="25" align="left" valign="top">

         

               <form name="frmInvest" method="post" action="" >

              <table width="100%" border="0" align="left" cellpadding="4" cellspacing="0" >

                <tr>

                  <td>Balance</td>

                  <td>&nbsp;</td>

                  <td><div class="form-inline"><label><?=number_format($vConvert,2,",",".");?> </label>

                  <select name="lmCurr" id="lmCurr" class="form-control" style="width:85px" onChange="setCurr(this.value);">

                     <?

                         $vSQL="select distinct  frateto from tb_exrate order by frateto";

						 $db->query($vSQL);

						 while ($db->next_record()) {

							 $vCurr=$db->f('frateto');

					 ?>

                         <option value="<?=$vCurr?>" <? if ($vCurr==$vCurrTo) echo 'selected'; ?>><?=$vCurr?></option>

                     

                     <? } ?>

                     </select>

                     </div>

                  </td>

                </tr>

                <tr>

                  <td>Date</td>

                  <td>:</td>

                  <td>

                    <div align="left">

                      <input class="form-control"  name="dc" id="dc" value="<?=date("Y-m-d")?>" size="12" readonly="readonly" />

                    </div></td>

                </tr>

                <tr> 

                  <td width="129" height="30">Name</td>

                  <td width="3">:</td>

                  <td width="335"> <div align="left">

                    <input class="form-control" name="nama" type="text" value="<?=$oMember->getMemberName($vUserActive)?>" readonly="true">

                    <input name="hAction" type="hidden" id="hAction" value="fPost"> 

                  </div></td>

                </tr>

                <tr>

                  <td>ID</td>

                  <td>:</td>

                  <td><div align="left">

                    <input class="form-control" name="ID" type="text" id="ID" value="<?=$vUserActive?>" readonly="true" />

                  </div></td>

                </tr>

                <tr> 

                  <td>Withdraw Amount</td>

                  <td>&nbsp;</td>

                  <td> <div align="left">

                   

                    <input class="form-control" name="tfNom" type="text" id="tfNom" dir="rtl" value="0" size="15" >

                     

                     

                  </div></td>

                </tr>

                

 <tr>

                  <td>Transfer to Account</td>

                  <td>&nbsp;</td>

                  <td><div align="left">

                    <select class="form-control" name="lmRekTo" id="lmRekTo" onChange="getData(this.value)">

                      <option value="<?=$oMember->getBank($vUserActive)?>"><?=$oMember->getBankName($oMember->getBank($vUserActive))?> <?=$oMember->getAtasNama($vUserActive)?> <?=$oMember->getRekening($vUserActive)?></option>

                

                    </select>

                  </div></td>

                </tr>

                <tr class="hide">

                  <td>Account Holder</td>

                  <td>&nbsp;</td>

                  <td><div align="left">

                    <input class="form-control" name="tfRekFrom" type="text" id="tfRekFrom"  />

                  </div></td>

                </tr>

                                

               

                <tr>

                  <td>Description</td>

                  <td valign="top">&nbsp;                </td>

                  <td><div align="left">

                    <textarea class="form-control" name="taKet" id="taKet" cols="45" rows="7"></textarea>

                  </div></td>

                </tr>

                

                <tr> 

                  <td height="37">&nbsp;</td>

                  <td>&nbsp;</td>

                  <td> <div align="left">

                    <input class="btn btn-primary" type="button" onClick="saveWithdraw()" name="kirim" value="Submit" > 

                    <input 



type="reset" class="btn btn-default" name="reset" value="Reset"> 

                  </div></td>

                </tr>

              </table>

            </form>

          <p>&nbsp;</p></td>

        </tr>

        <tr>

          <td  height="25" align="left" valign="top"></td>

        </tr>

    </table>	 

	<? } ?>   </td>

  </tr>

  <tr valign="top">

    <td align="center" valign="top"><form style="font-family:Tahoma" action="" method="post" name="frListJual" id="frListJual">

      <p><span class="style1"><span class="style22 style8">Withdraw History <span class="style8">

          [<?=$vUserActive." / ".$oMember->getMemberName($vUserActive);?>]

                </span></span></span><br />

                <br />

     <span class="style10"><strong>From :</strong></span>

                    <input  name="dc1"  id="dc1" value="<?=$vsTglAwal?>" size="9" />&nbsp; <span class="style9"> to </span>

                <input  name="dc2" class="" id="dc2" value="<?=$vsTglAkhir?>" size="9" />&nbsp;

                  &nbsp;<input class="btn btn-primary" type="submit" name="button" id="button" value="Refresh" />

      <table width="100%%" border="1" align="center" cellpadding="5" cellspacing="" class="table table-striped">

            <!-- <tr style="display:none">

                <td height="26"></td>

                <td><div align="center">

                    <input name="tfsnojual" type="text" class="inputborder" id="tfsnojual" value="<?=$vsNoJual?>" size="10" />

                </div></td>

                <td colspan="2" ><div align="left">

                    <input type="submit" name="Submit2" value="Cari" />

                    <input name="cbIgnore" type="checkbox" id="cbIgnore" value="yes" <? if ($vsIgnore=="yes") echo "checked";?>>

                    <span class="style2 style11">Abaikan Tanggal </span> </div></td>

              </tr> -->

      <tr <? if ($vProcessed==2) echo "bgcolor='#CCCCCC'" ?> >

                <td width="14%" height="26"><div align="center" class="style9">Date</div></td>

                <td width="18%"><div align="center" class="style9">Withdraw No.</div></td>

               <td width="18%"><div align="center" class="style10"><strong> Withdraw Amount</strong></div>

                    <div align="center" class="style10"></div>

                <div align="center" class="style10"> </div></td>

               <td width="18%"><div align="center"><strong>Currency</strong></div></td>

                <td width="19%"><div align="center" class="style10"><strong>WDraw To Acc</strong></div></td>

                <td width="19%"><div align="center" class="style10"><strong>Status</strong></div></td>

                <td width="31%"><div align="center">

                  <div align="center" class="style10"><strong>Description</strong></div>

                </div></td>

          </tr>

              <?

		  $vsql="select fadmin,ftglupdate,ftglappv,fidwithdraw,fidmember,frekto,fnominal as asubtotal,fstatusrow, fket, fcurr from tb_withdraw where 1 and fidmember='$vUserActive' and date(ftglupdate) between  date('$vsTglAwal') and date('$vsTglAkhir')";

		  $vsql.=$vCrit;

		  $vsql.="   order by fidwithdraw ";



		  $db->query($vsql);

		  

		  $vTotJual=0; $vTotPoint=0;

		  while ($db->next_record()) {

			 $vKet="";    

			 $vProcessed=$db->f('fstatusrow');

			 $vAppv=$db->f('ftglappv');

			 $vAdmin=$db->f('fadmin');

			  $vCurrUser=$db->f('fcurr');

		?>

              <tr  <? if ($vProcessed==2) echo "style='background-color:#009999;color:#000'"; else if ($vProcessed==4) echo "style='background-color:#666;color:#000'"?>    >

                <td><div align="center" class="style10">

                    <?=$oPhpdate->YMD2DMY($db->f('ftglupdate'),"-")?>

                    <br />

                </div></td>

                <td><span class="style10">

                <?=$db->f('fidwithdraw')?>

                  <br />                

                  </span></td>

                <td><div align="right" class="style10">

                    <?=number_format($db->f('asubtotal'),0,",",".");?>

                    <? $vTotJual+=$db->f('asubtotal'); ?>

                </div></td>

                <td><div align="center"><?=$db->f('fcurr')?></div></td>

                <td><span class="style10">

                  <?=$oMember->getBankName($db->f('frekto'))?> <?=$oMember->getRekening($vUserActive)?> a.n. <?=$oMember->getAtasNama($vUserActive)?>

                </span></td>

                <td><div align="center" class="style10">

				<?

				   if ($vProcessed==0 || $vProcessed==1)

				      echo "Pending";

				   else if ($vProcessed==2) 

				      echo "Approved <strong>".$oPhpdate->YMD2DMY($vAppv,"-")."</strong> by ".$vAdmin;

				   else if ($vProcessed==4)

				      echo "Dibatalkan";  	  

					  	   

				?>

				</div></td>

                <td><span class="style10">

                  <?=$db->f('fket')?>

                </span></td>

              </tr>

              <? 

     

	 } // while $db->next_record //if $vCrit

  ?>

              <tr>

                <td colspan="2"><span class="style10"><strong>Total</strong></span></td>

                <td><div align="right" class="style10"><strong>

                    <?=number_format($vTotJual,0,",",".");?>

                </strong></div></td>

                <td>&nbsp;</td>

                <td>&nbsp;</td>

                <td><span class="style10"></span></td>

                <td>&nbsp;</td>

              </tr>

        </table>

    </form></td>

  </tr>

</table>





 </div>

</section>

</div>

 

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





		

		<!-- begin scroll to top btn -->

		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>

		<!-- end scroll to top btn -->

	</div>

	<!-- end page container -->





<? include_once("../framework/member_footside.blade.php") ; ?>