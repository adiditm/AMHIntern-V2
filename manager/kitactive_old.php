<? include_once("../framework/admin_headside.blade.php");
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
   $vSalProd = $oMember->getMemField('fsaldowprod',$vUser);
   $vUserHO = $oRules->getSettingByField('fuserho');
  
  
       
   if ($_POST['hPost'] != '1') {
      $_SESSION['save']='';
      $_SESSION['del']='';
    
   } else {
    $vNextJual=$oJual->getNextIDAct();
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
	   
	   $vMainTable='tb_kit_active';
	   
	$vTotal=$_POST['hTotal'];
	   
    while (list($key,$val) = each($_SESSION['save'])) {
        //print_r($val);
        
    	$vSQL="insert into $vMainTable(fidpenjualan, fidseller, fidmember, falamatkrm, fnostockist, fidproduk, fjumlah, ftanggal, fhargasat, fsubtotal,ftgltrans, fjenis, fjmltrans, fserial, fpin,  fketerangan, ftglentry, fprocessed, ftglprocessed)";
    	$vSQL.=" values('$vNextJual','$vUser','$vBuyer','$vAlamat','$vUser','".$val['lmKode']."',".$val['txtJml'].",now(),".$val['hHarga'].",".$val['hSubTot'].",now(),'KA',0,'','','KIT Activation',now(),'2','1981-01-01 00:00:00')";
  	 	
  	 	$db->query($vSQL);
		$vSQL="update tb_skit set fstatus='3', fpendistribusi='$vUser' where fserno='$vBuyer'";
		$db->query($vSQL);
		
  	 	$vTotItem+=$val['txtJml'];
//Stock Position
		$vLastBal = $oMember->getStockPos('$vUserHO',$val['lmKode'],$val['lmSize'],$val['lmColor']);
		$vNewBal=$vLastBal - $val['txtJml'];
		$vSQL="insert into tb_mutasi_stok(fidmember, fidproduk, fsize,fcolor, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate, fref) ";	  	 	
		$vSQL .="values('$vUserHO','".$val['lmKode']."','".$val['lmSize']."','".$val['lmColor']."','$vBuyer',now(), 'Kit Activation [$vBuyer]',0 ,".$val['txtJml'].",$vNewBal,'KA','1' , '$vUser',now(), '$vNextJual');";//belum selesai
  	 	$db->query($vSQL);
		
  	 	$vSQL="update tb_stok_position set fbalance=fbalance-".$val['txtJml']." where fidmember='$vUserHO' and fidproduk='".$val['lmKode']."';";
		$db->query($vSQL);
  	    
  	    
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



		
		

		
    

    
    $db->query('COMMIT;');
	
	$oSystem->jsAlert("Activation succeed with ID $vNextJual!");

     $oSystem->jsLocation("../manager/kitactive.php");
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
		    if (confirm('Are you sure to activate this KIT?')==true) {
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

    //$('#tfSernoSpon').trigger('blur');
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
   var vURL = "kit_act_ajax.php";
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
 var vURL = "kit_act_ajax.php";
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
   var vURL="../main/mpurpose_ajax.php?op=kitavai";
   var vValid=/sernovalid/g;
   var vNoValid=/sernoinvalid/g;
   $('#loadNama').show();
   $('#statKitSpon').html('&nbsp;<img src="../images/ajax-loader-bar.gif" />');
   $.post(vURL, {serno : pParam.value},function(data) {
	 //  alert(data);
         if (vValid.test(data)) {
            $('#statKitSpon').html('<font color="#00f">KIT Valid!</font>');
			document.getElementById('btnSubmit').disabled=false;
			document.getElementById('btAdd').disabled=false;
		 } else if (vNoValid.test(data)) {   
             $('#statKitSpon').html('<font color="#f00">KIT Not Valid!</font>');
			 document.getElementById('btnSubmit').disabled=true;
			 document.getElementById('btAdd').disabled=true;
		 }
		//  $('#statKitSpon').html('');
   });
   return true;
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
				<h4>
				  <li><a href="javascript:;">KIT Activation</a></li></h4>
				
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">&nbsp;</small></h1>

<form method="post" id="frmReg" name="frmReg" action="<?=$_SERVER['PHP_SELF']?>">
	<div class="container">
    <div class="row" style="width:98%;margin-top:8px;margin-left:-2em">
    
     
    
    
        <div class="col-md-12">
               				<!--Panel Body -->
                     
                     							<!-- <div class="divtr">
                            <!-- Panel Sponsor -->

			                    <div class="panel panel-default" id="panelkanan">
									<div class="panel-heading toska" style="background-color:#1D96B2">
										<div class="panel-title ">
											<label for="exampleInputEmail1" style="font-weight:bold;">
											KIT Data</label></div>
									</div>
									<div class="panel-body">
										<div class="">
											<label for="exampleInputEmail1">Serial Number* 
											<div align="left" style="display:inline" id="statKitSpon">
											</div>
											</label>
											 <div class="input-group">
                                      <span class="input-group-addon"> <i class="fa fa-user"></i></span>
												<input  value="" type="text" class="form-control" id="tfSernoSpon" name="tfSernoSpon" placeholder="KIT Serial Number*" onBlur="checkKitSpon(this)" onKeyUp="setUpper(this)">
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
					        						<label for="exampleInputEmail1" style="font-weight:bold;">Produtcs</label>
					                               <br style="display: block;margin: -5px 0;" />
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
                                <th width="9%" style="text-align:right; height: 23px;"> Qty</th>
                                <th style="width: 173px; height: 23px;text-align:right" > Price</th>
                                <th style="width: 92px; height: 23px;text-align:right" >Sub Total</th>
                                <th width="12%" style="height: 23px">&radic;</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr id="trAdd" style="display:">
                                <th style="width: 33px; height: 30px;">&nbsp;</th>
                                <th width="25%" style="height: 30px;">
                                <select onChange="selectProd(this)" name="lmKode" id="lmKode" class="form-control" style="display:none;width:140px">
								
								<option value="" selected="selected">---Pilih---</option>
								<?
								    $vSQL="select distinct fidproduk, fsize, fidcolor, fnamaproduk, fhargajual1,fhargajual2, fsatuan from  m_product   where  faktif='1'  order by fidproduk";
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
                                <th id="thNama" style="height: 30px" >&nbsp;</th>
                                <th style="height: 30px;text-align:right"> 
                                <input name="txtJml" id="txtJml" class="form-control"  type="text" dir="rtl" style="display:none;min-width:55px;text-align:right" size="10" onKeyUp="calcSub(this)" onBlur="calcSub(this)" >                                
                                
                                </th>
                                <th style="width: 104px; height: 30px;text-align:right" id="thHarga" align="right"></th>
                                <th align="right" id="thSubTot" style="height: 30px; width: 94px;text-align:right"></th>
                                <th align="center" id="thSubTot" style="height: 30px"><input id="btSaveRow" type="button" onClick="return doSaveRow()" class="btn btn-success btn-sm" value="Save Item" style="display:none"/></th>
                                <input type="hidden" name="hSubTot" id="hSubTot" value="" />
                            </tr>
                            <tr>
                                <td style="width: 33px">&nbsp;<input type="hidden"  id="hHarga" name="hHarga" value="">
                                <input type="hidden"  id="hItemSat" name="hItemSat" value="">
                                <input type="hidden"  id="hQoh" name="hQoh" value="">
                                <input type="hidden" name="hJmlItem" id="hJmlItem" value="" /> 
                                </td>
                                <td align="left" style="width: 208px" colspan="2"><input disabled="disabled" id="btAdd" type="button" onClick="doAdd()" class="btn btn-info btn-sm" value="Add Item +"/>&nbsp;<input type="button" onClick="doCancel()" class="btn btn-default btn-sm" value="Cancel" id="btCancel" style="display:none"/></td>
                                <td>&nbsp;</td>
                                <td style="width: 104px">&nbsp;</td>
                                <td style="width: 94px">&nbsp;</td>
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
       <div class="col-lg-4 hide">
       
         <label style="color:blue" for="lmMethod">Metode Pembayaran</label>
         <select name="lmMethod" id="lmMethod" class="form-control">
           <option value="">--Pilih--</option>
           <option value="ctr">Cash / Transfer</option>
           <option value="wpr">Wallet Product</option>
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
	
<? include_once("../framework/admin_bottomjs.blade.php")?>	
	<script>
		$(document).ready(function() {
			App.init();
			Dashboard.init();
		});
	</script>

<? include_once("../framework/admin_footside.blade.php") ; ?>