<? include_once("../framework/admin_headside.blade.php")?>
<div class="content-wrapper">

       <section class="content">

<style type="text/css">
  table {
	  table;
  }
</style>


<?php


// MySQL host name, user name, password, database, and table
$opts['hn'] = $db->Host;
$opts['un'] = $db->User;
$opts['pw'] = $db->Password;
$opts['db'] = $db->Database;
$opts['tb'] = 'tb_rules_config';

// Name of field which is the unique key
$opts['key'] = 'fidsys';

// Type of key field (int/real/string/date etc.)
$opts['key_type'] = 'int';

// Sorting field(s)
$opts['sort_field'] = array('fket');

// Number of records to display on the screen
// Value of -1 lists all records in a table
$opts['inc'] = 40;

// Options you wish to give the users
// A - add,  C - change, P - copy, V - view, D - delete,
// F - filter, I - initial sort suppressed
$opts['options'] = 'ACPVDF';

// Number of lines to display on multiple selection filters

$opts['filters'] = 'fket <> \'\'  and fsetname in(\'fsmsreg\',\'fmailsmsgw\',\'fidsmsgw\',\'fpwdsmsgw\',\'fsmsbonusa\',\'fsmsbonusb\',\'fsmsreward\')' ;
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


$opts['buttons']['L']['up'] = array('<<','<','view','change',
                                    '>','>>','goto','goto_combo');
$opts['buttons']['L']['down'] = $opts['buttons']['L']['up'];

$opts['buttons']['F']['up'] = array('<<','<','view','change',
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
  'name'     => 'ID Sys',
  'select'   => 'T',
  'maxlen'   => 10,
  'sort'     => true,
    'options' => 'VD'
);

$opts['fdd']['fket'] = array(
  'name'     => 'Setting For',
  'select'   => 'T',
  'maxlen'   => 100,
  'sort'     => true,
  'input' => 'R'
);
$opts['fdd']['fsetval'] = array(
  'name'     => 'Setting Value',
  'select'   => 'T',
  'maxlen'   => 150,
  'sort'     => true,
  'textarea' => array( 'rows' => 4, 'cols' => 40)
);


$opts['fdd']['fsetname'] = array(
  'name'     => 'Variable',
  'select'   => 'T',
  'maxlen'   => 150,
  'sort'     => true,
  'options'  => 'LFAPC',
  'input' => 'R'
);


$opts['fdd']['fsetadd1'] = array(
  'name'     => 'Additional&nbsp;1',
  'select'   => 'T',
  'maxlen'   => 200,
  'sort'     => true,
  'options'  => 'LFAC'
);




// Now important call to phpMyEdit
require_once '../classes/phpmyedit.class.php';
new phpMyEdit($opts);

?>


<!-- Placed js at the end of the document so the pages load faster -->

<script src="../js/jquery-ui-1.9.2.custom.min.js"></script>
<script src="../js/jquery-migrate-1.2.1.min.js"></script>

<script src="../js/modernizr.min.js"></script>
<script src="../js/jquery.nicescroll.js"></script>

<!--common scripts for all pages-->
<script src="../js/scripts.js"></script>
<script language="javascript">
$(document).ready(function(){

      $('#caption').html('Setting SMS & Gateway');
});  
</script>
       </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<?
 include('../framework/admin_footside.blade.php');
?>
