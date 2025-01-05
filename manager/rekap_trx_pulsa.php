<? include_once("../framework/admin_headside.blade.php");

include_once("../classes/pulsaclass.php");
	include_once("../classes/antaclass.php");
	
  $vUserAnta =$oRules->getSettingByField('fantauser');
  $vPassAnta = $oRules->getSettingByField('fantapass');
  $vURLGetListPulsa = $oRules->getSettingByField('fantagetlist');
  $vURLCekBal = $oRules->getSettingByField('fantacekbal');
  $vAddNTA = $oRules->getSettingByField('fcountflush');
  
  $vData = array('username'=>$vUserAnta,'password'=>$vPassAnta);
  $vResultBal=$oPulsa->genPost($vURLCekBal,$vData,'');
  $vObjBal = json_decode($vResultBal,true);
  $vBal = $vObjBal['results']['data'];
  
  $vsTglAwal =$_POST['dc1'];
   $vsTglAkhir =$_POST['dc2'];

$vsql = "select fidmember, fnama, fsaldovcr,falamat,fprop,fkota,faktif from m_pebisnis  ";

		  $vsqltot = "select sum(fsaldovcr) as ftotsal from ($vsql) as gab where 1 and faktif <>'0' ";
		  $db->query($vsqltot);
		  $db->next_record();
		  $vBalBis = $db->f('ftotsal');

?>
<div class="right_col" role="main">
			
				 <div><label>
				 <h3>Rekap Transaksi Pulsa
                 
                  </h3>
                  <br>
                  <font color="#00f">Saldo Aminah di Anta : <?=number_format($vBal,0,",",".")?></font>
                  <br>
                  <font color="#00f">Saldo Seluruh Pebisnis : <?=number_format($vBalBis,0,",",".")?></font>
                  </label></div>


<form name="frmFilter" id="frmFilter" style="padding-bottom:2em;<?=$vFilterShow?>" method="post" >
<div class="row">
<div class="col-lg-12">
<label><h4><strong>Filter :</strong></h4></label>
</div>
<div class="col-lg-12">
<label><b>Tanggal</b></label>
 
  
<div class="col-lg-12 form-inline" >
<span class="col-lg-1" style="text-align:left;margin-top:7px">Mulai :</span> 
<input  name="dc1"  id="dc1" value="<?=$vsTglAwal?>" size="9" class="form-control" style="width:100px"  />
&nbsp; s/d &nbsp;
<input  name="dc2"  id="dc2" value="<?=$vsTglAkhir?>" size="9" class="form-control" style="width:100px" />
<input type="hidden" id="hList" name="hList" value="1" /></div>
  </div>
  </div>
  <br>
 
 
  

<div class="row">
<div class="col-lg-6 divtr">
  
    <input type="submit" name="btFilter" id="btFilter" value="Submit" class="btn btn-success ">
    <input type="button" name="btClear" id="btClear" value="Clear Filter" class="btn btn-default" onClick="document.location.href='../manager/rekap_trx_pulsa.php'">
</div>
</div>

</form>
<style type="text/css">
  table {
	  table;
  }
</style>
 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />
<script language="javascript">
  $(document).ready(function(){
	 $('input[name=PME_data_fprice]').css("direction", 'rtl');

	$('input[name=PME_data_fkurs]').css("direction", 'rtl');
	$('input[name=PME_data_fdaycount]').css("direction", 'rtl');
	$('input[name=PME_data_fassure]').css("direction", 'rtl');
	$('input[name=PME_data_fhandle]').css("direction", 'rtl');
	
	$('input[name=PME_data_fdepart]').datepicker({

                    format: "yyyy-mm-dd",
					//"setDate": new Date()

    }).on('changeDate', function (ev) {

    				$(this).datepicker('hide');

    });  

$('#dc1').datepicker({

                    format: "yyyy-mm-dd",
					//"setDate": new Date()

    }).on('changeDate', function (ev) {

    				$(this).datepicker('hide');

    });  


$('#dc2').datepicker({

                    format: "yyyy-mm-dd",
					//"setDate": new Date()

    }).on('changeDate', function (ev) {

    				$(this).datepicker('hide');

    });  
 
  });
</script>
<div class="table-responsive">
<?php
	

// MySQL host name, user name, password, database, and table
$opts['hn'] = $db->Host;
$opts['un'] = $db->User;
$opts['pw'] = $db->Password;
$opts['db'] = $db->Database;
$opts['tb'] = 'tb_trxpulsa';


// Name of field which is the unique key
$opts['key'] = 'fidsys';

// Type of key field (int/real/string/date etc.)
$opts['key_type'] = 'integer';

// Sorting field(s)
$opts['sort_field'] = array('fidtrx');

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


$opts['buttons']['L']['up'] = array('<<','<','view',
                                    '>','>>');
$opts['buttons']['L']['down'] = $opts['buttons']['L']['up'];

$opts['buttons']['F']['up'] = array('<<','<','view',
                                    '>','>>');
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
$vAddFilter='';
if ($vsTglAwal !='' && $vsTglAkhir !='') {
   $vAddFilter .= " and date(ftglentry) between '$vsTglAwal' and '$vsTglAkhir' ";
}
$opts['filters'] = 'PMEtable0.fket like \'Transaksi Pulsa%\' '.$vAddFilter;

$opts['fdd']['fidsys'] = array(
  'name'     => 'ID System',
  'select'   => 'T',
  'maxlen'   => 55,
  'sort'     => true,
  'options' =>'C',
  'input' =>'R'
  
);
//print_r($_POST);
$opts['fdd']['ftglentry'] = array(
  'name'     => 'Tanggal',
  'select'   => 'T',
  'maxlen'   => 25,
  'sort'     => true
);
	
$opts['fdd']['fidtrx'] = array(
  'name'     => 'Nomor TRX',
  'select'   => 'T',
  'maxlen'   => 25,
  'sort'     => true
);

$opts['fdd']['fidmember'] = array(
  'name'     => 'Pebisnis',
  'select'   => 'T',
  'maxlen'   => 25,
  'sort'     => true,
 //  'colattrs' => 'style="text-align:right;padding-right:30px"',
//   'number_format' => array(0, ',', '.')

/*'values'   => array(
    'table'       => 'm_pebisnis',
    'column'      => 'fidmember',
	'description'      => array('columns[0]'),
  )*/
  
); 

$opts['fdd']['fidmember']['values']['table']='m_pebisnis';
$opts['fdd']['fidmember']['values']['column']='fidmember';
$opts['fdd']['fidmember']['values']['description']['columns'][0] = 'fidmember';
$opts['fdd']['fidmember']['values']['description']['divs'][0] = '::';
$opts['fdd']['fidmember']['values']['description']['columns'][1] = 'fnama';

$opts['fdd']['fkdproduk'] = array(
  'name'     => 'Kode Produk',
  'select'   => 'T',
  'maxlen'   => 25,
  'sort'     => true,
  //'number_format' => array(0, ',', '.')
 //  'colattrs' => 'style="text-align:right;padding-right:30px"',
//   'number_format' => array(0, ',', '.')
  
); 


$opts['fdd']['fnominal'] = array(
  'name'     => 'Nominal',
  'select'   => 'T',
  'maxlen'   => 25,
  'sort'     => true,
  //'number_format' => array(0, ',', '.')
   'colattrs' => 'style="text-align:left;"',
//   'number_format' => array(0, ',', '.')
  
); 

$opts['fdd']['fhrgsumber'] = array(
  'name'     => 'Harga Anta',
  'select'   => 'T',
  'maxlen'   => 25,
  'sort'     => true,
  'number_format' => array(0, ',', '.'),
  'colattrs' => 'style="text-align:right;"',
//   'number_format' => array(0, ',', '.')
  
); 


$opts['fdd']['fhrgamh'] = array(
  'name'     => 'Harga NTA',
  'select'   => 'T',
  'maxlen'   => 25,
  'sort'     => true,
 
  'number_format' => array(0, ',', '.'),
   'colattrs' => 'style="text-align:right;"',
  
); 

$opts['fdd']['fmsisdn'] = array(
  'name'     => 'Nomor Tujuan',
  'select'   => 'T',
  'maxlen'   => 25,
  'sort'     => true,
  // 'number_format' => array(0, ',', '.')
 
);

$opts['fdd']['fstatustrx'] = array(
  'name'     => 'Status',
  'select'   => 'T',
  'maxlen'   => 25,
  'sort'     => true,
  // 'number_format' => array(0, ',', '.')
  'values2'  => array(0 => 'Berhasil', 1=>'Diproses', 11=>'Gagal', 4=>'Gagal')
 
);

$opts['fdd']['fserverresponse'] = array(
  'name'     => 'Server Response',
  'select'   => 'T',
  'maxlen'   => 25,
  'sort'     => true,
  // 'number_format' => array(0, ',', '.')
  'values2'  => array(0 => 'Berhasil', 1=>'Diproses', 11=>'Gagal', 4=>'Gagal'),
    'options'  => 'V'
  
 
);


$opts['fdd']['fprovider'] = array(
  'name'     => 'Provider',
  'select'   => 'T',
  'maxlen'   => 25,
  'sort'     => true,
  // 'number_format' => array(0, ',', '.')

 
);

// Now important call to phpMyEdit
require_once '../classes/phpmyedit.class.php';
new phpMyEdit($opts);




?>

<div class="col-lg-12" style="text-align:right;font-weight:bold;color:blue"> Total Transaksi :
<?
 $vSQL ="select sum(fhrgamh) as ftotal from tb_trxpulsa where fket like 'Transaksi Pulsa%' $vAddFilter ";
$db->query($vSQL);

while($db->next_record()) {
   echo number_format($db->f('ftotal'),0,",",".");	
}
?>
</div>
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
<script language="javascript">
$(document).ready(function(){

      $('#caption').html('User Admin Editor');
	  $(":radio").attr('checked', false)
	  $('#PME_data_fbnskorwil').attr('dir','rtl');
	  $('#PME_data_fbnssubkor').attr('dir','rtl');
});  

    function setUmum() {
   
      var vSel= document.forms[0].mychecked;
	  //alert(vSel.length);
	  var vChecked=0;
	  var vVal=0;
	  for (i=0; i<vSel.length; i++) 
  		if (vSel[i].checked == true)
		   vChecked+=1;
	  
	 if (!vSel.length)	{
		   vVal=vSel.value;
		   doShow(600,800,'wPrice','umum.php?uID='+vVal);
		   return false;
	 }

	      
	  if (vChecked==0) { 
	     alert('Pilih salah satu data voucher yang akan diedit detailnya!');
		 return false;  
	  }	 
	  for (i=0; i<vSel.length; i++) 
  		if (vSel[i].checked == true) {
		  vVal=vSel[i].value; 
		  doShow(600,800,'wPrice','tourdetail.php?uID='+vVal);
		}
		
	  
  		
   }
   
   
    function setUmum2() {
   	  var vURL=''; 
      var vSel= document.PME_sys_form.mychecked;
	//  alert(vSel.length);
	  //exit;
	  var vChecked=0;
	  var vVal=0;
	  for (i=0; i<vSel.length; i++) 
  		if (vSel[i].checked == true)
		   vChecked+=1;
	  
	 if (!vSel.length)	{//cuma 1
		   vVal=vSel.value;
		   //doShow(600,800,'wPrice','tourdetail.php?uID='+vVal);
		    vURL='../manager/koreksistock.php?op=<?=$vSpy?>'+CryptoJS.MD5(vVal.trim())+'&uMemberId='+vVal;
		   document.location.href=vURL;
		   return false;
	 }

	      
	  if (vChecked==0) { 
	     alert('Pilih salah satu outlet yang akan dikoreksi stoknya!');
		 return false;  
	  }	 
	  for (i=0; i<vSel.length; i++) 
  		if (vSel[i].checked == true) {
		  vVal=vSel[i].value; 
		  //doShow(600,800,'wPrice','tourdetail.php?uID='+vVal);
		   vURL='../manager/koreksistock.php?op=<?=$vSpy?>'+CryptoJS.MD5(vVal.trim())+'&uMemberId='+vVal;
		  document.location.href=vURL;
		//  alert(vURL);
		  exit;
		}
		
	  
  		
   }      
</script>
  </div>

	
<? include_once("../framework/admin_footside.blade.php") ; ?>