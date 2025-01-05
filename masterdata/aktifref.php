<? include_once("../framework/admin_headside.blade.php")?>

<?

   include_once("../classes/mobdetectclass.php");

    include_once("../classes/jualclass.php");

	include_once("../classes/productclass.php");

   
    $vRet= $oSystem->syncKorwil(); 
   $vFileName='../files/SyncPebisnis'.date('Y-m-d_H.i.s').'.htm';
   $fp=fopen($vFileName,'w',true);
   fputs($fp,$vRet,10000000);
   fclose($fp);		



$vCurrent=$_GET['current'];
$vChoosed =$_GET['choosed'];


include_once("../classes/networkclass.php");

define("MENU_ID", "mdm_member_aktif_detail");   



$vFall=$_GET['fallback'];



 if (!true || $oSystem->checkPriv($vUser,MENU_ID)) { ;

 }



$vOP=$_REQUEST['hOP'];

$vSpy=md5('spy');

$vID=$_REQUEST['tfID'];

$vNama=$_REQUEST['tfNama'];

$vNoHP=$_REQUEST['tfNoHP'];

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

if ($vKota!="")

   $vCrit.=" and fkota like '%$vKota%' ";



if ($vAktif==2)

   $vCrit.=" and faktif = 0";

else if ($vAktif==1)   

   $vCrit.=" and faktif = 1";



$vPage=$_GET['uPage'];
$vBatasBaris=50;
if ($vOP=="post")  $vBatasBaris=50000000000;
if ($vPage=="")
 	$vPage=0;

$vStartLimit=$vPage * $vBatasBaris;	
$vSaldoAll=$db->f('fsaldo');
$vsql="select * from m_pebisnis where 1 ";

$vsql.=$vCrit;
$vsql.=" order by fidmember ";

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

	$vArrMem[]=array($db->f('fidkorwil'),$db->f('fnama'),$db->f('falamat'),$vWil," ".$db->f('fnohp'));
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

$(document).ready(function(){



    $('#caption').html('Members Profiles');

    $('[data-toggle="tooltip"]').tooltip({tooltipClass:"ttclass"}); 


						/*$('#tblMain').DataTable({
							 "pageLength": 50,
							responsive: true,
						 	"language": {
    								"search": "Pencarian Umum:"
  							},
							
							"columnDefs": [
    							{
									"targets": [-1,0,1,2,3],
									 "orderable": false
									
								}
  							],
							
							// dom: 'Bfrtip',
       
						});*/


});



<!--

function MM_openBrWindow(theURL,winName,features) {
  		window.open(theURL,winName,features);
}

/*function MM_goToURL(pParam) { //v3.0
  if (pParam=='') {  
		  var vChecked=$('.classRB:checked').length;
		  if (parseInt(vChecked) < 1 ) {
			alert('Pilih korwil terlebih dahulu!');  
			return false;
		  }
		  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
		  if (getValue()=="") {
			  alert('Pilih salah satu member melalui Radio Button di kolom paling kanan, kemudian klik tombol ini kembali!');
			  return false;
		  }	  
		
		  for (i=0; i<(args.length-1); i+=2) 
			  eval(args[i]+".location='"+args[i+1]+"'");
	  
  } else return true;
}*/


function MM_goToURL() { //v3.0
  var vChecked=$('.classRB:checked').length;
  if (parseInt(vChecked) < 1 ) {
	alert('Pilih korwil terlebih dahulu!');  
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

function doDel(pParam,pIDTr) {

   if (confirm('Are you sure to delete this korwil ('+pParam+')')) {

	  var vURL='../manager/processing_ajax.php?current=<?=$vCurrent?>&op=delkor&od='+pParam;

	  $.get(vURL,function(data){

		  if (data=='success') {

			alert('Korwil '+pParam+' already deleted!')  ;

			$('#tr'+pIDTr).css("background-color", "#ccc"); 

		  }

	  }); 

	   

   } else return false;

}


function doUnblock(pParam,pIDTr) {

   if (confirm('Are you sure to unblock this member ('+pParam+')')) {

	  var vURL='../manager/processing_ajax.php?current=<?=$vCurrent?>&op=unblock&od='+pParam;

	  $.get(vURL,function(data){

		  if (data=='success') {

			alert('Member '+pParam+' already unblocked!')  ;

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


function checkInput(){
    if (document.getElementById('tfID').value.trim()=='' && document.getElementById('tfNama').value.trim()=='' && document.getElementById('tfNoHP').value.trim()=='') {
		alert('Masukkan salah satu atau lebih kata pencarian!');
		return false;
		
	}
	
}

</script>



<!--	<link rel="stylesheet" href="../css/screen.css"> -->







	



	

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.css"/>

 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />



  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />



  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />



  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />



  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />







<style type="text/css">



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




</style>



	<div class="right_col" role="main">

		<div><label>
		<h3>Data Pebisnis Lama</h3></label></div>

<div align="left" class="table-responsive col-lg-8"  > 
       		<form method="get" onSubmit="return checkInput()" >
       		<div class="row" >
		  <table border="0" cellpadding="4" cellspacing="0"  align="left" class="" >
            <tr>
              <td colspan="2" ><div align="left"><font size="3"><strong>Filter</strong></font></div></td>
            </tr>
            <tr>
              <td height="25" style="width: 14%" ><div align="left">ID Pebisnis </div></td>
              <td width="62%" height="25"><div align="left">
                <input name="hOP" type="hidden" id="hOP" value="post" />
                 <input name="current" type="hidden" id="current" value="<?=$_REQUEST['current']?>" />
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



              <td style="height: 25px; width: 14%;" nowrap><div align="left">Phone No</div></td>



              <td style="height: 25px"><div align="left">



                  <input name="tfNoHP" type="text" class="form-control" id="tfNoHP" value="<?=$vNoHP?>" />



              </div></td>



            </tr>



            <tr class="hide">



              <td height="25" style="width: 14%"><div align="left">Kota</div></td>



              <td height="25"><div align="left">



                  <input name="tfKota" type="text" class="form-control" id="tfKota" value="<?=$vKota?>" />



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



            <tr class="hide">



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



              <td height="25" style="width: 14%" nowrap><div align="left">Reg. Package</div></td>



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



                <input name="Submit2" type="button" class="btn btn-default" value="Reset" onClick="document.location.href='../masterdata/aktifref.php?op=&current=mdm_master_data&menu=mdm_master_data_pebisnis'" />



              </div></td>



            </tr>



          </table>

          </div>



</form>
<br><Br><br><Br>
 </div> <!--responsive-->

<?

      if ($oDetect->isMobile()) {

 

?>

<div style="margin-top:3em">

<? } else { ?>

<div style="margin-top:1em">



<? } ?>

<div class="row" style="text-align:left">
  <div class="col-lg-12">
  
  <? if (false) { ?>      
       <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_detail")) { ?> <input alt="Detail / Verifikasi Data" name="btDAddKor" type="button" class="btn btn-success btn-sm" id="btDAddKor" onClick="document.location.href='../manager/addkorwil.php?op=&current=mdm_master_data&'" value="Tambah Korwil &raquo;" onMouseovers="showhint('Lihat detail /  Edit Member '+getValue(), this, event, '220px')" style="margin-top:5px" >  <? } ?> 
       
       <? } ?>
       
  <? if ($vCurrent=='mdm_master_data') { ?>      
          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?> <input alt="Detail / Verifikasi Data" name="btDetail" type="button" class="btn btn-success btn-sm" id="btDetail" onClick="return MM_goToURL('parent','../manager/regpebisnis.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Detail / Edit Pebisnis &raquo;" onMouseovers="showhint('Lihat detail /  Edit Member '+getValue(), this, event, '220px')" style="margin-top:5px" >  <? }  ?>
          
          
  <? if ($vCurrent=='mdm_master_data') { ?>      
          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?> <input alt="Detail / Verifikasi Data" name="btDetail" type="button" class="btn btn-success btn-sm" id="btDetail" onClick="document.location.href='../masterdata/crudpebisnis.php'" value="&raquo; &raquo;" onMouseovers="showhint('Lihat detail /  Edit Member '+getValue(), this, event, '220px')" style="margin-top:5px" >  <? }  
		  
  }?>       
  
  
  <? if ($vCurrent=='mdm_master_data') { ?>      
          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?> <input alt="Detail / Verifikasi Data" name="btSpon" type="button" class="btn btn-success btn-sm" id="btSpon" onClick="document.location.href='../memstock/listspondirect.php?uMemberId='+getValue()" value="Jamaah Disponsori &raquo;" onMouseovers="showhint('Lihat detail /  Edit Member '+getValue(), this, event, '220px')" style="margin-top:5px" >  <? }  
		  
  }?>         
		  
		  
        <? if (false && $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?> 
        
        <input alt="Area" name="btDetail" type="button" class="btn btn-success btn-sm" id="btDetail" onClick="return MM_goToURL('parent','../masterdata/mdet_template.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Area Korwil &raquo;" onMouseovers="showhint('Lihat detail /  Edit Member '+getValue(), this, event, '220px')" style="margin-top:5px" >  <? } 
		  		  
		  
  }?>        
          
          

          
<? if(false){ ?>
         <!-- <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_detail")) { ?> <input alt="Member Activation" name="btActiv" type="button" class="btn btn-success btn-sm" id="btActiv" onClick="return MM_goToURL('parent','../memstock/activationadm.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Actvation&raquo;" onMouseovers="showhint('Aktiifasi Member '+getValue(), this, event, '220px')" style="margin-top:5px" >  <? } ?>       



          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_repstock")) { ?><input name="btStock" type="button" class="btn btn-success btn-sm" id="btStock" onClick="return MM_goToURL('parent','../memstock/rptstockphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Reseller Stock &raquo;" onMouseovers="showhint('Stock MS '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?> -->



         <!--  <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_repkit")) { ?><input name="btKit" type="button" class="btn btn-success btn-sm" id="bKit" onClick="return MM_goToURL('parent','../memstock/rptkitphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Agent KIT Report &raquo;" onMouseovers="showhint('KIT Agent '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?> -->



          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_uwallet")) { ?><input name="btWallet" type="button" class="btn btn-success btn-sm" id="btWallet" onClick="return MM_goToURL('parent','../memstock/payhistory.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="History Pembayaran &raquo;" onMouseovers="showhint('Nex-Wallet '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>



          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_uwallet")) { ?><input name="btWalletProd" type="button" class="btn btn-success btn-sm" id="btWalletProd" onClick="return MM_goToURL('parent','../memstock/recompass.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Rekom Pengurusan Paspor &raquo;" onMouseovers="showhint('Nex-Wallet '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>


          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_uwallet")) { ?><input name="btBawaan" type="button" class="btn btn-success btn-sm" id="btBawaan" onClick="return MM_goToURL('parent','../manager/databring.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Barang Bawaan &raquo;" onMouseovers="showhint('Nex-Wallet '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>
 
 
 <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_uwallet")) { ?><input name="btIdent" type="button" class="btn btn-success btn-sm" id="btIdent" onClick="return MM_goToURL('parent','../manager/dataident.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Kelengkapan Identitas &raquo;" onMouseovers="showhint('Nex-Wallet '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>           

          <? if (true) { ?><input name="btWalletKit" type="button" class="btn btn-success btn-sm" id="btWalletKit" onClick="return MM_openBrWindow('../memstock/kuitansi.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&no='+document.getElementById('lmAngs').value+'&uMemberId='+getValue(),'wKui','');return document.MM_returnValue" value="Kuitansi Angs  &raquo;" onMouseovers="showhint('Nex-Wallet '+getValue(), this, event, '210px')" style="margin-top:5px" /> 
		  <select id="lmAngs" name="lmAngs" style="max-width:45px;height:28px" onChange="document.getElementById('lmAngs1').value=this.value" >
                   <option value="1">1</option>
                   <option value="2">2</option>
                   <option value="3">3</option>
                   <option value="4">4</option>
                   <option value="str">Setoran Awal</option>
                   <option value="lns">Pelunasan</option>
          </select>
		  <? } ?>

          

                    <? if (true) { ?><input name="btWalletAcc" type="button" class="btn btn-success btn-sm" id="btWalletAcc" onClick="return MM_openBrWindow('../memstock/invoiceamh.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&no='+document.getElementById('lmInvo').value+'&uMemberId='+getValue());return document.MM_returnValue" value="Invoice Setoran &raquo;" onMouseovers="showhint('Nex-Wallet '+getValue(), this, event, '210px')" style="margin-top:5px" />
                    <select id="lmInvo" name="lmInvo" style="max-width:45px;height:28px;display:none" onChange="document.getElementById('lmInvo1').value=this.value" >
               <option value="1">1</option>
               <option value="2">2</option>
               <option value="3">3</option>
               <option value="4">4</option>
               <option value="str">Setoran Awal</option>
               <option value="lns">Pelunasan</option>
               </select>
                     <? } ?>
<? } //admin ?>
 
 <? if ($vCurrent=='mdm_memnet') { ?>      
          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?> <input alt="Detail / Verifikasi Data" name="btDetail2" type="button" class="btn btn-success btn-sm" id="btDetail2" onClick="return MM_goToURL('parent','../manager/contactfam.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Kontak Tidak Serumah &raquo;" onMouseovers="showhint('Lihat detail /  Edit Member '+getValue(), this, event, '220px')" style="margin-top:5px" >  <? }  }?>        
          
                    
<? if ($vCurrent=='mdm_operator') { ?>                          
                    <? if (true) { ?><input name="btDataFull" type="button" class="btn btn-success btn-sm" id="btDataFull" onClick="return MM_goToURL('parent','../manager/datafull.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Kelengkapan Data &raquo;" onMouseovers="showhint('Nex-Wallet '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>


<? } //operator ?>
          

          

          <!-- <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_uwallet")) { ?><input name="btWallet" type="button" class="btn btn-success btn-sm" id="btWallet" onClick="return MM_goToURL('parent','../memstock/ewalletrobalphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="RO-Wallet  &raquo;" onMouseovers="showhint('RO Wallet  '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?> -->

          

          <!-- 

                    <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_uwallet")) { ?><input name="btState3" type="button" class="btn btn-success btn-sm" id="btState3" onClick="return MM_goToURL('parent','../memstock/statementphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Weekly Statement &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /><? } ?>



                    <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_uwallet")) { ?><input name="btState4" type="button" class="btn btn-success btn-sm" id="btState2" onClick="return MM_goToURL('parent','../memstock/statementmophp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Monthly Statement &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /><? } ?> -->

          

<!--

          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_walladj")) { ?><input name="btKoreksi" type="button" class="btn btn-success btn-sm" id="bKoreksi" onClick="return MM_goToURL('parent','../manager/koreksi.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Koreksi Saldo &raquo;" onMouseovers="showhint('Nex-Wallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>

          

<? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_walladj")) { ?><input name="btKoreksiAu" type="button" class="btn btn-success btn-sm" id="bKoreksiAu" onClick="return MM_goToURL('parent','../manager/koreksiro.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Koreksi Saldo Automain &raquo;" onMouseovers="showhint('Nex-Wallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>          

          

 <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btEfund" type="button" class="btn btn-success btn-sm" id="btEfund" onClick="return MM_goToURL('parent','../manager/efundmem.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Entri Automain eFund &raquo;" onMouseovers="showhint('Nex-Wallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>          

          

 <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_walladj")) { ?><input name="btSet" type="button" class="btn btn-success btn-sm" id="btSet" onClick="return MM_goToURL('parent','../manager/koreksistockist.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Set Saldo Jaminan Stockist &raquo;" onMouseovers="showhint('Nex-Wallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>

           

        <!--  <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_walladj")) { ?><input name="btKoreksiRO" type="button" class="btn btn-danger btn-sm" id="bKoreksiRO" onClick="return MM_goToURL('parent','../manager/koreksirophp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="RO-Wallet Correction &raquo;" onMouseovers="showhint('RO-Wallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?> 



          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_repstinout")) { ?><input name="btStWallet" type="button" class="btn btn-success btn-sm" id="btStWallet" onClick="return MM_goToURL('parent','../memstock/stockbalphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Stock In/Out Report &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>

          

          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_repstinout")) { ?><input name="btStWallet1" type="button" class="btn btn-success btn-sm" id="btStWallet1" onClick="return MM_goToURL('parent','../memstock/stockbalrophp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="St In/Out Rpt (RO Items) &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>



          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_repstinout")) { ?><input name="btStWallet2" type="button" class="btn btn-success btn-sm" id="btStWallet2" onClick="return MM_goToURL('parent','../memstock/rptstockphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Stock Position &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>





          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_repstinout")) { ?><input name="btStWallet3" type="button" class="btn btn-success btn-sm" id="btStWallet3" onClick="return MM_goToURL('parent','../memstock/rptstockrophp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Stock Position (RO Items) &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>

          



          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_stockadj")) { ?><input name="btKoreksiSt" type="button" class="btn btn-success btn-sm" id="bKoreksiSt" onClick="return MM_goToURL('parent','../manager/koreksistockphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Stock Adjustment &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>



                    <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_stockadj")) { ?><input name="btKoreksiSt4" type="button" class="btn btn-success btn-sm" id="bKoreksiSt4" onClick="return MM_goToURL('parent','../manager/koreksistockrophp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Stock Adjustment (RO Items) &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /><? } ?>-->

<!--
          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_reporderhist")) { ?><input name="btHist" type="button" class="btn btn-success btn-sm" id="btHist" onClick="return MM_goToURL('parent','../memstock/historyro.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="History Penjualan &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>



         <!--  <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_repspon")) { ?><input name="btSpon" type="button" class="btn btn-success btn-sm" id="btSpon" onClick="return MM_goToURL('parent','../memstock/stjaringanphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Sponsorship Report &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?> -->


<!--
          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btGenea" type="button" class="btn btn-success btn-sm" id="btGenea" onClick="return MM_goToURL('parent','../memstock/genealogi2.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Genealogi &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>



         <? if (false) { ?><input name="btGeneaS" type="button" class="btn btn-success btn-sm" id="btGeneaS" onClick="return MM_goToURL('parent','../memstock/genealogispon.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Genealogi Unilevel &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>

         

         

		<? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btBBP" type="button" class="btn btn-success btn-sm" id="btBBP" onClick="return MM_goToURL('parent','../memstock/rptbnssponreal.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Bns Pengembangan Tim &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>



		<? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btBBP" type="button" class="btn btn-success btn-sm" id="btBBP" onClick="return MM_goToURL('parent','../memstock/pairing.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Bns Pengembangan Harian &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>

        

<? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btBBPcf" type="button" class="btn btn-success btn-sm" id="btBBPcf" onClick="return MM_goToURL('parent','../memstock/pairingcf.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Carry Forward Bonus &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>        



		<? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btBBP" type="button" class="btn btn-success btn-sm" id="btBBP" onClick="return MM_goToURL('parent','../memstock/rptbnsmatch.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Bns Royalti &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>



        

		<? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btBBP" type="button" class="btn btn-success btn-sm" id="btBBP" onClick="return MM_goToURL('parent','../memstock/rptprivro.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Bns Belanja Pribadi &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>

        <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btBBG" type="button" class="btn btn-success btn-sm" id="btBBG" onClick="return MM_goToURL('parent','../memstock/rptgroupro.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Bns Pengembangan Bulanan &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>

        <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="BtBMM" type="button" class="btn btn-success btn-sm" id="BtBMM" onClick="return MM_goToURL('parent','../memstock/rptmegamatch.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Bns Penghargaan Kepemimpinan &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>

        

        <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="BtBMM3" type="button" class="btn btn-success btn-sm" id="BtBMM3" onClick="return MM_goToURL('parent','../memstock/rptmegamatch.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Bns Klub Presiden &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>

        

        <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btRoHist" type="button" class="btn btn-success btn-sm" id="btRoHist" onClick="return MM_goToURL('parent','../memstock/historyro.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="RO History &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>





 <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btOneRoHist" type="button" class="btn btn-success btn-sm" id="btOneRoHist" onClick="return MM_goToURL('parent','../memstock/rptrostockist.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Bns Onetime + RO Stockist &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>

 

 

 <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btPoinStock" type="button" class="btn btn-success btn-sm" id="btPoinStock" onClick="return MM_goToURL('parent','../memstock/rptpoinstockist.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Bns Poin Stockist &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?> -->

 

         <!-- <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_reppair")) { ?><input name="btPair" type="button" class="btn btn-success btn-sm" id="btPair" onClick="return MM_goToURL('parent','../memstock/pairingphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Komisi Pair Report &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>



          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_repcf")) { ?><input name="btCF" type="button" class="btn btn-success btn-sm" id="btCF" onClick="return MM_goToURL('parent','../memstock/pairingcfphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="CF Omzet &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp; <? } ?>



          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_repcf")) { ?><input name="btCFR" type="button" class="btn btn-success btn-sm" id="btCFR" onClick="return MM_goToURL('parent','../memstock/pairingcfrealphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="CF Real &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp; <? } ?>





          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_repwd")) { ?><input name="btWD" type="button" class="btn btn-success btn-sm" id="btWD" onClick="return MM_goToURL('parent','../memstock/withdrawphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Withdraw History &raquo;" onMouseovers="showhint('Withdraw History '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>

          

          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_repwd")) { ?><input name="btRoyal" type="button" class="btn btn-success btn-sm" id="btRoyal" onClick="return MM_goToURL('parent','../memstock/bnsroyaltyphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Bns Royalty Preview &raquo;" onMouseovers="showhint('Withdraw History '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>       -->   



      </div>

      </div>    

    



     



<br><br>

<form name="memberForm">

      <div class="table-responsive"  >



    <table width="100%" border="0" align="left" cellpadding="1" cellspacing="0" class="table" style="background-color:white" id="tblMain" >

     <thead>

      <tr style="color:;font-weight:bold"> 



        <td   height="26" style="width: 30px"> <div align="center" >ID Korwil </div></td>



        <td width="20%"><div align="center" >Nama 



        </div></td>



        <td class="" width="45%"><div align="center" >Alamat 



          </div></td>



        <td widith="10%"><div align="center"  >Phone No. 
          
          
          
        </div></td>



        <td width="10%" ><div align="center" > Tanggal Aktif</div></td>


        <td  class="hide"><div align="center">Jenis Kelamin</div></td>
        <td  class="">Status Pebisnis</td>





        <td width="43"><div align="left" >&radic;</div></td>



      </tr>
      </thead>
	 <tbody>	


      <?



		  if ($vOP=="post") $vStartLimit=0;



		  $vsql="select * from m_pebisnis where  1 ";



		  $vsql.=$vCrit;



		  $vsql.=" order by fidmember ";



		  $vsql.="limit $vStartLimit ,$vBatasBaris ";



			//echo "<br><br><br>".$vsql;



		  $db->query($vsql);



		  $vHari=$oRules->getSettingByField("fbyyprint");



		  while ($db->next_record()) {



		     $vAktifList=$db->f('faktif'); 



			 $vTrial=$db->f('fisfree');



			 $vIDSys=$db->f('fidsys');

			 $vIDMem=$db->f('fidmember');

			 if ($vAktifList=='1')

			     $vActive='yellow';

			 else if ($vAktifList=='4')

			     $vActive='#ccc';

			 else $vActive='white';

			     







			  $vTglAktif=$oPhpdate->DMY2YMD($oPhpdate->YMD2DMY($db->f('ftglaktif')));



			     $vSaldo=$db->f('fsaldovcr');

				 $vSaldoProd=$db->f('fsaldowprod');

				 $vSaldoJaminan=$db->f('fsaldoro');

				 $vSaldoAcc=$db->f('fsaldowacc');



			 $vStockistCSS='';




				

			    



		?>



      <tr  bgcolor="<?=$vActives?>" style="<?=$vStockistCSSs?>"  id="tr<?=$vIDSys?>"  > 



        <td style=";" onMouseovers="showhint('<?=$vMess?>', this, event, '150px')" nowrap>

			<span  data-toggle="tooltip" titlex="<?=$vToolTip?>" >

        <a name="<?=$db->f('fidmember')?>"></a>



        <div align="left"><span  >



          <?=$db->f('fidmember')?>



          <? if ($vTrial=='1' && $vAktifList=='1') { ?>



          <br>



          Trial s/d <?=$oPhpdate->YMD2DMY($oMydate->dateAdd($vTglAktif,$vHari,"day")) ?>



          <? } ?>

		

          <? if(false) { ?>	

           <br><button onClick="doBlock('<?=$vIDMem?>','<?=$vIDSys?>')" type="button" class="btn btn-xs btn-danger"><i class="fa fa-ban"></i> Block</button>

           <? } ?>
           
 <? if($vAktifList=='90') { ?>	

           <br><button onClick="doDel('<?=$db->f('fidmember')?>','<?=$vIDSys?>')" type="button" class="btn btn-xs btn-danger"><i class="fa fa-ban"></i> Delete</button>

           <? } ?>           



          <? if($vAktifList=='4') { ?>	

           <!--<br><button onClick="doUnblock('<?=$vIDMem?>','<?=$vIDSys?>')" type="button" class="btn btn-xs btn-success"><i class="fa fa-check"></i> Unblock</button>-->
          <br> <font color="#f00" style="font-weight:bold">Status: Blocked</font>

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
        <td width="57" style="height: 39px" class="">          
        <div align="left"><span >



          <?=$db->f('falamat').", Kec. ".$oMember->getWilName('ID',$db->f('fprop'),$db->f('fkota'),$db->f('fkec'),'00')." ".$oMember->getWilName('ID',$db->f('fprop'),$db->f('fkota'),'00','00')?>



          <br>



          </span></div></td>



        <td  style="height: 39px"> 
          
          
          
          <div align="left"><span >
            
            
            
            <?=$db->f('fnohp')?>
            
            
            
            &nbsp;          </span></div></td>



        <td  style="height: 39px"> 
          
          
          
          <span >
            
            
            
            <?=$oPhpdate->YMD2DMY($db->f('ftglaktif'))?>
            
            
            
          </span>        </td>


        <td class="hide"  style="height: 39px;<? if ($db->f('fpriv')=='1') echo 'background-color:#ccc';?>"><div align="right">
          
          <?=number_format($vSaldoAcc,0,",",".")?>
          
        </div></td>
        <td class=""  style="height: 39px;<? if ($db->f('fpriv')=='1') echo 'background-color:#ccc';?>"><?=($db->f('faktif')=='1'?'Aktif':'Tidak Aktif')?></td>



              <td  style="height: 39px" <? if($vFall==$db->f('fidmember')) echo "bgcolor=#0f0";?>><span >

                

                <input class="classRB" id="rbSelected<?=$db->f('fidmember')?>" style="width:20px;height:20px" name="rbSelected" type="radio" value="<?=$db->f('fidmember')?>" onClick="checkStatus('<?=$db->f('faktif')?>','<?=$db->f('fstockist')?>')" <? if ($vChoosed==$db->f('fidmember')) echo 'checked'; ?> >

                

                </span>

                

              </td>



      </tr>



        <? } // while $db->next_record?>



        



      <tr  > 



        <td align="right" style="font-weight:bold">&nbsp;</td>
        <td align="right" style="font-weight:bold">&nbsp;</td>
        <td align="right" style="font-weight:bold">&nbsp;</td>
        <td align="right" style="font-weight:bold">&nbsp;</td>
        <td align="right" style="font-weight:bold">&nbsp;</td>


        <td  align="right" style="font-weight:bold" nowrap>Total Active <br> Pebisnis:
          <?=$vRecordCount?></td>
        <td  align="right" style="font-weight:bold" nowrap>&nbsp;</td>



              <td  >&nbsp;

                

              </td>



      </tr>


		</tbody>
                



      </table>



      </div>

    



    </form>

 </div>

<? if (false) { ?>      
       <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_detail")) { ?> <input alt="Detail / Verifikasi Data" name="btDAddKor1" type="button" class="btn btn-success btn-sm" id="btDAddKor1" onClick="return MM_goToURL('parent','../manager/addkorwil.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Tambah Korwil &raquo;" onMouseovers="showhint('Lihat detail /  Edit Member '+getValue(), this, event, '220px')" style="margin-top:5px" >  <? } ?> 
       <? } ?>

 <? if ($vCurrent=='mdm_master_data') { ?>      
       <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_detail")) { ?> <input alt="Detail / Verifikasi Data" name="btDetail3" type="button" class="btn btn-success btn-sm" id="btDetail3" onClick="return MM_goToURL('parent','../manager/regpebisnis.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Detail / Edit Pebisnis &raquo;" onMouseovers="showhint('Lihat detail /  Edit Member '+getValue(), this, event, '220px')" style="margin-top:5px" >  <? } ?>        


          

        <? if ($vCurrent=='mdm_master_data') { ?>      
          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?> <input alt="Detail / Verifikasi Data" name="btSpon1" type="button" class="btn btn-success btn-sm" id="btSpon1" onClick="document.location.href='../memstock/listspondirect.php?uMemberId='+getValue()" value="Jamaah Disponsori &raquo;" onMouseovers="showhint('Lihat detail /  Edit Member '+getValue(), this, event, '220px')" style="margin-top:5px" >  <? }  
		  
  }?>     
         <!-- <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_detail")) { ?> <input alt="Member Activation" name="btActiv" type="button" class="btn btn-success btn-sm" id="btActiv" onClick="return MM_goToURL('parent','../memstock/activationadm.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Actvation&raquo;" onMouseovers="showhint('Aktiifasi Member '+getValue(), this, event, '220px')" style="margin-top:5px" >  <? } ?>       



          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_repstock")) { ?><input name="btStock" type="button" class="btn btn-success btn-sm" id="btStock" onClick="return MM_goToURL('parent','../memstock/rptstockphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Reseller Stock &raquo;" onMouseovers="showhint('Stock MS '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?> -->



         <!--  <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_repkit")) { ?><input name="btKit" type="button" class="btn btn-success btn-sm" id="bKit" onClick="return MM_goToURL('parent','../memstock/rptkitphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Agent KIT Report &raquo;" onMouseovers="showhint('KIT Agent '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?> -->



          <? if (false && $oSystem->checkPriv($vUser,"mdm_listprof_uwallet")) { ?><input name="btWallet" type="button" class="btn btn-success btn-sm" id="btWallet" onClick="return MM_goToURL('parent','../masterdata/mdet_template.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Area Korwil &raquo;" onMouseovers="showhint('Nex-Wallet '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? }
 }
 
 if (false) { 
		   ?>

          

  <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_uwallet")) { ?><input name="btWalletProd1" type="button" class="btn btn-success btn-sm" id="btWalletProd1" onClick="return MM_goToURL('parent','../memstock/recompass.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Rekom Pengurusan Paspor &raquo;" onMouseovers="showhint('Nex-Wallet '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>

          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_uwallet")) { ?><input name="btBawaan1" type="button" class="btn btn-success btn-sm" id="btBawaan1" onClick="return MM_goToURL('parent','../manager/databring.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Barang Bawaan &raquo;" onMouseovers="showhint('Nex-Wallet '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>          

<? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_uwallet")) { ?><input name="btIdent1" type="button" class="btn btn-success btn-sm" id="btIdent1" onClick="return MM_goToURL('parent','../manager/dataident.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Kelengkapan Identitas &raquo;" onMouseovers="showhint('Nex-Wallet '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>  

          <? if (true) { ?><input name="btWalletKit1" type="button" class="btn btn-success btn-sm" id="btWalletKit1" onClick="return MM_openBrWindow('../memstock/kuitansi.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&no='+document.getElementById('lmAngs').value+'&uMemberId='+getValue(),'wKui','');return document.MM_returnValue" value="Kuitansi Angs  &raquo;" onMouseovers="showhint('Nex-Wallet '+getValue(), this, event, '210px')" style="margin-top:5px" /> 
		   <select id="lmAngs1" name="lmAngs1" style="max-width:45px;height:28px" onChange="document.getElementById('lmAngs').value=this.value">
                   <option value="1">1</option>
                   <option value="2">2</option>
                   <option value="3">3</option>
                   <option value="4">4</option>
                   <option value="str">Setoran Awal</option>
                   <option value="lns">Pelunasan</option>
               </select>
		  <? } ?>

          

                    <? if (true) { ?><input name="btWalletAcc1" type="button" class="btn btn-success btn-sm" id="btWalletAcc1" onClick="return MM_openBrWindow('../memstock/invoiceamh.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&no='+document.getElementById('lmInvo1').value+'&uMemberId='+getValue());return document.MM_returnValue" value="Invoice Setoran &raquo;" onMouseovers="showhint('Nex-Wallet '+getValue(), this, event, '210px')" style="margin-top:5px" /> 
					   <select id="lmInvo1" name="lmInvo1" style="max-width:45px;height:28px;display:none" onChange="document.getElementById('lmInvo').value=this.value" >
                   <option value="1">1</option>
                   <option value="2">2</option>
                   <option value="3">3</option>
                   <option value="4">4</option>
                   <option value="str">Setoran Awal</option>
                   <option value="lns">Pelunasan</option>
               </select>
					
					<? } ?>          
                    
<? }  //admin?>                    

<? if ($vCurrent=='mdm_memnet') { ?>      
          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?> <input alt="Detail / Verifikasi Data" name="btDetail4" type="button" class="btn btn-success btn-sm" id="btDetail4" onClick="return MM_goToURL('parent','../manager/contactfam.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Kontak Tidak Serumah &raquo;" onMouseovers="showhint('Lihat detail /  Edit Member '+getValue(), this, event, '220px')" style="margin-top:5px" >  <? } }?>    


<? if ($vCurrent=='mdm_operator') { ?>                          
                   <? if (true) { ?><input name="btDataFull1" type="button" class="btn btn-success btn-sm" id="btDataFull1" onClick="return MM_goToURL('parent','../manager/datafull.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Kelengkapan Data &raquo;" onMouseovers="showhint('Nex-Wallet '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>   

<? } //operator?>

          <!-- <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_uwallet")) { ?><input name="btWallet" type="button" class="btn btn-success btn-sm" id="btWallet" onClick="return MM_goToURL('parent','../memstock/ewalletrobalphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="RO-Wallet  &raquo;" onMouseovers="showhint('RO Wallet  '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?> -->

          

          <!-- 

                    <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_uwallet")) { ?><input name="btState3" type="button" class="btn btn-success btn-sm" id="btState3" onClick="return MM_goToURL('parent','../memstock/statementphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Weekly Statement &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /><? } ?>



                    <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_uwallet")) { ?><input name="btState4" type="button" class="btn btn-success btn-sm" id="btState2" onClick="return MM_goToURL('parent','../memstock/statementmophp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Monthly Statement &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /><? } ?> -->

          


<!--
          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_walladj")) { ?><input name="btKoreksi" type="button" class="btn btn-success btn-sm" id="bKoreksi" onClick="return MM_goToURL('parent','../manager/koreksi.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Koreksi Saldo &raquo;" onMouseovers="showhint('Nex-Wallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>

 

           

<? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_walladj")) { ?><input name="btKoreksiAu1" type="button" class="btn btn-success btn-sm" id="bKoreksiAu1" onClick="return MM_goToURL('parent','../manager/koreksiro.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Koreksi Saldo Automain &raquo;" onMouseovers="showhint('Nex-Wallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?> 

          

 <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btEfund1" type="button" class="btn btn-success btn-sm" id="btEfund1" onClick="return MM_goToURL('parent','../manager/efundmem.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Entri Automain eFund &raquo;" onMouseovers="showhint('Nex-Wallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>          

          

           <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_walladj")) { ?><input name="btSet1" type="button" class="btn btn-success btn-sm" id="btSet1" onClick="return MM_goToURL('parent','../manager/koreksistockist.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Set Saldo Jaminan Stockist &raquo;" onMouseovers="showhint('Nex-Wallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>

        <!--  <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_walladj")) { ?><input name="btKoreksiRO" type="button" class="btn btn-danger btn-sm" id="bKoreksiRO" onClick="return MM_goToURL('parent','../manager/koreksirophp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="RO-Wallet Correction &raquo;" onMouseovers="showhint('RO-Wallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?> 



          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_repstinout")) { ?><input name="btStWallet" type="button" class="btn btn-success btn-sm" id="btStWallet" onClick="return MM_goToURL('parent','../memstock/stockbalphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Stock In/Out Report &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>

          

          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_repstinout")) { ?><input name="btStWallet1" type="button" class="btn btn-success btn-sm" id="btStWallet1" onClick="return MM_goToURL('parent','../memstock/stockbalrophp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="St In/Out Rpt (RO Items) &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>



          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_repstinout")) { ?><input name="btStWallet2" type="button" class="btn btn-success btn-sm" id="btStWallet2" onClick="return MM_goToURL('parent','../memstock/rptstockphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Stock Position &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>





          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_repstinout")) { ?><input name="btStWallet3" type="button" class="btn btn-success btn-sm" id="btStWallet3" onClick="return MM_goToURL('parent','../memstock/rptstockrophp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Stock Position (RO Items) &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>

          



          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_stockadj")) { ?><input name="btKoreksiSt" type="button" class="btn btn-success btn-sm" id="bKoreksiSt" onClick="return MM_goToURL('parent','../manager/koreksistockphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Stock Adjustment &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>



                    <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_stockadj")) { ?><input name="btKoreksiSt4" type="button" class="btn btn-success btn-sm" id="bKoreksiSt4" onClick="return MM_goToURL('parent','../manager/koreksistockrophp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Stock Adjustment (RO Items) &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /><? } ?>-->
<!--
          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_reporderhist")) { ?><input name="btHist" type="button" class="btn btn-success btn-sm" id="btHist" onClick="return MM_goToURL('parent','../memstock/historyro.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="History Penjualan &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>



         <!--  <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_repspon")) { ?><input name="btSpon" type="button" class="btn btn-success btn-sm" id="btSpon" onClick="return MM_goToURL('parent','../memstock/stjaringanphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Sponsorship Report &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?> -->


<!--
          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btGenea" type="button" class="btn btn-success btn-sm" id="btGenea" onClick="return MM_goToURL('parent','../memstock/genealogi2.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Genealogi &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>



         <? if (false) { ?><input name="btGeneaS" type="button" class="btn btn-success btn-sm" id="btGeneaS" onClick="return MM_goToURL('parent','../memstock/genealogispon.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Genealogi Unilevel &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>

         



		<? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btBBP" type="button" class="btn btn-success btn-sm" id="btBBP" onClick="return MM_goToURL('parent','../memstock/rptbnssponreal.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Bns Pengembangan Tim &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>



		<? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btBBP" type="button" class="btn btn-success btn-sm" id="btBBP" onClick="return MM_goToURL('parent','../memstock/pairing.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Bns Pengembangan Harian &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>

        

        <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btBBPcf1" type="button" class="btn btn-success btn-sm" id="btBBPcf1" onClick="return MM_goToURL('parent','../memstock/pairingcf.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Carry Forward Bonus &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>  



		<? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btBBP" type="button" class="btn btn-success btn-sm" id="btBBP" onClick="return MM_goToURL('parent','../memstock/rptbnsmatch.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Bns Royalti &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>



        

		<? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btBBP" type="button" class="btn btn-success btn-sm" id="btBBP" onClick="return MM_goToURL('parent','../memstock/rptprivro.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Bns Belanja Pribadi &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>

        <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btBBG" type="button" class="btn btn-success btn-sm" id="btBBG" onClick="return MM_goToURL('parent','../memstock/rptgroupro.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Bns Pengembangan Bulanan &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>

        <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="BtBMM" type="button" class="btn btn-success btn-sm" id="BtBMM" onClick="return MM_goToURL('parent','../memstock/rptmegamatch.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Bns Penghargaan Kepemimpinan &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>

        

        <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="BtBMM3" type="button" class="btn btn-success btn-sm" id="BtBMM3" onClick="return MM_goToURL('parent','../memstock/rptmegamatch.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Bns Klub Presiden &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>

        

        <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btRoHist" type="button" class="btn btn-success btn-sm" id="btRoHist" onClick="return MM_goToURL('parent','../memstock/historyro.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="RO History &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>



 <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btOneRoHist1" type="button" class="btn btn-success btn-sm" id="btOneRoHist1" onClick="return MM_goToURL('parent','../memstock/rptrostockist.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Bns Onetime + RO Stockist &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>

 

 

  <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btPoinStock1" type="button" class="btn btn-success btn-sm" id="btPoinStock1" onClick="return MM_goToURL('parent','../memstock/rptpoinstockist.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Bns Poin Stockist &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>

         <!-- <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_reppair")) { ?><input name="btPair" type="button" class="btn btn-success btn-sm" id="btPair" onClick="return MM_goToURL('parent','../memstock/pairingphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Komisi Pair Report &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>



          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_repcf")) { ?><input name="btCF" type="button" class="btn btn-success btn-sm" id="btCF" onClick="return MM_goToURL('parent','../memstock/pairingcfphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="CF Omzet &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp; <? } ?>



          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_repcf")) { ?><input name="btCFR" type="button" class="btn btn-success btn-sm" id="btCFR" onClick="return MM_goToURL('parent','../memstock/pairingcfrealphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="CF Real &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp; <? } ?>





          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_repwd")) { ?><input name="btWD" type="button" class="btn btn-success btn-sm" id="btWD" onClick="return MM_goToURL('parent','../memstock/withdrawphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Withdraw History &raquo;" onMouseovers="showhint('Withdraw History '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>

          

          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_repwd")) { ?><input name="btRoyal" type="button" class="btn btn-success btn-sm" id="btRoyal" onClick="return MM_goToURL('parent','../memstock/bnsroyaltyphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Bns Royalty Preview &raquo;" onMouseovers="showhint('Withdraw History '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>       -->   



          



<div class="row <? if ($vOP=="post") echo "hide";?> " align="center">
<ul class="pagination" >
              <?
   for ($i=0;$i<$vPageCount;$i++) {
     $vOffset=$i*$vBatasBaris;
	   $idisp=$i;
	 if ($vOP=="post") $idisp=0;
     if ($idisp!=$vPage) {
?>
              <li ><a  href="aktifref.php?lmAktif=<?=$vAktif?>&lmMship=<?=$vPrem?>&uPage=<?=$idisp?>&lmSort=<?=$vSort?>&current=<?=$_REQUEST['current']?>" >
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

<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>

<script type="text/javascript" src="../js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="../js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="../js/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="../js/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="../js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="../js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<script src="../js/scripts.js"></script>
 </div>
<? include_once("../framework/admin_footside.blade.php") ; ?>