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

    $vSQL = "select * from m_tour order by fidtour";
   $a = $db->query($vSQL);
  
   $vArrTour=array();
   $vIndex=0;
   while($db->next_record()) {
	    $vArrTour[$vIndex]['fidtour'] = $db->f('fidtour');
	   $vArrTour[$vIndex]['fdesc'] = $db->f('fdesc');
	   $vIndex++;
   }
  // print_r($vArrTour);
   echo json_encode(utf8ize($vArrTour));


?>


     
