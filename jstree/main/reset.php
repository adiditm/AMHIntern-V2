<?
  include_once "../server/config.php";
  include_once CLASS_DIR."networkclass.php";
 // echo "Resetting tables...!";
  $vOP=$_GET['uOP'];
  if ($vOP=="reset") {
	  echo "Resetting tables...!";
	  $vsql="truncate table tb_mutasi;"; 
	  $db->query($vsql);



	  
	  $vsql="delete from m_anggota where fidsys> 1;"; 
	  $db->query($vsql);
	  $vsql="delete from  tb_updown where fidsys > 1;"; 
	  $db->query($vsql);
	  $vsql="truncate table tb_withdraw;";
	  $db->query($vsql);
	  $vsql="truncate table tb_trxstok_member;";
	  $db->query($vsql);
	  $vsql="truncate table tb_trxstok_member_temp;";
	  $db->query($vsql);
	  $vsql="truncate table tb_kom_spon;";
	  $db->query($vsql);	  
	  $vsql="truncate table tb_kom_mtx;";
	  $db->query($vsql);	  

	  $vsql="truncate table tb_kom_couple;";
	  $db->query($vsql);	  
	  $vsql="truncate table tb_kom_coupcf;";
	  $db->query($vsql);	  

	  $vsql="truncate table tb_kom_pr;";
	  $db->query($vsql);	  
	  $vsql="truncate table tb_kom_prcf;";
	  $db->query($vsql);	  


	  $vsql="truncate table tb_cftrans;";
	  $db->query($vsql);	  
	  $vsql="truncate table tb_cftransmo;";
	  $db->query($vsql);	  
	  $vsql="truncate table tb_cftransmost;";
	  $db->query($vsql);	  
	  $vsql="truncate table tb_cftransreal;";
	  $db->query($vsql);	  
	  
	  $vsql="truncate table tb_cftrans_sday;";
	  $db->query($vsql);	  
	  $vsql="truncate table tb_cftrans_smo;";
	  $db->query($vsql);	  
	  $vsql="truncate table tb_cftrans_smost;";
	  $db->query($vsql);	  
	  $vsql="truncate table tb_cftrans_srwd;";
	  $db->query($vsql);	  
	  $vsql="truncate table tb_cftrans_real;";
	  $db->query($vsql);	  



	  $vsql="truncate table tb_mutasi_stok;";
	  $db->query($vsql);	  
	  $vsql="truncate table tb_trxstok;";
	  $db->query($vsql);	  
	  $vsql="truncate table tb_trxstok_temp;";
	  $db->query($vsql);	  


	  $vsql="truncate table tb_trxkit;";
	  $db->query($vsql);	  
	  $vsql="truncate table tb_stok_position;";
	  $db->query($vsql);	  

	  $vsql="truncate table tb_kit_active;";
	  $db->query($vsql);	  

	  $vsql="truncate table tb_mutasi_wprod;";
	  $db->query($vsql);	  

	  $vsql="truncate table tb_mutasi_wkit;";
	  $db->query($vsql);	  

	  $vsql="truncate table tb_mutasi_wacc;";
	  $db->query($vsql);	  
	  $vsql="truncate table tb_rewards;";
	  $db->query($vsql);	  

	  //$vsql="truncate table tb_skit;";
	  $vsql="update  tb_skit set fstatus='3';";
	  $db->query($vsql);	  

	 // update tb_skit set fstatus='1',fpendistribusi='', ftgldist=null, ftglused=null;
	  //$db->query($vsql);	  

	  //$vsql="update tb_skit_upg set fstatus='1', ftgldist=null, ftglused=null, fpendistribusi='', frefpurc='', frefsell='' ";
	  //$db->query($vsql);	  

	  
	  $vsql="update m_anggota set fsaldovcr=0,fsaldowprod=0,fsaldowkit=0,fsaldowacc=0,fsaldoro=0 where fidmember='ONOTOP';";
	  $db->query($vsql);	  
	  


	  echo "<BR>Member data resetted!!";
  }
  
?>