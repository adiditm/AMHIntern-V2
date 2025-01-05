<?
  session_start();
  
  include "../server/config.php";
  include_once("../classes/systemclass.php");
  include_once("../classes/ruleconfigclass.php");
  include_once("../classes/networkclass.php");
  include_once("../classes/antaclass.php");
  include_once("../classes/memberclass.php");
    include_once("../classes/pulsaclass.php");

  $vPriv=$_SESSION['Priv']; 
  $vUser=$_SESSION['LoginUser'];
  if ($vUser=="") {
     $oSystem->jsAlert("Not Authorized!");
	 $oSystem->jsCloseWin();
  }
  
  $vIdTRX=$_GET['trx'];
	  $vSQL="select a.*, b.sn,b.ppobTag, b.ppobBiaya,b.ppobDetil,c.fprodname from tb_trxpulsa a left join tb_reversal b on a.fidtrx=b.client_trxid left join m_postpaid c on a.fkdproduk=c.fcmdbyr where a.fidtrx='$vIdTRX'";
	$db->query($vSQL);
	$db->next_record();
    $vSN=$db->f('fsn'); 
	$vRek=$db->f('fmsisdn'); 
	 $vFeePPOB=$oRules->getSettingByField("fadmppob");
	$vSN=$db->f('sn'); 
	 $vAdmin=$db->f('ppobBiaya');
	$vTagihan=$db->f('ppobTag') - $vAdmin; 
	$vAdminTot= $vFeePPOB;
	// + $vAdmin; 
	$vTagihanTot=$vTagihan+$vAdminTot;
	$vAtasnama=$db->f('ppobDetil');
	$vAtasnama=explode("Nama:",$vAtasnama);
	$vAtasnama=$vAtasnama[1];
	$vAtasnama=explode(":",$vAtasnama);
	$vAtasnama=$vAtasnama[0];
	$vAtasnama=str_replace("periode","",$vAtasnama);
	
	$vProduct = $db->f('fprodname');
	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>History</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.style1 {
	font-size: 16px;
	font-weight: bold;
}
.style2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: bold;
}
.style6 {color: #000000; font-weight: bold; font-size: 12px; }
.style7 {color: #000000}
.style8 {
	font-size: 12px;
	font-weight: bold;
}
.style9 {color: #000000; font-weight: bold; }
-->

.table {
   border:1px solid;
   border-collapse:collapse;	
}

.table td {
  border:1px solid;	
}
</style>
</head>
<body leftmargin="0" topmargin="0" onLoad="window.print();">
<div align="center"><span class="style2 style7">Pembayaran PPOB (<?=$vProduct?>)</span> <span class="style7"><br>
</span><br>
  <? if (true) { ?>
  <table width="95%" border="0" cellpadding="0" cellspacing="0" style="border:none">
    <tr>
      <td height="30" width="41%" class="tbhist" nowrap>ID Pel / Rekening / No. Pasca Bayar</td>
      <td width="0%" class="tbhist">:</td>
      <td width="59%" class="tbhist">&nbsp; <?=$vRek?></td>
    </tr>
   
	<tr >
      <td height="30" class="tbhist"><span class="style7">
        Nama</span></td>
      <td class="tbhist style7">:</td>
      <td class="tbhist style7" style="padding-left:7px"> <?=$vAtasnama?> </td>
    </tr>
	<tr>
	  <td height="30"  class="tbhist">Serial Number</td>
	  <td class="tbhist style7">:</td>
	  <td class="tbhist style7">&nbsp; <?=$vSN?> </td>
    </tr>
	<tr>
	  <td height="30"  class="tbhist">Jumlah Tagihan</td>
	  <td class="tbhist style7">:</td>
	  <td class="tbhist style7"><div align="right">
	    <?=number_format($vTagihan,0,",",".")?>
      </div></td>
    </tr>
	<tr>
	  <td height="30"  class="tbhist">Biaya Admin</td>
	  <td class="tbhist style7">:</td>
	  <td class="tbhist style7"><div align="right">
	    <?=number_format($vAdminTot,0,",",".")?>
      </div></td>
    </tr>
	<tr style="font-weight:bold">
	  <td height="30"  class="tbhist">Total Tagihan</td>
	  <td class="tbhist style7">:</td>
	  <td class="tbhist style7"><div align="right">
	    <?=number_format($vTagihanTot,0,",",".")?> 
      </div></td>
    </tr>
	

  </table>
	<? 
	} else {
	
	?>
	<? } ?>
</div>
<p align="center" class="style1">&nbsp;</p>
</body>
</html>
