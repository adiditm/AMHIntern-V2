<?
 include_once("../server/config.php");
 include_once(CLASS_DIR."simple_html_dom.php");
 $vFileName="Itinerary-".$_POST['hIDT'].".doc";
 
 Header("Content-type: application/msword");
 Header("Content-Disposition: attachment;filename=$vFileName");
?>
<html>
<head>
<title>Save As.....</title>
</head>
<body>
<?

/*$ch = curl_init(ABS_URL.'/?tick=tourdet&uID='.$_GET['uID']);
curl_setopt($ch, CURLOPT_HEADER, 0);
echo $text=curl_exec($ch);

$html = file_get_html($text);
foreach($html->find('div[id=packagedtl]') as $element) 
        echo str_replace("images/",ABS_URL."images/",$element->innertext) . '<br>';
*/

echo str_replace("images/",ABS_URL."images/",$_POST['hItiner']);		
 ?>
</body>
</html>