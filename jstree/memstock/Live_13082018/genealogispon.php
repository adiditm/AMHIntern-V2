<? 
		if ($_GET['uMemberId'] != '') 
           include_once("../framework/admin_headside.blade.php");
        else
           include_once("../framework/member_headside.blade.php") ;  
?>
<?
 error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
  //$oSystem->doED("decrypt",'RCtuaXgrTnowZmtnKzl6Z2JXNXN4Zz09');
  $vUser=$_SESSION['LoginUser'];
  $vRefUser=$_GET['uMemberId'];
  $vRefer= $_SERVER['HTTP_REFERER'];
  if (preg_match("/aktif.php/i",$vRefer,$var))
     $vFirst='1';
  else $vFirst='0';   

   $oSystem->getPriv($vUser);
  
  $vSpy = md5('spy').md5($_GET['uMemberId']);
  if ($_GET['op'] == $vSpy)
     $_SESSION['sop']=$vSpy;
  	
  //echo $vUserChoosed;
  $vCrit=$_POST['tfCrit'];
  $vAction=$_POST['hAction'];

  if($vUserChoosed=="" && $vPriv!="administrator") 
     $vUserChoosed=$vUser;
  else	 
     $vUserChoosed=$oMember->getFirstID();


	 
  if ($_GET['uTop']!="")
  $vUserChoosed=$_GET['uTop']; 	 
  
 // if ($oSystem->getPriv($vRefUser)==-1)
 //    $vUserChoosed=$vRefUser;


  if ($oNetwork->isInNetwork($vUserChoosed,$vUser)==-1 && $vPriv != "administrator")
     $vUserChoosed=$vUser;

//  if($oNetwork->isInNetwork($vUserChoosed,$vUser)==-1) $vUserChoosed=$vUser;
  //$vUserChoosed=;

	
  if ($vAction=="cari") { 
     if( $oSystem->getPriv($vUser)=='administrator') {
		  if ($oNetwork->isInNetwork($vCrit,'SMS964891346')=='1')
			 $vUserChoosed=$vCrit; 
		  else
			 $oSystem->jsAlert("Downline tidak ada, atau tidak berada dalam jaringan Anda!");	 
     
	  } else {
	  
		  if ($oNetwork->isInNetwork($vCrit,$vUser)=='1')
			 $vUserChoosed=$vCrit; 
		  else
			 $oSystem->jsAlert("Downline tidak ada, atau tidak berada dalam jaringan Anda!");	 

	} 	 
	  
  }

?>
<style type="text/css">
.ttclass {
 opacity:1;
 background-color:#eee;
 border:1px solid;
 border-radius:3px;
 
 
}




.fa-user {
  color:#06F;
  padding-right:2px;
  font-size:1.2em;
}

.fa-group {
  color:#006;
  padding-right:2px;
  font-size:1.2em;
}
</style>
<script language="Javascript">
$(document).ready(function(){
      $('#caption').html('Genealogi Sponsorship');

    $('[data-toggle="tooltip"]').tooltip({tooltipClass:"ttclass"}); 
    
    if ('<?= $_SESSION["sop"]?>' == '<?=$vSpy?>'  && '<?=$vFirst?>' == '1') {
       document.getElementById('tfCrit2').value='<?=$vRefUser?>';
       document.frmFilter.submit();
    }
    
    $('.jstree-icon').trigger('click');
     $('.jstree-clicked').trigger('click');
    

 

});	

	

	
</script>



<body class="sticky-header">
<? //echo $_SESSION['LoginUser']."dddddddddddddddd";?>
 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />
  <link rel="stylesheet" href="../jstree/dist/themes/default/style.min.css" />

 <div class="content-wrapper" style="min-height:40em" >
<section class="content" >


<p align="center" class="style1">Genealogy<br> 
  </p>

<table width="500"  border="0" align="center" cellpadding="0" cellspacing="0">
   <tr align="lefty" valign="top">
    <td style="width: 500px"><form id="frmFilter" name="frmFilter" method="post">
        <strong>Search Username </strong>
      <input name="tfCrit" type="text" class="inputborder" id="tfCrit2" value="<?=$vCrit?>">
&nbsp;
  <input name="btnCari" type="submit" id="btnCari" value="Search">
  <input name="hAction" type="hidden" id="hAction" value="cari">
  <br>
  <br>
        </form></td>
  </tr>
  </table>

	
	<h5><b>Sponsorhip</b></h5>
	<div id="lazy" class="demo"></div>

	
<!--	<script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script> -->
	<script src="../jstree/dist/jstree.min.js"></script>
	
	<script>
	// html demo
	
	

	// lazy demo
	$('#lazy').jstree({
	    // "plugins" : [ "wholerow" ],



		'core' : {
			'data' : {
				"url" : "../memstock/spontree.php?lazy&top=<?=$vUserChoosed?>",
				"data" : function (node) {
				//alert(node.id);
					return { "id" : node.id };
				}
			}
		}
	}).bind("loaded.jstree", function (event, data) {
     $(this).jstree("open_node", '1');
    // $('#lazy').set_icon(node, "../images/plus.png");
    // $('i.jstree-icon').not('i.jstree-file').removeClass('jstree-themeicon jstree-icon jstree-folder').addClass('fa fa-user');
});
	
	
/*	
	$('#lazy').on("changed.jstree", function (e, data) {
  console.log(data.selected);
});*/

$('#lazy').on('select_node.jstree', function (e, data) {
    data.instance.toggle_node(data.node);
	$('i.jstree-icon').not('i.jstree-file').not('i.jstree-ocl').removeClass('jstree-themeicon jstree-icon jstree-folder').addClass('fa fa-group');
	$('i.jstree-file').not('i.jstree-ocl').removeClass('jstree-themeicon jstree-icon jstree-file').addClass('fa fa-user');
});

$('#lazy').on('open_node.jstree', function (e, data) {
	$('i.jstree-icon').not('i.jstree-file').not('i.jstree-ocl').removeClass('jstree-themeicon jstree-icon jstree-folder').addClass('fa fa-group');
	$('i.jstree-file').not('i.jstree-ocl').removeClass('jstree-themeicon jstree-icon jstree-file').addClass('fa fa-user');
//alert('open');
});
//$('div#lazy').on('ready.jstree click', function (e, data) { $('i.jstree-icon').removeClass('jstree-themeicon jstree-icon').addClass('fa  fa-user'); });

	</script>
</div>


<!-- Placed js at the end of the document so the pages load faster -->

<script src="../js/jquery-ui-1.9.2.custom.min.js"></script>
<script src="../js/jquery-migrate-1.2.1.min.js"></script>

<script src="../js/modernizr.min.js"></script>
<script src="../js/jquery.nicescroll.js"></script>
<script src="../js/jquery.price_format.js"></script>




<script type="text/javascript" src="../js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="../js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="../js/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="../js/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="../js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="../js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<!--common scripts for all pages-->
<script src="../js/pickers-init.js"></script>



<?

           include_once("../framework/member_footside.blade.php");

?>
