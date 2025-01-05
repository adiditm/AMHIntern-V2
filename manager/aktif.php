<? include_once("../framework/admin_headside.blade.php")?>

<?

   include_once("../classes/mobdetectclass.php");

    include_once("../classes/jualclass.php");

	include_once("../classes/productclass.php");

   



$vCurrent=$_GET['current'];
$vChoosed =$_GET['choosed'];


include_once("../classes/networkclass.php");

define("MENU_ID", "mdm_member_aktif_detail");   



$vFall=$_GET['fallback'];



 if (!true || $oSystem->checkPriv($vUser,MENU_ID)) { ;

 }



//$vOP=$_REQUEST['hOP'];

$vSpy=md5('spy');

$vID=$_REQUEST['tfID'];

$vNama=$_REQUEST['tfNama'];

$vNoHP=$_REQUEST['tfNoHP'];
$vNoKTP=$_REQUEST['tfNoKTP'];

$vKota=$_REQUEST['tfKota'];

$vAktif=$_REQUEST['lmAktif'];

$vSort=$_REQUEST['lmSort'];

//$vCrit=" and faktif <> '0' ";



if ($vSort=="") $vSort=$_GET['lmSort'];

if ($vSort=="") $vSort=1;



if ($vAktif=="") $vAktif=$_GET['lmAktif'];

$vPrem=$_REQUEST['lmMship'];

if ($vPrem=="") $vPrem=$_GET['lmMship'];

$vStockist=$_REQUEST['lmStockist'];



if ($vSort=="1")

   $vOrder=" ftgldaftar ";

if ($vSort=="2")

   $vOrder=" fidmember ";

if ($vSort=="3")

   $vOrder=" fnama ";

   

   

if ($vID!="")

   $vCrit.=" and fidmember like '%$vID%' ";







if ($vNama!="")

   $vCrit.=" and fnama like '%$vNama%' ";

if ($vNoHP!="")

   $vCrit.=" and fnohp like '%$vNoHP%' ";
 
 if ($vNoKTP!="")

   $vCrit.=" and fnoktp like '%$vNoKTP%' ";

if ($vKota!="")

   $vCrit.=" and fkota like '%$vKota%' ";

if ($_GET['tfDepart'] !='') 
   $vCrit .= " and ftgldepart='{$_GET['tfDepart']}' ";

if ($vAktif==2)

   $vCrit.=" and faktif = 0";

else if ($vAktif==1)   

   $vCrit.=" and faktif = 1";



$vPage=$_GET['uPage'];
$vBatasBaris=15;
if ($vPage=="")
 	$vPage=0;

$vStartLimit=$vPage * $vBatasBaris;	
$vSaldoAll=$db->f('fsaldo');
$vsql="select * from m_anggota where 1 ";

$vsql.=$vCrit;
$vsql.=" order by $vOrder ";

$db->query($vsql);
$vArrMem="";
$vArrHead=array('Username','Name','Alamat','Kota','No. HP');
$vArrBlank=array('','','','','');

$i=0;
$vArrMem[]=$vArrHead;
//$vArrMem[]=$vArrBlank;
/*while ($db->next_record()) { //Convert Excel
	$vKotaList=$db->f('fkota');
	$vProp=$db->f('fprop');
	$vWil=$oMember->getWilName('ID',$vProp,$vKotaList,'','');    

	$vArrMem[]=array($db->f('fidmember'),$db->f('fnama'),$db->f('falamat'),$vWil," ".$db->f('fnohp'));
	//$vArrMem['fpassword'][$i]=$oSystem->doED('decrypt',$db->f('fpassword'));
	$i++;

}*/





$_SESSION['member']=$vArrMem;

//print_r($vArrMem);





$db->query($vsql);



$db->next_record();



$vRecordCount=$db->num_rows();



$vPageCount=ceil($vRecordCount/$vBatasBaris);





//$from="Uneeds <info@uneeds-style>";



?>









   <script src="../vendors/jquery/dist/jquery.min.js"></script>

<script language="JavaScript" type="text/JavaScript">

function doDel(pParam,pIDTr) {

   if (confirm('Are you sure to delete this jamaah ('+pParam+')')) {

	  var vURL='../manager/processing_ajax.php?current=<?=$vCurrent?>&op=deljam&od='+pParam;

	  $.get(vURL,function(data){

		  if (data=='success') {

			alert('Jamaah '+pParam+' already deleted!')  ;

			$('#tr'+pIDTr).css("background-color", "#ccc"); 

		  }

	  }); 

	   

   } else return false;

}

$(document).ready(function(){



    $('#caption').html('Members Profiles');

    $('[data-toggle="tooltip"]').tooltip({tooltipClass:"ttclass"}); 

$('#tfDepart').datepicker({

                    format: "yyyy-mm-dd",
					//"setDate": new Date()

    }).on('changeDate', function (ev) {

    				$(this).datepicker('hide');

    });  

	



});



<!--

function MM_openBrWindow(theURL,winName,features) {
  		winName='wNew';
		window.open(theURL,winName,features);
}

function MM_goToURL() { //v3.0
  var vChecked=$('.classRB:checked').length;
  if (parseInt(vChecked) < 1 ) {
	alert('Pilih jamaah terlebih dahulu!');  
	return false;
  }
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



   if (pOP=='act') vMess='Apakah Anda yakin mengaktifkan reseller ini?';



   else if (pOP=='trial') vMess='Apakah Anda yakin mengaktifkan reseller ini untuk trial?';



   else if(pOP=='stop') vMess='Apakah Anda yakin stop reseller ini untuk trial?';



   else vMess='Apakah Anda yakin menghapus reseller ini?';



   vSure=confirm(vMess);



   if (vSure==true) {



	     window.location=pURL+"&uStockist=0";



   } 



}







function doDeActivate(pURL) {



   vSure=confirm('Apakah Anda yakin me-non-aktifkan reseller ini?');



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



function doBlock(pParam,pIDTr) {

   if (confirm('Are you sure to block this member ('+pParam+')')) {

	  var vURL='../manager/processing_ajax.php?current=<?=$vCurrent?>&op=block&od='+pParam;

	  $.get(vURL,function(data){

		  if (data=='success') {

			alert('Member '+pParam+' already blocked!')  ;

			$('#tr'+pIDTr).css("background-color", "#ccc"); 

		  }

	  }); 

	   

   } else return false;

}



function doUnblock(pParam,pIDTr) {

   if (confirm('Are you sure to activate this member ('+pParam+')')) {

	  var vURL='../manager/processing_ajax.php?current=<?=$vCurrent?>&op=unblock&od='+pParam;

	  $.get(vURL,function(data){

		  if (data=='success') {

			alert('Member '+pParam+' already activated!')  ;
			document.location.href='../manager/aktif.php?op=&current=mdm_admin&menu=mdm_admin_verify';

			$('#tr'+pIDTr).css("background-color", "yellow"); 

		  }

	  }); 

	   

   } else return false;

}





//-->



function showDown(pUser) {

     var vURL='../manager/popdown.php?uMemberId='+pUser;

	 window.open(vURL,'wDowm','width=950,height=800,scrollbars=yes');



}

</script>



<!--	<link rel="stylesheet" href="../css/screen.css"> -->







	



	



 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />



  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />



  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />



  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />



  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />







<style type="text/css">
   .table-responsive{scrollbar-x-position: top !important; }


.ttclass {

 opacity:1;

 background-color:#eee;

 border:1px solid;

 border-radius:3px;

}

<!--



.style1 {color:#666666}



.style2 {



	color: #000000;



	font-weight: bold;



}



-->





/*





@media 



only screen and (max-width: 760px),



(min-device-width: 768px) and (max-device-width: 1024px)  {







	/* Force table to not be like tables anymore 



	table, thead, tbody, th, td, tr { 



		display: block; 



	}



	



	/* Hide table headers (but not display: none;, for accessibility) 



	thead tr { 



		position: absolute;



		top: -9999px;



		left: -9999px;



	}



	



	tr { border: 1px solid #ccc; }



	



	td { 



		/* Behave  like a "row" 



		border: none;



		border-bottom: 1px solid #eee; 



		position: relative;



		padding-left: 50%; 



	}



	



	td:before { 



		/* Now like a table header



		position: absolute;



		/* Top/left values mimic padding */

/*

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

*/

</style>



	<div class="right_col" role="main">

		<div><label><h3>Profile Jamaah</h3></label></div>







<div align="left" class="table-responsive col-lg-6" style="min-height:270px" > 
       		<form method="get"  >
       		<div class="row" >
		  <table border="0" cellpadding="4" cellspacing="0"  align="left" >
            <tr>
              <td colspan="2" ><div align="left"><font size="3"><strong>Filter</strong></font></div></td>
            </tr>
            <tr>
              <td height="25" style="width: 14%" ><div align="left">ID Jamaah </div></td>
              <td width="62%" height="25"><div align="left">
                <input name="hOP" type="hidden" id="hOP" value="post" />
                 <input name="current" type="hidden" id="current" value="<?=$_REQUEST['current']?>" />
                 <input name="menu" type="hidden" id="menu" value="<?=$_REQUEST['menu']?>" />
                 <input name="tfNama" type="hidden" id="tfNama" value="<?=$_REQUEST['tfNama']?>" />
                  <input name="tfKota" type="hidden" id="tfKota" value="<?=$_REQUEST['tfKota']?>" />
                   <input name="tfDepart" type="hidden" id="tfDepartX" value="<?=$_REQUEST['tfDepart']?>" />
                    <input name="tfNoHP" type="hidden" id="tfNoHP" value="<?=$_REQUEST['tfNoHP']?>" />
                     <input name="lmAktif" type="hidden" id="lmAktif" value="<?=$_REQUEST['lmAktif']?>" />
                 

                <input name="tfID" type="text" class="form-control" id="tfID" value="<?=$vID?>" />
              </div></td>
            </tr>
            <tr>



              <td height="25" style="width: 14%"><div align="left">Nama</div></td>



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
             <td style="height: 25px; width: 14%;"><div align="left">No KTP</div></td>



              <td style="height: 25px"><div align="left">



                  <input name="tfNoKTP" type="text" class="form-control" id="tfNoKTP" value="<?=$vNoKTP?>" />



              </div></td>
            </tr>



            <tr style="display:none">



              <td height="25" style="width: 14%"><div align="left">Kota</div></td>



              <td height="25"><div align="left">



                  <input name="tfKota" type="text" class="form-control" id="tfKota" value="<?=$vKota?>" />



              </div></td>



            </tr>

<tr >



              <td height="25" style="width: 14%" nowrap><div align="left">Tgl. Berangkat</div></td>



              <td height="25"><div align="left">



                  <input autocomplete="off" name="tfDepart" type="text" class="form-control" id="tfDepart" value="<?=$_GET['tfDepart']?>" />



              </div></td>



            </tr>

            <tr class="hide">



              <td style="width: 14%; height: 25px;"><div align="left">Stockist</div></td>



              <td style="height: 25px"><div align="left">



                  <select name="lmStockist" class="form-control" id="lmStockist">



                    <option value="" selected="selected">--All--</option>



                    <option value="0" <? if ($vStockist==0 && $vStockist!="") echo "selected"?>>Bukan Stockist</option>



                    <option value="1" <? if ($vStockist==1) echo "selected"?>>Stockist</option>



                  </select>



              </div></td>



            </tr>



            <tr style="display:">



              <td style="height: 25px; width: 14%;"><div align="left">Status</div></td>



              <td style="height: 25px"><div align="left">



                  <select name="lmAktif" class="form-control" id="lmAktif">



                    <option value="3" selected="selected">--All--</option>



                    <option value="2" <? if ($vAktif==2) echo "selected"?>>Inactive</option>



                    <option value="1" <? if ($vAktif==1) echo "selected"?>>Active</option>



                  </select>



              </div></td>



            </tr>



            <tr class="hide">



              <td height="25" style="width: 14%"><div align="left">Reg. Package</div></td>



              <td height="25"><div align="left">



                <select name="lmMship" class="form-control" id="lmMship">



                  <option value="-" selected="selected">--All--</option>



                  <option value="S" <? if ($vPrem=="B" || $vPrem=="S") echo "selected"?>>Executive</option>

				  <option value="G" <? if ($vPrem=="F" || $vPrem=="G") echo "selected"?>>Exclusive</option>

                  <option value="P" <? if ($vPrem=="F" || $vPrem=="P") echo "selected"?>>Elite</option>



                </select>



              </div></td>



            </tr>



            <tr style="display:none">



              <td style="height: 25px; width: 14%;"><div align="left">Sort By</div></td>



              <td style="height: 25px"><div align="left">



                <select name="lmSort" class="form-control" id="lmSort">
                  <option value="1" <? if ($vSort=="1") echo "selected";?>>Reg. Date</option>
                  <option value="2" <? if ($vSort=="2") echo "selected";?>>ID Jamaah</option>
                  <option value="3" <? if ($vSort=="3") echo "selected";?>>Nama</option>
                </select>



              </div></td>



            </tr>



            <tr>



              <td colspan="2"><div align="left"><br>



                  <input name="Submit" type="submit" class="btn btn-success" value="Cari" />



                &nbsp; &nbsp;



                <input name="Submit2" type="button" class="btn btn-default" value="Reset" onClick="document.location.href='../manager/aktif.php?op=&current=mdm_admin&menu=mdm_admin_verify'" />



              </div></td>



            </tr>



          </table>

          </div>



</form>

 </div> <!--responsive-->

<?

      if ($oDetect->isMobile()) {

 

?>

<div style="margin-top:3em">

<? } else { ?>

<div style="margin-top:23em">



<? } ?>

<? 
  $vSeq = '1';
  include("../manager/btnmenu.php");

?>    

    



     



<br><br>

<form name="memberForm">

      <div class="table-responsive"  >



    <table width="100%" border="0" align="left" cellpadding="1" cellspacing="0" class="table" style="background-color:white" >



      <tr style="color:;font-weight:bold">
        <td width="73" style="width: 30px">&radic;</td> 



        <td width="73"  height="26" style="width: 30px"> <div align="center" >ID Jamaah </div></td>



        <td width="250"><div align="center" >Nama 



        </div></td>



        <td width="300" class=""><div align="center" >Alamat 



          </div></td>



        <td width="160"><div align="center" >Phone No. 
          
          
          
        </div></td>



        <td width="268"><div align="center" > Tanggal Daftar</div></td>
        <td width="150" align="center">Tgl. Berangkat</td>


        <td width="150">Total Pembayaan</td>

        <td width="150" class="ide"><div align="center">Referensi</div></td>
        <td width="150" class="ide">Pendaftar</td>

        <td width="150" class="hide"><div align="center">Jenis Kelamin</div></td>
        <td width="" align="center">Status</td>
        <td width="" align="center">T. Terima</td>



        </tr>



      <?



		  if ($vOP=="post") $vStartLimit=0;



		  $vsql="select * from m_anggota where 1 ";



		  $vsql.=$vCrit;



		  $vsql.=" order by $vOrder ";



		  $vsql.="limit $vStartLimit ,$vBatasBaris ";



			//echo "<br><br><br>".$vsql;



		  $db->query($vsql);



		  $vHari=$oRules->getSettingByField("fbyyprint");



		  while ($db->next_record()) {



		     $vAktifList=$db->f('faktif'); 
			 if ($vAktifList=='1')
			    $vActives = '#FFF';
			else if ($vAktifList=='0')	
				$vActives = '#FF0';



			 $vTrial=$db->f('fisfree');



			 $vIDSys=$db->f('fidsys');

			 $vIDMem=$db->f('fidmember');

			 if ($vAktifList=='1') {

			     $vActive='white';
				 $vActiveText = "Aktif";

			 } else if ($vAktifList=='4')

			     $vActive='#ccc';

			 else{  $vActive='white';
			 $vActiveText = "Tidak Aktif";
			 
			 }
			 
			 $vCheckDoc=$db->f('fdoc');

			     







			  $vTglAktif=$oPhpdate->DMY2YMD($oPhpdate->YMD2DMY($db->f('ftglaktif')));



			     $vSaldo=$db->f('fsaldovcr');

				 $vSaldoProd=$db->f('fsaldowprod');

				 $vSaldoJaminan=$db->f('fsaldoro');

				 $vSaldoAcc=$db->f('fsaldowacc');



			 $vStockistCSS='';
			 
			 $vDepart = $db->f('ftgldepart');
			 $vSQLSeat = "select * from m_infodep where ftgldepart='$vDepart' ";
			 $db1->query($vSQLSeat);
			 $db1->next_record();
			 $vSeat = $db1->f('fsisaseat');




				

			    



		?>



      <tr  bgcolor="<?=$vActives?>" style="<?=$vStockistCSSs?>"  id="tr<?=$vIDSys?>"  >
        <td style=";" onMouseovers="showhint('<?=$vMess?>', this, event, '150px')" nowrap>
        <input class="classRB" id="rbSelected<?=$db->f('fidmember')?>" style="width:20px;height:20px" name="rbSelected" type="radio" value="<?=$db->f('fidmember')?>" onClick="checkStatus('<?=$db->f('faktif')?>','<?=$db->f('fstockist')?>')" <? if ($vChoosed==$db->f('fidmember')) echo 'checked'; ?> >
        </td> 



        <td style=";" onMouseovers="showhint('<?=$vMess?>', this, event, '150px')" nowrap>

			<span  data-toggle="tooltip" titlex="<?=$vToolTip?>" >

        <a name="<?=$db->f('fidmember')?>"></a>



        <div align="left"><span  >



          <?=$db->f('fidmember')?>



          <? if ($vTrial=='1' && $vAktifList=='1') { ?>



          <br>



          Trial s/d <?=$oPhpdate->YMD2DMY($oMydate->dateAdd($vTglAktif,$vHari,"day")) ?>



          <? } ?>

		

          <? if($vAktifList=='xxxx') { ?>	

           <br><button onClick="doBlock('<?=$vIDMem?>','<?=$vIDSys?>')" type="button" class="btn btn-xs btn-danger"><i class="fa fa-ban"></i> Block</button>

           <? } ?>



          <? if($vAktifList=='0') { ?>	
		 <? if ($_GET['current']=='mdm_admin' && $_GET['menu']=='mdm_admin_verify' ) {?>
           <br><button onClick="doUnblock('<?=$vIDMem?>','<?=$vIDSys?>')" type="button" class="btn btn-xs btn-success"><i class="fa fa-check"></i> Aktifkan</button>
           <? } ?>

           <? } ?>
           
           <? if ($_GET['current']=='mdm_admin' && $_GET['menu']=='mdm_admin_verify' ) {?>
           <br>
           <button onClick="doDel('<?=$db->f('fidmember')?>','<?=$vIDSys?>')" type="button" class="btn btn-xs btn-danger"><i class="fa fa-ban"></i> Delete</button>
   <? } ?>


          </span></div>

          

          </span></td>



        <td style="height: 39px;" ><span  data-toggle="tooltip" titlex="

          

		  LEFT: <? $vDownline="<b>LEFT</b>: "; echo '<br>';

		     //$vArrCangkok = $oNetwork->getArrayCangkok();

			 //if (!in_array($vKakiL,$vArrCangkok))

			  //   $vOutL[]=$vKakiL;

			/* while(list($key,$val)=@each($vOutL)) {

				$vPack=$oMember->getPaketID($val); 

				echo "[$val] "; 

				$vDownline .= " [$val/$vPack] ";

			 }

			 */

			

		  ?> 



		  <br>RIGHT: <? $vDownline .="<br><br><b>RIGHT</b>: "; echo '<br>';

		   //  if (!in_array($vKakiR,$vArrCangkok))

			//    $vOutR[]=$vKakiR;

		/*	 

			 while(list($key,$val)=@each($vOutR)) {

				$vPack=$oMember->getPaketID($val); 

				echo "[$val] "; 

				$vDownline .= " [$val/$vPack] ";

			 }

		  

		 */ 

		  ?> ">
		  <div align="left" data-toggle="modalx" data-target="#detailModalx"  >
          <?=$db->f('fnama');?>
          </div></span></td>
        <td width="338" style="height: 39px" class="">          
        <div align="left"><span >



          <?=$db->f('falamat').", ".$oMember->getWilName('ID',$db->f('fprop'),$db->f('fkota'),'00','00')?>



          <br>



          </span></div></td>



        <td  style="height: 39px"> 
          
          
          
          <div align="left"><span >
            
            
            
            <?=$db->f('fnohp')?>
            
            
            
            &nbsp;          </span></div></td>



        <td  style="height: 39px" align="center" nowrap><?=$oPhpdate->YMD2DMY($db->f('ftglaktif'))?>                  </td>
        <td  nowrap style="height: 39px;<? if ($db->f('fpriv')=='1') echo 'background-color:#ccc';?>" align="center"><?=$oPhpdate->YMD2DMY($db->f('ftgldepart'))?> <br>Sisa seat: <?=$vSeat?></td>


        <td  style="height: 39px;<? if ($db->f('fpriv')=='1') echo 'background-color:#ccc';?>"><div align="right">
          
          <?
          
		  	//number_format($db->f('ftotalbayar'),0,",",".");
		  	$vSQL = "select sum(fcredit) as total from tb_payhist where fidmember='".$db->f('fidmember')."'";
			$dbin->query($vSQL);
			$dbin->next_record();
			echo number_format($dbin->f('total'),0,",",".");
		  ?>
          
        </div></td>

        <td nowrap align="center" class="" style="height: 39px;<? if ($db->f('fpriv')=='1') echo 'background-color:#ccc';?>"><div align="left">

          <?=$db->f('frefer')?>

        </div></td>
        <td nowrap align="left" class="" style="height: 39px;<? if ($db->f('fpriv')=='1') echo 'background-color:#ccc';?>"><?=$db->f('fidregistrar')==''?'<font color="#00f"><b>Umum</b></font>':$db->f('fidregistrar')?></td>

        <td class="hide"  style="height: 39px;<? if ($db->f('fpriv')=='1') echo 'background-color:#ccc';?>"><div align="right">

          <?=number_format($vSaldoAcc,0,",",".")?>

        </div></td>
        <td  style="height: 39px" <? if($vFall==$db->f('fidmember')) echo "bgcolor=#0f0";?>><?=$vActiveText?></td>
        <td  style="height: 39px" align="center"><? if (trim($vCheckDoc)!='') {?><a  target="_blank" href="<?=$vCheckDoc?>"> <li class="fa fa-file-pdf-o" style="font-size:28px"></li></a><? } ?></td>



              </tr>



        <? } // while $db->next_record?>



        



      <tr  > 



        <td colspan="6" align="right" style="font-weight:bold">
          
          
          
          Total Active Member: <?=$vRecordCount?></td>
        <td  align="right" style="font-weight:bold">&nbsp;</td>


        <td  align="right" style="font-weight:bold">&nbsp;</td>

        <td  align="right" style="font-weight:bold">&nbsp;</td>
        <td  align="right" style="font-weight:bold">&nbsp;</td>

        <td  align="right" style="font-weight:bold">&nbsp;</td>
        <td  >&nbsp;</td>
        <td  >&nbsp;</td>



              </tr>



                



      </table>



      </div>

    



    </form>

 </div>


<? 
  $vSeq = '2';
  include("../manager/btnmenu.php");

?>  

      

  



          



<div class="row" align="center">
<ul class="pagination" >
              <?
   for ($i=0;$i<$vPageCount;$i++) {
     $vOffset=$i*$vBatasBaris;
	   $idisp=$i;
	 if ($vOP=="post") $idisp=0;
     if ($idisp!=$vPage) {
?>
              <li ><a  href="aktif.php?lmAktif=<?=$vAktif?>&lmMship=<?=$vPrem?>&uPage=<?=$idisp?>&lmSort=<?=$vSort?>&current=<?=$_REQUEST['current']?>&menu=<?=$_REQUEST['menu']?>&tfNoHP=<?=$_REQUEST['tfNoHP']?>&tfKota=<?=$_REQUEST['tfKota']?>&tfDepart=<?=$_REQUEST['tfDepart']?>&lmAktif=<?=$_REQUEST['lmAktif']?>&tfNama=<?=$_REQUEST['tfNama']?>" >
              <?=$i+1?>
              </a> </li> 
              <?
  } else {
?>

<li class="active">
             <a> <?=$i+1?></a> </li>
              <? } ?>
              <?  } //while?>
              <span >                </span><br>
              <br>
              </ul>
</div>

 <br>
      <button class="btn btn-info btn-sm hide" onClick="document.location.href='../manager/getexcel.php?arr=member&file=data_member'"><i class="fa fa-file-text-o"></i> Export Excel</button>
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
<script src="../js/scripts.js"></script>
 </div>
<? include_once("../framework/admin_footside.blade.php") ; ?>
