<?
session_start();
ini_set('display_errors', true);
error_reporting(E_ERROR);
include_once("../server/config.php");
include_once("../classes/memberclass.php");
include_once("../classes/networkclass.php");

   $vCode=$_GET['code'];
   $vOP=$_GET['op'];
   if ($vOP=='del') {
       $vSQL="delete from m_anggota where fidmember='$vCode' and faktif='0'";
       $db->query($vSQL);
        $vSQL="delete from tb_trxstok_member_temp where fidmember='$vCode'";
       $db->query($vSQL);


       if ($db->affected_rows() > 0) {
           echo 'deleted';
       } else {
           echo 'nodel';
       }
   }
   
   
   if ($vOP=='getqoh') {
      $vMS=$_GET['ms'];
	  $vIdProd=$_GET['idprod'];
	  $vSQL="select * from tb_stok_position where fidproduk='$vIdProd' and fidmember='$vMS' ";
	  $db->query($vSQL);
	  $db->next_record();
	  $vRes=$db->f('fbalance');
	  if (trim($vRes) == '' ) $vRes=0;
	  $vRes=number_format($vRes,0,",",".");
	  echo $vRes;
   }

   if ($vOP=='getqohro') {
      $vMS=$_GET['ms'];
	  $vIdProd=$_GET['idprod'];
	  $vSQL="select * from tb_stok_positionro where fidproduk='$vIdProd' and fidmember='$vMS' ";
	  $db->query($vSQL);
	  $db->next_record();
	  $vRes=$db->f('fbalance');
	  if (trim($vRes) == '' ) $vRes=0;
	  $vRes=number_format($vRes,0,",",".");
	  echo $vRes;
   }
   
   if ($vOP=='getconst') {
      
	  $vIdProd=$_GET['idprod'];
	  $vSQL="select * from m_product where fidproduk='$vIdProd' and faktif='1' ";
	  $db->query($vSQL);
	  $db->next_record();
	  $vRes=array();
	  $vRes['const1']=$db->f('fconst1');
	  $vRes['weight']=$db->f('fberat');
	  $vRes['price']=$db->f('fhargajual1');
	  
	  $vResJSon=json_encode($vRes);
	  echo $vResJSon;
   }


?>
