<?
    include_once("../server/config.php");
	 include_once("../classes/ruleconfigclass.php");
	 include_once("../classes/dateclass.php");

	 $vGroupLabel = array('u'=>'Umroh','t'=>'Tour Internasional','d'=>'Tour Domestik','h'=>'Haji');
	 $vTours = array();
	 $vSQL = "select * from m_tour where date(now()) <= ftgldepart and now() <= fexpired order by fgroup desc, ftgldepart asc";
	 $db->query($vSQL);
	 while ($db->next_record()) {
	     $vTours[] = array(
	         'tgl'      => $oPhpdate->YMD2DMY($db->f('ftgldepart')),
	         'hari'     => $db->f('fjmlhari'),
	         'kategori' => isset($vGroupLabel[$db->f('fgroup')]) ? $vGroupLabel[$db->f('fgroup')] : '',
	         'kota'     => $db->f('fcitydepart'),
	     );
	 }

	 $vKursSQL = "select * from tb_rules_config where fsetname='finfokursusd'";
	 $db->query($vKursSQL);
	 $db->next_record();
	 $vKursTgl = $oPhpdate->YMD2DMY($db->f('ftglupdate'));
?>
<!DOCTYPE html>
<html lang="id">
<head>
	<title>Aminah Internal Office</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="../images/favicon.ico"/>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap">
	<link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../css/design-system.css">
</head>
<body class="amh-theme">

	<div style="min-height:100vh;display:flex;flex-direction:column;justify-content:center;padding:3rem 1rem;">
		<div style="width:100%;max-width:420px;margin:0 auto;">

			<div style="display:flex;flex-direction:column;align-items:center;gap:0.75rem;margin-bottom:1.5rem;">
				<div style="width:96px;height:96px;background:#fff;border-radius:999px;padding:0.75rem;box-shadow:0 0 20px rgba(212,175,55,0.3);">
					<img src="../images/logoaminah.png" alt="Aminah Logo" style="width:100%;height:100%;object-fit:contain;">
				</div>
				<h1 style="font-size:1.45rem;font-weight:800;color:#fbbf24;margin:0;">Aminah Internal Office</h1>
			</div>

			<div class="amh-glass-panel" style="padding:1.1rem;margin-bottom:1rem;font-size:0.9rem;">
				<div style="display:flex;justify-content:space-between;border-bottom:1px solid rgba(255,255,255,0.1);padding-bottom:0.6rem;margin-bottom:0.6rem;">
					<span style="color:#94a3b8;">Kurs Dollar (USD):</span>
					<span style="color:#fbbf24;font-weight:700;">Rp <?=number_format($oRules->getSettingByField('finfokursusd'),0,",",".")?></span>
				</div>
				<div style="color:#94a3b8;font-size:0.8rem;margin-bottom:0.5rem;">Tanggal Kurs: <?=$vKursTgl?></div>
				<div style="font-weight:600;color:#e2e8f0;margin-bottom:0.4rem;">Jadwal Keberangkatan Terdekat:</div>
				<div style="overflow-x:auto;">
					<table style="width:100%;font-size:0.8rem;border-collapse:collapse;">
						<thead>
							<tr style="color:#fbbf24;border-bottom:1px solid rgba(255,255,255,0.1);">
								<th style="text-align:left;padding:0.35rem 0;">Tgl Berangkat</th>
								<th style="text-align:left;padding:0.35rem 0;">Paket</th>
								<th style="text-align:left;padding:0.35rem 0;">Kategori</th>
								<th style="text-align:left;padding:0.35rem 0;">Kota</th>
							</tr>
						</thead>
						<tbody>
						<? foreach ($vTours as $vTour) { ?>
							<tr style="border-bottom:1px solid rgba(255,255,255,0.05);">
								<td style="padding:0.35rem 0;"><?=$vTour['tgl']?></td>
								<td style="padding:0.35rem 0;"><?=$vTour['hari']?> hari</td>
								<td style="padding:0.35rem 0;"><?=$vTour['kategori']?></td>
								<td style="padding:0.35rem 0;"><?=$vTour['kota']?></td>
							</tr>
						<? } ?>
						</tbody>
					</table>
				</div>
			</div>

			<div class="amh-glass-panel" style="padding:1.5rem;">
				<div style="text-align:center;font-weight:700;font-size:1.15rem;margin-bottom:1rem;">
					Login
					<? if ($vMarkDev !='') echo "<b>$vMarkDev</b>";?>
				</div>

				<form method="post" action="../main/login.php" name="frmLogin" id="frmLogin">
					<div style="display:flex;justify-content:center;gap:1.5rem;margin-bottom:1.25rem;">
						<label class="amh-radio-pill">
							<input type="radio" name="rbLoginType" id="rbLoginN" value="N" checked onClick="setupLogin('N')"> Pebisnis
						</label>
						<label class="amh-radio-pill">
							<input type="radio" name="rbLoginType" id="rbLoginJ" value="J" onClick="setupLogin('J')"> Jamaah
						</label>
					</div>

					<div class="amh-input-group" id="inUser">
						<span class="amh-input-icon"><i class="fa fa-user"></i></span>
						<input type="text" id="login" name="tfUser" class="amh-input" placeholder="Username" onBlur="this.value=this.value.toUpperCase()">
					</div>

					<div class="amh-input-group" id="inPass">
						<span class="amh-input-icon"><i class="fa fa-lock"></i></span>
						<input type="password" id="password" name="tfPass" class="amh-input" placeholder="Password">
					</div>

					<button type="submit" class="amh-btn-gold" id="btLogin" name="btLogin" value="Login" style="width:100%;margin-top:0.5rem;" onClick="frmLogin.submit()">
						<i class="fa fa-sign-in"></i> Masuk Sekarang
					</button>
				</form>
			</div>

		</div>
	</div>

	<script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
	<script>
		var vInPass = '<div class="amh-input-group" id="inPass"><span class="amh-input-icon"><i class="fa fa-lock"></i></span><input type="password" id="password" name="tfPass" class="amh-input" placeholder="Password"></div>';

		function setupLogin(pParam) {
			if (pParam == 'N') {
				$('#inPass').remove();
				$('#inUser').after(vInPass);
				$('#login').attr('placeholder', 'Username');
			} else {
				$('#inPass').remove();
				$('#login').attr('placeholder', 'Contoh: JU-2020120011');
				$('#login').val('');
			}
		}
	</script>
	<script src="../js/main.js"></script>
	<? include_once("../framework/chat_widget.blade.php")?>
</body>
</html>
