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

    
	$vType = $_POST['type'];
	$vFrom = $_POST['from'];
	$vTo  = $_POST['to'];
	
	if ($vType == 'pulsappob')  {
				 $vSQL = "select *, case when fket like '%PPOB%' then 'PPOB' else 'PULSA' end as fjenis from tb_trxpulsa where  (fserverresponse like '%sukses%' or (fstatustrx='0' and fserverresponse like '%diproses%'))  and ftglentry between '$vFrom' and '$vTo' ";
			   $a = $db->query($vSQL);
			  
			   $vArrTrx=array();
			   $vOut=array();
			   $vIndex=0;
			   while($db->next_record()) {
				   $vArrTrx[$vIndex]['tanggal'] = $db->f('ftglentry');
				   $vArrTrx[$vIndex]['idtrx'] = $db->f('fidtrx');
				   $vArrTrx[$vIndex]['idmember'] = $db->f('fidmember');
				   $vArrTrx[$vIndex]['nominal'] = $db->f('fhrgamh');
				   $vArrTrx[$vIndex]['jenis'] = $db->f('fjenis');
				   
				   $vIndex++;
			   }
			  // print_r($vArrTour);
			  if (strlen($vFrom)!=10 || strlen($vTo)!=10) {
					$vOut['status'] = 'failed';
					$vOut['message'] =  'Incomplete date filter!'; 
				  
			  } else if ($vType=='') {
					$vOut['status'] = 'failed';
					$vOut['message'] =  'Incomplete parameter!'; 
				  
			  } else  if (count($vArrTrx) >0) {
					$vOut['status'] = 'succeed';
					$vOut['message'] =  'Retrieved '.count($vArrTrx).' transaction!'; 
					$vOut['data'] = $vArrTrx;
			  }
			   echo json_encode(utf8ize($vOut),JSON_PRETTY_PRINT);
   
	} else if ($vType == 'goods')  {
				 $vSQL = "select a.*,b.fpaket, b.fprogram, c.fnama from tb_penjualan a left join m_product b on a.fidproduk=b.fidproduk left join m_program c on b.fprogram=c.fidprogram  where  a.fprocessed='2'  and date(a.ftglprocessed) between '$vFrom' and '$vTo' ";
			   $a = $db->query($vSQL);
			  
			   $vArrTrx=array();
			   $vOut=array();
			   $vIndex=0;
			   while($db->next_record()) {
				   $vArrTrx[$vIndex]['tanggal'] = $db->f('ftglprocessed');
				   $vArrTrx[$vIndex]['idtrx'] = $db->f('fidpenjualan');
				   $vArrTrx[$vIndex]['idmember'] = $db->f('fidmember');
				   $vArrTrx[$vIndex]['nominal'] = $db->f('fsubtotal');
				   $vArrTrx[$vIndex]['jumlah'] = $db->f('fjumlah');
				   $vArrTrx[$vIndex]['ongkir'] = $db->f('fongkir');
				   $vArrTrx[$vIndex]['idprog'] = $db->f('fprogram');
				   $vArrTrx[$vIndex]['namaprog'] = $db->f('fnama');
				   
				   $vIndex++;
			   }
			  // print_r($vArrTour);
			  if (strlen($vFrom)!=10 || strlen($vTo)!=10) {
					$vOut['status'] = 'failed';
					$vOut['message'] =  'Incomplete date filter!'; 
				  
			  } else if ($vType=='') {
					$vOut['status'] = 'failed';
					$vOut['message'] =  'Incomplete parameter!'; 
				  
			  } else  if (count($vArrTrx) >0) {
					$vOut['status'] = 'succeed';
					$vOut['message'] =  'Retrieved '.count($vArrTrx).' transaction!'; 
					$vOut['data'] = $vArrTrx;
			  }
			   echo json_encode(utf8ize($vOut),JSON_PRETTY_PRINT);
   
	}


?>


     
