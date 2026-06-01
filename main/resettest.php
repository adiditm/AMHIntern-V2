<?
  include_once "../config.php";
  include_once CLASS_DIR."networkclass.php";
 // echo "Resetting tables...!";
  $vOP=$_GET['uOP'];
  if ($vOP=="reset") {
	  echo "Resetting tables...!";
	  $vsql="truncate table tb_mutasi;"; 
	  $db->query($vsql);
	  $vsql="truncate table tb_mutasi_ro;"; 
	  $db->query($vsql);
	  
	  $vsql="update m_anggota set faktif='0', ftglaktif=null, fsaldoro=0, fsaldovcr=0 where fidsys>=8;"; 
	  $db->query($vsql);

	  $vsql="update m_anggota set  fsaldoro=0, fsaldovcr=0;"; 
	  $db->query($vsql);
	  
	  $vsql="delete from  tb_updown where fidsys >=8;"; 
	  $db->query($vsql);
	  $vsql="truncate table tb_withdraw;";
	  $db->query($vsql);
	  $vsql="truncate table tb_penjualan;";
	  $db->query($vsql);
	  $vsql="truncate table tb_penjualan_temp;";
	  $db->query($vsql);
	  $vsql="truncate table tb_kom_spon;";
	  $db->query($vsql);	  
	  $vsql="truncate table tb_kom_mtx;";
	  $db->query($vsql);	  

	  $vsql="truncate table tb_kom_couple;";
	  $db->query($vsql);	  
	  $vsql="truncate table tb_kom_coupcf;";
	  $db->query($vsql);	  
	  $vsql="truncate table tb_mutasi_stok;";
	  $db->query($vsql);	  
	  $vsql="truncate table tb_trxstok;";
	  $db->query($vsql);	  
	  $vsql="truncate table tb_trxkit;";
	  $db->query($vsql);	  
	  $vsql="truncate table tb_stok_position;";
	  $db->query($vsql);	  
	  $vsql="truncate table tb_mutasi_kit;";
	  $db->query($vsql);	  

	  $vsql="update m_anggota set fsaldovcr=0;"; 
	  $db->query($vsql);

	  echo "<BR>Member data resetted!!";
  }
  
?>