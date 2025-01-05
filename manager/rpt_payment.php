<? 


           include_once("../framework/admin_headside.blade.php");


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



  if ($vRefURL=="")
      $oSystem->jsLocation("../main/logout.php");

  


  if (isset($vRefUser))
  	 $vUserChoosed=$vRefUser;
  else	 
  	 $vUserChoosed=$_SESSION['LoginUser'];


$vFPaket = $_POST['fpaket'];
$vFDepart = $_POST['tfFDepart'];
$vFHarga  = $_POST['fprice'];
$vFAirport  = $_POST['fairporttax'];
$vFAssure  = $_POST['fassure'];
$vFStatus  = $_POST['fstatus'];
$vFIDNama  = $_POST['tfFIDNama'];

$vAnd = "";
if ($vFPaket!='') 
     $vAnd .= " and fpaket = '$vFPaket' ";
if ($vFDepart!='') 
     $vAnd .= " and ftgldepart = '$vFDepart' ";
if ($vFHarga!='') 
     $vAnd .= " and fprice = '$vFHarga' ";

if ($vFAirport!='') 
     $vAnd .= " and fairporttax = '$vFAirport' ";

if ($vFAssure!='') 
     $vAnd .= " and fassure = '$vFAssure' ";
	 
if ($vFStatus!='') {
     if ($vFStatus=='0')
	 	$vAnd .= " and (ftotalbayar < fprice or ftotalbayar=0) ";	
	 else  if ($vFStatus=='1')
	 $vAnd .= " and ftotalbayar >= fprice and ftotalbayar >0 ";	
		
}

if ($vFIDNama!='') 
     $vAnd .= " and fidmember like  '%$vFIDNama%' or fnama like  '%$vFIDNama%' ";

  //$vAnd .= " and ftgldepart = '$vFDepart'  and  DATE_FORMAT(ftgldaftar,'%Y-%m') = '$vFMonth '";

  

?>


<script language="Javascript">



$(document).ready(function(){		
					  <? if ($oDetect->isMobile()) {?>
					  $('#caption').html('<span data-toggle="tooltip" data-placement="top" title="Mutasi Saldo Cash <?=$oMember->getMemberName($vUserChoosed)?>"><?=substr("Mutasi Cash ".$oMember->getMemberName($vUserChoosed),0,20);?>...</span>');
					  <? } else { ?>
						 $('#caption').html('Mutasi Saldo Cash <?=$vUserChoosed?>');
					  <? } ?>
					$('[data-toggle="tooltip"]').tooltip({tooltipClass:"ttclass"});  
					   $('#tfFMonth').datepicker({
										format: "yyyy-mm",
										autoclose : true,
										 viewMode: "months", 
										minViewMode: "months"					
						}).on('changeDate', function (ev) {
									 $(this).datepicker('hide');
						});  
					
					  
	/*				 $('#tfFDepart').datepicker({
										format: "yyyy-mm-dd",
						}).on('changeDate', function (ev) {
									 $(this).datepicker('hide');
						});  */
						
						$('#tblMain').DataTable({
							responsive: true,
						 	"language": {
    								"search": "Pencarian Umum:"
  							},
							
							"columnDefs": [
    							{
									"targets": [-1,0,1,2,3,4,5,6,7,8,9],
									 "orderable": false
									
								}
  							],
							
							 dom: 'Bfrtip',
        buttons: [{
             					extend: 'excelHtml5',
								filename: 'FinanceReport<?=date("dmy")?>',
								title: 'Laporan Pembayaran (Keberangkatan <?=$vFDepart?>)'
						}	, 
			 				{ 
								extend: 'print',
								title: 'Laporan Pembayaran (Keberangkatan <?=$vFDepart?>)'
							}
		]
						});
						
						
						$( "input[type=search]" ).css("max-width","100px"); 
						$("td").removeClass('sorting_asc');
						/*$( ".sorting" ).css("background","none");
						$( ".sorting_asc" ).css("background","none");
						$( ".sorting_desc" ).css("background","none");	*/		
					
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

function clearFilter() {
	$('#tfFDepart').val('');
	$('#fpaket').val('');
	$('#fprice').val('');
	$('#fairporttax').val('');
	$('#fassure').val('');
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
		<h3>Laporan Pembayaran</h3></label></div>  		       

<div class="col-lg-12"  >

      <form name="demoform"  method="post" id="demoform" style="color:black" >
        
        <div>&nbsp;</div>
        <div class="row"> 
               <div class="col-lg-2">
           <b>  Tgl. Keberangkatan </b>  </div>
              <div class="col-lg-2">
              
               
               <select name="tfFDepart" id="tfFDepart" class="form-control">
               <option value="">--Pilih--</option>
               <?
               		$vSQL="select distinct ftgldepart from m_anggota where faktif='1'  and ftgldepart <> ''  order by ftgldepart ";
					$dbin->query($vSQL);
					while($dbin->next_record()) {
			   ?>
               <option <? if($_POST['tfFDepart']==$dbin->f('ftgldepart')) echo 'selected'; ?> value="<?=$dbin->f('ftgldepart')?>"><?=$dbin->f('ftgldepart')?></option> 
               <? } ?>
               </select>
          </div>
       
        </div>
        
          <div>&nbsp;</div>
          
<div class="row"> 
               <div class="col-lg-2">
               <b> Status Pembayaran</b></div>
              <div class="col-lg-2">
                  <select class="form-control m-bot15" id="fstatus" name="fstatus">
                                <option  value=""  >--Pilih / Choose--</option>
                                <option  value="0" <? if($_POST['fstatus']=='0') echo 'selected'; ?> >Belum Lunas</option>
                                <option  value="1" <? if($_POST['fstatus']=='1') echo 'selected'; ?> >Sudah Lunas</option>
								
                            </select>
          </div>
       
        </div>
         <div>&nbsp;</div>
<div class="row"> 
               <div class="col-lg-2">
               <b> Filter ID / Nama</b>  </div>
              <div class="col-lg-2">
               <input autocomplete="false" name="tfFIDNama" id="tfFIDNama" type="text" class="form-control"  value="<?=$vFIDNama?>"/>
          		</div>
       
 
               
              
       
        </div>        

<div>&nbsp;</div>
                

           
        
         <div class="row">&nbsp; </div>         
        <div class="row"> 

              
              <div class="col-lg-2">
              <button type="button" id="btnSubmit" name="btnSubmit" class="btn btn-success" onclick="document.demoform.submit()">Submit</button>
              <button type="button" id="btnClear" name="btnClear" class="btn btn-default" onclick="clearFilter()">Reset</button>
          </div>
       
        </div>
      
        <br>
        
        
<div class="table-responsive">
<table class="table table-striped table-bordered " id="tblMain" cellpadding="0" cellspacing="0">
<thead>
<tr style="font-weight:bold">
  <td align="center" style="width:20px" class="mid">NO</td>
  <td align="center" width="475" class="mid">Nama Lengkap</td>
  <td align="center"  >No. ID </td>
  
  <td width="75" align="center">Referensi</td>
  <td  width="150" align="center">Harga</td>
  <td  width="150" align="center">Setoran Awal, Handle, Asuransi </td>
  <td align="center" valign="middle" style="padding-top:15px;width:25px" nowrap>Angsuran 1</td>
  <td align="center" valign="middle" style="padding-top:15px;width:25px" nowrap>Angsuran 2</td>
  <td align="center" valign="middle" style="padding-top:15px;width:25px" nowrap>Angsuran 3</td>
  <td align="center" valign="middle" style="padding-top:15px;width:25px" nowrap>Angsuran 4</td>
  <td align="center" valign="middle" style="padding-top:15px;width:25px" nowrap>Voucher</td>
  <td align="center" valign="middle" style="padding-top:15px;width:25px" nowrap>Pelunasan</td>
  <td align="center" valign="middle" style="padding-top:15px;width:25px">Total Pembayaran</td>
  </tr>
</thead>
  <tbody>      
        <?
              $vSQL="select  * from m_anggota where faktif='1'  $vAnd ";
			 $db->query($vSQL);
			 $vCount=0;
			 
			 
			 while($db->next_record()) {
				 $vCount++;
				 $vNama = $db->f('fnama');
				 $vSex = $db->f('fsex');
				 $vColor= $vSex=='F'?'red':'black';
				 $vCntPass = $db->f('fpasscntid');
				 $vPassno = $db->f('fpaspor');
				 $vPOB = $db->f('ftempat');
				 $vDOB = $oPhpdate->YMD2DMY($db->f('ftgllahir'));
				 $vDOBOri = $db->f('ftgllahir');
				 $vPassExp = $oPhpdate->YMD2DMY($db->f('fpassexpired'));
				 $vPassIssue = $oPhpdate->YMD2DMY($db->f('fpassrelease'));
				 $vTotBayar = $db->f('fstorawal') +$db->f('fassure') + $db->f('farabassure')+$db->f('fairporttax') +$db->f('fangsur1') + $db->f('fangsur2') + $db->f('fangsur3') + $db->f('fangsur4') + $db->f('fangsur5') + $db->f('flunas');
				 //$vTotBayar=$db->f('ftotalbayar');
				 $vHarga = $db->f('fprice');
				 if ($vTotBayar<$vHarga || $vTotBayar==0) {
					$vColor = "background-color:red"; 
				 }
		?>
        <tr style="<?=$vColor?>" ><td style="text-align: right;vertical-align:middle" valign="middle" ><?=$vCount?></td>
          <td valign="middle" style="vertical-align:middle"><?=strtoupper($vNama)?></td>
          <td align="center" valign="middle" style="vertical-align:middle" nowrap="nowrap"><?=$db->f('fidmember')?></td>
          <td align="center" valign="middle" style="vertical-align:middle"><?=$db->f('frefer')?></td>
          <td align="right" valign="middle" style="vertical-align:middle"><?=number_format($vHarga,0,",",".") ?></td>
          <td align="right" valign="middle" style="vertical-align:middle"><?=number_format($db->f('fstorawal')+$db->f('fassure')+$db->f('fairporttax')+$db->f('farabassure'),0,",",".") ?></td>
          <td style="text-align: right;vertical-align:middle" valign="middle"><span style="vertical-align:middle">
            <?=number_format($db->f('fangsur1'),0,",",".") ?>
          </span></td>
          <td style="text-align: right;vertical-align:middle" valign="middle" nowrap="nowrap"><span style="vertical-align:middle">
            <?=number_format($db->f('fangsur2'),0,",",".") ?>
          </span></td>
          <td style="text-align: right;vertical-align:middle" valign="middle" nowrap="nowrap"><span style="vertical-align:middle">
            <?=number_format($db->f('fangsur3'),0,",",".") ?>
          </span></td>
          <td style="text-align: right;vertical-align:middle" valign="middle"><span style="vertical-align:middle">
            <?=number_format($db->f('fangsur4'),0,",",".") ?>
          </span></td>
          <td style="text-align: right;vertical-align:middle" valign="middle"><span style="vertical-align:middle">
            <?=number_format($db->f('voucher'),0,",",".") ?>
          </span></td>
          <td style="text-align: right;vertical-align:middle" valign="middle"><span style="vertical-align:middle">
            <?=number_format($db->f('flunas'),0,",",".") ?>
          </span></td>
          <td style="text-align: right;vertical-align:middle" valign="middle"><span style="vertical-align:middle">
            <?
          
		  	//number_format($db->f('ftotalbayar'),0,",",".");
			 $vSQL = "select coalesce(sum(fcredit),0) as other from tb_payhist where fidmember='".$db->f('fidmember')."' and fkind in('handle','assure','arabassure')";
			$dbin->query($vSQL);
			$dbin->next_record();
			$vOtherPay =  $dbin->f('other');
			$vOtherMem = $db->f('fassure')+$db->f('fairporttax')+$db->f('farabassure');
			
			
		  	$vSQL = "select sum(fcredit) as total from tb_payhist where fidmember='".$db->f('fidmember')."'";
			$dbin->query($vSQL);
			$dbin->next_record();
			
			$vTotal = $dbin->f('total');
			if ($vOtherPay==0)
				$vTotal += $vOtherMem;
			echo number_format($vTotal,0,",",".");
			

		  ?>
          </span></td>
          </tr>
        <? } ?>
        </tbody>
        </table>

	</div>





</form>

 
   <button id="btnBack" type="button" class="btn btn-default"  onClick="document.location.href='<?= $_SESSION['refer'] ?>&choosed=<?=$vRefUser?>'">Back</button>









      









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
