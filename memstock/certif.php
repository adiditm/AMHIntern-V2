
<? 
include_once("../memstock/welcome.php");
include_once("../framework/member_headside.blade.php");
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
    $vNextJual=$oJual->getNextIDJual();
    $vBuyer=$_POST['tfSernoSpon'];
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
        
    	echo $vSQL="insert into $vMainTable(fidpenjualan, fidseller, fidmember, falamatkrm, fnostockist, fidproduk, fjumlah, ftanggal, fhargasat, fsubtotal, fsize, fcolor, ftgltrans, fjenis, fjmltrans, fserial, fpin, fmethod, fketerangan, ftglentry, fprocessed, ftglprocessed)";
    	$vSQL.=" values('$vNextJual','$vSeller','$vBuyer','$vAlamat','$vUser','".$val['lmKode']."',".$val['txtJml'].",now(),".$val['hHarga'].",".$val['hSubTot'].",'".$val['lmSize']."','".$val['lmColor']."',now(),'RO',0,'','','$lmMethod','Repeat Order',now(),'2','1981-01-01 00:00:00')";
  	 	
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
	}
 	    
  	    
    }
  	  



		
		

		if ($lmMethod=='wpr') {
			
			//Mutasi Si member


			$vLastBal=$oMember->getMemField('fsaldowprod',$vUser);
			$vNewBal=$vLastBal - $vTotal;

			$vsql="insert into tb_mutasi_wprod (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fincometax,fref) "; 
			$vsql.="values ('$vUser', '$vBuyer', now(),'Repeat Order Sales $vNextJual [Wallet Product] ' , 0,$vTotal ,$vNewBal ,'reorder' , '1','$vUser' , now(),0,'$vNextJual') "; 
			$db->query($vsql); 
			$oMember->updateBalConnWProd($vUser,$vNewBal,$db);



		}
    

    
    $db->query('COMMIT;');
	$oSystem->sendSMS($tfPhoneSpon,"UNIG\n\n$tfSponsor, terima kasih atas order Anda!");
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



.container {
    position: relative;
    text-align: center;
    color: white;
}

/* Bottom left text */
.bottom-left {
    position: absolute;
    bottom: 8px;
    left: 16px;
}

/* Top left text */
.top-left {
    position: absolute;
    top: 8px;
    left: 16px;
}

/* Top right text */
.top-right {
    position: absolute;
    top: 8px;
    right: 16px;
}

/* Bottom right text */
.bottom-right {
    position: absolute;
    bottom: 8px;
    right: 16px;
}

/* Centered text */
.centered {
    position: absolute;
    top: 57%;
    left: 50%;
    transform: translate(-50%, -50%);
	
}

/* Centered text */
.centered2 {
    position: absolute;
    top: 62%;
    left: 50%;
    transform: translate(-50%, -50%);
	
}


.centered3 {
    position: absolute;
    top: 65%;
    left: 16%;
  /*  transform: translate(-50%, -50%);*/
	text-align:justify;
	width:74%;
}


.centered4 {
    position: absolute;
    top: 46%;
    left: 30%;
  /*  transform: translate(-50%, -50%);*/
	text-align:justify;
	width:60%;
}

.centered5 {
    position: absolute;
    top: 86%;
    left: 20%;
  /*  transform: translate(-50%, -50%);*/
	text-align:justify;
	width:74%;
}

@font-face {
    font-family: myScript;
    src: url(parisienne-regular.woff);
}
	</style>
<script src="../js/jquery.validate.min.js"></script>
<script language="javascript">

function validRO() {
	//alert($('#hTot').val());ß
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
		<div class="right_col" role="main">
		<div><label><h3>Welcome Letter</h3></label></div>

<form method="post" id="frmPrint" name="frmPrint" enctype="multipart/form-data" >
<input type="hidden" id="hContent" name="hContent">
</form>

<form method="post" id="frmReg" name="frmReg" action="<?=$_SERVER['PHP_SELF']?>">
	<div class="container">
    <div class="row" style="width:98%;margin-top:8px">
    
     
    
    
        <div class="col-md-12">
               				<!--Panel Body -->
                     
                     							<!-- <div class="divtr">
                            <!-- Panel Sponsor -->

			                    <div class="panel panel-default container" id="panelkanan">
									<div class="panel-heading toska" style="background-color:#CCC;margin-top:1em;width:97.4%;margin-left:15px">
										<div class="panel-title " style="text-align:left">
											
                                            <button  type="button" id="btPrint" value="Print" class="btn btn-success" ><i class="fa fa-print">&nbsp;&nbsp;</i>Download PDF for Print</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label for="exampleInputEmail1" style="font-weight:bold;">
											Welcome <?=$oMember->getMemberName($vUser)?></label>
                                            
                                            </div>
                                            
									</div>
									<div class="panel-body" id="panelbody">
                                    <div id="maincontent">
									 <img src="../images/user/wclettersig.jpg" alt="Bg" style="width:100%;">
                        <!--             <div class="bottom-left">Bottom Left</div>
  <div class="top-left">Top Left</div>
  <div class="top-right">Top Right</div>
  <div class="bottom-right">Bottom Right</div>-->
  <div class="centered4"><span  style="width:90%;text-align:justify;font-size:18px;color:#262626;font-family:Tahoma, Geneva, sans-serif;">mengucapkan Selamat bergabung kepada Yth. Bapak / Ibu / Saudara / i:</span></div>
  <div class="centered"><span style="white-space:nowrap;text-align:center;font-size:55px;color:black;font-family:myScript;font-weight:boldß"><?=ucwords(strtolower($oMember->getMemberName($vUser)))?></span></div>
  
  <div class="centered2"><span style="white-space:nowrap;text-align:center;font-size:24px;color:black;font-family:Tahoma, Geneva, sans-serif;">Username: <?=$vUser?></span></div>
  
  
   <div class="centered3" id="ket"><span  style="width:90%;text-align:justify;font-size:15px;color:#262626;font-family:Tahoma, Geneva, sans-serif;">Bpk. / Ibu / Saudara / i telah resmi terdaftar sebagai mitra dari PT Usaha Nyata Insan Gemilang dan oleh karena itu saya <b><?=ucwords(strtolower($oMember->getMemberName($vUser)))?> </b>akan tunduk dan mengikuti peraturan yang ada di PT Usaha Nyata Insan Gemilang tanpa ada paksaan Atau tekanan dari siapapun.</span></div>
 
 
<div class="centered5"><span style="white-space:nowrap;text-align:center;font-size:18px;color:#727272;font-family:Tahoma, Geneva, sans-serif;"><?=$oPhpdate->YMD2DMY($oMember->getMemField('ftglaktif',$vUser))?></span></div>  
  
                                      <div id="nama" ></div>
</div>
</div>
										
							      
				</div>
				     
        </div>
		<!--Kolom Kanan -->
      </div>
    </div>
<hr /><br />
        
    <!--panel -->
</form> 
<!--<script src="//cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>

<div class="col-lg-6">


</div>
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
<script src="../js/scripts.js"></script></div>
	<!-- end page container -->
	

	<script>

function postToPrint() {
    var pForm=document.frmPrint;
    pForm.action='certfinal.php';
	window.open('', 'formpopup', 'width=860,height=700,resizeable,scrollbars');
    pForm.target = 'formpopup';
	pForm.submit();
}

	
	

		$(document).ready(function() {
			App.init();
			Dashboard.init();


		
			
			$('#btPrint').click(function() {
			
			//$('#hContent').val($('#panelbody').html());
			//postToPrint();
	
/*html2canvas(document.querySelector("#maincontent")).then(canvas => {
    document.body.appendChild(canvas)
});
			
			return false;*/
			
				
			  var options = {
				pagesplit: false,
				background: '#fff',
				format: 'PNG',
				padding: 0,
				margin: {
					top: 0,
					bottom: 0,
					left:0,
					right:0
					
				}
	
	};
			  var pdf = new jsPDF('l', 'mm', [320, 410]);
			  pdf.addHTML($("#maincontent"), 15, 15, options, function() {
				pdf.save('welcome_letter.pdf');
			  });
			});    

		});
	</script>

<? include_once("../framework/member_footside.blade.php") ; ?>