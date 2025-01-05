<?
  include_once "../config.php";
  include_once CLASS_DIR."networkclass.php";
 // echo "Resetting tables...!";
  $vOP=$_GET['uOP'];
  if ($vOP=="reset") {
	  echo "Resetting Unilevel data...!";

	  $vSQL="select a.*, b.fbalance from (select max(fidsys) as  idsys , fidmember from tb_mutasi group by fidmember) as a left join tb_mutasi b on a.idsys=b.fidsys"; 
	  $db->query($vSQL);
	  while ($db->next_record()) {
	     $vMember= $db->f('fidmember');
	     $vBalance= $db->f('fbalance');
	     $vSQLin="update m_anggota set fsaldovcr = $vBalance where fidmember='$vMember'";
	     $dbin->query($vSQLin);
	 // echo "<br>";
	  }
     

	  $vsql="delete from tb_trxstok_member where fjenis='AutoRO' ;"; 
	  $db->query($vsql);


	  $vsql="delete from tb_mutasi where fkind='uni' ;"; 
	  $db->query($vsql);

	  
	  



	  
  }
  
?>