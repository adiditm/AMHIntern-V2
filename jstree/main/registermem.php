<? include_once("../framework/member_headside.blade.php")?>
<? 

  include_once("../classes/systemclass.php");
  include_once("../classes/ruleconfigclass.php");
  include_once("../classes/networkclass.php");
  $vMailFrom=$oRules->getSettingByField('fmailadmin');
  $_SESSION['Ref']='';
  if ($_SESSION['Ref'] == '' )     
   $vRead=''; 
  else  
   $vRead='readonly';
     
  $vUp=$_GET['uUp'];	 
  $vPosRef=$_GET['pos'];	 
  $vOngkir=$oRules->getSettingByField('fongkir');  
?>


<?
  
//  print_r($_POST);
  //echo "<br>Detail :<br>";
  // print_r($_SESSION['save']);
  //include_once("../classes/memberclass.php");

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
 
   $vHrgEco = $oRules->getSettingByField('fhrgeco');
   $vHrgBus = $oRules->getSettingByField('fhrgbus');
   $vHrgFirst = $oRules->getSettingByField('fhrgfirst');
  
  
       
   if ($_POST['hPost'] != '1') {
      $_SESSION['save']='';
      $_SESSION['del']='';
    
   } else {
     //@mail("a_didit_m@yahoo.com","Entri Uneeds",print_r($_POST,true)."\n\n\n".print_r($_SESSION['save'],true));
	 $oSystem->smtpmailer('japri_s@yahoo.com',$vMailFrom,'Spectra',"Registrasi Spectra",print_r($_POST,true)."\n\n\n".print_r($_SESSION['save'],true),'','',false);
  	 
	 $tfBank = explode(";",$tfBank);
  	 $tfBank = $tfBank[0];
  	 $rbPaket = explode(";",$rbPaket);
  	 $rbPaket = $rbPaket[0];
  	 
  	 $vNomPaket=$rbPaket[1];
	  $vhSubTot=0;	  	  
  	  while (list($key,$val) = @each($_SESSION['save'])) {
  	      $vhSubTot+=$val['hSubTot'];
  	  }

  	 @reset($_SESSION['save']);
  	 if ($_POST['hTot'] == $vhSubTot)  {
		 if ($lmProp=='PX')	
		    $lmProp=$_POST['tfProp'];
		     
		 if ($lmKota=='KX')	
		    $lmKota=$_POST['tfKota'];
		    
		  //  $tfSerno =date("YmdHis").generateRandomString(3);
		   // $tfSponsor='UNEEDS00';
		 $vNextJual=$oJual->getNextIDJual().generateRandomString(3);  
		 $vRefTrx=$vNextJual;
		 $db->query('START TRANSACTION;');
		 $tfPrefix=str_replace("+","",$tfPrefix);
		 $tfHP=$tfPrefix.$tfHP;

		 $vSQL="select fserno from tb_skit where fstatus <> 3 and fserno='$tfSerno'";
		 $dbin->query($vSQL);
		 $vRows=$dbin->num_rows();
		 if ($vRows <=0) {
			 echo "<h2<Fraud detected!</h2>";
			 $db->query('ROLLBACK;');
			 exit;
		 }

		 
	  	 if ($oMember->regMember($tfSerno,$tfIdent,$tfNama,$tfTempat,$tfTglLahir,$lmNation,$tfSex,$taAlamat,$lmCountry,$lmProp,$lmKota,$tfPhone,$tfHP,$tfEmail,$tfBank,$tfRek,$tfAtasNama,$tfKotaBank,$tfBranchBank,$lmCountryBank,$tfSwift,$tfSernoUp,$tfSernoSpon,$tfPhoneSpon,$tfEmailSpon,$rbPosition,$hTot,$rbPaket,$tfNPWP,$db,$vUser,$tfAutoShip,$vRefTrx)==1) {  
	  	     $oNetwork->putMember($tfSerno,$db);
			 $vSQL="update tb_skit set ftglused=now(), fstatus='3' where fserno='$tfSerno'";
			 $db->query($vSQL);
	  	    
	  	     
		   $oSystem->jsAlert("Pendaftaran sukses, sponsor=$tfSernoSpon, upline=$tfSernoUp");
		   $oSystem->jsLocation("../memstock/registermem.php");
	  	     
	  	 
	  	 }
	  	 //Penjualan
	   
	    $vBuyer=$_POST['tfSerno'];
	    $vAlamat=$_POST['taAlamat'];
	    $vUser='web';
	   // mail("a_didit_m@yahoo.com","Entri Uneeds FO",print_r($_POST,true)."\n\n\n".print_r($_SESSION['save'],true));
	   /* TIDAK ADA Sistem Stok
	    while (list($key,$val) = each($_SESSION['save'])) {

	        //print_r($val);Masuk trx stok temporary
	    	$vSQL="insert into tb_trxstok_member_temp(fidpenjualan, fidseller, fidmember, falamatkrm, fnostockist, fidproduk, fjumlah, ftanggal, fhargasat, fsubtotal, fsize, fcolor, ftgltrans, fjenis, fjmltrans, fserial, fpin, fmethod, fketerangan, ftglentry, fprocessed, ftglprocessed,fshipcost)";
	    	$vSQL.=" values('$vNextJual','$vUser','$vBuyer','$vAlamat','$vUser','".$val['lmKode']."',".$val['txtJml'].",now(),".$val['hHarga'].",".$val['hSubTot'].",'".$val['lmSize']."','".$val['lmColor']."',now(),'FO',0,'','','mTrans','First Order + Ongkir',now(),'2',now(),$hShipCost)";
	  	 	$db->query($vSQL);


			$vLastBal = $oMember->getStockPos($vUser,$val['lmKode'],$val['lmSize'],$val['lmColor']);
			$vNewBal=$vLastBal - $val['txtJml'];
			$vSQL="insert into tb_mutasi_stok(fidmember, fidproduk, fsize,fcolor,fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate, fref) ";	  	 	
			$vSQL .="values('$vUser','".$val['lmKode']."','".$val['lmSize']."','".$val['lmColor']."','$vBuyer',now(), 'Penjualan FO kepada $vBuyer',0 ,".$val['txtJml'].",$vNewBal,'JFO','1' , '$vUser',now(), '$vNextJual');";//belum selesai
	  	 //	$db->query($vSQL);


	  	 	$vSQL="update tb_stok_position set fbalance=fbalance-".$val['txtJml']." where fidmember='$vUser' and fidproduk='".$val['lmKode']."' and fsize='".$val['lmSize']."' and fcolor='".$val['lmColor']."';";
			$db->query($vSQL);

	    } */
	        
	     if($db->query('COMMIT;')) {
	      //$oSystem->jsAlert("Registrasi sukses! Sponsor = $tfSernoSpon. ");
		    // $oSystem->jsAlert("Registrasi sukses! Sponsor = $tfSernoSpon. Pembelanjaan sebesar ".number_format($_REQUEST['hTot'],0,",",".").". Starter Kit ".number_format($_REQUEST['hKit'],0,",",".")." Total ".number_format($_REQUEST['hTot']+$_REQUEST['hKit'],0,",","."));
		 
	    // $_SESSION['Ref'] = $tfSernoSpon;
	 	// $oSystem->jsLocation("../../index.php?ref=$tfSernoSpon");   
	 //	$oSystem->jsCloseWin();   
	 	 
	 	 $vSubject=$oRules->getSettingByField('fsubjact');
	 	 $vIsi = $oRules->getSettingByField('fisiact');
		 $vIsiSMS = $oRules->getSettingByField('fsmsreg');
		 $vBcc = $oRules->getSettingByField('fmailbcc');
		 $vBcc2 = $oRules->getSettingByField('fmailbcc2');
	 	 $vIsi=str_replace("{MEMID}",$tfSerno,$vIsi);
		 $vIsi=str_replace("{SPONSOR}",$tfSernoSpon,$vIsi);
		 $vIsi=str_replace("{NAMA}",$tfNama,$vIsi);
		 $vLogo='<img src="http://'.$vHost.'/xsystem/images/login-logonew.png" width="100" />';
		 $vIsi=str_replace("{LOGO}",$vLogo,$vIsi);
		 $vIsi=nl2br($vIsi);

	 	 $vIsiSMS=str_replace("{MEMID}",$tfSerno,$vIsiSMS);
		 $vIsiSMS=str_replace("{SPONSOR}",$tfSernoSpon,$vIsiSMS);
		 $vIsiSMS=str_replace("{NAMA}",$tfNama,$vIsiSMS);
	 	 
		 
	 	 //@mail($tfEmail,$vSubject,$vIsi,"From:Admin Nexukses<admin@nexsukses.com>\n");
		 $oSystem->smtpmailer($tfEmail,$vMailFrom,'Spectra',$vSubject,$vIsi,$vBcc,$vBcc2);
		// $oSystem->sendSMS($tfHP, $vIsiSMS);
		 }
   }   else { //Jumlah tak Valid
         $oSystem->jsAlert('Jumlah belanja tidak valid, ulangi dari awal');
		 $oSystem->jsLocation("../memstock/register.php"); 
   }
  } 
//   echo $tfNama;
?>


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
		    if (confirm('Anda yakin melakukan pendaftaran?')==true) {
				var vValid= validPaket();
							
 				if (vValid)
 				   document.frmReg.submit();
				
			} else return false;
			
			
		}
	});
$(document).ready(function(){
 //  alert('ssss');
  // alert($('#hHarga').val());
   $('#tfIdent').attr('maxlength',16);

   $('#caption').html('Register New Member');
   $('#tfTglLahir').datepicker({
                    format: "dd-mm-yyyy"
    }).on('changeDate', function (ev) {
    $(this).datepicker('hide');
    });  


 // $.validator.messages.required = '<span style="color:red;font-weight:normal">This field is required!</span>';
  $('#frmReg input, #frmReg textarea,  #frmReg select, #frmReg checkbox, #frmReg radio').not([type="submit"]).not($("#tfNPWP")).not($("#tEmail")).not($("#tfSwift")).not($("#tfProp")).not($("#tfKota")).not($("#tfKotaBank")).not($("#tfBranchBank")).addClass('required');  
  $('#lmCountry').val('ID');
  $('#lmCountry').trigger('change');
  
  $('#lmCountryBank').val('ID');
  $('#lmCountryBank').trigger('change');
   $('#tfSernoSpon').trigger('blur');
   <? if ($vPosRef !='') {?>
     
    $('#rbPosition').trigger('change');
   <? } ?>

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
      $('#lmProp').html(data);
      $('#loadProp').hide();

   });   
}


function prepareKota(pParam) {
   var vCountry=$('#lmCountry').val();
   if (pParam.value !='PX') {
	   var vURL="../main/mpurpose_ajax.php?op=wil&neg="+vCountry+"&wil=kota&kodewil="+pParam.value;
	   $('#loadKota').show();
	   $('#tfProp').hide();
       $('#tfKota').hide();

	
	   $.get(vURL, function(data) {
	      $('#lmKota').html(data);
	       $('#loadKota').hide();
	
	   });   
   } else {
     $('#tfProp').show();
      $('#tfProp').focus();

     
   }
}

function getOther(pParam) {
   
   if (pParam.value =='KX') {
     $('#tfKota').show();
      $('#tfKota').focus();

     
   } else  $('#tfKota').hide();

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
   var vIDPaket=pParam.value.substring(0,3); 

   $('#statKit').html('&nbsp;<img src="../images/ajax-loader-bar.gif" />');
   $.post(vURL, {serno : pParam.value},function(data) {
      if (vValid.test(data)) {
         $('#statKit').html('<font color="#00f">Serial Number '+pParam.value+' is valid!</font>');
		 if (vPaketB.test(data)) {
			 document.getElementById('rbPaketB').checked=true;
		 } else if (vPaketP.test(data)) {
			document.getElementById('rbPaketP').checked=true; 
		 }
         document.getElementById('btnSubmit').disabled=false;
        // document.getElementById('btAdd').disabled=false;
     } else if (vUsed.test(data)) {
         $('#statKit').html('<font color="#f00">Serial Number '+pParam.value+' already used!</font>');
         document.getElementById('btnSubmit').disabled=true;    
       //  document.getElementById('btAdd').disabled=true;
 
     }  else if (vNotfound.test(data)) {
         $('#statKit').html('<font color="#f00">Serial Number '+pParam.value+' was not found!</font>');
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
   if (pParam.value=='')
      return false;
   else {    
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
         $('#statKitSpon').html('<font color="#f00">Sponsor  Tidak Valid!</font>');
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



function checkKitUp(pParam) {
   if (pParam.value=='')
      return false;
   else {    
   var vCountry=$('#lmCountry').val();
   var vURL="../main/mpurpose_ajax.php?op=kitup";
   var vYes=/yesx/g;
   var vNo=/nox/g;
   var vHas=/hasleg/g;
   var vNotIn=/notinnet/g;
   var vNamaS='';
   var vNama='';
   var vPosition=$('#rbPosition').val();
   var vSpon=$('#tfSernoSpon').val();
   $('#loadNama').show();
   $('#statKitUp').html('&nbsp;<img src="../images/ajax-loader-bar.gif" />');
   
   $.post(vURL, {sernoup : pParam.value, sernospon:vSpon, position: vPosition},function(data) {
	  
     if (vNotIn.test(data) && vNo.test(data)) {
		   
         $('#statKitUp').html('<font color="#f00">Upline Tidak Valid, di luar jaringan sponsor '+vSpon+'!</font>');
		
         document.getElementById('btnSubmit').disabled=true;

     } else if (vNo.test(data) && vHas.test(data)) {
		   
         $('#statKitUp').html('<font color="#f00">Upline Tidak Valid, kaki '+vPosition+' sudah terisi!</font>');
		
         document.getElementById('btnSubmit').disabled=true;

     } else if (vNo.test(data)) {
		
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



$('[id*=tfRek]').rules('add', {

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
     if (parseFloat(age) < 16) {
        $('#lblTL').html('Age must be at least 16');
        document.getElementById('btnSubmit').disabled=true;
		document.getElementById('tfTglLahir').value='';
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
 </script>
	<!--<link rel="stylesheet" href="../css/screen.css"> -->

	
	
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
		<!-- begin #content -->
      
		<div id="content" class="content">
			<ol class="breadcrumb pull-right">
				<h4><li><a href="javascript:;">Member Registration</a></li></h4>
				
			</ol>
        
<div class="row"><!-- 
			<ol class="breadcrumb pull-right">
				<li><a href="javascript:;">Home</a></li>
				<li class="active">Dashboard</li>
			</ol>
            -->
          
</div>

      

<form method="post" id="frmReg" name="frmReg" action="">
	<div class="container" >
    <div class="row" style="width:98%;margin-top:8px;margin-left:-2.6em">
    
     
    
    
        <div class="col-md-6">
                <div class="panel panel-default" id="panelkiri" >
                    <div class="panel-heading" style="background-color:#1D96B2">
                             <div class="panel-title" style="margin-top:-10px">
        						 <label for="exampleInputEmail1" style="font-weight:bold;">
								 Member&amp; Sponsor Data</label>
                               <br style="display: block;margin: -5px 0;" />                                    
                     		</div>
                     </div>
                     <div class="panel-body">
							 <div class="form-group" >

							<div style="" class="divtr col-lg-12">
							<label for="exampleInputEmail1" >Serial Number*  <div align="left" style="display:inline" id="statKit"></div></label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control" id="tfSerno" name="tfSerno" placeholder="Card/Serial No*" onBlur="checkKit(this)" onKeyUp="setUpper(this)" >

                                    </div>                            
                            
                            </div>
                            <input type="hidden" name="hPost" id="hPost" value="1" />
                            <div style="" class=" divtr col-lg-12">
							<label for="exampleInputEmail1">Sponsor* <div align="left" style="display:inline" id="statKitSpon"></div></label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>
                                    <input readonly type="text" class="form-control" id="tfSernoSpon" name="tfSernoSpon" placeholder="Masukan ID/Serial Sponsor*" value="<?=$_SESSION['LoginUser']?>" <?=$vRead?> onBlur="checkKitSpon(this)" onKeyUp="setUpper(this)"  >
                                    
                                    
                                    </div>                            
                            
                            </div>   
                            

                            <div style="" class=" divtr col-lg-12">
							<label for="tfSernoSponName">Sponsor Name* </label>
										<div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>                                    
                                      <input type="text" class="form-control" id="tfSernoSponName" name="tfSernoSponName" placeholder="Sponsor*" value="[Auto]" readonly  >
                                   
                                    </div>                            
                            
                            </div>   

 <div class="col-lg-4 col-md-12 col-xs-12  col-sm-12 divtr" style="z-index:10">
							                                <label for="exampleInputEmail1" ><span style="font-weight:bold">Placement*</span></label>
							                                <select name="rbPosition" id="rbPosition" class="form-control" onChange="if (this.value !='' && document.getElementById('tfSernoUp').value !='') checkKitUp(document.getElementById('tfSernoUp'));">
							                                <option value="">--Choose Position--</option>
							                                <option value="L" <? if($vPosRef=='L') echo 'selected';?>>Left / Kiri</option>
							                                <option value="R" <? if($vPosRef=='R') echo 'selected';?>>Right Kanan</option>
							                                </select>
</div>

                            <div style="" class=" divtr col-lg-8">
							<label for="exampleInputEmail1">Upline* <div align="left" style="display:inline" id="statKitUp"></div></label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>
                                    <input type="text" value="<?=trim($vUp);?>" <? if (trim($vUp) !='') echo 'readonly';?> class="form-control" id="tfSernoUp" name="tfSernoUp" placeholder="Masukan ID/Serial Upline*"  <?=$vRead?> onBlur="if (document.getElementById('rbPosition').value=='') {alert('Pilih posisi kiri/kanan!');return false;} ;checkKitUp(this)" onKeyUp="setUpper(this)"  >
                                    
                                    </div>                            
                            
                            </div>   
                            

                            <div style="" class=" divtr col-lg-12">
							<label for="tfSernoSponName">Upline Name* </label>
										<div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>                                    
                                      <input type="text" class="form-control" id="tfSernoUpName" name="tfSernoUpName" placeholder="[Auto]" value="" readonly  >
                                   
                                    </div>                            
                            
                            </div>   


                            <!--
                            <div style="" class="divtr hide">
							<label for="exampleInputEmail1">Username* </label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control" id="tfSerno" name="tfSerno" placeholder="Username*" onBlur="checkKit(this)"  >
                                    <input type="hidden" name="hPost" id="hPost" value="1" />
                                    </div>                            
                            
                            </div>   -->
                            <div class="divtr col-lg-6" >
                           
                                <label   for="tfNama">
								Full Name*</label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" id="tfNama" name="tfNama" placeholder="Full Name*" onBlur="$('#tfAtasNama').val(this.value)" onKeyUp="$('#tfAtasNama').val(this.value)">
                                </div>
                            </div>
                          
                             <div class="divtr col-lg-6">
                                    <label for="exampleInputEmail1">ID Card No*</label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-credit-card"></i></span>
                                    	<input type="number" maxlength="16" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control" id="tfIdent" name="tfIdent" onBlur="checkMultiIdent(this.value)" placeholder="ID Card No.*">
                                      </div>
                             </div>  
                             </div>
                               
                            <div class="form-group">
                                
                               <div class="divtr col-lg-6">
                                <label for="exampleInputEmail1" ><span style="font-weight:">Place of Birth*</span></label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-map-marker"></i></span>
                                <input type="text" class="form-control" id="tfTempat" name="tfTempat"  >
                                </div>
                              </div>
                                                                
                                    <div class="form-group">        
                                  <div class="divtr col-lg-6">
                                     <label for="exampleInputEmail1">Date of Birth*</label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-calendar"></i></span>
                                        <input onBlur="//checkAge(this.value)" id="tfTglLahir" name="tfTglLahir" class="form-control " placholder="DD-MM-YYYY"   type="text" >
                                        </div>
                                        

                                  </div>
                                  </div>
                                
                            </div>
                            <div class="form-group" >                      
                               <div class=" divtr col-lg-6 col-md-6" >
                                   <label for="exampleInputEmail1" >
								   <span style="font-weight:bold">Nationality*</span></label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-globe"></i></span>
                                <select class="form-control m-bot15" id="lmNation" name="lmNation">
                                <option  value="" selected="selected" >--Pilih / Choose--</option>
								<? 
								    $vSQL="select * from m_country order by fcountry_name";
								    $db->query($vSQL);
								    while ($db->next_record()) {
								?>                               
								 <option value="<?=$db->f('fcountry_code')?>" <? if ($db->f('fcountry_code')=='ID') echo ' selected';?> ><?=$db->f('fcountry_name')?></option>
								 <? } ?>
                            </select>

                                </div>
                              </div>
                                                                
                                  <div class="col-md-5 col-lg-6 divtr" >
                                      <label for="exampleInputEmail1">
									  <span style="font-weight:bold">&nbsp;Sex*</span></label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>
                            <select class="form-control m-bot15" id="tfSex" name="tfSex">
                                <option value="" selected="selected">---Pilih / Choose---</option>
                                <option value="F">Perempuan / Female</option>
                                <option value="M">Laki-laki / Male</option>
                                <!-- <option value="O">Lainnya / Other </option> -->
                            </select>
                           </div>

                          </div>
                                
                       </div>
                          <div class="form-group" >     
                        <div class="divtr col-lg-12">
                            <label for="exampleInputEmail1">Full Address along with Postal Code*</label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-envelope"></i></span>
                                <textarea id="taAlamat" name="taAlamat" class="form-control custom-control" rows="3" style="resize:none"></textarea>
                          <!--  <input type="text" class="form-control" id="tfNama" placeholder="Full Address along with Postal Code*"> -->
                            </div>
                        </div>
                        </div>

  					 <div class="form-group"  id="kotaprovneg">                      
                               
                                                                

   							<div class="form-group" > 
                               <div class="col-lg-4 col-md-4 divtr" >
                                <label for="exampleInputEmail1" ><span style="font-weight:bold">Country*</span></label>
                                                                 <!-- <input type="text" class="form-control" id="tfNama" placeholder="Country*"> -->
                                <select class="form-control m-bot15" id="lmCountry" name="lmCountry" onChange="prepareProp(this)">
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
                                <label for="exampleInputEmail1" ><span style="font-weight:bold">Province*</span></label>
                                                                <select class="form-control m-bot15" id="lmProp" name="lmProp" onChange="prepareKota(this)">
                                <option  value="" selected="selected" >--Pilih / Choose--</option>
                                <option  value="PX"  >Other Province</option>

								</select>
								<input style="display:none" type="text" class="form-control" id="tfProp" name="tfProp" placeholder="Other Province">
								
                                </div>
                            
                              
     						 <div class="col-lg-4 col-md-4 divtr" id="divKota">
                                <img id="loadKota"  align="absmiddle" src="../images/ajax-loader.gif" style="position:absolute;z-index:2;margin-left:45px;margin-top:24px;opacity: 0.5;display:none" />
                                <label for="exampleInputEmail1" ><span style="font-weight:bold">City*</span></label>
                                 
                                <select class="form-control m-bot15" id="lmKota" name="lmKota" onChange="getOther(this)">
                                <option  value="" selected="selected" >--Pilih / Choose--</option>
                                <option  value="KX"  >Other City</option>
								</select>
								<input style="display:none" type="text" class="form-control" id="tfKota" name="tfKota" placeholder="Other City">


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
                                                                
   							                    
                               <div class="col-lg-6 col-md-6 divtr" >
                                   <label for="exampleInputEmail1" >
								   <span style="font-weight:bold">&nbsp;Phone No.*</span></label>
                                   <div class="form-inline">
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-mobile"></i></span>
                                
                                <input type="text" class="form-control" id="tfPrefix" name="tfPrefix" value="+62" style="max-width:50px">
                                
                                </div>
                                
                                
                                <input type="number" class="form-control" id="tfHP" name="tfHP" placeholder="Phone No*"  style="max-width:130px">
                                </div>
                              </div>
                              
 							<div class=" col-lg-6 col-md-6 divtr" >
                                <label for="exampleInputEmail1"><b>Email</b></label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-envelope"></i></span>
                                <input type="email" class="form-control" id="tfEmail" name="tfEmail" placeholder="Email Address">
                                </div>
                            </div>                              
                              
						</div>
    					 <!--<div class="divtr" >
                                <label for="exampleInputEmail1"><div class="divtr"></div>Alamat Email</label>
                                 <div class="iconic-input">
                                    <i class="fa fa-envelope"></i>
                                <input type="email" class="form-control" id="tfEmail" name="tfEmail" placeholder="Email Address">
                                </div>
                            </div> -->
                               								<div class="row" style="margin-left:3px">
                                                            
                                                            <div class=" col-lg-6 col-md-6 divtr" ><label for="exampleInputEmail1" ><span style="font-weight:bold">Paket*</span></label>
                                                             </div>
                                                            </div>
                                                            
<!--
							                               <div class="col-lg-2 col-md-2 col-sm-4 divtr" style="display:none" >
							                                <label for="exampleInputEmail1" ><span style="font-weight:bold">&nbsp;</span></label>
							                                <input type="radio" class="form-control" id="UFC" name="rbPaket" value="F;<?=$vHrgFirst?>" > 
															   First Class</div> -->
							                              

                     </div> <!--Panel Body-->
                </div> <!--Col-md-6 kiri-->
				     
        </div>
        <div class="col-md-6" id="kolomkanan">
                    <div class="panel panel-default" id="panelkanan">
                    <div class="panel-heading" style="background-color:#1D96B2">
                             <div class="panel-title" style="margin-top:-10px">
        						<label for="exampleInputEmail1" style="font-weight:bold;">
								 Bank Account</label>
                               <br style="display: block;margin: -5px 0;" />                                    
                     		</div>
                     </div>


                     
                     <div class="panel-body">
						<div class="form-group" style="margin-left:-15px" id="kotacabnegbank"> 
							<div class="col-lg-6 col-md-6 divtr" >
                                <label for="exampleInputEmail1" >
								<span style="font-weight:normal">Bank Country*</span></label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-globe"></i></span>
                                <!--<input type="text" class="form-control" id="tfCountryBank" name="tfCountryBank" placeholder="Bank Country*"> -->
                                <select class="form-control m-bot15" id="lmCountryBank" name="lmCountryBank" onChange="setFilterBank(this.value)">
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
                              </div>                     
                     
                     
                         <div class="col-lg-6 col-md-6 divtr">
                            <img id="loadBank"  align="absmiddle" src="../images/ajax-loader.gif" style="position:absolute;z-index:2;margin-left:45px;margin-top:24px;opacity: 0.5;display:none" />
                             <label for="exampleInputEmail1">Bank Name*</label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-building-o"></i></span>
                                  <select  class="form-control m-bot15" id="tfBank" name="tfBank"  onchange="setMaxLenRek()">
                                <option  value="" selected="selected" >--Pilih / Choose--</option>
								<? 
								    $vSQL="select * from m_bank where faktif='1' order by fnamabank";
								    $db->query($vSQL);
								    while ($db->next_record()) {
								?>                               
								 <option  value="<?=$db->f('fkodebank').';'.$db->f('fmaxdigit')?>"  ><?=$db->f('fnamabank')?></option>
								 <? } ?>
                            </select>

                                   </div>
                         </div>   
                         </div>    

                         <div class="divtr">
                            <label for="exampleInputEmail1">Bank Account No*</label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-building-o"></i></span>
                                                <input type="number" oninput="maxLengthCheck(this);" class="form-control" id="tfRek" name="tfRek" placeholder="Bank Account No*" readonly="readonly">
                                   </div>
                         </div>       
          				<div class="divtr">
                                    <label for="exampleInputEmail1">Bank Account Name*</label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>
                                    	<input  type="text" class="form-control" id="tfAtasNama" name="tfAtasNama" placeholder="Bank Account Name*">
                                      </div>
                             </div>  

			 <div class="form-group" style="margin-left:-15px" id="kotacabnegbank">                      
                               <div class="col-lg-6 col-md-6 divtr" >
                                   <label for="exampleInputEmail1" >
								   <span style="font-weight:bold">Bank City</span></label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-bars"></i></span>
                                <input type="text" class="form-control" id="tfKotaBank" name="tfKotaBank" placeholder="Bank City">
                                </div>
                              </div>
                                                                
   							                    
                               <div class="col-lg-6 col-md-6 divtr" >
                                <label for="exampleInputEmail1" ><span style="font-weight:bold">Bank State/Branch</span></label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-bars"></i></span>
                                <input type="text" class="form-control" id="tfBranchBank" name="tfBranchBank" placeholder="Bank State/Branch">
                                </div>
                              </div>

   							
                               
						
             				<div class="col-lg-6 col-md-6 divtr">
                                    <label for="exampleInputEmail1"><div class="divtr"></div><span style="font-weight:bold">Bank Swift Code</span></label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-bars"></i></span>
                                    	<input type="text" class="form-control" id="tfSwift" name="tfSwift" placeholder="Outside Indonesia Only">
                                      </div>
                             </div>  

             				<div class="col-lg-6 col-md-6 divtr">
                                    <label for="exampleInputEmail1"><div class="divtr"></div><b>NPWP</b></label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-bars"></i></span>
                                    	<input type="number" class="form-control" id="tfNPWP" name="tfNPWP" placeholder="Taxpayer Registration Number">
                                      </div>
                             </div>  
                          
                  


													 
                          </div>   <!--Panel Body>

                            </div> <!--form-group -->
                            </div>  




                     </div> <!--Panel Body -->
                     
                     							<!-- <div class="divtr">
                            <!-- Panel Sponsor -->

			                     <!-- <div class="col-lg-5 col-md-4 col-xs-3 divtr hide" >
							                                <label for="exampleInputEmail1" ><span style="font-weight:bold">Package*</span></label>
							                                     
							                               
													
							                                <select name="rbPaket" id="rbPaket" class="form-control" onChange="setPaket(this.value)">
							                                <option value="">--Reg. Package--</option>
							                                <option value="S">Silver</option>
							                                <option value="G">Gold</option>
							                                <option value="P">Platinum</option>
							                                </select>
							                                </div> -->

					                               										                               
	<!--	<div class="col-lg-5 col-md-3 col-sm-4 divtr hide" >
			<label for="Automaintenance" ><span style="font-weight:bold">Automaintenance Item(s)*</span></label>		                               
			<select  class="form-control m-bot15" id="tfAutoShip" name="tfAutoShip"  >
                                <option  value="" selected="selected" >--Choose--</option>
								<? 
								    $vSQL="select * from m_product where faktif='1' order by fidsys";
								    $db->query($vSQL);
								    while ($db->next_record()) {
								?>                               
								 <option  value="<?=$db->f('fidproduk')?>"  ><?=$db->f('fnamaproduk')?></option>
								 <? } ?>
                            </select>
                            </div>
-->
						 </div>     
			

                </div> <!--Kolom Kanan -->
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
								<?
								    $vSQL="select distinct fidproduk, fsize, fidcolor, fnamaproduk, fhargajual1, fsatuan from  m_product   where  faktif='1' order by fidproduk";
								    $db->query($vSQL);
								    $vColorText="";
								    while($db->next_record()) {
								       $vCode=$db->f('fidproduk');
								       $vSize=$db->f('fsize');
								       $vColor = $db->f('fidcolor');
								       $vColName=$oProduct->getColor($vColor);
								       $vJmlItem = $db->f('fsatuan');

								       
								       $vNama=$db->f('fnamaproduk');
								       //.";$vSize;$vColor/$vColName";
								       $vHarga=number_format($db->f('fhargajual1'),0,"","");
								        $vQoh=number_format($db->f('fbalance'),0);

								      								       
								?>
								<option colors="<?=$vColor?>" qoh="<?=$vQoh?>" jmlitem="<?=$vJmlItem?>"   price="<?=$vHarga?>" sizes="<?=$vSize?>" value="<?=$vCode?>" selected="selected"><?=$vCode.";".$vNama?></option>

								<? } ?>
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

										<input id="cbTC" name="cbTC" type="checkbox"  ><a style="cursor:pointer;color:blue;text-decoration:none" href="#" onClick="openTerm()">&nbsp;Data tersebut diatas adalah benar</a><br><br>
										<input type="hidden" name="hKit" id="hKit" value="<?=$vKit?>" />
										<input type="hidden" name="hTotal" id="hTotal" value="" />
                                        <button disabled="disabled" id="btnSubmit" type="submit" class="btn btn-primary"  onClick="submitForm(this)">Submit</button> <div id="divLoad" style="display:inline"></div>
                                        
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
  <!-- /.content-wrapper -->
 <? include_once("../framework/member_theme.blade.php")?>	      
        <!-- end theme-panel -->
		
		<!-- begin scroll to top btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
	</div>
	<!-- end page container -->
	
<? include_once("../framework/member_bottomjs.blade.php")?>	
	<script>
		$(document).ready(function() {
			App.init();
			Dashboard.init();
		});
	</script>

<? include_once("../framework/member_footside.blade.php") ; ?>