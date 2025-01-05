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

    $vSQL = "select a.*, b.fnamacat, c.fpackname, d.fnama as fnamaprog, e.fnamakota from m_product a left join m_catproduct b on 
    a.fidcat=b.fidcat left join m_paket c on a.fpaket=c.fpackid left join m_program d on a.fprogram=d.fidprogram left join 
    m_kotav e on a.farea=e.fidsys where a.faktif='1' ";
   $a = $db->query($vSQL);
  
   $vArrTour=array();
   $vIndex=0;
   while($db->next_record()) {
	   $vArrTour[$vIndex]['fidproduk'] = $db->f('fidproduk');
	   $vArrTour[$vIndex]['fnamaproduk'] = $db->f('fnamaproduk');
       $vArrTour[$vIndex]['fdesc'] = $db->f('fdesc');
	   $vArrTour[$vIndex]['fidcat'] = $db->f('fidcat');
       $vArrTour[$vIndex]['fnamacat'] = $db->f('fnamacat');
	   $vArrTour[$vIndex]['fhargajual1'] = $db->f('fhargajual1');
	   $vArrTour[$vIndex]['fhargajual2nett'] = $db->f('fhargajual2');
	   $vArrTour[$vIndex]['fdiskon_aminah'] = $db->f('fpotong');
	   $vArrTour[$vIndex]['fimage'] = "https://intern.amhtechno.com/images/prod/".$db->f('fimage');
	   $vArrTour[$vIndex]['fvat'] = $db->f('fvat');
	   $vArrTour[$vIndex]['fberat'] = $db->f('fberat');
	   $vArrTour[$vIndex]['fharga'] = $db->f('fharga');
	   
	   $vArrTour[$vIndex]['farea'] = $db->f('farea');
       $vArrTour[$vIndex]['fnamakota'] = $db->f('fnamakota');
	   $vArrTour[$vIndex]['fpaket'] = $db->f('fpaket');
       $vArrTour[$vIndex]['fpackname'] = $db->f('fpackname');
	   $vArrTour[$vIndex]['fprogram'] = $db->f('fprogram');
       $vArrTour[$vIndex]['fnamaprog'] = $db->f('fnamaprog');
       $vArrTour[$vIndex]['fketprog'] = $db->f('fketprog');
	   

	   $vIndex++;
   }
  // print_r($vArrTour);
   echo json_encode(utf8ize($vArrTour),JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);


?>


     
