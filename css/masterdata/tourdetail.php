<?
  session_start();
  include_once "../server/config.php";
  include_once "../classes/ifaceclass.php";
  include_once "../classes/systemclass.php";

 $vPriv=$_SESSION['Priv']; 
  define("MENU_ID", "royal_page_edit");   
   if (($vPriv!="administrator") && ($vPriv!="2")){
	$oSystem->jsAlert("Not Authorized");
	//$oSystem->jsLocation("logout.php");
}
   
   $vID=$_GET['uID'];
   $vSQL="select * from m_tour where fidsys=$vID";
   $db->query($vSQL);
   while ($db->next_record()) {
      $vIDV=$db->f("fidtour");
	  $vOver=$db->f("foverv");
	  $vOverEn=$db->f("foverven");
	  $vDet=$db->f("fdetail");
	  $vDetEn=$db->f("fdetailen");
	  //$vAlamat=$db->f("falamat");
	  $vPrice=$db->f("fpriceinfo");
   }
       
   if ($_POST['hPost']=="1") {
      $vPostDesc=preg_replace("/\'/","`",$_POST['elm1']);
	  $vPostDescEn=preg_replace("/\'/","`",$_POST['elm2']);
	  $vPostDet=preg_replace("/\'/","`",$_POST['elm3']);
	  $vPostDetEn=preg_replace("/\'/","`",$_POST['elm4']);
	  
	  $vPostPrice=preg_replace("/\'/","`",$vPostPrice);
       $vSQL="update m_tour set foverv='$vPostDesc',foverven='$vPostDescEn',fdetail='$vPostDet',fdetailen='$vPostDetEn' where fidsys=$vID";
	  $db->query($vSQL);
	  
     $oSystem->jsCloseWin();
   }	    
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Price Info</title>
<link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
 <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
 <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- TinyMCE -->
<script type="text/javascript" src="../jscripts/tiny_mce/tiny_mce.js"></script>
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
		},
		paste_auto_cleanup_on_paste : true
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
	<table width="90%"  border="0" align="center" cellpadding="1" cellspacing="1" style="font-family:Tahoma,Verdana">
      <tr>
        <td colspan="3" align="center">
          <p><strong>Tour Description &amp; Detail </strong></p>          </td>
      </tr>
      <tr>
        <td width="33%"><div align="left"><strong>ID Tour </strong></div></td>
        <td width="2%"><div align="left"><strong>:</strong></div></td>
        <td width="65%"><div align="left"><?=$vIDV?>
          <input type="hidden" name="hPost" value="1" />
          <input type="hidden" name="hID" value="<?=$vID?>" />
        </div></td>
      </tr>
      
      
      <tr>
        <td height="729" colspan="3" valign="top"><p align="left"><br />
          <input class="btn btn-success btn-sm" type="submit" name="save2" value="Submit" />
          <input class="btn btn-default btn-sm" type="reset" name="reset2" value="Reset" />
          <br />
          <br />
          <div id="overv" style="display:none">
          <strong>Overview </strong>:<br />
          <br />
            <textarea id="elm1" name="elm1" rows="10" cols="30" style="width: 565" ><?=$vOver?></textarea>
          </p>
          <p align="left"><strong>Overview (English) </strong>:<br />
            <br />
            <textarea id="elm2" name="elm2" rows="10" cols="30" style="width: 565" ><?=$vOverEn?></textarea>
</p>
          <p align="left"><strong></strong></p>
          </div>
          <p align="left"><strong>Details </strong>:<br />
            <br />
            <textarea id="elm3" name="elm3" rows="20" cols="30" style="width: 565" ><?=$vDet?>
            </textarea>
          </p>
          <div style="display:none">
          <p align="left"><strong>Details (English) </strong>:<br />
            <br />
            <textarea id="elm4" name="elm4" rows="10" cols="30" style="width: 565" ><?=$vDetEn?>
            </textarea>
</p></div>
          <p align="left"></p>
          <p align="left"></p>
          <p align="left"><br />
            <input class="btn btn-success btn-sm" type="submit" name="save" value="Submit" />
            <input class="btn btn-default btn-sm" type="reset" name="reset" value="Reset" />
          </p>
          </p></td>
      </tr>
  </table>
	<br>
</form>

</body>
</html>
