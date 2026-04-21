<? include_once("../framework/masterheader.php")?>
<!-- <style type="text/css">
	hr.pme-hr		     { border: 0px solid; padding: 0px; margin: 0px; border-top-width: 1px; height: 1px; }
	table.pme-main 	     { border: #004d9c 1px solid; border-collapse: collapse; border-spacing: 0px; width: 100%; }
	table.pme-navigation { border: #004d9c 0px solid; border-collapse: collapse; border-spacing: 0px; width: 100%; }
	td.pme-navigation-0, td.pme-navigation-1 { white-space: nowrap; }
	th.pme-header	     { border: #004d9c 1px solid; padding: 4px; background: #add8e6; }
	td.pme-key-0, td.pme-value-0, td.pme-help-0, td.pme-navigation-0, td.pme-cell-0,
	td.pme-key-1, td.pme-value-1, td.pme-help-0, td.pme-navigation-1, td.pme-cell-1,
	td.pme-sortinfo, td.pme-filter { border: #004d9c 1px solid; padding: 3px; }
	td.pme-buttons { text-align: left;   }
	td.pme-message { text-align: center; }
	td.pme-stats   { text-align: right;  }
</style> -->
<script language="javascript">
$(document).ready(function(){
 //  alert('ssss');
  // alert($('#hHarga').val());
   $('#caption').html('Rate');
   $('input[name=PME_data_fvalidfrom]').datepicker({
                    format: "yyyy-mm-dd"
    });  
	$('input[name=PME_data_fvalidfrom]').css("width", 100);
	$('input[name=PME_data_funit]').css("direction", 'rtl');
	$('input[name=PME_data_fratenom]').css("direction", 'rtl');


});


</script>
<style type="text/css">
  table {
	  table;
  }
</style>
 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />
<body class="sticky-header">

<section>
    <!-- left side start-->
   <? include "../framework/leftadmin.php"; ?>
    <!-- main content start-->
    <div class="main-content" >

   <? include "../framework/headeradmin.php"; ?>
   
    <section class="wrapper">
  

<?php


// MySQL host name, user name, password, database, and table
$opts['hn'] = $db->Host;
$opts['un'] = $db->User;
$opts['pw'] = $db->Password;
$opts['db'] = $db->Database;
$opts['tb'] = 'tb_exrate';

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
  'options' =>'ACPVD',
  'input'	=> 'R' 
  
);

$opts['fdd']['fratefrom'] = array(
  'name'     => 'Indonesia Currency',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true
);

$opts['fdd']['frateto'] = array(
  'name'     => 'Foreign Currency',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true
);

$opts['fdd']['funit'] = array(
  'name'     => 'Foreign Unit',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true
);


$opts['fdd']['fratenom'] = array(
  'name'     => 'Sell Rate',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true
);


$opts['fdd']['fratenombuy'] = array(
  'name'     => 'Buy Rate',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true
);


$opts['fdd']['fvalidfrom'] = array(
  'name'     => 'Valid From',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true
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

 </section>
    <? include "../framework/footer.php";?>
        <!--footer section end-->


    </div>
    <!-- main content end-->
</section>

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



</body>
</html>