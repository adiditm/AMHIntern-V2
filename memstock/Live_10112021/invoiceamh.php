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
   
   $vSQL = "select * from m_anggota where fidmember = '$vJamaah' ";
   $db->query($vSQL);
   $db->next_record();
   

   $vBerangkatX = $db->f('ftgldepart');
   $vBerangkat = date( 'd M Y', strtotime($vBerangkatX));
   $vJmlHari = $db->f('fpaketday');
   $vPulang = strtotime($vBerangkatX. " + $vJmlHari days");
   $vPulang = date("d M Y",$vPulang);
   $vKurs = $db->f('fkurslunas');
?>

<html xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 12">
<link id=Main-File rel=Main-File href="../Invoiceamh.htm">
<link rel=File-List href=filelist.xml>
<link rel=Stylesheet href=invoiceamh_files/stylesheet.css>

    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->


<style>
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
@page
	{margin:.28in .28in .75in .28in;
	mso-header-margin:.3in;
	mso-footer-margin:.3in;}
-->
</style>
<script src="../vendors/jquery/dist/jquery.min.js"></script>
<![if !supportTabStrip]><script language="JavaScript">
<!--
function fnUpdateTabs()
 {
  if (parent.window.g_iIEVer>=4) {
   if (parent.document.readyState=="complete"
    && parent.frames['frTabs'].document.readyState=="complete")
   parent.fnSetActiveSheet(0);
  else
   window.setTimeout("fnUpdateTabs();",150);
 }
}

function printInv(){
	var vSuccess = /invsuccess/g;
    var vLastInv = $('#hInv').val();
	if (confirm('Dengan mencetak invoice ini, maka akan menambah nomor invoice terakhir menjadi '+pad(vLastInv,4)+', apakah Anda yakin mencetak?')){
			var vURL = 'mpurpose_ajax.php?op=printinv&year=<?=date("Y")?>&month=<?=date("m")?>';
			var vInvid = $('#hInv').val();
			var vNom = $('#hOutstand').val();
			var vNomin = $('#hNomin').val();
			
			$.post(vURL, {mem:'<?=$vJamaah?>',invid: vInvid, payfor:'Tagihan Umroh', nom:vNom,nomin:vNomin}, function(data) {
			    if (vSuccess.test(data)) {
								document.getElementById('divPrint').style.display='none';
								window.print();
								document.getElementById('divPrint').style.display='';	
				}
			
			});
			
	}
}

$(document).ready(function(){
   
   $.post('mpurpose_ajax.php?op=countinv&year=<?=date("Y")?>&month=<?=date("m")?>',function(data){
	    var vNextInv = parseFloat(data.trim()) + 1;
	    
		$('#lastInv').html(pad(vNextInv,4));
		$('#hInv').val(vNextInv);
   });
});


function pad (str, max) {
  str = str.toString();
  return str.length < max ? pad("0" + str, max) : str;
}

//-->
</script>
<![endif]>
</head>

<body link="#0563C1" vlink="#954F72" class=xl65>

<table border=0 cellpadding=0 cellspacing=0 width=1000 style='border-collapse:
 collapse;table-layout:fixed;width:740pt;margin-left:5px'>
 <col class=xl65 width=23 style='mso-width-source:userset;mso-width-alt:736;
 width:17pt'>
 <col class=xl65 width=166 style='mso-width-source:userset;mso-width-alt:5312;
 width:125pt'>
 <col class=xl65 width=22 style='mso-width-source:userset;mso-width-alt:704;
 width:17pt'>
 <col class=xl65 width=57 style='mso-width-source:userset;mso-width-alt:1824;
 width:43pt'>
 <col class=xl65 width=24 style='mso-width-source:userset;mso-width-alt:768;
 width:18pt'>
 <col class=xl65 width=67 style='mso-width-source:userset;mso-width-alt:2144;
 width:50pt'>
 <col class=xl65 width=23 style='mso-width-source:userset;mso-width-alt:736;
 width:17pt'>
 <col class=xl65 width=119 style='mso-width-source:userset;mso-width-alt:3808;
 width:89pt'>
 <col class=xl65 width=26 style='mso-width-source:userset;mso-width-alt:832;
 width:20pt'>
 <col class=xl65 width=19 style='mso-width-source:userset;mso-width-alt:608;
 width:14pt'>
 <col class=xl65 width=69 style='mso-width-source:userset;mso-width-alt:2208;
 width:52pt'>
 <col class=xl65 width=18 style='mso-width-source:userset;mso-width-alt:576;
 width:14pt'>
 <col class=xl65 width=133 style='mso-width-source:userset;mso-width-alt:4256;
 width:100pt'>
 <col class=xl65 width=19 style='mso-width-source:userset;mso-width-alt:608;
 width:14pt'>
 <col class=xl65 width=40 style='mso-width-source:userset;mso-width-alt:1280;
 width:30pt'>
 <col class=xl65 width=96 style='mso-width-source:userset;mso-width-alt:3072;
 width:72pt'>
 <col class=xl65 width=61 style='mso-width-source:userset;mso-width-alt:1952;
 width:46pt'>
 <col class=xl65 width=74 style='mso-width-source:userset;mso-width-alt:2368;
 width:56pt'>
 <tr height=20 style='height:15.0pt;border-top:1px solid #000'>
   <td width="23" height=20 class=xl95 style='height:15.0pt'>&nbsp;</td>
   <td class=xl65 style='mso-ignore:colspan'><img src="../images/logoinvoice.jpg" width="160" height="109" alt="IMG"></td>
   <td class=xl65 style='mso-ignore:colspan'>&nbsp;</td>
   <td class=xl65 style='mso-ignore:colspan'>&nbsp;</td>
   <td class=xl65 style='mso-ignore:colspan'>&nbsp;</td>
   <td class=xl65 style='mso-ignore:colspan'>&nbsp;</td>
   <td colspan="6" class=xl65 style='mso-ignore:colspan;vertical-align:top;'><div style="text-align:right">
     <table width="100%" border="0">
       <tr>
         <td align="right">PT. AMINAH (AMINAH TOUR)<br>
           Ruko Puri Kencana Karah Blok G No. 1 B Jambangan Selatan <br>
           Surabaya, Jawa Timur, Indonesia<br>
           Phone : +(62-31) 828 1956 - Fax : +(62-31) 828 1494<br>
           Email : aminah_a54@yahoo.com
           </td>
         </tr>
       </table>
     
     
   </div></td>

   <td class=xl96 style="vertical-align:top">&nbsp;</td>
 </tr>
 <tr height=21 style='mso-height-source:userset;height:15.75pt'>
   <td colspan=13 height=41 class=xl118 style='border-right:.5pt solid black;
  border-bottom:1.0pt solid black;height:30.75pt'>INVOICE</td>
 </tr>
 <tr height=19 style='height:14.25pt'>
   <td height=19 style='height:14.25pt' align=left valign=top><![if !vml]><![endif]><span
  style='mso-ignore:vglayout2'>
     <table cellpadding=0 cellspacing=0>
       <tr>
         <td height=19 class=xl95 width=23 style='height:14.25pt;width:17pt'>&nbsp;</td>
        </tr>
      </table>
    </span></td>
   <td colspan=8 class=xl65 style='mso-ignore:colspan'></td>
   <td width="19" align=left valign=top><![if !vml]><![endif]><span
  style='mso-ignore:vglayout2'>
     
    </span></td>
   <td colspan=2 class=xl65 style='mso-ignore:colspan'></td>
   <td class=xl96>&nbsp;</td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td height=19 class=xl95 style='height:14.25pt'>&nbsp;</td>
  <td colspan="6" rowspan="4" valign="top" class=xl65 style='mso-ignore:colspan;vertical-align:top'>Hari dan Tanggal :  <?=hariIni()?>, <?=tglIndonesia(date("Y-m-d"))?><br>
    No. Invoice	         :  <? 
	   
	  echo  $vInvNo =  "INVAMH.".date("Y.m").".";
	?><span id="lastInv"></span><input type="hidden" id="hInv" name="hInv" value=""></td>
  <td colspan="4" rowspan="4" class=xl65 style='mso-ignore:colspan;vertical-align:top'>Kepada:<br>
    <?
         $vSex = $oMember->getMemField('fsex',$vJamaah);
		 if ($vSex=='F')
		     echo "Umi";
		else 	 echo "Abah";
		
		echo " ".$oMember->getMemberName($vJamaah); 
	?> <br>
    <?
	    $vProp = $oMember->getMemField('fprop',$vJamaah);
		$vKab =  $oMember->getMemField('fkota',$vJamaah);
        echo $oMember->getWilName('ID',$vProp,$vKab,'00','0000');
	?><br>
    HP: +<?=$oMember->getNoHP($vJamaah); ?>
    <br>    
    <br></td>
  <td class=xl65 style='mso-ignore:colspan'></td>
  <td class=xl96>&nbsp;</td>
  </tr>
 <tr height=19 style='height:14.25pt'>
  <td height=19 class=xl95 style='height:14.25pt'>&nbsp;</td>
  <td class=xl65 style='mso-ignore:colspan'></td>
  <td class=xl96>&nbsp;</td>
  </tr>
 <tr height=19 style='height:14.25pt'>
  <td height=19 class=xl95 style='height:14.25pt'>&nbsp;</td>
  <td class=xl65 style='mso-ignore:colspan'></td>
  <td class=xl96>&nbsp;</td>
  </tr>
 <tr height=19 style='height:14.25pt'>
  <td height=19 class=xl95 style='height:14.25pt'>&nbsp;</td>
  <td class=xl65 style='mso-ignore:colspan'></td>
  <td class=xl97 width=133 style='width:100pt'>&nbsp;</td>
  </tr>
 <tr height=19 style='height:14.25pt'>
  <td height=19 class=xl95 style='height:14.25pt'>&nbsp;</td>
  <td colspan=11 class=xl65 style='mso-ignore:colspan'></td>
  <td class=xl96>&nbsp;</td>
  </tr>
 <tr height=19 style='height:14.25pt'>
  <td height=19 class=xl95 style='height:14.25pt'>&nbsp;</td>
  <td colspan=11 class=xl65 style='mso-ignore:colspan'></td>
  <td class=xl96>&nbsp;</td>
  </tr>
 <tr height=24 style='height:18.0pt'>
  <td height=24 class=xl98 colspan=7 style='height:18.0pt;mso-ignore:colspan'>Terima
  kasih telah memilih <font class="font10">AMINAH TOUR</font></td>
  <td colspan=5 class=xl65 style='mso-ignore:colspan'></td>
  <td class=xl96>&nbsp;</td>
  </tr>
 <tr height=24 style='height:18.0pt'>
  <td height=24 class=xl98 colspan=8 style='height:18.0pt;mso-ignore:colspan'>Konfirmasi
  reservasi Anda adalah sebagai berikut:</td>
  <td colspan=4 class=xl65 style='mso-ignore:colspan'></td>
  <td class=xl96>&nbsp;</td>
  </tr>
 <tr height=24 style='height:18.0pt'>
  <td height=24 class=xl99 style='height:18.0pt'>&nbsp;</td>
  <td colspan=11 class=xl65 style='mso-ignore:colspan'></td>
  <td class=xl96>&nbsp;</td>
  </tr>
 <tr height=24 style='height:18.0pt'>
  <td height=24 class=xl99 colspan=3 style='height:18.0pt;mso-ignore:colspan'>Informasi
  Pemesanan</td>
  <td colspan=9 class=xl65 style='mso-ignore:colspan'></td>
  <td class=xl96>&nbsp;</td>
  </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl95 style='height:15.0pt'>&nbsp;</td>
  <td width="166" class=xl100>PAKET UMROH</td>
  <td colspan=10 class=xl65 style='mso-ignore:colspan'></td>
  <td class=xl96>&nbsp;</td>
  </tr>
 <tr class=xl66 height=20 style='height:15.0pt'>
  <td height=20 class=xl101 style='height:15.0pt'>&nbsp;</td>
  <td class=xl67>TANGGAL</td>
  <td colspan=2 class=xl112 style='border-right:.5pt solid black;border-left:
  none'>PAKET</td>
  <td colspan=2 class=xl112 style='border-right:.5pt solid black;border-left:
  none'>DEP</td>
  <td colspan=2 class=xl112 style='border-right:.5pt solid black;border-left:
  none'>ARR</td>
  <td colspan=2 class=xl112 style='border-right:.5pt solid black;border-left:
  none'>ETD</td>
  <td colspan="2" class=xl68 style='border-left:none'>ETA</td>
  <td class=xl102>&nbsp;</td>
  </tr>
 <tr class=xl74 height=17 style='height:12.75pt'>
  <td height=17 class=xl88 style='height:12.75pt'>&nbsp;</td>
  <td class=xl82>Berangkat, <?=$vBerangkat?></td>
  <td width="22" rowspan=2 class=xl114 style='border-bottom:1.0pt solid black'><?=$db->f('fpaketday')?></td>
  <td width="57" rowspan=2 class=xl116 style='border-bottom:1.0pt solid black'>HARI</td>
  <td colspan=2 class=xl88 style='border-right:.5pt solid black;border-left:
  none'>&nbsp;</td>
  <td colspan=2 class=xl88 style='border-right:.5pt solid black;border-left:
  none'>&nbsp;</td>
  <td colspan=2 class=xl126 style='border-right:.5pt solid black;border-left:
  none'>&nbsp;</td>
  <td colspan="2" class=xl90  style='border-right:.5pt solid black;border-left:
  none'>&nbsp;</td>
  <td class=xl89>&nbsp;</td>
  </tr>
 <tr class=xl74 height=18 style='height:13.5pt'>
  <td height=18 class=xl88 style='height:13.5pt'>&nbsp;</td>
  <td class=xl83>Pulang, <?=$vPulang?></td>
  <td colspan=2 class=xl124 style='border-right:.5pt solid black;border-left:
  none'>&nbsp;</td>
  <td colspan=2 class=xl124 style='border-right:.5pt solid black;border-left:
  none'>&nbsp;</td>
  <td colspan=2 class=xl127 style='border-right:.5pt solid black;border-left:
  none'>&nbsp;</td>
  <td colspan="2" class=xl91>&nbsp;</td>
  <td class=xl89>&nbsp;</td>
  </tr>
 <tr class=xl66 height=19 style='height:14.25pt'>
  <td height=19 class=xl101 style='height:14.25pt'>&nbsp;</td>
  <td colspan=11 class=xl66 style='mso-ignore:colspan'></td>
  <td class=xl102>&nbsp;</td>
  </tr>
 <tr class=xl66 height=19 style='height:14.25pt'>
  <td height=19 class=xl101 style='height:14.25pt'>&nbsp;</td>
  <td colspan=11 class=xl66 style='mso-ignore:colspan'></td>
  <td class=xl102>&nbsp;</td>
  </tr>
 <tr class=xl66 height=19 style='height:14.25pt'>
  <td height=19 class=xl101 style='height:14.25pt'>&nbsp;</td>
  <td class=xl100>RINCIAN BIAYA</td>
  <td colspan=10 class=xl66 style='mso-ignore:colspan'></td>
  <td class=xl102>&nbsp;</td>
  </tr>
 <tr class=xl69 height=17 style='height:12.75pt'>
  <td height=17 class=xl103 style='height:12.75pt'>&nbsp;</td>
  <td class=xl70>Biaya Umroh</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td width="24" class=xl70>&nbsp;</td>
  <td width="67" class=xl70>&nbsp;</td>
  <td width="23" class=xl70>&nbsp;</td>
  <td width="119" class=xl71>&nbsp;</td>
  <td width="26" class=xl72>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td width="69" class=xl70>&nbsp;</td>
  <td width="18" class=xl70>&nbsp;</td>
  <td class=xl104>&nbsp;</td>
  </tr>
 <tr class=xl69 height=17 style='height:12.75pt'>
  <td height=17 class=xl103 style='height:12.75pt'>&nbsp;</td>
  <td class=xl69 colspan=2 style='mso-ignore:colspan'>Pemberangkatan <?=tglIndonesia($vBerangkatX)?></td>
  <td colspan=9 class=xl69 style='mso-ignore:colspan'></td>
  <td class=xl105>&nbsp;</td>
  </tr>
 <tr class=xl69 height=17 style='height:12.75pt'>
  <td height=17 class=xl103 style='height:12.75pt'>&nbsp;</td>
  <td class=xl69>Kurs Min. Rp <?=number_format($vKurs,0,",",".")?></td>
  <td class=xl69></td>
  <td class=xl73></td>
  <td class=xl69></td>
  <td class=xl73></td>
  <td class=xl74>=</td>
  <td class=xl75>Rp<?=number_format($db->f('fprice'),0,",",".")?></td>
  <td class=xl74>X</td>
  <td class=xl69 align=right>1</td>
  <td class=xl69>&nbsp;Jamaah</td>
  <td class=xl69>=</td>
  <td class=xl106>Rp<?=number_format($db->f('fprice'),0,",",".")?></td>
  </tr>
 <tr class=xl69 height=17 style='height:12.75pt'>
  <td height=17 class=xl103 style='height:12.75pt'>&nbsp;</td>
  <td class=xl69 colspan=7 style='mso-ignore:colspan'>Sudah include biaya
  paspor, airportax handling dan Suntik Miningitis</td>
  <td class=xl74></td>
  <td colspan=3 class=xl69 style='mso-ignore:colspan'></td>
  <td class=xl106>&nbsp;</td>
  </tr>
 <tr class=xl69 height=17 style='height:12.75pt'>
  <td height=17 class=xl103 style='height:12.75pt'>&nbsp;</td>
  <td class=xl76>&nbsp;</td>
  <td class=xl76>&nbsp;</td>
  <td class=xl76>&nbsp;</td>
  <td class=xl76>&nbsp;</td>
  <td class=xl76>&nbsp;</td>
  <td class=xl77>&nbsp;</td>
  <td class=xl78>&nbsp;</td>
  <td class=xl77>&nbsp;</td>
  <td class=xl76>&nbsp;</td>
  <td class=xl76>&nbsp;</td>
  <td class=xl76>&nbsp;</td>
  <td class=xl107>&nbsp;</td>
  </tr>
 <tr class=xl69 height=17 style='height:12.75pt'>
  <td height=17 class=xl103 style='height:12.75pt'>&nbsp;</td>
  <td colspan=11 class=xl111>TOTAL TAGIHAN BIAYA</td>
  <td class=xl108 style='border-top:none'>Rp<?=number_format($db->f('fprice'),0,",",".")?></td>
  </tr>
 <tr class=xl69 height=17 style='height:12.75pt'>
  <td height=17 class=xl103 style='height:12.75pt'>&nbsp;</td>
  <td colspan=11 class=xl80 style='mso-ignore:colspan'></td>
  <td class=xl109>&nbsp;</td>
  </tr>
  <?
     $vSQL = "select *,date(ftanggal) as fdateonly from tb_payhist where fidmember = '$vJamaah'";
	 $dbin->query($vSQL);
	 $vTotMasuk = 0;
	  while ($dbin->next_record()) {
		     $vTglBayar = $dbin->f('fdateonly');
			 $vFor = $dbin->f('fkind');
			 $vCredit  = $dbin->f('fcredit');
			 $vTotMasuk+=$vCredit;
  ?>
  
 <tr class=xl69 height=17 style='height:12.75pt'>
  <td height=17 class=xl103 style='height:12.75pt'>&nbsp;</td>
  <td class=xl84 colspan=3 style='mso-ignore:colspan'>Tgl <?=tglIndonesia($vTglBayar)?> 
  <?
        switch($vFor) {
		case 'sawal':
				$vKet = "Setoran Awal Tunai";
				break;
		case 'angs1':
				$vKet = "Angsuran 1";
				break;
		case 'angs2':
				$vKet = "Angsuran 2";
				break;
		case 'angs3':
				$vKet = "Angsuran 3";
				break;
		case 'angs4':
				$vKet = "Angsuran 4";
				break;
		case 'lunas':
				$vKet = "Pelunasan";
				break;
				
				
		}
			echo $vKet;	
  ?>
  </td>
  <td class=xl72>&nbsp;</td>
  <td class=xl72>&nbsp;</td>
  <td class=xl72>&nbsp;</td>
  <td class=xl85>&nbsp;</td>
  <td class=xl72>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>=</td>
  <td class=xl104>Rp<?=number_format($vCredit,0,",",".")?></td>
  </tr>
  
  <? 
     $vOutstanding = $db->f('fprice') - $vCredit;
  } ?>
 <tr class=xl69 height=17 style='height:12.75pt'>
  <td height=17 class=xl103 style='height:12.75pt'>&nbsp;</td>
  <td class=xl86>&nbsp;</td>
  <td class=xl77>&nbsp;</td>
  <td class=xl77>&nbsp;</td>
  <td class=xl77>&nbsp;</td>
  <td class=xl77>&nbsp;</td>
  <td class=xl77>&nbsp;</td>
  <td class=xl87>&nbsp;</td>
  <td class=xl77>&nbsp;</td>
  <td class=xl76>&nbsp;</td>
  <td class=xl76>&nbsp;</td>
  <td class=xl76>&nbsp;</td>
  <td class=xl107>&nbsp;</td>
  </tr>
 <tr class=xl69 height=17 style='height:12.75pt'>
  <td height=17 class=xl103 style='height:12.75pt'>&nbsp;</td>
  <td colspan=11 class=xl111>TOTAL DANA MASUK</td>
  <td class=xl108 style='border-top:none'>Rp<?=number_format($vTotMasuk,0,",",".")?>
  <input type="hidden" id="hNomin" name="hNomin" value="<?=$vTotMasuk?>">
  </td>
  </tr>
 <tr class=xl69 height=17 style='height:12.75pt'>
  <td height=17 class=xl103 style='height:12.75pt'>&nbsp;</td>
  <td colspan=11 class=xl80 style='mso-ignore:colspan'></td>
  <td class=xl109>&nbsp;</td>
  </tr>
 <tr class=xl69 height=17 style='height:12.75pt'>
   <td height=17 class=xl110 style='height:12.75pt'>&nbsp;</td>
   <td colspan=11 class=xl111>KEKURANGAN PEMBAYARAN (TOTAL DANA MASUK - TAGIHAN)</td>
   <td class=xl108>Rp<?=number_format($vOutstanding,0,",",".")?>
   <input type="hidden" id="hOutstand" name="hOutstand" value="<?=$vOutstanding?>">
   </td>
  </tr>
 <![if supportMisalignedColumns]>
 <![endif]>
</table>
<br>
<div class="row">
<div class="col-lg-12" style="padding-left:20px">
<div id="divPrint"><input name="btnPrint" type="button" value="Print&nbsp;" onClick="printInv()" class="btn btn-success"></div>
</div>
</body>

</html>
