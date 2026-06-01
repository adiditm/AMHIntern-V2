<? include_once("../framework/member_headside.blade.php");
include_once("../classes/memberclass.php");
include_once("../classes/networkclass.php");
include_once("../classes/systemclass.php");
?>
<?
  // print_r($_POST);
   while (list($key,$val)=each($_POST)) {
      $$key = $val;
   }
 
   $vHrgEco = $oRules->getSettingByField('fhrgeco');
   $vHrgBus = $oRules->getSettingByField('fhrgbus');
   $vHrgFirst = $oRules->getSettingByField('fhrgfirst');
   $vMailFrom=$oRules->getSettingByField('fmailadmin');
   
   $vTreshUp = $oRules->getSettingByField('ftreshup');
   $vTreshMaster = $oRules->getSettingByField('ftreshmaster');
   $vByyAdmin = $oRules->getSettingByField('fbyyadmin');
   $vBankFee = (float)$oRules->getSettingByField('fbyybank');
   $vSalProd = $oMember->getMemField('fsaldowprod',$vUser);
   $vBank1 = $oRules->getSettingByField('fbank');
   $vBank2 = $oRules->getSettingByField('fbank2');
   $vBank3 = $oRules->getSettingByField('fbank3');
   $vRekBank1 = $oRules->getSettingByField('frekbank1');
   $vRekBank2 = $oRules->getSettingByField('frekbank2');
   $vRekBank3 = $oRules->getSettingByField('frekbank3');
  
  
       
   if ($_POST['hPost'] != '1') {
      $_SESSION['save']='';
      $_SESSION['del']='';
    
   } else {
    $vNextJual=$oJual->getNextIDJual();
    $vBuyer=$_POST['tfSernoSpon'];
    $vBankDest=isset($_POST['lmBank']) ? addslashes(trim($_POST['lmBank'])) : '';
    $vPaket=$oMember->getMemField("fpaket",$vBuyer);
    $vAlamat=$oMember->getMemField('falamat',$vBuyer);
   // @mail("a_didit_m@yahoo.com","Entri RO Spectra by $vUser",print_r($_POST,true)."\n\n\n".print_r($_SESSION['save'],true));
    $oSystem->smtpmailer('japri_s@yahoo.com',$vMailFrom,'Spectra',"Entri RO Spectra by $vUser",print_r($_POST,true)."\n\n\n".print_r($_SESSION['save'],true),'','',false);
	$db->query('START TRANSACTION;');
    $vTotItem=0;
	if ($lmMethod=='ctr')
	   $vMainTable='tb_penjualan_temp';
	else if ($lmMethod=='wpr')  
	   $vMainTable='tb_penjualan';
	   
	$vTotal=$_POST['hTotal'];
	   
    while (list($key,$val) = each($_SESSION['save'])) {
        //print_r($val);
        
    	$vSQL="insert into $vMainTable(fidpenjualan, fidseller, fidmember, falamatkrm, fnostockist, fidproduk, fjumlah, ftanggal, fhargasat, fsubtotal, fsize, fcolor, ftgltrans, fjenis, fjmltrans, fserial, fpin, fmethod, fketerangan, ftglentry, fprocessed, ftglprocessed, fnorek)";
    	$vSQL.=" values('$vNextJual','$vUser','$vBuyer','$vAlamat','$vUser','".$val['lmKode']."',".$val['txtJml'].",now(),".$val['hHarga'].",".$val['hSubTot'].",'".$val['lmSize']."','".$val['lmColor']."',now(),'RO',0,'','','$lmMethod','Repeat Order',now(),'2','1981-01-01 00:00:00','$vBankDest')";
  	 	
  	 	$db->query($vSQL);
  	 	$vTotItem+=$val['txtJml'];
//Stock Position
/*		$vLastBal = $oMember->getStockPos($vUser,$val['lmKode'],$val['lmSize'],$val['lmColor']);
		$vNewBal=$vLastBal - $val['txtJml'];
		$vSQL="insert into tb_mutasi_stok(fidmember, fidproduk, fsize,fcolor, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate, fref) ";	  	 	
		$vSQL .="values('$vUser','".$val['lmKode']."','".$val['lmSize']."','".$val['lmColor']."','$vBuyer',now(), 'RO Sales [$vBuyer]',0 ,".$val['txtJml'].",$vNewBal,'JFO','1' , '$vUser',now(), '$vNextJual');";//belum selesai
  	 	$db->query($vSQL);
		
  	 	$vSQL="update tb_stok_position set fbalance=fbalance-".$val['txtJml']." where fidmember='$vUser' and fidproduk='".$val['lmKode']."' and fsize='".$val['lmSize']."' and fcolor='".$val['lmColor']."';";
		$db->query($vSQL);
  */	    
  	    
    }
  	    //Prosentase Fee RO
		$vProsenROFee = $oRules->getSettingByField('ffeeromem');
		$vProsenROFeeGroup = $oRules->getSettingByField('ffeerogroup');
		//Prosentase Mega Matching
		$vProsenMega = $oRules->getSettingByField('ffeemega');
		
		//Kedalaman RO Group
		$vDeepROG=$oRules->getSettingByField('fdeeprogrp');
		//Kedalaman Mega Matching
		$vDeepMega=$oRules->getSettingByField('fdeepmega');
		
  	    
  	    $vNomFee = $vProsenROFee * $vTotal / 100;
  	    $vNomFee=abs($vNomFee);

  	    $vNomFeeGroup = $vProsenROFeeGroup * $vTotal / 100;
  	    $vNomFeeGroup=abs($vNomFeeGroup);
  	    

		$vProsenTaxNPWP=$oRules->getSettingByField('ftaxnpwp');
		$vProsenTaxNonNPWP=$oRules->getSettingByField('ftaxnonpwp');



		
		

		if ($lmMethod=='wpr') {
			
			//Mutasi Si member


			$vLastBal=$oMember->getMemField('fsaldowprod',$vUser);
			$vNewBal=$vLastBal - $vTotal;

			$vsql="insert into tb_mutasi_wprod (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fincometax,fref) "; 
			$vsql.="values ('$vUser', '$vBuyer', now(),'Repeat Order Sales $vNextJual [Wallet Product] ' , 0,$vTotal ,$vNewBal ,'reorder' , '1','$vUser' , now(),0,'$vNextJual') "; 
			$db->query($vsql); 
			$oMember->updateBalConnWProd($vUser,$vNewBal,$db);


			//Bonus RO Si member

			$vNPWP = $oMember->getMemField('fnpwp',$vUser);
			if (trim($vNPWP) != '')
			   $vProsenTax = $vProsenTaxNPWP;
			else    
			   $vProsenTax = $vProsenTaxNonNPWP;
			
	
			$vTax =  $vProsenTax / 100;
			
			$vNomTax=$vNomFee * $vTax;
			$vNomFeeNett = $vNomFee - $vNomTax;
			

			$vLastBal=$oMember->getMemField('fsaldovcr',$vUser);
			$vNewBal=$vLastBal + $vNomFeeNett;

			$vsql="insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fincometax,fref) "; 
			$vsql.="values ('$vUser', '$vBuyer', now(),'Bonus Repeat Order Sales $vNextJual' , $vNomFeeNett,0 ,$vNewBal ,'bonusro' , '1','$vUser' , now(),$vNomTax,'$vNextJual') "; 
			$db->query($vsql); 
			$oMember->updateBalConn($vBuyer,$vNewBal,$db);
			
			$vSpon = $oNetwork->getSponsor($vUser);
			$vLevel=0;

			if ($vSpon !='' && $vSpon != -1 && $vSpon != '-') {
 				$vLevel++;
				//Bonus RO Group Level 1

				$vNPWP = $oMember->getMemField('fnpwp',$vSpon);
				if (trim($vNPWP) != '')
				   $vProsenTax = $vProsenTaxNPWP;
				else    
				   $vProsenTax = $vProsenTaxNonNPWP;
				
		
				$vTax =  $vProsenTax / 100;


				$vNomTaxGroup=$vNomFeeGroup * $vTax;
				$vNomFeeGroupNett = $vNomFeeGroup - $vNomTaxGroup;
				
				
								
				$vLastBal=$oMember->getMemField('fsaldovcr',$vSpon);
				$vNewBal=$vLastBal + $vNomFeeGroupNett;
	
				$vsql="insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fincometax,fref) "; 
				$vsql.="values ('$vSpon', '$vUser', now(),'Bonus RO Group Sales $vNextJual Level $vLevel' , $vNomFeeGroupNett,0 ,$vNewBal ,'bonusrogroup' , '1','$vUser' , now(),$vNomTaxGroup,'$vNextJual') "; 
				$db->query($vsql); 
				$oMember->updateBalConn($vSpon,$vNewBal,$db);
				
				
				//Mega Matching untuk RO Group level 1 
				$vLevelMega=0;
				for ($j=0;$j<$vDeepMega;$j++) {
					if ($j <= 0 ) 
					   $vSponMega = $oNetwork->getSponsor($vSpon);	
					else   
					   $vSponMega = $oNetwork->getSponsor($vSponMega);	
					
					if ($vSponMega !='' && $vSponMega != -1 && $vSponMega != '-') {			
							$vLevelMega++;
							$vPaketSpon=$oMember->getPaketID($vSponMega);
			
							$vNPWP = $oMember->getMemField('fnpwp',$vSponMega);
							if (trim($vNPWP) != '')
							   $vProsenTax = $vProsenTaxNPWP;
							else    
							   $vProsenTax = $vProsenTaxNonNPWP;
							
					
							$vTax =  $vProsenTax / 100;
			
							
							$vNomFeeMega=$vNomFeeGroup * $vProsenMega / 100;   
							$vNomTaxMega = $vNomFeeMega *  $vTax;
							$vNomFeeMegaNett = $vNomFeeMega -  $vNomTaxMega;
							
							   
			
								$vLastBal=$oMember->getMemField('fsaldovcr',$vSponMega);
								$vNewBal=$vLastBal + $vNomFeeMegaNett;
								
								$vsql="insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fincometax,fref) "; 
								$vsql.="values ('$vSponMega', '$vSpon', now(),'Bonus Mega Matching Sales $vNextJual Level $vLevelMega' , $vNomFeeMegaNett,0 ,$vNewBal ,'bonusmega' , '1','$vUser' , now(),$vNomTaxMega,'$vNextJual') "; 
								
							if ($j <= 0 ) {	
								$db->query($vsql); 						
								$oMember->updateBalConn($vSponMega,$vNewBal,$db);	
								
							} else {
							   //Harus cek paket
							    if ($vPaketSpon =='P'){
									$db->query($vsql); 						
									$oMember->updateBalConn($vSponMega,$vNewBal,$db);	
								}
							   
							   	
							}
					}
				} // end for mega matching
					
			}

			//RO Group Next level
			for ($i=0;$i < ($vDeepROG -1);$i++) {
			   	$vSpon=$oNetwork->getSponsor($vSpon);
				
				if ($vSpon !='' && $vSpon != -1 && $vSpon != '-') {
					$vLevel++;

					$vNPWP = $oMember->getMemField('fnpwp',$vSpon);
					if (trim($vNPWP) != '')
					   $vProsenTax = $vProsenTaxNPWP;
					else    
					   $vProsenTax = $vProsenTaxNonNPWP;
					
			
					$vTax =  $vProsenTax / 100;
	
	
					$vNomTaxGroup=$vNomFeeGroup * $vTax;
					$vNomFeeGroupNett = $vNomFeeGroup - $vNomTaxGroup;


					$vLastBal=$oMember->getMemField('fsaldovcr',$vSpon);
					$vNewBal=$vLastBal + $vNomFeeGroupNett;
		
					$vsql="insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fincometax,fref) "; 
					$vsql.="values ('$vSpon', '$vUser', now(),'Bonus RO Group Sales $vNextJual Level $vLevel' , $vNomFeeGroupNett,0 ,$vNewBal ,'bonusrogroup' , '1','$vUser' , now(),$vNomTaxGroup,'$vNextJual') "; 
					$db->query($vsql); 
					$oMember->updateBalConn($vSpon,$vNewBal,$db);


					//Mega Matching untuk RO Group next level 
					$vLevelMega=0;
					for ($j=0;$j<$vDeepMega;$j++) {
						if ($j <= 0 ) 
						   $vSponMega = $oNetwork->getSponsor($vSpon);	
						else   
					   		$vSponMega = $oNetwork->getSponsor($vSponMega);	
						
						if ($vSponMega !='' && $vSponMega != -1 && $vSponMega != '-') {			
								$vLevelMega++;
								$vPaketSpon=$oMember->getPaketID($vSponMega);
				
								$vNPWP = $oMember->getMemField('fnpwp',$vSponMega);
								if (trim($vNPWP) != '')
								   $vProsenTax = $vProsenTaxNPWP;
								else    
								   $vProsenTax = $vProsenTaxNonNPWP;
								
						
								$vTax =  $vProsenTax / 100;
				
								
								$vNomFeeMega=$vNomFeeGroup * $vProsenMega / 100;   
								$vNomTaxMega = $vNomFeeMega *  $vTax;
								$vNomFeeMegaNett = $vNomFeeMega -  $vNomTaxMega;
								
								   
				
									$vLastBal=$oMember->getMemField('fsaldovcr',$vSponMega);
									$vNewBal=$vLastBal + $vNomFeeMegaNett;
									
									$vsql="insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fincometax,fref) "; 
									$vsql.="values ('$vSponMega', '$vSpon', now(),'Bonus Mega Matching Sales $vNextJual Level $vLevelMega' , $vNomFeeMegaNett,0 ,$vNewBal ,'bonusmega' , '1','$vUser' , now(),$vNomTaxMega,'$vNextJual') "; 
									
								if ($j <= 0 ) {	
									$db->query($vsql); 						
									$oMember->updateBalConn($vSponMega,$vNewBal,$db);	
									
								} else {
								   //Harus cek paket
									if ($vPaketSpon =='P'){
										$oDB->query($vsql); 						
										$oMember->updateBalConn($vSponMega,$vNewBal,$db);	
									}
								   
									
								}
						}
					} // end for mega matching
					
						
				}
				
			}

			


		
		}
    

    
    $db->query('COMMIT;');
	if ($lmMethod=='ctr') {
		$vNamaPebisnis = trim($oMember->getMemFieldBis('fnama',$vUser));
		if ($vNamaPebisnis == '')
			$vNamaPebisnis = $vUser;

		$vTotalPay = (float)$vTotal + $vBankFee;
		$vAdminNumbers = array();
		$vAdminConf = trim($oRules->getSettingByField('fhpconf'));
		$vAdminCs = trim($oRules->getSettingByField('fhpcs'));
		if ($vAdminConf != '' && $vAdminConf != '-')
			$vAdminNumbers[] = $vAdminConf;
		if ($vAdminCs != '' && $vAdminCs != '-')
			$vAdminNumbers[] = $vAdminCs;
		$vAdminNumbers = array_values(array_unique($vAdminNumbers));

		if (count($vAdminNumbers) > 0) {
			$vBodyAdmin = 'Yth. Admin (admin2), ada transaksi belanja produk di AMH Techno melalui pebisnis [' . $vNamaPebisnis . '] dengan pembayaran transfer ke rekening [' . $vBankDest . "]\n\n";
			$vBodyAdmin .= 'Nomor Order / Pembelian : ' . $vNextJual . "\n";
			$vBodyAdmin .= 'Jumlah Pembayaran : ' . number_format($vTotalPay,0,',','.') . "\n\n";
			$vBodyAdmin .= 'Tolong cek secara berkala apakah dana sudah masuk di rekening. Jika sudah masuk, lakukan approve payment di halaman Approval Penjualan untuk transaksi tersebut, agar seller bisa segera memproses penjualan' . "\n \n";
			$vBodyAdmin .= 'Catatan: Total nominal transaksi sudah termasuk admin bank sebesar ' . number_format($vBankFee,0,',','.') . ".\n";

			foreach ($vAdminNumbers as $vAdminNumber) {
				$oSystem->sendWAMessage($vAdminNumber,$vBodyAdmin);
			}
		}
	}
	$oSystem->sendSMS($tfPhoneSpon,"SPECTRA2U\n\n$tfSponsor, terima kasih atas order Anda!");
     if ($lmMethod=='wpr')
	    $oSystem->jsAlert("Repeat Order Sukses dengan ID $vNextJual!");
	 else if ($lmMethod=='ctr')	
	    $oSystem->jsAlert("Permintaan Repeat Order Sukses dengan ID $vNextJual, tunggu approval dari Admin!");

     $oSystem->jsLocation("../memstock/reorder.php");
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
<script src="../js/jquery.validate.min.js"></script>
<script language="javascript">
function changeRek(pThis) {
	var vDefault = '<option value="">--Pilih--</option><option value="CASH">Cash</option><option value="<?=$vBank1?> <?=$vRekBank1?>"><?=$vBank1?> <?=$vRekBank1?></option><option value="<?=$vBank2?> <?=$vRekBank2?>"><?=$vBank2?> <?=$vRekBank2?></option><option value="<?=$vBank3?> <?=$vRekBank3?>"><?=$vBank3?> <?=$vRekBank3?></option>';
	if (pThis.value=='ctr') {
		document.getElementById('lmBank').disabled=false;
		$('#lmBank').css('pointer-events','auto');
		$('#lmBank').css('background-color','#fff');
		$('#lmBank').html(vDefault);
	} else if (pThis.value=='wpr') {
		document.getElementById('lmBank').disabled=true;
		$('#lmBank').css('pointer-events','none');
		$('#lmBank').css('background-color','#ccc');
		document.getElementById('lmBank').selectedIndex=0;
	} else {
		document.getElementById('lmBank').disabled=false;
		$('#lmBank').css('pointer-events','auto');
		$('#lmBank').css('background-color','#fff');
		document.getElementById('lmBank').selectedIndex=0;
		$('#lmBank').html(vDefault);
	}
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
			if ($('#lmMethod').val().trim()=='ctr' && $('#lmBank').val().trim()=='') {
				alert('Pilih rekening tujuan pembayaran terlebih dahulu!');
				$('#lmBank').focus();
				return false;
			}

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

 // $.validator.messages.required = '<span style="color:red;font-weight:normal">This field is required!</span>';
  $('#frmReg input, #frmReg textarea,  #frmReg select, #frmReg checkbox, #frmReg radio').not([type="submit"]).not($("#tfNPWP")).not($("#tEmail")).not($("#tfSwift")).not($("#tfEmailSpon")).addClass('required');  
  $('#lmCountry').val('ID');
  $('#lmCountry').trigger('change');
  changeRek(document.getElementById('lmMethod'));
  

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
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<h4><li><a href="javascript:;">Member Repeat Order</a></li></h4>
				
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">&nbsp;</small></h1>

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
											Member Data</label></div>
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
												<input readonly value="<?=$vUser?>" type="text" class="form-control" id="tfSernoSpon" name="tfSernoSpon" placeholder="Member ID*" onBlur="checkKitSpon(this)" onKeyUp="setUpper(this)">
											</div>
										</div>
										<div class="divtr">
											<img id="loadNama"  align="absmiddle" src="../images/ajax-loader.gif" style="position:absolute;z-index:2;margin-left:45px;margin-top:24px;opacity: 0.5;display:none" />
											<label for="exampleInputEmail1">Nama 
											Member*</label>
											<div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>
												<input readonly="readonly" type="text" class="form-control" id="tfSponsor" name="tfSponsor" placeholder="Member Name*">
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
													<input readonly="readonly" type="email" class="form-control" id="tfEmailSpon" name="tfEmailSpon" placeholder="Member's Email Address">
												</div>
											</div>
											
											<div class="col-lg-6 col-md-6 divtr" >
												<label for="exampleInputEmail1" >
												<span style="font-weight:bold">Alamat Surat
												</span></label>
												<div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-envelope"></i></span>
													<textarea  style="padding-left:30px" readonly="readonly" class="form-control" id="tfAlamat" name="tfAlamat" placeholder="Mailing Address"></textarea>
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
					                               <br style="display: block;margin: -5px 0;" /><label for="exampleInputEmail1" style="font-size:13px;color:green">Saldo Wallet Product : <?=number_format($vSalProd,0,",",".")?></label>
                                                   <input type="hidden" name="hSalProd" id="hSalProd" value="<?=$vSalProd?>" /> 
					                     		</div>
					                     </div>
					                     <div class="panel-body">

<div class="table-responsive" id="tbPurc">
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
								    $vSQL="select distinct fidproduk, fsize, fidcolor, fnamaproduk, fhargajual1,fhargajual2, fsatuan from  m_product   where  faktif='1' and fidcat='CAT-0001' order by fidproduk";
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

										<label style="font-weight:bold">Total Purchased : <span id="totalpurc"></span> <span id="spcurr">IDR</span><span id="samaconvert"></span><span id="convert"></span><span id="currconvert"></span></label> 

       <div class="row">
       <div class="col-lg-4">
       
         <label style="color:blue" for="lmMethod">Metode Pembayaran</label>
         <select name="lmMethod" id="lmMethod" class="form-control" onChange="changeRek(this)">
           <option value="">--Pilih--</option>
           <option value="ctr">Cash / Transfer</option>
           <option value="wpr">Wallet Product</option>
         </select>
       </div>
       <div class="col-lg-6">
         <label style="color:blue" for="lmBank">Rekening</label>
         <select name="lmBank" id="lmBank" class="form-control">
           <option value="">--Pilih--</option>
           <option value="CASH">Cash</option>
           <option value="<?=$vBank1?> <?=$vRekBank1?>"><?=$vBank1?> <?=$vRekBank1?></option>
           <option value="<?=$vBank2?> <?=$vRekBank2?>"><?=$vBank2?> <?=$vRekBank2?></option>
           <option value="<?=$vBank3?> <?=$vRekBank3?>"><?=$vBank3?> <?=$vRekBank3?></option>
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
                                        <button id="btnSubmit" type="submit" class="btn btn-primary" disabled="disabled" onClick="submitForm(this)">Submit</button> <div id="divLoad" style="display:inline"></div>
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
