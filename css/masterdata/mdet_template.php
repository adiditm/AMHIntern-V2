<? 

include_once("../framework/admin_headside.blade.php");

    include_once("../classes/productclass.php");
	include_once("../classes/memberclass.php");
   $vOutLet = $_SESSION['LoginOutlet'];
  // print_r($_SESSION['save']);
   while (list($key,$val)=each($_POST)) {
      $$key = $val;
   }

  $vIdTemp = $_GET['uMemberId'];
?>

      
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
.modal-backdrop {
  z-index: -1;
}
@media (max-width: 600px) {
  .divtr {
	margin-top:0px;
	
	}

.divtrsmall {
	margin-top:-15px;
	
}

  } 

.modal-body
{
    background-color: #fff;
}

.modal-content
{
    border-radius: 6px;
    -webkit-border-radius: 6px;
    -moz-border-radius: 6px;
    background-color:#CCC;
}

.modal-footer
{
    border-bottom-left-radius: 6px;
    border-bottom-right-radius: 6px;
    -webkit-border-bottom-left-radius: 6px;
    -webkit-border-bottom-right-radius: 6px;
    -moz-border-radius-bottomleft: 6px;
    -moz-border-radius-bottomright: 6px;
}

.modal-header
{
    border-top-left-radius: 6px;
    border-top-right-radius: 6px;
    -webkit-border-top-left-radius: 6px;
    -webkit-border-top-right-radius: 6px;
    -moz-border-radius-topleft: 6px;
    -moz-border-radius-topright: 6px;
}
	</style>
    <script src="../js/bootstrap.min.js"></script> 
<script src="../js/jquery.validate.min.js"></script>
<script language="javascript">

function delTemplate(pID,pKor,pProp,pKota,pKec) {
   if (confirm('Yakin menghapus ['+pProp.toUpperCase()+' -> '+pKota+' -> '+pKec+'] untuk area korwil '+pKor+'?')) {
 		var vURL='../main/mpurpose_ajax.php?op=deltemplate&idsys='+pID;
		$('#templateTable').html('<div align="center"><img align="middle" src="../images/ajax-loader.gif"></div>');
		$.get(vURL, function(data){
		    //alert(data);
			if (data.trim()!='success') {
			   alert('Delete failed!');
			}  else {
			   alert('['+pProp.toUpperCase()+' -> '+pKota+' -> '+pKec+'] sudah dihapus dari '+pKor+'!');	
			}
			$('#templateTable').load('../masterdata/mdet_template_ajax.php?idtemp=<?=$vIdTemp?>');	
		});
   }
}





function prepareProp(pParam,setKota) {

   

   var vURL="../main/mpurpose_ajax.php?op=wil&wil=prop&kodewil="+pParam.value;

 // $('#divProp').css({'background':'transparent url("../images/ajax-loader.gif")','background-repeat': 'no-repeat','background-position': 'center','z-index' : '10'});

  $('#loadProp').show();

  $.get(vURL, function(data) {
      $('#fprop').html(data);
      $('#loadProp').hide();
	  $('#fprop').val('<?=$vPropL?>');
	  $('#fprop').trigger('change');
	 
	       
   });   

}





function prepareKota(pParam) {
   var vCountry=$('#fcountry').val();
   var vDefKota = $('#hDefKota').val();
   if (pParam.value !='PX') {
	   var vURL="../main/mpurpose_ajax.php?op=wil&neg="+vCountry+"&wil=kota&kodewil="+pParam.value+'&def='+vDefKota;
	   $('#loadKota').show();
	   $('#tfprop').hide();
       $('#tfkota').hide();
	   $.get(vURL, function(data) {
	      $('#fkota').html(data);
	       $('#loadKota').hide();
		 
		 //  $('#fkota').val(vDefKota);
		    $('#fkota').trigger('change');
		   
	   });   
   } else {
     $('#tfprop').show();
      $('#tfprop').focus();     
   }
}


function prepareKeca(pParam) {
   var vCountry=$('#fcountry').val();
    var vProp=$('#fprop').val();
	 var vDefKec = $('#hDefKec').val();
	 //alert(vDefKec);
   if (pParam.value !='PX') {
	   var vURL="../main/mpurpose_ajax.php?op=wil&neg="+vCountry+"&wil=keca&kodeprop="+vProp+"&kodewil="+pParam.value+'&def='+vDefKec;
	   $('#loadKeca').show();
	   $('#tfprop').hide();
       $('#tfkota').hide();
	   $.get(vURL, function(data) {
	       $('#fkec').html(data);
	       
		   $('#loadKeca').hide();
		//   $('#fkec').val('<?=$vKecaL?>');
		   
	   });   
   } else {
     $('#tfprop').show();
      $('#tfprop').focus();     
   }
}



 </script>
<!-- 	<link rel="stylesheet" href="../css/screen.css"> -->

	
	
 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />


<div class="right_col" role="main">

		<div><label>
		<h3>Area <? if($_GET['j']=='sub') echo 'Sub '?> Korwil <?=$vIdTemp?></h3></label></div>
        <br />
         <button  onClick="doRefresh()"  class="btn btn-success btn-sm" type="button" name="btnRefresh" id="btnRefresh">Refresh
                                             <li class="fa fa-refresh"></li></button>  
        
        
        

<div class="modal fade" id="templateModal" role="dialog" style="z-index:100"> 
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="modalhead"><span id="varx"></span> Area  untuk <?=$vIdTemp?><span id="vary"></span></h4>
        </div>
        <div class="modal-body" style="padding: 2em 4em 3em 4em">
        <input type="hidden" id="hIdSys" name="hIdSys" value="" />
        <input type="hidden" id="hOp" name="hOp" value="" />
       <input type="hidden" id="hDefKota" name="hDefKota" value="" />
        <input type="hidden" id="hDefKec" name="hDefKec" value="" />
        

<div class="row">
 <div class="col-lg-12 col-md-4 divtr hide" >

                                <label for="exampleInputEmail1" ><span style="font-weight:bold">Negara*</span></label>

                                                                 <!-- <input type="text" class="form-control" id="tfNama" placeholder="Country*"> -->

                                <select class="form-control m-bot15" id="fcountry" name="fcountry" onChange="prepareProp(this)">

                                <option  value="" selected="selected" >--Pilih / Choose--</option>

								<? 

								    $vSQL="select * from m_country order by fcountry_name";

								    $db->query($vSQL);

								    while ($db->next_record()) {

								?>                               

								 <option <? if($db->f('fcountry_code')=='ID') echo 'selected'; ?> value="<?=$db->f('fcountry_code')?>" ><?=$db->f('fcountry_name')?></option>

								 <? } ?>

                            </select>



                                 </div>

                              

     							                    

                               <div class="col-lg-12 col-md-4 divtr" id="divProp">

                               <img id="loadProp"  align="absmiddle" src="../images/ajax-loader.gif" style="position:absolute;z-index:2;margin-left:45px;margin-top:24px;opacity: 0.5;display:none" />

                                <label for="exampleInputEmail1" ><span style="font-weight:bold">Propinsi*</span></label>

                                                                <select class="form-control m-bot15" id="fprop" name="fprop" onChange="prepareKota(this)">

                                <option  value="" selected="selected" >--Pilih / Choose--</option>

                                <option  value="PX"  >Other Province</option>



								</select>

								<input style="display:none" type="text" class="form-control" id="tfprop" name="tfprop" placeholder="Other Province">

								

                                </div>

                            

                              

     						 <div class="col-lg-12 col-md-4 divtr" id="divKota">
                                <img id="loadKota"  align="absmiddle" src="../images/ajax-loader.gif" style="position:absolute;z-index:2;margin-left:45px;margin-top:24px;opacity: 0.5;display:none" />
                                <label for="exampleInputEmail1" ><span style="font-weight:bold">Kabupaten/Kota*</span></label>
                                <select class="form-control m-bot15" id="fkota" name="fkota" onChange="prepareKeca(this)">
                                <option  value="" selected="selected" >--Pilih / Choose--</option>
                                <option  value="KX"  >Kota Lain</option>
								</select>
								<input style="display:none" type="text" class="form-control" id="tfkota" name="tfkota" placeholder="Other City">
                               </div>                        

                              

<div class="col-lg-12 col-md-6 divtr" id="divKec">
                                <img id="loadKeca"  align="absmiddle" src="../images/ajax-loader.gif" style="position:absolute;z-index:2;margin-left:45px;margin-top:24px;opacity: 0.5;display:none" />
                                <label for="exampleInputEmail1" ><span style="font-weight:bold">Kecamatan*</span></label>
                                <select class="form-control m-bot15" id="fkec" name="fkec" onChange="getOther(this)">
                                <option  value="" selected="selected" >--Pilih / Choose--</option>
                                <option  value="KX"  >Kec Lain</option>
								</select>
								<input style="display:none" type="text" class="form-control" id="tfkec" name="tfkec" placeholder="Other City">
                               </div>
                               
                 </div>              
           <br>


    

        </div>
        <div class="modal-footer">
          <span id="loading" ></span>
          
          <button onClick="saveEvent()" type="button" id="btSaveEvent" name="btSaveEvent" class="btn btn-success" >Save</button>
          <button type="button" id="btClose" name="btClose" class="btn btn-default" data-dismiss="modal">Close</button><span id="divLoadArea"></span>
          
        </div>
      </div>
      
    </div>
  </div>

<form method="post" id="frmReg" name="frmReg" action="<?=$_SERVER['PHP_SELF']?>">
	<div class="container">
    <div class="row" style="width:98%;margin-top:8px">
    
     
    
    
        <div class="col-md-12" id="templateTable" style="background-color:white">
               				
                     
		  <!-- <div class="divtr">
                            <!-- Panel Sponsor -->
         </div>
        
        <button  onClick="doAddEvent()" data-toggle="modal" data-target="#templateModal"  class="btn btn-success btn-sm" type="button" name="btnAddAddr" id="btnAddAddr" style="float:left;margin-left:0.5em;">Tambah Area 
                                             <li class="fa fa-plus"></li></button>  
                                             
                                             <?
                                                if($_GET['j']=='sub')
												   $vBack="aktifsubkorwil";
												else   
												   $vBack="aktifkorwil";
											 ?>
       <button  onClick="document.location.href='../masterdata/<?=$vBack?>.php?op=&current=mdm_master_data&menu=mdm_master_data_editkor'"  class="btn btn-default btn-sm" type="button" name="btnBack" id="btnBack" style="float:left;margin-left:0.5em;">Back
                                             &laquo;</button>          
                                             
                                                                          
		<!--Kolom Kanan -->
        </div>
    </div><br /><!--panel -->
</form>     
                     
 
        <!--footer section end-->


<!-- Placed js at the end of the document so the pages load faster -->

<!-- <script src="../js/jquery-ui-1.9.2.custom.min.js"></script>-->
<script src="../js/jquery-migrate-1.2.1.min.js"></script>

<script src="../js/modernizr.min.js"></script>
<!-- <script src="../js/jquery.nicescroll.js"></script> -->
<script src="../js/jquery.price_format.js"></script>




<script type="text/javascript" src="../js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="../js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="../js/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="../js/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="../js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="../js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<!--common scripts for all pages-->
<script src="../js/pickers-init.js"></script>

<script language="javascript">
$(document).ready(function(){

      //$('#caption').html('::Detail Template Event <?=$_GET['code']?>:');
	  $('#templateTable').html('<div align="center"><img align="middle" src="../images/ajax-loader.gif"></div>');
	  $('#templateTable').load('../masterdata/mdet_template_ajax.php?idtemp=<?=$vIdTemp?>');
	  
	 $('#fcountry').trigger('change');
	  

});  

function doRefresh(){
	  $('#templateTable').html('<div align="center"><img align="middle" src="../images/ajax-loader.gif"></div>');
	  $('#templateTable').load('../masterdata/mdet_template_ajax.php?idtemp=<?=$vIdTemp?>');
	  
	 $('#fcountry').trigger('change');
	
}
function doAddEvent() { 
	//$("#loading").html('<div style="text-align:center"><img align="middle" src="../images/ajax-loader.gif"> Loading ...</div>');  
	$('#varx').html('Tambah');
	$('#hOp').val('saveadd');
	$.get('../main/mpurpose_ajax.php?op=addevent&prefix=EV&idtemp=<?=$vIdTemp?>', function(data) {
	    $('#tfIDEvent').val (data);
	 });	
	 
	 $('#fprop').val('');
	 $('#fkota').val('');
	 $('#fkec').val('');
}

function doEditTemplate(pTemp) { 
	$('#varx').html('Edit');
	//$('#vary').html(' / Event '+pEvent);
	$('#hOp').val('saveedit');
	$.get('../main/mpurpose_ajax.php?op=loadevent&idsys='+pTemp, function(data) {
	    var vObj=jQuery.parseJSON(data);
		//alert(vObj.fcustname);
		$('#hDefKota').val(vObj.fkabkota);
		$('#hDefKec').val(vObj.fkec);
		$('#fprop').val(vObj.fprop);
		$('#hIdSys').val(vObj.fidsys);
		
		
		
		$('#fprop').trigger('change');
		$('#fkota').val(vObj.fkabkota);
		//$('#fkec').val(vObj.fkec);
		//$('#templateModal').modal('show');
	 });	
}

function saveEvent() {
	var vSubOp = $('#hOp').val();
	var vURL="../main/mpurpose_ajax.php?op=savearea&subop="+vSubOp;
	
	var vProp=$('#fprop').val();
	var vKabKota = $('#fkota').val();
	var vKec = $('#fkec').val();
	var vIdSys = $('#hIdSys').val();
	$('#divLoadArea').html('<img height="30" style="margin-top:-5px" align="top" src="../images/ajax-loader.gif">');
	$.post(vURL, { idkor: '<?=$vIdTemp?>', prop: vProp, kota: vKabKota, kec: vKec, idsys:vIdSys}, function(data){
		  vObj = $.parseJSON(data);
		  if (vObj.status=='success') {
			alert(vObj.message);
			$('#btClose').trigger('click');  
			$('#btnRefresh').trigger('click');  
		  } if (vObj.status=='failed') {
			alert(vObj.message);
			//$('#btClose').trigger('click');  
			  
		  }
		  
		 // $('#templateTable').load('../masterdata/mdet_template_ajax.php?idtemp=<?=$vIdTemp?>');
		 $('#divLoadArea').html('');
		} );
}
</script>
    
    <!-- /.content -->
 </div>

 <br>
      <button class="btn btn-info btn-sm hide" onClick="document.location.href='../manager/getexcel.php?arr=member&file=data_member'"><i class="fa fa-file-text-o"></i> Export Excel</button>
</div>
<!-- Placed js at the end of the document so the pages load faster -->


<!-- <script src="../js/scripts.js"></script> -->
 </div>
<? //include_once("../framework/admin_footside.blade.php") ; ?>
