<?php include_once("../framework/admin_headside.blade.php")?>

<? 

 
  include_once("../classes/systemclass.php");
  include_once("../classes/ruleconfigclass.php");
  include_once("../classes/networkclass.php");
  include_once("../classes/memberclass.php");
  include_once("../classes/komisiclass.php");

  $vMailFrom=$oRules->getSettingByField('fmailadmin');
//print_r($_POST);
 // $_SESSION['Ref']='';

  if ($_SESSION['Ref'] == '' )     
   $vRead=''; 
  else  
   $vRead='readonly';
   $vRead=''; 
  

  $vOngkir=$oRules->getSettingByField('fongkir');  


 $vRefer = $_SERVER['HTTP_REFERER'];
  if (preg_match("/aktif.php/",$vRefer)) {
	    $_SESSION['refer'] = $vRefer;  
  }
  
  
  $vMailFrom=$oRules->getSettingByField('fmailadmin');
//print_r($_POST);
 // $_SESSION['Ref']='';

	 if ($_GET['uMemberId'] != '')
    	$vUserActive=$_GET['uMemberId'];
	 else  $vUserActive=$vUser;
	$dbL = $db1;
 
 	$vSpy = md5('spy').md5($_GET['uMemberId']);

     $vSQL="select a.* from m_pebisnis a  where a.fidmember='$vUserActive'";
 
 	$dbL->query($vSQL);
 	$dbL->next_record();

   	$vIdPilgrimsL = $dbL->f('fidmember');

  	$vNamaL = $dbL->f('fnama');
	$vPropL = $dbL->f('fprop');
	$vKotaL = $dbL->f('fkota');
	$vKecaL = $dbL->f('fkec');

	$vNoKTP = $dbL->f('fnoktp');


	$vAlamatL = $dbL->f('falamat');
	$vNoHPL  = $dbL->f('fnohp');







function generateRandomString($length = 6) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}



   while (list($key,$val)=each($_POST)) {
      $$key = $val;
   }

   $fcount = 0;

   if ($_POST['hPost'] != '1') {
      $_SESSION['save']='';
      $_SESSION['del']='';
   } else {


	 $oSystem->smtpmailer('japri_s@yahoo.com',$vMailFrom,'AMH',"Registrasi AMH Internal",'','',false);
  	 $tfBank = explode(";",$tfBank);
  	 $tfBank = $tfBank[0];
  	 $rbPaket = explode(";",$rbPaket);
  	 $rbPaket = $rbPaket[0];
  	  	 
	  $vhSubTot=0;	  	 

	 	

	

		 $db->query('START TRANSACTION;');

		 $fprefix=str_replace("+","",$fprefix);

		 $tfHP=$fprefix.$fnohp;
		 $vYear = date("Y");
		 $vMonth = date("m");
		 $vCounter = $oMember->getMemCount($vYear,$vMonth);
		 $vCounter++;
		 $vCounterStr = str_pad($vCounter,4,"0",STR_PAD_LEFT);
		 $vPrefix = "J".$fjenis."-".date("Ym");  	

		 $fidmember= $vPrefix.$vCounterStr;
		 $flastuser = $_SESSION['LoginUser'];

			 if ($oMember->updateRef($fidmember,  $fnama, $fnohp, $falamat, $fprop,$fkota, $fkec, $femail, $fnoktp, $fket,$db)==1) {  

			 }
			
		
		//	$oMember->updMemCount($vYear,$vMonth,$vCounter,$db);

	if($db->query('COMMIT;')) {	  
	   $oSystem->jsAlert("Update Pebisnis sukses!");	
	  $oSystem->jsLocation($_SERVER['HTTP_REFERER']);

	}  else {
	    $oSystem->jsAlert('Update gagal!');	
		$db->query('ROLLBACK;');
	}

   } //$_POST[]

  

//   echo $tfNama;

?>


<link rel="stylesheet" type="text/css" href="../vendor/select2/select2.min.css">
<script src="../vendor/select2/select2.min.js"></script>
<script src="../js/combodate.js"></script>

<body class="sticky-header">

<style type="text/css">



.divtr {

	margin-top:10px;

	

	}

.divtrsmall {

	margin-top:-10px;

	

}



}

.bold {

	font-weight:bold;

	

}



@media (max-width: 600px) {

  .divtr {

	margin-top:0px;

	

	}



.divtrsmall {

	margin-top:-15px;

	

}



  } 



input::-webkit-outer-spin-button,

input::-webkit-inner-spin-button {

    /* display: none; <- Crashes Chrome on hover */

    -webkit-appearance: none;

    margin: 0; /* <-- Apparently some margin are still there even though it's hidden */

}





input[type=number] {

    -moz-appearance:textfield;

}



label.error{

    color: red !important;

    font-weight: normal !important;

}



.thedis {

        pointer-events: none;

        cursor: default;

        opacity: 0.6;

    }

.form-control {

       border-radius:4px;	

}



.required {

       border-radius:4px;	

}





	</style>

   

<script src="../js/jquery.validate.min.js"></script>

<script language="javascript">



<?

  $vNow = date('H:i:s');

  if ($vNow >= "00:00:00" && $vNow <="03:00:00") {

?>

  alert('Sistem sedang memproses bonus pukul 00:00:00 - 03:00:00, silakan melakukan registrasi di luar jam tersebut!');

  document.location.href='../index.php';

  

<? } ?>

function setPaket(pParam) {

  var vOngkir=0;

  if (pParam=='S') {

     vOngkir = parseFloat('<?=$vOngkir?>') * 1;

  } else if (pParam=='G') {

     vOngkir = parseFloat('<?=$vOngkir?>') * 3;

  } else if (pParam=='P') {

     vOngkir = parseFloat('<?=$vOngkir?>') * 7;

  } 

  

  $('#spShipCost').html(vOngkir);

  

$('#spShipCost').priceFormat({     

		                    prefix: ' ',

		                    centsSeparator: ',',

		                    thousandsSeparator: '.',

		                    limit: 15,

		                    centsLimit: 0

		       });



  

  $('#hShipCost').val(vOngkir);



}

/*

if ('<?=$_SESSION["Ref"]?>'=='-1' || '<?=$_SESSION["Ref"]?>'=='') {

    alert('No sponsor active in this page, please choose a referral from main page!');

    window.close();

    



}

*/

function validPaket() {

    //var vPaket=document.frmReg.rbPaket.value;

    var vPaket=$('#rbPaket').val();

	/*var vPaketE=document.getElementById('UEC').value;

	var vPaketB=document.getElementById('UBC').value;

	var vPaketF=document.getElementById('UFC').value;

	var vSplitPaketE=vPaketE.split(';');

	var vSplitPaketB=vPaketB.split(';');

	var vSplitPaketF=vPaketF.split(';');

	

	var vBatasE=vSplitPaketE[1];

	var vBatasB=vSplitPaketB[1];

	var vBatasF=vSplitPaketF[1];

	

	var vPaketE = vSplitPaketE[0];

	var vPaketB = vSplitPaketB[0];

	var vPaketF = vSplitPaketF[0];	

	

	vPaket = vPaket.split(';');

	var vNamaPaket=vPaket[0];

    vPaket=vPaket[1];

    */

    //alert(vBatasE+' '+vBatasB+' '+vBatasC);   

    

    

	//alert($('#hTotJum').val());

//	alert(vPaket);

	var vTotJum=$('#hTotJum').val();

//	if(typeof $('#hTotJum').val() !== "undefined") {

	if(true) {	

	   /*

	   if (vPaket=='S' && vTotJum !='1') {

	      alert('Registration Package Silver must purchase only 1 set');

	      return false;

	   } else  if (vPaket=='G' && vTotJum !='3') {

	      alert('Registration Package Gold  must purchase  3 sets');

	      return false;

	   } else  if (vPaket=='P' && vTotJum !='7') {

	      alert('Registration Package Platinum  must purchase  7 sets');

	      return false;

	   }





	if (parseFloat($('#hTot').val()) < parseFloat(vPaket)) {

			    alert('Belanja belum mencapai '+vPaket+' sesuai paket yg Anda pilih, mohon tambahkan belanja Anda!');				   

			    return false;

			} else if (parseFloat($('#hTot').val()) >= parseFloat(vBatasF) && (vNamaPaket=='B' || vNamaPaket=='E') ) {

			    alert('Belanja Anda cukup untuk paket First Class, silakan ganti kartu KIT dengan jenis First Class');

			    return false;

			} else if (parseFloat($('#hTot').val()) >= parseFloat(vBatasB) && vNamaPaket=='E' ) {

			    alert('Belanja Anda cukup untuk paket Business, silakan ganti kartu KIT dengan jenis Business Class');

			    return false;

			} else */

						

 return true;

			

		

	} else { 

	   alert('Anda belum melakukan pembelanjaan!');

	   return false;

	} 

}



	$.validator.setDefaults({

	    

		submitHandler: function() {

		   

 /*var vPaket=document.getElementById('rbPaket').value;

		    vPaket = vPaket.split(';');

		    vPaket=vPaket[1];

		    alert(vPaket);

		    return false; */

		    if (confirm('Anda yakin melakukan update?')==true) {

				var vValid= validPaket();

							

 				if (vValid)

 				   document.frmReg.submit();

				

			} else return false;

			

			

		}

	});

$(document).ready(function(){
    $("footer").css('width','100%');
    $("footer").css('margin-left','0px');

 //  alert('ssss');

  // alert($('#hHarga').val());

  if ('<?=trim($_SESSION['Ref'])?>'  != '') {

	//  $('#tfSernoSpon').trigger('blur');

  }
   $('#fidbisnis').select2();
   $('#tfIdent').attr('maxlength',16);



   $('#caption').html('Edit Pebisnis');

   /*$('#tfTglLahir').datepicker({

                    format: "dd-mm-yyyy"

    }).on('changeDate', function (ev) {

    $(this).datepicker('hide');

    });  

*/



$('#ftgllahir').combodate(

{

    minYear: 1930,

    maxYear: 2050,

}

);

$('.day').addClass('form-control');

$('.month').addClass('form-control');

$('.year').addClass('form-control');

$('.day').css("margin-left", "2px");

//$('.day').css("max-width", "70px");

$('.month').css("margin-left", "2px");

//$('.month').css("max-width", "80px");

$('.year').css("margin-left", "2px");

//$('.year').css("max-width", "90px");



 // $.validator.messages.required = '<span style="color:red;font-weight:normal">This field is required!</span>';

  $('#frmReg input, #frmReg textarea,  #frmReg select, #frmReg checkbox, #frmReg radio').not([type="submit"]).not($("#fidmember")).not($("#femail")).not($("#frefer")).not($("#fpropo")).not($("#fkota")).not($("#fpaspor")).not($("#tfBranchBank")).not($("#tfSernoUpName")).addClass('required');  

  $('#fcountry').val('ID');

  $('#fcountry').trigger('change');

  

  $('#lmCountryBank').val('ID');

  $('#lmCountryBank').trigger('change');





		$("#frmReg").validate({

				

			rules: {

				tfTempat: "required",

				tfNama: { 

				    required : true,

				      

				},

				tfIdent: {

					required: true,

					minlength: 16,

					maxlength: 16

				},

				tfEmail: {

					required: false,

					email: true

				},

				

				tfRek :{

				    required : true,

				},

				

			

				

				

				

			},

			messages: {

			   // tfIdent: '<span style="color:red;font-weight:normal">This field is required with minimum 9 character length!</span>',

			    tfRek : '<span style="color:red;font-weight:normal">This field is required and must be number!</span>',

			},

			

			 errorPlacement: function(error,element){ 

                            error.insertAfter(element); 

                          //  alert(error.html()); 

                       },

	               showErrors: function(errorMap, errorList){ 

                              this.defaultShowErrors();

                       }

		});  

		

$("input").css("color","#000");

$("select").css("color","#000");

$("textarea").css("color","#000");

$("button").css("color","#000");



});



   function doAdd() {

       $('#lmKode').show();

       $('#lmKode').val('');

       $('#btCancel').show();  

       $('#txtJml').show();   

       $('#lmSize').show(); 

       $('#lmColor').show();

        $('#trAdd').show(); 

       $('#btSaveRow').show(); 

       



   }

   

   function doCancel() {

      $('#lmKode').hide();

      $('#btCancel').hide();

      $('#txtJml').hide();  

      $('#lmSize').hide(); 

      $('#trAdd').hide(); 

      $('#btSaveRow').hide();



	  

   }

   

   function selectProd(pParam) {

      var vNama=$('[name=lmKode] option:selected').text();

      vNama=vNama.split(';');

      vNama=vNama[1];

      

      var vHarga=  $(pParam).find('option:selected').attr("price");     

      var vItemSat=  $(pParam).find('option:selected').attr("jmlitem");     

      $('#thNama').html(vNama);

      $('#thHarga').html(vHarga);

      

       $('#hHarga').val(vHarga);

       $('#hItemSat').val(vItemSat);

      // alert($('#hItemSat').val());



      $('#thHarga').priceFormat({     

                    prefix: ' ',

                    centsSeparator: ',',

                    thousandsSeparator: '.',

                    limit: 15,

                    centsLimit: 0

                });

      var vQoh=  $(pParam).find('option:selected').attr("qoh"); 

       $('#thQoh').html(vQoh);

       $('#hQoh').val(vQoh);



      $('#thQoh').priceFormat({     

                    prefix: ' ',

                    centsSeparator: ',',

                    thousandsSeparator: '.',

                    limit: 15,

                    centsLimit: 0

                });

       



      

      var vSize=  $(pParam).find('option:selected').attr("sizes");  

      if (vSize) {

	      vSize=vSize.split(',');

	      var vOpt='<option value="">---Pilih---</option>';

	      for(i = 0; i < vSize.length; i++){

	         vOpt+='<option value="'+vSize[i]+'">'+vSize[i]+'</option>';

		  }

		  

		  if (pParam.value !='') {

		     $('#lmSize').html(vOpt);

		     if (vSize.length == 1)

		        $('#lmSize option:last-child').attr('selected', 'selected');

		  } else   

		     $('#lmSize').html('<option value="">---Pilih---</option>');

	  } else 

	      $('#lmSize').html('<option value="">---Pilih---</option>'); 





      var vColor=  $(pParam).find('option:selected').attr("colors");



      if (vColor) {

	      vColor=vColor.split(',');

	      var vOpt='<option value="">---Pilih---</option>';

	      for(i = 0; i < vColor.length; i++){

	         vOpt+='<option value="'+vColor[i]+'">'+$('#'+vColor[i]).val()+'</option>';

		  }

		  

		  //alert(vOpt);

		  if (pParam.value !='') {

		     $('#lmColor').html(vOpt);

		     if (vColor.length == 1)

		        $('#lmColor option:last-child').attr('selected', 'selected');



		  } else   

		     $('#lmColor').html('<option value="">---Pilih---</option>');

	  } else 

	      $('#lmColor').html('<option value="">---Pilih---</option>'); 







   }

   

 function calcSub(pParam) {

     var vJum=pParam.value;

     var vHrg = $('#hHarga').val();

     var vItemSat = $('#hItemSat').val();

   

        

     var vSubTot = parseFloat(vJum) * parseFloat(vHrg);

     var vJmlItem= parseFloat(vJum) * parseFloat(vItemSat);



   // alert('Jum:'+vJum);alert('Hrg'+vHrg );alert('ItemSat'+vItemSat);

   

     $('#thSubTot').html(vSubTot);

     $('#thJmlItem').html(vJmlItem);



	$('#hJmlItem').val(vJmlItem);

   // alert(vJmlItem);

     $('#hSubTot').val(vSubTot);

     

      $('#thSubTot').priceFormat({     

                    prefix: ' ',

                    centsSeparator: ',',

                    thousandsSeparator: '.',

                    limit: 15,

                    centsLimit: 0

       });

 

    

     

 

}  


function calcPay() {
     var vSAwal = $('#fstorawal').val();
     var vAngsur1 = $('#fangsur1').val();
	 var vAngsur2 = $('#fangsur2').val();
	 var vAngsur3 = $('#fangsur3').val();
	 var vAngsur4 = $('#fangsur4').val();
	 var vLunas = $('#flunas').val();
	 var vTotal = parseFloat(vSAwal) + parseFloat(vAngsur1) + parseFloat(vAngsur2) + parseFloat(vAngsur3) + parseFloat(vAngsur4) + parseFloat(vLunas); 
     
     $('#ftotalbayar').val(vTotal);

}  





function doSaveRow() {

   var vURL = "register_purcout_ajax.php";

   if ($('#lmKode').val()=='') {

      alert('Choose Product!');

      return false;

   }





   

   if (parseFloat($('#txtJml').val()) <=0 || $('#txtJml').val()=='') {

      alert('Isikan jumlah item!');

      $('#txtJml').focus();

      return false;

   }

   $('#tdLoad').html('<img src="../images/ajax-loader.gif" />');

   $.post(vURL,$("#frmReg").serialize(), function(data) {

      $('#tbPurc').html(data);

      $('#tdLoad').empty();

		 var xTot=	parseFloat($('#hTot').val()) + parseFloat($('#hKit').val());

		 $('#hTotal').val(xTot);

		 $('#totalpurc').html(xTot);  

		      $('#totalpurc').priceFormat({     

		                    prefix: ' ',

		                    centsSeparator: ',',

		                    thousandsSeparator: '.',

		                    limit: 15,

		                    centsLimit: 0

		       });

		 $('#spcurr').html('IDR');      

		 $('#divCurr').show();

		 $('#lmCurr option:first-child').attr('selected', 'selected');



      

   });

   



 

   

}

 



function doDel(pNo, pKode,pSize,pColor,pNama,pJml,pHarga,pSubTot) {

//alert(pNo +':'+ pKode+':'+pSize+':'+pColor+':'+pNama+':'+pJml+':'+pHarga+':'+pSubTot);  

 var vURL = "register_purcout_ajax.php";

   $('#tdLoad').html('<img src="../images/ajax-loader.gif" />');

  

 $.post(vURL,{ delNo : pNo, delKode: pKode, delSize: pSize, delColor : pColor, delNama : pNama, delJml : pJml, delHarga : pHarga, delSubTot : pSubTot, op : 'del' }, function(data) {

      $('#tbPurc').html(data);

      $('#tdLoad').empty();

   });

}

  

  

function prepareProp(pParam) {

   

   var vURL="../main/mpurpose_ajax.php?op=wil&wil=prop&kodewil="+pParam.value;

 // $('#divProp').css({'background':'transparent url("../images/ajax-loader.gif")','background-repeat': 'no-repeat','background-position': 'center','z-index' : '10'});

  $('#loadProp').show();

  $.get(vURL, function(data) {
      $('#fprop').html(data);
      $('#loadProp').hide();
	  $('#fprop').val('<?=$vPropL?>');
	  $('#fprop').trigger('change');
   });   

}





function prepareKota(pParam) {
   var vCountry=$('#fcountry').val();
   if (pParam.value !='PX') {
	   var vURL="../main/mpurpose_ajax.php?op=wil&neg="+vCountry+"&wil=kota&kodewil="+pParam.value;
	   $('#loadKota').show();
	   $('#tfprop').hide();
       $('#tfkota').hide();
	   $.get(vURL, function(data) {
	      $('#fkota').html(data);
	       $('#loadKota').hide();
		   
		   $('#fkota').val('<?=$vKotaL?>');
		    $('#fkota').trigger('change');
		   
	   });   
   } else {
     $('#tfprop').show();
      $('#tfprop').focus();     
   }
}


function prepareKeca(pParam) {
   var vCountry=$('#fcountry').val();
    var vProp=$('#fprop').val();
   if (pParam.value !='PX') {
	   var vURL="../main/mpurpose_ajax.php?op=wil&neg="+vCountry+"&wil=keca&kodeprop="+vProp+"&kodewil="+pParam.value;
	   $('#loadKeca').show();
	   $('#tfprop').hide();
       $('#tfkota').hide();
	   $.get(vURL, function(data) {
	       $('#fkec').html(data);
	       
		   $('#loadKeca').hide();
		   $('#fkec').val('<?=$vKecaL?>');
		   
	   });   
   } else {
     $('#tfprop').show();
      $('#tfprop').focus();     
   }
}



function getOther(pParam) {

   

   if (pParam.value =='KX') {

     $('#tfKota').show();

      $('#tfKota').focus();



     

   } else  $('#tfKota').hide();



}





function checkUserName(pParam){

  if (pParam.value=='')

      return false;

   else {    

   var vCountry=$('#lmCountry').val();

   var vURL="../main/mpurpose_ajax.php?op=checkuser";

   var vValid=/xnotfound/g;

   var vUsed=/xused/g;





   $('#statUser').html('&nbsp;<img src="../images/ajax-loader-bar.gif" />');

	   $.post(vURL, {user : pParam.value},function(data) {

		  if (vValid.test(data)) {

			 $('#statUser').html('<font color="#00f">User '+pParam.value+' is valid!</font>');

			 document.getElementById('btnSubmit').disabled=false;

			// document.getElementById('btAdd').disabled=false;

		 } else if (vUsed.test(data)) {

			 $('#statUser').html('<font color="#f00">User '+pParam.value+' already used!</font>');

			 document.getElementById('btnSubmit').disabled=true;    

		   //  document.getElementById('btAdd').disabled=true;

	 

		 }  

		 

	   });	

	}

	

}



function checkKit(pParam) {

   //

   var vUser=document.getElementById('tfSerno').value;

  

   document.getElementById('tfSerno').value=vUser;

   if (pParam.value=='')

      return false;

   else {    

   var vCountry=$('#lmCountry').val();

   var vURL="../main/mpurpose_ajax.php?op=kit";

   var vValid=/xyes/g;

   var vPaketB=/B/g;

   var vPaketP=/P/g;

   var vNotfound=/xnotfound/g;

   var vUsed=/xused/g;

   var vNoAct=/xnotactive/g;

   var vIDPaket=pParam.value.substring(0,3); 



   $('#statKit').html('&nbsp;<img src="../images/ajax-loader-bar.gif" />');

   $.post(vURL, {serno : pParam.value},function(data) {

      if (vValid.test(data)) {

		 vData=data.split(';'); 

		 

         $('#statKit').html('<font color="#00f">Serial Number '+pParam.value+' is valid! ('+vData[1]+')</font>');



	 		var vPackId=vData[2].trim();

			

		 if (vPackId=='S')

		    $('#lmHU').val('1');

		 else if (vPackId=='G') {

		    $('#lmHU').val('3');

			

		 }

		 else if (vPackId=='P')

		    $('#lmHU').val('7');

         document.getElementById('btnSubmit').disabled=false;

	

	

	

		// loadPurc(pParam.value);

        // document.getElementById('btAdd').disabled=false;

     } else if (vUsed.test(data)) {

         $('#statKit').html('<font color="#f00">Serial Number '+pParam.value+' already used!</font>');

         document.getElementById('btnSubmit').disabled=true;    

       //  document.getElementById('btAdd').disabled=true;

 

     }  else if (vNotfound.test(data)) {

         $('#statKit').html('<font color="#f00">Serial Number '+pParam.value+' was not found!</font>');

         document.getElementById('btnSubmit').disabled=true;    

       //  document.getElementById('btAdd').disabled=true;

 

     }  else if (vNoAct.test(data)) {

         $('#statKit').html('<font color="#f00">Serial Number '+pParam.value+' is not active!</font>');

         document.getElementById('btnSubmit').disabled=true;    

       //  document.getElementById('btAdd').disabled=true;

 

     } else   {

     //alert(vIDPaket);

         $('#statKit').html('<font color="#f00">Serial Number '+pParam.value+' is not valid!</font>');

         document.getElementById('btnSubmit').disabled=true;

        /* document.getElementById(vIDPaket).checked=true;

         if (vIDPaket=='UEC') {

            $('#UBC').attr('disabled',true);

            $('#UFC').attr('disabled',true);

            $('#UEC').attr('disabled',false);

         } else if (vIDPaket=='UBC') {

            $('#UBC').attr('disabled',false);

            $('#UFC').attr('disabled',true);

            $('#UEC').attr('disabled',true);

         

         } else if (vIDPaket=='UFC') {

            $('#UBC').attr('disabled',true);

            $('#UFC').attr('disabled',false);

            $('#UEC').attr('disabled',true);

         }

        // $("#frmReg input[name=ticketID]:radio").attr('disabled',true);    

        // $('input[name="rbPaket"]').is(':not(:checked)').attr('disabled',true);

        

   */

     }

   });   



  }

}



function checkKitSpon(pParam) {

   if (pParam.value=='') {

	  $('#tfSernoSponName').val(''); 

	  document.getElementById('btnSubmit').disabled=true;

      return false;

   } else {    

   var vCountry=$('#lmCountry').val();

   var vURL="../main/mpurpose_ajax.php?op=kitspon";

   var vYes=/yesx/g;

   var vNo=/nox/g;

   var vNamaS='';

   var vNama='';

   $('#loadNama').show();

   $('#statKitSpon').html('&nbsp;<img src="../images/ajax-loader-bar.gif" />');

   $.post(vURL, {sernospon : pParam.value},function(data) {

      if (vNo.test(data)) {

         $('#statKitSpon').html('<font color="#f00">Sponsor Tidak Valid!</font>');

         document.getElementById('btnSubmit').disabled=true;



     } else if (vYes.test(data)) {

		   vNamaS=data.split('|');

		   vNama=vNamaS[1];

		   vPhone=vNamaS[2];

		   vEmail=vNamaS[3];

         

         $('#statKitSpon').html('<font color="#00f">Sponsor  valid!</font>');

         $('#tfSponsor').val(vNama);

         $('#tfPhoneSpon').val(vPhone);

         $('#tfEmailSpon').val(vEmail);

		 $('#tfSernoSponName').val(vNama);

      //  alert(vPhone+':'+vEmail);





         document.getElementById('btnSubmit').disabled=false;     

     }    

   $('#loadNama').hide();  

   });   



  }

}





function checkKitPres(pParam) {

   if (pParam.value=='') {

	  $('#tfSernoPresName').val(''); 

	  document.getElementById('btnSubmit').disabled=true;

      return false;

   } else {    

   var vCountry=$('#lmCountry').val();

   var vURL="../main/mpurpose_ajax.php?op=kitpres";

   var vYes=/yesx/g;

   var vNo=/nox/g;

   var vNamaS='';

   var vNama='';

   $('#loadNama').show();

   $('#statKitPres').html('&nbsp;<img src="../images/ajax-loader-bar.gif" />');

   $.post(vURL, {sernopres : pParam.value},function(data) {

      if (vNo.test(data)) {

         $('#statKitPres').html('<font color="#f00">Presenter Tidak Valid!</font>');

       //  document.getElementById('btnSubmit').disabled=true;



     } else if (vYes.test(data)) {

		   vNamaS=data.split('|');

		   vNama=vNamaS[1];

		   vPhone=vNamaS[2];

		   vEmail=vNamaS[3];

         

         $('#statKitPres').html('<font color="#00f">Presenter valid!</font>');

         $('#tfSernoPresName').val(vNama);

        // $('#tfPhoneSpon').val(vPhone);

        // $('#tfEmailSpon').val(vEmail);

		 //$('#tfSernoSponName').val(vNama);

      //  alert(vPhone+':'+vEmail);





         document.getElementById('btnSubmit').disabled=false;     

     }    

   $('#loadNama').hide();  

   });   



  }

}







function checkKitUp(pParam) {

   if (pParam.value=='') {

	   $('#statKitUp').html('');

       if ($('#tfSernoSponName').val() != '')

	   document.getElementById('btnSubmit').disabled=false;

      return false;

	  

   } else {    

   var vCountry=$('#lmCountry').val();

   var vURL="../main/mpurpose_ajax.php?op=kitup";

   var vYes=/yesx/g;

   var vNo=/nox/g;

   var vNoAll=/noxall/g;

   var vHas=/hasleg/g;

   var vNotIn=/notinnet/g;

   var vNamaS='';

   var vNama='';

   var vPosition=$('#rbPosition').val();

   var vSpon=$('#tfSernoSpon').val();

   $('#loadNama').show();

   $('#statKitUp').html('&nbsp;<img src="../images/ajax-loader-bar.gif" />');

 //  if (pParam.value !='') {

   $.post(vURL, {sernoup : pParam.value, sernospon:vSpon, position: vPosition},function(data) {

	  

     if (vNotIn.test(data) && vNo.test(data)) {

		   

         $('#statKitUp').html('<font color="#f00">Upline Tidak Valid, di luar jaringan sponsor '+vSpon+'!</font>');

		

         document.getElementById('btnSubmit').disabled=true;



     } else if (vNo.test(data) && vHas.test(data)) {

		   

         $('#statKitUp').html('<font color="#f00">Upline Tidak Valid, kaki '+vPosition+' sudah terisi!</font>');

		

         document.getElementById('btnSubmit').disabled=true;



     } else if (vNoAll.test(data)) {

		

         $('#statKitUp').html('<font color="#f00">Upline Tidak Valid!</font>');

         document.getElementById('btnSubmit').disabled=true;



     } else if (vYes.test(data)) {

		   vNamaS=data.split('|');

		   vNama=vNamaS[1];

		   vPhone=vNamaS[2];

		   vEmail=vNamaS[3];

         

         $('#statKitUp').html('<font color="#00f">Upline valid!</font>');

         //$('#tfUpline').val(vNama);

         //$('#tfPhoneSpon').val(vPhone);

         //$('#tfEmailSpon').val(vEmail);

		 $('#tfSernoUpName').val(vNama);

      //  alert(vPhone+':'+vEmail);



		if ($('#tfSernoSponName').val() != '')

          document.getElementById('btnSubmit').disabled=false;    

     }    

	 

	

   $('#loadNama').hide();  

   });   



  }

}



function setUpper(pParam) {

   document.getElementById(pParam.name).value=document.getElementById(pParam.name).value.toUpperCase();

}

function submitForm() {

   ;//document.frmReg.submit();



}





function setMaxLenRek() {

   var vSplit=$('#tfBank').val();

   vSplit=vSplit.split(';');

   var vMaxLen=vSplit[1];

   $('#tfRek').val('');

  

  $('#tfRek').attr('maxlength',vMaxLen);

   $('#tfRek').attr('placeholder','Bank Account No* ('+vMaxLen+' digits all number!)');





 

$('#tfRek').rules('add', {



   required: true,

   rangelength: [vMaxLen,vMaxLen],

   messages: {

       rangelength: 'Must be '+vMaxLen+' characters length!'

   }

});



  

   if ($('#tfBank').val() !='')

      $('#tfRek').attr('readonly', false);

   else   {

      $('#tfRek').attr('readonly', true);

      $('#tfRek').val('');

  }

	

}



function openTerm() {

   window.open('../main/term.php','wTerm','toolbar=no, scrollbars=yes, resizable=yes, top=0, left=0, width=800, height=700');



}





 function maxLengthCheck(object)

  {

    if (object.value.length > object.maxLength)

      object.value = object.value.slice(0, object.maxLength)

  }

 

function setFilterBank(pParam) {

   var vURL="../main/mpurpose_ajax.php?op=bankcnt&cnt="+pParam;

 

  $('#loadBank').show();

  $.get(vURL, function(data) {

      $('#tfBank').html(data);

      $('#loadBank').hide();



   });   

   



}



function setCurr(pParam,pNom) {

    var vURL='../main/mpurpose_ajax.php?op=currconvert&from=IDR&to='+pParam+'&nom='+pNom;

	 $.get(vURL, function(data) {

	  var vConvert = data ;

      $('#samaconvert').html(' = ');

      $('#convert').empty().html(vConvert);

      $('#currconvert').empty().html(pParam);

        



   });   



}



function checkAge(pDate) {

var ymdate = pDate.split("-").reverse().join("-");

var diff = Math.floor((new Date - new Date(ymdate )) / 1000 / (60 * 60 * 24));

     var age = Math.floor( diff / 365.25 );

     if (parseFloat(age) < 17) {

        $('#lblTL').html('Age must be at least 17');

        document.getElementById('btnSubmit').disabled=true;

		document.getElementById('ftgllahir').value='';

     } else { $('#lblTL').html('');

       document.getElementById('btnSubmit').disabled=false;



     }

}



function checkMultiIdent(pIdent) {

   var vURL="../main/mpurpose_ajax.php?op=checkmultiident&ident="+pIdent;

 // $('#divProp').css({'background':'transparent url("../images/ajax-loader.gif")','background-repeat': 'no-repeat','background-position': 'center','z-index' : '10'});



  $.get(vURL, function(data) {

	   var vJml=parseFloat(data.trim());

	

	   if (vJml >=999999999) {

	      alert('ID Card already have maximum using for registration');

	      document.getElementById('btnSubmit').disabled=true;

	      document.getElementById('tfIdent').value='';

	   } else document.getElementById('btnSubmit').disabled=false;

   });   

  

} 



function loadPurc(pKit){

//	alert(pKit);

   var vURL='../manager/loadpurc_ajax.php?kit='+pKit;

   $.get(vURL,function(data){

	  $('#divPurc').html(data);; 

   });	

	

}



function removeSpecChar(e) {

    return e.replace(/[^A-Za-z0-9_]/g, "");

}

 </script>

	<!--<link rel="stylesheet" href="../css/screen.css"> -->



	

 <link rel="stylesheet" type="text/css" href="../vendors/font-awesome/css/all.css" />	

 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />



<?

 $vSQL="select fidcolor,fcolor from m_color where faktif='1' order by fcolor";

  $db->query($vSQL);

  $i=0;

  while($db->next_record()) {

      $vCode=$db->f('fidcolor');

      $vColor=$db->f('fcolor');

      $i++;

?>

  <input type="hidden" name="hArrColor<?=$i?>" id="<?=$vCode?>" value="<?=$vColor?>" >



<? } ?>

 <div class="right_col" role="main">

		<div><label>
		<h3>Edit <? if($_GET['j']=='sub') echo 'Sub '?>Pebisnis</h3></label></div> 



<form method="post" id="frmReg" name="frmReg" action="">

	<div class="container" >

    <div class="row" style="width:98%;margin-top:8px">

    

     

    

    

        <div class="col-md-12">

                <div class="panel panel-default" id="panelkiri" >

                    <div class="panel-heading" >

                             <div class="panel-title" style="margin-top:0px">

        						 <label for="exampleInputEmail1" style="font-weight:bold;">

								 Data <? if($_GET['j']=='sub') echo 'Sub '?>Pebisnis</label>
       						   <br style="display: block;margin: -5px 0;" />                                    

                     		</div>

                     </div>

                     <div class="panel-body" style="color:black">

							 <div class="form-group" >
							   <div style="" class="divtr col-lg-6">

							<label for="exampleInputEmail1" >
							ID / Username
							 <? if($_GET['j']=='sub') echo 'Sub '?>Pebisnis*  
						     <div align="left" style="display:inline" id="statKit"></div></label>
							

                                    <div class="input-group">

                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>

                                    <input readonly type="text" class="form-control" id="fidmember" name="fidmember" value="<?=$vIdPilgrimsL?>"    >
                              </div>                            
                            </div>





                      <div class="divtr col-lg-6" >
                                <label   for="tfNama">
								Nama <? if($_GET['j']=='sub') echo 'Sub '?>Pebisnis*</label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" id="fnama" name="fnama" placeholder="(Tanpa tanda koma)*" onBlur="this.value=this.value.replace(/,/g,'');" onKeyUp="this.value=this.value.replace(/,/g,'');$('#tfAtasNama').val(this.value);" value="<?=$vNamaL?>">
                                </div>
</div>    
                        
<div class="divtr col-lg-6 ">

                                    <label for="exampleInputEmail1">Nomor KTP  *</label>

                                    <div class="input-group">

                                      <span class="input-group-addon"> <i class="fa fa-id-card"></i></span>

                                    	<input type="number" maxlength="16" oninput="" class="form-control" id="fnoktp" name="fnoktp" onBlur="checkMultiIdent(this.value)" placeholder="No. KTP.*" value="<?=$vNoKTP?>">

                               </div>

                             </div>
                             
                             

                <div class="form-group" >     

                        <div class="divtr col-lg-12">

                            <label for="exampleInputEmail1">Alamat Pebisnis*</label>

                                    <div class="input-group">

                                      <span class="input-group-addon"> <i class="fa fa-envelope"></i></span>

                                <textarea id="falamat" name="falamat" class="form-control custom-control" rows="2" style="resize:none"><?=$vAlamatL?></textarea>

                          <!--  <input type="text" class="form-control" id="tfNama" placeholder="Full Address along with Postal Code*"> -->

                            </div>

                        </div>

                        </div>


  

  					 <div class="form-group"  id="kotaprovneg">                      

                               

                                                                



   							<div class="form-group" > 

                               <div class="col-lg-4 col-md-4 divtr" >

                                <label for="exampleInputEmail1" ><span style="font-weight:bold">Negara*</span></label>

                                                                 <!-- <input type="text" class="form-control" id="tfNama" placeholder="Country*"> -->

                                <select class="form-control m-bot15" id="fcountry" name="fcountry" onChange="prepareProp(this)">

                                <option  value="" selected="selected" >--Pilih / Choose--</option>

								<? 

								    $vSQL="select * from m_country order by fcountry_name";

								    $db->query($vSQL);

								    while ($db->next_record()) {

								?>                               

								 <option value="<?=$db->f('fcountry_code')?>" ><?=$db->f('fcountry_name')?></option>

								 <? } ?>

                            </select>



                                 </div>

                              

     							                    

                               <div class="col-lg-4 col-md-4 divtr" id="divProp">

                               <img id="loadProp"  align="absmiddle" src="../images/ajax-loader.gif" style="position:absolute;z-index:2;margin-left:45px;margin-top:24px;opacity: 0.5;display:none" />

                                <label for="exampleInputEmail1" ><span style="font-weight:bold">Propinsi*</span></label>

                                                                <select class="form-control m-bot15" id="fprop" name="fprop" onChange="prepareKota(this)">

                                <option  value="" selected="selected" >--Pilih / Choose--</option>

                                <option  value="PX"  >Other Province</option>



								</select>

								<input style="display:none" type="text" class="form-control" id="tfprop" name="tfprop" placeholder="Other Province">

								

                                </div>

                            

                              

     						 <div class="col-lg-4 col-md-4 divtr" id="divKota">
                                <img id="loadKota"  align="absmiddle" src="../images/ajax-loader.gif" style="position:absolute;z-index:2;margin-left:45px;margin-top:24px;opacity: 0.5;display:none" />
                                <label for="exampleInputEmail1" ><span style="font-weight:bold">Kabupaten/Kota*</span></label>
                                <select class="form-control m-bot15" id="fkota" name="fkota" onChange="prepareKeca(this)">
                                <option  value="" selected="selected" >--Pilih / Choose--</option>
                                <option  value="KX"  >Kota Lain</option>
								</select>
								<input style="display:none" type="text" class="form-control" id="tfkota" name="tfkota" placeholder="Other City">
                               </div>                        

                              

<div class="col-lg-6 col-md-6 divtr" id="divKec">
                                <img id="loadKeca"  align="absmiddle" src="../images/ajax-loader.gif" style="position:absolute;z-index:2;margin-left:45px;margin-top:24px;opacity: 0.5;display:none" />
                                <label for="exampleInputEmail1" ><span style="font-weight:bold">Kecamatan*</span></label>
                                <select class="form-control m-bot15" id="fkec" name="fkec" onChange="getOther(this)">
                                <option  value="" selected="selected" >--Pilih / Choose--</option>
                                <option  value="KX"  >Kec Lain</option>
								</select>
								<input style="display:none" type="text" class="form-control" id="tfkec" name="tfkec" placeholder="Other City">
                               </div>


<div class="col-lg-6 divtr" >

                                   <label for="exampleInputEmail1" >

								   <span style="font-weight:bold">&nbsp;Nomor Telepon*</span></label>

                                   <div class="form-inline">

                                    <div class="input-group">

                                      <span class="input-group-addon"> <i class="fa fa-mobile"></i></span>

                                

                                <input  type="text" class="form-control" id="fprefix" name="fprefix" value="+62" style="max-width:50px">

                                 

                                </div>

                                <input  type="number" class="form-control" id="fnohp" name="fnohp" placeholder="Contoh: 8123456781 (tanpa 0 di depan)"  style="margin-top:-10px;width:80%" value="<?=$vNoHPL?>">

                                

                               

                                </div>

                              </div>
                              

						</div> <!--form-group-->

                        </div>

   

  

 					 <div class="form-group"  id="phonehp">                      

                              <!--

                               <div class="col-lg-6 col-md-6 divtr hide" >

                                <label for="exampleInputEmail1" ><span style="font-weight:bold">No Telepon*</span></label>

                                    <div class="input-group">

                                      <span class="input-group-addon"> <i class="fa fa-phone"></i></span>

                                <input type="number" class="form-control" id="tfPhone" name="tfPhone" placeholder="Phone Number*">

                                </div>

                              </div>-->

                                                                

   							                    

                               

                              

 							                              

                              

						</div>


                         
</div>

                               

                            <div class="form-group">

                                

                               

                                                                

                                    <div class="form-group">        

                                  

                                  </div>

                                

                            </div>

                            <div class="form-group" >                      

                               

                                                                

                                  

                                

                       </div>

 

    				

							                              



                     </div> <!--Panel Body-->

                </div> <!--Col-md-6 kiri-->

				     

        </div>

         <!--Kolom Kanan -->

        </div>





<!--         

<div class="panel panel-default" id="panelkanan" >

					                    <div class="panel-heading" >

					                             <div class="panel-title" style="margin-top:-10px">

					        						 <label for="exampleInputEmail1" style="font-weight:bold;">

													 Product Purchase</label><br style="display: block;margin: -5px 0;" />                                    

					                     		</div>

					                     </div>

					                     <div class="panel-body">



<div class="table-responsive" id="tbPurc">

<table class="table" >

                            <thead>

                            <tr>

                                <th width="3%">#</th>

                                <th width="15%">Product Code</th>

                                <th width="25%">Product Name</th>

                                <th width="9%" class="hide">Ukuran</th>

                                <th width="9%" align="right">Set Qty</th>

                                <th style="width: 10%" align="right">Item Qty</th>

                                <th style="width: 104px" align="right">Set Price</th>

                                <th style="width: 94px" align="right">Sub Total</th>

                                <th width="12%">&radic;</th>

                            </tr>

                            </thead>

                            <tbody>

                            <tr id="trAdd" style="display:">

                                <th style="width: 33px; height: 30px;"></th>

                                <th style="width: 208px; height: 30px;">

                                <select onChange="selectProd(this)" name="lmKode" id="lmKode" class="form-control" style="display:none;width:140px">

								

								<option value="" selected="selected">---Pilih---</option>

							

								</select>

							

								

								</th>

                                <th id="thNama" style="height: 30px" ></th>

                                <th id="thUkur" style="height: 30px" class="hide">

                                

                                <select name="lmSize" id="lmSize" style="display:none;min-width:80px" class="form-control">

								<option value="">---Pilih---</option>

								</select>

								

								</th>

                                <th style="height: 30px"> 

                                <input name="txtJml" id="txtJml" class="form-control"  type="text" dir="rtl" style="display:none;min-width:55px" size="10" onKeyUp="calcSub(this)" onBlur="calcSub(this)" >                                

                                

                                </th>

                                <th style="height: 30px; width: 10%;" align="left" id="thJmlItem"> 

                                

                                



                                </th>

                                <th style="width: 104px; height: 30px;" id="thHarga"></th>

                                <th align="right" id="thSubTot" style="height: 30px; width: 94px;"></th>

                                <th align="center" id="thSubTot" style="height: 30px"><input id="btSaveRow" type="button" onClick="return doSaveRow()" class="btn btn-success btn-sm" value="Save Item" style="display:none"/></th>

                                <th style="display:none; height: 30px;"></th><input type="hidden" name="hSubTot" id="hSubTot" value="" /></th>

                            </tr>

                            <tr>

                                <td style="width: 33px">&nbsp;<input type="hidden"  id="hHarga" name="hHarga" value="">

                                <input type="hidden"  id="hItemSat" name="hItemSat" value="">

                                <input type="hidden"  id="hQoh" name="hQoh" value="">

                                <input type="hidden" name="hJmlItem" id="hJmlItem" value="" /> 

                                </td>

                                <td align="left" style="width: 208px" colspan="2"><input disabled="disabled" id="btAdd" type="button" onClick="doAdd()" class="btn btn-info btn-sm" value="Add Item +"/>&nbsp;<input type="button" onClick="doCancel()" class="btn btn-default btn-sm" value="Cancel" id="btCancel" style="display:none"/></td>

                                <td align="left" id="tdLoad" class="hide">&nbsp;</td>

                                <td>&nbsp;</td>

                                <td style="width: 10%">&nbsp;</td>

                                <td style="width: 104px">&nbsp;</td>

                                <td style="width: 94px">&nbsp;</td>

                                <td>&nbsp;</td>

                                <td>&nbsp;</td>

                            </tr>

                            </tbody>

                        </table>

                        

                    </div>       

--responsive--



                    

        </div>         

        -- panel kanan--

   </div>   

   

   -->

  

   

<div class="row">

                           

                            <div class="col-md-6 " style="margin-left:1.4em">

										<?

										   //$vKit=$oRules->getSettingByField('fhrgkit');

										   $vKit=0;

										?>

                            

                                       <!-- <input name="Checkbox1" type="checkbox" checked="checked" disabled="disabled">Termasuk 

										biaya starter KIT Rp <?=number_format($vKit,0,",",".")?>,-<br><br>

								&nbsp;<label style="font-weight:bold">Total Purchased : <span id="totalpurc">0</span> <span id="spcurr"></span><span id="samaconvert"></span><span id="convert"></span><span id="currconvert"></span></label> -->

								      <br>&nbsp;<label style="font-weight:bold;" class="hide">Shipping Cost : <span class="hide" id="spShipCost">0</span></label> 

										<input type="hidden" name="hShipCost" id="hShipCost" value="0">

										<div class="form-inline" id="divCurr" style="display:none"> <label style="font-weight:bold" class="hide">Currency : </label>

										<select name="lmCurr" id="lmCurr" class="form-control hide" style="width:85px;" onChange="setCurr(this.value,$('#hTotal').val());">

									



                                        

                     <?

                         $vSQL="select distinct  frateto from tb_exrate order by frateto";

						 $db->query($vSQL);

						 while ($db->next_record()) {

							 $vCurr=$db->f('frateto');

					 ?>

                         <option value="<?=$vCurr?>" <? if ($vCurr==$vCurrTo) echo 'selected'; ?>><?=$vCurr?></option>

                     

                     <? } ?>

                     </select></div>



										<input id="cbTC" name="cbTC" type="checkbox"  ><a style="cursor:pointer;color:blue;text-decoration:underline" href="#" onClick="openTerm()">&nbsp;Data tersebut diatas adalah benar</a><br><br>

										<input type="hidden" name="hKit" id="hKit" value="<?=$vKit?>" />

										<input type="hidden" name="hTotal" id="hTotal" value="" />

                                        <button id="btnSubmit" type="submit" class="btn btn-primary"  onClick="submitForm(this)">Submit</button> 
                                        <?
                                                if($_GET['j']=='sub')
												   $vBack="aktifref";
												else   
												   $vBack="aktifref";
											 ?>
                                        
                                        <button type="button" class="btn btn-default" onClick="document.location.href='../masterdata/<?=$vBack?>.php?op=&current=mdm_master_data&menu=mdm_master_data_editkor';" >Back &laquo;</button> 
                                        
                                        
                                        
                                        <div id="divLoad" style="display:inline">
                                         
                                         <input type="hidden" name="hPost" id="hPost" value="1" />
                                        </div>

                                        

                            			 <!-- <input name="Button1" type="button" value="button" onclick="validPaket()"></div>  -->





</div>

</div>

										

									



                       

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

<!-- <script src="../js/pickers-init.js"></script>

<script src="../js/scripts.js"></script> -->

	</div>

	<!-- end page container -->

	





<? include_once("../framework/admin_footside.blade.php") ; ?>