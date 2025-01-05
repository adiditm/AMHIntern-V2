<? include_once("../framework/admin_headside.blade.php")?>

				
<div class="right_col" role="main">
		<div><label><h3>Entry New Item Stock</h3></label></div>

<?
  // print_r($_POST);
  $vUserHO = $oRules->getSettingByField('fuserho');
   $vCodePost=$_POST['lmProd'];
   $vNamaPost=$_POST['tfNamaProd'];	
   if (in_array($_POST['PME_sys_operation'],array('Add','View','Copy','More','Delete','Change')))
      $vFilterShow='hide';
   else	  $vFilterShow='';
?>

<style type="text/css">
  table {
	  table;
  }
  .divtr {
	 margin-top:1em;  
  }
</style>
<form name="frmFilter" id="frmFilter" style="padding-bottom:2em" method="post" class="<?=$vFilterShow?> hide" >
<div class="row">
<div class="col-lg-6">
<label><h4><strong>Filter :</strong></h4></label>
<br>

<label><b>Kode Produk</b></label>
  <select name="lmProd"  class="form-control" >
     <option value="">--Pilih--</option>
	 <?
        $vSQL = "select * from m_product order by fidproduk";
		$db->query($vSQL);
		while($db->next_record()) {
			$vCode=$db->f('fidproduk');
			$vNama=$db->f('fnamaproduk');
	 ?>
      <option value="<?=$vCode?>" <? if ($vCode == $vCodePost) echo 'selected'; ?>><?=$vCode?>; <?=$vNama?></option>
      
      <? } ?>
  </select>
  </div>
  </div>
  
<div class="row">
<div class="col-lg-6 divtr">
   <label><b>Nama Produk</b></label>
    <input type="text" name="tfNamaProd" id="tfNamaProd" value="<?=$vNamaPost?>" class="form-control ">
</div>
</div>

<div class="row">
<div class="col-lg-6 divtr">
  
    <input type="submit" name="btFilter" id="btFilter" value="Submit" class="btn btn-success ">
    <input type="button" name="btClear" id="btClear" value="Clear Filter" class="btn btn-default" onClick="document.location.href='../masterdata/mbarang.php'">
</div>
</div>

</form>

<hr  class="box box-title">

<div class="table-responsive">

<?php

//print_r($_POST);

// MySQL host name, user name, password, database, and table
$opts['hn'] = $db->Host;
$opts['un'] = $db->User;
$opts['pw'] = $db->Password;
$opts['db'] = $db->Database;
$opts['tb'] = 'tb_stok_position';

// Name of field which is the unique key
$opts['key'] = 'fidsys';

// Type of key field (int/real/string/date etc.)
$opts['key_type'] = 'integer';

// Sorting field(s)
$opts['sort_field'] = array('fidproduk');

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

//$opts['filters'] = 'fidproduk like \'%'.$vCodePost.'%\' AND fnamaproduk like \'%'.$vNamaPost.'%\'';

$opts['buttons']['L']['up'] = array('<<','<','add',
                                    '>','>>','goto','goto_combo');
$opts['buttons']['L']['down'] = $opts['buttons']['L']['up'];

$opts['buttons']['F']['up'] = array('<<','<','add',
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
  'input'	 => 'R'
);

$opts['fdd']['fidmember'] = array(
  'name'     => 'ID Warehouse',
  'select'   => 'T',
  'maxlen'   => 10,
  'sort'     => true,
  'default'  => $vUserHO,
  'input'    => 'R'
);

$opts['fdd']['fidproduk'] = array(
  'name'     => 'Product Code',
  'select'   => 'T',
  'maxlen'   => 10,
  'sort'     => true
);


$opts['fdd']['fidproduk']['values']['table']       = 'm_product'; 
$opts['fdd']['fidproduk']['values']['column']      = 'fidproduk'; 
$opts['fdd']['fidproduk']['values']['description'] = 'fnamaproduk'; // optional


$opts['fdd']['fbalance'] = array(
  'name'     => 'Opening Balance',
  'select'   => 'T',
  'maxlen'   => 10,
  'default'  => 0,
  'sort'     => true,
  
);


$opts['triggers']['insert']['after'] = '../manager/trig_newstock_ai.php'; 

// Now important call to phpMyEdit
require_once '../classes/phpmyedit.class.php';
new phpMyEdit($opts);



?>

 </div>
<!-- Placed js at the end of the document so the pages load faster -->


<script src="../js/jquery-migrate-1.2.1.min.js"></script>

<script src="../js/modernizr.min.js"></script>
<script src="../js/jquery.nicescroll.js"></script>




<!--ios7-->
<script src="../js/ios-switch/switchery.js" ></script>
<script src="../js/ios-switch/ios-init.js" ></script>

<!--icheck -->
<script src="../js/iCheck/jquery.icheck.js"></script>
<script src="../js/icheck-init.js"></script>
<!--multi-select-->
<script type="text/javascript" src="../js/jquery-multi-select/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="../js/jquery-multi-select/js/jquery.quicksearch.js"></script>
<script src="../js/multi-select-init.js"></script>
<!--spinner-->
<script type="text/javascript" src="../js/fuelux/js/spinner.min.js"></script>
<script src="../js/spinner-init.js"></script>
<!--file upload-->
<script type="text/javascript" src="../js/bootstrap-fileupload.min.js"></script>
<!--tags input-->
<script src="../js/jquery-tags-input/jquery.tagsinput.js"></script>
<script src="../js/tagsinput-init.js"></script>
<!--bootstrap input mask-->
<script type="text/javascript" src="../js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>

<!--common scripts for all pages-->



<script type="text/javascript">
    $(document).ready(function() {
    $('#PME_data_fidsys').attr('placeholder','(auto)')
 

		$('#caption').html('Products');
		   	});
			
			$('.pme-search').addClass('hide');
</script>
  
</div>

	


<? include_once("../framework/admin_footside.blade.php") ; ?>