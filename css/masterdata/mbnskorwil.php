<? include_once("../framework/admin_headside.blade.php")?>
<div class="right_col" role="main">
			
				 <div><label>
				 <h3>Setting Bonus Korwil </h3></label></div>

<style type="text/css">
  table {
	  table;
  }
</style>

<div class="table-responsive">
<?php


$vIDkey = $_POST['PME_sys_rec'];
 $vSQL="select * from tb_rules_bnskorwil where fidsys='$vIDkey'";
$db->query($vSQL);
$db->next_record();
$vIDPaket = $db->f('fpackid');

// MySQL host name, user name, password, database, and table
$opts['hn'] = $db->Host;
$opts['un'] = $db->User;
$opts['pw'] = $db->Password;
$opts['db'] = $db->Database;
$opts['tb'] = 'tb_rules_bnskorwil';


// Name of field which is the unique key
$opts['key'] = 'fidsys';

// Type of key field (int/real/string/date etc.)
$opts['key_type'] = 'string';

// Sorting field(s)
$opts['sort_field'] = array('fidmember');

// Number of records to display on the screen
// Value of -1 lists all records in a table
$opts['inc'] = 15;

// Options you wish to give the users
// A - add,  C - change, P - copy, V - view, D - delete,
// F - filter, I - initial sort suppressed
$opts['options'] = 'ACPVDF';

// Number of lines to display on multiple selection filters
$opts['multiple'] = '4';

// Navigation style: B - buttons (default), T - text links, G - graphic links
// Buttons position: U - up, D - down (default)
$opts['navigation'] = 'DB';

// Display special page elements
$opts['display'] = array(
	'form'  => true,
	'query' => true,
	'sort'  => true,
	'time'  => false,
	'tabs'  => true
);


$opts['buttons']['L']['up'] = array('<<','<','add','change','delete',
                                    '>','>>');
$opts['buttons']['L']['down'] = $opts['buttons']['L']['up'];

$opts['buttons']['F']['up'] = array('<<','<','add','change',
                                    '>','>>');
$opts['buttons']['F']['down'] = $opts['buttons']['F']['up'];

// Set default prefixes for variables
$opts['js']['prefix']               = 'PME_js_';
$opts['dhtml']['prefix']            = 'PME_dhtml_';
$opts['cgi']['prefix']['operation'] = 'PME_op_';
$opts['cgi']['prefix']['sys']       = 'PME_sys_';
$opts['cgi']['prefix']['data']      = 'PME_data_';

/* Get the user's default language and use it if possible or you can
   specify particular one you want to use. Refer to official documentation
   for list of available languages. */
//$opts['language'] = $_SERVER['HTTP_ACCEPT_LANGUAGE'] . '-UTF8';
$opts['language'] = 'EN-US';
//$opts['filters'] = 'fpriv <> \'administrator\' ';


$opts['fdd']['fidsys'] = array(
  'name'     => 'ID System',
  'select'   => 'T',
  'maxlen'   => 55,
  'sort'     => true,
  'options' =>'LVDF',
  'input' =>'R'
  
);
//print_r($_POST);
$opts['fdd']['fpackid'] = array(
  'name'     => 'Paket',
  'select'   => 'T',
  'maxlen'   => 25,
  'sort'     => true
);
	
$opts['fdd']['fidprogram'] = array(
  'name'     => 'Program',
  'select'   => 'T',
  'maxlen'   => 25,
  'sort'     => true
);

$opts['fdd']['fbnskorwil'] = array(
  'name'     => 'Bonus KTP Korwil',
  'select'   => 'T',
  'maxlen'   => 25,
  'sort'     => true,
   'colattrs' => 'style="text-align:right;padding-right:30px"',
   'number_format' => array(0, ',', '.')
  
); 


$opts['fdd']['fbnssubkor'] = array(
  'name'     => 'Bonus KTP Sub Korwil',
  'select'   => 'T',
  'maxlen'   => 25,
  'colattrs' => 'style="text-align:right;padding-right:30px"',
  'number_format' => array(0, ',', '.'),
  'sort'     => true
);


$opts['fdd']['fbnsregkor'] = array(
  'name'     => 'Bonus Registrasi Korwil',
  'select'   => 'T',
  'maxlen'   => 25,
  'colattrs' => 'style="text-align:right;padding-right:30px"',
  'number_format' => array(0, ',', '.'),
  'sort'     => true
);


$opts['fdd']['fbnsregsubkor'] = array(
  'name'     => 'Bonus Registrasi Sub Korwil',
  'select'   => 'T',
  'maxlen'   => 25,
  'colattrs' => 'style="text-align:right;padding-right:30px"',
  'number_format' => array(0, ',', '.'),
  'sort'     => true
);

$opts['fdd']['fbnsregkorbysub'] = array(
  'name'     => 'Bonus Korwil Reg. Subkorwil',
  'select'   => 'T',
  'maxlen'   => 25,
  'colattrs' => 'style="text-align:right;padding-right:30px"',
  'number_format' => array(0, ',', '.'),
  'sort'     => true
);




$opts['fdd']['fbnsspon'] = array(
  'name'     => 'Bonus Sponsor',
  'select'   => 'T',
  'maxlen'   => 25,
  'colattrs' => 'style="text-align:right;padding-right:30px"',
  'number_format' => array(0, ',', '.'),
  'sort'     => true
);

$opts['fdd']['fbnsregspon'] = array(
  'name'     => 'Bonus Korwil Reg. Pebisnis',
  'select'   => 'T',
  'maxlen'   => 25,
  'colattrs' => 'style="text-align:right;padding-right:30px"',
  'number_format' => array(0, ',', '.'),
  'sort'     => true
);

$opts['fdd']['fbnsregsubspon'] = array(
  'name'     => 'Bonus Subkorwil Reg. Pebisnis',
  'select'   => 'T',
  'maxlen'   => 25,
  'colattrs' => 'style="text-align:right;padding-right:30px"',
  'number_format' => array(0, ',', '.'),
  'sort'     => true
);

$opts['fdd']['fket'] = array(
  'name'     => 'Keterangan',
  'select'   => 'T',
  'maxlen'   => 25,
  //'values2'  => array('administrator' => 'Administrator','korwil'=>'Korwil','subkorwil'=>'Sub Korwil'),
 // 'default'  => 'administrator',
  'sort'     => true
);

$opts['fdd']['fidprogram']['values']['table']       = 'm_program'; 
$opts['fdd']['fidprogram']['values']['column']      = 'fidprogram'; 
$opts['fdd']['fidprogram']['values']['description'] = 'fnama'; // optional


$opts['fdd']['fpackid']['values']['table']       = 'm_paket'; 
$opts['fdd']['fpackid']['values']['column']      = 'fpackid'; 
$opts['fdd']['fpackid']['values']['description'] = 'fpackname'; // optional


$opts['fdd']['factive'] = array(
  'name'     => 'Active',
  'select'   => 'T',
  'maxlen'   => 1,
  'default'  => '',
  'sort'     => true,
  'values2'  => array(1 => 'Active', 0=>'Inactive')
);

$opts['fdd']['ftglupdate'] = array(
  'name'     => 'Tgl Update',
  'select'   => 'T',
  'maxlen'   => 1,
  'default'  => '',
  'sort'     => true,
  'values2'  => array(date("Y-m-d H:i:s")=>date("Y-m-d H:i:s")),
  'options'   => 'APC'
);



// Now important call to phpMyEdit
require_once '../classes/phpmyedit.class.php';
new phpMyEdit($opts);

?>
</div>

<!-- Placed js at the end of the document so the pages load faster -->

<script src="../js/jquery-ui-1.9.2.custom.min.js"></script>
<script src="../js/jquery-migrate-1.2.1.min.js"></script>

<script src="../js/modernizr.min.js"></script>
<script src="../js/jquery.nicescroll.js"></script>

<script type="text/javascript" src="../js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="../js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="../js/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="../js/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="../js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="../js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<!--common scripts for all pages-->
<script src="../js/pickers-init.js"></script>
<script src="../js/scripts.js"></script>
<script language="javascript">
$(document).ready(function(){

      $('#caption').html('User Admin Editor');
	  $(":radio").attr('checked', false)
	  $('#PME_data_fbnskorwil').attr('dir','rtl');
	  $('#PME_data_fbnssubkor').attr('dir','rtl');
	  $('#PME_data_fbnsregkor').attr('dir','rtl');
	  $('#PME_data_fbnsregsubkor').attr('dir','rtl');
	  $('#PME_data_fbnsregkorbysub').attr('dir','rtl');
	  $('#PME_data_fbnsregspon').attr('dir','rtl');
	   $('#PME_data_fbnsregsubspon').attr('dir','rtl');
	  $('#PME_data_fbnsspon').attr('dir','rtl');
	  $('input:text').each(function () {
                    $(this).css("min-width","120px");
                });
				
				
	 <? if ( $_POST['PME_sys_operation']=='Add'  ) { ?>
	  $('#PME_data_fpackid').prepend("<option value='' selected='selected'>--Pilih Paket--</option>");
	  <? } ?>
	
	 <? if ( $_POST['PME_sys_operation']=='Change'  ) { ?>
	  $('#PME_data_fpackid').prepend("<option value='' >--Pilih Paket--</option>");
	  <? if (trim($vIDPaket)=='') { ?>
	  		$('#PME_data_fpackid').val('');
	  <? } ?>
	  <? } ?>
	  
				
});  

    function setUmum() {
   
      var vSel= document.forms[0].mychecked;
	  //alert(vSel.length);
	  var vChecked=0;
	  var vVal=0;
	  for (i=0; i<vSel.length; i++) 
  		if (vSel[i].checked == true)
		   vChecked+=1;
	  
	 if (!vSel.length)	{
		   vVal=vSel.value;
		   doShow(600,800,'wPrice','umum.php?uID='+vVal);
		   return false;
	 }

	      
	  if (vChecked==0) { 
	     alert('Pilih salah satu data voucher yang akan diedit detailnya!');
		 return false;  
	  }	 
	  for (i=0; i<vSel.length; i++) 
  		if (vSel[i].checked == true) {
		  vVal=vSel[i].value; 
		  doShow(600,800,'wPrice','tourdetail.php?uID='+vVal);
		}
		
	  
  		
   }
   
   
    function setUmum2() {
   	  var vURL=''; 
      var vSel= document.PME_sys_form.mychecked;
	//  alert(vSel.length);
	  //exit;
	  var vChecked=0;
	  var vVal=0;
	  for (i=0; i<vSel.length; i++) 
  		if (vSel[i].checked == true)
		   vChecked+=1;
	  
	 if (!vSel.length)	{//cuma 1
		   vVal=vSel.value;
		   //doShow(600,800,'wPrice','tourdetail.php?uID='+vVal);
		    vURL='../manager/koreksistock.php?op=<?=$vSpy?>'+CryptoJS.MD5(vVal.trim())+'&uMemberId='+vVal;
		   document.location.href=vURL;
		   return false;
	 }

	      
	  if (vChecked==0) { 
	     alert('Pilih salah satu outlet yang akan dikoreksi stoknya!');
		 return false;  
	  }	 
	  for (i=0; i<vSel.length; i++) 
  		if (vSel[i].checked == true) {
		  vVal=vSel[i].value; 
		  //doShow(600,800,'wPrice','tourdetail.php?uID='+vVal);
		   vURL='../manager/koreksistock.php?op=<?=$vSpy?>'+CryptoJS.MD5(vVal.trim())+'&uMemberId='+vVal;
		  document.location.href=vURL;
		//  alert(vURL);
		  exit;
		}
		
	  
  		
   }      
</script>
  </div>

	
<? include_once("../framework/admin_footside.blade.php") ; ?>
