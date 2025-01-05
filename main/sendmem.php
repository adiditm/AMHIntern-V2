<?
   include_once("../server/config.php");

    
   $vOP=$_GET['uOP'];
   $vFrom = $_POST['from'];
   $vTo = $_POST['to'];

  
   if ($vOP='send') {
	  $vSQL="select a.*,a.fnama as nama_jamaah, b.fhargapub, b.fhargapub2, b.fhargapub3, b.fhargapub4,c.fnama,c.fsyaratsa,c.fsyaratlns, d.ftanggal from m_anggota   a left join m_tour b on a.fprod=b.fidtour left join m_program c on a.fprogram=c.fidprogram left join tb_payhist d on (a.fidmember=d.fidmember and d.fdesc like '%lunas%')  where date(ftglaktif)  between '$vFrom' and '$vTo' and a.faktif='1'  order by a.fidmember "; 
	  $db->query($vSQL);
	  $vRecord=array();
	  $vOut = array();
	  $i=0;
	  while ($db->next_record()) {
		 $vIdSys= $db->f("fidsys");
		 $vTglAktif=$db->f("ftglaktif");
		 if ($vTglAktif=='0000-00-00 00:00:00')
		     $vTglAktif=date("Y-m-d H:i:s"); 
			$vRecord[$i]['id_member'] = trim($db->f("fidmember"));
			$vRecord[$i]['nama_jamaah'] = trim($db->f("nama_jamaah"));
			$vRecord[$i]['nohp'] = trim($db->f("fnohp"));
			$vRecord[$i]['nophone'] = trim($db->f("fnophone"));
			$vRecord[$i]['alamat'] = trim($db->f("falamat"));
			$vRecord[$i]['email'] = trim($db->f("femail"));
			$vRecord[$i]['jenis_kelamin'] = trim($db->f("fsex"));
			$vRecord[$i]['tempatlahir'] = trim($db->f("ftempatlahir"));
			$vRecord[$i]['tgllahir'] = trim($db->f("ftgllahir"));
			$vRecord[$i]['tgl_daftar'] = trim($db->f("ftgldaftar"));
			$vRecord[$i]['tgl_aktif'] = trim($db->f("ftglaktif"));
			$vRecord[$i]['tgl_lunas'] = trim($db->f("ftanggal"));
			$vRecord[$i]['harga_single'] = trim($db->f("fhargapub"));
			$vRecord[$i]['harga_double'] = trim($db->f("fhargapub2"));
			$vRecord[$i]['harga_triple'] = trim($db->f("fhargapub3"));
			$vRecord[$i]['harga_quad'] = trim($db->f("fhargapub4"));
			$vRecord[$i]['id_pebisnis'] = trim($db->f("frefer"));
			$vRecord[$i]['jumlah_pax'] = trim($db->f("fjenispax"));
			$vRecord[$i]['setoran_awal'] = trim($db->f("fstorawal"));
			$vRecord[$i]['angsuran_1'] = trim($db->f("fangsur1"));
			$vRecord[$i]['angsuran_2'] = trim($db->f("fangsur2"));
			$vRecord[$i]['angsuran_3'] = trim($db->f("fangsur3"));
			$vRecord[$i]['angsuran_4'] = trim($db->f("fangsur3"));
			$vRecord[$i]['pelunasan'] = trim($db->f("flunas"));
			$vRecord[$i]['program'] = trim($db->f("fnama"));
			$vRecord[$i]['idprogram'] = trim($db->f("fprogram"));
			$vRecord[$i]['syarat_stor_awal'] = trim($db->f("fsyaratsa"));
			$vRecord[$i]['harus_lunas'] = trim($db->f("fsyaratlns"));
			

		 $i++;
	  }
	  
	  
	  if (strlen($vFrom)!=10 || strlen($vTo)!=10) {
					$vOut['status'] = 'failed';
					$vOut['message'] =  'Incomplete date filter!'; 
				  
			 
			  } else  if (count($vRecord) >0) {
					$vOut['status'] = 'succeed';
					$vOut['message'] =  'Retrieved '.count($vRecord).' records!'; 
					$vOut['data'] = $vRecord;
			  }
echo json_encode($vOut, JSON_PRETTY_PRINT);	  
   }
  
   
  

?>