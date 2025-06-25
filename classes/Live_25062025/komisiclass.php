<?

   include_once( $CLASS_DIR."memberclass.php");
   include_once( $CLASS_DIR."dateclass.php");
   include_once( $CLASS_DIR."networkclass.php");
   include_once( $CLASS_DIR."ifaceclass.php");
   include_once( $CLASS_DIR."ruleconfigclass.php");
   include_once( $CLASS_DIR."komisiclass.php");
   include_once( $CLASS_DIR."jualclass.php");
   include_once( $CLASS_DIR."productclass.php");

   

   $vArrPeringkat=array('E'=>'Executive','PE'=>'Platinum Executive','M'=>'Manager','PM'=>'Platinum Manager','D'=>'Director','RD'=>'Royal Director');

   

   class komisi {

   

   function checkSyaratReward($pID, $pIDSyarat) {

      global $oDB, $oNetwork;

   

         if ($pIDSyarat==0) {//Top Rekrut

				$vDown=$oNetwork->getDownlineLevel($pID,2);

				$vCountDown=count($vDown);

				$vCheckDownDown=true;

				$vCount25=0;

				for ($i=0;$i<($vCountDown);$i++) {

				  $vDownDown=$oNetwork->getDownlineCount($vDown[$i]);

				

				  if ($vDownDown >=450)

					 $vCount25+=1;

				}

				

				if ($vCount25 >= 25) 

				   return 1; 

				else   

				   return 0; 

				   

	  } //Top Rekrut

   

         if ($pIDSyarat==1) {//Bantuan Usaha Buka Stockist

				$vDown=$oNetwork->getDownlineLevel($pID,2);

				$vCountDown=count($vDown);

				$vCheckDownDown=true;

				$vCount25=0;

				for ($i=0;$i<($vCountDown);$i++) {

				  $vDownDown=$oNetwork->getDownlineCount($vDown[$i]);

				

				  if ($vDownDown >=450)

					 $vCount25+=1;

				}

				

				if ($vCount25 >= 25) 

				   return 1; 

				else   

				   return 0; 

				   

	  } //Bantuan Usaha Buka Stockist



         if ($pIDSyarat==2) {//Bonus Tour Jerusalem 

			$vDirectDown=$oNetwork->getDownlineCount1($pID);

			

			    $vDown=$oNetwork->getDownlineLevel($pID,2);

				$vCountDown=count($vDown);

				$vCheckDownDown=true;

				$vCount25=0;

				for ($i=0;$i<($vCountDown);$i++) {

				  $vDownDown=$oNetwork->getDownlineCount($vDown[$i]);

				

				  if ($vDownDown >=500)

					 $vCount25+=1;

				}

				

				if (($vCount25 >= 25)  && ($vDirectDown >= 5))

				   return 1; 

				else   

				   return 0; 

				   

	  } //Bonus Tour Jerusalem 



 		 if ($pIDSyarat==3) {//Direct Upline

		   $vDirectDown=$oNetwork->getDownline($pID);

		   $vCountDown=count($vDirectDown);

		   $vCount=0;

		   for($i=0;$i<$vCountDown;$i++) {

		       if ($this->checkReward($vDirectDown[$i],2)==1)

			   $vCount+=1;

		   }

		   if ($vCount >= 4) 

			 return 1; 

		   else		   

		     return 0; 

		 } // Direct Upline

		 

         if ($pIDSyarat==4) {//Bonus Refreshing Meeting 

			$vDirectDown=$oNetwork->getDownlineCount1($pID);

			

			    $vDown=$oNetwork->getDownlineLevel($pID,2);

				$vCountDown=count($vDown);

				$vCheckDownDown=true;

				$vCount16=0;

				for ($i=0;$i<($vCountDown);$i++) {

				  $vDownDown=$oNetwork->getDownlineCount($vDown[$i]);

				

				  if ($vDownDown >=100)

					 $vCount16+=1;

				}

				

				if (($vCount16 >= 16)  && ($vDirectDown >= 4))

				   return 1; 

				else   

				   return 0; 

				   

	  } //Bonus Refreshing Meeting



   

   

      if ($pIDSyarat==5) {//Gala Dinner

				$vDown=$oNetwork->getDownlineLevelTPoint($pID,2);		

				$vCountDown=count($vDown);

				$vCheckDownDown=true;

				$vCount9=0;

				for ($i=0;$i<($vCountDown);$i++) {

				  $vDownDown=$oNetwork->getDownlineCountTPoint($vDown[$i]);		

				  if ($vDownDown >=40) 

					 $vCount9+=1;

				}

				

				if ($vCount9 >= 9) 

				   return 1; 

				else   

				   return 0; 

				   

	  } //Gala Dinner



         if ($pIDSyarat==6) {//Bonus Ongkos Naik Haji/Eropa

			$vDirectDown=$oNetwork->getDownlineCount1TPoint($pID);

			

			    $vDown=$oNetwork->getDownlineLevel($pID,2);

				$vCountDown=count($vDown);

				$vCheckDownDown=true;

				$vCount25=0;

				for ($i=0;$i<($vCountDown);$i++) {

				  $vDownDown=$oNetwork->getDownlineCountTPoint($vDown[$i]);

				

				  if ($vDownDown >=500)

					 $vCount25+=1;

				}

				

				if (($vCount25 >= 25)  && ($vDirectDown >= 5))

				   return 1; 

				else   

				   return 0; 

				   

	  } //Bonus Ongkos Naik Haji/Eropa



         if ($pIDSyarat==7) {//Bonus ke 4 dari Jaringan Belanja Voucher 

			$vDirectDown=$oNetwork->getDownlineCount1TPoint($pID);

			

			    $vDown=$oNetwork->getDownlineLevelTPoint($pID,2);

				$vCountDown=count($vDown);

				$vCheckDownDown=true;

				$vCount16=0;

				for ($i=0;$i<($vCountDown);$i++) {

				  $vDownDown=$oNetwork->getDownlineCountTPoint($vDown[$i]);

				

				  if ($vDownDown >=300)

					 $vCount16+=1;

				}

				

				if (($vCount16 >= 16)  && ($vDirectDown >= 4))

				   return 1; 

				else   

				   return 0; 

				   

	  } //Bonus ke 4 dari Jaringan Belanja Voucher



 		 if ($pIDSyarat==8) {//Bonus Untuk Sponsor Langsung

		   $vDirectDown=$oNetwork->getDirectSponTPoint($pID);

		   $vCountDown=count($vDirectDown);

		   $vCount=0;

		   for($i=0;$i<$vCountDown;$i++) {

		       if ($this->checkReward($vDirectDown[$i],2)==1)

			   $vCount+=1;

		   }

		   if ($vCount >= 4) 

			 return 1; 

		   else		   

		     return 0; 

		 } // Bonus Untuk Sponsor Langsung





         if ($pIDSyarat==9) {//Bantuan Pengembangan Usaha

			$vDirectDown=$oNetwork->getDownlineCount1TPoint($pID);

			

			    $vDown=$oNetwork->getDownlineLevel($pID,2);

				$vCountDown=count($vDown);

				$vCheckDownDown=true;

				$vCount25=0;

				for ($i=0;$i<($vCountDown);$i++) {

				  $vDownDown=$oNetwork->getDownlineCountTPoint($vDown[$i]);

				

				  if ($vDownDown >=400)

					 $vCount25+=1;

				}

				

				if (($vCount25 >= 25)  && ($vDirectDown >= 5))

				   return 1; 

				else   

				   return 0; 

				   

	  } //Bantuan Pengembangan Usaha





	 return -1;

  } 

  

  //Ambil Voucher Kemarin ke belakang

   function getKomVcrPrev($pID) {

		global $oDB, $oMydate;

		$oMydate->setCritPrevDate(ftglkomisi,date("Y-m-d"));

		$vsql="select ffee as jumlah from (select fidmember as fid,sum(ffee) AS ffee,'vcr' from tb_kom_mtx_vcr where ftanggal <= (select ftglkomisi  from tb_criteria) and ffeestatus = 1 group by fidmember ) as vkom_mtx_vcr where fid='$pID'";	

		$oDB->query($vsql);

		while ($oDB->next_record()) {

		  $vmatrix = $oDB->f('jumlah');

		}

		if ($vmatrix!="")

		   return $vmatrix;

		else

		   return 0;  

	}

   

      //Ambil Komisi Matrix Voucher

   function getKomVcr($pID) {

		global $oDB, $oRules;

		$vRpPoint=$oRules->getSettingByField("frppointv",1);

		$vsql="select sum(ffee) as fmtxfee from tb_kom_mtx_vcr where fidmember='$pID' and ffeestatus='1'";	

		$oDB->query($vsql);

		while ($oDB->next_record()) {

		  $vVoucher=$oDB->f('fmtxfee');

		  $vmatrix = floor($vVoucher / $vRpPoint);

		  //$vmatrix = $vVoucher;

		}

		if ($vmatrix!="")

		   return $vmatrix;

		else

		   return 0;  

	}



      //Ambil Komisi Pasangan Periode

   function getKomCoupPeriodNT($pID,$pStart,$pEnd) {

		global $oDB, $oRules;

		$vsql="select sum(ffee) as fcoupfee from tb_kom_couple where fidreceiver='$pID' and ffeestatus='1' and (date(ftanggal) between date('$pStart') and date('$pEnd'))";	

		$oDB->query($vsql);

		$vres=0;

		while ($oDB->next_record()) {

		  $vres=$oDB->f('fcoupfee');

		}

	    return $vres;  

	}



      //Ambil Komisi Match Periode

   function getKomMatchPeriodNT($pID,$pStart,$pEnd) {

		global $oDB, $oRules;

		$vsql="select sum(ffee) as fmatchfee from tb_kom_match where fidreceiver='$pID' and ffeestatus='1' and (ftanggal between '$pStart' and '$pEnd')";	

		$oDB->query($vsql);

		$vres=0;

		while ($oDB->next_record()) {

		  $vres=$oDB->f('fmatchfee');

		}

	    return $vres;  

	}





   //Ambil Komisi Level Periode

   function getKomLevelPeriodNT($pID,$pStart,$pEnd) {

		global $oDB, $oRules;

		 $vsql="select sum(ffee) as flevelfee from tb_kom_mtx where fidmember='$pID' and ffeestatus='1' and (date(ftanggal) between date('$pStart') and date('$pEnd'))";	

		$oDB->query($vsql);

		$vres=0;

		while ($oDB->next_record()) {

		  $vres=$oDB->f('flevelfee');

		}

	    return $vres;  

	}





   //Ambil Komisi Level Periode

   function getKomSponPeriodNT($pID,$pStart,$pEnd) {

		global $oDB, $oRules;

		 $vsql="select sum(ffee) as fsponday from tb_kom_spon where fidsponsor='$pID' and (date(ftanggal) between '$pStart' and '$pEnd')";	

		$oDB->query($vsql);

		$vres=0;

		while ($oDB->next_record()) {

		  $vres=$oDB->f('fsponday');

		}

	    return $vres;  

	}







      //Ambil Komisi Level All

   function getKomLevel($pID,$pTgl) {

		global $oDB, $oRules;

		 $vsql="select sum(ffee) as flevelfee from tb_kom_mtx where fidmember='$pID' and ffeestatus=1  and ftanggal < '$pTgl' ";	

		$oDB->query($vsql);

		$vres=0;

		while ($oDB->next_record()) {

		  $vres=$oDB->f('flevelfee');

		}

	    return $vres;  

	}





      //Ambil Komisi Spon E

   function getKomSponE($pID,$pTgl) {

		global $oDB, $oRules;

		 $vsql="select sum(ffee) as flevelfee from tb_kom_spon where fidsponsor='$pID'  and date(ftanggal) = '$pTgl' ";	

		$oDB->query($vsql);

		$vres=0;

		while ($oDB->next_record()) {

		  $vres=$oDB->f('flevelfee');

		}

	    return $vres;  

	}





 // Get SaldoVoucher

   function getSaldoVcr($pID) {

   global $oDB, $oRules, $oJual;

        $vKomVcr=$this->getKomVcr($pID);

		$vBuyed=$oJual->getBuyed($pID);

		$vSaldo=$vKomVcr-$vBuyed;

		return $vSaldo;    	  

   }







   //get Reward ket

   function getKetClaim($pID,$pLevel) {

	   

      global $oDB;

      if ($pLevel=='') $pLevel=0;

	  $vres="";

	  $vSQL="select fbukti from tb_rewards where fkdanggota='$pID' and flevel=$pLevel "; 

	  $oDB->query($vSQL); 	

	  while ($oDB->next_record()) {

	     $vres=$oDB->f("fbukti");

	  }

	  

	  if ($vres!="")

	     return $vres;

	  else

	  	 return '-'; 	 

	  

   }

   

   //is Got All Reward

   function isGotReward($pID,$pLevel) {

      global $oDB;

      $vres="";

	  $vSQL="select flevel from tb_rewards where fkdanggota='$pID' and flevel=$pLevel "; 

	  $oDB->query($vSQL); 	

	  while ($oDB->next_record()) {

	     $vres=$oDB->f("flevel");

	  }

	  

	  if ($vres!="")

	     return true;

	  else

	  	 return false; 	 

	  

   }   

   

   //Check Reward Member

   function checkRewardOld($pID,$pIDSyarat) {

      global $oDB;

      $vres="";

	  $vSQL="select flevel from tb_rewards where fidmember='$pID' and flevel=$pIDSyarat "; 

	  $oDB->query($vSQL); 	

	  while ($oDB->next_record()) {

	     $vres=$oDB->f("flevel");

	  }

	  

	  if ($vres!="")

	     return 1;

	  else

	  	 return 0; 	 

	  

   }





   //Set Reward Member

   function setReward($pID,$pLevel,$pPeringkat,$pOmzet,$pReward) {

      global $oDB;

      $vSQL="insert into tb_rewards(`fkdanggota`,`flevel`,`fperingkat`,`fomzet`,`frewarddesc`,`ftanggal`) values('$pID',$pLevel,'$pPeringkat','$pOmzet','$pReward',now());"; 

	 



	    $oDB->query($vSQL); 	

   }



   //Check Reward Member

   function checkReward($pID,$pPeringkat) {

      global $oDB;

      $vSQL="select * from tb_rewards where  fkdanggota='$pID' and fperingkat='$pPeringkat' "; 	 

	  $oDB->query($vSQL); 	

	  $oDB->next_record();

	  $vres=0;

	  if ($oDB->num_rows() > 0)

	     $vres=1;

	  

	  return $vres;	 

	    

   }





   //Set Komisi Pasangan

   function setCouple($pID,$pRegistrar,$pFee, $pCount,$pTgl) {

      global $oDB;

      $vSQL="insert into tb_kom_couple(fidreceiver ,fidregistrar,ffee , ftanggal) values('$pID','$pRegistrar',$pFee,$pNom,'$pTgl');"; 

	 

	  if ($this->checkReward($pID,$pIDSyarat)==0)

	    $oDB->query($vSQL); 	

   }



   //Get Reward By ID Syarat

   function getRewardById($pIDSyarat) {

      global $oDB;

      $vres="";

	  $vSQL="select sum(fnominal) as fnom from tb_rewards where  flevel=$pIDSyarat "; 

	  $oDB->query($vSQL); 	

	  while ($oDB->next_record()) {

	     $vres=$oDB->f("fnom");

	  }

	  

	  if ($vres!="")

	     return $vres;

	  else

	  	 return 0; 	 

	  

   }



   //Get Omzet Stockist

   function getOmzet($pIDStock) {

      global $oDB;

      $vres="";

	  $vSQL="select count(fidmember) as fomzet from m_anggota where  fidstockist='$pIDStock' and faktif=1 "; 

	  $oDB->query($vSQL); 	

	  while ($oDB->next_record()) {

	     $vres=$oDB->f("fomzet");

	  }

	  

	  if ($vres!="")

	     return $vres;

	  else

	  	 return 0; 	 

	  

   }

   

   //Ambil Komisi Pasangan 

   function getAllCoupFee($pID,$pTgl) {

   global $oDB;

   $vWhere="";

   if (trim($pID)!="") $vWhere=" and fidreceiver = '$pID'";

   $vsql="select sum(ffee) as fcoupfee from tb_kom_couple where 1  $vWhere and ffeestatus='1' and date(ftanggal) < '$pTgl'";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('fcoupfee');

	}

	 if ($vres!="")  

	   return $vres;

	 else return 0;  

   }





//Get Fee Sponsor All by date

   function getAllSponFeeDate($pID,$pTgl) {

   global $oDB;

   $vsql="select sum(ffee) as fsponfee from tb_kom_spon where fidsponsor='$pID' and ffeestatus='S' and date(ftanggal) < '$pTgl' ";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('fsponfee');

	}

	   return $vres;

   }



   //Ambil Count Komisi Pasangan 

   function getAllCoupCount($pID,$pTgl) {

   global $oDB;

   $vWhere="";

   if (trim($pID)!="") $vWhere=" and fidreceiver = '$pID'";

   $vsql="select count(ffee) as fcoupfee from tb_kom_couple where 1  $vWhere and ffeestatus='1' and date(ftanggal) < '$pTgl'";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('fcoupfee');

	}

	 if ($vres!="")  

	   return $vres;

	 else return 0;  

   }





   //Ambil Komisi Pasangan 

   function getAllCoupFeeDay($pID,$pTgl) {

   global $oDB;

   $vsql="select sum(ffee) as fcoupfee from tb_kom_couple where fidreceiver = '$pID' and ffeestatus='1' and date(ftanggal) = '$pTgl'";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('fcoupfee');

	}

	 if ($vres!="")  

	   return $vres;

	 else return 0;  

   }





   //Ambil Komisi Match 

   function getAllMatchFee($pID,$pTgl) {

   global $oDB;

   $vsql="select sum(ffee) as fmatchfee from tb_kom_match where fidreceiver = '$pID' and ffeestatus='1' and ftanggal < '$pTgl'";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('fmatchfee');

	}

	 if ($vres!="")  

	   return $vres;

	 else return 0;  

   }





   //Ambil Omzet RO All

   function getAllOmzetRO() {

   global $oDB;

   $vsql="select sum(fsubtotal) as ftotal from tb_trxstok_member where fprocessed=2";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('ftotal');

	}

	  if ($vres!="")

	      return $vres;  

	  else

	      return 0;	  

   }



   //Ambil Omzet RO Month

   function getOmzetROMonth($pMonth,$pYear) {

   global $oDB;

   $pMonth=(int) $pMonth;

   $vsql="select sum(fsubtotal) as ftotal from tb_trxstok_member where fprocessed=2 and and fjenis='RO' and month(ftanggal)=$pMonth and year(ftanggal)=$pYear";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('ftotal');

	}

	  if ($vres!="")

	      return $vres;  

	  else

	      return 0;	  

   }



   //Ambil Omzet RO Month Poin

   function getOmzetROMonthP($pMonth,$pYear) {

   global $oDB;

   $pMonth=(int) $pMonth;

   $vsql="select sum(fsubtotpoint) as ftotal from tb_trxstok_member where fprocessed=2 and month(ftanggal)=$pMonth and year(ftanggal)=$pYear";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('ftotal');

	}

	  if ($vres!="")

	      return $vres;  

	  else

	      return 0;	  

   }







   //Ambil Omzet RO Month Member

   function getOmzetROMonthMember($pID,$pMonth,$pYear) {

   global $oDB;

   $pMonth=(int) $pMonth;

   $vsql="select sum(fsubtotal) as ftotal from tb_trxstok_member where fprocessed=2 and fjenis='RO' and month(ftanggal)=$pMonth and year(ftanggal)=$pYear and fidmember='$pID'";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('ftotal');

	}

	  if ($vres!="")

	      return $vres;  

	  else

	      return 0;	  

   }



   //Ambil Omzet RO Month Member dari RO Wallet

   function getOmzetROMonthMemberWallet($pID,$pMonth,$pYear) {

   global $oDB;

   $pMonth=(int) $pMonth;

   $vsql="select fbalance as ftotal from tb_mutasi_ro where month(ftanggal)=$pMonth and year(ftanggal)=$pYear and fidmember='$pID' and fkind='koreksi' and fdesc like '%RO Wallet Direct Change%' ";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('ftotal');

	}

	  if ($vres!="")

	      return $vres;  

	  else

	      return 0;	  

   }







   //Ambil Omzet RO Month Member Poin

   function getOmzetROMonthMemberP($pID,$pMonth,$pYear) {

   global $oDB;

   $pMonth=(int) $pMonth;

   $vsql="select sum(fsubtotpoint) as ftotal from tb_trxstok_member where fprocessed=2 and month(ftanggal)=$pMonth and year(ftanggal)=$pYear and fidmember='$pID'";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('ftotal');

	}

	  if ($vres!="")

	      return $vres;  

	  else

	      return 0;	  

   }











   //Ambil Omzet RO Day Member

   function getOmzetRODayMember($pID,$pDay,$pMonth,$pYear) {

   global $oDB;

   $pMonth=(int) $pMonth;

   $vsql="select sum(fsubtotal) as ftotal from tb_trxstok_member where fprocessed=2 and month(ftanggal)=$pMonth and year(ftanggal)=$pYear and day(ftanggal)=$pDay and fidmember='$pID'";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('ftotal');

	}

	  if ($vres!="")

	      return $vres;  

	  else

	      return 0;	  

   }





   //Ambil Omzet Jumlah Produk Month Member

   function getOmzetCountMonthMember($pID,$pProd,$pMonth,$pYear) {

   global $oDB;

   $pMonth=(int) $pMonth;

   // $vsql="select sum(fjumlah) as fjum from tb_trxstok_member where fprocessed=2 and month(ftanggal)=$pMonth and year(ftanggal)=$pYear and fidmember='$pID' and fidproduk='$pProd'";

	$vsql="select sum(a.fjumlah) as fjum from tb_trxstok_member a,m_product b where a.fidproduk=b.fidproduk and a.fprocessed=2 and month(a.ftanggal)=$pMonth and year(a.ftanggal)=$pYear and a.fidmember='$pID' and b.fmodel <> 'pulsa'";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('fjum');

	}

	  if ($vres!="")

	      return $vres;  

	  else

	      return 0;	  

   }







   //Ambil Omzet RO All Member

   function getOmzetROAllMember($pID) {

   global $oDB;

   $pMonth=(int) $pMonth;

   $vsql="select sum(fsubtotal) as ftotal from tb_trxstok_member where fprocessed=2 and fidproduk not like 'KIT%' and fjenis='RO' and fidmember = '$pID'";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('ftotal');

	}

	  if ($vres!="")

	      return $vres;  

	  else

	      return 0;	  

   }





   //Ambil Omzet RO All Member

   function getOmzetAllMember($pID) {

   global $oDB;

   $pMonth=(int) $pMonth;

   $vsql="select sum(fsubtotal) as ftotal from tb_trxstok_member where fprocessed=2 and fidmember = '$pID'";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('ftotal');

	}

	  if ($vres!="")

	      return $vres;  

	  else

	      return 0;	  

   }





  //Ambil Omzet RO All Member

   function getOmzetCompany() {

   global $oDB;

   $pMonth=(int) $pMonth;

   $vsql="select sum(fsubtotal) as ftotal from tb_trxstok_member where fprocessed=2 ";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('ftotal');

	}

	  if ($vres!="")

	      return $vres;  

	  else

	      return 0;	  

   }





   //Ambil Omzet RO Set All Member

   function getOmzetROSetAllMember($pID) {

   global $oDB;

   $pMonth=(int) $pMonth;

   $vsql="select sum(fjumlah) as ftotal from tb_trxstok_member where fprocessed=2 and fidproduk not like 'KIT%' and fidmember = '$pID'";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('ftotal');

	}

	  if ($vres!="")

	      return $vres;  

	  else

	      return 0;	  

   }





  //Ambil Omzet RO All Member with KIT

   function getOmzetROAllMemberKIT($pID) {

   global $oDB;

   $pMonth=(int) $pMonth;

   $vsql="select sum(fsubtotal) as ftotal from tb_trxstok_member where fprocessed=2  and fidmember = '$pID'";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('ftotal');

	}

	  if ($vres!="")

	      return $vres;  

	  else

	      return 0;	  

   }





   //Ambil Omzet RO All Member by date

   function getOmzetROAllMemberByDate($pID,$vAwal,$vAkhir) {

   global $oDB;

   $pMonth=(int) $pMonth;

   $vsql="select sum(fsubtotal) as ftotal from tb_trxstok_member where fprocessed=2 and fidmember = '$pID' and fidproduk not like 'KIT%' and fjenis='RO' and date(ftanggal) between '$vAwal' and '$vAkhir'";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('ftotal');

	}

	

	

	  if ($vres!="")

	      return $vres;  

	  else

	      return 0;	  

   }

   

   

   

  //Ambil Omzet FO All Member by date

   function getOmzetFOAllMemberByDate($pID,$vAwal,$vAkhir) {

   global $oDB;

   $pMonth=(int) $pMonth;

  $vsql="select sum(fsubtotal) as ftotal from tb_trxstok_member where fprocessed=2 and fidmember = '$pID' and fjenis = 'FO' and date(ftanggal) between '$vAwal' and '$vAkhir'";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('ftotal');

	}

	

	

	  if ($vres!="")

	      return $vres;  

	  else

	      return 0;	  

   }   





  //Ambil Bonus Spon + PAsangan  Member by date

   function getBonusAByDate($pID,$vAwal,$vAkhir) {

   global $oDB;

   $vresspon=0;$vrespair=0;

   $vsql="select sum(ffee) as ftotal from tb_kom_spon where  fidsponsor = '$pID'   and date(ftanggal) between date('$vAwal') and date('$vAkhir')";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vresspon=$oDB->f('ftotal');

	}





   $vsql="select sum(ffeenom) as ftotal from tb_kom_couple where  fidreceiver = '$pID'   and date(ftanggal) between date('$vAwal') and date('$vAkhir')";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vrespair=$oDB->f('ftotal');

	}

	

	$vres=$vresspon+$vrespair;

	

	



	      return $vres;  

   }   



   

   //Ambil Omzet RO All Member by Month

   function getOmzetROAllMemberByMonth($pID,$vMonth,$vYear) {

   global $oDB;

   $pMonth=(int) $pMonth;

  // echo $vYear;

   $vsql="select coalesce(sum(fsubtotal),0) as ftotal from tb_trxstok_member where fprocessed=2 and fidmember = '$pID' and fidproduk not like 'KIT%' and (fjenis='RO' or fjenis='AutoRO') and month(ftanggal) = $vMonth and year(ftanggal)=$vYear";

  //echo "<br>".$vsql."<br>";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('ftotal');

	}

	



  /* $vsql="select coalesce(sum(fcredit-fdebit),0) as ftotal from tb_mutasi_ro where fidmember = '$pID' and  month(ftanggal) = $vMonth and year(ftanggal)=$vYear and fkind='koreksi'";

   

  // echo "<br>".$vsql."<br>";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres2=$oDB->f('ftotal');

	}*/

	$vres2 =0;

	      return $vres+$vres2;  

   }   





   //Ambil Omzet RO Whole Member ( di bawahnya)

   function getOmzetROWholeMember($pID) {

      global $oDB,$oNetwork;

      $vDownAll=$oNetwork->getDownlineAll($pID,$vOut);

	  //echo "ID:".$pID."<br>:::".print_r($vOut);

	  if (is_array($vOut))

	      $vCount=count($vOut);

	  else 	  

	      $vCount=0;

	  $vTotOmzet=0;

	  for ($i=0;$i<$vCount;$i++) {

	    $vTotOmzet+=$this->getOmzetROAllMember($vOut[$i]);

	  }

	  return $vTotOmzet;

   }





   //Ambil Omzet RO Whole Member ( di bawahnya)

   function getOmzetWholeMember($pID) {

      global $oDB,$oNetwork;

      $vDownAll=$oNetwork->getDownlineAll($pID,$vOut);

	  if (is_array($vOut))

	      $vCount=count($vOut);

	  else 	  

	      $vCount=0;

	  $vTotOmzet=0;

	  for ($i=0;$i<$vCount;$i++) {

	    $vTotOmzet+=$this->getOmzetAllMember($vOut[$i]);

	  }

	  return $vTotOmzet;

   }





   //Ambil Omzet RO Set Whole Member ( di bawahnya)

   function getOmzetROSetWholeMember($pID) {

      global $oDB,$oNetwork;

      $vDownAll=$oNetwork->getDownlineAll($pID,$vOut);

	  if (is_array($vOut))

	      $vCount=count($vOut);

	  else 	  

	      $vCount=0;

	  $vTotOmzet=0;

	  for ($i=0;$i<$vCount;$i++) {

	    $vTotOmzet+=$this->getOmzetROSetAllMember($vOut[$i]);

	  }

	  return $vTotOmzet;

   }





   //Ambil Omzet RO Whole Member Bulanan ( di bawahnya)

   function getOmzetROWholeMemberMonth($pID,$pMonth,$pYear) {

      global $oDB,$oNetwork;

      $vOut="";

	  $vDownAll=$oNetwork->getDownlineAll($pID,$vOut);

	  	  if (is_array($vOut))

	      $vCount=count($vOut);

	  else 	  

	      $vCount=0;



	  $vTotOmzet=0;

	  $vOmzetSendiri=$this->getOmzetROMonthMember($pID,$pMonth,$pYear);

	  for ($i=0;$i<$vCount;$i++) {

	    $vTotOmzet+=$this->getOmzetROMonthMember($vOut[$i],$pMonth,$pYear);

	  }

	  

	  return $vTotOmzet+$vOmzetSendiri;

   }





   //Ambil Omzet RO Whole Member Bulanan ( di bawahnya) dari RO wallet

   function getOmzetROWholeMemberMonthWallet($pID,$pMonth,$pYear) {

      global $oDB,$oNetwork;

      $vOut="";

	  $vDownAll=$oNetwork->getDownlineAll($pID,$vOut);

	  	  if (is_array($vOut))

	      $vCount=count($vOut);

	  else 	  

	      $vCount=0;



	  $vTotOmzet=0;

	  $vOmzetSendiri=$this->getOmzetROMonthMemberWallet($pID,$pMonth,$pYear);

	  for ($i=0;$i<$vCount;$i++) {

	    $vTotOmzet+=$this->getOmzetROMonthMemberWallet($vOut[$i],$pMonth,$pYear);

	  }

	  

	  return $vTotOmzet+$vOmzetSendiri;

   }





   //Ambil Omzet RO Whole Member Bydate

   function getOmzetROWholeMemberByDate($pID,$pAwal,$pAkhir) {

      global $oDB,$oNetwork;

      $vOut="";

	  $vDownAll=$oNetwork->getDownlineAll($pID,$vOut);



	  if (is_array($vOut))

	      $vCount=count($vOut);

	  else 	  

	      $vCount=0;



	  $vTotOmzet=0;

	  $vOmzetSendiri=$this->getOmzetROAllMemberByDate($pID,$pAwal,$pAkhir);

	  for ($i=0;$i<$vCount;$i++) {

	    $vTotOmzet+=$this->getOmzetROAllMemberByDate($vOut[$i],$pAwal,$pAkhir);

		

	  }

	 

	  return $vTotOmzet+$vOmzetSendiri;

   }





//Ambil Omzet FO Whole Member Bydate

   function getOmzetFOWholeMemberByDate($pID,$pAwal,$pAkhir) {

      global $oDB,$oNetwork;

      $vOut="";

	  $vDownAll=$oNetwork->getDownlineAll($pID,$vOut);



	  if (is_array($vOut))

	      $vCount=count($vOut);

	  else 	  

	      $vCount=0;



	  $vTotOmzet=0;

	  $vOmzetSendiri=$this->getOmzetFOAllMemberByDate($pID,$pAwal,$pAkhir);

	  for ($i=0;$i<$vCount;$i++) {

	    $vTotOmzet+=$this->getOmzetFOAllMemberByDate($vOut[$i],$pAwal,$pAkhir);

		

	  }

	 

	  return $vTotOmzet+$vOmzetSendiri;

   }



   //Ambil Omzet RO Whole Member By Month

   function getOmzetROWholeMemberByMonth($pID,$pMonth,$pYear) {

      global $oDB,$oNetwork;

      $vOut="";

	  $vDownAll=$oNetwork->getDownlineAll($pID,$vOut);



	  if (is_array($vOut))

	      $vCount=count($vOut);

	  else 	  

	      $vCount=0;



	  $vTotOmzet=0;

	  $vOmzetSendiri=$this->getOmzetROAllMemberByMonth($pID,$pMonth,$pYear);

	  for ($i=0;$i<$vCount;$i++) {

	    $vTotOmzet+=$this->getOmzetROAllMemberByMonth($vOut[$i],$pMonth,$pYear);

		

	  }

	 

	  return $vTotOmzet+$vOmzetSendiri;

   }







   //Ambil Jumlah member Royalty

   function getCountRoyalty($pMonth,$pYear) {

   global $oDB;

   $pMonth=(int) $pMonth;

   $vsql="SELECT COUNT(*) AS froyalti FROM (SELECT fidmember, SUM(a.fsubtotal) AS fbuy from tb_trxstok_member a WHERE fprocessed=2 and MONTH(a.ftanggal)=$pMonth AND YEAR(a.ftanggal)=$pYear GROUP BY fidmember) AS b WHERE fbuy>=1000000";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('froyalti');

	}

	  if ($vres!="")

	      return $vres;  

	  else

	      return 0;	  

   }





   //Apakah dapat royalti bulan ini

   function isGotRoyalty($pID,$pMonth,$pYear) {

   global $oDB;

   $pMonth=(int) $pMonth;

   $vsql="select sum(fsubtotal) as ftotal from tb_trxstok_member where fprocessed=2 and month(ftanggal)=$pMonth and year(ftanggal)=$pYear and fidmember='$pID'";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('ftotal');

	}

	  if ($vres > 0)

	      return 1;  

	  else

	      return 0;	  

   }



   //Apakah dapat royalti poin bulan ini

   function isGotRoyaltyP($pID,$pMonth,$pYear) {

   global $oDB;

   $pMonth=(int) $pMonth;

   $vsql="select sum(fsubtotpoint) as ftotal from tb_trxstok_member where fprocessed=2 and month(ftanggal)=$pMonth and year(ftanggal)=$pYear and fidmember='$pID'";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('ftotal');

	}

	  if ($vres > 0)

	      return 1;  

	  else

	      return 0;	  

   }







//Omzet pengembangan (versi lama)

  function getOmzetKembangLama($pID,$pMonth,$pYear) {

      global $oNetwork;

	  

	   $vOmzetDL=0;$vOmzetDR=0;

	   $vOutL=null;$vOutR=null;

	   $vKakiL=$oNetwork->getDownLR($pID,"L");

	   $vKakiR=$oNetwork->getDownLR($pID,"R"); 

	   

	   if ($vKakiL !=-1)

	      $oNetwork->getDownlineAll($vKakiL,$vOutL);

	   else  $vOutL=null;	  

	   

	   if ($vKakiR !=-1)

	      $oNetwork->getDownlineAll($vKakiR,$vOutR);

	   else $vOutR=null;	  

	   

	   $vDownAllL=count($vOutL);

	   if ($vDownAllL > 0) $vDownAllL+=1;

	   $vDownAllR=count($vOutR);

	   if ($vDownAllR > 0) $vDownAllR+=1;

	   

	   

	   $vOmzetDL=$this->getOmzetROWholeMemberMonth($vKakiL,$pMonth,$pYear);

	   $vOmzetDR=$this->getOmzetROWholeMemberMonth($vKakiR,$pMonth,$pYear);

	 

	  if ((vOmzetDL<$vOmzetDR) && ($vOmzetDL>=300000) && ($vDownAllL > 0)) {

		   //$vOmzetDLFinal=$vOmzetDL * 10/100;

		   //$vOmzetDRFinal=$vOmzetDR * 2/100;

		   $vOmzetDLFinal=$vOmzetDL * 10/1000;

		   $vOmzetDRFinal=$vOmzetDR * 2/1000;		   

	  }	 

	  

	  if ((vOmzetDL>$vOmzetDR) && ($vOmzetDR>=300000) && ($vDownAllR > 0)) {

		   //$vOmzetDLFinal=$vOmzetDL * 2/100;

		   //$vOmzetDRFinal=$vOmzetDR * 10/100;

		   $vOmzetDLFinal=$vOmzetDL * 2/1000;

		   $vOmzetDRFinal=$vOmzetDR * 10/1000;		   

	  }	 

	  $vOmzetDLR=$vOmzetDLFinal+$vOmzetDRFinal;

	  if ($vOmzetDLR>50000000) $vOmzetDLR=50000000;

	  return $vOmzetDLR;



  }





//Omzet pengembangan

  function getOmzetKembang($pID,$pMonth,$pYear) {

      global $oNetwork;



	   $vOmzetDL=0;$vOmzetDR=0;

	   $vOutL=null;$vOutR=null;

	   $vKakiL=$oNetwork->getDownLR($pID,"L");

	   $vKakiR=$oNetwork->getDownLR($pID,"R"); 

	   

	   if ($vKakiL !=-1)

	      $oNetwork->getDownlineAll($vKakiL,$vOutL);

	   else  $vOutL=null;	  

	   

	   if ($vKakiR !=-1)

	      $oNetwork->getDownlineAll($vKakiR,$vOutR);

	   else $vOutR=null;	  

	    

	   $vDownAllL=count($vOutL);

	   if ($vDownAllL > 0) $vDownAllL+=1;

	   $vDownAllR=count($vOutR);

	   if ($vDownAllR > 0) $vDownAllR+=1;

	 

	   //echo $vKakiL.$pMonth.$pYear;

	    $vOmzetDL=$this->getOmzetROWholeMemberMonth($vKakiL,$pMonth,$pYear);

	    $vOmzetDR=$this->getOmzetROWholeMemberMonth($vKakiR,$pMonth,$pYear);

	   

	  if (($vOmzetDL<$vOmzetDR) && ($vOmzetDL>=300000) && ($vDownAllL >= 0)) {

		   //$vOmzetDLFinal=$vOmzetDL * 10/100;

		   //$vOmzetDRFinal=$vOmzetDR * 2/100;

		   //$vOmzetDLFinal=$vOmzetDL * 10/1000;

		   //$vOmzetDRFinal=$vOmzetDR * 2/1000;		   

		   $vOmzetDLFinal=floor($vOmzetDL / 1000000)*50000;

		   $vOmzetDRFinal=0;

	  }	 

	  

	  if (($vOmzetDL>$vOmzetDR) && ($vOmzetDR>=300000) && ($vDownAllR >= 0)) {

		   //$vOmzetDLFinal=$vOmzetDL * 2/100;

		   //$vOmzetDRFinal=$vOmzetDR * 10/100;

		   //$vOmzetDLFinal=$vOmzetDL * 2/1000;

		   //$vOmzetDRFinal=$vOmzetDR * 10/1000;		   

		   $vOmzetDLFinal=0;

		   $vOmzetDRFinal=floor($vOmzetDR / 1000000)*50000;		   		   

	  }	 



	  if (($vOmzetDL==$vOmzetDR) && ($vOmzetDR>=300000) && ($vDownAllR >= 0)) {

		   //$vOmzetDLFinal=$vOmzetDL * 2/100;

		   //$vOmzetDRFinal=$vOmzetDR * 10/100;

		   //$vOmzetDLFinal=$vOmzetDL * 2/1000;

		   //$vOmzetDRFinal=$vOmzetDR * 10/1000;		   

		   $vOmzetDLFinal=0;

		   $vOmzetDRFinal=floor($vOmzetDR / 1000000)*50000;		   	

	  }	 







	  $vOmzetDLR=$vOmzetDLFinal+$vOmzetDRFinal;

	 // $vKomday=$this->getOmzetRODayMember($pID,$pDay,$pMonth,$pYear));

	  if ($vOmzetDLR>60000000) $vOmzetDLR=60000000;

	  return $vOmzetDLR;



  }











//Platinum 1

  function getCountPlatinum1() {

      global $oNetwork, $dbin;

	  $vsql="select * from m_anggota where faktif=1";

	  $dbin->query($vsql);

	  $vCount=0;

	  while ($dbin->next_record()) {

	      $pID=$dbin->f("fidmember");

		  $vKakiL=$oNetwork->getDownLR($pID,"L");

		  $vKakiR=$oNetwork->getDownLR($pID,"R"); 

		  

		  $vOmzetDL=$this->getOmzetROWholeMember($vKakiL);

		  $vOmzetDR=$this->getOmzetROWholeMember($vKakiR)."<br>";

		  if (($vOmzetDL >=100000000 && $vOmzetDL < 450000000) && ($vOmzetDR >=100000000 && $vOmzetDR < 450000000)) {

		     $vCount+=1;		

		  }	 

	}//while $dbin	  

	  return $vCount;

  }





//Platinum 2

  function getCountPlatinum2() {

      global $oNetwork, $dbin;

	  $vsql="select * from m_anggota where faktif=1";

	  $dbin->query($vsql);

	  $vCount=0;

	  while ($dbin->next_record()) {

	      $pID=$dbin->f("fidmember");

		  $vKakiL=$oNetwork->getDownLR($pID,"L");

		  $vKakiR=$oNetwork->getDownLR($pID,"R"); 

		  

		  $vOmzetDL=$this->getOmzetROWholeMember($vKakiL);

		  $vOmzetDR=$this->getOmzetROWholeMember($vKakiR)."<br>";

		  if (($vOmzetDL >=450000000 && $vOmzetDL < 1350000000) && ($vOmzetDR >=450000000 && $vOmzetDR < 1350000000)) {

		     $vCount+=1;		

		  }	 

	}//while $dbin	  

	  return $vCount;

  }



//Platinum 2-2

  function getCountPlatinum3() {

      global $oNetwork, $dbin;

	  $vsql="select * from m_anggota where faktif=1";

	  $dbin->query($vsql);

	  $vCount=0;

	  while ($dbin->next_record()) {

	      $pID=$dbin->f("fidmember");

		  $vKakiL=$oNetwork->getDownLR($pID,"L");

		  $vKakiR=$oNetwork->getDownLR($pID,"R"); 

		  

		  $vOmzetDL=$this->getOmzetROWholeMember($vKakiL);

		  $vOmzetDR=$this->getOmzetROWholeMember($vKakiR)."<br>";

		  if (($vOmzetDL >=1350000000 && $vOmzetDL < 4000000000) && ($vOmzetDR >=1350000000 && $vOmzetDR < 4000000000)) {

		     $vCount+=1;		

		  }	 

	}//while $dbin	  

	  return $vCount;

  }



//Platinum Royal

  function getCountPlatinumR() {

      global $oNetwork, $dbin;

	  $vsql="select * from m_anggota where faktif=1";

	  $dbin->query($vsql);

	  $vCount=0;

	  while ($dbin->next_record()) {

	      $pID=$dbin->f("fidmember");

		  $vKakiL=$oNetwork->getDownLR($pID,"L");

		  $vKakiR=$oNetwork->getDownLR($pID,"R"); 

		  

		  $vOmzetDL=$this->getOmzetROWholeMember($vKakiL);

		  $vOmzetDR=$this->getOmzetROWholeMember($vKakiR)."<br>";

		  if (($vOmzetDL >=4000000000) && ($vOmzetDR >=4000000000)) {

		     $vCount+=1;		

		  }	 

	}//while $dbin	  

	  return $vCount;

  }







 //get Peringkat

   function getPeringkat($pValue) {

      if ($pValue>=4000000000)

	     $vPeringkat="Royal Platinum";

	  else if ($pValue>=1350000000)	 

	     $vPeringkat="Platinum * 2";

	  else if ($pValue>=450000000)	 

	     $vPeringkat="Platinum * 2";

	  else if ($pValue>=100000000)	 

   		 $vPeringkat="Platinum * 1";

	  else $vPeringkat=-1;	 

      return $vPeringkat; 

   }



   function getPeringkatPersen($pValue) {

      if ($pValue>=4000000000)

	     $vPeringkat=5;

	  else if ($pValue>=1350000000)	 

	     $vPeringkat=4.5;

	  else if ($pValue>=450000000)	 

	     $vPeringkat=4;

	  else if ($pValue>=100000000)	 

   		 $vPeringkat=2;

	  else $vPeringkat=0;	 	 

      return $vPeringkat; 

   }





   function isAlready($pUser,$pMonth,$pYear,$pKind) {

     global $oDB;

	 $vsql="select * from tb_kom_b where fidmember='$pUser' and fmonth=$pMonth and fyear=$pYear and fkind='$pKind'";

	 $vres=0;

	 $oDB->query($vsql);

	 while ($oDB->next_record()) {

	    $vres=$oDB->f("fidmember");

	 }

	 

	 if ($vres!="")

	    return 1;

	 else

	    return -1; 	



   }



   function isInGilir($pUser) {

     global $oDB;

	 $vsql="select * from tb_kom_b where fidmember='$pUser' and fkind='gilir'";

	 $vres=0;

	 $oDB->query($vsql);

	 while ($oDB->next_record()) {

	    $vres=$oDB->f("fidmember");

	 }

	 

	 if ($vres!="")

	    return 1;

	 else

	    return -1; 	



   }



   function isAlreadyGilir($pUser,$pMonth,$pYear,$pKind) {

     global $oDB;

	 $vsql="select * from tb_kom_b where fmonth=$pMonth and fyear=$pYear and fkind='$pKind'";

	 $vres=0;

	 $oDB->query($vsql);

	 while ($oDB->next_record()) {

	    $vres=$oDB->f("fidmember");

	 }

	 

	 if ($vres!="")

	    return 1;

	 else

	    return -1; 	



   }





//Insert Komisi B

   function insertKomisiB($pUser,$pMonth,$pYear,$pKind,$pFee) {

     global $oDB;

	 $vsql="insert into tb_kom_b(fidmember,fmonth,fyear,fkind,ffee,ftglcreated,ftglupdated) ";

	 $vsql.="values('$pUser',$pMonth,$pYear,'$pKind',$pFee,now(),now());";

	 $oDB->query($vsql);

   }



//Insert Komisi Jual RO

   function insertKomisiJual($pUser,$pMonth,$pYear,$pKind,$pFee,$pTglTrans,$pKet) {

     global $dbin1;

	 $vsql="insert into tb_kom_b(fidmember,fmonth,fyear,fkind,ffee,ftglcreated,ftglupdated,fket) ";

	 $vsql.="values('$pUser',$pMonth,$pYear,'$pKind',$pFee,'$pTglTrans',now(),'$pKet');";

	 $dbin1->query($vsql);

   }





//Update Komisi B

   function updateKomisiB($pUser,$pMonth,$pYear,$pKind,$pFee) {

     global $oDB;

	 $vsql="update  tb_kom_b set ffee=$pFee,ftglupdated=now() ";

	 $vsql.="where fidmember='$pUser' and fmonth=$pMonth and fyear=$pYear and fkind='$pKind';";

	 $oDB->query($vsql);

   }





//Insert or Update Komisi B

   function insUpdateKomisiB($pUser,$pMonth,$pYear,$pKind,$pFee) {

			$vKind=$pKind;

			if ($pKind != "gilir") {

				if ($this->isAlready($pUser,$pMonth,$pYear,$pKind)==-1) {

				  $this->insertKomisiB($pUser,$pMonth,$pYear,$pKind,$pFee);

				} else {

				  $this->updateKomisiB($pUser,$pMonth,$pYear,$pKind,$pFee);

				} 		

			} else {



				if ($this->isAlreadyGilir($pUser,$pMonth,$pYear,$pKind)==-1) {

				  $this->insertKomisiB($pUser,$pMonth,$pYear,$pKind,$pFee);

				} else {

				  $this->updateKomisiB($pUser,$pMonth,$pYear,$pKind,$pFee);

				} 		

			

			

			}	

   }

   

 //Ambil semua komisi 

   function getAllKom($pID,$pTgl) {

      global $oDB,$oNetwork;

	  $vBasic=$oNetwork->getAllMtxSpon($pID,$pTgl);//OK

	  $vBasic=0;//Hapus Sponsor Bonus

	  $vCoup=$this->getAllCoupFee($pID,$pTgl);

	 // $vKomBH=$this->getAllKomBK($pID,$pTgl,"bh"); 

	  

	  $vsql="select sum(ffee) as ffeeb from tb_kom_b where fidmember = '$pID' and (ftglcreated < '$pTgl' or ftglupdated < '$pTgl')";

	  $vres=0;

	  $oDB->query($vsql);

	  while ($oDB->next_record()) {

	     $vB=$oDB->f("ffeeb");

	  }

	  $vAll=$vBasic+$vCoup+$vB;

	  return $vAll;

   

   }





 //Ambil semua komisi A

   function getAllKomA($pID,$pTgl) {

      global $oDB,$oNetwork;

	  $vBasic=$oNetwork->getAllMtxSpon($pID,$pTgl);

	  $vCoup=$this->getAllCoupFee($pID,$pTgl);

	  //$vMatch=$this->getAllMatchFee($pID,$pTgl);

	  

	  $vAll=$vBasic+$vCoup;

	  return $vAll;

   

   }



 //Ambil semua komisi B

   function getAllKomB($pID,$pTgl) {

      global $oDB,$oNetwork;

  

	  $vsql="select sum(ffee) as ffeeb from tb_kom_b where fidmember = '$pID' and (ftglcreated < '$pTgl' or ftglupdated < '$pTgl')";

	  $vres=0;

	  $oDB->query($vsql);

	  while ($oDB->next_record()) {

	     $vB=$oDB->f("ffeeb");

	  }

	  $vAll=$vB;

	  return $vAll;

   

   }



 //Ambil semua komisi B kind

   function getAllKomBK($pID,$pTgl,$pKind) {

      global $oDB,$oNetwork;

  

	  $vsql="select sum(ffee) as ffeeb from tb_kom_b where fidmember = '$pID' and fkind='$pKind' and (date(ftglcreated) < '$pTgl' or date(ftglupdated) < '$pTgl')";

	  $vres=0;

	  $oDB->query($vsql);

	  while ($oDB->next_record()) {

	     $vB=$oDB->f("ffeeb");

	  }

	  $vAll=$vB;

	  return $vAll;

   

   }





  function getKomB($pID,$pMonth,$pYear,$pKind) {

      global $oDB;

	    $vsql="select sum(ffee) as ffeeb from tb_kom_b where fidmember = '$pID' and fmonth=".intval($pMonth)." and fyear=$pYear and fkind like '$pKind%' ";

	  

	  $oDB->query($vsql);

	  while ($oDB->next_record()) {

	     $vB=$oDB->f("ffeeb");

	  }

	  

	  if ($vB!="")

	     return $vB;

	  else

	     return 0;	 



  }









  function getKomBAllMember($pMonth,$pYear,$pKind) {

      global $oDB;

	  $vsql="select sum(ffee) as ffeeb from tb_kom_b where fmonth=$pMonth and fyear=$pYear and fkind='$pKind' ";

	  

	  $oDB->query($vsql);

	  while ($oDB->next_record()) {

	     $vB=$oDB->f("ffeeb");

	  }

	  

	  if ($vB!="")

	     return $vB;

	  else

	     return 0;	 



  }







   //Process Komisi week

   function processWeek($pID,$pDate,$pFee) {

	   global $oDB, $oMydate;

	   $vWeek=$oMydate->getWeek($pDate);

	   $vMonth=$oMydate->getMonth($pDate);

	   $vYear=$oMydate->getYear($pDate);

	   $vsql="insert into  tb_transfer(ftanggal,ftglpaid,fidmember,fstatus,fweek,fmonth,fyear,ffee) values('$pDate',now(),'$pID','weekcash',$vWeek,0,$vYear,$pFee)";

	   $oDB->query($vsql);

   }



   //Process Komisi Month

   function processMonth($pID,$pDate,$pFee) {

	   global $oDB, $oMydate;

	   $vWeek=$oMydate->getWeek($pDate);

	   $vMonth=$oMydate->getMonth($pDate);

	   $vYear=$oMydate->getYear($pDate);

	    $vsql="insert into  tb_transfer(ftanggal,ftglpaid,fidmember,fstatus,fweek,fmonth,fyear,ffee) values('$pDate',now(),'$pID','bcash',0,$vMonth,$vYear,$pFee)";

	   $oDB->query($vsql);

   }





//Check apakah komisi mingguan sudah diberikan

   function checkWeek($pID,$pWeek,$pYear) {

       global $oDB;

	   $vsql="select count(*) as fcount from tb_transfer where fidmember='$pID' and fweek=$pWeek and fyear=$pYear ";

	   $vres=0;

	   $oDB->query($vsql);

	   while ($oDB->next_record()) {

	     $vres=$oDB->f("fcount");

	   }

	   

	   if ($vres>0)

	     return 1;

	   else return 0;	 

   }







//Check apakah komisi bulanan sudah diberikan

   function checkMonth($pID,$pMonth,$pYear) {

       global $oDB;

	   $vsql="select count(*) as fcount from tb_transfer where fidmember='$pID' and fmonth=$pMonth and fyear=$pYear ";

	   $vres=0;

	   $oDB->query($vsql);

	   while ($oDB->next_record()) {

	    $vres=$oDB->f("fcount");

	   }

	   

	   if ($vres>0)

	     return 1;

	   else return 0;	 

   }





//Get Paid Cash

   function getCashPaid($pID) {

       global $oDB;

	   $vsql="select sum(ffee) as ffee from tb_transfer where fidmember='$pID' and (fstatus='weekcash' or fstatus='bcash')";

	   $vres=0;

	   $oDB->query($vsql);

	   while ($oDB->next_record()) {

	    $vres=$oDB->f("ffee");

	   }

	   

	   if ($vres>0)

	     return $vres;

	   else return 0;	 

   }





//Get Paid Cash A

   function getCashPaidA($pID) {

       global $oDB;

	   $vsql="select sum(ffee) as ffee from tb_transfer where fidmember='$pID' and (fstatus='weekcash')";

	   $vres=0;

	   $oDB->query($vsql);

	   while ($oDB->next_record()) {

	    $vres=$oDB->f("ffee");

	   }

	   

	   if ($vres>0)

	     return $vres;

	   else return 0;	 

   }





//Get Paid Cash Day

   function getCashPaidDay($pID) {

       global $oDB;

	   $vsql="select sum(ffee) as ffee from tb_transfer where fidmember='$pID' and (fstatus='daycash')";

	   $vres=0;

	   $oDB->query($vsql);

	   while ($oDB->next_record()) {

	    $vres=$oDB->f("ffee");

	   }

	   

	   if ($vres>0)

	     return $vres;

	   else return 0;	 

   }





//Get Count Paid Cash A

   function getCountCashPaidA($pID) {

       global $oDB;

	   $vsql="select count(ffee) as ffee from tb_transfer where ftglpaid >='2010-04-18' and fidmember='$pID' and (fstatus='weekcash')";

	   $vres=0;

	   $oDB->query($vsql);

	   while ($oDB->next_record()) {

	    $vres=$oDB->f("ffee");

	   }

	   

	   if ($vres>0)

	     return $vres;

	   else return 0;	 

   }





//Get Count Paid Cash Day

   function getCountCashPaidDay($pID) {

       global $oDB;

	   $vsql="select count(ffee) as ffee from tb_transfer where  fidmember='$pID' and (fstatus='daycash')";

	   $vres=0;

	   $oDB->query($vsql);

	   while ($oDB->next_record()) {

	    $vres=$oDB->f("ffee");

	   }

	   

	   if ($vres>0)

	     return $vres;

	   else return 0;	 

   }





//Get Paid Cash B

   function getCashPaidB($pID) {

       global $oDB;

	   $vsql="select sum(ffee) as ffee from tb_transfer where fidmember='$pID' and (fstatus='bcash')";

	   $vres=0;

	   $oDB->query($vsql);

	   while ($oDB->next_record()) {

	    $vres=$oDB->f("ffee");

	   }

	   

	   if ($vres>0)

	     return $vres;

	   else return 0;	 

   }



//Get Count Paid Cash B

   function getCountCashPaidB($pID) {

       global $oDB;

	   $vsql="select count(ffee) as ffee from tb_transfer where fidmember='$pID' and (fstatus='bcash')";

	   $vres=0;

	   $oDB->query($vsql);

	   while ($oDB->next_record()) {

	    $vres=$oDB->f("ffee");

	   }

	   

	   if ($vres>0)

	     return $vres;

	   else return 0;	 

   }









//Get Paid Auto

   function getAutoPaid($pID) {

       global $oDB;

	   $vsql="select sum(ffee) as ffee from tb_transfer where fidmember = '$pID' and fstatus='auto' ";

	   $vres=0;

	   $oDB->query($vsql);

	   while ($oDB->next_record()) {

	    $vres=$oDB->f("ffee");

	   }

	   

	   if ($vres>0)

	     return $vres;

	   else return 0;	 

   }







//Get Paid Pulsa

   function getPulsaPaid($pID) {

       global $oDB;

	   $vsql="select sum(ffee) as ffee from tb_transfer where fidmember = '$pID' and fstatus='pulsa' ";

	   $vres=0;

	   $oDB->query($vsql);

	   while ($oDB->next_record()) {

	    $vres=$oDB->f("ffee");

	   }

	   

	   if ($vres>0)

	     return $vres;

	   else return 0;	 

   }



   //Ambil Komisi Reward Normal Terbayar 

   function getRewardNPaid($pID) {

		global $oDB;

		$vsql="select sum(ffee) as frwdnpaid from tb_transfer where fidmember='$pID' and fstatus='rewardn' ";	

		$oDB->query($vsql);

		while ($oDB->next_record()) {

		  $vreward = $oDB->f('frwdnpaid');

		}

		if ($vreward!="")

		   return $vreward;

		else

		   return 0;  

	}





   //Ambil Komisi Reward Premium Terbayar 

   function getRewardPPaid($pID) {

		global $oDB;

		$vsql="select sum(ffee) as frwdppaid from tb_transfer where fidmember='$pID' and fstatus='rewardp' ";	

		$oDB->query($vsql);

		while ($oDB->next_record()) {

		  $vreward = $oDB->f('frwdppaid');

		}

		if ($vreward!="")

		   return $vreward;

		else

		   return 0;  

	}



   //Bayar Komisi Reward Normal  

   function setRewardNPaid($pID,$pFee,$pBukti,$pTanggal) {

		global $oDB;

		$vsql="insert into tb_transfer(ftanggal,fpaid,fbukti,ftglpaid,fidmember,fstatus,ffee) ";	

		$vsql.="values('$pTanggal','1','$pBukti',now(),'$pID','rewardn',$pFee) ";	

		$oDB->query($vsql);

	}



   //Bayar Komisi Reward Prem  

   function setRewardPPaid($pID,$pFee,$pBukti,$pTanggal) {

		global $oDB;

		$vsql="insert into tb_transfer(ftanggal,fpaid,fbukti,ftglpaid,fidmember,fstatus,ffee) ";	

		$vsql.="values('$pTanggal','1','$pBukti',now(),'$pID','rewardp',$pFee) ";	

		$oDB->query($vsql);

	}





   //Apa sudah pernah terbayar Reward Normal? 

   function isRewardNPaid($pID,$pReward) {

		global $oDB;

		$vsql="select sum(ffee) as fpaid from tb_transfer where fidmember='$pID' and fstatus='rewardn'  ";	

		$oDB->query($vsql);

		$oDB->next_record();

		$vPaid = $oDB->f('fpaid');

		if ($vPaid>=$pReward)

		   return 1;

		else

		   return 0;  

	}



   //Apa sudah pernah terbayar Reward Premium? 

   function isRewardPPaid($pID,$pReward) {

		global $oDB;

		$vsql="select sum(ffee) as fpaid from tb_transfer where fidmember='$pID' and fstatus='rewardp'  ";	

		$oDB->query($vsql);

		$oDB->next_record();

		$vPaid = $oDB->f('fpaid');

		if ($vPaid>=$pReward)

		   return 1;

		else

		   return 0;  

	}





   function getOmzetKembangInstant($pID,$pMonth, $pYear) {

		global $oDB;

		 $vsql="select sum(ffee) as fkembang from tb_kom_b where fidmember='$pID' and fmonth=$pMonth and fyear=$pYear  and fkind='kembang'";	

		$oDB->query($vsql);

		$oDB->next_record();

		$vKembang = $oDB->f('fkembang');

  	    if ($vKembang=="")

		   return 0;

		else   

		   return $vKembang;

	}





   function isBHExist($pID,$pBulan, $pTahun) {

		global $oDB;

		$vres="";

		 $vsql="select fidsys from tb_kom_b where fidmember='$pID' and fmonth=$pBulan and fyear=$pTahun";	

		$oDB->query($vsql);

		$oDB->next_record();

		$vres = $oDB->f('fidsys');

		if ($vres=="")

		   return false;

		else

		   return true;          

   } 





   //Check Trans bulan 

   function checkTrans($pKind, $pMonth,$pYear) {

		global $oDB;

		 $vsql="select fidsys from tb_transfer where fstatus='$pKind' and fmonth=$pMonth and fyear=$pYear ";	

		$oDB->query($vsql);

		while ($oDB->next_record()) {

		  $vreward = $oDB->f('fidsys');

		}

		if ($vreward!="")

		   return $vreward;

		else

		   return -1;  

	}





 //Ambil komisi BH

   function getKomBH($pID,$pMonth,$pYear) {

      global $oDB,$oNetwork;

  

	  $vsql="select ffee  from tb_kom_b where fidmember = '$pID' and fmonth=$pMonth and fyear=$pYear and fkind='bh'";

	  

	  $oDB->query($vsql);

	  while ($oDB->next_record()) {

	     $vBH=$oDB->f("ffee");

	  }

		if ($vBH!="")

		   return $vBH;

		else

		   return 0;  

   

   }



 //Ambil komisi BH All

   function getKomBHAll($pID,$pMonth,$pYear) {

      global $oDB,$oNetwork;

  

	  $vsql="select ffee  from tb_kom_b where fidmember = '$pID' and concat(fyear,fmonth) <= concat($pMonth,$pYear) and fkind='bh'";

	  

	  $oDB->query($vsql);

	  while ($oDB->next_record()) {

	     $vBH=$oDB->f("ffee");

	  }

		if ($vBH!="")

		   return $vBH;

		else

		   return 0;  

   

   }





 //Ambil komisi RO All

   function getKomROAll($pID,$pMonth,$pYear) {

      global $oDB,$oNetwork;

  

	  $vsql="select sum(ffee) as ffee  from tb_kom_b where fidmember = '$pID' and concat(fyear,fmonth) <= concat($pYear,$pMonth) and fkind='ro'";

	  

	  $oDB->query($vsql);

	  while ($oDB->next_record()) {

	     $vBH=$oDB->f("ffee");

	  }

		if ($vBH!="")

		   return $vBH;

		else

		   return 0;  

   

   }



 //Ambil komisi ROGroup All

   function getKomROGAll($pID,$pMonth,$pYear) {

      global $oDB,$oNetwork;

  

	  $vsql="select ffee  from tb_kom_b where fidmember = '$pID' and concat(fyear,fmonth) <= concat($pYear,$pMonth) and fkind='groupro'";

	  

	  $oDB->query($vsql);

	  while ($oDB->next_record()) {

	     $vBH=$oDB->f("ffee");

	  }

		if ($vBH!="")

		   return $vBH;

		else

		   return 0;  

   

   }



 //Ambil komisi Peringkat All

   function getKomStarAll($pID,$pMonth,$pYear) {

      global $oDB,$oNetwork;

  

	  $vsql="select ffee  from tb_kom_b where fidmember = '$pID' and concat(fyear,fmonth) <= concat($pMonth,$pYear) and fkind like 'star%'";

	  

	  $oDB->query($vsql);

	  while ($oDB->next_record()) {

	     $vBH=$oDB->f("ffee");

	  }

		if ($vBH!="")

		   return $vBH;

		else

		   return 0;  

   

   }





 //Ambil Qualified Progresif

   function getQualProg($pMonth,$pYear) {

      global $oDB;

  

		 $vSQLin=" select count(fidmember) as fcount from (select fidmember,sum(fsubtotpoint) ";

		 $vSQLin.=" as fomzet from tb_trxstok_member where month(ftanggal)=$pMonth and year(ftanggal)=$pYear ";

		 $vSQLin.=" group by fidmember) as tabel where fomzet >= (select fminprog from tb_rules_config where fidrule=1)";

		 $oDB->query($vSQLin);

		 $oDB->next_record();

 	     return $oDB->f("fcount");

   

   	}



 //Ambil Qualified Royalty

   function getQualRoyal($pMonth,$pYear) {

      global $oDB;

  

		 $vSQLin=" select count(fidmember) as fcount from (select fidmember,sum(fsubtotpoint) ";

		 $vSQLin.=" as fomzet from tb_trxstok_member where month(ftanggal)=$pMonth and year(ftanggal)=$pYear ";

		 $vSQLin.=" group by fidmember) as tabel where fomzet < (select fminprog from tb_rules_config where fidrule=1) ";

		 $vSQLin.=" and fomzet >= (select fminroyal from tb_rules_config where fidrule=1)";

		 $oDB->query($vSQLin);

		 $oDB->next_record();

 	     return $oDB->f("fcount");

   

   	}



   //Ambil KNP 

   function getKNP($pMonth,$pYear) {

		global $oDB;

		 $vsql="select * from tb_knp where fmonth=$pMonth and fyear=$pYear";	

		$oDB->query($vsql);

		$oDB->next_record();

		$vKNP = $oDB->f('fknp');

		if ($vKNP !="")

		   return $vKNP;

		else

		   return 0;  

	}



   //Bayar Fix Couple

   function fixCoup($pID,$pCount,$pFee) {

		global $oDB;

		for ($i=0;$i<$pCount;$i++) {

			$vsql="insert into tb_kom_couple(fidreceiver,fidregistrar,ffee,ftanggal,flr) ";	

			$vsql.="values('$pID','admin',$pFee,now(),'N') ";	

			$oDB->query($vsql);

		}

	}





   //Bayar Fix With Del Couple

   function fixDelCoup($pID,$pCount,$pFee) {

		global $oDB;

		$vsql="delete from tb_kom_couple where fidreceiver='$pID'";

		$oDB->query($vsql);

		for ($i=0;$i<$pCount;$i++) {

			$vsql="insert into tb_kom_couple(fidreceiver,fidregistrar,ffee,ftanggal,flr) ";	

			$vsql.="values('$pID','admin',$pFee,now(),'N') ";	

			$oDB->query($vsql);

		}

	}

//check profit

   function isProfitExist($pID,$pHari) {

		global $oDB;

		$vres="";

		 $vsql="select fidsys from tb_profit_share where fidinvest='$pID' and fharike='$pHari'";	

		$oDB->query($vsql);

		$oDB->next_record();

		$vres = $oDB->f('fidsys');

		if ($vres=="")

		   return false;

		else

		   return true;          

   } 



//Get Paid Invest

   function getInvestPaid($pID) {

       global $oDB;

	   $vsql="select sum(ffee) as ffee from tb_transfer where fidmember='$pID' and (fstatus='invest')";

	   $vres=0;

	   $oDB->query($vsql);

	   while ($oDB->next_record()) {

	    $vres=$oDB->f("ffee");

	   }

	   

	   if ($vres>0)

	     return $vres;

	   else return 0;	 

   }

 

 

  //Ambil komisi Invest All

   function getKomInvestAll($pID) {

      global $oDB,$oNetwork;

  

	  $vsql="select sum(ffee) as fffee  from tb_profit_share where fidmember = '$pID' and ftanggal <= (select ftglkomisi from tb_criteria)";

	  

	  $oDB->query($vsql);

	  while ($oDB->next_record()) {

	     $vBH=$oDB->f("fffee");

	  }

		if ($vBH!="")

		   return $vBH;

		else

		   return 0;  

   

   }



   //Bayar Komisi Invest 

   function setInvestPaid($pID,$pFee,$pBukti,$pTanggal) {

		global $oDB;

		$vsql="insert into tb_transfer(ftanggal,fpaid,fbukti,ftglpaid,fidmember,fstatus,ffee) ";	

		$vsql.="values('$pTanggal','1','$pBukti',now(),'$pID','invest',$pFee) ";	

		$oDB->query($vsql);

	}



        //Add  KNP member

		function addMemberKNP($pMonth,$pYear,$pTanggal,$pKNP,$pMember='') {

            global $oDB, $oDBin, $oSystem,$oMember; 

			$vres="";

		    $vsql="select fidsys from tb_profit_knp where date(ftanggal)=date('$pTanggal') ";

			$oDB->query($vsql);

			$oDB->next_record();



			if ($this->hasKNP($pMember,$pTanggal)==1) {

					   $vsql="update tb_profit_knp set ftanggal='$pTanggal',fbulan='$pMonth',ftahun='$pYear',ffee=$pKNP where fidmember='$pMember' and ftanggal='$pTanggal';";

					   $oDB->query($vsql);

					   $oSystem->jsAlert("Member $pMember sudah pernah diset KNP,  sistem sudah melakukan update menjadi $pKNP untuk tanggal $pTanggal!. Silakan cari lagi member ini untuk melihat hasil update!");

			} else if ($this->hasKNP($pMember,$pTanggal)==0 && $pMember != "") {

					   $vsql="insert into tb_profit_knp(ftanggal,fbulan,ftahun,fidmember,ffee) values('$pTanggal','$pMonth',$pYear,'$pMember',$pKNP);";

					   $oDB->query($vsql);		

					   $oSystem->jsAlert("KNP untuk member $pMember tanggal $pTanggal sudah dimasukkan!. Silakan cari lagi member ini untuk melihat hasil update!");		

			} else

			/*

			if ($oDB->f("fidsys") != "") 

			   $oSystem->jsAlert("KNP tanggal $pTanggal  sudah ada, silakan masukkan tanggal yang lain atau hapus dulu tanggal $pTanggal dan masukkan lagi!");

			*/

			 {

			   $vMember=$oMember->getAllMember($pYear.$pMonth);

			  // print_r($vMember);

			 //$oSystem->jsAlert($pMonth);

			   $vCount=0;

			   while (list($vKey,$vVal)=each($vMember)) {

				  if ($this->hasKNP($vVal,$pTanggal)==0) {

					   $vCount+=1;

					   $vsql="insert into tb_profit_knp(ftanggal,fbulan,ftahun,fidmember,ffee) values('$pTanggal','$pMonth',$pYear,'$vVal',$pKNP);";

					   $oDB->query($vsql);

				   }

			   }//while

			   $oSystem->jsAlert("$vCount KNP member sudah diset!");

			}

		}



        //Del  KNP member

		function delMemberKNP($pTanggal) {

            global $oDB; 

			$vres="";

		   echo $vsql="delete from tb_profit_knp where ftanggal='$pTanggal';";

			$oDB->query($vsql);

		}





		//Cek KNP/tidak

		 function hasKNP($pId,$pTanggal) {

				 global $dbin;

				 $vsql="select *  from tb_profit_knp where fidmember='$pId' and date(ftanggal)=date('$pTanggal')";	

				 $dbin->query($vsql);		

				 if ($dbin->num_rows() > 0 ) 

				   return 1;

				 else

				   return 0;   

						 

		}	

		

		

   function getLastBalance($pID) {

		global $oMember,$oNetwork;

		   $vSaldo=$oMember->getMemField("fsaldovcr",$pID);   

		

		return $vSaldo;

   }
   
  function getLastBalanceBis($pID) {

		global $oMember,$oNetwork;

		   $vSaldo=$oMember->getMemFieldBis("fsaldovcr",$pID);   

		

		return $vSaldo;

   }  



   function getLastBalanceRO($pID) {

		global $oMember,$oNetwork;

		   $vSaldo=$oMember->getMemField("fsaldoro",$pID);   

		

		return $vSaldo;

   }





//Insert Mutasi

   function insertMutasi($pID,$pIDFunder,$pTanggal,$pDesc,$pCred,$pDeb,$pBal,$pKind,$pRef='') {

       global $oDB;

	   $vsql="insert tb_mutasi(fidmember,fidfunder,ftanggal,fdesc,fcredit,fdebit,fbalance,fkind,fref) ";

	    $vsql.="values('$pID','$pIDFunder','$pTanggal','$pDesc',$pCred,$pDeb,$pBal,'$pKind','$pRef');";

	   $oDB->query($vsql);

   }





//Insert Mutasi

   function insertMutasiConn($pID,$pIDFunder,$pTanggal,$pDesc,$pCred,$pDeb,$pBal,$pKind,$pRef='',$pDB) {

       global $oDB;

	   $vsql="insert tb_mutasi(fidmember,fidfunder,ftanggal,fdesc,fcredit,fdebit,fbalance,fkind,fref) ";

	   $vsql.="values('$pID','$pIDFunder','$pTanggal','$pDesc',$pCred,$pDeb,$pBal,'$pKind','$pRef');";

	   $pDB->query($vsql);

   }





//Insert Mutasi

   function insertMutasiRO($pID,$pIDFunder,$pTanggal,$pDesc,$pCred,$pDeb,$pBal,$pKind,$pRef='') {

       global $oDB;

	   $vsql="insert tb_mutasi_ro(fidmember,fidfunder,ftanggal,fdesc,fcredit,fdebit,fbalance,fkind,fref) ";

	   $vsql.="values('$pID','$pIDFunder','$pTanggal','$pDesc',$pCred,$pDeb,$pBal,'$pKind','$pRef');";

	   $oDB->query($vsql);

   }





//Insert Mutasi Wprod

   function insertMutasiAuto($pID,$pIDFunder,$pTanggal,$pDesc,$pCred,$pDeb,$pBal,$pKind,$pRef='') {

       global $oDB;

	   $vsql="insert tb_mutasi_wprod(fidmember,fidfunder,ftanggal,fdesc,fcredit,fdebit,fbalance,fkind,fref) ";

	   $vsql.="values('$pID','$pIDFunder','$pTanggal','$pDesc',$pCred,$pDeb,$pBal,'$pKind','$pRef');";

	   $oDB->query($vsql);

   }





//Insert Mutasi Stockist

   function insertMutasiSt($pID,$pIDFunder,$pTanggal,$pDesc,$pCred,$pDeb,$pBal,$pKind,$pRef='') {

       global $oDB;

	   $vsql="insert tb_mutasi_stockist(fidmember,fidfunder,ftanggal,fdesc,fcredit,fdebit,fbalance,fkind,fref) ";

	   $vsql.="values('$pID','$pIDFunder','$pTanggal','$pDesc',$pCred,$pDeb,$pBal,'$pKind','$pRef');";

	   $oDB->query($vsql);

   }



//Update Mutasi

   function updateMutasi($pID,$pIDFunder,$pTanggal,$pDesc,$pCred,$pDeb,$pBal,$pKind) {

       global $oDB;

	   $vsql="update tb_mutasi set ftanggal='$pTanggal', fdesc='$pDesc', fcredit=$pCred, fbalance=$pBal ";

	   $vsql.=" where fidmember='$pID' and month(ftanggal)=month('$pTanggal') and year(ftanggal)=year('$pTanggal') and fkind='$pKind'";

	   $oDB->query($vsql);

   }

   

   

   //get CF

   function getPairCF($pID,$pDate) {

			 global $oDB, $oMydate;

			 $vYesterday=$oMydate->dateSub($pDate,1,'day');

			  $vsql="select *  from tb_kom_couple where fidreceiver='$pId' and date(ftanggal)=date('$vYesterday')";	

			 $oDB->query($vsql);		

			 $vCF=array();

			 $vCF['val']=0;$vCF['pos']='';

			 

			 while ($oDB->next_record()) {

				$vCF['val']=$oDB->f('fcf'); 

				$vCF['pos']=$oDB->f('flr');

				 

			 }

			   return $vCF;

	   

	   

   }



   //get CFPosition

   function getCFPos($pID,$pPos,$pDate) {

			 global $oDB, $oMydate;

			 $vYesterday=$oMydate->dateSub($pDate,1,'day');

			 $vsql="select *  from tb_kom_coupcf where fidreceiver='$pID' and date(ftanggal)=date('$vYesterday') and flr='$pPos'";	

			 $oDB->query($vsql);		

			 $vCF=0;

			 while ($oDB->next_record()) {

				$vCF=$oDB->f('fcf'); 				 

			 }

			   if ($vCF=='')

			      $vCF=0;

			     

			   return $vCF;

	   

	   

   }





 //get PR CFPosition

   function getPRCFPos($pID,$pPos,$pDate) {

			 global $oDB, $oMydate;

			 $vYesterday=$oMydate->dateSub($pDate,1,'day');

			 $vsql="select *  from tb_kom_prcf where fidreceiver='$pID' and date(ftanggal)=date('$vYesterday') and flr='$pPos'";	

			 $oDB->query($vsql);		

			 $vCF=0;

			 while ($oDB->next_record()) {

				$vCF=$oDB->f('fcf'); 				 

			 }

			   if ($vCF=='')

			      $vCF=0;

			     

			   return $vCF;

	   

	   

   }



   //get CFPosition RT / Today

   function getCFPosRT($pID,$pPos,$pDate) {

			 global $oDB, $oMydate;

			 $vYesterday=$pDate;

			 $vsql="select *  from tb_kom_coupcf where fidreceiver='$pID' and date(ftanggal)=date('$vYesterday') and flr='$pPos'";	

			 $oDB->query($vsql);		

			 $vCF=0;

			 while ($oDB->next_record()) {

				$vCF=$oDB->f('fcf'); 				 

			 }

			   if ($vCF=='')

			      $vCF=0;

			     

			   return $vCF;

	   

	   

   }





   //get CFPosition

   function getCFPosByID($pID,$pPos,$pIDCF) {

			 global $oDB, $oMydate;

			 

			 $vsql="select *  from tb_kom_coupcf where fidreceiver='$pID'  and flr='$pPos' and fidfee='$pIDCF'";	

			 $oDB->query($vsql);		

			 $vCF=0;

			 while ($oDB->next_record()) {

				$vCF=$oDB->f('fcf'); 				 

			 }

			   if ($vCF=='')

			      $vCF=0;

			     

			   return $vCF;	   

   }



function getPoint($vUserActive,$vAwal,$vAkhir) {

		global $oRules, $oNetwork, $oMember;

		$vOutLB="";$vOutLF="";

		$vOutRB="";$vOutRF="";

		$vPointE=$oRules->getSettingByField('fpointeco');

		$vPointB=$oRules->getSettingByField('fpointbuss');

		$vPointF=$oRules->getSettingByField('fpointfirst');

		

		$vDownL=$oNetwork->getDownLR($vUserActive,'L');

		$vDownR=$oNetwork->getDownLR($vUserActive,'R');

		

		

		

		$vPaketDownL=$oMember->getPaketID($vDownL);

		$vPaketDownR=$oMember->getPaketID($vDownR);

		

		if ($vDownL != -1 && $vDownL != "") {

			$oNetwork->getDownlineByPaket($vDownL,$vOutLB,$vAwal,$vAkhir,'B');

			$oNetwork->getDownlineByPaket($vDownL,$vOutLF,$vAwal,$vAkhir,'F');

		}

		

		if (is_array($vOutLB))

		   $vCountLB=count($vOutLB);

		else   

		   $vCountLB=0;

		   

		if (is_array($vOutLF))

		   $vCountLF=count($vOutLF);

		else   

		   $vCountLF=0;

		

		

		if ($vDownR != -1 && $vDownR != "") {

			$oNetwork->getDownlineByPaket($vDownR,$vOutRB,$vAwal,$vAkhir,'B');

			$oNetwork->getDownlineByPaket($vDownR,$vOutRF,$vAwal,$vAkhir,'F');

		}

		

		/*if($_SESSION['LoginUser']=='admin') {

		   if ($vUserActive=='UNEEDS00') {

		      echo $vUserActive.":".$vDownR."<br>";

		      print_r($vOutRF);echo "<br>";

		      print_r($vOutRB);

		      

		   }

		   

		 } */

		//print_r($vOutRB);

		if (is_array($vOutRB))

		   $vCountRB=count($vOutRB);

		else   

		   $vCountRB=0;

		   

		if (is_array($vOutRF))

		   $vCountRF=count($vOutRF);

		else   

		   $vCountRF=0;

		

		

		$vPointL = ($vPointF * $vCountLF) + ($vPointB * $vCountLB);

		

		

		if ($vPaketDownL=='B' && $oMember->getActivationDate($vDownL) >= $vAwal)

		    $vPointL+=$vPointB;

		   

		if ($vPaketDownL=='F' && $oMember->getActivationDate($vDownL) >= $vAwal)

		    $vPointL+=$vPointF;



	    $vPointR = ($vPointF * $vCountRF) + ($vPointB * $vCountRB);		    

		

		if ($vPaketDownR=='B' && $oMember->getActivationDate($vDownR) >= $vAwal)

		    $vPointR+=$vPointB;

		    

		if ($vPaketDownR=='F' && $oMember->getActivationDate($vDownR) >= $vAwal)

		    $vPointR+=$vPointF;

		    

		   		    

		$vRet['L']=$vPointL;    

		$vRet['R']=$vPointR;

		//print_r( $vRet);

		return $vRet;    







}



   //get RO Maintenance Month

   function getROMaMonth($pID,$pYear, $pMonth) {

			 global $oDB, $oMydate;

			 

			$vsql="select sum(fcredit - fdebit) as fsumcredit  from tb_mutasi_ro where fidmember='$pID' and  year(ftanggal) = $pYear and month(ftanggal) = $pMonth ";	

			 $oDB->query($vsql);		

			 $vRes=0;

			 while ($oDB->next_record()) {

				$vRes=$oDB->f('fsumcredit'); 				 

			 }

			  return $vRes;	   

   }



   //get Bonus yg belum dicairkan

   function getAllBonusStand($pID) {

			 global $oDB, $oMydate;

			 

			$vsql="select fbalance  from tb_mutasi where fidmember='$pID' order by ftanggal desc limit 1";	

			 $oDB->query($vsql);		

			 $vRes=0;

			 while ($oDB->next_record()) {

				$vRes=$oDB->f('fbalance'); 				 

			 }

			  return $vRes;	   

   }





  //get Bonus 

   function getAllBonus($pID) {

			 global $oDB, $oMydate;

			 

			$vsql="select sum(fcredit) as fbalance  from tb_mutasi where fidmember='$pID' order by ftanggal desc limit 1";	

			 $oDB->query($vsql);		

			 $vRes=0;

			 while ($oDB->next_record()) {

				$vRes=$oDB->f('fbalance'); 				 

			 }

			  return $vRes;	   

   }

   //get Bonus yg belum dicairkan

   function getBonusMonth($pID,$pYearMonth) {

			 global $oDB, $oMydate;

			 

			$vsql="select sum(fcredit - fdebit) as fbonus  from tb_mutasi where fidmember='$pID' and  fkind in('sponsor','match','pairing','person','netdev','reward','royalty') and date_format(ftanggal,'%Y-%m') =  '$pYearMonth' ";	

			 $oDB->query($vsql);		

			 $vRes=0;

			 while ($oDB->next_record()) {

				$vRes=$oDB->f('fbonus'); 				 

			 }

			  return $vRes;	   

   }



//get Bonus yg belum dicairkan

   function getBonusMonthOno($pID,$pYearMonth) {

			 global $oDB, $oMydate;

			 

			$vsql="select sum(fcredit - fdebit) as fbonus  from tb_mutasi where fidmember='$pID' and  fkind in('unile','spon','pairing','pres','netdev','reward') and date_format(ftanggal,'%Y-%m') =  '$pYearMonth' ";	

			 $oDB->query($vsql);		

			 $vRes=0;

			 while ($oDB->next_record()) {

				$vRes=$oDB->f('fbonus'); 				 

			 }

			  return $vRes;	   

   }

   //get Bonus yg belum dicairkan

   function getBonusYear($pID,$pYear) {

			 global $oDB, $oMydate;

			 

			$vsql="select sum(fcredit - fdebit) as fbonus  from tb_mutasi where fidmember='$pID' and  fkind in('sponsor','match','pairing','person','netdev','reward','royalty') and date_format(ftanggal,'%Y') =  '$pYear' ";	

			 $oDB->query($vsql);		

			 $vRes=0;

			 while ($oDB->next_record()) {

				$vRes=$oDB->f('fbonus'); 				 

			 }

			  return $vRes;	   

   }



 //get Bonus yg belum dicairkan

   function getBonusYearOno($pID,$pYear) {

			 global $oDB, $oMydate;

			 

			$vsql="select sum(fcredit - fdebit) as fbonus  from tb_mutasi where fidmember='$pID' and  fkind in('unile','spon','pairing','pres','netdev','reward') and date_format(ftanggal,'%Y') =  '$pYear' ";	

			 $oDB->query($vsql);		

			 $vRes=0;

			 while ($oDB->next_record()) {

				$vRes=$oDB->f('fbonus'); 				 

			 }

			  return $vRes;	   

   }

   

 //last Stockist Bonus

   function getStBal($pID,$pKind) {

      global $oDB;

	  $vRet=0;

	  if (in_array($pKind,array('bnstrxst','bnstrxkitst')))

           $vSQL="select * from tb_kom_stockist where fidmember = '$pID' and fkind in ('bnstrxst','bnstrxkitst') order by ftanggal desc, fidsys desc limit 1 "; 

	  else 	   $vSQL="select * from tb_kom_stockist where fidmember = '$pID' and fkind ='$pKind' order by ftanggal desc, fidsys desc limit 1 "; 

	  

	  $oDB->query($vSQL); 

	  $oDB->next_record();

	  $vRet = $oDB->f('fbalance');	

	  return $vRet;   

   }



 //Spread Stockist Bonus

   function spreadStBonus($pID,$pAmount,$pFee,$pKind,$pUnit,$pDesc,$pFunder='',$pRef) {

      global $oDB;

	  

	  $vLastBal=$this->getStBal($pID,$pKind);

	  $vNewBal = $vLastBal + $pFee;

      $vUser = $_SESSION['LoginUser'];

      $vSQL="INSERT INTO tb_kom_stockist( fidmember, fidfunder, famount,ffee,fdebit,fbalance, ftanggal, fkind, ffeeunit, ffeestatus, fdesc, flastuser, flastupdate,fref)"; 

	  $vSQL .= "VALUES ('$pID','$pFunder', $pAmount, $pFee,0,$vNewBal, now(), '$pKind', '$pUnit', '1', '$pDesc', '$vUser', now(),'$pRef');";

	 

	  

	    $oDB->query($vSQL); 

		if ($oDB->affected_rows() > 0)	

		   return 1;

		else return 0;   

   }	


//Spread Sponsor
   function spreadSpon($pID,$pAmount,$pFee,$pKind,$pUnit,$pDesc,$pFunder='',$pRef) {
      global $oDB;
	  
	  $vLastBal=$this->getStBal($pID,$pKind);
	  $vNewBal = $vLastBal + $pFee;
      $vUser = $_SESSION['LoginUser'];
	  $tfFFrom = date('Y-m-d');
	  $tfFTo = date('Y-m-d');
	  
      $vSQL="INSERT INTO tb_komisi(fdfrom, fdto, fidmember, fidfunder, famount, fkind, ffeestatus, fdesc, fref, ftanggal, flevel,fnetto) ";
	  $vSQL .= "VALUES ( '$tfFFrom','$tfFTo','$vRefer', 'system',$vTotal , 'SPON', '0', 'Bonus Sponsor Periode $vFromKet s/d $vToKet', '$vRef',now(),'',$vNetto );";  
				 				 
	 	  
	    $oDB->query($vSQL); 
		if ($oDB->affected_rows() > 0)	
		   return 1;
		else return 0;   
   }	



 //Ambil PR kiri / kanan

   function getPoinRwd($pID,$pLR) {

   global $oDB;

   $pMonth=(int) $pMonth;

   $vsql="select sum(ffeenom) as ftotal from tb_kom_pr where fidreceiver='$pID' and  flr='$pLR' ";

	$oDB->query($vsql);

	while ($oDB->next_record()) {

	   $vres=$oDB->f('ftotal');

	}

	  if ($vres!="")

	      return $vres;  

	  else

	      return 0;	  

   } 


//Insert Mutasi Payment

   function insertPayment($pID,$pIDFunder,$pTanggal,$pDesc,$pCred,$pDeb,$pBal,$pKind,$pRef='') {

       global $oDB;

	   $vsql="insert tb_payhist(fidmember,fidfunder,ftanggal,fdesc,fcredit,fdebit,fbalance,fkind,fref) ";

	   $vsql.="values('$pID','$pIDFunder','$pTanggal','$pDesc',$pCred,$pDeb,$pBal,'$pKind','$pRef');";

	   $oDB->query($vsql);

   }


//Insert Mutasi Payment Tabungan

   function insertPaymentTab($pID,$pIDFunder,$pTanggal,$pDesc,$pCred,$pDeb,$pBal,$pKind,$pRef='') {

       global $oDB;

	   $vsql="insert tb_payhisttab(fidmember,fidfunder,ftanggal,fdesc,fcredit,fdebit,fbalance,fkind,fref) ";

	   $vsql.="values('$pID','$pIDFunder','$pTanggal','$pDesc',$pCred,$pDeb,$pBal,'$pKind','$pRef');";

	   $oDB->query($vsql);

   }


//Insert Bonus Sponsor

   function insertSpon($pRefer, $pProg, $pPaket, $pRegistrant) {

       global $oDB, $dbin, $dbin1, $oRules, $oPhpdate, $oMember;
	   
	   	    
		  //Bonus Sponsor
		
		$vSQLProg = "select * from m_program  where fidprogram='$pProg' order by fidprogram ";
		$dbin1->query($vSQLProg);
		while($dbin1->next_record()) {
			$vIDProg = $dbin1->f('fidprogram');
			$vSyaratSA = $dbin1->f('fsyaratsa');
			$vSyaratLns = $dbin1->f('fsyaratlns');  
		
		
			if ($vSyaratLns !=0) {
				 $vSQLKTP = "select count(*) as fjml from(select a.fidmember from m_anggota a where a.frefer='$pRefer'  and a.fprogram='$pProg' and  a.fpaket='$pPaket'  and faktif='1' and a.flunas > 0 and a.fidmember='$pRegistrant'  ) as a ";
			} else {
				 $vSQLKTP = "select count(fidmember) as fjml from m_anggota where frefer='$pRefer'  and fprogram='$pProg' and  fpaket='$pPaket' and faktif='1'  and fstorawal >= $vSyaratSA and fidmember='$pRegistrant'  ";									
			}		  
		  	
			 //$vSQLKTP.":";
			$dbin->query($vSQLKTP);
			$dbin->next_record();
			 $vJml = $dbin->f('fjml');
						
			 //getBnsSetting($pJenis,$pProgram, $pLevel='') 
			$vBonus =  $oRules->getBnsSetting('SPON',$pProg, '',$pPaket) ;
			$vTotal = $vBonus * $vJml;
				
		//	echo "<br>Setting Bonus $vBonus ";
			if ($vTotal > 0) {
			  $vIDBisnis = $pRefer;
			  $vByyAdmin = $oRules->getSettingByField('fbyyadmin');
			  $vNetto = $vTotal - ($vTotal * $vByyAdmin / 100);
			  $vFromKet = $oPhpdate->YMD2DMY($tfFFrom);
			  $vToKet = $oPhpdate->YMD2DMY($tfFTo);
			  $vRef="REG-$pRegistrant"."-".date("Ymd-His");
			  $tfFFrom = date('Y-m-d');
			  $tfFTo = date('Y-m-d');
			 
			  
			 $vSQL="INSERT INTO tb_komisi(fdfrom, fdto, fidmember, fidfunder, famount, fkind, ffeestatus, fdesc, fref, ftanggal, flevel,fnetto) ";
			  $vSQL .= "VALUES ( '$tfFFrom','$tfFTo','$pRefer', '$pRegistrant',$vTotal , 'SPON', '1', 'Bonus Sponsor dari registrasi jamaah $pRegistrant', '$vRef',now(),'',$vNetto );";  
			 
			 $dbin->query($vSQL);
			 
			
			  $vDesc="Bonus Sponsor Registrasi $pRegistrant $vFromKet ";		
			  $vLastBal=$this->getLastBalanceBis($vIDBisnis);
			  
			  $vBal=$vLastBal + $vNetto;
			  $this->insertMutasi($pRefer,$pRefer,date("Y-m-d H:i:s"),$vDesc,$vNetto,0,$vBal,'spon',$pRegistrant) ;
			  $oMember->updateBalBis($pRefer,$vBal);	
			} //Insert bonus
				  
		}	

   }



 }//class



  

   $oKomisi = new komisi;

?>
