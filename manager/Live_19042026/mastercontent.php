<? include_once("../framework/admin_headside.blade.php")?>


				
<div class="right_col" role="main">
		<div><label><h3>First Content</h3></label></div>



       

<?php

   define("MENU_ID", "mdm_setting_mvoucher");
  // include_once("server/config.php");
   include_once(CLASS_DIR."systemclass.php");
   if ($oSystem->authAdminNP($vUser)==0) {
      $oSystem->jsAlert("Not Authorized!");
      $oSystem->jsLocation("logout.php");
   }
   
$opts['hn'] = $db->Host;
$opts['un'] = $db->User;
$opts['pw'] = $db->Password;
$opts['db'] = $db->Database;
$opts['tb'] = 'tb_content';

// Name of field which is the unique key
$opts['key'] = 'fidsys';

// Type of key field (int/real/string/date etc.)
$opts['key_type'] = 'int';

// Sorting field(s)
$opts['sort_field'] = array('fidsys');

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
	'time'  => true,
	'tabs'  => true
);

// Set default prefixes for variables
$opts['js']['prefix']               = 'PME_js_';
$opts['dhtml']['prefix']            = 'PME_dhtml_';
$opts['cgi']['prefix']['operation'] = 'PME_op_';
$opts['cgi']['prefix']['sys']       = 'menu=mastercontent&PME_sys_';
$opts['cgi']['prefix']['data']      = 'PME_data_';

/* Get the user's default language and use it if possible or you can
   specify particular one you want to use. Refer to official documentation
   for list of available languages. */
$opts['language'] = $_SERVER['HTTP_ACCEPT_LANGUAGE'] . '-UTF8';

$opts['filters'] = 'fstatusrow=\'1\'';

$opts['fdd']['fidsys'] = array(
  'name'     => 'ID Sys',
  'select'   => 'T',
  'maxlen'   => 11,
  'default'  => '0',
  'sort'     => true,
  'input'	 => 'R',
  'options'	 => 'APC'
  
);
$opts['fdd']['fgroup'] = array(
  'name'     => 'Menu Group',
  'select'   => 'T',
  'maxlen'   => 55,
  'sort'     => true,
  
  
 // 'input|C'	 => 'R'
);

$opts['fdd']['fgroup']['values']['table'] = 'tb_contgroup';
$opts['fdd']['fgroup']['values']['column'] = 'fgroupid';
$opts['fdd']['fgroup']['values']['description'] = 'fgroupname'; // optional


$opts['fdd']['fname'] = array(
  'name'     => 'Menu ID',
  'select'   => 'T',
  'maxlen'   => 55,
  'sort'     => true,
  
 // 'input|C'	 => 'R'
);




$opts['fdd']['fdesc'] = array(
  'name'     => 'Judul Menu ',
  'select'   => 'T',
  'maxlen'   => 254,
  'sort'     => true
);
/*
$opts['fdd']['fdescen'] = array(
  'name'     => 'Judul Menu English ',
  'select'   => 'T',
  'maxlen'   => 254,
  'sort'     => true,
  'options'	 => 'APCV'
); */
$opts['fdd']['fheader'] = array(
  'name'     => 'Header (tdk semua content pakai header )',
  'select'   => 'T',
  'maxlen'   => 254,
  'sort'     => true,

);
/*
$opts['fdd']['fheaderen'] = array(
  'name'     => 'Judul Halaman English',
  'select'   => 'T',
  'maxlen'   => 254,
  'sort'     => true
);
*/
$opts['fdd']['fcontent'] = array(
  'name'     => 'Content',
  'select'   => 'T',
  'maxlen'   => 65535,
  'textarea' => array(
    'rows' => 5,
    'cols' => 50),
  'sort'     => true,
  'options'	 => 'LFAPCV'
);

/*
$opts['fdd']['fcontenten'] = array(
  'name'     => 'Content En',
  'select'   => 'T',
  'maxlen'   => 65535,
  'textarea' => array(
    'rows' => 5,
    'cols' => 50),
  'sort'     => true,
  'options'	 => 'APCV'
);
*/
$opts['fdd']['fstatusrow'] = array(
  'name'     => 'Status',
  'select'   => 'T',
  'maxlen'   => 1,
  'default'  => '1',
  'sort'     => true,
  'values2'    => array('1' => 'Aktif', '0' => 'Tidak'),  
);
$opts['fdd']['ftglentry'] = array(
  'name'     => 'Tgl. Entry',
  'select'   => 'T',
  'options'  => 'ACP', // updated automatically (MySQL feature)
  'maxlen'   => 19,
  'sqlw|A'  =>  'now()',
  'sort'     => true,
  'input'    => 'H'
);
$opts['fdd']['fstatusrow'] = array(
  'name'     => 'Status',
  'select'   => 'O',
  'maxlen'   => 1,
  'sort'     => true,
  'values2'    => array('1' => 'Aktif', '0' => 'Tidak'),
   'options'  => 'ACPV'
);

$opts['fdd']['flastuser'] = array(
  'name'     => 'Last User',
  'select'   => 'T',
  'maxlen'   => 55,
  'sort'     => true,
  'default'  => $_SESSION['LoginUser'],
   'values'   => array($_SESSION['LoginUser']),
   'options' => 'ACVP'
);

// Now important call to phpMyEdit
require_once CLASS_DIR.'phpmyedit.class.php';
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

      $('#caption').html('Country');
});  
</script>

</div>
	<!-- end page container -->


<? include_once("../framework/admin_footside.blade.php") ; ?>
