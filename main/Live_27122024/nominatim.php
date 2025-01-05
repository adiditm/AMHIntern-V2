<?
    	    $vLat = $_GET['lat'];
	    $vLong = $_GET['lng'];	
	    $vOpenStreetURL = "http://nominatim.openstreetmap.org/reverse?format=json&lat=$vLat&lon=$vLong";
//echo file_get_contents($vOpenStreetURL);
         
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $vOpenStreetURL);
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:59.0) Gecko/20100101 Firefox/59.0");
            curl_setopt($ch, CURLOPT_REFERER, 'http://fms.onlineapp.id');
            echo $response = curl_exec ($ch);
            $err = curl_error($ch);  //if you need
            curl_close ($ch);

?>
