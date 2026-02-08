<?php include_once("../framework/admin_headside.blade.php")?>

<? 

 
  include_once("../classes/systemclass.php");
  include_once("../classes/ruleconfigclass.php");
  include_once("../classes/networkclass.php");
  include_once("../classes/memberclass.php");
  include_once("../classes/komisiclass.php");
  $vMailFrom=$oRules->getSettingByField('fmailadmin');
  $vVoucher=$oRules->getSettingByField('fvoucher');
//print_r($_POST);
 // $_SESSION['Ref']='';
  $vPriv=$_SESSION['Priv']; 
  if ($_SESSION['Ref'] == '' )     
   $vRead=''; 
  else  
   $vRead='readonly';
   $vRead=''; 
  $vRef = base64_decode($_GET['ref']);
  $vProd = $_GET['prod'];
  
   $vSQL="select * from m_tour where fidtour='$vProd'";
  $db->query($vSQL);
  $db->next_record();
  $vJenis = strtoupper($db->f('fgroup'));
  $vPaket = $db->f('fpaket');
  $vProg = $db->f('fprogram');
  $vTglDepart = $db->f('ftgldepart');
  
  

  $vOngkir=$oRules->getSettingByField('fongkir');  
  $vArabAssUSD=$oRules->getSettingByField('farabinsure');  
  $vKurs=$oRules->getSettingByField('finfokursusd');
  $vArabAssRP = $vArabAssUSD * $vKurs;





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
		 $fnamarefer = str_replace("'","''",$fnamarefer);
		 if ($vPriv=='administrator') {
		    $faktif='1';
			$ftglaktif=date("Y-m-d H:i:s");

			$vSQL="update m_tour set fsisaseat=fsisaseat-1 where fidtour='$vProd'";
			$db->query($vSQL);
			$vSQL="INSERT INTO tb_logchange(fkdanggota, fold, fnew, ftipe, fket, fstatusrow, ftglentry) ";
			$vSQL .="values('$fidmember', $hSisaSeat, $hSisaSeat-1, 'deduct-seat', 'Pengurangan Seat (Pendaftaran)', '1', now());";
			$db->query($vSQL);
		 } else {
		    $faktif='0';
			$ftglaktif="null";
			 
		 }
			
			$fnama = str_replace("'","''",$fnama);
			$fnamabuss = str_replace("'","''",$fnamabuss);
			$fwarisbuss = str_replace("'","''",$fwarisbuss);
			$fayah = str_replace("'","''",$fayah);
			$fkakek = str_replace("'","''",$fkakek);
			 if ($oMember->regPilgrims($fidmember, $fjenis, $fstorawal, $fangsur1, $fangsur2, $fangsur3, $fangsur4, $flunas, $ftotalbayar, $frefer, $fnama, $tfHP, $fnamabank, $fnorekening, $ftempat, $ftgllahir, $falamat, $fkota, $fkodepos, $fprop, $femail, $fpassword, $fpaspor, $fnamarefer, $faktif, $ftglaktif, $fatasnama, $fkotabank, $ftgldaftar,  $ftglentry, $fcount, $fcabbank, $fcountrybank, $fswift, $flastuser, $flastupdate, $ftitle, $fsex, $fnation, $ffoto, $fdoc, $fnoktp, $fcountry, $fket, $fnpwp,$fpaket,$fpaketday,$fjenpay,$fprogram,$fprice,$fairporttax,$fassure,$fkakek,$fayah,$fkec,$fdes,$fnohprefer,$fnoktprefer,$fnamabuss,$fnohpbuss,$fnoktpbuss,$ftgldepart,$farabassure,$fwarisbuss,$fpromo,$vProd,$_SESSION['LoginUser'],$fjenispax,$db)==1) {  

			 }
			
		
			$oMember->updMemCount($vYear,$vMonth,$vCounter,$db);
	 if ($vPriv=='administrator') {		
			$vNom = 0;
			if ($fstorawal > 0) {
				   $vDesc = "Setoran Awal";
				   $oKomisi->insertPayment($fidmember,$fidmember,date("Y-m-d H:i:s"),$vDesc,$fstorawal,0,$fstorawal,'sawal') ;
			}
	  	    
			if ($fangsur1 > 0) {
				   $vDesc = "Angsuran 1";
				   $vNom = $fstorawal + $fangsur1;
				   $oKomisi->insertPayment($fidmember,$fidmember,date("Y-m-d H:i:s"),$vDesc,$fangsur1,0,$vNom,'fangsur1') ;
			}


			if ($fangsur2 > 0) {
				   $vDesc = "Angsuran 2";
				   $vNom = $fstorawal + $fangsur1 + $fangsur2;
				   $oKomisi->insertPayment($fidmember,$fidmember,date("Y-m-d H:i:s"),$vDesc,$fangsur2,0,$vNom,'fangsur2') ;
			}


			if ($fangsur3 > 0) {
				   $vDesc = "Angsuran 3";
				   $vNom = $fstorawal + $fangsur1 + $fangsur2 + $fangsur3;
				   $oKomisi->insertPayment($fidmember,$fidmember,date("Y-m-d H:i:s"),$vDesc,$fangsur3,0,$vNom,'fangsur3') ;
			}


			if ($fangsur3 > 0) {
				   $vDesc = "Angsuran 4";
				   $vNom = $fstorawal + $fangsur1 + $fangsur2 + $fangsur3 + $fangsur4;
				   $oKomisi->insertPayment($fidmember,$fidmember,date("Y-m-d H:i:s"),$vDesc,$fangsur4,0,$vNom,'fangsur4') ;
			}
	


			if ($flunas > 0) {
				   $vDesc = "Pelunasan";
				   $vNom = $fstorawal + $fangsur1 + $fangsur2 + $fangsur3 + $fangsur4 + $flunas;
				   $oKomisi->insertPayment($fidmember,$fidmember,date("Y-m-d H:i:s"),$vDesc,$flunas,0,$vNom,'flunas') ;
			}


			if ($fairporttax > 0) {
				   $vDesc = "Perlengkapan";
				   $vNom = $fstorawal + $fangsur1 + $fangsur2 + $fangsur3 + $fangsur4 + $flunas +  $fairporttax;
				   $oKomisi->insertPayment($fidmember,$vIdMem,date("Y-m-d H:i:s"),$vDesc,$fairporttax,0,$vNom,'handle') ;
			}
			
			
			if ($fassure > 0) {
				   $vDesc = "Asuransi";
				   $vNom = $fstorawal + $fangsur1 + $fangsur2 + $fangsur3 + $fangsur4 + $flunas +  $fairporttax + $fassure;
				   $oKomisi->insertPayment($fidmember,$vIdMem,date("Y-m-d H:i:s"),$vDesc,$fassure,0,$vNom,'assure') ;
			}


			if ($farabassure > 0) {
				   $vDesc = "Asuransi Saudi Arabia";
				   $vNom = $fstorawal + $fangsur1 + $fangsur2 + $fangsur3 + $fangsur4 + $flunas +  $fairporttax + $fassure + $farabassure;
				   $oKomisi->insertPayment($fidmember,$vIdMem,date("Y-m-d H:i:s"),$vDesc,$farabassure,0,$vNom,'arabassure') ;
			}
	 } //Priv admin
	if($db->query('COMMIT;')) {	  
	   $oSystem->jsAlert("Pendaftaran sukses dengan ID $fidmember!");	
	//  $oSystem->jsLocation("../manager/register.php?op=&current=mdm_memnet&menu=mdm_memnet_profile");
	  $oSystem->jsLocation($_SERVER['HTTP_REFERER']);

	}  else {
	    $oSystem->jsAlert('Pendaftaran gagal!');	
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

  alert('Sistem sedang memproses diskon pukul 00:00:00 - 03:00:00, silakan melakukan registrasi di luar jam tersebut!');

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
			
			if($('#fstorawal').val() <=0) {
			   alert('Setoran awal harus diisi!');	
			   return false;
			}

		   

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
				$("footer").css('width','100%');
				$("footer").css('margin-left','0px');
			
			 //  alert('ssss');
			
			  // alert($('#hHarga').val());
			
			  if ('<?=trim($_SESSION['Ref'])?>'  != '') {
			
				//  $('#tfSernoSpon').trigger('blur');
			
			  }
			
			   $('#tfIdent').attr('maxlength',16);
			
			
			
			   $('#caption').html('Register Jamaah');
			
			
			
			
			
			$('#ftgllahir').combodate(
			
			{
			
				minYear: 1930,
			
				maxYear: <?=date('Y')?>,
			
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
			
			  $('#frmReg input, #frmReg textarea,  #frmReg select, #frmReg checkbox, #frmReg radio').not([type="submit"]).not($("#fidmember")).not($("#femail")).not($("#fpropo")).not($("#fkota")).not($("#fpaspor")).not($("#tfBranchBank")).not($("#tfSernoUpName")).not($("#femail")).not($("#cboxVoucher")).addClass('required');  
			
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
			
			  //$('#frefer').select2();
			  
			  <? if ($vRef !='') { ?>
				 $('#frefer').val('<?=$vRef?>');
				 $('#frefer').trigger('blur');
			  
			  <? } ?>
			 
		<? if ($vTglDepart !='') {?>
			$('#ftgldepart').val('<?=$vTglDepart?>');
			$('#ftgldepart').trigger('change');
		
		<? } ?>	
		
		
	<? if ($vPaket !='') {?>
			$('#fpaket').val('<?=$vPaket?>');
			$('#fpaket').trigger('change');
		
		<? } ?>		
		
		<? if ($vProg !='') {?>
			$('#fprogram').val('<?=$vProg?>');
			$('#fprogram').trigger('change');
		//	$('#fangsur1').attr('readonly','readonly');	
			if ($('#fprogram').val()!='19') {
				
				$('#cboxVoucher').attr('disabled','disabled');	
			}
		
		<? } ?>		
		
		$('#cboxVoucher').click(function(){
			if (this.checked) {
				$('#fangsur1').val('<?=$vVoucher?>');
			} else {
				$('#fangsur1').val('0');
			}
			
		});
				
});

function calcSA(pThis){
   	if (pThis.value>0) {
			var vSAOri = pThis.value;
			var vSA = pThis.value;
			var vAI = $('#fassure').val();
			var vHandle = $('#fairporttax').val();
			var vAA = $('#farabassure').val();
			vSA = parseFloat(vSA) - parseFloat(vAI) - parseFloat(vHandle) - parseFloat(vAA); 
			pThis.value=vSA;
			var vMessage = "<font color='#00f'>DP Anda "+vSAOri+" terbagi menjadi setoran awal "+vSA+", asuransi "+vAI+",  asuransi Arab Saudi "+vAA+", biaya perlengkapan &amp; handle  "+vHandle+"</font>";
			$('#lblStor').remove();
			$('#groupStor').after('<label id="lblStor">'+vMessage+'</label>');
			calcPay();
	}
}

function getSeat(pDepart) {

  		var vURL="../main/mpurpose_ajax.php?op=getseat&depart="+pDepart+'&prod=<?=$vProd?>';
		$.get(vURL,function(data){
			var vObj=$.parseJSON(data);
			if (vObj.status=='success') {
				//alert(vObj.data.price);
				$('#spSisa').html(vObj.data.sisaseat);
				$('#spPlane').html(vObj.data.plane);
				$('#spDesc').html(vObj.data.fdesc);
				if (vObj.data.plane===null) $('#spPlane').html('-');
				$('#spDepart').html(vObj.data.depart);
				$('#spHotel').html(vObj.data.hotel);
				$('#hSisaSeat').val(vObj.data.sisaseat);
			} else {
				$('#spSisa').html('-');
				$('#spPlane').html('-');
				$('#spDepart').html(vObj.data.depart);
				$('#hSisaSeat').val(0);
				$('#spDesc').html('');
				
			}
			
			$('#divSeat').show();
			if ($('#hSisaSeat').val()>0) {
			   document.getElementById('btnSubmit').disabled=false;
			} else { 
			   alert('Seat tidak tersedia untuk tanggal keberangkatan '+vObj.data.depart+', Anda tidak dapat melanjutkan pendaftaran!');
			   document.getElementById('btnSubmit').disabled=true;   
			   if ('<?=$vPriv?>'=='administrator') {
			   		document.location.href='../manager/indexadmin.php';
			   } else {
				   document.location.href='../manager/indexnonadmin.php';
			   }
			}
			   
			//console.log(vObj.data.hari);
		});
		
		
  
}



function spreadPProg(pDepart,pProg,pPaket) {
  if (pPaket !='' && pProg!='' && pDepart!='') {
  		var vURL="../main/mpurpose_ajax.php?op=thepprog&ppaket="+pPaket+"&pprog="+pProg+'&depart='+pDepart+'&prod=<?=$vProd?>';
		$.get(vURL,function(data){
			var vObj=$.parseJSON(data);
			if (vObj.status=='success') {
				//alert(vObj.data.price);
				$('#fpaketday').val(vObj.data.hari);
				$('#fprice').val(vObj.data.price);
				$('#fassure').val(vObj.data.assure);
				$('#fairporttax').val(vObj.data.handle);
				if (vObj.data.desc !== null && $('#fprogram').val()=='4') {
					$('#spPromo').html('<font color="#00f">'+vObj.data.desc+'</font>');
					$('#fpromo').val(vObj.data.idpromo);
					
					$('#fpaketday').val(vObj.data.haripromo);
					if (vObj.data.fcurr =='IDR')
						$('#fprice').val(vObj.data.pricepromo);
					else 
						$('#fprice').val(vObj.data.foreprice);	
					$('#fassure').val(vObj.data.assurepromo);
					$('#fairporttax').val(vObj.data.handlepromo);
					
					
				} else { 
					$('#spPromo').html('<font color="#f00">Tidak ada promo pada tanggal '+pDepart+'</font>');	
					$('#fpromo').val('');	
					$('#fpaketday').val(vObj.data.hari);
					//$('#fprice').val(vObj.data.price);
					if (vObj.data.fcurr =='IDR')
						$('#fprice').val(vObj.data.price);
					else 
						$('#fprice').val(vObj.data.foreprice);	

					$('#fassure').val(vObj.data.assure);
					$('#fairporttax').val(vObj.data.handle);				
				}
			} else {
				$('#fpaketday').val('0');
				$('#fprice').val('0');
				$('#fassure').val('0');	
				$('#fairporttax').val('0');		
				alert(vObj.message);	
			}
			
			//console.log(vObj.data.hari);
		});
		
		
  } else {
				$('#fpaketday').val('0');
				$('#fprice').val('0');
				$('#fassure').val('0');	
				$('#fairporttax').val('0');	
				$('#fpromo').val('');			
	  
  }
  
     if($('#fprogram').val()=='4') {
      $('#divPromo').show();
   } else {
      $('#divPromo').hide();
   }
}



function spreadPProgCode(pCode,pPaket) {
	//pPaket=$("#fprogram option:selected").attr("paket");
	pPax = '';
	if ($("#fjenispax").val() != '') 
		pPax = $("#fjenispax").val();
	
  if (pPaket !='' && pCode!='') {
	    var pProg = $("#fprogram").val();
  		var vURL="../main/mpurpose_ajax.php?op=thepprogcode&ppaket="+pPaket+"&code="+pCode+"&pprog="+pProg+'&pax='+pPax;
		$.get(vURL,function(data){
			var vObj=$.parseJSON(data);
			if (vObj.status=='success') {
				//alert(vObj.data.price);
				$('#fpaketday').val(vObj.data.hari);
				$('#fprice').val(vObj.data.price);
				$('#fassure').val(vObj.data.assure);
				$('#fairporttax').val(vObj.data.handle);
			//	$('#fpaket').val($("#fprogram option:selected").attr("paket"));
				getSeatCode(pCode,$("#fpaket").val());			
				
			} else {
				$('#fpaketday').val('0');
				$('#fprice').val('0');
				$('#fassure').val('0');	
				$('#fairporttax').val('0');		
				$('#fpaket').val('');	
			}
			
			//console.log(vObj.data.hari);
		});
		
		
  } else {
				$('#fpaketday').val('0');
				$('#fprice').val('0');
				$('#fassure').val('0');	
				$('#fairporttax').val('0');	
				$('#fpromo').val('');			
	  
  }
  
     if($('#fprogram').val()=='4') {
      $('#divPromo').show();
   } else {
      $('#divPromo').hide();
   }
}



function getSeatCode(pCode,pPaket) {

  		var vURL="../main/mpurpose_ajax.php?op=getseatcode&code="+pCode+'&paket='+pPaket;
		$.get(vURL,function(data){
			var vObj=$.parseJSON(data);
			if (vObj.status=='success') {
				//alert(vObj.data.price);
				$('#spSisa').html(vObj.data.sisaseat);
				$('#spPlane').html(vObj.data.plane);
				if (vObj.data.plane===null) $('#spPlane').html('-');
				$('#spDepart').html(vObj.data.depart);
				$('#spHotel').html(vObj.data.hotel);
				//$('#spJenPax').html(vObj.data.jenpax);
				$('#hSisaSeat').val(vObj.data.sisaseat);
			} else {
				$('#spSisa').html('-');
				$('#spPlane').html('-');
				$('#spDepart').html(vObj.data.depart);
				$('#hSisaSeat').val(0);
				
			}
			
			$('#divSeat').show();
			if ($('#hSisaSeat').val()>0) {
			   document.getElementById('btnSubmit').disabled=false;
			} else { 
			   alert('Seat tidak tersedia untuk tanggal keberangkatan '+vObj.data.depart+', Anda tidak dapat melanjutkan pendaftaran!');
			   document.getElementById('btnSubmit').disabled=true;   
			   if ('<?=$vPriv?>'=='administrator') {
			   		document.location.href='../manager/indexadmin.php';
			   } else {
				   document.location.href='../manager/indexnonadmin.php';
			   }
			}
			   
			//console.log(vObj.data.hari);
		});
		
		
  
}

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
	 var vIndoAss = $('#fassure').val();
	 var vArabAss = $('#farabassure').val();
	 var vHandle = $('#fairporttax').val();
	 var vTotal = parseFloat(vSAwal) + parseFloat(vAngsur1) + parseFloat(vAngsur2) + parseFloat(vAngsur3) + parseFloat(vAngsur4) + parseFloat(vLunas) + parseFloat(vIndoAss) + parseFloat(vArabAss) + parseFloat(vHandle); 
     
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

         $('#statKitSpon').html('<font color="#f00">Referensi Tidak Valid!</font>');

         document.getElementById('btnSubmit').disabled=true;



     } else if (vYes.test(data)) {

		   vNamaS=data.split('|');

		   vNama=vNamaS[1];

		   vPhone=vNamaS[2];

		   vEmail=vNamaS[3];

         

         $('#statKitSpon').html('<font color="#00f">Referensi  valid!</font>');

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

		   

         $('#statKitUp').html('<font color="#f00">Upline Tidak Valid, di luar jaringan referensi '+vSpon+'!</font>');

		

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

	

	   if (vJml >=10000) {

	      alert('KTP sudah pernah digunakan untuk pendaftaran, silakan masukkan nomor KTP lainnya!');

	      document.getElementById('btnSubmit').disabled=true;

	      document.getElementById('fnoktp').value='';

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

function spreadRef(pParam){
   if (pParam.value.trim() !='') {
		   
		   var vURL = '../main/mpurpose_ajax.php?op=getref';
		   var vSucc = /xsuccessref/;
		   var postdata = {"ref":pParam.value};
		   var vMessage='';
		    $('#statKitPres').html('&nbsp;<img src="../images/ajax-loader-bar.gif" />');
		   $.post(vURL,postdata,function(ret){
			  var vObj = $.parseJSON(ret);
			  
			  if(vObj.status=='xsuccessref') {
				  vMessage = '<font color="#00f">'+vObj.message+'</font>';
				 // alert(vObj.message); 
				  $('#fnamarefer').val(vObj.data.nama);
				  $('#fnohprefer').val(vObj.data.jhandphone);
			  } else {
				 vMessage = '<font color="#f00">'+vObj.message+'</font>';
				  pParam.value='';
			  }
			  
			  $('#statKitPres').html(vMessage);
			   
		   });
		   
   }
   
}

function spreadPromo(pParam){
   $('#fpaketday').val($('#'+pParam.id+' option:selected').attr('prhari'));
   $('#fprice').val($('#'+pParam.id+' option:selected').attr('prprice'));
   $('#fassure').val($('#'+pParam.id+' option:selected').attr('prassure'));
   $('#fairporttax').val($('#'+pParam.id+' option:selected').attr('prhandle'));
   
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
		<h3>Registrasi Jamaah <? if ($_GET['current']=='mdm_korwil_sub') echo " oleh Korwil / Sub Korwil";?></h3></label></div> 



<form method="post" id="frmReg" name="frmReg" action="">

	<div class="container" >

    <div class="row" style="width:98%;margin-top:8px">

<div class="col-md-6" id="kolomkanan">

                    <div class="panel panel-default" id="panelkiri">

                    <div class="panel-heading" >

                             <div class="panel-title" style="margin-top:0px">

        						<label for="exampleInputEmail1" style="font-weight:bold;">

								 Bio Data</label>

                               <br style="display: block;margin: -5px 0;" />                                    

                     		</div>

                     </div>





                     

                     <div class="panel-body">
   
 <div class="divtr col-lg-12" >
                                <label   for="tfNama">
								Nama Lengkap*</label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" id="fnama" name="fnama" placeholder="(Tanpa tanda koma)*" onBlur="this.value=this.value.replace(/,/g,'');$('#tfAtasNama').val(this.value);" onKeyUp="this.value=this.value.replace(/,/g,'');$('#tfAtasNama').val(this.value);">
                                </div>
</div>  

<div class="divtr col-lg-6" >
                                <label   for="fayah">
								Nama Ayah*</label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" id="fayah" name="fayah" placeholder="(Tanpa tanda koma)*" onBlur="" onKeyUp="">
                                </div>
</div>     


<div class="divtr col-lg-6" >
                                <label   for="fkakek">
								Nama Kakek*</label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" id="fkakek" name="fkakek" placeholder="(Tanpa tanda koma)*" onBlur="" onKeyUp="">
                                </div>
</div>                        

<div class="divtr col-lg-12">

                                <label for="exampleInputEmail1" ><span style="font-weight:">Tempat Lahir*</span></label>

                                    <div class="input-group">

                                      <span class="input-group-addon"> <i class="fa fa-map-marker"></i></span>

                                <input type="text" class="form-control" id="ftempat" name="ftempat"  >

                                </div>

                              </div>            

<div class="divtr col-lg-8">

                                  <label for="exampleInputEmail1" >Tanggal Lahir*  <div align="left" style="display:inline;color:red" id="lblTL"></div></label>



                                    <div class="input-group">

                                      <span class="input-group-addon"> <i class="fa fa-calendar"></i></span>

                                         <input onBlur="checkAge(this.value)" onChange="checkAge(this.value)"  id="ftgllahir" name="ftgllahir" class="form-control " placholder="DD-MM-YYYY"   type="text" data-format="DD-MM-YYYY" data-template="D MMM YYYY"  >

                                    </div>

                                        



                                  </div>                                         
                       
                       
<div class=" divtr col-lg-4  col-md-4" >

                                   <label for="exampleInputEmail1" >

								   <span style="font-weight:bold">Kewarganegaraan*</span></label>

                                    <div class="input-group">

                                      <span class="input-group-addon"> <i class="fa fa-globe"></i></span>

                                <select class="form-control m-bot15" id="fnation" name="fnation">

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

									  <span style="font-weight:bold">&nbsp;Jenis Kelamin*</span></label>

                                    <div class="input-group">

                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>

                            <select class="form-control m-bot15" id="fsex" name="fsex">

                                <option value="" selected="selected">---Pilih / Choose---</option>

                                <option value="F">Perempuan / Female</option>

                                <option value="M">Laki-laki / Male</option>

                                <!-- <option value="O">Lainnya / Other </option>-->

                            </select>

                           </div>



                          </div>
                                                                      
                         <div class="divtr col-lg-6">

                                    <label for="exampleInputEmail1">ID Card / No KTP *</label>

                                    <div class="input-group">

                                      <span class="input-group-addon"> <i class="fa fa-id-card"></i></span>

                                    	<input type="number" maxlength="16" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control" id="fnoktp" name="fnoktp" onBlur="checkMultiIdent(this.value)" placeholder="ID Card No.*">

                               </div>

                             </div>  


<div class="divtr col-lg-6">

                                    <label for="exampleInputEmail1">Nomor Paspor *</label>

                                    <div class="input-group">

                                      <span class="input-group-addon"> <i class="fa fa-passport"></i></span>

                                    	<input type="text" maxlength="16" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control" id="fpaspor" name="fpaspor" onBlur="checkMultiIdent(this.value)" placeholder="No. Paspor.*">

                               </div>

                             </div>



<div class=" col-lg-6 col-md-12 divtr" >

                                <label for="exampleInputEmail1"><b>Email</b></label>

                                    <div class="input-group">

                                      <span class="input-group-addon"> <i class="fa fa-envelope"></i></span>

                                <input type="email" class="form-control" id="femail" name="femail" placeholder="Email Address">

                                </div>

                            </div>

                         <div class="form-group" >     

                        <div class="divtr col-lg-12">

                            <label for="exampleInputEmail1">Alamat Lengkap dengan Kode Pos*</label>

                                    <div class="input-group">

                                      <span class="input-group-addon"> <i class="fa fa-envelope"></i></span>

                                <textarea id="falamat" name="falamat" class="form-control custom-control" rows="2" style="resize:none"></textarea>

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

                                                                

   							                    

                               <div class="col-lg-12 col-sm-12 col-md-12 divtr" >

                                   <label for="exampleInputEmail1" >

								   <span style="font-weight:bold">&nbsp;Nomor Telepon*</span></label>

                                   <div class="form-inline">

                                    <div class="input-group">

                                      <span class="input-group-addon"> <i class="fa fa-mobile"></i></span>

                                

                                <input  type="text" class="form-control" id="fprefix" name="fprefix" value="+62" style="max-width:50px">

                                

                                </div>

                                

                                

                                <input  type="number" class="form-control" id="fnohp" name="fnohp" placeholder="Contoh: 8123456781 (tanpa 0 di depan)"  style="max-width:110px;margin-top:-10px">

                                </div>

                              </div>

                              

 							                              

                              

						</div>



                     

                     </div>

	 <!--Referensi -->
					 
				<div class="panel-heading" >

                             <div class="panel-title" style="margin-top:0px">

        						 <label for="exampleInputEmail1" style="font-weight:bold;">

								 Data Pebisnis</label>
       						   <br style="display: block;margin: -5px 0;" />                                    

                     		</div>

              </div>

                     <div class="panel-body" style="color:black">
<div style="" class=" divtr col-lg-12">

							<label for="exampleInputEmail1">Pebisnis* <div align="left" style="display:inline" id="statKitPres"></div></label>

                                    <div class="input-group">

                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>

                                   <input type="text" class="form-control" id="frefer" name="frefer" placeholder="Masukkan Kode Pebisnis" value="" <?=$vRead?> onBlur="spreadRef(this)" onChange=""  >
								   <!-- <select class="form-control m-bot15" id="frefer" name="frefer" onChange="spreadRef(this)">
                            <option  value="" selected="selected" >--Pilih / Choose--</option>
                                <?
                                    $vSQL="select kode,nama, jhandphone from tmmember ";
									$oDBAMHT->query($vSQL);
									while($oDBAMHT->next_record()){
										$vKodeRef = $oDBAMHT->f('kode');
										$vNamaRef = $oDBAMHT->f('nama');
										$vHPRef = $oDBAMHT->f('jhandphone')
									
								?>
                                <option value="<?=$vKodeRef;?>"  tagnama="<?=$vNamaRef?>" taghp="<?=$vHPRef?>"  ><?=$vKodeRef;?> / <?=$vNamaRef;?></option>
                                <? } ?>
								
                               

                            </select> -->
								   
								   
                                    </div>                            
                            </div>					 
<div class="divtr col-lg-6" >
                                <label   for="tfNama">
								Nama Pebisnis*</label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" id="fnamarefer" name="fnamarefer" placeholder="(Tanpa tanda koma)*" readonly>
                                </div>
</div>		





<div class="divtr col-lg-6" >
                                <label   for="tfNama">
								Nomor HP Pebisnis*</label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-mobile"></i></span>
                                <input type="text" class="form-control" id="fnohprefer" name="fnohprefer" placeholder="" >
                                </div>
</div>		

<div class="divtr col-lg-12" >
                                <label   for="tfNama">
								Nomor KTP Pebisnis*</label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-id-card"></i></span>
                                <input type="text" class="form-control" id="fnoktprefer" name="fnoktprefer" placeholder="" >
                                </div>
</div>		
	 
					 </div>					 
                     <!--Panel Body-->

                     </div>

                     

                     <div class="panel panel-default hide">

 

                    <div class="panel-heading " >

                             <div class="panel-title" style="margin-top:0px">

        						<label for="exampleInputEmail1" style="font-weight:bold;">

								 Bank Account</label>

                               <br style="display: block;margin: -5px 0;" />                                    

                     		</div>

                     </div>





                     

                     <div class="panel-body">

						<div class="form-group" style="margin-left:-15px" id="kotacabnegbank"> 

							<div class="col-lg-6 col-md-6 divtr" >

                                <label for="exampleInputEmail1" >

								<span style="font-weight:bold">Bank Country*</span></label>

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



                         <div class="divtr col-lg-6"  style="margin-left:-15px">

                            <label for="exampleInputEmail1">Bank Account No*</label>

                                    <div class="input-group">

                                      <span class="input-group-addon"> <i class="fa fa-building-o"></i></span>

                                                <input type="number" oninput="maxLengthCheck(this);" class="form-control m-bot15" id="tfRek" name="tfRek" placeholder="Bank Account No*" readonly>

                                   </div>

                         </div>       

          				<div class="divtr col-lg-6">

                                    <label for="exampleInputEmail1">Bank Account Name*</label>

                                    <div class="input-group">

                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>

                                    	<input   type="text" class="form-control" id="tfAtasNama" name="tfAtasNama" placeholder="(Tanpa tanda koma) Bank Account Name*" onKeyUp="this.value=this.value.replace(/,/g,'');$('#tfAtasNama').val(this.value);" onBlur="this.value=this.value.replace(/,/g,'');$('#tfAtasNama').val(this.value);">

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

                     <div id="divPurc" style="border-radius:3px">

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

			



                </div>

       

 <div class="col-md-6">

                 <!--Col-md-6 kiri-->
		     

       
<div class="panel panel-default" id="panelkanan" >

                    <div class="panel-heading" >

                             <div class="panel-title" style="margin-top:0px">

        						 <label for="exampleInputEmail1" style="font-weight:bold;">

								 Program / Paket Umroh</label>
       						   <br style="display: block;margin: -5px 0;" />                                    

                     		</div>

              </div>

                     <div class="panel-body" style="color:black">

							 <div class="form-group" >






<div class="col-md-5 col-lg-6 divtr" >

                                      <label for="exampleInputEmail1">

									  <span style="font-weight:bold">&nbsp;Jenis Pemberangkatan*</span></label>

                                    <div class="input-group">

                                      <span class="input-group-addon"> <i class="fa fa-mosque"></i></span>

                            <select class="form-control m-bot15" id="fjenis" name="fjenis">
 <option value="">--Pilih Jenis--</option>

							                                <option value="U" <? if($vJenis=='U') echo 'selected'; ?>>Umroh</option>

							                                <option value="H" <? if($vJenis=='H') echo 'selected'; ?>>Haji</option>
                                                            <option value="D" <? if($vJenis=='D') echo 'selected'; ?>>Tour Domestik</option>
                                                            <option value="T" <? if($vJenis=='T') echo 'selected'; ?>>Tour Internasional</option>
                                                            <option value="L">Lainnya</option>

                            </select>

                           </div>
                                    


                          </div>





							<div style="" class="divtr col-lg-6 hide">

							<label for="exampleInputEmail1" >ID Jamaah*  
							<div align="left" style="display:inline" id="statKit"></div></label>
							

                                    <div class="input-group">

                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>

                                    <input type="text" class="form-control" id="fidmember" name="fidmember" placeholder="[Auto]"  readonly >
                              </div>                            
                            </div>


<div class="divtr col-lg-6">
                                  <label for="exampleInputEmail1" >Tanggal Berangkat*  </label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-calendar"></i></span>
                                          <select class="form-control m-bot15" id="ftgldepart" name="ftgldepart" onChange="$('#lblStor').remove();spreadPProg(this.value,$('#fprogram').val(),$('#fpaket').val());getSeat(this.value)" onFocus="$('#divSeat').hide();" onClick="$('#divSeat').hide();">
                                <option  value="" selected="selected" >--Pilih / Choose--</option>
								<? 
								    $vSQL="select distinct ftgldepart from m_tour order by ftgldepart";
								    $db->query($vSQL);
								    while ($db->next_record()) {
								?>                               
								 <option value="<?=$db->f('ftgldepart')?>"  ><?=$db->f('ftgldepart')?></option>
								 <? } ?>
                            </select>
                                    </div>
</div>


<div class="divtr col-lg-12" style="display:none" id="divSeat">
                                  <label id="lblSeat" for="exampleInputEmail1" style="color:#00f"><span id="spDesc"></span><br>Keberangkatan: <span id="spDepart"></span>, <span id="spPlane"></span>, Sisa seat: <span id="spSisa">0</span><span id="spHotel"></span> <span id="spJenPax" style="display:none"></span></label>
                                  <input  type="hidden" id="hSisaSeat" name="hSisaSeat" value="0" >
                                  
                                    
</div>

                        
 <div class="col-md-5 col-lg-6 divtr" id="divJenpax" >
                                      <label for="exampleInputEmail1">
									  <span style="font-weight:bold">&nbsp;Jumlah Pax*</span></label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-money"></i></span>
                            <select class="form-control m-bot15" id="fjenispax" name="fjenispax" onChange="spreadPProgCode('<?=$vProd?>',$('#fpaket').val())">
                           <!-- <option  value="" selected="selected" >--Pilih / Choose--</option>-->
                              <option  selected value="1"  >Single</option>   
                              <option  value="2"  >Double</option>  
                              <option  value="3"  >Triple</option>  
                              <option  value="4"  >Quad</option>  
								
                               

                            </select>
                           </div>
                          </div>

<div class="col-md-5 col-lg-6 divtr" >
                                      <label for="exampleInputEmail1">
									  <span style="font-weight:bold">&nbsp;Jenis Paket*</span></label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-gift"></i></span>
                                 <select class="form-control m-bot15" id="fpaket" name="fpaket" onChange="spreadPProg($('#ftgldepart').val(),$('#fprogram').val(),this.value)" style="background-color:#eee;pointer-events:none">
                                <option  value="" selected="selected" >--Pilih / Choose--</option>
								<? 
								    $vSQL="select * from m_paket order by fidsys";
								    $db->query($vSQL);
								    while ($db->next_record()) {
								?>                               
								 <option value="<?=$db->f('fpackid')?>"  ><?=$db->f('fpackname')?></option>
								 <? } ?>
                            </select>
                           </div>
                          </div>
<div class="col-md-5 col-lg-6 divtr" id="divProg" >
                                      <label for="exampleInputEmail1">
									  <span style="font-weight:bold">&nbsp;Program*</span></label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-money"></i></span>
                            <select class="form-control m-bot15" id="fprogram" name="fprogram" onChange="spreadPProg($('#ftgldepart').val(),this.value,$('#fpaket').val())" style="background-color:#eee;pointer-events:none">
                            <option  value="" selected="selected" >--Pilih / Choose--</option>
                                <?
                                    $vSQL="select * from m_program order by fidprogram ";
									$dbin->query($vSQL);
									while($dbin->next_record()){
								?>
                                <option value="<?=$dbin->f('fidprogram');?>"  ><?=$dbin->f('fnama');?></option>
                                <? } ?>
								
                               

                            </select>
                           </div>
                          </div>
<div class="col-md-5 col-lg-12 divtr " id="divPromo" style="display:none">

                                      <label for="exampleInputEmail1">

									  <span style="font-weight:bold">&nbsp;Promo*</span></label>

                                    <div class="panel-body" style="border:1px solid #cccc">

                                      
									  <span id="spPromo"></span>
									  <input class="form-control m-bot15" type="hidden" id="fpromo" name="fpromo" >

                          

                           </div>
                                    


                          </div>
                          <div style="" class=" divtr col-lg-6">

							<label for="exampleInputEmail1">Jumlah Hari* <div align="left" style="display:inline" id="statKitPres"></div></label>

                                    <div class="input-group">

                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>

                                    <input type="text" class="form-control" id="fpaketday" name="fpaketday" placeholder="Masukkan Jumlah Hari" value="" <?=$vRead?> onBlur=""  readonly >
                                    </div>                            
                            </div>   

                            


<div style="" class=" divtr col-lg-6">
							<label for="exampleInputEmail1">Harga* <div align="left" style="display:inline" id="statKitUp"></div></label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-money"></i></span>
                                    <input type="text" class="form-control" id="fprice" name="fprice" placeholder="0" value="0"  onBlur="" dir="rtl" onKeyUp=""  readonly  >
                                    </div>                            
 </div>


<div style="" class=" divtr col-lg-6">
							<label for="exampleInputEmail1">Perlengkapan &amp; Handle* <div align="left" style="display:inline" id="statKitUp"></div></label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-money"></i></span>
                                    <input type="text" class="form-control" id="fairporttax" name="fairporttax" placeholder="0" value="0"  onBlur="" dir="rtl" onKeyUp="if (!isNaN(this.value) && this.value !='') calcPay();" readonly   >
                                    </div>                            
 </div>


<div style="" class=" divtr col-lg-6">
							<label for="exampleInputEmail1">Asuransi Indonesia* <div align="left" style="display:inline" id="statKitUp"></div></label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-money"></i></span>
                                    <input type="text" class="form-control" id="fassure" name="fassure" placeholder="0" value="0"  onBlur="" dir="rtl" onKeyUp="if (!isNaN(this.value) && this.value !='') calcPay();"  readonly  >
                                    </div>                            
 </div>
 
 <div style="" class=" divtr col-lg-6">
							<label for="exampleInputEmail1">Asuransi Arab Saudi* <div align="left" style="display:inline" id="statKitUp"></div></label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-money"></i></span>
                                    <input type="text" class="form-control" id="farabassure" name="farabassure" placeholder="0" value="<?=$vArabAssRP?>"  onBlur="" dir="rtl" onKeyUp="if (!isNaN(this.value) && this.value !='') calcPay();" readonly   >
                                    </div>                            
 </div>

							<div class="col-md-5 col-lg-6 divtr" >
                                      <label for="exampleInputEmail1">
									  <span style="font-weight:bold">&nbsp;Jenis Pembiayaan*</span></label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-money"></i></span>
                            <select class="form-control m-bot15" id="fjenpay" name="fjenpay">
                                <option  value="" selected="selected" >--Pilih / Choose--</option>
								<option value="Cash"  >Cash</option>
                                <option value="Pembiayaan"  >Pembiayaan</option>
                                <option value="Saldo Bonus"  >Saldo Bonus</option>
                            </select>
                           </div>
                          </div>


							
                          
                          

                            
  



                             

                            

<div style="" class=" divtr col-lg-6">

							<label for="tfSernoPresName">Setoran Awal* </label>

										<div class="input-group" id="groupStor">

                                      <span class="input-group-addon"> <i class="fa fa-money"></i></span>                                    

                                      <input type="text" class="form-control" id="fstorawal" name="fstorawal" placeholder="0" value="0"  dir="rtl" onBlur="calcSA(this)" onKeyUp="//if (!isNaN(this.value) && this.value !='') calcPay();"  >

                                   

                                    </div>                            

                            

                            </div>  



                            <div style="" class=" divtr col-lg-6">

							<label for="exampleInputEmail1"><div align="left" style="display:inline; float:left" id="statKitUp"></div> Angsuran 1* <input name="cboxVoucher" id="cboxVoucher" type="checkbox" value="1" class="hide"></label>

                                    <div class="input-group">

                                      <span class="input-group-addon"> <i class="fa fa-money"></i></span>

                                    <input type="text" class="form-control" id="fangsur1" name="fangsur1" placeholder="0" value="0"  onBlur="" dir="rtl" onKeyUp="if (!isNaN(this.value) && this.value !='') calcPay();"   >

                                    

 

                                    </div>                            

                            

                            </div>   

                            

<div style="" class=" divtr col-lg-6">

							<label for="tfSernoSponName">Angsuran 2 </label>

										<div class="input-group">

                                      <span class="input-group-addon"> <i class="fa fa-money"></i></span>                                    

                                      <input type="text" class="form-control" id="fangsur2" name="fangsur2" placeholder="0" value="0"  dir="rtl"  onKeyUp="if (!isNaN(this.value) && this.value !='') calcPay();" >

                                   

                                    </div>                            

                            

                            </div>                            

 
<div style="" class=" divtr col-lg-6">

							<label for="tfSernoSponName">Angsuran 3 </label>

										<div class="input-group">

                                      <span class="input-group-addon"> <i class="fa fa-money"></i></span>                                    

                                      <input type="text" class="form-control" id="fangsur3" name="fangsur3" placeholder="0" value="0"  dir="rtl"  onKeyUp="if (!isNaN(this.value) && this.value !='') calcPay();" >

                                   

                                    </div>                            

                            

                            </div>
                            

<div style="" class=" divtr col-lg-6">

							<label for="tfSernoSponName">Angsuran 4 </label>

										<div class="input-group">

                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>                                    

                                      <input type="text" class="form-control" id="fangsur4" name="fangsur4" placeholder="0" value="0"  dir="rtl"  onKeyUp="if (!isNaN(this.value) && this.value !='') calcPay();" >

                                   

                                    </div>                            

                            

                            </div>

                               



<div style="" class=" divtr col-lg-6">

							<label for="tfSernoSponName">Pelunasan </label>

										<div class="input-group">

                                      <span class="input-group-addon"> <i class="fa fa-money"></i></span>                                    

                                      <input type="text" class="form-control" id="flunas" name="flunas" placeholder="0" value="0"  dir="rtl"  onKeyUp="if (!isNaN(this.value) && this.value !='') calcPay();" >

                                   

                                    </div>                            

                            

                            </div>

    <div style="" class=" divtr col-lg-6">

							<label for="tfSernoSponName">Total Pembayaran </label>

										<div class="input-group">

                                      <span class="input-group-addon"> <i class="fa fa-money"></i></span>                                    

                                      <input type="text" class="form-control" id="ftotalbayar" name="ftotalbayar" placeholder="0" value="0"  dir="rtl" readonly  >

                                   

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

                            

                          

    

                             </div>

                               

                            <div class="form-group">

                                

                               

                                                                

                                    <div class="form-group">        

                                  

                                  </div>

                                

                            </div>

                            <div class="form-group" >                      

                               

                                                                

                                  

                                

                       </div>

 

    					 <!--<div class="divtr" >

                                <label for="exampleInputEmail1"><div class="divtr"></div>Alamat Email</label>

                                 <div class="iconic-input">

                                    <i class="fa fa-envelope"></i>

                                <input type="email" class="form-control" id="tfEmail" name="tfEmail" placeholder="Email Address">

                                </div>

                            </div> -->

                               								

                                                            

<!--

							                               <div class="col-lg-2 col-md-2 col-sm-4 divtr" style="display:none" >

							                                <label for="exampleInputEmail1" ><span style="font-weight:bold">&nbsp;</span></label>

							                                <input type="radio" class="form-control" id="UFC" name="rbPaket" value="F;<?=$vHrgFirst?>" > 

															   First Class</div> -->

							                              



                     </div> <!--Panel Body-->
					

					<div class="panel-heading hide" >

                             <div class="panel-title" style="margin-top:0px">

        						 <label for="exampleInputEmail1" style="font-weight:bold;">

								 Data Calon Pebisnis</label>
       						   <br style="display: block;margin: -5px 0;" />                                    

                     		</div>

              </div>

                     <div class="panel-body hide" style="color:black">
<div class="divtr col-lg-12" >
                                <label   for="tfNama">
								Nama Lengkap Calon Pebisnis*</label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" id="fnamabuss" name="fnamabuss" placeholder="(Tanpa tanda koma)*" onBlur="this.value=this.value.replace(/,/g,'');" onKeyUp="this.value=this.value.replace(/,/g,'');">
                                </div>
</div>		





<div class="divtr col-lg-6" >
                                <label   for="tfNama">
								Nomor HP Calon Pebisnis*</label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-mobile"></i></span>
                                <input type="text" class="form-control" id="fnohpbuss" name="fnohpbuss" placeholder="" onBlur="this.value=this.value.replace(/,/g,'');" onKeyUp="this.value=this.value.replace(/,/g,'');">
                                </div>
</div>		


<div class="divtr col-lg-6" >
                                <label   for="tfNama">
								Ahli Waris*</label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" id="fwarisbuss" name="fwarisbuss" placeholder="" onBlur="" onKeyUp="">
                                </div>
</div>




<div class="col-md-5 col-lg-12 divtr hide" id="divProgDet" >
                                      <label for="exampleInputEmail1">
									  <span style="font-weight:bold">&nbsp;Program Detail*</span></label>
                                    <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-list"></i></span>
                            <select class="form-control m-bot15" id="fprogramdet" name="fprogramdet" onChange="changeProg(this);">
                            <option  value="-" selected="selected" >--Pilih / Choose--</option>
                                <?
                                    $vSQL="select * from tmpaket ";
									$oDBAMHT->query($vSQL);
									while($oDBAMHT->next_record()){
								?>
                                <option value="<?=$oDBAMHT->f('kode');?>"  ><?=$oDBAMHT->f('nama');?></option>
                                <? } ?>
								
                               

                            </select>
                           </div>
                          </div>	 
					 </div>
					 
					 
				
					

            </div> <!-- panel -->
                
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


                                         <div style="color:red">SEGALA BENTUK DANA YANG MASUK, TIDAK DAPAT DITARIK KEMBALI DENGAN CARA APAPUN dan  SETUJU dengan  SYARAT & KETENTUAN yang berlaku</div>
										<input id="cbTC" name="cbTC" type="checkbox"  ><a style="cursor:pointer;color:blue;text-decoration:underline" href="#" onClick="openTerm()">&nbsp;Data tersebut diatas adalah benar</a><br><br>

										<input type="hidden" name="hKit" id="hKit" value="<?=$vKit?>" />

										<input type="hidden" name="hTotal" id="hTotal" value="" />

                                        <button id="btnSubmit" type="submit" class="btn btn-primary"  onClick="submitForm(this)">Submit</button> <div id="divLoad" style="display:inline">
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
