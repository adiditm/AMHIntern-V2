<? include_once("../framework/admin_headside.blade.php");
include_once("../classes/memberclass.php");
include_once("../classes/networkclass.php");
include_once("../classes/systemclass.php");
include_once("../classes/actionpayclass.php");
include_once("../classes/ruleconfigclass.php");

/*if (count($_POST) >0) {
  print_r($_POST);
  exit;	
}*/

$vCount = $_GET['count'];
if ($vCount=='') $vCount=1;
	function is_base64_encoded($data)
	{
		if (preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $data)) {
		   return TRUE;
		} else {
		   return FALSE;
		}
	} 
 
  // print_r($_POST);
   while (list($key,$val)=each($_POST)) {
      $$key = $val;
   }
   
   if (is_base64_encoded($_GET['ref']))
   			$vRef = base64_decode($_GET['ref']);
	else 	$vRef = $_GET['ref'];
   $vProd = $_GET['prod'];
   $vSQL = "select * from m_product where fidproduk='$vProd'";
   $db->query($vSQL);
   $db->next_record();
   $vSeller = $db->f('fseller');
   
   $vSQL = "select * from m_seller where fidseller='$vSeller'";
   $db->query($vSQL);
   $db->next_record();
   $vSellerName = $db->f('fnama'); 
   
   $vUser = $_SESSION['LoginUser'];
   if ($vRef =='')
      $vRef = $vUser;
   
   $vKotaAsal = $oMember->getMemFieldSell('fkota',$vSeller);
   $vHrgEco = $oRules->getSettingByField('fhrgeco');
   $vHrgBus = $oRules->getSettingByField('fhrgbus');
   $vHrgFirst = $oRules->getSettingByField('fhrgfirst');
   $vMailFrom=$oRules->getSettingByField('fmailadmin');
   $vUserHO = $oRules->getSettingByField('fuserho');
   $vBank1 = $oRules->getSettingByField('fbank');
   $vBank2 = $oRules->getSettingByField('fbank2');
   $vBank3 = $oRules->getSettingByField('fbank3');

   $vRekBank1 = $oRules->getSettingByField('frekbank1');
   $vRekBank2 = $oRules->getSettingByField('frekbank2');
   $vRekBank3 = $oRules->getSettingByField('frekbank3');
   
   $vBankFee = $oRules->getSettingByField('fbyybank');

  


 /*  if ($vPriv=='member')
      $vSeller = $vUserHO;
   else	  
      $vSeller = $vUser;*/
   $vTreshUp = $oRules->getSettingByField('ftreshup');
   $vTreshMaster = $oRules->getSettingByField('ftreshmaster');
   $vByyAdmin = $oRules->getSettingByField('fbyyadmin');
   $vSalProd = $oMember->getMemFieldAdm('fsaldovcr',$vUser);
   $vOngkir = $_POST['tfOngkir'];
  // $vSalProd = 8000000;
  //$vSalProd = 5000000;

       
   if ($_POST['hPost'] != '1') {
      $_SESSION['save']='';
      $_SESSION['del']='';
    
   } else {
    $vNextJual=$oJual->getNextIDJual();
    $vBuyer=$_POST['tfSernoSpon'];
    //$vPaket=$oMember->getMemField("fpaket",$vBuyer);
  //  $vAlamat=$oMember->getMemField('falamat',$vBuyer);
    $vAlamat=$_POST['tfRecAddr'];
   // @mail("a_didit_m@yahoo.com","Entri RO Spectra by $vUser",print_r($_POST,true)."\n\n\n".print_r($_SESSION['save'],true));
    $oSystem->smtpmailer('japri_s@yahoo.com',$vMailFrom,'Onotoko',"Entri RO Onotoko by $vUser",print_r($_POST,true)."\n\n\n".print_r($_SESSION['save'],true),'','',false);
	$db->query('START TRANSACTION;');
    $vTotItem=0;
	if ($lmMethod=='ctr' || $lmMethod=='tva')
	   $vMainTable='tb_trxstok_member_temp';
	else if ($lmMethod=='wpr')  
	   $vMainTable='tb_trxstok_member';
	   
	$vTotal=$_POST['hTotal'];
	   
    while (list($key,$val) = each($_SESSION['save'])) {
        //print_r($val);
         if ($vSeller == '')  $vSeller = $_POST['hSeller'];
		if ($lmMethod == 'wpr')
			$vProcessed = '2';
		else if($lmMethod == 'ctr' || $lmMethod == 'tva')
			$vProcessed = '0';
			
    	 $vSQL="insert into $vMainTable(fidpenjualan, fidseller, fidmember, falamatkrm, fnostockist, fidproduk, fjumlah, ftanggal, fhargasat, fsubtotal, fsize, fcolor, ftgltrans, fjenis, fjmltrans, fserial, fpin, fmethod, fketerangan, ftglentry, fprocessed, ftglprocessed, fongkir, fberat, fcountry, fprop, fkota, fkec, fexpe, fpack, frecnohp, frecname)";
    	$vSQL.=" values('$vNextJual','$vSeller','$vBuyer','$vAlamat','$vUser','".$val['lmKode']."',".$val['txtJml'].",now(),".$val['hHarga'].",".$val['hSubTot'].",'".$val['lmSize']."','".$val['lmColor']."',now(),'RO',0,'','','$lmMethod','Repeat Order',now(),'$vProcessed','1981-01-01 00:00:00',$vOngkir,{$_POST['hTotWeight']},'{$_POST['fcountry']}','{$_POST['fprop']}','{$_POST['fkota']}','{$_POST['fkec']}','{$_POST['fexpe']}','{$_POST['fpack']}','{$_POST['tfRecPhone']}','{$_POST['tfRecName']}')";
  	 	
  	 	$db->query($vSQL);
  	 	$vTotItem+=$val['txtJml'];
		

 
    if ($lmMethod=='wpr') {
	//Stock Position Seller
			$vLastBal = $oMember->getStockPosUnig($vSeller,$val['lmKode']);
			$vNewBal=$vLastBal - $val['txtJml'];
			$vSQL="insert into tb_mutasi_stok(fidmember, fidproduk, fsize,fcolor, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate, fref) ";	  	 	
			$vSQL .="values('$vSeller','".$val['lmKode']."','".$val['lmSize']."','".$val['lmColor']."','$vBuyer',now(), 'RO Sales [$vBuyer]',0 ,".$val['txtJml'].",$vNewBal,'JRO','1' , '$vUser',now(), '$vNextJual');";//belum selesai
			$db->query($vSQL);
			
			$vSQL="update tb_stok_position set fbalance=fbalance-".$val['txtJml']." where fidmember='$vSeller' and fidproduk='".$val['lmKode']."'";
			$db->query($vSQL);


			//$oNetwork->sendFeeTitikCompress($vBuyer,20,$vTotal,$vNextJual);			
	} else if ($lmMethod=='tva') {
		
	}
 	    
  	    
    }
  	  



		
		

		if ($lmMethod=='wpr') {
			
			//Mutasi Si member


			$vLastBal=$oMember->getMemFieldAdm('fsaldovcr',$vUser);
			$vNewBal=$vLastBal - $vTotal;

			$vsql="insert into tb_mutasi_wprod (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fincometax,fref) "; 
			$vsql.="values ('$vUser', '$vBuyer', now(),'Repeat Order Sales $vNextJual [Dengan Saldo] ' , 0,$vTotal ,$vNewBal ,'reorder' , '1','$vUser' , now(),0,'$vNextJual') "; 
			$db->query($vsql); 
			$oMember->updateBalConnWProd($vUser,$vNewBal,$db);


//Prepare values\
    $vProsenFeeSpon = $oRules->getSettingByField('fprosensponb');
	$vBelanja = $vTotal;
    $vSponFee = $vBelanja * $vProsenFeeSpon /100;
	// $vSponFee = $oRules->getSettingByField('fprosenspon') * 1800000 / 100;
	$vPresFee = $vBelanja * $oRules->getSettingByField('fpresfeeb') / 100;
	$vSponsor = $oNetwork->getSponsor($vUser);	
    $vResSponsor=$vSponsor;
//	$vResPres = $oMember->getMemField('fidrespres',$vUser);
	$vFeeAdmin=$oRules->getSettingByField('fbyyadmin');
	$vProsenCash=$oRules->getSettingByField('fprosencash');
	$vProsenWProd=$oRules->getSettingByField('fprosenwprod');
	$vMaxWProd=$oRules->getSettingByField('fmaxwprod');
	$vVAT=$oRules->getSettingByField('fvat');
	//$vProsenWKit=$oRules->getSettingByField('fprosenwkit');
	//$vProsenWAcc=$oRules->getSettingByField('fprosenwacc');
	$vProsenTaxNPWP=$oRules->getSettingByField('ftaxnpwp');
	$vProsenTaxNonNPWP=$oRules->getSettingByField('ftaxnonpwp');
	
	/*$vNPWPSpon = $oMember->getMemField('fnpwp',$vResSponsor);
	if (trim($vNPWPSpon) != '')
	   $vProsenTax = $vProsenTaxNPWP;
	else    
	   $vProsenTax = $vProsenTaxNonNPWP;*/
	$vProsenTax=0;   
	//$vMaxMaRO = $oRules->getSettingByField('fmaxrowal');
	
	
   // $vTotBelanja=$oMember->getMemField('ftotbelanja',$pID);
    //$vPaket=$oMember->getMemField('fpaket',$pID);
    //$vBonusRO=35000;
    
    
    //$vSponFee=$oRules->getSettingByField('fsponfee');
   $vPTKPMonth=$oRules->getSettingByField('fptkp');
   $vPTKPYear=$oRules->getSettingByField('fptkpy');
   $vProsenNormaPPH=$oRules->getSettingByField('fnormapph');
   $vProsenAdm=$oRules->getSettingByField('ffeeadmin');
	
    
 
	$vSponFeeCash=$vSponFee * $vProsenCash / 100;
	$vSponFeeWProd=$vSponFee * $vProsenWProd / 100;

	$vPresFeeCash=$vPresFee * $vProsenCash / 100;
	$vPresFeeWProd=$vPresFee * $vProsenWProd / 100;

//=============Income Sponsor===================//
			//$vProsenAdm=0;
		    $vYearMonth=substr(date("Y-m-d"),0,7);
			$vYear=substr(date("Y-m-d"),0,4);
		    $vIncomeMonth = $oKomisi->getBonusMonth($vResSponsor,$vYearMonth);
			$vIncomeYear = $oKomisi->getBonusYear($vResSponsor,$vYear);

		    $vIncomeMonthPres = $oKomisi->getBonusMonth($vResPres,$vYearMonth);
			$vIncomeYearPres = $oKomisi->getBonusYear($vResPres,$vYear);

			$vSponFeeAdm=$vSponFeeCash * ($vProsenAdm / 100);
			$PresFeeAdm=$vPresFeeCash * ($vProsenAdm / 100);

			if ($vIncomeMonth >= $vPTKPMonth || $vIncomeYear >= $vPTKPYear) {
		  	    $vTaxPPH = $vSponFeeCash  * ($vProsenTax /100) * ($vProsenNormaPPH / 100);
				$vSponFeeCashNett = $vSponFeeCash - $vTaxPPH - $vSponFeeAdm;
				
				
				$vFeeID .= " nett with PPH $vProsenNormaPPH%";
			} else {
			    $vTaxPPH = 0;
				$vSponFeeCashNett = $vSponFeeCash - $vTaxPPH - $vSponFeeAdm;
				$vFeeID .= " nett ";
			}
			
			
			if ($vIncomeMonthPres >= $vPTKPMonth || $vIncomeYearPres >= $vPTKPYear) {
		  	    $vTaxPPH = $vPresFeeCash  * ($vProsenTax /100) * ($vProsenNormaPPH / 100);
				$vPresFeeCashNett = $vPresFeeCash - $vTaxPPH - $vPresFeeAdm;
				
				
				$vFeeID .= " nett with PPH $vProsenNormaPPH%";
			} else {
			    $vTaxPPH = 0;
				$vPresFeeCashNett = $vPresFeeCash - $vTaxPPH - $vPresFeeAdm;
				$vFeeID .= " nett ";
			}			
//=============Income Sponso & Presr===================//
	
//Sponsor
			//$vSponsor = $oNetwork->getSponsor($vUser);	
		    $vsql="insert into tb_kom_spon(fidsponsor,fidregistrar,ffee,ftanggal,ffeestatus) ";
			$vsql.="values ('$vSponsor','$vUser',$vSponFee,now(),'BSRO')"; //Masukkan komisi sponsor
			$db->query($vsql);   

//presenter
			
		    $vsql="insert into tb_kom_spon(fidsponsor,fidregistrar,ffee,ftanggal,ffeestatus) ";
			$vsql.="values ('$vResPres','$vUser',$vPresFee,now(),'BPRO')"; //Masukkan komisi Presenter
			$db->query($vsql);   
			
			
//Mutasi Saldo

			$vLastBal=$oMember->getMemFieldAdm('fsaldovcr',$vSponsor);
			//$vLastBalWprod=$oMember->getMemField('fsaldowprod',$vSponsor);
			
			if ($vLastBalWprod >= $vMaxWProd) {
					 $vTaxPPH =($vSponFeeCash + $vSponFeeWProd)  * ($vProsenTax /100) * ($vProsenNormaPPH / 100);
					 $vSponFeeCashNett =($vSponFeeCash + $vSponFeeWProd)  - $vTaxPPH - $vSponFeeAdm;				 
					
			}
			
			$vNewBal=$vLastBal + $vSponFeeCashNett;
			$vUserL=$_SESSION['LoginUser'];
			if (trim($vUserL) == '')
			   $vUserL='newreg';
			
			$vVATNom = $vBelanja * $vVAT / 100;
			$vsql="insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fincometax,fvat) "; 
			$vsql.="values ('$vSponsor', '$vUser', now(),'Bonus sponsor RO [$vUser] $vFeeID' , $vSponFeeCashNett,0 ,$vNewBal ,'sponb' , '1','$vUserL' , now(),$vTaxPPH,0) "; 
			$db->query($vsql); 
			$oMember->updateBalConn($vSponsor,$vNewBal,$db);
			
//Presenter


			$vLastBalWprod=$oMember->getMemFieldAdm('fsaldovcr',$vSponsor);
			
			if ($vLastBalWprod >= $vMaxWProd) {
		  	    $vTaxPPH = ($vPresFeeCash + $vPresFeeWProd)  * ($vProsenTax /100) * ($vProsenNormaPPH / 100);
				$vPresFeeCashNett = ($vPresFeeCash + $vPresFeeWProd) - $vTaxPPH - $vPresFeeAdm;
					
			}

			$vLastBal=$oMember->getMemFieldAdm('fsaldovcr',$vResPres);



			$vNewBal=$vLastBal + $vPresFeeCashNett;
			$vUserL=$_SESSION['LoginUser'];
			if (trim($vUserL) == '')
			   $vUserL='newreg';

			$vsql="insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fincometax,fvat) "; 
			$vsql.="values ('$vResPres', '$vUser', now(),'Bonus presenter RO [$vUser] $vFeeID' , $vPresFeeCashNett,0 ,$vNewBal ,'presb' , '1','$vUserL' , now(),$vTaxPPH,0) "; 
			$db->query($vsql); 
			$oMember->updateBalConn($vResPres,$vNewBal,$db);
			
			
		
			//Wallet Prod
			$vLastBal=$oMember->getMemFieldAdm('fsaldowprod',$vSponsor);

			if ($vLastBal >= $vMaxWProd) {
				  $vSponFeeWProd = 0;
				  $vDescX = "Bonus sponsor RO [$vUser] - cutoff";
			} else    $vDescX = "Bonus sponsor RO [$vUser]";

			
			$vNewBal=$vLastBal + $vSponFeeWProd;

		 //Wallet Product
			$vsql="insert into tb_mutasi_wprod (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fincometax) "; 
			$vsql.="values ('$vSponsor', '$vUser', now(),'$vDescX' , $vSponFeeWProd,0 ,$vNewBal ,'sponb' , '1','$vUserL' , now(),0) "; 
			
			if ($vSponFeeWProd >0)
					$db->query($vsql); 
			
			$oMember->updateBalConnWProd($vSponsor,$vNewBal,$db);



			//Wallet Prod
			$vLastBal=$oMember->getMemFieldAdm('fsaldovcr',$vResPres);

			if ($vLastBal >= $vMaxWProd) {
				  $vPresFeeWProd = 0;
				  $vDescX = "Bonus presenter RO [$vUser] - cutoff";
			} else    $vDescX = "Bonus presenter RO [$vUser]";
			
			$vNewBal=$vLastBal + $vPresFeeWProd;

		 //Wallet Product
			$vsql="insert into tb_mutasi_wprod (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fincometax) "; 
			$vsql.="values ('$vResPres', '$vUser', now(),'$vDescX ' , $vPresFeeWProd,0 ,$vNewBal ,'presb' , '1','$vUserL' , now(),0) "; 
			if ($vPresFeeWProd >0)
				$db->query($vsql); 
			
			$oMember->updateBalConnWProd($vResPres,$vNewBal,$db);

//===========End Mutasi Saldo ============= //			




		}
    

    
    $db->query('COMMIT;');
	$oSystem->sendSMS($tfPhoneSpon,"ONOTOKO\n\n$tfSponsor, terima kasih atas order Anda!",'','');
     if ($lmMethod=='wpr')
	    $oSystem->jsAlert("Order Sukses dengan ID $vNextJual!");
	 else if ($lmMethod=='ctr')	
	    $oSystem->jsAlert("Permintaan Order Sukses dengan ID $vNextJual, tunggu approval dari Admin!");
	 else if ($lmMethod=='tva') {
		$oSystem->jsAlert("Permintaan Order Sukses dengan ID $vNextJual, klik OK dan lanjutkan dengan transfer dana ke Virtual Account! Mohon untuk tidak menutup browser Anda sebelum keluar nomor Virtual Account!");
		?>


		<script language="javascript">
		$(document).ready(function() {
			 // Generate VA pembayaran sebelum submit form
			 $.post('../main/mpurpose_ajax.php?op=generateva', {
				amount: '<?=$_POST["hTotal"]?>',					
				ref: '<?=$vNextJual?>',
				buyer: '<?=$_POST['tfRecName']?>',
				bankva: '<?=$_POST['lmBank']?>'
			}, function(response) {
			  var result = JSON.parse(response);
			  if (result.status == '0001') {
				var vVA = result.data.address;
				var vAmount = result.data.totAmount;
				var vFee = <?=$vBankFee?>;
				var vBank = result.data.channelName;
				var vBankCode = result.data.bankCode;
				var trxDate = result.data.trxDate;
				var creditAmount = result.data.creditAmount;
				var debitAmount = result.data.debitAmount;
				var bankCode = result.data.bankCode;
				var channelId = result.data.channelId;
				var channelName = result.data.channelName;
				var address = result.data.address;
				var addressName = result.data.addressName;
				var refId = result.data.refId;
				$.post('../main/mpurpose_ajax.php?op=saveva',{
					va_no:address, va_amount:vAmount, va_fee:vFee, va_bank:vBank, va_bankcode:vBankCode, va_trxdate:trxDate, va_credit:creditAmount, va_debit:debitAmount, va_bankcode:bankCode, va_channelid:channelId, va_channelname:channelName, va_address:address, va_addressname:addressName, va_refid:refId}, 
					function(data){
						var vaInfo = '<h2>Informasi Pembayaran</h2> <br><br>';
						vaInfo += '<b>Nomor Virtual Account</b> : ' + address + '<br>';
						vaInfo += '<b>Jumlah Pembayaran</b> : ' + numberFormat(vAmount) + '<br>';
						vaInfo += '<b>Bank</b> : ' + vBank.toUpperCase() + '<br>';
						//vaInfo += '<b>Bank Code</b> : ' + vBankCode + '<br><br>';
						vaInfo += 'Catatlah atau screenshot informasi ini. Anda juga akan mendapatkan informasi ini di email Anda (cek folder spam / junk juga).<br>';
						vaInfo += 'Catatan: Total nominal transaksi sudah termasuk admin bank sebesar ' + numberFormat(vFee) + '<br>';
						
						var vObj = $.parseJSON(data);
						console.log(vObj.status);
						if (vObj.status == 'success') {
								$('#divContent').html(vaInfo);
								$('#btnModal').trigger('click');		
						} else {
							alert(vObj.message);
							return false;
						}
						
						//document.location.href='../manager/indexnonadmin.php';
					
				});
				
			  } else {
				alert('Gagal membuat VA pembayaran: ' + result.message);
				return false;
			  }
			}).fail(function() {
			  alert('Terjadi kesalahan saat membuat VA pembayaran');
			  return false;
			});
		});
		</script>
		<?
		//exit;
		}
		
	//$oSystem->jsLocation('../manager/indexnonadmin.php');	
?>
<script language="javascript">

function printTrx(pParam,pTgl,pIDMem) {
	var vURL='../memstock/detjual.php?uNoJual='+pParam+'&uTanggal='+pTgl+'&uIDMember='+pIDMem;
	window.open(vURL,'wPrint','width=900 height=600');
}

printTrx('<?=$vNextJual?>','<?=date('Y-m-d')?>','<?=$vUser?>');
</script>
<?
     //$oSystem->jsLocation("../memstock/reorder.php");
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

  .error {
	color: red;
	
  }
	</style>
<script src="../js/jquery.validate.min.js"></script>
<script language="javascript">
function numberFormat(number, decimals = 0, decPoint = ',', thousandsSep = '.') {
    let fixedNumber = parseFloat(number).toFixed(decimals);
    let [integerPart, decimalPart] = fixedNumber.split('.');
    integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, thousandsSep);
    return decimalPart ? integerPart + decPoint + decimalPart : integerPart;
}

function changeRek(pThis){
	var vDefault = '<option value="">--Pilih--</option><option value="CASH">Cash</option><option value="<?=$vBank1?> <?=$vRekBank1?>"><?=$vBank1?> <?=$vRekBank1?></option><option value="<?=$vBank2?> <?=$vRekBank2?>"><?=$vBank2?> <?=$vRekBank2?></option><option value="<?=$vBank3?> <?=$vRekBank3?>"><?=$vBank3?> <?=$vRekBank3?></option>';

	var vBankList ='';
	
   if (pThis.value=='ctr') {
	  document.getElementById('lmBank').disabled=false;
	  $('#lmBank').css('pointer-events','auto');
	  $('#lmBank').css('background-color','#fff');
	 // $('#lmBank option[value="tva"]').remove();
   }  else {
	  // document.getElementById('lmBank').disabled=true; 
	  // $('#lmBank').css('pointer-events','none');
	   //$('#lmBank').css('background-color','#ccc');
	   document.getElementById('lmBank').selectedIndex=0; 
	   if (pThis.value=='tva') {
			var vURL='../main/mpurpose_ajax.php?op=banklist';
			$.post(vURL,function(data) {
				vBankList = data;
				$('#lmBank').html(vBankList);
			//console.log(vBankList);
			});
		  
	   } else {
		   $('#lmBank').html(vDefault);
	   }
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
			    alert('Saldo Anda tidak mencukupi untuk pembelanjaan ini, silakan ganti metode pembayaran!');	
				return false;
			}


		    if (confirm('Anda yakin melakukan Order?')==true) {
				var vValid= validRO();
							
 				if (vValid) {
 				  
 				   document.frmReg.submit();
				}
				
			} else return false;
			
			
		}
	});
$(document).ready(function(){
 //  alert('ssss');
  // alert($('#hHarga').val());
   $('#caption').html('Entry Order <? if ($_SESSION['Priv']=='administrator') echo ' by Admin'; ?>');
   $('#tfTglLahir').datepicker({
                    format: "dd-mm-yyyy"
    });  

 // $.validator.messages.required = '<span style="color:red;font-weight:normal">This field is required!</span>';
  $('#frmReg input, #frmReg textarea,  #frmReg select, #frmReg checkbox, #frmReg radio').not([type="submit"]).not($("#tfNPWP")).not($("#tEmail")).not($("#tfSwift")).not($("#tfEmailSpon")).addClass('required');  
  $('#fcountry').val('ID');
  $('#fcountry').trigger('change');
  $('#fexpe').select2();

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
	
	<? if ($vProd !='') {?>
	//alert('aaaaa');
	doAddAuto('<?=$vProd?>');
	//doAdd('<?=$vProd?>');
	<? } ?>
//	$('#tfBerat').val($('#hTotWeight').val());
	
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
   
   
   function doAddAuto(pProd) {
	 //  alert(pProd);
       $('#lmKode').show();
       $('#btAdd').trigger('click'); 
	   $('#lmKode').val(pProd);
	    $('#lmKode').trigger('change');  
       $('#btCancel').show();  
       $('#txtJml').show();   
	   $('#txtJml').val('<?=$vCount?>');   
	   $('#txtJml').trigger('change');   
	    $('#txtJml').trigger('blur');   
       $('#lmSize').show(); 
       $('#lmColor').show();
        $('#trAdd').show(); 
       $('#btSaveRow').show(); 
	   $('#btSaveRow').trigger('click'); 
		//alert($('#lmKode').find('option:selected').attr('sweight'));
       

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
	//   console.log(pParam);
      var vNama=$('[name=lmKode] option:selected').text();
      vNama=vNama.split(';');
      <? if ($_SESSION['Priv'] == 'administrator')  {?>
	  vNama=vNama[1];
	  <? } else {?>
	   vNama=vNama[1];
	  <? } ?>
      
      var vHarga=  $(pParam).find('option:selected').attr("price");     
      var vItemSat=  $(pParam).find('option:selected').attr("jmlitem"); 
	  var vWeight=  $(pParam).find('option:selected').attr("sweight"); 
      $('#thNama').html(vNama);
      $('#thHarga').html(vHarga);
       $('#hHarga').val(vHarga);
        $('#hItemSat').val(vItemSat);
	  $('#hWeight').val(vWeight);	
	
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
  
  
    
 function calcTot() {
	var xTot=	parseFloat($('#hTot').val()) + parseFloat($('#tfOngkir').val()) + parseFloat($('#tfBankFee').val());
		  $('#hTotal').val(xTot);
	//	 alert(xTot);
		  $('#totalpurc').html(xTot);  
		  $('#totalpurc').priceFormat({     
						prefix: ' ',
						centsSeparator: ',',
						thousandsSeparator: '.',
						limit: 15,
						centsLimit: 0
		   });
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
   var vURL = "../memstock/register_purc_ajax.php";
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



		 var xTot=	parseFloat($('#hTot').val()) + parseFloat($('#tfOngkir').val());
		 $('#hTotal').val(xTot);
	//	 alert(xTot);
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
		 <? if(count($_POST)<=0){ ?>
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
		 <? } ?>

		 
      
   });
}
 

function doDel(pNo, pKode,pSize,pColor,pNama,pJml,pHarga,pSubTot) {
//alert(pNo +':'+ pKode+':'+pSize+':'+pColor+':'+pNama+':'+pJml+':'+pHarga+':'+pSubTot);  
 var vURL = "../memstock/register_purc_ajax.php";
   $('#tdLoad').html('<img src="../images/ajax-loader.gif" />');
  
 $.post(vURL,{ delNo : pNo, delKode: pKode, delSize: pSize, delColor : pColor, delNama : pNama, delJml : pJml, delHarga : pHarga, delSubTot : pSubTot, op : 'del' }, function(data) {
      $('#tbPurc').html(data);
      $('#tdLoad').empty();

		 var xTot=	parseFloat($('#hTot').val()) + parseFloat($('#tfOngkir').val());
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
   var vURLAddr="../main/mpurpose_ajax.php?op=addrongkir";
   var vYes=/yesx/g;
   var vYesAddr=/yesaddr/g;
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
         
         $('#statKitSpon').html('<font color="#00f">Pebisnis valid!</font>');
         $('#tfSponsor').val(vNama);
         $('#tfPhoneSpon').val(vPhone);
         $('#tfEmailSpon').val(vEmail);
         $('#tfAlamat').val(vAlamat);

      //  alert(vPhone+':'+vEmail);
      


         document.getElementById('btnSubmit').disabled=false;     
         document.getElementById('btAdd').disabled=false; 
         var vYMonth='<?=date("Ym")?>';
		 <? if(count($_POST)<=0){ ?>
         $.get('../main/mpurpose_ajax.php?op=checkmultiro&user='+pParam.value+'&ymonth='+vYMonth,function(data){
             if(parseFloat(data.trim()) >=100000000000 ) {
                alert('This member already have maximum RO in this month, please choose other member!');
		         document.getElementById('btnSubmit').disabled=true;     
		         document.getElementById('btAdd').disabled=true;               
             }
         });
		 <? } ?>
		 <? if(count($_POST)<=0){ ?>
		 $.post(vURLAddr, {sernospon : '<?=$vSeller?>'},function(data) {
			 if (vYesAddr.test(data)) {
			 	$('#statAddr').html('<font color="#060">, alamat seller (<?=$vSellerName?>) valid!</font><input type="hidden" name="hSeller" id="hSeller" value="<?=$vSeller?>">');
			 } else {
				 alert('Seller belum diset untuk produk ini, atau alamat seller (<?=$vSellerName?>) tidak valid, transaksi tidak dapat dilanjutkan. Hubungi admin untuk update data seller!');
				 
				 document.location.href='<?=$_SERVER['HTTP_REFERER']?>';
				 return false;
			 }
		 });
		 <? }?>
     }    
   $('#loadNama').hide();  
   });   

  }
}

function setUpper(pParam) {
   document.getElementById(pParam.name).value=document.getElementById(pParam.name).value.toUpperCase();
}


function setCurr(pParam,pNom) {
    var vURL='../main/mpurpose_ajax.php?op=currconvert&from=IDR&to='+pParam+'&nom='+pNom;
	<? if(count($_POST)<=0){ ?> 
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
	<? } ?>

}




function prepareProp(pParam) {
   var vURL="../main/mpurpose_ajax.php?op=wil&wil=propongkir&kodewil="+pParam.value;
  $('#loadProp').show();

  $.get(vURL, function(data) {
      $('#fprop').html(data);
      $('#loadProp').hide();
	  $('#fprop').val('<?=$vPropL?>');
	  $('#fprop').trigger('change');
	  $('#fprop').select2();
   });   

}





function prepareKota(pParam) {
   var vCountry=$('#fcountry').val();
   if (pParam.value !='PX') {
	   var vURL="../main/mpurpose_ajax.php?op=wil&neg="+vCountry+"&wil=kotaongkir&prov_id="+pParam.value;
	   $('#loadKota').show();
	   $('#tfprop').hide();
       $('#tfkota').hide();
	   $.get(vURL, function(data) {
	      $('#fkota').html(data);
	       $('#loadKota').hide();
		   $('#fkota').select2();
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
	   var vURL="../main/mpurpose_ajax.php?op=wil&neg="+vCountry+"&wil=kecaongkir&kota_id="+pParam.value;
	   $('#loadKeca').show();
	   $('#tfprop').hide();
       $('#tfkota').hide();
	   $.get(vURL, function(data) {
	       $('#fkec').html(data);
	       $('#fkec').select2();
		   $('#loadKeca').hide();
		   $('#fkec').val('<?=$vKecaL?>');
		   
	   });   
   } else {
     $('#tfprop').show();
      $('#tfprop').focus();     
   }
}



function getPaket(pParam) {
   var vCountry=$('#fcountry').val();
    var vKec=$('#fkec').val();
	var vExpe=pParam.value;
	var vBerat=$('#hTotWeight').val();
	$('#tfBerat').val(vBerat);
	var vKotaAsal = '<?=$vKotaAsal?>';
   if (pParam.value !='PX') {
	   var vURL="../main/mpurpose_ajax.php?op=packongkir";
	   $('#loadPack').show();
	   $('#tfprop').hide();
       $('#tfkota').hide();
	   $.post(vURL, {id_kecamatan:vKec, kurir:vExpe, berat:vBerat , id_kotaasal:vKotaAsal},function(data) {
	       $('#fpack').html(data);
	       $('#fpack').select2();
		   $('#loadPack').hide();
		   //$('#fkec').val('<?=$vKecaL?>');
		   
	   });   
   } else {
     $('#tfprop').show();
      $('#tfprop').focus();     
   }
}


function getOngkir(pParam) {
   $('#tfOngkir').val(($(pParam).find('option:selected').attr('ongkir')));
  // $('#lmKode').find('option:selected').attr('sweight')
}


function getOther(pParam) {
   if (pParam.value =='KX') {
     $('#tfKota').show();
      $('#tfKota').focus();
   } else  $('#tfKota').hide();
}

function zeroOngkir(){
	$('#tfOngkir').val('0');
	$('#fpack').val('0');	
	$('#fpack').trigger('change');	
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
		<div><label><h3>Pembelian Barang / Jasa</h3></label></div> 

<form method="post" id="frmReg" name="frmReg" action="<?=$_SERVER['PHP_SELF']?>"  >
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
											Data Pebisnis</label></div>
									</div>
									<div class="panel-body">
                                    <div class="form-group" style="margin-left:-15px" id="phonemailspon">
										<div class="col-lg-6 col-md-6 divtr">
											<label for="exampleInputEmail1">
											ID 
											Pebisnis * 
											<div align="left" style="display:inline" id="statKitSpon">
											</div>
                                            <div align="left" style="display:inline" id="statAddr">
											</div>
											</label>
											 <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>
												<input <? if ($vPriv!='administrator') echo 'readonly';?> value="<?=$vRef?>" type="text" class="form-control" id="tfSernoSpon" name="tfSernoSpon" placeholder="Member ID*" onBlur="checkKitSpon(this)" onKeyUp="setUpper(this)">
											</div>
									  </div>
										<div class="divtr hide">
											<img id="loadNama"  align="absmiddle" src="../images/ajax-loader.gif" style="position:absolute;z-index:2;margin-left:45px;margin-top:24px;opacity: 0.5;display:none" />
											<label for="exampleInputEmail1">Nama 
											Member*</label>
											<div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>
												<input readonly type="text" class="form-control" id="tfSponsor" name="tfSponsor" placeholder="Member Name*">
											</div>
										</div>
										
											<div class="col-lg-6 col-md-6 divtr hide" >
												<label for="exampleInputEmail1" >
												<span style="font-weight:bold">No Telepon 
												Member*</span></label>
												<div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-mobile"></i></span>
													<input  type="text" class="form-control" id="tfPhoneSpon" name="tfPhoneSpon" placeholder="Member Phone Number*">
												</div>
											</div>
											<div class="col-lg-6 col-md-6 divtr hide" >
												<label for="exampleInputEmail1" >
												<span style="font-weight:bold">Alamat Email 
												Member</span></label>
												<div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-envelope"></i></span>
													<input readonly type="email" class="form-control" id="tfEmailSpon" name="tfEmailSpon" placeholder="Member's Email Address">
												</div>
											</div>
											
											<div class="col-lg-6 col-md-6 divtr hide" >
												<label for="exampleInputEmail1" >
												<span style="font-weight:bold">Alamat Surat
												</span></label>
												<div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-envelope"></i></span>
													<textarea  style="padding-left:30px" readonly class="form-control" id="tfAlamat" name="tfAlamat" placeholder="Mailing Address"></textarea>
												</div>
											</div>

<div class="col-lg-6 col-md-6 divtr" >
												<label for="exampleInputEmail1" >
												<span style="font-weight:bold">Nama Penerima Barang *</span></label>
												<div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>
													<input  type="text" class="form-control" id="tfRecName" name="tfRecName" placeholder="Nama Penerima">
												</div>


										  </div>
                                            
  <div class="col-lg-6 col-md-6 divtr" >
												<label for="exampleInputEmail1" >
												<span style="font-weight:bold">Alamat Lengkap Penerima *</span></label>
												<div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-map"></i></span>
													<input  type="text" class="form-control" id="tfRecAddr" name="tfRecAddr" placeholder="Contoh: Jl. Sawi 89 Jakarta">
												</div>
										  </div>
 
 


                               <div class="col-lg-6 col-md-6 divtr" >
 

                                <label for="exampleInputEmail1" ><span style="font-weight:bold">Negara*</span></label>

                                                                 <!-- <input type="text" class="form-control" id="tfNama" placeholder="Country*"> -->

                                <select style="pointer-events:none;background-color:#CCC" class="form-control m-bot15" id="fcountry" name="fcountry" onChange="prepareProp(this);zeroOngkir()">

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

                              

     							<div class="clearfix"></div>                    

                               <div class="col-lg-6 col-md-6 divtr" id="divProp">

                               <img id="loadProp"  align="absmiddle" src="../images/ajax-loader.gif" style="position:absolute;z-index:2;margin-left:45px;margin-top:24px;opacity: 0.5;display:none" />

                                <label for="exampleInputEmail1" ><span style="font-weight:bold">Propinsi*</span></label>

                                                                <select class="form-control m-bot15" id="fprop" name="fprop" onChange="prepareKota(this);zeroOngkir()">

                                <option  value="" selected="selected" >--Pilih / Choose--</option>

                                <option  value="PX"  >Other Province</option>



								</select>

								<input style="display:none" type="text" class="form-control" id="tfprop" name="tfprop" placeholder="Other Province">

								

                                </div>

                            

                              

     						 <div class="col-lg-6 col-md-6 divtr" id="divKota">
                                <img id="loadKota"  align="absmiddle" src="../images/ajax-loader.gif" style="position:absolute;z-index:2;margin-left:45px;margin-top:24px;opacity: 0.5;display:none" />
                                <label for="exampleInputEmail1" ><span style="font-weight:bold">Kabupaten/Kota*</span></label>
                                <select class="form-control m-bot15" id="fkota" name="fkota" onChange="prepareKeca(this);zeroOngkir()">
                                <option  value="" selected="selected" >--Pilih / Choose--</option>
                                <option  value="KX"  >Kota Lain</option>
								</select>
								<input style="display:none" type="text" class="form-control" id="tfkota" name="tfkota" placeholder="Other City">
                               </div>                        

                              

<div class="col-lg-6 col-md-6 divtr" id="divKec">
                                <img id="loadKeca"  align="absmiddle" src="../images/ajax-loader.gif" style="position:absolute;z-index:2;margin-left:45px;margin-top:24px;opacity: 0.5;display:none" />
                                <label for="exampleInputEmail1" ><span style="font-weight:bold">Kecamatan*</span></label>
                                <select class="form-control m-bot15" id="fkec" name="fkec" onChange="getOther(this);zeroOngkir()">
                                <option  value="" selected="selected" >--Pilih / Choose--</option>
                                <option  value="KX"  >Kec Lain</option>
								</select>
								<input style="display:none" type="text" class="form-control" id="tfkec" name="tfkec" placeholder="Other City">
                               </div>
                               
                         
<div class="col-lg-6 col-md-6 divtr" id="divExpe">
                                <img id="loadexpe"  align="absmiddle" src="../images/ajax-loader.gif" style="position:absolute;z-index:2;margin-left:45px;margin-top:24px;opacity: 0.5;display:none" />
                                <label for="exampleInputEmail1" ><span style="font-weight:bold">Expedisi*</span></label>
  <select class="form-control m-bot15 " id="fexpe" name="fexpe" onChange="getPaket(this);zeroOngkir()">
                                <option  value="" selected="selected" >--Pilih / Choose--</option>
                                <option  value="jne">JNE</option>
                                <option  value="jnt">JNT</option>
                                <option  value="wahana">Wahana</option>
                                <option  value="pos">POS Indonesia</option>
								</select>
								
                               </div>                               
                                                                                      
 
 <div class="col-lg-6 col-md-6 divtr" id="divPack">
                                <img id="loadPack"  align="absmiddle" src="../images/ajax-loader.gif" style="position:absolute;z-index:2;margin-left:45px;margin-top:24px;opacity: 0.5;display:none" />
                                <label for="exampleInputEmail1" ><span style="font-weight:bold">Jenis Paket*</span></label>
                                <select class="form-control m-bot15" id="fpack" name="fpack" onChange="getOngkir(this);calcTot()">
                                <option  value="" selected="selected" >--Pilih / Choose--</option>
                                
								</select>
								
                               </div>
                                              
<div class="col-lg-6 col-md-6 divtr" >
												<label for="exampleInputEmail1" >
												<span style="font-weight:bold">No HP Penerima Barang *</span></label>
												<div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-mobile"></i></span>
													<input  type="text" class="form-control" id="tfRecPhone" name="tfRecPhone" placeholder="Contoh: 0897997794">
												</div>
										  </div>

<div class="col-lg-6 col-md-6 divtr" >
												<label for="exampleInputEmail1" >
												<span style="font-weight:bold">Berat Total (gr) *</span></label>
												<div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-money"></i></span>
													<input  type="text" class="form-control" id="tfBerat" name="tfBerat"  value="0" readonly>
												</div>
										  </div>

		<div class="col-lg-6 col-md-6 divtr" >
												<label for="exampleInputEmail1" >
												<span style="font-weight:bold">Biaya/Ongkos Kirim *</span></label>
												<div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-money"></i></span>
													<input  type="text" class="form-control" id="tfOngkir" name="tfOngkir" placeholder="Contoh: 30000 (tanpa titik/koma)" onChange="calcTot()" value="0" readonly>
												</div>
										  </div>
                                          
                                          
                                          
      <div class="col-lg-6 col-md-6 divtr" >
												<label for="exampleInputEmail1" >
												<span style="font-weight:bold">Biaya Admin Bank*</span></label>
												<div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-money"></i></span>
													<input  type="text" class="form-control" id="tfBankFee" name="tfBankFee" placeholder="Contoh: 4500 (tanpa titik/koma)" onChange="calcTot()" value="<?=$vBankFee?>" readonly>
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
					                               <br style="display: block;margin: -5px 0;" /><label for="exampleInputEmail1" style="font-size:13px;color:green">Saldo  : <?=number_format($vSalProd,0,",",".")?></label>
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
								    $vSQL="select distinct fidproduk, fsize, fidcolor, fnamaproduk, fhargajual1,fhargajual2, fsatuan, fberat from  m_product   where  faktif='1'  order by fidproduk";
								    $db->query($vSQL);
								    $vColorText="";
								    while($db->next_record()) {
								       $vCode=$db->f('fidproduk');
								       $vSize=$db->f('fsize');
									   $vWeight=$db->f('fberat');
								       $vColor = $db->f('fidcolor');
								       $vColName=$oProduct->getColor($vColor);
								       $vJmlItem = $db->f('fsatuan');

								       
								       $vNama=$db->f('fnamaproduk');
								       //.";$vSize;$vColor/$vColName";
								       $vHarga=number_format($db->f('fhargajual1'),0,"","");
								        $vQoh=number_format($db->f('fbalance'),0);

								      								       
								?>
								<option colors="<?=$vColor?>" qoh="<?=$vQoh?>" jmlitem="<?=$vJmlItem?>"   price="<?=$vHarga?>" sizes="<?=$vSize?>" sweight="<?=$vWeight?>" value="<?=$vCode?>" selected="selected"><?=$vCode.";".$vNama?></option>

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
                                <td style="width: 33px">&nbsp;<input type="hidden"  id="hWeight" name="hWeight" value="">
                   
                                <input type="hidden"  id="hItemSat" name="hItemSat" value="">
                                <input type="hidden"  id="hQoh" name="hQoh" value="">
                                <input type="hidden" name="hJmlItem" id="hJmlItem" value="" /> 
                                </td>
                                <td align="left" style="width: 208px" colspan="2"><input disabled="disabled" id="btAdd" type="button" onClick="doAdd()" class="btn btn-info btn-sm hide" value="Add Item +"/>&nbsp;<input type="button" onClick="doCancel()" class="btn btn-default btn-sm" value="Cancel" id="btCancel" style="display:none"/></td>
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
           <option value="wpr">Saldo Bonus</option>
		   <? if ($_SESSION['LoginUser']=='1401-0000-0001') { ?>
           <option value="tva">Transfer Virtual Account</option>
		   <? } ?>
           <!-- <option value="wtr">Wallet Product + Cash / Transfer</option> -->
         </select>
       </div>
       
      <div class="col-lg-6">
       
         <label style="color:blue" for="lmMethod">Rekening</label>
         <select name="lmBank" id="lmBank" class="form-control" required  >
           <option value="">--Pilih--</option>
           <option value="CASH">Cash</option>
           <option value="<?=$vBank1?> <?=$vRekBank1?>"><?=$vBank1?> <?=$vRekBank1?></option>
           <option value="<?=$vBank2?> <?=$vRekBank2?>"><?=$vBank2?> <?=$vRekBank2?></option>
           <option value="<?=$vBank3?> <?=$vRekBank3?>"><?=$vBank3?> <?=$vRekBank3?></option>
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
                                        <button id="btnSubmit" type="submit" class="btn btn-primary" disabled="disabled" onClick="">Submit</button> <div id="divLoad" style="display:inline"></div>
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
	
	<button type="button" class="btn btn-info btn-lg" style="display:none" id="btnModal" data-toggle="modal" data-target="#dialogModal" data-backdrop="static">Open Modal</button>

<div class="modal fade " id="dialogModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="modalhead">Selesaikan Pembayaran Virtual Account</h4>
        </div>
        <div class="modal-body " style="padding: 2em 4em 3em 4em">
        <div class="row">
             <div class="col-lg-12" id="divContent">
                
             </div>
           
          </div>
          



        </div>
        <div class="modal-footer">
          <input type="hidden" id="hIdSys" name="hIdSys" value="" />
          <input type="hidden" id="hIdTrx" name="hIdTrx" value="" />
           <input type="hidden" id="hKind" name="hKind" value="" />

          <button type="button" id="btClose" name="btClose" class="btn btn-default" data-dismiss="modal" onClick="document.location.href='../manager/indexnonadmin.php';">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
<? include_once("../framework/member_footside.blade.php") ; ?>
