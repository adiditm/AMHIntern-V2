<?php



   include_once  $CLASS_DIR."ruleconfigclass.php";   

   include_once  "../classes/memberclass.php";   

   include_once  $CLASS_DIR."systemclass.php";  

   include_once  $CLASS_DIR."networkclass.php";   

   include_once  $CLASS_DIR."komisiclass.php";  

   include_once  $CLASS_DIR."productclass.php";   

   class penjualan {

      function addItem($fidpenjualan,$fidmember,$falamatkrm,$fnostockist,$fidproduk,$fjumlah,$fhargasat,$fsubtotal,$fpointsat,$fsubtotpoint,$fketerangan) {

	      global $oDB,$oSystem;

		  $vsql="insert into tb_penjualan_temp(fidpenjualan,fidmember,falamatkrm,fnostockist,fidproduk,fjumlah,ftanggal,fhargasat,fsubtotal,fpointsat,fsubtotpoint,fketerangan,ftglentry) ";

		  $vsql.="values('$fidpenjualan','$fidmember','$falamatkrm','$fnostockist','$fidproduk',$fjumlah,now(),$fhargasat,$fsubtotal,$fpointsat,$fsubtotpoint,'$fketerangan',now())";

		  

		  $vsql2="update tb_penjualan_temp set fjumlah=fjumlah+$fjumlah,fsubtotal=fhargasat * fjumlah,fsubtotpoint=fpointsat*fjumlah where fidpenjualan='$fidpenjualan' and fidproduk='$fidproduk' and fidmember='$fidmember'";

		  if ($this->checkItem($fidpenjualan,$fidmember,$fidproduk)==1)

		     $oDB->query($vsql2);

		  else	

		     $oDB->query($vsql); 

		  

		//  $oSystem->jsAlert("Item Added!");

		  

		  

	  }





      function addItemWallet($fidpenjualan,$fidmember,$falamatkrm,$fnostockist,$fidproduk,$fjumlah,$fhargasat,$fsubtotal,$fpointsat,$fsubtotpoint,$fketerangan) {

	      global $oDB,$oSystem;

		  $vsql="insert into tb_trxstok_temp(fidpenjualan,fidmember,falamatkrm,fnostockist,fidproduk,fjumlah,ftanggal,fhargasat,fsubtotal,fpointsat,fsubtotpoint,fketerangan,ftglentry) ";

		  $vsql.="values('$fidpenjualan','$fidmember','$falamatkrm','$fnostockist','$fidproduk',$fjumlah,now(),$fhargasat,$fsubtotal,$fpointsat,$fsubtotpoint,'$fketerangan',now())";

		  

		  $vsql2="update tb_trxstok_temp set fjumlah=fjumlah+$fjumlah,fsubtotal=fhargasat * fjumlah,fsubtotpoint=fpointsat*fjumlah where fidpenjualan='$fidpenjualan' and fidproduk='$fidproduk' and fidmember='$fidmember'";

		  

		  //Cek apakah sudah ada di detil

		  if ($this->checkItemWallet($fidpenjualan,$fidmember,$fidproduk)==1)

		     $oDB->query($vsql2);

		  else	

		     $oDB->query($vsql); 

		  

		//  $oSystem->jsAlert("Item Added!");

		  

		  

	  }





     function addItemSell($fidpenjualan,$fidseller,$fidmember,$falamatkrm,$fnostockist,$fidproduk,$fjumlah,$fhargasat,$fsubtotal,$fpointsat,$fsubtotpoint,$fketerangan) {

	      global $oDB,$oSystem;

		  $vsql="insert into tb_trxstok_member_temp(fidpenjualan,fidseller,fidmember,falamatkrm,fnostockist,fidproduk,fjumlah,ftanggal,fhargasat,fsubtotal,fpointsat,fsubtotpoint,fketerangan,ftglentry) ";

		  $vsql.="values('$fidpenjualan','$fidseller','$fidmember','$falamatkrm','$fnostockist','$fidproduk',$fjumlah,now(),$fhargasat,$fsubtotal,$fpointsat,$fsubtotpoint,'$fketerangan',now())";

		  

		  $vsql2="update tb_trxstok_member_temp set fjumlah=fjumlah+$fjumlah,fsubtotal=fhargasat * fjumlah,fsubtotpoint=fpointsat*fjumlah where fidpenjualan='$fidpenjualan' and fidproduk='$fidproduk' and fidmember='$fidmember'  and fidseller='$fidseller'";

		  

		  //Cek apakah sudah ada di detil

		  if ($this->checkItemSell($fidpenjualan,$fidmember,$fidproduk)==1)

		     $oDB->query($vsql2);

		  else	

		     $oDB->query($vsql); 

		  

		//  $oSystem->jsAlert("Item Added!");

		  

		  

	  }





	  

	  function checkItem($fidpenjualan,$fidmember,$fidproduk) {

	      global $oDB,$oSystem;

		  $vsql="select * from tb_penjualan_temp where fidpenjualan='$fidpenjualan' and fidproduk='$fidproduk' and fidmember='$fidmember'";  

	  	  $oDB->query($vsql);

		  if ($oDB->num_rows()>0)

		     return 1;

		  else

		  	 return 0; 	 

	  }





	  



	  function checkItemWallet($fidpenjualan,$fidmember,$fidproduk) {

	      global $oDB,$oSystem;

		  $vsql="select * from tb_trxstok_temp where fidpenjualan='$fidpenjualan' and fidproduk='$fidproduk' and fidmember='$fidmember'";  

	  	  $oDB->query($vsql);

		  if ($oDB->num_rows()>0)

		     return 1;

		  else

		  	 return 0; 	 

	  }



	  function checkItemSell($fidpenjualan,$fidmember,$fidproduk) {

	      global $oDB,$oSystem;

		  $vsql="select * from tb_trxstok_member_temp where fidpenjualan='$fidpenjualan' and fidproduk='$fidproduk' and fidmember='$fidmember'";  

	  	  $oDB->query($vsql);

		  if ($oDB->num_rows()>0)

		     return 1;

		  else

		  	 return 0; 	 

	  }

	  

	  function delItem($fidpenjualan,$fidmember,$fidproduk) {

	   	  global $oDB,$oSystem;

		  $vsql="delete from tb_penjualan_temp where fidpenjualan='$fidpenjualan' and  fidmember='$fidmember' and fidproduk='$fidproduk' ";

		  $oDB->query($vsql);

		 //$oSystem->jsAlert("Item Deleted!");



	  }





	  function delItemWallet($fidpenjualan,$fidmember,$fidproduk) {

	   	  global $oDB,$oSystem;

		  $vsql="delete from tb_trxstok_temp where fidpenjualan='$fidpenjualan' and  fidmember='$fidmember' and fidproduk='$fidproduk' ";

		  $oDB->query($vsql);

		 //$oSystem->jsAlert("Item Deleted!");



	  }





	  function delItemSell($fidpenjualan,$fidmember,$fidproduk) {

	   	  global $oDB,$oSystem;

		  $vsql="delete from tb_trxstok_member_temp where fidpenjualan='$fidpenjualan' and  fidmember='$fidmember' and fidproduk='$fidproduk' ";

		  $oDB->query($vsql);

		 //$oSystem->jsAlert("Item Deleted!");



	  }

	  

	  function clearTemp() {

	     global $oDB;

	     $vsql="truncate table tb_penjualan_temp";

		 $oDB->query($vsql);

	  } 



	  function clearTempWallet() {

	     global $oDB;

	     $vsql="truncate table tb_trxstok_temp";

		 $oDB->query($vsql);

	  }



	  function clearTempSell() {

	     global $oDB;

	     $vsql="truncate table tb_trxstok_member_temp";

		 $oDB->query($vsql);

	  }

   

      

   

	  function postJual($pIdMember,$pNoJual,$pTanggal,$pAlamat,$pStockist,$pTglTrans,$pRekDest,$pJmlTrans,$pSerial,$pPIN,$pMethod) {

	     global $oDB,$dbin,$oSystem,$oNetwork;

	     $vsql="select sum(fsubtotpoint) as ftotpint from tb_penjualan_temp where fidpenjualan='$pNoJual'";

		 $oDB->query($vsql);

		 $oDB->next_record();

		 $vTotPoint=$oDB->f("ftotpint");

		 

	     $vsql="select * from tb_penjualan_temp where fidpenjualan='$pNoJual'";

		 $oDB->query($vsql);



		 

		 while ($oDB->next_record()) {

		   $vNoJual= $oDB->f("fidpenjualan");

		   $vIDMember=$oDB->f("fidmember");

		   $vAlamatKrm=$oDB->f("falamatkrm");

		   $vIDStockist=$oDB->f("fnostockist");   

		   $vIDProduk=$oDB->f("fidproduk");

		   $vQty=$oDB->f("fjumlah");

		   $vHargaSat=$oDB->f("fhargasat");

		   $vSubTotal=$oDB->f("fsubtotal");

		   $vPointSat=$oDB->f("fpointsat");

		   $vSubTotPoint=$oDB->f("fsubtotpoint");

		   

		   $vKet=$oDB->f("fketerangan");

		   $vsqlin="insert into tb_penjualan(fidpenjualan,fidmember,falamatkrm,fnostockist,fidproduk,fjumlah,ftanggal,fhargasat,fsubtotal,fpointsat,fsubtotpoint,fketerangan,ftglentry,ftgltrans,frekdest,fjmltrans,fserial,fpin,fmethod) ";

		   $vsqlin.="values('$vNoJual','$vIDMember','$pAlamat','$pStockist','$vIDProduk',$vQty,'$pTanggal',$vHargaSat,$vSubTotal,$vPointSat,$vSubTotPoint,'$vKet',now(),'$pTglTrans','$pRekDest','$pJmlTrans','$pSerial','$pPIN','$pMethod')";

		   $dbin->query($vsqlin);

		 }

		 

		 //$oNetwork->sendFeeProduct($vIDMember,$vTotPoint);

		 $this->clearTempJual($pIdMember,"");

		 $oSystem->jsAlert("Pembelian processed, mohon tunggu respon dari admin kami!");

	  } 











	  function postJualWallet($pIdMember,$pNoJual,$pTanggal,$pAlamat,$pStockist,$pTglTrans,$pRekDest,$pJmlTrans,$pSerial,$pPIN,$pMethod) {

	     global $oDB,$dbin,$oSystem,$oNetwork;

	     $vsql="select sum(fsubtotpoint) as ftotpint from tb_trxstok_temp where fidpenjualan='$pNoJual'";

		 $oDB->query($vsql);

		 $oDB->next_record();

		 $vTotPoint=$oDB->f("ftotpint");

		 

	     $vsql="select * from tb_trxstok_temp where fidpenjualan='$pNoJual'";

		 $oDB->query($vsql);



		 

		 while ($oDB->next_record()) {

		   $vNoJual= $oDB->f("fidpenjualan");

		   $vIDMember=$oDB->f("fidmember");

		   $vAlamatKrm=$oDB->f("falamatkrm");

		   $vIDStockist=$oDB->f("fnostockist");   

		   $vIDProduk=$oDB->f("fidproduk");

		   $vQty=$oDB->f("fjumlah");

		   $vHargaSat=$oDB->f("fhargasat");

		   $vSubTotal=$oDB->f("fsubtotal");

		   $vPointSat=$oDB->f("fpointsat");

		   $vSubTotPoint=$oDB->f("fsubtotpoint");

		   

		   $vKet=$oDB->f("fketerangan");

		   $vsqlin="insert into tb_trxstok(fidpenjualan,fidmember,falamatkrm,fnostockist,fidproduk,fjumlah,ftanggal,fhargasat,fsubtotal,fpointsat,fsubtotpoint,fketerangan,ftglentry,ftgltrans,frekdest,fjmltrans,fserial,fpin,fmethod) ";

		   $vsqlin.="values('$vNoJual','$vIDMember','$pAlamat','$pStockist','$vIDProduk',$vQty,'$pTanggal',$vHargaSat,$vSubTotal,$vPointSat,$vSubTotPoint,'$vKet',now(),'$pTglTrans','$pRekDest','$pJmlTrans','$pSerial','$pPIN','$pMethod')";

		   $dbin->query($vsqlin);

		 }

		 

		 //$oNetwork->sendFeeProduct($vIDMember,$vTotPoint);

		 $this->clearTempJualWallet($pIdMember,"");

		 $oSystem->jsAlert("Wallet processed!");

	  } 





 

 

 

 

 	  function postJualSell($pIdMember,$pNoJual,$pTanggal,$pAlamat,$pStockist,$pTglTrans,$pRekDest,$pJmlTrans,$pSerial,$pPIN,$pMethod) {

	     global $oDB,$dbin,$db,$oSystem,$oNetwork,$oProduct,$oKomisi;

	     $vsql="select sum(fsubtotpoint) as ftotpint from tb_trxstok_member_temp where fidpenjualan='$pNoJual'";

		 $oDB->query($vsql);

		 $oDB->next_record();

		 $vTotPoint=$oDB->f("ftotpint");

		 

	     $vsql="select * from tb_trxstok_member_temp where fidpenjualan='$pNoJual'";

		 $oDB->query($vsql);



		 

		 while ($oDB->next_record()) {

		   $vNoJual= $oDB->f("fidpenjualan");

		   $vIDSeller=$oDB->f("fidseller");

		   $vIDMember=$oDB->f("fidmember");

		   $vAlamatKrm=$oDB->f("falamatkrm");

		   $vIDStockist=$oDB->f("fnostockist");   

		   $vIDProduk=$oDB->f("fidproduk");

		   $vQty=$oDB->f("fjumlah");

		   $vHargaSat=$oDB->f("fhargasat");

		   $vSubTotal=$oDB->f("fsubtotal");

		   $vPointSat=$oDB->f("fpointsat");

		   $vSubTotPoint=$oDB->f("fsubtotpoint");

		   

		   $vKet=$oDB->f("fketerangan");

		   $vsqlin="insert into tb_trxstok_member(fidpenjualan,fidseller,fidmember,falamatkrm,fnostockist,fidproduk,fjumlah,ftanggal,fhargasat,fsubtotal,fpointsat,fsubtotpoint,fketerangan,ftglentry,ftgltrans,frekdest,fjmltrans,fserial,fpin,fmethod) ";

		   $vsqlin.="values('$vNoJual','$vIDSeller','$vIDMember','$pAlamat','$pStockist','$vIDProduk',$vQty,'$pTanggal',$vHargaSat,$vSubTotal,$vPointSat,$vSubTotPoint,'$vKet',now(),'$pTglTrans','$pRekDest','$pJmlTrans','$pSerial','$pPIN','$pMethod')";

		   $dbin->query($vsqlin);

//Masukkan omzet 		   

   		   $vsqlin="insert into tb_penjualan(fidpenjualan,fidmember,falamatkrm,fnostockist,fidproduk,fjumlah,ftanggal,fhargasat,fsubtotal,fpointsat,fsubtotpoint,fketerangan,ftglentry,ftgltrans,frekdest,fjmltrans,fserial,fpin,fmethod,fprocessed,ftglprocessed) ";

		   $vsqlin.="values('$vNoJual','$vIDMember','$pAlamat','$pStockist','$vIDProduk',$vQty,'$pTanggal',$vHargaSat,$vSubTotal,$vPointSat,$vSubTotPoint,'$vKet',now(),'$pTglTrans','$pRekDest','$pJmlTrans','$pSerial','$pPIN','$pMethod',2,'$pTglTrans')";

		   $dbin->query($vsqlin);

//Masukkan Bonus RO

           $vPros=$oProduct->getProRO($vIDProduk) /100;

           $vFee=$vSubTotal * $vPros;

		   $vKet=$oProduct->getJenisRO($vIDProduk);

		   $oKomisi->insertKomisiJual($vIDMember,"month('$pTglTrans')","year('$pTglTrans')","ro",$vFee,$vTglTrans,$vKet);





//Masukkan Bonus RO Group

           		$vUpline=$oNetwork->getUpline($vIDMember);   

			   $vPros=$oProduct->getProROGroup($vIDProduk) /100;

			   $vFee=$vSubTotal * $vPros;

			   $vKet=$oProduct->getJenisRO($vIDProduk);

			   if ($vUpline!=-1 && trim($vUpline)!="")

			      $oKomisi->insertKomisiJual($vUpline,"month('$pTglTrans')","year('$pTglTrans')","groupro",$vFee,$vTglTrans,$vKet);







		   for ($i=0;$i<9;$i++) {

		       $vUpline=$oNetwork->getUpline($vUpline);	

			   $vPros=$oProduct->getProROGroup($vIDProduk) /100;

			   $vFee=$vSubTotal * $vPros;

			   $vKet=$oProduct->getJenisRO($vIDProduk);

			   if ($vUpline!=-1 && trim($vUpline)!="")

			      $oKomisi->insertKomisiJual($vUpline,"month('$pTglTrans')","year('$pTglTrans')","groupro",$vFee,$vTglTrans,$vKet);

		   }



		   

		 }

		 

		 //$oNetwork->sendFeeProduct($vIDMember,$vTotPoint);

		 $this->clearTempJualSell($pIdMember,"");

		 $oSystem->jsAlert("Penjualan processed!");

	  } 



 

 

     function clearTempJual($pID,$pSession) {

            global $oDB;   

  			$oDB->query("delete from  tb_penjualan_temp where fidmember='$pID'");

     }

     function clearTempJualWallet($pID,$pSession) {

            global $oDB;   

  			$oDB->query("delete from  tb_trxstok_temp where fidmember='$pID'");

     }

 

     function clearTempJualSell($pID,$pSession) {

            global $oDB;   

  			$oDB->query("delete from  tb_trxstok_member_temp where fidseller='$pID'");

     }





 // Get Pembelanjaan

   function getBuyed($pID) {

   global $oDB, $oRules, $oProduct;

   $vsql="select sum(fsubtotal) as fbuy from tb_penjualan where  fidmember='$pID' and fmethod='mPot'";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('fbuy');

	}

	   if ($vres != "")

	      return $vres;

	   else return 0;	    	  

   }





 // Get Disc

   function getDesc($pID) {

   global $oDB, $oRules, $oProduct;

   $vsql="select fdiscglobal from tb_penjualan where  fidmember='$pID' ";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('fdiscglobal');

	}

	   if ($vres != "")

	      return $vres;

	   else return 0;	    	  

   }



 // Get Pembelanjaan Global Bulanan

   function getROGlobal($pThBul) {

   global $oDB, $oRules, $oProduct;

    $vsql="select coalesce(sum(fsubtotal),0) as fbuy from tb_trxstok_member where  fjenis='RO' or fjenis='AutoRO' and  DATE_FORMAT(ftanggal,'%Y%m') = '$pThBul' ";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('fbuy');

	}



   $vsql="select coalesce(sum(fcredit-fdebit),0) as ftotal from tb_mutasi_ro where  DATE_FORMAT(ftanggal,'%Y%m') = '$pThBul' and fkind='koreksi'";

   

  // echo "<br>".$vsql."<br>";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres2=$oDB->f('ftotal');

	}

	 return $vres+$vres2;



   }





// Get Pembelanjaan Stok

   function getBuyedTot($pID) {

   global $oDB, $oRules, $oProduct;

   $vsql="select sum(fsubtotal) as fbuy from tb_trxstok_member where fidproduk not like 'KIT%' and  fidpenjualan='$pID' ";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('fbuy');

	}

	   if ($vres != "")

	      return $vres;

	   else return 0;	    	  

   }





// Get Request  Stok

   function getPOTot($pID) {

   global $oDB, $oRules, $oProduct;

   $vsql="select sum(fsubtotal) as fbuy from tb_trxstok_temp where fidproduk not like 'KIT%' and  fidpenjualan='$pID' ";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres1=$oDB->f('fbuy');

	}



   $vsql="select sum(fsubtotal) as fbuy from tb_trxstok where fidproduk not like 'KIT%' and  fidpenjualan='$pID' ";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres2=$oDB->f('fbuy');

	}



   $vres=$vres1 + $vres2;

	   if ($vres != "")

	      return $vres;

	   else return 0;	    	  

   }





// Get PO kit total

   function getPOTotKit($pID) {

   global $oDB, $oRules, $oProduct;

   $vsql="select sum(fsubtotal) as fbuy from tb_trxkit where   fidpenjualan='$pID' ";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres1=$oDB->f('fbuy');

	}



   $vres=$vres1 ;

	   if ($vres != "")

	      return $vres;

	   else return 0;	    	  

   }



// Get Sell  

   function getSellTot($pID) {

   global $oDB, $oRules, $oProduct;

   $vsql="select sum(fbuy) as fbuy from (select sum(fsubtotal) as fbuy from tb_trxstok_member where 1 and  fidpenjualan='$pID' ";

    $vsql.=" union all select sum(fsubtotal) as fbuy from tb_trxstok_member_temp where 1 and  fidpenjualan='$pID') as a ";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres1=$oDB->f('fbuy');

	}





   $vres=$vres1 ;

	   if ($vres != "")

	      return $vres;

	   else return 0;	    	  

   }

   

   

 // Get Kind Product  

   function getKindProd($pID) {

   global $oDB, $oRules, $oProduct;

   $vsql="select * from (select fidproduk as fidprod from tb_trxstok_member where 1 and  fidpenjualan='$pID' ";

    $vsql.=" union all select fidproduk as fidprod from tb_trxstok_member_temp where 1 and  fidpenjualan='$pID') as a limit 1 ";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres1=$oDB->f('fidprod');

	}





   $vres=$vres1 ;

	   if ($vres != "")

	      return $vres;

	   else return -1;	    	  

   }  

   

 // Get Payment Method

   function getPayMethod($pID) {

   global $oDB, $oRules, $oProduct;

   $vsql="select * from (select fmethod as fmet from tb_trxstok_member where 1 and  fidpenjualan='$pID' ";

    $vsql.=" union all select fmethod as fmet from tb_trxstok_member_temp where 1 and  fidpenjualan='$pID') as a limit 1 ";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres1=$oDB->f('fmet');

	}


   $vres=$vres1 ;

	   if ($vres != "")

	      return $vres;

	   else return -1;	    	  

   }  



 
// Get by Field

   function getJualField($pID, $pField) {

   global $oDB, $oRules, $oProduct;

   $vsql="select * from (select * from tb_trxstok_member where 1 and  fidpenjualan='$pID' ";

     $vsql.=" union all select * from tb_trxstok_member_temp where 1 and  fidpenjualan='$pID') as a limit 1 ";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres1=$oDB->f($pField);

	}




   $vres=$vres1 ;

	   if ($vres != "")

	      return $vres;

	   else return -1;	    	  

   }  

 

 // Get Status  

   function getStatusBuy($pID) {

   global $oDB, $oRules, $oProduct;

   $vsql="select * from (select '2'  as fstatus from tb_trxstok_member where 1 and  fidpenjualan='$pID' ";

    $vsql.=" union all select '0'  as fstatus from tb_trxstok_member_temp where 1 and  fidpenjualan='$pID') as a limit 1 ";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres1=$oDB->f('fstatus');

	}





   $vres=$vres1 ;

	   if ($vres != "")

	      return $vres;

	   else return -1;	    	  

   }     

   

   

   

   

// Get Sell  Temp

   function getSellTotTemp($pID) {

   global $oDB, $oRules, $oProduct;

   $vsql="select sum(fsubtotal) as fbuy from tb_trxstok_member_temp where fidproduk not like 'KIT%' and  fidpenjualan='$pID' ";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres1=$oDB->f('fbuy');

	}


   $vres=$vres1 ;

	   if ($vres != "")

	      return $vres;

	   else return 0;	    	  

   }   

   

// Get ongkir  Temp

   function getOngkirTemp($pID) {

   global $oDB, $oRules, $oProduct;

   $vsql="select fongkir as fongkir from tb_trxstok_member_temp where fidproduk not like 'KIT%' and  fidpenjualan='$pID' ";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres1=$oDB->f('fongkir');

	}
   

   		$vres=$vres1 ;

	   if ($vres != "")

	      return $vres;

	   else return 0;	    	  

   }   
   



// Get ongkir  Temp

   function getOngkir($pID) {

   global $oDB, $oRules, $oProduct;

   $vsql="select fongkir as fongkir from tb_trxstok_member where fidproduk not like 'KIT%' and  fidpenjualan='$pID' ";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres1=$oDB->f('fongkir');

	}
   

   		$vres=$vres1 ;

	   if ($vres != "")

	      return $vres;

	   else return 0;	    	  

   }     
   
   
 // Get Pembelanjaan

   function getBuyedByStatus($pStatus,$pAwal,$pAkhir) {

   global $oDB, $oRules, $oProduct;

   $vAnd="";

   if ($pStatus !=0)

      $vAnd=" and fprocessed=$pStatus";

    $vsql="select sum(fsubtotal) as fbuy from tb_trxstok_member where 1 $vAnd and  fprocessed <> 4 and ftanggal between '$pAwal' and '$pAkhir' ";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('fbuy');

	}

	   if ($vres != "")

	      return $vres;

	   else return 0;	    	  

   }





 // Get Pembelanjaan

   function getInvestByStatus($pStatus,$pAwal,$pAkhir) {

   global $oDB, $oRules, $oProduct;

   $vAnd="";

   if ($pStatus !=0)

      $vAnd=" and fstatusrow=$pStatus";

    $vsql="select sum(fnominal) as finvest from tb_investasi where 1 $vAnd and  fstatusrow <> 4 and ftglaktif between '$pAwal' and '$pAkhir' ";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('finvest');

	}

	   if ($vres != "")

	      return $vres;

	   else return 0;	    	  

   }


// Get Trans

   function getTransByStatus($pStatus,$pAwal,$pAkhir) {

   global $oDB, $oRules, $oProduct;

   $vAnd="";

   if ($pStatus !=0)

      $vAnd=" and fstatusrow=$pStatus";

    $vsql="select sum(fnominal) as ftrans from tb_baltrans where 1 $vAnd and  fstatusrow <> 4 and ftglupdate between '$pAwal' and '$pAkhir' ";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('ftrans');

	}

	   if ($vres != "")

	      return $vres;

	   else return 0;	    	  

   }
 



 // Get Alamat pengiriman

   function getAddressSend($pJual) {

   global $oDB, $oRules, $oProduct;

   $vsql="select falamatkrm  from tb_penjualan where  fidpenjualan='$pJual'";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('falamatkrm');

	}

	   if ($vres != "")

	      return $vres;

	   else return -1;	    	  

   }





// Get Detail Penjualan

   function dispDetBuyed($pIDJual) {

   global $oDB, $oRules, $oProduct;

   $vsql="select a.fidproduk,a.fhargasat, a.fjumlah, b.fnamaproduk,a.fsize, a.fcolor from tb_trxstok_member a";

   $vsql.=" left join m_product b on a.fidproduk=b.fidproduk where a.fidproduk not like 'KIT%' and  a.fidpenjualan='$pIDJual'";

   $vsql .= " union all ";

   $vsql .="select a.fidproduk,a.fhargasat, a.fjumlah, b.fnamaproduk,a.fsize, a.fcolor from tb_trxstok_member_temp a";

   $vsql.=" left join m_product b on a.fidproduk=b.fidproduk where a.fidproduk not like 'KIT%' and  a.fidpenjualan='$pIDJual'";



	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vSize=$oDB->f("fsize");	



	   $vIDProd=$oDB->f("fidproduk");	       

	   

	   $vColor=$oProduct->getColor($oDB->f("fcolor"));

	   $vProd=str_replace(" ","&nbsp;", $vIDProd."/".$oDB->f("fnamaproduk")." (".number_format($oDB->f("fhargasat"),0,",",".").")");

	   if ($vIDProd=='KIT-001')

	      $vProd='Starter KIT';	   



	   $vJum=$oDB->f("fjumlah");

	   $vDisp="<table width='110' border='0'>";

	   $vDisp.="<tr>";

	   $vDisp.="<td width='90' valign='top'><div align='left'>$vProd</div></td>";

	   $vDisp.="<td><div align='left' valign='top'>:</div></td>";

	   $vDisp.="<td valign='top'><div align='right'>$vJum</div></td>";

	   $vDisp.="</tr>";

	   $vDisp.="</table>";

	   echo $vDisp;

	}

   }





// Get Detail Penjualan

   function dispDetAct($pIDJual,$pKIT='') {

   global $oDB, $oRules, $oProduct;

   $vsql="select a.fidproduk,a.fhargasat, a.fjumlah, b.fnamaproduk from tb_kit_active a";

   $vsql.=" left join m_product b on a.fidproduk=b.fidproduk where a.fidproduk not like 'KIT%' and  a.fidpenjualan='$pIDJual' and a.fidmember='$pKIT'";



	$oDB->query($vsql);

	$vDisp="<table width='110' border='0'>";

	$vTot=0;

	while ($oDB->next_record()) {

	   $vSize=$oDB->f("fsize");	



	   $vIDProd=$oDB->f("fidproduk");	       

	   

	   

	   $vProd=str_replace(" ","&nbsp;", $vIDProd."/".$oDB->f("fnamaproduk")." (".number_format($oDB->f("fhargasat"),0,",",".").")");

	   if ($vIDProd=='KIT-001')

	      $vProd='Starter KIT';	   



	   $vJum=$oDB->f("fjumlah");

	   $vHargaSat=$oDB->f("fhargasat");

	   $vSubTot=$vJum * $vHargaSat;

	   $vTot+=$vSubTot;

	   

	   $vDisp.="<tr>";

	   $vDisp.="<td width='90' valign='top'><div align='left'>$vProd</div></td>";

	   $vDisp.="<td><div align='left' valign='top'>:</div></td>";

	   $vDisp.="<td valign='top'><div align='right'>$vJum</div></td>";

	   $vDisp.="</tr>";

	   

	}

	   $vDisp.="<tr>";

	   $vDisp.="<td style=\"font-weight:bold\"><div align='left' valign='top'>Total: ".number_format($vTot,0,",",".")."</div></td>";

	   $vDisp.="</tr>";

	

	$vDisp.="</table>";

	   echo $vDisp;

   }





// Get Detail Penjualan

   function dispDetPO($pIDJual) {

   global $oDB, $oRules, $oProduct;

   $vsql="select a.fidproduk,a.fhargasat, a.fjumlah, b.fnamaproduk,a.fsize, a.fcolor, '1' as fstatus from tb_trxstok a";

   $vsql.=" left join m_product b on a.fidproduk=b.fidproduk where a.fidproduk not like 'KIT%' and  a.fidpenjualan='$pIDJual'";



   $vsql.=" union all select a.fidproduk,a.fhargasat, a.fjumlah, b.fnamaproduk,a.fsize, a.fcolor, '0' as fstatus from tb_trxstok_temp a";

  $vsql.=" left join m_product b on a.fidproduk=b.fidproduk where a.fidproduk not like 'KIT%' and  a.fidpenjualan='$pIDJual'";



	   

	   echo "<table width='110' border='0' style='margin-top:-0.9em'>";



	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vSize=$oDB->f("fsize");	

	



	   $vIDProd=$oDB->f("fidproduk");	       

	   

	   $vColor=$oProduct->getColor($oDB->f("fcolor"));

	   $vProd=str_replace(" ","&nbsp;", $vIDProd."/".$oDB->f("fnamaproduk")." (".number_format($oDB->f("fhargasat"),0,",",".").")");

	   if ($vIDProd=='KIT-001')

	      $vProd='Starter KIT';	  

	       

		$vJum=$oDB->f("fjumlah");

	   $vDisp="<tr>";

	   $vDisp.="<td width='90' valign='top' ><div align='left'>$vProd</div></td>";

	   $vDisp.="<td><div align='left' valign='top'>:</div></td>";

	   $vDisp.="<td valign='top'><div align='right'>$vJum</div></td>";

	   $vDisp.="</tr>";



	  echo $vDisp;

	}

	

		   echo "</table>";

   }





// Get Detail Penjualan

   function dispDetPOKit($pIDJual) {

   global $oDB, $oRules, $oProduct;

   $vsql="select a.fhargasat, a.fjumlah, a.fjenis,a.fprocessed as fstatus, b.fpackname from tb_trxkit a";

   $vsql.=" left join m_paket b on a.fjenis=b.fpackid where  a.fidpenjualan='$pIDJual'";



	   

	   echo "<table width='110' border='0' style='margin-top:-0.9em'>";



	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   

	



	   $vPakname=$oDB->f("fpackname");	       

	   

	  

	   $vProd=str_replace(" ","&nbsp;", $oDB->f("fpackname")." (".number_format($oDB->f("fhargasat"),0,",",".").")");

	       

		$vJum=$oDB->f("fjumlah");

	   $vDisp="<tr>";

	   $vDisp.="<td width='90' valign='top' ><div align='left'>$vPakname</div></td>";

	   $vDisp.="<td><div align='left' valign='top'>:</div></td>";

	   $vDisp.="<td valign='top'><div align='right'>$vJum</div></td>";

	   $vDisp.="</tr>";



	  echo $vDisp;

	}

	

		   echo "</table>";

   }





// Get Detail Penjualan

   function dispDetSell($pIDJual) {

   global $oDB, $oRules, $oProduct;

   $vsql="select a.fidproduk,a.fhargasat, a.fjumlah, b.fnamaproduk,a.fsize, a.fcolor, '1' as fstatus from tb_trxstok_member a";

   $vsql.=" left join m_product b on a.fidproduk=b.fidproduk where 1 and  a.fidpenjualan='$pIDJual'";



   $vsql.=" union all select a.fidproduk,a.fhargasat, a.fjumlah, b.fnamaproduk,a.fsize, a.fcolor, '0' as fstatus from tb_trxstok_member_temp a";

  $vsql.=" left join m_product b on a.fidproduk=b.fidproduk where 1 and  a.fidpenjualan='$pIDJual'";



	   

	   echo "<table width='110' border='0' style='margin-top:-0.9em'>";



	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vSize=$oDB->f("fsize");	

	



	   $vIDProd=$oDB->f("fidproduk");	       

	   

	   $vColor=$oProduct->getColor($oDB->f("fcolor"));

	   $vProd=str_replace(" ","&nbsp;", $vIDProd."/".$oDB->f("fnamaproduk")." (".number_format($oDB->f("fhargasat"),0,",",".").")");

	   if ($vIDProd=='KIT-001')

	      $vProd='Starter KIT';	  

	       

		$vJum=$oDB->f("fjumlah");

	   $vDisp="<tr>";

	   $vDisp.="<td width='90' valign='top' ><div align='left'>$vProd</div></td>";

	   $vDisp.="<td><div align='left' valign='top'>:</div></td>";

	   $vDisp.="<td valign='top'><div align='right'>$vJum</div></td>";

	   $vDisp.="</tr>";



	  echo $vDisp;

	}

	

		   echo "</table>";

   }

// Get Detail Penjualan Pulsa

   function dispDetBuyPulsa($pIDJual) {

   global $oDB, $oRules, $oProduct;

   $vsql="select a.fidproduk,a.fhargasat, a.fjumlah, b.fnamaproduk from tb_withdraw_pulsa a";

   $vsql.=" left join m_product b on a.fidproduk=b.fidproduk where  a.fidpenjualan='$pIDJual'";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vIDProd=$oDB->f("fidproduk");

	   

	       

	   $vProd=$oDB->f("fnamaproduk");

	   if ($vIDProd=='KIT-001')

	      $vProd='Starter KIT';

	   $vJum=$oDB->f("fjumlah");

	   $vDisp="<table width='110' border='0'>";

	   $vDisp.="<tr>";

	   $vDisp.="<td width='90'><div align='left'>$vIDProd."/".$vProd</div></td>";

	   $vDisp.="<td><div align='left'>:</div></td>";

	   $vDisp.="<td><div align='right'>$vJum</div></td>";

	   $vDisp.="</tr>";

	   $vDisp.="</table>";

	   echo $vDisp;

	}

   }







 // Apakah Tutup Point

   function isTutupPoint($pID,$pDate) {

   global $oDB;

   $vsql="select count(fidpenjualan) as fjumlah from tb_penjualan where  fidmember='$pID' and month(ftanggal)=month('$pDate') and year(ftanggal)=year('$pDate')";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('fjumlah');

	}

	   if ($vres > 0)

	      return 1;

	   else return 0;	    	  

   }

   

   //Process Jual

   function processSell($pIDJual) {

	   global $oDB;

	   $vsql="update tb_penjualan set fprocessed=2, ftglprocessed=now() where fidpenjualan='$pIDJual';";

	   $oDB->query($vsql);

	   //$vsql="insert into  tb_transfer(ftanggal,ftglpaid,fidmember,fstatus,fweek,fmonth,fyear,ffee) values('$pDate',now(),'$pID','weekcash',$vWeek,0,$vYear,$pFee)";

	   if ($oDB->affected_rows() > 0)

	      return 1;

	   else

	      return 0;

   }





   //Process Invest

   function processInvest($pIDJual) {

	   global $oDB,$oRules;

	   $vHari=$oRules->getSettingByField(fdayinvest,1);

	   $vsql="update tb_investasi set fstatusrow=2,ftglaktif=now(),ftglend=adddate(now(), interval $vHari DAY)  where fidinvest='$pIDJual';";

	   $oDB->query($vsql);

	   //$vsql="insert into  tb_transfer(ftanggal,ftglpaid,fidmember,fstatus,fweek,fmonth,fyear,ffee) values('$pDate',now(),'$pID','weekcash',$vWeek,0,$vYear,$pFee)";

	   if ($oDB->affected_rows() > 0)

	      return 1;

	   else

	      return 0;

   }





   //Process Jual Pulsa

   function processSellPulsa($pIDJual) {

	   global $oDB;

	   $vsql="update tb_withdraw_pulsa set fprocessed=2, ftglprocessed=now() where fidpenjualan='$pIDJual';";

	   $oDB->query($vsql);

	   

	   if ($oDB->affected_rows() > 0)

	      return 1;

	   else

	      return 0;

   }





//Ambil nilai beli pulsa

function getBuyPulsa($pID) {

      global $oDB;

	  $vsql="select sum(fsubtotal) as ftotal from tb_withdraw_pulsa a, m_product b ";

	  $vsql.="where a.fidproduk=b.fidproduk and b.fmodel='pulsa' and a.fidmember='$pID' "; 

	  $oDB->query($vsql);

	  $vres=0;

	  while ($oDB->next_record()) {

	    $vres=$oDB->f('ftotal');

	  }

	  if ($vres !="")

	      return $vres;

	  else return 0;	    	  



}



//Ambil nilai beli non pulsa

function getBuyedNonPulsa($pID) {

      global $oDB;

	  $vsql="select sum(fsubtotal) as ftotal from tb_penjualan a, m_product b ";

	  $vsql.="where a.fidproduk=b.fidproduk and b.fmodel <> 'pulsa' and a.fidmember='$pID' and a.fprocessed=2"; 

	  $oDB->query($vsql);

	  $vres=0;

	  while ($oDB->next_record()) {

	    $vres=$oDB->f('ftotal');

	  }

	  if ($vres !="")

	      return $vres;

	  else return 0;	    	  



}





//Ambil harga satuan

function getHargaSat($pID) {

      global $oDB;

	  $vsql="select fhargajual,fidproduk from m_product where fidproduk='$pID' ";

	  $oDB->query($vsql);

	  $vres=0;

	  while ($oDB->next_record()) {

	    $vres=$oDB->f('fhargajual');

	  }

	  if ($vres !="")

	      return $vres;

	  else return 0;	    	  



}





 // Get Penjualan by ID Jual

   function getBuyedById($pIDJual) {

   global $oDB, $oRules, $oProduct;

   $vsql="select sum(fsubtotal) as fbuy from tb_penjualan where  fidpenjualan='$pIDJual' and fmethod='mPot'";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('fbuy');

	}

	   if ($vres != "")

	      return $vres;

	   else return 0;	    	  

   }



 // Get Penjualan by ID Jual Temp

   function getBuyedByIdTemp($pIDJual) {

   global $oDB, $oRules, $oProduct;

   $vsql="select sum(fsubtotal) as fbuy from tb_trxstok_member_temp where  fidpenjualan='$pIDJual' ";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('fbuy');

	}

	   if ($vres != "")

	      return $vres;

	   else return 0;	    	  

   }





 // Get Method

   function getBuyedMethod($pIDJual) {

   global $oDB, $oRules, $oProduct;

   $vsql="select fmethod from tb_penjualan where  fidpenjualan='$pIDJual' ";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('fmethod');

	}

	   if ($vres != "")

	      return $vres;

	   else return -1;	    	  

   }





 // Get withdraw Pulsa

   function getWithdraw($pIDJual) {

   global $oDB, $oRules, $oProduct;

   $vsql="select sum(fsubtotal) as fbuy from tb_withdraw_pulsa where  fidpenjualan='$pIDJual' ";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('fbuy');

	}

	   if ($vres != "")

	      return $vres;

	   else return 0;	    	  

   }







 // Get withdraw Pulsa

   function getBuyThisMonth($pID,$pTanggal) {

   global $oDB, $oRules, $oProduct;

   $vsql="select sum(fsubtotal) as fbuy from tb_penjualan where  fidmember='$pID' and ftanggal like '$pTanggal%'";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('fbuy');

	}

	   if ($vres != "")

	      return $vres;

	   else return 0;	    	  

   }







//Ambil kartu total dari member

   function getAllCard($pID) {

       global $oDB;

	   $vsql="select count(*) as fjml from tb_skit where fpendistribusi='$pID'";

	   $oDB->query($vsql);

	   while ($oDB->next_record()) {

	      $vres=$oDB->f("fjml");

	   }

	   

	   if ($vres!="")

	      return $vres;

	   else 

	      return 0;	  

   

   }



//Ambil kartu total dari member

   function getAllCardUpg($pID) {

       global $oDB;

	   $vsql="select count(*) as fjml from tb_skit_upg where fpendistribusi='$pID'";

	   $oDB->query($vsql);

	   while ($oDB->next_record()) {

	      $vres=$oDB->f("fjml");

	   }

	   

	   if ($vres!="")

	      return $vres;

	   else 

	      return 0;	  

   

   }





//Ambil kartu terjual dari member

   function getSoldCard($pID) {

       global $oDB;

	   $vsql="select count(*) as fjml from tb_skit where fpendistribusi='$pID' and fserno in (select fserno from m_anggota)";

	   $oDB->query($vsql);

	   while ($oDB->next_record()) {

	      $vres=$oDB->f("fjml");

	   }

	   

	   if ($vres!="")

	      return $vres;

	   else 

	      return 0;	  

   

   }





//Ambil kartu terjual dari member

   function getKitStatus($pKIT) {

       global $oDB;

	   $vsql="select fserno from m_anggota where fserno='$pKIT'";

	   $oDB->query($vsql);

	   $vres='';

	   while ($oDB->next_record()) {

	      $vres .=$oDB->f("fserno");

	   }



	   $vsql="select fserno from tb_skit where fserno='$pKIT' and fstatus='4'";

	   $oDB->query($vsql);

	   $vres='';

	   while ($oDB->next_record()) {

	      $vres .=$oDB->f("fserno");

	   }



	   

	   if (trim($vres)!="")

	      return 1;

	   else 

	      return 0;	  

   

   }





//Ambil kartu terjual dari member

   function getSoldCardUpg($pID) {

       global $oDB;

	   $vsql="select count(*) as fjml from tb_skit_upg where fpendistribusi='$pID' and frefsell in (select fidmember from m_anggota)";

	   $oDB->query($vsql);

	   while ($oDB->next_record()) {

	      $vres=$oDB->f("fjml");

	   }

	   

	   if ($vres!="")

	      return $vres;

	   else 

	      return 0;	  

   

   }





//Ambil paket kartu 

   function getKitPack($pID) {

       global $oDB, $oProduct;

	   $vsql="select fpaket from tb_skit where fserno='$pID' ";

	   $oDB->query($vsql);

	   while ($oDB->next_record()) {

	      $vres=$oDB->f("fpaket");

	   }

	   

	  /* if($vres=='S')

	      $vPackName='1 HU';

	   else if($vres=='G')

	      $vPackName='3 HU';

	   else if($vres=='P')

	      $vPackName='7 HU';

	   else if($vres=='T')

	      $vPackName='1 HU';

	   else if($vres=='X')

	      $vPackName='3 HU';

	   else if($vres=='L')

	      $vPackName='7 HU';*/

		

		$vPackName = $oProduct->getPackName($vres);



	   

	  

	   

	   $vOut=array();

	   if ($vres!="") {

	      $vOut['name']=$vPackName;

		  $vOut['id']=$vres;

		  

	   } else {



	      $vOut['name']=0;

		  $vOut['id']=0;



	   }

	   return $vOut;

   

   }



//Ambil kartu belum terjual dari member

   function getSaldoCard($pID) {

       global $oDB;

	   $vsql="select count(*) as fjml from tb_skit where fpendistribusi='$pID' and fserno not in (select fserno from m_anggota )";

	   $oDB->query($vsql);

	   while ($oDB->next_record()) {

	      $vres=$oDB->f("fjml");

	   }

	   

	   if ($vres!="")

	      return $vres;

	   else 

	      return 0;	  

   

   }





//Ambil kartu belum terjual dari member

   function getSaldoCardUpg($pID) {

       global $oDB;

	   $vsql="select count(*) as fjml from tb_skit_upg where fpendistribusi='$pID' and frefsell not in (select fidmember from m_anggota)";

	   $oDB->query($vsql);

	   while ($oDB->next_record()) {

	      $vres=$oDB->f("fjml");

	   }

	   

	   if ($vres!="")

	      return $vres;

	   else 

	      return 0;	  

   

   }



//Ambil total Stock

   function getTotStock($pID,$pIDProduk) {

       global $oDB;

	   $vsql="select sum(fjumlah) as fjml from tb_trxstok where fidmember='$pID' and fidproduk ='$pIDProduk'";

	   $oDB->query($vsql);

	   while ($oDB->next_record()) {

	      $vres=$oDB->f("fjml");

	   }

	   

	   if ($vres!="")

	      return $vres;

	   else 

	      return 0;	  

   

   }







//Ambil total Stock Terjual

   function getTotStockSold($pID,$pIDProduk) {

       global $oDB;

	   $vsql="select sum(fjumlah) as fjml from tb_trxstok_member where fidseller='$pID' and fidproduk ='$pIDProduk'";

	   $oDB->query($vsql);

	   while ($oDB->next_record()) {

	      $vres=$oDB->f("fjml");

	   }



	   $vsql="select sum(fjumlah) as fjml from tb_trxstok_member_temp where fidseller='$pID' and fidproduk ='$pIDProduk'";

	   $oDB->query($vsql);

	   while ($oDB->next_record()) {

	      $vres+=$oDB->f("fjml");

	   }



	   

	   if ($vres!="")

	      return $vres;

	   else 

	      return 0;	  

   

   }





//Ambil total Stock Sisa

   function getTotStockBal($pID,$pIDProduk) {

       global $oDB;

       $vres=$this->getTotStock($pID,$pIDProduk) - $this->getTotStockSold($pID,$pIDProduk);

	   

	   if ($vres!="")

	      return $vres;

	   else 

	      return 0;	  

   

   }



//Get Penjual

   function getSeller($pIDJual) {

       global $oDB;

	   $vsql="select fidseller from tb_trxstok_member where fidpenjualan='$pIDJual' ";

	   $oDB->query($vsql);

	   while ($oDB->next_record()) {

	      $vres=$oDB->f("fidseller");

	   }

	   

	   if ($vres!="")

	      return $vres;

	   else 

	      return 0;	  

   

   }

   

   // Get WD

   function getWDByStatus($pStatus,$pAwal,$pAkhir) {

   global $oDB, $oRules, $oProduct;

   $vAnd="";

   if ($pStatus !=0)

      $vAnd=" and fstatusrow=$pStatus";

    $vsql="select sum(fnominal) as fwd from tb_withdraw where 1 $vAnd and  fstatusrow <> 4 and ftglupdate between '$pAwal' and '$pAkhir' ";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('fwd');

	}

	   if ($vres != "")

	      return $vres;

	   else return 0;	    	  

   }



   function convertRate($pCurrFrom,$pCurrTo,$pNom,$pJB) {

	   global $oDB;

	   if ($pJB=='J')

	      $vRate="fratenom";

	   else if ($pJB=='B')  

	      $vRate="fratenombuy"; 

	   $vSQL="select fratefrom, frateto, $vRate, funit from tb_exrate where fratefrom='$pCurrFrom' and frateto='$pCurrTo'";

	   $oDB->query($vSQL);

	   $oDB->next_record();

	   $vRateNom = $oDB->f($vRate);

	   $vUnit = $oDB->f('funit');

	   

	   if ($vUnit > 0)

	      $vConvert = $pNom  * $vUnit / $vRateNom;

	   else $vConvert=$pNom;

	   

	   return $vConvert;	  

	   

	   

   }





   function convertRateID($pCurrFrom,$pCurrTo,$pNom,$pJB) {

	   global $oDB;

	   if ($pJB=='J')

	      $vRate="fratenom";

	   else if ($pJB=='B')  

	      $vRate="fratenombuy"; 

	     

	   $vSQL="select fratefrom, frateto, $vRate, funit from tb_exrate where fratefrom='IDR' and frateto='$pCurrTo'";

	   $oDB->query($vSQL);

	   $oDB->next_record();

	   $vRateNom = $oDB->f($vRate);

	   $vUnit = $oDB->f('funit');

	   

	   if ($vUnit > 0) {

	     if ($pCurrFrom == 'IDR') 

	        $vConvert = $pNom  * $vUnit / $vRateNom;

	     else   

	        $vConvert = $pNom  * $vRateNom / $vUnit; 

	   } else $vConvert=$pNom;

	   

	   return $vConvert;	     

	   

   }





   function convertRateNonID($pCurrFrom,$pCurrTo,$pNom,$pJB) {

	   global $oDB;

	   if ($pJB=='J')

	      $vRate="fratenom";

	   else if ($pJB=='B')  

	      $vRate="fratenombuy"; 

	     

	   $vSQL="select fratefrom, frateto, $vRate, funit from tb_exrate where fratefrom='$pCurrFrom' and frateto='$pCurrTo'";

	   $oDB->query($vSQL);

	   $oDB->next_record();

	   $vRateNom = $oDB->f($vRate);

	   $vUnit = $oDB->f('funit');

	   

	   if ($vUnit > 0) {

	     if ($pCurrFrom == 'IDR') 

	        $vConvert = $pNom  * $vUnit / $vRateNom;

	     else   

	        $vConvert = $pNom  * $vRateNom / $vUnit; 

	   } else $vConvert=$pNom;

	   

	   return $vConvert;	     

	   

   }

 

   

   //Process WD

   function processWD($pIDJual,$pAdmin,$pDB) {

	   global $oRules,$oKomisi,$oMember;
	   
	   $vsql="update tb_withdraw set fstatusrow=2,ftglappv=now(),fadmin='$pAdmin'  where fidwithdraw='$pIDJual' and fstatusrow=0;";

	   $pDB->query($vsql);



	   if ($pDB->affected_rows() > 0) {

	      

		  $vID=$this->getMemberByWD($pIDJual);

		  $vNom=$this->getNomByWD($pIDJual);

		//  $vCurr=$this->getCurrByWD($pIDJual);

	//	  $vNom = $this->convertRate($vCurr,'IDR',$vNom);

		  $vKet=$this->getDescByWD($pIDJual);

		  	$vDesc="Withdraw  ($vKet)";

		  $vLastBal=$oKomisi->getLastBalanceBis($vID);

		  $vBal=$vLastBal-$vNom;

		  $oKomisi->insertMutasiConn($vID,$vID,date("Y-m-d H:i:s"),$vDesc,0,$vNom,$vBal,'withdraw',$pIDJual, $pDB) ;

		  $oMember->changeBalBisConn($vID,$vNom,'D',$pDB);

		  return 1;

	   } else

	      return 0;

   }

    //Process Trans
   function processTrans($pIDJual,$pAdmin,$pIDMember,$pNom, $pKet, $pIDTo) {
	   global $oDB,$db,$oRules,$oKomisi,$oMember, $oSystem;
	   $vsql="update tb_baltrans set fstatusrow=2,ftglappv=now(),fadmin='$pAdmin'  where fidtrans='$pIDJual' and fstatusrow=0;";
	   $oDB->query($vsql);

	   if ($oDB->affected_rows() > 0) {
	      
		  $vID=$pIDMember;
		  $vNom=$pNom;
		  $vKet=$pKet;

		  
		  $vDesc="Transfer saldo  ke  $pIDTo ($vKet)";
		  $vLastBal=$oKomisi->getLastBalanceBis($vID);
		  if ($vLastBal==-1) {
			$vsql="select * from m_korwil where fidkorwil='$vID'";
			$db->query($vsql);
			$db->next_record();
			$vIDBis = $db->f('fidbisnis');
			$vLastBal=$oKomisi->getLastBalanceBis($vIDBis);
		  } else $vIDBis=$vID;
		  
		  $vBal=$vLastBal-$vNom;
		  if ($vBal < 0) {
			 $oSystem->jsAlert('Saldo yang ditransfer tidak cukup!');  
			 $vsql="update tb_baltrans set fstatusrow=0,ftglappv=null,fadmin=null  where fidtrans='$pIDJual' ";
	   $oDB->query($vsql);
			 return 0;
		  } else {
			  $oKomisi->insertMutasi($vID,$vID,date("Y-m-d H:i:s"),$vDesc,0,$vNom,$vBal,'transfer') ;
			  $oMember->updateSaldoBiz($vIDBis,$vNom,'D');
	
			  $vDesc="Terima transferan saldo  dari  $vID ($vKet)";
			  $vLastBal=$oKomisi->getLastBalanceBis($pIDTo);
			  $vBal=$vLastBal+$vNom;
			  $oKomisi->insertMutasi($pIDTo,$vID,date("Y-m-d H:i:s"),$vDesc,$vNom,0,$vBal,'rectransfer') ;
			  $oMember->updateSaldoBiz($pIDTo,$vNom,'K');
	
			  return 1;
		  }
	   } else
	      return 0;
   } 

    function getMemberByWD($pWD){

	   global $oDB;

	   $vsql="select fidmember from tb_withdraw where fidwithdraw='$pWD';";

	   $oDB->query($vsql);

	   $oDB->next_record();

	   return $oDB->f('fidmember');

   }



    function getMemberByJual($pTrx){

	   global $oDB;

	   $vsql="select fidmember from tb_trxstok_member where fidpenjualan='$pTrx';";

	   $oDB->query($vsql);

	   $oDB->next_record();

	   return $oDB->f('fidmember');

   }

  

    function getNomByWD($pWD){

	   global $oDB;

	   $vsql="select fnominal from tb_withdraw where fidwithdraw='$pWD' and fstatusrow <> '4';";

	   $oDB->query($vsql);

	   $oDB->next_record();

	   return $oDB->f('fnominal');

   }

 

     function getCurrByWD($pWD){

	   global $oDB;

	   $vsql="select fcurr from tb_withdraw where fidwithdraw='$pWD' and fstatusrow <> '4';";

	   $oDB->query($vsql);

	   $oDB->next_record();

	   $vCurr=$oDB->f('fcurr');

	   if ($vCurr=='') $vCurr='IDR';

	   return $vCurr;

   }



 

   function getDescByWD($pWD){

	   global $oDB;

	   $vsql="select fket as fresult from tb_withdraw where fidwithdraw='$pWD';";

	   $oDB->query($vsql);

	   $oDB->next_record();

	   return $oDB->f('fresult');

   }

   function getNextIDJual() {

   	   global $oDB;

   	   $vPrefix="J".date("Ymd");

   	   $vSQL="select max(maxid) as amaxid from (select max(fidpenjualan) as maxid from tb_trxstok_member where fidpenjualan like '$vPrefix%'";

	    $vSQL.="union all select max(fidpenjualan) as maxid from tb_trxstok_member_temp where fidpenjualan like '$vPrefix%') as a";

   	   $oDB->query($vSQL);

   	   $oDB->next_record();

   	   $vMaxid=$oDB->f('amaxid');

   	   if ($vMaxid=='') {

	   	   $vNext=$vPrefix."00001";

   	   } else {

	   	  $vSuffix=substr($vMaxid,9,5);

	   	  $vSuffix=((int) $vSuffix) + 1;

	   	  $vSuffix=str_pad($vSuffix, 5, '0', STR_PAD_LEFT);

	   	  $vNext=$vPrefix.$vSuffix;

	   }  

	   

	   return $vNext;

   	   

   }

 

    function getNextIDAct() {

   	   global $oDB;

   	   $vPrefix="A".date("Ymd");

   	   $vSQL="select max(fidpenjualan)  as amaxid from tb_kit_active  where fidpenjualan like '$vPrefix%'";



   	   $oDB->query($vSQL);

   	   $oDB->next_record();

   	   $vMaxid=$oDB->f('amaxid');

   	   if ($vMaxid=='') {

	   	   $vNext=$vPrefix."00001";

   	   } else {

	   	  $vSuffix=substr($vMaxid,9,5);

	   	  $vSuffix=((int) $vSuffix) + 1;

	   	  $vSuffix=str_pad($vSuffix, 5, '0', STR_PAD_LEFT);

	   	  $vNext=$vPrefix.$vSuffix;

	   }  

	   

	   return $vNext;

   	   

   }

   

   

   function getKITNom($pKIT) {

   	   global $oDB;



   	   $vSQL="select sum(fsubtotal)  as fsubtot from tb_kit_active  where trim(fidmember) = trim('$pKIT') ";

	   $vSubtot =0;	

   	   $oDB->query($vSQL);

   	   $oDB->next_record();

   	   $vSubtot=$oDB->f('fsubtot');

	   return $vSubtot;

   	   

   }



   

   function getNextIDKIT() {

   	   global $oDB;

   	   $vPrefix='KI'.date("Ymd");

   	   $vSQL="select max(fidpenjualan) as maxid from tb_trxkit where fidpenjualan like '$vPrefix%'";

   	   $oDB->query($vSQL);

   	   $oDB->next_record();

   	   $vMaxid=$oDB->f('maxid');

   	   if ($vMaxid=='') {

	   	   $vNext=$vPrefix."00001";

   	   } else {

	   	  $vSuffix=substr($vMaxid,10,5);

	   	  $vSuffix=((int) $vSuffix) + 1;

	   	  $vSuffix=str_pad($vSuffix, 5, '0', STR_PAD_LEFT);

	   	  $vNext=$vPrefix.$vSuffix;

	   }  

	   

	   return $vNext;

   	   

   }





   function getNextIDStock() {

   	   global $oDB;

   	   $vPrefix='ST'.date("Ymd");

   	   $vSQL="select max(fidpenjualan) as maxid from tb_trxstok where fidpenjualan like '$vPrefix%'";

   	   $oDB->query($vSQL);

   	   $oDB->next_record();

   	   $vMaxid=$oDB->f('maxid');

   	   if ($vMaxid=='') {

	   	   $vNext=$vPrefix."00001";

   	   } else {

	   	  $vSuffix=substr($vMaxid,10,5);

	   	  $vSuffix=((int) $vSuffix) + 1;

	   	  $vSuffix=str_pad($vSuffix, 5, '0', STR_PAD_LEFT);

	   	  $vNext=$vPrefix.$vSuffix;

	   }  

	   $vMicro=microtime(true);

	   $vMicro=str_replace(".","",$vMicro);

	   $vLength=strlen($vMicro);

	   

	   $vMicro=substr($vMicro,($vLength-3),$vLength);

	   return $vNext.".".$vMicro;

   	   

   }



   

   

   

   function getNextIDRPO() {

   	   global $oDB;

   	   $vPrefix='RPO'.date("Ymd");

   	   $vSQL="select max(fidpenjualan) as maxid from tb_trxstok_temp where fidpenjualan like '$vPrefix%'";

   	   $oDB->query($vSQL);

   	   $oDB->next_record();

   	   $vMaxid=$oDB->f('maxid');

   	   if ($vMaxid=='') {

	   	   $vNext=$vPrefix."00001";

   	   } else {

	   	  $vSuffix=substr($vMaxid,11,5);

	   	  $vSuffix=((int) $vSuffix) + 1;

	   	  $vSuffix=str_pad($vSuffix, 5, '0', STR_PAD_LEFT);

	   	  $vNext=$vPrefix.$vSuffix;

	   }  

	   

	   return $vNext;

   	   

   }

   

   

   function transferKIT($pJumlah=0,$pJenis) {

        global $oDB;

		$vSQL="select fserno from tb_skit where fstatus='1' and fserno like '$pJenis%' limit $pJumlah";

		$oDB->query($vSQL);

		$vOut='';

		while ($oDB->next_record()) {

		   $vOut[]=$oDB->f('fserno'); 

		

		}

		

		return $vOut;

   }

 



   function getCntCurr($pCnt) {

        global $oDB;

		$vSQL="select fcurr from m_country where fcountry_code='$pCnt'";

		$oDB->query($vSQL);

		$vOut='';

		while ($oDB->next_record()) {

		   $vOut=$oDB->f('fcurr'); 

		

		}

		

		return $vOut;

   }

 

 function isSpecCurr($pCurr) {

         global $oDB;

		$vSQL="select fspecial from tb_exrate where frateto='$pCurr'";

		$oDB->query($vSQL);

		$vOut='';

		while ($oDB->next_record()) {

		   $vOut=$oDB->f('fspecial'); 

		

		}

		

		if ($vOut=='1')

		   return true;

		else return false;   



 }

 

 	  function checkMultiRO($pUser,$pYearMonth) {

	      global $oDB;

		$vsql="select sum(fjumlah) as jml from tb_trxstok_member where fjenis='RO' and fidmember='$pUser' and DATE_FORMAT(ftanggal,'%Y%m') = '$pYearMonth'  ";  

	  	  $oDB->query($vsql);

	  	  $oDB->next_record();

		  $vJum=$oDB->f('jml');

		  if ($vJum=='') $vJum=0;

		  return $vJum;

	  }



 	  function getBuyedJumById($IDJual) {

	      global $oDB;

		$vsql="select sum(fjumlah) as jml from tb_trxstok_member where fidpenjualan = '$IDJual'  ";  

	  	  $oDB->query($vsql);

	  	  $oDB->next_record();

		  $vJum=$oDB->f('jml');

		  if ($vJum=='') $vJum=0;

		  return $vJum;

	  }



 

  	  function getSetRO($pUser) {

	      global $oDB;

		  $vsql="select sum(fjumlah) as jml from tb_trxstok_member where fidmember='$pUser' and fjenis='RO'";  

	  	  $oDB->query($vsql);

	  	  $oDB->next_record();

		  $vJum=$oDB->f('jml');

		  if ($vJum=='') $vJum=0;

		  return $vJum;

	  }

	  

	  function checkStock($pIdMember,$pIdProduct,$pAmount) {

	  	  global $oDB;

	  	 $vSQL="select * from tb_stok_position where fidmember='$pIdMember' and fidproduk='$pIdProduct' ";

	  	  $oDB->query($vSQL);

	  	  $oDB->next_record();

	  	  $vQoh=$oDB->f('fbalance');

	  	  if ($vQoh=='')

	  	      $vQoh=0;

	  	      

	  	  if ($vQoh >= $pAmount)

	  	     return 1;

	  	  else return 0;    



	  }



// Get Topup

   function getTopupByStatus($pStatus,$pAwal,$pAkhir) {

   global $oDB, $oRules, $oProduct;

   $vAnd="";

   if ($pStatus !=0)

      $vAnd=" and fstatusrow=$pStatus";

    $vsql="select sum(fnominal) as ftopup from tb_topup where 1 $vAnd and  fstatusrow <> 4 and ftglupdate between '$pAwal' and '$pAkhir' ";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('ftopup');

	}

	   if ($vres != "")

	      return $vres;

	   else return 0;	    	  

   } 

   

   

  //Process Topup

   function processTopup($pIDJual,$pAdmin) {

	   global $oDB,$oRules,$oKomisi,$oMember;

	   $vsql="update tb_topup set fstatusrow=2,fadmin='$pAdmin'  where fidtopup='$pIDJual' and fstatusrow=0;";

	   $oDB->query($vsql);



	   if ($oDB->affected_rows() > 0) {

	      

		  $vID=$this->getMemberByTopup($pIDJual);

		  $vNom=$this->getNomByTopup($pIDJual);

		  $vKet=$this->getDescByTopup($pIDJual);

		  $vSyset=$this->getSysETByTopup($pIDJual);

		  if ($vSyset != "" && $vSyset!='0') 

		    $vDesc="Topup Deposit Sinkron dari EasyTravel ($pIDJual - $vKet)"; 

		  else

		    $vDesc="Topup Deposit ($pIDJual - $vKet)";

		  $vLastBal=$oKomisi->getLastBalance($vID);

		  $vBal=$vLastBal+$vNom;

		  $oKomisi->insertMutasi($vID,$vID,date("Y-m-d H:i:s"),$vDesc,$vNom,0,$vBal,'topup') ;

		  $oMember->updateSaldo($vID,$vNom,'K');

		  return 1;

	   } else

	      return 0;

   }   

   

    function getMemberByTopup($pTopup){

	   global $oDB;

	   $vsql="select fidmember from tb_topup where fidtopup='$pTopup';";

	   $oDB->query($vsql);

	   $oDB->next_record();

	   return $oDB->f('fidmember');

   }

   function getNomByTopup($pTopup){

	   global $oDB;

	   $vsql="select fnominal from tb_topup where fidtopup='$pTopup';";

	   $oDB->query($vsql);

	   $oDB->next_record();

	   return $oDB->f('fnominal');

   }

  

  

   function getDescByTopup($pTopup){

	   global $oDB;

	   $vsql="select fket as fresult from tb_topup where fidtopup='$pTopup';";

	   $oDB->query($vsql);

	   $oDB->next_record();

	   return $oDB->f('fresult');

   }

   function getSysETByTopup($pTopup){

	   global $oDB;

	   $vsql="select fidsyset from tb_topup where fidtopup='$pTopup';";

	   $oDB->query($vsql);

	   $oDB->next_record();

	   return $oDB->f('fidsyset');

   }

  function getNextIDJPoin() {
   	   global $oDB;
   	   $vPrefix="PY".date("Ymd");
   	   $vSQL="select max(maxid) as amaxid from (select max(fidpenjualan) as maxid from tb_payment where fidpenjualan like '$vPrefix%'";
	    $vSQL.="union all select max(fidpenjualan) as maxid from tb_payment_temp where fidpenjualan like '$vPrefix%') as a";
   	   $oDB->query($vSQL);
   	   $oDB->next_record();
   	   $vMaxid=$oDB->f('amaxid');
   	   if ($vMaxid=='') {
	   	   $vNext=$vPrefix."00001";
   	   } else {
	   	  $vSuffix=substr($vMaxid,10,5);
	   	  $vSuffix=((int) $vSuffix) + 1;
	   	  $vSuffix=str_pad($vSuffix, 5, '0', STR_PAD_LEFT);
	   	  $vNext=$vPrefix.$vSuffix;
	   }  
	   
	   return $vNext;
   	   
   }



   function getPendingTrans($pID,$pJenis){
	   global $oDB;
	   $vsql="select sum(fnominal) as fpending  from tb_baltrans where fidmember='$pID' and fstatusrow='0';";
	   $oDB->query($vsql);
	   $oDB->next_record();
	   
	   if ($oDB->f('fpending') =='') 
	      $vRet=0;
	   else $vRet=$oDB->f('fpending');	   
	   return $vRet;
	   
	   
   }


   function getPendingWD($pID,$pJenis){
	   global $oDB;
	   $vsql="select sum(fnominal) as fpending  from tb_withdraw where fidmember='$pID' and fstatusrow='0';";
	   $oDB->query($vsql);
	   $oDB->next_record();
	   if ($oDB->f('fpending') =='') 
	      $vRet=0;
	   else $vRet=$oDB->f('fpending');	   
	   return $vRet;
   }


   function getPendingTrx($pID,$pJenis){
	   global $oDB;
	   $vsql="select sum(fhrgamh) as fpending  from tb_trxpulsa where fidmember='$pID' and fstatustrx='1';";
	   $oDB->query($vsql);
	   $oDB->next_record();
	   if ($oDB->f('fpending') =='') 
	      $vRet=0;
	   else $vRet=$oDB->f('fpending');	   
	   return $vRet;
   }


function reverseBalance($vUser,$vDesc,$vHarga,$vIDTrx,$vKdProd) {
	    global $oDB, $dbin, $oProduct, $oNetwork, $oMember, $oRules, $oKomisi,$oMember;
		$vsql="update tb_trxpulsa set fstatustrx=4,ftglupdate=now(),flastuser='system', fket=concat(fket,'$vDesc') where fidtrx='$vIDTrx' and fstatustrx not in ('4','0','11')";
		$oDB->query($vsql);
		if ($oDB->affected_rows() <=0)
		exit;
		$vFeePulsa=$oRules->getSettingByField("fcountflush");
        $vFeePublic=$oRules->getSettingByField("fhrgpaket");

		$vLastBal=$oMember->getMemFieldBis('fsaldovcr',$vUser);
		$vBal=$vLastBal+$vHarga;
		
		
		$vDesc="Reversal atau refund transaksi gagal ($vDesc), $vIDTrx, pembelian pulsa atau PLN $vKdProd ";
		$oKomisi->insertMutasi($vUser,$vUser,date("Y-m-d H:i:s"),$vDesc,$vHarga,0,$vBal,'pulsa') ;
		$oMember->updateBalBis($vUser,$vBal);
	
/*	
		$vProsenFeeSpon=$oRules->getSettingByField("fminroyal");
		$vSponFee=($vFeePublic - $vFeePulsa) * ($vProsenFeeSpon/100);
	
		$vSponsor=$oNetwork->getSponsor($vUser);
		$vLastBal=$oember->getLastBalBis($vUser);
		$vBal=$vLastBal+$vSponFee;
		
		
		$vDesc="Pengembalian Bonus Transaksi Sponsor untuk $vSponsor, pembelian pulsa karena gagal ($vDesc) $vIDTrx - $vKdProd ";
		$oKomisi->insertMutasi($vUser,$vUser,date("Y-m-d H:i:s"),$vDesc,$vSponFee,0,$vBal,'pulsa') ;
		$oMember->updateSaldo($vUser,$vSponFee,'K');
	
	
		$vLastBal=$oKomisi->getLastBalance($vSponsor);
		$vBal=$vLastBal-$vSponFee;
		
		
		$vDesc="Kembalikan Bonus Transaksi Sponsor dari $vUser karena reversal karena gagal ($vDesc), pembelian pulsa $vIDTrx - $vKdProd ";
		$oKomisi->insertMutasi($vSponsor,$vSponsor,date("Y-m-d H:i:s"),$vDesc,0,$vSponFee,$vBal,'pulsa') ;
		$oMember->updateSaldo($vSponsor,$vSponFee,'D');	  */	
	
}

 } //Class

   $oJual=new penjualan;

?>
