<?
  include_once "../config.php";
  include_once CLASS_DIR."networkclass.php";
 // echo "Resetting tables...!";
  $vOP=$_GET['uOP'];
  if ($vOP=="reset") {
	  echo "Resetting bonus titik tables...!";

	  $vsql="delete from m_anggota where fidsys>=8;"; 
	  $db->query($vsql);
	  $vsql="delete from  tb_updown where fidsys >=8;"; 
	  $db->query($vsql);

	  $vsql="truncate table tb_mutasi;"; 
	  $db->query($vsql);
	  $vsql="truncate table tb_mutasi_ro;"; 
	  $db->query($vsql);
	  
	  $vsql="delete from m_anggota where fidsys>=8;"; 
	  $db->query($vsql);
	  $vsql="delete from  tb_updown where fidsys >=8;"; 
	  
	  $vsql="truncate table tb_kom_mtx;";
	  $db->query($vsql);	  




	  $vsql="update m_anggota set fsaldovcr=0;"; 
	  $db->query($vsql);

	  echo "<BR>Bonus titik resetted!!";
  }
  
?>