<?
  session_start();
   include_once("../server/config.php");
   include_once("../classes/memberclass.php");
   include_once(CLASS_DIR."dateclass.php");
   include_once("../classes/networkclass.php");
   include_once(CLASS_DIR."ifaceclass.php");
   include_once("../classes/ruleconfigclass.php");
   include_once(CLASS_DIR."komisiclass.php");
   include_once(CLASS_DIR."jualclass.php");
   include_once(CLASS_DIR."systemclass.php");
   include_once(CLASS_DIR."productclass.php");
   include_once(CLASS_DIR."texttoimageclass.php");
   include_once("../classes/mobdetectclass.php");
    if ($_SESSION['LoginUser']=='') { 	
      header("Location: ../main/logout.php");
	}

function hariIni(){
	$hari = date ("D");
 
	switch($hari){
		case 'Sun':
			$hari_ini = "Minggu";
		break;
 
		case 'Mon':			
			$hari_ini = "Senin";
		break;
 
		case 'Tue':
			$hari_ini = "Selasa";
		break;
 
		case 'Wed':
			$hari_ini = "Rabu";
		break;
 
		case 'Thu':
			$hari_ini = "Kamis";
		break;
 
		case 'Fri':
			$hari_ini = "Jumat";
		break;
 
		case 'Sat':
			$hari_ini = "Sabtu";
		break;
		
		default:
			$hari_ini = "Tidak di ketahui";		
		break;
	}
 
	return $hari_ini ;
 
}

  function tglIndonesia($tanggal){
    $bulan = array (
      1 =>   'Januari',
      'Februari',
      'Maret',
      'April',
      'Mei',
      'Juni',
      'Juli',
      'Agustus',
      'September',
      'Oktober',
      'November',
      'Desember'
    );
    $pecahkan = explode('-', $tanggal);
    
    // variabel pecahkan 0 = tanggal
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tahun
   
    return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
  }
   
   $vJamaah = $_GET['uMemberId'];
   $vAngs = $_GET['no'];
   
   $vSQL = "SELECT
	fidmember as `ID Jamaah`,
	fstorawal as `Angsuran / Setoran Awal`,
	fangsur2 as `Angsuran 2`,
	fangsur3 as `Angsuran 3`,
	fangsur4 as `Angsuran 4`,
	flunas as `Pelunasan`,
	ftotalbayar as `Total Pembayaran`,
	frefer as `ID Mitra / Atria`,
	fnama as `Nama`,
	fnohp as `No HP`,
	ftempat as `Tempat Lahir`,
	ftgllahir as `Tgl. Lahir`,
	falamat as `Alamat`,
	fkota as `Kota`,
	fprop as `Propinsi`,
	femail as `Email`,
	fnamarefer as `Nama Mitra / Atria`,
	ftgldaftar as `Tgl. Daftar`,
	fsex as `Jenis Kelamin`,
	fnoktp as `Nomor KTP`,
	fcountry as `Negara` ,
	ftgldepart as `Tgl. Berangkat`,
	fpaket as `Paket`,
	fpaketday as `Jumlah Hari`,
	fjenpay as `Pembayaran`,
	fprogram as `Program`,
	fprice as `Harga`,
	fairporttax as `Air Port Tax`,
	fassure as `Asuransi`,
	farabassure as `Asuransi Arab Saudi`,
	fkakek as `Nama Kakek`,
	fayah as `Nama Ayah`,
	fkec as `Kecamatan`,
	fumur as `Usia`,
	fidregistrar as `Pendaftar`
FROM
	m_anggota where fidmember = '$vJamaah' ";
   $db->query($vSQL);
   $db->next_record();
   $vData=$db->Record;
   

   $vBerangkatX = $db->f('ftgldepart');
   $vBerangkat = date( 'd M Y', strtotime($vBerangkatX));
   $vJmlHari = $db->f('fpaketday');
   $vPulang = strtotime($vBerangkatX. " + $vJmlHari days");
   $vPulang = date("d M Y",$vPulang);
   $vKurs = $db->f('fkurslunas');
   
   
function sortVertically( $data ,$pMember,$pProduct,$pPhpdate)
{
   // print_r($data);
	/* PREPARE data for printing */
    ksort( $data );     // Sort array by key.
    $numCols    = 1;    // Desired number of columns
    $numCells   = is_array($data) ? count($data) : 1 ;
    $numRows    = ceil($numCells / $numCols);
    $extraCells = $numCells % $numCols;  // Store num of tbody's with extra cell
    $i          = 0;    // iterator
    $cCell      = 0;    // num of Cells printed
    $output     = NULL; // initialize 


    /* START table printing */
    $output     .= '<div>';
    $output     .= '<table style="border:0px solid;border-collapse:collapse" cellpadding="3" cellspacing="0">';


    foreach($data as $key => $value )
    {
   
	  
	   $vArrNum=array(
	   		'Air Port Tax',
			'Angsuran 1',
			'Angsuran / Setoran Awal',
			'Angsuran 2',
			'Angsuran 3',	
			'Angsuran 4',	
			'Pelunasan',	
			'Asuransi',		
			'Asuransi Arab Saudi',
			'Total Pembayaran',
			'Harga',
			'Setoran Awal'
	   );
	   if(in_array($key,$vArrNum)) $value=number_format($value,0,",",".");
	   if ($key=='ID Mitra / Atria') $value=strtoupper($value);
	   if ($key=='Jenis Kelamin') {
		   if ($value=='F') $value='Perempuan'; else $value='Laki-laki';   
	   }
	   
	   if ($key=='Kecamatan') {
		     $value= $pMember->getWilName('ID',$data['Propinsi'],$data['Kota'],$data['Kecamatan']);
	   }

	   if ($key=='Kota') {
		     $value= $pMember->getWilName('ID',$data['Propinsi'],$data['Kota']);
	   }

	   if ($key=='Paket') {
		     $value= $pProduct->getPackName($data['Paket']);
	   }

   		if ($key=='Program') {
		     $value= $pProduct->getProgramName($data['Program']);
	   }
	   if ($key=='Propinsi') {
		      $value= $pMember->getWilName('ID',$data['Propinsi']);
	   }


	   if ($key=='Negara') {
		     $value= $pMember->getCountryName('ID');
	   }
	   if (preg_match("/Tgl./",$key)) {
		     $value= $pPhpdate->YMD2DMY($value);
	   }
	   
	   if ($key=='Usia') {
		     $value= date_diff(date_create($data['Tgl. Lahir']), date_create('now'))->y;
	   }
	   
	
	   if (!is_numeric($key)) {
	    if( $i % $numRows === 0 )   // Start a new tbody
        {
            if( $i !== 0 )          // Close prev tbody
            {
                $extraCells--;
                if ($extraCells === 0 )
                {
                    $numRows--;     // No more tbody's with an extra cell
                    $extraCells--;  // Avoid re-reducing numRows
                }
                $output .= '</tbody>';
            }

            $output .= '<tbody style="float: left;">';
            $i = 0;                 // Reset iterator to 0
        }
        $output .= '<tr>';
            $output .= '<th align="left" style="border:1px solid;">'.$key.'</th>';
            $output .= '<td style="border:1px solid;border-left:none;">'.$value.'</td>';
        $output .= '</tr>';

        $cCell++;                   // increase cells printed count
        if($cCell == $numCells){    // last cell, close tbody
            $output .= '</tbody>';
        }

        $i++;
    }
	}
	

    $output .= '</table>';
    $output .= '</div>';
    return $output;
	
}   


?>
<html>
<head>
<title>Data Registrasi Jamaah <?=$vJamaah?> (<?=$oMember->getMemberName($vJamaah)?>)</title>

<style type="text/css">
  body, table{font-family:Verdana, Geneva, sans-serif;font-size:12px}
  
</style>
</head>
<body onLoad="window.print() ">
<h4>Data Registrasi Jamaah <?=$vJamaah?> (<?=$oMember->getMemberName($vJamaah)?>)</h4><BR />
<?
echo sortVertically($vData,$oMember,$oProduct,$oPhpdate);
?>

</body>
</html>