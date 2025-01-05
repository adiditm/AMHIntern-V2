<? include_once("../framework/admin_headside.blade.php")?>
<div class="right_col" role="main">
			
				 <div><label><h3>Master Bank</h3></label></div>
<style type="text/css">
  table {
	  table;
  }
</style>

<div class="table-responsive">

<?php


// MySQL host name, user name, password, database, and table
$opts['hn'] = $db->Host;
$opts['un'] = $db->User;
$opts['pw'] = $db->Password;
$opts['db'] = $db->Database;
$opts['tb'] = 'm_bank';

// Name of field which is the unique key
$opts['key'] = 'fkodebank';

// Type of key field (int/real/string/date etc.)
$opts['key_type'] = 'string';

// Sorting field(s)
$opts['sort_field'] = array('fkodebank');

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

$opts['fdd']['fkodebank'] = array(
  'name'     => 'Bank Code',
  'select'   => 'T',
  'maxlen'   => 10,
  'sort'     => true,
  'nowrap'	 => true
);
$opts['fdd']['fnamabank'] = array(
  'name'     => 'Bank Name',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true
);


$opts['fdd']['fmaxdigit'] = array(
  'name'     => 'Account No. Max. Digit',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true,

);


$opts['fdd']['fcountry_code'] = array(
  'name'     => 'Country',
  'select'   => 'T',
  'maxlen'   => 11,
  'sort'     => true,
  'default'  => 'ID',
  //'help'     => 'Khusus untuk Non Bulan Madu, abaikan untuk Bulan Madu'
);
$opts['fdd']['fcountry_code']['values']['table']       = 'm_country'; 
$opts['fdd']['fcountry_code']['values']['column']      = 'fcountry_code'; 
$opts['fdd']['fcountry_code']['values']['description'] = 'fcountry_name'; // optional




$opts['fdd']['fclearno'] = array(
  'name'     => 'Kode Clearing',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true,

);


$opts['fdd']['frtgscode'] = array(
  'name'     => 'Kode RTGS',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true,

);


$opts['fdd']['fbranchname'] = array(
  'name'     => 'Cabang',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true,

);



$opts['fdd']['fcity'] = array(
  'name'     => 'Kota',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true,

);

$opts['fdd']['faktif'] = array(
  'name'     => 'Active',
  'select'   => 'T',
  'maxlen'   => 1,
  'default'  => '',
  'sort'     => true,
  'values2'  => array(1 => 'Active', 0=>'Inactive')
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

<!--common scripts for all pages-->

<script language="javascript">
$(document).ready(function(){

      $('#caption').html('Bank');
});  
</script>
   </div>

	


<? include_once("../framework/admin_footside.blade.php") ; ?>