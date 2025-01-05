<?
  include_once "../config.php";
  include_once CLASS_DIR."networkclass.php";
 // echo "Resetting tables...!";
  $vOP=$_GET['uOP'];
  if ($vOP=="reset") {
	  echo "Resetting Stock..!";

	  $vsql="truncate table tb_stok_position;";
	  $db->query($vsql);	  
	  $vsql="truncate table tb_trxstok;";
	  $db->query($vsql);	  
	  $vsql="truncate table tb_trxkit;";
	  $db->query($vsql);	
	  
	  $vsql="update tb_skit set fstatus='1', fpendistribusi='', ftgldist=null, ftglused=null,frefpurc='',frefsell=''  ;";
	  $db->query($vsql);	
  


	  echo "<BR>Member stock resetted!!";
	  
		  
  }
  
?>