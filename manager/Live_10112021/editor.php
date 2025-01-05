<? include_once("../framework/admin_headside.blade.php")?>
<? include_once("../classes/ifaceclass.php")?>
<?
  //print_r($_POST);
  define("MENU_ID", "royal_page_edit");   
   $vMenuChoosed=$_GET['uMenuname'];
   $vNamePost=$_POST['lmMenu'];
   if ($vMenuChoosed=="")
       $vMenuChoosed=$vNamePost;
	   
   if ($vMenuChoosed=="")
       $vMenuChoosed='term';
   
   $vDesc=$_POST['tfDesc'];
   $vHeader=$_POST['tfHeader'];
   $vHeaderEn=$_POST['tfHeaderEn'];
   $vSEOTit=$_POST['tfSEOTit'];
   $vSEODesc=$_POST['tfSEODesc'];
   $vSEOKey=$_POST['tfSEOKey'];
   $vColor=$_POST['tfFontColor'];
   $vBgColor=$_POST['tfBgColor'];
  // $vContent=addslashes($_POST['elm1']);
   $vContent=preg_replace("/'/","`",$_POST['elm1']);
   
   //$vContent=$_POST['elm1'];
   //$vContentEn=$_POST['elm2'];
   //$vContentEn=addslashes($_POST['elm2']);
   $vContent=str_replace("'","`",$_POST['elm2']);
   $vHeight=$_POST['tfHeight'];
   $vAll=$_POST['cbAll'];
   if ($vNamePost!="") {
       //updateMenu($pMenu,$pDesc,$pHeader,$pColor,$pBgColor,$pContent) {
      $oInterface->updateMenu($vNamePost,$vDesc,$vHeader,$vColor,$vBgColor,$vContent,'800');
	  if ($vAll=="1") 
	     $oInterface->updateBgColorAll($vBgColor); 
   }
?>




<!-- TinyMCE -->
<script type="text/javascript" src="../jscripts/tinymce/tinymce.min.js"></script>
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


tinymce.init({
  selector: '#elm1',  // change this value according to your HTML
  auto_focus: '#elm1',

  plugins : 'advlist autolink link image lists charmap print preview code textcolor',

  valid_elements : '*[*]', 
  extended_valid_elements :  "iframe[src|width|height|name|align|frameborder|scrolling|strong]",
  file_browser_callback: function(field_name, url, type, win) {
    win.document.getElementById(field_name).value = 'my browser value';
  },
  file_browser_callback_types: 'file image media',

file_picker_callback: function(callback, value, meta) {
    // Provide file and text for the link dialog
    if (meta.filetype == 'file') {
      callback('mypage.html', {text: 'My text'});
    }

    // Provide image and alt text for the image dialog
    if (meta.filetype == 'image') {
      callback('myimage.jpg', {alt: 'My alt text'});
    }

    // Provide alternative source and posted for the media dialog
    if (meta.filetype == 'media') {
      callback('movie.mp4', {source2: 'alt.ogg', poster: 'image.jpg'});
    }
  },
  
  
    images_upload_url: 'postAcceptor.php',
  automatic_uploads: false,
  images_upload_base_path: '../images/user/',
  
  images_upload_handler: function (blobInfo, success, failure) {
    var xhr, formData;

    xhr = new XMLHttpRequest();
    xhr.withCredentials = false;
    xhr.open('POST', 'postAcceptor.php');

    xhr.onload = function() {
      var json;

      if (xhr.status != 200) {
        failure('HTTP Error: ' + xhr.status);
        return;
      }

      json = JSON.parse(xhr.responseText);

      if (!json || typeof json.location != 'string') {
        failure('Invalid JSON: ' + xhr.responseText);
        return;
      }

      success(json.location);
    };

    formData = new FormData();
    formData.append('file', blobInfo.blob(), blobInfo.filename());

    xhr.send(formData);
  }  
    
});

/*
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
		extended_valid_elements :  "iframe[src|width|height|name|align|frameborder|scrolling]",
		entity_encoding : "raw",
		convert_urls: false,
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
	});*/
</script>
<!-- /TinyMCE -->
<script language="javascript">
<!--
function changeMenu() {
      var menuName=document.frmEditor.lmMenu.value;
	  window.location='../manager/editor.php?uMenuname='+menuName;
   }

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}

function doSubmit() {
  if (document.frmEditor.lmMenu.value=="") {
   		alert('Pilih menu yang akan diedit!');
		document.frmEditor.lmMenu.focus();
	    return false;
	} else {
	  if (confirm('Yakin menyimpan?')==true) 
	    return true;
	    else return false;
  } 
}

function checkChoose() {
  if (document.frmEditor.lmMenu.value=="") {
    alert('Pilih menu yang akan diedit');
	document.frmEditor.lmMenu.focus();
  }
}
//-->

$(document).ready(function(){

    $('#caption').html('CMS Page Editor');






});

</script>
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
<div class="content-wrapper">

       <section class="content">
<form method="post"  name="frmEditor" onsubmit="return doSubmit()">

	<table width="90%"  border="0" align="center" cellpadding="1" cellspacing="1" class="contentfontnoback">
      <tr>
        <td colspan="3" align="center">
          <h4 align="left">CMS Page Editor</h4>
          <div align="left"><span class="style1">Sebelum melakukan editing, pastikan sudah memilih menu yang akan diedit.</span> 
            </div>          
            <br />
          </div>
          <div align="center"></div></td>
      </tr>
      <tr>
        <td width="22%"><div align="left"><strong>Menu</strong></div></td>
        <td width="1%"><div align="left"><strong>:</strong></div></td>
        <td width="77%"><div align="left">
          <select name="lmMenu"  id="lmMenu" onchange="MM_callJS('changeMenu()')">
          <option value="" selected="selected">--Pilih--</option>
		    <?
		     echo $vMenu=$oInterface->getMenu();
			 
			 $vCountMenu=count($vMenu);
			 for ($i=0;$i<$vCountMenu;$i++) {
		  ?>
            <option value="<?=$vMenu[$i]?>" <? if ($vMenuChoosed==$vMenu[$i]) echo "selected"; ?>>
            <?=$oInterface->getMenuDesc($vMenu[$i])?>
            </option>
            
            <? } ?>
          </select>
        </div></td>
      </tr>
      <tr>
        <td><div align="left"><strong>Deskripsi</strong></div></td>
        <td><div align="left"><strong>:</strong></div></td>
        <td><div align="left">
          <input name="tfDesc" type="text"  class="inputborder" id="tfDesc" size="65"  value="<?=$oInterface->getMenuDesc($vMenuChoosed)?>"/>
        </div></td>
      </tr>
      <tr>
        <td><div align="left"><strong>Header/Judul </strong></div></td>
        <td><div align="left"><strong>:</strong></div></td>
        <td><div align="left">
          <input name="tfHeader" type="text"  class="inputborder" id="tfHeader" value="<?=$oInterface->getMenuHeader($vMenuChoosed)?>" size="65" />
        </div></td>
      </tr>
      <tr class="hide">
        <td><div align="left"><strong>Header/Judul EN </strong></div></td>
        <td><div align="left"><strong>:</strong></div></td>
        <td><div align="left">
          <input name="tfHeaderEn" type="text"  class="inputborder" id="tfHeaderEn" value="<?=$oInterface->getMenuHeader($vMenuChoosed)?>" size="65" />
        </div></td>
      </tr>
      <tr class="hide">
        <td ><div align="left"><strong>Font Color (Global) </strong></div></td>
        <td><div align="left"><strong>:</strong></div></td>
        <td><div align="left">
          <input name="tfFontColor" type="text"  class="inputborder" id="tfFontColor" value="<?=$oInterface->getMenuColor($vMenuChoosed)?>" size="15" /> 
          <input name="button" type="button" onclick="showColorGrid3('tfFontColor','color_2');" value="..." /> 
          <input type="text" ID="color_2" size="1" value=""> 
        </div></td>
      </tr>
      <tr class="hide">
        <td><div align="left"><strong>Background Color (Global) </strong></div></td>
        <td><div align="left"><strong>:</strong></div></td>
        <td><div align="left">
          <input name="tfBgColor" type="text"  class="inputborder" id="tfBgColor" value="<?=$oInterface->getMenuBgColor($vMenuChoosed)?>" size="15" /> 
        </div>
          <div id="colorpicker301" class="colorpicker301"></div>
          <div align="left">
            <input type="button" onclick="showColorGrid3('tfBgColor','color_1');" value="...">
            &nbsp;
            <input type="text" ID="color_1" size="1" value="">
		
		
            <input name="cbAll" type="checkbox" id="cbAll" value="1" />
        Semua Menu        </div>          <div id="colorpicker301" class="colorpicker301">          </div></td></tr>
      <tr class="hide">
        <td><div align="left"><strong>Height (pixel)</strong></div></td>
        <td><div align="left"><strong>:</strong></div></td>
        <td><div align="left">
          <input name="tfHeight" type="text"  class="inputborder" id="tfHeight" value="<?=$oInterface->getHeight($vMenuChoosed)?>" size="15" />
        </div></td>
      </tr>
      <tr>
        <td colspan="3"><p align="left"><br />
          <input type="submit" name="save2" value="Submit" class="btn btn-success" />
          <input type="reset" name="reset2" value="Reset" class="btn btn-default" />
          <br />
          <br /><div >
          <strong>Indonesia:</strong><br />
            <textarea class=""  id="elm1" name="elm1" rows="25" cols="30" style="width: 565" ><?=$oInterface->getMenuContent($vMenuChoosed)?></textarea>
            </div>
          </p>
          <p align="left" > <strong class="hide">English :</strong> <br />
              <textarea class="hide" id="elm2" name="elm2" rows="25" cols="30" style="width: 565" ><?=$oInterface->getMenuContent($vMenuChoosed)?></textarea>
            <br />
            <input type="submit" name="save" value="Submit" class="btn btn-success" />
            <input type="reset" name="reset" value="Reset" class="btn btn-default" />
          </p>
          </p></td>
      </tr>
    </table>
	<br>
</form>
 </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<?
 include('../framework/admin_footside.blade.php');
?>
