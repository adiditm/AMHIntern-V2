<?
	session_start();
	$vUser=$_SESSION['LoginUser'];
    $vPriv=$_SESSION['Priv'];
	include_once "../server/config.php";
	include_once CLASS_DIR."productclass.php";
	include_once CLASS_DIR."ruleconfigclass.php";
	include_once "../classes/systemclass.php";
	include_once CLASS_DIR."dateclass.php";
	include_once CLASS_DIR."jualclass.php";
	include_once CLASS_DIR."komisiclass.php";
	
	 if ($_SESSION['LoginUser']=="") {
		$oSystem->jsAlert("Not Authorized");
		//$oSystem->jsLocation("logout.php");
		$oSystem->jsCloseWin();
		exit;
	 }
	 
	 $vTanggal=$_POST['dc'];
	 if ($vTanggal=="") $vTanggal=$oPhpdate->getNowYMDT("-");
	 $vAction=$_POST['hAction'];
	 $vNoJual=$_SESSION['sNoJual'];
	 $vIDMember=$_POST['lmID'];
	 $vIDProduk=$_POST['lmIDProd'];
	 $vQty=$_POST['tfJumlah'];
	 $vHargaSat=$oProduct->getHargaJual($vIDProduk);
	 
	 if ($vAction=="add") {
	    //addItem($fidpenjualan,$fidmember,$fidproduk,$fjumlah,$fhargasat,$fsubtotal,$fketerangan) {
		$vSubTot=$vQty * $vHargaSat;
		$oJual->addItem($vNoJual,$vIDMember,$vIDProduk,$vQty,$vHargaSat,$vSubTot,"-"); 
	 }


	 if ($vAction=="post") {
	    //addItem($fidpenjualan,$fidmember,$fidproduk,$fjumlah,$fhargasat,$fsubtotal,$fketerangan) {
		$oJual->postJual($vNoJual,$vTanggal);
	 }

	 if ($vAction=="del") {
		$oJual->delItem($vNoJual,$vIDMember,$vIDProduk); 
	 }



	 
	 
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Pembelian</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="netto.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style4 {font-size: 18px}
.style5 {
	font-size: 14px;
	font-weight: bold;
}
-->
</style>
</head>

<body class="loginfont" onLoad="window.print();">
<p align="center" class="style1"><span class="style5">Detail Pembelian 
</span></p>
<p align="center" class="style1"><span class="style5">
  <script>
    </script>
  </span>
  <strong>
  <script></script>
  </strong>
  <script>function AddItem() {
      document.getElementById("hAction").value="add";

	  if (document.getElementById("lmIDProd").value=="-" || document.getElementById("lmID").value=="-" ) {
	     alert('Anda belum memilih ID Anggota atau ID Produk');
		 return false;
	  } else	     
  	  document.frJual.submit();
  }

  function DelItem(pIDProd) {
      document.getElementById("hAction").value="del";
  	  document.getElementById("lmIDProd").value=pIDProd;
	  document.frJual.submit();
  }


  function PostJual(pNoUrut) {
    if (pNoUrut!='0') {  
	  if (confirm('Yakin memposting penjualan?')==true) {
		  document.getElementById("hAction").value="post";
		  document.frJual.submit();
	  }
	 } else alert('Anda belum memnambah Item Produk!'); 
  }

  </script>
</p>
<table width="482" border="0">
  <tr>
    <td width="153"><div align="left"><strong>Tanggal </strong></div></td>
    <td width="10"><div align="left"><strong>:</strong></div></td>
    <td width="311"><div align="left"><strong>
      <?=$oPhpdate->YMD2DMY($_GET['uTanggal'])?>
    </strong></div></td>
  </tr>
  <tr>
    <td><div align="left"><strong>No. Pembelian </strong></div></td>
    <td><div align="left"><strong>:</strong></div></td>
    <td><div align="left"><strong>
      <?=$_GET['uNoJual']?>
    </strong></div></td>
  </tr>
  <tr>
    <td><div align="left"><strong>Member
    </strong>/ <strong>Pebisnis</strong></div></td>
    <td><div align="left"><strong>:</strong></div></td>
    <td><div align="left"><strong>
      <?=$_GET['uIDMember']." / ".$oMember->getMemberNameAdm($_GET['uIDMember'],'sponsor')?>
    </strong></div></td>
  </tr>
  <tr>
    <td valign="top"><strong>Alamat Kirim</strong></td>
    <td valign="top"><strong>:</strong></td>
    <td valign="top"><strong>
      <?
    		echo $oJual->getJualField($_GET['uNoJual'],'frecname');
			echo "<br>";
			echo $oJual->getJualField($_GET['uNoJual'],'falamatkrm');
	?>
    </strong></td>
  </tr>
  <tr >
    <td><strong>HP No</strong></td>
    <td><strong>:</strong></td>
    <td><strong>
      <?
    		
			echo $oJual->getJualField($_GET['uNoJual'],'frecnohp');
	?>
    </strong></td>
  </tr>
  <tr>
    <td><strong>Metode Pembayaran</strong></td>
    <td><strong>:</strong></td>
    <td><strong>
      <? 
      $vSQL = "select * from tb_trx_va where va_refid ='".$_GET['uNoJual']."';";
      $db->query($vSQL);
      $db->next_record();
      $vBank = strtoupper($db->f('va_bankcode'));
	   $vMethod=$oJual->getPayMethod($_GET['uNoJual']);
	   if ($vMethod=='ctr' || $vMethod=='mTrans') 
	      echo 'Cash/Transfer';
	   else if ($vMethod=='tva' ) 
        echo "Transfer Virtual Account $vBank";
     else echo 'eWallet'; 	  
	   
	   ?>
    </strong></td>
  </tr>
</table>
<p class="style1"><br>
  <strong>Items :</strong><br>
</p>
<form action="" method="post" name="frJual" class="style1"  id="frJual">
  <br>
  <table width="100%"  border="1" cellspacing="0" cellpadding="0">
    <tr>
      <td width="3%"><div align="center"><strong>No</strong></div></td>
      <td width="14%"><div align="center"><strong>Kode Barang</strong></div></td>
      <td width="27%"><div align="center"><strong>Nama </strong></div></td>
      <td width="19%"><div align="center"><strong>Hrg Sat </strong></div></td>
      <td width="7%"><div align="center"><strong>Jumlah</strong></div></td>
      <td width="15%"><div align="center"><strong>Subtotal</strong></div></td>
    </tr>
    <?
	  $vNoJual=$_GET['uNoJual'];
	   $vsql="select a.*, b.am_fee from(select *, 2 as fstatus from tb_trxstok_member where fidpenjualan='$vNoJual' union all select *, 0 as fstatus from tb_trxstok_member_temp where fidpenjualan='$vNoJual') as a left join tb_trx_va b on a.fidpenjualan=b.va_refid where a.fidpenjualan='$vNoJual'";

	  $db->query($vsql);
	  $vNoUrut=0;
	  $vTot=0;
	  $vTotPoint=0;
	  while ($db->next_record()) {
	      $vNoUrut+=1;
        $vIdProdList=$db->f("fidproduk");
        $vStatus=$db->f("fstatus");
        $vPaid=$db->f("fpaid");
        $vAMHFee = $db->f("am_fee");
        $vExpe = strtoupper($db->f("fexpe")).' Paket '.$db->f("fpack");
	?>
	<tr>
      <td><?=$vNoUrut?></td>
      <td><?=$db->f("fidproduk");?></td>
      <td><?=$oProduct->getProductName($db->f("fidproduk"));?></td>
      <td><div align="right">
        <?
		  echo number_format($db->f("fhargasat"),0,",",".");
		  $vHargaJual=$db->f("fhargasat");
		?>
      </div></td>
      <td><div align="right">
        <?
		  echo number_format($db->f("fjumlah"),0,",",".");
		  $vSubTot=$db->f("fjumlah") *  $vHargaJual;
		?>
      </div></td>
      <td><div align="right">
        <?
		  
		  $vTot+=$vSubTot;
		  echo number_format($vSubTot,0,",",".");
		?>
      </div></td>
    </tr>
	<? } ?>
    <tr>
      <td colspan="5" align="rifght">Biaya Pengiriman (<?=$vExpe?>)</td>
      <td align="right"><?
         echo number_format($vCost=$oJual->getJualField($_GET['uNoJual'],'fongkir'),0,",",".");
	  ?>      </td>
    </tr>

    <tr>
      <td colspan="5" align="rifght">Biaya Admin</td>
      <td align="right"><?
         echo number_format($vAMHFee,0,",",".");
	  ?>      </td>
    </tr>

    <tr>
      <td colspan="5"><strong>Total</strong></td>
      <td><div align="right"><strong>
        <?
		  
		  $vTot+=$vSusTot;
		  echo number_format($vTot+$vCost+$vAMHFee,0,",",".");
		?>
        
      </strong></div></td>
    </tr>
  </table>
  <? if ($vStatus=='0' && $vPaid=='0')  {?> 
  <br>
  <b style="color:red">Status: Pending</b><br>
  <? } else if($vStatus=='0' && $vPaid=='1') {?>
    <b style="color:blue">Status: Diproses</b><br>
  <? } ?>
  <? if (preg_match("/KIT/",$vIdProdList)) { ?>
  <br>
  
  <b>Detail KIT :</b><br>
  
  <table width="482"  border="1" cellspacing="0" cellpadding="0">
  <tr style="font-weight:bold">
    <td width="32"><div align="center">No.</div></td>
    <td width="352"><div align="center">Serial / KIT</div></td>
    <td width="90"><div align="center">Paket</div></td>
  </tr>
  <?
      $vSQL="select * from tb_skit where frefpurc='".$_GET['uNoJual']."'";
	 $db->query($vSQL);
	 $vNo=0;
	 while ($db->next_record()) {
		 $vNo++;
  ?>
  <tr>
    <td><?=$vNo?></td>
    <td><?=$db->f('fserno')?></td>
    <td align="center"><?=$db->f('fpaket')?></td>
  </tr>
  
  <? } ?>
</table>

  <? } ?>
  <br>
  <br>
  <br>
</form>
<span style="font-family: Verdana, Arial, Helvetica, sans-serif">
<iframe width=188 height=166 name="gToday:datetime:agenda.js:gfPop:plugins_timeSec.js" id="gToday:datetime:agenda.js:gfPop:plugins_time.js" src="ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>

</span>
</body>

</html>
