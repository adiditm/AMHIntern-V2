<?
  session_start();
  $vOP=$_GET['op'];
  include_once "../config.php";
  include_once "../classes/memberclass.php";
  include_once "../classes/systemclass.php";
  include_once "../classes/ruleconfigclass.php";
  

  
  
  $vUser=$_SESSION['LoginUser'];
  //$vSetting=$oRules->getSettingByField("fminprog",1);
  $vSetting=15;
  $vSetting=$vSetting/60;
  $vSetting = gmdate('H:i:s', floor($vSetting * 3600));
  
  $vSQL="select case when TIMEDIFF(NOW(),fstartlog) >= '$vSetting' then 1 else 9999 end as fselisih from m_anggota where fidmember='$vUser' ";
  $db->query($vSQL);
  $vRet=0;
  if ($db->num_rows() > 0) {
	  while($db->next_record()) {
		$vRet = $db->f('fselisih');  
	  }
  }
  echo $vRet;
  
?>