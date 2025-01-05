<? include_once("../framework/admin_headside.blade.php")?>
<? include_once("../classes/ifaceclass.php")?>
<?
 //print_r($_POST);
  define("MENU_ID", "royal_page_edit");   
  $vMenuChoosed=$_GET['uMenuname'];
  $vGroupChoosed=$_GET['uGroup'];
   $vNamePost=$_POST['lmMenu'];
   $vGroupPost=$_POST['lmGroup'];
   
	   
   if ($vMenuChoosed=="")
       $vMenuChoosed='hometop';

   if ($vGroupChoosed=="")
       $vGroupChoosed='home';

   
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
   $vContentEn=str_replace("'","\\'",$_POST['elm2']);
   $vHeight=$_POST['tfHeight'];
   $vAll=$_POST['cbAll'];
   if ($vNamePost!="") {
       //updateMenu($pMenu,$pDesc,$pHeader,$pColor,$pBgColor,$pContent) {
      //$oInterface->updateMenu($vNamePost,$vDesc,$vHeader,$vHeaderEn,$vColor,$vBgColor,$vContent,$vContentEn,$vHeight,$vSEOTit,$vSEODesc,$vSEOKey);
	  $vUpdate=0;
	  $vUpdate=$oInterface->updateMenu($vNamePost,$vDesc,$vHeader,$vColor,$vBgColor,$vContent,'800');
	  //if ($vAll=="1") 
	 //    $oInterface->updateBgColorAll($vBgColor); 
	 if ($vUpdate==1) {
		   $vMenuPost=$_POST['lmMenu'];
		   $vGroupPost=$_POST['lmGroup'];
	       $oSystem->jsLocation("../manager/editoro.php?&uMenuname=$vMenuPost&uGroup=$vGroupPost");
	 
	   }
   }
?>



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
	});
</script>
<!-- /TinyMCE -->
<script language="javascript">
<!--
function changeMenu() {
      var menuName=document.frmEditor.lmMenu.value;
	  var menuGroup=document.frmEditor.lmGroup.value;
	  window.location='editoro.php?menu=editor&uMenuname='+menuName+'&uGroup='+menuGroup;
   }

function changeGroup() {
      
	  var menuGroup=document.frmEditor.lmGroup.value;
	  window.location='editoro.php?menu=editor&uGroup='+menuGroup;
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
</head>

<div class="right_col" role="main">
		<div><label><h3>CMS Page Editor</h3></label></div>



       
<form method="post" action="editoro.php" name="frmEditor" onsubmit="return doSubmit()">

	<table width="95%"  border="0" align="left" cellpadding="1" cellspacing="1" class="contentfontnoback">
      <tr>
        <td colspan="3" align="center">
          <p align="left"><strong>Page Content Editor</strong>          </p>
          <div align="left"><span class="style1">Sebelum melakukan editing, pastikan sudah <br />
            memilih group dan menu yang akan diedit.</span> 
            </div>          
            <br />
          <div align="center"></div></td>
      </tr>
<tr>
        <td width="14%"><div align="left"><strong>Group</strong></div></td>
        <td width="1%"><div align="left"><strong>:</strong></div></td>
        <td width="85%"><div align="left">
          <select class="form-control" name="lmGroup"  id="lmGroup" onchange="MM_callJS('changeGroup()')" style="max-width:500px">
          <option value="" selected="selected">--Pilih--</option>
		    <?
		     echo $vGroup=$oInterface->getGroup();
			 
			 $vCountGroup=count($vGroup);
			 for ($i=0;$i<$vCountGroup;$i++) {
		  ?>
            <option value="<?=$vGroup[$i]?>" <? if ($vGroupChoosed==$vGroup[$i]) echo "selected"; ?>>
            <?=$oInterface->getGroupDesc($vGroup[$i])?>
            </option>
            
            <? } ?>
          </select>
        </div></td>
      </tr>      
      <tr>
        <td width="14%"><div align="left"><strong>Menu</strong></div></td>
        <td width="1%"><div align="left"><strong>:</strong></div></td>
        <td width="85%"><div align="left">
          <select class="form-control" name="lmMenu"  id="lmMenu" onchange="MM_callJS('changeMenu()')" style="max-width:500px">
          <option value="" selected="selected">--Pilih--</option>
		    <?
		     echo $vMenu=$oInterface->getMenu($vGroupChoosed);
			 
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
        <td><div align="left"><strong>Judul Menu</strong></div></td>
        <td><div align="left"><strong>:</strong></div></td>
        <td><div align="left">
          <input  style="max-width:500px" name="tfDesc" type="text"  class="form-control" id="tfDesc" size="65"  value="<?=$oInterface->getMenuDesc($vMenuChoosed)?>"/>
        </div></td>
      </tr>     
      
      <tr>
        <td><div align="left"><strong>Header/Judul </strong></div></td>
        <td><div align="left"><strong>:</strong></div></td>
        <td><div align="left">
          <input style="max-width:500px" name="tfHeader" type="text"  class="form-control" id="tfHeader" value="<?=$oInterface->getMenuHeader($vMenuChoosed)?>" size="65" />
        </div></td>
      </tr>
      <tr class="hide">
        <td ><div align="left"><strong>Font Color (Global) </strong></div></td>
        <td><div align="left"><strong>:</strong></div></td>
        <td><div align="left">
          <input name="tfFontColor" type="text"  class="form-control" id="tfFontColor" value="<?=$oInterface->getMenuColor($vMenuChoosed)?>" size="15" /> 
          <input name="button" type="button" onclick="showColorGrid3('tfFontColor','color_2');" value="..." /> 
          <input type="text" ID="color_2" size="1" value=""> 
        </div></td>
      </tr>
      <tr class="hide">
        <td><div align="left"><strong>Background Color (Global) </strong></div></td>
        <td><div align="left"><strong>:</strong></div></td>
        <td><div align="left">
          <input name="tfBgColor" type="text"  class="form-control" id="tfBgColor" value="<?=$oInterface->getMenuBgColor($vMenuChoosed)?>" size="15" /> 
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
          <input name="tfHeight" type="text"  class="form-control" id="tfHeight" value="<?=$oInterface->getHeight($vMenuChoosed)?>" size="15" />
        </div></td>
      </tr>
      <tr class="hide">
        <td><div align="left"><strong>URL</strong></div></td>
        <td><div align="left"><strong>:</strong></div></td>
        <td>
        
        </td>
      </tr>
      
    </table>
<br />
          <input type="submit" name="save2" value="Submit" class="btn btn-info" />
          <input type="reset" name="reset2" value="Reset" class="btn btn-default" />
    
    <div class="table-responsive"><br />
           
          <textarea class="form-control"  id="elm1" name="elm1" rows="15" cols="30" style="width: 85%" ><?=$oInterface->getMenuContent($vMenuChoosed)?></textarea>
            
          </p>
          <p align="left" class="hide"> <strong>English :</strong> <br />
              <textarea id="elm2" name="elm2" rows="25" cols="30" style="width: 565" ><?=$oInterface->getMenuContent($vMenuChoosed,"en")?></textarea>
       
          </p>
       </div>
        <input type="submit" name="save" value="Submit" class="btn btn-info" />
        <input type="reset" name="reset" value="Reset" class="btn btn-default" />
       
	<br>
</form>

</div>
	<!-- end page container -->


<? include_once("../framework/admin_footside.blade.php") ; ?>
