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

    $vStatus = $_GET['status'];
    if ($vStatus != '') {
        $vAnd .= " and a.fstatusrow = '".$vStatus."'"; 
    }

    $vSQL = "select a.*, b.fnamakota, c.fpackname, d.fnama as fnamaprog, d.fket as fketprog,a.fstatusrow as fstatus from m_tour a left join m_kotav b on a.farea=b.fidsys  left join m_paket c on a.fpaket=c.fpackid left join m_program d on a.fprogram=d.fidprogram where 1 $vAnd  and a.ftgldepart >= date(now()) and date(a.fexpired) >= date(now()) order by a.fidtour";
   $a = $db->query($vSQL);
  
   $vArrTour=array();
   $vIndex=0;
   while($db->next_record()) {
	   $vArrTour[$vIndex]['fidtour'] = $db->f('fidtour');
	   $vArrTour[$vIndex]['fdesc'] = $db->f('fdesc');
	   $vArrTour[$vIndex]['fsisaseat'] = $db->f('fsisaseat');
       
	   $vArrTour[$vIndex]['fdetail'] = $db->f('fdetail');
	   $vArrTour[$vIndex]['fimage'] = "https://intern.amhtechno.com/images/user/".$db->f('fimage');
	   $vArrTour[$vIndex]['fcurr'] = $db->f('fcurr');
	   $vArrTour[$vIndex]['fcurrsym'] = $db->f('fcurrsym');
	   $vArrTour[$vIndex]['fharga'] = $db->f('fharga');
	   $vArrTour[$vIndex]['fhargapub'] = $db->f('fhargapub');
       $vArrTour[$vIndex]['fhargapub2'] = $db->f('fhargapub2');
	   $vArrTour[$vIndex]['fhargapub3'] = $db->f('fhargapub3');
	   $vArrTour[$vIndex]['fhargapub4'] = $db->f('fhargapub4');
	   $vArrTour[$vIndex]['farea'] = $db->f('farea');
       $vArrTour[$vIndex]['fnamakota'] = $db->f('fnamakota');
	   $vArrTour[$vIndex]['fpaket'] = $db->f('fpaket');
       $vArrTour[$vIndex]['fpackname'] = $db->f('fpackname');
	   $vArrTour[$vIndex]['fprogram'] = $db->f('fprogram');
       $vArrTour[$vIndex]['fnamaprog'] = $db->f('fnamaprog');
       $vArrTour[$vIndex]['fketprog'] = $db->f('fketprog');
	   $vArrTour[$vIndex]['fjmlhari'] = $db->f('fjmlhari');
	   $vArrTour[$vIndex]['fplane'] = $db->f('fplane');
	   $vArrTour[$vIndex]['fhotel'] = $db->f('fhotel');
	   $vArrTour[$vIndex]['fassure'] = $db->f('fassure');
	   $vArrTour[$vIndex]['fhandle'] = $db->f('fhandle');
	   $vArrTour[$vIndex]['fkurs'] = $db->f('fkurs');
	   $vArrTour[$vIndex]['fcountry'] = $db->f('fcountry');
       $vArrTour[$vIndex]['fgroup'] = $db->f('fgroup');
       $vArrTour[$vIndex]['fstatus'] = $db->f('fstatus');

	   $vIndex++;
   }
  // print_r($vArrTour);
   echo json_encode(utf8ize($vArrTour),JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);


?>


     
