<? include_once("../framework/admin_headside.blade.php")?>
<div class="right_col" role="main">
			
				 <div><label>
				 <h3>User Login Sponsor </h3></label></div>

<style type="text/css">
  table {
	  table;
  }
</style>

<div class="table-responsive">
<?php
//print_r($_POST);

// MySQL host name, user name, password, database, and table
$opts['hn'] = $db->Host;
$opts['un'] = $db->User;
$opts['pw'] = $db->Password;
$opts['db'] = $db->Database;
$opts['tb'] = 'm_admin';

$vIDMember = $_POST['PME_sys_rec'];
$vSQL="select * from m_admin where fidmember='$vIDMember'";
$db->query($vSQL);
$db->next_record();
$vIDJamaah = $db->f('fidjamaah');

// Name of field which is the unique key
$opts['key'] = 'fidmember';

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


$opts['buttons']['L']['up'] = array('<<','<','add','view','change','delete',
                                    '>','>>','goto','goto_combo');
$opts['buttons']['L']['down'] = $opts['buttons']['L']['up'];

$opts['buttons']['F']['up'] = array('<<','<','add','view','change','delete',
                                    '>','>>','goto','goto_combo');
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
$opts['filters'] = 'fpriv = \'sponsor\' ';


$opts['fdd']['fidmember'] = array(
  'name'     => 'Username',
  'select'   => 'T',
  'maxlen'   => 55,
  'sort'     => true,
 
);
//print_r($_POST);
if ($_POST['PME_sys_saveadd'] == 'Save' && $_POST['PME_data_fpriv']=='administrator')
    $opts['fdd']['fidmember']['sqlw'] = 'concat(\'admin_\',$val_qas)';
	
$opts['fdd']['fnama'] = array(
  'name'     => 'Name',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true
);

$opts['fdd']['fpassword'] = array(
  'name'     => 'Password',
  'select'   => 'T',
  'maxlen'   => 254,
  'sort'     => true,
  'sqlw' 	 => 'IF(fpassword= $val_qas, $val_qas, MD5($val_qas))'
); 


$opts['fdd']['fpriv'] = array(
  'name'     => 'Privilege',
  'select'   => 'T',
  'maxlen'   => 25,
  'values2'  => array('sponsor'=>'Pebisnis / Sponsor'),
  'default'  => 'sponsor',
  'sort'     => true
);

$opts['fdd']['fidjamaah'] = array(
  'name'     => 'Link ke Jamaah',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true
);

$opts['fdd']['fidjamaah']['values']['table']       = 'm_anggota'; 
$opts['fdd']['fidjamaah']['values']['column']      = 'fidmember'; 
$opts['fdd']['fidjamaah']['values']['description']['columns'][0] = 'fidmember'; // optional
$opts['fdd']['fidjamaah']['values']['description']['divs'][0] = ' / '; // optional
$opts['fdd']['fidjamaah']['values']['description']['columns'][1] = 'fnama'; // optional


$opts['fdd']['faktif'] = array(
  'name'     => 'Active',
  'select'   => 'T',
  'maxlen'   => 1,
  'default'  => '',
  'sort'     => true,
  'values2'  => array(1 => 'Active', 0=>'Inactive')
);
$opts['fdd']['fpin'] = array(
  'name'     => 'PIN',
  'select'   => 'T',
  'maxlen'   => 20,
  'sort'     => true
  
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
<link rel="stylesheet" type="text/css" href="../vendor/select2/select2.min.css">
<script src="../vendor/select2/select2.min.js"></script>
<script language="javascript">
$(document).ready(function(){

      $('#caption').html('User Admin Editor');
	  $(":radio").attr('checked', false)
	  $('#PME_data_fidmember').attr("placeholder","Contoh: 1411-0022-0004");
	 
	 <? if ( $_POST['PME_sys_operation']=='Add'  ) { ?>
	  $('#PME_data_fidjamaah').prepend("<option value='' selected='selected'>--Nama Jamaah--</option>");
	  <? } ?>
	
	 <? if ( $_POST['PME_sys_operation']=='Change'  ) { ?>
	  $('#PME_data_fidjamaah').prepend("<option value='' >--Nama Jamaah--</option>");
	  <? if (trim($vIDJamaah)=='') { ?>
	  		$('#PME_data_fidjamaah').val('');
	  <? } ?>
	  <? } ?>
  
	  	  $('#PME_data_fidjamaah').select2();

	  $('.pme-form').submit(function(){
		   <? if ($_POST['PME_sys_operation']=='Change' || $_POST['PME_sys_operation']=='Add'  ) { ?>
		   
		   var btn = document.activeElement.getAttribute('value');

		   
	    /*if($('#PME_data_fidjamaah').val()=='' && btn !='Cancel') {
		    alert('Pilih nama jamaah untuk user pebisnis ini!');
		    return false; 
		   }*/
		 <? } ?>
	  });

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