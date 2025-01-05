<? 

	  //     if ($_GET['op'] != '') 

           include_once("../framework/admin_headside.blade.php");

  //      else

     //      include_once("../framework/member_headside.blade.php") ;  

$bulan = array(
                '01' => 'JANUARI',
                '02' => 'FEBRUARI',
                '03' => 'MARET',
                '04' => 'APRIL',
                '05' => 'MEI',
                '06' => 'JUNI',
                '07' => 'JULI',
                '08' => 'AGUSTUS',
                '09' => 'SEPTEMBER',
                '10' => 'OKTOBER',
                '11' => 'NOVEMBER',
                '12' => 'DESEMBER',
        );

  $vRefURL=$_SERVER['HTTP_REFERER'];
  $vPost = $_POST['hPost'];

   while (list($key,$val)=each($_POST)) {
      $$key = $val;
   }

  if ($tfFFrom=='') $tfFFrom = date('Y-m-d', strtotime('first day of previous month'));
   if ($tfFTo=='') $tfFTo = date('Y-m-d', strtotime('last day of previous month'));


  if ($tfFLevel=='') $tfFLevel ='KOR'; 
  if ($vRefURL=="")
      $oSystem->jsLocation("../main/logout.php");

  


  if (isset($vRefUser))
  	 $vUserChoosed=$vRefUser;
  else	 
  	 $vUserChoosed=$_SESSION['LoginUser'];
	
	


$vAnd = "";
	if ($tfFFrom !='' && $tfFTo !='' )	
		$vAnd .= " and faktif='1' and ftgldepart = '$tfFDepart' "	;

   $vSQL="select  distinct frefer from m_anggota where 1 ";

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script language="Javascript">
function doPost(pParam){
   var vFrom = document.getElementById('tfFFrom').value.split("-").reverse().join("-");	
   var vTo = document.getElementById('tfFTo').value.split("-").reverse().join("-");	
   if (parseFloat(pParam) >0) {
	   if(confirm('Anda yakin melakukan posting bonus SPONSOR periode '+vFrom+' s/d '+vTo+'?')) {
		  document.getElementById('hPost').value='1';
		  document.frmRep.submit();
			 
	   }
   } else alert('Tidak ada bonus yang diposting!');
}

function showDoc(pParam, pNama){
	//alert(pParam);
	event.preventDefault();
	var vMessage='KELENGKAPAN DOKUMEN '+pNama+': \n';
	if(pParam.trim() !='') {
	   var vObj=$.parseJSON(pParam);
	   if (vObj && vObj.fidentfoto34 && vObj.fidentfoto34=='1')
	   	   	vMessage+="Foto 3x4: Sudah\n";
	   else	    		
	   		vMessage+="<font color='#f00'>Foto 3x4: Belum</font>\n";

	   if (vObj && vObj.fidentfoto46 && vObj.fidentfoto46=='1')
	   	   	vMessage+="Foto 4x6: Sudah\n";
	   else	    		
	   		vMessage+="<font color='#f00'>Foto 4x6: Belum</font>\n";
			
	   if (vObj && vObj.fidentformas && vObj.fidentformas=='1')
	   	   	vMessage+="Formulir Asli: Sudah\n";
	   else	    		
	   		vMessage+="<font color='#f00'>Formulir Asli: Belum</font>\n";
			
	   if (vObj && vObj.fidentformfc=='1')
	   	   	vMessage+="Formulir Fotocopy: Sudah\n";
	   else	    		
	   		vMessage+="<font color='#f00'>Formulir Fotocopy: Belum</font>\n";

	   if (vObj && vObj.fidentakteas=='1')
	   	   	vMessage+="Akta Lahir Asli: Sudah\n";
	   else	    		
	   		vMessage+="<font color='#f00'>Akta Lahir Asli: Belum</font>\n";

	   if (vObj && vObj.fidentaktefc=='1')
	   	   	vMessage+="Akta Lahir Fotocopy: Sudah\n";
	   else	    		
	   		vMessage+="<font color='#f00'>Akta Lahir Fotocopy: Belum</font>\n";

	   if (vObj && vObj.fidentpasporas=='1')
	   	   	vMessage+="Akta Lahir Asli: Sudah\n";
	   else	    		
	   		vMessage+="<font color='#f00'>Akta Lahir Asli: Belum</font>\n";
			
	   if (vObj && vObj.fidentpasporfc=='1')
	   	   	vMessage+="Akta Lahir Fotocopy: Sudah\n";
	   else	    		
	   		vMessage+="<font color='#f00'>Akta Lahir Fotocopy: Belum</font>\n";
			

	   if (vObj && vObj.fidentktpas=='1')
	   	   	vMessage+="KTP Asli: Sudah\n";
	   else	    		
	   		vMessage+="<font color='#f00'>KTP Asli: Belum</font>\n";

	   if (vObj && vObj.fidentktpfc=='1')
	   	   	vMessage+="KTP Fotocopy: Sudah\n";
	   else	    		
	   		vMessage+="<font color='#f00'>KTP Fotocopy: Belum</font>\n";

	   if (vObj && vObj.fidentkkas=='1')
	   	   	vMessage+="KK Asli: Sudah\n";
	   else	    		
	   		vMessage+="<font color='#f00'>KK Asli: Belum</font>\n";

	   if (vObj && vObj.fidentkkfc=='1')
	   	   	vMessage+="KK Fotocopy: Sudah\n";
	   else	    		
	   		vMessage+="<font color='#f00'>KK Fotocopy: Belum</font>\n";
	
	   if (vObj && vObj.fidentnikahas=='1')
	   	   	vMessage+="Buku Nikah Asli: Sudah\n";
	   else	    		
	   		vMessage+="<font color='#f00'>Buku Nikah Asli: Belum</font>\n";
	
	   if (vObj && vObj.fidentnikahfc=='1')
	   	   	vMessage+="Buku Nikah Fotocopy: Sudah\n";
	   else	    		
	   		vMessage+="<font color='#f00'>Buku Nikah Fotocopy: Belum</font>\n";
	//Lengkap{"fidentfoto34":"1","fidentfoto46":"1","fidentformas":"1","fidentformfc":"1","fidentakteas":"1","fidentaktefc":"1","fidentpasporas":"1","fidentpasporfc":"1","fidentktpas":"1","fidentktpfc":"1","fidentkkas":"1","fidentkkfc":"1","fidentnikahas":"1","fidentnikahfc":"1"}
		//alert(vMessage);
		$.alert({
			title: 'Kelengkapan Dokumen!',
			content: vMessage.replace(/\n/g,"<br>"),
			onContentReady: function () {
				$(".jconfirm-box").css('height','370x');	
			
			}
		});

	} else {
		vMessage+="<font color='#f00'>Foto 3x4: Belum</font>\n";
		vMessage+="<font color='#f00'>Foto 4x6: Belum</font>\n";
		vMessage+="<font color='#f00'>Formulir Asli: Belum</font>\n";
		vMessage+="<font color='#f00'>Formulir Fotocopy: Belum</font>\n";
		vMessage+="<font color='#f00'>Akta Lahir Asli: Belum</font>\n";
		vMessage+="<font color='#f00'>Akta Lahir Fotocopy: Belum</font>\n";
		vMessage+="<font color='#f00'>KTP Asli: Belum</font>\n";
		vMessage+="<font color='#f00'>KTP Fotocopy: Belum</font>\n";
		vMessage+="<font color='#f00'>KK Asli: Belum</font>\n";
		vMessage+="<font color='#f00'>KK Fotocopy: Belum</font>\n";
		vMessage+="<font color='#f00'>Buku Nikah Asli: Belum</font>\n";
		vMessage+="<font color='#f00'>Buku Nikah Fotocopy: Belum</font>\n";
		
		$.alert({
			title: 'Kelengkapan Dokumen!',
			content: vMessage.replace(/\n/g,"<br>"),
			onContentReady: function () {
				$(".jconfirm-box").css('height','370x');	
			
			}
		});

	}
	
	
}


function showBring(pParam,pNama,pSex){
		//alert(pParam);
		//{"fbawakoper":"1","fbawatpaspor":"1","fbawabukudoa":"1","fbawaikrom":"1","fbawatkabin":"1","fbawakainser":"1","fbawasabuk":"1","fbawalain":"1"}
	event.preventDefault();
	var vMessage='KELENGKAPAN DOKUMEN '+pNama+': \n';
	if(pParam.trim() !='') {
	   var vObj=$.parseJSON(pParam);
	   if (vObj && vObj.fbawakoper && vObj.fbawakoper=='1')
	   	   	vMessage+="Tas Koper: Sudah\n";
	   else	    		
	   		vMessage+="<font color='#f00'>Tas Koper: Belum</font>\n";

	   if (vObj && vObj.fbawatpaspor && vObj.fbawatpaspor=='1')
	   	   	vMessage+="Tas Paspor: Sudah\n";
	   else	    		
	   		vMessage+="<font color='#f00'>Tas Paspor: Belum</font>\n";
			
	   if (vObj && vObj.fbawabukudoa && vObj.fbawabukudoa=='1')
	   	   	vMessage+="Buku Doa: Sudah\n";
	   else	    		
	   		vMessage+="<font color='#f00'>Buku Doa: Belum</font>\n";
			
	   if (pSex=='M') {
		   if (vObj && vObj.fbawaikrom=='1')
				vMessage+="Kain Ikrom: Sudah\n";
		   else	    		
				vMessage+="<font color='#f00'>Kain Ikrom: Belum</font>\n";
	   } else {
		   if (vObj && vObj.fbawabergok=='1')
				vMessage+="Bergo Kecil: Sudah\n";
		   else	    		
				vMessage+="<font color='#f00'>Bergo Kecil: Belum</font>\n";
		   
	   }

	   if (vObj && vObj.fbawatkabin=='1')
	   	   	vMessage+="Tas Kabin: Sudah\n";
	   else	    		
	   		vMessage+="<font color='#f00'>Tas Kabin: Belum</font>\n";

	   if (vObj && vObj.fbawakainser=='1')
	   	   	vMessage+="Kain Seragam: Sudah\n";
	   else	    		
	   		vMessage+="<font color='#f00'>Kain Seragam: Belum</font>\n";
	   if (pSex=='M') { 	
		   if (vObj && vObj.fbawasabuk=='1')
				vMessage+="Sabuk: Sudah\n";
		   else	    		
				vMessage+="<font color='#f00'>Sabuk: Belum</font>\n";
	   } else {
		   if (vObj && vObj.fbawabergob=='1')
				vMessage+="Bergo Besar: Sudah\n";
		   else	    		
				vMessage+="<font color='#f00'>Bergo Besar: Belum</font>\n";
		   
	   }
			

	//Lengkap{"fidentfoto34":"1","fidentfoto46":"1","fidentformas":"1","fidentformfc":"1","fidentakteas":"1","fidentaktefc":"1","fidentpasporas":"1","fidentpasporfc":"1","fidentktpas":"1","fidentktpfc":"1","fidentkkas":"1","fidentkkfc":"1","fidentnikahas":"1","fidentnikahfc":"1"}
		//alert(vMessage);
		$.alert({
			title: 'Kelengkapan Dokumen!',
			content: vMessage.replace(/\n/g,"<br>"),
			onContentReady: function () {
				$(".jconfirm-box").css('height','270px');	
			
			}
		});

	} else {
		vMessage+="<font color='#f00'>Tas Koper: Belum</font>\n";
		vMessage+="<font color='#f00'>Tas Paspor: Belum</font>\n";
		vMessage+="<font color='#f00'>Buku Doa: Belum</font>\n";
		if (pSex=='M') {
			vMessage+="<font color='#f00'>Kain Ikrom: Belum</font>\n";
		} else {
			vMessage+="<font color='#f00'>Bergo Kecil: Belum</font>\n";
		}
		vMessage+="<font color='#f00'>Tas Kabin: Belum</font>\n";
		vMessage+="<font color='#f00'>Kain Seragam: Belum</font>\n";
		if (pSex=='M') { 	
				vMessage+="<font color='#f00'>Sabuk: Belum</font>\n";
		} else {
			vMessage+="<font color='#f00'>Bergo Besar: Belum</font>\n";
		}
	
		
		$.alert({
			title: 'Kelengkapan Dokumen!',
			content: vMessage.replace(/\n/g,"<br>"),
			onContentReady: function () {
				$(".jconfirm-box").css('height','270px');	
			
			}
		});

	}
}
$(document).ready(function(){
		
					  <? if ($oDetect->isMobile()) {?>
					  $('#caption').html('<span data-toggle="tooltip" data-placement="top" title="Mutasi Saldo Cash <?=$oMember->getMemberName($vUserChoosed)?>"><?=substr("Mutasi Cash ".$oMember->getMemberName($vUserChoosed),0,20);?>...</span>');
					  <? } else { ?>
						 $('#caption').html('Mutasi Saldo Cash <?=$vUserChoosed?>');
					  <? } ?>
					$('[data-toggle="tooltip"]').tooltip({tooltipClass:"ttclass"});  
					   /*$('#tfFFrom').datepicker({
										format: "yyyy-mm",
										autoclose : true,
										 viewMode: "months", 
										minViewMode: "months"					
						}).on('changeDate', function (ev) {
									 $(this).datepicker('hide');
						}); */ 
						$('#tfFFrom').datepicker({
										format: "yyyy-mm-dd",
						}).on('changeDate', function (ev) {
									 $(this).datepicker('hide');
						});   					
					  
					 $('#tfFTo').datepicker({
										format: "yyyy-mm-dd",
						}).on('changeDate', function (ev) {
									 $(this).datepicker('hide');
						});  
						
						/*$('#tblMain').DataTable({
							responsive: true,
						 	"language": {
    								"search": "Pencarian Umum:"
  							},
							
							"columnDefs": [
    							{
									"targets": [-1,0,1,2,3],
									 "orderable": false
									
								}
  							],
							
							 dom: 'Bfrtip',
        buttons: [{
             					extend: 'excelHtml5',
								filename: 'ManifestTIKET<?=date("dmy")?>',
								title: 'Manifest TIKET'
						}	, 
			 				{ 
								extend: 'print',
								title: 'Manifest TIKET'
							}
		]
						});*/
						
						
						$( "input[type=search]" ).css("max-width","100px"); 
						$("td").removeClass('sorting_asc');
						/*$( ".sorting" ).css("background","none");
						$( ".sorting_asc" ).css("background","none");
						$( ".sorting_desc" ).css("background","none");	*/		
					
	$('#tblMain').DataTable({
							"pageLength" : 100,
							responsive: true,
						 	"language": {
    								"search": "Pencarian Umum:"
  							},
							
							"columnDefs": [
    							{
									
									//"sType": "numeric", "aTargets": [-1] 
									"targets": [0],
									// "orderable": false,
									 "type": "num"
									
								}
  							],
							
							 dom: 'Bfrtip',
        buttons: [{
             					extend: 'excelHtml5',
								filename: 'BonusSponsorBrgkt<?=$tfFDepart?>',
								title: 'Bonus Sponsor Tanggal Berangkat <?=$tfFDepart?>'
						}	, 
			 				{ 
								extend: 'print',
								title: 'Bonus Sponsor Tanggal Berangkat <?=$tfFDepart?>',
								exportOptions: {
        							stripHtml: false
    							}
							}
		]
  });  
			
});	



	



	

function showDet(pTgl,pDesc,pCred,pDeb,pFullNex,pFullRO,pFullAll,pTax) {

   $('#lblTgl').html(pTgl);

   $('#lblDesc').html(pDesc);

   $('#lblCred').html(pCred);

   $('#lblDeb').html(pDeb);      

   $('#bnsFullNex').html(pFullNex);  

   $('#bnsFullRO').html(pFullRO);  

   $('#bnsFullAll').html(pFullAll);  

   $('#lblTax').html(pTax);





}

</script>


   <script type="text/javascript" src="../js/printThis.js"></script>




<script language="javascript">



   function clearForm() {    



	 document.demoform.dc.value='';



	 document.demoform.dc1.value='';



	 document.demoform.lmPP.selectedIndex=0;



	 document.demoform.tfSearch.value='';



   }



   



   function doSearch() {



     document.demoform.lmPage.selectedIndex=0;



	 document.demoform.submit();



   }

function printPDF() {
  var pdf = new jsPDF('p', 'pt', 'a4');
  pdf.canvas.height = 72 * 11;
  pdf.canvas.width = 72 * 8.5;

  pdf.addHTML(document.body,function() {
        pdf.save('web.pdf');
    });


};


function printRecom(){
	$("[data-role=header], [data-role=footer]")
    	.removeClass("ui-screen-hidden", function () {
    	$.mobile.resetActivePageHeight();
	});
	
	$('#bodypanel').printThis();
	return false;
	
}
     

function savePDF(){
	alert('Print');
	  // var $j=jQuery.noConflict();
	//   $('#buttons').hide();
         
	   var opt = {
			 // margin:       3,
			  filename:     'COB-MC190509000019.pdf',
			//  image:        { type: 'jpeg', quality: 1 },
		//	 html2canvas:  { scale: 0.65},
			//  jsPDF:        { unit: 'cm', format: 'a4', orientation: 'portrait' }
		};
		
		var element = document.getElementById('content');
		//html2pdf(element,opt);
		html2pdf().set(opt).from(element).save();

	//	setTimeout($j('#buttons').show(), 15000);
}	 


</script>











<style type="text/css">
@print{
    @page :footer {color: #fff  !important}
    @page :header {color: #fff !important}
}

@media print {
  @page { margin: 0 !important; }
  body { margin: 1.6cm !important; }
}

.style1 {	color: #000000;
	font-weight: bold;
}
.style4 {color: #000000}
table td {
	padding:3px 3px 3px 3px;
}
.auto-style1 {
	font-weight: bold;
}

  .headmani {
	padding:0px 0px 0px 0px !important;
  }
  
  .bottomline {
	   border-bottom:2px solid black !important;  
  }
  
.table, .table td , .table th{
    border: black solid 1px !important;
	border-collapse:collapse !important;
}

  .noborder{
	border-left:1px solid red !important;
	border-collapse:collapse !important;
  }
.mid {
	  vertical-align:middle !important;
}
</style>










<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.css"/>
 

 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />


<div class="right_col" role="main">
<div class="row">
		<div><label>
		<h3>Bonus Sponsor berdasarkan Tanggal Berangkat Non SP</h3></label></div>  		       

<div class="col-lg-12"  >

      <form name="frmRep"  method="post" id="frmRep" style="color:black" >
        <div class="row"> 
               <div class="col-lg-2">
               <b> Tanggal Berangkat</b>  </div>
              <div class="col-lg-2">
               <select name="tfFDepart" id="tfFDepart" class="form-control">
               <option value="">--Pilih--</option>
               <?
               		$vSQLDep="select distinct ftgldepart from m_anggota where ftgldepart <> ''  order by ftgldepart ";
					$dbin->query($vSQLDep);
					while($dbin->next_record()) {
			   ?>
               <option <? if($_POST['tfFDepart']==$dbin->f('ftgldepart')) echo 'selected'; ?> value="<?=$dbin->f('ftgldepart')?>"><?=$dbin->f('ftgldepart')?></option> 
               <? } ?>
               </select>
          		<input type="hidden" name="hPost" id="hPost" value="" />
              </div>
       
 
              
       
        </div>
 
 
 <div class="row hide"> 
               <div class="col-lg-2">
               <b> Korwil / Subkorwil</b>  </div>
              <div class="col-lg-2">
               <select name="tfFLevel" id="tfFLevel" class="form-control">
               
               <option value="KOR" <? if ($tfFLevel=='KOR') echo 'selected'  ?>>Korwil</option>
               <option value="SUBKOR" <? if ($tfFLevel=='SUBKOR') echo 'selected'  ?>>Sub Korwil</option>
              
               </select>
          		</div>
       
 
              
          </div>
        
        
          <div>&nbsp;</div>
        <div class="row"> 

              
              <div class="col-lg-1">
              <button type="button" id="btnSubmit" name="btnSubmit" class="btn btn-success" onclick="document.frmRep.submit()">Submit</button>
          </div>
          <div class="col-lg-1">
              <button type="button" id="btnClear" name="btnClear" class="btn btn-default" onclick="$('#tfFMonth').val('');$('#tfFDepart').val('');$('#tfFDoc').val('');$('#tfFBring').val('');">Clear</button>
          </div>
       
        </div>
      
        <br>
        
    <?
            if ($vPost=='1') {
				$vSQLCheck = "select * from tb_komisi where '$tfFFrom' between fdfrom and fdto and fkind='SPON'  ";
				$dbin1->query($vSQLCheck);
				$dbin1->next_record();
				$vRowFrom = $dbin1->num_rows();
	
			 	$vSQLCheck = "select * from tb_komisi where '$tfFTo' between fdfrom and fdto and fkind='SPON'  ";
				$dbin1->query($vSQLCheck);
				$dbin1->next_record();
				$vRowTo = $dbin1->num_rows();
				
				if ($vRowFrom >0 || $vRowTo >0)  {
					
					$oSystem->jsAlert("Posting gagal. Tanggal yang Anda pilih sudah berada pada periode posting sebelumnya. Silakan pilih periode lainnya!");
					$oSystem->jsLocation($_SERVER['HTTP_REFERER']);
					exit;
					
				}
			}
		
		?>     
<label>Syarat bonus program</label>
<?
$vSQLProg = "select * from m_program order by fidprogram ";
		$dbin1->query($vSQLProg);
		while($dbin1->next_record()) {
				$vIDProg = $dbin1->f('fidprogram');
				$vNama = $dbin1->f('fnama');
				$vSyaratSA = $dbin1->f('fsyaratsa');
				$vSyaratLns = $dbin1->f('fsyaratlns');
								
?>

<div class="row">
<div class="col-lg-2">
<?=$vNama?>
</div>

<div class="col-lg-4">
<?
   if ($vSyaratLns !=0) {
	 echo "Lunas";   
   } else {
	 echo "Setoran Awal ".number_format($vSyaratSA,0,",",".");     
   }
?>
</div>
</div>
<? } ?>
<br />        
<div class="table-responsive">
<table class="table table-striped table-bordered " id="tblMain" cellpadding="0" cellspacing="0" style="width:100%">
<thead>
<tr style="font-weight:bold">
  <td width="32" align="center" class="mid" style="width:20px">NO</td>
 
  <td  width="113" align="center" nowrap="nowrap">ID Pebisnis</td>
  <td  width="155" align="center">Nama Pebisnis</td>
  <td  width="174" align="center">Jml Sponsor Jamaah </td>
  <td  width="215" align="center">Bonus per Jamaah</td>
  <td  width="145" align="center">Total</td>
  
  </tr>
</thead>
  <tbody>      
        <?
             $db->query($vSQL);
			 $vCount=0;$vTotal=0;$vGrandTot=0;
			 if ($vPost=='1')
			    $dbin1->query('START TRANSACTION;');

			 while($db->next_record()) {
				 $vCount++;
					 
				 $vRefer = $db->f('frefer');
				 $vSQLNama = "select kode,nama from tmmember where kode ='$vRefer'";
				 $oDBAMHT->query($vSQLNama);
				 $oDBAMHT->next_record();
				 $vNamaRefer = $oDBAMHT->f('nama');

			
				 				 
				 if (true) {
				 
		?>
        <tr style="color:<?=$vColor?>"><td style="text-align: right;vertical-align:middle" valign="middle" ><?=$vCount?></td>
          <td valign="middle" style="vertical-align:middle"><?=strtoupper($vRefer)?> </td>
          <td align="left" valign="middle" style="vertical-align:middle"><?=strtoupper($vNamaRefer)?></td>
          <td align="left" valign="middle" style="vertical-align:middle">
		  
		  <?
		  
		   
						$vTotal=0;
						
						$vSQLPack = "select * from m_paket order by fpackid ";
						$db1->query($vSQLPack);
						while($db1->next_record()) {
							$vIDPaket = $db1->f('fpackid');
							$vSQLProg = "select * from m_program where fidprogram <> '4' order by fidprogram ";
							$dbin1->query($vSQLProg);
							  while($dbin1->next_record()) {
									$vIDProg = $dbin1->f('fidprogram');
									$vSyaratSA = $dbin1->f('fsyaratsa');
									$vSyaratLns = $dbin1->f('fsyaratlns');
									
								if ($vSyaratLns !=0) {												
									$vSQLKTP = "select count(fidmember) as fjml from m_anggota where frefer='$vRefer'  and fprogram='$vIDProg'  and fpaket='$vIDPaket' and flunas > 0 $vAnd ";
								} else {
									$vSQLKTP = "select count(fidmember) as fjml from m_anggota where frefer='$vRefer'  and fprogram='$vIDProg'  and fpaket='$vIDPaket' and fstorawal >= $vSyaratSA  $vAnd ";
								}
								
								
								$dbin->query($vSQLKTP);
								$dbin->next_record();
								$vJml = $dbin->f('fjml');
								echo $db1->f('fpackname')."-".$dbin1->f('fnama').": ";
								echo number_format($vJml,0,",",".");
								echo "<br>";

								
							}
						}
		  
		  
		  ?></td>
          <td align="left" valign="middle" style="vertical-align:middle">
		  <?  
		  
						$vSQLPack = "select * from m_paket order by fpackid ";
						$db1->query($vSQLPack);
						while($db1->next_record()) {
							$vIDPaket = $db1->f('fpackid');
							$vSQLProg = "select * from m_program where fidprogram <> '4'  order by fidprogram ";
							$dbin1->query($vSQLProg);
							  while($dbin1->next_record()) {
									$vIDProg = $dbin1->f('fidprogram');
									$vSyaratSA = $dbin1->f('fsyaratsa');
									$vSyaratLns = $dbin1->f('fsyaratlns');
									
								if ($vSyaratLns !=0) {									
									$vSQLKTP = "select count(fidmember) as fjml from m_anggota where frefer='$vRefer' and fprogram='$vIDProg' and fpaket='$vIDPaket'  and flunas >0 $vAnd ";
								} else {
									$vSQLKTP = "select count(fidmember) as fjml from m_anggota where frefer='$vRefer' and fprogram='$vIDProg' and fpaket='$vIDPaket'  and fstorawal >= $vSyaratSA $vAnd ";
								}
								
								
								$dbin->query($vSQLKTP);
								$dbin->next_record();
								$vJml = $dbin->f('fjml');
															
							     //getBnsSetting($pJenis,$pProgram, $pLevel='') 
								$vBonus =  $oRules->getBnsSetting('SPON',$vIDProg, $tfFLevel,$vIDPaket) ;
								$vTotal += $vJml * $vBonus;
								
								echo $db1->f('fpackname')."-".$dbin1->f('fnama').": ";
								echo number_format($vBonus,0,",",".");
								echo "<br>";

								
							}
						}
		  
		  ?></td>
          <td align="right" valign="middle" style="vertical-align:middle">
		 <? 
					 
					 $vGrandTot+= $vTotal; 		
		      echo  number_format($vTotal,0,",","."); 
		 	 $vRef="POSTSPON-".date("Ymd-His");
			  if ($vPost =='1' && $vTotal >0) {
				  
				  $vSQLBis="select fidbisnis from m_korwil where fidkorwil='$vIDKorwil' ";
				  $db1->query($vSQLBis);
				  $db1->next_record();
				  $vIDBisnis=$db1->f('fidbisnis');
				  $vByyAdmin = $oRules->getSettingByField('fbyyadmin');
				  $vNetto = $vTotal - ($vTotal * $vByyAdmin / 100);
				  $vFromKet = $oPhpdate->YMD2DMY($tfFFrom);
				  $vToKet = $oPhpdate->YMD2DMY($tfFTo);
				  
				  
				 $vSQL="INSERT INTO tb_komisi(fdfrom, fdto, fidmember, fidfunder, famount, fkind, ffeestatus, fdesc, fref, ftanggal, flevel,fnetto) ";
				 $vSQL .= "VALUES ( '$tfFFrom','$tfFTo','$vRefer', 'system',$vTotal , 'SPON', '0', 'Bonus Sponsor Periode $vFromKet s/d $vToKet', '$vRef',now(),'',$vNetto );";  
				 
				 $dbin->query($vSQL);
			  }			  
		   
		   ?></td>
        
          </tr>
        <? } } ?>
        
        <tr style="color:<?=$vColor?>">
          <td valign="middle" style="text-align: right;vertical-align:middle" >&nbsp;</td>
          <td valign="middle" style="text-align: right;vertical-align:middle" >&nbsp;</td>
          <td valign="middle" style="text-align: right;vertical-align:middle" >&nbsp;</td>
          <td valign="middle" style="text-align: right;vertical-align:middle" >&nbsp;</td>
          <td valign="middle" style="text-align: right;vertical-align:middle" ><strong>Grand Total</strong></td>
          <td align="right" valign="middle" style="vertical-align:middle"><?=number_format($vGrandTot,0,",",".")?></td>
        </tr>
        
<?		
		
		 if ($vPost=='1') {
			    if($dbin1->query("COMMIT;")) {
				   $oSystem->jsAlert("Posting bonus Sponsor berhasil!");	
				   $oSystem->jsLocation($_SERVER['HTTP_REFERER']);
				}
				   
			 }?>             
             
             </tbody>
        </table>

	</div>





</form>

 
   
   <button id="btnBack" type="button" class="btn btn-success hide"  onClick="doPost(<?=$vGrandTot?>)"><li class="fa fa-download"></li> Post</button>









      









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
</div>
</div>

	<!-- end page container -->
	</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
<!--<script src="../vendors/datatables.net/js/jquery.dataTables.js"></script>-->
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>










<? include_once("../framework/member_footside.blade.php") ; ?>