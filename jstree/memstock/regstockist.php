<? include_once("../framework/member_headside.blade.php");
include_once("../classes/memberclass.php");
include_once("../classes/networkclass.php");
include_once("../classes/systemclass.php");
?>
<?


  print_r($_POST);
  
 
 // echo "sssssssssssnnnnn snasNKJSjhkhkjdaskdga skdahsdkahsdk ahdkhaskdasdh ";
   while (list($key,$val)=each($_POST)) {
      $$key = $val;
   }
    $vSQL="select * from m_anggota where fidmember='$vUser'";
   $db->query($vSQL);
   $db->next_record();
   $vKotaID=$db->f('fkota');
   $vPropID=$db->f('fpropinsi');
   
   $vHrgEco = $oRules->getSettingByField('fhrgeco');
   $vHrgBus = $oRules->getSettingByField('fhrgbus');
   $vHrgFirst = $oRules->getSettingByField('fhrgfirst');
   $vMailFrom=$oRules->getSettingByField('fmailadmin');
   $vUserHO = $oRules->getSettingByField('fuserho');
   if ($vPriv=='member')
      $vSeller = $vUserHO;
   else	  
      $vSeller = $vUser;
	  
	  
   $vTreshUp = $oRules->getSettingByField('ftreshup');
   $vTreshMaster = $oRules->getSettingByField('ftreshmaster');
   $vByyAdmin = $oRules->getSettingByField('fbyyadmin');
   $vSalProd = $oMember->getMemField('fsaldowprod',$vUser);
  //$vSalProd = 5000000;

       
   if ($_POST['hPost'] != '1') {
      $_SESSION['save']='';
      $_SESSION['del']='';
    
   } else {
    /*$vNextJual=$oJual->getNextIDJual();
    $vBuyer=$_POST['tfSernoSpon'];
    $vPaket=$oMember->getMemField("fpaket",$vBuyer);
    $vAlamat=$oMember->getMemField('falamat',$vBuyer);*/
   // @mail("a_didit_m@yahoo.com","Entri RO Spectra by $vUser",print_r($_POST,true)."\n\n\n".print_r($_SESSION['save'],true));
   
   
    $oSystem->smtpmailer('japri_s@yahoo.com',$vMailFrom,'Spectra',"Reg Stockist by $vUser",print_r($_POST,true)."\n\n\n".print_r($_SESSION['save'],true),'','',false);
	
	$db->query('START TRANSACTION;');
    $vTotItem=0;
	$tfDesc = $oSystem->strEscape($tfDesc);
	$tfSernoSpon = $oSystem->strEscape($tfSernoSpon);
	if ($lmType=='1')
	   $lmDesc='Mobile Stockist';
	else if ($lmType=='2')   
	   $lmDesc='Stockist';
	else if ($lmType=='3')    
		$lmDesc='Master Stockist';
	
	$vSQL = "select * from tb_stockist_temp where fidmember='$tfSerno' and ftype='{$lmType}'";
	$db->query($vSQL);
	$db->next_record();
	if ($db->num_rows() > 0) {
		$oSystem->jsAlert("Permintaan pendaftaran Stockist ditolak karena sudah pernah didaftarkan sebagai $lmDesc!");
		$oSystem->jsLocation("../memstock/regstockist.php");
		exit;
	}
	   
	$vTotal=$_POST['hTotal'];

    	 $vSQL="INSERT INTO tb_stockist_temp(fidmember, fidsponsor,ftype, fdesc, faktif, ftgldaftar) ";
    	 $vSQL.=" values('$tfSerno','$tfSernoSpon','$lmType','{$tfDesc}','0',now())";
  	
  	 	$db->query($vSQL);

    
    $db->query('COMMIT;');
	
	$oSystem->jsAlert("Permintaan pendaftaran $lmDesc sukses, tunggu approval dari Admin!");

    $oSystem->jsLocation("../memstock/regstockist.php");
   }   
 
//   echo $tfNama;
?>

<body class="sticky-header">
<style type="text/css">

.divtr {
	margin-top:10px;
	
	}
.divindent {
	margin-left:1em;
	
	}	
.divtrsmall {
	margin-top:-10px;
	
}

}
.bold {
	font-weight:bold;
	
}

.error {
	color:red;
	
}

@media (max-width: 600px) {
  .divtr {
	margin-top:0px;
	
	}

.divtrsmall {
	margin-top:-15px;
	
}

  } 


	</style>
<script src="../js/jquery.validate.min.js"></script>
<script language="javascript">

 
function prepareProp(pParam) {
   
   var vURL="../main/mpurpose_ajax.php?op=wil&wil=prop&kodewil="+pParam.value;
 // $('#divProp').css({'background':'transparent url("../images/ajax-loader.gif")','background-repeat': 'no-repeat','background-position': 'center','z-index' : '10'});
  $('#loadProp').show();
  $.get(vURL, function(data) {
      $('#lmProp').html(data);
      $('#loadProp').hide();
	  $('#lmProp').val('<?=$vPropID?>');
	  $('#lmProp').trigger('change');

   });   
}


function prepareKota(pParam) {
   var vCountry=$('#lmCountry').val();
   var vURL="../main/mpurpose_ajax.php?op=wil&neg="+vCountry+"&wil=kota&kodewil="+pParam.value;
   $('#loadKota').show();

   $.get(vURL, function(data) {
      $('#lmKota').html(data);
       $('#loadKota').hide();
 		 $('#lmKota').val('<?=$vKotaID?>');
		 $('#lmKota').prop('disabled', true);
		  $('#lmProp').prop('disabled', true);

   });   
}

function validRO() {
	//alert($('#hTot').val());
	if(typeof $('#hTot').val() !== "undefined") {
       return true;
	} else { 
	   alert('Anda belum melakukan pembelanjaan!');
	   return false;
	} 
}

	$.validator.setDefaults({
	    
		submitHandler: function() {
		     var vSalProd=$('#hSalProd').val();
			// alert($('#hTotal').val());
			if (parseFloat($('#hTotal').val()) > parseFloat(vSalProd) && $('#lmMethod').val().trim()=='wpr') {
			    alert('Saldo Wallet Product Anda tidak mencukupi untuk pembelanjaan ini, silakan ganti metode pembayaran!');	
				return false;
			}

 /*var vPaket=document.getElementById('rbPaket').value;
		    vPaket = vPaket.split(';');
		    vPaket=vPaket[1];
		    alert(vPaket);
		    return false; */
			var vType= $('#lmType option:selected').text();
		    if (confirm('Anda yakin melakukan Registrasi '+vType+'?')==true) {
				//var vValid= validRO();
							
 				//if (vValid)
 				   document.frmReg.submit();
				
			} else return false;
			
			
		}
	});
$(document).ready(function(){
 //  alert('ssss');
  // alert($('#hHarga').val());
   $('#caption').html('Entry Repeat Order <? if ($_SESSION['Priv']=='administrator') echo ' by Admin'; ?>');
   $('#tfTglLahir').datepicker({
                    format: "dd-mm-yyyy"
    });  

   
 // $.validator.messages.required = '<span style="color:red;font-weight:normal">This field is required!</span>';
  $('#frmReg input, #frmReg textarea,  #frmReg select, #frmReg checkbox, #frmReg radio').not([type="submit"]).not($("#tfNPWP")).not($("#tEmail")).not($("#tfSwift")).not($("#tfEmailSpon")).not($("#tfDesc")).addClass('required');  
  $('#lmCountry').val('ID');
  $('#lmCountry').trigger('change');
   prepareProp(document.getElementById('lmCountry'));

		$("#frmReg").validate({
			rules: {
				tfTempat: "required",
				tfNama: { 
				    required : false,
				      
				},
				tfIdent: {
					required: true,
					minlength: 9
				},
				tfEmail: {
					required: false,
					email: true
				},
				
				tfRek :{
				    required : true,
				},
				
				tfEmailSpon: {
					required: false,
					email: false
				},
			
				
				
				
			},
			messages: {
			   // tfIdent: '<span style="color:red;font-weight:normal">This field is required with minimum 9 character length!</span>',
			   // tfRek : '<span style="color:red;font-weight:normal">This field is required with minimum 10 character length!</span>',
			},
			
			 errorPlacement: function(error,element){ 
                            error.insertAfter(element); 
                          //  alert(error.html()); 
                       },
	               showErrors: function(errorMap, errorList){ 
                              this.defaultShowErrors();
                       }
		});  

    $('#tfSernoSpon').trigger('blur');
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
      <? if ($_SESSION['Priv'] == 'administrator')  {?>
	  vNama=vNama[1];
	  <? } else {?>
	   vNama=vNama[1];
	  <? } ?>
      
      var vHarga=  $(pParam).find('option:selected').attr("price");     
      var vItemSat=  $(pParam).find('option:selected').attr("jmlitem"); 
      $('#thNama').html(vNama);
      $('#thHarga').html(vHarga);
       $('#hHarga').val(vHarga);
        $('#hItemSat').val(vItemSat);

      $('#thHarga').priceFormat({     
                    prefix: ' ',
                    centsSeparator: ',',
                    thousandsSeparator: '.',
                    limit: 15,
                    centsLimit: 0
                });

       var vQoh=  $(pParam).find('option:selected').attr("qoh"); 
       $('#thQoh').html(vQoh);
       $('#hQoh').val(100000000);

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
		    
		     if (parseInt(vSize.length) == 1)
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

     var vQoh = $('#hQoh').val();
     if ( parseFloat(vJum) > parseFloat(vQoh)) {
        alert('Jumlah tidak boleh melebihi stok tersedia (QOH)!');
        $('#btSaveRow').hide();
        return false;
     } else  $('#btSaveRow').show(); 
     
     var vSubTot = parseFloat(vJum) * parseFloat(vHrg);
     var vJmlItem= parseFloat(vJum) * parseFloat(vItemSat);

   //  alert(vJum);alert(vHrg );alert(vSubTot );
     $('#thSubTot').html(vSubTot);
     $('#hSubTot').val(vSubTot);
     
      $('#thSubTot').priceFormat({     
                    prefix: ' ',
                    centsSeparator: ',',
                    thousandsSeparator: '.',
                    limit: 15,
                    centsLimit: 0
                });
     
       $('#thJmlItem').html(vJmlItem);

	$('#hJmlItem').val(vJmlItem);
   
 
}  

function doSaveRow() {
   var vURL = "register_purc_ajax.php";
   if ($('#lmKode').val()=='' ) {
      alert('Pilih kode produk!');
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



		 var xTot=	parseFloat($('#hTot').val());
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
		 $('#divCurr').hide();
		 $('#lmCurr option:first-child').attr('selected', 'selected');
		 //batasan RO

         var vYMonth='<?=date("Ym")?>';
         var pParam = $('#tfSernoSpon').val();
         $.get('../main/mpurpose_ajax.php?op=checkmultiro&user='+pParam+'&ymonth='+vYMonth,function(data){
             var vTotalRO=parseFloat(data.trim()) + parseFloat($('#hTotJum').val());
		
            // alert(vTotalRO);
             if (false) {
                 alert('RO for this member ('+pParam+') was exceeded!');
				 var vCount = 0;
				 for(i=0;i<50;i++) {
				 	if (document.getElementById('btDelItem'+i))
					   vCount+=1;
				 }
				  if (vCount > 0) vCount-=1; 
				  $('#btDelItem'+vCount).trigger('click');
                 document.getElementById('btnSubmit').disabled=true;
             
             } else document.getElementById('btnSubmit').disabled=false;

         });

		 
      
   });
}
 

function doDel(pNo, pKode,pSize,pColor,pNama,pJml,pHarga,pSubTot) {
//alert(pNo +':'+ pKode+':'+pSize+':'+pColor+':'+pNama+':'+pJml+':'+pHarga+':'+pSubTot);  
 var vURL = "register_purc_ajax.php";
   $('#tdLoad').html('<img src="../images/ajax-loader.gif" />');
  
 $.post(vURL,{ delNo : pNo, delKode: pKode, delSize: pSize, delColor : pColor, delNama : pNama, delJml : pJml, delHarga : pHarga, delSubTot : pSubTot, op : 'del' }, function(data) {
      $('#tbPurc').html(data);
      $('#tdLoad').empty();

		 var xTot=	parseFloat($('#hTot').val());
		 $('#hTotal').val(xTot);
		 $('#totalpurc').html(xTot);  
		      $('#totalpurc').priceFormat({     
		                    prefix: ' ',
		                    centsSeparator: ',',
		                    thousandsSeparator: '.',
		                    limit: 15,
		                    centsLimit: 0
		       });
      
   });
}
  
 



function checkKitSpon(pParam) {
   if (pParam.value=='')
      return false;
   else {    
   var vCountry=$('#lmCountry').val();
   var vURL="../main/mpurpose_ajax.php?op=kitsponro";
   var vYes=/yesx/g;
   var vNo=/nox/g;
   var vNamaS='';
   var vNama='';
   $('#loadNama').show();
   $('#statKitSpon').html('&nbsp;<img src="../images/ajax-loader-bar.gif" />');
   $.post(vURL, {sernospon : pParam.value},function(data) {
      if (vNo.test(data)) {
         var dataX=data.split('|');
         if (dataX[1]=='nomem')
            $('#statKitSpon').html('<font color="#f00">Sponsor Not Valid!</font>');
         else (dataX[1]=='nonet')   
             $('#statKitSpon').html('<font color="#f00">Sponsor Not Valid due not in Agent network (cross-line)!</font>');

         document.getElementById('btnSubmit').disabled=true;

     } else if (vYes.test(data)) {
		   vNamaS=data.split('|');
		   vNama=vNamaS[1];
		   vPhone=vNamaS[2];
		   vEmail=vNamaS[3];
		   vAlamat=vNamaS[4];
         
         $('#statKitSpon').html('<font color="#00f">Sponsor valid!</font>');
         $('#tfSponsor').val(vNama);
         $('#tfPhoneSpon').val(vPhone);
         $('#tfEmailSpon').val(vEmail);
         $('#tfAlamat').val(vAlamat);

      //  alert(vPhone+':'+vEmail);
      


         document.getElementById('btnSubmit').disabled=false;     
        // document.getElementById('btAdd').disabled=false; 
         var vYMonth='<?=date("Ym")?>';
         $.get('../main/mpurpose_ajax.php?op=checkmultiro&user='+pParam.value+'&ymonth='+vYMonth,function(data){
             if(parseFloat(data.trim()) >=100000000000 ) {
                alert('This member already have maximum RO in this month, please choose other member!');
		         document.getElementById('btnSubmit').disabled=true;     
		     //    document.getElementById('btAdd').disabled=true;               
             }
         });
     }    
   $('#loadNama').hide();  
   });   

  }
}


function checkKit(pParam) {
   if (pParam.value=='')
      return false;
   else {    
   var vCountry=$('#lmCountry').val();
   var vURL="../main/mpurpose_ajax.php?op=kitstockist";
   var vYes=/yesx/g;
   var vNo=/nox/g;
   var vNamaS='';
   var vNama='';
   $('#loadNama').show();
   
  if ($('#tfSernoSpon').val() == $('#tfSerno').val()) {
            $('#statKitMem').html('<font color="#f00">Member Not Valid!</font>');  
			 document.getElementById('btnSubmit').disabled=true;
			  $('#loadNama').hide();  
			 return false;
  }
   
   $('#statKitMem').html('&nbsp;<img src="../images/ajax-loader-bar.gif" />');
   $.post(vURL, {serno : pParam.value},function(data) {
	   
      if (vNo.test(data)) {
         var dataX=data.split('|');
		// alert(dataX[1]);
         if (dataX[0]=='nox')
            $('#statKitMem').html('<font color="#f00">Member Not Valid!</font>');
         

         document.getElementById('btnSubmit').disabled=true;

     } else if (vYes.test(data)) {
		   vNamaS=data.split('|');
		   vNama=vNamaS[1];
		   vPhone=vNamaS[2];
		   vEmail=vNamaS[3];
		   vAlamat=vNamaS[4];
		    vStockist=vNamaS[5];
         if (vNamaS[5] !=0) {
			 document.getElementById('btnSubmit').disabled=true;
			 $('#statKitMem').html('<font color="#f00">Member tidak valid, karena sudah menjadi Stockist!</font>');
			 $('#loadNama').hide(); 
		     return false;
		 }
         $('#statKitMem').html('<font color="#00f">Member valid!</font>');
         $('#tfMember').val(vNama);
         $('#tfPhoneSpon').val(vPhone);
         $('#tfEmailSpon').val(vEmail);
         $('#tfAlamat').val(vAlamat);

      //  alert(vPhone+':'+vEmail);
      


         document.getElementById('btnSubmit').disabled=false;     
        // document.getElementById('btAdd').disabled=false; 
         var vYMonth='<?=date("Ym")?>';
         $.get('../main/mpurpose_ajax.php?op=checkmultiro&user='+pParam.value+'&ymonth='+vYMonth,function(data){
             if(parseFloat(data.trim()) >=100000000000 ) {
                alert('This member already have maximum RO in this month, please choose other member!');
		         document.getElementById('btnSubmit').disabled=true;     
		     //    document.getElementById('btAdd').disabled=true;               
             }
         });
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

function setCurr(pParam,pNom) {
    var vURL='../main/mpurpose_ajax.php?op=currconvert&from=IDR&to='+pParam+'&nom='+pNom;
	 $.get(vURL, function(data) {
	  var vConvert = data ;
      $('#samaconvert').html(' = ');
      $('#convert').empty().html(vConvert);
      $('#currconvert').empty().html(pParam);
   /*   $('#convert').priceFormat({     
                    prefix: ' ',
                    centsSeparator: ',',
                    thousandsSeparator: '.',
                    limit: 15,
                    centsLimit: 0
       });*/
      

   });   

}


 </script>
<!-- 	<link rel="stylesheet" href="../css/screen.css"> -->

	
	
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
		<div><label><h3>Stockist Registration Form</h3></label></div> 


<form method="post" id="frmReg" name="frmReg" action="<?=$_SERVER['PHP_SELF']?>">
	<div class="container">
    <div class="row" style="width:98%;margin-top:8px">
    <input type="hidden" id="hPost" name="hPost" value="1" />
    
     
    
    
        <div class="col-md-12">
               				<!--Panel Body -->
                     
                     							<!-- <div class="divtr">
                            <!-- Panel Sponsor -->

			                    <div class="panel panel-default" id="panelkanan">
									<div class="panel-heading toska" style="background-color:#1D96B2">
										<div class="panel-title ">
											<label for="exampleInputEmail1" style="font-weight:bold;">
											Member Data</label></div>
									</div>
									<div class="panel-body">
<div class="">
											<label for="exampleInputEmail1">ID 
											Sponsor* 
											<div align="left" style="display:inline" id="statKitSpon">
											</div>
											</label>
											 <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>
												<input readonly value="<?=$vUser?>" type="text" class="form-control" id="tfSernoSpon" name="tfSernoSpon" placeholder="Member ID*" onBlur="checkKitSpon(this)" onKeyUp="setUpper(this)">
											</div>
										</div>
                                                                            
                                    
										<div class="">
											<label for="exampleInputEmail1">ID 
											Member* 
											<div align="left" style="display:inline" id="statKitMem">
											</div>
											</label>
											 <div class="input-group" >
                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>
												<input  value="" type="text" class="form-control" id="tfSerno" name="tfSerno" placeholder="Member ID*" onBlur="checkKit(this)" onKeyUp="setUpper(this)">
											</div>
										</div>
										<div class="col-lg-6 col-md-6 divtr">
											<img id="loadNama"  align="absmiddle" src="../images/ajax-loader.gif" style="position:absolute;z-index:2;margin-left:45px;margin-top:24px;opacity: 0.5;display:none" />
											<label for="exampleInputEmail1">Nama 
											Sponsor*</label>
											<div class="input-group" style="margin-left:-15px">
                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>
												<input readonly type="text" class="form-control" id="tfSponsor" name="tfSponsor" placeholder="Sponsor Name*">
											</div>
										</div>
<div class="col-lg-6 col-md-6 divtr" style="margin-left:-7px">
											<img id="loadNama"  align="absmiddle" src="../images/ajax-loader.gif" style="position:absolute;z-index:2;margin-left:45px;margin-top:24px;opacity: 0.5;display:none" />
											<label for="exampleInputEmail1">Nama 
											Member*</label>
											<div class="input-group" >
                                            
                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>
												<input readonly type="text" class="form-control" id="tfMember" name="tfMember" placeholder="Member Name*">
											</div>
										</div>
                                                                                
										<div class="form-group" style="margin-left:-15px" id="phonemailspon">
											<div class="col-lg-6 col-md-6 divtr" >
												<label for="exampleInputEmail1" >
												<span style="font-weight:bold">No Telepon 
												Member*</span></label>
												<div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-mobile"></i></span>
													<input  type="text" class="form-control" id="tfPhoneSpon" name="tfPhoneSpon" placeholder="Member Phone Number*">
												</div>
											</div>
											<div class="col-lg-6 col-md-6 divtr" >
												<label for="exampleInputEmail1" >
												<span style="font-weight:bold">Alamat Email 
												Member</span></label>
												<div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-envelope"></i></span>
													<input style="width:98%" readonly type="email" class="form-control" id="tfEmailSpon" name="tfEmailSpon" placeholder="Member's Email Address">
												</div>
											</div>
											
											<div class="col-lg-6 col-md-6 divtr" >
												<label for="exampleInputEmail1" >
												<span style="font-weight:bold">Alamat Member
												</span></label>
												<div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-envelope"></i></span>
													<textarea  style="padding-left:30px" readonly class="form-control" id="tfAlamat" name="tfAlamat" placeholder="Mailing Address"></textarea>
												</div>
											</div>

											
										</div>
										</div>
                                        
                                        
<div class="row" >                      
                               
   							
                               <div class="col-lg-4 col-md-4 divtr hide" >
                                   <label for="exampleInputEmail1" >
								   <span style="font-weight:bold">Country*</span></label>
                                                                 <!-- <input type="text" class="form-control" id="tfNama" placeholder="Country*"> -->
                                <select class="form-control m-bot15" id="lmCountry" name="lmCountry" onChange="prepareProp(this)">
                                <option  value="" selected="selected" >--Pilih / Choose--</option>
								<? 
								    $vCntID=$db->f('fcountry');
								    $vSQL="select * from m_country order by fcountry_name";
								    $dbin->query($vSQL);
								    
								    while ($dbin->next_record()) {
								?>                               
								 <option value="<?=$dbin->f('fcountry_code')?>" <? if ($dbin->f('fcountry_code')==$vCntID) echo ' selected';?>><?=$dbin->f('fcountry_name')?></option>
								 <? } ?>
                            </select>

              </div>
                              
     							                    
              <div class="col-lg-4 col-md-4 divtr divindent " id="divProp">
                               <img id="loadProp"  align="absmiddle" src="../images/ajax-loader.gif" style="position:absolute;z-index:2;margin-left:45px;margin-top:24px;opacity: 0.5;display:none" />
                                   <label for="exampleInputEmail1" >
								   <span style="font-weight:bold">Province*</span></label>
                                                                <select class="form-control m-bot15" id="lmProp" name="lmProp" onChange="prepareKota(this)">
                                <option  value="" selected="selected" >--Pilih / Choose--</option>
                                

								</select>
								
                                </div>
                            
                              
			  <div class="col-lg-4 col-md-4 divtr" id="divKota">
                                <img id="loadKota"  align="absmiddle" src="../images/ajax-loader.gif" style="position:absolute;z-index:2;margin-left:45px;margin-top:24px;opacity: 0.5;display:none" />
                                 <label for="exampleInputEmail1" >
								 <span style="font-weight:bold">City*</span></label>
                                 
                                <select class="form-control m-bot15" id="lmKota" name="lmKota">
                                <option  value="" selected="selected" >--Pilih / Choose--</option>
                                <option  value="<?=$db->f('fkota')?>" selected="selected" ><?=$db->f('fkotaname')?></option>

								</select>

              </div>                        
  
  <div class="col-lg-4 col-md-4 divtr divindent " id="divSbg">
                               <img id="loadProp"  align="absmiddle" src="../images/ajax-loader.gif" style="position:absolute;z-index:2;margin-left:45px;margin-top:24px;opacity: 0.5;display:none" />
                                   <label for="exampleInputEmail1" >
								   <span style="font-weight:bold">Mendaftar Sebagai*</span></label>
                <select class="form-control m-bot15" id="lmType" name="lmType" >
                                <option  value="" selected="selected" >--Pilih / Choose--</option>
                                 <option  value="1"  >Mobile Stockist</option>
                                 <option  value="2"  >Stockist</option>
                                 <option  value="3"  >Master Stockist</option>
                                

								</select>
                                
                                
								
              </div>
                              
 <div class="col-lg-6 col-md-6 divtr" >
												<label for="exampleInputEmail1" >
												<span style="font-weight:bold">Pesan / Keterangan
												</span></label>
												<div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-envelope"></i></span>
												  <textarea  style="padding-left:30px"  class="form-control" id="tfDesc" name="tfDesc" placeholder="Masukkan pesan / keterangan jika diperlukan "></textarea>
												</div>
			  </div>                             
						</div>     
                     <br><br>                                     
		  </div> <!-- panel body -->
				     
        </div>
		<!--Kolom Kanan -->
        </div>
        
        
    </div>
<hr /><br />
        
<div class="panel panel-default" id="panelkanan">
					                    
					                      <!--body-->
   </div>    <!--panel --> 
        
  <div class="col-lg-6">      
  <button id="btnSubmit" type="submit" class="btn btn-primary" disabled="disabled" onClick="submitForm(this)">Register Stockist</button>   </div>                       
                       
 </form> 
 
 <?
 $vSQL = "select * from tb_stockist_temp where fidmember='$vUser'";
	$db->query($vSQL);
	$db->next_record();
	if ($db->num_rows() > 0) {
 ?>  
 <br><br>  
 <div class="row">
 <hr>
 </div>

<label for="exampleInputEmail1" style="font-size:1.2em">Status Registrasi Stokist</label>
<table width="85%" class="table table-bordered">
  <tr style="font-weight:bold;text-align:center">
    <td>Username</td>
    <td>Tipe Stokist</td>
    <td>Status</td>
    <td>Tgl. Daftar</td>
    <td>Tgl. Aktif</td>
    <td>Keterangan</td>
  </tr>
  <?
     $vSQL = "select * from tb_stockist_temp where fidsponsor='$vUser'";
	$db->query($vSQL);
	while($db->next_record()) {
		if ($db->f('ftype')=='1')
		   $vTypeDesc='Mobile Stockist';
		else if ($db->f('ftype')=='2')
		   $vTypeDesc='Stockist';
		else if ($db->f('ftype')=='3')
		   $vTypeDesc='Master Stockist';
	
		if ($db->f('faktif')=='0')
		   $vStatDesc='<span class="btn btn-warning btn-sm">Pending</span>';
		else if ($db->f('faktif')=='1')
		   $vStatDesc='<span class="btn btn-info btn-sm">Approved</span>';
	   
  ?>
  <tr>
    <td><?=$db->f('fidmember')?></td>
    <td><?=$vTypeDesc?></td>
    <td align="center"><?=$vStatDesc?></td>
    <td align="center"><?=substr($db->f('ftgldaftar'),0,10)?></td>
    <td align="center"><?=substr($db->f('ftglaktif'),0,10)?></td>
    <td><?=$db->f('fdesc')?></td>
  </tr>
  <? } ?>
</table>
<? } ?>
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