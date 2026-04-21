<? include_once("../framework/admin_headside.blade.php")?>


<div class="right_col" role="main">
			
				 <div><label>
				 <h3>Master Umroh, Haji dan Tour</h3></label></div>

<?
   //print_r($_POST);
   
   $vCodePost=$_POST['lmGroup'];
   $vNamaPost=$_POST['tfNamaProd'];	
   if (in_array($_POST['menu=mastertour&PME_sys_operation'],array('Add','View','Copy','More','Delete','Change')))
      $vFilterShow='display:none';
   else	  $vFilterShow='';
?>

<style type="text/css">
  table {
	  table;
  }
  .pme-input-0 {
       min-width:90px !important;
       
  }
  .divtr {
	 margin-top:1em;  
  }
</style>
<form name="frmFilter" id="frmFilter" style="padding-bottom:2em;<?=$vFilterShow?>" method="post" >
<div class="row">
<div class="col-lg-6">
<label><h4><strong>Filter :</strong></h4></label>
<br>

<label><b>Jenis / Group</b></label>
  <select name="lmGroup"  class="form-control" >
     <option value="">--Pilih--</option>
	 <option value="u" <? if ($vCodePost=='u') echo selected ?>>Umroh</option>
     <option value="h" <? if ($vCodePost=='h') echo selected ?>>Haji</option>
     <option value="d" <? if ($vCodePost=='d') echo selected ?>>Tour Domestik</option>
     <option value="t" <? if ($vCodePost=='t') echo selected ?>>Tour Internasional</option>
  </select>
  </div>
  </div>
  <br>
  

<div class="row">
<div class="col-lg-6 divtr">
  
    <input type="submit" name="btFilter" id="btFilter" value="Submit" class="btn btn-success ">
    <input type="button" name="btClear" id="btClear" value="Clear Filter" class="btn btn-default" onClick="document.location.href='../masterdata/mastertour.php'">
</div>
</div>

</form>
<style type="text/css">
  table {
	  table;
  }
</style>
 
<script language="javascript">

$(document).ready(function(){



  $('#PME_data_fjmlhari').select2();
  $('#PME_data_fcitydepart').select2();
   $('#PME_data_fexpired').attr('autocomplete','off');
     $('#PME_data_ftgldepart').attr('autocomplete','off');

  $('#PME_data_fexpired').datepicker({

                    format: "yyyy-mm-dd"

    }).on('changeDate', function (ev) {

    $(this).datepicker('hide');

    });  
	
 $('#PME_data_ftgldepart').datepicker({

                    format: "yyyy-mm-dd"

    }).on('changeDate', function (ev) {

    $(this).datepicker('hide');

    });  
		
});  

   function addDetail() {
   
      var vSel= document.forms[1].mychecked;
   //   alert(document.forms[0]);
	  //alert(vSel.length);
	  var vChecked=0;
	  var vVal=0;
	  for (i=0; i<vSel.length; i++) 
  		if (vSel[i].checked == true)
		   vChecked+=1;
	  
	 if (!vSel.length)	{
		   vVal=vSel.value;
		   doShow(600,800,'wPrice','tourdetail.php?uID='+vVal);
		   return false;
	 }

	      
	  if (vChecked==0) { 
	     alert('Pilih salah satu data  yang akan diedit detailnya!');
		 return false;  
	  }	 
	  for (i=0; i<vSel.length; i++) 
  		if (vSel[i].checked == true) {
		  vVal=vSel[i].value; 
		  doShow(600,800,'wPrice','tourdetail.php?uID='+vVal);
		}
		
	  
  		
   }
 
   function addGal() {
      var vSel= document.forms[1].mychecked;
	  var vChecked=0;
	  var vVal=0;
	  for (i=0; i<vSel.length; i++) 
  		if (vSel[i].checked == true)
		   vChecked+=1;

	 if (!vSel.length)	{
		   vVal=vSel.value;
		   doShow(500,700,'wPrice','tgal.php?uID='+vVal);
		   return false;
	 }

	  	
	  if (vChecked==0) { 
	     alert('Pilih salah satu data voucher yang akan ditambahkan Gallery!');
		 return false;  
	  }	 
	  for (i=0; i<vSel.length; i++) 
  		if (vSel[i].checked == true) {
		  vVal=vSel[i].value; 
		  doShow(500,700,'wPrice','tgal.php?uID='+vVal);
		}
	  
  		
   }
 

  function addHrg() {
   
      var vSel= document.forms[1].mychecked;
	  //alert(vSel.length);
	  var vChecked=0;
	  var vVal=0;
	  for (i=0; i<vSel.length; i++) 
  		if (vSel[i].checked == true)
		   vChecked+=1;
	  
	 if (!vSel.length)	{
		   vVal=vSel.value;
		   doShow(600,800,'wPrice','tprice.php?uID='+vVal);
		   return false;
	 }

	      
	  if (vChecked==0) { 
	     alert('Pilih salah satu data voucher yang akan diedit detailnya!');
		 return false;  
	  }	 
	  for (i=0; i<vSel.length; i++) 
  		if (vSel[i].checked == true) {
		  vVal=vSel[i].value; 
		  doShow(600,800,'wPrice','tprice.php?uID='+vVal);
		}
		
	  
  		
   }

   
function doShow(windowHeight, windowWidth, windowName, windowUri)
{
    var centerWidth = (window.screen.width - windowWidth) / 2;
    var centerHeight = (window.screen.height - windowHeight) / 2;

    newWindow = window.open(windowUri, windowName, 'scrollbars=1, resizable=0,width=' + windowWidth + 
        ',height=' + windowHeight + 
        ',left=' + centerWidth + 
        ',top=' + centerHeight);

    newWindow.focus();
    return newWindow.name;
}//-->

function dateAdd(date,days,intv) {
    var mydate = new Date(date);
    return mydate.Add(intv, days).format('Y-m-d');
}
</script>

<?php

   define("MENU_ID", "mdm_setting_mtour");


   if ($oSystem->authAdminNP($vUser)==0) {
      $oSystem->jsAlert("Not Authorized!");
      $oSystem->jsLocation("logout.php");
   }
 //$vBonusReg=$oRules->getSettingByCol('fbnsumrreg');
$opts['hn'] = $db->Host;
$opts['un'] = $db->User;
$opts['pw'] = $db->Password;
$opts['db'] = $db->Database;
$opts['tb'] = 'm_tour';

//$opts['buttons']['L']['down'] = array('<<','<','add','change','copy','view','delete','>','>>','goto','goto_combo','<input type="button"  name="menu=mastertour&amp;PME_sys_operation" value="Edit Overv&Detil" onClick="addDetail()"/>','<input type="button"  name="menu=mastertour&amp;PME_sys_operation" value="Gallery" onClick="addGal()"/>','<input type="button"  name="menu=mastertour&amp;PME_sys_operation" value="Paket Harga" onClick="addHrg()"/>');
//$opts['buttons']['F']['down'] = array('<<','<','add','change','copy','view','delete','>','>>','goto','goto_combo','<input type="button"  name="menu=mastertour&amp;PME_sys_operation" value="Edit Overv&Detil" onClick="addDetail()"/>','<input type="button"  name="menu=mastertour&amp;PME_sys_operation" value="Gallery" onClick="addGal()"/>','<input type="button"  name="menu=mastertour&amp;PME_sys_operation" value="Paket Harga" onClick="addHrg()"/>');
$opts['buttons']['L']['down'] = array('<<','<','add','change','copy','view','delete','>','>>','goto','goto_combo','<input type="button"  name="menu=mastertour&amp;PME_sys_operation" value="Edit Detil" onClick="addDetail()"/>');
$opts['buttons']['F']['down'] = array('<<','<','add','change','copy','view','delete','>','>>','goto','goto_combo','<input type="button"  name="menu=mastertour&amp;PME_sys_operation" value="Edit Detil" onClick="addDetail()"/>');


// Name of field which is the unique key
$opts['key'] = 'fidsys';

// Type of key field (int/real/string/date etc.)
$opts['key_type'] = 'int';

// Sorting field(s)
$opts['sort_field'] = array('fidtour');

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
	'query' => false,
	'sort'  => true,
	'time'  => true,
	'tabs'  => true
);

// Set default prefixes for variables
$opts['js']['prefix']               = 'PME_js_';
$opts['dhtml']['prefix']            = 'PME_dhtml_';
$opts['cgi']['prefix']['operation'] = 'PME_op_';
$opts['cgi']['prefix']['sys']       = 'menu=mastertour&PME_sys_';
$opts['cgi']['prefix']['data']      = 'PME_data_';

/* Get the user's default language and use it if possible or you can
   specify particular one you want to use. Refer to official documentation
   for list of available languages. */
$opts['language'] = $_SERVER['HTTP_ACCEPT_LANGUAGE'] . '-UTF8';



if (trim($vCodePost !=""))
   $opts['filters'] = "fgroup ='".$vCodePost."'";

$opts['fdd']['fidsys'] = array(
  'name'     => 'ID Sys',
  'select'   => 'T',
  'maxlen'   => 1,
  'sort'     => true,
  'input'	 => 'R',
  'options'	 => 'PC'
  
);

$opts['fdd']['fgroup'] = array(
  'name'     => 'Group',
  'help'     => 'Contoh : Tour / Umroh',
  'select'   => 'T',
  'maxlen'   => 254,
  'sort'     => true,
  'values2'    => array('u' => 'Umroh','h' => 'Haji','t' => 'Tour Internasional','d' => 'Tour Domestik')
);
$opts['fdd']['fidtour'] = array(
  'name'     => 'ID Tour',
  'help'     => 'Contoh : T-001, T123A',
  'select'   => 'T',
  'maxlen'   => 55,
  'sort'     => true,
  'nowrap'     => true
);



$opts['fdd']['fdesc'] = array(
  'name'     => 'Desc Tour',
  'help'     => 'Contoh : Bali - Seminyak',
  'select'   => 'T',
  'maxlen'   => 254,
  'sort'     => true,
  'colattrs' => ''
);

$opts['fdd']['ftgldepart'] = array(
  'name'     => 'Tgl Berangkat',
 // 'help'     => 'Contoh : Bali - Seminyak',
  'select'   => 'T',
  'maxlen'   => 254,
  'sort'     => true,
  'colattrs' => ''
);

$opts['fdd']['fcitydepart'] = array(
  'name'     => 'Kota Berangkat',
 // 'help'     => 'Contoh : Jakarta',
  'select'   => 'D',
  'maxlen'   => 254,
  'sort'     => true,
  'colattrs' => ''
);

$opts['fdd']['fcitydepart']['values']['table']       = 'm_wilayah';
$opts['fdd']['fcitydepart']['values']['column']      = 'fnamawil';
$opts['fdd']['fcitydepart']['values']['description'] = 'fnamawil';
$opts['fdd']['fcitydepart']['values']['filters']     = "fkec='00' and fdeskel='0000' and fkabkota <> '00'";



$opts['fdd']['fjmlhari'] = array(
  'name'     => 'Jml Hari',
  'help'     => 'Khusus Umroh',
  'select'   => 'T',
  'maxlen'   => 10,
  'sort'     => true,
  //'values2'    => array(9=>'9',10=>'10',11=>'11',12=>'12',13=>'13',14=>'14',15=>'15',16=>'16',17=>'17',18=>'18',19=>'19',20=>'20',21=>'21')
  'values2'    => array(
1=>1,
2=>2,
3=>3,
4=>4,
5=>5,
6=>6,
7=>7,
8=>8,
9=>9,
10=>10,
11=>11,
12=>12,
13=>13,
14=>14,
15=>15,
16=>16,
17=>17,
18=>18,
19=>19,
20=>20,
21=>21,
22=>22,
23=>23,
24=>24,
25=>25,
26=>26,
27=>27,
28=>28,
29=>29,
30=>30,

)
);


/*
$opts['fdd']['fdescen'] = array(
  'name'     => 'Desc Tour (English)',
  'help'     => 'Contoh : Bali - Seminyak',
  'select'   => 'T',
  'maxlen'   => 254,
  'sort'     => true
);
*/
$opts['fdd']['fimage'] = array(
  'name'     => 'Image',
  'select'   => 'FL',
  'maxlen'   => 11,
  'sort'     => true,
  'options'  => 'AVCP'
);

$opts['fdd']['falamat'] = array(
  'name'     => 'Alamat',
  'select'   => 'T',
  'options'  => 'ACPV',
  'maxlen'   => 100,
  'help|APV' => '',
  'sort'     => true

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
  'name'     => 'ID Area / Kota',
  'select'   => 'T',
  'maxlen'   => 11,
  'sort'     => true,
  //'help'     => 'Khusus untuk Non Bulan Madu, abaikan untuk Bulan Madu'
);

$opts['fdd']['farea']['values']['table']       = 'm_kotav'; 
$opts['fdd']['farea']['values']['column']      = 'fidsys'; 
$opts['fdd']['farea']['values']['description'] = 'fnamakota'; // optional


$opts['fdd']['fcountry'] = array(
  'name'     => 'Negara',
  'select'   => 'T',
  'maxlen'   => 11,
  'sort'     => true,
  //'help'     => 'Khusus untuk Non Bulan Madu, abaikan untuk Bulan Madu'
);

$opts['fdd']['fcountry']['values']['table']       = 'm_countryprd'; 
$opts['fdd']['fcountry']['values']['column']      = 'fiso'; 
$opts['fdd']['fcountry']['values']['description'] = 'fprintname'; // optional





$opts['fdd']['fcurr'] = array(
  'name'     => 'Currency',
  'help'     => 'Contoh : IDR, USD, EUR',
  'select'   => 'T',
  'maxlen'   => 10,
  'sort'     => true,
  'options'  => 'ACPV'
);

$opts['fdd']['fcurrsym'] = array(
  'name'     => 'Currency Symbol',
  'help'     => 'Contoh : Rp, $, ',
  'select'   => 'T',
  'maxlen'   => 10,
  'sort'     => true
);
/*
$opts['fdd']['fhargax'] = array(
  'name'     => 'Harga NTA',
  'select'   => 'T',
  'maxlen'   => 9,
  'default'  => '0',
   'number_format' => array(0, ',', '.'),
  'sort'     => true,
  'sql'     => 'fhargapub - 0',
  'input'   => 'R'

); */

$opts['fdd']['fhargapub'] = array(
  'name'     => 'Harga Published',
  'select'   => 'T',
  'maxlen'   => 9,
  'default'  => '0',
   'number_format' => array(0, ',', '.'),
  'sort'     => true

);


$opts['fdd']['fhargapub2'] = array(
  'name'     => 'Harga Published Double',
  'select'   => 'T',
  'maxlen'   => 9,
  'default'  => '0',
   'number_format' => array(0, ',', '.'),
  'sort'     => true

);


$opts['fdd']['fhargapub3'] = array(
  'name'     => 'Harga Published Triple',
  'select'   => 'T',
  'maxlen'   => 9,
  'default'  => '0',
   'number_format' => array(0, ',', '.'),
  'sort'     => true

);

$opts['fdd']['fhargapub4'] = array(
  'name'     => 'Harga Published Quad',
  'select'   => 'T',
  'maxlen'   => 9,
  'default'  => '0',
   'number_format' => array(0, ',', '.'),
  'sort'     => true

);

$opts['fdd']['fplane'] = array(
  'name'     => 'Pesawat',
  'help'     => 'Contoh : Lion Air',
  'select'   => 'T',
  'maxlen'   => 254,
  'sort'     => true,
  'colattrs' => '',
  'options'  => 'ACPV',
);

$opts['fdd']['fplane'] = array(
  'name'     => 'Pesawat',
  'help'     => 'Contoh : Lion Air',
  'select'   => 'T',
  'maxlen'   => 254,
  'sort'     => true,
  'colattrs' => '',
  'options'  => 'ACPV',
);

$opts['fdd']['fhotel'] = array(
  'name'     => 'Hotel',
 // 'help'     => 'Contoh : Lion Air',
  'select'   => 'T',
  'maxlen'   => 254,
  'sort'     => true,
  'colattrs' => '',
  'options'  => 'ACPV',
);


$opts['fdd']['fassure'] = array(
  'name'     => 'Biaya Asuransi',
 // 'help'     => 'Contoh : Lion Air',
  'select'   => 'T',
  'maxlen'   => 254,
  'sort'     => true,
  'colattrs' => '',
  'options'  => 'ACPV',
);

$opts['fdd']['fhandle'] = array(
  'name'     => 'Biaya Airport Handle',
 // 'help'     => 'Contoh : Lion Air',
  'select'   => 'T',
  'maxlen'   => 254,
  'sort'     => true,
  'colattrs' => '',
  'options'  => 'ACPV',
);

$opts['fdd']['fsisaseat'] = array(
  'name'     => 'Sisa Seat Pesawat',
 // 'help'     => 'Contoh : Lion Air',
  'select'   => 'T',
  'maxlen'   => 254,
  'sort'     => true,
  'colattrs' => '',
  'options'  => 'ACPV',
);


$opts['fdd']['fkurs'] = array(
  'name'     => 'Kurs',
 // 'help'     => 'Contoh : Lion Air',
  'select'   => 'T',
  'maxlen'   => 254,
  'sort'     => true,
  'colattrs' => ''
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
  'select'   => 'T',
  'maxlen'   => 1,
  'sort'     => true,
  'values2'    => array('1' => 'Aktif', '0' => 'Tidak'),
   'options'  => 'ACPV'
);

$opts['fdd']['fcango'] = array(
  'name'     => 'Jenis Tour',
  'select'   => 'O',
  'maxlen'   => 1,
  'sort'     => true,
  'default'  => '0',
  'values2'    => array('1' => '2 Can Go', '0' => 'Normal'),
  'input'  => 'H',
  'options' => 'ACPV'
);


$opts['fdd']['fuserid'] = array(
  'name'     => 'Last User',
  'select'   => 'T',
  'maxlen'   => 55,
  'sort'     => true,
  'default'  => $_SESSION['LoginUser'],
   'values'   => array($_SESSION['LoginUser']),
   'options' => 'ACVP'
);




$opts['fdd']['fexpired'] = array(
  'name'     => 'Expired',
  'select'   => 'T',
  'options'  => 'LFAVCPD',
  'maxlen'   => 19,

  'sort'     => true,

  'escape'   => false,
  'nowrap'   => true  ,
 
);

$opts['fdd']['fexpired']['sql|LF'] = 'if( "'.date("Y-m-d").'" >= fexpired , CONCAT("<span style=\"color:#ff0000\"><strong>", date(fexpired), "</strong></span>"), date(fexpired) )';





$opts['fdd']['fketpaket'] = array(
  'name'     => '<strong>Satuan Paket</strong>',
  'select'   => 'D',
  'maxlen'   => 1,
  'sort'     => true,
  'default'  => '0',
  'values2'    => array('Per Pax' => 'Per Pax', 'Per Couple' => 'Per Couple', 'Per Entourage'=>'Per Entourage'),
  'options' => 'ACPV'
);




$opts['triggers']['insert']['after']  = 'afterinstour.php';
//$opts['triggers']['delete']['pre']  = 'beforedeltour.php';
//image
		
		 $_POST['PME_data_fimage']=$_FILES['PME_data_fimage']['name'];
		
		if ($_FILES['PME_data_fimage'] !="" ) {
			$target_path = "../images/user/";
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
require_once CLASS_DIR.'phpmyedit.class.php';
//require_once CLASS_DIR.'pme-mce-cal.class.php';
//new phpMyEdit_mce_cal($opts);
new phpMyEdit($opts);

?>

  </div>
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />
  
<script type="text/javascript" src="../js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<script type="text/javascript" src="../js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>

<script type="text/javascript" src="../js/bootstrap-daterangepicker/moment.min.js"></script>

<script type="text/javascript" src="../js/bootstrap-daterangepicker/daterangepicker.js"></script>

<script type="text/javascript" src="../js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>

<script type="text/javascript" src="../js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>

	
<? include_once("../framework/admin_footside.blade.php") ; ?>
