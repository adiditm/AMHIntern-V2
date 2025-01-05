<?php
header("Content-Type: application/json");

include_once("../server/config.php");
    function utf8ize($d) {
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } else if (is_string ($d)) {
        return utf8_encode($d);
    }
    return $d;
    }

    $vSQL = "select * from m_program order by fidprogram";
   $a = $db->query($vSQL);
  
   $vArrTour=array();
   $vIndex=0;
   while($db->next_record()) {
	    $vArrTour[$vIndex]['id_program'] = $db->f('fidprogram');
	   $vArrTour[$vIndex]['nama_program'] = $db->f('fnama');
	   $vArrTour[$vIndex]['keterangan'] = $db->f('fket');
	    $vArrTour[$vIndex]['syarat_setor_awal'] = $db->f('fsyaratsa');
		$vArrTour[$vIndex]['harus_lunas'] = $db->f('fsyaratlns');
	   $vIndex++;
   }
  // print_r($vArrTour);
   echo json_encode(utf8ize($vArrTour),JSON_PRETTY_PRINT);


?>


     
