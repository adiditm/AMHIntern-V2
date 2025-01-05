<?
    include_once("../server/config.php");
	 include_once("../classes/ruleconfigclass.php");
	 include_once("../classes/mobdetectclass.php");
	 include_once("../classes/dateclass.php");
	 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Aminah Internal Office</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="../images/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="../vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../css/util.css">
	<link rel="stylesheet" type="text/css" href="../css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
        
			<div class="wrap-login100">
             <? if ($oMobi->isMobile() || $oMobi->isTablet()) {?>
            <div align="center" style="margin-right:auto;margin-left:auto;margin-top:-20%">
            <img src="../images/logoaminah.png" alt="IMG" align="middle" >
           <br><br><b> Informasi</b><br>
                    Kurs Dollar (USD): <b><?=number_format($oRules->getSettingByField('finfokursusd'),0,",",".")?></b><br>
      <table width="200"  style="border:1px solid #ccc; padding:2px 2px 2px 2px" >
	   
	   <tr>
    <td style="border:1px solid #ccc; padding:2px 2px 2px 2px" nowrap><strong>Tgl Berangkat</strong></td>
    <td style="border:1px solid #ccc; padding:2px 2px 2px 2px"><strong>Paket</strong></td>
  </tr>              
					<?
					    $vSQL ="select * from m_tour where date(now()) <= ftgldepart  and now() <= fexpired  order by fgroup desc, ftgldepart asc";
						$db->query($vSQL);
						while($db->next_record()) {
							$vGroup = $db->f('fgroup');
							if ($vGroup=='u')
							   $vGroupText='Umroh';
							else if ($vGroup=='t')
							   $vGroupText='Tour Internasional';
							else if ($vGroup=='d')
							   $vGroupText='Tour Domestik';
							else if ($vGroup=='h')
							   $vGroupText='Haji';					?>
					
					
 
  <tr>
    <td style="border:1px solid #ccc; padding:2px 2px 2px 2px" nowrap align="center"><?=$oPhpdate->YMD2DMY($db->f('ftgldepart'))?></td>
    <td style="border:1px solid #ccc; padding:2px 2px 2px 2px" align="right" nowrap><?=$db->f('fjmlhari')?> hari</td>
      <td style="border:1px solid #ccc; padding:2px 2px 2px 2px" align="left" nowrap><?=$vGroupText?></td>
  </tr>
  	<? } ?>
</table>
<br>

</div>
<? } ?>

				<div class="login100-pic js-tilt"  align="center">
					<img src="../images/logoaminah.png" alt="IMG" align="middle" >
                    <br><br><b>Informasi</b><br><br>
                    Kurs Dollar (USD): <b><?=number_format($oRules->getSettingByField('finfokursusd'),0,",",".")?></b><br>
      <table width="200"  style="border:1px solid #ccc; padding:2px 2px 2px 2px" >
	   
	   <tr>
    <td style="border:1px solid #ccc; padding:2px 2px 2px 2px" nowrap><strong>Tgl Berangkat</strong></td>
    <td style="border:1px solid #ccc; padding:2px 2px 2px 2px"><strong>Paket</strong></td>
    <td style="border:1px solid #ccc; padding:2px 2px 2px 2px"><strong>Kategori</strong></td>
       </tr>              
					<?
					    $vSQL ="select * from m_tour where date(now()) <= ftgldepart  and now() <= fexpired  order by fgroup desc, ftgldepart asc";
						$db->query($vSQL);
						while($db->next_record()) {
							$vGroup = $db->f('fgroup');
							if ($vGroup=='u')
							   $vGroupText='Umroh';
							else if ($vGroup=='t')
							   $vGroupText='Tour Internasional';
							else if ($vGroup=='d')
							   $vGroupText='Tour Domestik';
							else if ($vGroup=='h')
							   $vGroupText='Haji';
   
					?>
					
					
 
  <tr>
    <td style="border:1px solid #ccc; padding:2px 2px 2px 2px" nowrap align="center"><?=$oPhpdate->YMD2DMY($db->f('ftgldepart'))?></td>
    <td style="border:1px solid #ccc; padding:2px 2px 2px 2px" align="right" nowrap><?=$db->f('fjmlhari')?> hari</td>
    <td style="border:1px solid #ccc; padding:2px 2px 2px 2px" align="left" nowrap><?=$vGroupText?></td>
  </tr>
  	<? } ?>
</table>

				
				</div>

				<form class="login100-form validate-form" method="post" action="../main/login.php">
					<span class="login100-form-title">
					    Login
                        <? if ($vMarkDev !='') echo "<b>$vMarkDev</b>";?>
					</span>

		   <div class="wrap-input100 validate-input" data-validate = "Valid user is required">
						   <input type="text" id="login" class="input100" name="tfUser" placeholder="Username" onBlur="this.value=this.value.toUpperCase()">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
					
                          <input type="password" id="password" class="input100" name="tfPass" placeholder="Password">

						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
                           
						</button>
					</div>

					

					<div class="text-center p-t-136">
						<a class="txt2" href="#"><i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
        
        
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="../vendor/bootstrap/js/popper.js"></script>
	<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="../vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="../vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="../js/main.js"></script>

</body>
</html>
