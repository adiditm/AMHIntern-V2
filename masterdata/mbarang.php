<? include_once("../framework/admin_headside.blade.php")?>
<div class="right_col" role="main">
			
				 <div><label><h3>Master Product</h3></label></div>
<?
  // print_r($_POST);
   $vCodePost=$_POST['lmProd'];
   $vNamaPost=$_POST['tfNamaProd'];

   // Seller privilege: hanya tampilkan produk milik seller login
   // NOTE: comparison on PHP-level should use original lowercase value: 'seller'
   $vPrivSess = $_SESSION['Priv'];
   $vSellerUser = strtoupper($_SESSION['LoginUser']);
   $vIsSeller = ($vPrivSess == 'seller');


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
<form name="frmFilter" id="frmFilter" style="padding-bottom:2em" method="post" class="<?=$vFilterShow?>">
<div class="row">
<div class="col-lg-6">
<label><h4><strong>Filter :</strong></h4></label>
<br>

<label><b>Kode Produk</b></label>
  <select name="lmProd"  class="form-control" >
     <option value="">--Pilih--</option>
	 <?
        $vSQL = "select * from m_product";
		if ($vPrivSess == 'seller') {
			$vSQL .= " where UPPER(fseller) = '$vSellerUser'";
		}
		$vSQL .= " order by fidproduk";
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
$opts['tb'] = 'm_product';

// Name of field which is the unique key
$opts['key'] = 'fidproduk';

// Type of key field (int/real/string/date etc.)
$opts['key_type'] = 'string';

// Sorting field(s)
$opts['sort_field'] = array('fidproduk');

// Number of records to display on the screen
// Value of -1 lists all records in a table
$opts['inc'] = 15;

// Options you wish to give the users
// A - add,  C - change, P - copy, V - view, D - delete,
// F - filter, I - initial sort suppressed
$opts['options'] = $vIsSeller ? 'CVF' : 'ACPVDF';

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

$vCodeFilter = addslashes($vCodePost);
$vNamaFilter = addslashes($vNamaPost);
//print_r($_SESSION);
 $vFilters = "fidproduk like '%".$vCodeFilter."%' AND fnamaproduk like '%".$vNamaFilter."%'";
		if ($vPrivSess == 'seller') {
	$vFilters .= " AND UPPER(fseller) = '".$vSellerUser."'";
}

//echo $vFilters;
$opts['filters'] = $vFilters;

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

$opts['fdd']['fidproduk'] = array(
  'name'     => 'Product Code',
  'select'   => 'T',
  'maxlen'   => 10,
  'sort'     => true
);
$opts['fdd']['fnamaproduk'] = array(
  'name'     => 'Product Name',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true
);


$opts['fdd']['fdesc'] = array(
  'name'     => 'Deskripsi',
  'select'   => 'T',
  'maxlen'   => 250,
  'sort'     => true
);

$opts['fdd']['fdesc']['textarea']['rows'] = 5;
$opts['fdd']['fdesc']['textarea']['cols'] = 40;

$opts['fdd']['fimage'] = array(
  'name'     => 'Image',
  'select'   => 'FL',
  'maxlen'   => 11,
  'sort'     => true,
  'options'  => 'AVCP'
);


$opts['fdd']['fidcat'] = array(
  'name'     => 'Category',
  'select'   => 'T',
  'maxlen'   => 11,
  'sort'     => true,
  'default'  => 'CAT-0001',
  //'help'     => 'Khusus untuk Non Bulan Madu, abaikan untuk Bulan Madu'
);
$opts['fdd']['fidcat']['values']['table']       = 'm_catproduct'; 
$opts['fdd']['fidcat']['values']['column']      = 'fidcat'; 
$opts['fdd']['fidcat']['values']['description'] = 'fnamacat'; // optional

$opts['fdd']['fbpom'] = array(
  'name'     => 'PIRT/BPOM',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true,
  //'input'	 => 'R'

);

$opts['fdd']['fhalal'] = array(
  'name'     => 'Halal',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true,
  'values2'  => array('0' => 'Halal Indonesia', '1'=>'Halal MUI', '2' => 'Non Halal')
  

);


$opts['fdd']['fberat'] = array(
  'name'     => 'Berat (gr)',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true,
  'options'  => 'A,C,P,D,L,F'  

);



$opts['fdd']['fpaket'] = array(
  'name'     => 'Paket',
  'select'   => 'D',
  'maxlen'   => 1,
  'sort'     => true,

 
);


$opts['fdd']['fpaket']['values']['table']       = 'm_paket'; 
$opts['fdd']['fpaket']['values']['column']      = 'fpackid'; 
$opts['fdd']['fpaket']['values']['description'] = 'fpackname'; // optional


$opts['fdd']['fprogram'] = array( 
  'name'     => 'Program',
  'select'   => 'D',
  'maxlen'   => 1,
  'sort'     => true,
  'default'  => '1',

);


$opts['fdd']['fprogram']['values']['table']       = 'm_program'; 
$opts['fdd']['fprogram']['values']['column']      = 'fidprogram'; 
$opts['fdd']['fprogram']['values']['description'] = 'fnama'; // optional


$opts['fdd']['farea'] = array(
  'name'     => 'Area / Kota',
  'select'   => 'T',
  'maxlen'   => 11,
  'sort'     => true,
  //'help'     => 'Khusus untuk Non Bulan Madu, abaikan untuk Bulan Madu'
);

$opts['fdd']['farea']['values']['table']       = 'm_kotav'; 
$opts['fdd']['farea']['values']['column']      = 'fidsys'; 
$opts['fdd']['farea']['values']['description'] = 'fnamakota'; // optional


$opts['fdd']['fseller'] = array(
  'name'     => 'Perusahaan / Seller',
  'select'   => 'D',
  'maxlen'   => 1,
  'sort'     => true, 
);

$opts['fdd']['fseller']['values']['table']       = 'v_seller'; 
$opts['fdd']['fseller']['values']['column']      = 'fidmember'; 
$opts['fdd']['fseller']['values']['description'] = 'fnama'; // optional


$opts['fdd']['fhargajual1'] = array(
  'name'     => 'Harga Publish',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true,

);

$opts['fdd']['fpotong'] = array(
  'name'     => 'Potongan Harga Untuk Aminah (%)',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true,
  'default'  => '0',

);

$opts['fdd']['fhargajual2'] = array(
  'name'     => 'Harga Nett',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true,

);



$opts['fdd']['fhargajual1']['number_format'] = array(0, ',', '.');


$opts['fdd']['fvat'] = array(
  'name'     => 'Hrg. Termasuk PPN / VAT',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true,

);
/*
$opts['fdd']['fconst2']['number_format'] = array(0, ',', '.');

$opts['fdd']['fconst2'] = array(
  'name'     => 'Konstanta 2',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true,

);

$opts['fdd']['fconst3']['number_format'] = array(0, ',', '.');

$opts['fdd']['fconst3'] = array(
  'name'     => 'Konstanta 3',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true,

);

$opts['fdd']['fconst4']['number_format'] = array(0, ',', '.');


$opts['fdd']['fconst4'] = array(
  'name'     => 'Konstanta 4',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true,

);

$opts['fdd']['fconst4']['number_format'] = array(0, ',', '.');


$opts['fdd']['fhargajual2'] = array(
  'name'     => 'RO Price',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true,

);



$opts['fdd']['fhargajual3'] = array(
  'name'     => 'Price 3',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true,
  'options'  => 'A,C,P,D'  

);




$opts['fdd']['fhargajual4'] = array(
  'name'     => 'Price 4',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true,
  'options'  => 'A,C,P,D'  

);
*/

/*

$vSize='';$vArrSize='';
//if ($_POST['PME_sys_operation']=='Change' || $_POST['PME_sys_morechange']=='Apply'  || $_POST['PME_sys_operation']=='Add') {
   $vSQL="select fsize from m_size where faktif='1'";
   $db->query($vSQL);
   $vNumRows=$db->num_rows();
   $i=0;
   while($db->next_record()) {
      // $vArrSize.="'".[$db->f(0)]."'=>'".$db->f(0)."'";
      if ($i < $vNumRows)
         $vSize.="'".$db->f(0)."'=>'".$db->f(0)."',";
      else   
         $vSize.="'".$db->f(0)."'=>'".$db->f(0)."'";
         
         $vArrSize[$db->f(0)]=$db->f(0);
      $i++;
   }
   

$vColor='';$vArrColor='';
//if ($_POST['PME_sys_operation']=='Change' || $_POST['PME_sys_morechange']=='Apply'  || $_POST['PME_sys_operation']=='Add') {
   $vSQL="select fidcolor,fcolor from m_color where faktif='1' order by fcolor";
   $db->query($vSQL);
   $vNumRows=$db->num_rows();
   $i=0;
   while($db->next_record()) {
      // $vArrSize.="'".[$db->f(0)]."'=>'".$db->f(0)."'";
      if ($i < $vNumRows)
         $vColor.="'".$db->f(0)."'=>'".$db->f(0)."',";
      else   
         $vColor.="'".$db->f(0)."'=>'".$db->f(0)."'";
         
         $vArrColor[$db->f(0)]=$db->f(1);
      $i++;
   }

   
//}

/*

$opts['fdd']['fsize'] = array(
  'name'     => 'Ukuran',
  'select'   => 'M',
  'maxlen'   => 50,
  'sort'     => true,
// 'values2'  => array('S'=>'S','M'=>'M','L'=>'L','XL'=>'XL','XXL'=>'XXL'),
  'values2'  => $vArrSize,
// 'help'	 => $vArrSize

);

print_r($vArrSize,true);
*/


/*
$opts['fdd']['fidcolor'] = array(
  'name'     => 'Warna',
  'select'   => 'M',
  'maxlen'   => 50,
  'sort'     => true,
  'values2'  => $vArrColor,


);
*/
/*
$opts['fdd']['fidcolor']['values']['table']       = 'm_color'; 
$opts['fdd']['fidcolor']['values']['column']      = 'fidcolor'; 
$opts['fdd']['fidcolor']['values']['description'] = 'fcolor'; // optional


$opts['fdd']['fmodel'] = array(
  'name'     => 'Type',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true,
  'values2'  => array('Women' => 'Women','Men' => 'Men','Unisex' => 'Unisex')


); */
/*
$opts['fdd']['fpointmember'] = array(
  'name'     => 'Cashback',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true,
  'options'  => 'A,C,P,D,L,F'  

  //'values2'  => array('Women' => 'Women','Men' => 'Men','Unisex' => 'Unisex')


);

*/

$opts['fdd']['faktif'] = array(
  'name'     => 'Active',
  'select'   => 'T',
  'maxlen'   => 1,
  'default'  => '',
  'sort'     => true,
  'values2'  => array(1 => 'Active', 0=>'Inactive')
);

if ($vIsSeller) {
	foreach (array_keys($opts['fdd']) as $vFieldName) {
		if ($vFieldName == 'faktif') {
			continue;
		}

		if (!isset($opts['fdd'][$vFieldName]['input'])) {
			$opts['fdd'][$vFieldName]['input'] = 'R';
		}
		else if (strpos($opts['fdd'][$vFieldName]['input'], 'R') === false) {
			$opts['fdd'][$vFieldName]['input'] .= 'R';
		}
	}
}

$image_sub_dir = "prod";
$opts['triggers']['insert']['after']  = 'afterinsbrg.php';

	 $_POST['PME_data_fimage']=$_FILES['PME_data_fimage']['name'];
		
		if ($_FILES['PME_data_fimage'] !="" ) {
			$target_path = "../images/prod/";
			if (file_exists($target_path.$_FILES['PME_data_fimage']['name'])) {
			    if (@unlink($target_path.$_FILES['PME_data_fimage']['name'])) echo "";
				//if (@unlink($target_path."t".$_FILES['PME_data_fimage']['name'])) echo "";
			}			
			
			$target_pathori=$target_path;
			$target_path = $target_path . basename( $_FILES['PME_data_fimage']['name']); 
				
				
			if(move_uploaded_file($_FILES['PME_data_fimage']['tmp_name'], $target_path)) {
				echo "The file ".  basename( $_FILES['PME_data_fimage']['name']). 
				" Image uploaded!";
			} else{
				echo "";
			}
	
        } 


// Now important call to phpMyEdit
require_once '../classes/phpmyedit.class.php';
new phpMyEdit($opts);
/*
if ($_POST['PME_sys_operation']=='Change' || $_POST['PME_sys_morechange']=='Apply' ) {
   $vSQL="select fsize, fidcolor from m_product where fidproduk='".$_POST['PME_sys_rec']."'";
   $db->query($vSQL);
   $db->next_record();
   $vSize=$db->f(0);
   $vColor=$db->f(1);
   $vSelect = 'select';
} else {
   $vSQL="select fsize from m_size ";
   $db->query($vSQL);
   $vSize='';$i=0;
   $vNumRows=$db->num_rows();
   while($db->next_record()) {
      if ($i < $vNumRows) {
         $vSize.=$db->f(0).",";
      } else  { 
         $vSize.=$db->f(0);
      }
	  $i++;	
   }

   $vSQL="select fidcolor from m_color order by fcolor ";
   $db->query($vSQL);
   $vSize='';$i=0;
   $vNumRows=$db->num_rows();
   while($db->next_record()) {
      if ($i < $vNumRows) {
         $vColor.=$db->f(0).",";
      } else  { 
         $vColor.=$db->f(0);
      }
	  $i++;	
   }


   $vSelect='';
}
*/


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

 /*
		
        $('#PME_data_fsize').multiselect({
			   enableClickableOptGroups: true,
			   allSelectedText: 'All', 
            numberDisplayed: 15,
            includeSelectAllOption: true
			});

        $('#PME_data_fidcolor').multiselect({
			   enableClickableOptGroups: true,
			   allSelectedText: 'All', 
            numberDisplayed: 15,
            includeSelectAllOption: true
			});
		

		var data = '<?=$vSize?>';
        var valArr = data.split(",");
        var i = 0, size = valArr.length;
        for (i; i < size; i++) {
            $('#PME_data_fsize').multiselect('<?=$vSelect?>', valArr[i]);
		}

		/*var datac = '<?=$vColor?>';
        var valArrc = datac.split(",");
        var i = 0, colorc = valArrc.length;
        for (i; i < colorc ; i++) {
            $('#PME_data_fidcolor').multiselect('<?=$vSelect?>', valArrc[i]);
		}*/
		//alert($('#PME_data_fpotong').val());
		if ($('#PME_data_fpotong').val()=='')
			$('#PME_data_fpotong').val('0');

		$('#caption').html('Products');
		   	});
			
			$('.pme-search').addClass('hide');
			$('#PME_data_fpotong').attr('dir','rtl');
			$('#PME_data_fvat').attr('dir','rtl');
			var vHarga1 = parseFloat($('#PME_data_fhargajual1').val());
			
			
			$('#PME_data_fpotong').change(function(){
				var vPotong = $(this).val();
				var vNett = vHarga1 - (vHarga1 * vPotong /100);
				$('#PME_data_fhargajual2').val(vNett);
			});
			
			$('#PME_data_fhargajual1').change(function(){
				var vPotong = $('#PME_data_fpotong').val();
				var vHarga1 = $(this).val();
				var vNett = vHarga1 - (vHarga1 * vPotong /100);
				$('#PME_data_fhargajual2').val(vNett);
			});
		
</script>
  
</div>

<? include_once("../framework/admin_footside.blade.php") ; ?>
