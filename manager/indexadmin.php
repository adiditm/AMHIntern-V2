<? include_once("../framework/admin_headside.blade.php")?>
<?
  $vRefer=$_SERVER['HTTP_REFERER'];
  $vRefer = explode("/",$vRefer);
  $vCount = count($vRefer) -1;
  $vRefer = $vRefer[$vCount];
  if ($vPriv=='sponsor')
     $vContent=$oInterface->getMenuContent('beranda3');
  if ($vPriv=='korwil')
     $vContent=$oInterface->getMenuContent('beranda2');

?>
	<div class="right_col" role="main">

		<h1 style="font-size:1.5rem;font-weight:800;color:#fff;margin:0 0 1rem;">Dashboard</h1>

		<button type="button" class="amh-btn-outline" id="btnModal" data-toggle="modal" data-target="#myModal" style="display:none">Open Modal</button>

		<div class="amh-stat-grid">
			<div class="amh-glass-panel amh-stat-card">
				<div class="amh-stat-icon" style="background:rgba(168,85,247,0.15);color:#c084fc;"><i class="fa fa-user"></i></div>
				<div>
					<div class="amh-stat-value"><?
						$vSQL = "select count(fidsys) as fcount from m_anggota where faktif  ='1' ";
						$db->query($vSQL);
						$db->next_record();
						echo $db->f('fcount');
					?></div>
					<div class="amh-stat-label">Total Jamaah</div>
				</div>
			</div>

			<div class="amh-glass-panel amh-stat-card">
				<div class="amh-stat-icon" style="background:rgba(56,189,248,0.15);color:#38bdf8;"><i class="fa fa-user"></i></div>
				<div>
					<div class="amh-stat-value"><?
						$vMonthNow = date('Y-m');
						$vSQL = "select count(fidsys) as fcount from m_anggota where faktif  ='1' and  date_format(ftglaktif,'%Y-%m') = '$vMonthNow' ";
						$db->query($vSQL);
						$db->next_record();
						echo $db->f('fcount');
					?></div>
					<div class="amh-stat-label">Jamaah Bulan Ini</div>
				</div>
			</div>

			<div class="amh-glass-panel amh-stat-card">
				<div class="amh-stat-icon" style="background:rgba(52,211,153,0.15);color:#34d399;"><i class="fa fa-plane"></i></div>
				<div>
					<div class="amh-stat-value"><?
						$vMonthNow = date('Y-m');
						$vSQL = "select count(fidsys) as fcount from m_anggota where faktif  ='1' and  date_format(ftglaktif,'%Y-%m') = '$vMonthNow' and fpaspor <>'' ";
						$db->query($vSQL);
						$db->next_record();
						echo $db->f('fcount');
					?></div>
					<div class="amh-stat-label">Siap Brgkt Bln. Ini</div>
				</div>
			</div>

			<div class="amh-glass-panel amh-stat-card">
				<div class="amh-stat-icon" style="background:rgba(251,113,133,0.15);color:#fb7185;"><i class="fa fa-clock-o"></i></div>
				<div>
					<div class="amh-stat-value"><?
						$vMonthNow = date('Y-m');
						$vSQL = "select count(fidsys) as fcount from m_anggota where faktif  ='1' and  date_format(ftglaktif,'%Y-%m') = '$vMonthNow' and fpaspor ='' ";
						$db->query($vSQL);
						$db->next_record();
						echo $db->f('fcount');
					?></div>
					<div class="amh-stat-label">Blm Siap Berangkat</div>
				</div>
			</div>

			<div class="amh-glass-panel amh-stat-card">
				<div class="amh-stat-icon" style="background:rgba(56,189,248,0.15);color:#38bdf8;"><i class="fa fa-list"></i></div>
				<div>
					<div class="amh-stat-value"><?
						$vSQL = "select count(*) as fcount from(select distinct fidpenjualan from tb_penjualan_temp) as a ";
						$db->query($vSQL);
						$db->next_record();
						echo $db->f('fcount');
					?></div>
					<div class="amh-stat-label">Transaksi Produk Pending</div>
				</div>
			</div>

			<div class="amh-glass-panel amh-stat-card">
				<div class="amh-stat-icon" style="background:rgba(168,85,247,0.15);color:#c084fc;"><i class="fa fa-list"></i></div>
				<div>
					<div class="amh-stat-value"><?
						$vSQL = "select count(*) as fcount from(select distinct fidpenjualan from tb_penjualan) as a ";
						$db->query($vSQL);
						$db->next_record();
						echo $db->f('fcount');
					?></div>
					<div class="amh-stat-label">Transaksi Produk Sukses</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content amh-glass-panel" style="color:#e2e8f0;">
					<div class="modal-header" style="border-bottom:1px solid rgba(255,255,255,0.1);">
						<button type="button" class="close" data-dismiss="modal" style="color:#e2e8f0;">&times;</button>
						<h4 class="modal-title">Tata Cara</h4>
					</div>
					<div class="modal-body">
						<p><?=$vContent?></p>
					</div>
					<div class="modal-footer" style="border-top:1px solid rgba(255,255,255,0.1);">
						<button type="button" class="amh-btn-gold" data-dismiss="modal">Saya setuju dengan tata-cara ini!</button>
					</div>
				</div>
			</div>
		</div>

	</div>
<script language="javascript">
   $(document).ready(function(){
	   <? 
	   $vRefer = addslashes($vRefer);
	   if (preg_match("/login.php/i","$vRefer") && $vPriv !='administrator') { ?>
	   		$('#btnModal').trigger('click');
	   
	   <? } ?>
	   
   });
   
   
<? if ($vScriptName!='aktif.php') { 
			$vSQL = "select  * from m_anggota where faktif = '0' ";
			$db->query($vSQL);
			while($db->next_record()) {
				$vIDMember = $db->f('fidmember');
				$vNama = $db->f('fnama');
				$vRefer = $db->f('frefer');
				$vNamaRefer = $db->f('fnamarefer');
				$vRegistrar = $db->f('fidregistrar');

?>
Lobibox.notify('warning',  // Available types 'warning', 'info', 'success', 'error'
{
   closeOnEsc      : true,
   draggable       : true, 
   msg					:'Aktifasi <font color="#0f0">member</font> <?=$vIDMember?> / <?=$vNama?> ! Klik <a style="color:blue" href="../manager/aktif.php?hOP=post&current=mdm_admin&menu=mdm_admin_verify&tfNama=&tfKota=&tfDepart=&tfNoHP=&lmAktif=&tfID=&tfNama=<?=$vNama?>&tfNoHP=&tfKota=&tfDepart=&lmStockist=&lmAktif=3&lmMship=-&lmSort=1&Submit=Cari&choosed=<?=$vIDMember?>">di sini</a> utk memproses. ',
   delay: false,
   closeOnClick : false,
   size : 'mini' 


});
<? } 
}
?>


<? if ($vScriptName!='appvpay.php') { 

				$vsql ="select distinct ftglentry, fidpenjualan,fidseller,fidmember, fketerangan,fprocessed, fjumlah, fsubtotal   from tb_payment_temp where   fjenis='POIN' and fmethod='ctr' and fprocessed='1' ";
				 $vsql.= " union ";			 
				 $vsql.= " select distinct ftglentry, fidpenjualan,fidseller,fidmember, fketerangan,fprocessed , fjumlah, fsubtotal  from tb_payment where   fjenis='POIN' and fmethod='ctr'  and fprocessed='1'";
				 			
			$db->query($vsql);
			while($db->next_record()) {
				$vIDMember = $db->f('fidmember');
				$vNama = $oMember->getMemberName($vIDMember);
				$vPayer = $db->f('fidseller');
				

?>
Lobibox.notify('warning',  // Available types 'warning', 'info', 'success', 'error'
{
   closeOnEsc      : true,
   draggable       : true, 
   msg					:'Aktifasi <font color="#0f0">payment</font> <?=$vIDMember?> / <?=$vNama?> ! Klik <a style="color:blue" href="../manager/appvpay.php?op=&current=mdm_admin&menu=mdm_admin_appvpay">di sini</a> utk memproses. ',
   delay: false,
   closeOnClick : false,
   size : 'mini' 


});
<? } 
}
?>


<? if ($vScriptName!='veriwith.php') { 

				$vsql ="select distinct ftglupdate, fidwithdraw,fidmember, fket,fstatusrow, fnominal from tb_withdraw where    fstatusrow='0' ";
				 			
			$db->query($vsql);
			while($db->next_record()) {
				$vIDMember = $db->f('fidmember');
				$vNama = $oMember->getMemberNameAdm($vIDMember,'sponsor');
				
				

?>
Lobibox.notify('warning',  // Available types 'warning', 'info', 'success', 'error'
{
   closeOnEsc      : true,
   draggable       : true, 
   msg					:'Approval <font color="#0f0">pencairan</font> <?=$vIDMember?> / <?=$vNama?> ! Klik <a style="color:blue" href="../manager/veriwith.php?op=&current=mdm_admin&menu=mdm_admin_veriwith">di sini</a> utk memproses. ',
   delay: false,
   closeOnClick : false,
   size : 'mini' 


});
<? } 
}
?>


<? if ($vPriv=='administrator' && $vScriptName!='approvesell.php') { 

				$vsql ="select distinct fidpenjualan from tb_penjualan_temp_out where (ifnull(fprocessed,'0')='0' or ifnull(fprocessed,0)=0)";
				 			
			$db->query($vsql);
			while($db->next_record()) {
				$vIDJual = $db->f('fidpenjualan');
				
				

?>
Lobibox.notify('warning',  // Available types 'warning', 'info', 'success', 'error'
{
   closeOnEsc      : true,
   draggable       : true, 
   msg					:'Pemrosesan transaksi produk (<?=$vIDJual?>)! Klik <a style="color:blue" href="../manager/approvesell.php?hl=<?=$vIDJual?>">di sini</a> untuk melihat.',
   delay: false,
   closeOnClick : false,
   size : 'mini' 


});
<? } 
}
?>

   
</script>

<? include_once("../framework/admin_footside.blade.php") ; ?>