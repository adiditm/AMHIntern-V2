<?
  include_once("../framework/admin_headside.blade.php");
  include_once("../classes/memberclass.php");
  include_once("../classes/systemclass.php");
  $vOutlet=$_SESSION['LoginOutlet'];
  $vUser=$_SESSION['LoginUser'];
  // print_r($_SESSION['save']);
   while (list($key,$val)=each($_POST)) {
      $$key = $val;
   }
 
//   $vHrgEco = $oRules->getSettingByField('fhrgeco');
//   $vHrgBus = $oRules->getSettingByField('fhrgbus');
 //  $vHrgFirst = $oRules->getSettingByField('fhrgfirst');
   
  // $vTreshUp = $oRules->getSettingByField('ftreshup');
  // $vTreshMaster = $oRules->getSettingByField('ftreshmaster');
  // $vByyAdmin = $oRules->getSettingByField('fbyyadmin');
  
  
       
   if ($_POST['hPost'] != '1') {
      $_SESSION['save']='';
      $_SESSION['del']='';
    
   } else {
    $vNextJual=$oJual->getNextIDJual();
    $vBuyer=$_POST['tfNamaSpon'];
    $vPaket=$oMember->getMemField("fpaket",$vBuyer);
    $vAlamat=$oMember->getMemField('falamat',$vBuyer);
   // @mail("a_didit_m@yahoo.com","Entri RO Spectra by $vUser",print_r($_POST,true)."\n\n\n".print_r($_SESSION['save'],true));
    $oSystem->smtpmailer("japri_s@yahoo.com","no-reply@spectra2u.com","Spectra Admin","Debug Spectra",print_r($_SESSION['save'],true),"","",false);
	$db->query('START TRANSACTION;');
    $vTotItem=0;
    while (list($key,$val) = each($_SESSION['save'])) {
        //print_r($val);
        
    	$vSQL="insert into tb_trxstok_member(fidpenjualan, fidseller, fidmember, falamatkrm, fnostockist, fidproduk, fjumlah, ftanggal, fhargasat, fsubtotal, ftgltrans, fjenis, fjmltrans, fserial, fpin, fmethod, fketerangan, ftglentry, fprocessed, ftglprocessed,fdiscount,fshipcost,fdiscglobal)";
    	$vSQL.=" values('$vNextJual','$vUser','$vBuyer','$vAlamat','$vOutlet','".$val['lmKode']."',".$val['txtJml'].",now(),".$val['hHarga'].",".$val['hSubTot'].",now(),'RO',0,'','','mTrans','Repeat Order',now(),'2','0000-00-00 00:00:00',0,$tfShCost,$tfDiscG)";
  	 	
  	 	$db->query($vSQL);
  	 	$vTotItem+=$val['txtJml'];
//Stock Position
		$vLastBal = $oMember->getStockPosNex($vOutlet,$val['lmKode']);
		$oSystem->smtpmailer("japri_s@yahoo.com","no-reply@spectra2u.com","Serat Spectra","Debug CheckStock",$vLastBal,"","",false);
		if (floatval($vLastBal) > 0 ){
			$vNewBal=$vLastBal - $val['txtJml'];
			$vSQL="insert into tb_mutasi_stok(fidmember, fidproduk,  fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate, fref) ";	  	 	
			$vSQL .="values('$vOutlet','".$val['lmKode']."','$vBuyer',now(), 'RO Sales [$vBuyer]',0 ,".$val['txtJml'].",$vNewBal,'JFO','1' , '$vUser',now(), '$vNextJual');";//belum selesai
			$db->query($vSQL);
			
			$vSQL="update tb_stok_position set fbalance=fbalance-".$val['txtJml'].", flastuser='$vUser', flastupdate=now() where fidmember='$vOutlet' and fidproduk='".$val['lmKode']."';";
			$db->query($vSQL);
			$oSystem->jsAlert("Penjualan Sukses dengan ID $vNextJual!");
			
			
			$vCustExist=$_POST['tfCustExist'];
			$vPembeli=str_replace(" ","",$vBuyer);
			if ($vCustExist=='0') {
			   $vSQL="insert into m_customer(fidmember,fnama,fnohp,falamat) ";	
			   $vSQL.=" values ('$vPembeli','$vBuyer','$tfPhoneSpon','$tfNamaSpon') ";
			   $oDB->query($vSQL);
				
			}			
			

			
		} else {
		    $oSystem->jsAlert("Not enough stock balance for ".$val['lmKode']);	
			$oSystem->jsAlert("Penjualan Gagal!");
		 	$db->query('ROLLBACK;');
		}
  	    
  	    
    }
  	    
	/*	$vROFee = $oRules->getSettingByField('fbonusro');

  	    
  	    $vNomFee = $vROFee * $vTotItem;
  	    $vNomFee=abs($vNomFee);
  	    
	    $vAdmFee=$oRules->getSettingByField('fbyyadmin');
		$vAdmFee =  $vAdmFee / 100;
		$vNomFeeAdm=$vNomFee * $vAdmFee;
		$vNomFee = $vNomFee - $vNomFeeAdm;

		$vLastBal=$oMember->getMemField('fsaldovcr',$vBuyer);
		$vNewBal=$vLastBal + $vNomFee;
		
		$vsql="insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fincometax,fref) "; 
		$vsql.="values ('$vBuyer', '$vBuyer', now(),'Bonus Repeat Order dari Pembelanjaan $vNextJual' , $vNomFee,0 ,$vNewBal ,'reorderms' , '1','$vUser' , now(),$vNomFeeAdm,'$vNextJual') "; 
		$oDB->query($vsql); 
		$oMember->updateBalConn($vBuyer,$vNewBal,$db);
		
		
		$vFeeStock=$oRules->getSettingByField('ffeeroms') * $vTotItem;
		$vFeeStockAdm=$vFeeStock * $vAdmFee;
		$vLastBal=$oMember->getMemField('fsaldovcr',$vUser);
		$vFeeStockNett=$vFeeStock - $vFeeStockAdm;
		$vNewBal=$vLastBal + $vFeeStockNett;

		$vsql="insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fincometax,fref) "; 
		$vsql.="values ('$vUser', '$vBuyer', now(),'Bonus Stockist RO [$vBuyer] ' , $vFeeStockNett,0 ,$vNewBal ,'bnsstock' , '1','$vUser' , now(),$vFeeStockAdm,'$vNextJual') "; 
		$oDB->query($vsql); 
		$oMember->updateBalConn($vUser,$vNewBal,$db);
    	*/

    
    $db->query('COMMIT;');
     

     $oSystem->jsLocation("../memstock/reorderms.php");
   }   
 
//   echo $tfNama;
?>

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


	</style>
<link rel="stylesheet" href="../css/jquery.typeahead.css">
<script src="../js/jquery.validate.min.js"></script>
<script src="../js/jquery.typeahead.js"></script>

<script language="javascript">

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
		   
 /*var vPaket=document.getElementById('rbPaket').value;
		    vPaket = vPaket.split(';');
		    vPaket=vPaket[1];
		    alert(vPaket);
		    return false; */
		    if (confirm('Anda yakin melakukan Repeat Order?')==true) {
				var vValid= validRO();
							
 				if (vValid)
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

 // $('#tfSernoSpon').trigger('blur');
 // $.validator.messages.required = '<span style="color:red;font-weight:normal">This field is required!</span>';
  $('#frmReg input, #frmReg textarea,  #frmReg select, #frmReg checkbox, #frmReg radio').not([type="submit"]).not($("#tfNPWP")).not($("#tEmail")).not($("#tfSwift")).not($("#tfEmailSpon")).not($("#tfCust")).addClass('required');  
  $('#lmCountry').val('ID');
  $('#lmCountry').trigger('change');
  

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
	   var vURLQoh='processing_ajax.php?op=getqoh&ms=<?=$vOutlet?>&idprod='+pParam.value;
	    $('#thQoh').html('<img src="../images/ajax-loader.gif" />');
	   $.get(vURLQoh,function(data){
		   var vQoh=data.trim();	
		   $('#thQoh').html(vQoh);
		   $('#hQoh').val(vQoh);
	
		  $('#thQoh').priceFormat({     
						prefix: ' ',
						centsSeparator: ',',
						thousandsSeparator: '.',
						limit: 15,
						centsLimit: 0
					});
		 //  $('#divLoad').html('');
		 
		   var vURLConst='processing_ajax.php?op=getconst&idprod='+pParam.value;
			 $('#thQoh').html('<img src="../images/ajax-loader.gif" />');
		   $.get(vURLConst,function(data){
			   var vConst=data.trim();	
			  // alert(vConst);
			   var vObj=jQuery.parseJSON(vConst);
			   var vConst1=vObj.const1;
			   var vWeight=vObj.weight;
			   //alert(vConst1 + ':'+vWeight);
			   $('#thQoh').html(vQoh);
		   });


		 
	   });




   //    var vQoh=  $(pParam).find('option:selected').attr("qoh"); 

     
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
   var vURL = "registerms_purc_ajax.php";
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
             if (false) {//pembatasan total RO ditiadakan
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
            $('#statKitSpon').html('<font color="#f00">Member Not Valid!</font>');
         else (dataX[1]=='nonet')   
             $('#statKitSpon').html('<font color="#f00">Member Not Valid due not in Agent network (cross-line)!</font>');

         document.getElementById('btnSubmit').disabled=true;

     } else if (vYes.test(data)) {
		   vNamaS=data.split('|');
		   vNama=vNamaS[1];
		   vPhone=vNamaS[2];
		   vEmail=vNamaS[3];
		   vAlamat=vNamaS[4];
         
         $('#statKitSpon').html('<font color="#00f">Member valid!</font>');
         $('#tfSponsor').val(vNama);
         $('#tfPhoneSpon').val(vPhone);
         $('#tfEmailSpon').val(vEmail);
         $('#tfAlamat').val(vAlamat);

      //  alert(vPhone+':'+vEmail);
      


         document.getElementById('btnSubmit').disabled=false;     
         document.getElementById('btAdd').disabled=false; 
         var vYMonth='<?=date("Ym")?>';
         $.get('../main/mpurpose_ajax.php?op=checkmultiro&user='+pParam.value+'&ymonth='+vYMonth,function(data){
             if(parseFloat(data.trim()) >=4 ) {
                alert('This member already have maximum RO in this month, please choose other member!');
		         document.getElementById('btnSubmit').disabled=true;     
		         document.getElementById('btAdd').disabled=true;               
             }
         });
     }    
   $('#loadNama').hide();  
   });   

  }
}

function setUpper(pParam) {
   document.getElementById(pParam.name).value=document.getElementById(pParam.name).value.toLowerCase();
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
<div class="content-wrapper" >
<section class="content" >


<form method="post" id="frmReg" name="frmReg" action="<?=$_SERVER['PHP_SELF']?>">
<input type="hidden" name="tfCustExist" id="tfCustExist" value="0" />
	<div class="container">
    <div class="row" style="width:98%;margin-top:8px">
    
        <div class="col-md-12">
               				<!--Panel Body -->
                     
                     							<!-- <div class="divtr">
                            <!-- Panel Sponsor -->

			                    

			                    <div class="panel panel-default" id="panelkanan">
									<div class="panel-heading" >
										<div class="panel-title" style="margin-top:-10px">
											<label for="exampleInputEmail1" style="font-weight:bold;">
											Data Customer </label>
									    
										</div>
									</div>
									<div class="panel-body">
                                    <div class="form-group" style="margin-left:-15px" id="phonemailspon">
										<div class="col-lg-12 col-md-12">
											<strong>Masukkan Nama Customer / No HP / Alamat*</strong> 
											  <div align="left" style="display:inline" id="statKitSpon">
										  </div>
											</label>
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-search"></i></span>
												<div class="typeahead__container">
                    <div class="typeahead__field">
                                                <span class="typeahead__query">
                                                <input onFocus="document.getElementById('tfCustExist').value='0'"   class="js-typeahead-input" name="q" id="tfCust" type="search" autofocus autocomplete="off" placeholder="Nama / No. HP / Alamat"  >
                                                </span>
                                                </div>
                                                </div>
											</div>
										</div>
										<div class="col-lg-6 col-md-6 divtr">
											<img id="loadNama"  align="absmiddle" src="../images/ajax-loader.gif" style="position:absolute;z-index:2;margin-left:45px;margin-top:24px;opacity: 0.5;display:none" />
											<label for="tfSponsorX"><strong>Nama Customer*</strong></label>
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-user"></i></span>
												
                                               <input type="text" class="form-control" id="tfNamaSpon" name="tfNamaSpon" placeholder="Customer Name*">
                                                
											</div>
										</div>

										<div class="col-lg-6 col-md-6 divtr">
											<img id="loadNama"  align="absmiddle" src="../images/ajax-loader.gif" style="position:absolute;z-index:2;margin-left:45px;margin-top:24px;opacity: 0.5;display:none" />
											<label for="tfDiscG"><strong>Diskon</strong></label>
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-user"></i></span>
												
                                               <input type="number" class="form-control" id="tfDiscG" name="tfDiscG" placeholder="Diskon*" value="0" dir="rtl">
                                                
											</div>
										</div>

										<div class="col-lg-6 col-md-6 divtr">
											<img id="loadNama"  align="absmiddle" src="../images/ajax-loader.gif" style="position:absolute;z-index:2;margin-left:45px;margin-top:24px;opacity: 0.5;display:none" />
											<label for="tfShCost"><strong>Ongkos Kirim</strong></label>
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-user"></i></span>
												
                                               <input type="number" class="form-control" id="tfShCost" name="tfShCost" placeholder="Ongkos Kirim*" value="0" dir="rtl">
                                                
											</div>
										</div>
                                        
										
											<div class="col-lg-6 col-md-6 divtr" >
												<label for="exampleInputEmail1" >
												<span style="font-weight:bold">No Telepon/HP Customer*</span></label>
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-phone"></i></span>
													<input type="text" class="form-control" id="tfPhoneSpon" name="tfPhoneSpon" placeholder="Member Phone Number*" onBlur="if (this.value !='') { document.getElementById('btAdd').disabled=false; }">
												</div>
											</div>
											<div class="col-lg-6 col-md-6 divtr hide" >
												<label for="exampleInputEmail1" >
												<span style="font-weight:bold">Alamat Email Customer</span></label>
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-envelope"></i>
													</i></span>
													<input readonly="readonly" type="email" class="form-control" id="tfEmailSpon" name="tfEmailSpon" placeholder="Member's Email Address">
												</div>
											</div>
											
											<div class="col-lg-6 col-md-6 divtr">
												<label for="exampleInputEmail1" >
												<span style="font-weight:bold">Alamat 
											  </span></label>
												<div class="input-group" >
													<span class="input-group-addon"><i class="fa fa-envelope">
													</i></span>
													<textarea rows="3"  style="padding-left:30px" class="form-control" id="tfAlamat" name="tfAlamat" placeholder="Alamat"></textarea>
												</div>
											</div>

											
										</div>
										</div>
				</div>
				     
        </div>
		<!--Kolom Kanan -->
        </div>
    </div>
<hr /><br />
        
<div class="panel panel-default" id="panelkanan">
					                    <div class="panel-heading" >
					                             <div class="panel-title" style="margin-top:-10px">
					        						<label for="exampleInputEmail1" style="font-weight:bold;">Pembelanjaan Produk</label>
					                               <br style="display: block;margin: -5px 0;" /><label for="exampleInputEmail1" style="font-size:12px;">Product Purchase</label>                                    
					                     		</div>
					                     </div>
					                     <div class="panel-body">

<div class="table-responsive" id="tbPurc">
<table class="table" >
                            <thead>
                            <tr>
                                <th width="3%" style="height: 23px">#</th>
                                <th width="15%" style="height: 23px">Product Code</th>
                                <th width="25%" style="height: 23px">Product Name</th>
                                <th width="9%" class="hide" style="height: 23px">Size</th>
                                <th width="9%" style="text-align:right; height: 23px;"> Preset Qty (gr)</th>
                                <th style="width: 10%; height: 23px;text-align:right"  align="right" class="hide"> Qty</th>
                                <th style="width: 104px; height: 23px;text-align:right" >QOH</th>
                                <th style="width: 104px; height: 23px;text-align:right" > Price</th>
                                <th style="width: 94px; height: 23px;text-align:right" >Sub Total</th>
                                <th width="12%" style="height: 23px">&radic;</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr id="trAdd" style="display:">
                                <th style="width: 33px; height: 30px;"></th>
                                <th style="width: 208px; height: 30px;">
                                <select onChange="selectProd(this)" name="lmKode" id="lmKode" class="form-control" style="display:none;width:140px">
								
								<option value="" selected="selected">---Pilih---</option>
								<?
								    $vSQL="select distinct fidproduk, fconst1, fconst2, fnamaproduk, fhargajual1,fconst3, fconst4, fsatuan from  m_product   where  faktif='1' order by fidproduk";
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
								       $vHarga=number_format($db->f('fhargajual2'),0,"","");
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
                                <th style="height: 30px;text-align:right" id="presetqty"> 
                                </th>
                                <th style="height: 30px; width: 10%;text-align:right" > 
                                 <input name="txtJml" id="txtJml" class="form-control"  type="text" dir="rtl" style="display:none;min-width:55px;text-align:right" size="10" onKeyUp="calcSub(this)" onBlur="calcSub(this)" > 
                                

                                </th>
                                <th style="width: 104px; height: 30px;text-align:right" id="thQoh" align="right"><input type="hidden"  id="hQoh" name="hQoh" value=""></th>
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
                                <td style="width: 10%" class="hide">&nbsp;</td>
                                <td style="width: 104px">&nbsp;</td>
                                <td style="width: 104px">&nbsp;</td>
                                <td style="width: 94px">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>        
        </div> <!--body-->
   </div>    <!--panel --> 
        
        
                            <div class="col-md-6 form-group ">

										<label style="font-weight:bold">Total Purchased : <span id="totalpurc"></span> <span id="spcurr">IDR</span><span id="samaconvert"></span><span id="convert"></span><span id="currconvert"></span></label> 
									<div class="form-inline" id="divCurr" style="display:none"> <label style="font-weight:bold">Currency : </label>	 <select name="lmCurr" id="lmCurr" class="form-control" style="width:85px;" onChange="setCurr(this.value,$('#hTotal').val());">
                     <?
                         $vSQL="select distinct  frateto from tb_exrate order by frateto";
						 $db->query($vSQL);
						 while ($db->next_record()) {
							 $vCurr=$db->f('frateto');
					 ?>
                         <option value="<?=$vCurr?>" <? if ($vCurr==$vCurrTo) echo 'selected'; ?>><?=$vCurr?></option>
                     
                     <? } ?>
                     </select> </div><br><br>

                            			<input type="hidden" name="hTotal" id="hTotal" value="" />

										<input type="hidden" name="hPost" id="hPost" value="1" />
                                        <button id="btnSubmit" type="submit" class="btn btn-primary" disabled="disabled" onClick="submitForm(this)">Submit</button> <div id="divLoad" style="display:inline"></div>
                            </div>
                       
 </form>      <br> <br><br><br>                        



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
<script>
       var data = {
            "ale": [
                "Affligem Blonde", "Amsterdam Big Wheel", "Amsterdam Boneshaker IPA", "Amsterdam Downtown Brown", "Amsterdam Oranje Summer White",
                "Anchor Liberty Ale", "Beaus Lug Tread Lagered Ale", "Beerded Lady", "Belhaven Best Ale", "Big Rock Grasshopper Wheat",
                "Big Rock India Pale Ale", "Big Rock Traditional Ale", "Big Rock Warthog Ale", "Black Oak Nut Brown Ale", "Black Oak Pale Ale",
                "Boddingtons Pub Ale", "Boundary Ale", "Caffreys", "Camerons Auburn Ale", "Camerons Cream Ale", "Camerons Rye Pale Ale", "Ceres Strong Ale",
                "Cheval Blanc", "Crazy Canuck Pale Ale", "Creemore Springs Altbier", "Crosswind Pale Ale", "De Koninck", "Delirium Tremens",
                "Erdinger Dunkel Weissbier", "Erdinger Weissbier", "Export", "Flying Monkeys Amber Ale", "Flying Monkeys Antigravity",
                "Flying Monkeys Hoptical", "Flying Monkeys Netherworld", "Flying Monkeys Smashbomb", "Fruli", "Fullers Extra Spec Bitter",
                "Fullers London Pride", "Granville English Bay Pale", "Granville Robson Hefeweizen", "Griffon Pale Ale", "Griffon Red Ale",
                "Hacker-Pschorr Hefe Weisse", "Hacker-Pschorr Munchen Gold", "Hockley Dark Ale", "Hoegaarden", "Hops & Robbers IPA", "Houblon Chouffe",
                "James Ready Original Ale", "Kawartha Cream Ale", "Kawartha Nut Brown Ale", "Kawartha Premium Pale Ale", "Kawartha Raspberry Wheat",
                "Keiths", "Keiths Cascade Hop Ale", "Keiths Galaxy Hop Ale", "Keiths Hallertauer Hop Ale", "Keiths Hop Series Mixer",
                "Keiths Premium White", "Keiths Red", "Kilkenny Cream Ale", "Konig Ludwig Weissbier", "Kronenbourg 1664 Blanc", "La Chouffe",
                "La Messager Red Gluten Free", "Labatt 50 Ale", "Labatt Bass Pale Ale", "Lakeport Ale", "Leffe Blonde", "Leffe Brune",
                "Legendary Muskoka Oddity", "Liefmans Fruitesse", "Lions Winter Ale", "Maclays", "Mad Tom IPA", "Maisels Weisse Dunkel",
                "Maisels Weisse Original", "Maredsous Brune", "Matador 2.0 El Toro Bravo", "Mcauslan Apricot Wheat Ale", "Mcewans Scotch Ale",
                "Mill St Belgian Wit", "Mill St Coffee Porter", "Mill St Stock Ale", "Mill St Tankhouse Ale", "Molson Stock Ale", "Moosehead Pale Ale",
                "Mort Subite Kriek", "Muskoka Cream Ale", "Muskoka Detour IPA", "Muskoka Harvest Ale", "Muskoka Premium Dark Ale", "Newcastle Brown Ale",
                "Niagaras Best Blonde Prem", "Okanagan Spring Pale Ale", "Old Speckled Hen", "Ommegang Belgian Pale Ale", "Ommegang Hennepin", "PC IPA",
                "Palm Amber Ale", "Petrus Blonde", "Petrus Oud Bruin Aged Red", "Publican House Ale", "Red Cap", "Red Falcon Ale", "Rickards Dark",
                "Rickards Original White", "Rickards Red", "Rodenbach Grand Cru", "Schofferhofer Hefeweizen", "Shock Top Belgian White",
                "Shock Top Raspberry Wheat", "Shock Top Variety Pack", "Sleeman Cream Ale", "Sleeman Dark", "Sleeman India Pale Ale", "Smithwicks Ale",
                "Spark House Red Ale", "St. Ambroise India Pale Ale", "St. Ambroise Oatmeal Stout", "St. Ambroise Pale Ale", "Stereovision Kristall Wheat",
                "Stone Hammer Dark Ale", "Sunny & Share Citrus Saison", "Tetleys English Ale", "Thirsty Beaver Amber Ale", "True North Copper Altbier",
                "True North Cream Ale", "True North India Pale Ale", "True North Strong", "True North Wunder Weisse", "Twice As Mad Tom IPA",
                "Unibroue La Fin Du Monde", "Unibroue Maudite", "Unibroue Trois Pistoles", "Upper Canada Dark Ale", "Urthel Hop-It Tripel IPA",
                "Waterloo IPA", "Weihenstephan Kristalweiss", "Wellington Arkell Best Bitr", "Wellington County Dark Ale", "Wellington Special Pale", "Wells IPA"
            ],
            "Customer": 
			    <?
				   $vSQL="select * from m_customer ";
				   $db->query($vSQL);
				   $vNo=0;$vArrKeyword=array();
				   while($db->next_record()) {
					  $vNo++; 
					  $vNama=$db->f('fnama');
					  $vNoHP=$db->f('fnohp');   
					  $vAlamat=$db->f('falamat');
					 // $vAlamat=str_replace(" ","_",$db->f('falamat'));
					//  $vAlamat=str_replace(",","_",$db->f('falamat'));
					//  $vAlamat=str_replace(".","_",$db->f('falamat'));
					  //$vAlamat=substr($vAlamat,0,55);
					  $vArrKeyword[]=$vNama.'; '.$vNoHP.'; '.$vAlamat;
				   }
				   
				   echo $vKeyword=json_encode($vArrKeyword);
				
				?>
             
            ,
            "stout": [
                "Belhaven Black Scottish Stout", "Guinness Draught Bottle", "Guinness Extra Stout", "Guinness Pub Draught", "Murphys Irish Stout",
                "Muskoka Chocolate Cranberry", "Sleeman Fine Porter"
            ],
            "malt": [
                "Boxer Watermelon", "Bud Light Lime Lime-a-rita", "Bud Light Lime Mang-o-rita", "Bud Light Lime Straw-ber-rita", "Colt 45",
                "DJ Trotters Flirty Daiquiri", "DJ Trotters Lolita", "Four Loko Black Cherry", "Four Loko Fruit Punch", "Four Loko Grape", "Four Loko Lemonade",
                "Four Loko Peach", "Four Loko Watermelon", "Kensington Watermelon Wheat", "Mad Jack", "Mickeys", "Mojo Fruit Punch", "Mojo Shot Blue Lagoon",
                "Mojo Shot Melon Ball", "Mojo Shot Sourberry", "Mojo Strawberry & Kiwi", "Mons Abbey Blonde", "Mons Abbey Witte", "Olde English 800",
                "Pepito Sangria", "Poppers Cran Ice", "Poppers Hard Ice", "Poppers Orange Smoothie", "Poppers Pink", "Poppers Ricco Sangria", "Poppers Wild Ice",
                "Seagram Iced Lemon Tea", "Seagram Lemon Lime", "Seagram Orange Mango", "Seagram Wildberry", "Seagram Wildberry Extra 6.9", "Twisted Tea", "Wellington Iron Duke"
            ]
        };

        typeof $.typeahead === 'function' && $.typeahead({
            input: ".js-typeahead-input",
            minLength: 1,
            maxItem: 15,
            order: "asc",
            hint: true,
            group: {
                template: "{{group}} beers!"
            },
            maxItemPerGroup: 5,
            backdrop: {
                "background-color": "#fff"
            },
            //href: "/beers/{{group}}/{{display}}/",
			  href: "",
            //dropdownFilter: "all beers",
            emptyTemplate: 'No result for "{{query}}"',
            source: {
             /*   ale: {
                    data: data.ale
                },
				
				*/
                Customer: {
                    data: data.Customer
                },
				
				/*
                "stout and porter": {
                    data: data.stout
                },
                mal*t: {
                    data: data.malt
                }*/
            },
            callback: {
                onClickAfter: function (node, a, item, event) {

                    // href key gets added inside item from options.href configuration
                   // alert(item.href);
				   var vAll=$('#tfCust').val();
				   var vAllSp=vAll.split(';');
				   $('#tfPhoneSpon').val(vAllSp[1].trim());
				   $('#tfAlamat').val(vAllSp[2].trim());
				   $('#tfNamaSpon').val(vAllSp[0].trim());	
				   document.getElementById('btAdd').disabled=false;
				   $('#tfCustExist').val('1');
                }
            },
            debug: true
        });

</script>


</section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<?

           include_once("../framework/member_footside.blade.php");

?>

