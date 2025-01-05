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



$vOP=$_REQUEST['hOP'];

$vSpy=md5('spy');

$vID=$_REQUEST['tfID'];

$vNama=$_REQUEST['tfNama'];

$vNoHP=$_REQUEST['tfNoHP'];

$vKota=$_REQUEST['tfKota'];

$vAktif=$_REQUEST['lmAktif'];

$vSort=$_REQUEST['lmSort'];

$vCrit=" and faktif <> '0' ";



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

if ($vKota!="")

   $vCrit.=" and fkota like '%$vKota%' ";

if ($_GET['tfDepart'] !='') 
   $vCrit .= " and ftgldepart='{$_GET['tfDepart']}' ";

if ($vAktif==2)

   $vCrit.=" and faktif = 0";

else if ($vAktif==1)   

   $vCrit.=" and faktif = 1";

// $vSQLArea="select concat(a.fprop,a.fkabkota,a.fkec) as farea from tb_korwil_area a 
//left join m_korwil b on a.fidkorwil=b.fidkorwil 
//where b.fidkorwil='{$_GET['lmKorwil']}' ";

if ($_GET['lmKorwil'] !='')
   $vCrit .= " and frefer='{$_GET['lmKorwil']}' ";


$vPage=$_GET['uPage'];
if ($_GET['lmKorwil'] !='')
	$vBatasBaris=600000;
else	$vBatasBaris=15;
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
<link rel="stylesheet" type="text/css" href="../vendor/select2/select2.min.css">
<script src="../vendor/select2/select2.min.js"></script>
<script language="JavaScript" type="text/JavaScript">

$(document).ready(function(){
    $('#lmKorwil').select2();
$('#tfDepart').datepicker({

                    format: "yyyy-mm-dd",
					//"setDate": new Date()

    }).on('changeDate', function (ev) {

    				$(this).datepicker('hide');

    });  


});

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





});



<!--

function MM_openBrWindow(theURL,winName,features) {
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

</script>



<!--	<link rel="stylesheet" href="../css/screen.css"> -->







	



	



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

		
		<h3>Panduan Pengoperasian (Pebisnis)</h3>
		
        <div class="panel" style="width:100%">
        <div class="panel-body" >
        <div class="col-lg-12">
        <?=$oInterface->getMenuContent('appspon');?>
        </div>
        </div>
        </div>
	







<div align="left" class="table-responsive col-lg-6" style="min-height:270px" > 
       		<form method="get" >
       		<div class="row" ></div>



</form>

 </div> <!--responsive--><!-- Placed js at the end of the document so the pages load faster -->

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