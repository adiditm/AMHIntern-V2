<?php
   //include_once("../server/config.php");

   include_once CLASS_DIR."prefixclass.php";	   
   include_once CLASS_DIR."ruleconfigclass.php";	   

   
   class shop {
 
 		function checkNewOrders() {
            global $oDB; 
			$vres="";
		    $vsql="SELECT count(*) as fjumlah from ss_orders where processed=1";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fjumlah");
			}
			if ($vres > 0)
	  		   return $vres;
			else
			   return 0;   
		}
//ambil ID dari order
 		function getIdFromOrder($pIdOrder) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fidmember from ss_orders where orderID=$pIdOrder";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fidmember");
			}
			if (isset($vres))
	  		   return $vres;
			else
			   return -1;   
		}

//ambil Sponsor dari order
 		function getSponsorFromOrder($pIdOrder) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fidsponsor from ss_orders where orderID=$pIdOrder";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fidsponsor");
			}
			if (isset($vres))
	  		   return $vres;
			else
			   return -1;   
		}

} //Class



$oShop = new shop;

?>