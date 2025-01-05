<? 

	       if ($_GET['op'] != '') 

           include_once("../framework/admin_headside.blade.php");

        else

           include_once("../framework/member_headside.blade.php") ;  

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

  $vRefUser=$_GET['uMemberId'];
  $vUser=$_SESSION['LoginUser'];
  $vSpy = md5('spy').md5($_GET['uMemberId']);
   if ($_GET['op']==$vSpy)
      $vUserChoosed=$_GET['uMemberId'];




  $vNama = $oMember->getMemberName($vUserChoosed);
  $vAlamat = $oMember->getMemField('falamat',$vUserChoosed);
  $vKab = $oMember->getMemField('fkota',$vUserChoosed);
  $vProp = $oMember->getMemField('fprop',$vUserChoosed);
  $vKab = $oMember->getWilName('ID',$vProp,$vKab,'00','00');
  $vNoKTP  = $oMember->getMemField('fnoktp',$vUserChoosed);


  if (isset($vRefUser))
  	 $vUserChoosed=$vRefUser;
  else	 
  	 $vUserChoosed=$_SESSION['LoginUser'];







 $vPage=$_POST['lmPage'];	 



    if ($vPage=="") $vPage=1;







 $vStart=$_POST['dc'];$vEnd=$_POST['dc1'];



 



 $vStartString=$vStart." 00:00:00";



 $vEndString=$vEnd." 23:59:59";



 $vSearch=$_POST['tfSearch'];







 $vCrit="";$vFilterText="";



 if ($vStart!="" || $vEnd!="") {



	    $vCrit.=" and ftanggal >= '$vStartString' and ftanggal <= '$vEndString' " ;

	    $vFilterText.="[Date: $vStartString - $vStartString]";

}



 if ($vSearch!="")	{	



        $vCrit.=" and fdesc like '%$vSearch%' ";

	    $vFilterText.="[Description: $vSearch]";

}        







  $vSQL="select count(*) as fjumrec from tb_mutasi where fkind in('spon','pairing','pres','resetday','resetweek','resetmonth','unile') and fidmember='$vUserChoosed' $vCrit";



 



  	 // echo "xxx";



 //exit;	



 $db->query($vSQL);



 $db->next_record();



 



 $vJumRec=$db->f("fjumrec");



 $vRecPerPage=$_POST['lmPP'];



 if ($vRecPerPage=="") $vRecPerPage=25;



 $vRecPerPage;



 $vJumPage=ceil($vJumRec / $vRecPerPage);



 $vOffset=($vPage-1) *  $vRecPerPage ;



// $oKomisi->delZeroMut();



 $vByy=	 $oRules->getSettingByField('fbyyadmin');

 $vPersenRO=$oRules->getSettingByField('fprosenauto');

 $vPersenNex=$oRules->getSettingByField('fprosencash');



?>











<script language="Javascript">



$(document).ready(function(){



  <? if ($oDetect->isMobile()) {?>

  $('#caption').html('<span data-toggle="tooltip" data-placement="top" title="Mutasi Saldo Cash <?=$oMember->getMemberName($vUserChoosed)?>"><?=substr("Mutasi Cash ".$oMember->getMemberName($vUserChoosed),0,20);?>...</span>');

  <? } else { ?>

	 $('#caption').html('Mutasi Saldo Cash <?=$vUserChoosed?>');

  <? } ?>

      

$('[data-toggle="tooltip"]').tooltip({tooltipClass:"ttclass"});  



     







   $('#dc').datepicker({



                    format: "yyyy-mm-dd",



                    autoclose : true



    }).on('changeDate', function (ev) {

    $(this).datepicker('hide');

    });  

  



    



       $('#dc1').datepicker({



                    format: "yyyy-mm-dd",



                    autoclose : true



    }).on('changeDate', function (ev) {

    $(this).datepicker('hide');

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
</style>











 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />


<div class="right_col" role="main">

		<div><label>
		<h3>Rekomendasi Pengurusan Paspor <?=$vRefUser." / ".$oMember->getMemberName($vRefUser);?></h3></label></div>  		       

<div class="col-lg-12"  >

      <form name="demoform" method="post" id="demoform" style="color:black" >


      <div class="panel panel-default">
        <?
             $vSQL="select * from tb_recomm where fdefault='1' ";
			 $db->query($vSQL);
			 $db->next_record();
			 $vContent = $db->f('fcontent');
			 $vContent = str_replace("{TGL}",date("d"),$vContent);
			 $vContent = str_replace("{BLN}",ucwords(strtolower($bulan[date("m")])),$vContent);
			 $vContent = str_replace("{THN}",date('Y'),$vContent);
			 $vContent = str_replace("{NAMA}",$vNama,$vContent);
			 $vContent = str_replace("{ALAMAT}",$vAlamat,$vContent);
			 $vContent = str_replace("{NOKTP}",$vNoKTP,$vContent);
			 
			 echo $vContent;
			 
		?>
        </div>




</form>

  <button style="margin-left:2em" class="btn btn-info btn-sm" onClick="return printRecom()"><i class="fa fa-print"></i> Print</button>  
   <button id="btnBack" type="button" class="btn btn-default"  onClick="document.location.href='<?= $_SESSION['refer'] ?>&choosed=<?=$vRefUser?>'">Back</button>

  <br ><br>        
</div>

 







      









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

	<!-- end page container -->

	



	</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>


<? include_once("../framework/member_footside.blade.php") ; ?>