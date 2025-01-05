<? include_once("../framework/admin_headside.blade.php")?>
<div class="right_col" role="main">
			
				 <div><label><h3>Data Korwil</h3></label></div>

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
$opts['tb'] = 'm_korwil';

// Name of field which is the unique key
$opts['key'] = 'fidsys';

// Type of key field (int/real/string/date etc.)
$opts['key_type'] = 'integer';

// Sorting field(s)
$opts['sort_field'] = array('fidkorwil');

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
	'sort'  => false,
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

$opts['fdd']['fidsys'] = array(
  'name'     => 'ID System',
  'select'   => 'T',
  'maxlen'   => 10,
  'sort'     => true,
  'options'  => 'C,D,L,F' ,
   'input'	 => 'R'
);

if ($_POST['PME_sys_operation'] == 'Change') {
    
	
$opts['fdd']['fidkorwil'] = array(
  'name'     => 'ID Korwil',
  'select'   => 'T',
  'maxlen'   => 10,
  'sort'     => true,
  
  
  'escape'   => false
);

} else {
$opts['fdd']['fidkorwil'] = array(
  'name'     => 'ID Korwil',
  'select'   => 'T',
  'maxlen'   => 10,
  'sort'     => true,
  
  'sql'		 => 'concat(fidkorwil,\'<br><button type="button" class="btn btn-success btn-xs" onclick="return doEdetail(\',\'\\\'\',fidkorwil,\'\\\'\',\');">Detail Area &raquo;</button>\')',
  'escape'   => false
);	
	
}



$opts['fdd']['fnama'] = array(
  'name'     => 'Nama Korwil',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true
);

$opts['fdd']['fnohp'] = array(
  'name'     => 'Nomor HP',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true
);

$opts['fdd']['flevel'] = array(
  'name'     => 'Level',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true,
  'values2'	 => array('KOR'=>'KORWIL','SUBKOR'=>'SUB KORWIL')
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

<!--common scripts for all pages-->

<script language="javascript">
$(document).ready(function(){

      $('#caption').html('Master Template Event');
	  $("input.pme-search[type=submit]").hide();

});  

function doEdetail(pCode) {
	//alert(pCode);
	document.location.href='../masterdata/mdet_template.php?code='+pCode;
	return false;
}
</script>

  </div>
  <!-- /.content-wrapper -->


<?
 include('../framework/admin_footside.blade.php');
?>
