<? include_once("../framework/admin_headside.blade.php")?>

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

		 height : 650,

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

  selector: '#PME_data_fcontent',  // change this value according to your HTML

  auto_focus: '#PME_data_fcontent',



  plugins : 'advlist autolink link image lists charmap print preview code textcolor',

	theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",

		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",

		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",

		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",


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

<div class="right_col" role="main">

		<div><label>
		<h3>Format Surat Rekomendasi</h3></label></div>


<?php



   define("MENU_ID", "mdm_setting_mvoucher");

  // include_once("server/config.php");

   include_once(CLASS_DIR."systemclass.php");

   if ($oSystem->authAdminNP($vUser)==0) {

      $oSystem->jsAlert("Not Authorized!");

      $oSystem->jsLocation("logout.php");

   }

   

$opts['hn'] = $db->Host;

$opts['un'] = $db->User;

$opts['pw'] = $db->Password;

$opts['db'] = $db->Database;

$opts['tb'] = 'tb_recomm';



// Name of field which is the unique key

$opts['key'] = 'fidsys';



// Type of key field (int/real/string/date etc.)

$opts['key_type'] = 'int';



// Sorting field(s)

$opts['sort_field'] = array('fidsys');



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

	'time'  => true,

	'tabs'  => true

);



// Set default prefixes for variables

$opts['js']['prefix']               = 'PME_js_';

$opts['dhtml']['prefix']            = 'PME_dhtml_';

$opts['cgi']['prefix']['operation'] = 'PME_op_';

$opts['cgi']['prefix']['sys']       = 'menu=mastercontent&PME_sys_';

$opts['cgi']['prefix']['data']      = 'PME_data_';



/* Get the user's default language and use it if possible or you can

   specify particular one you want to use. Refer to official documentation

   for list of available languages. */

$opts['language'] = $_SERVER['HTTP_ACCEPT_LANGUAGE'] . '-UTF8';



$opts['filters'] = 'fstatusrow=\'1\'';



$opts['fdd']['fidsys'] = array(

  'name'     => 'ID Sys',

  'select'   => 'T',

  'maxlen'   => 11,

  'default'  => '0',

  'sort'     => true,

  'input'	 => 'R',

  'options'	 => 'APC'

  

);






$opts['fdd']['fname'] = array(

  'name'     => 'Menu ID',

  'select'   => 'T',

  'maxlen'   => 55,

  'sort'     => true,

  

 // 'input|C'	 => 'R'

);

$opts['fdd']['fdesc'] = array(

  'name'     => 'Nama Template',

  'select'   => 'T',

  'maxlen'   => 55,

  'sort'     => true,

  

 // 'input|C'	 => 'R'

);



$opts['fdd']['fcontent'] = array(

  'name'     => 'Content',

  'select'   => 'T',

  'maxlen'   => 65535,

  'textarea' => array(

    'rows' => 5,

    'cols' => 50),

  'sort'     => true,

  'options'	 => 'APC'

);




$opts['fdd']['fstatusrow'] = array(

  'name'     => 'Status',

  'select'   => 'T',

  'maxlen'   => 1,

  'default'  => '1',

  'sort'     => true,

  'values2'    => array('1' => 'Aktif', '0' => 'Tidak'),  

);

$opts['fdd']['fdefault'] = array(

  'name'     => 'Default',

  'select'   => 'T',

  'maxlen'   => 1,

  'default'  => '0',

  'sort'     => true,

  'values2'    => array('1' => 'Yes', '0' => 'No'),  

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

$opts['triggers']['update']['after']  = 'trig_default_template.php';

// Now important call to phpMyEdit

require_once CLASS_DIR.'phpmyedit.class.php';

new phpMyEdit($opts);



?>





<!-- Placed js at the end of the document so the pages load faster -->



<script src="../js/jquery-ui-1.9.2.custom.min.js"></script>

<script src="../js/jquery-migrate-1.2.1.min.js"></script>



<script src="../js/modernizr.min.js"></script>

<script src="../js/jquery.nicescroll.js"></script>



<!--common scripts for all pages-->

<script src="../js/scripts.js"></script>

<script language="javascript">

$(document).ready(function(){



      $('#caption').html('Country');
	  

	  setTimeout(function () { 
		 	$('#mceu_15').parent().removeClass('col-md-6');
	  		$('#mceu_15').parent().addClass('col-lg-10');
			$('#PME_data_fcontent_ifr').css('height','450px');

	  }, 2000);
});  



</script>



</div>

	<!-- end page container -->





<? include_once("../framework/admin_footside.blade.php") ; ?>

