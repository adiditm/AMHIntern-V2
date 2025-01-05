<? include_once("../framework/admin_headside.blade.php")?>
<div class="content-wrapper">

       <section class="content">
<style type="text/css">
  table {
	  table;
  }
</style>

<div class="table-responsive">
<?php
define("MENU_ID", "mdm_setting_menuedit");

   include_once(CLASS_DIR."systemclass.php");
   if ($oSystem->authAdminNP($vUser)==0) {
      $oSystem->jsAlert("Not Authorized!");
      $oSystem->jsLocation("logout.php");
   }	  

//include_once "adminempty.php";
// MySQL host name, user name, password, database, and table
$opts['hn'] = $db->Host;
$opts['un'] = $db->User;
$opts['pw'] = $db->Password;
$opts['db'] = $db->Database;
$opts['tb'] = 'm_menu';

// Name of field which is the unique key
$opts['key'] = 'menu_id';

// Type of key field (int/real/string/date etc.)
$opts['key_type'] = 'string';

// Sorting field(s)
$opts['sort_field'] = array('menu_id');

// Number of records to display on the screen
// Value of -1 lists all records in a table
$opts['inc'] = 15;

// Options you wish to give the users
// A - add,  C - change, P - copy, V - view, D - delete,
// F - filter, I - initial sort suppressed
$opts['options'] = 'ACPVDF';
$opts['filters'] = 'is_active= 1';
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
	'time'  => true,
	'tabs'  => true
);

// Set default prefixes for variables
$opts['js']['prefix']               = 'PME_js_';
$opts['dhtml']['prefix']            = 'PME_dhtml_';
$opts['cgi']['prefix']['operation'] = 'PME_op_';
$opts['cgi']['prefix']['sys']       = 'menu=menuedit&PME_sys_';
$opts['cgi']['prefix']['data']      = 'PME_data_';


$opts['language'] = $_SERVER['HTTP_ACCEPT_LANGUAGE'] . '-UTF8';



$opts['fdd']['menu_id'] = array(
  'name'     => 'Menu ID',
  'select'   => 'T',
  'maxlen'   => 130,
  'sort'     => true
);
$opts['fdd']['menu_title'] = array(
  'name'     => 'Menu Title',
  'select'   => 'T',
  'maxlen'   => 150,
  'sort'     => true
);




$opts['fdd']['is_active'] = array(
  'name'     => 'Aktif',
  'select'   => 'O',
  'maxlen'   => 1,
  'default'  => '1',
  'values2'    => array('1' => 'Ya', '0' => 'Tidak'),
  'sort'     => true
);
/*
$opts['fdd']['menu_order'] = array(
  'name'     => 'Menu Order',
  'select'   => 'T',
  'maxlen'   => 6,
  'default'  => '0',
  'sort'     => true
);
*/
// Now important call to phpMyEdit
require_once '../classes/phpmyedit.class.php';
new phpMyEdit($opts);

?>
</div>
       </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<?
 include('../framework/admin_footside.blade.php');
?>