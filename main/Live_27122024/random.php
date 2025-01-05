<?php

function generateRandomString($length = 6) {
    $characters = '0123567989ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Random Generator</title>
</head>

<body>

<form method="post" action="">
	Jumlah Record : <input name="txtJum" type="text" value="1000" /><br>Paket Class 
<select name="lmClass">
				<option value="OJI" <? if ($_POST['lmClass']=='OJI') echo ' selected';?>>OJI</option>
				<option value="OLU" <? if ($_POST['lmClass']=='OLU') echo ' selected';?>>OLU </option>
				<option value="OTU" <? if ($_POST['lmClass']=='OTU') echo ' selected';?>>OTU </option>				
</select>
	<br>		
	<input name="Button1" type="Submit" value="Submit"  /><br>&nbsp;
	
  <? if ($_POST['lmClass'] !='') {?> 	
	<table border="1" cellpadding="0" cellspacing="0" style="width: 45%">
		<tr>
			<td style="width: 68px">No</td>
			<td>Starter Number</td>
		</tr>
		<?
		    $vJum=$_POST['txtJum'];
		    $tempArray = array();  
			for ($i=0;$i<$vJum;$i++) {
			
			   


				 $tempCode = $_POST['lmClass'].generateRandomString(9); //here 9 is number digit you want randon number you want
				
				 if (!in_array($tempCode, $tempArray)) {
				     $tempArray[] = $tempCode;
				 }
				 
		    }
			
		
		$vCount=count($tempArray);
		for ($j=0;$j<$vCount;$j++) {
		
	?>
		
		<tr>
			<td style="width: 68px"><?=$j+1?></td>
			<td><?=$tempArray[$j]?></td>
		</tr>
		
		<? } ?>
	</table>
	<? } ?>
	
	

</form>

</body>

</html>
