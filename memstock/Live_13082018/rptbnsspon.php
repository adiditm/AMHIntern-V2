<? 

		 include_once("../classes/ruleconfigclass.php") ;
		 
        if ($_GET['op'] != '') 
           include_once("../framework/admin_headside.blade.php");
        else
           include_once("../framework/member_headside.blade.php") ;  
     
		   
		if ($_GET['uMemberId'] != '')
			$vUserActive=$_GET['uMemberId'];
		 else  $vUserActive=$vUser;
		 
		 $vSpy = md5('spy').md5($_GET['uMemberId']);		   
?>





<script language="JavaScript" type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->

$(document).ready(function(){

     

  <? if ($oDetect->isMobile()) {?>
  $('#caption').html('<span data-toggle="tooltip" data-placement="top" title="Bonus Sponsor <?=$oMember->getMemberName($vUserActive)?>"><?=substr("Bns Sponsor ".$oMember->getMemberName($vUserActive),0,20);?>...</span>');
  <? } else { ?>
	$('#caption').html('Sponsorship Status <?=$vUserActive?> (<?=$oMember->getMemberName($vUserActive);?>)');
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

</script>
<style type="text/css">
<!--
.style1 {
	color: #0000FF;
	font-weight: bold;
}
.style3 {color: #FFFF00}
.style4 {font-weight: bold}
-->
</style>



 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />

		<div id="content" class="content">
			<ol class="breadcrumb pull-right">
				<h4><li><a href="javascript:;">Bonus Sponsor</a></li></h4>
				
			</ol>
<h1 class="page-header">&nbsp;</small></h1>
<div class="row">
            <div align="left" class="col-sm-4 col-lg-2"><strong>Date </strong></div>


              <div  class="col-lg-2  col-sm-2 col-md-2 col-xs-4" style="min-width:10em">
              <input class="dpick form-control form-inline"  name="dc"  id="dc" size="10" value="<?=$vStart?>"  />
              </div>
              
              <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"><strong>To</strong></div>
                            <div align="left" class="col-lg-2  col-sm-2 col-md-2 col-xs-4" style="min-width:10em">
              <input  class="dpick form-control form-inline" name="dc1" id="dc1" value="<?=$vEnd?>" size="10" /></div>

            </div>
            <br />
     <div class="row">
                      <div class="col-lg-6">
             <input name="btRefresh" type="button" id="btRefresh" value="Search" onClick="doSearch()" class="btn btn-success" /> 
        &nbsp;
        <input name="btReset" type="button" id="btReset" value="Reset" onClick="clearForm()" class="btn btn-danger"  />
        &nbsp;<input name="btBack" type="button" id="btBack" value="Back" onClick="document.location.href='../manager/aktif.php'" class="btn btn-default"  />
  </div>
</div>    
<br />    
    <table width="75%" border="0" align="center" cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
        <tr style="font-weight:bold"> 
          <td width="20%" height="5"  align="center"> <div align="right">Jumlah Sponsorship </div></td>
          <td width="34%" align="center" ><div align="right">Bonus  Sponsor</div></td>
          <td width="46%" align="center"><div align="right">Jumlah Bonus</div></td>
        </tr>
        
        <tr > 
          <td align="center"> <div align="right"><font color="#000000"> 
            <?
			  $vJmlSponsor=$oNetwork->getSponsorshipCount($vUserActive);
			   echo number_format($vJmlSponsor,0,',','.');
			?>
          </font></div></td>
          <td align="center"> <div align="right"><font color="#000000">
            <?
			 $vSponsor = $oRules->getSettingByField('fsponfee');
			 $vKomSpon=$vJmlSponsor * $vSponsor;
			 echo number_format($vSponsor,0,',','.');
		  ?>
          </font></div></td>
          <td align="center"> <div align="right"><font color="#000000">
            <?
			 if($oMember->isFree($vUserActive)==1)
			     $vKomSpon=$vJmlSponsor * $vSponsor * 0;
			 else if ($oMember->isActive($vUser)==1)	 
			     $vKomSpon=$vJmlSponsor * $vSponsor;
			 echo number_format($vKomSpon,0,',','.');
		  ?>
          </font></div></td>
        </tr>
        <tr >
          <td colspan="3" align="center"><div align="left" style="color:blue"><b>Catatan:</b> Bonus Sponsor di halaman ini adalah nilai gross sebelum dialokasikan untuk Wallet Non Cash dan pajak</div></td>
        </tr>
      </table>
 

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
	
<? include_once("../framework/member_bottomjs.blade.php")?>	
	<script>
		$(document).ready(function() {
			App.init();
			Dashboard.init();
		});
	</script>

<? include_once("../framework/member_footside.blade.php") ; ?>