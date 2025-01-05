<?php 
  include_once("../framework/admin_headside.blade.php");
  include_once("../classes/systemclass.php");
  include_once("../classes/ruleconfigclass.php");
  include_once("../classes/networkclass.php");
  include_once("../classes/antaclass.php");
  include_once("../classes/memberclass.php");
    include_once("../classes/pulsaclass.php");
  $vUserAnta =$oRules->getSettingByField('fantauser');
  $vPassAnta = $oRules->getSettingByField('fantapass');
   $vURLGetListPra = $oRules->getSettingByField('fantagetlist');
  $vURLCheck = $oRules->getSettingByField('fantacektrx');
  $vURLServer = $oRules->getSettingByField('fantadotrx');
  
   $vURLGetListPulsa = $vURLGetListPra."?type=pulsa";
   $vListPulsa =$oAnta->sendGet($vURLGetListPulsa);
  $vObjPulsa = json_decode($vListPulsa,true);
  //print_r($vObjPulsa['results']['data']);
  $vSQL ="truncate table m_voucherhp;";
  $db->query($vSQL);
  foreach($vObjPulsa['results']['data'] as $vProductPulsa){
	  $vBrand = $vProductPulsa['namaproduk'];
	  $vJenis = $vProductPulsa['jenis_produk'];
	  $vKet = $vProductPulsa['keterangan'];
	  $vKode = $vProductPulsa['kode'];
	  $vHarga = $vProductPulsa['harga'];
	  $vSQL = "INSERT INTO m_voucherhp(Brand, Jenis, Keterangan, Kode, Harga, Status)VALUES ( '$vBrand', '$vJenis',  '$vKet','$vKode' , $vHarga,'OK');";
	   $db->query($vSQL);
	 // echo "$vSQL <br>";
  }
    $vURLGetListData = $vURLGetListPra."?type=data";
   $vListPulsa =$oAnta->sendGet($vURLGetListData);
  $vObjPulsa = json_decode($vListPulsa,true); 
  
    foreach($vObjPulsa['results']['data'] as $vProductPulsa){
	  $vBrand = $vProductPulsa['namaproduk'];
	  $vJenis = $vProductPulsa['jenis_produk'];
	  $vKet = $vProductPulsa['keterangan'];
	  $vKode = $vProductPulsa['kode'];
	  $vHarga = $vProductPulsa['harga'];
	  $vSQL = "INSERT INTO m_voucherhp(Brand, Jenis, Keterangan, Kode, Harga, Status)VALUES ( '$vBrand', '$vJenis',  '$vKet','$vKode' , $vHarga,'OK');";
	   $db->query($vSQL);
	 // echo "$vSQL <br>";
  }

  $vURLGetListToken= $vURLGetListPra."?type=token";
  $vListPulsa =$oAnta->sendGet($vURLGetListToken);
  $vObjPulsa = json_decode($vListPulsa,true); 
  
    foreach($vObjPulsa['results']['data'] as $vProductPulsa){
	  $vBrand = $vProductPulsa['namaproduk'];
	  $vJenis = $vProductPulsa['jenis_produk'];
	  $vKet = $vProductPulsa['keterangan'];
	  $vKode = $vProductPulsa['kode'];
	  $vHarga = $vProductPulsa['harga'];
	  $vSQL = "INSERT INTO m_voucherhp(Brand, Jenis, Keterangan, Kode, Harga, Status)VALUES ( '$vBrand', '$vJenis',  '$vKet','$vKode' , $vHarga,'OK');";
	   $db->query($vSQL);
	 // echo "$vSQL <br>";
  }

  $vURLGetListGame= $vURLGetListPra."?type=game";
  $vListPulsa =$oAnta->sendGet($vURLGetListGame);
  $vObjPulsa = json_decode($vListPulsa,true); 
  
    foreach($vObjPulsa['results']['data'] as $vProductPulsa){
	  $vBrand = $vProductPulsa['namaproduk'];
	  $vJenis = $vProductPulsa['jenis_produk'];
	  $vKet = $vProductPulsa['keterangan'];
	  $vKode = $vProductPulsa['kode'];
	  $vHarga = $vProductPulsa['harga'];
	  $vSQL = "INSERT INTO m_voucherhp(Brand, Jenis, Keterangan, Kode, Harga, Status)VALUES ( '$vBrand', '$vJenis',  '$vKet','$vKode' , $vHarga,'OK');";
	   $db->query($vSQL);
	 // echo "$vSQL <br>";
  }

  $vURLGetListEmoney = $vURLGetListPra."?type=emoney";
  $vListPulsa =$oAnta->sendGet($vURLGetListEmoney);
  $vObjPulsa = json_decode($vListPulsa,true); 
  
    foreach($vObjPulsa['results']['data'] as $vProductPulsa){
	  $vBrand = $vProductPulsa['namaproduk'];
	  $vJenis = $vProductPulsa['jenis_produk'];
	  $vKet = $vProductPulsa['keterangan'];
	  $vKode = $vProductPulsa['kode'];
	  $vHarga = $vProductPulsa['harga'];
	  $vSQL = "INSERT INTO m_voucherhp(Brand, Jenis, Keterangan, Kode, Harga, Status)VALUES ( '$vBrand', '$vJenis',  '$vKet','$vKode' , $vHarga,'OK');";
	   $db->query($vSQL);
	 // echo "$vSQL <br>";
  }

  
  
  // exit;
  //INSERT INTO amhtechn_intern.m_voucherhp(Brand, Jenis, Nom, Kode, Harga, Status)VALUES ( '', '', , '', , '');
  $vMailFrom=$oRules->getSettingByField('fmailadmin');
  $vMindap=$oRules->getSettingByField('fmindap');

 // $_SESSION['Ref']='';

  if ($_SESSION['Ref'] == '' )     

   $vRead=''; 

  else  

   $vRead='readonly';

   $vRead=''; 

     

  $vOngkir=$oRules->getSettingByField('fongkir');  

 // echo $_SESSION['Ref']."ssssssssss";


 
    $vFeePulsa=$oRules->getSettingByField("fcountflush");
	$vFeePublic=$oRules->getSettingByField("fhrgpaket");
	$vMinBal=$vMindap;

	
	$vsTglAwal=$_POST['dc1'];
	if ($vsTglAwal=='') $vsTglAwal=date("Y-m-d");
	$vsTglAkhir=$_POST['dc2'];
	if ($vsTglAkhir=='') $vsTglAkhir=date("Y-m-d");
	

    if ($_POST['hPost']=='1') {
	 //   $oSystem->jsLocation('../memstock/pulsa_at.php');
		//print_r($_POST);
		$vStatus='1';
		$vTgl = date('Y-m-d');
		while(list($key,$val)=each($_POST)) {
			
		   if (preg_match("/cbProd/",$key,$vMatches)) {
			   if ($val !='') {

				  $vValuePost=explode('|',$val);
				  $vKdProd=$vValuePost[0];
				  $vNomPost=$vValuePost[1];
				  $vHargaPost=$vValuePost[2];
				  $vHargaAsliPost=$vValuePost[3];
				  $vOperator=$vValuePost[4];
				  $vTypeProd=$vValuePost[5];
				  $vNextID=$oMember->getNextTrxID($vTgl);
				  $vMsisdn=$_POST['tfMsis'];

				  $vLastBal=$oMember->getMemFieldBis('fsaldovcr',$vUser);
				  if (($vLastBal - $vMinBal) < $vHargaPost) {
					  $oSystem->jsAlert('Error! Saldo aktif Anda sebesar '.number_format(($vLastBal - $vMinBal),0,",",".").' tidak cukup untuk transaksi pulsa seharga '.number_format($vHargaPost,0,",",".").'.');
					  $oSystem->jsLocation('../memstock/pulsa_at.php');
					  exit;
					  
				  }

//Temporary
				  $vSQL="INSERT INTO tb_trxpulsa_temp  (fidtrx,fidmember,fkdproduk,fnominal,fhrgsumber,fhrgamh,fmsisdn,fserverresponse,fxmlsent,fket,flastuser,fstatustrx,fstatusrow,fsaldoamh,ftglupdate,ftglentry,fprovider) ";
				  $vSQL.="VALUE('$vNextID','$vUser','$vKdProd','$vNomPost',$vHargaAsliPost,$vHargaPost,'$vMsisdn','$vServerResponse','$vXMLSent','Transaksi Pulsa $vOperator ke $vMsisdn','$vUser','1','1',0,now(),now(),'ANTA');";   
				   $db->query($vSQL);	


			      $vSQL="INSERT INTO tb_trxpulsa (fidtrx,fidmember,fkdproduk,fnominal,fhrgsumber,fhrgamh,fmsisdn,fserverresponse,fxmlsent,fket,flastuser,fstatustrx,fstatusrow,fsaldoamh,ftglupdate,ftglentry,fprovider) ";
				  $vSQL.="VALUE('$vNextID','$vUser','$vKdProd','$vNomPost',$vHargaAsliPost,$vHargaPost,'$vMsisdn','$vServerResponse','$vXMLSent','Transaksi Pulsa $vOperator ke $vMsisdn','$vUser','1','1',0,now(),now(),'ANTA');";   
				  $db->query($vSQL);	
				  $vDesc="Transaksi pulsa $vOperator $vNextID - $vKdProd ke nomor ($vMsisdn)";
				  $vLastBal=$oMember->getMemFieldBis(fsaldovcr,$vUser);
				  $vBal=$vLastBal-$vHargaPost;
				  $oKomisi->insertMutasi($vUser,$vUser,date("Y-m-d H:i:s"),$vDesc,0,$vHargaPost,$vBal,'trxpulsa',$vNextID) ;
				  $oMember->updateBalBis($vUser,$vBal);



					
					$vProsenFeeSpon=$oRules->getSettingByField("fminroyal");
					$vSponFee=($vFeePublic - $vFeePulsa) * ($vProsenFeeSpon/100);
/*
					$vSponsor=$oNetwork->getSponsor($vUser);
					$vLastBal=$oKomisi->getLastBalance($vSponsor);
					$vBal=$vLastBal+$vSponFee;
					
					
					$vDesc="Bonus Transaksi Sponsor dari $vUser, pembelian pulsa $vNextID - $vKdProd ";
					$oKomisi->insertMutasi($vSponsor,$vSponsor,date("Y-m-d H:i:s"),$vDesc,$vSponFee,0,$vBal,'pulsa') ;
					$oMember->updateSaldo($vSponsor,$vSponFee,'K');


					$vLastBal=$oKomisi->getLastBalance($vUser);
					$vBal=$vLastBal-$vSponFee;
					
					
					$vDesc="Bayar Bonus Transaksi Sponsor untuk $vSponsor, pembelian pulsa $vNextID - $vKdProd ke nomor ($vMsisdn)";
					$oSystem->sendMail("didit@operamail.com","japri_s@yahoo.com","Didit Opera","","Debug Mutasi AMH","PrevBal:$vLastBal, Bal:$vBal, SFee;$vSponFee","localhost");
					$oKomisi->insertMutasi($vUser,$vUser,date("Y-m-d H:i:s"),$vDesc,0,$vSponFee,$vBal,'pulsa') ;
					$oMember->updateSaldo($vUser,$vSponFee,'D');*/
					
				  $vSig=md5($vMsisdn.$vNextID);
				//  $vURLServer="http://windows.amhtechno.com/reqvoucher.php?kprod=$vKdProd&msis=$vMsisdn&trxid=$vNextID&sig=$vSig&cmd=TOPUP";
				  
	

				 // $vResult=$oPulsa->getGoto($vURLServer,"");
				 $vData = array("customer_id"=>$vMsisdn,'username'=>$vUserAnta,'password'=>$vPassAnta,'code'=>$vKdProd,'type'=>$vTypeProd);
				 $vResult=$oPulsa->genPost($vURLServer,$vData,'');
				   
			

					$pattern = '/\{(?:[^{}]|(?R))*\}/x';
					
					preg_match_all($pattern, $vResult, $matches);
					 $vJSon=$matches[0][0];
				//	print_r($vJSon);
					$vObjRes =json_decode($vJSon,true);
					//print_r($vObjRes);  
					$vResData = $vObjRes['results']['data'];
								   
				  


				  
				//  exit;
				 // $vResX=explode("|",$vResult);
				 $vServerResponse= $vJSon;
				 
			//	 //exit;
				  //$vXMLSent=$vResX[0];				

			      $vSQL="update tb_trxpulsa set fserverresponse='$vServerResponse', fxmlsent='{$vResData['request_id']}' where fidtrx='$vNextID' and (fserverresponse='' or fserverresponse is null); ";
				 
				  $db->query($vSQL);	

				   
				 //Resp Object
//				  $vServerResponse=substr($vServerResponse,15,255);
				//  $vServerResponse=explode("<?xml",$vServerResponse);
				 // $vServerResponse=$vServerResponse[0];
				  
				  if (trim($vServerResponse)=='') {
					  $oSystem->jsAlert('Error! Tidak ada response dari server pulsa!');
					  $oJual->reverseBalance($vUser,'Error! Tidak ada response dari server pulsa!',$vHargaPost,$vNextID,$vKdProd);
					  $oSystem->jsLocation('../memstock/pulsa_at.php');				  
					  exit;
				  } else if (preg_match("/Empty reply from server/i",$vServerResponse)) {
					  $oSystem->jsAlert('Error! Tidak ada response dari server pulsa!');
					  $oJual->reverseBalance($vUser,'Error! Tidak ada response dari server pulsa!',$vHargaPost,$vNextID,$vKdProd);
					  $oSystem->jsLocation('../memstock/pulsa_at.php');
					  exit;
				  } else if (preg_match("/Failed to connect to/i",$vServerResponse)) {
					  $oSystem->jsAlert('Error! Ada masalah koneksi server pulsa!');
					  $oJual->reverseBalance($vUser,'Error! Ada masalah koneksi server pulsa!',$vHargaPost,$vNextID,$vKdProd);
					  $oSystem->jsLocation('../memstock/pulsa_at.php');
					  exit;
				  } else if (preg_match("/engine_not_running/i",$vServerResponse)) {
					  $oSystem->jsAlert('Error! Salah Status Kode!');
					  $oJual->reverseBalance($vUser,'Error! Salah Status Kode!',$vHargaPost,$vNextID,$vKdProd);					  
					  $oSystem->jsLocation('../memstock/pulsa_at.php');
					  exit;
				  }  else if (preg_match("/ID Client telah diblokir/i",$vServerResponse)) {
					  $oSystem->jsAlert('Error! Ada masalah server pulsa!');
					  $oJual->reverseBalance($vUser,'Error! Ada masalah server pulsa!',$vHargaPost,$vNextID,$vKdProd);
					  $oSystem->jsLocation('../memstock/pulsa_at.php');
					  exit;
				  } else if (preg_match("/Salah Password/i",$vServerResponse)) {
					  $oSystem->jsAlert('Error! Ada masalah authentikasi server pulsa!');
					  $oJual->reverseBalance($vUser,'Error! Ada masalah authentikasi server pulsa!',$vHargaPost,$vNextID,$vKdProd);
					  $oSystem->jsLocation('../memstock/pulsa_at.php');
					  exit;
				  } else if (preg_match("/Possible Attack/i",$vServerResponse)) {
					  $oSystem->jsAlert('Error! Possible Attack!');
					  $oJual->reverseBalance($vUser,'Error! Possible Attack!',$vHargaPost,$vNextID,$vKdProd);
					  $oSystem->jsLocation('../memstock/pulsa_at.php');
					  exit;
				  } else if (preg_match("/Sudah Pernah Diorderkan/i",$vServerResponse)) {
					  $oSystem->jsAlert("Error! Kode produk $vKdProd sudah pernah diorderkan ke nomor $vMsisdn, tidak bisa diorder lagi dalam 24 jam!");
					  $oJual->reverseBalance($vUser,"Error! Kode produk $vKdProd sudah pernah diorderkan ke nomor $vMsisdn, tidak bisa diorder lagi dalam 24 jam!",$vHargaPost,$vNextID,$vKdProd);
					  $oSystem->jsLocation('../memstock/pulsa_at.php');
					  exit;
				  }  else if ($vResData['status_code']=='0') {
					  $vStatus='1';
					  $oSystem->jsAlert("Sukses! Transaksi pulsa $vKdProd ke nomor $vMsisdn berhasil dikirim ke server pulsa, silakan tunggu pulsa masuk ke nomor tujuan!. Untuk mengetahui status transaksi terkini, klik tombol [Refresh List]!");
					  $oSystem->jsLocation('../memstock/pulsa_at.php');
				  }  else if ($vResData['status_code']=='1') {
					  $vStatus='0';
					  $oSystem->jsAlert("Sukses! Transaksi pulsa $vKdProd ke nomor $vMsisdn berhasil, silakan tunggu pulsa masuk ke nomor tujuan!. Untuk mengetahui status transaksi terkini, klik tombol [Refresh List]!");
					  $oSystem->jsLocation('../memstock/pulsa_at.php');
				  } else  if ($vResData['status_code']=='2') {
					  $oSystem->jsAlert("Transaksi Gagal, kemungkinan salah produk atau ada gangguan!");
					  $oJual->reverseBalance($vUser,'Transaksi Gagal, kemungkinan salah produk atau ada gangguan!',$vHargaPost,$vNextID,$vKdProd);
					  $oSystem->jsLocation('../memstock/pulsa_at.php');
					  exit;
				  } 
				  
	
					
					

				//  $oSystem->jsAlert("Sukses! Transaksi pulsa $vKdProd ke nomor $vMsisdn berhasil dikirim ke server pulsa, silakan tunggu pulsa masuk ke nomor tujuan!");
				  $oSystem->jsLocation('../memstock/pulsa_at.php');

				  
			   }
		   }
			
		}
	}
 ?>
<body class="sticky-header"> 
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
-->
</style>

 <div class="right_col" role="main" >
		<div><label><h3>Transaksi Pulsa
            <?=$vUser?>
		</h3>
	    </label></div> 

<table  width="100%"  border="0" cellpadding="0" cellspacing="0">
<script type="text/javascript" src="../js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />
<script language="javascript">


function changeTRX(pThis) {

	var vLength=$('.cbProd').length;
	for (i=0;i<vLength;i++) {
	    var objFocused=document.activeElement.id;
		if 	(('cbProd'+(i+1)) !=objFocused) 
		   $('#cbProd'+(i+1)).val('');
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
		   vText=$('#cbProd'+(i+1)).find("option:selected").text().trim();
		   if (vValue!='') {
			   if(confirm('Yakin melakukan pembelian pulsa '+vText+' ke nomor tujuan '+vMsis+'?')==true) {
				  document.frmInvest.submit(); 
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
	
$('#dc1').datepicker({

                    format: "yyyy-mm-dd",
					//"setDate": new Date()

    }).on('changeDate', function (ev) {

    				$(this).datepicker('hide');

    });  


$('#dc2').datepicker({

                    format: "yyyy-mm-dd",
					//"setDate": new Date()

    }).on('changeDate', function (ev) {

    				$(this).datepicker('hide');

    });  
 

	
if ('<?=$_POST[hList]?>' == '1') {

   window.location.hash='history';
}

 $("#tfMsis").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
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
</script>
  
  <tr valign="top"> 
    <td align="center" valign="top">
  
      <table width="100%"  border="0" align="left" cellpadding="0"  cellspacing="0">
        <tr> 
          <td width="498"  height="25" align="left" valign="top">
          <?=$oInterface->getKetTRX($vuMenu)?><blink>
         <!-- <h2 style="color:#F00">Maaf transaksi pulsa HP dan PLN sedang gangguan!</h2></blink> -->

         
            <form name="frmInvest" method="post" action="" onSubmit="return saveTopup()">
              <table width="100%" border="0" align="left" cellpadding="3" class="table table-striped table-bordered" cellspacing="0" style="border:1px solid #CCC" ">
                <tr>
                  <td width="140">ID</td>
                  <td colspan="3"><div align="left">
                    <input name="ID" type="text" id="ID" value="<?=$vUser?>" size="15" readonly="true" style="background-color:#CCC" />
                    <input type="hidden" name="hPost" id="fPost" value="1" />
                  </div></td>
                </tr>
                <tr>
                  <td>Nomor Tujuan (MSISDN)</td>
                  <td colspan="3"><input style="font-size:14px;font-weight:bold;" name="tfMsis" type="text" id="tfMsis"  size="30"  class="Number"    /></td>
                </tr>
                <tr>
                  <td rowspan="9" valign="top">Produk</td>
                  <td width="173">Telkomsel Pulsa</td>
                  <td width="501">
                    <select class="cbProd form-control" onChange="changeTRX(this)" name="cbProd1" id="cbProd1">
                      <option selected="selected" value="">--Pilih--</option>
                      <?
                         $vSQL="select * from m_voucherhp where Jenis in ('pulsa') and Brand='Telkomsel' and status='OK' order by Nom";
						 $db->query($vSQL);
						 while ($db->next_record()) {
							 $vValue=$db->f('Kode');
							 $vBrand=$db->f('Brand');
							 $vNominal=$db->f('Keterangan');
							 $vRegional=$db->f('Regional');
							 $vHargaAsli=$db->f('Harga');
							 $vHarga=$db->f('Harga') + $vFeePulsa;
							 $vHargaP=$db->f('Harga') + $vFeePublic;
							 $vStatus=$db->f('Status');
							 $vType=$db->f('Jenis');
							 $vLabel=strtoupper($db->f('Kode'))." $vNominal, NTA: ".number_format($vHarga,0,',','.').", Hrg. Jual: ".number_format($vHargaP,0,',','.');
					  ?>
                      <option value="<?="$vValue|$vNominal|$vHarga|$vHargaAsli|$vBrand|$vType"?>"><?=$vLabel?></option>
                      <? } ?>
                  </select></td>
                  <td width="151" rowspan="2"><img src="../images/tsel.jpg" height="40" alt="tsel" /></td>
                </tr>
                <tr>
                  <td>Telkomsel Data</td>
                  <td><select class="cbProd form-control" onChange="changeTRX(this)" name="cbProd2" id="cbProd2">
                    <option selected="selected" value="">--Pilih--</option>
                    <?
                         $vSQL="select * from m_voucherhp where Jenis in ('data') and Brand='Telkomsel' and status='OK' order by Nom";
						 $db->query($vSQL);
						 while ($db->next_record()) {
							 $vValue=$db->f('Kode');
							 $vBrand=$db->f('Brand');
							 $vNominal=$db->f('Keterangan');
							 $vRegional=$db->f('Regional');
							 $vHargaAsli=$db->f('Harga');
							 $vHarga=$db->f('Harga') + $vFeePulsa;
$vHargaP=$db->f('Harga') + $vFeePublic;
							 $vStatus=$db->f('Status');
							 $vType=$db->f('Jenis');
							 $vLabel=strtoupper($db->f('Kode'))." $vNominal, NTA: ".number_format($vHarga,0,',','.').", Hrg. Jual: ".number_format($vHargaP,0,',','.');
							 
					  ?>
                    <option value="<?="$vValue|$vNominal|$vHarga|$vHargaAsli|$vBrand|$vType"?>">
                      <?=$vLabel?>
                      </option>
                    <? } ?>
                  </select></td>
                </tr>
                <tr>
                  <td>Indosat Pulsa</td>
                  <td><select class="cbProd form-control" onChange="changeTRX(this)" name="cbProd3" id="cbProd3">
                    <option selected="selected" value="">--Pilih--</option>
                    <?
                         $vSQL="select * from m_voucherhp where Brand in ('Indosat') and Jenis='pulsa' and status='OK' order by Nom";
						 $db->query($vSQL);
						 while ($db->next_record()) {
							 $vValue=$db->f('Kode');
							 $vBrand=$db->f('Brand');
							 $vNominal=$db->f('Keterangan');
							 $vRegional=$db->f('Regional');
							 $vHargaAsli=$db->f('Harga');
							 $vHarga=$db->f('Harga') + $vFeePulsa;
$vHargaP=$db->f('Harga') + $vFeePublic;
							 $vStatus=$db->f('Status');
							 $vType=$db->f('Jenis');
							 $vLabel=strtoupper($db->f('Kode'))." $vNominal, NTA: ".number_format($vHarga,0,',','.').", Hrg. Jual: ".number_format($vHargaP,0,',','.');
					  ?>
                    <option value="<?="$vValue|$vNominal|$vHarga|$vHargaAsli|$vBrand|$vType"?>">
                      <?=$vLabel?>
                      </option>
                    <? } ?>
                  </select></td>
                  <td rowspan="2"><img src="../images/indosat.jpg" alt="indosat"  height="40" /></td>
                </tr>
                <tr>
                  <td>Indosat Data</td>
                  <td><select class="cbProd form-control" onChange="changeTRX(this)" name="cbProd4" id="cbProd4">
                    <option selected="selected" value="">--Pilih--</option>
                    <?
                         $vSQL="select * from m_voucherhp where Brand in ('Indosat') and Jenis='data' and status='OK' order by Nom";
						 $db->query($vSQL);
						 while ($db->next_record()) {
							 $vValue=$db->f('Kode');
							 $vBrand=$db->f('Brand');
							 $vNominal=$db->f('Keterangan');
							 $vRegional=$db->f('Regional');
							 $vHargaAsli=$db->f('Harga');
							 $vHarga=$db->f('Harga') + $vFeePulsa;
$vHargaP=$db->f('Harga') + $vFeePublic;
							 $vStatus=$db->f('Status');
							 $vType=$db->f('Jenis');
							 $vLabel=strtoupper($db->f('Kode'))." $vNominal, NTA: ".number_format($vHarga,0,',','.').", Hrg. Jual: ".number_format($vHargaP,0,',','.');
							  if (in_array($vValue,$vArrSMS))
							    $vLabel.=" (SMS)"; 

					  ?>
                    <option value="<?="$vValue|$vNominal|$vHarga|$vHargaAsli|$vBrand|$vType"?>">
                      <?=$vLabel?>
                      </option>
                    <? } ?>
                    </select></td>
                </tr>
                <tr>
                  <td>XL Pulsa</td>
                  <td><select class="cbProd form-control" onChange="changeTRX(this)" name="cbProd5" id="cbProd5">
                    <option selected="selected" value="">--Pilih--</option>
                    <?
                         $vSQL="select * from m_voucherhp where Brand in ('XL / AXIS') and Jenis='pulsa' and kode like 'p-xl%' and status='OK' order by Nom";
						 $db->query($vSQL);
						 while ($db->next_record()) {
							 $vValue=$db->f('Kode');
							 $vBrand=$db->f('Brand');
							 $vNominal=$db->f('Keterangan');
							 $vRegional=$db->f('Regional');
							 $vHargaAsli=$db->f('Harga');
							 $vHarga=$db->f('Harga') + $vFeePulsa;
$vHargaP=$db->f('Harga') + $vFeePublic;
							 $vStatus=$db->f('Status');
							 $vType=$db->f('Jenis');
							 $vLabel=strtoupper($db->f('Kode'))." $vNominal, NTA: ".number_format($vHarga,0,',','.').", Hrg. Jual: ".number_format($vHargaP,0,',','.');
					  ?>
                    <option value="<?="$vValue|$vNominal|$vHarga|$vHargaAsli|$vBrand|$vType"?>">
                      <?=$vLabel?>
                      </option>
                    <? } ?>
                    </select></td>
                  <td rowspan="2"><img src="../images/xl.jpg" alt="indosat"  height="40" /></td>
                </tr>
                <tr>
                  <td>XL Data</td>
                  <td><select class="cbProd form-control" onChange="changeTRX(this)" name="cbProd6" id="cbProd6">
                    <option selected="selected" value="">--Pilih--</option>
                    <?
                         $vSQL="select * from m_voucherhp where Brand in ('XL / AXIS') and Jenis='data' and kode like 'd-xl%' and status='OK' order by Nom";
						 $db->query($vSQL);
						 while ($db->next_record()) {
							 $vValue=$db->f('Kode');
							 $vBrand=$db->f('Brand');
							 $vNominal=$db->f('Keterangan');
							 $vRegional=$db->f('Regional');
							 $vHargaAsli=$db->f('Harga');
							 $vHarga=$db->f('Harga') + $vFeePulsa;
$vHargaP=$db->f('Harga') + $vFeePublic;
							 $vStatus=$db->f('Status');
							 $vType=$db->f('Jenis');
							 $vLabel=strtoupper($db->f('Kode'))." $vNominal, NTA: ".number_format($vHarga,0,',','.').", Hrg. Jual: ".number_format($vHargaP,0,',','.');
					  ?>
                    <option value="<?="$vValue|$vNominal|$vHarga|$vHargaAsli|$vBrand|$vType"?>">
                      <?=$vLabel?>
                      </option>
                    <? } ?>
                  </select></td>
                  </tr>
                
                <tr>
                  <td>Axis Pulsa</td>
                  <td><select class="cbProd form-control" onChange="changeTRX(this)" name="cbProd7" id="cbProd7">
                    <option selected="selected" value="">--Pilih--</option>
                    <?
                         $vSQL="select * from m_voucherhp where Brand in ('XL / AXIS') and Jenis='pulsa' and kode like 'p-axis%' and status='OK' order by Nom";
						 $db->query($vSQL);
						 while ($db->next_record()) {
							 $vValue=$db->f('Kode');
							 $vBrand=$db->f('Brand');
							 $vNominal=$db->f('Keterangan');
							 $vRegional=$db->f('Regional');
							 $vHargaAsli=$db->f('Harga');
							 $vHarga=$db->f('Harga') + $vFeePulsa;
$vHargaP=$db->f('Harga') + $vFeePublic;
							 $vStatus=$db->f('Status');
							 $vType=$db->f('Jenis');
							 $vLabel=strtoupper($db->f('Kode'))." $vNominal, NTA: ".number_format($vHarga,0,',','.').", Hrg. Jual: ".number_format($vHargaP,0,',','.');
					  ?>
                    <option value="<?="$vValue|$vNominal|$vHarga|$vHargaAsli|$vBrand|$vType"?>">
                      <?=$vLabel?>
                      </option>
                    <? } ?>
                  </select></td>
                  <td rowspan="2"><img src="../images/axis.jpg" alt="indosat"  height="40" /></td>
                </tr>
                <tr>
                  <td>Axis Data</td>
                  <td><select class="cbProd form-control" onChange="changeTRX(this)" name="cbProd8" id="cbProd8">
                    <option selected="selected" value="">--Pilih--</option>
                    <?
                         $vSQL="select * from m_voucherhp where Brand in ('XL / AXIS') and Jenis='data' and kode like 'd-axis%' and status='OK' order by Nom";
						 $db->query($vSQL);
						 while ($db->next_record()) {
							 $vValue=$db->f('Kode');
							 $vBrand=$db->f('Brand');
							 $vNominal=$db->f('Keterangan');
							 $vRegional=$db->f('Regional');
							 $vHargaAsli=$db->f('Harga');
							 $vHarga=$db->f('Harga') + $vFeePulsa;
$vHargaP=$db->f('Harga') + $vFeePublic;
							 $vStatus=$db->f('Status');
							 $vType=$db->f('Jenis');
							 $vLabel=strtoupper($db->f('Kode'))." $vNominal, NTA: ".number_format($vHarga,0,',','.').", Hrg. Jual: ".number_format($vHargaP,0,',','.');
					  ?>
                    <option value="<?="$vValue|$vNominal|$vHarga|$vHargaAsli|$vBrand|$vType"?>">
                      <?=$vLabel?>
                      </option>
                    <? } ?>
                  </select></td>
                  </tr>
                <tr>
                  <td>Three Pulsa</td>
                  <td><select class="cbProd form-control" onChange="changeTRX(this)" name="cbProd9" id="cbProd9">
                    <option selected="selected" value="">--Pilih--</option>
                    <?
                         $vSQL="select * from m_voucherhp where Brand in ('Tri') and Jenis='pulsa' and status='OK' order by Nom";
						 $db->query($vSQL);
						 while ($db->next_record()) {
							 $vValue=$db->f('Kode');
							 $vBrand=$db->f('Brand');
							 $vNominal=$db->f('Keterangan');
							 $vRegional=$db->f('Regional');
							 $vHargaAsli=$db->f('Harga');
							 $vHarga=$db->f('Harga') + $vFeePulsa;
$vHargaP=$db->f('Harga') + $vFeePublic;
							 $vStatus=$db->f('Status');
							 $vType=$db->f('Jenis');
							 $vLabel=strtoupper($db->f('Kode'))." $vNominal, NTA: ".number_format($vHarga,0,',','.').", Hrg. Jual: ".number_format($vHargaP,0,',','.');
					  ?>
                    <option value="<?="$vValue|$vNominal|$vHarga|$vHargaAsli|$vBrand|$vType"?>">
                      <?=$vLabel?>
                      </option>
                    <? } ?>
                  </select></td>
                  <td rowspan="2"><img src="../images/tri.jpg" alt="indosat"  height="40" /></td>
                </tr>
                <tr>
                  <td valign="top">&nbsp;</td>
                  <td>Three Data</td>
                  <td><select class="cbProd form-control" onChange="changeTRX(this)" name="cbProd10" id="cbProd10">
                    <option selected="selected" value="">--Pilih--</option>
                    <?
                         $vSQL="select * from m_voucherhp where Brand in ('Tri') and Jenis='data' and status='OK' order by Nom";
						 $db->query($vSQL);
						 while ($db->next_record()) {
							 $vValue=$db->f('Kode');
							 $vBrand=$db->f('Brand');
							 $vNominal=$db->f('Keterangan');
							 $vRegional=$db->f('Regional');
							 $vHargaAsli=$db->f('Harga');
							 $vHarga=$db->f('Harga') + $vFeePulsa;
$vHargaP=$db->f('Harga') + $vFeePublic;
							 $vStatus=$db->f('Status');
							 $vType=$db->f('Jenis');
							 $vLabel=strtoupper($db->f('Kode'))." $vNominal, NTA: ".number_format($vHarga,0,',','.').", Hrg. Jual: ".number_format($vHargaP,0,',','.');
					  ?>
                    <option value="<?="$vValue|$vNominal|$vHarga|$vHargaAsli|$vBrand|$vType"?>">
                      <?=$vLabel?>
                      </option>
                    <? } ?>
                  </select></td>
                  </tr>
                <tr>
                  <td valign="top">&nbsp;</td>
                  <td>Smartfren Pulsa</td>
                  <td><select class="cbProd form-control" onChange="changeTRX(this)" name="cbProd11" id="cbProd11">
                    <option selected="selected" value="">--Pilih--</option>
                    <?
                         $vSQL="select * from m_voucherhp where Brand in ('SMARTFREN') and Jenis='pulsa' and status='OK' order by Nom";
						 $db->query($vSQL);
						 while ($db->next_record()) {
							 $vValue=$db->f('Kode');
							 $vBrand=$db->f('Brand');
							 $vNominal=$db->f('Keterangan');
							 $vRegional=$db->f('Regional');
							 $vHargaAsli=$db->f('Harga');
							 $vHarga=$db->f('Harga') + $vFeePulsa;
$vHargaP=$db->f('Harga') + $vFeePublic;
							 $vStatus=$db->f('Status');
							 $vType=$db->f('Jenis');
							 $vLabel=strtoupper($db->f('Kode'))." $vNominal, NTA: ".number_format($vHarga,0,',','.').", Hrg. Jual: ".number_format($vHargaP,0,',','.');
					  ?>
                    <option value="<?="$vValue|$vNominal|$vHarga|$vHargaAsli|$vBrand|$vType"?>">
                      <?=$vLabel?>
                      </option>
                    <? } ?>
                  </select></td>
                  <td rowspan="2"><img src="../images/smartfren.jpg" alt="indosat"  height="40" /></td>
                </tr>
                
<tr>
                  <td valign="top">&nbsp;</td>
                  <td>Smartfren Data</td>
                  <td><select class="cbProd form-control" onChange="changeTRX(this)" name="cbProd12" id="cbProd12">
                    <option selected="selected" value="">--Pilih--</option>
                    <?
                         $vSQL="select * from m_voucherhp where Brand in ('SMARTFREN') and Jenis='data' and status='OK' order by Nom";
						 $db->query($vSQL);
						 while ($db->next_record()) {
							 $vValue=$db->f('Kode');
							 $vBrand=$db->f('Brand');
							 $vNominal=$db->f('Keterangan');
							 $vRegional=$db->f('Regional');
							 $vHargaAsli=$db->f('Harga');
							 $vHarga=$db->f('Harga') + $vFeePulsa;
$vHargaP=$db->f('Harga') + $vFeePublic;
							 $vStatus=$db->f('Status');
							 $vType=$db->f('Jenis');
							 $vLabel=strtoupper($db->f('Kode'))." $vNominal, NTA: ".number_format($vHarga,0,',','.').", Hrg. Jual: ".number_format($vHargaP,0,',','.');
					  ?>
                    <option value="<?="$vValue|$vNominal|$vHarga|$vHargaAsli|$vBrand|$vType"?>">
                      <?=$vLabel?>
                      </option>
                    <? } ?>
                  </select></td>
                  </tr>
                
                                
                <tr>
                  <td valign="top">&nbsp;</td>
                  <td>By U</td>
                  <td><select class="cbProd form-control" onChange="changeTRX(this)" name="cbProd13" id="cbProd13">
                    <option selected="selected" value="">--Pilih--</option>
                    <?
                         $vSQL="select * from m_voucherhp where Brand in ('by.U') and Jenis='pulsa' and status='OK' order by Nom";
						 $db->query($vSQL);
						 while ($db->next_record()) {
							 $vValue=$db->f('Kode');
							 $vBrand=$db->f('Brand');
							 $vNominal=$db->f('Keterangan');
							 $vRegional=$db->f('Regional');
							 $vHargaAsli=$db->f('Harga');
							 							 $vHarga=$db->f('Harga') + $vFeePulsa;
$vHargaP=$db->f('Harga') + $vFeePublic;
							 $vStatus=$db->f('Status');
							 $vType=$db->f('Jenis');
							 $vLabel=strtoupper($db->f('Kode'))." $vNominal, NTA: ".number_format($vHarga,0,',','.').", Hrg. Jual: ".number_format($vHargaP,0,',','.');
					  ?>
                    <option value="<?="$vValue|$vNominal|$vHarga|$vHargaAsli|$vBrand|$vType"?>">
                      <?=$vLabel?>
                      </option>
                    <? } ?>
                    </select></td>
                  <td><img src="../images/byu.png" alt="indosat"  height="40" /></td>
                </tr>
                <tr>
                  <td valign="top">&nbsp;</td>
                  <td>Ceria</td>
                  <td><select class="cbProd form-control" onChange="changeTRX(this)" name="cbProd14" id="cbProd14">
                    <option selected="selected" value="">--Pilih--</option>
                    <?
                         $vSQL="select * from m_voucherhp where Brand in ('ceria') and Jenis='pulsa' and status='OK' order by Nom";
						 $db->query($vSQL);
						 while ($db->next_record()) {
							 $vValue=$db->f('Kode');
							 $vBrand=$db->f('Brand');
							 $vNominal=$db->f('Keterangan');
							 $vRegional=$db->f('Regional');
							 $vHargaAsli=$db->f('Harga');
							 $vHarga=$db->f('Harga') + $vFeePulsa;
$vHargaP=$db->f('Harga') + $vFeePublic;
							 $vStatus=$db->f('Status');
							 $vType=$db->f('Jenis');
							 $vLabel=strtoupper($db->f('Kode'))." $vNominal, NTA: ".number_format($vHarga,0,',','.').", Hrg. Jual: ".number_format($vHargaP,0,',','.');
					  ?>
                    <option value="<?="$vValue|$vNominal|$vHarga|$vHargaAsli|$vBrand|$vType"?>">
                      <?=$vLabel?>
                      </option>
                    <? } ?>
                    </select></td>
                  <td><img src="../images/ceria.jpg" alt="indosat"  height="40" /></td>
                </tr>
                <? if (trim($oInterface->getMenuContent("topup",true)) != '') { ?>
                <? } ?>
                
                <tr> 
                  <td height="37" colspan="4"> <div align="left">
                    <input class="btn btn-success" type="button" name="kirim" value="Kirim Transaksi" onClick="confirmOrder()"> 
                    <input  class="btn btn-default"

type="reset" name="reset" value="Bersihkan"> 
                  </div></td>
                </tr>
              </table>
            </form>
          <p>&nbsp;</p></td>
        </tr>
        <tr>
          <td  height="25" align="left" valign="top"></td>
        </tr>
    </table>	 
	  </td>
  </tr>
  <tr valign="top">
    <td align="center" valign="top"><form style="" action="" method="post" name="frListJual" id="frListJual">
      <p><span class="style1"><span class="style22 style8">History Transaksi<span class="style8">
          [<?=$vUser." / ".$oMember->getMemberName($vUser);?>]
                </span></span></span><span class="style8"><a name="history" id="history"></a></span><br />
                <br />
    <div class="row form-inline" style="font-weight:bold">
            <div class="col-lg-7" ><span class="col-lg-2" style="text-align:right;margin-top:7px">Mulai :</span> <input  name="dc1"  id="dc1" value="<?=$vsTglAwal?>" size="9" class="form-control" style="width:100px"  />
s/d
            <input  name="dc2"  id="dc2" value="<?=$vsTglAkhir?>" size="9" class="form-control" style="width:100px" />
               
<input type="submit" name="button" id="button" value="Refresh List" class="btn btn-info" style="margin-top:6px" />
                  <input type="hidden" id="hList" name="hList" value="1" /></div> </div>
                  <br />
<div align="left" style="color:#f00;font-weight:bold">Untuk mengetahui status transaksi terkini, klik tombol [Refresh List]!</div>
<div class="table-responsive">
      <table width="100%%" border="1" align="center" cellpadding="0" cellspacing="0" class=" table table-striped table-bordered">
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
        <td width="2%"><div align="center" class="style9">No.</div></td>
                <td width="20%" height="26"><div align="center" class="style9">Tanggal</div></td>
                <td width="9%"><div align="center" class="style9">No Transaksi </div></td>
                <td width="8%"><div align="center" class="style10"><strong>Kode Produk</strong></div>
                    <div align="center" class="style10"></div>
                <div align="center" class="style10"> </div></td>
                <td width="7%"><div align="center" class="style10"><strong>Nominal</strong></div></td>
                <td width="11%"><div align="center" class="style10"><strong>Harga</strong></div></td>
                <td width="24%"><div align="center" class="style10"><strong>Status</strong></div></td>
                <td width="19%"><div align="center">
                  <div align="center" class="style10"><strong>Keterangan</strong></div>
                </div></td>
          </tr>
              <?
		  $vsql="select * from tb_trxpulsa where 1 and fkdproduk not like 'PLN%' and fidmember='$vUser' and (date(ftglentry) between  date('$vsTglAwal') and date('$vsTglAkhir'))";
		  $vsql.=$vCrit;
		  $vsql.="   order by fidtrx ";

		  $db->query($vsql);
		  
		  $vNo=0; 
		  
		  while($db->next_record()){
			  
			 $vRequestId=$db->f('fxmlsent');
			 $vIDTrx=$db->f('fidtrx');
			 
				
			 $vData = array("request_id"=>$vRequestId,'username'=>$vUserAnta,'password'=>$vPassAnta);		
			 
			 $vResultCheck=$oPulsa->genPost($vURLCheck,$vData,'');		
			 $vObjCheck = json_decode($vResultCheck,true);
			 $vDataCheck = $vObjCheck['results']['data'];
			 $vStatus = $vDataCheck['status_code'];
			 $vSN = $vDataCheck['sn'];
			 if($vStatus=='1') {
				$vSQL ="update tb_trxpulsa set fstatustrx='0', fsn='$vSN' where fidtrx='$vIDTrx' ";
				$dbin->query($vSQL); 
			 } else if($vStatus=='0') {
				$vSQL ="update tb_trxpulsa set fstatustrx='1' where fidtrx='$vIDTrx' ";
				$dbin->query($vSQL); 
			 } 			 if($vStatus=='2') {
				$vSQL ="update tb_trxpulsa set fstatustrx='4' where fidtrx='$vIDTrx' ";
				$dbin->query($vSQL); 
			 }


			//  echo $vSQL;
			  
		  }
		   $db->query($vsql);
		  while ($db->next_record()) {
			  $vNo+=1;
			 $vTanggal=$oPhpdate->YMDT2DMYT($db->f('ftglentry'));
			 $vIDTrx=$db->f('fidtrx');
			 $vKdProd=$db->f('fkdproduk');
			 $vNomList=$db->f('fnominal');
			 $vResponse=$db->f('fserverresponse');
			 $vHargList=number_format($db->f('fhrgamh'),0,",",".");
			 $vKet=$db->f('fket');
			    			 
			 
			 $vKetAll=explode(", Yth: AA0225, AMH TECHNO",$vKet);
			 if (preg_match("/BERHASIL/i",$vKetAll[1]))
			    $vKet=$vKetAll[0]." BERHASIL";
			 else 	$vKet=$vKetAll[0];
			 
			// $vKet=str_replace("BERHASIL BERHASIL","BERHASIL",$vKet);
			 $vStatDB=$db->f('fstatustrx');
			 $vSNDB=$db->f('fsn');
			 $vVNDB=$db->f('fvn');
			 if ($vStatDB=='0') {
			     $vStatText='Berhasil';
				 if ($vSNDB !='' || $vVNDB !='')
				    $vStatText.=", SN: $vSNDB, VN: $vVNDB";
			 } else if ($vStatDB=='1' && preg_match("/error/",$vResponse))
			     $vStatText='Gagal';
			 else if ($vStatDB=='1' && !preg_match("/error/",$vResponse))
			     $vStatText='Diproses';
			 else if ($vStatDB=='11' || $vStatDB=='4')
			     $vStatText='Gagal';

		?>
              <tr  <? if ($vStatDB=='0') echo "style='background-color:#66CC66;color:black'"; else if ($vStatDB=='11' || $vStatDB=='4') echo "style='background-color:#f00;color:black'"?>    >
                <td><div align="right"><span class="style10">
                  <?=$vNo?>
                </span></div></td>
                <td><div align="center" class="style10">
                    <?=$vTanggal?>
                    <br />
                </div></td>
                <td  nowrap><span class="style10" >
                <?=$vIDTrx?>
                  <br />                
                  </span></td>
                <td><div align="center" class="style10">
                  <?=$vKdProd?>
                </div></td>
                <td><div align="right"><span class="style10">
                  <?=$vNomList?>
                </span></div></td>
                <td><div align="right"><span class="style10">
                  <?=$vHargList?>
                </span></div></td>
                <td><?=$vStatText?></td>
                <td><span class="style10">
                  <?=$vKet?>
                </span></td>
              </tr>
              <? 
     
	 } // while $db->next_record //if $vCrit
  ?>
              <tr style="display:none">
                <td colspan="3"><span class="style10"><strong>Total</strong></span></td>
                <td><div align="right" class="style10"><strong>
                    <?=number_format($vTotJual,0,",",".");?>
                </strong></div></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
        </table>
        </div>
    </form></td>
  </tr>
</table>

</div>
<? include_once("../framework/outer_footside.blade.php") ; ?>
