	<script language="javascript" type="text/javascript" src="../jscripts/tiny_mce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="../jscripts/tiny_mce/tiny_mce.js"></script>

<script language="javascript" type="text/javascript">
	
var FileBrowserDialogue = {
    init : function () {
        // Here goes your code for setting your custom things onLoad.
    },
    mySubmit : function (src) {
        //var URL = document.my_form.my_field.value;
        var URL = src;
        var win = tinyMCEPopup.getWindowArg("window");
		//alert("tes : "+URL);
        // insert information now
        win.document.getElementById(tinyMCEPopup.getWindowArg("input")).value = URL;
        win.document.getElementById(tinyMCEPopup.getWindowArg("input")).value = URL;
        win.document.getElementById(tinyMCEPopup.getWindowArg("input")).value = URL;
		//win.document.getElementById("input").value = URL;
        
		// are we an image browser
        if (typeof(win.ImageDialog) != "undefined")
        {
            // we are, so update image dimensions and preview if necessary
            if (win.ImageDialog.getImageData) win.ImageDialog.getImageData();
            if (win.ImageDialog.showPreviewImage) win.ImageDialog.showPreviewImage(URL);
        }

        // close popup window
        tinyMCEPopup.close();
    }
}

tinyMCEPopup.onInit.add(FileBrowserDialogue.init, FileBrowserDialogue);

</script>

<form name="my_form" method="post" action='upload-act.php' enctype="multipart/form-data">
<input type="file" name="image" />
<input type="submit" name='Submit' value="upload">
</form>
<hr/>

<?
//  MENAMPILKAN FILE IMAGE YANG SIAP DI-INSERT KE TEXT EDITOR
$dir = opendir ("../images/user/"); // <---------------------------- DIREKTORI PUSAT PENYIMPANAN IMAGE / TUJUAN UPLOAD
	while (false !== ($file = readdir($dir))) {
		if (strpos($file, '.gif',1)||strpos($file, '.jpg',1)||strpos($file, '.jpeg',1)||strpos($file, '.png',1)||strpos($file, '.swf',1) || strpos($file, '.gif',1)||strpos($file, '.JPG',1)||strpos($file, '.JPEG',1)||strpos($file, '.PNG',1)||strpos($file, '.SWF',1) ) {
			echo "<img align='top' alt='Click to inter this image' title='$file' onclick='FileBrowserDialogue.mySubmit(this.src);' style={margin:5px;cursor:pointer;} width='150' src='../images/user/$file' border='1' /> <br />$file<br /><br />";
		}
	}
?>

