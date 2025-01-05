<? include_once("../framework/admin_headside.blade.php");
include_once("../classes/memberclass.php");
include_once("../classes/networkclass.php");
include_once("../classes/systemclass.php");
include_once("../classes/espayclass.php");
include_once("../classes/ruleconfigclass.php");
?>
<?
  // print_r($_POST);
   while (list($key,$val)=each($_POST)) {
      $$key = $val;
   }
   
   

   if ($vPriv=='member')
      $vSeller = $vUserHO;
   else	  
      $vSeller = $vUser;
	  
   $vMemberId = $_GET['uMemberId'];	  
   $vMemberName = $oMember->getMemberName($vMemberId);
   $vProgram=$oMember->getMemField('fprogram',$vMemberId);
   
  // $vSalProd = 8000000;
  //$vSalProd = 5000000;
  
       
   if ($_POST['hPost'] != '1') {
      $_SESSION['save']='';
      $_SESSION['del']='';
    
   } else {
    $vNextJual=$oJual->getNextIDJPoin();
    $vBuyer=$_POST['tfSernoSpon'];
    $vPaket=$oMember->getMemField("fpaket",$vBuyer);
    $vAlamat=$oMember->getMemField('falamat',$vBuyer);
	 $vEmail = $oMember->getMemField('femail',$vBuyer);
	
   // @mail("a_didit_m@yahoo.com","Entri RO Spectra by $vUser",print_r($_POST,true)."\n\n\n".print_r($_SESSION['save'],true));
    $oSystem->smtpmailer('japri_s@yahoo.com',$vMailFrom,'Onotoko',"Entri Point Order Onotoko by $vUser",print_r($_POST,true)."\n\n\n".print_r($_SESSION['save'],true),'','',false);
	$db->query('START TRANSACTION;');
    $vTotItem=0;
	if ($lmMethod=='ctr' || $lmMethod=='esp')
	   $vMainTable='tb_payment_temp';
	else if ($lmMethod=='wpr')  
	   $vMainTable='tb_payment';
	   
	$vTotal=$_POST['hTotal'];
	
				   	 
        //print_r($val);
		  $vPoinFund = 1;
          $vTotal = $tfPoin * $vPoinFund;
		  if (strtolower($hPayText)==strtolower('voucher')) 
		      $vDesc = 'Redeem';
		  else $vDesc = 'Pembayaran';	  
    	 $vSQL="insert into $vMainTable(fidpenjualan, fidseller, fidmember, fnostockist, fidproduk, fjumlah,  fhargasat, fsubtotal,  ftgltrans, fjenis, fjmltrans, fmethod, fketerangan, ftglentry, fprocessed, ftglprocessed)";
    	 $vSQL.=" values('$vNextJual','$vSeller','$vBuyer','$vUser','$lmAngs',".round($tfPoin,2).",$vPoinFund, ".round($vTotal,2).",now(),'POIN',0,'$lmMethod','$vDesc $hPayText',now(),'1','1981-01-01 00:00:00')";
  	 	//echo $vSQL;
  	 	$db->query($vSQL);
  	 	$vTotItem+=$val['txtJml'];
		
    $db->query('COMMIT;');
	$tfPhoneSpon= $oMember->getMemField('fnohp',$vBuyer);
	//if (substr($tfPhoneSpon,0,2) == '62');
	  //  $tfPhoneSpon = "0".substr($tfPhoneSpon,2,15);
	
     if ($lmMethod=='esp') {
	 //   $oSystem->jsAlert("Proses ini memerlukan waktu beberapa detik sampe satu menit, tergantung kecepatan koneksi!");
		$vName = $oMember->getMemberName($vUser);
		$vHP = $oMember->getNoHP($vUser);
		$vResultOri = $oEspay->sendInvoice('013',$vUser,$vName,$vTotal,'IDR',$vNextJual,$vHP);
	//echo "<br>Result: $vResult";
	    $vResult = str_replace("'","''",$vResultOri['res']);
		$vRequest = str_replace("'","''",$vResultOri['req']);
		
		$vContent = json_decode($vResult,true);
		//print_r($vContent);
		$vSQL = "insert into tb_inquespay(ftanggal,fipaddress,frequest,fcontent,fapikind) ";
		$vSQL .= "values(now(),'localhost','$vRequest','$vResult ','invo')" ;
			//$vResponseEspay=$vContent;
			$db->query($vSQL);		
		//	print_r($vContent);
		 $vVaSuccess ='0';
		if (is_array($vContent)) {
			 $vError =  $vContent['error_code'];
			 if ($vError =='0000') {
							 $vVA = $vContent['va_number'];
							 
							 $vTotalPay = number_format($vContent['total_amount'],0,",",".");
							 $vExpired = $oPhpdate->YMDT2DMYT($vContent['expired']);
							 $vVaSuccess = '1';
				
								$vMessage="Yth. $vName, silakan selesaikan pembayaran Order Point Fund sebesar Rp $vTotalPay (untuk $tfPoin poin)  <br>\n
							Transfer ke VIrtual Account bank Permata : $vVA  <br> \n
							Batas Waktu : $vExpired <br> \n
							Setelah pembayaran diterima, maka sistem kami akan secara otomatis memproses order Anda!  <br> \n
							Pesan ini juga terkirim ke SMS dan Email Anda. <br> \n<br> \n
							
							Terima kasih atas kepercayaan Anda!  <br> \n
							Salam Sukses";
							
							$vSQL = "update tb_trxstok_member_temp set  fserial ='$vVA' where fidpenjualan='$vNextJual' ";
							$db->query($vSQL);
							// 
							 $vResSMS = $oSystem->sendSMS($tfPhoneSpon,"$vName, trm kasih! Silakan trnsfr ke Virt. Account Permata $vVA Rp $vTotalPay (utk $tfPoin poin), bts wkt $vExpired ",$vIDGoSMS,$vPassGoSMS);
						//	 echo"$vIDGoSMS,$vPassGoSMS $tfPhoneSpon :: $vResSMS ";
							 $oSystem->smtpmailer($vEmail,$vMailFrom,"Onotoko Notification","Penyelesaian Pembayaran Order  Poin Fund",$vMessage,"","",true);
			 } else {
								$vSQL="delete from tb_trxpoint_temp where fidpenjualan='$vNextJual'";
								$db1->query($vSQL);
								$vMessage="Payment Error, silakan ulangi order Anda!";
				 
			 }
		}
			
		//$oSystem->smtpmailer();
	 } else if ($lmMethod=='ctr')	 {
		 		$vName = $oMember->getMemberName($vUser);
				$vHP = $oMember->getNoHP($vUser);

		 					$vRekReceive = $oRules->getSettingByField('fsprekfrom');
							$vTotalFormat = number_format($vTotal,0,",",".");

							$vMessage="Yth. $vName, silakan selesaikan pembayaran Order Point Fund sebesar Rp $vTotalFormat (untuk $tfPoin poin)  <br>\n
							Transfer ke Rekening bank Permata : $vRekReceive  <br> \n
							
							
							Terima kasih atas kepercayaan Anda!  <br> \n
							Salam Sukses";
							
							
							 
							 $vResSMS = $oSystem->sendSMS($tfPhoneSpon,"$vName, trm kasih! Silakan trnsfr rekening Bank Permata $vRekReceive Rp $vTotalFormat (utk $tfPoin poin) ",$vIDGoSMS,$vPassGoSMS);
						//	 echo"$vIDGoSMS,$vPassGoSMS $tfPhoneSpon :: $vResSMS ";
							 $oSystem->smtpmailer($vEmail,$vMailFrom,"Onotoko Notification","Penyelesaian Pembayaran Order  Poin Fund",$vMessage,"","",true);		 
	    $oSystem->jsAlert("Entri pembayaran Sukses dengan ID $vNextJual, selesaikan pembayaran dan tunggu approval dari Admin!");
		$_SESSION['save']='';
		 $oSystem->jsLocation($_SERVER['HTTP_REFERER']);
	 } 
?>

<script language="javascript">
function printTrx(pParam,pTgl,pIDMem) {
	var vURL='../memstock/detjual.php?uNoJual='+pParam+'&uTanggal='+pTgl+'&uIDMember='+pIDMem;
	window.open(vURL,'wPrint','width=900 height=600');
}

//printTrx('<?=$vNextJual?>','<?=date('Y-m-d')?>','<?=$vUser?>');
</script>
<?
   //  $oSystem->jsLocation("../memstock/reorder.php");
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
<!-- <iframe id="sgoplus-iframe" src="" scrolling="no" frameborder="0"></iframe>
<script type="text/javascript" src="https://sandbox-kit.espay.id/public/signature/js"></script>
<script type="text/javascript">
    window.onload = function() {
        var data = {
            key: "0No7OkOteSt59w",
            paymentId: "ONOTOKO1642284569",
            backUrl: "https://www.trial.onotoko.co.id",
			bankCode: "013",
			bankProduct: "BCAO"
        },
        sgoPlusIframe = document.getElementById("sgoplus-iframe");
        if (sgoPlusIframe !== null) sgoPlusIframe.src = SGOSignature.getIframeURL(data);
        SGOSignature.receiveForm();
    };
</script>    -->
<script src="../js/jquery.validate.min.js"></script>
<script language="javascript">
function keepAngs(){
   $('#hPayText').val($('select[name=lmAngs] option:selected').text());	
}
function calcPoint(pParam) {
	var vHrgJoin = 1;
	var vTotOrder = parseFloat(pParam)  * parseFloat(vHrgJoin);
	//vTotOrder = vTotOrder.toFixed(2);
	$('#hTotal').val(vTotOrder);
	//$('#spTotOrder').html($.number(vTotOrder, 2, ',','.' ));
	//console.log($.number(vTotOrder, 2, ',','.' ));
	
	
	$('#totalpurc').html($.number(vTotOrder, 2, ',','.' ));
	$('#hTot').val(vTotOrder);
	
}

function validRO() {
	//alert($('#hTot').val());
	if(typeof $('#hTotal').val() !== "undefined") {
       return true;
	} else { 
	   alert('Anda belum melakukan order!');
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
		    if (confirm('Anda yakin melakukan Pembayaran '+$('#hPayText').val()+'?')==true) {
				var vValid= validRO();
							
 				if (vValid)
 				   document.frmReg.submit();
				
			} else return false;
			
			
		}
	});
$(document).ready(function(){
 //  alert('ssss');
  // alert($('#hHarga').val());
   $('#caption').html('Entry Point Fund Order <? if ($_SESSION['Priv']=='administrator') echo ' by Admin'; ?>');
   $('#tfTglLahir').datepicker({
                    format: "dd-mm-yyyy"
    });  

 // $.validator.messages.required = '<span style="color:red;font-weight:normal">This field is required!</span>';
  $('#frmReg input, #frmReg textarea,  #frmReg select, #frmReg checkbox, #frmReg radio').not([type="submit"]).not($("#tfNPWP")).not($("#tEmail")).not($("#tfSwift")).not($("#tfEmailSpon")).addClass('required');  
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

    $('#tfSernoSpon').trigger('blur');
	$('#tfPoin').trigger('blur');
	
if ('<?=count($_POST)?>' > 0) {	
  if ( '<?=$lmMethod?>' == 'esp' )  {
	if ('<?=$vVaSuccess?>' == '1' ) {
		
		 $('#paytot').html('<?=$vTotalPay?> (untuk <?=$tfPoin?>)');
		 $('#vanum').html('<?=$vVA?>');
		 $('#texpired').html('<?=$vExpired?>');
		 $('#btmodal').trigger('click');
	} else {
		alert('Penerbitan Invoice gagal, silakan coba lagi!');
		document.location.href='<?=$_SERVER['HTTP_REFERER']?>';
	}
  }
}

	
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
		// $('#totalpurc').html(xTot);  
		 	$('#totalpurc').html($.number(xTot, 2, ',','.' ));
		     /* $('#totalpurc').priceFormat({     
		                    prefix: ' ',
		                    centsSeparator: ',',
		                    thousandsSeparator: '.',
		                    limit: 15,
		                    centsLimit: 0
		       });*/
		 $('#spcurr').html('IDR');      
		 $('#divCurr').hide();
		 $('#lmCurr option:first-child').attr('selected', 'selected');
		 //batasan RO

         var vYMonth='<?=date("Ym")?>';
         var pParam = $('#tfSernoSpon').val();
         $.get('../main/mpurpose_ajax.php?op=checkmultiro&user='+pParam+'&ymonth='+vYMonth,function(data){
             var vTotalRO=parseFloat(data.trim()) + parseFloat($('#hTotJum').val());
		
            // alert(vTotalRO);
             if (vTotalRO > 100000000000) {
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
		 $('#totalpurc').html($.number(xTot, 2, ',','.' ));
		 /*$('#totalpurc').html(xTot);  
		      $('#totalpurc').priceFormat({     
		                    prefix: ' ',
		                    centsSeparator: ',',
		                    thousandsSeparator: '.',
		                    limit: 15,
		                    centsLimit: 0
		       });*/
      
   });
}
  



function checkKitSpon(pParam) {
   if (pParam.value=='')
      return false;
   else {    
   var vCountry=$('#lmCountry').val();
   var vURL="../main/mpurpose_ajax.php?op=mempay";
   var vYes=/yesx/g;
   var vNo=/nox/g;
   var vNamaS='';
   var vNama='';
   $('#loadNama').show();
   $('#statKitSpon').html('&nbsp;<img src="../images/ajax-loader-bar.gif" />');
   $.post(vURL, {sernospon : pParam.value},function(data) {
   
      if (vNo.test(data)) {
	 
         var dataX=data.split('|');
		 // alert(dataX[1]);
         if (dataX[1].trim()=='nomem')
            $('#statKitSpon').html('<font color="#f00">Member Not Valid!</font>');
         else if (dataX[1].trim()=='nonet')   
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
             if(parseFloat(data.trim()) >=100000000000 ) {
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
 <script src="../js/jquery.number.js"></script>
	
	
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



<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" >&times;</button>
        <h4 class="modal-title">Payment</h4>
      </div>
      <div class="modal-body">
        <p><br>Silakan selesaikan pembayaran sebesar <b>Rp <span id="paytot"></span></b><br>
        Transfer ke VIrtual Account bank Permata : <b><span id="vanum"></span></b>
         <br>Batas Waktu  : <b><span id="texpired"></span></b>
        <br>Setelah pembayaran diterima, maka sistem kami akan secara otomatis memproses order Anda!
        <br>Pesan ini juga terkirim ke SMS dan Email Anda.
        <br><br>
        Terima kasih atas kepercayaan Anda!
        <br>Salam Sukses
        
        </p>
        
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onClick="document.location.href='<?=$_SERVER['HTTP_REFERER']?>'">Close</button>
      </div>
    </div>

  </div>
</div>

<div class="right_col" role="main">
		<div><label>
		<h3> Entri Pembayaran </h3></label></div> 

<form method="post" id="frmReg" name="frmReg" action="<?=$_SERVER['PHP_SELF']?>">
	<div class="container">
    <div class="row" style="width:98%;margin-top:8px">
    
     
    
    
        <div class="col-md-12">
               				<!--Panel Body -->
                     
                     							<!-- <div class="divtr">
                            <!-- Panel Sponsor -->

			                    <div class="panel panel-default" id="panelkanan">
									<div class="panel-heading toska" style="background-color:#1D96B2">
										<div class="panel-title ">
											<label for="exampleInputEmail1" style="font-weight:bold;">
											Data Jamaah <?=$vMemberId?> (<?=$vMemberName?>)</label></div>
									</div>
									<div class="panel-body">
										<div class="">
											<label for="exampleInputEmail1">ID 
											Member* 
											<div align="left" style="display:inline" id="statKitSpon">
											</div>
											</label>
											 <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>
												<input readonly value="<?=$vMemberId?>" type="text" class="form-control" id="tfSernoSpon" name="tfSernoSpon" placeholder="Member ID*" onBlur="checkKitSpon(this)" onKeyUp="setUpper(this)">
											</div>
										</div>
										<div class="divtr">
											<img id="loadNama"  align="absmiddle" src="../images/ajax-loader.gif" style="position:absolute;z-index:2;margin-left:45px;margin-top:24px;opacity: 0.5;display:none" />
											<label for="exampleInputEmail1">Nama 
											Jamaah*</label>
											<div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>
												<input readonly type="text" class="form-control" id="tfSponsor" name="tfSponsor" placeholder="Member Name*">
											</div>
										</div>
										<div class="form-group" style="margin-left:-15px" id="phonemailspon">
											<div class="col-lg-6 col-md-6 divtr" >
												<label for="exampleInputEmail1" >
												<span style="font-weight:bold">No Telepon 
												Jamaah*</span></label>
												<div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-mobile"></i></span>
													<input  type="text" class="form-control" id="tfPhoneSpon" name="tfPhoneSpon" placeholder="Member Phone Number*">
												</div>
											</div>
											<div class="col-lg-6 col-md-6 divtr" >
												<label for="exampleInputEmail1" >
												<span style="font-weight:bold">Alamat Email 
												Jamaah</span></label>
												<div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-envelope"></i></span>
													<input readonly type="email" class="form-control" id="tfEmailSpon" name="tfEmailSpon" placeholder="Member's Email Address">
												</div>
											</div>
											
											<div class="col-lg-6 col-md-6 divtr" >
												<label for="exampleInputEmail1" >
												<span style="font-weight:bold">Alamat Surat
												</span></label>
												<div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-envelope"></i></span>
													<textarea  style="padding-left:30px" readonly class="form-control" id="tfAlamat" name="tfAlamat" placeholder="Mailing Address"></textarea>
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
         <input type="hidden" name="hPayText" id="hPayText" value="<?=$vSalProd?>" /> 
<div class="panel panel-default" id="panelkanan">
					                    <div class="panel-heading" >
					                             <div class="panel-title" style="margin-top:-10px">
					                               <div style="font-weight:bold"> 
                            Jumlah Pembayaran : 
                              <input type="text" id="tfPoin" name="tfPoin" class="form-control" dir="rtl" style="width:155px;display:inline" value="0" onKeyUp="calcPoint(this.value)" onBlur="" /> 
                            <span id="spTotOrder"></span>
                           
                            </div>
					                            <span style="display:none"> 
                                                   <br style="display: block;margin: -5px 0;" /><label for="exampleInputEmail1" style="font-size:13px;color:green">Saldo Wallet Product : <?=number_format($vSalProd,0,",",".")?></label>
                                                   <input type="hidden" name="hSalProd" id="hSalProd" value="<?=$vSalProd?>" /> </span>
					                     		</div>
					                     </div>
					                     <div class="panel-body hide">

<div class="table-responsive hide" id="tbPurc">
<table class="table table-striped" >
                            <thead>
                            <tr class="bgtr">
                                <th width="3%" style="height: 23px">#</th>
                                <th width="15%" style="height: 23px">Product Code</th>
                                <th width="25%" style="height: 23px">Product Name</th>
                                <th width="9%" class="hide" style="height: 23px">Ukuran</th>
                                <th width="9%" style="text-align:right; height: 23px;"> Qty</th>
                                <th style="width: 10%; height: 23px;text-align:right"  align="right" class="hide">Item Qty</th>
                                <th style="width: 173px; height: 23px;text-align:right" > Price</th>
                                <th style="width: 92px; height: 23px;text-align:right" >Sub Total</th>
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
								    $vSQL="select distinct fidproduk, fsize, fidcolor, fnamaproduk, fhargajual1,fhargajual2, fsatuan from  m_product   where  faktif='1' and fidcat <>'CAT-0001' order by fidproduk";
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
                                <th style="height: 30px;text-align:right"> 
                                <input name="txtJml" id="txtJml" class="form-control"  type="text" dir="rtl" style="display:none;min-width:55px;text-align:right" size="10" onKeyUp="calcSub(this)" onBlur="calcSub(this)" >                                
                                
                                </th>
                                <th style="height: 30px; width: 10%;text-align:right" align="right" id="thJmlItem" class="hide"> 
                                
                                

                                </th>
                                <th style="width: 104px; height: 30px;text-align:right" id="thHarga" align="right"></th>
                                <th align="right" id="thSubTot" style="height: 30px; width: 94px;text-align:right"></th>
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

										<label style="font-weight:bold">Total Bayar : <span id="totalpurc"></span> <span id="spcurr">IDR</span><span id="samaconvert"></span><span id="convert"></span><span id="currconvert"></span></label> 

       <div class="row">
       
  <div class="col-lg-6 ">
       
         <label style="color:blue" for="lmMethod"><br> 
          Untuk Pembayaran</label>
         <select id="lmAngs" name="lmAngs"  class="form-control" onChange="keepAngs()" >
         <option value="">--Pilih--</option>
         			
     			   <option value="fangsur1">Angsuran 1</option>
                  
                   <option value="fangsur2">Angsuran 2</option>
                   <option value="fangsur3">Angsuran 3</option>
                   <option value="fangsur4">Angsuran 4</option>
                   <option value="fstorawal">Setoran Awal</option>
				   <? if ($vProgram=='19') {?>
				   <option value="voucher">Voucher</option>
				   <? } ?>
                   <option value="flunas">Pelunasan</option>
          </select>
       </div>     
       <div class="col-lg-4 hide">
       
         <label style="color:blue" for="lmMethod">Metode Pembayaran</label>
         <select name="lmMethod" id="lmMethod" class="form-control" onChange="//alert(document.getElementById('hTotal').value)">
           
           <option value="ctr">Cash / Manual Transfer</option>
          <!--  <option value="esp">Transfer ke Virtual Account</option>
          <option value="wpr">Wallet Product</option> -->
           <!-- <option value="wtr">Wallet Product + Cash / Transfer</option> -->
         </select>
       </div>
       </div>									
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
                                        <button id="btnSubmit" type="submit" class="btn btn-primary" disabled="disabled" onClick="submitForm(this)">Submit</button> 
                                        
<button type="button" class="btn btn-info btn-lg hide" id="btmodal" data-toggle="modal" data-target="#myModal">Open Modal</button>                                        
                                        <div id="divLoad" style="display:inline"></div>
                            </div>
                       
 </form>     
 <br>
 <br>
  <br>
 <br>                          
  <br>
 <br>                          
 <br>                          
  <br>
 <br> 

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


<? include_once("../framework/admin_footside.blade.php") ; ?>
