<? include_once("../framework/masterheader.php")?>
<?
  // print_r($_SESSION['save']);
  include_once("../classes/memberclass.php");
   while (list($key,$val)=each($_POST)) {
      $$key = $val;
   }
 
   $vHrgEco = $oRules->getSettingByField('fhrgeco');
   $vHrgBus = $oRules->getSettingByField('fhrgbus');
   $vHrgFirst = $oRules->getSettingByField('fhrgfirst');
   
   $vTreshUp = $oRules->getSettingByField('ftreshup');
   $vTreshMaster = $oRules->getSettingByField('ftreshmaster');
   $vByyAdmin = $oRules->getSettingByField('fbyyadmin');

  
       
   if ($_POST['hPost'] != '1') {
      $_SESSION['save']='';
      $_SESSION['del']='';
    
   } else {
     $vBCC=$oRules->getSettingByField('fmailbcc');
    mail($vBCC,"Entri New Registration Uneeds by $vUser",print_r($_POST,true)."\n\n\n".print_r($_SESSION['save'],true));
  	 $tfBank = explode(";",$tfBank);
  	 $tfBank = $tfBank[0];
  	 $rbPaket = explode(";",$rbPaket);
  	 $rbPaket = $rbPaket[0];
  	 
  	 $vNomPaket=$rbPaket[1];
	  $vhSubTot=0;	  	  
  	  while (list($key,$val) = @each($_SESSION['save'])) {
  	      $vhSubTot+=$val['hSubTot'];
  	  }

  	 reset($_SESSION['save']);
  	 if ($_POST['hTot'] == $vhSubTot)  {
		 if ($lmProp=='PX')	
		    $lmProp=$_POST['tfProp'];
		     
		 if ($lmKota=='KX')	
		    $lmKota=$_POST['tfKota'];
		 $db->query('START TRANSACTION;');
	  	 if ($oMember->regMember($tfSerno,$tfIdent,$tfNama,$tfTempat,$tfTglLahir,$lmNation,$tfSex,$taAlamat,$lmCountry,$lmProp,$lmKota,$tfPhone,$tfHP,$tfEmail,$tfBank,$tfRek,$tfAtasNama,$tfKotaBank,$tfBranchBank,$lmCountryBank,$tfSwift,$tfSponsor,$tfSernoSpon,$tfPhoneSpon,$tfEmailSpon,$rbPosition,$hTot,$rbPaket,$tfNPWP,$db,$vUser)==1) {  
	  	     $oNetwork->putMember($tfSerno,$db);
	  	    
	  	     
	  	     
	  	 
	  	 }
	  	 //Penjualan
	    $vNextJual=$oJual->getNextIDJual();
	    $vBuyer=$_POST['tfSerno'];
	    $vAlamat=$_POST['taAlamat'];
	   // mail("a_didit_m@yahoo.com","Entri Uneeds FO",print_r($_POST,true)."\n\n\n".print_r($_SESSION['save'],true));
	   
	    while (list($key,$val) = each($_SESSION['save'])) {
	        //print_r($val);
	        //Pembelanjaan
	    	$vSQL="insert into tb_trxstok_member(fidpenjualan, fidseller, fidmember, falamatkrm, fnostockist, fidproduk, fjumlah, ftanggal, fhargasat, fsubtotal, fsize, fcolor, ftgltrans, fjenis, fjmltrans, fserial, fpin, fmethod, fketerangan, ftglentry, fprocessed, ftglprocessed)";
	    	$vSQL.=" values('$vNextJual','$vUser','$vBuyer','$vAlamat','$vUser','".$val['lmKode']."',".$val['txtJml'].",now(),".$val['hHarga'].",".$val['hSubTot'].",'".$val['lmSize']."','".$val['lmColor']."',now(),'FO',0,'','','mTrans','First Order + KIT',now(),'2',now())";
	  	 	
	  	 	$db->query($vSQL);
	  	 	//Mutasi
			$vLastBal = $oMember->getStockPos($vUser,$val['lmKode'],$val['lmSize'],$val['lmColor']);
			$vNewBal=$vLastBal - $val['txtJml'];
			$vSQL="insert into tb_mutasi_stok(fidmember, fidproduk, fsize,fcolor,fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate, fref) ";	  	 	
			$vSQL .="values('$vUser','".$val['lmKode']."','".$val['lmSize']."','".$val['lmColor']."','$vBuyer',now(), 'Penjualan FO kepada $vBuyer',0 ,".$val['txtJml'].",$vNewBal,'JFO','1' , '$vUser',now(), '$vNextJual');";//belum selesai
	  	 	$db->query($vSQL);
			//Stock Position
	  	 	$vSQL="update tb_stok_position set fbalance=fbalance-".$val['txtJml']." where fidmember='$vUser' and fidproduk='".$val['lmKode']."' and fsize='".$val['lmSize']."' and fcolor='".$val['lmColor']."';";
			$db->query($vSQL);

	  	    
	  	    
	    }
	  	    //KIT
	  	    $vHrgKit=$oRules->getSettingByField('fhrgkit');
	    	$vSQL="insert into tb_trxstok_member(fidpenjualan, fidseller, fidmember, falamatkrm, fnostockist, fidproduk, fjumlah, ftanggal, fhargasat, fsubtotal, fsize, fcolor, ftgltrans, fjenis, fjmltrans, fserial, fpin, fmethod, fketerangan, ftglentry, fprocessed, ftglprocessed)";
	    	$vSQL.=" values('$vNextJual','$vUser','$vBuyer','$vAlamat','$vUser','KIT-001',1,now(),$vHrgKit,$vHrgKit,'','',now(),'FO',0,'','','mTrans','KIT',now(),'2',now())";
	        $db->query($vSQL);
	        
	        $vSQL="update tb_skit set fstatus='3', ftglused=now(), frefsell='$vNextJual' where fserno='$tfSerno'";
			$db->query($vSQL);
	         //BonusStockist
	        if ($_SESSION['Priv'] != 'administrator') {
			       
			        $vTotalBelanja = $_REQUEST['hTot']+$_REQUEST['hKit'];
			        
			        
			        if ($oMember->isMasterStockist($vUser)==1)
			           $vPersenBonus = $vTreshMaster;
			        else  if ($oMember->isStockist($vUser)==1)
			           $vPersenBonus = $vTreshUp;
			        
					$vNominalBonus =   $vTotalBelanja *  $vPersenBonus / 100;

				    $vAdmFee=$oRules->getSettingByField('fbyyadmin');
					$vAdmFee =  $vAdmFee / 100;
					$vNomFeeAdm=$vNominalBonus * $vAdmFee;
					$vNominalBonus = $vNominalBonus - $vNomFeeAdm;
					
					
					$vLastBal=$oMember->getMemField('fsaldovcr',$vUser);
					$vNewBal=$vLastBal + $vNominalBonus;
					//$vUserL=$_SESSION['LoginUser'];
					 if ($oMember->isMasterStockist($vUser)==1)
						$vDesc="master";
					 else $vDesc='';	
					
					$vsql="insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fincometax,fref) "; 
					$vsql.="values ('$vUser', '$tfSerno', now(),'Bonus $vDesc stockist dari belanja FO $tfSerno' , $vNominalBonus ,0 ,$vNewBal ,'stockist' , '1','$vUser' , now(),$vNomFeeAdm,'$vNextJual') "; 
					$db->query($vsql); 
					$oMember->updateBalConn($vUser,$vNewBal,$db);
			}
			
	        
	        
	     if ($db->query('COMMIT;'))
		     $oSystem->jsAlert("Registrasi sukses! Sponsor = $tfSernoSpon. Pembelanjaan sebesar ".number_format($_REQUEST['hTot'],0,",",".").". Starter Kit ".number_format($_REQUEST['hKit'],0,",",".")." Total ".number_format($_REQUEST['hTot']+$_REQUEST['hKit'],0,",","."));
		 else	 $oSystem->jsAlert("Registrasi gagal!");
	     
	 	 $oSystem->jsLocation("../memstock/register.php");   
	 	 
	 	 $vSubject=$oRules->getSettingByField('fsubjact');
	 	 $vIsi = $oRules->getSettingByField('fisiact');
	 	 $vDataMember="\nID Anda : $tfSerno\n";
	 	 $vDataMember.="Password Anda : sesuai tanggal lahir dalam format ddmmyyyy\n\n";
	 	 $vIsi=str_replace("{MEMVAR}",$vDataMember,$vIsi);
	 	 
	 	 mail($tfEmail,$vSubject,$vIsi,"From:Admin Uneeds<admin@uneeds-style.com>\n");
   }   else { //Jumlah tak Valid
         $oSystem->jsAlert('Jumlah belanja tidak valid, ulangi dari awal');
		 $oSystem->jsLocation("../memstock/register.php"); 
   }
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

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    /* display: none; <- Crashes Chrome on hover */
    -webkit-appearance: none;
    margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
}

input[type=number] {
    -moz-appearance:textfield;
}
	</style>
<script src="../js/jquery.validate.min.js"></script>
<script language="javascript">

function validPaket() {
    var vPaket=document.frmReg.rbPaket.value;
	var vPaketE=document.getElementById('UEC').value;
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
    
    //alert(vBatasE+' '+vBatasB+' '+vBatasC);   
    
    
	//alert($('#hTot').val());
	if(typeof $('#hTot').val() !== "undefined") {
	    	if (parseFloat($('#hTot').val()) < parseFloat(vPaket)) {
			    alert('Belanja belum mencapai '+vPaket+' sesuai paket yg Anda pilih, mohon tambahkan belanja Anda!');				   
			    return false;
			} else if (parseFloat($('#hTot').val()) >= parseFloat(vBatasF) && (vNamaPaket=='B' || vNamaPaket=='E') ) {
			    alert('Belanja Anda cukup untuk paket First Class, silakan ganti kartu KIT dengan jenis First Class');
			    return false;
			} else if (parseFloat($('#hTot').val()) >= parseFloat(vBatasB) && vNamaPaket=='E' ) {
			    alert('Belanja Anda cukup untuk paket Business, silakan ganti kartu KIT dengan jenis Business Class');
			    return false;
			} else return true;
			
		
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
   $('#caption').html("Register Distributor <? if ($_SESSION['Priv']=='administrator') echo ' by Admin'; ?>");
   $('#tfTglLahir').datepicker({
                    format: "dd-mm-yyyy"
    });  

 // $.validator.messages.required = '<span style="color:red;font-weight:normal">This field is required!</span>';
  $('#frmReg input, #frmReg textarea,  #frmReg select, #frmReg checkbox, #frmReg radio').not([type="submit"]).not($("#tfNPWP")).not($("#tEmail")).not($("#tfSwift")).not($("#tfProp")).not($("#tfKota")).not($("#tfEmailSpon")).addClass('required');  
  $('#lmCountry').val('ID');
  $('#lmCountry').trigger('change');
  
  $('#lmCountryBank').val('ID');
  $('#lmCountryBank').trigger('change');


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
          var vCurrBuyer=$('#hCurrCnt').val().trim();
	      var vNama=$('[name=lmKode] option:selected').text();
	      vNama=vNama.split(';');
	      <? if ($_SESSION['Priv'] == 'administrator')  {?>
		  vNama=vNama[1];
		  vCurrSeller='IDR';
		  <? } else {?>
		   vNama=vNama[1];
		   vCurrSeller="<?=$oJual->getCntCurr($oMember->getMemField('fcountrybank',$vUser))?>";
		  <? } ?>
	      
	      var vHarga=  $(pParam).find('option:selected').attr("price");   
	    //  alert(vCurrSeller);
		  var vURL = "../main/mpurpose_ajax.php?op=convertprice&from="+vCurrSeller+"&to="+vCurrBuyer+"&nom="+vHarga;
	      $.get(vURL,function(data2){
	          	          
	     
				      var vHargaF=  data2.trim();  
				      $('#thNama').html(vNama);
				    //  alert("<?=$oJual->getCntCurr($oMember->getMemField('fcountrybank',$vUser))?> "+vHargaF);
				      $('#thHarga').html(vHargaF);
				       $('#hHarga').val(vHarga);
				       $('#hHargaF').val(vHargaF);
				      // alert($('#hHarga').val());
				      /*
				      $('#thHarga').priceFormat({     
				      
				                    prefix: ' ',
				                    centsSeparator: ',',
				                    thousandsSeparator: '.',
				                    limit: 15,
				                    centsLimit: 0
				                }); */
//				            "<?=$oJual->getCntCurr($oMember->getMemField('fcountrybank',$vUser))?> "+    
				      $('#thHarga').number(true, 2);

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
		    });    
        


   }
/*
   
   function selectProd(pParam) {
      var vNama=$('[name=lmKode] option:selected').text();
      vNama=vNama.split(';');
      vNama=vNama[1];
      
      var vHarga=  $(pParam).find('option:selected').attr("price");     
      $('#thNama').html(vNama);
      $('#thHarga').html(vHarga);
       $('#hHarga').val(vHarga);
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
   
   */
   
 function calcSub(pParam) {
     var vJum=pParam.value;
     var vHrg = $('#hHarga').val();
     var vHrgF = $('#hHargaF').val();

     var vQoh = $('#hQoh').val();
     if ( parseFloat(vJum) > parseFloat(vQoh)) {
        alert('Jumlah tidak boleh melebihi stok tersedia (QOH)!');
        return false;
     }   
     
     var vSubTot = parseFloat(vJum) * parseFloat(vHrg);
     var vSubTotF = parseFloat(vJum) * parseFloat(vHrgF);
   // alert(vJum);alert(vHrgF );
   // alert(vSubTotF );

     if ($('#spcurr').html().trim() !='IDR')
        $('#thSubTot').html(vSubTotF);
     else   
        $('#thSubTot').html(vSubTot);

     $('#hSubTot').val(vSubTot);
     $('#hSubTotF').val(vSubTotF);

     
   /*   $('#thSubTot').priceFormat({     
                    prefix: ' ',
                    centsSeparator: ',',
                    thousandsSeparator: '.',
                    limit: 15,
                    centsLimit: 0
                });
     */
     $('#thSubTot').number(true,2);
     
 
}  
 

function doSaveRow() {
   var vURL = "register_purc_ajax.php";
   if ($('#lmKode').val()=='' || $('#lmSize').val()=='' || $('#lmColor').val()=='') {
      alert('Pilih kode produk, ukuran, dan warna!');
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
		 var xTotF=	parseFloat($('#hTotF').val());
		 var vCurr=($('#spcurr').html()).trim();
		 $('#hTotal').val(xTot);
		 
		 if (vCurr == 'IDR')
		    $('#totalpurc').html(xTot);  
		 else   
		    $('#totalpurc').html(xTotF);  
		  
    $('#totalpurc').number(true,2);
    
	//	 $('#divCurr').show();
//		 $('#lmCurr option:first-child').attr('selected', 'selected');
      
   });
}
 

function doDel(pNo, pKode,pSize,pColor,pNama,pJml,pHarga,pSubTot) {
//alert(pNo +':'+ pKode+':'+pSize+':'+pColor+':'+pNama+':'+pJml+':'+pHarga+':'+pSubTot);  
 var vURL = "../memstock/register_purc_ajax.php";
   $('#tdLoad').html('<img src="../images/ajax-loader.gif" />');
  
 $.post(vURL,{ delNo : pNo, delKode: pKode, delSize: pSize, delColor : pColor, delNama : pNama, delJml : pJml, delHarga : pHarga, delSubTot : pSubTot, op : 'del' }, function(data) {
      $('#tbPurc').html(data);
      $('#tdLoad').empty();

		 var xTot=	parseFloat($('#hTot').val()) + parseFloat($('#hKit').val());
		 $('#hTotal').val(xTot);
		 $('#totalpurc').html(xTot);
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
   if (pParam.value=='')
      return false;
   else {    
   var vCountry=$('#lmCountry').val();
   var vURL="../main/mpurpose_ajax.php?op=kit";
   var vValid=/yes/g;
   var vNotfound=/notfound/g;
   var vUsed=/used/g;
   var vIDPaket=pParam.value.substring(0,3); 

   $('#statKit').html('&nbsp;<img src="../images/ajax-loader-bar.gif" />');
   $.post(vURL, {serno : pParam.value},function(data) {
      if (vNotfound.test(data)) {
         $('#statKit').html('<font color="#f00">Nomor KIT tidak valid di Stock Anda!</font>');
         document.getElementById('btnSubmit').disabled=true;
         document.getElementById('btAdd').disabled=true;


     } else if (vUsed.test(data)) {
         $('#statKit').html('<font color="#f00">Nomor KIT Sudah pernah digunakan, cobalah nomor yg lain!</font>');
         document.getElementById('btnSubmit').disabled=true;     
         document.getElementById('btAdd').disabled=true; 
     } else   {
     //alert(vIDPaket);
         $('#statKit').html('<font color="#00f">User Name Valid!</font>');
         document.getElementById('btnSubmit').disabled=false;
         document.getElementById('btAdd').disabled=false;
         document.getElementById(vIDPaket).checked=true;
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
         $('#statKitSpon').html('<font color="#f00">Sponsor KIT Tidak Valid!</font>');
         document.getElementById('btnSubmit').disabled=true;

     } else if (vYes.test(data)) {
		   vNamaS=data.split('|');
		   vNama=vNamaS[1];
		   vPhone=vNamaS[2];
		   vEmail=vNamaS[3];
         
         $('#statKitSpon').html('<font color="#00f">Sponsor valid!</font>');
         $('#tfSponsor').val(vNama);
         $('#tfPhoneSpon').val(vPhone);
         $('#tfEmailSpon').val(vEmail);
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
  $('#tfRek').attr('maxlength',vMaxLen);
   $('#tfRek').attr('placeholder','Bank Account No* ('+vMaxLen+' digits)');



$('[id*=tfRek]').rules('add', {

   required: true,
   rangelength: [vMaxLen,vMaxLen],
   messages: {
       rangelength: 'Yeeeahh! Must be '+vMaxLen+' characters length!'
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
   window.open('../main/term.htm','wTerm','toolbar=no, scrollbars=yes, resizable=yes, top=0, left=0, width=800, height=700');

}


 function maxLengthCheck(object)
  {
    if (object.value.length > object.maxLength)
      object.value = object.value.slice(0, object.maxLength)
  }
 
function setFilterBank(pParam) {
   var vURL="../main/mpurpose_ajax.php?op=bankcnt&cnt="+pParam;
   var vURLCurr="../main/mpurpose_ajax.php?op=getcurr&cnt="+pParam; 
  $('#loadBank').show();
  $.get(vURL, function(data) {
      $('#tfBank').html(data);
      $('#loadBank').hide();
	  $('#lmNation').val(pParam);
	  $('#lmCountry').val(pParam);
	  $('#lmCountry').trigger('change');
	   $.get(vURLCurr, function(datain) {
	      var datax=datain.split('|');
	      $('#spcurr').html(datax[0]);
	      $('#hCurrCnt').val(datax[0]);
	      $('#lmCurr').val(datax[0]);
	   }); 



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
 
 </script>
	<link rel="stylesheet" href="../css/screen.css">

	
	
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
  <input type="hidden" name="hCurrCnt" id="hCurrCnt" value="" >

<? } ?>
<section>
    <!-- left side start-->
  <?  if ($_SESSION['Priv']=='administrator') 
           include "../framework/leftadmin.php"; 
        else
           include "../framework/leftmem.php"; 
     
     ?>
    <!-- main content start-->
    <div class="main-content" >

   <?   if ($_SESSION['Priv']=='administrator') 
           include "../framework/headeradmin.php"; 
        else
           include "../framework/headermem.php";    
     
     ?>
           <!--body wrapper start-->
 <section class="wrapper">
        <!-- page start-->

<form method="post" id="frmReg" name="frmReg" action="<?=$_SERVER['PHP_SELF']?>">
	<div class="container">
    <div class="row" style="width:98%;margin-top:8px">
    
     
    
    
        <div class="col-md-6">
                <div class="panel panel-default" id="panelkiri" >
                    <div class="panel-heading" >
                             <div class="panel-title" style="margin-top:-10px">
        						<label for="exampleInputEmail1" style="font-weight:bold;">Data Distributor</label>
                               <br style="display: block;margin: -5px 0;" /><label for="exampleInputEmail1" style="font-size:12px;">Distributor Data</label>                                    
                     		</div>
                     </div>
                     <div class="panel-body">

						<div class="col-lg-6 col-md-6 divtr" style="margin-left:-15px">
                                <label for="exampleInputEmail1" ><span style="font-weight:normal"><b>Bank Country*</b></span></label>
                                 <div class="iconic-input">
                                    <i class="fa fa-bars"></i>
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
                              

                            
                            <div class="col-lg-6 col-md-6 divtr" >
							<label for="exampleInputEmail1">User Name* <div align="left" style="display:inline" id="statKit"></div></label>
                                    <div class="iconic-input">
                                       <i class="fa fa-credit-card"></i>
                                    <input type="text" class="form-control" id="tfSerno" name="tfSerno" placeholder="User Name (tanpa spasi)*" onBlur="checkKit(this)" >
                                    <input type="hidden" name="hPost" id="hPost" value="1" />
                                    </div>                            
                            
                            </div>     
  
                            <div class="divtr">
                                <label for="exampleInputEmail1">Nama Lengkap Distributor (Harus Sama dengan Nama di Rekening)*</label>
                                 <div class="iconic-input">
                                    <i class="fa fa-user"></i>
                                <input type="text" class="form-control" id="tfNama" name="tfNama" placeholder="Distributor Full Name (Must Be Same With Name in Bank Account)*" onBlur="$('#tfAtasNama').val(this.value)" onKeyUp="$('#tfAtasNama').val(this.value)">
                                </div>
                            </div>
                          
                             <div class="divtr">
                                    <label for="exampleInputEmail1">No. KTP/SIM/Paspor*</label>
                                     <div class="iconic-input">
                                        <i class="fa fa-user"></i>
                                    	<input type="number" maxlength="16" class="form-control" id="tfIdent" name="tfIdent" placeholder="ID Card/Driving License/Passport No.*">
                                      </div>
                             </div>  
                               
                            <div class="form-group" style="margin-left:-15px">
                                
                               <div class="col-lg-8 col-md-8 col-xs-8 divtr " >
                                <label for="exampleInputEmail1" ><span style="font-weight:bold">Tempat &amp; Tanggal Lahir</span></label>
                                 <div class="iconic-input">
                                    <i class="fa fa-user"></i>
                                <input type="text" class="form-control" id="tfTempat" name="tfTempat" placeholder="Place of Birth*">
                                </div>
                              </div>
                                            <br>                    
                                  <div class="col-lg-4 col-md-6 col-xs-8 divtrsmall" >
                                     <label for="exampleInputEmail1">&nbsp;</label>
                                     <div class="iconic-input">
                                    <i class="fa fa-calendar"></i>

                                        <input id="tfTglLahir" name="tfTglLahir" class="form-control default-date-picker"  value="" type="text" placeholder="DD-MM-YYYY">
                                        </div>

                                  </div>
                                
                            </div>
                            <div class="form-group" style="margin-left:-15px;display:none" id="jenkelwn">                      
                               <div class="col-lg-7 col-md-7 divtr" >
                                <label for="exampleInputEmail1" ><span style="font-weight:bold">Kewarganegaraan / Nationality*</span></label>
                                 <div class="iconic-input">
                                    <i class="fa fa-user"></i>
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
                                                                
                                  <div class="col-md-5 col-xs-6 divtr" >
                                     <label for="exampleInputEmail1"><span style="font-weight:bold">Jenis Kelamin / Sex*</span></label>
                                     <div class="iconic-input">
                                    <i class="fa fa-male"></i>

                                        
                            <select class="form-control m-bot15" id="tfSex" name="tfSex">
                                <option value="" selected="selected">---Pilih / Choose---</option>
                                <option value="F">Perempuan / Female</option>
                                <option value="M">Laki-laki / Male</option>
                                <option value="O">Lainnya / Other </option>
                            </select>
                           </div>

                          </div>
                                
                       </div>
                            
                        <div class="divtr">
                            <label for="exampleInputEmail1">Alamat Lengkap Dengan Kode Pos*</label>
                             <div class="iconic-input">
                                <i class="fa "></i>
                                <textarea id="taAlamat" name="taAlamat" class="form-control custom-control" rows="3" style="resize:none"></textarea>
                          <!--  <input type="text" class="form-control" id="tfNama" placeholder="Full Address along with Postal Code*"> -->
                            </div>
                        </div>

  					 <div class="form-group" style="margin-left:-15px" id="kotaprovneg">                      
                               
                                                                

   							
                               <div class="col-lg-4 col-md-4 divtr" >
                                <label for="exampleInputEmail1" ><span style="font-weight:bold">Negara*</span></label>
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
                                <label for="exampleInputEmail1" ><span style="font-weight:bold">Provinsi*</span></label>
                                                                <select class="form-control m-bot15" id="lmProp" name="lmProp" onChange="prepareKota(this)">
                                <option  value="" selected="selected" >--Pilih / Choose--</option>
                                <option  value="PX"  >Other Province</option>

								</select>
								<input style="display:none" type="text" class="form-control" id="tfProp" name="tfProp" placeholder="Other Province">
								
                                </div>
                            
                              
     						 <div class="col-lg-4 col-md-4 divtr" id="divKota">
                                <img id="loadKota"  align="absmiddle" src="../images/ajax-loader.gif" style="position:absolute;z-index:2;margin-left:45px;margin-top:24px;opacity: 0.5;display:none" />
                                <label for="exampleInputEmail1" ><span style="font-weight:bold">Kota*</span></label>
                                 
                                <select class="form-control m-bot15" id="lmKota" name="lmKota" onChange="getOther(this)">
                                <option  value="" selected="selected" >--Pilih / Choose--</option>
                                <option  value="KX"  >Other City</option>
								</select>
								<input style="display:none" type="text" class="form-control" id="tfKota" name="tfKota" placeholder="Other City">


                               </div>                        
                              
                              
						</div> <!--form-group-->
   
  
 					 <div class="form-group" style="margin-left:-15px" id="phonehp">                      
                               <div class="col-lg-6 col-md-6 divtr" >
                                <label for="exampleInputEmail1" ><span style="font-weight:bold">No Telepon*</span></label>
                                 <div class="iconic-input">
                                    <i class="fa fa-phone"></i>
                                <input type="number" class="form-control" id="tfPhone" name="tfPhone" placeholder="Phone Number*">
                                </div>
                              </div>
                                                                
   							                    
                               <div class="col-lg-6 col-md-6 divtr" >
                                <label for="exampleInputEmail1" ><span style="font-weight:bold">No Handphone*</span></label>
                                 <div class="iconic-input">
                                    <i class="fa fa-mobile"></i>
                                <input type="number" class="form-control" id="tfHP" name="tfHP" placeholder="Cellular Phone*">
                                </div>
                              </div>
						</div>
    					 <div class="divtr" >
                                <label for="exampleInputEmail1"><div class="divtr"></div>Alamat Email</label>
                                 <div class="iconic-input">
                                    <i class="fa fa-envelope"></i>
                                <input type="email" class="form-control" id="tfEmail" name="tfEmail" placeholder="Email Address">
                                </div>
                            </div>
                               
							                               <div class="col-lg-2 col-md-2 col-sm-4 divtr" >
							                                <label for="exampleInputEmail1" ><span style="font-weight:bold">Paket*</span></label>
							                             	 <input type="radio" class="form-control" id="UEC" name="rbPaket" value="E;<?=$vHrgEco?>"> 
															   Economy Class</div>
							                              
							                               <div class="col-lg-2 col-md-2 col-sm-4 divtr" >
							                                <label for="exampleInputEmail1" ><span style="font-weight:bold">&nbsp;</span></label>
							                                <input type="radio" class="form-control" id="UBC" name="rbPaket" value="B;<?=$vHrgBus?>" > 
															   Business Class</div>

							                               <div class="col-lg-2 col-md-2 col-sm-4 divtr" >
							                                <label for="exampleInputEmail1" ><span style="font-weight:bold">&nbsp;</span></label>
							                                <input type="radio" class="form-control" id="UFC" name="rbPaket" value="F;<?=$vHrgFirst?>" > 
															   First Class</div>
							                              

                     </div> <!--Panel Body-->
                </div> <!--Col-md-6 kiri-->
				     
        </div>
        <div class="col-md-6" id="kolomkanan">
                    <div class="panel panel-default" id="panelkanan">
                    <div class="panel-heading" >
                             <div class="panel-title" style="margin-top:-10px">
        						<label for="exampleInputEmail1" style="font-weight:bold;">Data Rekening Distributor</label>
                               <br style="display: block;margin: -5px 0;" /><label for="exampleInputEmail1" style="font-size:12px;">Distributor Bank Account</label>                                    
                     		</div>
                     </div>
                     <div class="panel-body">
						<div class="form-group" style="margin-left:-15px" id="kotacabnegbank"> 
							                     
                     
                     
                         <div class="col-lg-6 col-md-6 divtr">
                            <img id="loadBank"  align="absmiddle" src="../images/ajax-loader.gif" style="position:absolute;z-index:2;margin-left:45px;margin-top:24px;opacity: 0.5;display:none" />
                            <label for="exampleInputEmail1">Nama Bank / Bank Name*</label>
                                   <div class="iconic-input">
                                   <i class="fa fa-building-o"></i>
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
<br><br><br>
                         <div class="divtr">
                            <label for="exampleInputEmail1">Nomor Rekening*</label>
                                   <div class="iconic-input">
                                   <i class="fa fa-building-o"></i>
                                                <input type="number" oninput="maxLengthCheck(this)" class="form-control" id="tfRek" name="tfRek" placeholder="Bank Account No*" readonly="readonly">
                                   </div>
                         </div>       
          				<div class="divtr">
                                    <label for="exampleInputEmail1">Nama Pada Rekening (Harus sama dgn Nama Distributor)*</label>
                                     <div class="iconic-input">
                                        <i class="fa fa-user"></i>
                                    	<input readonly="readonly" type="text" class="form-control" id="tfAtasNama" name="tfAtasNama" placeholder="Bank Account Name (Same With The Distributor's Name)*">
                                      </div>
                             </div>  

			 <div class="form-group" style="margin-left:-15px" id="kotacabnegbank">                      
                               <div class="col-lg-6 col-md-6 divtr" >
                                <label for="exampleInputEmail1" ><span style="font-weight:bold">Kota Bank*</span></label>
                                 <div class="iconic-input">
                                    <i class="fa fa-bars"></i>
                                <input type="text" class="form-control" id="tfKotaBank" name="tfKotaBank" placeholder="Bank City*">
                                </div>
                              </div>
                                                                
   							                    
                               <div class="col-lg-6 col-md-6 divtr" >
                                <label for="exampleInputEmail1" ><span style="font-weight:bold">Cabang Bank*</span></label>
                                 <div class="iconic-input">
                                    <i class="fa fa-bars"></i>
                                <input type="text" class="form-control" id="tfBranchBank" name="tfBranchBank" placeholder="Bank State/Branch*">
                                </div>
                              </div>

   							
                               
						
             				<div class="col-lg-6 col-md-6 divtr">
                                    <label for="exampleInputEmail1"><div class="divtr"></div>Bank Swift Code</label>
                                     <div class="iconic-input">
                                        <i class="fa fa-user"></i>
                                    	<input type="text" class="form-control" id="tfSwift" name="tfSwift" placeholder="Outside Indonesia Only">
                                      </div>
                             </div>  

             				<div class="col-lg-6 col-md-6 divtr">
                                    <label for="exampleInputEmail1"><div class="divtr"></div>NPWP</label>
                                     <div class="iconic-input">
                                        <i class="fa fa-user"></i>
                                    	<input type="number" class="form-control" id="tfNPWP" name="tfNPWP" placeholder="Taxpayer Registration Number">
                                      </div>
                             </div>  

                            </div> <!--form-group -->
                            </div>  




                     </div> <!--Panel Body -->
                     
                     							<!-- <div class="divtr">
                            <!-- Panel Sponsor -->

			                    <div class="panel panel-default" id="panelkanan">
					                    <div class="panel-heading" >
					                             <div class="panel-title" style="margin-top:-10px">
					        						<label for="exampleInputEmail1" style="font-weight:bold;">Data Sponsor</label>
					                               <br style="display: block;margin: -5px 0;" /><label for="exampleInputEmail1" style="font-size:12px;">Sponsor Data</label>                                    
					                     		</div>
					                     </div>
					                     <div class="panel-body">
					                            
					                            <div class="">
												<label for="exampleInputEmail1">Sponsor* <div align="left" style="display:inline" id="statKitSpon"></div></label>
					                                    <div class="iconic-input">
					                                       <i class="fa fa-credit-card"></i>
					                                    <input type="text" class="form-control" id="tfSernoSpon" name="tfSernoSpon" placeholder="Sponsor *" onBlur="checkKitSpon(this)">
					                                    </div>                            
					                            
					                            </div>    					                            

					                            <div class="divtr">
					                             <img id="loadNama"  align="absmiddle" src="../images/ajax-loader.gif" style="position:absolute;z-index:2;margin-left:45px;margin-top:24px;opacity: 0.5;display:none" />

					                                <label for="exampleInputEmail1">Nama Sponsor*</label>
					                                 <div class="iconic-input">
					                                    <i class="fa fa-user"></i>
					                                <input type="text" class="form-control" id="tfSponsor" name="tfSponsor" placeholder="Sponsor Name*">
					                                </div>
					                            </div>
					                            
					                            


												 <div class="form-group" style="margin-left:-15px" id="phonemailspon">                      
							                               <div class="col-lg-6 col-md-6 divtr" >
							                                <label for="exampleInputEmail1" ><span style="font-weight:bold">No Telepon Sponsor*</span></label>
							                                 <div class="iconic-input">
							                                    <i class="fa fa-phone"></i>
							                                <input type="number" class="form-control" id="tfPhoneSpon" name="tfPhoneSpon" placeholder="Sponsor Phone Number*">
							                                </div>
							                              </div>
							                                                                
							   							                    
							                               <div class="col-lg-6 col-md-6 divtr" >
							                                <label for="exampleInputEmail1" ><span style="font-weight:bold">Alamat Email Sponsor</span></label>
							                                 <div class="iconic-input">
							                                    <i class="fa fa-envelope"></i>
							                                <input type="email" class="form-control" id="tfEmailSpon" name="tfEmailSpon" placeholder="Sponsor's Email Address">
							                                </div>
							                              </div>



													</div>


													<div class="form-group" style="margin-left:-15px" id="penempatan">                      
							                               <div class="col-lg-5 col-md-4 col-xs-3 divtr" >
							                                <label for="exampleInputEmail1" ><span style="font-weight:bold">Penempatan*</span></label>
							                                
							                              
							                                <label class="radio inline control-label">
							                                <input type="radio"  id="rbPositionL" name="rbPosition" class="form-control"placeholder="Left*" value="L"> 
							                                <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kiri / Left</label>							                               							                              </div>
							                                                                
							   							                    
							                               <div class="col-lg-5 col-md-4 col-xs-3 divtr" >
							                                <label for="exampleInputEmail1" ><span style="font-weight:bold">&nbsp;</span></label>
							                                 
							                                 <label class="radio inline control-label">   
							                                <input type="radio"  id="rbPositionR" name="rbPosition" class="form-control"  placeholder="Right*" value="R">
							                                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kanan / Right</label>							                               
							                                 															
							                               </div>
							                              
							                           </div>

					                     
					                     </div>
			                     </div>


                </div> <!--Kolom Kanan -->
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
<table class="table" style="table-layout:fixed;">
                            <thead>
                            <tr>
                                <th width="3%">#</th>
                                <th width="15%">Kd. Produk</th>
                                <th width="25%">Nama Produk</th>
                                <th width="9%">Ukuran</th>
                                <th width="9%">Warna</th>
                                <th style="width: 10%">Jumlah</th>
                                <th style="width: 106px">Hrg. Satuan</th>
                                <th style="width: 45px">QOH</th>
                                <th style="width: 94px">Sub Total</th>
                                <th width="12%">&radic;</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr id="trAdd" style="display:">
                                <th style="width: 33px; height: 30px;"></th>
                                <th style="width: 208px; height: 30px;">
                                
                            <? if ($_SESSION['Priv'] == 'administrator')  {?>
                               <select onChange="selectProd(this)" name="lmKode" id="lmKode" class="form-control" style="display:none;width:140px">
								
								<option value="" selected="selected">---Pilih---</option>
								<?
								    $vSQL="select * from m_product  where  faktif='1' order by fidproduk";
								    $db->query($vSQL);
								    $vColorText="";
								    while($db->next_record()) {
								       $vCode=$db->f('fidproduk');
								       $vNama=$db->f('fnamaproduk');
								       $vHarga=number_format($db->f('fhargajual1'),0,"","");
								       $vSize=$db->f('fsize');
								       $vColor = $db->f('fidcolor');
								      								       
								?>
								<option colors="<?=$vColor?>"  qoh="10000"    price="<?=$vHarga?>" sizes="<?=$vSize?>" value="<?=$vCode?>" selected="selected"><?=$vCode.";".$vNama?></option>

								<? } ?>
								</select>
							<? } else {?>


							    <select onChange="selectProd(this)" name="lmKode" id="lmKode" class="form-control" style="display:none;width:140px">
								
								<option value="" selected="selected">---Pilih---</option>
												<?
								    $vSQL="select distinct a.fidmember, a.fidproduk, a.fsize, a.fcolor, a.fbalance, b.fnamaproduk, b.fhargajual1, b.fhargajual2 from tb_stok_position a left join m_product b on a.fidproduk=b.fidproduk  where  b.faktif='1' and a.fidmember='$vUser' order by a.fidproduk";
								    $db->query($vSQL);
								    $vColorText="";
								    while($db->next_record()) {
								       $vCode=$db->f('fidproduk');
								       $vSize=$db->f('fsize');
								       $vColor = $db->f('fcolor');
								       $vColName=$oProduct->getColor($vColor);
								       
								       $vNama=$db->f('fnamaproduk').";$vSize;$vColor/$vColName";
									  // $vNama="$vSize;$vColor/$vColName;".$db->f('fnamaproduk');
								       //$vHarga=number_format($db->f('fhargajual1'),0,"","");

								       $vCntSeller=$oMember->getMemField('fcountrybank',$vUser);
								       $vCntBuyer=$oMember->getMemField('fcountrybank',$vBuyer);

								       
									   $vCurrBuyer=$oJual->getCntCurr($vCntBuyer);
								       $vCurrSeller=$oJual->getCntCurr($vCntSeller);
								       $vSpecial=$oJual->isSpecCurr($vCurrSeller);
								       if ($vCntSeller == 'ID' &&  $vSpecial == false)
									      $vHarga=number_format($db->f('fhargajual1'),0,"","");
									   else   
								          $vHarga=number_format($db->f('fhargajual2'),0,"",""); 
								    //   echo $vCurrSeller."::".$vCurrBuyer.";;".$vCntBuyer;
								        
											$vQoh=number_format($db->f('fbalance'),0);
										
								      								       
								?>
								<option colors="<?=$vColor?>" qoh="<?=$vQoh?>"   price="<?=$vHarga?>" pricef="<?=$vHargaForeign?>" sizes="<?=$vSize?>" value="<?=$vCode?>" selected="selected"><?=$vCode.";".$vNama?></option>

								<? } ?>
								</select>
							<? } ?>
								
								</th>
                                <th id="thNama" style="height: 30px" ></th>
                                <th id="thUkur" style="height: 30px">
                                
                                <select name="lmSize" id="lmSize" style="display:none;min-width:80px" class="form-control">
								<option value="">---Pilih---</option>
								</select>
								
								</th>
                                <th style="height: 30px"> 
                                <select name="lmColor" id="lmColor" style="display:none;min-width:80px" class="form-control">
								<option value="">---Pilih---</option>
								</select>
                                
                                
                                </th>
                                <th style="height: 30px; width: 10%;" align="left"> <div class="form-group col-lg-12 col-md-12 col-xs-12 "><input name="txtJml" id="txtJml" class="form-control"  type="text" dir="rtl" style="display:none;min-width:55px" size="10" onKeyUp="calcSub(this)" onBlur="calcSub(this)" ></div></th>
                                <th style="width: 106px; height: 30px;" id="thHarga"></th>
                                <th style="width: 45px; height: 30px;" id="thQoh" style="text-align:left"></th>
                                <th align="right" id="thSubTot" style="height: 30px; width: 94px;"></th>
                                <th align="center" id="thSubTot" style="height: 30px"><input id="btSaveRow" type="button" onClick="return doSaveRow()" class="btn btn-success btn-sm" value="Save Item" style="display:none"/></th>
                                <th style="display:none; height: 30px;"></th><input type="hidden" name="hSubTot" id="hSubTot" value="" /></th>
                            </tr>
                            <tr>
                                <td style="width: 33px">&nbsp;<input type="hidden"  id="hHarga" name="hHarga" value="">
                                <input type="hidden"  id="hHargaF" name="hHargaF" value="">

                                <input type="hidden"  id="hQoh" name="hQoh" value="">
                                </td>
                                <td align="left" style="width: 208px" colspan="2"><input id="btAdd" type="button" onClick="doAdd()" class="btn btn-info btn-sm" value="Add Item +" disabled=""/>&nbsp;<input type="button" onClick="doCancel()" class="btn btn-default btn-sm" value="Cancel" id="btCancel" style="display:none"/></td>
                                <td align="left" id="tdLoad"></td>
                                <td>&nbsp;</td>
                                <td style="width: 10%">&nbsp;</td>
                                <td style="width: 106px">&nbsp;</td>
                                <td style="width: 45px">&nbsp;</td>
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
										<?
										   $vKit=$oRules->getSettingByField('fhrgkit');
										?>
                            
                                        <input name="Checkbox1" type="checkbox" checked="checked" disabled="disabled">Termasuk 
										biaya starter KIT Rp <?=number_format($vKit,0,",",".")?>,-<br><br>

										<label style="font-weight:bold">Total Purchased : <span id="totalpurc"></span> <span id="spcurr">IDR</span><span id="samaconvert"></span><span id="convert"></span><span id="currconvert"></span></label> 
										<div class="form-inline" id="divCurr" style="display:none"> <label style="font-weight:bold">Currency : </label>
										<select name="lmCurr" id="lmCurr" class="form-control" style="width:85px;" onChange="setCurr(this.value,$('#hTotal').val());">
                     <?
                         $vSQL="select distinct  frateto from tb_exrate order by frateto";
						 $db->query($vSQL);
						 while ($db->next_record()) {
							 $vCurr=$db->f('frateto');
					 ?>
                         <option value="<?=$vCurr?>" <? if ($vCurr==$vCurrTo) echo 'selected'; ?>><?=$vCurr?></option>
                     
                     <? } ?>
                     </select></div>

										
										<br><br>

										<input name="cbTC" id="cbTC" type="checkbox"  ><a style="cursor:pointer;color:blue;text-decoration:underline" href="#" onClick="openTerm();">&nbsp;Saya sudah membaca Syarat &amp; Ketentuan</a><br><br>
										<input type="hidden" name="hKit" id="hKit" value="<?=$vKit?>" />
										<input type="hidden" name="hTotal" id="hTotal" value="" />
                                        <button id="btnSubmit" type="submit" class="btn btn-primary" disabled="disabled" onClick="submitForm(this)">Submit</button> <div id="divLoad" style="display:inline"></div>
                            			 <!-- <input name="Button1" type="button" value="button" onclick="validPaket()"></div>  -->
                       
 </form>                               
        <!-- page end-->
        </section>
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
