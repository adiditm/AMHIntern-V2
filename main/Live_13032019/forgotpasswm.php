<?php
       session_start();
        include_once("../server/config.php");
        require_once '../simage/securimage.php';
		require_once '../classes/memberclass.php';
		require_once '../classes/systemclass.php';
		require_once '../classes/ruleconfigclass.php';
		
		 $vUser = $_POST['tfUser'];
		 $vEmail = $_POST['tfEmail'];
		$vPost = $_POST['hPost'];
		
		if ($vPost == '1') {
		   if($oMember->authEmail($vUser,$vEmail)=='0') {
			  $oSystem->jsAlert('Email tidak sesuai dengan ID Anda!');
			  $oSystem->jsLocation('../main/forgotpasswm.php');
		   } else {
			   $vFrom=$oRules->getMailFrom();
			   $vBody="$vUser, Anda telah meminta link reset password. Berikut adalah link untuk reset password Anda: <br><br>";
			   $vSessReset=$oSystem->doED('encrypt',$vUser.date('Y-m-d H:i:s'));
			   $vBody .= "<a href='https://".$_SERVER['HTTP_HOST']."/xsystem/main/forgotpasswd.php?u=$vUser&s=$vSessReset'>https://".$_SERVER['HTTP_HOST']."/xsystem/main/forgotpasswd.php?u=$vUser&s=$vSessReset</a>";
			   $vBody .= "<br>Klik link tersebut atau copy & paste ke alamat di browser Anda.<br><br>Terima Kasih. Spectra2u.com";
			   $oSystem->smtpmailer($vEmail,'no-reply@spectra2u.com','Spectra2U',"Link Reset Password $vUser",$vBody,'','',true);
			   $vSQL="update m_anggota set fsession='$vSessReset' where fidmember='$vUser'";
			   $db->query($vSQL);
			   $oSystem->jsAlert('Link reset password sudah dikirim ke email Anda, silakan cek dan ikuti langkah reset password!');
			   $oSystem->jsLocation('../main/forgotpasswm.php');
		   }
		}
	
 ?>

<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Forgot Password</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Open+Sans'>

      <link rel="stylesheet" href="../css/style-login.css">

<style type="text/css">

</style>  
</head>

<body>
  <div class="cont">
  <div class="demo" style="height:95%">
    <div class="login" >
      <div class="login__logo"><img src="../images/login-logonew.png" width="120" height="62"></div>
  <form class="form-signin" id="asdfg" action="forgotpasswm.php" method="post" >    
<span  onClick="document.location.href='/xsystem/main/loginform.php'" ><li class="fa fa-home" style="cursor:pointer;font-size:24px;color:white"> </li><span style="font-size:12px;color:white"> Login</span></span>
      <div class="login__form">
       <span style="font-size:4em;color:white">Forgot Password</span><br>
       <span style="font-size:1.7em;color:yellow">(Masukkan Username dan Email yang terdaftar di spectra2u.com)</span>
        <div class="login__row">
          <svg class="svg-icon" viewBox="5 0 15 15">
							<path d="M12.075,10.812c1.358-0.853,2.242-2.507,2.242-4.037c0-2.181-1.795-4.618-4.198-4.618S5.921,4.594,5.921,6.775c0,1.53,0.884,3.185,2.242,4.037c-3.222,0.865-5.6,3.807-5.6,7.298c0,0.23,0.189,0.42,0.42,0.42h14.273c0.23,0,0.42-0.189,0.42-0.42C17.676,14.619,15.297,11.677,12.075,10.812 M6.761,6.775c0-2.162,1.773-3.778,3.358-3.778s3.359,1.616,3.359,3.778c0,2.162-1.774,3.778-3.359,3.778S6.761,8.937,6.761,6.775 M3.415,17.69c0.218-3.51,3.142-6.297,6.704-6.297c3.562,0,6.486,2.787,6.705,6.297H3.415z"></path>
						</svg>
          <input name="tfUser" id="tfUser" type="text" class="login__input name" placeholder="Username"/>
        </div>

        <div class="login__row">

          
          <svg class="svg-icon" viewBox="5 0 15 15">
							<path d="M17.388,4.751H2.613c-0.213,0-0.389,0.175-0.389,0.389v9.72c0,0.216,0.175,0.389,0.389,0.389h14.775c0.214,0,0.389-0.173,0.389-0.389v-9.72C17.776,4.926,17.602,4.751,17.388,4.751 M16.448,5.53L10,11.984L3.552,5.53H16.448zM3.002,6.081l3.921,3.925l-3.921,3.925V6.081z M3.56,14.471l3.914-3.916l2.253,2.253c0.153,0.153,0.395,0.153,0.548,0l2.253-2.253l3.913,3.916H3.56z M16.999,13.931l-3.921-3.925l3.921-3.925V13.931z"></path>
						</svg>
          <input name="tfEmail" id="tfEmail" type="text" class="login__input name" placeholder="Email"/>
        </div>

  
  
  		<input type="hidden" name="hPost" value="1">

        <button type="submit" class="login__submit">Kirim link reset ke email</button>
        <p style="display:none" class="login__signup">Belum bergabung? &nbsp;<a href="../main/register.php">Sign up</a></p>
      </div>
      <br><br><br>
    </div>
    </form>
    <div class="app">
      <div class="app__top">
        <div class="app__menu-btn">
          <span></span>
        </div>
        <svg class="app__icon search svg-icon" viewBox="0 0 20 20">
          <!-- yeap, its purely hardcoded numbers straight from the head :D (same for svg above) -->
          <path d="M20,20 15.36,15.36 a9,9 0 0,1 -12.72,-12.72 a 9,9 0 0,1 12.72,12.72" />
        </svg>
        <p class="app__hello">Good Morning!</p>
        <div class="app__user">
          <img src="//s3-us-west-2.amazonaws.com/s.cdpn.io/142996/profile/profile-512_5.jpg" alt="" class="app__user-photo" />
          <span class="app__user-notif">3</span>
        </div>
        <div class="app__month">
          <span class="app__month-btn left"></span>
          <p class="app__month-name">March</p>
          <span class="app__month-btn right"></span>
        </div>
      </div>
      <div class="app__bot">
        <div class="app__days">
          <div class="app__day weekday">Sun</div>
          <div class="app__day weekday">Mon</div>
          <div class="app__day weekday">Tue</div>
          <div class="app__day weekday">Wed</div>
          <div class="app__day weekday">Thu</div>
          <div class="app__day weekday">Fri</div>
          <div class="app__day weekday">Sad</div>
          <div class="app__day date">8</div>
          <div class="app__day date">9</div>
          <div class="app__day date">10</div>
          <div class="app__day date">11</div>
          <div class="app__day date">12</div>
          <div class="app__day date">13</div>
          <div class="app__day date">14</div>
        </div>
        <div class="app__meetings">
          <div class="app__meeting">
            <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/142996/profile/profile-80_5.jpg" alt="" class="app__meeting-photo" />
            <p class="app__meeting-name">Feed the cat</p>
            <p class="app__meeting-info">
              <span class="app__meeting-time">8 - 10am</span>
              <span class="app__meeting-place">Real-life</span>
            </p>
          </div>
          <div class="app__meeting">
            <img src="//s3-us-west-2.amazonaws.com/s.cdpn.io/142996/profile/profile-512_5.jpg" alt="" class="app__meeting-photo" />
            <p class="app__meeting-name">Feed the cat!</p>
            <p class="app__meeting-info">
              <span class="app__meeting-time">1 - 3pm</span>
              <span class="app__meeting-place">Real-life</span>
            </p>
          </div>
          <div class="app__meeting">
            <img src="//s3-us-west-2.amazonaws.com/s.cdpn.io/142996/profile/profile-512_5.jpg" alt="" class="app__meeting-photo" />
            <p class="app__meeting-name">H</p>
            <p class="app__meeting-info">
              <span class="app__meeting-time">This button  ></span>
            </p>
          </div>
        </div>
      </div>
      <div class="app__logout">
        <svg class="app__logout-icon svg-icon" viewBox="0 0 20 20">
          <path d="M6,3 a8,8 0 1,0 8,0 M10,0 10,12"/>
        </svg>
      </div>
    </div>
  </div>
</div>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script src="../js/index.js"></script>

</body>
</html>
