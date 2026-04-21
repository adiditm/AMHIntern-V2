<?php 
  
  $vOp=$_GET['op'];
  if ($vOp=='getprod') {
	  session_start();
	  $vJenis = $_GET['jen'];
	  include_once("../server/config.php");
	  include_once("../classes/antaclass.php");
	  include_once("../classes/ruleconfigclass.php");
  	  
	   $vURLGetListPasca = $oRules->getSettingByField('fantagetlistpasca');
	   $vURLJenis = $vURLGetListPasca."?type=$vJenis";
  	   $vListPasca =$oAnta->sendGet($vURLJenis);
       $vArrProd  = json_decode($vListPasca,true);
	   
	   $vTgl = date('Y-m-d');
	   $vUser = $_SESSION['LoginUser'];
       $vNextID=$oMember->getNextTrxIDCekList($vTgl);
	   
	   $vSQL = "INSERT INTO  tb_cekppob(fidtrx, fidmember, fcommand, fmsisdn, fserverresponse, fxmlsent, flastuser, fsaldoamh, ftglentry) ";
			   $vSQL .= "VALUE ('$vNextID', '$vUser', '$vJenis', '', '$vListPasca', '$vURLJenis', '$vUser',0, now());";   
			   $db->query($vSQL);	  
	  
	   $vCount=0;  
	   // print_r($vArrProd);
	   $vCountProd = count($vArrProd['results']['data']['data']);
	   $vOptions ='<option selected="selected" value="" class="form-control">--Pilih--</option>';
	   if ($vCountProd >0 ) {
		   foreach($vArrProd['results']['data']['data'] as $val){
			 
			
			 $vData = $val;
		//	print_r($vData);
			 $vCode = $vData['code'];
			 $vName =  $vData['name'];  
			 $vImg =  $vData['image_url'];
			 $vType =  $vData['type']; 
			 $vOptions .= '<option typex="'.$vType.'" value="'.$vCode.'">'.$vName.'</option>';	 
			 $vCount++;	
		   }
	  
  
	   }
	   echo  $vOptions;
     exit;
  }
  
 
 
   if ($vOp=='inqu') {
	   session_start();
	  $vType=$_POST['typex'];
	  $vCode = $_POST['code'];
	  $vCustId = $_POST['customer_id'];
	  

	  include_once("../server/config.php");
	  include_once("../classes/antaclass.php");
	  include_once("../classes/memberclass.php");
	  include_once("../classes/ruleconfigclass.php");
	  $vUserAnta =$oRules->getSettingByField('fantauser');
  	  $vPassAnta = $oRules->getSettingByField('fantapass');  	  
	  $vURLInquPasca = $oRules->getSettingByField('fantainqupasca');
	  $vURLCekBal = $oRules->getSettingByField('fantacekbal'); 

	  $vURLCekBal = $oRules->getSettingByField('fantacekbal');
	  $vData = array('username'=>$vUserAnta,'password'=>$vPassAnta);
	  $vResultBal=$oAnta->sendPost($vURLCekBal,$vData);
	  $vObjBal = json_decode($vResultBal,true);
	  $vBal = $vObjBal['results']['data'];
  	   
	   $vData['username'] = $vUserAnta;
	   $vData['password'] = $vPassAnta;
	   
	  
	   $vData['code']=$vCode;
	   if ($vType =='pln')
	      $vData['type']='electricity';
	   else  $vData['type']=$vType;	  
	      
	   $vData['customer_id']=$vCustId;
	   
	    $vDataX = http_build_query($vData);
	   //echo $vURLInquPasca;
	   
	    echo  $vResInqu = $oAnta->sendPost($vURLInquPasca,$vData);
  	   
	   $vTgl = date('Y-m-d');
	   $vUser = $_SESSION['LoginUser'];
       $vNextID=$oMember->getNextTrxIDCek($vTgl);
	   
	   $vSQL = "INSERT INTO  tb_cekppob(fidtrx, fidmember, fcommand, fmsisdn, fserverresponse, fxmlsent, flastuser, fsaldoamh, ftglentry) ";
			   $vSQL .= "VALUE ('$vNextID', '$vUser', '$vType:$vCode', '$vCustId', '$vResInqu', '$vDataX', '$vUser',$vBal, now());";   
			   $db->query($vSQL);	  

	   // print_r($vArrProd);
	 
     exit;
  }


   if ($vOp=='process') {
	   session_start();
	   $vArrOut=array();
	  $vType=$_POST['typex'];
	  $vInqu = $_POST['inqu'];
	  $vJen = $_POST['jen'];
	  $vProd = $_POST['prod'];
	  
	  

	  include_once("../server/config.php");
	  include_once("../classes/antaclass.php");
	  include_once("../classes/memberclass.php");
	  include_once("../classes/ruleconfigclass.php");
	  
	  $vUserAnta =$oRules->getSettingByField('fantauser');
  	  $vPassAnta = $oRules->getSettingByField('fantapass');  	  
	   $vURLPayPasca = $oRules->getSettingByField('fantapaypasca');


	  $vURLCekBal = $oRules->getSettingByField('fantacekbal');
	  $vData = array('username'=>$vUserAnta,'password'=>$vPassAnta);
	   $vResultBal=$oAnta->sendPost($vURLCekBal,$vData);
	  $vObjBal = json_decode($vResultBal,true);
	  $vBalAmh = $vObjBal['results']['data'];
	   
	   $vData['username'] = $vUserAnta;
	   $vData['password'] = $vPassAnta;
	   $vData['type']=$vType;
	   $vData['inquiry_id']=$vInqu;
	   
	   
	   
	     $vDataX = http_build_query($vData);
		$vXMLSent = $vData['type'].":".$vData['inquiry_id'];
		
		
	   $vTgl = date('Y-m-d');
	   $vUser = $_SESSION['LoginUser'];
	   $vMsisdn=$_POST['tfMsis'];
	   $vMinBal=$oRules->getSettingByField('fmindap');
	   $vHargaPost = $_POST['tagih'];
	   $vHargaAsliPost = $_POST['tagihori'];
	   if (trim($vUser) !='') {
		  // echo $vDataX;
	   
	      $vServerResponse = $oAnta->genPost($vURLPayPasca,$vDataX,'');
		// $vServerResponse = '{"results":{"data":{"supplier":"df","request_id":"AUPSCyPvOT9C0","inquiry_id":"pasca614d770d6a4743.33500069","customer_id":"08123110039","type":"hp","product_name":"2"},"message":"Transaksi Sukses, Cek notifikasi untuk informasi lebih detail.","error":""}}';
		      $vDataResult = json_decode($vServerResponse);

	 		if (count($vDataResult->results->data) >0 || trim($vDataResult->results->error) =='') {
			
				  $vNextID=$oMember->getNextTrxIDPO($vTgl);
				 

				  $vLastBal=$oMember->getMemFieldBis('fsaldovcr',$vUser);
				  if (($vLastBal - $vMinBal) < $vHargaPost) {
					  $vArrOut['status'] = 'failed';
					  $vArrOut['data'] = null;
					  $vArrOut['message'] = 'Error! Saldo aktif Anda sebesar '.number_format(($vLastBal - $vMinBal),0,",",".").' tidak cukup untuk transaksi tagihan sebesar '.number_format($vHargaPost,0,",",".");
					  
					 echo  json_encode($vArrOut);
					  exit;
					  
				  }

//Temporary
				  $vSQL="INSERT INTO tb_trxpulsa_temp  (fidtrx,fidmember,fkdproduk,fnominal,fhrgsumber,fhrgamh,fmsisdn,fserverresponse,fxmlsent,fket,flastuser,fstatustrx,fstatusrow,fsaldoamh,ftglupdate,ftglentry,fprovider) ";
				  $vSQL.="VALUE('$vNextID','$vUser','$vType','$vProd',$vHargaAsliPost,$vHargaPost,'$vMsisdn','$vServerResponse','$vXMLSent','Transaksi PPOB $vJen:$vProd ke $vMsisdn','$vUser','0','1',$vBalAmh,now(),now(),'ANTA');";   
				   $db->query($vSQL);	


			      $vSQL="INSERT INTO tb_trxpulsa (fidtrx,fidmember,fkdproduk,fnominal,fhrgsumber,fhrgamh,fmsisdn,fserverresponse,fxmlsent,fket,flastuser,fstatustrx,fstatusrow,fsaldoamh,ftglupdate,ftglentry,fprovider) ";
				  $vSQL.="VALUE('$vNextID','$vUser','$vType','$vProd',$vHargaAsliPost,$vHargaPost,'$vMsisdn','$vServerResponse','$vXMLSent','Transaksi PPOB $vJen:$vProd ke $vMsisdn','$vUser','1','1',$vBalAmh,now(),now(),'ANTA');";   
				  $db->query($vSQL);	
				  $vDesc="Transaksi pulsa $vOperator $vNextID - $vKdProd ke nomor ($vMsisdn)";
				  $vLastBal=$oMember->getMemFieldBis(fsaldovcr,$vUser);
				  $vBal=$vLastBal-$vHargaPost;
				  $oKomisi->insertMutasi($vUser,$vUser,date("Y-m-d H:i:s"),$vDesc,0,$vHargaPost,$vBal,'trxppob',$vNextID) ;
				  $oMember->updateBalBis($vUser,$vBal);

				 $vArrOut['message'] = 'Transaksi PPOB ke rekening / nomor '.$vMsisdn.' Sukses! ';
				 $vArrOut['status'] = 'succeed';
				 $vArrOut['data'] = array("newbal"=>$vBal);
				 echo  json_encode($vArrOut);

			exit;	
			} else {
				 $vArrOut = array();
				 $vArrOut['message'] = 'Transaksi PPOB ke rekening / nomor '.$vMsisdn.' Gagal!. '.$vDataResult->results->message;
				 $vArrOut['status'] = 'failed';
				 $vArrOut['data'] = null;	
				  echo  json_encode($vArrOut);
			}
	   }
  	   
      
	  

	   // print_r($vArrProd);
	 
     exit;
  }
  
  include_once("../framework/admin_headside.blade.php");
  include_once("../classes/systemclass.php");
  include_once("../classes/ruleconfigclass.php");
  include_once("../classes/networkclass.php");
  include_once("../classes/antaclass.php");
  include_once("../classes/memberclass.php");
    include_once("../classes/pulsaclass.php");
  $vUserAnta =$oRules->getSettingByField('fantauser');
  $vPassAnta = $oRules->getSettingByField('fantapass');
  $vURLGetListPulsa = $oRules->getSettingByField('fantagetlist');
  $vURLGetListPasca = $oRules->getSettingByField('fantagetlistpasca');
  $vURLGetInquPasca = $oRules->getSettingByField('fantainqupasca');
  $vURLGetPayPasca = $oRules->getSettingByField('fantapaypasca');
  $vURLCheck = $oRules->getSettingByField('fantacektrx');
  $vURLServer = $oRules->getSettingByField('fantadotrx');
  $vFeePPOB=$oRules->getSettingByField('fbyyppob');
  
  $vListPasca =$oAnta->sendGet($vURLGetListPasca);
  
  
  $vListPulsa =$oAnta->sendGet($vURLGetListPulsa);
  $vObjPulsa = json_decode($vListPulsa,true);
  
  
 
  $vUser=$_SESSION['LoginUser'];
  

  
	$vsTglAwal=$_POST['dc1'];
	if ($vsTglAwal=='') $vsTglAwal=date("Y-m-d");
	$vsTglAkhir=$_POST['dc2'];
	if ($vsTglAkhir=='') $vsTglAkhir=date("Y-m-d");


 ?>
<style type="text/css">
<!--
.style8 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 15px;
}
.style9 {
	font-size: 12px;
	font-weight: bold;
}
.style10 {font-size: 12px}
input,select,textarea,button {
	border:1px solid #999;
}

.tbltrx {
   	border-collapse:collapse;
}

.tbltrx td {
   border:1px solid #CCC;	
}

.bgload {
    background:no-repeat url("../images/ajax-loader.gif");
	background-position: center;
}
-->
</style>
<script language="javascript">

var xtime;
function getProd(pThis) {
	$('#tblResult').hide();
	$('#info').html('');
	if(pThis.value !='') {
	    var vURL='../memstock/ppob.php?op=getprod&jen='+pThis.value;
		$('#cbProd').addClass('bgload');
		$('#select2-cbProd-container').addClass('bgload');
		$.get(vURL,function(data){
			//$vObj = $.parseJSON(data);
			$('#cbProd').html(data);
			$('#cbProd').removeClass('bgload');
			$('#select2-cbProd-container').removeClass('bgload');
		});	
		
	}
}

function confirmOrder() {
 	var vLength=$('.cbProd').length;
	
	var vValue='';
	var vText='';
	var vMsis=$('#tfMsis').val();
	if (document.getElementById('tfMsis').value=='') {
	   alert('Anda belum memasukkan nomor tujuan!');	
	   document.getElementById('tfMsis').focus();
	   return false;
	}
	for (i=0;i<vLength;i++) {
		   vValue=$('#cbProd'+(i+1)).val();
		   //alert(vValue);
		   vText=$('#cbProd'+(i+1)).find("option:selected").text();
		   if (vValue!='') {
			   if(confirm('Yakin melakukan pembelian pulsa '+vText+' ke nomor tujuan '+vMsis+'?')==true) {
				  document.frmPPOB.submit(); 
				 return true;
			   } else return false;
		   }

	}
	
	if (vValue=='') {
	   alert('Anda belum memilih produk!');	
	   return false;
		
	}
  	
}

$(document).ready(function() {
	$('#cbJen').select2();
	$('#cbProd').select2();

if ('<?=$_POST[hList]?>' == '1') {

   window.location.hash='history';
}
 

 $("#tfMsis").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 86 && e.ctrlKey === true || e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

});


function numberThousand(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

function checkTagihan() {
	  var vNoRek=document.getElementById('tfMsis').value;
	  var vProd=document.getElementById('cbProd').value;
	  var vNoHP=document.getElementById('tfNoHP').value;
	  var vSucc=/inquiry_id/gi;
	  var vSuccTagihan=/"tagihan":/gi;
	  var vGagal = /Gagal/gi;
  	  var vSalahPLN = /tujuan salah/gi;
	  var vBelumTer = /Tagihan belum tersedia/gi;
	  var vProc = /checkproceed/gi;
	  var vFail = /checkfailed/gi;
	  var vLunas = /sudah dibayar/gi;
	  var vLunasPLN = /sudah terbayar/gi;
	  var vSalah = /Nomor tujuan salah/gi;
	  var vSalahSKU = /SKU tidak di temukan/gi;
	  var vSalahPLN = /yang anda masukkan salah/gi;
	  var vSalahProd = /message format tidak sesuai dengan spesifikasi/gi;
	  var vSaldo=document.getElementById('hSaldoG').value;
	  
	  
 		if (document.getElementById('tfMsis').value=='') {
	     alert('Isikan nomor rekening/telepon/HP tertagih!');
	     document.getElementById('tfMsis').focus();
	     return false;
	  }

	  if (document.getElementById('tfNoHP').value=='') {
	     alert('Isikan nomor HP pelanggan!');
	     document.getElementById('tfNoHP').focus();
	     return false;
	  }

	  if (document.getElementById('cbProd').value=='') {
	     alert('Pilih produk / jenis!');
	     document.getElementById('cbProd').focus();
	     return false;
	  }
	 
	  //alert(vProd);
	  $('#spload').html('<img src="../images/ajax-loader.gif" height="20" align="top">Checking...');
	  document.getElementById('kirim').disabled=true;
	  document.getElementById('kirim').style.color='#ccc';
	  $('#info').empty();
	  $('#infobyr').empty();
	  var URL="ppob.php?op=inqu";
	  var vType=$("#cbProd option:selected").attr('typex');
	  if (vType=='pln') vType='electricity';
	  var vCode =$('#cbProd').val();
	  var vCust  =$('#tfMsis').val();
	 // alert(vType);
	  $.post(URL, {typex:vType,code:vCode,customer_id:vCust},function(data) {
		  /*  if (vGagal.test(data)) {
			   alert('Check tagihan gagal, silakan coba lagi!');
			   return false;	
			}*/
			if (data !='') {
					
					var IS_JSON = true;
					try {
						  var vObj = $.parseJSON(data);
					} catch(err) {
						 IS_JSON = false;
					}                				
								
					
					if(!IS_JSON){
						 alert('Invalid API response!');
						 return false;			
					} else {
					//	console.log(vObj.results);


						if (vSucc.test(data) || vSuccTagihan.test(data)) { 
						//	alert(data);
							$('#spload').empty();
							$('#info').html('<span style="font-size:14px;color:blue"> Check tagihan sukses!</span>');
							$('#jmlTagihan').html(numberThousand(vObj.results.data.tagihan));
							$('#byyAdmin').html('<?=number_format($vFeePPOB,0,",",".")?>');
							var vTotal = parseFloat('<?=$vFeePPOB?>') + parseFloat(vObj.results.data.tagihan);
							$('#ttlTagihan').html(numberThousand(vTotal));
							$('#idCust').html($('#tfMsis').val());
							$('#namaCust').html(vObj.results.data.nama);
							$('#tblResult').show();
							
							 
							document.getElementById('hTagih').value=vTotal;
							document.getElementById('hTagihOri').value=vObj.results.data.tagihan;
						 	document.getElementById('hAdmin').value=<?=$vFeePPOB?>;
							document.getElementById('hInqu').value=vObj.results.data.inquiry_id;
							document.getElementById('hType').value=vType;
						  
							 
							if(vObj.results.data.inquiry_id !== undefined) {
								if (parseFloat(vSaldo) < parseFloat(vTotal)) {
								   alert('Check tagihan sukses, tetapi saldo Anda tidak cukup!');	 	
								} else document.getElementById('kirim').disabled=false;
							} else alert('Check tagihan sukses, tetapi Anda belum bisa melakukan pembayaran!');	
							//setTimeout(doStuff, 10000, vData[0]);
							//alert(vData[1].trim());
						} else if (vGagal.test(data)) { 
							$('#info').html('<span style="font-size:14px;color:red">Check tagihan gagal, silakan coba lagi!</span>');
							//document.getElementById('kirim').disabled=false;
							//document.getElementById('kirim').style.color='#00f';
							$('#spload').empty();
			
						} else if (vSalah.test(data) || vSalahPLN.test(data) || vSalahSKU.test(data)) {  
							$('#info').html('<span style="font-size:14px;color:red">Check tagihan gagal! Nomor rekening pelanggan atau produk salah.</span>');
							$('#spload').empty();
						} else if (vLunas.test(data)) {  
							$('#info').html('<span style="font-size:14px;color:red">Check tagihan gagal! Tagihan sudah dibayar.</span>');
							$('#spload').empty();
						} else if (vLunasPLN.test(data)) {  
							$('#info').html('<span style="font-size:14px;color:red">Check tagihan gagal! Tagihan PLN sudah dibayar.</span>');
							$('#spload').empty();
						} else if (vFail.test(data)) {  
							$('#info').html('<span style="font-size:14px;color:red">Check tagihan gagal! Cek nomor rekening/HP dan Jenis/Produk, atau kemungkinan sudah lunas. Coba lagi</span>');
							$('#spload').empty();
						} else if (vBelumTer.test(data)) {  
							$('#info').html('<span style="font-size:14px;color:red">Check tagihan gagal! Tagihan belum tersedia!</span>');
							$('#spload').empty();
						}
							
							
							//$('#resInqu').html(data);
							
							
						}					
					//
					$('#spload').html('');
					
					

			}
			
			 
	  });	
	
}

function bayarTagihan() {
	  var vSaldo=document.getElementById('hSaldoG').value;
	  
	  $('#info').html('');
	  var vNoRek=document.getElementById('tfMsis').value;
	  var vProd=document.getElementById('cbProd').value;
	 // var vNoHP=document.getElementById('tfNoHP').value;
	  var vPOB=vProd.split('|');
	  var vSucc = /Transaksi Sukses/g;
	  var vError = /Error!/g;
	  var vFail = /Transaksi Gagal/g;
	  var vKurang=/Saldo Anda tidak cukup/g;
	  var vTagihan=document.getElementById('hTagih').value;
	  var vAdmin=document.getElementById('hAdmin').value;
	  //alert(vProd);
	  var flTagihanTot = parseFloat(vTagihan) + parseFloat(vAdmin);
	  var flNTA = flTagihanTot - parseFloat(<?=$vFeePPOB?>);
	  var vInquId = document.getElementById('hInqu').value;
	  var vType = document.getElementById('hType').value;
	  var vProd = document.getElementById('cbProd').value;
	  var vJen = document.getElementById('cbJen').value;
	  var vMSIS = document.getElementById('tfMsis').value;
	  var vTagihan = document.getElementById('hTagih').value;
	  var vTagihanOri = document.getElementById('hTagihOri').value;
	  var dataPost = {inqu:vInquId, typex: vType, prod: vProd, jen:vJen, tfMsis:vMSIS,tagih:vTagihan,tagihori:vTagihanOri };
	  if (vSaldo > flNTA) {
	  
		  if (confirm('INFO : Eksekusi pembayaran bersifat permanen dan tidak bisa dikembalikan. Anda yakin melakukan pembayaran?')==true) {
				  $('#infobyr').html('<img src="../images/ajax-loader.gif"  align="top">Tunggu, sedang melakukan pembayaran...');
				 
				  var URL="ppob.php?op=process";
				  document.getElementById('kirim').disabled=true;
						$.post(URL, dataPost,function(data) {
						var vData=$.parseJSON(data);
						//alert(data);
						if (vData.status=='succeed') { 
							alert(vData.message);
						    
							$('#spload').empty();
							
							$('#infobyr').html('<span style="font-size:14px;color:blue">Transaksi PPOB sukses!</span>');
							$('#hSaldoG').val(vData.data.newbal);
							$('#btnReset').trigger('click');
							
							//setTimeout(doStuff, 10000, vData[0]);
							//alert(vData[1].trim());
						} else {
							alert(vData.message);	
							$('#infobyr').html('');
							
						}
				  });	
		  
		  
		  }
	  } else alert('Saldo Anda  sebesar '+vSaldo+' tidak mencukupi untuk transaksi ini (NTA='+flNTA+')');
}

var formatThousands = function(n, dp){
  var s = ''+(Math.floor(n)), d = n % 1, i = s.length, r = '';
  while ( (i -= 3) > 0 ) { r = '.' + s.substr(i, 3) + r; }
  return s.substr(0, i + 3) + r + 
    (d ? '.' + Math.round(d * Math.pow(10, dp || 2)) : '');
};

var doStuff = function (pParam) {
   	  var URL="e2_checkppob_ajax.php?op=checkrev&idtrx="+pParam;
      var vDetTag='';
	  var vDetTagT='';
	  var vParam=pParam;
	  $.get(URL, function(data) {
			//alert(data);
			if (data !='notfound') {
		      vDetTag=data.split('|');
			  vDetTagT='<span style="color:blue;">Nomer Rekening Tertagih : '+vDetTag[1];
			  vDetTagT+='<br>Jumlah Tagihan : '+formatThousands(parseFloat(vDetTag[2])-parseFloat(vDetTag[3]));
			  vDetTagT+='<br>Biaya Admin : '+formatThousands(vDetTag[3]);
			  vDetTagT+='<br>Atas Nama : '+vDetTag[4];
			  vDetTagT+='<br>Total : '+formatThousands(parseFloat(vDetTag[2]));
			  vDetTagT+='</span>';
			  document.getElementById('hTagih').value=parseFloat(vDetTag[2])-parseFloat(vDetTag[3]);
			  document.getElementById('hAdmin').value=vDetTag[3];
			  
			  $('#info').html(vDetTagT);
			  clearTimeout(xtime);
			  document.getElementById('kirim').disabled=false;
			  document.getElementById('kirim').style.color='#00f';
			}
	  });	
};

function resetForm() {
	  document.getElementById('kirim').disabled=true;
	  document.getElementById('kirim').style.color='#69f';
	  $('#info').empty();
	  $('#infobyr').empty();
	  document.frmPPOB.reset();
}

function theClear() {
	clearTimeout(xtime);
}

function doPrint(pNo) {
  	window.open('printppob.php?trx='+pNo,'wPPOB','width=650,height=350');
}
</script>
<div class="right_col" role="main" style="min-height:1px !important">

<div><label> <h3>Transaksi PPOB </h3></label></div> 


    <?  if ($_GET['op']!='spy') {?>
     

         
            <form name="frmPPOB" id="frmPPOB" method="post" action="" onsubmit="return saveTopup()">
              <table width="100%" border="0" align="left" cellpadding="5" cellspacing="0" style="border:none " class="table">
                <tr>
                  <td width="232" style="width: 5px">ID</td>
                  <td colspan="2"><div align="left">
                    <input name="ID" type="text" id="ID" value="<?=$vUser?>" size="15"  class="form-control" readonly="readonly" />
                    <input type="hidden" name="hPost" id="fPost" value="1" />
                  </div></td>
                </tr>
                <tr>
                  <td style="width: 5px">Nomor Rekening/Meter</td>
                  <td colspan="2"><input style="font-size:14px;font-weight:bold" name="tfMsis" type="text" id="tfMsis"  size="20"  onchange="$('#info').html('')" onkeyup="$('#info').html('');"   onblur="this.value=this.value.trim();" class="form-control"  /><span id="spLoadProd"></span></td>
                </tr>
                <tr class="hide">
                  <td style="width: 5px">Nomor HP Pelanggan</td>
                  <td colspan="2"><input style="font-size:14px;font-weight:bold" name="tfNoHP" type="text" id="tfNoHP"  size="30" value="-"   class="form-control" onblur="this.value=this.value.trim()"  /></td>
                </tr>

                <tr style="display:">
                  <td valign="top" style="width: 5px" onclick="theClear()">Jenis<br /><br />
                    Produk</td>
                  <td colspan="2" style="width: 207px"><div class="col-lg-5">
                  <select   name="cJen" id="cbJen" class="form-control" style="margin-left:-10px" onchange="getProd(this)">
                  <option  value="" class="form-control">--Pilih--</option>
                  <option value="electricity" class="form-control">Kelistrikan / PLN</option>
                  <option  value="bpjs" class="form-control">BPJS</option>
                  <option  value="internet" class="form-control">Internet</option>
                  <option value="tv" class="form-control">TV</option>
                  <option value="finance" class="form-control">Finance</option>
                  <option  value="pdam" class="form-control">PDAM</option>
                  <option  value="hp" class="form-control">Handphone</option>
                  <option  value="pbb" class="form-control">Pajak PBB</option>
                  <option  value="gas" class="form-control">Gas</option>
                      
                   
                   
                      </option>
                    
                  </select> 
                  
                
<select   name="cbProd" id="cbProd" class="form-control" style="margin-left:-10px">
                    <option selected="selected" value="" class="form-control">--Pilih--</option>
                    <?
                         $vSQL="select * from m_postpaid where faktif='1' ";
						 $db->query($vSQL);
						 while ($db->next_record()) {
							 $vValueCek=$db->f('fcmdcek');
							 $vValueByr=$db->f('fcmdbyr');
							 $vName=$db->f('fprodname');
							 
							 
							 $vLabel=$vName;
					  ?>
                    <option value="<?="$vValueCek|$vValueByr|$vName"?>">
                      <?=$vLabel?>
              </option>
                    <? } ?>
                  </select> 
                                    
                  </div><br />  <br />
                  <input type="button" name="btnCheck" id="btnCheck" value="Check Tagihan" onclick="checkTagihan();" class="btn btn-info btn-sm" /><span id="spload"></span></td>
                </tr>
                <tr style="display:">
                  <td valign="top" style="width: 5px" onclick="theClear()">&nbsp;</td>
                  <td colspan="2" style="width: 207px" id="resInqu">
                  
 <table width="45%"  id="tblResult" class="table table-bordered" style="display:none;padding:5px" border="1" cellpadding="5" >
  <tr>
    <td width="24%" nowrap="nowrap">Nomor / ID Customer</td>
    <td width="76%" id="idCust">&nbsp;</td>
  </tr>
  <tr>
    <td >Nama</td>
    <td id="namaCust">&nbsp;</td>
  </tr>
  <tr>
    <td >Jml. Tagihan</td>
    <td id="jmlTagihan">&nbsp;</td>
  </tr>
  <tr>
    <td>Biaya Admin</td>
    <td id="byyAdmin">&nbsp;</td>
  </tr>
  <tr>
    <td>Total Tagihan</td>
    <td id="ttlTagihan">&nbsp;</td>
  </tr>
</table>

                  
                  </td>
                </tr>
                <? if (trim($oInterface->getMenuContent("topup",true)) != '') { ?>
                <? } ?>
                
                <tr> 
                  <td height="37" nowrap="nowrap"> 
                    <input type="button" name="kirim" id="kirim" value="Bayar Tagihan" onclick="bayarTagihan()" disabled="disabled" class="btn btn-success"> 
                    <input type="button" name="btnReset" id="btnReset" onclick="resetForm()" value="Bersihkan" class="btn btn-default"> 
                  </td>
                  <td width="368" height="37"><div align="left" id="info">&nbsp;</div></td>
                  <td width="338"><div align="left" id="infobyr">&nbsp;</div>
                  <input name="hTagih" id="hTagih" type="hidden" value="" />
                  <input name="hTagihOri" id="hTagihOri" type="hidden" value="" />
                  <input name="hAdmin" id="hAdmin" type="hidden" value="" />
                  <input name="hInqu" id="hInqu" type="hidden" value="" />
                  <input name="hType" id="hType" type="hidden" value="" />
                  </td>
                </tr>
              </table>
    </form>
          <p>&nbsp;</p></td>
        </tr>
        <tr>
          <td  height="25" align="left" valign="top"></td>
        </tr>
    </table>	 
	<? } ?>   </td>
  </tr>
  <tr valign="top">
    <td align="center" valign="top"><form style="font-family:Tahoma" action="" method="post" name="frListJual" id="frListJual">
      <p align="center"><span class="style1"><span class="style22 style8">History Transaksi<span class="style8">
          [<?=$vUser." / ".$oMember->getMemberName($vUser);?>]<a name="history"></a>
                </span></span></span><br />
                <br />
     <div class="col-lg-1"> <span class="style10"><strong>Mulai :</strong></span></div>
                    <div class="col-lg-2"><input  name="dc1"  id="dc1" value="<?=$vsTglAwal?>" size="9" class="form-control" /></div>
                     <div class="col-lg-1"><span class="style9">s/d</span></div>
         <div class="col-lg-2"><input  name="dc2" class="form-control" id="dc2" value="<?=$vsTglAkhir?>" size="9"  /></div>
        &nbsp;
        <input type="submit" name="button" id="button" value="Refresh List" class="btn btn-success" /><input type="hidden" id="hList" name="hList" value="1" /><br />
<div align="left" style="color:#f00;font-weight:bold">Untuk mengetahui status transaksi terkini, klik tombol [Refresh List]!</div>
      <table width="100%%" border="0" align="center" cellpadding="0" cellspacing="0" class="table table-bordered table-stripped">
            <!-- <tr style="display:none">
                <td height="26"></td>
                <td><div align="center">
                    <input name="tfsnojual" type="text" class="inputborder" id="tfsnojual" value="<?=$vsNoJual?>" size="10" />
                </div></td>
                <td colspan="2" ><div align="left">
                    <input type="submit" name="Submit2" value="Cari" />
                    <input name="cbIgnore" type="checkbox" id="cbIgnore" value="yes" <? if ($vsIgnore=="yes") echo "checked";?>>
                    <span class="style2 style11">Abaikan Tanggal </span> </div></td>
              </tr> -->
      <tr <? if ($vProcessed==2) echo "bgcolor='#CCCCCC'" ?> >
        <td width="3%"><div align="center" class="style9">No.</div></td>
                <td width="15%" height="26"><div align="center" class="style9">Tanggal</div></td>
                <td width="20%"><div align="center" class="style9">No Transaksi </div></td>
                <td width="10%"><div align="center" class="style9"> Transaksi </div></td>
                <td width="10%"><div align="center" class="style10"><strong>Jml Tagihan</strong></div></td>
                <td width="10%"><div align="center" class="style10"><strong>Status</strong></div></td>
                <td width="27%"><div align="center">
                  <div align="center" class="style10"><strong>Keterangan</strong></div>
                </div></td>
                <td width="5%" style="display:none"><div align="center">&radic;</div></td>
          </tr>
              <?
		  $vsql="select * from tb_trxpulsa where 1 and fket like 'Transaksi PPOB%' and fidmember='$vUser' and (date(ftglentry) between  date('$vsTglAwal') and date('$vsTglAkhir'))";
		  $vsql.=$vCrit;
		  $vsql.="   order by fidtrx ";

		  $db->query($vsql);
		  
		  $vNo=0; 
		  while ($db->next_record()) {
			  $vNo+=1;
			 $vTanggal=$oPhpdate->YMDT2DMYT($db->f('ftglentry'));
			 $vIDTrx=$db->f('fidtrx');
			 $vKdProd=$db->f('fkdproduk');
			// $vNomList=number_format($db->f('fnominal'),0,",",".");
			 $vHargList=number_format($db->f('fhrgamh'),0,",",".");
			 $vKet=$db->f('fket');
			 $vStatDB=$db->f('fstatustrx');
			 $vSNDB=$db->f('fsn');
			 $vVNDB=$db->f('fvn');
			 if ($vStatDB=='1') {
			     $vStatText='Berhasil';
				 if ($vSNDB !='' || $vVNDB !='')
				    $vStatText.=", SN/Token: $vSNDB, VN: $vVNDB";
			 } else if ($vStatDB=='1')
			     $vStatText='Diproses';
			 else if ($vStatDB=='11' || $vStatDB=='4')
			     $vStatText='Gagal';

		?>
              <tr  <? if ($vStatDB=='0') echo "style='background-color:#66CC66'"; else if ($vStatDB=='11' || $vStatDB=='4') echo "style='background-color:#f00'"?>    >
                <td><div align="right">
<?=$vNo?>
</div></td>
                <td><?=$vTanggal?></td>
                <td ><?=$vIDTrx?></td>
                <td ><?=$vKdProd?></td>
                <td><div align="right">
<?=$vHargList?>
</div></td>
                <td><?=$vStatText?></td>
                <td><?
				  //echo $vKet;
				  //echo "<br><br>";
				 
				  
				  $vKet2=str_replace("Tagihan","",$vKet2);
				  echo $vKetAll="$vKet";
				  ?></td>
                <td><div align="center" style="display:none"><input name="" type="button" value="Print" onclick="doPrint('<?=$vIDTrx?>')" <? if ($vStatDB !='0') echo 'disabledxx'; ?> /></div></td>
              </tr>
              <? 
     
	 } // while $db->next_record //if $vCrit
  ?>
              <tr style="display:none">
                <td colspan="4"><span class="style10"><strong>Total</strong></span></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td style="display:none">&nbsp;</td>
              </tr>
        </table>
    </form>
</div>
<? include_once("../framework/outer_footside.blade.php") ; ?>
