<?php

   include_once  $CLASS_DIR."prefixclass.php";	   
   include_once  $CLASS_DIR."dateclass.php";	   
   include_once  $CLASS_DIR."ruleconfigclass.php";	   

   
   class product {
 
        //ambil nama member dari ID yang diketahui
		function getProductName($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fnamaproduk from m_product where fidproduk='$pID' ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fnamaproduk");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}


        //ambil  konstanta produk 
		function getConst($pID) {
            global $oDB; 
			$vres="";
		    echo $vsql="SELECT fconst$pID as fresconst from m_product where fidproduk='$pID' ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fresconst");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}

  

        //ambil ID member dari Nama yang diketahui
		function getProductID($pName) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fidproduk from m_product where fnamaproduk='$pName' ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fidproduk");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}


        //ambil jumlah product yang aktif
		function getActiveProductCount() {
            global $oDB; 
			$vres="";
		    $vsql="SELECT count(fidproduk) as faktifcount from m_product where faktif <> '0' ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("faktifcount");
			}
			if ($vres > 0)
	  		   return $vres;
			else
			   return -1;   
		}


        //ambil jumlah member yang tidak aktif
		function getnoActiveProductCount() {
            global $oDB; 
			$vres="";
		    $vsql="SELECT count(fidproduk) as faktifcount from m_product where faktif='0' ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("faktifcount");
			}
			if ($vres > 0)
	  		   return $vres;
			else
			   return -1;   
		}








        //check apakah Aktif
		function isActive($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT faktif from m_product where fidproduk='$pID' ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("faktif");
			}
			if ($vres == "1")
	  		   return 1;
			else
			   return 0;   
		}









        //Set Active / Deacvtive
		function changeActive($pID,$pActive) {
            global $oDB; 
			$vres="";
		       $vsql="update m_product set faktif = '$pActive' where fidproduk='$pID' ";	
			$vres=$oDB->query($vsql);
			if ($oDB->affected_rows() > 0)
	  		   return 1;
			else
			   return "Error!, kemungkinan karena : ID Member tidak ada, dan atau kondisi sudah aktif / non aktif ";   
		}

		
		 //Get Merk
		function getMerk($pId) {
		     global $oDB; 
  			 $vsql="select fmerk from m_product where (fidproduk='$pId') ";	
			 $oDB->query($vsql);		
			 while ($oDB->next_record()) {
			   $vres = $oDB->f("fmerk");
			 }
 		     if ($vres!="")
			    return $vres;
			 else 
			    return -1;   
		}


		 //Get Tanggal Expired
		function getExpired($pId) {
		     global $oDB; 
  			 $vsql="select fexpired from m_product where (fidproduk='$pId') ";	
			 $oDB->query($vsql);		
			 while ($oDB->next_record()) {
			   $vres = $oDB->f("fexpired");
			 }
 		     if ($vres!="")
			    return $vres;
			 else 
			    return -1;   
		}


		 //Get Model
		function getModel($pId) {
		     global $oDB, $oPhpdate; 
  			 $vsql="select fmodel from m_product where (fidproduk='$pId') ";	
			 $oDB->query($vsql);		
			 while ($oDB->next_record()) {
			   $vres = $oDB->f("fmodel");
			 }
 		     if ($vres!="")
			    return $oPhpdate->YMD2DMY($vres,"-");
			 else 
			    return -1;   
		}


		 //Get  Satuan
		function getSatuan($pId) {
		     global $oDB; 
  			 $vsql="select fsatuan from m_product where (fidproduk='$pId') ";	
			 $oDB->query($vsql);		
			 while ($oDB->next_record()) {
			   $vres = $oDB->f("fsatuan");
			 }
 		     if ($vres!="")
			    return $vres;
			 else 
			    return -1;   
		}


		 //Get  Harga Jual
		function getHargaJual($pId) {
		     global $oDB; 
  			 $vsql="select fhargajual1 from m_product where (fidproduk='$pId') ";	
			 $oDB->query($vsql);		
			 while ($oDB->next_record()) {
			   $vres = $oDB->f("fhargajual1");
			 }
 		     if ($vres!="")
			    return $vres;
			 else 
			    return 0;   
		}


		 //Get  Harga Jual
		function getHargaJualMulti($pId,$pIndex) {
		     global $oDB; 
  			 $vsql="select fhargajual$pIndex as fres from m_product where (fidproduk='$pId') ";	
			 $oDB->query($vsql);		
			 while ($oDB->next_record()) {
			   $vres = $oDB->f("fres");
			 }
 		     if ($vres!="")
			    return $vres;
			 else 
			    return 0;   
		}

		 //Get  Point Member
		function getPointMember($pId) {
		     global $oDB; 
  			 $vsql="select fpointmember from m_product where (fidproduk='$pId') ";	
			 $oDB->query($vsql);		
			 while ($oDB->next_record()) {
			   $vres = $oDB->f("fpointmember");
			 }
 		     if ($vres!="")
			    return $vres;
			 else 
			    return -1;   
		}

		 //Get  Kemasan
		function getKemasan($pId) {
		     global $oDB; 
  			 $vsql="select fkemasan from m_product where (fidproduk='$pId') ";	
			 $oDB->query($vsql);		
			 while ($oDB->next_record()) {
			   $vres = $oDB->f("fkemasan");
			 }
 		     if ($vres!="")
			    return $vres;
			 else 
			    return -1;   
		}


		 //Get  Berat
		function getBerat($pId) {
		     global $oDB; 
  			 $vsql="select fberat from m_product where (fidproduk='$pId') ";	
			 $oDB->query($vsql);		
			 while ($oDB->next_record()) {
			   $vres = $oDB->f("fberat");
			 }
 		     if ($vres!="")
			    return $vres;
			 else 
			    return -1;   
		}


		 //Get  Volume
		function getVolume($pId) {
		     global $oDB; 
  			 $vsql="select fvolume from m_product where (fidproduk='$pId') ";	
			 $oDB->query($vsql);		
			 while ($oDB->next_record()) {
			   $vres = $oDB->f("fvolume");
			 }
 		     if ($vres!="")
			    return $vres;
			 else 
			    return -1;   
		}



		 //Get  Keterangan
		function getKeterangan($pId) {
		     global $oDB; 
  			 $vsql="select fketerangan from m_product where (fidproduk='$pId') ";	
			 $oDB->query($vsql);		
			 while ($oDB->next_record()) {
			   $vres = $oDB->f("fketerangan");
			 }
 		     if ($vres!="")
			    return $vres;
			 else 
			    return -1;   
		}



        //check apakah ID Produk ada
		function checkID($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fidproduk from m_product where fidproduk='$pID' ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fidproduk");
			}
			if ($vres != "")
	  		   return 1;
			else
			   return 0;   
		}



			//REGISTER product semua field
	 function regProductComplete( $fidproduk , $fnamaproduk , $fmerk , $fexpired , $fmodel , $fbarcode , $fsatuan , $fhargajual , $fpoint, $fpabrik , $fkemasan , $fhpp , $fhargabeli , $fgambar , $fpointmember , $fpointstockist , $fpointadmin , $fketerangan , $fberat , $fvolume , $faktif , $fsession , $fuserid) {
			 global $oDB, $oRules, $oSystem;
			 
			 $except="";
			 if ($fidproduk=="") {
			    $except.="<font color='#FF0000'> ID Produk tidak boleh kosong!</font><br>";
				$vAlert="ID Produk tidak boleh kosong!";
			 } 	
			 if ($this->checkID($fidproduk)==1) {
			    $except.="<font color='#FF0000'>Error!, ID Produk $fidproduk sudah digunakan, gunakan ID lain!</font><br>";
				$vAlert="Error!, ID Produk $fidproduk sudah digunakan, gunakan ID lain!";
			 }	
			 if ($fnamaproduk=="") {
			    $except.="<font color='#FF0000'>Nama tidak boleh kosong!</FONT><br>"; 	
				$vAlert="Nama tidak boleh kosong!";
			 }	
			  	
	 		 $vsql="INSERT INTO m_product ( fidproduk , fnamaproduk , fmerk , fexpired , fmodel , fbarcode , fsatuan , fhargajual , fpointmember, fpabrik , fkemasan , fhpp , fhargabeli , fgambar , fpointmember , fpointstockist , fpointadmin , fketerangan , fberat , fvolume , faktif , fsession , fuserid , ftglentry )"; 
			 echo $vsql.="VALUES ('$fidproduk' , '$fnamaproduk' , '$fmerk' , '$fexpired' , '$fmodel' , '$fbarcode' , '$fsatuan' , $fhargajual , $fpoint, '$fpabrik' , '$fkemasan' , $fhpp , $fhargabeli , '$fgambar' , $fpointmember , $fpointstockist , $fpointadmin , '$fketerangan' , '$fberat' , '$fvolume' , '$faktif' , '$fsession' , '$fuserid' , now() )" ;
				
			 if ($except!="") {
			    echo $except;	
				$oSystem->jsAlert($vAlert);
				return -1;
			 } else {
				$oDB->query($vsql);		
				if ($oDB->affected_rows() > 0 ) 
				  return 1;
				else
				  return 0;   
			 }	  
	}		


			//REGISTER product field seperlunya
	 function regProduct($fidproduk , $fnamaproduk , $fmerk , $fexpired , $fmodel , $fsatuan , $fhargajual , $fpoint, $fkemasan ,   $fberat , $fvolume , $fketerangan , $faktif  , $fuserid) {
			 global $oDB, $oRules, $oSystem;
			 $except="";
			 if ($fidproduk=="") {
			    $except.="<font color='#FF0000'> ID Produk tidak boleh kosong!</font><br>";
				$vAlert="ID Produk tidak boleh kosong!";
				$oSystem->jsAlert($vAlert);
			 }	
			 if ($this->checkID($fidproduk)==1) {
			    $except.="<font color='#FF0000'>Error!, ID Produk $fidproduk sudah digunakan!</font><br>";
				$vAlert="Error!, ID Produk $fidproduk sudah digunakan, gunakan ID lain!";
				$oSystem->jsAlert($vAlert);
			 }	
			 if ($fnamaproduk=="") {
			    $except.="<font color='#FF0000'>Nama Produk tidak boleh kosong!</FONT><br>"; 	
				$vAlert="Nama Produk tidak boleh kosong!";
				$oSystem->jsAlert($vAlert);
			 }	
			  	
	 		 $vsql="INSERT INTO m_product ( fidproduk , fnamaproduk , fmerk , fexpired , fmodel , fsatuan , fhargajual , fpointmember, fkemasan ,  fberat  , fvolume, fketerangan  , fuserid , ftglentry )"; 
			 $vsql.="VALUES ('$fidproduk', '$fnamaproduk' , '$fmerk' , '$fexpired' , '$fmodel' , '$fsatuan' , $fhargajual , $fpoint, '$fkemasan' ,   '$fberat' , '$fvolume' , '$fketerangan' ,  '$fuserid' , now() )" ;
				
			 if ($except!="") {
			    echo $except;	
				
				return -1;
			 } else {
				$oDB->query($vsql);	
				$oSystem->jsAlert("Data produk sudah tersimpan!");	 	
				if ($oDB->affected_rows() > 0 ) {
				  return 1;
				   
				}  
				else
				  return 0;   
				
			 }	  
	}		




	
     //Update Produk
     function updateProduct($fidproduk , $fnamaproduk , $fmerk , $fexpired , $fmodel , $fsatuan , $fhargajual , $fpoint, $fkemasan ,   $fberat , $fvolume , $fketerangan  , $fuserid) {
     	global $oDB, $oSystem;
        $vsql="update m_product set fidproduk='$fidproduk',fnamaproduk='$fnamaproduk',fmerk='$fmerk',fexpired='$fexpired',fmodel='$fmodel',fsatuan='$fsatuan',fhargajual=$fhargajual,fpointmember=$fpoint,fkemasan='$fkemasan',fberat='$fberat',fvolume='$fvolume',fketerangan='$fketerangan',fuserid='fuserid' where fidproduk='$fidproduk'"; 
		$oDB->query($vsql);
		$oSystem->jsAlert("Produk updated!");
 	 }


   //Set Password
     function setPassConfirm($pID,$pNewPass,$pConfirm){
     	global $oDB, $oSystem;
		if ($pNewPass==$pConfirm) {
			$this->setPass($pNewPass,$pID);
		} else
		   $oSystem->jsAlert("Ponfirmasi salah!");
 	 }




	//Delete Product
	 function delProduct($pID) {
		 global $oDB, $oSystem;
	 	   $vsql="delete from m_product where fidproduk='$pID' ";	   
		   $oDB->query($vsql);		
 		   $oSystem->jsAlert("Product deleted!");
	 }
	

        //ambil produk ke combo
		function getProduct2Combo() {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fidproduk, fnamaproduk from m_product ";	
			$oDB->query($vsql);
			echo "<select name='cbProd'>";
			echo "<option value='-'>--Pilih--</option>";
			while ($oDB->next_record()) {
			  $vID=$oDB->f("fidproduk");
			  $vNama=$oDB->f("fnamaproduk");
              echo "<option value='$vID'>$vID</option>";                   
			}
			echo "</select>";
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}

        //ambil produk ke combo
		function getProductList() {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fidproduk, fnamaproduk from m_product ";	
			$oDB->query($vsql);
			echo "<ul>"; 
			while ($oDB->next_record()) {
			  $vID=$oDB->f("fidproduk");
			  $vNama=$oDB->f("fnamaproduk");
              echo "<li><strong>$vID</strong> : $vNama</li><br>";                   
			}
			echo "</ul>"; 
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}
        
		
		//ambil prosen RO dari ID yang diketahui
		function getProRO($pID) {
            global $dbin1; 
			$vres="";$vpros=0;
		    $vsql="SELECT fmodel from m_product where fidproduk='$pID' ";	
			$dbin1->query($vsql);
			while ($dbin1->next_record()) {
			    $vres = $dbin1->f("fmodel");
				if ($vres=="sembako")
				   $vpros=0.5;
				else if ($vres=="pulsa")
				   $vpros=0.3;
				else if ($vres=="herbal")
				   $vpros=10;
				else if ($vres=="pupuk")
				   $vpros=4;
			}
	  		   return $vpros;
		}


		//ambil prosen RO Group dari ID yang diketahui
		function getProROGroup($pID) {
            global $dbin1; 
			$vres="";$vpros=0;
		    $vsql="SELECT fmodel from m_product where fidproduk='$pID' ";	
			$dbin1->query($vsql);
			while ($dbin1->next_record()) {
			    $vres = $dbin1->f("fmodel");
				if ($vres=="sembako")
				   $vpros=0.1;
				else if ($vres=="pulsa")
				   $vpros=0.1;
				else if ($vres=="herbal")
				   $vpros=0.5;
				else if ($vres=="pupuk")
				   $vpros=0.5;
			}
	  		   return $vpros;
		}
		//ambil jenis RO dari ID yang diketahui
		function getJenisRO($pID) {
            global $dbin1; 
			$vres="";$vpros=0;
		    $vsql="SELECT fmodel from m_product where fidproduk='$pID' ";	
			$dbin1->query($vsql);
			while ($dbin1->next_record()) {
			    $vres = $dbin1->f("fmodel");
			}
	  		   return $vres;
		}

		//ambil Warna dari kode
		function getColor($pID) {
            global $dbin1; 
			$vres="";$vpros=0;
		    $vsql="SELECT fcolor from m_color where fidcolor='$pID' ";	
			$dbin1->query($vsql);
			while ($dbin1->next_record()) {
			    $vres = $dbin1->f("fcolor");
			}
	  		   return $vres;
		}

//Insert Mutasi
   function insertMutasiStock($pID,$pProduct,$pSize,$pColor,$pTanggal,$pDesc,$pCred,$pDeb,$pBal,$pKind,$pRef='') {
       global $oDB;
	   $vsql="insert tb_mutasi_stok(fidmember,fidproduk,fsize,fcolor,ftanggal,fdesc,fcredit,fdebit,fbalance,fkind,fref) ";
	   $vsql.="values('$pID','$pProduct','$pSize','$pColor','$pTanggal','$pDesc',$pCred,$pDeb,$pBal,'$pKind','$pRef');";
	   $oDB->query($vsql);
   }


//Insert Mutasi Item RO
   function insertMutasiStockRO($pID,$pProduct,$pSize,$pColor,$pTanggal,$pDesc,$pCred,$pDeb,$pBal,$pKind,$pRef='') {
       global $oDB;
	   $vsql="insert tb_mutasi_stokro(fidmember,fidproduk,fsize,fcolor,ftanggal,fdesc,fcredit,fdebit,fbalance,fkind,fref) ";
	   $vsql.="values('$pID','$pProduct','$pSize','$pColor','$pTanggal','$pDesc',$pCred,$pDeb,$pBal,'$pKind','$pRef');";
	   $oDB->query($vsql);
   }

	function getStockPos($pKodeBrg,$pSize,$pColor) {
	        global $oDB;

			$vres=0;
		   $vsql="SELECT  fbalance from m_product where  fidproduk='$pKodeBrg' and fsize='$pSize' and fidcolor='$pColor'";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fbalance");
			}
			if ($vres == '') $vres='Not Found';
			return $vres;
	}	


	function getStockPosWH($pWH,$pKodeBrg,$pSize,$pColor) {
	        global $oDB;

			$vres=0;
		   $vsql="SELECT  fbalance from tb_stok_position where  fidproduk='$pKodeBrg' and fidmember='$pWH'";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fbalance");
			}
			if ($vres == '') $vres='Not Found';
			return $vres;
	}	
	
		//ambil Nama paket dari kode
		function getPackName($pID) {
            global $oDB; 
			$vres="";$vpros=0;
		    $vsql="SELECT fpackname from m_paket where fpackid='$pID' ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fpackname");
			}
	  		   return $vres;
		}
	
} //Class

 $vPaketInvest = array(
    "2000000" => "Silver",
    "5000000" => "Gold",
	"10000000" => "Crown",
	"30000000" => "Platinum",
	"50000000" => "Diamond"
);

$oProduct = new product;

?>
