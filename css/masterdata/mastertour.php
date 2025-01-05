<? include_once("../framework/admin_headside.blade.php")?>
<div class="right_col" role="main">
			
				 <div><label>
				 <h3>Master Umroh dan Tour</h3></label></div>

<style type="text/css">
  table {
	  table;
  }
</style>
 
<script language="javascript">

$(document).ready(function(){





$('#PME_data_fexpired').datepicker({

                    format: "yyyy-mm-dd"

    }).on('changeDate', function (ev) {

    $(this).datepicker('hide');

    });  
});  

   function addDetail() {
   
      var vSel= document.forms[0].mychecked;
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
      var vSel= document.forms[0].mychecked;
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
   
      var vSel= document.forms[0].mychecked;
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



if (trim($_GET['uID'])!="")
   $opts['filters'] = 'fidtour ="'.trim($_GET['uID']).'" and fpaket="1" ';
else   
   $opts['filters'] = 'fpaket="1"';

$opts['fdd']['fidsys'] = array(
  'name'     => 'ID Sys',
  'select'   => 'T',
  'maxlen'   => 1,
  'sort'     => true,
  'input'	 => 'R',
  'options'	 => 'APC'
  
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


$opts['fdd']['fgroup'] = array(
  'name'     => 'Group',
  'help'     => 'Contoh : Tour / Umroh',
  'select'   => 'T',
  'maxlen'   => 254,
  'sort'     => true,
  'values2'    => array('t' => 'Tour Internasional','u' => 'Umroh','d' => 'Tour Domestik')
);


$opts['fdd']['fjmlhari'] = array(
  'name'     => 'Jml Hari',
  'help'     => 'Khusus Umroh',
  'select'   => 'T',
  'maxlen'   => 10,
  'sort'     => true,
  'values2'    => array(9=>'9',10=>'10',11=>'11',12=>'12',13=>'13',14=>'14',15=>'15',16=>'16',17=>'17',18=>'18',19=>'19',20=>'20',21=>'21')
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
  'options'  => 'FLAVCPD',
  'maxlen'   => 100,
  'help|APV' => '',
  'sort'     => true

);

$opts['fdd']['fpaket'] = array(
  'name'     => 'Paket',
  'select'   => 'D',
  'maxlen'   => 1,
  'sort'     => true,
  'default'  => '1',
  'values2'    => array('1' => 'Reguler')
);






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

$opts['fdd']['fhargax'] = array(
  'name'     => 'Harga NTA',
  'select'   => 'T',
  'maxlen'   => 9,
  'default'  => '0',
   'number_format' => array(0, ',', '.'),
  'sort'     => true,
  'sql'     => 'fhargapub - 0',
  'input'   => 'R'

);

$opts['fdd']['fhargapub'] = array(
  'name'     => 'Harga Published',
  'select'   => 'T',
  'maxlen'   => 9,
  'default'  => '0',
   'number_format' => array(0, ',', '.'),
  'sort'     => true

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

$opts['fdd']['fcango'] = array(
  'name'     => 'Jenis Tour',
  'select'   => 'O',
  'maxlen'   => 1,
  'sort'     => true,
  'default'  => '0',
  'values2'    => array('1' => '2 Can Go', '0' => 'Normal'),
  // 'options'  => 'ACPV'
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



$picker =$picker ='<a href="javascript:void(0)" onclick="if(document.forms[0].PME_data_fexpired.value==\'\') {{var today=new Date();  document.forms[0].PME_data_fexpired.value=dateAdd(today.format(\'n/j/Y\'),14,\'D\');};} if(self.gfPop)gfPop.fPopCalendar(document.forms[0].PME_data_fexpired);return false;" ><img src="calbtn.gif" alt="" name="popcal" width="34" height="22" border="0" align="absmiddle" id="popcal" /></a> Pilih Tanggal';

$opts['fdd']['fexpired'] = array(
  'name'     => 'Expired',
  'select'   => 'T',
  'options'  => 'LFAVCPD',
  'maxlen'   => 19,
  'help|APV' => 'Format: yyyy-mm-dd',
  'sort'     => true,
  'help|APC' => $picker,
  'escape'   => false,
  'nowrap'   => true  
);

$opts['fdd']['fexpired']['sql|LF'] = 'if( "'.date("Y-m-d").'" >= fexpired , CONCAT("<span style=\"color:#ff0000\"><strong>", date(fexpired), "</strong></span>"), date(fexpired) )';





$opts['fdd']['fketpaket'] = array(
  'name'     => '<strong>Satuan Paket</strong>',
  'select'   => 'D',
  'maxlen'   => 1,
  'sort'     => true,
  'default'  => '0',
  'values2'    => array('Per Pax' => 'Per Pax', 'Per Couple' => 'Per Couple', 'Per Entourage'=>'Per Entourage')
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
  
  
<script type="text/javascript" src="../js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<script type="text/javascript" src="../js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>

<script type="text/javascript" src="../js/bootstrap-daterangepicker/moment.min.js"></script>

<script type="text/javascript" src="../js/bootstrap-daterangepicker/daterangepicker.js"></script>

<script type="text/javascript" src="../js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>

<script type="text/javascript" src="../js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>

	
<? include_once("../framework/admin_footside.blade.php") ; ?>