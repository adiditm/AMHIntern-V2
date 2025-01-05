<?
  session_start();
  include_once "../config.php";
  include_once "../classes/ifaceclass.php";
  include_once "../classes/systemclass.php";
  include_once "../classes/dateclass.php";

  $vPriv=$_SESSION['Priv']; 
  define("MENU_ID", "royal_page_edit");   
 //  if (($vPriv!="1") && ($vPriv!="2")){//
	//$oSystem->jsAlert("Not Authorized");
	//$oSystem->jsLocation("logout.php");
//}
   
   $vID=$_GET['uID'];
   $vSQL="select * from tb_topup where fidtopup='$vID'";
   $db->query($vSQL);
   while ($db->next_record()) {
      $vIDV=$db->f("fidtopup");
	  $vID=$db->f("fidmember");
	  $vTanggal=$db->f("ftglupdate");
	  $vTglAppv=$db->f("ftglappv");
	  $vStatus=$db->f("fstatusrow");
	  $vKet=$db->f("fket");
	  $vAdmin=$db->f("fadmin");
	  $vJml=$db->f("fnominal");
   }
       
  	    
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Topup Info</title>

<!-- TinyMCE -->
<script type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
function myFileBrowser (field_name, url, type, win) {
	 var cmsURL = 'upload.php'   ;  // <-------- PERHATIKAN INI !
	 if (cmsURL.indexOf("?") < 0) {
	   cmsURL = cmsURL + "?type=" + type;
	 }
	 else {
	   cmsURL = cmsURL + "&type=" + type;
	 }
	 tinyMCE.activeEditor.windowManager.open({
		 file : cmsURL,
		 title : 'My File Browser',
		 width : 420,  // Your dimensions may differ - toy around with them!
		 height : 400,
		 resizable : "yes",
		 inline : "yes",  // This parameter only has an effect if you use the inlinepopups plugin!
		 close_previous : "no"
	 }, {
	 window : win,
	 input : field_name
	 });
	 return false;
}


	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example word content CSS (should be your site CSS) this one removes paragraph margins
		content_css : "css/word.css",
		file_browser_callback : 'myFileBrowser',
		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
<!-- /TinyMCE -->
<script language="javascript">
<!--

function changeMenu() {
      var menuName=document.frmEditor.lmMenu.value;
	  window.location='admin.php?menu=editor&uMenuname='+menuName;
   }
//-->
</script>
<link rel="stylesheet" href="css/admin.css" type="text/css" />
<style type="text/css">
<!--
.style1 {
	color: #0000FF;
	font-size: 11px;
	font-weight: bold;
}
-->
</style>
</head>
<body>
<form method="post"  name="frmEditor" onsubmit="return confirm('Yakin menyimpan Overview & Detail?')">
	<table width="90%"  border="0" align="center" cellpadding="1" cellspacing="1" style="font-family:Tahoma,Verdana" class="tabelrekap">
      <tr>
        <td colspan="3" align="center">
          <p><strong>Detail Topup </strong></p>          </td>
      </tr>
      <tr>
        <td width="33%"><div align="left">ID Topup </div></td>
        <td width="2%"><div align="left">:</div></td>
        <td width="65%"><div align="left">
          <?=$vIDV?>
        </div></td>
      </tr>
      <tr>
        <td><div align="left">Login ID</div></td>
        <td>:</td>
        <td><div align="left">
          <?=$vID?>
        </div></td>
      </tr>
      <tr>
        <td><div align="left">Tanggal</div></td>
        <td>:</td>
        <td><div align="left">
          <?=$oPhpdate->YMD2DMY($vTanggal,"-")?>
        </div></td>
      </tr>
     <tr>
        <td><div align="left">Status</div></td>
        <td>:</td>
        <td><div align="left">
          <?
             if ($vStatus=='2' || $vStatus=='1')
			    echo 'Approved';
			 else if ($vStatus=='0')
			    echo 'Pending';	
			 else if ($vStatus=='4')	
			    echo 'Cancel / Reject';	
		  ?>
        </div></td>
      </tr>
     <tr>
       <td>Jumlah</td>
       <td>:</td>
       <td><?=number_format($vJml,0,",",".")?></td>
     </tr>      
      <tr>
        <td><div align="left">Tgl Approve/Reject</div></td>
        <td><div align="left">:</div></td>
        <td><div align="left">
          <? 
		    if ($vStatus=='2' || $vStatus=='4') {
			    echo $oPhpdate->YMD2DMY($vTglAppv,"-");
				echo " by $vAdmin";
			}
			
			?> 
           
        </div></td>
      </tr>
 
      <tr>
        <td valign="top"><div align="left">Keterangan</div></td>
        <td valign="top">:</td>
        <td><div align="left">
          <?=$vKet?>
        </div></td>
      </tr>
      
      
      <tr>
        <td  colspan="3" valign="top"><p align="center"><br />
          <input type="button"  value="Close" onclick="window.close()" />
          
          </p></td>
      </tr>
  </table>
	<br>
</form>

</body>
</html>
