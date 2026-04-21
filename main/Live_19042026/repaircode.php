<?
  include_once "../config.php";
  include_once CLASS_DIR."networkclass.php";
 // echo "Resetting tables...!";
	  $db->query($vSQL);
	  
	  $vSQL="select * from m_anggota where fidmember not like 'UNEED%' "; 
	  $db->query($vSQL);
	  $vCount=0;
	  while ($db->next_record()) {
	     $vCount++;
	     $vMember= $db->f('fidmember');
	     $vMemberCut=substr($vMember,0,10);


	     echo $vSQLin="update tb_kom_couple set fidreceiver = '$vMember' where fidreceiver='$vMemberCut'";
	     echo "<br>";
	     $dbin->query($vSQLin);

	     echo $vSQLin="update tb_kom_couple set fidregistrar = '$vMember' where fidregistrar ='$vMemberCut'";
	     echo "<br>";
	     $dbin->query($vSQLin);


	     echo $vSQLin="update tb_kom_coupcf set fidreceiver = '$vMember' where fidreceiver ='$vMemberCut'";
	     echo "<br>";
	     $dbin->query($vSQLin);

	 // echo "<br>";
	  }
  
?>