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



  if ($vRefURL=="")
      $oSystem->jsLocation("../main/logout.php");

  


  if (isset($vRefUser))
  	 $vUserChoosed=$vRefUser;
  else	 
  	 $vUserChoosed=$_SESSION['LoginUser'];


$vFMonth = $_POST['tfFMonth'];
$vFDepart = $_POST['tfFDepart'];

$vAnd = "";
if ($vFMonth!='') 
     $vAnd .= " and DATE_FORMAT(ftgldaftar,'%Y-%m') = '$vFMonth' ";
if ($vFDepart!='') 
     $vAnd .= " and ftgldepart = '$vFDepart' ";



  //$vAnd .= " and ftgldepart = '$vFDepart'  and  DATE_FORMAT(ftgldaftar,'%Y-%m') = '$vFMonth '";

   $vSQL="select  * from m_anggota where 1  $vAnd ";

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
					
					  
					 $('#tfFDepart').datepicker({
										format: "yyyy-mm-dd",
						}).on('changeDate', function (ev) {
									 $(this).datepicker('hide');
						});  
						
						$('#tblMain').DataTable({
							responsive: true,
						 	"language": {
    								"search": "Pencarian Umum:"
  							},
							
							"columnDefs": [
    							{
									"targets": [-1,0,1,2,3,4,5,6,7,8,9,10,11],
									 "orderable": false
									
								}
  							],
							
							 dom: 'Bfrtip',
        buttons: [{
             					extend: 'excelHtml5',
								filename: 'ManifestSIPATUH<?=date("dmy")?>',
								title: 'Manifest SIPATUH'
						}	, 
			 				{ 
								extend: 'print',
								title: 'Manifest SIPATUH'
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
		<h3>Manifest SIPATUH</h3></label></div>  		       

<div class="col-lg-12"  >

      <form name="demoform"  method="post" id="demoform" style="color:black" >
        <div class="row"> 
               <div class="col-lg-1">
               <b> Filter Bulan Daftar</b>  </div>
              <div class="col-lg-2">
               <input name="tfFMonth" id="tfFMonth" type="text" class="form-control"  value="<?=$vFMonth?>"/>
          </div>
       
        </div>
        <div>&nbsp;</div>
        <div class="row"> 
               <div class="col-lg-1">
               <b> Filter Tgl. Berangkat </b>  </div>
              <div class="col-lg-2">
               <input name="tfFDepart" id="tfFDepart" type="text" class="form-control" value="<?=$vFDepart?>" />
          </div>
       
        </div>
        
          <div>&nbsp;</div>
        <div class="row"> 

              
              <div class="col-lg-1">
              <button type="button" id="btnSubmit" name="btnSubmit" class="btn btn-success" onclick="document.demoform.submit()">Submit</button>
          </div>
       
        </div>
      
        <br>
        
        
<div class="table-responsive">
<table class="table table-striped table-bordered " id="tblMain" cellpadding="0" cellspacing="0">
<thead>
<tr style="font-weight:bold">
  <td align="center" style="width:20px" class="mid">NO</td>
  <td align="center" width="475" class="mid">Nama</td>
  <td align="center"  >Sex<br />
    M/F</td>
  
  <td width="75" align="center">Country<br />
    Code</td>
  <td  width="150" align="center">Passport<br />
    
    No</td>
  <td width="150" align="center">Place<br />
    Date&nbsp;of&nbsp;Birth</td>
  <td align="center" valign="middle" style="padding-top:15px;width:25px">UMUR</td>
  <td align="center" valign="middle" style="padding-top:15px;width:25px">Date<br /> of&nbsp;Expiry</td>
  <td align="center" valign="middle" style="padding-top:15px;width:25px">Date<br /> of&nbsp;Issue</td>
  <td align="center" valign="middle" style="padding-top:15px;width:25px">Issuing Office</td>
  <td align="center" valign="middle" style="padding-top:15px;width:25px">Relationship</td>
  <td align="center" valign="middle" style="padding-top:15px;width:25px">Keterangan</td>
  <td align="center" valign="middle" style="padding-top:15px;width:25px">NIK</td>
  <td align="center" valign="middle" style="padding-top:15px;width:25px">Pendidikan<br />Terakhir</td>
  <td align="center" valign="middle" style="padding-top:15px;width:25px">Pekerjaan</td>
</tr>
</thead>
  <tbody>      
        <?
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
		?>
        <tr style="color:<?=$vColor?>"><td style="text-align: right;vertical-align:middle" valign="middle" ><?=$vCount?></td>
          <td valign="middle" style="vertical-align:middle"><?=strtoupper($vNama)?></td>
          <td align="center" valign="middle" style="vertical-align:middle"><?=$vSex?></td>
          <td align="center" valign="middle" style="vertical-align:middle"><?=$vCntPass?></td>
          <td align="center" valign="middle" style="vertical-align:middle"><?=$vPassno ?></td>
          <td  align="center" class="headmani"><div style="border-bottom:2px solid #000"><?=strtoupper($vPOB)?></div><div>            <?=strtoupper($vDOB)?></div></td><td style="text-align: right;vertical-align:middle" valign="middle">
          <?
                 echo $vAge = floor((time() - strtotime($vDOBOri)) / 31556926);
		  ?>
          </td>
          <td style="text-align: center;vertical-align:middle" valign="middle" nowrap="nowrap"><span style="vertical-align:middle">
            <?=$vPassExp ?>
          </span></td>
          <td style="text-align: center;vertical-align:middle" valign="middle" nowrap="nowrap"> <?=$vPassIssue ?></td>
          <td style="text-align: left;vertical-align:middle" valign="middle"> <?=$db->f('fpassoffice') ?></td>
          <td style="text-align: left;vertical-align:middle" valign="middle"><?=$db->f('frelation') ?></td>
          <td style="text-align: left;vertical-align:middle" valign="middle"><?=$db->f('fket') ?></td>
          <td style="text-align: left;vertical-align:middle" valign="middle"><?=$db->f('fnik') ?></td>
          <td style="text-align: left;vertical-align:middle" valign="middle"><?=$db->f('feducation') ?></td>
          <td style="text-align: left;vertical-align:middle" valign="middle"><?=$db->f('fjob') ?></td>
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